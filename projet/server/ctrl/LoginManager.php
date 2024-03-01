<?php
include_once('session/SessionManager.php');
require_once('wrk/LoginDBManager.php');

class LoginManager
{

  private $manager;

  public function __construct()
  {
    $this->manager = new LoginDBManager();
  }

  public function createUser($username, $password)
  {
    // Appeler la méthode createUser de LoginDBManager
    return $this->manager->createUser($username, $password);
  }

  public function loginUser($username, $password)
  {
      // Crée instance
      $session = SessionManager::getInstance(); 

          $jsonString = $this->manager->loginUser($username, $password);
          
          // Décoder la chaîne JSON
          $data = json_decode($jsonString, true);

          // Récupérer la valeur bool de la clé 'success'
          $success = $data['success'];

          if ($success) {
              // Crée instance + définit la variable de session
              $session->set('username', $username);
              //sessionStor.setItem('username', $$username);
              echo($jsonString);
          }
  }

  public function logoutUser($username){
    $session = SessionManager::getInstance();
    
    $session->destroy();
    

   // if (!$session->has('username')) {
      $jsonString = $this->manager->logoutUser(true,$username);
      echo($jsonString);
    //}else{
     // $jsonString = $this->manager->logoutUser(false);
      //echo($jsonString);
    //}
    
  }
}

?>