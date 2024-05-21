<?php



require_once("../global.php");



@$page = $_GET['page'];



global $menu;

global $subMenu;

$menu="domain"; // ul menu active



switch($page):

    case ("domain"):

        $subMenu='domain';

        $content = include "domain.php";

        break;

    case ("edit"):

        $subMenu='domain';

        $content = include "domainEdit.php";

        break;

    default:

        $content = "Page Not Found.";

        break;

    endswitch;





include("../header.php");

echo '<h3 class="main_heading">'. _uc($_e['Courses']) .'</h3>';

echo $content;



include("../footer.php");



?>