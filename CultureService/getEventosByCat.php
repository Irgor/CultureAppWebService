<?php
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Max-Age: 1000");
	header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
	header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");	
	header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
	header("Access-Control-Allow-Origin: *");
	// header("Content-Type: application/json; charset=utf-8"); 
    
    require_once("conexao.php");
    
    $cat = $_GET['cat'];
    if($cat == "Musica"){
    	$sql = "SELECT *, nomeCategoria FROM tbevento INNER JOIN tbcategoria ON tbevento.codCategoria = tbcategoria.codCategoria WHERE nomeCategoria LIKE '%Musica%' OR nomeCategoria LIKE '%Danca%' order by codEvento desc";
    }else if($cat == "Literatura"){
    $sql = "SELECT *, nomeCategoria FROM tbevento INNER JOIN tbcategoria ON tbevento.codCategoria = tbcategoria.codCategoria WHERE nomeCategoria LIKE '%Literatura%' OR nomeCategoria LIKE '%Agenda%' order by codEvento desc";
    
    }else{
    	$sql = "SELECT *, nomeCategoria FROM tbevento INNER JOIN tbcategoria ON tbevento.codCategoria = tbcategoria.codCategoria WHERE nomeCategoria LIKE '%".$cat."%' order by codEvento desc";
    }

    // $sql = "SELECT codEvento, nomeEvento, descricaoEvento, logradouroEvento, cepEvento, nomeTipoEvento, dataInicioEvento, statusEvento FROM tbEvento inner join tbTipoEvento on tbTipoEvento.codTipoEvento = tbEvento.codTipoEvento";
   

    $stmt = $con->prepare($sql);
    if($stmt->execute()){
        if($stmt->rowCount() > 0){
            $result = $stmt->fetchAll();
            // print_r($result);
            $teste;

            foreach($result as $i => $r){
                $teste = $r;

                if($teste['origemEvento'] != 'sesc' && $teste['origemEvento'] != 'Sala São Paulo'){
                    $teste['origemEvento'] = 'Itau Cultural';
                    $teste['16'] = 'Itau Cultural';

                }

                foreach($teste as $j => $v){
                    try{
                        //$v = utf8_decode($v);
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
                    $teste[$j] = $v;
                }
                $result[$i] = $teste;
            }

            $str = "[";
            // print_r($result[17]);
            foreach($result as $i => $ev){

                    //echo(json_encode($ev));
                    //print_r($ev);
                    $str .= json_encode($ev).",";
                    $str = str_replace(",,", ",", $str);
            }

            $fim = strlen($str) - 1;
            $str = substr($str, 0, $fim);            
            $str .= "]";
            $str = str_replace("[,","[", $str);

            
            echo($str);

        }
    }

    
?>