<?php 
include_once("global.php"); 
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
global $dbF,$webClass;
$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
     exit();
}
include_once('header.php');
include'dashboardheader.php'; ?>

<div class="index_content mypage health_form">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
             Technical Audit National Standard of Cleanlines
        </div>
        <!--link_menu close-->
     <div class="left_side">
            <?php $active = 'reportIssue'; include'dashboardmenu.php';?>
        </div><!-- left_side close -->
        <div class="right_side mock_inspection cleanliness_form">
            <div class="right_side_top">
                <div class="change-session">
                <?php
                    $functions->changeSession();
                    
                    ?>
                </div>
                <!-- change-session -->
            </div>
            <!-- right_side_top close -->

		<div id="tabs">
	   		<ul>
	        	<li><a active href="#tabs-1">Reception Cleanliness Audit</a></li>
                <li><a active href="#tabs-2">Kitchen Cleanliness Audit</a></li>
                <li><a active href="#tabs-3">Surgeries Cleanliness Audit</a></li>
	        	<li><a href="#tabs-4">Audit View</a></li>   
	        </ul>   
       <div id="tabs-1">
          	<form method="post" action="reception_cleanliness_audit_reports" enctype="multipart/form-data">
                 <?php
                   $check = $functions->selectAllPracticeData($_SESSION['currentUser']);
                    $fchk = false; ?>
                 <h3 style="padding-bottom: 22px;font-weight: 800;"> Practice Detail </h3> <br>
                    <div class="contact_right req">
                   <div class="form_1_">
                              
                                 <?php
                                 if (isset($_GET['editId'])) {
                                    $user1 = intval($_SESSION['webUser']['id']);    
                                    @$id =  $_GET['editId'];
                                    $sql  = "SELECT * FROM mock_inspection_report WHERE id = '$id'";
                                    $data = $dbF->getRow($sql);  
                                    // $pid=$data['pid'];
                                    $htmldata=json_decode($data['all_html'],true); 
                                    if($_SESSION['currentUser']!=$data['pid']){
                                        header('Location: login');
                                    }
                                    ?>
                                    <input type="hidden" name="old_id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="pid" value="<?php echo $user1; ?>">
                                   <div class="form_1_side_">Name of the practice</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[name-of-practice]" placeholder="Name of the practice" value="<?php echo $data[name_of_practice];?>" >
                                    </div>
                                    <div class="form_1_side_">Name of the practice manager</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[name-of-practice-manager]" placeholder="Name of the practice manager" value="<?php echo $data[name_of_practice_manager];?>" >
                                    </div>
                                    <div class="form_1_side_">Audit carried out by:</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[audit_carried_out_by]"  placeholder="Audit carried out by" value="<?php echo $data[audit_carried_out_by];?>">
                                    </div>
                                    
                                    <div class="form_1_side_"> Date</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" class="datepickerr" name="form[Date]" placeholder="Date" value="<?php echo $data[date];?>">
                                    </div>
                                    <?php
                                   }
                                   else{
                                        $user1 = intval($_SESSION['currentUser']);
                                  ?>

                                <input type="hidden" name="pid" value="<?php echo $user1; ?>">
                                <input type="hidden" name="form[cleanliness_type]" value="Reception" > 
                                    
                                        <input type="hidden" name="form[name-of-practice]" value="<?php echo $check[1] ?>" >
                                    
                                
                                        <input type="hidden" value="<?php echo $check[2] ?>" name="form[name-of-practice-manager]">
                                
                                    <div class="form_1_side_">Audit carried out by: </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[audit_carried_out_by]" value="" placeholder="Audit carried out by" >
                                    </div>
                                    
                                    <div class="form_1_side_">Date</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" class="datepickerr" value="<?php echo date('Y-m-d') ?>" name="form[Date]" placeholder="Date" >
                                    </div>
                                   

<?php
                                   } ?>
                                   <!--  <div class="form_1_side_"></div>
                                    <div class="form_2_side_">
                                        <div id="recaptcha2"></div>
                                    </div> -->
                                   
                                  
                              
                            </div>
                        </div>

                   
                    <hr>
                <div class="quest-box">
                    <div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAABHNCSVQICAgIfAhkiAAABN5JREFUWEflmFtoHGUUx883m7i72d3MqhVBxKY01BvG1IdQ3dmoiCLipaFQsxNvkD4VLAoiCorgixVfSkARo77UzEbEaq0PasG22Wn0oTT1iuCtUosKXmayuew22Tn+v0lnnaabnc00DQluHjI7833n+33/c75zzo6gFf4RK5yPVg9gOm8eWFY1hbCs3kxP0JpVBQHIQYOX9DkzWXo20IOrD5BZ2WnrNz29pGr5jKXzhYNE4mYKraCgx61ebdfqAdxrplKTsWhY4GKiVKb7tKI3f8kVbDXMrxVB14YFhCe/snWt4/8LqOZHb2Pma8IqKJroG3tr5tPzpmBYsIXmLX0MDpl3KSTaGwGF0n/YD2hv1xurGuY2Ieg1pBkRLlHPSzNpo3CchFgbBIjD4OBPl4CtxuHtgp1+VPrLMO9iIcRJ/D/hOM4r433dw+l3j66lU1ODVk67I8ju2ZUkDCDTeCna0tE8M3ldxKHd2FC6urAsoL6Cho387VRoc/FBrRAEJ58HArZKFwtnQz1jlt69S6qmCH55bhzb5IgBmN9j9WWOpfOftTlceQiLbYd7LwUzU4VyQeHQEGAju0wPHe4khcfm2HgfYuveBQ+JYQ5Alkcl5Cw3dU7qm76st0aggmq+sFOw0lXbSOUDqR4C/3epTBCctKG+Zd5PEbodC/dj/Als5opzAqx3SByHn1UUMuHKA1hskuLJy62ejdZCC6rD5vc0S89I16aNEYuEolaYs0U9Cxu1P8EKGuYngpzaCsZTbVQqorFQHmaHDLtP61sQzigYeLbV1rNNckzaczXz+7i3YOMaCBgUg/8pzLdauezBWuOlW0WEhpEnqzCp3WY20kQjONU/oVavD63gYgETxucdCs20+t2Gbr0IuGQ5mmgrbbnhF8+m7OKZnb9svXtNaEA1b74umLbMN4BTCMNau2oUvkMivrIi+J5ib/ZD9yAYhd8EiXcsXduBawPPczi0h6DwLZ6d1HDh7giLfbj/Be53hgas1s4aFlAJhDo08pJQlCfgqv0AdiuDaoygnCmDLGgPMl6PLGvz1fPA8ehNW8/0hwc0Rh5DZdhcy8AMN+9oFjxOVPkZgBURT6zxTrF/Y/7Ycw/Ie2NpLk1IlWNEkXVW7sbjoQGDYtBdcMg8RAp1IwEfw8+FjdUYMwoTTCICZeN+O4CXqSkj7yFU3rBz2rbQgG6pq9PNlGLxvTFF2DQ98SuUTpDD31JLMlMrH7rKTU98jJjscpsLYgXXdSED00xQNwMFTpUvaHFrdbQ8NYb1LsS9WXzdLxzxkaPQj4pD61EKe+DqLIAiciw6mxzGJmWs1lPynAFd1zBNo5u5WqYQeepxKB7xQPyug2qytykDLCbn4Ms0ri/yxuDxi3Yu+5R/TiBgI92MNFghceSM3IfDhfi7U8IArITrUSWeGJCuxyZ+wMJucgbkP8TOk4jJQeluh+m5cV173oMMBGzkkIQZU4U8rX50emoTwmB4PuSyA6rG6AsiGnvVmguHOSV9kLIkuh453UQsO6CbH1l0EWJ2PiQS+0kAtcuQ8FLT2YDYjQzkMG5raI7gJOINHQ3/iRJ3iZxzRkwCrhxtucqr2Svm7Raa3jEckXWlaPJ6f0PhA5RvnZbx477A1GqW0JppZhnRFrVU4BvORVk7D4NXPOC/gCfzRzwZcKQAAAAASUVORK5CYII=); background-repeat: no-repeat; background-position: center;"></div>
                    <h3>General Environment-Reception</h3>
                    <h5><span class="audit_txt">1. The entrance/ exit to the facility is clean, uncluttered, fresh smelling?<span></h5><br>
                    <div class="question">
                        <div class="numb">1.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Area is visibly clean</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_entrance_clean_question]" value="Area is visibly clean">
<input type="radio" name="reception[r_entrance_clean]" value="yes" id="r_entrance_clean" <?php if($htmldata['reception']['data']['r_entrance_clean']['value']=="yes") echo "checked";?>>
<label for="r_entrance_clean">Yes</label>
<input type="radio" name="reception[r_entrance_clean]" value="The entrance and exit to the facility is not clean" id="r_entrance_clean2" <?php if($htmldata['reception']['data']['r_entrance_clean']['value']=="The entrance and exit to the facility is not clean") echo "checked";?>>
<label for="r_entrance_clean2">No</label>


<input type="radio" name="reception[r_entrance_clean]" value="N/A" id="r_entrance_clean3" <?php if($htmldata['reception']['data']['r_entrance_clean']['value']=="N/A") echo "checked";?>>
<label for="r_entrance_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_entrance_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_entrance_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="The entrance and exit to the facility is not clean" >
                             
                        </div>

                    </div>
                    <!-- question -->
                   <div class="question">
                        <div class="numb">1.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Free from clutter
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_entrance_clutter_question]" value="Free from clutter">
<input type="radio" name="reception[r_entrance_clutter]" value="yes" id="r_entrance_clutter" <?php if($htmldata['reception']['data']['r_entrance_clutter']['value']=="yes") echo "checked";?>>
<label for="r_entrance_clutter">Yes</label>
<input type="radio" name="reception[r_entrance_clutter]" value="The entrance and exit to the facility is cluttered" id="r_entrance_clutter2" <?php if($htmldata['reception']['data']['r_entrance_clutter']['value']=="The entrance and exit to the facility is cluttered") echo "checked";?>>
<label for="r_entrance_clutter2">No</label>


<input type="radio" name="reception[r_entrance_clutter]" value="N/A" id="r_entrance_clutter3" <?php if($htmldata['reception']['data']['r_entrance_clutter']['value']=="N/A") echo "checked";?>>
<label for="r_entrance_clutter3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_entrance_clutter_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_entrance_clutter']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="The entrance and exit to the facility is cluttered" >
                             
                        </div>

                      
                    </div>               
                 
 <!-- question -->
                   <div class="question">
                        <div class="numb">1.3</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 No foul or stale odours
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_entrance_fresh_smell_question]" value="No foul or stale odours">
<input type="radio" name="reception[r_entrance_fresh_smell]" value="yes" id="r_entrance_fresh_smell" <?php if($htmldata['reception']['data']['r_entrance_fresh_smell']['value']=="yes") echo "checked";?>>
<label for="r_entrance_fresh_smell">Yes</label>
<input type="radio" name="reception[r_entrance_fresh_smell]" value="The entrance/ exit to the facility is not fresh smelling" id="r_entrance_fresh_smell2" <?php if($htmldata['reception']['data']['r_entrance_fresh_smell']['value']=="The entrance/ exit to the facility is not fresh smelling") echo "checked";?>>
<label for="r_entrance_fresh_smell2">No</label>


<input type="radio" name="reception[r_entrance_fresh_smell]" value="N/A" id="r_entrance_fresh_smell3" <?php if($htmldata['reception']['data']['r_entrance_fresh_smell']['value']=="N/A") echo "checked";?>>
<label for="r_entrance_fresh_smell3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_entrance_fresh_smell_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_entrance_fresh_smell']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="The entrance/ exit to the facility area is not visibly clean" >
                             
                        </div>

                    </div>                     
                        <hr>
                 
 <!-- question -->
 <h5><span class="audit_txt">2. The reception areas are clean, uncluttered, fresh smelling?<span></h5><br>
    <div class="question">
                        <div class="numb">2.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Area is visibly clean</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_reception_clean_question]" value="Area is visibly clean">
<input type="radio" name="reception[r_reception_clean]" value="yes" id="r_reception_clean" <?php if($htmldata['reception']['data']['r_reception_clean']['value']=="yes") echo "checked";?>>
<label for="r_reception_clean">Yes</label>
<input type="radio" name="reception[r_reception_clean]" value="The reception areas are not clean" id="r_reception_clean2" <?php if($htmldata['reception']['data']['r_reception_clean']['value']=="The reception areas are not clean") echo "checked";?>>
<label for="r_reception_clean2">No</label>


<input type="radio" name="reception[r_reception_clean]" value="N/A" id="r_reception_clean3" <?php if($htmldata['reception']['data']['r_reception_clean']['value']=="N/A") echo "checked";?>>
<label for="r_reception_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_reception_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_reception_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="The reception areas are not clean" >
                             
                        </div>

                    </div>
                    <!-- question -->
                   <div class="question">
                        <div class="numb">2.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Free from clutter
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_reception_clutter_question]" value="Free from clutter">
<input type="radio" name="reception[r_reception_clutter]" value="yes" id="r_reception_clutter" <?php if($htmldata['reception']['data']['r_reception_clutter']['value']=="yes") echo "checked";?>>
<label for="r_reception_clutter">Yes</label>
<input type="radio" name="reception[r_reception_clutter]" value="The reception areas are cluttered" id="r_reception_clutter2" <?php if($htmldata['reception']['data']['r_reception_clutter']['value']=="The reception areas are cluttered") echo "checked";?>>
<label for="r_reception_clutter2">No</label>


<input type="radio" name="reception[r_reception_clutter]" value="N/A" id="r_reception_clutter3" <?php if($htmldata['reception']['data']['r_reception_clutter']['value']=="N/A") echo "checked";?>>
<label for="r_reception_clutter3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_reception_clutter_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_reception_clutter']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="The reception areas are cluttered" >
                             
                        </div>

                      
                    </div>               
                 
 <!-- question -->
                   <div class="question">
                        <div class="numb">2.3</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 No foul or stale odours
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_reception_fresh_smell_question]" value="No foul or stale odours">
<input type="radio" name="reception[r_reception_fresh_smell]" value="yes" id="r_reception_fresh_smell" <?php if($htmldata['reception']['data']['r_reception_fresh_smell']['value']=="yes") echo "checked";?>>
<label for="r_reception_fresh_smell">Yes</label>
<input type="radio" name="reception[r_reception_fresh_smell]" value="The reception areas are not fresh smelling" id="r_reception_fresh_smell2" <?php if($htmldata['reception']['data']['r_reception_fresh_smell']['value']=="The reception areas are not fresh smelling") echo "checked";?>>
<label for="r_reception_fresh_smell2">No</label>


<input type="radio" name="reception[r_reception_fresh_smell]" value="N/A" id="r_reception_fresh_smell3" <?php if($htmldata['reception']['data']['r_reception_fresh_smell']['value']=="N/A") echo "checked";?>>
<label for="r_reception_fresh_smell3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_reception_fresh_smell_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_reception_fresh_smell']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="The reception areas are not visibly clean" >
                             
                        </div>

                    </div>                     
                        <hr>  
<h5><span class="audit_txt">3. Walls are clean and in a good state of repair?<span></h5><br>
<div class="question">
                        <div class="numb">3.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 Visibly clean, no obvious signs of splashes, stains, dust, sticky tape etc
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_walls_clean_question]" value="Visibly clean, no obvious signs of splashes, stains, dust, sticky tape etc">
<input type="radio" name="reception[r_walls_clean]" value="yes" id="r_walls_clean" <?php if($htmldata['reception']['data']['r_walls_clean']['value']=="yes") echo "checked";?>>
<label for="r_walls_clean">Yes</label>
<input type="radio" name="reception[r_walls_clean]" value="Walls are not clean" id="r_walls_clean2" <?php if($htmldata['reception']['data']['r_walls_clean']['value']=="Walls are not clean") echo "checked";?>>
<label for="r_walls_clean2">No</label>


<input type="radio" name="reception[r_walls_clean]" value="N/A" id="r_walls_clean3" <?php if($htmldata['reception']['data']['r_walls_clean']['value']=="N/A") echo "checked";?>>
<label for="r_walls_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_walls_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_walls_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Walls are not clean" >
                             
                        </div>

                      
                    </div>               
                 
 <!-- question -->
                   <div class="question">
                        <div class="numb">3.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Free from visible damage i.e. chipped flaky paintwork, holes, cracks, unfinished surfaces, sticky tape
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_walls_damage_question]" value="Free from visible damage i.e. chipped flaky paintwork, holes, cracks, unfinished surfaces, sticky tape">
<input type="radio" name="reception[r_walls_damage]" value="yes" id="r_walls_damage" <?php if($htmldata['reception']['data']['r_walls_damage']['value']=="yes") echo "checked";?>>
<label for="r_walls_damage">Yes</label>
<input type="radio" name="reception[r_walls_damage]" value="Walls are not good state of repair" id="r_walls_damage2" <?php if($htmldata['reception']['data']['r_walls_damage']['value']=="Walls are not good state of repair") echo "checked";?>>
<label for="r_walls_damage2">No</label>


<input type="radio" name="reception[r_walls_damage]" value="N/A" id="r_walls_damage3" <?php if($htmldata['reception']['data']['r_walls_damage']['value']=="N/A") echo "checked";?>>
<label for="r_walls_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_walls_damage_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_walls_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Walls are not good state of repair" >
                             
                        </div>

                    </div>                     
                        <hr> 


<h5><span class="audit_txt">4. Skirting is clean and in a good state of repair?<span></h5><br>
<div class="question">
                        <div class="numb">4.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 Visibly clean, no obvious signs of splashes, stains, dust
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_skirting_clean_question]" value="Visibly clean, no obvious signs of splashes, stains, dust, sticky tape etc">
<input type="radio" name="reception[r_skirting_clean]" value="yes" id="r_skirting_clean" <?php if($htmldata['reception']['data']['r_skirting_clean']['value']=="yes") echo "checked";?>>
<label for="r_skirting_clean">Yes</label>
<input type="radio" name="reception[r_skirting_clean]" value="skirting are not clean" id="r_skirting_clean2" <?php if($htmldata['reception']['data']['r_skirting_clean']['value']=="skirting are not clean") echo "checked";?>>
<label for="r_skirting_clean2">No</label>


<input type="radio" name="reception[r_skirting_clean]" value="N/A" id="r_skirting_clean3" <?php if($htmldata['reception']['data']['r_skirting_clean']['value']=="N/A") echo "checked";?>>
<label for="r_skirting_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_skirting_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_skirting_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="skirting are not clean" >
                             
                        </div>

                      
                    </div>               
                 
 <!-- question -->
                   <div class="question">
                        <div class="numb">4.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Free from visible damage i.e. chipped flaky paintwork, holes, cracks, unfinished surfaces, sticky tape
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_skirting_damage_question]" value="Free from visible damage i.e. chipped flaky paintwork, holes, cracks, unfinished surfaces, sticky tape">
<input type="radio" name="reception[r_skirting_damage]" value="yes" id="r_skirting_damage" <?php if($htmldata['reception']['data']['r_skirting_damage']['value']=="yes") echo "checked";?>>
<label for="r_skirting_damage">Yes</label>
<input type="radio" name="reception[r_skirting_damage]" value="skirting are not good state of repair" id="r_skirting_damage2" <?php if($htmldata['reception']['data']['r_skirting_damage']['value']=="skirting are not good state of repair") echo "checked";?>>
<label for="r_skirting_damage2">No</label>


<input type="radio" name="reception[r_skirting_damage]" value="N/A" id="r_skirting_damage3" <?php if($htmldata['reception']['data']['r_skirting_damage']['value']=="N/A") echo "checked";?>>
<label for="r_skirting_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_skirting_damage_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_skirting_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="skirting are not good state of repair" >
                             
                        </div>

                    </div> 

                        <hr> 
            <h5><span class="audit_txt">5. Lights and fittings are clean and in a good state of repair?<span></h5><br>
<div class="question">
                        <div class="numb">5.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 Visibly clean, free from dust debris and cobwebs
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_lights_and_fittings_clean_question]" value="Visibly clean, free from dust debris and cobwebs">
<input type="radio" name="reception[r_lights_and_fittings_clean]" value="yes" id="r_lights_and_fittings_clean" <?php if($htmldata['reception']['data']['r_lights_and_fittings_clean']['value']=="yes") echo "checked";?>>
<label for="r_lights_and_fittings_clean">Yes</label>
<input type="radio" name="reception[r_lights_and_fittings_clean]" value="Lights and fittings are not clean" id="r_lights_and_fittings_clean2" <?php if($htmldata['reception']['data']['r_lights_and_fittings_clean']['value']=="Lights and fittings are not clean") echo "checked";?>>
<label for="r_lights_and_fittings_clean2">No</label>


<input type="radio" name="reception[r_lights_and_fittings_clean]" value="N/A" id="r_lights_and_fittings_clean3" <?php if($htmldata['reception']['data']['r_lights_and_fittings_clean']['value']=="N/A") echo "checked";?>>
<label for="r_lights_and_fittings_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_lights_and_fittings_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_lights_and_fittings_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Lights and fittings are not clean" >
                             
                        </div>

                      
                    </div>               
                 
 <!-- question -->
                   <div class="question">
                        <div class="numb">5.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Bulbs are in working order and fittings are intact
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_lights_and_fittings_damage_question]" value="Bulbs are in working order and fittings are intact">
<input type="radio" name="reception[r_lights_and_fittings_damage]" value="yes" id="r_lights_and_fittings_damage" <?php if($htmldata['reception']['data']['r_lights_and_fittings_damage']['value']=="yes") echo "checked";?>>
<label for="r_lights_and_fittings_damage">Yes</label>
<input type="radio" name="reception[r_lights_and_fittings_damage]" value="Lights and fittings are not good state of repair" id="r_lights_and_fittings_damage2" <?php if($htmldata['reception']['data']['r_lights_and_fittings_damage']['value']=="Lights and fittings are not good state of repair") echo "checked";?>>
<label for="r_lights_and_fittings_damage2">No</label>


<input type="radio" name="reception[r_lights_and_fittings_damage]" value="N/A" id="r_lights_and_fittings_damage3" <?php if($htmldata['reception']['data']['r_lights_and_fittings_damage']['value']=="N/A") echo "checked";?>>
<label for="r_lights_and_fittings_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_lights_and_fittings_damage_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_lights_and_fittings_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Lights and fittings are not good state of repair" >
                             
                        </div>

                    </div>                     
                        <hr> 

<h5><span class="audit_txt">6. Light switches/pull cords are clean and in a good state of repair?<span></h5><br>
<div class="question">
                        <div class="numb">6.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 Visibly clean especially around touch points
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_lights_switches_clean_question]" value="Visibly clean especially around touch points">
<input type="radio" name="reception[r_lights_switches_clean]" value="yes" id="r_lights_switches_clean" <?php if($htmldata['reception']['data']['r_lights_switches_clean']['value']=="yes") echo "checked";?>>
<label for="r_lights_switches_clean">Yes</label>
<input type="radio" name="reception[r_lights_switches_clean]" value="Light switches and pull cords are not clean" id="r_lights_switches_clean2" <?php if($htmldata['reception']['data']['r_lights_switches_clean']['value']=="Light switches and pull cords are not clean") echo "checked";?>>
<label for="r_lights_switches_clean2">No</label>


<input type="radio" name="reception[r_lights_switches_clean]" value="N/A" id="r_lights_switches_clean3" <?php if($htmldata['reception']['data']['r_lights_switches_clean']['value']=="N/A") echo "checked";?>>
<label for="r_lights_switches_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_lights_switches_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_lights_switches_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Light switches and pull cords are not clean" >
                             
                        </div>

                      
                    </div>               
                 
 <!-- question -->
                   <div class="question">
                        <div class="numb">6.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_lights_switches_damage_question]" value="No visible sign of damage">
<input type="radio" name="reception[r_lights_switches_damage]" value="yes" id="r_lights_switches_damage" <?php if($htmldata['reception']['data']['r_lights_switches_damage']['value']=="yes") echo "checked";?>>
<label for="r_lights_switches_damage">Yes</label>
<input type="radio" name="reception[r_lights_switches_damage]" value="Light switches/ pull cords are not good state of repair" id="r_lights_switches_damage2" <?php if($htmldata['reception']['data']['r_lights_switches_damage']['value']=="Light switches/ pull cords are not good state of repair") echo "checked";?>>
<label for="r_lights_switches_damage2">No</label>


<input type="radio" name="reception[r_lights_switches_damage]" value="N/A" id="r_lights_switches_damage3" <?php if($htmldata['reception']['data']['r_lights_switches_damage']['value']=="N/A") echo "checked";?>>
<label for="r_lights_switches_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_lights_switches_damage_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_lights_switches_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Light switches/ pull cords are not good state of repair" >
                             
                        </div>

                    </div>                     
                        <hr> 

