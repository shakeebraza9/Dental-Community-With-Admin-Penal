<?php



require_once("../global.php");



@$page = $_GET['page'];



global $menu;



global $subMenu;



$menu="paper"; // ul menu active



switch($page):



    case ("paper"):



        $subMenu='paper';



        $content = include "paper.php";



        $mainHead = '<h3 class="main_heading">'. _uc($_e['Papers']) .'</h3>';



        break;



    case ("edit"):



        $subMenu='paper';



        $content = include "paperEdit.php";



        $mainHead = '<h3 class="main_heading">'. _uc($_e['Papers']) .'</h3>';



        break;



    case ("assign"):



        $subMenu='assign';



        $content = include "assignPaper.php";



        $mainHead = '<h3 class="main_heading">'. _uc($_e['Assign Papers']) .'</h3>';



        break;

    case ("printResult"):

        $subMenu='assign';
        $content = include "printResult.php";

        break;



   case ("addCpdGenerater"):
        $subMenu='addCpdGenerater';
        $content = include "cpdGeneraterNew.php";
        break;

    default:



        $content = "Page Not Found.";



        $mainHead = '404 NOT FOUND!';



        break;



    endswitch;



include("../header.php");



echo @$mainHead;



echo $content;







include("../footer.php");







?>