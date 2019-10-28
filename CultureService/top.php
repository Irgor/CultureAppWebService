<?php
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Max-Age: 1000");
	header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
	header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");	
	header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=utf-8"); 
    
    require_once("conexao.php");

    $sql = "SELECT * FROM tbevento ORDER BY codEvento desc";

    $stmt = $con->prepare($sql);

    if($stmt->execute()){
        $obj = $stmt->fetchAll();
        $json = json_encode($obj);
        echo($json);
    }


?>