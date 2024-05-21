<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

include_once('header.php');

$functions->pin();
// $fill_user = $_SESSION['webUser']['id'];
$user = $_SESSION['webUser']['id'];
        $sql = "SELECT * FROM `leaves` WHERE `fill_user`='$user' AND `type`='Sick' AND `status`='accepted' AND `to_date` < CURDATE() AND `id` NOT IN (SELECT `lid` FROM `returnWork` WHERE `user` = '$user')";
$ldata = $dbF->getRow($sql);
if(empty($ldata)){
     $style="style='display:none'";
}

include'dashboardheader.php'; ?>
<div class="index_content">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            Return to Work
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'hrm'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
            <div class="profile rota" <?php  ?> >
                Please complete return to Work form, and upload
                <br>
 <a class="apink" href="https://smartdentalcompliance.com/uploads/files/COVID-19_Return_to_Work.docx"  data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i> Download Return to Work Form</a>
                

               
                <br><br>

                <form action="hrm" method="post" enctype="multipart/form-data">
                    <?php echo $functions->setFormToken('returnWork',false); ?>
                    <input type="hidden" name="lid" value="<?php echo $ldata['id'] ?>">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label>Details</label>
                            <textarea name="desc"></textarea>
                             <?php echo "Leave of Absence:  From ".date('d-M-Y',strtotime($ldata['from_date']))."  To ".date('d-M-Y',strtotime($ldata['to_date'])); ?>
                        </div>
                        
                        <div class="col-12 col-md-6">
       
                            <div class="add-file">
                                <label>Please Upload Return to Work Form</label>
                                <div class="file">
                                    <input type="file" name="file">
                                    <i class="fas fa-paperclip"></i>
                                    <div>Upload</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="submit" class="submit_class" value="Submit" name="submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- right_side close -->
    </div>
    </div>
    <!-- left_right_side -->
    <script>
        $(document).on('change', '.file input', function() {
            filename = this.files[0].name;
            $(this).parent('div').find('div').text(filename);
        });
    </script>
    <?php include_once('footer.php'); ?>