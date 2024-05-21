<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu = "ticketM"; // ul menu active

switch ($page):
    case ("ticket_user"):
        $subMenu = 'ticket_user';
        $content = include "ticket_user.php";
        break;
    case ("edit"):
        $subMenu = 'ticket_user';
        $content = include "ticket_user_edit.php";
        break;
    default:
        $content = _uc($_e['Page Not Found.']);
        break;
endswitch;


include("../header.php");
echo '<h3 class="main_heading">' . _uc($_e['Ticket User Management']) . '</h3>';
echo $content;

include("../footer.php");