<?php
ob_start();

require_once("classes/cpdGenerater.class.php");
global $dbF;

$cpdGenerater  =   new cpdGenerater();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$cpdGenerater->newCpdGeneraterAdd();
?>
<h2 class="sub_heading"><?php echo ($_e['Add New News/Event']); ?></h2>
        <?php $cpdGenerater->cpdGeneraterNew();  ?>

    <script>
     $('#selectCource').change(function(){
    $.ajax({
        url: "<?php echo WEB_URL ?>/ajax_call.php?page=valueOfCourceData",
        data: { "valueOfCource": $("#selectCource").val(),"valueOfDate": $("#dDate").val() },
        dataType:"html",
        type: "post",
        success: function(data){


        	if(data){
resultObj = eval(data);

console.log(resultObj);

           $('#ch').val(resultObj[1]);
           $('#aim').val(resultObj[4]);
           $('#obj').val(resultObj[5]);
           $('#lc').val(resultObj[6]);
           $('#do').val(resultObj[7]);
           $('#minutes').val(resultObj[3]);
           $('#expDate').val(resultObj[8]);
        }}
    });
});
    </script>
<?php return ob_get_clean(); ?>