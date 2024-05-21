<?php
require_once("../global.php");
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
@$page = $_GET['page'];
global $menu;
global $subMenu;
$menu="issuesM"; // ul menu active
switch($page):
    case ("issue"):
        $subMenu='issues';
        $content = include "issues.php";
        break;
    // case ("issues"):
    //     $subMenu='issues';
    //     $content = include "issuesEdit.php";
    //     break;
    // case ("issues"):
    //     $subMenu='addIssues';
    //     $content = include "issuesNew.php";
    //     break;
    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Issues Management']) .'</h3>';
echo $content;

include("../footer.php");

?>