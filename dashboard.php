<?php 

include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}
    $user = $_SESSION['webUser']['id'];
// include_once('header.php');
include'dashboardheader.php';

$msg = $chk1 = $chk2 = $chk3 = "";
$chk1 = $functions->checkin();
$chk2 = $functions->checkout();
$chk3 = $functions->covid();
$chk4 = $functions->newuserWellcome();
$chk5= $functions->checkin_not_rota_set();
$chk6 = $functions->lunch_time_checkin();
$chk7 = $functions->lunch_time_checkout();
if($chk1){
    $msg = "Check In Successfully";
}
if($chk2){
    $msg = "Check Out Successfully";
}

if($chk3){
    $msg = "Covid Form Submit Successfully";
}
if($chk5){
    $msg = "Check In Successfully";
}
if($chk6){
    $msg = "Lunch In Successfully";
}
if($chk7){
    $msg = "lunch Out Successfully";
}

$allEvent = $functions->allEvent($_SESSION['currentUser']);
$allApprovedEvent = $functions->allApprovedEvent($_SESSION['currentUser']);
$allMandatoryEvent = $functions->allMandatoryEvent($_SESSION['currentUser']); 
$allRecommendedEvent = $functions->allRecommendedEvent($_SESSION['currentUser']); 
$allMandatoryDueEvent = $functions->allMandatoryDueEvent($_SESSION['currentUser']);
$allMandatoryUnDueEvent = $functions->allMandatoryUnDueEvent($_SESSION['currentUser']);
$allRecommendedDueEvent = $functions->allRecommendedDueEvent($_SESSION['currentUser']);
$allRecommendedUnDueEvent = $functions->allRecommendedUnDueEvent($_SESSION['currentUser']);
$allMandatoryOverDueEvent = $functions->allMandatoryOverDueEvent($_SESSION['currentUser']);
$allRecommendedOverDueEvent = $functions->allRecommendedOverDueEvent($_SESSION['currentUser']);
$MandatoryOverDueEvent = $functions->MandatoryOverDueEvent($_SESSION['currentUser']);
$RecommendedOverDueEvent = $functions->RecommendedOverDueEvent($_SESSION['currentUser']);
$MandatoryDueEvent = $functions->MandatoryDueEvent($_SESSION['currentUser']);
$RecommendedDueEvent = $functions->RecommendedDueEvent($_SESSION['currentUser']);
$allMandatoryApprovedEvent = $functions->allMandatoryApprovedEvent($_SESSION['currentUser']);
$allRecommendedApprovedEvent = $functions->allRecommendedApprovedEvent($_SESSION['currentUser']);
$allMandatoryUnApprovedEvent = $functions->allMandatoryUnApprovedEvent($_SESSION['currentUser']);
$overAllMandatory = $functions->allPercent($allMandatoryApprovedEvent,($allMandatoryDueEvent+$allMandatoryOverDueEvent+$allMandatoryApprovedEvent));
$overAllRecommended =$functions->allPercent($allRecommendedApprovedEvent,($allRecommendedDueEvent+$allRecommendedOverDueEvent+$allRecommendedApprovedEvent));
$allDueEvent = $allMandatoryDueEvent+$allMandatoryOverDueEvent+$allRecommendedDueEvent+$allRecommendedOverDueEvent;
$overAll = $functions->allPercent($allApprovedEvent,$allDueEvent+$allApprovedEvent);

