<?php
header('Access-Control-Allow-Origin: *');
require_once("Wrk/configConnexion.php");
require_once("Wrk/dbConnexion.php");
require_once("Beans/Equipe.php");
require_once("Beans/Joueur.php");
require_once("Wrk/Wrk.php");
require_once("Ctrl/Ctrl.php");

$ctrl = new Ctrl();


if ($_GET['action'] == "equipe")
{
	$equipes = new EquipeCtrl();
	$ctrl->getEquipes();
}

if ($_GET['action'] == "joueur")
{
	if (isset($_GET["equipeId"]))
	{
		$joueurs = new JoueurCtrl();
		$ctrl->getJoueurs($_GET["equipeId"]);
	}
}

?>