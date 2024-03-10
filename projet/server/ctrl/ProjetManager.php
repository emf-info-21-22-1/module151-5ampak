<?php
include_once('session/SessionManager.php');
require_once('wrk/ProjetDBManager.php');

class ProjetManager
{

  private $manager;
  private $session;

  public function __construct()
  {
    $this->session = SessionManager::getInstance();
    $this->manager = new ProjetDBManager();
  }

  public function getProjetUser($username, $pkUser)
  {

    //get 'username'
    if ($this->session->get('username')) {
      $result = $this->manager->getProjetUser($pkUser);
      echo ($result);
    }


  }
  public function createUserProjet($pkUser,$projectName)
  {
    if ($this->session->get('username')) {
      $result = $this->manager->postProjetUser($pkUser,$projectName);
      echo ($result);
    }
  }
}
?>