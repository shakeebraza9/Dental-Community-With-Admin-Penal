<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/stock_ajax.php");
    $page=$_GET['page'];

    $ajax=new stock_ajax();

    switch($page){
        //Color
        case 'receiptDetail':
            $ajax->receiptDetail('color');
            break;
             case 'InventoryInfo':
            $ajax->InventoryInfo();
            break;
            case 'receiptDetailGTN':
            $ajax->receiptDetailGTN();
            break;
        case 'receiptDetailDN':
            $ajax->receiptDetailDN();
            break;
        case 'receiptDetailIAN':
            $ajax->receiptDetailIAN();
            break;                    
        case 'receiptInfo':
            $ajax->receiptInfo();
            break; 
        case 'countCurrentQTY':
            $ajax->countCurrentQTY();
            break;
        case 'directQTYAdd':
            $ajax->directQTYAdd();
            break;

        case 'directQTYRemove':
            $ajax->directQTYRemove();
        break;

        case 'directStockQTYAdd':
            $ajax->directStockQTYAdd();
        break;

        case 'directStockQTYRemove':
        $ajax->directStockQTYRemove();
        break;
        
        case 'getstorename':
        $ajax->getstorename($_POST['id']);
        break;

        case 'getstorename_grn':
        $ajax->getstorename_grn($_POST['id']);
        break;

        case 'directStockLocationAdd':
        $ajax->directStockLocationAdd();
        break;
        
        case 'getdetails':
        $ajax->getdetails();
        break;
    }


}

?>