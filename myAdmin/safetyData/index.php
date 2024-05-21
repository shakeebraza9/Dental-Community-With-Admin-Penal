<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="pages"; // ul menu active

switch($page):
    case ("safetyData"):
        $subMenu='safetyData';
        $content = include "safetyData.php";
        break;
    case ("edit"):
        $subMenu='safetyData';
        $content = include "safetyDataEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc('Safety Data Management') .'</h3>';
echo $content;

include("../footer.php");

?>