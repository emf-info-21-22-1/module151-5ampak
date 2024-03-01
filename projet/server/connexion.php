<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Credentials: true');
//connexion ctrl
include_once('ctrl/LoginManager.php');


if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'loginUser':
            if (isset($_POST['username'])) {
                if (isset($_POST['password'])) {

                    $username = $_POST["username"];
                    $password = $_POST["password"];

                    //ctrl login
                    $login = new LoginManager();
                    $login->loginUser($username, $password);

                }
            }
            break;
        case 'logoutUser':
            if (isset($_POST['username'])) {

                $username = $_POST["username"];
                //ctrl login
                $login = new LoginManager();
                $login->logoutUser($username);

            }
            break;
    }

}


?>