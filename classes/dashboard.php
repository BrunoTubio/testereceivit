<?php
    class Dashboard{

        // Instanciando Conexão
        private $conn;

        // Contrutor é levantado com a conexão
        public function __construct($db){
            $this->conn = $db;
        }

        public function CountAllClientes(){
            $sqlQuery = "SELECT count(id) as 'valor', 
            			'Clientes Cadastrados' as 'titulo',
            			'Contador de Clientes no BD' as 'subtitulo'          				
            			FROM clientes";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dataRow;
        }

        public function CountAllTitulos(){
            $sqlQuery = "SELECT count(id) as 'total', concat('R$',sum(valor)) as 'valor' FROM titulos";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dataRow;
        }

        public function ValoresAReceber(){
            $sqlQuery = "SELECT concat('R$',sum(valor)) as 'valor' 
            			 FROM titulos
            			 WHERE vencimento >= CURDATE()";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dataRow;
        }

        public function TitulosVencidos(){
            $sqlQuery = "SELECT concat('R$',sum(valor)) as 'valor' 
            			 FROM titulos
            			 WHERE vencimento < CURDATE()";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dataRow;
        }



}
?>