<h5><span class="audit_txt">7. Radiators are clean and in a good state of repair?<span></h5><br>
<div class="question">
                        <div class="numb">7.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 Visibly clean, check top and behind for a build up of dust
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_radiators_clean_question]" value="Visibly clean, check top and behind for a build up of dust">
<input type="radio" name="reception[r_radiators_clean]" value="yes" id="r_radiators_clean" <?php if($htmldata['reception']['data']['r_radiators_clean']['value']=="yes") echo "checked";?>>
<label for="r_radiators_clean">Yes</label>
<input type="radio" name="reception[r_radiators_clean]" value=" Radiators are not clean" id="r_radiators_clean2" <?php if($htmldata['reception']['data']['r_radiators_clean']['value']==" Radiators are not clean") echo "checked";?>>
<label for="r_radiators_clean2">No</label>


<input type="radio" name="reception[r_radiators_clean]" value="N/A" id="r_radiators_clean3" <?php if($htmldata['reception']['data']['r_radiators_clean']['value']=="N/A") echo "checked";?>>
<label for="r_radiators_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_radiators_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_radiators_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value=" Radiators are not clean" >
                             
                        </div>

                      
                    </div>               
                 
 <!-- question -->
                   <div class="question">
                        <div class="numb">7.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage or rust
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_radiators_damage_question]" value="No visible sign of damage or rust">
<input type="radio" name="reception[r_radiators_damage]" value="yes" id="r_radiators_damage" <?php if($htmldata['reception']['data']['r_radiators_damage']['value']=="yes") echo "checked";?>>
<label for="r_radiators_damage">Yes</label>
<input type="radio" name="reception[r_radiators_damage]" value=" Radiators are not good state of repair" id="r_radiators_damage2" <?php if($htmldata['reception']['data']['r_radiators_damage']['value']==" Radiators are not good state of repair") echo "checked";?>>
<label for="r_radiators_damage2">No</label>


<input type="radio" name="reception[r_radiators_damage]" value="N/A" id="r_radiators_damage3" <?php if($htmldata['reception']['data']['r_radiators_damage']['value']=="N/A") echo "checked";?>>
<label for="r_radiators_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_radiators_damage_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_radiators_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value=" Radiators are not good state of repair" >
                             
                        </div>

                    </div>                     
                        <hr> 

<h5><span class="audit_txt">8. Notice boards are clean, tidy and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[r_notice_board_main_question]" value="Notice boards are clean, tidy and in a good state of repair?">
<div class="question">
                        <div class="numb">8.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_notice_board_clean_question]" value="Visibly clean">
<input type="radio" name="reception[r_notice_board_clean]" value="yes" id="r_notice_board_clean" <?php if($htmldata['reception']['data']['r_notice_board_clean']['value']=="yes") echo "checked";?>>
<label for="r_notice_board_clean">Yes</label>
<input type="radio" name="reception[r_notice_board_clean]" value="notice board are not clean" id="r_notice_board_clean2" <?php if($htmldata['reception']['data']['r_notice_board_clean']['value']=="notice board are not clean") echo "checked";?>>
<label for="r_notice_board_clean2">No</label>


<input type="radio" name="reception[r_notice_board_clean]" value="N/A" id="r_notice_board_clean3" <?php if($htmldata['reception']['data']['r_notice_board_clean']['value']=="N/A") echo "checked";?>>
<label for="r_notice_board_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_notice_board_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_notice_board_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="notice board are not clean" >
                             
                        </div>

                      
                    </div>               
               <!-- question -->
           <div class="question">
                <div class="numb">8.2</div>
                <div class="quest">


<div class="quest-inner">
<div class="q">
Tidy
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_notice_board_tidy_question]" value="Tidy">
<input type="radio" name="reception[r_notice_board_tidy]" value="yes" id="r_notice_board_tidy" <?php if($htmldata['reception']['data']['r_notice_board_tidy']['value']=="yes") echo "checked";?>>
<label for="r_notice_board_tidy">Yes</label>
<input type="radio" name="reception[r_notice_board_tidy]" value="notice_board are not tidy" id="r_notice_board_tidy2" <?php if($htmldata['reception']['data']['r_notice_board_tidy']['value']=="notice_board are not tidy") echo "checked";?>>
<label for="r_notice_board_tidy2">No</label>


<input type="radio" name="reception[r_notice_board_tidy]" value="N/A" id="r_notice_board_tidy3" <?php if($htmldata['reception']['data']['r_notice_board_tidy']['value']=="N/A") echo "checked";?>>
<label for="r_notice_board_tidy3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_notice_board_tidy_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_notice_board_tidy']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="notice_board are not tidy" >
                             
                        </div>

                    </div>         
 <!-- question -->
                   <div class="question">
                        <div class="numb">8.3</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible damage
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_notice_board_damage_question]" value="No visible damage">
<input type="radio" name="reception[r_notice_board_damage]" value="yes" id="r_notice_board_damage" <?php if($htmldata['reception']['data']['r_notice_board_damage']['value']=="yes") echo "checked";?>>
<label for="r_notice_board_damage">Yes</label>
<input type="radio" name="reception[r_notice_board_damage]" value="notice board are not good state of repair" id="r_notice_board_damage2" <?php if($htmldata['reception']['data']['r_notice_board_damage']['value']=="notice board are not good state of repair") echo "checked";?>>
<label for="r_notice_board_damage2">No</label>


<input type="radio" name="reception[r_notice_board_damage]" value="N/A" id="r_notice_board_damage3" <?php if($htmldata['reception']['data']['r_notice_board_damage']['value']=="N/A") echo "checked";?>>
<label for="r_notice_board_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_notice_board_damage_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_notice_board_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="notice board are not good state of repair" >
                             
                        </div>

                    </div>                     
                        <hr> 



<h5><span class="audit_txt">9. Flooring is clean, in a good state of repair, made from impermeable material?<span></h5><br>
<input type="hidden" name="form[r_flooring_main_question]" value="Flooring is clean, in a good state of repair, made from impermeable material?">
<div class="question">
                        <div class="numb">9.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean, no build up of residue/ dirt, check edges and corners are free from dust and grit
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_flooring_clean_question]" value="Visibly clean, no build up of residue/ dirt, check edges and corners are free from dust and grit">
<input type="radio" name="reception[r_flooring_clean]" value="yes" id="r_flooring_clean" <?php if($htmldata['reception']['data']['r_flooring_clean']['value']=="yes") echo "checked";?>>
<label for="r_flooring_clean">Yes</label>
<input type="radio" name="reception[r_flooring_clean]" value="Flooring are not clean" id="r_flooring_clean2" <?php if($htmldata['reception']['data']['r_flooring_clean']['value']=="Flooring are not clean") echo "checked";?>>
<label for="r_flooring_clean2">No</label>


<input type="radio" name="reception[r_flooring_clean]" value="N/A" id="r_flooring_clean3" <?php if($htmldata['reception']['data']['r_flooring_clean']['value']=="N/A") echo "checked";?>>
<label for="r_flooring_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_flooring_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_flooring_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Flooring are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">9.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Free from rips and tears, laid correctly
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_flooring_damage_question]" value="Free from rips and tears, laid correctly">
<input type="radio" name="reception[r_flooring_damage]" value="yes" id="r_flooring_damage" <?php if($htmldata['reception']['data']['r_flooring_damage']['value']=="yes") echo "checked";?>>
<label for="r_flooring_damage">Yes</label>
<input type="radio" name="reception[r_flooring_damage]" value="Flooring are not good state of repair" id="r_flooring_damage2" <?php if($htmldata['reception']['data']['r_flooring_damage']['value']=="Flooring are not good state of repair") echo "checked";?>>
<label for="r_flooring_damage2">No</label>


<input type="radio" name="reception[r_flooring_damage]" value="N/A" id="r_flooring_damage3" <?php if($htmldata['reception']['data']['r_flooring_damage']['value']=="N/A") echo "checked";?>>
<label for="r_flooring_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_flooring_damage_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_flooring_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Flooring are not good state of repair" >
                             
                        </div>

                    </div> 
     <!-- question -->
           <div class="question">
                <div class="numb">9.3</div>
                <div class="quest">


<div class="quest-inner">
<div class="q">
Washable and impervious to moisture
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_flooring_impermeable_question]" value="Washable and impervious to moisture">
<input type="radio" name="reception[r_flooring_impermeable]" value="yes" id="r_flooring_impermeable" <?php if($htmldata['reception']['data']['r_flooring_impermeable']['value']=="yes") echo "checked";?>>
<label for="r_flooring_impermeable">Yes</label>
<input type="radio" name="reception[r_flooring_impermeable]" value="flooring are not made from impermeable material" id="r_flooring_impermeable2" <?php if($htmldata['reception']['data']['r_flooring_impermeable']['value']=="flooring are not made from impermeable material") echo "checked";?>>
<label for="r_flooring_impermeable2">No</label>


<input type="radio" name="reception[r_flooring_impermeable]" value="N/A" id="r_flooring_impermeable3" <?php if($htmldata['reception']['data']['r_flooring_impermeable']['value']=="N/A") echo "checked";?>>
<label for="r_flooring_impermeable3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_flooring_impermeable_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_flooring_impermeable']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="flooring are not made from impermeable material" >
                             
                        </div>

                    </div>                     
                        <hr> 

<h5><span class="audit_txt">10. Doors and frames are clean and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[r_doors_main_question]" value="Doors and frames are clean and in a good state of repair?">
<div class="question">
                        <div class="numb">10.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean especially around touch points
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_doors_clean_question]" value="Visibly clean especially around touch points">
<input type="radio" name="reception[r_doors_clean]" value="yes" id="r_doors_clean" <?php if($htmldata['reception']['data']['r_doors_clean']['value']=="yes") echo "checked";?>>
<label for="r_doors_clean">Yes</label>
<input type="radio" name="reception[r_doors_clean]" value="doors and frames are not clean" id="r_doors_clean2" <?php if($htmldata['reception']['data']['r_doors_clean']['value']=="doors and frames are not clean") echo "checked";?>>
<label for="r_doors_clean2">No</label>


<input type="radio" name="reception[r_doors_clean]" value="N/A" id="r_doors_clean3" <?php if($htmldata['reception']['data']['r_doors_clean']['value']=="N/A") echo "checked";?>>
<label for="r_doors_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_doors_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_doors_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="doors and frames are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">10.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 No visible sign of damage, no exposed wood
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_doors_damage_question]" value="No visible sign of damage, no exposed wood">
<input type="radio" name="reception[r_doors_damage]" value="yes" id="r_doors_damage" <?php if($htmldata['reception']['data']['r_doors_damage']['value']=="yes") echo "checked";?>>
<label for="r_doors_damage">Yes</label>
<input type="radio" name="reception[r_doors_damage]" value="doors and frames are not good state of repair" id="r_doors_damage2" <?php if($htmldata['reception']['data']['r_doors_damage']['value']=="doors and frames are not good state of repair") echo "checked";?>>
<label for="r_doors_damage2">No</label>


<input type="radio" name="reception[r_doors_damage]" value="N/A" id="r_doors_damage3" <?php if($htmldata['reception']['data']['r_doors_damage']['value']=="N/A") echo "checked";?>>
<label for="r_doors_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_doors_damage_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_doors_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="doors and frames are not good state of repair" >
                             
                        </div>

                    </div> 
                    <hr>

<h5><span class="audit_txt">11. External windows including frames and sills are clean and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[r_external_windows_main_question]" value="External windows including frames and sills are clean and in a good state of repair?">
<div class="question">
                        <div class="numb">11.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_external_windows_clean_question]" value="Visibly clean">
<input type="radio" name="reception[r_external_windows_clean]" value="yes" id="r_external_windows_clean" <?php if($htmldata['reception']['data']['r_external_windows_clean']['value']=="yes") echo "checked";?>>
<label for="r_external_windows_clean">Yes</label>
<input type="radio" name="reception[r_external_windows_clean]" value="External windows including frames and sills are not clean" id="r_external_windows_clean2" <?php if($htmldata['reception']['data']['r_external_windows_clean']['value']=="External windows including frames and sills are not clean") echo "checked";?>>
<label for="r_external_windows_clean2">No</label>


<input type="radio" name="reception[r_external_windows_clean]" value="N/A" id="r_external_windows_clean3" <?php if($htmldata['reception']['data']['r_external_windows_clean']['value']=="N/A") echo "checked";?>>
<label for="r_external_windows_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_external_windows_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_external_windows_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="External windows including frames and sills are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">11.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage, cracks
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_external_windows_damage_question]" value="No visible sign of damage, cracks">
<input type="radio" name="reception[r_external_windows_damage]" value="yes" id="r_external_windows_damage" <?php if($htmldata['reception']['data']['r_external_windows_damage']['value']=="yes") echo "checked";?>>
<label for="r_external_windows_damage">Yes</label>
<input type="radio" name="reception[r_external_windows_damage]" value="External windows including frames and sills are not good state of repair" id="r_external_windows_damage2" <?php if($htmldata['reception']['data']['r_external_windows_damage']['value']=="External windows including frames and sills are not good state of repair") echo "checked";?>>
<label for="r_external_windows_damage2">No</label>


<input type="radio" name="reception[r_external_windows_damage]" value="N/A" id="r_external_windows_damage3" <?php if($htmldata['reception']['data']['r_external_windows_damage']['value']=="N/A") echo "checked";?>>
<label for="r_external_windows_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_external_windows_damage_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_external_windows_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="External windows including frames and sills are not good state of repair" >
                             
                        </div>

                    </div> 
                    <hr>
<h5><span class="audit_txt">12. Internal windows including frames and sills are clean and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[r_internal_windows_main_question]" value="Internal windows including frames and sills are clean and in a good state of repair?">
<div class="question">
                        <div class="numb">12.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_internal_windows_clean_question]" value="Visibly clean">
<input type="radio" name="reception[r_internal_windows_clean]" value="yes" id="r_internal_windows_clean" <?php if($htmldata['reception']['data']['r_internal_windows_clean']['value']=="yes") echo "checked";?>>
<label for="r_internal_windows_clean">Yes</label>
<input type="radio" name="reception[r_internal_windows_clean]" value="internal windows including frames and sills are not clean" id="r_internal_windows_clean2" <?php if($htmldata['reception']['data']['r_internal_windows_clean']['value']=="internal windows including frames and sills are not clean") echo "checked";?>>
<label for="r_internal_windows_clean2">No</label>


<input type="radio" name="reception[r_internal_windows_clean]" value="N/A" id="r_internal_windows_clean3" <?php if($htmldata['reception']['data']['r_internal_windows_clean']['value']=="N/A") echo "checked";?>>
<label for="r_internal_windows_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_internal_windows_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_internal_windows_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="internal windows including frames and sills are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">12.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Internal glass dividing panels/ windows for visible sign of damage, cracks
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_internal_windows_damage_question]" value="Internal glass dividing panels/ windows for visible sign of damage, cracks">
<input type="radio" name="reception[r_internal_windows_damage]" value="yes" id="r_internal_windows_damage" <?php if($htmldata['reception']['data']['r_internal_windows_damage']['value']=="yes") echo "checked";?>>
<label for="r_internal_windows_damage">Yes</label>
<input type="radio" name="reception[r_internal_windows_damage]" value="internal windows including frames and sills are not good state of repair" id="r_internal_windows_damage2" <?php if($htmldata['reception']['data']['r_internal_windows_damage']['value']=="internal windows including frames and sills are not good state of repair") echo "checked";?>>
<label for="r_internal_windows_damage2">No</label>


<input type="radio" name="reception[r_internal_windows_damage]" value="N/A" id="r_internal_windows_damage3" <?php if($htmldata['reception']['data']['r_internal_windows_damage']['value']=="N/A") echo "checked";?>>
<label for="r_internal_windows_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_internal_windows_damage_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_internal_windows_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="internal windows including frames and sills are not good state of repair" >
                             
                        </div>

                    </div> 
                    <hr>
<h5><span class="audit_txt">13. Window curtains/ blinds are clean and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[r_curtains_main_question]" value="Window curtains/ blinds are clean and in a good state of repair?">
<div class="question">
                        <div class="numb">13.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_curtains_clean_question]" value="Visibly clean">
<input type="radio" name="reception[r_curtains_clean]" value="yes" id="r_curtains_clean" <?php if($htmldata['reception']['data']['r_curtains_clean']['value']=="yes") echo "checked";?>>
<label for="r_curtains_clean">Yes</label>
<input type="radio" name="reception[r_curtains_clean]" value="Window curtains/ blinds are not clean" id="r_curtains_clean2" <?php if($htmldata['reception']['data']['r_curtains_clean']['value']=="Window curtains/ blinds are not clean") echo "checked";?>>
<label for="r_curtains_clean2">No</label>


<input type="radio" name="reception[r_curtains_clean]" value="N/A" id="r_curtains_clean3" <?php if($htmldata['reception']['data']['r_curtains_clean']['value']=="N/A") echo "checked";?>>
<label for="r_curtains_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_curtains_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_curtains_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Window curtains/ blinds are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">13.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage, wear and tear, no rips
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_curtains_damage_question]" value="No visible sign of damage, wear and tear, no rips">
<input type="radio" name="reception[r_curtains_damage]" value="yes" id="r_curtains_damage" <?php if($htmldata['reception']['data']['r_curtains_damage']['value']=="yes") echo "checked";?>>
<label for="r_curtains_damage">Yes</label>
<input type="radio" name="reception[r_curtains_damage]" value="Window curtains/ blinds are not good state of repair" id="r_curtains_damage2" <?php if($htmldata['reception']['data']['r_curtains_damage']['value']=="Window curtains/ blinds are not good state of repair") echo "checked";?>>
<label for="r_curtains_damage2">No</label>


<input type="radio" name="reception[r_curtains_damage]" value="N/A" id="r_curtains_damage3" <?php if($htmldata['reception']['data']['r_curtains_damage']['value']=="N/A") echo "checked";?>>
<label for="r_curtains_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_curtains_damage_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_curtains_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Window curtains/ blinds are not good state of repair" >
                             
                        </div>

                    </div> 
                    <hr>
<h5><span class="audit_txt">14. Desktops/ tables are clean, in a good state of repair, uncluttered, made from impermeable material?<span></h5><br>
<input type="hidden" name="form[r_desktops_main_question]" value="Desktops/ tables are clean, in a good state of repair, uncluttered, made from impermeable material?">
<div class="question">
                        <div class="numb">14.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_desktops_clean_question]" value="Visibly clean">
<input type="radio" name="reception[r_desktops_clean]" value="yes" id="r_desktops_clean" <?php if($htmldata['reception']['data']['r_desktops_clean']['value']=="yes") echo "checked";?>>
<label for="r_desktops_clean">Yes</label>
<input type="radio" name="reception[r_desktops_clean]" value="Desktops and tables are not clean" id="r_desktops_clean2" <?php if($htmldata['reception']['data']['r_desktops_clean']['value']=="Desktops and tables are not clean") echo "checked";?>>
<label for="r_desktops_clean2">No</label>


<input type="radio" name="reception[r_desktops_clean]" value="N/A" id="r_desktops_clean3" <?php if($htmldata['reception']['data']['r_desktops_clean']['value']=="N/A") echo "checked";?>>
<label for="r_desktops_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_desktops_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_desktops_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Desktops and tables are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">14.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage, exposed wood
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_desktops_damage_question]" value="No visible sign of damage, exposed wood">
<input type="radio" name="reception[r_desktops_damage]" value="yes" id="r_desktops_damage" <?php if($htmldata['reception']['data']['r_desktops_damage']['value']=="yes") echo "checked";?>>
<label for="r_desktops_damage">Yes</label>
<input type="radio" name="reception[r_desktops_damage]" value="Desktops and tables are not good state of repair" id="r_desktops_damage2" <?php if($htmldata['reception']['data']['r_desktops_damage']['value']=="Desktops and tables are not good state of repair") echo "checked";?>>
<label for="r_desktops_damage2">No</label>


<input type="radio" name="reception[r_desktops_damage]" value="N/A" id="r_desktops_damage3" <?php if($htmldata['reception']['data']['r_desktops_damage']['value']=="N/A") echo "checked";?>>
<label for="r_desktops_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_desktops_damage_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_desktops_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Desktops and tables are not good state of repair" >
                             
                        </div>

                    </div> 
  <!-- question -->
                   <div class="question">
                        <div class="numb">14.3</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Clutter free and tidy
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_desktops_clutter_question]" value="Clutter free and tidy">
<input type="radio" name="reception[r_desktops_clutter]" value="yes" id="r_desktops_clutter" <?php if($htmldata['reception']['data']['r_desktops_clutter']['value']=="yes") echo "checked";?>>
<label for="r_desktops_clutter">Yes</label>
<input type="radio" name="reception[r_desktops_clutter]" value="Desktops and tables is cluttered" id="r_desktops_clutter2" <?php if($htmldata['reception']['data']['r_desktops_clutter']['value']=="Desktops and tables is cluttered") echo "checked";?>>
<label for="r_desktops_clutter2">No</label>


<input type="radio" name="reception[r_desktops_clutter]" value="N/A" id="r_desktops_clutter3" <?php if($htmldata['reception']['data']['r_desktops_clutter']['value']=="N/A") echo "checked";?>>
<label for="r_desktops_clutter3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_desktops_clutter_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_desktops_clutter']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Desktops and tables is cluttered" >
                             
                        </div>

                      
                    </div>       
     <!-- question -->
           <div class="question">
                <div class="numb">14.4</div>
                <div class="quest">


<div class="quest-inner">
<div class="q">
Washable and impervious to moisture
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_desktops_impermeable_question]" value="Washable and impervious to moisture">
<input type="radio" name="reception[r_desktops_impermeable]" value="yes" id="r_desktops_impermeable" <?php if($htmldata['reception']['data']['r_desktops_impermeable']['value']=="yes") echo "checked";?>>
<label for="r_desktops_impermeable">Yes</label>
<input type="radio" name="reception[r_desktops_impermeable]" value="Desktops and tables are not made from impermeable material" id="r_desktops_impermeable2" <?php if($htmldata['reception']['data']['r_desktops_impermeable']['value']=="Desktops and tables are not made from impermeable material") echo "checked";?>>
<label for="r_desktops_impermeable2">No</label>


<input type="radio" name="reception[r_desktops_impermeable]" value="N/A" id="r_desktops_impermeable3" <?php if($htmldata['reception']['data']['r_desktops_impermeable']['value']=="N/A") echo "checked";?>>
<label for="r_desktops_impermeable3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_desktops_impermeable_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_desktops_impermeable']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Desktops and tables are not made from impermeable material" >
                             
                        </div>

                    </div>                     
                        <hr> 


<h5><span class="audit_txt">15. High, low and horizontal surfaces are clean, in a good state of repair, uncluttered, made from impermeable material?<span></h5><br>
<input type="hidden" name="form[r_horizontal_surface_main_question]" value="High, low and horizontal surfaces are clean, in a good state of repair, uncluttered, made from impermeable material?">
<div class="question">
                        <div class="numb">15.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_horizontal_surface_clean_question]" value="Visibly clean">
<input type="radio" name="reception[r_horizontal_surface_clean]" value="yes" id="r_horizontal_surface_clean" <?php if($htmldata['reception']['data']['r_horizontal_surface_clean']['value']=="yes") echo "checked";?>>
<label for="r_horizontal_surface_clean">Yes</label>
<input type="radio" name="reception[r_horizontal_surface_clean]" value="High, low and horizontal surfaces are not clean" id="r_horizontal_surface_clean2" <?php if($htmldata['reception']['data']['r_horizontal_surface_clean']['value']=="High, low and horizontal surfaces are not clean") echo "checked";?>>
<label for="r_horizontal_surface_clean2">No</label>


<input type="radio" name="reception[r_horizontal_surface_clean]" value="N/A" id="r_horizontal_surface_clean3" <?php if($htmldata['reception']['data']['r_horizontal_surface_clean']['value']=="N/A") echo "checked";?>>
<label for="r_horizontal_surface_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_horizontal_surface_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_horizontal_surface_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="High, low and horizontal surfaces are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">15.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage, exposed wood
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_horizontal_surface_damage_question]" value="No visible sign of damage, exposed wood">
<input type="radio" name="reception[r_horizontal_surface_damage]" value="yes" id="r_horizontal_surface_damage" <?php if($htmldata['reception']['data']['r_horizontal_surface_damage']['value']=="yes") echo "checked";?>>
<label for="r_horizontal_surface_damage">Yes</label>
<input type="radio" name="reception[r_horizontal_surface_damage]" value="High, low and horizontal surfaces are not good state of repair" id="r_horizontal_surface_damage2" <?php if($htmldata['reception']['data']['r_horizontal_surface_damage']['value']=="High, low and horizontal surfaces are not good state of repair") echo "checked";?>>
<label for="r_horizontal_surface_damage2">No</label>


<input type="radio" name="reception[r_horizontal_surface_damage]" value="N/A" id="r_horizontal_surface_damage3" <?php if($htmldata['reception']['data']['r_horizontal_surface_damage']['value']=="N/A") echo "checked";?>>
<label for="r_horizontal_surface_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_horizontal_surface_damage_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_horizontal_surface_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="High, low and horizontal surfaces are not good state of repair" >
                             
                        </div>

                    </div> 
  <!-- question -->
                   <div class="question">
                        <div class="numb">15.3</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Clutter free and tidy
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_horizontal_surface_clutter_question]" value="Clutter free and tidy">
<input type="radio" name="reception[r_horizontal_surface_clutter]" value="yes" id="r_horizontal_surface_clutter" <?php if($htmldata['reception']['data']['r_horizontal_surface_clutter']['value']=="yes") echo "checked";?>>
<label for="r_horizontal_surface_clutter">Yes</label>
<input type="radio" name="reception[r_horizontal_surface_clutter]" value="High, low and horizontal surfaces is cluttered" id="r_horizontal_surface_clutter2" <?php if($htmldata['reception']['data']['r_horizontal_surface_clutter']['value']=="High, low and horizontal surfaces is cluttered") echo "checked";?>>
<label for="r_horizontal_surface_clutter2">No</label>


