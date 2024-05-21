<?php ob_start(); 
    include_once("global.php");
    global $dbF, $webClass;

    $sql = "SELECT * FROM `free_resources` WHERE `publish` = 1 ORDER BY `id` DESC";
    $data = $dbF->getRows($sql);
    $check = $webClass->freeResoursesFormSubmit();
?>
           

        <div class="standard">
            <div class="m-y-50">
                <div class="flex">
        <?php foreach($data as $key => $value){?>
        
       
                    <div class="recourses-item">
                        <div class="recourses-inner">
                        </div>
                        <div class="inner-flex">
                            <img src="webImages2/Icon feather-file.svg" alt="">
                            <div>
                                <h4><?php echo $value['title']?></h4>
                            </div>
                        </div>

                        <div class="resource-download freeResourseDownloadBtn">
                            <input type="hidden" value="<?php echo $value['title'] ?>" class="title"/>
                            <input type="hidden" value="<?php echo $value['id'] ?>" class="file_id"/>
                            <a href="javascript:;">Click to download <img src="webImages2/line.svg" alt=""></a>
                        </div>
                    </div>



                
            
        
        <!-- Box Close --><!-- Box Open -->
        <?php } ?>
</div>
            </div>
        </div>
        <div class="standard">
            <div class="m-y-50">
               
            </div>
        </div>


<?php
return ob_get_clean(); ?>