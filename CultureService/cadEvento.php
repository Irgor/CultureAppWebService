<?php	
	header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=utf-8"); 
	header("Access-Control-Request-Headers: X-PINGOTHER, Content-Type");
	
	require('conexao.php');
    
	$data = json_decode(file_get_contents('php://input'), true);


    foreach ($data as $v) {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($v['local'])."+CA&key=AIzaSyCAckKLHl-T6HPk2pTVfxrjHXf4yLojpfw&amp";
        $localData = json_decode(file_get_contents($url));
        $v['localData'] = $localData;
        var_dump($v);
    }

?>