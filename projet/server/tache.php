<?php
header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Origin: https://paccauds.emf-informatique.ch/151/client');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT');

//connexion ctrl
include_once('ctrl/TacheManager.php');


if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'createTask':
            if (isset($_POST['projet'])) {


                $projet = $_POST["projet"];

                //ctrl login
                $login = new TacheManager();
                $login->createTask($projet);


            }
            break;
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    parse_str(file_get_contents("php://input"), $vars);

    if (isset($vars['action'])) {
        switch ($vars['action']) {
            case 'moveTask':
                if( isset($vars['blockNewLocation']) and isset($vars['tacheMove'])){
                    //param action TODO
                    $blockNewLocation = $vars['blockNewLocation'];
                    $tacheMove = $vars['tacheMove'];
                    $userPK = $vars['userPK'];
                    //ctrl login
                    $login = new TacheManager();
                    $login->moveTask($blockNewLocation, $tacheMove, $userPK);
                }
                break;

            case 'modifyTask':
                if( isset($vars['pkTask']) and isset($vars['nomTask'])){
                      //param action TODO
                      $pkTask = $vars['pkTask'];
                      $nomTask = $vars['nomTask'];
               

                      //ctrl loginé
                      $login = new TacheManager();
                      $login->modifieDescriptionTask($pkTask,$nomTask);
                }
             break;

        }

    }
} else if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'getTasksProjet':
            if (isset($_GET['projetPK'])) {
                $PKprojet = $_GET["projetPK"];
                //ctrl login 2
                $login = new TacheManager();
                $login->getTasksProjet($PKprojet);
            }
            break;
    }
}

?>