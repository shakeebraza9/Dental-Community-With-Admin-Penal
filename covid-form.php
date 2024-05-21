<?php 
include_once("global.php");

$login       =  $webClass->userLoginCheck();
if(!$login){

    
    echo "<script>location.reload();</script>";
     exit();
}

?> 
<div class="event_details" id="myform">
    <h3>COVID Screening</h3>
    Please submit this form to continue..
    <div class="form_side">
        <form method="post" action="dashboard" enctype="multipart/form-data">
            <?php echo $functions->setFormToken('covid',false); ?>
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
            <div class="col">
                <div class="form-group">
                    <label>1. Have you tested positive for COVID-19 in the last 7 days?</label>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="switch">
                                <input type="checkbox" name="q1" value="Yes" checked>
                                <span class="slider">Yes No</span>
                            </label>
                        </div>
                        <input type="text" class="col" name="q1c" placeholder="Comments">
                    </div>
                </div>
                <!-- form-group -->
                <div class="form-group">
                    <label>2. Are you waiting for a COVID-19 test or the results?</label>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="switch">
                                <input type="checkbox" name="q2" value="Yes" checked>
                                <span class="slider">Yes No</span>
                            </label>
                        </div>
                        <input type="text" class="col" name="q2c" placeholder="Comments">
                    </div>
                </div>
                <!-- form-group -->
                <div class="form-group">
                    <label>3. Do you have any of the following symptoms: • New, continuous cough*; • High Temperature or fever; • Loss of , or change in sense of smell or taste?</label>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="switch">
                                <input type="checkbox" name="q3" value="Yes" checked>
                                <span class="slider">Yes No</span>
                            </label>
                        </div>
                        <input type="text" class="col" name="q3c" placeholder="Comments">
                    </div>
                </div>
                <!-- form-group -->
                <div class="form-group">
                    <label>4. Do you live with someone who has either tested positive for COVID-19 or had symptoms of COVID-19 in the last 14 days?</label>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="switch">
                                <input type="checkbox" name="q4" value="Yes" checked>
                                <span class="slider">Yes No</span>
                            </label>
                        </div>
                        <input type="text" class="col" name="q4c" placeholder="Comments">
                    </div>
                </div>
                <!-- form-group -->
                <div class="form-group">
                    <label>5. Have you been notified by NHS Test and Trace in the last 10 days that you are a contact of a person who has tested positive for COVID-19 and you do not live with that person?</label>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="switch">
                                <input type="checkbox" name="q5" value="Yes" checked>
                                <span class="slider">Yes No</span>
                            </label>
                        </div>
                        <input type="text" class="col" name="q5c" placeholder="Comments">
                    </div>
                </div>
                <!-- form-group -->
                <div class="form-group">
                    <input type="submit" class="submit_class" value="Submit Information" name="submit">
                </div>
                <!-- form-group -->
            </div>
        </form>
    </div>
    <!-- form_side close -->
</div>
<!-- event_details -->