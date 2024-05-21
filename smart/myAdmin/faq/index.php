<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="faqM"; // ul menu active

switch($page):
    case ("faq"):
        $subMenu='faq';
        $content = include "faq.php";
        break;
    case ("edit"):
        $subMenu='faq';
        $content = include "faqEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">FAQ</h3>';
echo $content;

include("../footer.php");

?>