<input type="radio" name="reception[r_horizontal_surface_clutter]" value="N/A" id="r_horizontal_surface_clutter3" <?php if($htmldata['reception']['data']['r_horizontal_surface_clutter']['value']=="N/A") echo "checked";?>>
<label for="r_horizontal_surface_clutter3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_horizontal_surface_clutter_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_horizontal_surface_clutter']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="High, low and horizontal surfaces is cluttered" >
                             
                        </div>

                      
                    </div>       
     <!-- question -->
           <div class="question">
                <div class="numb">15.4</div>
                <div class="quest">


<div class="quest-inner">
<div class="q">
Washable and impervious to moisture
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_horizontal_surface_impermeable_question]" value="Washable and impervious to moisture">
<input type="radio" name="reception[r_horizontal_surface_impermeable]" value="yes" id="r_horizontal_surface_impermeable" <?php if($htmldata['reception']['data']['r_horizontal_surface_impermeable']['value']=="yes") echo "checked";?>>
<label for="r_horizontal_surface_impermeable">Yes</label>
<input type="radio" name="reception[r_horizontal_surface_impermeable]" value="High, low and horizontal surfaces are not made from impermeable material" id="r_horizontal_surface_impermeable2" <?php if($htmldata['reception']['data']['r_horizontal_surface_impermeable']['value']=="High, low and horizontal surfaces are not made from impermeable material") echo "checked";?>>
<label for="r_horizontal_surface_impermeable2">No</label>


<input type="radio" name="reception[r_horizontal_surface_impermeable]" value="N/A" id="r_horizontal_surface_impermeable3" <?php if($htmldata['reception']['data']['r_horizontal_surface_impermeable']['value']=="N/A") echo "checked";?>>
<label for="r_horizontal_surface_impermeable3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_horizontal_surface_impermeable_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_horizontal_surface_impermeable']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="High, low and horizontal surfaces are not made from impermeable material" >
                             
                        </div>

                    </div>                     
                        <hr>

<h5><span class="audit_txt">16. Air vents are clean?<span></h5><br>
<input type="hidden" name="form[r_vents_main_question]" value=" Air vents are clean?">
<div class="question">
                        <div class="numb">16.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean and free from excessive dust, damage
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_vents_clean_question]" value="Visibly clean and free from excessive dust, damage">
<input type="radio" name="reception[r_vents_clean]" value="yes" id="r_vents_clean" <?php if($htmldata['reception']['data']['r_vents_clean']['value']=="yes") echo "checked";?>>
<label for="r_vents_clean">Yes</label>
<input type="radio" name="reception[r_vents_clean]" value="Air vents are not clean" id="r_vents_clean2" <?php if($htmldata['reception']['data']['r_vents_clean']['value']=="Air vents are not clean") echo "checked";?>>
<label for="r_vents_clean2">No</label>


<input type="radio" name="reception[r_vents_clean]" value="N/A" id="r_vents_clean3" <?php if($htmldata['reception']['data']['r_vents_clean']['value']=="N/A") echo "checked";?>>
<label for="r_vents_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_vents_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_vents_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Air vents are not clean" >
                             
                        </div>

                      
                    </div>  
                    <hr>             
<h5><span class="audit_txt">17. Chairs/ stools are clean, in a good state of repair, made from impermeable material?<span></h5><br>
<input type="hidden" name="form[r_chairs_main_question]" value="Chairs/ stools are clean, in a good state of repair, made from impermeable material?">
<div class="question">
                        <div class="numb">17.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_chairs_clean_question]" value="Visibly clean">
<input type="radio" name="reception[r_chairs_clean]" value="yes" id="r_chairs_clean" <?php if($htmldata['reception']['data']['r_chairs_clean']['value']=="yes") echo "checked";?>>
<label for="r_chairs_clean">Yes</label>
<input type="radio" name="reception[r_chairs_clean]" value="Chairs and stools are not clean" id="r_chairs_clean2" <?php if($htmldata['reception']['data']['r_chairs_clean']['value']=="Chairs and stools are not clean") echo "checked";?>>
<label for="r_chairs_clean2">No</label>


<input type="radio" name="reception[r_chairs_clean]" value="N/A" id="r_chairs_clean3" <?php if($htmldata['reception']['data']['r_chairs_clean']['value']=="N/A") echo "checked";?>>
<label for="r_chairs_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_chairs_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_chairs_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Chairs and stools are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">17.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 No visible signs of damage, rips, worn unsealed surfaces
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_chairs_damage_question]" value="No visible signs of damage, rips, worn unsealed surfaces">
<input type="radio" name="reception[r_chairs_damage]" value="yes" id="r_chairs_damage" <?php if($htmldata['reception']['data']['r_chairs_damage']['value']=="yes") echo "checked";?>>
<label for="r_chairs_damage">Yes</label>
<input type="radio" name="reception[r_chairs_damage]" value="Chairs and stools are not good state of repair" id="r_chairs_damage2" <?php if($htmldata['reception']['data']['r_chairs_damage']['value']=="Chairs and stools are not good state of repair") echo "checked";?>>
<label for="r_chairs_damage2">No</label>


<input type="radio" name="reception[r_chairs_damage]" value="N/A" id="r_chairs_damage3" <?php if($htmldata['reception']['data']['r_chairs_damage']['value']=="N/A") echo "checked";?>>
<label for="r_chairs_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_chairs_damage_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_chairs_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Chairs and stools are not good state of repair" >
                             
                        </div>

                    </div> 
     <!-- question -->
           <div class="question">
                <div class="numb">17.3</div>
                <div class="quest">


<div class="quest-inner">
<div class="q">
Washable and impervious to moisture
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_chairs_impermeable_question]" value="Washable and impervious to moisture">
<input type="radio" name="reception[r_chairs_impermeable]" value="yes" id="r_chairs_impermeable" <?php if($htmldata['reception']['data']['r_chairs_impermeable']['value']=="yes") echo "checked";?>>
<label for="r_chairs_impermeable">Yes</label>
<input type="radio" name="reception[r_chairs_impermeable]" value="Chairs and stools are not made from impermeable material" id="r_chairs_impermeable2" <?php if($htmldata['reception']['data']['r_chairs_impermeable']['value']=="Chairs and stools are not made from impermeable material") echo "checked";?>>
<label for="r_chairs_impermeable2">No</label>


<input type="radio" name="reception[r_chairs_impermeable]" value="N/A" id="r_chairs_impermeable3" <?php if($htmldata['reception']['data']['r_chairs_impermeable']['value']=="N/A") echo "checked";?>>
<label for="r_chairs_impermeable3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_chairs_impermeable_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_chairs_impermeable']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Chairs and stools are not made from impermeable material" >
                             
                        </div>

                    </div>                     
                        <hr> 


<h5><span class="audit_txt">18. Televisions are clean?<span></h5><br>
<input type="hidden" name="form[r_televisions_main_question]" value=" Televisions are clean?">
<div class="question">
                        <div class="numb">18.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean and free from excessive dust, damage
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_televisions_clean_question]" value="Visibly clean and free from excessive dust, damage">
<input type="radio" name="reception[r_televisions_clean]" value="yes" id="r_televisions_clean" <?php if($htmldata['reception']['data']['r_televisions_clean']['value']=="yes") echo "checked";?>>
<label for="r_televisions_clean">Yes</label>
<input type="radio" name="reception[r_televisions_clean]" value="Televisions are not clean" id="r_televisions_clean2" <?php if($htmldata['reception']['data']['r_televisions_clean']['value']=="Televisions are not clean") echo "checked";?>>
<label for="r_televisions_clean2">No</label>


<input type="radio" name="reception[r_televisions_clean]" value="N/A" id="r_televisions_clean3" <?php if($htmldata['reception']['data']['r_televisions_clean']['value']=="N/A") echo "checked";?>>
<label for="r_televisions_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_televisions_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_televisions_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Televisions are not clean" >
                             
                        </div>

                      
                    </div>  
                    <hr>

<h5><span class="audit_txt">19. Display/ computer screens are clean?<span></h5><br>
<input type="hidden" name="form[r_computer_main_question]" value="Display/ computer screens are clean?">
<div class="question">
                        <div class="numb">19.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_computer_clean_question]" value="Visibly clean">
<input type="radio" name="reception[r_computer_clean]" value="yes" id="r_computer_clean" <?php if($htmldata['reception']['data']['r_computer_clean']['value']=="yes") echo "checked";?>>
<label for="r_computer_clean">Yes</label>
<input type="radio" name="reception[r_computer_clean]" value="Display and computer screens are not clean" id="r_computer_clean2" <?php if($htmldata['reception']['data']['r_computer_clean']['value']=="Display and computer are not clean") echo "checked";?>>
<label for="r_computer_clean2">No</label>


<input type="radio" name="reception[r_computer_clean]" value="N/A" id="r_computer_clean3" <?php if($htmldata['reception']['data']['r_computer_clean']['value']=="N/A") echo "checked";?>>
<label for="r_computer_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_computer_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_computer_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Display and computer are not clean" >
                             
                        </div>

                      
                    </div> 
<div class="question">
                        <div class="numb">19.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Free from paper labels and adhesive tape
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_computer_papers_question]" value="Free from paper labels and adhesive tape">
<input type="radio" name="reception[r_computer_papers]" value="yes" id="r_computer_papers" <?php if($htmldata['reception']['data']['r_computer_papers']['value']=="yes") echo "checked";?>>
<label for="r_computer_papers">Yes</label>
<input type="radio" name="reception[r_computer_papers]" value="Display and computer are not free from paper labels and adhesive tape" id="r_computer_papers2" <?php if($htmldata['reception']['data']['r_computer_papers']['value']=="Display and computer are not free from paper labels and adhesive tape") echo "checked";?>>
<label for="r_computer_papers2">No</label>


<input type="radio" name="reception[r_computer_papers]" value="N/A" id="r_computer_papers3" <?php if($htmldata['reception']['data']['r_computer_papers']['value']=="N/A") echo "checked";?>>
<label for="r_computer_papers3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_computer_papers_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_computer_papers']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Display and computer are not free from paper labels and adhesive tape" >
                             
                        </div>

                      
                    </div>   
                    <hr>   

<h5><span class="audit_txt">20. Telephones are clean including public phone?<span></h5><br>
<input type="hidden" name="form[r_telephones_main_question]" value="Telephones are clean including public phone?">
<div class="question">
                        <div class="numb">20.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_telephones_clean_question]" value="Visibly clean">
<input type="radio" name="reception[r_telephones_clean]" value="yes" id="r_telephones_clean" <?php if($htmldata['reception']['data']['r_telephones_clean']['value']=="yes") echo "checked";?>>
<label for="r_telephones_clean">Yes</label>
<input type="radio" name="reception[r_telephones_clean]" value="Telephones and public phone are not clean" id="r_telephones_clean2" <?php if($htmldata['reception']['data']['r_telephones_clean']['value']=="Telephones and public phone are not clean") echo "checked";?>>
<label for="r_telephones_clean2">No</label>


<input type="radio" name="reception[r_telephones_clean]" value="N/A" id="r_telephones_clean3" <?php if($htmldata['reception']['data']['r_telephones_clean']['value']=="N/A") echo "checked";?>>
<label for="r_telephones_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_telephones_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_telephones_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Telephones and public phone are not clean" >
                             
                        </div>

                      
                    </div> 
<div class="question">
                        <div class="numb">20.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Free from paper labels and adhesive tape
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_telephones_papers_question]" value="Free from paper labels and adhesive tape">
<input type="radio" name="reception[r_telephones_papers]" value="yes" id="r_telephones_papers" <?php if($htmldata['reception']['data']['r_telephones_papers']['value']=="yes") echo "checked";?>>
<label for="r_telephones_papers">Yes</label>
<input type="radio" name="reception[r_telephones_papers]" value="Telephones and public phone are not free from paper labels and adhesive tape" id="r_telephones_papers2" <?php if($htmldata['reception']['data']['r_telephones_papers']['value']=="Telephones and public phone are not free from paper labels and adhesive tape") echo "checked";?>>
<label for="r_telephones_papers2">No</label>


<input type="radio" name="reception[r_telephones_papers]" value="N/A" id="r_telephones_papers3" <?php if($htmldata['reception']['data']['r_telephones_papers']['value']=="N/A") echo "checked";?>>
<label for="r_telephones_papers3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_telephones_papers_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_telephones_papers']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Telephones and public phone are not free from paper labels and adhesive tape" >
                             
                        </div>

                      
                    </div>   
                    <hr> 
<h5><span class="audit_txt">21. Fans are clean?<span></h5><br>
<input type="hidden" name="form[r_fans_main_question]" value="Fans are clean?">
<div class="question">
                        <div class="numb">21.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_fans_clean_question]" value="Visibly clean">
<input type="radio" name="reception[r_fans_clean]" value="yes" id="r_fans_clean" <?php if($htmldata['reception']['data']['r_fans_clean']['value']=="yes") echo "checked";?>>
<label for="r_fans_clean">Yes</label>
<input type="radio" name="reception[r_fans_clean]" value="fans are not clean" id="r_fans_clean2" <?php if($htmldata['reception']['data']['r_fans_clean']['value']=="fans are not clean") echo "checked";?>>
<label for="r_fans_clean2">No</label>


<input type="radio" name="reception[r_fans_clean]" value="N/A" id="r_fans_clean3" <?php if($htmldata['reception']['data']['r_fans_clean']['value']=="N/A") echo "checked";?>>
<label for="r_fans_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_fans_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_fans_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="fans are not clean" >
                             
                        </div>

                      
                    </div>  
                    <hr>

<h5><span class="audit_txt">22. Ceilings are clean and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[r_ceilings_main_question]" value="Ceilings are clean and in a good state of repair?">
<div class="question">
                        <div class="numb">22.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_ceilings_clean_question]" value="Visibly clean">
<input type="radio" name="reception[r_ceilings_clean]" value="yes" id="r_ceilings_clean" <?php if($htmldata['reception']['data']['r_ceilings_clean']['value']=="yes") echo "checked";?>>
<label for="r_ceilings_clean">Yes</label>
<input type="radio" name="reception[r_ceilings_clean]" value="ceilings are not clean" id="r_ceilings_clean2" <?php if($htmldata['reception']['data']['r_ceilings_clean']['value']=="ceilings are not clean") echo "checked";?>>
<label for="r_ceilings_clean2">No</label>


<input type="radio" name="reception[r_ceilings_clean]" value="N/A" id="r_ceilings_clean3" <?php if($htmldata['reception']['data']['r_ceilings_clean']['value']=="N/A") echo "checked";?>>
<label for="r_ceilings_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_ceilings_clean_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_ceilings_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="ceilings are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">22.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 No visible sign of damage, cracks, flaking paint
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_ceilings_damage_question]" value="No visible sign of damage, cracks, flaking paint">
<input type="radio" name="reception[r_ceilings_damage]" value="yes" id="r_ceilings_damage" <?php if($htmldata['reception']['data']['r_ceilings_damage']['value']=="yes") echo "checked";?>>
<label for="r_ceilings_damage">Yes</label>
<input type="radio" name="reception[r_ceilings_damage]" value="ceilings are not good state of repair" id="r_ceilings_damage2" <?php if($htmldata['reception']['data']['r_ceilings_damage']['value']=="ceilings are not good state of repair") echo "checked";?>>
<label for="r_ceilings_damage2">No</label>


<input type="radio" name="reception[r_ceilings_damage]" value="N/A" id="r_ceilings_damage3" <?php if($htmldata['reception']['data']['r_ceilings_damage']['value']=="N/A") echo "checked";?>>
<label for="r_ceilings_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_ceilings_damage_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_ceilings_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="ceilings are not good state of repair" >
                             
                        </div>

                    </div> 
     <!-- question -->
           <div class="question">
                <div class="numb">22.3</div>
                <div class="quest">


<div class="quest-inner">
<div class="q">
Tiles are secure and in place
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[r_ceilings_secure_question]" value="Tiles are secure and in place">
<input type="radio" name="reception[r_ceilings_secure]" value="yes" id="r_ceilings_secure" <?php if($htmldata['reception']['data']['r_ceilings_secure']['value']=="yes") echo "checked";?>>
<label for="r_ceilings_secure">Yes</label>
<input type="radio" name="reception[r_ceilings_secure]" value="Tiles are not secure and in place" id="r_ceilings_secure2" <?php if($htmldata['reception']['data']['r_ceilings_secure']['value']=="Tiles are not secure and in place") echo "checked";?>>
<label for="r_ceilings_secure2">No</label>


<input type="radio" name="reception[r_ceilings_secure]" value="N/A" id="r_ceilings_secure3" <?php if($htmldata['reception']['data']['r_ceilings_secure']['value']=="N/A") echo "checked";?>>
<label for="r_ceilings_secure3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[r_ceilings_secure_comment]" class="form-control"><?php echo $htmldata['reception']['data']['r_ceilings_secure']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Tiles are not secure and in place" >
                             
                        </div>

                    </div>                     
                        <hr> 



                </div>
                <!-- quest-box -->
       





                    
              
               <input class="submit_class" type="submit" value="Submit">
              
               
            </form>
           </div>




 <div id="tabs-2">
    <form method="post" action="kitchen_cleanliness_audit_reports" enctype="multipart/form-data">
                 <?php
                   $check = $functions->selectAllPracticeData($_SESSION['currentUser']);
                    $fchk = false; ?>
                 <h3 style="padding-bottom: 22px;font-weight: 800;"> Practice Detail </h3> <br>
                    <div class="contact_right req">
                   <div class="form_1_">
                              
                                 <?php
                                 if (isset($_GET['editId'])) {
                                    $user1 = intval($_SESSION['webUser']['id']);    
                                    @$id =  $_GET['editId'];
                                    $sql  = "SELECT * FROM mock_inspection_report WHERE id = '$id'";
                                    $data = $dbF->getRow($sql);  
                                    // $pid=$data['pid'];
                                    $htmldata=json_decode($data['all_html'],true); 
                                    if($_SESSION['currentUser']!=$data['pid']){
                                        header('Location: login');
                                    }
                                    ?>
                                    <input type="hidden" name="old_id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="pid" value="<?php echo $user1; ?>">
                                   <div class="form_1_side_">Name of the practice</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[name-of-practice]" placeholder="Name of the practice" value="<?php echo $data[name_of_practice];?>" >
                                    </div>
                                    <div class="form_1_side_">Name of the practice manager</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[name-of-practice-manager]" placeholder="Name of the practice manager" value="<?php echo $data[name_of_practice_manager];?>" >
                                    </div>
                                    <div class="form_1_side_">Audit carried out by:</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[audit_carried_out_by]"  placeholder="Audit carried out by" value="<?php echo $data[audit_carried_out_by];?>">
                                    </div>
                                    
                                    <div class="form_1_side_"> Date</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" class="datepickerr" name="form[Date]" placeholder="Date" value="<?php echo $data[date];?>">
                                    </div>
                                    <?php
                                   }
                                   else{
                                        $user1 = intval($_SESSION['currentUser']);
                                  ?>

                                <input type="hidden" name="pid" value="<?php echo $user1; ?>">
                                <input type="hidden" name="form[cleanliness_type]" value="Kitchen" > 
                                    
                                        <input type="hidden" name="form[name-of-practice]" value="<?php echo $check[1] ?>" >
                                    
                                
                                        <input type="hidden" value="<?php echo $check[2] ?>" name="form[name-of-practice-manager]">
                                
                                    <div class="form_1_side_">Audit carried out by: </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[audit_carried_out_by]" value="" placeholder="Audit carried out by" >
                                    </div>
                                    
                                    <div class="form_1_side_">Date</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" class="datepickerr" value="<?php echo date('Y-m-d') ?>" name="form[Date]" placeholder="Date" >
                                    </div>
                                   

<?php
                                   } ?>
                                   <!--  <div class="form_1_side_"></div>
                                    <div class="form_2_side_">
                                        <div id="recaptcha2"></div>
                                    </div> -->
                                   
                                  
                              
                            </div>
                        </div>

                   
                    <hr>
                <div class="quest-box">
                    <div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAABHNCSVQICAgIfAhkiAAABN5JREFUWEflmFtoHGUUx883m7i72d3MqhVBxKY01BvG1IdQ3dmoiCLipaFQsxNvkD4VLAoiCorgixVfSkARo77UzEbEaq0PasG22Wn0oTT1iuCtUosKXmayuew22Tn+v0lnnaabnc00DQluHjI7833n+33/c75zzo6gFf4RK5yPVg9gOm8eWFY1hbCs3kxP0JpVBQHIQYOX9DkzWXo20IOrD5BZ2WnrNz29pGr5jKXzhYNE4mYKraCgx61ebdfqAdxrplKTsWhY4GKiVKb7tKI3f8kVbDXMrxVB14YFhCe/snWt4/8LqOZHb2Pma8IqKJroG3tr5tPzpmBYsIXmLX0MDpl3KSTaGwGF0n/YD2hv1xurGuY2Ieg1pBkRLlHPSzNpo3CchFgbBIjD4OBPl4CtxuHtgp1+VPrLMO9iIcRJ/D/hOM4r433dw+l3j66lU1ODVk67I8ju2ZUkDCDTeCna0tE8M3ldxKHd2FC6urAsoL6Cho387VRoc/FBrRAEJ58HArZKFwtnQz1jlt69S6qmCH55bhzb5IgBmN9j9WWOpfOftTlceQiLbYd7LwUzU4VyQeHQEGAju0wPHe4khcfm2HgfYuveBQ+JYQ5Alkcl5Cw3dU7qm76st0aggmq+sFOw0lXbSOUDqR4C/3epTBCctKG+Zd5PEbodC/dj/Als5opzAqx3SByHn1UUMuHKA1hskuLJy62ejdZCC6rD5vc0S89I16aNEYuEolaYs0U9Cxu1P8EKGuYngpzaCsZTbVQqorFQHmaHDLtP61sQzigYeLbV1rNNckzaczXz+7i3YOMaCBgUg/8pzLdauezBWuOlW0WEhpEnqzCp3WY20kQjONU/oVavD63gYgETxucdCs20+t2Gbr0IuGQ5mmgrbbnhF8+m7OKZnb9svXtNaEA1b74umLbMN4BTCMNau2oUvkMivrIi+J5ib/ZD9yAYhd8EiXcsXduBawPPczi0h6DwLZ6d1HDh7giLfbj/Be53hgas1s4aFlAJhDo08pJQlCfgqv0AdiuDaoygnCmDLGgPMl6PLGvz1fPA8ehNW8/0hwc0Rh5DZdhcy8AMN+9oFjxOVPkZgBURT6zxTrF/Y/7Ycw/Ie2NpLk1IlWNEkXVW7sbjoQGDYtBdcMg8RAp1IwEfw8+FjdUYMwoTTCICZeN+O4CXqSkj7yFU3rBz2rbQgG6pq9PNlGLxvTFF2DQ98SuUTpDD31JLMlMrH7rKTU98jJjscpsLYgXXdSED00xQNwMFTpUvaHFrdbQ8NYb1LsS9WXzdLxzxkaPQj4pD61EKe+DqLIAiciw6mxzGJmWs1lPynAFd1zBNo5u5WqYQeepxKB7xQPyug2qytykDLCbn4Ms0ri/yxuDxi3Yu+5R/TiBgI92MNFghceSM3IfDhfi7U8IArITrUSWeGJCuxyZ+wMJucgbkP8TOk4jJQeluh+m5cV173oMMBGzkkIQZU4U8rX50emoTwmB4PuSyA6rG6AsiGnvVmguHOSV9kLIkuh453UQsO6CbH1l0EWJ2PiQS+0kAtcuQ8FLT2YDYjQzkMG5raI7gJOINHQ3/iRJ3iZxzRkwCrhxtucqr2Svm7Raa3jEckXWlaPJ6f0PhA5RvnZbx477A1GqW0JppZhnRFrVU4BvORVk7D4NXPOC/gCfzRzwZcKQAAAAASUVORK5CYII=); background-repeat: no-repeat; background-position: center;"></div>
                    <h3>Kitchen / Staff Room</h3>
                      <h5><span class="audit_txt">1. The kitchen is clean, uncluttered, fresh smelling, in a good state of repair?<span></h5><br>
                    <input type="hidden" name="form[k_kitchen_main_question]" value=" The kitchen is clean, uncluttered, fresh smelling, in a good state of repair?">
                    <div class="question">
                        <div class="numb">1.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Area is visibly clean</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_kitchen_clean_question]" value="Area is visibly clean">
