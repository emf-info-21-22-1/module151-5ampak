<?php
include_once('session/SessionManager.php');
require_once('wrk/LoginDBManager.php');

class LoginManager
{

  private $manager;
  private $session;

  public function __construct()
  {
    $this->manager = new LoginDBManager();

    $this->session = SessionManager::getInstance();
  }

  public function createUser($username, $password)
  {
    // Appeler la méthode createUser de LoginDBManager
    return $this->manager->createUser($username, $password);
  }

  public function loginUser($username, $password)
  {


    $jsonString = $this->manager->loginUser($username, $password);
    //don't crée session when no logged
    $data = json_decode($jsonString, true);

    if ($data['connexionPossible']) {
      // Crée instance + définit la variable de session (USER UNIQUE !)
      $this->session->set('username', $username);
    }


    echo ($jsonString);

  }

  public function logoutUser($username)
  {

    $result = "";

    if ($this->session->get('username')) {

      $this->session->destroy();
      $jsonString = $this->manager->logoutUser(true, $username);
      $result = $jsonString;
    } else {

      $jsonString = $this->manager->logoutUser(false, $username);
      $result = $jsonString;
    }
    echo $result;
  }
}

?>