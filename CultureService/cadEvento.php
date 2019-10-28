<?php	
	header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8"); 
	header("Access-Control-Request-Headers: X-PINGOTHER, Content-Type");
	
	require('conexao.php');
    
	$data = json_decode(file_get_contents('php://input'), true);

    $categorias;

    $sql = "SELECT * FROM tbcategoria";
    $stmt = $con->prepare($sql);
    if($stmt->execute()){
        $categorias = $stmt->fetchAll();
    }

    foreach ($data as $evento) {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($evento['local'])."+CA&key=AIzaSyCAckKLHl-T6HPk2pTVfxrjHXf4yLojpfw&amp";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $localData = json_decode($response, true);
        $evento['localData'] = $localData;
        
        $localData = $localData['results'];
        $localData = $localData[0];
        $localData = $localData['address_components'];
                

        $con2 = $con;
        $status = 0;
        
        $sql = "SELECT nomeEventoBot FROM tbeventobot WHERE nomeEventoBot like ?";
        $stmt = $con->prepare($sql);
        $nomeEvento = $evento['nome'];
        $nomeEvento = $nomeEvento;
        $stmt->bindParam(1, $nomeEvento);



        if($stmt->execute()){
            if($stmt->rowCount() <= 0){
                $sql2 = "INSERT INTO tbeventobot(nomeEventoBot, descricaoEventoBot, dataInicioEventoBot, dataFinalEventoBot, logradouroEventoBot, bairroEventoBot, cepEventoBot, statusCadastro, imgEventoBot, numeroEventoBot,valorEventoBot, classificacaoIndicativa, nomeCategoria, codCategoria, origemEvento, siteOrigemEvento) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt2 = $con2->prepare($sql2);


                
                $nome = $evento['nome'];
                $desc = $evento['desc'];
                $dataIni = $evento['dataIni'];
                $dataFim = $evento['dataFim'];
                $log = $localData[1]['long_name'];
                $bairro = $localData[2]['long_name'];
                $cep = $localData[6]['long_name'];
                $img = $evento['img'];
                $num = $localData[0]['long_name'];
                $preco = $evento['preco'];
                $classi = $evento['classificacao'];
                $cat = $evento['categoria'];
                
                $codCat = 0;
                foreach($categorias as $cati){
                    if($evento['categoria'] == $cati['nomeCategoria']){
                    	echo($evento['categoria']." ".$cati['nomeCategoria']."\n");
                        $codCat = $cati['codCategoria'];
                    }
                }


                $origem = $evento['origem'];
                $siteOrigem = $evento['siteOrigem'];

                
                $stmt2->bindParam(1,$nome);
                $stmt2->bindParam(2,$desc);  
                $stmt2->bindParam(3,$dataIni);  
                $stmt2->bindParam(4,$dataFim);  
                $stmt2->bindParam(5,$log);  
                $stmt2->bindParam(6,$bairro);  
                $stmt2->bindParam(7,$cep);  
                $stmt2->bindParam(8,$status);  
                $stmt2->bindParam(9, $img);
                $stmt2->bindParam(10, $num);
                $stmt2->bindParam(11, $preco);
                $stmt2->bindParam(12, $classi);
                $stmt2->bindParam(13, $cat);
                $stmt2->bindParam(14, $codCat);
                $stmt2->bindParam(15, $origem);
                $stmt2->bindParam(16, $siteOrigem);
                

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