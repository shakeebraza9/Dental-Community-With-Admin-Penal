<?php 
include_once("global.php");
$login       =  $webClass->userLoginCheck();
if(!$login){
echo "<script>location.reload();</script>";
exit();
}
$show = false;
$id = intval($_GET['id']);

$sql = "SELECT cs FROM `clientAddTbl` WHERE `id`='$id'";
$data = $dbF->getRow($sql);
?>
<div class="event_details" id="myform">
<h3>Change Status</h3>
<div class="form_side">
<form method="post" id="myForm" action="crm">
<?php echo $functions->setFormToken('changeStatus',false); ?>
<input type='hidden' name='refId' value='<?php echo $id ?>'>
<div class="form-group">
<label>Select Status :</label>
<select name="cs">
<option selected="" value="<?php echo @$data['cs'] ?>"><?php echo @$data['cs'] ?></option>
<option value="On Sales">On Sales</option>
<option value="On Demo">On Demo</option>
<option value="Not Started">Not Started</option>
<option value="Live Onboard">Live Onboard</option>
<option value="Pending Work">Pending Work</option>
<option value="Deferred">Deferred</option>
<option value="Canceled">Canceled</option>

<option value="Book onboarding call">Book onboarding call</option>
<option value="Monthly touch base required">Monthly touch base required</option>
<option value="Pending task">Pending task</option>
<option value="Cqc inspection due">Cqc inspection due</option>
<option value="Team traning required">Team traning required</option>
<option value="Special request submitted">Special request submitted</option>
<option value="Hot lead">Hot lead</option>
<option value="Contact in 1 month">Contact in 1 month</option>
<option value="Contact in 2 months">Contact in 2 months</option>
<option value="Contact in 3 months">Contact in 3 months</option>
<option value="Contact in 4 months">Contact in 4 months</option>
<option value="Contact in 6 months">Contact in 6 months</option>
<option value="Not interested">Not interested</option>

</select>

</div>
<?php
echo '<input type="submit" class="submit_class" value="Save" name="submit">';

?>
</form>
</div><!-- form_side close -->
</div><!-- event_details -->
<script>

     // wait for the DOM to be loaded
     $(function() {
       // bind 'myForm' and provide a simple callback function
       $('#myForm').ajaxForm(function() {
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



$(".div<?php echo $id ?>").load("crm.php .div<?php echo $id ?>", function() {


});



        },1000); 






       });
     });
</script>