<?php



require_once("../global.php");



@$page = $_GET['page'];

//echo $page; 

global $menu;

global $subMenu;

$menu="orderManagements"; // ul menu active



switch($page):

    case ("newOrder"):

        $subMenu='newOrder';

        $content = include "newOrder.php";

        break;


 case ("invoicelist"):

        $subMenu='invoicelist';

        $content = include "invoicelist.php";

        break;
 case ("reports"):
        $subMenu='reports';
        $content = include "reports.php";
        break;
    case ("edit"):

        $subMenu='newOrder';

        $content = include "invoice.php";

        break;
          case ("Downloadall"):

        $subMenu='newOrder';

        $content = include "Downloadall.php";
        break;


           case ("DownloadallwithDate"):

        $subMenu='newOrder';

        $content = include "DownloadallwithDate.php";
        break;


        
     case ("calendar"):

        $subMenu='calendar';

        $content = include "schedule_calendar.php";

        break;

    case ("technicalForm"):

        $subMenu='technicalForm';

        $content = include "techincal_form.php";

        break;



    default:

        $content = "Page Not Found.";

        break;

    endswitch;

 
if($page == 'Downloadall' || $page == 'DownloadallwithDate'){}else{
include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Order / Invoice Management']) .'</h3>';
}

echo $content;


if($page == 'Downloadall' || $page == 'DownloadallwithDate'){}else{
include("../footer.php");
}

?>