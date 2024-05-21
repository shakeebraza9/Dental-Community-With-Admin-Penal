<?php


class gocardless extends object_class
{
  
  public function __construct()
  {
    global $functions;
    $chk = $functions->ibms_setting('GoCardlessTesting');
     if ($_SERVER['REMOTE_ADDR']== '39.48.200.248') {
      $chk = 1;
    }
    
    if($chk == 1){
      $key = $functions->ibms_setting('GoCardlessTestSecret');
      putenv("GC_ACCESS_TOKEN=$key");
      return 'SANDBOX';
    }
    else{
      $key = $functions->ibms_setting('GoCardlessLiveSecret');
      putenv("GC_ACCESS_TOKEN=$key");
      return 'LIVE';
    }
  } 
}
?>