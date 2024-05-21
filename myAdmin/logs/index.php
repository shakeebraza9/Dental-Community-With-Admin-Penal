<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="logs"; // ul menu active

switch($page):
    case ("defectReg"):
        $subMenu='defectReg';
        $content = include "defectReg.php";
        break;
    case ("defectArchive"):
        $subMenu='defectArchive';
        $content = include "defectArchive.php";
        break;

    case ("returnReg"):
        $subMenu='returnReg';
        $content = include "returnReg.php";
        break;
    case ("productReturn"):
        $subMenu='productReturn';
        $content = include "productReturn.php";
        break;
    case ("productDefect"):
        $subMenu='productDefect';
        $content = include "productDefect.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Logs Management']) .'</h3>';
echo $content;

include("../footer.php");

?>