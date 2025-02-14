<?php $functions->adminFooter(); ?>
<!-- scripts -->


<!--- Jquery 2 not support IE 6,7,8
   <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
-->
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/js/jquery.cookie.js"></script>

<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/js/angular.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/js/angularApp.js"></script>

<!-- js tree -->
<link rel="stylesheet" href="<?php echo WEB_ADMIN_URL; ?>/assets/jstree/themes/default/style.min.css" />
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/jstree/jstree.js"></script>

<!--  Color Picker -->
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/colorpicker/js/colorpicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo WEB_ADMIN_URL; ?>/assets/colorpicker/css/colorpicker.css">

<!-- Ajax file upload-->
<!-- Our CSS stylesheet file -->
<link rel="stylesheet" href="<?php echo WEB_ADMIN_URL; ?>/ajaxFileUpload/css/styles.css" />
<!-- Including the HTML5 Uploader plugin -->
<script src="<?php echo WEB_ADMIN_URL; ?>/ajaxFileUpload/js/jquery.filedrop.js"></script>
<!-- The main script file -->
<script src="<?php echo WEB_ADMIN_URL; ?>/ajaxFileUpload/js/script.js?ver=<?php echo filemtime(__DIR__ . '/ajaxFileUpload/js/script.js'); ?>"></script>

<!-- switch on off -->
<!-- <link rel="stylesheet" type="text/css" href="assets/bs-switch/bootstrap-switch.css" />
<script type="text/javascript" src="assets/bs-switch/bootstrap-switch.js"></script>
-->
<link rel="stylesheet" type="text/css" href="<?php echo WEB_ADMIN_URL; ?>/assets/bs-switch/bootstrap-switch.3.0.css" />
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/bs-switch/bootstrap-switch.3.0.js"></script>

<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/editor/ckeditor.js"></script>

<!-- datatable css-->

<link rel="stylesheet" type="text/css" href="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/css/dataTables.bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/css/buttons.bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/css/select.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/css/fixedHeader.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/css/colReorder.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/css/responsive.dataTables.min.css" />

<!-- datatable css END-->

<!-- datatable js-->

<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/js/buttons.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/js/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/js/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/js/buttons.print.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/datatable/js/dataTables.responsive.min.js"></script>

<!-- datatable js END-->

<!--Bootstrap Dual Select Box-->
<script src="<?php echo WEB_ADMIN_URL; ?>/assets/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo WEB_ADMIN_URL; ?>/assets/bootstrap-duallistbox/src/bootstrap-duallistbox.css">

<!-- Jquery UI-->
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/jquery-ui/js/jquery-ui.1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/bootstrap/js/bootstrap.js"></script>



<!-- Latest compiled and minified CSS -->
<!-- <link rel="stylesheet" href="<?php echo WEB_ADMIN_URL; ?>/css/bootstrap-select.min.css"> -->

<!-- Latest compiled and minified JavaScript -->
<!-- <script src="<?php echo WEB_ADMIN_URL; ?>/js/bootstrap-select.min.js"></script> -->

<!--multiselect js-->
<!-- <script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/assets/bootstrap-multiselect-master/dist/js/bootstrap-multiselect.js"></script> -->




<!-- Alertify JS-->
<script src="<?php echo WEB_ADMIN_URL; ?>/assets/alertify/lib/alertify.min.js"></script>
<script>
    $(document).ready(function(){
        
        
        
        
        
        
        
        
        //  $('.mySelect').multiselect(
        //   {
        //     includeSelectAllOption: true,
        //     enableHTML      : true,
        //     filterPlaceholder: 'Search for something...',
        //     enableFiltering: true,
        //     enableCaseInsensitiveFiltering: true
        //   }
        // );
        
        
        
        
        
        $('.make-switch').on('switch-change', function (e, data) {
        if(data.value){
            $(this).find(".checkboxHidden").val('1');
        }else{
            $(this).find(".checkboxHidden").val('0');
        }
    });
    /* jAlert */
    $( "#jAlert" ).dialog({
        modal: true,
        autoOpen:false,
        buttons: {
            "Close": function() {
                $( this ).dialog( "close" );
            }
        }
    });
    $('.ui-dialog-buttonset').find('button').addClass('btn-danger').addClass('btn');
    /* jAlert End */
    });
</script>
<div id="jAlert" style="display: none;"></div> <!-- use for jAlert custome alert show -->

<div class="notifications ">
   <!-- <div  id="uniqueId" class="notification ">
        <div class="notification_close btn btn-default">x</div>
        <div class="notification_heading navbar-inverse">
            Alert Will show here, Product
        </div>
        <div class="notification_text btn-success">   Message</div>
    </div>-->



</div>
</body>
</html>