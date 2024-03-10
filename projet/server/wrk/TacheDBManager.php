<?php

require_once('connexion/Connexion.php');
class TacheDBManager
{

    private $connexion;
    public function __construct()
    {
        $this->connexion = Connexion::getInstance();
    }
    public function postCreateTask($PKprojet)
    {
        //protection
        $escapedInputPKProjet = htmlspecialchars($PKprojet, ENT_QUOTES, 'UTF-8');

        $json = "";


            //mettre tache dans table t_tache
            $params = array('pk_projet' => $PKprojet);
            $query = $this->connexion->executeQuery("INSERT INTO t_tache (Nom, FK_Projet) VALUES ('default tache', :pk_projet)", $params);
        if($query){
             //get pk crée
            $lastInsertedId = $this->connexion->getLastId('t_tache');

            http_response_code(200);
            $json = json_encode(array('message' => 'Une ligne a été insérée avec succès.', 'pkTacheCrée' => $lastInsertedId));

        } else{
            http_response_code(500);
            $json = json_encode(array('message' => 'Problème lors de la création'));
        } 

           
        return $json;
    }

    public function putMoveTask($blockNewLocation, $tacheMove, $userPK)
    {
        $resultData = "";
        //protection
        $escapedInputBlockNewLocation = htmlspecialchars($blockNewLocation, ENT_QUOTES, 'UTF-8');
        $escapedInputTacheMove = htmlspecialchars($tacheMove, ENT_QUOTES, 'UTF-8');
        $escapedInputUserPK = htmlspecialchars($userPK, ENT_QUOTES, 'UTF-8');

        $params = array('PKUser' => $escapedInputUserPK);
        $result = $this->connexion->selectQuery("SELECT IsAdmin  FROM t_user  WHERE PK_User = :PKUser", $params);
        $isAdmin = $result[0]['IsAdmin'];

        if ($escapedInputBlockNewLocation == 4 && $isAdmin == false) {
            http_response_code(500);
            $resultData = json_encode(array('message' => "L'utilisateur n'est pas administrateur"));

        } else {


            try {
                // Débuter une nouvelle transaction
                $this->connexion->startTransaction();

                // Vérifier si la tâche existe
                $params = array('tacheMove' => $escapedInputTacheMove);
                $rows = $this->connexion->selectQuery("SELECT PK_Tache FROM t_tache WHERE PK_Tache = :tacheMove", $params);

                if (!empty($rows)) {
                    // Mettre à jour l'état de la tâche avec la nouvelle position
                    $params = array('blockNewLocation' => $escapedInputBlockNewLocation, 'tacheMove' => $escapedInputTacheMove);

                    $this->connexion->executeQuery("UPDATE t_tache SET Etat = :blockNewLocation WHERE PK_Tache = :tacheMove", $params);

                    // Valider la transaction
                    $this->connexion->commitTransaction();

                    // Répondre avec un message de succès
                    $resultData = json_encode(array('message' => 'La tâche a été déplacée avec succès.'));
                } else {
                    // Répondre avec un message d'erreur si la tâche n'existe pas
                    http_response_code(404);
                    $resultData = json_encode(array('message' => 'La tâche spécifiée n\'existe pas.'));
                }
            } catch (PDOException $e) {
                // En cas d'erreur, annuler la transaction
                $this->connexion->rollbackTransaction();

                // Répondre avec un message d'erreur
                http_response_code(500);
                $resultData = json_encode(array('message' => 'Une erreur est survenue lors du déplacement de la tâche : ' . $e->getMessage()));
            }

        }
        return $resultData;
    }
    public function getTasksProjet($PKprojet)
    {
        $result = "";
    
        // Récupérer les tâches du projet spécifié
        $params = array('PKprojet' => $PKprojet);
        $tasks = $this->connexion->selectQuery("SELECT * FROM t_tache WHERE FK_Projet = :PKprojet", $params);
    
        if (!empty($tasks)) {
            // Créer un tableau pour stocker toutes les tâches
            $allTasks = array();
    
            // Boucler sur chaque tâche et l'ajouter au tableau des tâches
            foreach ($tasks as $task) {
                $allTasks[] = $task;
            }
    
            // Encoder le tableau de toutes les tâches en JSON
            $result = json_encode($allTasks);
        } else {
            // Répondre avec un message d'erreur si aucune tâche n'est trouvée pour le projet spécifié
            http_response_code(404);
            $result = json_encode(array('message' => 'Aucune tâche trouvée pour le projet spécifié.'));
        }
        return $result;
    }
    


    public function modifieTaskProjet($pkTask, $nom)
    {
        $resultData = "";
    
        try {
            // Débuter une nouvelle transaction
            $this->connexion->startTransaction();
    
            // Vérifier si la tâche existe
            $params = array('PK_Tache' => $pkTask);
            $rows = $this->connexion->selectQuery("SELECT PK_Tache FROM t_tache WHERE PK_Tache = :PK_Tache", $params);
    
            if (!empty($rows)) {
                // Mettre à jour le champ Nom de la tâche
                $params = array('nom' => $nom, 'PK_Tache' => $pkTask);
                $this->connexion->executeQuery("UPDATE t_tache SET Nom = :nom WHERE PK_Tache = :PK_Tache", $params);
    
                // Valider la transaction
                $this->connexion->commitTransaction();
    
                // Répondre avec un message de succès
                $resultData = json_encode(array('message' => 'Le champ description de la tâche a été modifié avec succès.'));
            } else {
                // Répondre avec un message d'erreur si la tâche n'existe pas
                http_response_code(404);
                $resultData = json_encode(array('message' => 'La tâche spécifiée n\'existe pas.'));
            }
        } catch (PDOException $e) {
          
            $this->connexion->rollbackTransaction();
    
          
            http_response_code(500);
            $resultData = json_encode(array('message' => 'Une erreur est survenue lors de la modification du champ Nom de la tâche : ' . $e->getMessage()));
        }
    
        return $resultData;
    }
    


}
?>