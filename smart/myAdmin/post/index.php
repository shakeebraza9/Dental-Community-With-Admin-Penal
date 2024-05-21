<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="postM"; // ul menu active

switch($page):
    case ("post"):
        $subMenu='post';
        $content = include "post.php";
        break;
    case ("edit"):
        $subMenu='post';
        $content = include "postEdit.php";
        break;
    case ("addpost"):
        $subMenu='addpost';
        $content = include "postNew.php";
        break;
    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Post Management']) .'</h3>';
echo $content;

include("../footer.php");

?>