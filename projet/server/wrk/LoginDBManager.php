<?php

require_once('connexion/Connexion.php');
include('beans/user.php');
class LoginDBManager
{
  private $connexion;

  public function __construct()
  {
    $this->connexion = Connexion::getInstance();
  }

  public function createUser($username, $password)
  {
    //protection
    $escapedInputUsername = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    //pas besoin ?
    $escapedInputpassword = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');

    //check if user already exist

    //param
    $params = array('username' => $escapedInputUsername);
    //request
    $query = $this->connexion->selectSingleQuery("SELECT username FROM t_user WHERE username=:username", $params);
    if (!$query) {
      //hashed password
      $hashedPassword = password_hash($escapedInputpassword, PASSWORD_DEFAULT);
      //crée param
      $params = array('username' => $escapedInputUsername, 'password' => $hashedPassword);
      //execuite query
      $query = $this->connexion->executeQuery("INSERT INTO t_user(username, password) VALUES (:username, :password);", $params);
      http_response_code(200);
      echo json_encode(array('message' => 'Utilisateur créé avec succès !'));
    } else {
      //pas autoriser
      http_response_code(401);
      echo json_encode(array('message' => 'Utilisateur existe déjà'));
    
    }
  }

  public function loginUser($username, $password)
  {

    $json = "";

    // Paramètres pour la requête
    $params = array('username' => $username);
    //requête pour check user existe
    $row =  $this->connexion->selectSingleQuery("SELECT * FROM t_user WHERE username=:username", $params);


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
          $json = json_encode(array('connexionPossible'=> true,'message' => 'Connexion possible ! ','Userlogin' => $user->getUsername(), 'UserPK' => $user->getPKUser(), "IsAdmin" => $user->îsAdmin()));
          
        } else {
          http_response_code(401);
          $json = json_encode(array('connexionPossible'=> false,'message' => 'Connexion impossible : mot de passe incorrect'));
        }
        
      } else {
        http_response_code(404);
        $json = json_encode(array('connexionPossible'=> false,'message' => 'Connexion impossible : mot de passe non défini dans la base de données'));
      }
    } else {
      http_response_code(404);
      $json = json_encode(array('connexionPossible'=> false,'message' => 'Connexion impossible : utilisateur non trouvé'));

    }
    return $json;
  }



  public function logoutUser(bool $result, $username){
    $json = "";
    if($result){
        http_response_code(200);
        $json = json_encode(array('message' => "Déconnexion réussie : L'utilisateur a bien été déconnecté", 'userLogOut' => $username));
    } else {
        http_response_code(404);
        $json = json_encode(array('message' => "Déconnexion échouée : L'utilisateur n'a pas été déconnecté"));
    } 
    return $json;
}

}
?>