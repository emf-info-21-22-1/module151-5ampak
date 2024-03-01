<?php
include_once('session/SessionManager.php');
require_once('wrk/ProjetDBManager.php');

class ProjetManager{

    private $manager;

    public function __construct()
    {
      $this->manager = new ProjetDBManager();
    }
  
    public function getProjetUser($username, $pkUser)
    {
        echo'projet Ctrl';
    }
}  
?>