<?php

include_once('global.php');
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

// $dbF->prnt($_REQUEST);
if(isset($_SESSION['_uid']) && $_SESSION['_uid']>0){



}else{

    $mailId = $_GET['mailId'];
    $invoiceId = $_GET['invoiceId'];

    if(isset($_GET['orderId'])){

        $sId = $_GET['orderId'];

        $sId = $functions->decode($sId);

        if($id == $sId) {

            $id = $sId;

            echo "<script>alert('".$dbF->hardWords("Print This Invoice or Save this Link",false)."');</script>";

        }else{

            exit;

        }

    }else{

        exit;

    }

}



$msg = include_once('invoicemail.php');

echo $msg;