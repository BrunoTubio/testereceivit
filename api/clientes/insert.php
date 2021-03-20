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

	$nome = $documento = $nascimento = $endereco = "";

	$data = json_decode(file_get_contents("php://input"));

	if ($data) {
	  $nome = 		test_input($data->nome);
	  $documento = 	test_input($data->documento);
	  $nascimento = test_input($data->nascimento);
	  $endereco = 	test_input($data->endereco);	
	//Mandou campos em branco ou com problemas
	
	  if(empty($nome) || empty($documento) || empty($nascimento) || empty($endereco)){
	  		http_response_code(400);
		  	echo 'Todos os campos precisam ser preenchidos corretamente';
		  	return;
	  }

	  if(strlen($nome) > 100 || strlen($documento) > 18 || strlen($endereco) > 200){
		  	http_response_code(400);
		  	echo 'Nome não pode passar de 100 caracteres, documento não pode ter mais de 18 e são APENAS números e endereço não pode ser maior que 200 caracteres.';
		  	return;
	  }

	    $database = new Database();
	    $db = $database->getConnection();
	
	    $item = new Clientes($db);
			
	    $item->nome = $nome;
	    $item->documento = $documento;
	    $item->nascimento = date("Y-m-d",strtotime(str_replace('/','-',$nascimento))); //formatando a data assim que recebo
	    $item->endereco = $endereco;
	    
	    if($item->createCliente()){
		    http_response_code(200);
	        echo 'Cliente cadastrado com sucesso!';
	        return;
	    } else{
		    http_response_code(400);
	        echo 'Houve um problema ao cadastrar o cliente.';
	        return;
	    }


	}else{
		http_response_code(400);
		echo "Nenhuma informação chegou até aqui";
		return;
	}
	  

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

?>