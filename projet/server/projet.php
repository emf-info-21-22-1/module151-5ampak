<?php
header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Origin: https://paccauds.emf-informatique.ch/151/client');
header('Access-Control-Allow-Credentials: true');
//connexion ctrl
include_once('ctrl/ProjetManager.php');

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'getProjetUser':
            if (isset($_GET['username'])) {
                if (isset($_GET['pkuser'])) {

                    $username = $_GET["username"];
                    $pkUser = $_GET["pkuser"];

                    //ctrl login 2
                    $login = new ProjetManager();
                    $login->getProjetUser($username, $pkUser);

                }
            }
        }

} else if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'createUserProjet':     
            if (isset($_POST['pkUser']) && isset($_POST['projectName'])) {

                $pkUser = $_POST["pkUser"];
                $projectName = $_POST["projectName"];
                //ctrl login
                $login = new ProjetManager();
                $login->createUserProjet($pkUser,$projectName);
            }
            break;
    }
}

?>