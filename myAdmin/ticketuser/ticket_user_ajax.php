<?php

if (isset($_GET['page'])) {
    require_once(__DIR__ . "/classes/ticket_user_ajax.class.php");
    $page = $_GET['page'];

    $ajax = new ticket_ajax();
    switch ($page) {
        case 'deleteUser':
            $ajax->UserDelete();
            break;
    }
}