if($functions->health_check($_SESSION['currentUser'])){
$allEvent = 0;
$allApprovedEvent = 0;
$allMandatoryEvent = 0; 
$allRecommendedEvent = 0; 
$allMandatoryDueEvent = 0;
$allMandatoryUnDueEvent = 0;
$allRecommendedDueEvent = 0;
$allRecommendedUnDueEvent = 0;
$allMandatoryOverDueEvent = 0;
$allRecommendedOverDueEvent = 0;
$MandatoryOverDueEvent = 0;
$RecommendedOverDueEvent = 0;
$MandatoryDueEvent = 0;
$RecommendedDueEvent = 0;
$allMandatoryApprovedEvent = 0;
$allRecommendedApprovedEvent = 0;
$allMandatoryUnApprovedEvent = 0;
$overAllRecommended = 0;
$overAllMandatory = 0;
$allDueEvent = 0;
$overAll = 0;
}
$display = null;
if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['cdashboard'] == '0'){
    $display = 'style="display:none;"';
}
?>
<!--<script>
console.log('<?php /*echo "\n".$allEvent." allEvent\n".
$allApprovedEvent." allApprovedEvent\n".
$allDueEvent." allDueEvent\n".
$allMandatoryEvent." allMandatoryEvent\n". 
$allMandatoryDueEvent." allMandatoryDueEvent\n".
$allMandatoryUnDueEvent." allMandatoryUnDueEvent\n".
$allMandatoryOverDueEvent." allMandatoryOverDueEvent\n".
$allMandatoryApprovedEvent." allMandatoryApprovedEvent\n".
$allMandatoryUnApprovedEvent." allMandatoryUnApprovedEvent\n".
$MandatoryOverDueEvent." MandatoryOverDueEvent\n".
$RecommendedOverDueEvent." RecommendedOverDueEvent\n".
$MandatoryDueEvent." MandatoryDueEvent\n".
$RecommendedDueEvent." RecommendedDueEvent\n".
$allRecommendedEvent." allRecommendedEvent\n".
$allRecommendedDueEvent." allRecommendedDueEvent\n".
$allRecommendedUnDueEvent." allRecommendedUnDueEvent\n".
$allRecommendedOverDueEvent." allRecommendedOverDueEvent\n".
$allRecommendedApprovedEvent." allRecommendedApprovedEvent\n".
$overAllMandatory." overAllMandatory\n".
$overAllRecommended." overAllRecommended\n".
$overAll." overAll"*/ ?>');
</script>-->






<div class="index_content mypage">
        <div class="left_right_side">
            
            <!-- left_side close -->
            <div class="right_side">
                <!-- <div data-toggle="tooltip" title="Help Video" style="position: absolute;top: 10px;right: 15px;margin: auto;display: block;" class="help" onclick="video('EJUtPIhK-Bg')"><i class="fa fa-question-circle"></i></div> -->

                <div class="right_side_top">
                    <!-- <h3 class="main-heading_">Compliance Dashboard</h3> -->
                    <div class="change-session">
                    <?php
                    //$functions->changeSession();
                   
                    // $data = $functions->health_check($_SESSION['currentUser']);
                    // if($data && ($_SESSION['currentUserType'] !='Employee' || @$_SESSION['superUser']['health_form'] == 'read' || @$_SESSION['superUser']['health_form'] == 'edit' || @$_SESSION['superUser']['health_form'] == 'full'))
                    // { 
                        ?>
                    <div class="col1_btnn">
                        <a href="<?php echo WEB_URL."/health_check_form" ?>">Initial Compliance Health Check form</a>
                    </div>
                    <?php //} ?>

                     <?php  //if($_SESSION['currentUserType'] == 'Master' ){ ?>
                       <!-- <div class="col1_btn_practices">
                        <a href="<?php //echo WEB_URL."/allmeter" ?>">Practices Dashboard</a>
                    </div> -->

           <?php //}     
                    $userId     = $_SESSION['webUser']['id'];
                    $sQl = "SELECT `onbording` FROM `accounts_user` WHERE `acc_type`= ? AND `acc_id`= ? ";
                    $data = $dbF->getRow($sQl,array(1,$userId));
                    if ((isset($_SESSION['onbordingPracticeStatus']) && $data['onbording'] < 5) || (isset($_SESSION['onbordingStatus']) && $data['onbording'] < 7)) {
                        
                    if (isset($_SESSION['onbordingPracticeStatus'])) {
                        $url = "practice-onboarding";
                    }else if (isset($_SESSION['onbordingStatus'])) {
                        $url = "onboarding";
                    }
                   ?>
                   <div class="onboardBtn" style="display: none;">
                        <a href="<?php echo WEB_URL."/".$url; ?>">Onboarding</a>
                    </div>
                    <?php }  ?>
                    </div>
                    <!-- change-session -->

        <!--             <div class="col-12 red_alert alert" style="font-size: 17px;border: 1px solid;color: #353535;background-color: #f3c7c7;border-style: outset;">-->
        <!--               Good News !!! The system is upgrading with some exciting new features, sorry for any inconvenience-->
        <!--<img src="https://smartdentalcompliance.com/webImages/logo.png?magic=0123" alt="" style="width: 40px;">-->
        <!--            </div>-->
                    
                    <?php if($msg !=''){ ?>
                    <div class="col-sm-12 alert alert-success alert-dismissible" style="margin-top: 10px">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?php echo $msg; ?>
                    </div>
                    <?php } ?>
                    <?php
                    $data = $functions->health_check($_SESSION['currentUser']);
                    if($data && $_SESSION['currentUserType'] !='Employee')
                    { ?>
                    <a href="health_check_form">
                    <div class="col-12 red_alert alert" style="margin-top: 10px">
                        Please Submit Initial Compliance Health Check Form
                    </div>
                    </a>
                    <?php } ?>
                    <?php
                    $data = $functions->user_check($_SESSION['webUser']['id']);
                    if($data)
                    { ?>
                    
                      
                    <a href="profile?page=Profile">
                    <div class="col-12 red_alert alert" style="margin-top: 10px">
                        Click Here to change your password and pin
                    </div>
                    </a>
                    <?php } ?>
                    <?php
                    $data = $functions->practice_profile($_SESSION['webUser']['id']);
                    if($data && $_SESSION['currentUserType'] !='Employee')
                    { ?>
                   
                    <?php } ?>
                    <?php
                    $sql = "SELECT * FROM `ratingAnswer` WHERE `emp_rating_id` = '$_SESSION[currentUser]' AND `answer` =''";
                        $row = $dbF->getRow($sql);
                   


     $dated = date('Y-m-d');

                      $sql = "SELECT * FROM `practiceaddreminder` WHERE `pid` = '$_SESSION[currentUser]' and ffromdate <= '$dated' AND ttodate >= '$dated'";
                        $variable = $dbF->getRows($sql);
                    if(!empty($variable)){

                        foreach ($variable as $key => $valuewarning) {
                            echo '<a href="addReminder">
                            <div class="col-12 alert alert-warning" style="margin-top: 10px">
                           Reminder!     '.$valuewarning['ttitle'].' (Due Date: '.$valuewarning['ttodate'].')
                            </div>
                            </a>';
                        }

 
                        }


                    ?>


                    <?php 



// if ($_SESSION['currentUserType'] !='Employee') {
$u_id = $_SESSION['currentUser'];
// }else
// {
// $u_id = $_SESSION['webUser']['id'];
// }




                         $sqlXX = "SELECT team_image FROM `practiceprofile` WHERE `team_image` != '#' and `user_id` = $u_id";
                        $rowXX = $dbF->getRow($sqlXX);

                        if(!empty($rowXX['team_image'])){ ?>



              <!--<div class="jumbo" style="background-image: url('<?php echo WEB_URL; ?>/images/<?php echo $rowXX['team_image']; ?>') !important;">-->
                    <div class="jumbo flex_">


<?php }else{


$u_id = $_SESSION['webUser']['id'];
$sqlXX = "SELECT team_image FROM `practiceprofile` WHERE `team_image` != '#' and `user_id` = $u_id";
$rowXX = $dbF->getRow($sqlXX);
if(!empty($rowXX['team_image'])){ ?>
<!--<div class="jumbo" style="background-image: url('<?php echo WEB_URL; ?>/images/<?php echo $rowXX['team_image']; ?>') !important;">-->
    <div class="jumbo flex_" >

<?php }else{
?>



 <div class="jumbo flex_">


<?php 
}
} 
?>      <div class="jumbo-left">
                       <div class="inline">
                            <?php
                    $data = $functions->practice_profile($_SESSION['webUser']['id']);
                    if($data && $_SESSION['currentUserType'] !='Employee')
                    { ?>
                    <a class="p_profile href="practice-profile">
                            
                  
                        <div class="alert_flex">
                       <i class="fas fa-cog"></i> Click here to fill Practice Profile</div> 
             
                    <i class="fas fa-arrow-right" style="margin: 5px;"></i>
                    </a>
                    <?php } ?>
                        
                          <?php  if(!empty($row) && $_SESSION['currentUserType'] !='Employee'){ ?>
                        <a class="p_profile" href="addRating">
                            <div class="alert_flex" >
                               <i class="fas fa-thumbs-up"></i>     Click here to complete your weekly check-in. </div>
                            <i class="fas fa-arrow-right" style="margin: 5px;"></i>
                     </a>
                  <?php  }?>
                 
                        </div>
                        <div>
                           <?php if ($allMandatoryOverDueEvent > 0): ?> 
                           <a class="p_profile"  href="allMandatoryOverDue"  class="inline_fw">
                    <div class="alert_flex" >
                    <i  class="fas fa-flag"></i> &nbsp;
                    You still have <span style="font-weight: bold;"> <?php echo $allMandatoryOverDueEvent ?></span> mandatory activities Which will needs to be completed in order to pass your CQC inspection </div>
                   <i class="fas fa-arrow-right"></i> </a>
                     <?php endif ?>
                    </div>
                        </div>
                        <div class="jumbo-right">
                            <div class=jumbo-v>
                                <img src="webImages/jumbovideo.png">
                                <a onclick="video('EJUtPIhK-Bg')"><img src="webImages/jumbobtn.svg"></a>
                            </div>
                            <div><span>Play a Demo Video</span></div>
                        </div>
                    </div>
                    <!-- jumbo -->
                </div>
                <!-- right_side_top close -->
                <div class="col22" <?php echo $display ?>>
                    <div class="col2_main">
                        <div class="col2_main_left">
                            <h5>Overall Compliance Health<span><?php echo date('d F Y'); ?></span></h5>
                            <div class="pass">
                                Pass/<span class="fail">Fail</span>
                            </div>
                            <!-- pass -->
                            <div class="highcharts" id="highcharts-d20dd988-0de9-4d4f-8b07-767024feeb79"></div>
                            <script>
                            // Chart
                            (function() {
                                var files = ["js/highstock.js", "js/highcharts-more.js", "js/highcharts-3d.js", "js/data.js", "js/solid-gauge.js"], //"js/funnel.js", "js/annotations.js", 
                                    loaded = 0;
                                if (typeof window["HighchartsEditor"] === "undefined") {
                                    window.HighchartsEditor = {
                                        ondone: [cl],
                                        hasWrapped: false,
                                        hasLoaded: false
                                    };
                                    include(files[0]);
                                } else {
                                    if (window.HighchartsEditor.hasLoaded) {
                                        cl();
                                    } else {
                                        window.HighchartsEditor.ondone.push(cl);
                                    }
                                }

                                function isScriptAlreadyIncluded(src) {
                                    var scripts = document.getElementsByTagName("script");
                                    for (var i = 0; i < scripts.length; i++) {
                                        if (scripts[i].hasAttribute("src")) {
                                            if ((scripts[i].getAttribute("src") || "").indexOf(src) >= 0 || (scripts[i].getAttribute("src") === "js/highcharts.js" && src === "js/highstock.js")) {
                                                return true;
                                            }
                                        }
                                    }
                                    return false;
                                }

                                function check() {
                                    if (loaded === files.length) {
                                        for (var i = 0; i < window.HighchartsEditor.ondone.length; i++) {
                                            try {
                                                window.HighchartsEditor.ondone[i]();
                                            } catch (e) {
                                                console.error(e);
                                            }
                                        }
                                        window.HighchartsEditor.hasLoaded = true;
                                    }
                                }

                                function include(script) {
                                    function next() {
                                        ++loaded;
                                        if (loaded < files.length) {
                                            include(files[loaded]);
                                        }
                                        check();
                                    }
                                    if (isScriptAlreadyIncluded(script)) {
                                        return next();
                                    }
                                    var sc = document.createElement("script");
                                    sc.src = script;
                                    sc.type = "text/javascript";
                                    sc.onload = function() {
                                        next();
                                    };
                                    document.head.appendChild(sc);
                                }

                                function each(a, fn) {
                                    if (typeof a.forEach !== "undefined") {
                                        a.forEach(fn);
                                    } else {
                                        for (var i = 0; i < a.length; i++) {
                                            if (fn) {
                                                fn(a[i]);
                                            }
                                        }
                                    }
                                }
                                var inc = {},
                                    incl = [];
                                each(document.querySelectorAll("script"), function(t) {
                                    inc[t.src.substr(0, t.src.indexOf("?"))] = 1;
                                });

                                function cl() {
                                    if (typeof window["Highcharts"] !== "undefined") {
                                        var options = {
                                            "chart": {
                                                "type": "gauge",
                                                "plotBackgroundColor": null,
                                                "plotBackgroundImage": null,
                                                "plotBorderWidth": 0,
                                                "plotShadow": false,
                                                "spacingTop": 5,
                                                "spacingBottom": 5,
                                                "colorCount": 10
                                            },
                                            "title": {
                                                "text": "",
                                                "style": {
                                                    "fontFamily": "Default",
                                                    "color": "#333333",
                                                    "fontSize": "22px",
                                                    "fontWeight": "bold",
                                                    "fontStyle": "normal"
                                                }
                                            },
                                            "pane": {
                                                "startAngle": -150,
                                                "endAngle": 90,
                                                "background": [],
                                                "size": 0
                                            },
                                            "yAxis": [{
                                                "min": 0,
                                                "max": <?php echo $allApprovedEvent+$allDueEvent ?>,
                                                "minorTickInterval": "auto",
                                                "minorTickWidth": 1,
                                                "minorTickLength": 4,
                                                "minorTickPosition": "outside",
                                                "minorTickColor": "#ccc",
                                                "tickPixelInterval": 30,
                                                "tickWidth": 2,
                                                "tickPosition": "outside",
                                                "tickLength": 6,
                                                "tickColor": "#aaa",
                                                "labels": {
                                                    "step": 2,
                                                    "rotation": "auto"
                                                },
                                                "title": {
                                                    "text": ""
                                                },
                                                "plotBands": [{
                                                    "from": 0,
                                                    "to": <?php echo $MandatoryOverDueEvent ?>,
                                                    "color": "#DF5353",
                                                    "label": {
                                                        "text": ""
                                                    },
                                                    "thickness": 15
                                                }, {
                                                    "from": <?php echo $MandatoryOverDueEvent ?>,
                                                    "to": <?php echo $MandatoryOverDueEvent+$RecommendedOverDueEvent ?>,
                                                    "color": "#0f75bd",
                                                    "thickness": 15
                                                }, {
                                                    "from": <?php echo $MandatoryOverDueEvent+$RecommendedOverDueEvent ?>,
                                                    "to": <?php echo $MandatoryOverDueEvent+$RecommendedOverDueEvent+$MandatoryDueEvent+$RecommendedDueEvent ?>,
                                                    "color": "#55BF3B",
                                                    "thickness": 15
                                                }]
                                            }],
                                            "series": [{
                                                "turboThreshold": 0,
                                                "tooltip": {
                                                    "valueSuffix": "",
                                                    "style": {
                                                        "fontSize": "12px"
                                                    },
                                                    "borderRadius": 3,
                                                    "borderWidth": 1,
                                                    "enabled": true,
                                                    "headerFormat": "<span style=\"font-size: 10px\">{point.key}</span><br/>",
                                                    "hideDelay": 499,
                                                    "padding": 7,
                                                    "pointFormat": "<span style=\"color:{point.color}\">â—</span> {series.name}: <b>{point.y}</b><br/>"
                                                },
                                                "name": "Speed",
                                                "type": "gauge",
                                                "dataLabels": {
                                                    "style": {
                                                        "fontSize": "22px",
                                                        "textOutline": "none"
                                                    }
                                                },
                                                "dial": {
                                                    "backgroundColor": "#01abbf",
                                                    "rearLength": "3%",
                                                    "radius": "40%",
                                                    "baseWidth": 20,
                                                    "baseLength": "3%"
                                                },
                                                "pivot": {
                                                    "radius": 30,
                                                    "backgroundColor": "#01abbf"
                                                },
                                                "marker": {}
                                            }],
                                            "plotOptions": {
                                                "gauge": {
                                                    "dataLabels": {
                                                        "borderWidth": 0,
                                                        "borderRadius": 10,
                                                        "padding": 10,
                                                        "rotation": 0,
                                                        "y": -18,
                                                        "zIndex": 99,
                                                        "color": "#fff"
                                                    },
                                                    "boostThreshold": 5000
                                                }
                                            },
                                            "data": {
                                                "csv": "\"Category\";\"Speed\"\n\"Completed\";<?php echo $functions->meter($allApprovedEvent,($allMandatoryUnApprovedEvent-$allMandatoryUnDueEvent-$allMandatoryDueEvent)) ?>",
                                                "googleSpreadsheetKey": false,
                                                "googleSpreadsheetWorksheet": false
                                            },
                                            "subtitle": {
                                                "text": ""
                                            },
                                            "tooltip": {
                                                "enabled": false,
                                                "borderWidth": 1
                                            },
                                            "colorAxis": {
                                                "crosshair": {
                                                    "width": 1
                                                },
                                                "labels": {
                                                    "autoRotation": ["0"]
                                                },
                                                "marker": {
                                                    "color": "#212121"
                                                }
                                            },
                                            "rangeSelector": {
                                                "buttonTheme": {
                                                    "padding": 5,
                                                    "height": 18
                                                }
                                            },
                                            "responsive": {
                                                "rules": []
                                            },
                                            "xAxis": [{
                                                "title": {},
                                                "labels": {}
                                            }]
                                        };
                                        new Highcharts.Chart("highcharts-d20dd988-0de9-4d4f-8b07-767024feeb79", options);
                                    }
                                }
                            })();

                            // Chart
                            </script>
                        </div>
                        <!-- col2_main_left close -->
                        <div class="col2_main_right">
                            <h5>Completed Compliance Activities</h5>
                            <div class="box-piesite">
                                <ul>
                                    <li class="design">
                                        <div class="piesite" id="pie_0" data-pie="<?php echo $overAll ?>"></div>
                                        <div class="box-piesite_txt">
                                            You have <a href="<?php echo WEB_URL ?>/overDue?type=completed"> <span>completed
                                                <?php echo $allApprovedEvent ?> out of
                                                <?php echo $allDueEvent+$allApprovedEvent ?> activities</span></a> and <a href="<?php echo WEB_URL ?>/overDue"> <span>
                                                <?php echo $allMandatoryOverDueEvent+$allRecommendedOverDueEvent ?> overdue activities</span></a>
                                            from possible <a href="javascript:;">
                                                <?php echo $allDueEvent ?> to date.</a>
                                        </div>
                                        <!-- box-piesite_txt close -->
                                    </li>
                                </ul>
                            </div>
                            <!-- box-piesite close -->
                        </div>
                        <!-- col2_main_right close -->
                    </div>
                    <!-- col2_main close -->
                    <div class="col33" <?php echo $display ?>>
                        <div class="col33_left">
                            <div class="col33_left_main">
                          
                          

                                 <h5>Mandatory Compliance Activities  </h5>




                                <div class="col3_left_main2">
                                    <div class="col3_left_main2_left">
                                        <div class="box-piesite">
                                               <a href="<?php echo WEB_URL ?>/overDue?type=mandatory"  >
                                            <ul>
                                             
                                                <li class="design">
                                                    <div class="piesite" id="pie_1" data-pie="<?php echo $overAllMandatory ?>" style="cursor:pointer;"></div>
                                                </li>
                                                
                                            </ul>
                                            </a>
                                        </div>
                                        <!-- box-piesite close -->
                                    </div>
                                    <div> 
                                        <h3><?php echo $allMandatoryOverDueEvent ?></h3>
                                        <h4>Over Due</h4>

                                        <h3><?php echo $allMandatoryOverDueEvent+$allMandatoryDueEvent ?>
                                        </h3>
                                        <h4>Total Due</h4>
                                    </div>
                                    <!-- col3_left_main2_left close -->
                                    <!--<div class="col3_left_main2_right">-->
                                    <!--    <ul>-->
                                    <!--        <li>-->
                                                
                                    <!--        </li>-->
                                    <!--        <li>-->
                                               
                                    <!--            <div>(within next 30 days)</div>-->
                                    <!--        </li>-->
                                    <!--    </ul>-->
                                    <!--</div>-->
                                    <!-- col3_left_main2_right close -->
                                   
                                </div>
                                
                                <!-- col3_left_main2 close -->
                                 <h5>Compliant<br><span>Completed
                                            <?php echo $allMandatoryApprovedEvent."/".($allMandatoryEvent-$allMandatoryUnDueEvent) ?> activities</span></h5>
                            </div>
                            <!-- col3_left_main close -->
                        </div>
                        <!-- col3_left close -->
                        <div class="col33_left">
                            <div class="col33_left_main">
                             <h5>Recommended Compliance Activities</h5>
                                <div class="col3_left_main2">
                                    <div class="col3_left_main2_left">
                                        <div class="box-piesite">
                                            <a href="<?php echo WEB_URL ?>/overDue?type=recommended" >
                                            <ul>
                                                
                                                <li class="design">
                                                    <div class="piesite" id="pie_2" data-pie="<?php echo $overAllRecommended ?>"  style="cursor:pointer;"></div>
                                                </li>
                                                
                                            </ul>
                                            </a>
                                        </div>
                                        <!-- box-piesite close -->
                                    </div>
                                    <div>
                                        <h3>
                                            <?php echo $allRecommendedOverDueEvent ?>
                                        </h3>
                                        <h4>Over Due</h4> 
                                        <h3>
                                            <?php echo $allRecommendedOverDueEvent+$allRecommendedDueEvent ?>
                                        </h3>
                                        <h4>Total Due</h4>
                                    </div>
                                    <!-- col3_left_main2_left close -->
                                    <!--<div class="col3_left_main2_right">-->
                                    <!--    <ul>-->
                                    <!--        <li>-->
                                               
                                    <!--        </li>-->
                                    <!--        <li>-->
                                               
                                    <!--            <div>(within next 30 days)</div>-->
                                    <!--        </li>-->
                                    <!--    </ul>-->
                                    <!--</div>-->
                                    <!-- col3_left_main2_right close -->
                                   
                                </div>
                                <!-- col3_left_main2 close -->
                                 <h5>Compliant<br><span>Completed
                                            <?php echo $allRecommendedApprovedEvent."/".($allRecommendedEvent-$allRecommendedUnDueEvent) ?> activities</span></h5>
                            </div>
                            <!-- col3_left_main close -->
                        </div>
                        <!-- col3_left close -->
                    </div>
                    <!-- col33 close -->
                </div>
                <!-- col22 close -->
                <div class="col44">
                    <div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                        <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
                            <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="true" aria-expanded="true">
                                <a href="#tabs-1" id="ui-id-1" class="ui-tabs-anchor" role="presentation" tabindex="-1">My Uploads <span><?php echo $functions->countMyUploads() ?></span></a></li>
                            <li class="src-event">
                                <div class="search">
                                    <input type="text" id="src-event"><i class="fas fa-search"></i>
                                </div>
            
                                <select class="tabs_dropdown" name="cm" id="cm">
                                    <?php echo $functions->eventMyUploadsTitle() ?>
                                </select>
                            </li>
                        </ul>
                        <div id="tabs-1">
                            <div class="col4_main">

                                <div class="col4_main_left">
                                    <ul>
                                       
                                        <?php  echo $functions->eventMyUploads() ?>
                                    </ul>
                                    
                                    
                                 
                                        
                                        
                                </div>
                            </div>
                            <!-- col4_main close -->
                        </div>
                    </div>
                    <!-- tabs close -->
                    <div class="col4_txt_blue">
                        My Uploads
                    </div>
                    <!-- col4_txt_blue close -->
                    <div class="col4_txt_green">
                        Recommended
                    </div>
                    <!-- col4_txt_green close -->
                    <div class="col4_txt_red">
                        Mandatory
                    </div>
                    <!-- col4_txt_red close -->
                </div>
                <!-- col44 close -->
            </div>
            <!-- right_side close -->
        </div>
        <!-- left_right_side -->

            <style type="text/css">
        
        .col4_main_left1 span {
    display: none;
}


    </style>

<script>
// hide the content 
    var div =document.getElementById('mainnn')
    var display=0;
    function hideshow(){
        if(display==1){
            div.style.display='block';
            display = 0;
        }else{
            div.style.display='none';
            display=1;
        }
    }

</script>
    
<?php include_once('dashboardfooter.php'); ?>