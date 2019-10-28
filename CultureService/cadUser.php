<?php	
	header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=utf-8"); 
	header("Access-Control-Request-Headers: X-PINGOTHER, Content-Type");
	
	require('conexao.php');
    
	$json = $_GET['json'];
	$obj = json_decode($json, true);

	$data =  date("Y-m-d");

	
	$sql="SELECT codUsuario from tbusuario WHERE emailUsuario like ?";
	$stmt = $con->prepare($sql);
	$stmt->bindParam(1, $obj['emailUsuario']);
	$stmt->execute();
	
	$cod = $stmt->fetchAll();
	
	
	if($cod[0]['codUsuario'] > 0){
		echo('{"0":"-1"}');
	}else{
		$sql = "INSERT INTO tbusuario(nomeUsuario, emailUsuario, senhaUsuario, dataNascimentoUsuario, statusUsuario, codNivel, dataCadastro) VALUES (?,?,?,?,1,2,?)";
                
		$stmt = $con->prepare($sql);
		$stmt->bindParam(1, $obj['nomeUsuario']);
		$stmt->bindParam(2, $obj['emailUsuario']);
		$stmt->bindParam(3, $obj['senhaUsuario']);	
		$stmt->bindParam(4, $obj['dataNascimentoUsuario']);
		$stmt->bindParam(5, $data);
	        
		if($stmt->execute()){
			echo('{"0":"1"}');
		}else{
			echo('{"0":"0"}');
		}
	}


	
	
?>