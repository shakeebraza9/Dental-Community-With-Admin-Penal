<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="donateM"; // ul menu active

switch($page):
    case ("donate"):
        $subMenu='donate';
        $content = include "donate.php";
        break;
    case ("edit"):
        $subMenu='donate';
        $content = include "donateEdit.php";
        break;
    case ("addNews"):
        $subMenu='addNews';
        $content = include "donateNew.php";
        break;
    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['News Management']) .'</h3>';
echo $content;

include("../footer.php");

?>