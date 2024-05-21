<?php
ob_start();
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require_once("classes/issues.class.php");
global $dbF;

$issues  =   new issues();

// $dbF->prnt($_POST);
// $dbF->prnt($_FILES);
// exit;
// $issues->issuesEditSubmit();
// $issues->newIssuesAdd();

?>
<!-- <h2 class="sub_heading"><?php echo _uc($_e['Manage Issues']); ?></h2> -->

    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab">All Issues </a></li>
      

    </ul>


    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active container-fluid" id="home">
            <h2  class="tab_heading"><?php echo _uc($_e['Active Issues']); ?></h2>
            <?php $issues->issuesView();  ?>
        </div>

    

    </div>



<?php return ob_get_clean(); ?>