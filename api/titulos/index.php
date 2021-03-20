<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../../config/database.php';
    include_once '../../classes/titulos.php';

    $database = new Database();
    $db = $database->getConnection();

    $titulos = new Titulos($db);

	if(isset($_GET['id_cliente']) && is_numeric($_GET['id_cliente'])){

		$stmt = $titulos->getTitulosCliente($_GET['id_cliente']);
	}else{
	    $stmt = $titulos->getAllTitulos();	
	}
    $itemCount = $stmt->rowCount();

    if($itemCount > 0){
        
        $titulosArray = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "cliente_id" => $cliente_id,
                "descricao" => $descricao,
                "valor" => str_replace('.', ',', $valor),
                "vencimento" => $vencimento,
                "atraso" => $atraso,
                "created_date" => $created_date,
                "updated_date" => $updated_date,
                "nome_cliente" => $nome_cliente

            );

            array_push($titulosArray, $e);
        }
        echo json_encode($titulosArray);
    }

    else{
        http_response_code(400);
        echo json_encode(
            array("message" => "Nenhum titulo encontrado.")
        );
    }
?>