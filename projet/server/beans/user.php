<?php
class User {
    private $pk_user;
    private $username;
    private $password;
 
    private $isAdmin;

    public function initFromDb($data){
        $this->pk_user = $data["PK_User"];
        $this->username = $data["Username"];
        $this->password = $data["Password"];
        $this->isAdmin = $data["IsAdmin"];
    }
 
    public function getPKUser(){
        return $this->pk_user;
    }
 
    public function getUsername(){
        return $this->username;
    }
 
    public function getPassword(){
        return $this->password;
    }
    public function îsAdmin(){
        return $this->isAdmin == 1 ? true : false;
    }

}
 
?>