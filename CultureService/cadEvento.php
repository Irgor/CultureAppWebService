<?php	
	header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=utf-8"); 
	header("Access-Control-Request-Headers: X-PINGOTHER, Content-Type");
	
	require('conexao.php');
    
	$data = json_decode(file_get_contents('php://input'), true);

    foreach ($data as $evento) {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($evento['local'])."+CA&key=AIzaSyCAckKLHl-T6HPk2pTVfxrjHXf4yLojpfw&amp";
        $localData = json_decode(file_get_contents($url), true);
        $evento['localData'] = $localData;
        
        $localData = $localData['results'];
        $localData = $localData[0];
        $localData = $localData['address_components'];

        // var_dump($evento);

        $con2 = $con;
        $status = 0;
        
        $sql = "SELECT nomeEventoBot FROM tbeventobot WHERE nomeEventoBot like ?";
        $stmt = $con->prepare($sql);
        $nomeEvento = $evento['nome'];
        $nomeEvento = utf8_encode($nomeEvento);
        $stmt->bindParam(1, $nomeEvento);


        if($stmt->execute()){
            if($stmt->rowCount() <= 0){
                $sql2 = "INSERT INTO tbeventobot(nomeEventoBot, descricaoEventoBot, dataInicioEventoBot, logradouroEventoBor, bairroEventoBot, cepEventoBot, statusCadastro) VALUES (?,?,?,?,?,?,?)";
                $stmt2 = $con2->prepare($sql2);


                $nome = utf8_encode($evento['nome']);
                $desc = utf8_encode($evento['desc']);
                $data = utf8_encode($evento['data']);
                $log = utf8_encode($localData[1]['long_name']);
                $bairro = utf8_encode($localData[2]['long_name']);
                $cep = $localData[6]['long_name'];

                $stmt2->bindParam(1,$nome);
                $stmt2->bindParam(2,$desc);  
                $stmt2->bindParam(3,$data);  
                $stmt2->bindParam(4,$log);  
                $stmt2->bindParam(5,$bairro);  
                $stmt2->bindParam(6,$cep);  
                $stmt2->bindParam(7,$status);  

                if($stmt2->execute()){
                    echo("O evento: ".$evento['nome']." foi cadastrado!\n\n");
                }else{
                    echo("Erro ao cadastrar o evento: ".$evento['nome']."\n\n");
                }
            }else{
                echo("O evento: ".$evento['nome']." já esta cadastrado!\n\n");
            }
        }
        



    }

?>