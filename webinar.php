<style>
    .webinar_left iframe {
        width: 100%;
        height: 500px;
    }
    
    .presented_by {
        margin-top: 1rem;
        display: flex;
        gap: 2rem;
    }
    .web_img {
        width: 50px;
        height: 50px;
        border-radius: 50px;
        overflow: hidden;
    }
    .web_img img {
        width: 100%;
    }
    
    .webinar_left > img {
        margin: 0 auto;
        display: block;
    }
</style>

<?php 
ob_start();

include("global.php");
global $dbF, $webClass;

?>    
 

<?php

$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);

$wID = "";
// var_dump($_POST);
// if(count($uri_segments) == 3){
//     $wID = $uri_segments[2];
    
// }
if(isset($_POST['form']['id']) && !empty($_POST['form']['id'])){
    $wID = $_POST['form']['id'];
}

$msg = "";
$check = $webClass->webinarFormSubmit();
// var_dump($check);
if ($check) {
    $msg = "Your registration is completed";
}
 ?>
     
  <?php
if ($wID == '' || !$check)
{
?>
        <div class="standard">
            <div class="m-y-50">
                <div id="tabs">
                    <ul>
                        <li>
                            <a href="#webinar"><img src="webImages2/upcoming.svg" alt="">Upcoming Webinar</a>
                        </li>
                        
                        <li>
                            <a href="#trainings"><img src="webImages2/upcoming.svg" alt="">Upcoming Trainings</a>
                        </li>
                        <li>
                            <a href="#recorded_webinar"><img src="webImages2/recorded.svg" alt="">Recorded Webinar</a>
                        </li>


                    </ul>
                    <div id="webinar">
                        <div class="sol-grid">
                            <?php
                            $sql  = "SELECT * from webinar where publish = 1 AND date >= CURDATE() AND type !='training' ORDER BY `date` ASC";
                        $data = $dbF->getRows($sql);
                        foreach ($data as $key => $value) {
        
                                $id      = $value['id'];
                                $heading = translatefromserialize($value['heading']);
                                 $heading_ = translatefromserialize($value['heading']);
                                $zoomLink = translatefromserialize($value['zoomLink']);
                                $PresentedBy = translatefromserialize($value['presented_by']);
                                 $PresentedBy = explode(" ", $PresentedBy);
                                 $strViewname = $PresentedBy[0];
                                if (!empty($value['image']) && $value['image'] != "#") {
                                    
                                $image1     = $value['image'];
                                $image1     = WEB_URL."/images/".$image1;
                                }else{
                                    $image1 = "";
                                }
                                $imageR     = $value['presented_image'];
                                $image2     = WEB_URL."/images/".$imageR;
                                $functions->resizeImage($image2, 'auto',400, false);
                                 if ($value['presented_image'] == "https://smartdentalcompliance.com/images/#" ||trim($value['presented_image']) == ""  || $value['presented_image'] == '#') 
                                      {
                    
                                        $presented_image = WEB_URL."/webImages/d-profile.png";
                                       }
                                       else
                                      {

                                         $presented_image = $image2;



                                        }

                                $desc    = translatefromserialize($value['shortDesc']);
                                $date    = date('d-M-Y', strtotime($value['date']));
                                $duration= $value['duration'];
                                $link    = WEB_URL . "/page-webinar/$id";
                                
                                echo '<div class="col8_left_box box-m-1">
                                <div class="col8_left_box_img boxes-image-in">
                                    <img src="'.$image1.'" alt="">
                                </div>
                                <!-- col8_left_box_img close -->
                                <div class="col8_left_box_txt textex-te">
                                    <h4>'.$heading.'</h4>
                                    <span>Presented by:</span> <span class="name">'.$strViewname.'</span>
                                    <div class="flex_ webBtn">
                                     
                                    
                                    <input type="hidden" value="'.$heading_.'" class="webinarName"/>
                                    <input type="hidden" value="'.$zoomLink.'" class="zoomLink"/>
                                    <input type="hidden" value="'.$id.'" class="webinarId"/>
                                        <a href="javascript:void(0);" class="play-btn register" >Register</a>
                                        <div class="date">
                                            <div>Date:'.$date.'</div>
                                            <div>Lenght: '.$duration.'</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- col8_left_box_txt close -->
                            </div>';
                            }    
                        ?>       
                            
                            <!-- col8_left_box close -->
                        </div>
                    </div>
                    <div id="trainings">
                        <div class="sol-grid">
                            <?php
                            $sql  = "SELECT * from webinar where publish = 1 AND date >= CURDATE() AND type ='training' ORDER BY `date` ASC";
                        $data = $dbF->getRows($sql);
                        foreach ($data as $key => $value) {
        
                                $id      = $value['id'];
                                $heading = translatefromserialize($value['heading']);
                                 $heading_ = translatefromserialize($value['heading']);
                                $zoomLink = translatefromserialize($value['zoomLink']);
                                $PresentedBy = translatefromserialize($value['presented_by']);
                                 $PresentedBy = explode(" ", $PresentedBy);
                                 $strViewname = $PresentedBy[0];
                                if (!empty($value['image']) && $value['image'] != "#") {
                                    
                                $image1     = $value['image'];
                                $image1     = WEB_URL."/images/".$image1;
                                }else{
                                    $image1 = "";
                                }
                                $imageR     = $value['presented_image'];
                                $image2     = WEB_URL."/images/".$imageR;
                                $functions->resizeImage($image2, 'auto',400, false);
                                 if ($value['presented_image'] == "https://smartdentalcompliance.com/images/#" ||trim($value['presented_image']) == ""  || $value['presented_image'] == '#') 
                                      {
                    
                                        $presented_image = WEB_URL."/webImages/d-profile.png";
                                       }
                                       else
                                      {

                                         $presented_image = $image2;



                                        }

                                $desc    = translatefromserialize($value['shortDesc']);
                                $date    = date('d-M-Y', strtotime($value['date']));
                                $duration= $value['duration'];
                                $link    = WEB_URL . "/page-webinar/$id";
                                
                                echo '<div class="col8_left_box box-m-1">
                                <div class="col8_left_box_img boxes-image-in">
                                    <img src="'.$image1.'" alt="">
                                </div>
                                <!-- col8_left_box_img close -->
                                <div class="col8_left_box_txt textex-te">
                                    <h4>'.$heading.'</h4>
                                    <span>Presented by:</span> <span class="name">'.$strViewname.'</span>
                                    <div class="flex_ webBtn">
                                     
                                    
                                    <input type="hidden" value="'.$heading_.'" class="webinarName"/>
                                    <input type="hidden" value="'.$zoomLink.'" class="zoomLink"/>
                                    <input type="hidden" value="'.$id.'" class="webinarId"/>
                                        <a href="javascript:void(0);" class="play-btn register" >Register</a>
                                        <div class="date">
                                            <div>Date:'.$date.'</div>
                                            <div>Lenght: '.$duration.'</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- col8_left_box_txt close -->
                            </div>';
                            }    
                        ?>       
                            
                            <!-- col8_left_box close -->
                        </div>
                    </div>
                    <div id="recorded_webinar">
                        <div class="sol-grid">
                        <?php    
                        $sql  = "SELECT * from webinar where publish = 1 AND date <= CURDATE() ORDER BY `date` DESC";
                        $data = $dbF->getRows($sql);
                        foreach ($data as $key => $value) {
        
                                $id      = $value['id'];
                                $heading = translatefromserialize($value['heading']);
                                $heading_ = translatefromserialize($value['heading']);
                                $zoomLink = translatefromserialize($value['zoomLink']);
                                $PresentedBy = translatefromserialize($value['presented_by']);
                                 $PresentedBy = explode(" ", $PresentedBy);
                                 $strViewname = $PresentedBy[0];
                                if (!empty($value['image']) && $value['image'] != "#") {
                                    
                                $image1     = $value['image'];
                                $image1     = WEB_URL."/images/".$image1;
                                }else{
                                    $image1 = "";
                                }
                                $imageR     = $value['presented_image'];
                                $image2     = WEB_URL."/images/".$imageR;
                                $functions->resizeImage($image2, 'auto',400, false);
                                 if ($value['presented_image'] == "https://smartdentalcompliance.com/images/#" ||trim($value['presented_image']) == ""  || $value['presented_image'] == '#') 
                                      {
                    
                                        $presented_image = WEB_URL."/webImages/d-profile.png";
                                       }
                                       else
                                      {

                                         $presented_image = $image2;



                                        }

                                $desc    = translatefromserialize($value['shortDesc']);
                                $date    = date('d-M-Y', strtotime($value['date']));
                                $duration= $value['duration'];
                                $link    = WEB_URL . "/page-webinar/$id";
                                
                                echo '<div class="col8_left_box box-m-1">
                                <div class="col8_left_box_img boxes-image-in">
                                    <img src="'.$image1.'" alt="">
                                </div>
                                <!-- col8_left_box_img close -->
                                <div class="col8_left_box_txt textex-te">
                                    <h4>'.$heading.'</h4>
                                    <span>Presented by:</span> <span class="name">'.$strViewname.'</span>
                                    <div class="webBtn flex_ ">
                                        <input type="hidden" value="'.$id.'" class="webinarId"/>
                                        <input type="hidden" value="'.$heading_.'" class="webinarName"/>
                                        <input type="hidden" value="'.$zoomLink.'" class="zoomLink"/>
                                        <a href="javascript:void(0);" class="play-btn">Play Now</a>
                                        <div class="date">
                                            <div>Date:'.$date.'</div>
                                            <div>Lenght: '.$duration.'</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- col8_left_box_txt close -->
                            </div>';
                            }    
                        ?>          
                       
                    
                            <!-- col8_left_box close -->
                            
                         


                        </div>
                    </div>


                </div>
            </div>
           
        </div>
    <?php
} else {
    ?>
<?php
    $detailWebinar = "";
    $data_    = array();
    $sql_     = "SELECT * from webinar where id='$wID'";
    $data_    = $dbF->getRow($sql_);

    $imageR_     = $data_['image'];
    $image2_    = WEB_URL."/images/".$imageR_;
    
    $imageR     = $data_['presented_image'];
    $image2     = WEB_URL."/images/".$imageR;
    $functions->resizeImage($image2, 'auto',400, false);
     if ($data_['presented_image'] == "https://smartdentalcompliance.com/images/#" ||trim($data_['presented_image']) == ""  || $data_['presented_image'] == '#') 
          {

            $presented_image = WEB_URL."/webImages/d-profile.png";
           }
           else
          {

             $presented_image = $image2;



            }
    $PresentedBy = translatefromserialize($data_['presented_by']);
     $PresentedBy = explode(" ", $PresentedBy);
     $strViewname = $PresentedBy[0];
    $heading_ = translatefromserialize($data_['heading']);
    $desc_    = translatefromserialize($data_['dsc']);
    $zoomLink = translatefromserialize($data_['zoomLink']);
    $video_    = translatefromserialize($data_['recurring']);
    $large    = translateFromSerialize($data_['dsc']);
    $date_    = date('d-M-Y', strtotime($data_['date']));
    $date2_    = date('Y-m-d', strtotime($data_['date']));
    $current_date=date("Y-m-d");
    if($date2_<$current_date){$heading_='Recorded '.$heading_;}
    // var_dump($video_);
    $btn='<div class="col1_btn webBtn">
    <input type="hidden" value="'.$heading_.'" class="webinarName"/>
    <input type="hidden" value="'.$zoomLink.'" class="zoomLink"/>
                                <a href="javascript:;">Register </a>
                                </div>';
    if($check==true && $date2_<$current_date){

        if($video_==""){
            $prnt='<h4 style="color:red;line-height: 100px;"><b>Video Will be Uploaded Soon</b></h4>';
        }else{
            $prnt=$video_;
            $btn='';
        }                 
    }else{
            $prnt=' <img src="'.$image2_.'" alt="blogger">';
        
    }
    $detailWebinar    .='<div class="webinar_left">
                            <h3 style="padding: 50px;text-align: center;">'.$heading_.'</h3>
                            '.$prnt.'
                            <div class="webinar_txt">
                                <h6> Date : '. $date_ .' </h6>
                                
                                    <label>Presented By:  </label>
                                    <div class="presented_by" >
                                        <div class="web_img">
                                            <img src="'.$presented_image.'">
                                        </div>
                                        <div class="web_txt">                                    
                                            <h2>'.$strViewname.'</h2>
                                        </div>
                                    </div>
                                
                                '.$desc_.'
                            
                            </div>

                            <!-- webinar_txt close -->
                        </div> ';
                        // $btn.
?>    
    <!--Inner Container Starts -->
        <div class="standard">
            <div class="m-y-50">
                    <?php if (!empty($msg)) { ?>
                        <div class="alert alert-info">
                            <?php echo $msg; ?>
                        </div>
                    <?php } ?>
                    <div class="webinar">
                        <!-- blog_left start -->
                        <?php echo $detailWebinar; ?>
                        <!-- blog_left close -->
                        
                    </div>
            </div>
           
        </div>
        <!--Inner Container Ends-->
    <?php
}
?>

<?php // include("footer.php"); ?>

<?php
return ob_get_clean(); ?>