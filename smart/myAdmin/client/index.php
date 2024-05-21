<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
//$menu="clientM"; // ul menu active
$menu="pages"; // ul menu active
switch($page):
    case ("client"):
        $subMenu='client';
        $content = include "client.php";
        break;
    case ("edit"):
        $subMenu='client';
        $content = include "clientEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc('Courses Management') .'</h3>';
echo $content;

include("../footer.php");

?>