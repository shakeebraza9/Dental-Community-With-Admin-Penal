<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="bookingFormM"; // ul menu active

switch($page):
    case ("bookingForm"):
        $subMenu='bookingForm';
        $content = include "bookingForm.php";
        break;
    case ("edit"):
        $subMenu='bookingForm';
        $content = include "bookingFormEdit.php";
        break;

     case ("lunchandlearnedit"):
        $subMenu='lunchandlearn';
        $content = include "lunchandlearnEdit.php";
        break; 
     case ("lunchandlearn"):
        $subMenu='lunchandlearn';
        $content = include "lunchandlearn.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Bookings']) .'</h3>';
echo $content;

include("../footer.php");

?>