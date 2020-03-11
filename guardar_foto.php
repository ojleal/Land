<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
require_once dirname(__FILE__).'/Params.php';
$P = new Params("landtravel.ini");

$imagenCodificada = file_get_contents("php://input");

echo 'La imagen codificada es '. $imagenCodificada;

if(strlen($imagenCodificada) <= 0) exit("No se recibió ninguna imagen");

$imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", urldecode($imagenCodificada));


$imagenDecodificada = base64_decode($imagenCodificadaLimpia);


//$nombreImagenGuardada = "ua-".$_SESSION['userid'].".png";

$nombreImagenGuardada = "ua-222.png";


$fileNameCmps1 = explode(".", $nombreImagenGuardada);

$fileExtension1 = strtolower(end($fileNameCmps1));

//$uploadFileDir= $P->API_PATH.'uploads/';
$uploadFileDir= 'uploads/';
$dest_path1 = $uploadFileDir.$nombreImagenGuardada;

file_put_contents($dest_path1, $imagenDecodificada);

exit($nombreImagenGuardada);


	$img_avatar=$imagenDecodificada;
	$id=$_SESSION['userid'];
	$url= $P->API_URL.'register/'.$id.'';
	$data = array("img_avatar" => $img_avatar);
    $data_string = json_encode($data);  
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
    	    'Apikey:'.$P->API_KEY,                                                                        

		    'Content-Type: application/json',                                                                                

		    'Content-Length: ' . strlen($data_string)
		)
	);                                                                                                                   
	$result = curl_exec($ch);
	if(curl_errno($ch) !== 0) {
	    error_log('cURL error when connecting to ' . $url . ': ' . curl_error($ch));

	}

	$_SESSION['avatar']=$img_avatar;
	curl_close($ch);		
    echo $result;       

?>