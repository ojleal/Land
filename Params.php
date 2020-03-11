<?php

class Params
{ 
  /*
  public $BD_IP;
  public $BD_Usr;
  public $BD_Pwd;
  public $BD_Inst;
  public $BD_Port;
  public $MailSrc;
  public $MailPwd;
  */
  public $API_KEY;
  public $API_URL;
  public $API_PATH;
  public $API_IMG;
  public function __construct($IniFile)
  { $Ini=fopen($IniFile,"rt");
    if( $Ini===false)
      throw new _Exception("Error(Params): No pudo abrirse el descriptor de archivo",": ".GetMsgErr($php_errormsg));
    try
    { if(!rewind($Ini))
        { $StrExcptn="Error(Params): No pudo ejecutarse el rebobinado";
          throw new _Exception($StrExcptn,": ".GetMsgErr($php_errormsg));
        }
     /*
      $this->BD_IP  =$this->GetLine($Ini);
      $this->BD_Usr =$this->GetLine($Ini);
      $this->BD_Pwd =$this->GetLine($Ini);
      $this->BD_Inst=$this->GetLine($Ini);
      $this->BD_Port=$this->GetLine($Ini);
      $this->MailSrc=$this->GetLine($Ini);
      $this->MailPwd=$this->GetLine($Ini);
     */ 
      $this->API_KEY=$this->GetLine($Ini);
      $this->API_URL=$this->GetLine($Ini);
      $this->API_PATH=$this->GetLine($Ini);
      $this->API_IMG=$this->GetLine($Ini);
    }
    catch(Exception $Ex)
    { fclose($Ini);
      throw new _Exception($Ex->getMessage());
    }
    fclose($Ini);
  }
  private function GetLine($Ini)
  { if( feof($Ini))
      throw new _Exception("Error(Params)",": Mal formato en archivo Ini.");
    return trim(fgets($Ini));
  }
}
    function checkheader($url)
    {
      //echo $url."<br/>";
      //echo "Se verificaran las cabeceras <br>";
        $encabezados = @get_headers($url);
        //var_dump($encabezados);
            if (preg_match("|200|", $encabezados[0])) {
              ///echo "debe retornar veraddero<br>";
              return true;
            } elseif(preg_match("|404|", $encabezados[0])) {
              ///echo "debe retornar falso<br>";
              return false;
            }else{
              //echo "debe retornar falso<br>";
              return false;
            }
    }
    function checkimg($url,$path){
      if(substr($url,0,4) !=="http")
      {
        if (strrpos($url,".") === false )
          $ext = "nada";
        else
          $ext = substr($url,strrpos($url,"."));
       // echo "<br>esta es la imagen ".$url." y esta la extension:<b>".$ext."</b>";
        if($ext != ".jpg" && $ext != ".png" && $ext != ".gif" && $ext != ".jpeg" && $ext != ".image")
        {
          //echo "esta es una imagen con extension <b>".$ext."</b> y no sirve<br>";
          return false;
        }
        else
        {
            //echo "esta es una imagen con extension <b>".$ext."</b><br>";
            return checkheader($path.$url);
        }  
      }else{
        return checkheader($url);
      }
    } 
?>