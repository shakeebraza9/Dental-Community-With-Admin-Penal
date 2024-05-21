<?php



require_once("../global.php");



@$page = $_GET['page'];



global $menu;

global $subMenu;

$menu="domain"; // ul menu active



switch($page):

    case ("question"):

        $subMenu='questions';

        $content = include "question.php";

        break;

    case ("edit"):

        $subMenu='questions';

        $content = include "questionEdit.php";

        break;

    default:

        $content = "Page Not Found.";

        break;

    endswitch;





include("../header.php");

echo '<h3 class="main_heading">'. _uc($_e['Questions']) .'</h3>';

echo $content;



include("../footer.php");



?>