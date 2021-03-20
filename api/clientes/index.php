<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../../config/database.php';
    include_once '../../classes/clientes.php';

    $database = new Database();
    $db = $database->getConnection();

    $clientes = new Clientes($db);

    $stmt = $clientes->getAllClientes();
    $itemCount = $stmt->rowCount();


    //echo json_encode($itemCount);

    if($itemCount > 0){
        
        $clientesArray = array();
        //$clientesArray["body"] = array();
        //$clientesArray["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "nome" => $nome,
                "documento" => $documento,
                "nascimento" => $nascimento,
                "idade" => $idade,
                "endereco" => $endereco,
                "created_date" => $created_date,
                "updated_date" => $updated_date
            );

            array_push($clientesArray, $e);
        }
        echo json_encode($clientesArray, JSON_FORCE_OBJECT);

    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "Nenhum cliente cadastrado.")
        );
    }
?>