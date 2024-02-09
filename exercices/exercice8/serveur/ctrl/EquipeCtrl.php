<?php
require_once('wrk/EquipesDBManager.php');
class EquipeCtrl{
  
  private $manager;  
  public function __construct(){
    $this->manager = new EquipesDBManager();
  } 
  public function getEquipesJSON(){
    $equipes = $this->manager->getEquipes();
    $result = json_encode($equipes);
    return $result;
  }
  

}

?>