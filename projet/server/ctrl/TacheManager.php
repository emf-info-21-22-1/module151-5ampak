<?php
include_once('session/SessionManager.php');
require_once('wrk/TacheDBManager.php');
class TacheManager
{

  private $manager;
  private $session;

  public function __construct()
  {
    $this->manager = new TacheDBManager();
    $this->session = SessionManager::getInstance();
  }

  public function createTask($projet)
  {
    if ($this->session->get('username')) {
      $jsonString = $this->manager->postCreateTask($projet);
      echo ($jsonString);
    }
  }

  public function moveTask($blockNewLocation, $tacheMove, $userPK)
  {
    if ($this->session->get('username')) {
    $jsonString = $this->manager->putMoveTask($blockNewLocation, $tacheMove, $userPK);
    echo ($jsonString);
    }
  }

  public function getTasksProjet($PKprojet)
  {
    if ($this->session->get('username')) {
    $jsonString = $this->manager->getTasksProjet($PKprojet);
    echo ($jsonString);
    }
  }

  public function modifieDescriptionTask($pkTask,$nom){
    if ($this->session->get('username')) {
      $jsonString = $this->manager->modifieTaskProjet($pkTask,$nom);
      echo($jsonString);
    }
  }
}
?>