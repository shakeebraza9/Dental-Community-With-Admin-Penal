<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;

$menu = "webinarM"; // ul menu active

switch($page):
    case ("webinar"):
        $subMenu='webinar';
        $content = include "webinar.php";
        break;
    case ("edit"):
        $subMenu='webinar';
        $content = include "webinarEdit.php";
        break;
    case ("addWebinar"):
        $subMenu='addWebinar';
        $content = include "webinarNew.php";
        break;
    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc( 'webinar Management' ) .'</h3>';
echo $content;
include("../footer.php");

?>