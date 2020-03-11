<?php
require_once dirname(__FILE__).'/Params.php';
    $P=new Params("../../landtravel.ini");
if (isset($_SERVER['HTTP_ORIGIN'])) {  
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");  
    header('Access-Control-Allow-Credentials: true');  
    header('Access-Control-Max-Age: 86400');   
}  
  
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {  
  
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))  
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");  
  
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))  
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");  
} 
//--------------------------------------------------------//
session_start();


$email=$_POST['email'];
$fbid=$_POST['fbid'];
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$password='testapi';
//// 07/05/2019 new code boris///// ⇊
    $picture = $_POST['picture'];
    $backgroundimg = $_POST['backgroundimg'];
    
//// 07/05/2019 new code boris///// ⇈

/* codigo sustituido 07/05/2019
    $ruta='http://graph.facebook.com/'.$fbid.'/picture?width=250&height=250 ';
    $imagen = file_get_contents($ruta);
    $uploadFileDir='/home/landtours/staging.landtours.co/uploads/';

    file_put_contents($uploadFileDir.$fbid.'/imagen_copiada.jpg',$imagen);
    file_put_contents($uploadFileDir.$fbid.'.jpg',$imagen);


    $data = array("email"=>$email,"firstname"=>$firstname,"lastname"=>$lastname,"active" =>"1","fbid" =>$fbid,"img_avatar"=>$fbid.'.jpg');         
*/
//// 07/05/2019 new code boris///// ⇊
 $data = array("email"=>$email,"firstname"=>$firstname,"lastname"=>$lastname,"active" =>"1","fbid" =>$fbid,"img_avatar"=>$picture,"img_background"=>$backgroundimg);
//// 07/05/2019 new code boris///// ⇈

$data_string = json_encode($data);  

$ch = curl_init($P->API_URL.'register/');                                                                      
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

curl_close($ch);





//-----------------------busco usuario con correo y password vacio por facebook ---------------------------------------//
$data = array("uid" => $fbid, "searchtype" =>"fb");         
                                                         
$data_string = json_encode($data);                                                                                   
                                                                                                                     
$ch = curl_init($P->API_URL.'user/');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
    'Apikey:'.$P->API_KEY,                                                                        
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
                                                                                                                     
$resultt = curl_exec($ch);
if(curl_errno($ch) !== 0) {
    error_log('cURL error when connecting to ' . $url . ': ' . curl_error($ch));
}

curl_close($ch);

$resultado=json_decode($resultt);

$_SESSION['userid']=$resultado->results[0]->id;
$_SESSION['firstname']=$resultado->results[0]->firstname;
$_SESSION['lastname']=$resultado->results[0]->lastname;
$_SESSION['email']=$resultado->results[0]->email;
$_SESSION['country']=$resultado->results[0]->country;
$_SESSION['avatar']=$resultado->results[0]->img_avatar;
$_SESSION['img_background']=$resultado->results[0]->img_background;

if($picture != $resultado->results[0]->img_avatar)
{
    $data = array("img_avatar" =>$picture);         
                                                        
    $data_string = json_encode($data);                                                                                   
                                                                                                                         
    $ch = curl_init($P->API_URL.'register/'.$_SESSION['userid']);                                                                      
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

    curl_close($ch);

}
if($backgroundimg != $resultado->results[0]->img_background)
{
    $data = array("img_background" =>$backgroundimg);         
                                                        
    $data_string = json_encode($data);                                                                                   
                                                                                                                         
    $ch = curl_init($P->API_URL.'register/'.$_SESSION['userid']);                                                                      
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

    curl_close($ch);

}
$_SESSION['avatar']=$picture;
print_r($resultt);
?>
