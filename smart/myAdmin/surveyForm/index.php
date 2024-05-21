<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;

$menu="surveyFormM"; // ul menu active

switch($page):

    case ("surveyForm"):
        $subMenu='formM';
        $content = include "surveyFormView.php";
    break;


    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Survey Form Data']) .'</h3>';
echo $content;

include("../footer.php");

?>