<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="freeResourcesM"; // ul menu active

switch($page):
    case ("documents"):
        $subMenu='freeResources';
        $content = include "freeResources.php";
        break;
    case ("edit"):
        $subMenu='freeResources';
        $content = include "freeResourcesEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Free Resources']) .'</h3>';
echo $content;

include("../footer.php");

?>