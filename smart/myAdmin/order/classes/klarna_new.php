<?php







class myKlarna extends object_class{



    public $testingServer;



    private $klarnaObj;



    private $orderId;



    private $inTransaction;



    private $invoiceStatus;



    private $paymentType;



    private $rsvNo;



    private $rsvNo_done;







    public  $purchase_country;



    public  $purchase_currency;



    public  $locale;







    public function __construct(){



        parent::__construct('3');



        if($this->functions->ibms_setting('klarnaTesting') == '1'){



            $this->testingServer = true; // make it false on live



        }else{



            $this->testingServer = false; // make it false on live



        }







        if($this->functions->isAdminLink()){



            $this->purchase_country = 'SE';



            $this->purchase_currency = 'SEK';



            $this->locale = 'sv-se';



        }else {



            $this->klarnaCountry();



        }



        



    }







    public function klarnaSharedSecret(){



        if($this->testingServer==true){



            //Testing Imedia Merchant eId



            //$eid = '1173';



            $eid        =   $this->functions->ibms_setting('klarnaTestId');

            // $eid        =   'K503790_5f1c2c47537b'; // Klarna v3 Testing Id



            // Shared secret



            //$sharedSecret = '5zWdni3xNVcbAUN';



            $sharedSecret   =   $this->functions->ibms_setting('klarnaTestSecret');

            // $sharedSecret   =   'IPgOCZvXcLgkmCch'; // Klarna v3 Testing Secret



            // testing URL



            // $orderUrl = "https://checkout.testdrive.klarna.com/checkout/orders";
            $orderUrl = "https://api.playground.klarna.com/";



            /**



             * test drive



             * Swedish consumer



            E-mail address: checkout-se@testdrive.klarna.com



            Postal code: 12345



            Personal identity number: 410321-9202



             */



        }else{



            //Real Merchant Id



            //Also Change Klarna Id From order/classes/invoice.php



            //$eid = '34266';



            $eid        =   $this->functions->ibms_setting('klarnaLiveId');



            //Shared secret



            //$sharedSecret = 'ulPhDhler4beKLa';



            $sharedSecret   =   $this->functions->ibms_setting('klarnaLiveSecret');



            // $orderUrl = "https://checkout.klarna.com/checkout/orders";
            $orderUrl = "https://api.klarna.com/";



        }



        return array('eId' => $eid,'sharedSecret' => $sharedSecret,'url' => $orderUrl, 'test' => $this->testingServer);



    }







    public function klarnaCountry(){



        global $productClass;



        $currentCurrency = $productClass->currentCurrencySymbol();



        $currentCountry  = $productClass->currentCurrencyCountry();







        //if any condition match, other if false, auto correct



        if(strtoupper($currentCountry) == 'SE'){



            //Sweden



            $this->purchase_country = 'SE';



            $this->purchase_currency = 'SEK';



            $this->locale = 'sv-se';



        }else if(strtoupper($currentCountry) == 'FI'){



            //Finland



            $this->purchase_country = 'FI';



            $this->purchase_currency = 'EUR';



            if(strtolower(currentWebLanguage())=='sweden' || strtolower(currentWebLanguage())=='swedish') {



                $this->locale = 'sv-fi'; //swedish language



            }else{



                $this->locale = 'fi-fi'; // Finland language



            }



        }else if(strtoupper($currentCountry) == 'NO'){



            //Norway



            $this->purchase_country = 'NO';



            $this->purchase_currency = 'NOK';



            $this->locale = 'nb-no';



        }else if(strtoupper($currentCountry) == 'DE'){



            //Germany | denmark



            $this->purchase_country = 'DE';



            $this->purchase_currency = 'EUR';



            $this->locale = 'de-de';



        }else if(strtoupper($currentCountry) == 'AT'){



            //Austria



            $this->purchase_country = 'AT';



            $this->purchase_currency = 'EUR';



            $this->locale = 'de-at';



        }else{



            //Sweden default



            $this->purchase_country = 'SE';



            $this->purchase_currency = 'SEK';



            $this->locale = 'sv-se';



        }







        /*echo $this->purchase_country;



        echo $this->purchase_currency;



        echo $this->locale;*/



    }











