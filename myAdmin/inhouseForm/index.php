<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;

$menu="bookingFormM"; // ul menu active

switch($page):

    case ("formData"):
        $subMenu='inhouseFormM';
        $content = include "inhouseFormView.php";
    break;


    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Inhouse Form Data']) .'</h3>';
echo $content;

include("../footer.php");

?>