<input type="radio" name="kitchen[k_kitchen_clean]" value="yes" id="k_kitchen_clean" <?php if($htmldata['kitchen']['data']['k_kitchen_clean']['value']=="yes") echo "checked";?>>
<label for="k_kitchen_clean">Yes</label>
<input type="radio" name="kitchen[k_kitchen_clean]" value="The kitchen are not clean" id="k_kitchen_clean2" <?php if($htmldata['kitchen']['data']['k_kitchen_clean']['value']=="The kitchen are not clean") echo "checked";?>>
<label for="k_kitchen_clean2">No</label>


<input type="radio" name="kitchen[k_kitchen_clean]" value="N/A" id="k_kitchen_clean3" <?php if($htmldata['kitchen']['data']['k_kitchen_clean']['value']=="N/A") echo "checked";?>>
<label for="k_kitchen_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audik_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_kitchen_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_kitchen_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="The kitchen are not clean" >
                             
                        </div>

                    </div>
                    <!-- question -->
                   <div class="question">
                        <div class="numb">1.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
free from clutter
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_kitchen_cluttek_question]" value="free from clutter">
<input type="radio" name="kitchen[k_kitchen_clutter]" value="yes" id="k_kitchen_clutter" <?php if($htmldata['kitchen']['data']['k_kitchen_clutter']['value']=="yes") echo "checked";?>>
<label for="k_kitchen_clutter">Yes</label>
<input type="radio" name="kitchen[k_kitchen_clutter]" value="The kitchen are cluttered" id="k_kitchen_clutter2" <?php if($htmldata['kitchen']['data']['k_kitchen_clutter']['value']=="The kitchen are cluttered") echo "checked";?>>
<label for="k_kitchen_clutter2">No</label>


<input type="radio" name="kitchen[k_kitchen_clutter]" value="N/A" id="k_kitchen_clutter3" <?php if($htmldata['kitchen']['data']['k_kitchen_clutter']['value']=="N/A") echo "checked";?>>
<label for="k_kitchen_clutter3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audik_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_kitchen_cluttek_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_kitchen_clutter']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="The kitchen are cluttered" >
                             
                        </div>

                      
                    </div>               
                 
 <!-- question -->
                   <div class="question">
                        <div class="numb">1.3</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No foul or stale odours are present
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_kitchen_fresh_smell_question]" value="No foul or stale odours are present">
<input type="radio" name="kitchen[k_kitchen_fresh_smell]" value="yes" id="k_kitchen_fresh_smell" <?php if($htmldata['kitchen']['data']['k_kitchen_fresh_smell']['value']=="yes") echo "checked";?>>
<label for="k_kitchen_fresh_smell">Yes</label>
<input type="radio" name="kitchen[k_kitchen_fresh_smell]" value="The kitchen are not fresh smelling" id="k_kitchen_fresh_smell2" <?php if($htmldata['kitchen']['data']['k_kitchen_fresh_smell']['value']=="The kitchen are not fresh smelling") echo "checked";?>>
<label for="k_kitchen_fresh_smell2">No</label>


<input type="radio" name="kitchen[k_kitchen_fresh_smell]" value="N/A" id="k_kitchen_fresh_smell3" <?php if($htmldata['kitchen']['data']['k_kitchen_fresh_smell']['value']=="N/A") echo "checked";?>>
<label for="k_kitchen_fresh_smell3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audik_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_kitchen_fresh_smell_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_kitchen_fresh_smell']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="The kitchen are not fresh smelling" >
                             
                        </div>

                    </div>                     
                        <hr>
<h5><span class="audit_txt">2. Walls are clean and in a good state of repair?<span></h5><br>
    <input type="hidden" name="form[k_walls_main_question]" value="Walls are clean and in a good state of repair?">
<div class="question">
                        <div class="numb">2.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 Visibly clean, no obvious signs of splashes, stains, dust, sticky tape etc
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_walls_clean_question]" value="Visibly clean, no obvious signs of splashes, stains, dust, sticky tape etc">
<input type="radio" name="kitchen[k_walls_clean]" value="yes" id="k_walls_clean" <?php if($htmldata['kitchen']['data']['k_walls_clean']['value']=="yes") echo "checked";?>>
<label for="k_walls_clean">Yes</label>
<input type="radio" name="kitchen[k_walls_clean]" value="Walls are not clean" id="k_walls_clean2" <?php if($htmldata['kitchen']['data']['k_walls_clean']['value']=="Walls are not clean") echo "checked";?>>
<label for="k_walls_clean2">No</label>


<input type="radio" name="kitchen[k_walls_clean]" value="N/A" id="k_walls_clean3" <?php if($htmldata['kitchen']['data']['k_walls_clean']['value']=="N/A") echo "checked";?>>
<label for="k_walls_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_walls_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_walls_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Walls are not clean" >
                             
                        </div>

                      
                    </div>               
                 
 <!-- question -->
                   <div class="question">
                        <div class="numb">2.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Free from visible damage i.e. chipped flaky paintwork, holes, cracks, unfinished surfaces, sticky tape
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_walls_damage_question]" value="Free from visible damage i.e. chipped flaky paintwork, holes, cracks, unfinished surfaces, sticky tape">
<input type="radio" name="kitchen[k_walls_damage]" value="yes" id="k_walls_damage" <?php if($htmldata['kitchen']['data']['k_walls_damage']['value']=="yes") echo "checked";?>>
<label for="k_walls_damage">Yes</label>
<input type="radio" name="kitchen[k_walls_damage]" value="Walls are not good state of repair" id="k_walls_damage2" <?php if($htmldata['kitchen']['data']['k_walls_damage']['value']=="Walls are not good state of repair") echo "checked";?>>
<label for="k_walls_damage2">No</label>


<input type="radio" name="kitchen[k_walls_damage]" value="N/A" id="k_walls_damage3" <?php if($htmldata['kitchen']['data']['k_walls_damage']['value']=="N/A") echo "checked";?>>
<label for="k_walls_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_walls_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_walls_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Walls are not good state of repair" >
                             
                        </div>

                    </div>                     
                        <hr>                        

<h5><span class="audit_txt">3. Skirting is clean and in a good state of repair?<span></h5><br>
<div class="question">
                        <div class="numb">3.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 Visibly clean, no obvious signs of splashes, stains, dust
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_skirting_clean_question]" value="Visibly clean, no obvious signs of splashes, stains, dust, sticky tape etc">
<input type="radio" name="kitchen[k_skirting_clean]" value="yes" id="k_skirting_clean" <?php if($htmldata['kitchen']['data']['k_skirting_clean']['value']=="yes") echo "checked";?>>
<label for="k_skirting_clean">Yes</label>
<input type="radio" name="kitchen[k_skirting_clean]" value="skirting are not clean" id="k_skirting_clean2" <?php if($htmldata['kitchen']['data']['k_skirting_clean']['value']=="skirting are not clean") echo "checked";?>>
<label for="k_skirting_clean2">No</label>


<input type="radio" name="kitchen[k_skirting_clean]" value="N/A" id="k_skirting_clean3" <?php if($htmldata['kitchen']['data']['k_skirting_clean']['value']=="N/A") echo "checked";?>>
<label for="k_skirting_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_skirting_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_skirting_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="skirting are not clean" >
                             
                        </div>

                      
                    </div>               
                 
 <!-- question -->
                   <div class="question">
                        <div class="numb">3.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Free from visible damage i.e. chipped flaky paintwork, holes, cracks, unfinished surfaces, sticky tape
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_skirting_damage_question]" value="Free from visible damage i.e. chipped flaky paintwork, holes, cracks, unfinished surfaces, sticky tape">
<input type="radio" name="kitchen[k_skirting_damage]" value="yes" id="k_skirting_damage" <?php if($htmldata['kitchen']['data']['k_skirting_damage']['value']=="yes") echo "checked";?>>
<label for="k_skirting_damage">Yes</label>
<input type="radio" name="kitchen[k_skirting_damage]" value="skirting are not good state of repair" id="k_skirting_damage2" <?php if($htmldata['kitchen']['data']['k_skirting_damage']['value']=="skirting are not good state of repair") echo "checked";?>>
<label for="k_skirting_damage2">No</label>


<input type="radio" name="kitchen[k_skirting_damage]" value="N/A" id="k_skirting_damage3" <?php if($htmldata['kitchen']['data']['k_skirting_damage']['value']=="N/A") echo "checked";?>>
<label for="k_skirting_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_skirting_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_skirting_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="skirting are not good state of repair" >
                             
                        </div>

                    </div> 

                        <hr>
 <h5><span class="audit_txt">4. Lights and fittings are clean and in a good state of repair?<span></h5><br>
<div class="question">
                        <div class="numb">4.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 Visibly clean, free from dust debris and cobwebs
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_lights_and_fittings_clean_question]" value="Visibly clean, free from dust debris and cobwebs">
<input type="radio" name="kitchen[k_lights_and_fittings_clean]" value="yes" id="k_lights_and_fittings_clean" <?php if($htmldata['kitchen']['data']['k_lights_and_fittings_clean']['value']=="yes") echo "checked";?>>
<label for="k_lights_and_fittings_clean">Yes</label>
<input type="radio" name="kitchen[k_lights_and_fittings_clean]" value="Lights and fittings are not clean" id="k_lights_and_fittings_clean2" <?php if($htmldata['kitchen']['data']['k_lights_and_fittings_clean']['value']=="Lights and fittings are not clean") echo "checked";?>>
<label for="k_lights_and_fittings_clean2">No</label>


<input type="radio" name="kitchen[k_lights_and_fittings_clean]" value="N/A" id="k_lights_and_fittings_clean3" <?php if($htmldata['kitchen']['data']['k_lights_and_fittings_clean']['value']=="N/A") echo "checked";?>>
<label for="k_lights_and_fittings_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_lights_and_fittings_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_lights_and_fittings_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Lights and fittings are not clean" >
                             
                        </div>

                      
                    </div>               
                 
 <!-- question -->
                   <div class="question">
                        <div class="numb">4.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Bulbs are in working order and fittings are intact
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_lights_and_fittings_damage_question]" value="Bulbs are in working order and fittings are intact">
<input type="radio" name="kitchen[k_lights_and_fittings_damage]" value="yes" id="k_lights_and_fittings_damage" <?php if($htmldata['kitchen']['data']['k_lights_and_fittings_damage']['value']=="yes") echo "checked";?>>
<label for="k_lights_and_fittings_damage">Yes</label>
<input type="radio" name="kitchen[k_lights_and_fittings_damage]" value="Lights and fittings are not good state of repair" id="k_lights_and_fittings_damage2" <?php if($htmldata['kitchen']['data']['k_lights_and_fittings_damage']['value']=="Lights and fittings are not good state of repair") echo "checked";?>>
<label for="k_lights_and_fittings_damage2">No</label>


<input type="radio" name="kitchen[k_lights_and_fittings_damage]" value="N/A" id="k_lights_and_fittings_damage3" <?php if($htmldata['kitchen']['data']['k_lights_and_fittings_damage']['value']=="N/A") echo "checked";?>>
<label for="k_lights_and_fittings_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_lights_and_fittings_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_lights_and_fittings_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Lights and fittings are not good state of repair" >
                             
                        </div>

                    </div>                     
                        <hr> 

<h5><span class="audit_txt">5. Light switches/pull cords are clean and in a good state of repair?<span></h5><br>
<div class="question">
                        <div class="numb">5.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 Visibly clean especially around touch points
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_lights_switches_clean_question]" value="Visibly clean especially around touch points">
<input type="radio" name="kitchen[k_lights_switches_clean]" value="yes" id="k_lights_switches_clean" <?php if($htmldata['kitchen']['data']['k_lights_switches_clean']['value']=="yes") echo "checked";?>>
<label for="k_lights_switches_clean">Yes</label>
<input type="radio" name="kitchen[k_lights_switches_clean]" value="Light switches and pull cords are not clean" id="k_lights_switches_clean2" <?php if($htmldata['kitchen']['data']['k_lights_switches_clean']['value']=="Light switches and pull cords are not clean") echo "checked";?>>
<label for="k_lights_switches_clean2">No</label>


<input type="radio" name="kitchen[k_lights_switches_clean]" value="N/A" id="k_lights_switches_clean3" <?php if($htmldata['kitchen']['data']['k_lights_switches_clean']['value']=="N/A") echo "checked";?>>
<label for="k_lights_switches_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_lights_switches_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_lights_switches_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Light switches and pull cords are not clean" >
                             
                        </div>

                      
                    </div>               
                 
 <!-- question -->
                   <div class="question">
                        <div class="numb">5.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_lights_switches_damage_question]" value="No visible sign of damage">
<input type="radio" name="kitchen[k_lights_switches_damage]" value="yes" id="k_lights_switches_damage" <?php if($htmldata['kitchen']['data']['k_lights_switches_damage']['value']=="yes") echo "checked";?>>
<label for="k_lights_switches_damage">Yes</label>
<input type="radio" name="kitchen[k_lights_switches_damage]" value="Light switches/ pull cords are not good state of repair" id="k_lights_switches_damage2" <?php if($htmldata['kitchen']['data']['k_lights_switches_damage']['value']=="Light switches/ pull cords are not good state of repair") echo "checked";?>>
<label for="k_lights_switches_damage2">No</label>


<input type="radio" name="kitchen[k_lights_switches_damage]" value="N/A" id="k_lights_switches_damage3" <?php if($htmldata['kitchen']['data']['k_lights_switches_damage']['value']=="N/A") echo "checked";?>>
<label for="k_lights_switches_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_lights_switches_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_lights_switches_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Light switches/ pull cords are not good state of repair" >
                             
                        </div>

                    </div>                     
                        <hr> 
<h5><span class="audit_txt">6. Radiators are clean and in a good state of repair?<span></h5><br>
<div class="question">
                        <div class="numb">6.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 Visibly clean, check top and behind for a build up of dust
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_radiators_clean_question]" value="Visibly clean, check top and behind for a build up of dust">
<input type="radio" name="kitchen[k_radiators_clean]" value="yes" id="k_radiators_clean" <?php if($htmldata['kitchen']['data']['k_radiators_clean']['value']=="yes") echo "checked";?>>
<label for="k_radiators_clean">Yes</label>
<input type="radio" name="kitchen[k_radiators_clean]" value=" Radiators are not clean" id="k_radiators_clean2" <?php if($htmldata['kitchen']['data']['k_radiators_clean']['value']==" Radiators are not clean") echo "checked";?>>
<label for="k_radiators_clean2">No</label>


<input type="radio" name="kitchen[k_radiators_clean]" value="N/A" id="k_radiators_clean3" <?php if($htmldata['kitchen']['data']['k_radiators_clean']['value']=="N/A") echo "checked";?>>
<label for="k_radiators_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_radiators_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_radiators_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value=" Radiators are not clean" >
                             
                        </div>

                      
                    </div>               
                 
 <!-- question -->
                   <div class="question">
                        <div class="numb">6.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage or rust
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_radiators_damage_question]" value="No visible sign of damage or rust">
<input type="radio" name="kitchen[k_radiators_damage]" value="yes" id="k_radiators_damage" <?php if($htmldata['kitchen']['data']['k_radiators_damage']['value']=="yes") echo "checked";?>>
<label for="k_radiators_damage">Yes</label>
<input type="radio" name="kitchen[k_radiators_damage]" value=" Radiators are not good state of repair" id="k_radiators_damage2" <?php if($htmldata['kitchen']['data']['k_radiators_damage']['value']==" Radiators are not good state of repair") echo "checked";?>>
<label for="k_radiators_damage2">No</label>


<input type="radio" name="kitchen[k_radiators_damage]" value="N/A" id="k_radiators_damage3" <?php if($htmldata['kitchen']['data']['k_radiators_damage']['value']=="N/A") echo "checked";?>>
<label for="k_radiators_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_radiators_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_radiators_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value=" Radiators are not good state of repair" >
                             
                        </div>

                    </div>                     
                        <hr> 

<h5><span class="audit_txt">7. Notice boards are clean, tidy and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[k_notice_board_main_question]" value="Notice boards are clean, tidy and in a good state of repair?">
<div class="question">
                        <div class="numb">7.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Notice boards are clean, no adhesive tape
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_notice_board_clean_question]" value="Notice boards are clean, no adhesive tape">
<input type="radio" name="kitchen[k_notice_board_clean]" value="yes" id="k_notice_board_clean" <?php if($htmldata['kitchen']['data']['k_notice_board_clean']['value']=="yes") echo "checked";?>>
<label for="k_notice_board_clean">Yes</label>
<input type="radio" name="kitchen[k_notice_board_clean]" value="notice board are not clean" id="k_notice_board_clean2" <?php if($htmldata['kitchen']['data']['k_notice_board_clean']['value']=="notice board are not clean") echo "checked";?>>
<label for="k_notice_board_clean2">No</label>


<input type="radio" name="kitchen[k_notice_board_clean]" value="N/A" id="k_notice_board_clean3" <?php if($htmldata['kitchen']['data']['k_notice_board_clean']['value']=="N/A") echo "checked";?>>
<label for="k_notice_board_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_notice_board_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_notice_board_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="notice board are not clean" >
                             
                        </div>

                      
                    </div>               
               <!-- question -->
           <div class="question">
                <div class="numb">7.2</div>
                <div class="quest">


<div class="quest-inner">
<div class="q">
Notice boards are tidy
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_notice_board_tidy_question]" value="Notice boards are tidy">
<input type="radio" name="kitchen[k_notice_board_tidy]" value="yes" id="k_notice_board_tidy" <?php if($htmldata['kitchen']['data']['k_notice_board_tidy']['value']=="yes") echo "checked";?>>
<label for="k_notice_board_tidy">Yes</label>
<input type="radio" name="kitchen[k_notice_board_tidy]" value="notice_board are not tidy" id="k_notice_board_tidy2" <?php if($htmldata['kitchen']['data']['k_notice_board_tidy']['value']=="notice_board are not tidy") echo "checked";?>>
<label for="k_notice_board_tidy2">No</label>


<input type="radio" name="kitchen[k_notice_board_tidy]" value="N/A" id="k_notice_board_tidy3" <?php if($htmldata['kitchen']['data']['k_notice_board_tidy']['value']=="N/A") echo "checked";?>>
<label for="k_notice_board_tidy3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_notice_board_tidy_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_notice_board_tidy']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="notice_board are not tidy" >
                             
                        </div>

                    </div>         
 <!-- question -->
                   <div class="question">
                        <div class="numb">7.3</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
There are no signs of visible damage
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_notice_board_damage_question]" value="There are no signs of visible damage">
<input type="radio" name="kitchen[k_notice_board_damage]" value="yes" id="k_notice_board_damage" <?php if($htmldata['kitchen']['data']['k_notice_board_damage']['value']=="yes") echo "checked";?>>
<label for="k_notice_board_damage">Yes</label>
<input type="radio" name="kitchen[k_notice_board_damage]" value="notice board are not good state of repair" id="k_notice_board_damage2" <?php if($htmldata['kitchen']['data']['k_notice_board_damage']['value']=="notice board are not good state of repair") echo "checked";?>>
<label for="k_notice_board_damage2">No</label>


<input type="radio" name="kitchen[k_notice_board_damage]" value="N/A" id="k_notice_board_damage3" <?php if($htmldata['kitchen']['data']['k_notice_board_damage']['value']=="N/A") echo "checked";?>>
<label for="k_notice_board_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_notice_board_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_notice_board_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="notice board are not good state of repair" >
                             
                        </div>

                    </div>                     
                        <hr> 
<h5><span class="audit_txt">8. Air vents are clean?<span></h5><br>
<input type="hidden" name="form[k_vents_main_question]" value=" Air vents are clean?">
<div class="question">
                        <div class="numb">8.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean and free from excessive dust
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_vents_clean_question]" value="Visibly clean and free from excessive dust">
<input type="radio" name="kitchen[k_vents_clean]" value="yes" id="k_vents_clean" <?php if($htmldata['kitchen']['data']['k_vents_clean']['value']=="yes") echo "checked";?>>
<label for="k_vents_clean">Yes</label>
<input type="radio" name="kitchen[k_vents_clean]" value="Air vents are not clean" id="k_vents_clean2" <?php if($htmldata['kitchen']['data']['k_vents_clean']['value']=="Air vents are not clean") echo "checked";?>>
<label for="k_vents_clean2">No</label>


<input type="radio" name="kitchen[k_vents_clean]" value="N/A" id="k_vents_clean3" <?php if($htmldata['kitchen']['data']['k_vents_clean']['value']=="N/A") echo "checked";?>>
<label for="k_vents_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_vents_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_vents_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Air vents are not clean" >
                             
                        </div>

                      
                    </div>  
                    <hr>  
<h5><span class="audit_txt">9. High, low and horizontal surfaces are clean, in a good state of repair, uncluttered, made from impermeable material?<span></h5><br>
<input type="hidden" name="form[k_horizontal_surface_main_question]" value="High, low and horizontal surfaces are clean, in a good state of repair, uncluttered, made from impermeable material?">
<div class="question">
                        <div class="numb">9.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean and dust free
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_horizontal_surface_clean_question]" value="Visibly clean and dust free">
<input type="radio" name="kitchen[k_horizontal_surface_clean]" value="yes" id="k_horizontal_surface_clean" <?php if($htmldata['kitchen']['data']['k_horizontal_surface_clean']['value']=="yes") echo "checked";?>>
<label for="k_horizontal_surface_clean">Yes</label>
<input type="radio" name="kitchen[k_horizontal_surface_clean]" value="High, low and horizontal surfaces are not clean" id="k_horizontal_surface_clean2" <?php if($htmldata['kitchen']['data']['k_horizontal_surface_clean']['value']=="High, low and horizontal surfaces are not clean") echo "checked";?>>
<label for="k_horizontal_surface_clean2">No</label>


<input type="radio" name="kitchen[k_horizontal_surface_clean]" value="N/A" id="k_horizontal_surface_clean3" <?php if($htmldata['kitchen']['data']['k_horizontal_surface_clean']['value']=="N/A") echo "checked";?>>
<label for="k_horizontal_surface_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_horizontal_surface_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_horizontal_surface_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="High, low and horizontal surfaces are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">9.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage, exposed wood
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_horizontal_surface_damage_question]" value="No visible sign of damage, exposed wood">
<input type="radio" name="kitchen[k_horizontal_surface_damage]" value="yes" id="k_horizontal_surface_damage" <?php if($htmldata['kitchen']['data']['k_horizontal_surface_damage']['value']=="yes") echo "checked";?>>
<label for="k_horizontal_surface_damage">Yes</label>
<input type="radio" name="kitchen[k_horizontal_surface_damage]" value="High, low and horizontal surfaces are not good state of repair" id="k_horizontal_surface_damage2" <?php if($htmldata['kitchen']['data']['k_horizontal_surface_damage']['value']=="High, low and horizontal surfaces are not good state of repair") echo "checked";?>>
<label for="k_horizontal_surface_damage2">No</label>


<input type="radio" name="kitchen[k_horizontal_surface_damage]" value="N/A" id="k_horizontal_surface_damage3" <?php if($htmldata['kitchen']['data']['k_horizontal_surface_damage']['value']=="N/A") echo "checked";?>>
<label for="k_horizontal_surface_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_horizontal_surface_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_horizontal_surface_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="High, low and horizontal surfaces are not good state of repair" >
                             
                        </div>

                    </div> 
  <!-- question -->
                   <div class="question">
                        <div class="numb">9.3</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Clutter free and tidy
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_horizontal_surface_clutter_question]" value="Clutter free and tidy">
<input type="radio" name="kitchen[k_horizontal_surface_clutter]" value="yes" id="k_horizontal_surface_clutter" <?php if($htmldata['kitchen']['data']['k_horizontal_surface_clutter']['value']=="yes") echo "checked";?>>
<label for="k_horizontal_surface_clutter">Yes</label>
<input type="radio" name="kitchen[k_horizontal_surface_clutter]" value="High, low and horizontal surfaces is cluttered" id="k_horizontal_surface_clutter2" <?php if($htmldata['kitchen']['data']['k_horizontal_surface_clutter']['value']=="High, low and horizontal surfaces is cluttered") echo "checked";?>>
<label for="k_horizontal_surface_clutter2">No</label>


<input type="radio" name="kitchen[k_horizontal_surface_clutter]" value="N/A" id="k_horizontal_surface_clutter3" <?php if($htmldata['kitchen']['data']['k_horizontal_surface_clutter']['value']=="N/A") echo "checked";?>>
<label for="k_horizontal_surface_clutter3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_horizontal_surface_cluttek_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_horizontal_surface_clutter']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="High, low and horizontal surfaces is cluttered" >
                             
                        </div>

                      
                    </div>       
     <!-- question -->
           <div class="question">
                <div class="numb">9.4</div>
                <div class="quest">


<div class="quest-inner">
<div class="q">
Washable and impervious to moisture, smooth and with covered edges
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_horizontal_surface_impermeable_question]" value="Washable and impervious to moisture">
<input type="radio" name="kitchen[k_horizontal_surface_impermeable]" value="yes" id="k_horizontal_surface_impermeable" <?php if($htmldata['kitchen']['data']['k_horizontal_surface_impermeable']['value']=="yes") echo "checked";?>>
<label for="k_horizontal_surface_impermeable">Yes</label>
<input type="radio" name="kitchen[k_horizontal_surface_impermeable]" value="High, low and horizontal surfaces are not made from impermeable material" id="k_horizontal_surface_impermeable2" <?php if($htmldata['kitchen']['data']['k_horizontal_surface_impermeable']['value']=="High, low and horizontal surfaces are not made from impermeable material") echo "checked";?>>
<label for="k_horizontal_surface_impermeable2">No</label>


