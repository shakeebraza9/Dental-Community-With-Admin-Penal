<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu = "ticketM"; // ul menu active

switch ($page):
    case ("ticket"):
        $subMenu = 'ticket';
        $content = include "ticket.php";
        break;
    case ("edit"):
        $subMenu = 'ticket';
        $content = include "ticketedit.php";
        break;
    case ("response"):
        $subMenu = 'ticket';
        $content = include "ticketresponse.php";
        break;
    case ("responseview"):
        $subMenu = 'ticket';
        $content = include "ticketresponseview.php";
        break;
    default:
        $content = _uc($_e['Page Not Found.']);
        break;
endswitch;


include("../header.php");
echo '<h3 class="main_heading">' . _uc($_e['Ticket Management']) . '</h3>';
echo $content;

include("../footer.php");