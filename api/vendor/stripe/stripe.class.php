<?php

    class stripe_functions extends webProduct_functions {
        
        private function getStripeSceret(){
            $chk = $this->functions->ibms_setting('StripeTesting');
            if($_SERVER['REMOTE_ADDR']=='173.231.200.172') {
              $chk = 1;
            }
            if($chk == 1){
              $key = $this->functions->ibms_setting('StripeTestSecret');
              return $key;
            }
            else{
              $key = $this->functions->ibms_setting('StripeLiveSecret');
              return $key;
            }
        } 
        
        public function initializeStripe(){
            $STRIPE_PUBLISHABLE_KEY =  $this->STRIPE_PUBLISHABLE_KEY ;
            $STRIPE_SECRET_KEY = $this->getStripeSceret() ;
            \Stripe\Stripe::setApiKey($STRIPE_SECRET_KEY);
        }
        
        
        public function createCustomer($userData = false){
            //  $this->dbF->prnt($userData);
             $this->initializeStripe();
             if($userData != false ){
                
                $email = ( isset($userData['email']) && !empty($userData['email']) ) ? $userData['email'] : '';
                $pName = ( isset($userData['userName']) && !empty($userData['userName']) ) ? $userData['userName'] : '';
                $mobile = ( isset($userData['phone']) && !empty($userData['phone']) ) ? $userData['phone'] : '';
                $address = ( isset($userData['address']) && !empty($userData['address']) ) ? $userData['address'] : '';
                $city = ( isset($userData['city']) && !empty($userData['city']) ) ? $userData['city'] : '';
                
                $customer = \Stripe\Customer::create([
                        'email' => $email,
                        'name' => $pName,
                        'phone' => $mobile,
                        'address' => [
                            'line1' => $address,
                            'city' => $city,
                        ],
                    ]);
                    
                return $customer;    
               }
               
               return "";
             
        }
        
        public function oneOfPaymentStipe($successUrl, $failedUrl , $customerId='' , $orderId="", $userData=false){
            $this->initializeStripe();
            $customer='';
            
           
               
               
            // first create if user is not exists
            // if(empty($customerId) && $userData != false ){
                
                $email = ( isset($userData['email']) && !empty($userData['email']) ) ? $userData['email'] : '';
                $pName = ( isset($userData['userName']) && !empty($userData['userName']) ) ? $userData['userName'] : '';
                $mobile = ( isset($userData['phone']) && !empty($userData['phone']) ) ? $userData['phone'] : '';
                $address = ( isset($userData['address']) && !empty($userData['address']) ) ? $userData['address'] : '';
                $city = ( isset($userData['city']) && !empty($userData['city']) ) ? $userData['city'] : '';
                
                $customer = \Stripe\Customer::create([
                        'email' => $email,
                        'name' => $pName,
                        'phone' => $mobile,
                        'address' => [
                            'line1' => $address,
                            'city' => $city,
                        ],
                    ]);
                
            //   }
               
                // $customerId = (empty($customerId)) ?  $customer->id : $customerId ;
                $customerId =  $customer->id ;
                $proName = ( isset($userData['proName']) && !empty($userData['proName']) ) ? $userData['proName'] : ''; 
                $amount = ( isset($userData['amount']) && !empty($userData['amount']) ) ? $userData['amount'] : 0 ; 
                $amount = $amount *100;
                $quantity = ( isset($userData['quantity']) && !empty($userData['quantity']) ) ? $userData['quantity'] : 1 ; 
                $session = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [ 
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => $proName,
                            ],
                            'unit_amount' => $amount, // Amount in cents
                                ],
                        'quantity' => $quantity,
                        ]],
                        'mode' => 'payment',
                        'customer' => $customerId , // given 
                        'success_url' => $successUrl."?order_id=$orderId&status=success&sessionId={CHECKOUT_SESSION_ID}",
                        'cancel_url' => $failedUrl."?order_id=$orderId&status=failed&sessionId={CHECKOUT_SESSION_ID}",
                    ]);
                    header("Location: " . $session->url);
                    exit;   
            }
            
        public function getSessionData($sessionId=""){
            if($sessionId==""){
                return "";
            }else{
                $this->initializeStripe();
                $session = \Stripe\Checkout\Session::retrieve($sessionId);
                return $session;
            }
        }
        
        public function payRecurringPayment($paymentId, $cutomerId, $amount){
            $this->initializeStripe();
            
            $PaymentData = \Stripe\PaymentIntent::create([ 
              'payment_method_types' => ['us_bank_account'],
              'payment_method' => $paymentId,
              'customer' => $cutomerId,
              'confirm' => true,
              'amount' => $amount, 
              'currency' => 'usd',
            ]);
            
            echo "Payment of '".$amount."' aginst payment id '".$paymentId."' aginst customer id '".$cutomerId."' is ". $PaymentData->status ;
             ;
            
        }
        
        public function recurringPayment($successUrl, $failedUrl , $customerId='' , $orderId="", $userData=false){
            
            
                try{
                
    
                $acc_name = ( isset($userData['accName']) && !empty($userData['accName']) ) ? $userData['accName'] : '';
                $acc_num = ( isset($userData['accNum']) && !empty($userData['accNum']) ) ? $userData['accNum'] : '';
                $routing_num = ( isset($userData['routingNum']) && !empty($userData['routingNum']) ) ? $userData['routingNum'] : '';
                $amount = ( isset($userData['amount']) && !empty($userData['amount']) ) ? $userData['amount'] : '';
                 
                 $this->initializeStripe();
                 $customer_id = '';
                 $customeData = '';
                 
                //  if customer doesn't exist make customer other wise add customer id
                //  if(empty($customerId)){
                   $customeData= $this->createCustomer($userData);
                   $customer_id = $customeData->id;
                //  }else{
                    //  $customer_id = $customerId;
                //  }
                 
                //  var_dump($customer_id , $customeData);
                 $setup_intent = \Stripe\SetupIntent::create([
                  'payment_method_types' => ['us_bank_account'],
                  'customer' => $customer_id,
                  'confirm' => true,
                  'payment_method_options' => [
                    'us_bank_account' => [
                      'verification_method' => 'automatic',
                    ],
                  ],
                  'payment_method_data' => [
                    'type' => 'us_bank_account',
                    'billing_details' => [
                      'name' => $acc_name,
                    ],
                    'us_bank_account' => [
                      'routing_number' => $routing_num,
                      'account_number' => $acc_num,
                      'account_holder_type' => 'individual',
                    ],
                  ],
                    'mandate_data' => [
                    'customer_acceptance' => [
                      'type' => 'offline',
                    ]
                  ],
                ]);
                
                $payment_method = $setup_intent->payment_method;
                
                if(!isset($payment_method) || empty($payment_method)){
                     throw new Exception("Invalid Account Number");
                }else{
                   $success_url = $successUrl."?order_id=$orderId&status=success&pId=$payment_method&sId=$customer_id";
                  header("Location: " . $success_url);
                }
               
            }catch(Exception $err){
                echo $err;
            }    
        }
        
        
        public function checking(){
            echo "Running........... <br>";
        }
        
        public function getCustomerData($cusId=""){
            if(empty($cusId)){
                return "";
            }else{
               $this->initializeStripe();
               $customer = \Stripe\Customer::retrieve($cusId);
               return $customer;
            }
        }
        
        public function inactiveUser($customerID=""){
            try {
                if(empty($customerID)){
                    return -1;
                }else{
                    $this->initializeStripe();
                    // echo $cusId;
                    // Cancel all subscriptions
                    $subscriptions = \Stripe\Subscription::all(['customer' => $customerID]);
                    
                    if($subscriptions->data){
                        foreach ($subscriptions->data as $subscription) {
                            $subscription->cancel();
                        }
                    }
                
                    // Remove payment sources if available
                    $customer = \Stripe\Customer::retrieve($customerID);
                    if ($customer->sources) {
                        $customer->sources->each(function ($source) use ($customer) {
                            $source->delete();
                        });
                    }
                
                    // Delete the customer
                    $customer->delete();
                    
                return 1;
                }
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                // Handle any errors that occur
                echo 'Error: ' . $e->getMessage();
                return 0;
            }
        }
        
        public function allPaymentMethods($cusId = ""){
            if(!empty($cusId) ){
               $STRIPE_SECRET_KEY = $this->getStripeSceret() ;
               $stripe = new \Stripe\StripeClient($STRIPE_SECRET_KEY);
               
                $data = $stripe->paymentMethods->all([
                'customer' => $cusId,
                'type' => 'card',
                ]);
               
                $this->dbF->prnt($data);
            }
            

           
        }
        
        public function detachPaymentMethod($paymentId = ""){
            if(!empty($paymentId)){
                    $STRIPE_SECRET_KEY = $this->getStripeSceret() ;

                    $stripe = new \Stripe\StripeClient($STRIPE_SECRET_KEY);
                    $stripe->paymentMethods->detach(
                      $paymentId,
                      []
                    );
            }
        }
        
    }


?>