<input type="radio" name="kitchen[k_horizontal_surface_impermeable]" value="N/A" id="k_horizontal_surface_impermeable3" <?php if($htmldata['kitchen']['data']['k_horizontal_surface_impermeable']['value']=="N/A") echo "checked";?>>
<label for="k_horizontal_surface_impermeable3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_horizontal_surface_impermeable_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_horizontal_surface_impermeable']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="High, low and horizontal surfaces are not made from impermeable material" >
                             
                        </div>

                    </div>                     
                        <hr>
<h5><span class="audit_txt">10. External windows including frames and sills are clean and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[k_external_windows_main_question]" value="External windows including frames and sills are clean and in a good state of repair?">
<div class="question">
                        <div class="numb">10.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_external_windows_clean_question]" value="Visibly clean">
<input type="radio" name="kitchen[k_external_windows_clean]" value="yes" id="k_external_windows_clean" <?php if($htmldata['kitchen']['data']['k_external_windows_clean']['value']=="yes") echo "checked";?>>
<label for="k_external_windows_clean">Yes</label>
<input type="radio" name="kitchen[k_external_windows_clean]" value="External windows including frames and sills are not clean" id="k_external_windows_clean2" <?php if($htmldata['kitchen']['data']['k_external_windows_clean']['value']=="External windows including frames and sills are not clean") echo "checked";?>>
<label for="k_external_windows_clean2">No</label>


<input type="radio" name="kitchen[k_external_windows_clean]" value="N/A" id="k_external_windows_clean3" <?php if($htmldata['kitchen']['data']['k_external_windows_clean']['value']=="N/A") echo "checked";?>>
<label for="k_external_windows_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_external_windows_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_external_windows_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="External windows including frames and sills are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">10.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage, cracks
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_external_windows_damage_question]" value="No visible sign of damage, cracks">
<input type="radio" name="kitchen[k_external_windows_damage]" value="yes" id="k_external_windows_damage" <?php if($htmldata['kitchen']['data']['k_external_windows_damage']['value']=="yes") echo "checked";?>>
<label for="k_external_windows_damage">Yes</label>
<input type="radio" name="kitchen[k_external_windows_damage]" value="External windows including frames and sills are not good state of repair" id="k_external_windows_damage2" <?php if($htmldata['kitchen']['data']['k_external_windows_damage']['value']=="External windows including frames and sills are not good state of repair") echo "checked";?>>
<label for="k_external_windows_damage2">No</label>


<input type="radio" name="kitchen[k_external_windows_damage]" value="N/A" id="k_external_windows_damage3" <?php if($htmldata['kitchen']['data']['k_external_windows_damage']['value']=="N/A") echo "checked";?>>
<label for="k_external_windows_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_external_windows_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_external_windows_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="External windows including frames and sills are not good state of repair" >
                             
                        </div>

                    </div> 
                    <hr>
<h5><span class="audit_txt">11. Internal windows including frames and sills are clean and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[k_internal_windows_main_question]" value="Internal windows including frames and sills are clean and in a good state of repair?">
<div class="question">
                        <div class="numb">11.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_internal_windows_clean_question]" value="Visibly clean">
<input type="radio" name="kitchen[k_internal_windows_clean]" value="yes" id="k_internal_windows_clean" <?php if($htmldata['kitchen']['data']['k_internal_windows_clean']['value']=="yes") echo "checked";?>>
<label for="k_internal_windows_clean">Yes</label>
<input type="radio" name="kitchen[k_internal_windows_clean]" value="internal windows including frames and sills are not clean" id="k_internal_windows_clean2" <?php if($htmldata['kitchen']['data']['k_internal_windows_clean']['value']=="internal windows including frames and sills are not clean") echo "checked";?>>
<label for="k_internal_windows_clean2">No</label>


<input type="radio" name="kitchen[k_internal_windows_clean]" value="N/A" id="k_internal_windows_clean3" <?php if($htmldata['kitchen']['data']['k_internal_windows_clean']['value']=="N/A") echo "checked";?>>
<label for="k_internal_windows_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_internal_windows_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_internal_windows_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="internal windows including frames and sills are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">11.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Internal glass dividing panels/ windows for visible sign of damage, cracks
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_internal_windows_damage_question]" value="Internal glass dividing panels/ windows for visible sign of damage, cracks">
<input type="radio" name="kitchen[k_internal_windows_damage]" value="yes" id="k_internal_windows_damage" <?php if($htmldata['kitchen']['data']['k_internal_windows_damage']['value']=="yes") echo "checked";?>>
<label for="k_internal_windows_damage">Yes</label>
<input type="radio" name="kitchen[k_internal_windows_damage]" value="internal windows including frames and sills are not good state of repair" id="k_internal_windows_damage2" <?php if($htmldata['kitchen']['data']['k_internal_windows_damage']['value']=="internal windows including frames and sills are not good state of repair") echo "checked";?>>
<label for="k_internal_windows_damage2">No</label>


<input type="radio" name="kitchen[k_internal_windows_damage]" value="N/A" id="k_internal_windows_damage3" <?php if($htmldata['kitchen']['data']['k_internal_windows_damage']['value']=="N/A") echo "checked";?>>
<label for="k_internal_windows_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_internal_windows_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_internal_windows_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="internal windows including frames and sills are not good state of repair" >
                             
                        </div>

                    </div> 
                    <hr>
<h5><span class="audit_txt">12. Window curtains/ blinds are clean and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[k_curtains_main_question]" value="Window curtains/ blinds are clean and in a good state of repair?">
<div class="question">
                        <div class="numb">12.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_curtains_clean_question]" value="Visibly clean">
<input type="radio" name="kitchen[k_curtains_clean]" value="yes" id="k_curtains_clean" <?php if($htmldata['kitchen']['data']['k_curtains_clean']['value']=="yes") echo "checked";?>>
<label for="k_curtains_clean">Yes</label>
<input type="radio" name="kitchen[k_curtains_clean]" value="Window curtains/ blinds are not clean" id="k_curtains_clean2" <?php if($htmldata['kitchen']['data']['k_curtains_clean']['value']=="Window curtains/ blinds are not clean") echo "checked";?>>
<label for="k_curtains_clean2">No</label>


<input type="radio" name="kitchen[k_curtains_clean]" value="N/A" id="k_curtains_clean3" <?php if($htmldata['kitchen']['data']['k_curtains_clean']['value']=="N/A") echo "checked";?>>
<label for="k_curtains_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_curtains_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_curtains_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Window curtains/ blinds are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">12.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage, wear and tear, no rips
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_curtains_damage_question]" value="No visible sign of damage, wear and tear, no rips">
<input type="radio" name="kitchen[k_curtains_damage]" value="yes" id="k_curtains_damage" <?php if($htmldata['kitchen']['data']['k_curtains_damage']['value']=="yes") echo "checked";?>>
<label for="k_curtains_damage">Yes</label>
<input type="radio" name="kitchen[k_curtains_damage]" value="Window curtains/ blinds are not good state of repair" id="k_curtains_damage2" <?php if($htmldata['kitchen']['data']['k_curtains_damage']['value']=="Window curtains/ blinds are not good state of repair") echo "checked";?>>
<label for="k_curtains_damage2">No</label>


<input type="radio" name="kitchen[k_curtains_damage]" value="N/A" id="k_curtains_damage3" <?php if($htmldata['kitchen']['data']['k_curtains_damage']['value']=="N/A") echo "checked";?>>
<label for="k_curtains_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_curtains_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_curtains_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Window curtains/ blinds are not good state of repair" >
                             
                        </div>

                    </div> 
                    <hr>
<h5><span class="audit_txt">13. Flooring is clean, in a good state of repair, made from impermeable material?<span></h5><br>
<input type="hidden" name="form[k_flooring_main_question]" value="Flooring is clean, in a good state of repair, made from impermeable material?">
<div class="question">
                        <div class="numb">13.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean, no build up of residue/ dirt, check edges and corners are free from dust and grit
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_flooring_clean_question]" value="Visibly clean, no build up of residue/ dirt, check edges and corners are free from dust and grit">
<input type="radio" name="kitchen[k_flooring_clean]" value="yes" id="k_flooring_clean" <?php if($htmldata['kitchen']['data']['k_flooring_clean']['value']=="yes") echo "checked";?>>
<label for="k_flooring_clean">Yes</label>
<input type="radio" name="kitchen[k_flooring_clean]" value="Flooring are not clean" id="k_flooring_clean2" <?php if($htmldata['kitchen']['data']['k_flooring_clean']['value']=="Flooring are not clean") echo "checked";?>>
<label for="k_flooring_clean2">No</label>


<input type="radio" name="kitchen[k_flooring_clean]" value="N/A" id="k_flooring_clean3" <?php if($htmldata['kitchen']['data']['k_flooring_clean']['value']=="N/A") echo "checked";?>>
<label for="k_flooring_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_flooring_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_flooring_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Flooring are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">13.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Free from rips and tears, laid correctly
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_flooring_damage_question]" value="Free from rips and tears, laid correctly">
<input type="radio" name="kitchen[k_flooring_damage]" value="yes" id="k_flooring_damage" <?php if($htmldata['kitchen']['data']['k_flooring_damage']['value']=="yes") echo "checked";?>>
<label for="k_flooring_damage">Yes</label>
<input type="radio" name="kitchen[k_flooring_damage]" value="Flooring are not good state of repair" id="k_flooring_damage2" <?php if($htmldata['kitchen']['data']['k_flooring_damage']['value']=="Flooring are not good state of repair") echo "checked";?>>
<label for="k_flooring_damage2">No</label>


<input type="radio" name="kitchen[k_flooring_damage]" value="N/A" id="k_flooring_damage3" <?php if($htmldata['kitchen']['data']['k_flooring_damage']['value']=="N/A") echo "checked";?>>
<label for="k_flooring_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_flooring_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_flooring_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Flooring are not good state of repair" >
                             
                        </div>

                    </div> 
     <!-- question -->
           <div class="question">
                <div class="numb">13.3</div>
                <div class="quest">


<div class="quest-inner">
<div class="q">
Washable and impervious to moisture
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_flooring_impermeable_question]" value="Washable and impervious to moisture">
<input type="radio" name="kitchen[k_flooring_impermeable]" value="yes" id="k_flooring_impermeable" <?php if($htmldata['kitchen']['data']['k_flooring_impermeable']['value']=="yes") echo "checked";?>>
<label for="k_flooring_impermeable">Yes</label>
<input type="radio" name="kitchen[k_flooring_impermeable]" value="flooring are not made from impermeable material" id="k_flooring_impermeable2" <?php if($htmldata['kitchen']['data']['k_flooring_impermeable']['value']=="flooring are not made from impermeable material") echo "checked";?>>
<label for="k_flooring_impermeable2">No</label>


<input type="radio" name="kitchen[k_flooring_impermeable]" value="N/A" id="k_flooring_impermeable3" <?php if($htmldata['kitchen']['data']['k_flooring_impermeable']['value']=="N/A") echo "checked";?>>
<label for="k_flooring_impermeable3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_flooring_impermeable_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_flooring_impermeable']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="flooring are not made from impermeable material" >
                             
                        </div>

                    </div>                     
                        <hr> 

<h5><span class="audit_txt">14. Doors and frames are clean and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[k_doors_main_question]" value="Doors and frames are clean and in a good state of repair?">
<div class="question">
                        <div class="numb">14.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean especially around touch points
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_doors_clean_question]" value="Visibly clean especially around touch points">
<input type="radio" name="kitchen[k_doors_clean]" value="yes" id="k_doors_clean" <?php if($htmldata['kitchen']['data']['k_doors_clean']['value']=="yes") echo "checked";?>>
<label for="k_doors_clean">Yes</label>
<input type="radio" name="kitchen[k_doors_clean]" value="doors and frames are not clean" id="k_doors_clean2" <?php if($htmldata['kitchen']['data']['k_doors_clean']['value']=="doors and frames are not clean") echo "checked";?>>
<label for="k_doors_clean2">No</label>


<input type="radio" name="kitchen[k_doors_clean]" value="N/A" id="k_doors_clean3" <?php if($htmldata['kitchen']['data']['k_doors_clean']['value']=="N/A") echo "checked";?>>
<label for="k_doors_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_doors_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_doors_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="doors and frames are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">14.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 No visible sign of damage, no exposed wood
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_doors_damage_question]" value="No visible sign of damage, no exposed wood">
<input type="radio" name="kitchen[k_doors_damage]" value="yes" id="k_doors_damage" <?php if($htmldata['kitchen']['data']['k_doors_damage']['value']=="yes") echo "checked";?>>
<label for="k_doors_damage">Yes</label>
<input type="radio" name="kitchen[k_doors_damage]" value="doors and frames are not good state of repair" id="k_doors_damage2" <?php if($htmldata['kitchen']['data']['k_doors_damage']['value']=="doors and frames are not good state of repair") echo "checked";?>>
<label for="k_doors_damage2">No</label>


<input type="radio" name="kitchen[k_doors_damage]" value="N/A" id="k_doors_damage3" <?php if($htmldata['kitchen']['data']['k_doors_damage']['value']=="N/A") echo "checked";?>>
<label for="k_doors_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_doors_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_doors_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="doors and frames are not good state of repair" >
                             
                        </div>

                    </div> 
                    <hr>


<h5><span class="audit_txt">15. The room is free from inappropriate items?<span></h5><br>
<input type="hidden" name="form[k_room_main_question]" value="The room is free from inappropriate items?">
<div class="question">
                        <div class="numb">15.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Free from inappropriate items i.e. outdoor clothing, personal belongings
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_room_inappropriate_question]" value="Free from inappropriate items i.e. outdoor clothing, personal belongings">
<input type="radio" name="kitchen[k_room_inappropriate]" value="yes" id="k_room_inappropriate" <?php if($htmldata['kitchen']['data']['k_room_inappropriate']['value']=="yes") echo "checked";?>>
<label for="k_room_inappropriate">Yes</label>
<input type="radio" name="kitchen[k_room_inappropriate]" value="the room is not free from inappropriate items" id="k_room_inappropriate2" <?php if($htmldata['kitchen']['data']['k_room_inappropriate']['value']=="the room is not free from inappropriate items") echo "checked";?>>
<label for="k_room_inappropriate2">No</label>


<input type="radio" name="kitchen[k_room_inappropriate]" value="N/A" id="k_room_inappropriate3" <?php if($htmldata['kitchen']['data']['k_room_inappropriate']['value']=="N/A") echo "checked";?>>
<label for="k_room_inappropriate3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_room_inappropriate_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_room_inappropriate']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="the room is not free from inappropriate items" >
                             
                        </div>

                      
                    </div>               
   
                    <hr>


<h5><span class="audit_txt">16. All equipment and products are stored appropriately?<span></h5><br>
<input type="hidden" name="form[k_equipment_approp_main_question]" value="All equipment and products are stored appropriately?">
<div class="question">
                        <div class="numb">16.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Items stored off the floor, neat and tidy. Is storage sufficient, any inappropriate items on surfaces or on top of cupboards
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_equipment_approp_question]" value="Items stored off the floor, neat and tidy. Is storage sufficient, any inappropriate items on surfaces or on top of cupboards">
<input type="radio" name="kitchen[k_equipment_approp]" value="yes" id="k_equipment_approp" <?php if($htmldata['kitchen']['data']['k_equipment_approp']['value']=="yes") echo "checked";?>>
<label for="k_equipment_approp">Yes</label>
<input type="radio" name="kitchen[k_equipment_approp]" value="All equipment and products are not stored appropriately" id="k_equipment_approp2" <?php if($htmldata['kitchen']['data']['k_equipment_approp']['value']=="All equipment and products are not stored appropriately") echo "checked";?>>
<label for="k_equipment_approp2">No</label>


<input type="radio" name="kitchen[k_equipment_approp]" value="N/A" id="k_equipment_approp3" <?php if($htmldata['kitchen']['data']['k_equipment_approp']['value']=="N/A") echo "checked";?>>
<label for="k_equipment_approp3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_equipment_approp_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_equipment_approp']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="All equipment and products are not stored appropriately" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">16.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Decanted products are stored in labelled, sealed containers
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_decanted_approp_question]" value="Decanted products are stored in labelled, sealed containers
">
<input type="radio" name="kitchen[k_decanted_approp]" value="yes" id="k_decanted_approp" <?php if($htmldata['kitchen']['data']['k_decanted_approp']['value']=="yes") echo "checked";?>>
<label for="k_decanted_approp">Yes</label>
<input type="radio" name="kitchen[k_decanted_approp]" value="Decanted products are not stored appropriately" id="k_decanted_approp2" <?php if($htmldata['kitchen']['data']['k_decanted_approp']['value']=="Decanted products are not stored appropriately") echo "checked";?>>
<label for="k_decanted_approp2">No</label>


<input type="radio" name="kitchen[k_decanted_approp]" value="N/A" id="k_decanted_approp3" <?php if($htmldata['kitchen']['data']['k_decanted_approp']['value']=="N/A") echo "checked";?>>
<label for="k_decanted_approp3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_decanted_approp_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_decanted_approp']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Decanted products are not stored appropriately" >
                             
                        </div>

                    </div> 
                    <hr>
<h5><span class="audit_txt">17. A dedicated hand wash sink is available, clean and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[k_sink_main_question]" value="A dedicated hand wash sink is available, clean and in a good state of repair?">
<div class="question">
                        <div class="numb">17.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_sink_clean_question]" value="Visibly clean">
<input type="radio" name="kitchen[k_sink_clean]" value="yes" id="k_sink_clean" <?php if($htmldata['kitchen']['data']['k_sink_clean']['value']=="yes") echo "checked";?>>
<label for="k_sink_clean">Yes</label>
<input type="radio" name="kitchen[k_sink_clean]" value="A dedicated hand wash sink is available are not clean" id="k_sink_clean2" <?php if($htmldata['kitchen']['data']['k_sink_clean']['value']=="A dedicated hand wash sink is available are not clean") echo "checked";?>>
<label for="k_sink_clean2">No</label>


<input type="radio" name="kitchen[k_sink_clean]" value="N/A" id="k_sink_clean3" <?php if($htmldata['kitchen']['data']['k_sink_clean']['value']=="N/A") echo "checked";?>>
<label for="k_sink_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_sink_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_sink_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="A dedicated hand wash sink is available are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">17.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage, cracks, fitted correctly
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_sink_damage_question]" value="No visible sign of damage, no exposed wood">
<input type="radio" name="kitchen[k_sink_damage]" value="yes" id="k_sink_damage" <?php if($htmldata['kitchen']['data']['k_sink_damage']['value']=="yes") echo "checked";?>>
<label for="k_sink_damage">Yes</label>
<input type="radio" name="kitchen[k_sink_damage]" value="A dedicated hand wash sink are not good state of repair" id="k_sink_damage2" <?php if($htmldata['kitchen']['data']['k_sink_damage']['value']=="A dedicated hand wash sink are not good state of repair") echo "checked";?>>
<label for="k_sink_damage2">No</label>


<input type="radio" name="kitchen[k_sink_damage]" value="N/A" id="k_sink_damage3" <?php if($htmldata['kitchen']['data']['k_sink_damage']['value']=="N/A") echo "checked";?>>
<label for="k_sink_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_sink_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_sink_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="A dedicated hand wash sink are not good state of repair" >
                             
                        </div>

                    </div> 
                    <hr>

<h5><span class="audit_txt">18. Taps are clean and in a good state of repair taps?<span></h5><br>
<input type="hidden" name="form[k_taps_clean_main_question]" value="Taps are clean and in a good state of repair taps">
<div class="question">
                        <div class="numb">18.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_taps_clean_question]" value="Visibly clean">
<input type="radio" name="kitchen[k_taps_clean]" value="yes" id="k_taps_clean" <?php if($htmldata['kitchen']['data']['k_taps_clean']['value']=="yes") echo "checked";?>>
<label for="k_taps_clean">Yes</label>
<input type="radio" name="kitchen[k_taps_clean]" value="Taps are not clean" id="k_taps_clean2" <?php if($htmldata['kitchen']['data']['k_taps_clean']['value']=="Taps are not clean") echo "checked";?>>
<label for="k_taps_clean2">No</label>


<input type="radio" name="kitchen[k_taps_clean]" value="N/A" id="k_taps_clean3" <?php if($htmldata['kitchen']['data']['k_taps_clean']['value']=="N/A") echo "checked";?>>
<label for="k_taps_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_taps_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_taps_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Taps are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">18.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_taps_damage_question]" value="No visible sign of damage">
<input type="radio" name="kitchen[k_taps_damage]" value="yes" id="k_taps_damage" <?php if($htmldata['kitchen']['data']['k_taps_damage']['value']=="yes") echo "checked";?>>
<label for="k_taps_damage">Yes</label>
<input type="radio" name="kitchen[k_taps_damage]" value="taps are not in a good state of repair taps" id="k_taps_damage2" <?php if($htmldata['kitchen']['data']['k_taps_damage']['value']=="taps are not in a good state of repair taps") echo "checked";?>>
<label for="k_taps_damage2">No</label>


<input type="radio" name="kitchen[k_taps_damage]" value="N/A" id="k_taps_damage3" <?php if($htmldata['kitchen']['data']['k_taps_damage']['value']=="N/A") echo "checked";?>>
<label for="k_taps_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_taps_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_taps_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="taps are not in a good state of repair taps" >
                             
                        </div>

                    </div> 
 <!-- question -->
                   <div class="question">
                        <div class="numb">18.3</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Free from lime scale
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_taps_scale_question]" value="Free from lime scale">
<input type="radio" name="kitchen[k_taps_scale]" value="yes" id="k_taps_scale" <?php if($htmldata['kitchen']['data']['k_taps_scale']['value']=="yes") echo "checked";?>>
<label for="k_taps_scale">Yes</label>
<input type="radio" name="kitchen[k_taps_scale]" value="taps are not free from lime scale" id="k_taps_scale2" <?php if($htmldata['kitchen']['data']['k_taps_scale']['value']=="taps are not free from lime scale") echo "checked";?>>
<label for="k_taps_scale2">No</label>


<input type="radio" name="kitchen[k_taps_scale]" value="N/A" id="k_taps_scale3" <?php if($htmldata['kitchen']['data']['k_taps_scale']['value']=="N/A") echo "checked";?>>
<label for="k_taps_scale3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_taps_scale_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_taps_scale']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="taps are not free from lime scale" >
                             
                        </div>

                    </div> 

                    <hr>


<h5><span class="audit_txt">19. An equipment sink is available, clean, in a good state of repair?<span></h5><br>
<input type="hidden" name="form[k_equipment_sink_available_main_question]" value="An equipment sink is available, clean, in a good state of repair">
<div class="question">
                        <div class="numb">19.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Check availability for cleaning equipment
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_equipment_sink_available_question]" value="Check availability for cleaning equipment">
<input type="radio" name="kitchen[k_equipment_sink_available]" value="yes" id="k_equipment_sink_available" <?php if($htmldata['kitchen']['data']['k_equipment_sink_available']['value']=="yes") echo "checked";?>>
<label for="k_equipment_sink_available">Yes</label>
<input type="radio" name="kitchen[k_equipment_sink_available]" value="An equipment sink is not available" id="k_equipment_sink_available2" <?php if($htmldata['kitchen']['data']['k_equipment_sink_available']['value']=="An equipment sink is not available") echo "checked";?>>
<label for="k_equipment_sink_available2">No</label>


<input type="radio" name="kitchen[k_equipment_sink_available]" value="N/A" id="k_equipment_sink_available3" <?php if($htmldata['kitchen']['data']['k_equipment_sink_available']['value']=="N/A") echo "checked";?>>
<label for="k_equipment_sink_available3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_equipment_sink_available_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_equipment_sink_available']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="An equipment sink is not available" >
                             
                        </div>

                      
                    </div>     

<div class="question">
                        <div class="numb">19.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Check if visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_equipment_sink_clean_question]" value="Check if visibly clean">
<input type="radio" name="kitchen[k_equipment_sink_clean]" value="yes" id="k_equipment_sink_clean" <?php if($htmldata['kitchen']['data']['k_equipment_sink_clean']['value']=="yes") echo "checked";?>>
<label for="k_equipment_sink_clean">Yes</label>
<input type="radio" name="kitchen[k_equipment_sink_clean]" value="An equipment sink is not clean" id="k_equipment_sink_clean2" <?php if($htmldata['kitchen']['data']['k_equipment_sink_clean']['value']=="An equipment sink is not clean") echo "checked";?>>
<label for="k_equipment_sink_clean2">No</label>


