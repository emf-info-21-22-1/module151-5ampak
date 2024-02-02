<?php

class ctrl
{

    private $wrk;
    public function __construct()
    {
       include_once('wrk.php');
       $this->wrk = new wrk();
    }

    public function getEquipes()
    { 
       
        return $this->wrk->getEquipesFromDB(); 
    }
}

?>