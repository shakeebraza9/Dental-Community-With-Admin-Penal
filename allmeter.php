<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

$msg = $chk1 = $chk2 = $chk3 = "";
$chk1 = $functions->checkin();
$chk2 = $functions->checkout();
$chk3 = $functions->covid();
$chk3 = $functions->newuserWellcome();

if($chk1){
    $msg = "Check In Successfully";
}
if($chk2){
    $msg = "Check Out Successfully";
}

if($chk3){
    $msg = "Covid Form Submit Successfully";
}
include'dashboardheader.php';
  $sql = "SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$_SESSION[currentUser]'";
        $data = $dbF->getRow($sql);
  $allpractices =  explode(',',$data['setting_val']);
  // echo "<pre>";
  // print_r($allpractices);
  // echo "</pre>";
 
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
            <div class="link_menu">
                <span>
                    <img src="<?= WEB_URL?>/webImages/menu.png" alt="">
                </span>
                DashBoard
            </div>
            <!--link_menu close-->
            <!-- <div class="left_side">
                <?php //$active = 'dashboard'; include'dashboardmenu.php';?>
            </div> -->
            <!-- left_side close -->
            <div class="right_side">
                <div data-toggle="tooltip" title="Help Video" style="position: absolute;top: 0;" class="help" onclick="video('EJUtPIhK-Bg')" style="display:none;"><i class="fa fa-question-circle"></i></div>

                <div class="right_side_top">
                    <div class="change-session">
                    <?php
                   
                    //$functions->changeSession();
                    ?>
                    <?php
                    $data = $functions->health_check($_SESSION['currentUser']);
                    if($data && $_SESSION['currentUserType'] !='Employee' || @$_SESSION['superUser']['health_form'] == 'read' || @$_SESSION['superUser']['health_form'] == 'edit' || @$_SESSION['superUser']['health_form'] == 'full')
                    { ?>
                    <div class="col1_btnn">
                        <a href="<?php echo WEB_URL."/health_check_form" ?>">Initial Compliance Health Check form</a>
                    </div>
                    <?php } ?>

                     <?php if($_SESSION['currentUserType'] == 'Master'){?>
                     <div class="col1_btn_practices" style="display: none;">
                        <a href="<?php echo WEB_URL."/main_dashboard" ?>">Practice Dashboard</a>
                     </div>

                    <?php } ?>
                    </div>
                    <!-- change-session -->
