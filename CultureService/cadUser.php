<?php	
	header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=utf-8"); 
	header("Access-Control-Request-Headers: X-PINGOTHER, Content-Type");
	
	require('conexao.php');
    
	$json = $_GET['json'];
	$obj = json_decode($json, true);

	// echo($json);
	// var_dump($obj);

	$sql = "INSERT INTO tbUsuario(nomeUsuario, emailUsuario, senhaUsuario, dataNascimentoUsuario, loginUsuario) VALUES (?,?,?,?,?)";
	$stmt = $con->prepare($sql);
	$stmt->bindParam(1, $obj['nomeUsuario']);
	$stmt->bindParam(2, $obj['emailUsuario']);
	$stmt->bindParam(3, $obj['senhaUsuario']);	
	$stmt->bindParam(4, $obj['dataNascimentoUsuario']);
	$stmt->bindParam(5, $obj['emailUsuario']);	
	
	if($stmt->execute()){
		echo("a");
	}else{
		echo("n");
	}
	
?>