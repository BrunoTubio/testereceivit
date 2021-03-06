<?php 
    class Database {
        private $host = "localhost";
        private $database_name = "receivit";
        private $username = "root";
        private $password = "root";

        public $conn;

        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Problema ao conectar no MySQL: " . $exception->getMessage();
            }
            return $this->conn;
        }
    }  
?>