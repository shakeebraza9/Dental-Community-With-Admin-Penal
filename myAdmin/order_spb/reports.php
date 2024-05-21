<?php
ob_start();

require_once("classes/reports.class.php");
global $dbF;

$reports  =   new reports();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
// $reports->reportsEditSubmit();
// $reports->newreportsAdd();
?>
 

    <!-- Nav tabs -->
  


    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active container-fluid" id="home">
             
            <?php $reports->reportsSUP();  ?>
        </div>

       
    </div>
<!-- 
<script>
    $(function(){
        tableHoverClasses();
        dateJqueryUi();
    });

 
 

</script> -->

<!-- 
<style type="text/css">
    
    table { table-layout: fixed; width: 100%; }
table tr { border-bottom:1px solid #e9e9e9; }
table thead td, th {border-left: 1px solid #f2f2f2; border-right: 1px solid #d5d5d5; background: #ddd url("../images/sprites4.png") repeat-x scroll 0 100% ; font-weight: bold; text-align:left;}
table tr td, th { border:1px solid #D5D5D5; padding:15px;}
table tr:hover { background:#fcfcfc;}
table tr ul.actions {margin: 0;}
table tr ul.actions li {display: inline; margin-right: 5px;}

td.last {
    width: 1px;
    white-space: nowrap;
}
td.fitwidth {
    width: 1px;
    white-space: nowrap;
}td {
 white-space: nowrap;
}
</style> -->



<!-- <style type="text/css">
    table { table-layout: fixed; width: 100%; }
    table {
  border: 1px solid black;
  table-layout: fixed;
  width: 200px;
}

th,
td {
 width:200px; 
  height:50px;
  max-width:200px;
  min-width:200px; 
  max-height:50px; 
  min-height:50px;
}
</style> -->
<?php return ob_get_clean(); ?>