<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
if($page == "emailTXT"){
    $menu="bookingFormM"; // ul menu active
}else if($page == "boardingForm"){
    $menu="bookingFormM"; // ul menu active
}
else{
    $menu="emailM"; // ul menu active
}


switch($page):
    case ("email"):
        $subMenu='email';
        $content = include "email.php";
        break;

    case ("newsLetter"):
        $subMenu='newsLetter';
        $content = include "newsLetter.php";
        break;

    case ("emailContent"):
        $subMenu='emailContent';
        $content = include "emailContent.php";
    break;


   case ("emailTXT"):
        $subMenu='emailTXT';
        $content = include "emailTXT.php";
    break;
    
    case ("boardingForm"):
        $subMenu='boardingFrom';
        $content = include "boardingForm.php";
    break;



    
    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Email Management']) .'</h3>';
echo $content;

include("../footer.php");

?>