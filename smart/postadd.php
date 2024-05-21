<?php 
include_once("global.php");

$login = $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}


 ?>
<div class="event_details" id="myform">


    <h3>Create post</h3>

    <div class="form_side">
        <form method="post" action="" enctype="multipart/form-data">
            <?php echo $functions->setFormToken('postadd',false); ?>
            <input type="hidden" name="id" value="<?php  ?>">
            <div class="row">
           
        
            <!-- form-group -->
              <div class="form-group col-md-6" >
                        <label class="control-label">Comment</label>
        <textarea name="ckeditorcmt" id="ckeditor" class="form-control ckeditor" placeholder="Enter Your Post" ></textarea>
    
<script>
  
CKEDITOR.replace( 'ckeditor');
  
</script>


                       </div>
            <!-- form-group -->
          
            <!-- form-group -->
          
        <?php    $img = "";
            if(@$data['image']!=''){
                $img=@$data['image']; ?>
               <input type='hidden' name='oldImg' value='$img' />";
                <div class="form-group">
                    <label  class="control-label">'Old Post Image</label>
                    <div class="col-sm-10  col-md-9">
                    <img src="<?php echo WEB_URL?>/images/<?php echo $img ?> " style="max-height:250px;" >
                    </div>
               </div>';
          <?php  } ?>

           <div class="form-group">
                    <label  class="  control-label">Post Image (278x278 px)</label>
                    <div class="col-sm-10  col-md-9">
                        <input type="file" name="image" class="btn-file btn btn-primary">
                    </div>
               </div>

            <!-- form-group -->
             
            <!-- form-group -->

            <div class="form-group col-12">
            <?php
            if(empty($data)){
            echo '<input type="submit" class="submit_class" value="Submit Post" name="submit">';
            }
            else{
            echo '<input type="submit" class="submit_class" value="Edit Post" name="edit">';
            }
            ?>
            </div>


            </div>
        </form>
    </div><!-- form_side close -->
</div><!-- event_details -->

