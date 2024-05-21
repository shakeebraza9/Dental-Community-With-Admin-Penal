<?php 
include_once("global.php");

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}

@$id = intval($_GET['id']);
$sql = "SELECT * FROM `lieu` WHERE `id`=?";
$data = $dbF->getRow($sql,array($id));
if (empty($data)) {
   $token = $functions->setFormToken('lieuInsert',false);
}
else{
  $token = $functions->setFormToken('lieuUpdate',false);;
}
?>
<div class="event_details" id="myform">
    <h3>Overtime Request Form</h3>
    <div class="form_side">
        <form method="post" id="myformAjax" action="hrm" enctype="multipart/form-data">
            <?php echo $token; ?>
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Overtime Request Type :</label>
                    <select name="type" class="type">
                        <option value="Paid">Paid</option>
                        <option value="Non Paid">Non Paid</option>
                        <option value="Late/Leave/Less">Adjust with Late/Leave/Less hour work</option>
                    </select>
                </div>
                <!-- form-group -->
                <script>
                    $('.type').val('<?php echo $data['type'] ?>').change();
                </script>
                <div class="form-group col-md-6">
                    <label>Overtime Request Hours :</label>
                    <input type="number" name="hours" class="hours" step="0.25">
                </div>
                <!-- form-group -->
                <script>
                    $('.hours').val('<?php echo $data['hours'] ?>').change();
                </script>
                <?php if($_SESSION['currentUserType'] != 'Employee'){ ?>
                <div class="form-group col-md-6">
                    <label>Overtime Status :</label>
                    <select name="status" class="status" required>
                        <option value="Accepted">Accepted</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>
                <!-- form-group -->
                <script>
                    $('.status').val('<?php echo $data['status'] ?>').change();
                </script>
                <?php } ?>



                  <div class="form-group col-md-6">
                    <label>Note :</label>
                    <input type="text" name="txtNote" class="txtNote">
                </div>
                <!-- form-group -->
                <script>
                    $('.txtNote').val('<?php echo $data['txtNote'] ?>').change();
                </script>





                <div class="form-group col-12">
                    <?php
                    if(empty($data)){
                        echo '<input type="submit" class="submit_class" value="Submit Information" name="submit">';
                    }
                    else{
                        echo '<input type="submit" class="submit_class" value="Submit Information" name="edit">';
                    }
                    ?>
                </div>
                <!-- form-group -->
            </div>
        </form>
    </div>
    <!-- form_side close -->
</div>
<!-- event_details --><script>

     // wait for the DOM to be loaded
$(function() {
// bind 'myformAjax' and provide a simple callback function
$('#myformAjax').ajaxForm(function() {
$(".fixed_side").removeClass("fixed_side_");
$(".col5").removeClass("col5_");
$(".myevents-div").removeClass("myevents-div_");
$(".myevents-div").removeClass("redborder");
$(".myevents-div").removeClass("blueborder");
$(".myevents-div").removeClass("greenborder");
$("[title='chat widget']").parent('div').attr("style", "display: block !important;position: fixed !important");
setTimeout(function(){
$(".myevents-form").empty();
$('.myevents-div #loader').show();
$(".right_side").load("lieu.php .right_side");
},1000); 
});
});
</script>