<input type="radio" name="kitchen[k_equipment_sink_clean]" value="N/A" id="k_equipment_sink_clean3" <?php if($htmldata['kitchen']['data']['k_equipment_sink_clean']['value']=="N/A") echo "checked";?>>
<label for="k_equipment_sink_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_equipment_sink_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_equipment_sink_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="An equipment sink is not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">19.3</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage, cracks, fitted correctly
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_equipment_sink_damage_question]" value="No visible sign of damage, cracks, fitted correctly">
<input type="radio" name="kitchen[k_equipment_sink_damage]" value="yes" id="k_equipment_sink_damage" <?php if($htmldata['kitchen']['data']['k_equipment_sink_damage']['value']=="yes") echo "checked";?>>
<label for="k_equipment_sink_damage">Yes</label>
<input type="radio" name="kitchen[k_equipment_sink_damage]" value="equipment sink are not in a good state of repair equipment_sink" id="k_equipment_sink_damage2" <?php if($htmldata['kitchen']['data']['k_equipment_sink_damage']['value']=="equipment sink are not in a good state of repair equipment_sink") echo "checked";?>>
<label for="k_equipment_sink_damage2">No</label>


<input type="radio" name="kitchen[k_equipment_sink_damage]" value="N/A" id="k_equipment_sink_damage3" <?php if($htmldata['kitchen']['data']['k_equipment_sink_damage']['value']=="N/A") echo "checked";?>>
<label for="k_equipment_sink_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_equipment_sink_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_equipment_sink_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="equipment sink are not in a good state of repair taps" >
                             
                        </div>

                    </div> 
<hr>
<h5><span class="audit_txt">20. Ceilings are clean and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[k_ceilings_clean_main_question]" value="Ceilings are clean and in a good state of repair">
<div class="question">
                       


                        <div class="numb">20.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Check if visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_ceilings_clean_question]" value="Check if visibly clean">
<input type="radio" name="kitchen[k_ceilings_clean]" value="yes" id="k_ceilings_clean" <?php if($htmldata['kitchen']['data']['k_ceilings_clean']['value']=="yes") echo "checked";?>>
<label for="k_ceilings_clean">Yes</label>
<input type="radio" name="kitchen[k_ceilings_clean]" value="Ceilings is not clean" id="k_ceilings_clean2" <?php if($htmldata['kitchen']['data']['k_ceilings_clean']['value']=="Ceilings is not clean") echo "checked";?>>
<label for="k_ceilings_clean2">No</label>


<input type="radio" name="kitchen[k_ceilings_clean]" value="N/A" id="k_ceilings_clean3" <?php if($htmldata['kitchen']['data']['k_ceilings_clean']['value']=="N/A") echo "checked";?>>
<label for="k_ceilings_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_ceilings_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_ceilings_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Ceilings is not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">20.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage, cracks, flaking paint
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_ceilings_damage_question]" value="No visible sign of damage, cracks, flaking paint">
<input type="radio" name="kitchen[k_ceilings_damage]" value="yes" id="k_ceilings_damage" <?php if($htmldata['kitchen']['data']['k_ceilings_damage']['value']=="yes") echo "checked";?>>
<label for="k_ceilings_damage">Yes</label>
<input type="radio" name="kitchen[k_ceilings_damage]" value="Ceilings are not in a good state of repair ceilings" id="k_ceilings_damage2" <?php if($htmldata['kitchen']['data']['k_ceilings_damage']['value']=="Ceilings are not in a good state of repair ceilings") echo "checked";?>>
<label for="k_ceilings_damage2">No</label>


<input type="radio" name="kitchen[k_ceilings_damage]" value="N/A" id="k_ceilings_damage3" <?php if($htmldata['kitchen']['data']['k_ceilings_damage']['value']=="N/A") echo "checked";?>>
<label for="k_ceilings_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_ceilings_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_ceilings_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Ceilings are not in a good state of repair taps" >
                             
                        </div>

                    </div>
  <div class="question">                   
 <div class="numb">20.3</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Tiles are secure and in place
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_ceilings_secure_question]" value="Tiles are secure and in place">
<input type="radio" name="kitchen[k_ceilings_secure]" value="yes" id="k_ceilings_secure" <?php if($htmldata['kitchen']['data']['k_ceilings_secure']['value']=="yes") echo "checked";?>>
<label for="k_ceilings_secure">Yes</label>
<input type="radio" name="kitchen[k_ceilings_secure]" value="Tiles are not secure and in place" id="k_ceilings_secure2" <?php if($htmldata['kitchen']['data']['k_ceilings_secure']['value']=="Tiles are not secure and in place") echo "checked";?>>
<label for="k_ceilings_secure2">No</label>


<input type="radio" name="kitchen[k_ceilings_secure]" value="N/A" id="k_ceilings_secure3" <?php if($htmldata['kitchen']['data']['k_ceilings_secure']['value']=="N/A") echo "checked";?>>
<label for="k_ceilings_secure3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_ceilings_secure_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_ceilings_secure']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Tiles are not secure and in place" >
                             
                        </div>

                      
                    </div>     
<hr>
<h5><span class="audit_txt">21. Kitchen fittings and fixtures are clean, in a good state of repair?<span></h5><br>
<input type="hidden" name="form[k_kitchen_fittings_clean_main_question]" value="Kitchen fittings and fixtures are clean, in a good state of repair">
<div class="question">
                       

                        <div class="numb">21.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Check if visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_kitchen_fittings_clean_question]" value="Check if visibly clean">
<input type="radio" name="kitchen[k_kitchen_fittings_clean]" value="yes" id="k_kitchen_fittings_clean" <?php if($htmldata['kitchen']['data']['k_kitchen_fittings_clean']['value']=="yes") echo "checked";?>>
<label for="k_kitchen_fittings_clean">Yes</label>
<input type="radio" name="kitchen[k_kitchen_fittings_clean]" value="Kitchen fittings and fixtures are not clean" id="k_kitchen_fittings_clean2" <?php if($htmldata['kitchen']['data']['k_kitchen_fittings_clean']['value']=="Kitchen fittings and fixtures are not clean") echo "checked";?>>
<label for="k_kitchen_fittings_clean2">No</label>


<input type="radio" name="kitchen[k_kitchen_fittings_clean]" value="N/A" id="k_kitchen_fittings_clean3" <?php if($htmldata['kitchen']['data']['k_kitchen_fittings_clean']['value']=="N/A") echo "checked";?>>
<label for="k_kitchen_fittings_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_kitchen_fittings_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_kitchen_fittings_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Kitchen fittings and fixtures are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">21.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage, cracks, flaking paint
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_kitchen_fittings_damage_question]" value="No visible sign of damage, cracks, flaking paint">
<input type="radio" name="kitchen[k_kitchen_fittings_damage]" value="yes" id="k_kitchen_fittings_damage" <?php if($htmldata['kitchen']['data']['k_kitchen_fittings_damage']['value']=="yes") echo "checked";?>>
<label for="k_kitchen_fittings_damage">Yes</label>
<input type="radio" name="kitchen[k_kitchen_fittings_damage]" value="Kitchen fittings and fixtures are not in a good state of repair kitchen_fittings" id="k_kitchen_fittings_damage2" <?php if($htmldata['kitchen']['data']['k_kitchen_fittings_damage']['value']=="Kitchen fittings and fixtures are not in a good state of repair kitchen_fittings") echo "checked";?>>
<label for="k_kitchen_fittings_damage2">No</label>


<input type="radio" name="kitchen[k_kitchen_fittings_damage]" value="N/A" id="k_kitchen_fittings_damage3" <?php if($htmldata['kitchen']['data']['k_kitchen_fittings_damage']['value']=="N/A") echo "checked";?>>
<label for="k_kitchen_fittings_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_kitchen_fittings_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_kitchen_fittings_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Kitchen fittings and fixtures are not in a good state of repair taps" >
                             
                        </div>

                    </div> 
<hr>
<h5><span class="audit_txt">22. Kitchen appliances are clean, in a good state of repair i.e. toaster?<span></h5><br>
<input type="hidden" name="form[k_kitchen_appliances_clean_main_question]" value="Kitchen appliances are clean, in a good state of repair i.e. toaster?">
                       

<div class="question">
                        <div class="numb">22.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_kitchen_appliances_clean_question]" value="Check if visibly clean">
<input type="radio" name="kitchen[k_kitchen_appliances_clean]" value="yes" id="k_kitchen_appliances_clean" <?php if($htmldata['kitchen']['data']['k_kitchen_appliances_clean']['value']=="yes") echo "checked";?>>
<label for="k_kitchen_appliances_clean">Yes</label>
<input type="radio" name="kitchen[k_kitchen_appliances_clean]" value="Kitchen appliances are not clean" id="k_kitchen_appliances_clean2" <?php if($htmldata['kitchen']['data']['k_kitchen_appliances_clean']['value']=="Kitchen appliances are not clean") echo "checked";?>>
<label for="k_kitchen_appliances_clean2">No</label>


<input type="radio" name="kitchen[k_kitchen_appliances_clean]" value="N/A" id="k_kitchen_appliances_clean3" <?php if($htmldata['kitchen']['data']['k_kitchen_appliances_clean']['value']=="N/A") echo "checked";?>>
<label for="k_kitchen_appliances_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_kitchen_appliances_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_kitchen_appliances_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Kitchen appliances are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">22.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_kitchen_appliances_damage_question]" value="No visible sign of damage">
<input type="radio" name="kitchen[k_kitchen_appliances_damage]" value="yes" id="k_kitchen_appliances_damage" <?php if($htmldata['kitchen']['data']['k_kitchen_appliances_damage']['value']=="yes") echo "checked";?>>
<label for="k_kitchen_appliances_damage">Yes</label>
<input type="radio" name="kitchen[k_kitchen_appliances_damage]" value="Kitchen appliances are not in a good state of repair kitchen_appliances" id="k_kitchen_appliances_damage2" <?php if($htmldata['kitchen']['data']['k_kitchen_appliances_damage']['value']=="Kitchen appliances are not in a good state of repair kitchen_appliances") echo "checked";?>>
<label for="k_kitchen_appliances_damage2">No</label>


<input type="radio" name="kitchen[k_kitchen_appliances_damage]" value="N/A" id="k_kitchen_appliances_damage3" <?php if($htmldata['kitchen']['data']['k_kitchen_appliances_damage']['value']=="N/A") echo "checked";?>>
<label for="k_kitchen_appliances_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_kitchen_appliances_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_kitchen_appliances_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Kitchen appliances are not in a good state of repair taps" >
                             
                        </div>

                    </div> 
<hr>

<h5><span class="audit_txt">23. Food fridges are visibly clean, free from inappropriate items in a good state of repair and serviced regularly?<span></h5><br>
<input type="hidden" name="form[k_fridges_clean_main_question]" value="Food fridges are visibly clean, free from inappropriate items in a good state of repair and serviced regularly?">

                       

<div class="question">
                        <div class="numb">23.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_fridges_clean_question]" value="Check if visibly clean">
<input type="radio" name="kitchen[k_fridges_clean]" value="yes" id="k_fridges_clean" <?php if($htmldata['kitchen']['data']['k_fridges_clean']['value']=="yes") echo "checked";?>>
<label for="k_fridges_clean">Yes</label>
<input type="radio" name="kitchen[k_fridges_clean]" value="Food fridges are not visibly clean" id="k_fridges_clean2" <?php if($htmldata['kitchen']['data']['k_fridges_clean']['value']=="Food fridges are not visibly clean") echo "checked";?>>
<label for="k_fridges_clean2">No</label>


<input type="radio" name="kitchen[k_fridges_clean]" value="N/A" id="k_fridges_clean3" <?php if($htmldata['kitchen']['data']['k_fridges_clean']['value']=="N/A") echo "checked";?>>
<label for="k_fridges_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_fridges_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_fridges_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Food fridges are not visibly clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->

<div class="question">
                        <div class="numb">23.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
  Used only to store food, no specimens etc
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_fridges_store_question]" value=" Used only to store food, no specimens etc">
<input type="radio" name="kitchen[k_fridges_store]" value="yes" id="k_fridges_store" <?php if($htmldata['kitchen']['data']['k_fridges_store']['value']=="yes") echo "checked";?>>
<label for="k_fridges_store">Yes</label>
<input type="radio" name="kitchen[k_fridges_store]" value="Food fridges are not used only to store food" id="k_fridges_store2" <?php if($htmldata['kitchen']['data']['k_fridges_store']['value']=="Food fridges are not used only to store food") echo "checked";?>>
<label for="k_fridges_store2">No</label>


<input type="radio" name="kitchen[k_fridges_store]" value="N/A" id="k_fridges_store3" <?php if($htmldata['kitchen']['data']['k_fridges_store']['value']=="N/A") echo "checked";?>>
<label for="k_fridges_store3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_fridges_store_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_fridges_store']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Food fridges are not used only to store food" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
<div class="question">
                        <div class="numb">23.3</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Open food is labelled and dated
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_fridges_labelled_question]" value="Open food is labelled and dated">
<input type="radio" name="kitchen[k_fridges_labelled]" value="yes" id="k_fridges_labelled" <?php if($htmldata['kitchen']['data']['k_fridges_labelled']['value']=="yes") echo "checked";?>>
<label for="k_fridges_labelled">Yes</label>
<input type="radio" name="kitchen[k_fridges_labelled]" value="Food fridges are not open food, is not labelled and dated" id="k_fridges_labelled2" <?php if($htmldata['kitchen']['data']['k_fridges_labelled']['value']=="Food fridges are not open food, is not labelled and dated") echo "checked";?>>
<label for="k_fridges_labelled2">No</label>


<input type="radio" name="kitchen[k_fridges_labelled]" value="N/A" id="k_fridges_labelled3" <?php if($htmldata['kitchen']['data']['k_fridges_labelled']['value']=="N/A") echo "checked";?>>
<label for="k_fridges_labelled3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_fridges_labelled_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_fridges_labelled']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Food fridges are not open food, is not labelled and dated" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
  <!-- question -->
<div class="question">
                        <div class="numb">23.4</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Temperature checks are carried out and recorded on a daily basis(to identify failures in cold chain)
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_fridges_temperature_question]" value="Temperature checks are carried out and recorded on a daily basis(to identify failures in cold chain)">
<input type="radio" name="kitchen[k_fridges_temperature]" value="yes" id="k_fridges_temperature" <?php if($htmldata['kitchen']['data']['k_fridges_temperature']['value']=="yes") echo "checked";?>>
<label for="k_fridges_temperature">Yes</label>
<input type="radio" name="kitchen[k_fridges_temperature]" value="Temperature checks are not carried out and recorded on a daily basis" id="k_fridges_temperature2" <?php if($htmldata['kitchen']['data']['k_fridges_temperature']['value']=="Temperature checks are not carried out and recorded on a daily basis") echo "checked";?>>
<label for="k_fridges_temperature2">No</label>


<input type="radio" name="kitchen[k_fridges_temperature]" value="N/A" id="k_fridges_temperature3" <?php if($htmldata['kitchen']['data']['k_fridges_temperature']['value']=="N/A") echo "checked";?>>
<label for="k_fridges_temperature3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_fridges_temperature_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_fridges_temperature']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Temperature checks are not carried out and recorded on a daily basis" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question --> <!-- question -->
<div class="question">
                        <div class="numb">23.5</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Variations outside temperature ranges are actioned
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_fridges_outside_temp_question]" value="Variations outside temperature ranges are actioned">
<input type="radio" name="kitchen[k_fridges_outside_temp]" value="yes" id="k_fridges_outside_temp" <?php if($htmldata['kitchen']['data']['k_fridges_outside_temp']['value']=="yes") echo "checked";?>>
<label for="k_fridges_outside_temp">Yes</label>
<input type="radio" name="kitchen[k_fridges_outside_temp]" value="Variations outside temperature ranges are not actioned" id="k_fridges_outside_temp2" <?php if($htmldata['kitchen']['data']['k_fridges_outside_temp']['value']=="Variations outside temperature ranges are not actioned") echo "checked";?>>
<label for="k_fridges_outside_temp2">No</label>


<input type="radio" name="kitchen[k_fridges_outside_temp]" value="N/A" id="k_fridges_outside_temp3" <?php if($htmldata['kitchen']['data']['k_fridges_outside_temp']['value']=="N/A") echo "checked";?>>
<label for="k_fridges_outside_temp3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_fridges_outside_temp_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_fridges_outside_temp']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Variations outside temperature ranges are not actioned" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">23.6</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_fridges_damage_question]" value="No visible sign of damage">
<input type="radio" name="kitchen[k_fridges_damage]" value="yes" id="k_fridges_damage" <?php if($htmldata['kitchen']['data']['k_fridges_damage']['value']=="yes") echo "checked";?>>
<label for="k_fridges_damage">Yes</label>
<input type="radio" name="kitchen[k_fridges_damage]" value="Food fridges are not in a good state of repair fridges" id="k_fridges_damage2" <?php if($htmldata['kitchen']['data']['k_fridges_damage']['value']=="Food fridges are not in a good state of repair fridges") echo "checked";?>>
<label for="k_fridges_damage2">No</label>


<input type="radio" name="kitchen[k_fridges_damage]" value="N/A" id="k_fridges_damage3" <?php if($htmldata['kitchen']['data']['k_fridges_damage']['value']=="N/A") echo "checked";?>>
<label for="k_fridges_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_fridges_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_fridges_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Food fridges are not in a good state of repair taps" >
                             
                        </div>

                    </div> 
   <div class="question">
                        <div class="numb">23.7</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Maintenance programme in place and records available
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_fridges_maintenance_question]" value="Maintenance programme in place and records available">
<input type="radio" name="kitchen[k_fridges_maintenance]" value="yes" id="k_fridges_maintenance" <?php if($htmldata['kitchen']['data']['k_fridges_maintenance']['value']=="yes") echo "checked";?>>
<label for="k_fridges_maintenance">Yes</label>
<input type="radio" name="kitchen[k_fridges_maintenance]" value="Maintenance programme in place and records not available" id="k_fridges_maintenance2" <?php if($htmldata['kitchen']['data']['k_fridges_maintenance']['value']=="Maintenance programme in place and records not available") echo "checked";?>>
<label for="k_fridges_maintenance2">No</label>


<input type="radio" name="kitchen[k_fridges_maintenance]" value="N/A" id="k_fridges_maintenance3" <?php if($htmldata['kitchen']['data']['k_fridges_maintenance']['value']=="N/A") echo "checked";?>>
<label for="k_fridges_maintenance3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_fridges_maintenance_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_fridges_maintenance']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Maintenance programme in place and records not available" >
                             
                        </div>

                    </div> 
<hr>
<h5><span class="audit_txt">24. The dishwasher is visibly clean in a good state of repair and serviced regularly?<span></h5><br>
<input type="hidden" name="form[k_dishwasher_clean_main_question]" value="The dishwasher is visibly clean in a good state of repair and serviced regularly?">

                       

<div class="question">
                        <div class="numb">24.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_dishwasher_clean_question]" value="Check if visibly clean">
<input type="radio" name="kitchen[k_dishwasher_clean]" value="yes" id="k_dishwasher_clean" <?php if($htmldata['kitchen']['data']['k_dishwasher_clean']['value']=="yes") echo "checked";?>>
<label for="k_dishwasher_clean">Yes</label>
<input type="radio" name="kitchen[k_dishwasher_clean]" value="dishwasher are not visibly clean" id="k_dishwasher_clean2" <?php if($htmldata['kitchen']['data']['k_dishwasher_clean']['value']=="dishwasher are not visibly clean") echo "checked";?>>
<label for="k_dishwasher_clean2">No</label>


<input type="radio" name="kitchen[k_dishwasher_clean]" value="N/A" id="k_dishwasher_clean3" <?php if($htmldata['kitchen']['data']['k_dishwasher_clean']['value']=="N/A") echo "checked";?>>
<label for="k_dishwasher_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_dishwasher_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_dishwasher_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="dishwasher are not visibly clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
<div class="question">
                        <div class="numb">24.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Temperature checks are carried out and recorded on a daily basis(to identify failures in wash cycle)
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_dishwasher_temperature_question]" value="Temperature checks are carried out and recorded on a daily basis(to identify failures in wash cycle)">
<input type="radio" name="kitchen[k_dishwasher_temperature]" value="yes" id="k_dishwasher_temperature" <?php if($htmldata['kitchen']['data']['k_dishwasher_temperature']['value']=="yes") echo "checked";?>>
<label for="k_dishwasher_temperature">Yes</label>
<input type="radio" name="kitchen[k_dishwasher_temperature]" value="Temperature checks are not carried out and recorded on a daily basis" id="k_dishwasher_temperature2" <?php if($htmldata['kitchen']['data']['k_dishwasher_temperature']['value']=="Temperature checks are not carried out and recorded on a daily basis") echo "checked";?>>
<label for="k_dishwasher_temperature2">No</label>


<input type="radio" name="kitchen[k_dishwasher_temperature]" value="N/A" id="k_dishwasher_temperature3" <?php if($htmldata['kitchen']['data']['k_dishwasher_temperature']['value']=="N/A") echo "checked";?>>
<label for="k_dishwasher_temperature3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_dishwasher_temperature_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_dishwasher_temperature']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Temperature checks are not carried out and recorded on a daily basis" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
 <div class="question">
                        <div class="numb">24.3</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_dishwasher_damage_question]" value="No visible sign of damage">
<input type="radio" name="kitchen[k_dishwasher_damage]" value="yes" id="k_dishwasher_damage" <?php if($htmldata['kitchen']['data']['k_dishwasher_damage']['value']=="yes") echo "checked";?>>
<label for="k_dishwasher_damage">Yes</label>
<input type="radio" name="kitchen[k_dishwasher_damage]" value="dishwasher are not in a good state of repair dishwasher" id="k_dishwasher_damage2" <?php if($htmldata['kitchen']['data']['k_dishwasher_damage']['value']=="dishwasher are not in a good state of repair dishwasher") echo "checked";?>>
<label for="k_dishwasher_damage2">No</label>


<input type="radio" name="kitchen[k_dishwasher_damage]" value="N/A" id="k_dishwasher_damage3" <?php if($htmldata['kitchen']['data']['k_dishwasher_damage']['value']=="N/A") echo "checked";?>>
<label for="k_dishwasher_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_dishwasher_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_dishwasher_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="dishwasher are not in a good state of repair taps" >
                             
                        </div>

                    </div> 
   <div class="question">
                        <div class="numb">24.4</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Maintenance programme in place and records available
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_dishwasher_maintenance_question]" value="Maintenance programme in place and records available">
<input type="radio" name="kitchen[k_dishwasher_maintenance]" value="yes" id="k_dishwasher_maintenance" <?php if($htmldata['kitchen']['data']['k_dishwasher_maintenance']['value']=="yes") echo "checked";?>>
<label for="k_dishwasher_maintenance">Yes</label>
<input type="radio" name="kitchen[k_dishwasher_maintenance]" value="Maintenance programme in place and records not available" id="k_dishwasher_maintenance2" <?php if($htmldata['kitchen']['data']['k_dishwasher_maintenance']['value']=="Maintenance programme in place and records not available") echo "checked";?>>
<label for="k_dishwasher_maintenance2">No</label>


<input type="radio" name="kitchen[k_dishwasher_maintenance]" value="N/A" id="k_dishwasher_maintenance3" <?php if($htmldata['kitchen']['data']['k_dishwasher_maintenance']['value']=="N/A") echo "checked";?>>
<label for="k_dishwasher_maintenance3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_dishwasher_maintenance_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_dishwasher_maintenance']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Maintenance programme in place and records not available" >
                             
                        </div>

                    </div> 
<hr>
<h5><span class="audit_txt">25. The Microwave is visibly clean in a good state of repair?<span></h5><br>
<input type="hidden" name="form[k_microwave_clean_main_question]" value="The Microwave is visibly clean in a good state of repair?">
                       

<div class="question">
                        <div class="numb">25.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_microwave_clean_question]" value="Check if visibly clean">
<input type="radio" name="kitchen[k_microwave_clean]" value="yes" id="k_microwave_clean" <?php if($htmldata['kitchen']['data']['k_microwave_clean']['value']=="yes") echo "checked";?>>
<label for="k_microwave_clean">Yes</label>
<input type="radio" name="kitchen[k_microwave_clean]" value="microwave are not visibly clean" id="k_microwave_clean2" <?php if($htmldata['kitchen']['data']['k_microwave_clean']['value']=="microwave are not visibly clean") echo "checked";?>>
<label for="k_microwave_clean2">No</label>


<input type="radio" name="kitchen[k_microwave_clean]" value="N/A" id="k_microwave_clean3" <?php if($htmldata['kitchen']['data']['k_microwave_clean']['value']=="N/A") echo "checked";?>>
<label for="k_microwave_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_microwave_clean_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_microwave_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="microwave are not visibly clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
 <!-- question -->
 <div class="question">
                        <div class="numb">25.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_microwave_damage_question]" value="No visible sign of damage">
<input type="radio" name="kitchen[k_microwave_damage]" value="yes" id="k_microwave_damage" <?php if($htmldata['kitchen']['data']['k_microwave_damage']['value']=="yes") echo "checked";?>>
<label for="k_microwave_damage">Yes</label>
<input type="radio" name="kitchen[k_microwave_damage]" value="microwave are not in a good state of repair microwave" id="k_microwave_damage2" <?php if($htmldata['kitchen']['data']['k_microwave_damage']['value']=="microwave are not in a good state of repair microwave") echo "checked";?>>
<label for="k_microwave_damage2">No</label>


