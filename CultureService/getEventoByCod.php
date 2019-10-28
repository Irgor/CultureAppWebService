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

    //$sql = "SELECT codEvento, nomeEvento, descricaoEvento, logradouroEvento, cepEvento, nomeTipoEvento, dataInicioEvento, statusEvento FROM tbEvento inner join tbTipoEvento on tbTipoEvento.codTipoEvento = tbEvento.codTipoEvento WHERE codEvento = ?";
    $sql = "SELECT *, nomeCategoria FROM tbevento inner join tbcategoria on tbevento.codCategoria = tbcategoria.codCategoria WHERE codEvento = ? ";
    
    $stmt = $con->prepare($sql);
    $stmt->bindParam(1 , $codEvento);


    if($stmt->execute()){
        $result = $stmt->fetchAll();
        $reuslt = $result[0];
        

        
        
        $result = $result[0];
        
        
        
        foreach($result as $i => $v){
            try{
                $v = str_replace('“',"'",$v);
                       $v = str_replace('“',"'",$v);
                        $v = str_replace('”',"'",$v);
                        $v = str_replace(","," ",$v);
                        $v = str_replace("�","u",$v);
                        $v = str_replace("\/","/",$v); 
                        $v = str_replace("Ã","ç",$v);
                        $v = str_replace("§a","á",$v);
                        $v = str_replace("â€œ",'"',$v);
                        $v = str_replace("ç¡â€",'á"',$v);
                        $v = str_replace("ç¢","â",$v);
                        $v = str_replace("§ç£","ã",$v);
                        $v = str_replace("ç¡",'á',$v);
                        $v = str_replace('çª','ê',$v);
                        $v = str_replace('çº','ú',$v);
                        $v = str_replace('ç­','í',$v);
                        $v = str_replace('ç£','ã',$v);
			$v = str_replace("ç©","é",$v);
                        $v = str_replace('ç ','á',$v);
                        $v = str_replace('ç§o','ço',$v);
                        $v = str_replace('â€','"',$v);
                        $v = str_replace('â€','"',$v);
                        $v = str_replace('ç‡ç•','çõ',$v);
                        $v = str_replace('ç³','ó',$v);
                        $v = str_replace("â€'",'-',$v);
                        $v = str_replace('ç ','ás',$v);
                        
                        
                        
                        $v = str_replace("%28","(",$v);
                        $v = str_replace("%29",")",$v);
            }catch(Exception $e){
                $v = $v;
            }
            $result[$i] = $v;
        }

        if($result['origemEvento'] != 'Sesc' && $result['origemEvento'] != 'Sala S達o Paulo'){
            $result['origemEvento'] = 'Itau Cultural';
            $result[16] = 'Itau Cultural';
        }
    
        
        $json = json_encode($result);
        echo($json);
    }

    
    
?>