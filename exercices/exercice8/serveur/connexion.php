<?php
    include("configConnexion.php");

    class Connexion {
        private static $_instance = null;
        private $pdo;

        public static function getInstance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new Connexion();
            }
            return self::$_instance;
        }

        //conn
        private function __construct() {
            try {
                $this->pdo = new PDO(
                    DB_TYPE . ':host=' . DB_HOST .';port=3306;dbname=' . DB_NAME,
                    DB_USER,
                    DB_PASS, 
                    array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    )
                );
             
            } catch (PDOException $e) {
                print "Erreur !" . $e->getMessage() ."<br/>";
                die();
            }
        }

        public function isConnected() {
            return $this->pdo !== null;
        }
    }

    //verifier conn
    $connexion = Connexion::getInstance();
    if ($connexion->isConnected()) {
        echo "Connexion réussie !";
    } else {
        echo "Échec de la connexion !";
    }
?>
