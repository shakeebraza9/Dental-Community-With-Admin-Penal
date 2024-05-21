<?php

require_once("../global.php");
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="termsM"; // ul menu active

switch($page):
    case ("terms"):
        $subMenu='terms';
        $content = include "terms.php";
        break;
    case ("edit"):
        $subMenu='terms';
        $content = include "termsEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Terms Management']) .'</h3>';
echo $content;

include("../footer.php");

?>