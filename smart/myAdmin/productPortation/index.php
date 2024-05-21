<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="product";

switch($page):
    case ("csv"):
        $subMenu='impExp';
        $content = include "csv.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");

echo '<h3 class="main_heading">'. _uc('Product Manangement') .'</h3>';
echo $content;

include("../footer.php");

?>