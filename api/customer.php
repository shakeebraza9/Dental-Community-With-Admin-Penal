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

// $redirectFlow = $client->redirectFlows()->complete(
//     $_GET['redirect_flow_id'], //The redirect flow ID from above.
//     ["params" => ["session_token" => "dummy_session_token"]]
// );

// print("Mandate: " . $redirectFlow->links->mandate . "<br />");
// // Save this mandate ID for the next section.
// print("Customer: " . $redirectFlow->links->customer . "<br />");

// Display a confirmation page to the customer, telling them their Direct Debit has been
// set up. You could build your own, or use ours, which shows all the relevant
// information and is translated into all the languages we support.
// print("Confirmation URL: " . $redirectFlow->confirmation_url . "<br />");

// $customers = $client->customers()->list()->records;
// print_r($customers);
try {
$client->customers()->remove("CU00087W2GGDYN");
} catch (\GoCardlessPro\Core\Exception\ApiException $e) {
}
// $client->mandates()->cancel("MD0007Z9WJPHKT");
// header("location: $redirectFlow->confirmation_url");