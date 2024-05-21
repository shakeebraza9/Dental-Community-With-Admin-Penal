<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="blogM"; // ul menu active

switch($page):
    case ("blog"):
        $subMenu='blog';
        $content = include "blog.php";
        break;
    case ("edit"):
        $subMenu='blog';
        $content = include "blogEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Blog Management']) .'</h3>';
echo $content;

include("../footer.php");

?>