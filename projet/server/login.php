<?php
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Origin: https://paccauds.emf-informatique.ch/151/client');
header('Access-Control-Allow-Credentials: true');


//connexion ctrl
include_once('ctrl/LoginManager.php');


if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'createUser':
            if (isset($_POST['username'])) {
                if (isset($_POST['password'])) {

                    $username = $_POST["username"];
                    $password = $_POST["password"];
                    
                    //ctrl login
                    $login = new LoginManager();
                    $login->createUser($username, $password);
                
                }
            }
            break;
    }
}
?>