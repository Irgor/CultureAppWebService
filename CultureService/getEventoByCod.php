<?php
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Max-Age: 1000");
	header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
	header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");	
	header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=utf-8"); 
    
    require_once("conexao.php");
    
    if(isset($_GET['cod'])){
        $codEvento = $_GET['cod'];
    }

    $sql = "SELECT codEvento, nomeEvento, descricaoEvento, logradouroEvento, cepEvento, nomeTipoEvento, dataInicioEvento, statusEvento FROM tbEvento inner join tbTipoEvento on tbTipoEvento.codTipoEvento = tbEvento.codTipoEvento WHERE codEvento = ?";
    
    $stmt = $con->prepare($sql);
    $stmt->bindParam(1 , $codEvento);

    if($stmt->execute()){
        $result = $stmt->fetchAll();
        $json = json_encode($result);
        echo($json);
    }

    
    
?>