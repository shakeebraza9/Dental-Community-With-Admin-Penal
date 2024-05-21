<?php
/**
 * For add new page, just copy past all files,
 * and replace words with new page name.
 * if new fields required use setting_fields table for additional fields,
 */

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="pages"; // ul menu active

switch($page):
    case ("testimonial"):
        $subMenu='testimonial';
        $content = include "testimonial.php";
        break;
    case ("edit"):
        $subMenu='testimonial';
        $content = include "testimonialEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Testimonial Management']) .'</h3>';
echo $content;

include("../footer.php");

?>