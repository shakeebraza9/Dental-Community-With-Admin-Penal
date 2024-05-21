<?php 
include_once("global.php");
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

// include_once('header.php');  

$msg = $chk1 = $chk2 = $chk3 = "";
// $chk1 = $functions->checkin();
// $chk2 = $functions->checkout();
$chk3 = $functions->covid();
$chk4 = $functions->newuserWellcome();
$chk5= $functions->checkin_not_rota_set();
// $chk6 = $functions->lunch_time_checkin();
// $chk7 = $functions->lunch_time_checkout();
if(@$chk1){
    $msg = "Check In Successfully";
}
if(@$chk2){
    $msg = "Check Out Successfully";
}

if(@$chk3){
    $msg = "Covid Form Submit Successfully";
}
if(@$chk5){
    $msg = "Check In Successfully";
}
if(@$chk6){
    $msg = "Lunch In Successfully";
}
if(@$chk7){
    $msg = "lunch Out Successfully";
}
include'dashboardheader.php';

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

$box22 = $webClass->getBox("box22");
$box23 = $webClass->getBox("box23");
$box24 = $webClass->getBox("box24");
$box25 = $webClass->getBox("box25");
$box26 = $webClass->getBox("box26");
$box27 = $webClass->getBox("box27");

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
            <!-- <div class="link_menu">
                    <span>
                        <img src="webImages/menu.png" alt="" />
                    </span>
                    DashBoard
                </div> -->

            <div class="right_side">
                <div data-toggle="tooltip" title="Help Video" style="position: absolute; top: 0" class="help d-none"
                    onclick="video('EJUtPIhK-Bg')">
                    <i class="fa fa-question-circle"></i>
                </div>
                <div class="right_side_top">
                    <!-- <div class="red_alert alert">
                        <a href="#" class="close">×</a>
                        Initial Compliance Health Check form
                    </div>
                    <div class="green_alert alert">
                        <a href="#" class="close">×</a>
                        Initial Compliance Health Check form
                    </div>
                    <div class="yellow_alert alert">
                        <a href="#" class="close">×</a>
                        Initial Compliance Health Check form
                    </div> -->

                    <div class="jumboDash">
                        <div class="left">
                            <div class="cardDiv">
                                <div class="grid-container">
                                    <a href="<?php echo $box22['link']; ?>">
                                        <div class="grid-item item1">
                                            <div class="imgdiv">
                                                <!-- -->
                                                <span class="avatar_title">
                                                    <img src="<?php echo $box22['image']; ?>"
                                                        alt="compliance management" />
                                                </span>
                                            </div>
                                            <h4><?php echo $box22['heading']; ?></h4>
                                        </div>
                                    </a>
                                    <a href="<?php echo $box23['link']; ?>">
                                        <div class="grid-item item2">
                                            <div class="imgdiv">
                                                <span class="avatar_title">
                                                    <img src="<?php echo $box23['image']; ?>" alt="CE Courses" />
                                                </span>
                                            </div>
                                            <h4><?php echo $box23['heading']; ?></h4>
                                        </div>
                                    </a>
                                    <a href="<?php echo $box24['link']; ?>">
                                        <div class="grid-item item3">
                                            <div class="imgdiv">
                                                <span class="avatar_title">
                                                    <img src="<?php echo $box24['image']; ?>" alt="HR management" />
                                                </span>
                                            </div>
                                            <h4><?php echo $box24['heading']; ?></h4>
                                        </div>
                                    </a>
                                    <a href="<?php echo $box25['link']; ?>">
                                        <div class="grid-item item4">
                                            <div class="imgdiv">
                                                <span class="avatar_title">
                                                    <img src="<?php echo $box25['image']; ?>" alt="Stock Management" />
                                                </span>
                                            </div>
                                            <h4><?php echo $box25['heading']; ?></h4>
                                        </div>
                                    </a>
                                    <a href="<?php echo $box26['link']; ?>">
                                        <div class="grid-item item5">
                                            <div class="imgdiv">
                                                <span class="avatar_title">
                                                    <img src="<?php echo $box26['image']; ?>"
                                                        alt="Activity Calender" />
                                                </span>
                                            </div>
                                            <h4><?php echo $box26['heading']; ?></h4>
                                        </div>
                                    </a>
                                    <a href="<?php echo $box27['link']; ?>">
                                        <div class="grid-item item6">
                                            <div class="imgdiv">
                                                <span class="avatar_title">
                                                    <img src="<?php echo $box27['image']; ?>" alt="My Staff" />
                                                </span>
                                            </div>
                                            <h4><?php echo $box27['heading']; ?></h4>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="tablediv">
                                <div class="heading">
                                <?php if ($allMandatoryOverDueEvent > 0): ?>
                                    <div style="color: #2a3042; font-size: 15px !important; margin-top: -15px;" class="alert alert-danger"> <a style="color: red;" href="allMandatoryOverDue">
                                    <i style="color: #2a3042;"  class="fas fa-flag"></i> &nbsp;
                                    You still have <span style="font-weight: bold;"> <?php echo $allMandatoryOverDueEvent ?></span> mandatory activities Which will needs to be completed in order to pass your OSHA inspection
                                    </a></div>
                                    <?php  if($_SESSION['currentUserType'] !='Employee'){ ?>
                                            <a href="addRating">
                                                <div class="p_profile">
                                                <div class="alert_flex">    
                                                   <i class="fas fa-thumbs-up"></i>     Click here to complete your weekly check-in. </div>
                                                
                                                <i class="fas fa-arrow-right" style="margin: 5px;"></i></div>
                                         </a>
                                      <?php  }?>
                                    <?php endif ?>
                                    <h3 style="margin-bottom: -13px">Activities</h3>
                                </div>
                                <div class="tableInner">
                                    <?php 
                                    echo $functions->upcomingActivities();
                                     ?>
                                </div>
                            </div>
                        </div>
                        <div class="right right_flex">
                            <div class="right_main_left">
                                <h5>Our Compliance Health<span><?php echo date('d F Y'); ?></span></h5>
                                <div class="pass">Pass/<span class="fail">Fail</span></div>

                                <div class="highcharts" id="highcharts-d20dd988-0de9-4d4f-8b07-767024feeb79">
                                    <!-- <img src="<?php echo WEB_URL?>/webImages/speedometer.gif" alt="" /> -->
                                </div>
                                <script>
                                    // Chart
                                    (function () {
                                        var files = [
                                            "js/highstock.js",
                                            "js/highcharts-more.js",
                                            "js/highcharts-3d.js",
                                            "js/data.js",
                                            "js/solid-gauge.js",
                                        ], //"js/funnel.js", "js/annotations.js",
                                            loaded = 0;
                                        if (typeof window["HighchartsEditor"] === "undefined") {
                                            window.HighchartsEditor = {
                                                ondone: [cl],
                                                hasWrapped: false,
                                                hasLoaded: false,
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
                                                    if (
                                                        (scripts[i].getAttribute("src") || "").indexOf(
                                                            src
                                                        ) >= 0 ||
                                                        (scripts[i].getAttribute("src") ===
                                                            "js/highcharts.js" &&
                                                            src === "js/highstock.js")
                                                    ) {
                                                        return true;
                                                    }
                                                }
                                            }
                                            return false;
                                        }

                                        function check() {
                                            if (loaded === files.length) {
                                                for (
                                                    var i = 0;
                                                    i < window.HighchartsEditor.ondone.length;
                                                    i++
                                                ) {
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
                                            sc.onload = function () {
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
                                        each(document.querySelectorAll("script"), function (t) {
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
                                                            "color": "#2a3042",
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
                                                            "color": "#a5a5a5",
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
                            <div class="top">
                                <div class="top_heading">
                                    <h5>Latest CE Courses</h5>
                                </div>
                                <?php
                                $sql2 = "SELECT * FROM `subjects` WHERE `publish` = 1 ORDER BY `subject_id` DESC LIMIT 5";
                                $data2 = $dbF->getRows($sql2);
                                ?>

                                <table class="top_table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($data2 as $val){
                                        $subject_title = $val['subject_title'];
                                        $id = $val['subject_id'];
                                        $date = $val['date_timestamp'];
                                        $date = new DateTime($date); 
                                        $date = $date->format('d-m-Y');
                                      echo "
                                            <tr>
                                            <td><a href='" . WEB_URL . "/course?id=$id'>$subject_title</a></td>
                                            <td>$date</td>
                                        </tr>
                                    ";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="refer">
                                <h5>Refer your friend</h5>

                                <div class="inner_refer">
                                    <div class="col1_btn">
                                        <a href="javascript:;" onclick="referfriend();">
                                            Refer a Friend</a>
                                    </div>

                                    <div class="refer_socicn">
                                        <a href="<?php echo $functions->ibms_setting('Facebook');?>">
                                            <i class="fab fa-facebook"></i>
                                        </a>
                                        <a href="<?php echo $functions->ibms_setting('Twitter');?>">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a href="<?php echo $functions->ibms_setting('linkedIn');?>">
                                            <i class="fab fa-linkedin"></i>
                                        </a>

                                        <a href="<?php echo $functions->ibms_setting('Instagram');?>">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style type="text/css">
            .col4_main_left1 span {
                display: none;
            }
        </style>

<?php include_once('dashboardfooter.php'); ?>