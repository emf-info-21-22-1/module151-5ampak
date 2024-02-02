<?php
class equipe{
    private $nom;
    private $pk;

    function __construct($nom,$pk){
        $this->nom = $nom;
        $this->pk = $pk;
    }
    public function get_nom()
    {
        return $this->nom;
    }
    public function get_pk()
    {
        return $this->pk;
    }
    public function get_pk_id()
    {
        return $this->pk;
    }
    public function get_pk_name()
    {
        return $this->pk;
    }

}

?>