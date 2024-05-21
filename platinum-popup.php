<?php
include("global.php");
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
 $id = intval($_SESSION['webUser']['id']);

$sql  = "SELECT * FROM `orders` WHERE `order_user`=? AND `product_id` IN (1,14,22,23,24,82,87,89,90,139,157)  AND  order_mandate != ''  ";
    $data =  $functions->dbF->getRows($sql,array($id));
    // var_dump($data);
    $product_id=@$data[0]['product_id'];
    $price_per_month=@$data[0]['price_per_month']/1.2;
    $sq1Price="SELECT propri_price FROM `product_price_spb` WHERE `propri_prodet_id` IN (90,139,157)";
              $dataPrice=$functions->dbF->getRows($sq1Price,false);
              // var_dump($dataPrice[]);

              $platinum_price=@$dataPrice[0]["propri_price"]-$price_per_month;
              $consult_price=@$dataPrice[1]["propri_price"]-$price_per_month;
              $platinum_Consult_price=@$dataPrice[2]["propri_price"]-$price_per_month;
    // $platinum_price=299-$price_per_month;
    
    // var_dump('price per month',$price_per_month,'price',$platinum_price);
$platinum_Consult='<div class="col-md-6 ">
                <p>Upgrage your app to</p> 
               <h3>PLATINUM CONSULT PACKAGE</h3>
               <ul>
                  <li>All AIOM Platinum Features</li>
                  <li>On-site Training</li>
                  <li>Annual Mock Inspection</li>
                  <li>Compliance Check In Call</li>
                  <li>4 Consultency Days</li>
                  <li>Comprehensive Employment Advise</li>
                  <li>Intensive Reporting Tool</li>
                   
               </ul> 
               <div style=" position: absolute; bottom: 10px;">
               <h3 style="display: inline-block;font-family: "Poppins";font-size: 32px;">An Additional £'.$platinum_Consult_price.'</h3>
               <p style="display: inline-block;">per month + VAT</p>
               <div class="update_button">
                   <a data-fancybox="" id="157" onclick="upgradePackage(this.id)" class="btn explore" target="_blank">Upgrade</a>
               </div>
                </div>
            </div>';
 $platinum=' <div class="col-md-6 ">
               <p>Upgrage your app to</p> 
               <h3>PLATINUM COMPLIANCE PACKAGE</h3>
               <ul>
                   <li>1-year access to All-In-One Management Software
                        <ul>
                            <li>Compliance Management </li>
                            <li> Online CPD Courses </li>
                            <li> HR Management & Rota Scheduling </li>
                            <li>  Mock Inspection </li>
                            <li> Full Compliance Support </li>
                        </ul>
                   </li>
                   <li>Risk Assessment</li>
                   <li>In House Traning</li>
                   <li>Equipment Servicing</li>
                   <li>Radiation Protection Advisor</li>
               </ul> 
               <div style=" position: absolute; bottom: 10px;">
               <h3 style="display: inline-block;font-family: "Poppins";font-size: 32px;">An Additional £'.$platinum_price.'</h3>
               <p style="display: inline-block;">per month + VAT</p>
             
               <div class="update_button">
                   <a data-fancybox="" id="90" onclick="upgradePackage(this.id)" class="btn explore" target="_blank">Upgrade</a>
               </div>
               </div>
            </div>';

$consult='<div class="col-md-6 ">
                <p>Upgrage your app to</p> 
               <h3>SMART CONSULT PACKAGE</h3>
               <ul>
                   <li>Compilance Dashboard </li>
                   <li>Compilance template</li>
                   <li>CPD Courses</li>
                   <li>HR Management</li>
                   <li>Staff Clock In &#38; Out</li>
                   <li>2 Consultancy Days(worth   &#163;500)</li>
                   <li>Complition of Audits by qualified</li>
                   <li>Consultant</li>
                   <li>Annual Mock Inspection</li>
                   <li>Assistant at CQC Insepection</li>
                   
               </ul>
               <div style=" position: absolute; bottom: 10px;">
               <h3 style="display: inline-block;font-family: "Poppins";font-size: 32px;">An Additional £'.$consult_price.'</h3>
               <p style="display: inline-block;">per month + VAT</p>
               <div class="update_button">
                   <a data-fancybox="" id="139" onclick="upgradePackage(this.id)" class="btn explore" target="_blank">Upgrade</a>
               </div>
               </div>

            </div>';

?>

<div class="fixed_side"></div>
<div class="new-popup upgrade-form" style="display:none; background-color: #fdfdfd; color: #000; max-height: 90vh;
    overflow: auto;">

    <div style="    float: right;
    position: absolute;
    top: 8px;
    right: 12px;"><button type="button" class="hvr-pop" onclick="close_newpopup()" style="border: none;background: none"><i class='fas fa-times' style='font-size:24px'></i></button></div>
        <div class="row ">
           
          <?php
              if($product_id==90){
                echo $platinum_Consult;
              }elseif ($product_id==139) {
                echo $platinum.$platinum_Consult;
              }else{
                echo $platinum.$consult;
              }
          ?>  
            
        </div>

    <!--<div class="new-popup-bottom">-->
    <!--    www.smartdentalcompliance.com | 0800 689 1061-->
    <!--</div>-->
</div>
<!-- new-popup -->