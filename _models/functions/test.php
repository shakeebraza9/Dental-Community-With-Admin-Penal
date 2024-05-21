<?php 
    include_once('global.php');
?>

<div class="customprice_div" id="product_price_form">
            <div class="practice-form">
                    <div class="col5_close">
                        <img src="https://php8.imdemo.xyz/dental_community/webImages/close.png?magic=01" alt="" class="hvr-pop">
                    </div>
                    <div class="heading">
                        <h1 id="pro_heading"></h1>
                        <h6>Your details</h6>
                    </div>
                    <div class="inner_pricing_form">
                        
                        <form method="POST" action="orderInvoice.php">
                            <?php $functions->setFormToken('WebOrderReady'); ?>  
                             
                             <input type="hidden" name="productId"  value="13"> 
                             <input type="hidden" name="pname"  value="Up to 25 Users">
                             <input type="hidden" name="price" value="129">
                             <input type="hidden" name="validity" value="0">

                            <!--<input type="hidden" name="contactFormToken" value="645df2757a838">                            -->
                            <div class="inputs_flex">
                                <div class="input-feild booking-form">
                                    <input type="text" placeholder="Practice Name" name="pName" required="">
                                </div>
                                
                                <div class="input-feild booking-form">
                                    <input type="text" placeholder="Practice Number" name="mobile" required="">
                                </div>
    
                            </div>
                            
                            <div class="inputs_flex">
                                <div class="input-feild booking-form">
                                    <input type="text" placeholder="Practice Address" name="address" required="">
                                </div>
                                
                                <div class="input-feild booking-form">
                                    <input type="text" placeholder="Practice City Address" name="city" required="">
                                </div>
                            </div>

                            <div class="input-field additional">
                                <div class="input-feild booking-form">
                                    <input type="email" placeholder="Practice Email Address" name="email" required="">
                                </div>
                            </div>
                            
                             <div class="input-field additional" >
                                <div class="input-feild booking-form">
                                    <input type="checkbox" name="terms_and_condition" id='terms' required="">
                                    <label for="terms">Terms and Conditions</label>
                                </div>
                            </div> 
                            
                            

							<!--<input type="hidden" name="token" id="token" value="03AL8dmw_9XWqTs27Py5SPKZsY36k8L2pW__8xjp7nPwXc-KYR6WYK1blxUBr8hzUx3qcCyYs9WGr0fVadR2SkcXPjc7Y5KIk-9cCHbMroLTh9Aqv-sGrn54_JNxfYk56vYUgz_ibZBjWmd8eaVifu_4G_B9_7RcqX-XIHhV-N4Vk4ZexIjlMDe1qUdL1lndiMPQD7NPugS1cbOxrZmekqY1xw1ykff7kSh_pJ0cWjiOp6-NCS-Gg6XT71Y2JXjhPpghni51SKs5h3SWdQYs12SHlMeXeA46b-9tZW3vvBfW1JZDjTXEOObup4yX-mNPvI3nFV5rKY3ckpXUqUiLO9BmdxCue7Z-29nrRh1WUsaHxoUY-udi4TDgIotSQamWazaKVvFlZRUSvP5Cfdw1tib6teLFY4nVjpoquJfXbHtQGpiC-Pn3aFoaEU4xl_nFcgy_jD41WlQLJZd59Fb_S_Q-vPxuET2WqXey6OdWN5PpxyRfkiAOQQIKHMjzabS3FNEdIweiEc3U75XDv5okuar6_EbNqbixOoQnw1JPctwzTZ6d9BTkastXuBYmYNtA4747ELb0GNwYH7Cd8u8KuokUTZ5CYehUbGkQ">-->
                            <button type="submit" name="name" id="checkoutBtn" class="btn submit-btn hvr-bounce-to-right" >Proceed to Checkout</button>

                        </form>


                    </div>
                </div>
        </div>


