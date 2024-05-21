<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="cpdGeneraterM"; // ul menu active

switch($page):
    // case ("cpdGenerater"):
    //     $subMenu='cpdGenerater';
    //     $content = include "cpdGenerater.php";
    //     break;
    // case ("edit"):
    //     $subMenu='cpdGenerater';
    //     $content = include "cpdGeneraterEdit.php";
    //     break;
    case ("addCpdGenerater"):
        $subMenu='addCpdGenerater';
        $content = include "cpdGeneraterNew.php";
        break;
    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc('CPD Generater Management') .'</h3>';
echo $content;

include("../footer.php");

?>