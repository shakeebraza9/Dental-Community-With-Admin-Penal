<?php 
include_once("global.php");

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}

?>
<div class="event_details" id="myform">
    <h3>Events</h3>
    <div class="form_side">
        <form method="post" action="calendar" enctype="multipart/form-data">
            <?php echo $functions->setFormToken('newEventAll',false); ?>
              <div class="form-group">
                            <label>Date :</label>
                            <input class="datepicker" type="text" name="due_date" value="" required autocomplete="off" >
                        </div>
            <div class="form-group">
                <label>Details :</label>
                <textarea name="desc" required></textarea>
            </div>
            <!-- form-group -->
            <input type="submit" class="submit_class" value="Submit Information" name="editAll">
        </form>
    </div><!-- form_side close -->
</div><!-- event_details -->
<script>
$(".datepicker").datepicker({ dateFormat: 'd-M-yy',

    changeMonth: true,
 changeYear: true,
  yearRange: "-100:+0",
  showButtonPanel: true
});
</script>