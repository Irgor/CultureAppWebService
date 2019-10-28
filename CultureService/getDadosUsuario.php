<?php	
    header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=utf-8"); 
    header("Access-Control-Request-Headers: X-PINGOTHER, Content-Type");
    require('conexao.php');
    
    $cod = $_GET['cod'];
    
    $sql = "SELECT * FROM tbusuario WHERE codUsuario like ?";
    
    $stmt = $con->prepare($sql);
    $stmt->bindParam(1, $cod);
    
    if($stmt->execute()){
        $user = $stmt->fetchAll();
        $json = json_encode($user);
        echo($json);
    }
    
?>