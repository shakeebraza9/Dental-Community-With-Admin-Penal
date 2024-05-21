<?php 

include(__DIR__."/../global.php");

putenv("GC_ACCESS_TOKEN=sandbox_-cJfaal_pyd5y-3r5rop_91NRiZdozi97FCDMYX5");

require 'vendor/autoload.php';

$client = new \GoCardlessPro\Client([
    // We recommend storing your access token in an
    // environment variable for security
    'access_token' => getenv('GC_ACCESS_TOKEN'),
    // Change me to LIVE when you're ready to go live
    'environment' => \GoCardlessPro\Environment::SANDBOX
]);

/* ------------------ Create Single Payment ------------------ */

// $payment = $client->payments()->create([
//   "params" => [
//       "amount" => 1000, // 10 GBP in pence
//       "currency" => "GBP",
//       "links" => [
//           "mandate" => "MD0007VASBKQZ7"
//                        // The mandate ID from last section
//       ],
//       // Almost all resources in the API let you store custom metadata,
//       // which you can retrieve later
//       "metadata" => [
//           "invoice_number" => "001"
//       ]
//   ],
//   "headers" => [
//       "Idempotency-Key" => "random_payment_specific_string"
//   ]
// ]);

// // Keep hold of this payment ID - we'll use it in a minute
// // It should look like "PM000260X9VKF4"
// print("ID: " . $payment->id);

/* ------------------ Create Single Payment ------------------ */

/* ------------------ Payment Status ------------------ */

$payment = $client->payments()->get("PM000Z58S71JMS");
//                               // Payment ID from above
// echo "<pre>";print_r($payment);
print("Status: " . $payment->status . "<br />");
// print("Cancelling...<br />");

// $payment = $client->payments()->cancel("PM000Z325DV0PS");
// print("Status: " . $payment->status);

/* ------------------ Payment Status ------------------ */

/* ------------------ Create Subscriptions ------------------ */

// $subscription = $client->subscriptions()->create([
//   "params" => [
//       "amount" => 1500, // 15 GBP in pence
//       "currency" => "GBP",
//       "interval_unit" => "monthly",
//       "day_of_month" => "22",
//       "start_date" => "2020-01-21",
//       "links" => [
//           "mandate" => "MD0007VCG0VSYH"
//                        // Mandate ID from the last section
//       ],
//       "metadata" => [
//           "subscription_number" => "ABC1234"
//       ]
//   ],
//   "headers" => [
//       "Idempotency-Key" => "random_subscription_specific_strin"
//   ]
// ]);

// // Keep hold of this subscription ID - we'll use it in a minute.
// // It should look a bit like "SB00003GKMHFFY"
// print("ID: " . $subscription->id);

/* ------------------ Create Subscriptions ------------------ */


/* ------------------ Subscriptions Status ------------------ */

// $subscription = $client->subscriptions()->get("SB000223J93JNA");
// //                                         // Subscription ID from above.
// echo "<pre>";print_r($subscription);
// print("Status: " . $subscription->status . "<br />");
// print("Cancelling...<br />");

// $subscription = $client->subscriptions()->cancel("SB0002232ECC25");

// print("Status: " . $subscription->status . "<br />");

/* ------------------ Subscriptions Status ------------------ */