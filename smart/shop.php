<?php
ob_start();
include_once("global.php");
global $webClass,$dbF,$productClass;
if(isset($_GET['id'])){ 
    ?>
<script>
$(document).ready((function() {
        selectProduct(<?php echo base64_decode($_GET['id']);?>);
        $("html, body").animate({
            scrollTop: 0
        }, "slow"), $(".background_side").fadeToggle(), $(".col101_cart").fadeToggle(), $("#checkoutBtn").prop("disabled", !0)
}));
</script>
    <?php
}
$chk = $webClass->delegates();

if(isset($_SESSION['url'])){ ?>
    <script>
        $(window).bind('load', function() {$('#iframe').append('<iframe src="<?php echo @$_SESSION['url']?>"/>');});
    </script>
    <?php unset($_SESSION['url']);
}

?>
<div class="fix-side"></div>
<div class="col101 col101_cart">
    <div class="close_popup hvr-pop">
        <i class="fas fa-times"></i>
    </div>
    <!-- close_popup close -->
    <h1></h1>
    <h6>YOUR DETAILS</h6>
    <form id="orderForm" method="post" action="orderInvoice.php">
        <?php $productClass->functions->setFormToken('WebOrderReady');
        $user_id    = $webClass->webUserId();
        $sql        = "SELECT * FROM accounts_user WHERE acc_id = '$user_id'";
        $userData   = $dbF->getRow($sql);
        $sql        = "SELECT * FROM accounts_user_detail WHERE id_user = '$user_id'";
        $userInfo   = $dbF->getRows($sql);
        ?>
        <input type="hidden" name="pname" value="">
        <input type="hidden" name="validity" value="">
        <input type="hidden" name="price" value="">
        <input type="hidden" name="productId" value="">
        <div class="form_input">
            <input type="text" name="full_name" value="<?php echo @$userData['acc_name']; ?>" placeholder="Practice Name" required>
        </div>
        <!-- form_input close -->
        <div class="form_input">
            <input type="phone" name="mobile" value="<?php echo $webClass->webUserInfoArray($userInfo,'phone'); ?>" placeholder="Practice Number" required>
        </div>
        <!-- form_input close -->
        <div class="form_input">
            <input type="text" name="address" value="<?php echo $webClass->webUserInfoArray($userInfo,'address'); ?>" placeholder="Practice Address" required>
        </div>
        <!-- form_input close -->
        <div class="form_input">
            <input type="text" name="city" value="<?php echo $webClass->webUserInfoArray($userInfo,'city'); ?>" placeholder="Practice City Address" required>
        </div>
        <!-- form_input close -->
        <div class="form_input">
            <input type="email" name="email" value="<?php echo @$userData['acc_email']; ?>" placeholder="Practice Email Address" required>
        </div>
        <!-- form_input close -->
        <br>
        <input style="height: 15px;
    display: inline-block;
    vertical-align: middle;
    width: 30px;" type="checkbox" required>
        <a style="display: inline-block;
                vertical-align: middle;z-index: 1;
    position: relative;" 
    href="https://smartdentalcompliance.com/page-terms-and-conditions" target="_blank">Terms and Conditions</a>
    <br><br>
    <div class="form_input">
            <input type="text" name="proof_signature" value="" placeholder="Please Enter your name as a proof of signature" required>
        </div>
    <br>

        <div class="col101_btn_main2">
            <div class="col1_btn">
                <button type="submit" name="submit" id="checkoutBtn" disabled>Proceed to Checkout</button>
            </div>
            <!-- col1_btn close -->
        </div>
        <!-- col101_btn_main2 close -->
    </form>
</div>
<!-- col101 close -->
<div class="col101 col101_cart2">
    <div class="close_popup hvr-pop">
        <i class="fas fa-times"></i>
    </div>
    <!-- close_popup close -->
    <h1></h1>
    <h6>YOUR DETAILS</h6>
    <form id="orderForm" method="post">
        <?php $productClass->functions->setFormToken('delegates'); ?>
        <input type="hidden" name="form[course]" class="pname">


                              <input type="hidden" id="g-delegates" name="g-delegates">
    <input type="hidden" name="action" value="delegates">





        <div class="form_input">
            <input type="text" name="form[name]" placeholder="Name" required>
        </div>
        <!-- form_input close -->
        <div class="form_input">
            <input type="phone" name="form[mobile]" placeholder="Mobile No" required>
        </div>
        <!-- form_input close -->
        <div class="form_input">
            <input type="text" name="form[address]" placeholder="Address" required>
        </div>
        <!-- form_input close -->
        <div class="form_input">
            <input type="text" name="form[city]" placeholder="City" required>
        </div>
        <!-- form_input close -->
        <div class="form_input">
            <input type="email" name="form[email]" placeholder="Email" required>
        </div>
        <!-- form_input close -->
        <div class="form_input">
            <input type="text" name="form[delegates]" placeholder="No. of Delegates" required>
        </div>
        <!-- form_input close -->
        <div class="form_input" style="width: 75%">
            <textarea name="form[delegates]" placeholder="Message"></textarea>
        </div>
        <!-- form_input close -->
        <div class="col101_btn_main2">
        <!--     <div class="form_input">
                <div id="recaptcha2"></div>
            </div> -->
            <!-- form_input close -->
            <!-- <br> -->
            <div class="col1_btn">
                <button type="submit" name="submit" id="checkoutBtn">Submit</button>
            </div>
            <!-- col1_btn close -->
        </div>
        <!-- col101_btn_main2 close -->
    </form>
