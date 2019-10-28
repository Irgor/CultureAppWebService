<?php	
	header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=utf-8"); 
	header("Access-Control-Request-Headers: X-PINGOTHER, Content-Type");
	require('conexao.php');
    
    $login = $_GET['login'];
    $senha = $_GET['senha'];
    
    $sql = "SELECT codUsuario FROM tbusuario WHERE emailUsuario like ? and senhaUsuario like ?";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(1, $login);
    $stmt->bindParam(2, $senha);
    
    if($stmt->execute()){
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if($r['codUsuario'] === null){
        
            echo '{"0":"0"}';
        }else{
            echo '{"0":"'.$r['codUsuario'].'"}';
        }
    }
    
?>