    public function klarnaInvoices($orderId,$inTransaction,$inv,$paymentType,$rsvNo,$rsvNo_done,$extra = false){



        $this->inTransaction    = $inTransaction; // klarna invoice Number



        $this->rsvNo            = $inTransaction; // klarna reservation number



        $this->invoiceStatus    = $inv; // Project invoice status



        $this->paymentType      = $paymentType; // project payment status



        $this->orderId          = $orderId; // project order id



        $this->rsvNo_done       = $rsvNo_done; //When Order complete klarna send NEW RSV For refund







        $klarnaSecrets  = $this->klarnaSharedSecret();







        $eid            =   $klarnaSecrets['eId'];



        $sharedSecret   =   $klarnaSecrets['sharedSecret'];



        $orderUrl       =   $klarnaSecrets['url'];



        // echo dirname(dirname(dirname(__DIR__))).'/../../src/Klarna/vendor/autoload.php';

        require_once dirname(dirname(dirname(__DIR__))).'/src/Klarna/vendor/autoload.php';



        // echo '<h1>'.$inTransaction.'</h1>';



        // require_once __DIR__.'/../../klarna/Klarna.php';







        // Dependencies from http://phpxmlrpc.sourceforge.net/



        // require_once __DIR__.'/../../klarna/transport/xmlrpc-3.0.0.beta/lib/xmlrpc.inc';



        // require_once __DIR__.'/../../klarna/transport/xmlrpc-3.0.0.beta/lib/xmlrpc_wrappers.inc';





        $connector = Klarna\Rest\Transport\Connector::create(

            $eid,

            $sharedSecret,

            $orderUrl

        );





        $order = new Klarna\Rest\OrderManagement\Order($connector, $inTransaction);

        // $order->fetch($inTransaction);



        // $this->dbF->prnt($order);



        // $k = new Klarna();







        $this->klarnaObj    =   $order;







        // $k->config(



        //     $eid,                 // Merchant ID



        //     $sharedSecret,       // Shared secret



        //     KlarnaCountry::SE,    // Purchase country



        //     KlarnaLanguage::SV,   // Purchase language



        //     KlarnaCurrency::SEK,  // Purchase currency



        //     Klarna::LIVE,         // Server



        //     'json',               // PClass storage



        //     './pclasses.json'     // PClass storage URI path



        // );







        $rno = $inTransaction;



        $invno  =   '';



        if($inv==='3'){



            if($extra){

                return $this->klarnaActiveExtraInvoice();

            }else{

                return $this->klarnaActiveInvoice();

            }



        }elseif($inv==='0'){



            if($extra){

                return $this->klarnaCancelExtraInvoice();

            }else{

                return $this->klarnaCancelInvoice();

            }



        }elseif($inv==='6'){



            if($extra){

                return $this->klarnaFullRefuntExtraInvoice();

            }else{

                return $this->klarnaFullRefuntInvoice();

            }



        }











    }







    public function klarnaActiveInvoice(){



        $k      = $this->klarnaObj;



        $inTransaction    = $this->inTransaction;

        $rsvNo  =   $this->rsvNo;

        $id     = $this->orderId;



        try {



            $order_det = $k->fetch($inTransaction);



            $order_amount = $order_det['order_amount'];



            $capture = array('captured_amount' => $order_amount);



            $k->createCapture($capture);

            

            $order_cap = $k->fetch($inTransaction);

           

            $capture_id = $order_cap['captures'][0]['capture_id'];

            $klarna_reference = $order_cap['captures'][0]['klarna_reference'];



            $sql ="UPDATE order_invoice SET rsvNo_done='$klarna_reference' , `rsvNo` = '$capture_id' WHERE order_invoice_pk = '$id'";



            $this->dbF->setRow($sql,false);



            // Reservation is activated, proceed accordingly.



            return " Active Invoice Status (Klarna Reference): $klarna_reference : \n Complete RSV : ";



        }catch(Exception $e) {



            // Something went wrong, print the message:

            // echo $e;



            return " Active Invoice Error : {$e->getMessage()} (#{$e->getCode()})\n";



        }



    }



