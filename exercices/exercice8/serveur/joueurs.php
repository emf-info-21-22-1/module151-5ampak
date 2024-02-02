<?php

require_once("Wrk/wrk.php");
require_once("Ctrl/ctrl.php");

$ctrl = new ctrl();

if ($_GET['action'] == 'equipe') 
{
	$ctrl->getEquipes();
}
if($_GET['action'] == "joueur")
{
	if (isset($_GET['equipeId']))
	{
		$ctrl->getJoueurs($_GET['equipeId']);
	}
}