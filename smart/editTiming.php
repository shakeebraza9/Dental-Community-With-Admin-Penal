<?php 
include_once("global.php");

$login = $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}

@$id = intval($_GET['id']);
$sql = "SELECT * FROM `record` WHERE `id`=?";
$data = $dbF->getRow($sql,array($id));
 $checkin = $data['checkin'];
 $checkout = $data['checkout'];
 $date = $data['date'];
 $timeFrom = $data['timeFrom'];
 $timeTo = $data['timeTo'];
 $userId = $data['userId'];
 $breakTime = $data['breakTime'];
 $hourWorked = $data['hourWorked'];
 $hour = $data['hour'];
 


 ?>
<div class="event_details" id="myform">
 
    <h3>Edit Rota (<?php echo $webClass->UserName($userId); ?>) (<?php echo $date; ?>)</h3>
 
    <div class="form_side">
        <form method="post" action="rota-reports" id="editTiming">
            
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
            <input type="hidden" name="breakTime" value="<?php echo $breakTime ?>">
            <div class="row">
         
            <div class="form-group col-md-6">
                <label>Checkin :</label>
                 <input type="text" name="checkin" id="checkin" class="time_picker" value="<?php echo $checkin; ?>">
            </div>
            <!-- form-group -->
          
            <div class="form-group col-md-6">
                <label>Checkout :</label>
                 <input type="text" name="checkout" class="time_picker" id="checkout" value="<?php echo $checkout; ?>">
            </div>
            <!-- form-group -->
<!--   <div class="form-group col-md-6">
                <label>Hour Worked:</label>
                 <input type="text" name="hourWorked" id="hourWorked" readonly="" value="<?php echo $hourWorked; ?>">
            </div> -->
            <!-- form-group -->

  <div class="form-group col-md-6">
                <label>Comment :</label>
                 <input type="text" name="comment" class="comment" id="comment" value="<?php echo $data['comment']; ?>">
            </div>


<!-- 
   <div class="form-group col-md-6">
                <label>Break Time:</label>
                 <input type="text" name="breakTime" class="time_picker" id="breakTime" readonly="" value="<?php //echo $breakTime; ?>">
            </div> -->
            <!-- form-group -->




             <!--  <div class="form-group col-md-6">
                <label>Date :</label>
                 <input type="date" name="date" id="date" readonly="" value="<?php //echo $date; ?>">
            </div> -->
            <!-- form-group -->


 
            


            <!--   <div class="form-group col-md-6">
                <label>Time From :</label>
                 <input type="text" name="timeFrom" id="timeFrom" readonly="" value="<?php echo $timeFrom; ?>">
            </div> -->
            <!-- form-group -->


   <!--            <div class="form-group col-md-6">
                <label>Time To:</label>
                 <input type="text" name="timeTo" id="timeTo" readonly="" value="<?php echo $timeTo; ?>">
            </div> -->
            <!-- form-group -->




 

<!-- <div class="form-group col-md-6">
                <label>Hour:</label>
                 <input type="text" name="hour" id="hour" readonly="" value="<?php echo $hour; ?>">
            </div> -->
            <!-- form-group -->

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
    </div><!-- form_side close -->
</div><!-- event_details -->
<script>
 $(function() {

    $('.time_picker').timepicker({
        hourGrid: 4,
        minuteGrid: 10,
        timeFormat: 'hh:mm tt'
    });



// bind 'myForm' and provide a simple callback function
$('#editTiming').ajaxForm(function() {
// $('#loader').fadeIn(600);
// $(".updateTable").load("rota-reports.php .updateTable", function() {
  location.reload();
// $(".fixed_side").removeClass("fixed_side_"),$(".col5").removeClass("col5_"),$(".myevents-div").removeClass("myevents-div_");
// });
// $('#loader').fadeOut(600);
});
});
</script>