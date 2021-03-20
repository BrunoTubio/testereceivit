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

    $database = new Database();
    $db = $database->getConnection();

    $cliente = new Clientes($db);

    $cliente->id = isset($_GET['id']) ? $_GET['id'] : die();
  	
    if($cliente->getSingleCliente()){
        // monta o array
        $dadosCliente = array(
            "id" =>  $cliente->id,
            "nome" => $cliente->nome,
            "documento" => $cliente->documento,
            "nascimento" => $cliente->nascimento,
            "idade" => $cliente->idade,
            "endereco" => $cliente->endereco,
            "created_date" => $cliente->created_date,
            "updated_date" => $cliente->updated_date
        );
      
        http_response_code(200);
        echo json_encode($dadosCliente);
    }else{
        http_response_code(400);
        echo json_encode("Nenhum cliente encontrado com esse ID");
    }
?>