<input type="radio" name="kitchen[k_microwave_damage]" value="N/A" id="k_microwave_damage3" <?php if($htmldata['kitchen']['data']['k_microwave_damage']['value']=="N/A") echo "checked";?>>
<label for="k_microwave_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_microwave_damage_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_microwave_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="microwave are not in a good state of repair taps" >
                             
                        </div>

                    </div>
 <!-- question -->
 <div class="question">
                        <div class="numb">25.3</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
If used to reheat patients food guidance is available
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_microwave_guidance_question]" value="If used to reheat patients food guidance is available">
<input type="radio" name="kitchen[k_microwave_guidance]" value="yes" id="k_microwave_guidance" <?php if($htmldata['kitchen']['data']['k_microwave_guidance']['value']=="yes") echo "checked";?>>
<label for="k_microwave_guidance">Yes</label>
<input type="radio" name="kitchen[k_microwave_guidance]" value="If used to reheat patients food guidance is not available" id="k_microwave_guidance2" <?php if($htmldata['kitchen']['data']['k_microwave_guidance']['value']=="If used to reheat patients food guidance is not available") echo "checked";?>>
<label for="k_microwave_guidance2">No</label>


<input type="radio" name="kitchen[k_microwave_guidance]" value="N/A" id="k_microwave_guidance3" <?php if($htmldata['kitchen']['data']['k_microwave_guidance']['value']=="N/A") echo "checked";?>>
<label for="k_microwave_guidance3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_microwave_guidance_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_microwave_guidance']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="If used to reheat patients food guidance is not available" >
                             
                        </div>

                    </div>

                    <hr>
<h5><span class="audit_txt">26.  Is there a policy regarding restricted public access to the kitchen?<span></h5><br>
<input type="hidden" name="form[k_policy_regarding_main_question]" value=" Is there a policy regarding restricted public access to the kitchen?">

                       

<div class="question">
                        <div class="numb">26.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 There is a policy regarding access to the kitchen
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[k_policy_regarding_question]" value="There is a policy regarding access to the kitchen">
<input type="radio" name="kitchen[k_policy_regarding]" value="yes" id="k_policy_regarding" <?php if($htmldata['kitchen']['data']['k_policy_regarding']['value']=="yes") echo "checked";?>>
<label for="k_policy_regarding">Yes</label>
<input type="radio" name="kitchen[k_policy_regarding]" value="There is no policy regarding access to the kitchen" id="k_policy_regarding2" <?php if($htmldata['kitchen']['data']['k_policy_regarding']['value']=="There is no policy regarding access to the kitchen") echo "checked";?>>
<label for="k_policy_regarding2">No</label>


<input type="radio" name="kitchen[k_policy_regarding]" value="N/A" id="k_policy_regarding3" <?php if($htmldata['kitchen']['data']['k_policy_regarding']['value']=="N/A") echo "checked";?>>
<label for="k_policy_regarding3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[k_policy_regarding_comment]" class="form-control"><?php echo $htmldata['kitchen']['data']['k_policy_regarding']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="There is no policy regarding access to the kitchen" >
                             
                        </div>

                      
                    </div> 
<hr>

                </div>
                <!-- quest-box -->
       





                    
              
               <input class="submit_class" type="submit" value="Submit">
              
               
            </form>
</div>





<div id="tabs-3">

        <form method="post" action="surgeries_cleanliness_audit_report" enctype="multipart/form-data">
             <?php
                   $check = $functions->selectAllPracticeData($_SESSION['currentUser']);
                    $fchk = false; ?>
                 <h3 style="padding-bottom: 22px;font-weight: 800;"> Practice Detail </h3> <br>
                    <div class="contact_right req">
                   <div class="form_1_">
                              
                                 <?php
                                 if (isset($_GET['editId'])) {
                                    $user1 = intval($_SESSION['webUser']['id']);    
                                    @$id =  $_GET['editId'];
                                    $sql  = "SELECT * FROM mock_inspection_report WHERE id = '$id'";
                                    $data = $dbF->getRow($sql);  
                                    // $pid=$data['pid'];
                                    $htmldata=json_decode($data['all_html'],true); 
                                    if($_SESSION['currentUser']!=$data['pid']){
                                        header('Location: login');
                                    }
                                    ?>
                                    <input type="hidden" name="old_id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="pid" value="<?php echo $user1; ?>">
                                   <div class="form_1_side_">Name of the practice</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[name-of-practice]" placeholder="Name of the practice" value="<?php echo $data[name_of_practice];?>" >
                                    </div>
                                    <div class="form_1_side_">Name of the practice manager</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[name-of-practice-manager]" placeholder="Name of the practice manager" value="<?php echo $data[name_of_practice_manager];?>" >
                                    </div>
                                    <div class="form_1_side_">Audit carried out by:</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[audit_carried_out_by]"  placeholder="Audit carried out by" value="<?php echo $data[audit_carried_out_by];?>">
                                    </div>
                                    
                                    <div class="form_1_side_"> Date</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" class="datepickerr" name="form[Date]" placeholder="Date" value="<?php echo $data[date];?>">
                                    </div>
                                    <?php
                                   }
                                   else{
                                        $user1 = intval($_SESSION['currentUser']);
                                  ?>

                                <input type="hidden" name="pid" value="<?php echo $user1; ?>">
                                <input type="hidden" name="form[cleanliness_type]" value="Surgeries" > 
                                    
                                        <input type="hidden" name="form[name-of-practice]" value="<?php echo $check[1] ?>" >
                                    
                                
                                        <input type="hidden" value="<?php echo $check[2] ?>" name="form[name-of-practice-manager]">
                                
                                    <div class="form_1_side_">Audit carried out by: </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[audit_carried_out_by]" value="" placeholder="Audit carried out by" >
                                    </div>
                                    
                                    <div class="form_1_side_">Date</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" class="datepickerr" value="<?php echo date('Y-m-d') ?>" name="form[Date]" placeholder="Date" >
                                    </div>
                                   

<?php
                                   } ?>
                                   <!--  <div class="form_1_side_"></div>
                                    <div class="form_2_side_">
                                        <div id="recaptcha2"></div>
                                    </div> -->
                                   
                                  
                              
                            </div>
                        </div>

                   
                    <hr>
                <div class="quest-box">
                    <div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAABHNCSVQICAgIfAhkiAAABN5JREFUWEflmFtoHGUUx883m7i72d3MqhVBxKY01BvG1IdQ3dmoiCLipaFQsxNvkD4VLAoiCorgixVfSkARo77UzEbEaq0PasG22Wn0oTT1iuCtUosKXmayuew22Tn+v0lnnaabnc00DQluHjI7833n+33/c75zzo6gFf4RK5yPVg9gOm8eWFY1hbCs3kxP0JpVBQHIQYOX9DkzWXo20IOrD5BZ2WnrNz29pGr5jKXzhYNE4mYKraCgx61ebdfqAdxrplKTsWhY4GKiVKb7tKI3f8kVbDXMrxVB14YFhCe/snWt4/8LqOZHb2Pma8IqKJroG3tr5tPzpmBYsIXmLX0MDpl3KSTaGwGF0n/YD2hv1xurGuY2Ieg1pBkRLlHPSzNpo3CchFgbBIjD4OBPl4CtxuHtgp1+VPrLMO9iIcRJ/D/hOM4r433dw+l3j66lU1ODVk67I8ju2ZUkDCDTeCna0tE8M3ldxKHd2FC6urAsoL6Cho387VRoc/FBrRAEJ58HArZKFwtnQz1jlt69S6qmCH55bhzb5IgBmN9j9WWOpfOftTlceQiLbYd7LwUzU4VyQeHQEGAju0wPHe4khcfm2HgfYuveBQ+JYQ5Alkcl5Cw3dU7qm76st0aggmq+sFOw0lXbSOUDqR4C/3epTBCctKG+Zd5PEbodC/dj/Als5opzAqx3SByHn1UUMuHKA1hskuLJy62ejdZCC6rD5vc0S89I16aNEYuEolaYs0U9Cxu1P8EKGuYngpzaCsZTbVQqorFQHmaHDLtP61sQzigYeLbV1rNNckzaczXz+7i3YOMaCBgUg/8pzLdauezBWuOlW0WEhpEnqzCp3WY20kQjONU/oVavD63gYgETxucdCs20+t2Gbr0IuGQ5mmgrbbnhF8+m7OKZnb9svXtNaEA1b74umLbMN4BTCMNau2oUvkMivrIi+J5ib/ZD9yAYhd8EiXcsXduBawPPczi0h6DwLZ6d1HDh7giLfbj/Be53hgas1s4aFlAJhDo08pJQlCfgqv0AdiuDaoygnCmDLGgPMl6PLGvz1fPA8ehNW8/0hwc0Rh5DZdhcy8AMN+9oFjxOVPkZgBURT6zxTrF/Y/7Ycw/Ie2NpLk1IlWNEkXVW7sbjoQGDYtBdcMg8RAp1IwEfw8+FjdUYMwoTTCICZeN+O4CXqSkj7yFU3rBz2rbQgG6pq9PNlGLxvTFF2DQ98SuUTpDD31JLMlMrH7rKTU98jJjscpsLYgXXdSED00xQNwMFTpUvaHFrdbQ8NYb1LsS9WXzdLxzxkaPQj4pD61EKe+DqLIAiciw6mxzGJmWs1lPynAFd1zBNo5u5WqYQeepxKB7xQPyug2qytykDLCbn4Ms0ri/yxuDxi3Yu+5R/TiBgI92MNFghceSM3IfDhfi7U8IArITrUSWeGJCuxyZ+wMJucgbkP8TOk4jJQeluh+m5cV173oMMBGzkkIQZU4U8rX50emoTwmB4PuSyA6rG6AsiGnvVmguHOSV9kLIkuh453UQsO6CbH1l0EWJ2PiQS+0kAtcuQ8FLT2YDYjQzkMG5raI7gJOINHQ3/iRJ3iZxzRkwCrhxtucqr2Svm7Raa3jEckXWlaPJ6f0PhA5RvnZbx477A1GqW0JppZhnRFrVU4BvORVk7D4NXPOC/gCfzRzwZcKQAAAAASUVORK5CYII=); background-repeat: no-repeat; background-position: center;"></div>
                    <h3>Surgeries</h3>
                    <h5><span class="audit_txt">1. Internal windows including frames and sills are clean and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[s_internal_windows_clean_main_question]" value="Internal windows including frames and sills are clean and in a good state of repair?">
<div class="question">
                        <div class="numb">1.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_internal_windows_clean_question]" value="Visibly clean">
<input type="radio" name="surgeries[s_internal_windows_clean]" value="yes" id="s_internal_windows_clean" <?php if($htmldata['surgeries']['data']['s_internal_windows_clean']['value']=="yes") echo "checked";?>>
<label for="s_internal_windows_clean">Yes</label>
<input type="radio" name="surgeries[s_internal_windows_clean]" value="internal windows including frames and sills are not clean" id="s_internal_windows_clean2" <?php if($htmldata['surgeries']['data']['s_internal_windows_clean']['value']=="internal windows including frames and sills are not clean") echo "checked";?>>
<label for="s_internal_windows_clean2">No</label>


<input type="radio" name="surgeries[s_internal_windows_clean]" value="N/A" id="s_internal_windows_clean3" <?php if($htmldata['surgeries']['data']['s_internal_windows_clean']['value']=="N/A") echo "checked";?>>
<label for="s_internal_windows_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_internal_windows_clean_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_internal_windows_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="internal windows including frames and sills are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">1.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Internal glass dividing panels/ windows for visible sign of damage, cracks
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_internal_windows_damage_question]" value="Internal glass dividing panels/ windows for visible sign of damage, cracks">
<input type="radio" name="surgeries[s_internal_windows_damage]" value="yes" id="s_internal_windows_damage" <?php if($htmldata['surgeries']['data']['s_internal_windows_damage']['value']=="yes") echo "checked";?>>
<label for="s_internal_windows_damage">Yes</label>
<input type="radio" name="surgeries[s_internal_windows_damage]" value="internal windows including frames and sills are not good state of repair" id="s_internal_windows_damage2" <?php if($htmldata['surgeries']['data']['s_internal_windows_damage']['value']=="internal windows including frames and sills are not good state of repair") echo "checked";?>>
<label for="s_internal_windows_damage2">No</label>


<input type="radio" name="surgeries[s_internal_windows_damage]" value="N/A" id="s_internal_windows_damage3" <?php if($htmldata['surgeries']['data']['s_internal_windows_damage']['value']=="N/A") echo "checked";?>>
<label for="s_internal_windows_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_internal_windows_damage_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_internal_windows_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="internal windows including frames and sills are not good state of repair" >
                             
                        </div>

                    </div> 
                    <hr>
<h5><span class="audit_txt">2. Window curtains/ blinds are clean and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[s_curtains_clean_main_question]" value="Window curtains/ blinds are clean and in a good state of repair?">
<div class="question">
                        <div class="numb">2.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_curtains_clean_question]" value="Visibly clean">
<input type="radio" name="surgeries[s_curtains_clean]" value="yes" id="s_curtains_clean" <?php if($htmldata['surgeries']['data']['s_curtains_clean']['value']=="yes") echo "checked";?>>
<label for="s_curtains_clean">Yes</label>
<input type="radio" name="surgeries[s_curtains_clean]" value="Window curtains/ blinds are not clean" id="s_curtains_clean2" <?php if($htmldata['surgeries']['data']['s_curtains_clean']['value']=="Window curtains/ blinds are not clean") echo "checked";?>>
<label for="s_curtains_clean2">No</label>


<input type="radio" name="surgeries[s_curtains_clean]" value="N/A" id="s_curtains_clean3" <?php if($htmldata['surgeries']['data']['s_curtains_clean']['value']=="N/A") echo "checked";?>>
<label for="s_curtains_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_curtains_clean_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_curtains_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Window curtains/ blinds are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">2.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage, wear and tear, no rips
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_curtains_damage_question]" value="No visible sign of damage, wear and tear, no rips">
<input type="radio" name="surgeries[s_curtains_damage]" value="yes" id="s_curtains_damage" <?php if($htmldata['surgeries']['data']['s_curtains_damage']['value']=="yes") echo "checked";?>>
<label for="s_curtains_damage">Yes</label>
<input type="radio" name="surgeries[s_curtains_damage]" value="Window curtains/ blinds are not good state of repair" id="s_curtains_damage2" <?php if($htmldata['surgeries']['data']['s_curtains_damage']['value']=="Window curtains/ blinds are not good state of repair") echo "checked";?>>
<label for="s_curtains_damage2">No</label>


<input type="radio" name="surgeries[s_curtains_damage]" value="N/A" id="s_curtains_damage3" <?php if($htmldata['surgeries']['data']['s_curtains_damage']['value']=="N/A") echo "checked";?>>
<label for="s_curtains_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_curtains_damage_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_curtains_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Window curtains/ blinds are not good state of repair" >
                             
                        </div>

                    </div> 
                    <hr>

<h5><span class="audit_txt">3. Flooring is clean, in a good state of repair, made from impermeable material?<span></h5><br>
<input type="hidden" name="form[s_flooring_clean_main_question]" value="Flooring is clean, in a good state of repair, made from impermeable material?">
<div class="question">
                        <div class="numb">3.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean, no build up of residue/ dirt, check edges and corners are free from dust and grit
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_flooring_clean_question]" value="Visibly clean, no build up of residue/ dirt, check edges and corners are free from dust and grit">
<input type="radio" name="surgeries[s_flooring_clean]" value="yes" id="s_flooring_clean" <?php if($htmldata['surgeries']['data']['s_flooring_clean']['value']=="yes") echo "checked";?>>
<label for="s_flooring_clean">Yes</label>
<input type="radio" name="surgeries[s_flooring_clean]" value="Flooring are not clean" id="s_flooring_clean2" <?php if($htmldata['surgeries']['data']['s_flooring_clean']['value']=="Flooring are not clean") echo "checked";?>>
<label for="s_flooring_clean2">No</label>


<input type="radio" name="surgeries[s_flooring_clean]" value="N/A" id="s_flooring_clean3" <?php if($htmldata['surgeries']['data']['s_flooring_clean']['value']=="N/A") echo "checked";?>>
<label for="s_flooring_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_flooring_clean_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_flooring_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Flooring are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">3.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Free from rips and tears, laid correctly
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_flooring_damage_question]" value="Free from rips and tears, laid correctly">
<input type="radio" name="surgeries[s_flooring_damage]" value="yes" id="s_flooring_damage" <?php if($htmldata['surgeries']['data']['s_flooring_damage']['value']=="yes") echo "checked";?>>
<label for="s_flooring_damage">Yes</label>
<input type="radio" name="surgeries[s_flooring_damage]" value="Flooring are not good state of repair" id="s_flooring_damage2" <?php if($htmldata['surgeries']['data']['s_flooring_damage']['value']=="Flooring are not good state of repair") echo "checked";?>>
<label for="s_flooring_damage2">No</label>


<input type="radio" name="surgeries[s_flooring_damage]" value="N/A" id="s_flooring_damage3" <?php if($htmldata['surgeries']['data']['s_flooring_damage']['value']=="N/A") echo "checked";?>>
<label for="s_flooring_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_flooring_damage_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_flooring_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Flooring are not good state of repair" >
                             
                        </div>

                    </div> 
     <!-- question -->
           <div class="question">
                <div class="numb">3.3</div>
                <div class="quest">


<div class="quest-inner">
<div class="q">
Washable and impervious to moisture
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_flooring_impermeable_question]" value="Washable and impervious to moisture">
<input type="radio" name="surgeries[s_flooring_impermeable]" value="yes" id="s_flooring_impermeable" <?php if($htmldata['surgeries']['data']['s_flooring_impermeable']['value']=="yes") echo "checked";?>>
<label for="s_flooring_impermeable">Yes</label>
<input type="radio" name="surgeries[s_flooring_impermeable]" value="flooring are not made from impermeable material" id="s_flooring_impermeable2" <?php if($htmldata['surgeries']['data']['s_flooring_impermeable']['value']=="flooring are not made from impermeable material") echo "checked";?>>
<label for="s_flooring_impermeable2">No</label>


<input type="radio" name="surgeries[s_flooring_impermeable]" value="N/A" id="s_flooring_impermeable3" <?php if($htmldata['surgeries']['data']['s_flooring_impermeable']['value']=="N/A") echo "checked";?>>
<label for="s_flooring_impermeable3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_flooring_impermeable_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_flooring_impermeable']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="flooring are not made from impermeable material" >
                             
                        </div>

                    </div>                     
                        <hr> 

<h5><span class="audit_txt">4. Doors and frames are clean and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[s_doors_clean_main_question]" value="Doors and frames are clean and in a good state of repair?">
<div class="question">
                        <div class="numb">4.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean especially around touch points
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_doors_clean_question]" value="Visibly clean especially around touch points">
<input type="radio" name="surgeries[s_doors_clean]" value="yes" id="s_doors_clean" <?php if($htmldata['surgeries']['data']['s_doors_clean']['value']=="yes") echo "checked";?>>
<label for="s_doors_clean">Yes</label>
<input type="radio" name="surgeries[s_doors_clean]" value="doors and frames are not clean" id="s_doors_clean2" <?php if($htmldata['surgeries']['data']['s_doors_clean']['value']=="doors and frames are not clean") echo "checked";?>>
<label for="s_doors_clean2">No</label>


<input type="radio" name="surgeries[s_doors_clean]" value="N/A" id="s_doors_clean3" <?php if($htmldata['surgeries']['data']['s_doors_clean']['value']=="N/A") echo "checked";?>>
<label for="s_doors_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_doors_clean_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_doors_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="doors and frames are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">4.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 No visible sign of damage, no exposed wood
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_doors_damage_question]" value="No visible sign of damage, no exposed wood">
<input type="radio" name="surgeries[s_doors_damage]" value="yes" id="s_doors_damage" <?php if($htmldata['surgeries']['data']['s_doors_damage']['value']=="yes") echo "checked";?>>
<label for="s_doors_damage">Yes</label>
<input type="radio" name="surgeries[s_doors_damage]" value="doors and frames are not good state of repair" id="s_doors_damage2" <?php if($htmldata['surgeries']['data']['s_doors_damage']['value']=="doors and frames are not good state of repair") echo "checked";?>>
<label for="s_doors_damage2">No</label>


<input type="radio" name="surgeries[s_doors_damage]" value="N/A" id="s_doors_damage3" <?php if($htmldata['surgeries']['data']['s_doors_damage']['value']=="N/A") echo "checked";?>>
<label for="s_doors_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_doors_damage_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_doors_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="doors and frames are not good state of repair" >
                             
                        </div>

                    </div> 
                    <hr>


<h5><span class="audit_txt">5. The room is free from inappropriate items?<span></h5><br>
<input type="hidden" name="form[s_room_inappropriate_main_question]" value="The room is free from inappropriate items?">
<div class="question">
                        <div class="numb">5.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Free from inappropriate items i.e. outdoor clothing, personal belongings
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_room_inappropriate_question]" value="Free from inappropriate items i.e. outdoor clothing, personal belongings">
<input type="radio" name="surgeries[s_room_inappropriate]" value="yes" id="s_room_inappropriate" <?php if($htmldata['surgeries']['data']['s_room_inappropriate']['value']=="yes") echo "checked";?>>
<label for="s_room_inappropriate">Yes</label>
<input type="radio" name="surgeries[s_room_inappropriate]" value="the room is not free from inappropriate items" id="s_room_inappropriate2" <?php if($htmldata['surgeries']['data']['s_room_inappropriate']['value']=="the room is not free from inappropriate items") echo "checked";?>>
<label for="s_room_inappropriate2">No</label>


<input type="radio" name="surgeries[s_room_inappropriate]" value="N/A" id="s_room_inappropriate3" <?php if($htmldata['surgeries']['data']['s_room_inappropriate']['value']=="N/A") echo "checked";?>>
<label for="s_room_inappropriate3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_room_inappropriate_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_room_inappropriate']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="the room is not free from inappropriate items" >
                             
                        </div>

                      
                    </div>               
   
                    <hr>
<h5><span class="audit_txt">6. All equipment and products are stored appropriately?<span></h5><br>
<input type="hidden" name="form[s_equipment_clean_main_question]" value="All equipment and products are stored appropriately?">
<div class="question">
                        <div class="numb">6.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Items stored off the floor, neat and tidy. Is storage sufficient, any inappropriate items on surfaces or on top of cupboards
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_equipment_clean_question]" value="Items stored off the floor, neat and tidy. Is storage sufficient, any inappropriate items on surfaces or on top of cupboards">
<input type="radio" name="surgeries[s_equipment_clean]" value="yes" id="s_equipment_clean" <?php if($htmldata['surgeries']['data']['s_equipment_clean']['value']=="yes") echo "checked";?>>
<label for="s_equipment_clean">Yes</label>
<input type="radio" name="surgeries[s_equipment_clean]" value="equipment and frames are not clean" id="s_equipment_clean2" <?php if($htmldata['surgeries']['data']['s_equipment_clean']['value']=="equipment and frames are not clean") echo "checked";?>>
<label for="s_equipment_clean2">No</label>


<input type="radio" name="surgeries[s_equipment_clean]" value="N/A" id="s_equipment_clean3" <?php if($htmldata['surgeries']['data']['s_equipment_clean']['value']=="N/A") echo "checked";?>>
<label for="s_equipment_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_equipment_clean_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_equipment_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="equipment and frames are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">6.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Decanted products are stored in labelled, sealed containers
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_equipment_damage_question]" value="No visible sign of damage, no exposed wood">
<input type="radio" name="surgeries[s_equipment_damage]" value="yes" id="s_equipment_damage" <?php if($htmldata['surgeries']['data']['s_equipment_damage']['value']=="yes") echo "checked";?>>
<label for="s_equipment_damage">Yes</label>
<input type="radio" name="surgeries[s_equipment_damage]" value="equipment and frames are not good state of repair" id="s_equipment_damage2" <?php if($htmldata['surgeries']['data']['s_equipment_damage']['value']=="equipment and frames are not good state of repair") echo "checked";?>>
<label for="s_equipment_damage2">No</label>


<input type="radio" name="surgeries[s_equipment_damage]" value="N/A" id="s_equipment_damage3" <?php if($htmldata['surgeries']['data']['s_equipment_damage']['value']=="N/A") echo "checked";?>>
<label for="s_equipment_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_equipment_damage_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_equipment_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="equipment and frames are not good state of repair" >
                             
                        </div>

                    </div> 
                    <hr>
<h5><span class="audit_txt">7. A dedicated hand wash sink is available, clean and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[s_sink_clean_main_question]" value="A dedicated hand wash sink is available, clean and in a good state of repair?">
<div class="question">
                        <div class="numb">7.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_sink_clean_question]" value="Visibly clean">
