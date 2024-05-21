<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="training"; // ul menu active

switch($page):
    case ("training"):
        $subMenu='training';
        $content = include "training.php";
        break;
    case ("edit"):
        $subMenu='training';
        $content = include "trainingEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Training/Document Management']) .'</h3>';
echo $content;

include("../footer.php");

?>