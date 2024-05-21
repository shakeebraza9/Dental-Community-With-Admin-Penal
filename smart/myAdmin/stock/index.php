<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="stock";

switch($page):
    case ("addStore"):
        $subMenu='add store';
        $content = include "addstore.php";
        break;

    case ("purchaseReceipt"):
        $subMenu='purchase receipt';
        $content = include "purchaseReceipt.php";
        break;

    case ("inventory"):
        $subMenu='inventory';
        $content = include "inventory.php";
        break;

    case ("quickAdd"):
        $subMenu='inventory';
        $content = include "qucik_stock_byproduct.php";
        break;

    case ("csv"):
        $subMenu='Import/Export';
        $content = include "csv.php";
        break;
case ("grnEdit"):
        $subMenu='purchase receipt';
        $content = include "grnEdit.php";
        break;
        case ("grnEdit2"):
        $subMenu='purchase receipt';
        $content = include "grnEdit2.php";
        break;

    case ("gtnEdit"):
        $subMenu='goods transfer note';
        $content = include "gtnEdit.php";
        break;
 case ("goodstransfernote"):
        $subMenu='goods transfer note';
        $content = include "goodstransfernote.php";
        break;    

    case ("dnEdit"):
        $subMenu='delivery note';
        $content = include "dnEdit.php";
        break;

    case ("ianEdit"):
        $subMenu='inventory adjustment note';
        $content = include "ianEdit.php";
        break;
case ("inventoryadjustmentnote"):
        $subMenu='inventory adjustment note';
        $content = include "inventoryadjustmentnote.php";
        break;

    case ("inventoryvaluation"):
        $subMenu='inventory valuation';
        $content = include "inventoryvaluation.php";
        break;

    case ("inventoryinout"):
        $subMenu='inventory in out';
        $content = include "inventoryinout.php";
        break;
    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");

echo '<h3 class="main_heading">'. _uc($_e['Stock Management']) .'</h3>';
echo $content;

include("../footer.php");

?>