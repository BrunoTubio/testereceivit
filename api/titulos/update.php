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
    
    $item = new Titulos($db);
    
    $data = json_decode(file_get_contents("php://input"));
    var_dump($data);die();
    $item->id = $data->id;
    
    $item->cliente_id = $data->cliente_id;
    $item->descricao = $data->descricao;
    $item->vencimento = date("Y-m-d",strtotime(str_replace('/','-',$data->vencimento))); //formatando a data assim que recebo
    $item->valor = number_format(str_replace(',', '.', $data->valor), 2, '.', '');
    
    if($item->updateTitulo()){
 	    http_response_code(200);
        echo json_encode("Titulo atualizado.");
    } else{
 	    http_response_code(400);
        echo json_encode("Houve um problema ao atualizar esse titulo.");
    }
?>