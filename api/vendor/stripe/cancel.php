<?php 
     include_once(__DIR__.'/../stripe-php/init.php');
     
    
     function deletePaymentMethod($paymentMethodID ="" , $secret="" ){
            try {
                
                if(empty($paymentMethodID)){
                    return -1;
                }else{
                    $stripe = new \Stripe\StripeClient($secret);
                    $customer = $stripe->paymentMethods->detach( 
                      $paymentMethodID, 
                      []
                    );
                    return 1;
                 }
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                // Handle any errors that occur
                echo 'Error: ' . $e->getMessage();
                return 0;
            }
        }
    
?> 