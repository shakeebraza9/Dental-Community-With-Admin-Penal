<?php 
include_once("global.php");

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}

?>
<div class="event_details" id="myform">
    <h3>Request Custom Log</h3>
    <div class="form_side">
        <form method="post" action="calendar" enctype="multipart/form-data">
            <?php echo $functions->setFormToken('customlog',false); ?>
            <div class="form-group">
                <label>Event Title :</label>
                <input type="text" name="title" required>
            </div>
            <!-- form-group -->
            <div class="form-group">
                <label>Frequency :</label>
                <input type="text" name="frequency" required>
            </div>
            <!-- form-group -->
            <div class="form-group">
                <label>Details :</label>
                <textarea name="desc" required></textarea>
            </div>
            <!-- form-group -->
            <input type="submit" class="submit_class" value="Request Now" name="submit">
        </form>
    </div><!-- form_side close -->
</div><!-- event_details -->