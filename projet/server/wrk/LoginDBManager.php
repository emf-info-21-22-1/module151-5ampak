<?php

require_once('connexion/Connexion.php');
include('beans/user.php');
class LoginDBManager
{

  public function __construct()
  {
    // Initialisation de lsa connexion à la base de données, si nécessaire
  }

  public function createUser($username, $password)
  {

    //check if user already exist
    //param
    $params = array('username' => $username);
    //request
    $query = Connexion::getInstance()->selectSingleQuery("SELECT username FROM t_user WHERE username=:username", $params);
    if (!$query) {
      //hashed password
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      //crée param
      $params = array('username' => $username, 'password' => $hashedPassword);
      //execuite query
      $query = Connexion::getInstance()->executeQuery("INSERT INTO t_user(username, password) VALUES (:username, :password);", $params);
      http_response_code(200);
      echo json_encode(array('success' => true, 'message' => 'Utilisateur créé avec succès'));
    } else {
      //pas autoriser
      http_response_code(401);
      echo "User already exist !";
    }
  }

  public function loginUser($username, $password)
  {

    $json = "";

    // Paramètres pour la requête
    $params = array('username' => $username);
    //requête pour check user existe
    $row = Connexion::getInstance()->selectSingleQuery("SELECT * FROM t_user WHERE username=:username", $params);


    if ($row) {
      // Création d'un nouvel objet User et initialisation à partir des données de la base de données
      $user = new User();
      $user->initFromDb($row);


      if ($user->getPassword() !== null) {
        // Récupération du mot de passe haché depuis la base de données
        $db_password_hash = $user->getPassword();

        //vérifier si c'est le même password
        if (password_verify($password, $db_password_hash)) {

          http_response_code(200);
          $json = json_encode(array('success' => true, 'message' => 'Connexion possible','Userlogin' => $user->getUsername(), 'UserPK' => $user->getPKUser()));

        } else {
          http_response_code(401);
          $json = json_encode(array('success' => false, 'message' => 'Connexion impossible : mot de passe incorrect'));
        }
        
      } else {
        http_response_code(404);
        $json = json_encode(array('success' => false, 'message' => 'Connexion impossible : mot de passe non défini dans la base de données'));
      }
    } else {
      http_response_code(404);
      $json = json_encode(array('success' => false, 'message' => 'Connexion impossible : utilisateur non trouvé'));

    }
    return $json;
  }



  public function logoutUser( bool $result, $username){
    $json = "";
    if($result){
     http_response_code(200);
       $json = json_encode(array('success' => true, 'message' => "Deconnexion réussis : L'utilisateur à bien été déconnecter", 'userLogOut' => $username));
      
    }else{
      http_response_code(401);
      $json = json_encode(array('success' => false, 'message' => "Deconnexion non réussis : L'utilisateur n'a pas été déconnecter"));
    } 
   return $json;
  }

}
?>