<?php
    class Titulos{

        // Instanciando Conexão
        private $conn;

        // Instanciando Tabela
        private $db_table = "titulos";

        // Instanciando campos em variáveis
        public $id;
        public $cliente_id;
        public $descricao;
        public $valor;
        public $vencimento;
        public $created_date;
        public $updated_date;

        // Contrutor é levantado com a conexão
        public function __construct($db){
            $this->conn = $db;
        }

        // Método que retorna todos os titulos cadastrados na tabela
        // Formatei a data que entra em PHP e estou formatando a data de saída em SQL, só pra fazer diferente
        // Cálculo dinâmico da idade direto em Query
        public function getAllTitulos(){
            $sqlQuery = "SELECT titulos.id as id, 
            			 cliente_id, 
            			 descricao, 
            			 valor, 
            			 DATE_FORMAT(vencimento,'%d/%m/%Y') as 'vencimento',
            			 TIMESTAMPDIFF(DAY, vencimento, CURDATE()) AS 'atraso',  
            			 DATE_FORMAT(titulos.created_date,'%d/%m/%Y') as 'created_date', 
            			 DATE_FORMAT(titulos.updated_date,'%d/%m/%Y') as 'updated_date',
            			 clientes.nome as nome_cliente 
            			 FROM " . $this->db_table . "
            			 JOIN clientes ON cliente_id = clientes.id";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        public function getTitulosCliente($cliente_id){
            $sqlQuery = "SELECT titulos.id as id, 
            			 cliente_id, 
            			 descricao, 
            			 valor, 
            			 DATE_FORMAT(vencimento,'%d/%m/%Y') as 'vencimento',
            			 TIMESTAMPDIFF(DAY, vencimento, CURDATE()) AS 'atraso',  
            			 DATE_FORMAT(titulos.created_date,'%d/%m/%Y') as 'created_date', 
            			 DATE_FORMAT(titulos.updated_date,'%d/%m/%Y') as 'updated_date',
            			 clientes.nome as nome_cliente 
            			 FROM " . $this->db_table . "
            			 JOIN clientes ON cliente_id = clientes.id
            			 WHERE cliente_id = " . $cliente_id . ""
            			 ;
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // Método que Insere um Titulo cliente na tabela
        public function createTitulo(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
						SET
                        cliente_id = :cliente_id, 
                        descricao = :descricao, 
                        valor = :valor, 
                        vencimento = :vencimento, 
                        created_date = now()";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->cliente_id=htmlspecialchars(strip_tags($this->cliente_id));
            $this->descricao=htmlspecialchars(strip_tags($this->descricao));
            $this->valor=htmlspecialchars(strip_tags($this->valor));
            $this->vencimento=htmlspecialchars(strip_tags($this->vencimento));
        
            // bind data
            $stmt->bindParam(":cliente_id", $this->cliente_id);
            $stmt->bindParam(":descricao", $this->descricao);
            $stmt->bindParam(":valor", $this->valor);
            $stmt->bindParam(":vencimento", $this->vencimento);
			
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // Método que recebe um ID e retorna o titulo relacionado
        public function getSingleTitulo(){
            $sqlQuery = "SELECT id, 
            			 cliente_id, 
            			 descricao, 
            			 valor, 
            			 DATE_FORMAT(vencimento,'%d/%m/%Y') as 'vencimento',
            			 TIMESTAMPDIFF(DAY, vencimento, CURDATE()) AS 'atraso',  
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

	            $this->cliente_id = $dataRow['cliente_id'];
	            $this->descricao = $dataRow['descricao'];
	            $this->valor = $dataRow['valor'];
	            $this->vencimento = $dataRow['vencimento'];
	            $this->atraso = $dataRow['atraso'];
	            $this->created_date = $dataRow['created_date'];
	            $this->updated_date = $dataRow['updated_date'];
				
				return true;	            
			}else{
				return false;
			}
        }        

        // Método que recebe um ID e atualiza o titulo selecionado
        public function updateTitulo(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        cliente_id = :cliente_id, 
                        descricao = :descricao, 
                        valor = :valor, 
                        vencimento = :vencimento, 
                        updated_date = now()
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->cliente_id=htmlspecialchars(strip_tags($this->cliente_id));
            $this->descricao=htmlspecialchars(strip_tags($this->descricao));
            $this->valor=htmlspecialchars(strip_tags($this->valor));
            $this->vencimento=htmlspecialchars(strip_tags($this->vencimento));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":cliente_id", $this->cliente_id);
            $stmt->bindParam(":descricao", $this->descricao);
            $stmt->bindParam(":valor", $this->valor);
            $stmt->bindParam(":vencimento", $this->vencimento);
            $stmt->bindParam(":id", $this->id);
			$stmt->execute();
        
            if($stmt->rowCount() > 0){
               return true;
            }
               return false;
        	
        }

        // Apaga do Banco o titulo selecionado
        function deleteTitulo(){
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