<?php
ob_start();
include_once("global.php");
global $webClass;
?>
<div class="inner_content">
<?php
$sql    = "SELECT * FROM client WHERE publish = '1' ORDER BY `sort` ASC ";
$data   =  $dbF->getRows($sql);
foreach ($data as $key => $value) {
    $id         = $value['id'];
    $caption   = $value['client_caption'];
    $title   = translateFromSerialize($value['client_title']);
    $sdesc   = translateFromSerialize($value['client_sheading']);
    $desc   = translateFromSerialize($value['client_shrtDesc']);
    $linkText   = translateFromSerialize($value['client_heading']);
    $duration   = translateFromSerialize($value['duration']);
    $delegates  = translateFromSerialize($value['delegates']);
    $certificates = translateFromSerialize($value['certificates']);
    $availability = translateFromSerialize($value['availability']);
    $image =  WEB_URL."/images/".$value['image'];

if (1) { ?>
<div class="standard">
            <div class="m-y-50">
                <div class="main-heading">
                    <span><?php echo $title?></span>
                    <?php echo $sdesc?>
                </div>
                <div class="package-main">
                    <div class="package-image">
                        <img src="<?php echo $image ?>" alt="">
                        <!--<div class="playbtn">-->
                        <!--    <a data-fancybox href="https://www.youtube.com/watch?v=h2d7maCIOEM">-->
                        <!--        <img src="webImages2/Group 7037.png" alt="">-->
                        <!--    </a>-->
                        <!--</div>-->
                    </div>
                    <div class="package-text">
                        
                        <?php echo $desc?>   
                        
                        
                        <a href="<?php echo WEB_URL."/page-shop"?>"><button class="btn book" ><?php echo $linkText?></button></a>
                        <div class="tiny-card-main">
                            <div class="tiny-card">
                                <img src="webImages2/tiny1.svg" alt="">
                                <div class="tiny-card-text">
                                    <span>Duration</span>
                                    <span><?php echo $duration?></span>
                                </div>
                            </div>
                            <div class="tiny-card">
                                <img src="webImages2/tiny2.svg" alt="">
                                <div class="tiny-card-text">
                                    <span>delegates</span>
                                    <span><?php echo $delegates?></span>
                                </div>
                            </div>
                            <div class="tiny-card">
                                <img src="webImages2/tiny3.svg" alt="">
                                <div class="tiny-card-text">
                                    <span>Certificates</span>
                                    <span><?php echo $certificates?></span>
                                </div>
                            </div>
                            <div class="tiny-card">
                                <img src="webImages2/tiny4.svg" alt="">
                                <div class="tiny-card-text">
                                    <span>Availability</span>
                                    <span><?php echo $availability?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
<?php } else { ?>


<?php }

} ?>
  <div class="standard">
            <div class="m-y-50">
                <div class="main-heading">
                    <span>INTENSIVE COURSE TWIST</span>
                    <h2>Health & Safety, Radiation, Compliance Management, Data Protection</h2>
                    <p>This is a course designed to provide the dental team with knowledge and skills in the main areas of a dental practice. It includes health and safety, radiation, compliance management and data protection.</p>
                </div>
                <div class="package-main">
                    <div class="package-image">
                        <img src="webImages2/medical.webp" alt="">
                        <div class="playbtn">
                            <a data-fancybox href="https://www.youtube.com/watch?v=h2d7maCIOEM">
                                <img src="webImages2/Group 7037.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="package-text">
                        <h4>Core Topics Covered:</h4>
                        <div class="container">
                            <div id="accordion" class="accordion-container">
                                <h4 class="accordion-title open ">Health & Safety</h4>
                                <div class="accordion-content activ_ ">
                                    <ul>
                                        <li>Legislation & regulation of health & Safety</li>
                                        <li> Health & Safety Act </li>
                                        <li> All about risk assessments</li>
                                        <li> Managing Health & Safety issues</li>
                                    </ul>
                                </div>

                                <h4 class="accordion-title">Radiography</h4>
                                <div class="accordion-content">
                                    <ul>
                                        <li>Legislation & regulation of health & Safety</li>
                                        <li> Health & Safety Act </li>
                                        <li> All about risk assessments</li>
                                        <li> Managing Health & Safety issues</li>
                                    </ul>
                                </div>
                                <h4 class="accordion-title">Compliance</h4>
                                <div class="accordion-content">
                                    <ul>
                                        <li>Legislation & regulation of health & Safety</li>
                                        <li> Health & Safety Act </li>
                                        <li> All about risk assessments</li>
                                        <li> Managing Health & Safety issues</li>
                                    </ul>
                                </div>
                                <h4 class="accordion-title">Data Protection</h4>
                                <div class="accordion-content">
                                    <ul>
                                        <li>Legislation & regulation of health & Safety</li>
                                        <li> Health & Safety Act </li>
                                        <li> All about risk assessments</li>
                                        <li> Managing Health & Safety issues</li>
                                    </ul>
                                </div>
                                <h4 class="accordion-title">Data Protection</h4>
                                <div class="accordion-content">
                                    <ul>
                                        <li>Legislation & regulation of health & Safety</li>
                                        <li> Health & Safety Act </li>
                                        <li> All about risk assessments</li>
                                        <li> Managing Health & Safety issues</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo WEB_URL."/page-shop"?>">
                        <button class="btn book">Book Now</button></a>

                    </div>

                </div>

            </div>
        </div>        

<?php return ob_get_clean(); ?>
