<?php 
include("global.php");
global $functions;
global $dbF;
              @$key=$_POST["secret"];
              @$token=$_POST["token"];
              @$useremail=base64_decode($_POST["userId"]);
              @$pass=base64_decode($_POST["userpass"]);
              @$password = $functions->encode($pass);
              $authenticate=0;
              if($key==md5("xbb43#@sxxv890!!&%$~a0*"))
              {
                  if($token==md5($useremail.$pass))
                  {
                      $authenticate=1;
                  }
              }
              else
              {
                  $authenticate=0;
              }
                if($authenticate==1)
                {
                    $sql = "SELECT * FROM accounts_user WHERE acc_email=? AND acc_pass=?";
                    $result=$dbF->getRow($sql,array($useremail,$password));
                    if($dbF->rowCount>0)
                    {echo "1";}else{echo "0......";}      
                }  


?>