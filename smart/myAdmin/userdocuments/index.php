<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="documents"; // ul menu active

switch($page):
    case ("userdocuments"):
        $subMenu='userdocuments';
        $content = include "userdocuments.php";
        break;
    case ("edit"):
        $subMenu='userdocuments';
        $content = include "userdocumentsEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['User Documents']) .'</h3>';
echo $content;

include("../footer.php");

?>