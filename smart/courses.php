<?php

include_once("global.php");
include_once('header.php'); 

global $dbF,$webClass,$assign_paperr,$paper_iid;

$login       =  $webClass->userLoginCheck();
if(!$login){
    //if user not login then go to login page
    header("Location: login.php");
}

$pap_id=$_GET['paper_id'];
echo $pap_id;
die();
?>