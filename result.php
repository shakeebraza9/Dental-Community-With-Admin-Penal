<?php 
include_once("global.php");
global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
header('Location: login');
}

$msg  = "";



include'dashboardheader.php';




function acc_name($acc_name){
global $db,$dbF;
$sql = "SELECT acc_name FROM accounts_user where acc_id = '$acc_name'";
$data = $dbF->getRow($sql); 
$acc_name = isset($data['acc_name']) ? $data['acc_name'] : "";
return $acc_name;

}



$id = base64_decode($_GET['p']);

?>
<div class="index_content mypage health_form">
    <div class="left_right_side">
        <div class="right_side">
            <div class="right_side_top">
                <?php 

$sql = "SELECT title FROM `questionInstance` WHERE `id` = '$id'";
$row = $dbF->getRow($sql);

 ?>
                <h4>
                    <?php echo $row[0]; ?>
                </h4>
            </div>
            <!-- right_side_top close -->
            <?php if($msg!=''){ ?>
            <div class="col-sm-12 alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <div class="row">
                <?php

$user = $_SESSION['webUser']['id'];
$sq2 = "SELECT id_user FROM `accounts_user_detail` WHERE `setting_name` = 'account_under' and `setting_val` = '$user'";
$row2 = $dbF->getRows($sq2);
if(!empty($row2)){

foreach ($row2 as $key => $val2) {


// echo acc_name($val2['id_user']);


$sql = "SELECT date_timestamp,id,qId,emp_rating_id,eId,AVG(answer) as answer FROM `ratingAnswer` WHERE `eId` = '$val2[id_user]' group by qId";

$row = $dbF->getRows($sql);
?>
                <div class="form-group col-12">
                    <?php

$ttl = '';
$qt = '';
$i =0;
foreach ($row as $key => $value) {
$i++;
$date     = date('Y-M-d',strtotime($value['date_timestamp']));
$view = base64_encode($value['id']);


$ttl .= round($value['answer'],1).",";


$sql = "SELECT title,qc FROM `ratingQuestion` WHERE `id` = '$value[qId]'";
$row = $dbF->getRow($sql);

$qt .= "'$row[qc]',";
?>
                    <div class="quesRating<?php echo $val2['id_user']; ?> btn-default col-sm-12">
                        <div id="quesRating<?php echo $val2['id_user']; ?>" class="graphDiv">
                            <?php //$dashboard->quesRating(); ?>
                        </div>
                    </div>
                    <?php }
$ttl  = trim($ttl,',');
$qt  = trim($qt,',');
?>
                    <script>
                    $(function() {
                        $('#quesRating<?php echo $val2['id_user']; ?>').highcharts({
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: '<?php echo acc_name($val2["id_user"]); ?>'
                            },
                            xAxis: {
                                categories: [<?php echo $qt; ?>],
                                labels: {
                                    rotation: -45,
                                    style: {
                                        fontSize: '14px'
                                    }
                                }
                            },
                            legend: {
                                enabled: false // bottom option show off
                            },
                            yAxis: {
                                min: 0,
                                max: 10,
                                title: {
                                    text: 'Staff Performance'
                                }
                            },
                            tooltip: {
                                headerFormat: '<span style="font-size:10px"><b>{point.key}</b></span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },
                            plotOptions: {
                                column: {
                                    pointPadding: 0,
                                    borderWidth: 0
                                }
                            },
                            series: [{
                                name: 'Question',
                                data: [<?php echo $ttl; ?>],
                                dataLabels: {
                                    enabled: true,
                                    rotation: -90,
                                    color: '#FFFFFF',
                                    align: 'right',
                                    format: '{point.y}',
                                    y: 10, // 10 pixels down from the top
                                    style: {
                                        fontSize: '14px',
                                        fontFamily: 'Verdana, sans-serif'
                                    }
                                }

                            }]
                        });
                    });
                    </script>
                </div>
                <?php
}}





  ?>
                <!-- /////////by question////////// -->
                <?php



$sql = "SELECT * FROM `ratingQuestion` WHERE `pId` = '$user'";
$rowData = $dbF->getRows($sql);
$j=0;
foreach ($rowData as $key => $value) {
	# code...
$j++;



$sql = "SELECT qId,eId,AVG(answer) as answer FROM `ratingAnswer` WHERE `qId` = '$value[id]' and eId IN (SELECT id_user FROM `accounts_user_detail` WHERE `setting_name` = 'account_under' and `setting_val` = '$user') group by eId";

$row = $dbF->getRows($sql);
?>
                <div class="form-group col-12">
                    <?php

$names = '';
$val = '';
foreach ($row as $key => $values) {


$myNames = acc_name($values['eId']);


$names .= "'$myNames',";

$rou = round($values['answer'],1);




$val .= "$rou,";
// var_dump($values);
?>
                    <?php }
$val  = trim($val,',');
$names  = trim($names,',');
?>
                    <div class="quesRatingNew<?php echo $j; ?> btn-default col-sm-12">
                        <div id="quesRatingNew<?php echo $j; ?>" class="graphDiv">
                            <?php //$dashboard->quesRatingNew(); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div> <br>
                    <script>
                    $(function() {
                        $('#quesRatingNew<?php echo $j; ?>').highcharts({
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: '<?php echo $value['title']; ?>'
                            },
                            xAxis: {
                                categories: [<?php echo $names; ?>],
                                labels: {
                                    rotation: -45,
                                    style: {
                                        fontSize: '14px'
                                    }
                                }
                            },
                            legend: {
                                enabled: false // bottom option show off
                            },
                            yAxis: {
                                min: 0,
                                max: 10,
                                title: {
                                    text: 'Staff Performance'
                                }
                            },
                            tooltip: {
                                headerFormat: '<span style="font-size:10px"><b>{point.key}</b></span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },
                            plotOptions: {
                                column: {
                                    pointPadding: 0,
                                    borderWidth: 0
                                }
                            },
                            series: [{
                                name: 'Question',
                                data: [<?php echo $val; ?>],
                                dataLabels: {
                                    enabled: true,
                                    rotation: -90,
                                    color: '#FFFFFF',
                                    align: 'right',
                                    format: '{point.y}',
                                    y: 10, // 10 pixels down from the top
                                    style: {
                                        fontSize: '14px',
                                        fontFamily: 'Verdana, sans-serif'
                                    }
                                }

                            }]
                        });
                    });
                    </script>
                </div>
                <?php
}




  ?>
            </div>
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
</div>
<!-- index_content -->
<?php include_once('dashboardfooter.php'); ?>
<script src="<?php echo WEB_ADMIN_URL ?>/assets/highcharts/js/highstock.js"></script>
<script src="<?php echo WEB_ADMIN_URL ?>/assets/highcharts/js/exporting.js"></script>