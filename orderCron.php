<?php
include("global.php");

 // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$gocardless = new gocardless();
$active = $gocardless->__construct();

require 'api/vendor/autoload.php';

if($active == 'LIVE'){
    $client = new \GoCardlessPro\Client([
        'access_token' => getenv('GC_ACCESS_TOKEN'),
        'environment' => \GoCardlessPro\Environment::LIVE
    ]);
}
else{
    $client = new \GoCardlessPro\Client([
        'access_token' => getenv('GC_ACCESS_TOKEN'),
        'environment' => \GoCardlessPro\Environment::SANDBOX
    ]);
}

$msg  = "";
$date = Date('Y-m-d');
$date2 = date('Y-m-d', strtotime("-3 month $date"));


$orders = $dbF->getRows("SELECT * FROM `orders` WHERE `order_status` != 'cancelled' AND `order_customer` != 'manual'");

foreach ($orders as $key => $order) {

	$orderId = $order['order_id'];
	$user 	 = $functions->userName($order['order_user']);
	$mandate = $order['order_mandate'];
	$invoices  = $dbF->getRows("SELECT * FROM `invoices` WHERE `due_date` <= '$date' AND `due_date` >= '$date2' AND `order_id`='$orderId' AND `invoice_status` != 'paid'");
//echo"<pre>";var_dump($invoices);
	foreach ($invoices as $key => $invoice) {

		$paymentId = $invoice['payment_id'];
		$invoiceId = $invoice['invoice_pk'];
		$oprice = $invoice['price'];
		$price = round(($oprice*100),0);
		$ik    = $invoiceId.uniqid();

		if(empty($paymentId)){
			try {
				$payment = $client->payments()->create([
			      "params" => [
			          "amount" => $price, // 10 GBP in pence
			          "currency" => "GBP",
			          "links" => [
			              "mandate" => "$mandate"
			                           // The mandate ID from last section
			          ],
			          // Almost all resources in the API let you store custom metadata,
			          // which you can retrieve later
			          "metadata" => [
			              "invoice_number" => "$ik"
			          ]
			      ],
			      "headers" => [
			          "Idempotency-Key" => "$ik"
			      ]
			    ]);
			    $paymentId = $payment->id;
			    $dbF->setRow("UPDATE `invoices` SET `payment_id` = '$paymentId' WHERE `invoice_pk` = '$invoiceId'");
				echo $msg .= "Payment Create of Amount GBP $oprice of user $user<br>Order Id : $orderId<br>Invoice Id : $invoiceId<br>Payment ID : $paymentId<br><br>";
			} catch (\GoCardlessPro\Core\Exception\ApiException $e) {}
			catch (\GoCardlessPro\Core\Exception\MalformedResponseException $e) {}
			catch (\GoCardlessPro\Core\Exception\ApiConnectionException $e) {}
		}
		else{

			try {
				$payment = $client->payments()->get($paymentId);
				$paymentStatus = $payment->status;

				if($paymentStatus == 'confirmed' || $paymentStatus == 'paid_out'){
					$dbF->setRow("UPDATE `invoices` SET `invoice_status`='paid' WHERE `invoice_pk`='$invoiceId'");
					echo $msg .= "Payment Receive of Amount GBP $oprice of user $user<br>Order Id : $orderId<br>Invoice ID : $invoiceId<br>Payment ID : $paymentId<br><br>";
				}
				else{
					$dbF->setRow("UPDATE `invoices` SET `invoice_status`='$paymentStatus' WHERE `invoice_pk`='$invoiceId'");
				}
			} catch (\GoCardlessPro\Core\Exception\ApiException $e) {}
			catch (\GoCardlessPro\Core\Exception\MalformedResponseException $e) {}
			catch (\GoCardlessPro\Core\Exception\ApiConnectionException $e) {}
		}
	}
}

	$email = $functions->ibms_setting('Email');
if(!empty($msg)){
	$functions->send_mail($email,'Order Management',$msg);
	$functions->send_mail('mobashir@imedia.com.pk','Cron Check',$msg);
}

    $return1 = $functions->someDayOfSignup("someDayOfSignup",1);
    $return2 = $functions->someDayOfSignup("someDayOfSignup",5);
    $return3 = $functions->someDayOfSignup("someDayOfSignup",10);
    $return4 = $functions->someDayOfSignup("someDayOfSignup",15);
    $return5 = $functions->someDayOfSignup("someDayOfSignup",90);
    $return6 = $functions->someDayOfSignup("someDayOfSignup",180);
    $return7 = $functions->someDayOfSignup("someDayOfSignup",365);

    $table ='<table border="1">
                <tr>
                    <td>User Name</td>
                    <td>User Email</td>
                    <td>Email Type</td> 
                    <td>Account Type</td>
                    <td>Account Creation Date</td>
                </tr>
                '.$return1.''.$return2.''.$return3.''.$return4.''.$return5.''.$return6.''.$return7.'
            </table>';

    if(!empty($return1) || !empty($return2) || !empty($return3) ||
        !empty($return4) || !empty($return5) || !empty($return6) 
        || !empty($return7)){

        $functions->send_mail($email,$dbF->hardWords('Email Log',false),$table);
        $functions->send_mail('mobashir@im.com.pk',$dbF->hardWords('Email Log',false),$table);

    }else{
        $functions->send_mail($email,$dbF->hardWords('Email Log',false),$dbF->hardWords('Today email not send.',false));
        $functions->send_mail('mobashir@im.com.pk',$dbF->hardWords('Email Log',false),$dbF->hardWords('Today email not send.',false));
    }