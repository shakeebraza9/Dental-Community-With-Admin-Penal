<?php
include("global.php");

ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

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

try {
$payment = $client->payments()->get("PM0011G2Y2MDDT");
echo $paymentStatus = $payment->status;

$dbF->setRow("UPDATE `invoices` SET `invoice_status`='paid' WHERE `payment_id`='PM0011G2Y2MDDT'");

} catch (\GoCardlessPro\Core\Exception\ApiException $e) {}
catch (\GoCardlessPro\Core\Exception\MalformedResponseException $e) {}
catch (\GoCardlessPro\Core\Exception\ApiConnectionException $e) {}


exit();








$msg  = "";
$date = Date('Y-m-d');

$orders = $dbF->getRows("SELECT * FROM `orders` WHERE `order_status` != 'cancelled' AND `order_customer` != 'manual'");

foreach ($orders as $key => $order) {

	$orderId = $order['order_id'];
	$user 	 = $functions->userName($order['order_user']);
	$mandate = $order['order_mandate'];
	$invoices  = $dbF->getRows("SELECT * FROM `invoices` WHERE `due_date` <= '$date' AND `order_id`='$orderId' AND `invoice_status` != 'paid'");

	foreach ($invoices as $key => $invoice) {

		$paymentId = $invoice['payment_id'];
		$invoiceId = $invoice['invoice_pk'];
		$oprice = $invoice['price'];
		$price = ($oprice*100);
		$ik    = $invoiceId.uniqid();

		if(empty($paymentId)){
				// $payment = $client->payments()->create([
			    //   "params" => [
			    //       "amount" => $price, // 10 GBP in pence
			    //       "currency" => "GBP",
			    //       "links" => [
			    //           "mandate" => "$mandate"
			    //                        // The mandate ID from last section
			    //       ],
			    //       // Almost all resources in the API let you store custom metadata,
			    //       // which you can retrieve later
			    //       "metadata" => [
			    //           "invoice_number" => "$ik"
			    //       ]
			    //   ],
			    //   "headers" => [
			    //       "Idempotency-Key" => "$ik"
			    //   ]
			    // ]);
			    // $paymentId = $payment->id;
			    // $dbF->setRow("UPDATE `invoices` SET `payment_id` = '$paymentId' WHERE `invoice_pk` = '$invoiceId'");
			    // $msg .= "Payment Create of Amount GBP $oprice of user $user<br>";
		}
		else{

			$payment = $client->payments()->get($paymentId);
			echo $paymentStatus = $payment->status;
			echo "<br>";
			// if($paymentStatus == 'confirmed'){
			// 	$dbF->setRow("UPDATE `invoices` SET `invoice_status`='paid' WHERE `invoice_pk`='$invoiceId'");
			// 	$msg .= "Payment Receive of Amount GBP $oprice of user $user<br>";
			// }
		}
	}
}

// if(!empty($msg)){
// 	$email = $functions->ibms_setting('Email');
// 	$functions->send_mail($email,'Order Management',$msg);
// 	$functions->send_mail('m.anus@imedia.com.pk','Cron Check',$msg);
// }