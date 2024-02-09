<?php
require_once('wrk/Connexion.php');
require_once('bean/Joueur.php');
class JoueursDBManager
{
  private $connexion;

  public function __construct()
  {

    $this->connexion = connexion::getInstance();
  }

  public function getJoueurs($equipeId)
  {

    $query = $this->connexion->selectQuery("SELECT nom, points from t_joueur where FK_equipe=$equipeId", null);

    $result = array();
    foreach ($query as $row) {
      $joueur = new Joueur($row['nom'], $row['points']);
      $result[] = $joueur;
    }

    return $result;
  }
}

?>