    public function klarnaActiveExtraInvoice(){



        $k      = $this->klarnaObj;



        $inTransaction    = $this->inTransaction;



        $rsvNo  =   $this->rsvNo;



        $id     = $this->orderId;



        try {



            $order_det = $k->fetch($inTransaction);



            $order_amount = $order_det['order_amount'];



            $capture = array('captured_amount' => $order_amount);



            $k->createCapture($capture);

            

            $order_cap = $k->fetch($inTransaction);

           

            $capture_id = $order_cap['captures'][0]['capture_id'];

            $klarna_reference = $order_cap['captures'][0]['klarna_reference'];



            $sql ="UPDATE order_extra_amount SET rsvNo_done='$klarna_reference' , `rsvNo` = '$capture_id' WHERE id = '$id'";



            $this->dbF->setRow($sql,false);



           // Reservation is activated, proceed accordingly.







            return " Active Invoice Status : $risk : \n Complete RSV : $invno";



        }catch(Exception $e) {



            // Something went wrong, print the message:

            // echo $e;



            return " Active Invoice Error : {$e->getMessage()} (#{$e->getCode()})\n";



        }



    }







    public function klarnaCancelInvoice(){



        $k      = $this->klarnaObj;



        $inTransaction    = $this->inTransaction;



        $rsvNo  =   $this->rsvNo;



        $id     = $this->orderId;



        //$this->dbF->prnt($k);



                try {



                $k->cancel();// need reservation number



                $invno="CANCELED";



               // echo "Result: {$result}\n";







                return " Cancel Invoice Status: $invno";



                // Reservation cancelled, proceed accordingly.



            } catch(Exception $e) {



                // Something went wrong or the reservation doesn't exist.



                return " Cancel Invoice Error : {$e->getMessage()} (#{$e->getCode()})\n";



            }



    }





    public function klarnaCancelExtraInvoice(){



        $k      = $this->klarnaObj;



        $inTransaction    = $this->inTransaction;



        $rsvNo  =   $this->rsvNo;



        $id     = $this->orderId;



        //$this->dbF->prnt($k);



                try {



                $k->cancel();// need reservation number



                $invno="CANCELED";



               // echo "Result: {$result}\n";







                return " Cancel Invoice Status: $invno";



                // Reservation cancelled, proceed accordingly.



            } catch(Exception $e) {



                // Something went wrong or the reservation doesn't exist.



                return " Cancel Invoice Error : {$e->getMessage()} (#{$e->getCode()})\n";



            }



    }







    public function klarnaFullRefuntInvoice(){



        $k      = $this->klarnaObj;



        $inTransaction    = $this->inTransaction;



        $rsvNo  =   $this->rsvNo;



        $rsvNo_done =   $this->rsvNo_done;



        $id     = $this->orderId;



        try {



            $order = $k->fetch();

            $order_amount = $order['order_amount'];



            $refund_array = array('refunded_amount' => $order_amount);



            $result = $k->refund($refund_array);



            // echo '<pre>'; print_r($result); echo '</pre>';





            // $result =  $k->creditInvoice($rsvNo_done); // need reservation number, that klarna send on invoice done status







            return " \n Full Refund Status : OK, \n RSV :  ";



            // Reservation cancelled, proceed accordingly.



        } catch(Exception $e) {



            // Something went wrong or the reservation doesn't exist.

            // echo $e;



            return " Full Refund Error : {$e->getMessage()} (#{$e->getCode()})\n";



        }



    }





    public function klarnaFullRefuntExtraInvoice(){



        $k      = $this->klarnaObj;



        $inTransaction    = $this->inTransaction;



        $rsvNo  =   $this->rsvNo;



        $rsvNo_done =   $this->rsvNo_done;



        $id     = $this->orderId;



        try {



            $order = $k->fetch();

            $order_amount = $order['order_amount'];



            $refund_array = array('refunded_amount' => $order_amount);



            $result = $k->refund($refund_array);



            // $result =  $k->creditInvoice($rsvNo_done); // need reservation number, that klarna send on invoice done status







            return " \n Full Refund Status : OK, \n RSV :  ";



            // Reservation cancelled, proceed accordingly.



        } catch(Exception $e) {



            // Something went wrong or the reservation doesn't exist.



            return " Full Refund Error : {$e->getMessage()} (#{$e->getCode()})\n";



        }



    }







}











?>