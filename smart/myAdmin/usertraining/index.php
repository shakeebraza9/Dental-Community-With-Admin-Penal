<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="training"; // ul menu active

switch($page):
    case ("usertraining"):
        $subMenu='usertraining';
        $content = include "usertraining.php";
        break;
    case ("edit"):
        $subMenu='usertraining';
        $content = include "usertrainingEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['User Training/Document']) .'</h3>';
echo $content;

include("../footer.php");

?>