<?php 
include_once("global.php");

$login = $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}

@$id = intval($_GET['id']);
$sql = "SELECT * FROM `leaves` WHERE `id`=?";
$data = $dbF->getRow($sql,array($id));
 $fill_user = @$data['fill_user'];
$username = $functions->UserName($fill_user);
$option =  $functions->leavetype();
 ?>
<div class="event_details" id="myform">
<?php if(empty($_GET['id'])){  ?>
    <h3>Holiday Request Form <?php echo '('.$username.')' ?></h3>
<?php }
        else { ?>
    <h3>Holiday Request Form</h3>
<?php } ?>
    <div class="form_side">
        <form method="post"  action="leaves" enctype="multipart/form-data">
            <?php echo $functions->setFormToken('employeeleaveInsert',false); ?>
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
            <div class="row">
           <div class="form-group col-md-6">
                    <label>Select Employee</label>
                    <select name="fill_user">
                        <?php


if ($_SESSION['superUser']['hrrota'] == 'full') {


                         echo $functions->allEmployees($_SESSION['currentUser'],$data['fill_user']);

                         }




                        echo $functions->allEmployees($_SESSION['allUsers'],$_SESSION['currentUser']); ?>
                         
                    </select>
                        
                </div>
         <div class="form-group col-md-6" style="display:none;">
                <label>Title :</label>
                <input type="text" placeholder="Ttitle Name" name="title" value="" >
            </div>
            <!-- form-group -->
            <div class="form-group col-md-6">
                <label>Leave Type :</label>
                <select name="type"  class="type" required>
                <option  selected  disabled  >Select Leave Type</option>
                   <?php echo $option ?>
                </select>
            </div>
            <!-- form-group -->
            <script>
                $('.type').val('<?php echo @$data['type'] ?>').change();
            </script>
            <div class="form-group col-md-6">
                <label>Date From :</label>
                <input class="datepicker form-control" id="from" type="date" value="<?php if(!empty($data['from_date'])) echo date('d-M-Y',strtotime($data['from_date'])) ?>" placeholder="Date From" name="datef" required>
            </div>
            <!-- form-group -->
            <div class="form-group col-md-6">
                <label>Date To :</label>
                <input class="datepicker form-control" id="tto" type="date" value="<?php if(!empty($data['to_date'])) echo date('d-M-Y',strtotime($data['to_date'])) ?>" placeholder="Date to" name="datet" required>
            </div>
            <!-- form-group -->
             <div class="form-group col-md-6">
                <label>Leave Hours :</label>
                <input type="number"  step="0.25" value="<?php echo $data['hours'] ?>" placeholder="Leave Hours" name="hours" required autocomplete="off" class="" min="0">
            </div>
            <!-- form-group -->
            <?php if($_SESSION['currentUserType'] != 'Employee' ||  $_SESSION['superUser']['hrrota'] == 'full'){ ?>
             <div class="form-group col-md-6">
                <label>Pay :</label>
                <select name="pay" class="pay" required>
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">UnPaid</option>
                </select>
            </div>
            <!-- form-group -->
            <script>
                $('.pay').val('<?php echo $data['pay'] ?>').change();
            </script>
            <?php } ?>
            <?php if($_SESSION['currentUserType'] != 'Employee' ||  $_SESSION['superUser']['hrrota'] == 'full'){ ?>
            <div class="form-group col-md-6">
                <label>Leave Status :</label>
                <select name="status" class="status" required>
                    <option value="Accepted">Accepted</option>
                    <option value="Rejected">Rejected</option>
                    <option value="Pending">Pending</option>
                </select>
            <script>
                $('.status').val('<?php echo $data['status'] ?>').change();
            </script>
            </div>
             <!--<div class="form-group col-md-6">-->
             <!--       <label>Employee For</label>-->
             <!--       <select name="fill_user">-->
             <!--           <?php // $functions->allEmployees($_SESSION['currentUser'],$data['fill_user']) ?>-->
             <!--       <?php // $functions->allEmployees($_SESSION['allUsers'],$_SESSION['currentUser']) ?>-->
                         
             <!--       </select>-->
                        
             <!--   </div>-->
              <div class="form-group col-md-6">
                        <label>Comment</label>
                        <textarea name="comment"></textarea>
                    </div>
            <!-- form-group -->
            <?php } ?>
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
// $(".datepicker").datepicker({ 
//     dateFormat: 'd-M-yy',
//       changeMonth: true,
//       changeYear: true 
//  });
// $(function() {
//     $( "#from, #tto" ).datepicker({
//          dateFormat: 'd-M-yy',
//         defaultDate: "+1w",
//           changeMonth: true,
//           changeYear: true,
//        // yearRange: "-100:+0",
//        showButtonPanel:true,
//       // minDate: 0,
      
//         onSelect: function( selectedDate ) {
//             if(this.id == 'from'){
//               // var dateMin = $('#from').datepicker("getDate");
//               var dateMin = $('#from').datepicker("getDate");
//               var rMin = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() + 0); // Min Date = Selected + 1d
//               var rMax = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() + 31); // Max Date = Selected + 31d
//               $('#tto').datepicker("option","minDate",rMin);
//               $('#tto').datepicker("option","maxDate",rMax);                    
//             }

//         }
//     });
// });
</script>