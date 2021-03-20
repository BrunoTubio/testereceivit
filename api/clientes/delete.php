<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../classes/clientes.php';
    include_once '../../classes/titulos.php';

    $database = new Database();
    $db = $database->getConnection();

    $data = json_decode(file_get_contents("php://input"));

	if($data->id){

	    $titulo = new Titulos($db);
	    $stmt = $titulo->getTitulosCliente($data->id);
	    $itemCount = $stmt->rowCount();

	    //var_dump($itemCount);die();
	    
		if($itemCount > 0){
			http_response_code(400);
			echo json_encode("Voce nao pode apagar um cliente que tem um titulo cadastrado");
		}else{

		    $cliente = new Clientes($db);
		    $cliente->id = $data->id;
		    
			    if($cliente->deleteCliente()){
				    http_response_code(200);
			        echo json_encode("Cliente apagado com sucesso");
			    } else{
			        http_response_code(400);
			        echo json_encode("Problema ao apagar esse cliente");
			    }
		}
		
	}else{
		http_response_code(400);
		echo json_encode("Nenhum dado recebido");
		
	}
    
        
?>