</div>
<!-- col101 close -->
<script>
function selectProduct(id) {
    var pId = id;
    $.ajax({
        url: 'ajax_call.php?page=selectProduct',
        type: 'post',
        data: { pId: pId }
    }).done(function(res) {
        var parsed = JSON.parse(res);
        pname = parsed.pname;
        validity = parsed.validity;
        price = parsed.price;
        $('.col101_cart h1').text(pname);
        $('input[name=pname]').val(pname);
        $('input[name=validity]').val(validity);
        $('input[name=price]').val(price);
        $('input[name=productId]').val(pId);
        $('#checkoutBtn').prop('disabled',false);
    });
}
</script>
     <div class="main-shop">
            <div class="standard">
                <div id="tabs">
                    <ul>
                        <li>
                            <a href="#tabs-1"><img src="webImages2/tab-soft.svg" alt="">Software</a>
                        </li>
                        <li>
                            <a href="#tabs-2"><img src="webImages2/tab-pkg.svg" alt="">Packages</a>
                        </li>
                        <li>
                            <a href="#tabs-3"><img src="webImages2/tab-courses.svg" alt="">Courses</a>
                        </li>
                        <li>
                            <a href="#tabs-4"><img src="webImages2/tab-service.svg" alt="">Services</a>
                        </li>

                    </ul>
                    <div id="tabs-1">
                        <div class="pricingTable">
                            
                            
                            <ul class="pricingTable-firstTable">

                                
                                   <?php 
                                    $sql = "SELECT `prodet_id` FROM `proudct_detail_spb` WHERE `prodet_id`='139' OR  `prodet_id`='89' OR  `prodet_id`='90' ORDER BY (FIELD(`prodet_id`,89,139,90))";
                                    $data = $dbF->getRows($sql);
                                    foreach ($data as $key => $value) {


                                        // var_dump($value);
                                        echo $productClass->pBox($value['prodet_id'],false,'software');
                                    } ?>
                                   
                            </ul>
                        </div>

                        <a href="javascript:void(0);" class="shop-table-toggle-btn">Complete Feature List<i class="fa-solid fa-chevron-up"></i></a>

                        <div class="shop-table standard" style="transform: scaleY(0); height:0;">
                            <div class="standard">
                                <table class="no-shadow">
                                    <tr>
                                        <th></th>
                                        <th>All-In-One Management Smart Manage</th>
                                        <th>All-In-One Management Smart Consult</th>
                                        <th>All-In-One Management Platinum</th>
                                    </tr>
                                    <tr>
                                        <td>Compliance Health Check Meters</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Automated Digital Activity Calendar</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Over 500+ Digital Compliance Templates</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Digital Mock Inspection</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Compliance Report Feature</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Digital Storage Hub</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Digital Compliance Dashboard</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>CPD Dashboard</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Over 50+ hours Verified CPD Courses</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>HR Employement Dashboard</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Over 100+ HR Templates</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Stock Management Audits</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Annual Mock Inspection</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Annual Health & Safety Risk Assessment</td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Annual Fire Risk Assessment</td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Annual Legionella Risk Assessment</td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>3 years RPA Service</td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Autoclave PVI</td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Compressor PVI</td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>PAT Testing</td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>10% off Training courses</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>10% Equipment Servicing</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>10% Risk Assessments</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>10% RPA Service</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Dedicated Consultant</td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Consultancy Days (Worth £500)</td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""><p style="display: inline-block;">(2 Days/Year)</p></td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Audits By Qualified Consultant</td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>Assistance in CQC Inspection</td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/cross.svg" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td>24/7 Compliance Support</td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                        <td><img src="webImages2/right.svg" alt=""></td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="tabs-2">
                        <div class="sol-grid">
                            <?php 
                        $sql = "SELECT `prodet_id` FROM `proudct_detail_spb` WHERE `product_update`='1' AND `category`='packages'";
                        $data = $dbF->getRows($sql);
                        foreach ($data as $key => $value) {
                            echo $productClass->pBox($value['prodet_id'],false,'packages');
                        } ?> 

                        </div>
                    </div>
                    <div id="tabs-3">
                        <div class="sol-grid">
                            <?php 
                                    $sql = "SELECT `prodet_id` FROM `proudct_detail_spb` WHERE `product_update`='1' AND `category`='courses'";
                                    $data = $dbF->getRows($sql);
                                    foreach ($data as $key => $value) {
                                        echo $productClass->pBox($value['prodet_id'],false,'courses');
                                    } ?>
                            
           



                        </div>
                    </div>
                    <div id="tabs-4">
                        <div class="sol-grid">
                            <?php 
                        $sql = "SELECT `prodet_id` FROM `proudct_detail_spb` WHERE `product_update`='1' AND `category`='services'";
                        $data = $dbF->getRows($sql);
                        foreach ($data as $key => $value) {
                            echo $productClass->pBox($value['prodet_id'],false,'packages');
                        } ?> 
                       </div>
                    </div>

                </div>
                <div class="more-about">
                    <div class="right">
                        <h2>Want to know more about AIOM
                        </h2>
                        <p>Ask about AIOM plans, prices, features or anything else.</p>
                        <a href="">Talk to Sales</a>
                        <a href="">Book a Demo</a>
                    </div>
                </div>
            </div>
        </div>
<?php
return ob_get_clean(); ?>
