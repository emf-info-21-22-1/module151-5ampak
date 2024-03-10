<?php
class Projet {
    private $PK_Projet;
    private $Nom;
    private $Description;
 

    public function initFromDb($data){
        $this->PK_Projet = $data["PK_Projet"];
        $this->Nom = $data["Nom"];
        $this->Description = $data["Description"];

    }
 
    public function getPKProjet(){
        return $this->PK_Projet;
    }
 
    public function getNom(){
        return $this->Nom;
    }
 
    public function getDesccription(){
        return $this->Description;
    }
}
 
?>