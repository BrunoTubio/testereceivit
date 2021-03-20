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
    include_once '../../classes/titulos.php';
    
    $database = new Database();
    $db = $database->getConnection();
        
    $titulo = new Titulos($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $titulo->id = $data->id;
    
    if($titulo->deleteTitulo()){
	    http_response_code(200);
        echo json_encode("Titulo apagado com sucesso");
    } else{
        http_response_code(404);
        echo json_encode("Problema ao apagar esse titulo");
    }
?>