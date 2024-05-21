<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="myUploadsM"; // ul menu active

switch($page):
    case ("myUploads"):
        $subMenu='myUploads';
        $content = include "myUploads.php";
        break;
    case ("edit"):
        $subMenu='myUploads';
        $content = include "myUploadsEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['My Uploads']) .'</h3>';
echo $content;

include("../footer.php");

?>