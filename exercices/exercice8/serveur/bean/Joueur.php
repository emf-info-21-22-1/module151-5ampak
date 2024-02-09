<?php
class Joueur implements JsonSerializable{
  private $nom;
  private $points;
  
  public function __construct($nom, $points){
    $this->nom = $nom;
    $this->points = $points;
  }
  
  public function getNom(){
    return $this->nom;
  }
  
  public function getPoints(){
    return $this->points;
  }

  public function jsonSerialize() :mixed{
    return [
      'points' => $this->points,
      'nom' => $this->nom,
    ];}
}
?>