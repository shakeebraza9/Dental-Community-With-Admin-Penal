<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="rotaM"; // ul menu active

switch($page):
    case ("addshift"):
        $subMenu='shift';
        $content = include "shift.php";
        break;
    case ("edit"):
        $subMenu='shift';
        $content = include "shiftEdit.php";
        break;
    case ("rota"):
        $subMenu='rota';
        $content = include "rota.php";
        break;
    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Rota Management']) .'</h3>';
echo $content;

include("../footer.php");

?>