<?php 
ini_set('display_errors', 0);
error_reporting(E_ALL);
include_once("global.php");

$login = $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}

@$id = intval($_GET['id']);
$sql = "SELECT * FROM `leaves` WHERE `id`=?";
$data = $dbF->getRow($sql,array($id));
 $fill_user = $data['fill_user'];
$username = $functions->UserName($fill_user);
$option =  $functions->leavetype();
 ?>
<div class="event_details" id="myform">
<?php if(!empty(intval($_GET['id']))){  ?>
    <h3>Leave Request Form <?php echo '('.$username.')' ?></h3>
<?php }
        else { ?>
    <h3>Leave Request Form</h3>
<?php } ?>
    <div class="form_side">
        <form method="post" action="leaves" enctype="multipart/form-data">
            <?php echo $functions->setFormToken('leave',false); ?>
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
            <div class="row">
                <?php if(!empty($_GET['id'])){  ?>
           <div class="form-group col-md-6" style="display:none;">
                <label>FOR :</label>
                <input type="text" placeholder="Title Name" readonly="" value="<?php echo $username ?>" >
            </div>
            <?php } ?>
         <div class="form-group col-md-6" style="display:none;">
                <label>Title :</label>
                <input type="text" placeholder="Title Name" name="title" value="<?php echo $data['title'] ?>" >
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
                $('.type').val('<?php echo $data['type'] ?>').change();
            </script>
            <div class="form-group col-md-6">
                <label>Date From :</label>
                <input class="datepicker" id="from" type="text" value="<?php if(!empty($data['from_date'])) echo date('d-M-Y',strtotime($data['from_date'])) ?>" placeholder="Date From" name="datef" required autocomplete="off" readonly>
            </div>
            <!-- form-group -->
            <div class="form-group col-md-6">
                <label>Date To :</label>
                <input class="datepicker" id="tto" type="text" value="<?php if(!empty($data['to_date'])) echo date('d-M-Y',strtotime($data['to_date'])) ?>" placeholder="Date to" name="datet" required autocomplete="off" readonly>
            </div>
            <!-- form-group -->
             <div class="form-group col-md-6">
                <label>Leave Hours :</label>
                <input type="number" step="0.25" value="<?php echo $data['hours'] ?>" placeholder="Leave Hours" name="hours" required autocomplete="off" class="" min="0">
            </div>
            <!-- form-group -->
            <?php if($_SESSION['currentUserType'] != 'Employee' ||  $_SESSION['superUser']['hrdashboard'] == 'full'){ ?>
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
            <?php if($_SESSION['currentUserType'] != 'Employee' ||  $_SESSION['superUser']['hrdashboard'] == 'full'){ ?>
            <div class="form-group col-md-6">
                <label>Leave Status :</label>
                <select name="status" class="status" required>
                    <option value="Accepted">Accepted</option>
                    <option value="Rejected">Rejected</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>
              
            <!-- form-group -->
            <script>
                $('.status').val('<?php echo $data['status'] ?>').change();
            </script>
            <?php } ?>
            <div class="form-group col-md-6">
                <label>Comment</label>
                <textarea name="comment" value="<?php echo $data['comment'] ?>"><?php echo $data['comment'] ?></textarea>
            </div>
            <div class="form-group col-md-6">
            </div>
            
            <?php 
                $fromDate = $data['from_date'];
                $toDate = $data['to_date'];
                if(($_SESSION['currentUserType'] != 'Employee' ||  $_SESSION['superUser']['hrdashboard'] == 'full') && $data['status'] == "Pending" ){ 
               $user =intval($_SESSION['currentUser']);
                $sql1 = "
                        SELECT * FROM leaves WHERE 
                        status='Accepted' AND 
                        (fill_user IN (SELECT acc_id FROM accounts_user WHERE acc_id IN (SELECT id_user FROM accounts_user_detail WHERE setting_val='$user' AND setting_name='account_under') OR acc_id='$user') OR fill_user = '$user') AND 
                        (('$fromDate' BETWEEN from_date AND to_date) OR
                        ('$toDate' BETWEEN from_date AND to_date) OR
                        (from_date BETWEEN '$fromDate' AND '$toDate') OR
                        (to_date BETWEEN '$fromDate' AND '$toDate')) AND  `id` != '$id'
                ";
               $data1 = $dbF->getRows($sql1); 
               if ($dbF->rowCount > 0) {
                   echo '<div class="form-group col-md-6" style="margin-bottom: 0;">
                             <label>Accepted Applications:</label>';
                            foreach ($data1 as $key => $value) {
                                    $name = $functions->UserName($value['fill_user']);
                                 
                                        echo'
                                        - ('.$name.') (' . date("d-M-Y", strtotime($value['from_date'])) . ' - ' . date("d-M-Y", strtotime($value['to_date'])) . ') (' . $value['type'] . ') <br>
                                    ';
                                }
                        echo'</div>';
                }
                     $sql1 = "
                        SELECT * FROM leaves WHERE 
                        status='Pending' AND 
                        (fill_user IN (SELECT acc_id FROM accounts_user WHERE acc_id IN (SELECT id_user FROM accounts_user_detail WHERE setting_val='$user' AND setting_name='account_under') OR acc_id='$user') OR fill_user = '$user') AND 
                        (('$fromDate' BETWEEN from_date AND to_date) OR
                        ('$toDate' BETWEEN from_date AND to_date) OR
                        (from_date BETWEEN '$fromDate' AND '$toDate') OR
                        (to_date BETWEEN '$fromDate' AND '$toDate')) AND  `id` != '$id'
                     ";
                    $data1 = $dbF->getRows($sql1); 
                    if ($dbF->rowCount > 0) {
                        echo'<div class=" col-md-6">
                            <label>Pending Applications:</label>';
                            foreach ($data1 as $key => $value) {
                                    $name = $functions->UserName($value['fill_user']);
                                 
                                        echo'
                                      - ('.$name.') (' . date("d-M-Y", strtotime($value['from_date'])) . ' - ' . date("d-M-Y", strtotime($value['to_date'])) . ') (' . $value['type'] . ') <br> 
                                    ';
                                }
                        echo'</div>';
                }
                
            }
            ?>
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
$(function() {
    $( "#from, #tto" ).datepicker({
         dateFormat: 'd-M-yy',
        defaultDate: "+1w",
          changeMonth: true,
          changeYear: true,
     yearRange: "-100:+10",
      showButtonPanel:true,
      
        onSelect: function( selectedDate ) {
            if(this.id == 'from'){
              // var dateMin = $('#from').datepicker("getDate");
              var dateMin = $('#from').datepicker("getDate");
              var rMin = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() + 0); // Min Date = Selected + 1d
              var rMax = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() + 31); // Max Date = Selected + 31d
              $('#tto').datepicker("option","minDate",rMin);
              $('#tto').datepicker("option","maxDate",rMax);                    
            }

        }
    });
});
</script>