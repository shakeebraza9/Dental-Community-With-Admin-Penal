<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
//$menu="brandsM"; // ul menu active
$menu="pages"; // ul menu active
switch($page):
    case ("newslider"):
        $subMenu='newslider';
        $content = include "newslider.php";
        break;
    case ("edit"):
        $subMenu='newslider';
        $content = include "newsliderEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Slider Management']) .'</h3>';
echo $content;

include("../footer.php");

?>