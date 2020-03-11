<?
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
require_once dirname(__FILE__).'/Params.php';
$P = new Params("../../landtravel.ini");
$loadfine="fail";
if ((isset($_FILES['uploadedFile']))  &&  $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
   
	$fileTmpPath1 = $_FILES['uploadedFile']['tmp_name'];
	$fileName1 = "ua-".$_SESSION['userid'].".png";
      
    $fileNameCmps1 = explode(".", $fileName1);
    $fileExtension1 = strtolower(end($fileNameCmps1));
	
	$allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
    if ((in_array($fileExtension1, $allowedfileExtensions))) {

        $uploadFileDir= $P->API_PATH.'uploads/';
        $dest_path1 = $uploadFileDir.$fileName1;


        if ((copy($fileTmpPath1,$dest_path1))) {
            $message ='Files are successfully uploaded.';
	    	$loadfine="well";
            //echo 'pase';
	    } else {
            $message = 'There was an error uploading files. Please make sure the upload directory is writable.';
            echo 'no pase';
        }
    }else {
       $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
    }
} else {
    $message = 'There is an error in the file upload. Please check the following error';
	//$img_avatar=$_POST['image1'];
    
}

//---------------------actualizo el perfil despues de subir la imagen---------------------------------------//

if ($loadfine=="well") {


	$img_avatar=$fileName1;
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

}