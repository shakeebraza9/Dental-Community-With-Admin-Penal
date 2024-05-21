<?php 
include_once("global.php");

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}

@$id = intval($_GET['id']);
$sql = "SELECT * FROM `rotaStatus` WHERE `id`='?'";
$data = $dbF->getRow($sql,array($id));
$date = date('d-M-Y',strtotime($data['week']))."&nbsp;&nbsp;to&nbsp;&nbsp;".date('d-M-Y',strtotime("$data[week] +7 day"));
?>
<div class="event_details" id="myform">
    <h3>Rota Amendments</h3>
    <div class="form_side">
        <form method="post" action="hrm" enctype="multipart/form-data">
            <?php echo $functions->setFormToken('amendRota',false); ?>
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
            <div class="row">
                <div class="form-group col-12">
                    <?php echo $date ?>
                </div>
                <!-- form-group -->
                <div class="form-group col-12">
                    <label>Details :</label>
                    <textarea name="details"></textarea>
                </div>
                <!-- form-group -->
                <div class="form-group col-12">
                    <input type="submit" class="submit_class" value="Submit Information" name="submit">
                </div>
                <!-- form-group -->
            </div>
        </form>
    </div>
    <!-- form_side close -->
</div>
<!-- event_details -->