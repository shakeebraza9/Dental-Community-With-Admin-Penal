<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="pages"; // ul menu active

switch($page):
    case ("fileManager"):
        $subMenu='fileManager';
        $content = include "fileManager.php";
        break;
    case ("edit"):
        $subMenu='fileManager';
        $content = include "fileManagerEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Files Management']) .'</h3>';
echo $content;

include("../footer.php");

?>