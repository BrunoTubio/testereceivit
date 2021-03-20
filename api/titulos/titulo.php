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

    $titulo->id = isset($_GET['id']) ? $_GET['id'] : die();
  	
    if($titulo->getSingleTitulo()){
        // monta o array
        $dadosTitulo = array(

            "id" =>  $titulo->id,
            "cliente_id" => $titulo->cliente_id,
            "descricao" => $titulo->descricao,
            "valor" => str_replace('.', ',', $titulo->valor),
            "vencimento" => $titulo->vencimento,
            "atraso" => $titulo->atraso,
            "created_date" => $titulo->created_date,
            "updated_date" => $titulo->updated_date
        );
      
        http_response_code(200);
        echo json_encode($dadosTitulo);
    }else{
        http_response_code(404);
        echo json_encode("Nenhum titulo encontrado com esse ID");
    }
?>