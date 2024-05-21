<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="newsM"; // ul menu active

switch($page):
    case ("news"):
        $subMenu='news';
        $content = include "news.php";
        break;
    case ("edit"):
        $subMenu='news';
        $content = include "newsEdit.php";
        break;
    case ("addNews"):
        $subMenu='addNews';
        $content = include "newsNew.php";
        break;
    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['News Management']) .'</h3>';
echo $content;

include("../footer.php");

?>