<!--<div class="col-12 red_alert alert" style="font-size: 17px;border: 1px solid;color: #353535;background-color: #f3c7c7;border-style: outset;">-->
<!--                       Good News !!! The system is upgrading with some exciting new features, sorry for any inconvenience-->
<!--        <img src="https://smartdentalcompliance.com/new/webImages/logo.png?magic=01" alt="" style="width: 40px;">-->
<!--                    </div>-->
                  
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
                    
                    <!--<a href="profile?page=Profile">-->
                    
                    
                    <!--<div class="col-12 red_alert alert" style="margin-top: 10px">-->
                    <!--    Click Here to change your password and pin-->
                    <!--</div>-->
                    <!--</a>-->
                    <?php } ?>
                    <?php
                    $data = $functions->practice_profile($_SESSION['webUser']['id']);
                    if($data && $_SESSION['currentUserType'] !='Employee')
                    { ?>
                    <!--<a href="practice-profile">-->
                    <!--<div class="col-12 red_alert alert" style="margin-top: 10px">-->
                    <!--    Click here to fill Practice Profile -->
                    <!--</div>-->
                    <!--</a>-->
                    <?php } ?>
                    <?php
                    $sql = "SELECT * FROM `ratingAnswer` WHERE `emp_rating_id` = '$_SESSION[currentUser]' AND `answer` =''";
                        $row = $dbF->getRow($sql);
                    // if(!empty($row) && $_SESSION['currentUserType'] !='Employee'){
                    //     echo '<a href="addRating">
                    //         <div class="col-12 alert alert-warning" style="margin-top: 10px font-weight: bold;">
                    //             Click here to submit your views about coworkers
                    //         </div>
                    //         </a>';
                    // }
                  

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
                         <a href="practice-profile"><i class="fas fa-cog"></i> Click here to fill Practice Profile  <i class="fas fa-arrow-right"></i> </a>
                    <?php } ?>
                      <?php
                    $sql = "SELECT * FROM `ratingAnswer` WHERE `emp_rating_id` = '$_SESSION[currentUser]' AND `answer` =''";
                        $row = $dbF->getRow($sql);
                   if(!empty($row) && $_SESSION['currentUserType'] !='Employee'){
                      ?>
                        <a href="addRating"><i class="fas fa-thumbs-up"></i></i>Click here to submit your views about coworkers<i class="fas fa-arrow-right"></i></a>
                <?php }?>    
                
                        </div>
                        <div>
                           
                    
                    </div>
                        </div>
                        <div class="jumbo-right">
                            <div class=jumbo-v>
                                <img src="webImages/jumbovideo.png">
                                <!-- <a onclick="video('EJUtPIhK-Bg')"><img src="webImages/jumbobtn.svg"></a> -->
                            </div>
                            <div><span>Play a Demo Video</span></div>
                        </div>
                    </div>
                    <!-- jumbo -->
                </div>
                <!-- right_side_top close -->
             
      
                    
               
                    
                  
            
                         <?php  for ($i=0; $i <count($allpractices) ; $i++) { ?>
                          <?php
                $sql2 = "SELECT `acc_name`,acc_id FROM `accounts_user` WHERE `acc_id`='$allpractices[$i]'";
        $data2 = $dbF->getRow($sql2);
                  echo "<h2 style='text-align: center;margin: 20px  0px ;'>".@$data2['acc_name']."</h2>";
                ?>   
                <div class="col22 m-0" <?php echo $display ?>>
                
                    <div class="col2_main ">
                        <?php
                       
$allEvent = $functions->allEvent($allpractices[$i]);
$allApprovedEvent = $functions->allApprovedEvent($allpractices[$i]);
$allMandatoryEvent = $functions->allMandatoryEvent($allpractices[$i]); 
$allRecommendedEvent = $functions->allRecommendedEvent($allpractices[$i]); 
$allMandatoryDueEvent = $functions->allMandatoryDueEvent($allpractices[$i]);
$allMandatoryUnDueEvent = $functions->allMandatoryUnDueEvent($allpractices[$i]);
$allRecommendedDueEvent = $functions->allRecommendedDueEvent($allpractices[$i]);
$allRecommendedUnDueEvent = $functions->allRecommendedUnDueEvent($allpractices[$i]);
$allMandatoryOverDueEvent = $functions->allMandatoryOverDueEvent($allpractices[$i]);
$allRecommendedOverDueEvent = $functions->allRecommendedOverDueEvent($allpractices[$i]);
$MandatoryOverDueEvent = $functions->MandatoryOverDueEvent($allpractices[$i]);
$RecommendedOverDueEvent = $functions->RecommendedOverDueEvent($allpractices[$i]);
$MandatoryDueEvent = $functions->MandatoryDueEvent($allpractices[$i]);
$RecommendedDueEvent = $functions->RecommendedDueEvent($allpractices[$i]);
$allMandatoryApprovedEvent = $functions->allMandatoryApprovedEvent($allpractices[$i]);
$allRecommendedApprovedEvent = $functions->allRecommendedApprovedEvent($allpractices[$i]);
$allMandatoryUnApprovedEvent = $functions->allMandatoryUnApprovedEvent($allpractices[$i]);
$overAllMandatory = $functions->allPercent($allMandatoryApprovedEvent,($allMandatoryDueEvent+$allMandatoryOverDueEvent+$allMandatoryApprovedEvent));
$overAllRecommended =$functions->allPercent($allRecommendedApprovedEvent,($allRecommendedDueEvent+$allRecommendedOverDueEvent+$allRecommendedApprovedEvent));
$allDueEvent = $allMandatoryDueEvent+$allMandatoryOverDueEvent+$allRecommendedDueEvent+$allRecommendedOverDueEvent;
$overAll = $functions->allPercent($allApprovedEvent,$allDueEvent+$allApprovedEvent);



 
        ?>
                        <div class="col2_main_left">
                      
                            <h5>
            Overall Compliance Health (<?php echo @$data2['acc_name']."--".@$data2['acc_id']; ?> )<span><?php echo date('d F Y'); ?></span></h5>
                            <div class="pass">
                                Pass/<span class="fail">Fail</span>
                            </div>
                            <!-- pass -->
                            <div class="highcharts" id="highcharts-<?php echo $allpractices[$i]; ?>"></div>
                            <script>
                            // Chart
                            (function() {
                                var files = ["js/highstock.js", "js/highcharts-more.js", "js/highcharts-3d.js", "js/data.js", "js/funnel.js", "js/annotations.js", "js/solid-gauge.js"],
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
                                                    "color": "#DDDF0D",
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
                                                    "rearLength": "4%",
                                                    "radius": "40%",
                                                    "baseWidth": 34,
                                                    "baseLength": "14%"
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
                                        new Highcharts.Chart("highcharts-<?php echo $allpractices[$i]; ?>", options);
                                    }
                                }
                            })();

                            // Chart
                            </script>
                        </div>
                         
                        <!-- col2_main_left close -->
                        <div class="col2_main_right">
                            <h5>Completed</h5>
                            <div class="box-piesite">
                                <ul>
                                    <li class="design">
                <div class="piesite_" id="" data-pie="<?php echo $overAll ?>"><span><?php  $overAll = explode('.', $overAll);
                echo $overAll[0].'%'; ?></span></div>
                                        <div class="box-piesite_txt">
                                            You have <span> completed
                                                <?php echo $allApprovedEvent ?> out of
                                                <?php echo $allDueEvent+$allApprovedEvent ?> activities</span> and <span>
                                                <?php echo $allMandatoryOverDueEvent+$allRecommendedOverDueEvent ?> overdue activities</span>
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
                                <h5>Mandatory Compliance Activities</h5>
                                <div class="col3_left_main2">
                                          <div><h3>
                                                    <?php echo $allMandatoryOverDueEvent ?>
                                                </h3>
                                                <h4>Over Due</h4></div>
                                    <div class="col3_left_main2_left">
                                        <div class="box-piesite">
                                            <ul>
                                                <li class="design">
                                                    <div class="piesite_" id="" data-pie="<?php echo $overAllMandatory ?>">
                                                  <span>                
                            <?php 
                                    $overAllMandatory = explode('.',$overAllMandatory);
                                                         echo $overAllMandatory[0].'%'; ?>
                                                         </span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- box-piesite close -->
                                    </div>
                                    <!-- col3_left_main2_left close -->
                                    <div> <h3>
                                                    <?php echo $allMandatoryOverDueEvent+$allMandatoryDueEvent ?>
                                                </h3>
                                                <h4>Total Due</h4></div>
                                    <!--<div class="col3_left_main2_right">-->
                                    <!--    <ul>-->
                                    <!--        <li>-->
                                    <!--            <h3>-->
                                    <!--                <?php echo $allMandatoryOverDueEvent ?>-->
                                    <!--            </h3>-->
                                    <!--            <h4>Over Due</h4>-->
                                    <!--        </li>-->
                                    <!--        <li>-->
                                    <!--            <h3>-->
                                    <!--                <?php echo $allMandatoryOverDueEvent+$allMandatoryDueEvent ?>-->
                                    <!--            </h3>-->
                                    <!--            <h4>Total Due</h4>-->
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
                                     <div> <h3>
                                                    <?php echo $allRecommendedOverDueEvent ?>
                                                </h3>
                                                <h4>Over Due</h4></div>
                                    <div class="col3_left_main2_left">
                                        <div class="box-piesite">
                                            <ul>
                                                <li class="design">
                                                    <div class="piesite_" id="" data-pie="<?php echo $overAllRecommended ?>">
                                <span>                       
                           <?php $overAllRecommended = explode('.', $overAllRecommended);
                            echo $overAllRecommended[0].'%'; ?></span>

                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- box-piesite close -->
                                    </div>
                                    <!-- col3_left_main2_left close -->
                                    <div> <h3>
                                                    <?php echo $allRecommendedOverDueEvent+$allRecommendedDueEvent ?>
                                                </h3>
                                                <h4>Total Due</h4></div>
                                    <!--<div class="col3_left_main2_right">-->
                                    <!--    <ul>-->
                                    <!--        <li>-->
                                    <!--            <h3>-->
                                    <!--                <?php echo $allRecommendedOverDueEvent ?>-->
                                    <!--            </h3>-->
                                    <!--            <h4>Over Due</h4>-->
                                    <!--        </li>-->
                                    <!--        <li>-->
                                    <!--            <h3>-->
                                    <!--                <?php echo $allRecommendedOverDueEvent+$allRecommendedDueEvent ?>-->
                                    <!--            </h3>-->
                                    <!--            <h4>Total Due</h4>-->
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
                    <?php } ?>
                <!-- col22 close -->
               
                <!-- col44 close -->
            </div>
            <!-- right_side close -->
        </div>
        <!-- left_right_side -->
<?php include_once('dashboardfooter.php'); ?>