<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="reviewsM"; // ul menu active

switch($page):
    case ("review"):
        $subMenu='reviews';
        $content = include "review.php";
        break;
        
    case ("edit"):
        $subMenu='reviews';
        $content = include "reviewEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;

endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Reviews Management']) .'</h3>';
echo $content;

include("../footer.php");

?>