<?php
    class Clientes{

        // Instanciando Conexão
        private $conn;

        // Instanciando Tabela
        private $db_table = "clientes";

        // Instanciando campos em variáveis
        public $id;
        public $nome;
        public $documento;
        public $nascimento;
        public $endereco;
        public $created_date;
        public $updated_date;

        // Contrutor é levantado com a conexão
        public function __construct($db){
            $this->conn = $db;
        }

        // Método que retorna todos os clientes cadastrados na tabela
        // Formatei a data que entra em PHP e estou formatando a data de saída em SQL, só pra fazer diferente
        // Cálculo dinâmico da idade direto em Query
        public function getAllClientes(){
            $sqlQuery = "SELECT id, 
            			 nome, 
            			 documento, 
            			 DATE_FORMAT(nascimento,'%d/%m/%Y') as 'nascimento',
            			 TIMESTAMPDIFF(YEAR, nascimento, CURDATE()) AS 'idade',  
            			 endereco, 
            			 DATE_FORMAT(created_date,'%d/%m/%Y') as 'created_date', 
            			 DATE_FORMAT(updated_date,'%d/%m/%Y') as 'updated_date' 
            			 FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // Método que Insere um novo cliente na tabela
        public function createCliente(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
						SET
                        nome = :nome, 
                        documento = :documento, 
                        nascimento = :nascimento, 
                        endereco = :endereco, 
                        created_date = now()";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->nome=htmlspecialchars(strip_tags($this->nome));
            $this->documento=htmlspecialchars(strip_tags($this->documento));
            $this->nascimento=htmlspecialchars(strip_tags($this->nascimento));
            $this->endereco=htmlspecialchars(strip_tags($this->endereco));
        
            // bind data
            $stmt->bindParam(":nome", $this->nome);
            $stmt->bindParam(":documento", $this->documento);
            $stmt->bindParam(":nascimento", $this->nascimento);
            $stmt->bindParam(":endereco", $this->endereco);
			
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // Método que recebe um ID e retorna o cliente relacionado
        public function getSingleCliente(){
            $sqlQuery = "SELECT id, 
            			 nome, 
            			 documento, 
            			 DATE_FORMAT(nascimento,'%d/%m/%Y') as 'nascimento',
            			 TIMESTAMPDIFF(YEAR, nascimento, CURDATE()) AS 'idade',  
            			 endereco, 
            			 DATE_FORMAT(created_date,'%d/%m/%Y') as 'created_date', 
            			 DATE_FORMAT(updated_date,'%d/%m/%Y') as 'updated_date' 
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

	            $stmt->execute();
	
	            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

			if($dataRow !== FALSE){ //Se não encontra nada com o ID, o banco retorna 0
					            
	            $this->nome = $dataRow['nome'];
	            $this->documento = $dataRow['documento'];
	            $this->nascimento = $dataRow['nascimento'];
	            $this->idade = $dataRow['idade'];
	            $this->endereco = $dataRow['endereco'];
	            $this->created_date = $dataRow['created_date'];
	            $this->updated_date = $dataRow['updated_date'];
				
				return true;	            
			}else{
				return false;
			}
        }        

        // Método que recebe um ID e atualiza os dados do cliente
        public function updateCliente(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        nome = :nome, 
                        documento = :documento, 
                        nascimento = :nascimento, 
                        endereco = :endereco, 
                        updated_date = now()
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->nome=htmlspecialchars(strip_tags($this->nome));
            $this->documento=htmlspecialchars(strip_tags($this->documento));
            $this->nascimento=htmlspecialchars(strip_tags($this->nascimento));
            $this->endereco=htmlspecialchars(strip_tags($this->endereco));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":nome", $this->nome);
            $stmt->bindParam(":documento", $this->documento);
            $stmt->bindParam(":nascimento", $this->nascimento);
            $stmt->bindParam(":endereco", $this->endereco);
            $stmt->bindParam(":id", $this->id);
			$stmt->execute();
        
            if($stmt->rowCount() > 0){
               return true;
            }
               return false;
        	
        }

        // Apaga do Banco o Cliente selecionado pelo ID
        function deleteCliente(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
                    
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
        
            if($stmt->rowCount() > 0){
               return true;
            }
               return false;
        	}

    }
?>