<input type="radio" name="surgeries[s_sink_clean]" value="yes" id="s_sink_clean" <?php if($htmldata['surgeries']['data']['s_sink_clean']['value']=="yes") echo "checked";?>>
<label for="s_sink_clean">Yes</label>
<input type="radio" name="surgeries[s_sink_clean]" value="A dedicated hand wash sink is available are not clean" id="s_sink_clean2" <?php if($htmldata['surgeries']['data']['s_sink_clean']['value']=="A dedicated hand wash sink is available are not clean") echo "checked";?>>
<label for="s_sink_clean2">No</label>


<input type="radio" name="surgeries[s_sink_clean]" value="N/A" id="s_sink_clean3" <?php if($htmldata['surgeries']['data']['s_sink_clean']['value']=="N/A") echo "checked";?>>
<label for="s_sink_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_sink_clean_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_sink_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="A dedicated hand wash sink is available are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">7.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage, cracks, fitted correctly
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_sink_damage_question]" value="No visible sign of damage, no exposed wood">
<input type="radio" name="surgeries[s_sink_damage]" value="yes" id="s_sink_damage" <?php if($htmldata['surgeries']['data']['s_sink_damage']['value']=="yes") echo "checked";?>>
<label for="s_sink_damage">Yes</label>
<input type="radio" name="surgeries[s_sink_damage]" value="A dedicated hand wash sink are not good state of repair" id="s_sink_damage2" <?php if($htmldata['surgeries']['data']['s_sink_damage']['value']=="A dedicated hand wash sink are not good state of repair") echo "checked";?>>
<label for="s_sink_damage2">No</label>


<input type="radio" name="surgeries[s_sink_damage]" value="N/A" id="s_sink_damage3" <?php if($htmldata['surgeries']['data']['s_sink_damage']['value']=="N/A") echo "checked";?>>
<label for="s_sink_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_sink_damage_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_sink_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="A dedicated hand wash sink are not good state of repair" >
                             
                        </div>

                    </div> 
                    <hr>
<h5><span class="audit_txt">8. Taps are clean and in a good state of repair taps?<span></h5><br>
<input type="hidden" name="form[s_taps_clean_main_question]" value="Taps are clean and in a good state of repair taps">
<div class="question">
                        <div class="numb">8.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_taps_clean_question]" value="Visibly clean">
<input type="radio" name="surgeries[s_taps_clean]" value="yes" id="s_taps_clean" <?php if($htmldata['surgeries']['data']['s_taps_clean']['value']=="yes") echo "checked";?>>
<label for="s_taps_clean">Yes</label>
<input type="radio" name="surgeries[s_taps_clean]" value="Taps are not clean" id="s_taps_clean2" <?php if($htmldata['surgeries']['data']['s_taps_clean']['value']=="Taps are not clean") echo "checked";?>>
<label for="s_taps_clean2">No</label>


<input type="radio" name="surgeries[s_taps_clean]" value="N/A" id="s_taps_clean3" <?php if($htmldata['surgeries']['data']['s_taps_clean']['value']=="N/A") echo "checked";?>>
<label for="s_taps_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_taps_clean_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_taps_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Taps are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">8.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_taps_damage_question]" value="No visible sign of damage">
<input type="radio" name="surgeries[s_taps_damage]" value="yes" id="s_taps_damage" <?php if($htmldata['surgeries']['data']['s_taps_damage']['value']=="yes") echo "checked";?>>
<label for="s_taps_damage">Yes</label>
<input type="radio" name="surgeries[s_taps_damage]" value="taps are not in a good state of repair taps" id="s_taps_damage2" <?php if($htmldata['surgeries']['data']['s_taps_damage']['value']=="taps are not in a good state of repair taps") echo "checked";?>>
<label for="s_taps_damage2">No</label>


<input type="radio" name="surgeries[s_taps_damage]" value="N/A" id="s_taps_damage3" <?php if($htmldata['surgeries']['data']['s_taps_damage']['value']=="N/A") echo "checked";?>>
<label for="s_taps_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_taps_damage_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_taps_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="taps are not in a good state of repair taps" >
                             
                        </div>

                    </div> 
 <!-- question -->
                   <div class="question">
                        <div class="numb">8.3</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Free from lime scale
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_taps_scale_question]" value="Free from lime scale">
<input type="radio" name="surgeries[s_taps_scale]" value="yes" id="s_taps_scale" <?php if($htmldata['surgeries']['data']['s_taps_scale']['value']=="yes") echo "checked";?>>
<label for="s_taps_scale">Yes</label>
<input type="radio" name="surgeries[s_taps_scale]" value="taps are not free from lime scale" id="s_taps_scale2" <?php if($htmldata['surgeries']['data']['s_taps_scale']['value']=="taps are not free from lime scale") echo "checked";?>>
<label for="s_taps_scale2">No</label>


<input type="radio" name="surgeries[s_taps_scale]" value="N/A" id="s_taps_scale3" <?php if($htmldata['surgeries']['data']['s_taps_scale']['value']=="N/A") echo "checked";?>>
<label for="s_taps_scale3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_taps_scale_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_taps_scale']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="taps are not free from lime scale" >
                             
                        </div>

                    </div> 

                    <hr>
<h5><span class="audit_txt">9. Ceilings are clean and in a good state of repair?<span></h5><br>
<input type="hidden" name="form[s_ceilings_clean_main_question]" value="Ceilings are clean and in a good state of repair">
<div class="question">
 
                        <div class="numb">9.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Check if visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_ceilings_clean_question]" value="Check if visibly clean">
<input type="radio" name="surgeries[s_ceilings_clean]" value="yes" id="s_ceilings_clean" <?php if($htmldata['surgeries']['data']['s_ceilings_clean']['value']=="yes") echo "checked";?>>
<label for="s_ceilings_clean">Yes</label>
<input type="radio" name="surgeries[s_ceilings_clean]" value="Ceilings is not clean" id="s_ceilings_clean2" <?php if($htmldata['surgeries']['data']['s_ceilings_clean']['value']=="Ceilings is not clean") echo "checked";?>>
<label for="s_ceilings_clean2">No</label>


<input type="radio" name="surgeries[s_ceilings_clean]" value="N/A" id="s_ceilings_clean3" <?php if($htmldata['surgeries']['data']['s_ceilings_clean']['value']=="N/A") echo "checked";?>>
<label for="s_ceilings_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_ceilings_clean_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_ceilings_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Ceilings is not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">9.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage, cracks, flaking paint
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_ceilings_damage_question]" value="No visible sign of damage, cracks, flaking paint">
<input type="radio" name="surgeries[s_ceilings_damage]" value="yes" id="s_ceilings_damage" <?php if($htmldata['surgeries']['data']['s_ceilings_damage']['value']=="yes") echo "checked";?>>
<label for="s_ceilings_damage">Yes</label>
<input type="radio" name="surgeries[s_ceilings_damage]" value="Ceilings are not in a good state of repair ceilings" id="s_ceilings_damage2" <?php if($htmldata['surgeries']['data']['s_ceilings_damage']['value']=="Ceilings are not in a good state of repair ceilings") echo "checked";?>>
<label for="s_ceilings_damage2">No</label>


<input type="radio" name="surgeries[s_ceilings_damage]" value="N/A" id="s_ceilings_damage3" <?php if($htmldata['surgeries']['data']['s_ceilings_damage']['value']=="N/A") echo "checked";?>>
<label for="s_ceilings_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_ceilings_damage_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_ceilings_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Ceilings are not in a good state of repair taps" >
                             
                        </div>

                    </div> 
                      <div class="question">
 <div class="numb">9.3</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Tiles are secure and in place
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_ceilings_secure_question]" value="Tiles are secure and in place">
<input type="radio" name="surgeries[s_ceilings_secure]" value="yes" id="s_ceilings_secure" <?php if($htmldata['surgeries']['data']['s_ceilings_secure']['value']=="yes") echo "checked";?>>
<label for="s_ceilings_secure">Yes</label>
<input type="radio" name="surgeries[s_ceilings_secure]" value="Tiles are not secure and in place" id="s_ceilings_secure2" <?php if($htmldata['surgeries']['data']['s_ceilings_secure']['value']=="Tiles are not secure and in place") echo "checked";?>>
<label for="s_ceilings_secure2">No</label>


<input type="radio" name="surgeries[s_ceilings_secure]" value="N/A" id="s_ceilings_secure3" <?php if($htmldata['surgeries']['data']['s_ceilings_secure']['value']=="N/A") echo "checked";?>>
<label for="s_ceilings_secure3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_ceilings_secure_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_ceilings_secure']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Tiles are not secure and in place" >
                             
                        </div>

                      
                    </div>                          
                        <hr>
<h5><span class="audit_txt">10. Surgery fittings and fixtures are clean, in a good state of repair?<span></h5><br>
<input type="hidden" name="form[s_surgery_clean_main_question]" value="Surgery fittings and fixtures are clean, in a good state of repair?">
<div class="question">

                        <div class="numb">10.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Check if visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_surgery_clean_question]" value="Check if visibly clean">
<input type="radio" name="surgeries[s_surgery_clean]" value="yes" id="s_surgery_clean" <?php if($htmldata['surgeries']['data']['s_surgery_clean']['value']=="yes") echo "checked";?>>
<label for="s_surgery_clean">Yes</label>
<input type="radio" name="surgeries[s_surgery_clean]" value="Surgery fittings and fixtures is not clean" id="s_surgery_clean2" <?php if($htmldata['surgeries']['data']['s_surgery_clean']['value']=="Surgery fittings and fixtures is not clean") echo "checked";?>>
<label for="s_surgery_clean2">No</label>


<input type="radio" name="surgeries[s_surgery_clean]" value="N/A" id="s_surgery_clean3" <?php if($htmldata['surgeries']['data']['s_surgery_clean']['value']=="N/A") echo "checked";?>>
<label for="s_surgery_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_surgery_clean_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_surgery_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Surgery fittings and fixtures is not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">10.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage, cracks, flaking paint
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_surgery_damage_question]" value="No visible sign of damage, cracks, flaking paint">
<input type="radio" name="surgeries[s_surgery_damage]" value="yes" id="s_surgery_damage" <?php if($htmldata['surgeries']['data']['s_surgery_damage']['value']=="yes") echo "checked";?>>
<label for="s_surgery_damage">Yes</label>
<input type="radio" name="surgeries[s_surgery_damage]" value="Surgery fittings and fixtures are not in a good state of repair surgery" id="s_surgery_damage2" <?php if($htmldata['surgeries']['data']['s_surgery_damage']['value']=="Surgery fittings and fixtures are not in a good state of repair surgery") echo "checked";?>>
<label for="s_surgery_damage2">No</label>


<input type="radio" name="surgeries[s_surgery_damage]" value="N/A" id="s_surgery_damage3" <?php if($htmldata['surgeries']['data']['s_surgery_damage']['value']=="N/A") echo "checked";?>>
<label for="s_surgery_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_surgery_damage_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_surgery_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Surgery fittings and fixtures are not in a good state of repair taps" >
                             
                        </div>

                    </div>
<hr>

<h5><span class="audit_txt">11. Dental Equipment are clean, in a good state of repair i.e. Scanner, laser equipment, whitening equipment?<span></h5><br>
<input type="hidden" name="form[s_dental_equipment_clean_main_question]" value="Dental Equipment are clean, in a good state of repair i.e. Scanner, laser equipment, whitening equipment?">
<div class="question">
                       
                        <div class="numb">11.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_dental_equipment_clean_question]" value="visibly clean">
<input type="radio" name="surgeries[s_dental_equipment_clean]" value="yes" id="s_dental_equipment_clean" <?php if($htmldata['surgeries']['data']['s_dental_equipment_clean']['value']=="yes") echo "checked";?>>
<label for="s_dental_equipment_clean">Yes</label>
<input type="radio" name="surgeries[s_dental_equipment_clean]" value="Dental Equipment is not clean" id="s_dental_equipment_clean2" <?php if($htmldata['surgeries']['data']['s_dental_equipment_clean']['value']=="Dental Equipment is not clean") echo "checked";?>>
<label for="s_dental_equipment_clean2">No</label>


<input type="radio" name="surgeries[s_dental_equipment_clean]" value="N/A" id="s_dental_equipment_clean3" <?php if($htmldata['surgeries']['data']['s_dental_equipment_clean']['value']=="N/A") echo "checked";?>>
<label for="s_dental_equipment_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_dental_equipment_clean_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_dental_equipment_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Dental Equipment fittings and fixtures is not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">11.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_dental_equipment_damage_question]" value="No visible sign of damage">
<input type="radio" name="surgeries[s_dental_equipment_damage]" value="yes" id="s_dental_equipment_damage" <?php if($htmldata['surgeries']['data']['s_dental_equipment_damage']['value']=="yes") echo "checked";?>>
<label for="s_dental_equipment_damage">Yes</label>
<input type="radio" name="surgeries[s_dental_equipment_damage]" value="Dental Equipment are not in a good state of repair dental_equipment" id="s_dental_equipment_damage2" <?php if($htmldata['surgeries']['data']['s_dental_equipment_damage']['value']=="Dental Equipment are not in a good state of repair dental_equipment") echo "checked";?>>
<label for="s_dental_equipment_damage2">No</label>


<input type="radio" name="surgeries[s_dental_equipment_damage]" value="N/A" id="s_dental_equipment_damage3" <?php if($htmldata['surgeries']['data']['s_dental_equipment_damage']['value']=="N/A") echo "checked";?>>
<label for="s_dental_equipment_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_dental_equipment_damage_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_dental_equipment_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Dental Equipment are not in a good state of repair taps" >
                             
                        </div>

                    </div>
<hr>
<h5><span class="audit_txt">12. Dental chair, spittoon unit, dental tray, dental chair light is clean?<span></h5><br>
<input type="hidden" name="form[s_dental_chair_clean_main_question]" value=" Dental chair, spittoon unit, dental tray, dental chair light is clean?">
<div class="question">
                       

                        <div class="numb">12.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_dental_chair_clean_question]" value="visibly clean">
<input type="radio" name="surgeries[s_dental_chair_clean]" value="yes" id="s_dental_chair_clean" <?php if($htmldata['surgeries']['data']['s_dental_chair_clean']['value']=="yes") echo "checked";?>>
<label for="s_dental_chair_clean">Yes</label>
<input type="radio" name="surgeries[s_dental_chair_clean]" value="Dental chair, spittoon unit, dental tray, dental chair light is not clean" id="s_dental_chair_clean2" <?php if($htmldata['surgeries']['data']['s_dental_chair_clean']['value']=="Dental chair, spittoon unit, dental tray, dental chair light is not clean") echo "checked";?>>
<label for="s_dental_chair_clean2">No</label>


<input type="radio" name="surgeries[s_dental_chair_clean]" value="N/A" id="s_dental_chair_clean3" <?php if($htmldata['surgeries']['data']['s_dental_chair_clean']['value']=="N/A") echo "checked";?>>
<label for="s_dental_chair_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_dental_chair_clean_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_dental_chair_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Dental chair, spittoon unit, dental tray, dental chair light is not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">12.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_dental_chair_damage_question]" value="No visible sign of damage">
<input type="radio" name="surgeries[s_dental_chair_damage]" value="yes" id="s_dental_chair_damage" <?php if($htmldata['surgeries']['data']['s_dental_chair_damage']['value']=="yes") echo "checked";?>>
<label for="s_dental_chair_damage">Yes</label>
<input type="radio" name="surgeries[s_dental_chair_damage]" value="Dental chair, spittoon unit, dental tray, dental chair light are not in a good state of repair" id="s_dental_chair_damage2" <?php if($htmldata['surgeries']['data']['s_dental_chair_damage']['value']=="Dental chair, spittoon unit, dental tray, dental chair light are not in a good state of repair") echo "checked";?>>
<label for="s_dental_chair_damage2">No</label>


<input type="radio" name="surgeries[s_dental_chair_damage]" value="N/A" id="s_dental_chair_damage3" <?php if($htmldata['surgeries']['data']['s_dental_chair_damage']['value']=="N/A") echo "checked";?>>
<label for="s_dental_chair_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_dental_chair_damage_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_dental_chair_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Dental chair, spittoon unit, dental tray, dental chair light are not in a good state of repair" >
                             
                        </div>

                    </div>
<hr>
<h5><span class="audit_txt">13. Dental units and work surfaces are clean?<span></h5><br>
<input type="hidden" name="form[s_dental_units_clean_main_question]" value="Dental units and work surfaces are clean?">


<div class="question">
                        <div class="numb">13.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
 visibly clean
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_dental_units_clean_question]" value="visibly clean">
<input type="radio" name="surgeries[s_dental_units_clean]" value="yes" id="s_dental_units_clean" <?php if($htmldata['surgeries']['data']['s_dental_units_clean']['value']=="yes") echo "checked";?>>
<label for="s_dental_units_clean">Yes</label>
<input type="radio" name="surgeries[s_dental_units_clean]" value="Dental units and work surfaces are not clean" id="s_dental_units_clean2" <?php if($htmldata['surgeries']['data']['s_dental_units_clean']['value']=="Dental units and work surfaces are not clean") echo "checked";?>>
<label for="s_dental_units_clean2">No</label>


<input type="radio" name="surgeries[s_dental_units_clean]" value="N/A" id="s_dental_units_clean3" <?php if($htmldata['surgeries']['data']['s_dental_units_clean']['value']=="N/A") echo "checked";?>>
<label for="s_dental_units_clean3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_dental_units_clean_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_dental_units_clean']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Dental units and work surfaces are not clean" >
                             
                        </div>

                      
                    </div>               
                  
 <!-- question -->
                   <div class="question">
                        <div class="numb">13.2</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
No visible sign of damage
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_dental_units_damage_question]" value="No visible sign of damage">
<input type="radio" name="surgeries[s_dental_units_damage]" value="yes" id="s_dental_units_damage" <?php if($htmldata['surgeries']['data']['s_dental_units_damage']['value']=="yes") echo "checked";?>>
<label for="s_dental_units_damage">Yes</label>
<input type="radio" name="surgeries[s_dental_units_damage]" value="Dental units and work surfaces are not in a good state of repair" id="s_dental_units_damage2" <?php if($htmldata['surgeries']['data']['s_dental_units_damage']['value']=="Dental units and work surfaces are not in a good state of repair") echo "checked";?>>
<label for="s_dental_units_damage2">No</label>


<input type="radio" name="surgeries[s_dental_units_damage]" value="N/A" id="s_dental_units_damage3" <?php if($htmldata['surgeries']['data']['s_dental_units_damage']['value']=="N/A") echo "checked";?>>
<label for="s_dental_units_damage3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_dental_units_damage_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_dental_units_damage']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Dental units and work surfaces are not in a good state of repair" >
                             
                        </div>

                    </div>
<div class="question">
<div class="numb">13.3</div>
<div class="quest">


<div class="quest-inner">
<div class="q">
If used to reheat patients food guidance is available
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_dental_units_guidance_question]" value="If used to reheat patients food guidance is available">
<input type="radio" name="surgeries[s_dental_units_guidance]" value="yes" id="s_dental_units_guidance" <?php if($htmldata['surgeries']['data']['s_dental_units_guidance']['value']=="yes") echo "checked";?>>
<label for="s_dental_units_guidance">Yes</label>
<input type="radio" name="surgeries[s_dental_units_guidance]" value="If used to reheat patients food guidance is not available" id="s_dental_units_guidance2" <?php if($htmldata['surgeries']['data']['s_dental_units_guidance']['value']=="If used to reheat patients food guidance is not available") echo "checked";?>>
<label for="s_dental_units_guidance2">No</label>


<input type="radio" name="surgeries[s_dental_units_guidance]" value="N/A" id="s_dental_units_guidance3" <?php if($htmldata['surgeries']['data']['s_dental_units_guidance']['value']=="N/A") echo "checked";?>>
<label for="s_dental_units_guidance3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_dental_units_guidance_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_dental_units_guidance']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="If used to reheat patients food guidance is not available" >
                             
                        </div>
</div>
<hr>
<h5><span class="audit_txt">14. Daily surgery logs are completed and up to date?<span></h5><br>
<input type="hidden" name="form[s_daili_surgery_log_main_question]" value="Daily surgery logs are completed and up to date?">
<div class="question">
                       

                        <div class="numb">14.1</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
There are daily surgery loging log present for each surgery
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[s_daili_surgery_log_question]" value="There are daily surgery loging log present for each surgery">
<input type="radio" name="surgeries[s_daili_surgery_log]" value="yes" id="s_daili_surgery_log" <?php if($htmldata['surgeries']['data']['s_daili_surgery_log']['value']=="yes") echo "checked";?>>
<label for="s_daili_surgery_log">Yes</label>
<input type="radio" name="surgeries[s_daili_surgery_log]" value="Daily surgery logs are not completed and not up to date" id="s_daili_surgery_log2" <?php if($htmldata['surgeries']['data']['s_daili_surgery_log']['value']=="Daily surgery logs are not completed and not up to date") echo "checked";?>>
<label for="s_daili_surgery_log2">No</label>


<input type="radio" name="surgeries[s_daili_surgery_log]" value="N/A" id="s_daili_surgery_log3" <?php if($htmldata['surgeries']['data']['s_daili_surgery_log']['value']=="N/A") echo "checked";?>>
<label for="s_daili_surgery_log3">N/A</label>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[s_daili_surgery_log_comment]" class="form-control"><?php echo $htmldata['surgeries']['data']['s_daili_surgery_log']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="Daily surgery logs are not completed and not up to date" >
                             
                        </div>

                      
                    </div>

                </div>
                <!-- quest-box -->
       





                    
              
               <input class="submit_class" type="submit" value="Submit">
              
               
            </form>
    </div>

             <div id="tabs-4">


                         <?php echo '<table class="table table-hover updateTable">
<thead>
<tr>
<th>Audit Carried By</th> 
<th>Date</th>
<th>Score</th>
<th>Audit Type</th>
<th>Action</th>
 
   
</tr>    
</thead>
<tbody class="table_data">';
$user =  intval($_SESSION['currentUser']);
$userW =  intval($_SESSION['webUser']['id']);
$sql = "SELECT * FROM `cleanliness_audit` WHERE `pid` = '$user' OR `pid` = '$userW' ORDER BY `cleanliness_audit`.`id` DESC";
$data = $dbF->getRows($sql);
$cnt  = 0;
foreach ($data as $key => $val) {
$cnt++;
$audit_by=$val['audit_conduct_by'];
$total_score = $val['total_score'];
$id = $val['id'];
$type=$val['cleanliness_type'];
$links="";
$totalp="";
if($type=='Surgeries'){
    $links='surgeries_cleanliness_audit_report?allhtml='.$id;
    $totalp=round($total_score/30*100);
}elseif($type=='Kitchen') {
    $links='kitchen_cleanliness_audit_reports?allhtml='.$id;
    $totalp=round($total_score/65*100);
}elseif ($type=='Reception') {
    $links='reception_cleanliness_audit_reports?allhtml='.$id;
    $totalp=round($total_score/51*100);
}else{}
$date = $val['date'];
echo "<tr>
    <td>" .$audit_by. "</td>
   <td>" .date('d-M-Y',strtotime($date)). "</td>
   <td>" . $totalp . "</td>
   <td>" . $type . "</td>
   <td><a class='apink' href='".$links."' data-toggle='tooltip' title='View' target='_blank' style='    color: #01abbf !important;'><i class='fas fa-eye'></i></a>
    </td>
   ";


echo "</tr>";
}
echo "</tbody></table>";


         ?>





</div>

       

        </div>
        <!-- right_side close -->
        
    </div>
  

<script>



$('.quest span').on('click', function() {
    $(this).parents('.quest').find('.quest-hover').addClass('not');
    $('.quest .quest-hover:not(.not)').slideUp(300);
    $(this).parents('.quest').find('.quest-hover').removeClass('not');
    $(this).parents('.quest').find('.quest-hover').slideToggle(300);

});
$('input[type=radio]').on('click', function() {
    var chk = this.value;
    if (chk == 'yes') {
       //$('.CurrentlyUsing input[type=radio]:eq(1)').isSelected();
      //  $(this).('input[type=radio]:eq(1)').val('null');
      // $(this).('input[type=radio]:eq(1)').hide();

    } else {
      // $('.CurrentlyUsing input[type=radio]:eq(0)').isSelected();
      // $(this).('input[type=radio]:eq(0)').val('null');
      //  $(this).('input[type=radio]:eq(0)').hide();

    }

    // if (chk == 'yes') {
    //     $(this).parents('.question').find('.sh').css("display", "inline-block");
    //     $(this).parents('.question').find('.sh').css("display", "none");
    //     $(this).parents('.question').find('input[type=radio]').val('');
    // } else {
    //     $(this).parents('.question').find('input[type=text]').attr('required', true);
    //     $(this).parents('.question').find('input[type=text]').attr('required', false);
    // }
});
$(document).on('change', '.file input', function() {
    filename = this.files[0].name;
    $(this).parent('div').find('div').text(filename);
});
</script>

<style type="text/css">
.quest-inner{

    display: flex;
}


.quest-hoverComments{

display: none;
}

.health_form form .question .quest {max-width:unset;}


.health_form form .question .quest .quest-inner .inputs {
 
    width: 92px;
}
.health_form form .question .quest .quest-inner .inputs {
     
    width: inherit;
}
</style>


<?php include_once('footer.php'); ?>