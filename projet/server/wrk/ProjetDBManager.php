<?php

require_once('connexion/Connexion.php');
include('beans/projet.php');
class ProjetDBManager
{

  private $connexion;
  public function __construct()
  {
    $this->connexion = Connexion::getInstance();
  }

  public function getProjetUser($pkUser)
  {

    $result = "";
    //get pk projet de l'user
    $params = array('pkUser' => $pkUser);
    $rows = $this->connexion->selectQuery("SELECT FK_Projet FROM tr_user_projet WHERE FK_User = :pkUser", $params);

    if ($rows) {
      // Tableau pour stocker les objets Projet
      $projets = array();

      foreach ($rows as $row) {
        // get clé primaire du projet
        $pkProjet = $row['FK_Projet'];

        // Get projet detail
        $params = array('pkProjet' => $pkProjet);
        $rowProjetData = $this->connexion->selectSingleQuery("SELECT * FROM t_projet WHERE PK_Projet = :pkProjet", $params);

        if ($rowProjetData) {
          $projet = new Projet();
          $projet->initFromDb($rowProjetData);
          $projets[] = $projet;
        }
      }

      // prepare projet json
      $projetList = array();
      foreach ($projets as $projet) {
        $projetData = array(
          'Nom' => $projet->getNom(),
          'Description' => $projet->getDesccription(),
          'PK_Projet' => $projet->getPKProjet(),
        );
        $projetList[] = $projetData;
      }

      //convert json
      $jsonProjetList = json_encode($projetList);
      http_response_code(200);
      $result = $jsonProjetList;

    } else {
      http_response_code(404);
      $result = json_encode(array('message' =>'Aucune ligne trouvée.'));
    }
    return $result;
  }


  public function postProjetUser($pkUser, $projectName)
  {
    // Initialisation du résultat
    $result = "";

    // Définition des valeurs par défaut
    $name = $projectName;
    $description = "Default";

    // Protection contre les injections HTML
    $escapedInputName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $escapedInputDescription = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

    // Insertion du projet dans la table t_projet
    $params = array('name' => $escapedInputName, 'description' => $escapedInputDescription);
    $query = $this->connexion->executeQuery("INSERT INTO t_projet(Nom, Description) VALUES (:name, :description);", $params);
    if ($query) {

      // Récupération de l'ID du projet créé
      $projectId = $this->connexion->getLastId('t_projet');

      // Association du projet à l'utilisateur dans la table tr_user_projet
      $params = array('userId' => $pkUser, 'projectId' => $projectId);
      $query = $this->connexion->executeQuery("INSERT INTO tr_user_projet(FK_User, FK_Projet) VALUES (:userId, :projectId);", $params);

      // Succès de création du projet
      http_response_code(200);
      $result = json_encode(array('message' =>'Projet créé avec succès !'));

    } else{
      http_response_code(500);
      $result =  $result = json_encode(array('message' => 'Problème lors de la création du projet'));
    }
    // Retourner le résultat
    return $result;
  }
}
?>