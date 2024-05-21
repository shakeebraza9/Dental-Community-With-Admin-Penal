<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="documents"; // ul menu active

switch($page):
    case ("documents"):
        $subMenu='documents';
        $content = include "documents.php";
        break;
    case ("edit"):
        $subMenu='documents';
        $content = include "documentsEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Documents']) .'</h3>';
echo $content;

include("../footer.php");

?>