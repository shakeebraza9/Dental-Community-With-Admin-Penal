<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/webUsers_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new webusers_ajax();
    switch($page){
        case 'deleteWebUser':
            $ajax->deleteWebUser();
        break;
        case 'activeWebUser':
            $ajax->activeWebUser();
        break;
        case 'deleteAdminUser':
            $ajax->deleteAdminUser();
        break;
        case 'activeAdminUser':
            $ajax->activeAdminUser();
        break;
        case 'deleteAdminGrp':
            $ajax->deleteAdminGrp();
        break;
        case 'activeSponsor':
            $ajax->activeSponsor();
        break;
        case 'rotaForget':
            $ajax->rotaForget();
        break;
        case 'active_WebUsers':
            $ajax->fetch_WebUsers();
        break;
            case 'draft_WebUsers':
            $ajax->fetch_draft_WebUsers();
        break;
            case 'trial_WebUsers':
            $ajax->fetch_trial_WebUsers();
        break;
    }
}

?>