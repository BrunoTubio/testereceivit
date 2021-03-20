<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../../config/database.php';
    include_once '../../classes/dashboard.php';

    $database = new Database();
    $db = $database->getConnection();

    $dashboard = new Dashboard($db);

    $Final = array();
    
    $ClientesCadastrados = $dashboard->CountAllClientes();

    $DadosTitulos = $dashboard->CountAllTitulos();
	$ArrayTitulo = ["titulo" => "Total de Titulos"];
	$ArraySubTitulo = ["subtitulo" => "Valor dos títulos"];
	$TotalTitulos = array_merge($DadosTitulos, $ArrayTitulo, $ArraySubTitulo);	

    $ValoresReceber = $dashboard->ValoresAReceber();
	$ArrayTitulo = ["titulo" => "Valores futuros"];
	$ArraySubTitulo = ["subtitulo" => "Títulos que ainda não venceram"];	
	$TotalTitulosReceber = array_merge($ValoresReceber, $ArrayTitulo, $ArraySubTitulo);

    $ValoresVencidos = $dashboard->TitulosVencidos();
	$ArrayTitulo = ["titulo" => "Valores Vencidos"];
	$ArraySubTitulo = ["subtitulo" => "Total em Reais de títulos vencidos"];	
	$TotalTitulosVencidos = array_merge($ValoresVencidos, $ArrayTitulo, $ArraySubTitulo);
	
	array_push($Final, $ClientesCadastrados, $TotalTitulos, $TotalTitulosReceber, $TotalTitulosVencidos);
	echo json_encode($Final, JSON_FORCE_OBJECT); 
die(0);

?>