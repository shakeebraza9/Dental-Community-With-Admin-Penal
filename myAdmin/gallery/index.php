<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="galleryM"; // ul menu active

switch($page):
    case ("gallery"):
        $subMenu='gallery';
        $content = include "gallery.php";
        break;
    case ("albumManage"):
        $subMenu='gallery';
        $content = include "galleryEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Gallery Management']) .'</h3>';
echo $content;

include("../footer.php");

?>