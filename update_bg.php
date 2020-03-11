<?
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
require_once dirname(__FILE__).'/Params.php';
$P=new Params("../../landtravel.ini");
$loadfine="fail";

if ((isset($_FILES['img']))  &&  $_FILES['img']['error'] === UPLOAD_ERR_OK)
{
   
	$fileTmpPath1 = $_FILES['img']['tmp_name'];
	$fileName1 = "ubg-".$_SESSION['userid'].".png";
    $fileNameCmps1 = explode(".", $fileName1);
    $fileExtension1 = strtolower(end($fileNameCmps1));
	$allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
	if ((in_array($fileExtension1, $allowedfileExtensions)))
    {

   		$uploadFileDir= $P->API_PATH.'uploads/';
		$dest_path1 = $uploadFileDir.$fileName1;
		if ((copy($fileTmpPath1,$dest_path1)))   //ambos
	    {
        	$message ='Files are successfully uploaded.';
			$loadfine="well";
              //echo 'pase';
	 	}
    	else 
    	{
    		$message = 'There was an error uploading files. Please make sure the upload directory is writable.';
			echo 'no pase';
    	}
	}// fin si la extension no es valida
	else
    {
       $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
    }
}//fin si hay archivo arriba
 else {
    //$message = 'There is an error in the file upload. Please check the following error';
	$img_avatar=$_POST['image1'];
}
//---------------------actualizo el perfil despues de subir la imagen---------------------------------------//

if ($loadfine=="well")  ///go to database and save

	{
		$img_background=$fileName1;

		$id=$_SESSION['userid'];

		$url= $P->API_URL.'register/'.$id.'';

		$data = array("img_background" => $img_background);
		$data_string = json_encode($data);
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     

		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(  

		    'Apikey:'.$P->API_KEY,
		    'Content-Type: application/json',
		    'Content-Length: ' . strlen($data_string))       
		);
		$result = curl_exec($ch);
		if(curl_errno($ch) !== 0) {
		    error_log('cURL error when connecting to ' . $url . ': ' . curl_error($ch));
		}
		$_SESSION['img_background']=$img_background;
		curl_close($ch);
		echo $result;
	}