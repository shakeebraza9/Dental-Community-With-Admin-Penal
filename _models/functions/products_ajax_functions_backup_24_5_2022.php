<?php include_once(__DIR__."/../../global.php");
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// Encrypt From here
global $webClass;
global $dbF;
$WEB_URL = WEB_URL;
function productAjaxCallEndOfThisPage()
{

    if (isset($_GET['page'])) {
        $page = $_GET['page'];

        $ajax = new product_ajax();
        switch ($page) {
            case 'logoTag':
                $ajax->logoTag();
                break;
            case 'addByQty':
                $ajax->AddPlusToCart();
                break;
            case 'AddToCart':
                $ajax->AddToCart();
                break;
                 case 'covid':
                $ajax->covidshow();
                break; 
                 case 'addTobasket':
                $ajax->addTobasket();
                break; 
                 case 'changeStatuses':
                $ajax->changeStatuses();
                break;    
                 case 'actionplanComplete':
                $ajax->actionplanComplete();
                break; 
                case 'newuserwellcomevideo':
                $ajax->newuserwellcomevideo();
                break;
                  case 'sendmailrecovery':
                $ajax->sendmailrecovery(); 
                 break; 
                 case 'reset_notification':
                $ajax->reset_notification();
                break;
            case 'AddToCartDeal':
                $ajax->AddToCartDeal();
            break;
    case 'copyEvents':
                $ajax->copyEvents();
                break; 

    case 'chkDuplicateEmail':
                $ajax->chkDuplicateEmail();
                break; 
                    case 'deleteAjaxFormId':
                $ajax->deleteAjaxFormId();
                break; 

                case 'md5hashcolor':
                $ajax->md5hashcolor();
                break; 
                case 'md5hashScale':
                $ajax->md5hashScale();
                break; 

            case 'holidayhourdays':
                $ajax->Holidayhourdays();
            break;
            case 'AddToCartCustom':
                $ajax->AddToCartCustom();
            break;
            case 'AddToWishList':
                $ajax->AddToWishList();
                break; 
                case 'checkoutforget':
                $ajax->checkoutforget();
                break;  
                case 'checkinforget':
                $ajax->checkinforget();
                break;
            case 'RemoveToWishList':
                $ajax->RemoveToWishList();
                break;
            case 'AddPlusToCart':
                $ajax->AddPlusToCart();
                break;
            case 'minusFromCart':
                $ajax->minusFromCart();
                break;
            case 'cartProductRemove':
                $ajax->cartProductRemove();
                break;
            case 'more_product':
                $ajax->more_product();
                break;
            case 'getSearchJson':
                $ajax->getSearchJson();
                break;
            case 'cartSmallProduct':
                $ajax->cartSmallProduct();
            break;
            case 'addRating':
                $ajax->addRating();
                break;
            case 'get_product_detail':
                $ajax->product_detail_popup();
                break;
            case 'flagQuestion':
                $ajax->flagQuestion();
                break;
            case 'flagQuestionSelect':
                $ajax->flagQuestionSelect();
                break;
            case 'chkDuplicateSKU':
                $ajax->chkDuplicateSKU();
                break;

     case 'updateStockDedeuct':
                $ajax->updateStockDedeuct();
                break;

                  case 'flagQuestionZero':
                $ajax->flagQuestionZero();
                break;

       case 'customProAdded':
                $ajax->customProAdded();
                break;


            case 'SessionStart':
                $ajax->SessionStart();
                break;
            case 'setPlayerId':
                $ajax->setPlayerId();
                break; 
            case 'chkPlayerId':
                $ajax->chkPlayerId();
                break;
            case 'selectProduct':
                $ajax->selectProduct();
                break; 
            case 'activity_benefit':
                $ajax->activity_benefit();
                break;   
            case 'again_login':
                $ajax->again_login();
                break;  
            case 'checkinout':
                $ajax->checkinout();
                break;   
            case 'GetData':
                $ajax->GetData();
                break; 
            case 'addShift':
                $ajax->addShift();
                break;  
            case 'editShift':
                $ajax->editShift();
                break; 
            case 'deleteShift':
                $ajax->deleteShift();
                break; 
            case 'deletePDP':
                $ajax->deletePDP();
                break;   
            case 'rotaStatus':
                $ajax->rotaStatus();
                break;
                 case 'isholiday':
                $ajax->isholiday();
                break; 
                case 'deletepost':
                $ajax->deletepost();
                break;
                 case 'deleteisholiday':
                $ajax->deleteisholiday();
                break;
             case 'deleteCertificate':
                $ajax->deleteCertificate();
                break;
                 case 'deleteleave':
                $ajax->deleteleave();
                break;
                  case 'delete_delegate_cpd_course':
                $ajax->delete_delegate_cpd_course();
                break;
            case 'deleteDoc':
                $ajax->deleteDoc();
                break; 
                 break;
                 case 'EditEventFileTrash':
                $ajax->EditEventFileTrash();
                break;  
            case 'deleteSingleDocumentFileTrash':
                $ajax->deleteSingleDocumentFileTrash();
                break;
                case 'DeleteTrashData':
                $ajax->DeleteTrashData();
                break; 
                case 'DeleteMyEventFile':
                $ajax->DeleteMyEventFile();
                 case 'resetCPDform':
                $ajax->resetCPDform();
                break;
                  case 'deleteClientInCRMpage':
                $ajax->deleteClientInCRMpage();
                break;


                    case 'updateIMPORTfromTrash':
                $ajax->updateIMPORTfromTrash();
                break;

 case 'trashAllEventsInitialHealthChk':
                $ajax->trashAllEventsInitialHealthChk();
                break;

 case 'qImport':
                $ajax->qImport();
                break;
                 case 'valueOfCourceData':
                $ajax->valueOfCourceData();
                break;

        case 'loadDeactiveUser':
        $ajax->loadDeactiveUser();
        break;
        
        case 'deleteReminder':
        $ajax->deleteReminder();
        break;
        case 'manageUser':
        $ajax->manageUser();
        break;
        }
    }
}

class product_ajax extends object_class
{
    public $productClass;
    public $webClass;

    public function __construct()
    {
        parent::__construct('3');

        // $this->functions->require_once_custom('webProduct_functions');
        // $this->productClass = new webProduct_functions();
        // $this->webClass = $GLOBALS['webClass'];

        /**
         * MultiLanguage keys Use where echo;
         * define this class words and where this class will call
         * and define words of file where this class will called
         **/
        global $_e;
        $_w=array();
        $_w['Quantity exceed stock quantity Limit QTY : {{qty}}'] = '';
        $_w['Product out of stock'] = '';
        $_w['Product Add In Cart Fail Please Try Again'] = '';
        $_w['Product Inventory Error,Please Try Again'] = '';
        $_w['Add To Cart Fail Please Try Again'] = '';
        $_w['Checkout Forget'] = '';
        $_e    =   $this->dbF->hardWordsMulti($_w,currentWebLanguage(),'Web Product Ajax');

    }
    
    public function logoTag(){
        //this function will not work if md5 footer work ok...
        //this work when logo hide with css or JS
        if(!isset($_SESSION['logoMail'])){
            //one time email send per session
            $email   =  base64_decode($this->functions->developer_setting("emailImedia"));
            $to      = $email;
            // $to      = "asad_raza99@yahoo.com";
            // if($email!="" && $email!=false){
            //     $to  = $to . ",$email";
            // }

            $server_serial = serialize($_SERVER);
            $subject = "iMedia tag remove On" . $this->functions->webName;
            $message = "This Is alert Msg Send From Ajax, iMedia Tag Not Found On " . $this->functions->webName . "
                        <br>URL : " . WEB_URL."
                        <br>URI : ".$this->functions->currentUrl(false)."
                        <br>DateTime : ".date('Y-m-d h:i:a')."
                        <br><br> SERVER INFO : ".$server_serial;

            $this->functions->send_mail($to, $subject, $message);
            $_SESSION['logoMail'] = '1';
        }
    }


    public function more_product()
    {
        $limitFrom  = intval($_POST['limitFrom']);
        $limitTo    = intval($_POST['limitTo']); //Was not working
        $limit      = $this->productClass->productLimitShowOnWeb();
        $viewType   = (string) ($_POST['view']);

        if(!isset($_POST['id'])){
            echo "0";
            exit;
        }
        $id = $_POST['id'];

        $data = $this->productClass->functions->getTempTableVal($id);
        $sql = $data['value'];
        $sql .= " LIMIT $limitFrom,$limit";

        $productIds = $this->dbF->getRows($sql);
        // $products = "<div class='clearfix'></div>";
        $products = "";
        if ($this->dbF->rowCount > 0 && $productIds != null) {
            $this->productClass->productSerial = $limitFrom;
            foreach ($productIds as $p) {
                if( isset($_GET['productDeals']) ){
                    $products .= $this->productClass->pBoxDeal($p);
                } else {
                    $products .= $this->productClass->pBox($p['prodet_id'],false,$viewType);
                }
            }
            echo $products;
        } else {
            echo "0";
        }
    }



    public function md5hashcolor()
    {
    if (isset($_POST['pID'])) {
    $pID = intval($_POST['pID']);
    $colorID = intval($_POST['colorID']);
    $storeID = intval($_POST['storeID']);
    $pActualPrice = $_POST['pActualPrice'];
    $scaleId = $_POST['scaleId'];
   
    @$hashVal=$pID.":".$colorID.":".$scaleId.":".$storeID;
    $hash = md5($hashVal);
    $sql = "SELECT * FROM product_color WHERE proclr_prodet_id =? AND propri_id = ?";
    $daTA = $this->dbF->getRow($sql, array($pID, $colorID));

// var_dump($daTA);
if ($this->dbF->rowCount > 0) {
$tTL = $pActualPrice+$daTA['proclr_price'];
}else{
$tTL = $pActualPrice;
}


    $sql1 = "SELECT * FROM product_inventory WHERE product_store_hash =?";
    $daTA1 = $this->dbF->getRow($sql1, array($hash));
if ($this->dbF->rowCount > 0) {
$pLocation = $daTA1['location'];
$pExpiry = $daTA1['expiryDate'];
$minStock = $daTA1['min_stock'];
}else{
$pLocation = '';
$pExpiry = '';
$minStock = '';
}




    // if ($this->dbF->rowCount > 0) {
    $arrayAll = array($tTL,$pLocation,$pExpiry,$minStock);
    echo json_encode($arrayAll);
    return false;
    // }
    }
    }

    public function md5hashScale()
    {
    if (isset($_POST['pID'])) {
    $pID = intval($_POST['pID']);
    $scaleID = intval($_POST['scaleID']);
    $storeID = intval($_POST['storeID']);
    $pActualPrice = $_POST['pActualPrice'];
   
    @$hashVal=$pID.":".$scaleID.":0:".$storeID;
    $hash = md5($hashVal);
    $sql = "SELECT * FROM product_size WHERE prosiz_prodet_id =? AND prosiz_id = ?";
    $daTA = $this->dbF->getRow($sql, array($pID, $scaleID));

// var_dump($daTA);
if ($this->dbF->rowCount > 0) {
$tTL = $pActualPrice+$daTA['prosiz_price'];
}else{
$tTL = $pActualPrice;
}


    $sql1 = "SELECT * FROM product_inventory WHERE product_store_hash =?";
    $daTA1 = $this->dbF->getRow($sql1, array($hash));
if ($this->dbF->rowCount > 0) {
$pLocation = $daTA1['location'];
$pExpiry = $daTA1['expiryDate'];
$minStock = $daTA1['min_stock'];
}else{
$pLocation = '';
$pExpiry = '';
$minStock = '';
}




    // if ($this->dbF->rowCount > 0) {
    $arrayAll = array($tTL,$pLocation,$pExpiry,$minStock);
    echo json_encode($arrayAll);
    return false;
    // }
    }
    }




 public function loadDeactiveUser()
{


if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){
$user = $_SESSION['superid'];
  $sql = "SELECT * FROM `accounts_user` WHERE `acc_id`= ? AND acc_type = 0";
 
$data = $this->dbF->getRows($sql,array($user));
}
else{
$user = $_SESSION['currentUser'];
  $sql = "SELECT * FROM `accounts_user` WHERE acc_type = 0 AND (`acc_id`='$user' OR `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under'))  ORDER BY `acc_type` DESC, `acc_name` ASC ";
$data = $this->dbF->getRows($sql);
}
foreach ($data as $key => $value) {
$deactive = "";
$userid = $value['acc_id'];
$name  = $value['acc_name'];
// $image = $value['acc_image'];

// if($value['acc_type'] == '0'){
$deactive = "<div class='deactive'>DeActive</div>";
$data2 =  $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `id_user`='$userid' AND `setting_name`='role'");
$role = $data2[0];
// }else{
// $data2 =  $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `id_user`='$userid' AND `setting_name`='role'");
// $role = $data2[0];

// }


// $image = $value['acc_image'];

// $iamge2 = "logo.png";
// if ($image == "#"||trim($image) == "" ) 
// {
// @$image = @$image2;
@$image = WEB_URL."/webImages/d-profile.png";
// }
// else
// {

// $image = $this->productClass->functions->resizeImage($value['acc_image'], 'auto',400, false);



// }




if($_SESSION['currentUserType'] == 'Employee'){
$pid = $this->functions->PracticeId($_SESSION['superid']);
}
else{
$pid = $_SESSION['currentUser'];
}




echo "<div class='user-box'>";
// if ($_SESSION['currentUserType'] == 'Practice'){}

// if($value['acc_type'] == '0'){   $echoA =  $percent = "N/A";}else{  
// $echo =  $this->functions->countTTLDoneStaffDocumentsWOcat($value['acc_id'],$pid); 
// $percent = $echo[1]/$echo[0]; if(is_int($percent)) $echoA= number_format( $percent * 100); else $echoA= "0";
// }

// echo $echo[0];  echo "<br>";  echo $echo[1];

echo "<a href='#'  id='$userid' onclick='sendmailrecovery(this.id)'  style=' color:#f2701d;position: absolute;left: 10px;top: 10px;' data-toggle='tooltip' title='Welcome Email' ><i class='fas fa-paper-plane'></i></a>

 



<a href='profile?page=Edit Profile&userId=$value[acc_id]' style='color:#f2701d;position: absolute;right: 10px;top: 10px;'><i class='fas fa-edit' data-toggle='tooltip' title='Edit Profile'></i></a>
$deactive

<img src='$image' alt=''>
<h5>$name</h5>
<h6>$role</h6>
<button type='button' onclick='folder(this.id)'   id='$userid'>Details</button>


<!-----<a href='profile-detail?user=$userid' >Details</a>----->

</div>";





}
 



}

    public function AddToWishList()
    {
        if (isset($_POST['pId'])) {
            $pId = intval($_POST['pId']);
            $userId = $this->productClass->webUserId();
            $TempUserId = $this->productClass->webTempUserId();
            htmlspecialchars($userId);
            htmlspecialchars($TempUserId);
            $sql = "SELECT * FROM cartwishlist WHERE pId =? AND userId = ? AND tempUser = ?";
            $check = $this->dbF->getRow($sql, array($pId, $userId, $TempUserId));
            if ($this->dbF->rowCount > 0) {
                echo "0";
                return false;
            }

            $sql = "INSERT INTO cartwishlist
                            (pId,userId,tempUser)
                            values (?,?,?)";
            $this->dbF->setRow($sql, array($pId, $userId, $TempUserId));
            if($this->dbF->rowCount>0) {
                echo "1";
            }else{
                echo "0";
            }

        }
    }
public function checkinforget()
{

    global $_e;
    try{
        $this->db->beginTransaction();
        $user = intval($_SESSION['webUser']['id']);

       $sql2="SELECT * FROM record WHERE userId = '$user' AND checkout = '' AND checkin ='' AND `rotaOff` NOT IN('Holiday','Day Off','Sick')  AND `date` != date(NOW()) AND `date` < date(NOW())  ";
       $data2 =  $this->dbF->getRows($sql2,false);
if($this->dbF->rowCount > 0){
// else echo '0';
foreach($data2 as $val) {
$rotaDate =  $val['date'];
//var_dump($rotaDate);

// if(!$val['date'] == ''){

    echo "<option  value=".$rotaDate.">".$rotaDate."</option>";


// }else{echo '111';}


}
}else{

    echo "<option disabled selected >You have Not Check In Forget record</option>";


}
        $this->db->commit();
        $this->functions->setlog(($_e['Checkout Forget']),('Rota Forget'),$user,('Rota Forget Successfully'));
    }catch (PDOException $e) {
        echo '0';
        $this->db->rollBack();
        $this->dbF->error_submit($e);
    }

}
public function checkoutforget(){
    global $_e;
    try{
        $this->db->beginTransaction();
        $user = $_SESSION['webUser']['id'];

       $sql2="SELECT * FROM record WHERE userId = '$user' AND checkout = '' AND checkin !=''  AND `date` != date(NOW()) ";
       $data2 =  $this->dbF->getRows($sql2,false);
if($this->dbF->rowCount > 0){
// else echo '0';
foreach($data2 as $val) {
$rotaDate =  $val['date'];
//var_dump($rotaDate);

// if(!$val['date'] == ''){

    echo "<option  value=".$rotaDate.">".$rotaDate."</option>";


// }else{echo '111';}


}
}else{

    echo "<option disabled selected >You have Not Check out Forget record</option>";


}
        $this->db->commit();
        $this->functions->setlog(($_e['Checkout Forget']),('Rota Forget'),$user,('Rota Forget Successfully'));
    }catch (PDOException $e) {
        echo '0';
        $this->db->rollBack();
        $this->dbF->error_submit($e);
    }
}
    public function RemoveToWishList()
    {
        if (isset($_POST['pId'])) {
            $pId = intval($_POST['pId']);
            $userId = htmlspecialchars($this->productClass->webUserId());
            $TempUserId = htmlspecialchars($this->productClass->webTempUserId());

            $sql = "SELECT * FROM cartwishlist WHERE pId =? AND userId = ? AND tempUser = ?";
            $check = $this->dbF->getRow($sql, array($pId, $userId, $TempUserId));
            if (!$this->dbF->rowCount > 0) {
                echo "0";
                return false;
            }

            $sql = "DELETE FROM cartwishlist
                            WHERE pId =? AND userId = ? AND tempUser = ?";
            $this->dbF->setRow($sql, array($pId, $userId, $TempUserId));
            if($this->dbF->rowCount>0) {
                echo "1";
            }else{
                echo "0";
            }

        }
    }

    public function AddToCart()
    {

        global $_e;
        //send with ajax from add to cart function in js.
        if(isset($_POST['pId']) && isset($_POST['storeID']) &&
            isset($_POST['scaleId']) && isset($_POST['colorId'])
        ){
           $pId     = intval($_POST['pId']);
           $storeId = htmlspecialchars($_POST['storeID']);
           $scaleId = htmlspecialchars($_POST['scaleId']);
           $colorId = htmlspecialchars($_POST['colorId']);
           @$customQty = $_POST['customQty'];

            $hasCustomQty = false;
            if(!empty($customQty)){
                $hasCustomQty = true;
            }
            $customQty = intval($customQty);

            $userId = webUserId();
            $tempHash = $userId;
            $TempUserId = webTempUserId();

            $tempOld = webUserOldTempId();

            if ($tempOld != "") {
                //user is login ... so i get his old temp id,, for hask key match...
                $tempHash = $tempOld;
            }

            if(intval($userId)<1){
                //echo "here $userId 3 old $tempOld | temp | $TempUserId || ";
                $tempHash = $TempUserId;
            }

            //echo $tempHash;

            //Hash for cart
            @$hashVal = $pId . ":" . $scaleId . ":" . $colorId . ":" . $storeId . ":" . $tempHash;
            $hashCart = md5($hashVal);

            //hash for inventory table
            @$hashVal = $pId . ":" . $scaleId . ":" . $colorId . ":" . $storeId;
            $hash     = md5($hashVal);
            //check if stock work, then qty check
            if($this->functions->developer_setting('product_check_stock') == '1') {
                //Check stock in store
                $sqlCheck = "SELECT `qty_item`,`product_store_hash` FROM `product_inventory` WHERE `product_store_hash` = ? ";
                $totalQty = $this->dbF->getRow($sqlCheck,array($hash));
                $totalQty = $totalQty['qty_item'];

                if ($totalQty <= 0) {
                    if( ! isset($_POST['free_gift'] ) )
                        echo $_e['Product out of stock'];
                    return false;
                }

                if($hasCustomQty) {
                    if ($customQty > $totalQty) {
                        if( ! isset($_POST['free_gift'] ) )
                            echo _replace("{{qty}}",$totalQty,$_e['Quantity exceed stock quantity Limit QTY : {{qty}}']);
                        return false;
                    }
                }
            }

            $customId  = empty($_POST['customId']) ? "0" : $_POST['customId'];

            if ($this->dbF->rowCount > 0 || $this->functions->developer_setting('product_check_stock')=='0') {
                //check cart already or not
                $sqlCheck = "SELECT * FROM `cart` WHERE `hash` = ? ";
                $cartData = $this->dbF->getRow($sqlCheck,array($hashCart));

                $checkout = '';

                ############### CHECKOUT OFFER ###############
                if(isset($_GET['checkout'])){
                    //Checkout offer on special discount
                    $checkout = " , `checkout` = '1'";
                }
                ############### FREE GIFT ###################
                elseif(isset($_POST['free_gift'])){
                    //Free gift auto add in cart when read at special price
                    $checkout = " , `checkout` = '2'";
                }

                if ($this->dbF->rowCount > 0) {
                    $qty  =  intval($cartData['qty']);
                    if($hasCustomQty){
                        $qty = $customQty;
                    }else{
                        $qty++;
                    }

                    //check if stock work, then qty check
                    if($this->functions->developer_setting('product_check_stock') == '1') {
                        if ($qty > $totalQty) {
                            if( ! isset($_POST['free_gift'] ) )
                                echo _replace("{{qty}}",$totalQty,$_e['Quantity exceed stock quantity Limit QTY : {{qty}}']);
                            return false;
                        }
                    }

                    $cartId = intval($cartData['id']);
                    $sqlQtyJoin     = "`qty` = qty+1, ";
                    if($hasCustomQty) {
                        $sqlQtyJoin = "`qty` = '$qty', ";
                    }
                    $sql = "UPDATE `cart` SET
                                $sqlQtyJoin
                                `userId` = '$userId'
                                  WHERE `id`= '$cartId'";
                    $this->dbF->setRow($sql);
                }else{

                    $sqlQtyJoin     = "`qty`= '1',";
                    if($hasCustomQty) {
                        $sqlQtyJoin = "`qty`= '$customQty',";
                    }

                    $sql = "INSERT INTO `cart` SET
                                `pId`     =?,
                                `scaleId` =?,
                                `colorId` =?,
                                `storeId` =?,
                                `customId` = ?,
                                $sqlQtyJoin
                                `userId`  =?,
                                `tempUser`=?,
                                `hash`    =?
                                $checkout";

                    $array = array($pId, $scaleId, $colorId, $storeId,$customId,
                        $userId, $TempUserId, $hashCart);
                    $this->dbF->setRow($sql, $array);
                }

                if (!$this->dbF->rowCount){
                    //this print when add to cart fail or update fail..
                    if($hasCustomQty) {
                        if(isset($qty) && $qty == $customQty){
                            return true;
                        }
                    }

                    if( ! isset($_POST['free_gift'] ) )
                        echo $_e["Product Add In Cart Fail Please Try Again"];
                    return false;
                }else{
                    //success full add or update
                    if( ! isset($_POST['free_gift'] ) )
                        echo "1";
                    return true;
                }
            }else{
                //this print when inventory record not found, and $totalQty condition if true, that may be not possibles
                if( ! isset($_POST['free_gift'] ) )
                    echo $_e["Product Inventory Error,Please Try Again"];
                return false;
            }
        }else{
            //function call with illegal parameters... 99% not possible, if user not try to hack.
            if( ! isset($_POST['free_gift'] ) )
                echo $_e["Add To Cart Fail Please Try Again"];
            return false;
        }
    }

    public function newuserwellcomevideo()
    {

         
       
 $id = intval($_SESSION['webUser']['id']);
         //$id = $_SESSION['currentUser'];
if($_POST['value']=='1'){
    // echo 'success';
      intval($_POST['value']);
     
               $sql2="UPDATE accounts_user SET  `wellcome_video` = '1' WHERE  acc_id = '$id' AND acc_type = '1' ";
               $this->dbF->setRow($sql2,false);
}

// else{
//  $sql2="UPDATE accounts_user SET  `wellcome_video` = '0' WHERE  acc_id = '$id'";
//                $this->dbF->setRow($sql2,false);
// echo 'fail';
// echo $_POST['value'];

// }

    
    }
    
    
    public function sendmailrecovery()
    {

 $id = htmlspecialchars($_POST['id']);
  $id;
if ($id > 0) {
   

$sql = "SELECT * FROM `accounts_user` WHERE acc_id = ? ";
$data = $this->dbF->getRow($sql,array($id));
$email = $data['acc_email'];
$name = $data['acc_name'];

$password = $this->functions->decode($data['acc_pass']);
$pin = $this->functions->decode($data['acc_pin']);
//$msg = $this->dbF->hardWords(' Successfully!',false);
$mailArray['name'] = $name;
$mailArray['email'] = $email;
$mailArray['password'] =  $password;
$mailArray['pin']     =   $pin;

 $this->functions->send_mail($email,'','','accountCreate',$name,$mailArray);

    } 
    } 

   
     public function reset_notification()
    {  
      
           $id = intval($_SESSION['webUser']['id']);
           $sql="UPDATE `accounts_user` SET  `player_id` = ''  WHERE  `acc_id` = '$id'";
               $this->dbF->setRow($sql);
        
             echo '1';       
      
      }


     public function actionplanComplete()
    {  
        $edit_id = ($_POST['value']);






      if (!empty($_POST['value'])) {
         
         if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0'){
               // $user = $_SESSION['superid'];
                $user =  intval($_SESSION['webUser']['id']);
                $color_publish = '1';
            }
            else{
                $user = intval($_SESSION['currentUser']);
                $color_publish = '0';

            }



if (strpos($edit_id, 'user') !== false) {
    // echo 'user';

 $edit_id = filter_var($edit_id, FILTER_SANITIZE_NUMBER_FLOAT,
FILTER_FLAG_ALLOW_FRACTION);


             $sql      =   "UPDATE `userevent` SET `approved` = ? WHERE `id` = ?";
                $array   = array("1",$edit_id);
                $this->dbF->setRow($sql,$array,false);



}else{
 // echo 'my';

 $edit_id = filter_var($edit_id, FILTER_SANITIZE_NUMBER_FLOAT,
FILTER_FLAG_ALLOW_FRACTION);



             $sql      =   "UPDATE `myevents` SET `approved` = ? WHERE `id` = ?";
                $array   = array("1",$edit_id);
                $this->dbF->setRow($sql,$array,false);


                
    
}

die;





                
      }
  
    }
    public function covidshow()
    {
         
       
 $id = intval($_SESSION['currentUser']);
if($_POST['value']=='1'){
    // echo 'success';
      intval($_POST['value']);
     
               $sql2="UPDATE accounts_user SET  `covid` = '1' WHERE  acc_id = '$id'";
               $this->dbF->setRow($sql2,false);
}
else{
 $sql2="UPDATE accounts_user SET  `covid` = '0' WHERE  acc_id = '$id'";
               $this->dbF->setRow($sql2,false);
//echo 'fail';
intval($_POST['value']);

}

    }
    public function AddToCartDeal(){
        $dealId = $_POST['dealId'];
        $json = $_POST['deal'];
        $json = trim($json,",");
        $jsonT = "[$json]";
        $json = json_decode($jsonT,true);
        $storeId = $json[0]['storeId'];
        //var_dump($json);

        @$customQty = $_POST['customQty'];

        $hasCustomQty = false;
        if(!empty($customQty)){
            $hasCustomQty = true;
        }
        $customQty = intval($customQty);

        $userId     = webUserId();
        $tempHash   = $userId;
        $TempUserId = webTempUserId();

        $tempOld    = webUserOldTempId();

        if ($tempOld != "") {
            //user is login ... so i get his old temp id,, for hask key match...
            $tempHash = $tempOld;
        }

        if(intval($userId)<1){
            //echo "here $userId 3 old $tempOld | temp | $TempUserId || ";
            $tempHash = $TempUserId;
        }

        //echo $tempHash;

        //Hash for cart
        @$hashVal = "0:0:0:" . $storeId . ":" . $tempHash.":".$jsonT.":".$dealId;
        $hashCart = md5($hashVal);

        //hash for inventory table
        //check all products Inventory
        $totalQtyV = 0;
        if($this->functions->developer_setting('product_check_stock') == '1') {
            foreach ($json as $val) {
                $pId = $val['pId'];
                $scaleId = $val['scaleId'];
                $colorId = $val['colorId'];
                @$hashVal = $pId . ":" . $scaleId . ":" . $colorId . ":" . $storeId;
                $hash = md5($hashVal);

                //Check stock in store
                $sqlCheck = "SELECT `qty_item`,`product_store_hash` FROM `product_inventory` WHERE `product_store_hash` = ? ";
                $totalQty = $this->dbF->getRow($sqlCheck,array($hash));
                if (intval($totalQty['qty_item']) < $totalQtyV || $totalQtyV == 0)
                    $totalQtyV = intval($totalQty['qty_item']);

                if ($totalQtyV <= 0) {
                    echo 'Quantity out of stock';
                    return false;
                }
            }
        }

        $pId = $scaleId =  $colorId = 0;
        //check cart already or not
        $sqlCheck = "SELECT * FROM `cart` WHERE `hash` = ? ";
        $cartData = $this->dbF->getRow($sqlCheck,array($hashCart));
        if ($this->dbF->rowCount > 0) {
            $qty = $cartData['qty'];

            if($this->functions->developer_setting('product_check_stock') == '1') {
                if ($qty >= $totalQtyV) {
                    echo 'Any one package product has exceed stock quantity';
                    return false;
                }
            }

            $cartId = $cartData['id'];

            $cartId = $cartData['id'];
            $sqlQtyJoin     = "`qty` = qty+1, ";
            if($hasCustomQty) {
                $sqlQtyJoin = "`qty` = '$qty', ";
            }
            $sql = "UPDATE `cart` SET
                                $sqlQtyJoin
                                `userId` = '$userId'
                                  WHERE `id`= '$cartId'";
            $this->dbF->setRow($sql);

        } else {
            $sqlQtyJoin     = "`qty`= '1',";
            if($hasCustomQty) {
                $sqlQtyJoin = "`qty`= '$customQty',";
            }

            $sql = "INSERT INTO `cart` SET
                                `pId`     =?,
                                `scaleId` =?,
                                `colorId` =?,
                                `storeId` =?,
                                $sqlQtyJoin
                                `userId`  =?,
                                `tempUser`=?,
                                `hash`    =?,
                                `deal`    =?,
                                `info`    =?
                                ";

            $json = serialize($json);
            $array = array($pId, $scaleId, $colorId, $storeId,
                $userId, $TempUserId, $hashCart,$dealId,$json);
            $this->dbF->setRow($sql, $array);
        }
        if (!$this->dbF->rowCount){
            echo "Product Add In Cart Fail Please Try Again";
        }else{
            echo "1";
        }

    }


function decimal_to_time($decimal) {
    $hours = floor($decimal / 60);
    $minutes = floor($decimal % 60);
    $seconds = $decimal - (int)$decimal;
    $seconds = round($seconds * 60);
 
    return str_pad($hours, 2, "0", STR_PAD_LEFT) . ":" . str_pad($minutes, 2, "0", STR_PAD_LEFT) . ":" . str_pad($seconds, 2, "0", STR_PAD_LEFT);
}



    public function Holidayhourdays(){
      //  var_dump($_POST);
       //  $_POST['based_on'];
      if ($_POST['based_on'] == 'days') 
      {
         $working_days = $_POST['working_days'];
         $start_date = $_POST['start_date'];
         $end_date = $_POST['end_date'];
         $date1 = $start_date;
         $date2 = $end_date;

          $start = strtotime($start_date);
          $end = strtotime($end_date);

          $days_between = ceil(abs($end - $start) / 86400);

          $holiday =    ($working_days * 5.6)*($days_between/365);
     // echo $holiday;
         $array =   array($holiday,$_POST['based_on']);
          echo json_encode($array);
      }
       if ( $_POST['based_on'] == 'hours') {
          $working_hours = $_POST['working_hours'];
          $start_date = $_POST['start_date'];
          $end_date = $_POST['end_date'];
          $date1 = $start_date;
          $date2 = $end_date;



          $start = strtotime($start_date);
          $end = strtotime($end_date);

          $days_between = ceil(abs($end - $start) / 86400);
  
 


           $holiday =    ($working_hours * 0.7)*($days_between/365);
        
      $holiday = $holiday*8;

   
          $array =  array($holiday,$_POST['based_on']);
            echo json_encode($array);
   /// echo $this->decimal_to_time($holiday); // prints 11:11:11
// $h = intval($holiday);
//     $m = round((((($holiday - $h) / 100.0) * 60.0) * 100), 0);
//     if ($m == 60)
//     {
//         $h++;
//         $m = 0;
//     }
//     $retval = sprintf("%02d:%02d", $h, $m);
//     echo $retval;

        }
 
    }
    public function AddToCartCustom(){

   



        if (isset($_POST['customPId']) ){
            $pId        = htmlspecialchars($_POST['customPId']);
            $custom_id  = $_POST['custom_id'];
            $storeId    = $_POST['customStore_' . $pId];
            $colorId    = $_POST['customColor_' . $pId];
            @$submit_later = $_POST['customSubmit_later_' . $pId];
            $submit_later  = empty($submit_later) ? '0' : '1';

            $userId     = webUserId();
            $tempHash   = $userId;
            $TempUserId = webTempUserId();

            $tempOld = webUserOldTempId();

            if ($tempOld != ""){
                //user is login ... so i get his old temp id,, for hash key match...
                $tempHash = $tempOld;
            }

            if(intval($userId)<1){
                //echo "here $userId 3 old $tempOld | temp | $TempUserId || ";
                $tempHash = $TempUserId;
            }

            @$customFields      = htmlspecialchars($_POST['custom']);
            $customFieldsS      =   serialize($customFields);
            $hashOfCustomFields = md5(str_replace(" ","",$customFieldsS).":");
            $scaleId            = $hashOfCustomFields;

            $customPrice        = $this->productClass->customSizePrice($pId);

            //Hash for cart
            @$hashVal   = $pId . ":" . $scaleId . ":" . $colorId . ":" . $storeId . ":" . $tempHash;
            $hashCart   = md5($hashVal);

            //check cart already or not
            $sqlCheck = "SELECT * FROM `cart` WHERE `hash` = ?";
            $cartData = $this->dbF->getRow($sqlCheck,array($hashCart));
            if ($this->dbF->rowCount > 0){
                $qty = $cartData['qty'];
                $cartId = $cartData['id'];
                $sql = "UPDATE `cart` SET
                                `qty`     = qty+1,
                                `userId` = '$userId'
                                  WHERE `id`= '$cartId'";
                $this->dbF->setRow($sql);

                //update submitLater info on cart submit.....
                $sql = "UPDATE p_custom_submit SET submitLater = '$submit_later' WHERE id IN (SELECT customId FROM cart WHERE `id`= '$cartId')";
                $cartData = $this->dbF->setRow($sql);
            } else {
                //Submit Custom Fields
                $pInfo  =   "$pId-custom-$colorId-$storeId";
                $sql    =   "INSERT INTO p_custom_submit(pInfo,custom_id,actualPrice,submitLater) VALUES (?,?,?,?)";
                $this->dbF->setRow($sql,array($pInfo,$custom_id,$customPrice,$submit_later));
                $customId = $this->dbF->rowLastId;

                $sqlArray = array();
                $isFields = false;
                $sql    =   "INSERT INTO p_custom_submit_setting(orderId,setting_name,setting_value) VALUES ";

                foreach($_POST['custom'] as $key2=>$val2){
                    $isFields = true;
                    $sql .= "(?,?,?),";
                    $sqlArray[] = $customId;
                    $sqlArray[] = $key2;
                    $sqlArray[] = $val2;
                }

                $sql = trim($sql,",");
                if($isFields){
                    $this->dbF->setRow($sql, $sqlArray);
                }

                $sql    = "INSERT INTO `cart` SET
                                `pId`     =?,
                                `scaleId` ='0',
                                `colorId` =?,
                                `storeId` =?,
                                `customId` = ?,
                                `qty`     = '1',
                                `userId`  =?,
                                `tempUser`=?,
                                `hash`    =?";

                $array  = array($pId, $colorId, $storeId,$customId,
                    $userId, $TempUserId, $hashCart);
                $this->dbF->setRow($sql, $array);
                if($this->dbF->rowCount>0){
                    echo "1";
                }else{
                    echo "0";
                }
            }
        }
    }

    public function AddPlusToCart()
    {
        if (isset($_POST['cartId'])) {
            $cartId = $_POST['cartId'];

            if(isset($_POST['addQty'])){
                @$customQty = intval($_POST['addQty']);
            }else{
                $customQty = false;
            }

            $hasCustomQty = false;
            if(!empty($customQty)){
                $hasCustomQty = true;
            }

            //Get Detail For get Product total Qty in stock
            $sql = "SELECT * FROM `cart`
                                WHERE `id`= ? ";
            $data = $this->dbF->getRow($sql,array($cartId));
            if ($this->dbF->rowCount > 0) {
                $pId = $data['pId'];
                $storeId = $data['storeId'];
                $scaleId = $data['scaleId'];
                $colorId = $data['colorId'];
                $qty     = $data['qty'];
                $dealId  = $data['deal'];
                $customId = $data['customId'];
                @$info   = unserialize($data['info']);

                if($hasCustomQty){
                    $qty = $customQty;
                }else{
                    $qty++;
                }


                if($dealId != '0'){
                    $totalQty = $this->productClass->getDealLowestProductQty($info);
                }else{
                    $totalQty = $this->productClass->productF->productQTY($pId, $storeId, $scaleId, $colorId);
                }

                //check if stock work, then qty check
                if($customId == '0' && $this->functions->developer_setting('product_check_stock') == '1') {
                    if ($qty > $totalQty) {
                        echo 'Quantity out of stock: Limit QTY :'.$totalQty;
                        return false;
                    }
                }

            }


            $sqlQtyJoin = "`qty`     = qty+1";
            if($hasCustomQty) {
                $sqlQtyJoin = "`qty`= '$customQty'";
            }

            $sql = "UPDATE `cart` SET
                                $sqlQtyJoin
                                WHERE `id`= '$cartId'";
            $this->dbF->setRow($sql);
        }
    }

    public function addByQty()
    {
        if (isset($_POST['cartId'])) {
            $cartId = htmlspecialchars($_POST['cartId']);
            $newQty = intval($_POST['addQty']);

            //Get Detail For get Product total Qty in stock
            $sql = "SELECT * FROM `cart`
                                WHERE `id`= ?";
            $data = $this->dbF->getRow($sql,array($cartId));
            if ($this->dbF->rowCount > 0) {
                $pId     = $data['pId'];
                $storeId = $data['storeId'];
                $scaleId = $data['scaleId'];
                $colorId = $data['colorId'];
                $qty     = $data['qty'];
                $dealId  = $data['deal'];
                @$info   = unserialize($data['info']);

                if($dealId != '0'){
                    $totalQty = $this->productClass->getDealLowestProductQty($info);
                }else{
                    $totalQty = $this->productClass->productF->productQTY($pId, $storeId, $scaleId, $colorId);
                }
                if ($newQty > $totalQty) {
                    echo 'Quantity out of stock';
                    return false;
                }
            }

            $sql = "UPDATE `cart` SET
                                `qty`     = $newQty
                                  WHERE `id`= '$cartId'";
            $this->dbF->setRow($sql);
        }
    }

    public function minusFromCart()
    {
        if (isset($_POST['cartId'])) {
            $cartId = htmlspecialchars($_POST['cartId']);

            $sql = "UPDATE `cart` SET
                                `qty`     = qty-1
                                WHERE `id`= '$cartId' AND qty >= 0";
            $this->dbF->setRow($sql);
        }
    }

    public function cartProductRemove()
    {
        if (isset($_POST['cartId'])) {
            $cartId = $_POST['cartId'];

            $sql = "DELETE FROM `cart` WHERE `id`= '$cartId'";
            $this->dbF->setRow($sql);
            echo "1";
        }else{
            echo "0";
        }
    }

    public function getSearchJson()
    {
        $key        =   $_GET['val'];

        $key        = addslashes($key);
        $limit      =   3;
        if(isset($_GET['limit'])){
            $limit = $_GET['limit'];
        }
        //search All related Match products
        $sql            =    "SELECT prodet_id,prodet_name,product_update FROM `proudct_detail_spb` WHERE prodet_name LIKE '%$key%'  GROUP BY prodet_id
                                UNION
                                SELECT prodet_id,prodet_name,product_update FROM `proudct_detail_spb` WHERE prodet_name LIKE '%$key%' GROUP BY prodet_id LIMIT 0,$limit";
        $data           = $this->dbF->getRows($sql);

        if($this->dbF->rowCount>0){
            $temp = "[";
            foreach($data as $val){
                $id    =   $val['prodet_id'];
                $pName       =   translateFromSerialize($val['prodet_name']);

                $key2       =   stripslashes($key);
                $pName2      =   str_ireplace($key2,'<span class="searchHighlight">'.$key2.'</span>',$pName);

                $img    =   $this->productClass->productF->productSpecialImage($id,'main');
                $img    =   $this->productClass->functions->resizeImage($img,'auto',70,false);

                $price = $this->productClass->productF->productPrice($id);
                $currencyId =   $price['propri_cur_id'];
                $symbol     =   $this->productClass->productF->currencySymbol($currencyId);
                $priceP =   $price['propri_price'];

                $discount       =   $this->productClass->productF->productDiscount($id,$currencyId);
                @$discountFormat=   $discount['discountFormat'];
                @$discountP     =   $discount['discount'];

                $discountPrice  =   $this->productClass->productF->discountPriceCalculation($priceP,$discount);
                $newPrice       =   $priceP - $discountPrice;

                $priceP         .= ' '.$symbol;
                $newPrice       .= ' '.$symbol;

                if($newPrice    !=  $priceP){
                    $hasDiscount = true;
                    $oldPriceDiv = '<span class="oldPrice">'.$priceP.'</span>';
                    $newPriceDiv = '<span class="NewDiscountPrice">'.$newPrice.'</span>';
                }else{
                    $oldPriceDiv= "";
                    $newPriceDiv = '<span class="NewDiscountPrice">'.$priceP.'</span>';
                }

                $pName      =   addslashes($pName);
                $pName2      =   addslashes($pName2);
                $img        =   addslashes($img);
                $temp .= '{
                        "label"     : \''.$pName.'\',
                        "id"        : "'.$id.'",
                        "name"      : \''.$pName2.'\',
                        "image"     : "'.$img.'",
                        "priceCode" : "'.$symbol.'",
                        "newPrice"  : \''.$newPriceDiv.'\',
                        "oldPrice"  : \''.$oldPriceDiv.'\'
                        },';
            }
            $temp= trim($temp,',');
            $temp .= "]";
        }else{
            $temp   =    "[]";
        }

        echo $temp;


    }

    public function cartSmallProduct(){
       $cartInfo = $this->productClass->cartInfo(true);
        $price  = $cartInfo['price']." ".$cartInfo['symbol'];
        $products = $cartInfo['products'];
        $qty    = $cartInfo['qty'];

        if(!isset($_GET['product'])){
            $products   =   '';
        }
        echo "$products
        <script>
        $(document).ready(function(){
            $('.cartPriceAjax').text('$price');
            $('.cartItemNo').text('$qty');
        });
        </script>";
    }

    public function addRating(){
        $this->functions->_modelFile("classes/rating.php");
        $rate  = new rating();
        $rate->addRatings_();
    }

    # prev sql
    // SELECT id FROM `products` WHERE `id` != 5 AND `category` = 'International Products' AND `id` < 5 ORDER BY `id` DESC LIMIT 1     

    # NEXT OR LAST SQL
// (SELECT * FROM products WHERE id > 100 AND `category` = 'International Products' ORDER BY id ASC LIMIT 1)
// UNION (SELECT * FROM products WHERE id = (SELECT MAX(id) FROM products))
// LIMIT 1

// -- previous or last, if there is no previous
// (SELECT * FROM images WHERE image_id < 12345 ORDER BY image_id DESC LIMIT 1)
// UNION (SELECT * FROM images WHERE image_id = (SELECT MAX(image_id) FROM images))
// LIMIT 1

// -- next or first, if there is no next
// (SELECT * FROM images WHERE image_id > 12345 ORDER BY image_id ASC LIMIT 1)
// UNION (SELECT * FROM images WHERE image_id = (SELECT MIN(image_id) FROM images))
// LIMIT 1


# http://stackoverflow.com/questions/594668/get-previous-and-next-row-from-current-idd

    public function get_next_product($product_id, $category_name)
    {
        intval($product_id);
        htmlspecialchars($category_name);
        return $this->dbF->getRow(' SELECT id FROM `products` WHERE `category` = ? AND `id` > 1 ORDER BY `id` ASC LIMIT 1  ', array($product_id, $category_name) );
    }

    public function product_detail_popup( $value='' )
    {
        global $webClass;
        $id      = intval($_POST['id']);
        $today   = date('Y-m-d');
        $product = $this->dbF->getRow(' SELECT * FROM `products` WHERE `id` = ? AND  `product_update` = 1 AND `publish_date` <= ? ', array($id, $today) );

        $product_name = translateFromSerialize($product['heading']);
        $product_desc = translateFromSerialize($product['dsc']);
        $product_fact = translateFromSerialize($product['nutritional_facts']);
        // echo($product['heading']);
        $product_image_spbs = $webClass->get_product_image_spbs($product['id']);
        $product_image_spbs_html = $webClass->print_product_image_spbs($product_image_spbs);

        $product_recipes = $webClass->get_product_recipes($product['id']);
        $product_recipes_html = $webClass->print_product_recipes($product_recipes);



        $html    = <<<HTML




<div class="show_hide_box">
      
      <span class="close_btn"> X </span>

      <span class="left_btn"> <i class="fa fa-angle-left"> </i></span>
      <span class="right_btn"><i class="fa fa-angle-right"> </i></span>
      
      <div class="content_box">

        <div class="first_section">
            
            <div class="brands">

            {$product_image_spbs_html}

            </div>


            <div class="rec_">

                {$product_recipes_html}

            </div>
          
        </div>

        <div class="detail_section">
              
            <h2> {$product_name} </h2>
            
            {$product_desc}

        </div>
<div class="third_div">
        {$product_fact}
</div>
      </div>

</div>


HTML;



        echo $html;

    }

    public function flagQuestion(){

        $result_id = intval($_POST['result_id']);

        $sql = "UPDATE `test_result` SET `flag` = 1 WHERE `result_id` = ?";
        $res = $this->dbF->setRow($sql, array($result_id));

        if($this->dbF->rowCount > 0){
            echo '1';
        }else{
            echo '0';
        }
    }



        public function flagQuestionSelect(){

        $result_id = intval($_POST['result_id']);

        $sql = "SELECT * from `test_result` WHERE `result_id` = ? and `flag` = 1";
        $res = $this->dbF->setRow($sql, array($result_id));

        if($this->dbF->rowCount > 0){
            echo '1';
        }else{
            echo '0';
        }
    }

  public function flagQuestionZero(){

        $result_id = intval($_POST['result_id']);

        $sql = "UPDATE `test_result` SET `flag` = 0 WHERE `result_id` = ?";
        $res = $this->dbF->setRow($sql, array($result_id));

        if($this->dbF->rowCount > 0){
            echo '1';
        }else{
            echo '0';
        }
    }  public function chkDuplicateSKU(){

        $result_id = ($_POST['result_id']);
  $sql = "SELECT * from `product_inventory_detail` WHERE `p_code` = ? and `p_code` !=''";
        $res = $this->dbF->setRow($sql, array($result_id));

        if($this->dbF->rowCount > 0){
            echo '1';
        }else{
            echo '0';
        }
    }
 public function updateStockDedeuct(){

        $orderid = $_POST['orderid'];
        $invoice = $_POST['invoice'];
        $prev_status = $_POST['prev_status'];
        $message = $_POST['message'];
  
   $sql = "UPDATE `stockOrder` SET  `status` = ?,`comm` = ? WHERE `id`= ?";
                    $this->dbF->setRow($sql,array($invoice,$message,$orderid));


if($invoice == '1'  && $prev_status == '0'){


$sqlCheck = "SELECT * FROM `stockOrderDetail` WHERE `fKey` = ? ";
 $eventFormsData =  $this->dbF->getRows($sqlCheck,array($orderid));


foreach ($eventFormsData as $key => $value) {

$hash = $value['hasH'];
$pqty = $value['qty'];
$store = $value['storeid'];

$sqlCheck="SELECT `product_store_hash` FROM `product_inventory` WHERE `product_store_hash` = '$hash' and qty_store_id = ?";
$this->dbF->getRow($sqlCheck,array($store));
if($this->dbF->rowCount>0){
$date =date('Y-m-d H:i:s'); //2014-09-24 13:46:10

$sql= "UPDATE `product_inventory` SET `qty_item` = qty_item-$pqty , `updateTime` = '$date' WHERE `product_store_hash` = '$hash' and `qty_store_id` = '$store'";
 $this->dbF->setRow($sql);
}else{
}


}



}



        if($this->dbF->rowCount > 0){
            echo '1';
        }else{
            echo '0';
        }
    }
    public function SessionStart(){
        echo "1";
    }

public function setPlayerId() {
      $playerId = htmlspecialchars($_POST['playerId']);
       if(isset($_POST['status'])){$status = htmlspecialchars($_POST['status']);}else{$status = "do";}
    
    //  $_SESSION['webUser']['plyrid']= $status;
     if($status != 'not' ){
      htmlspecialchars($_SESSION['webUser']['plyrid']);
     
    if (isset($_SESSION['webUser']['id'])) {
        // $id = $_SESSION['currentUser'];
        $id = intval($_SESSION['webUser']['id']);
        $arry1 = array($playerId);
        $sql = "SELECT `player_id` FROM `accounts_user` WHERE `accounts_user`.`acc_id` = ";
        $data = $this->dbF-> getRow($sql,array($id));
        $arry2 = explode(",", $data[0]);
        if (in_array($playerId, $arry2)) {
            echo " already exist";
        } else {
            $arry = array_merge($arry1, $arry2);
            $arry = array_unique($arry);
            $arry = implode(",",$arry);
            $arry = trim($arry,",");
            $sql = "UPDATE `accounts_user` SET `player_id` = '$arry' WHERE `accounts_user`.`acc_id` = ?";
            $this->dbF->setRow($sql,array($id));
            echo " Player ID Updated";
        }
    }
}
    
    
}

// playerId close
    public function chkPlayerId() { 

     $playerId = htmlspecialchars($_POST['playerId']);
     
    if (isset($_SESSION['webUser']['id'])) {
    
        // $id = $_SESSION['currentUser'];
        $id = intval($_SESSION['webUser']['id']);
        $arry1 = array($playerId);
        $sql = "SELECT `player_id` FROM `accounts_user` WHERE `accounts_user`.`acc_id` = ?";
        $data = $this->dbF-> getRow($sql,array($id));
        $arry2 = explode(",", $data[0]);
        // var_dump($arry2);
        if (in_array($playerId, $arry2)) {
            echo "done";
        } else {
            echo "do";
        }
        
    }



}


    public function selectProduct(){
        $pId = intval($_POST['pId']);

        $sql_det = "SELECT `prodet_name`,`validity` FROM `proudct_detail_spb` WHERE `prodet_id` = ?";
        $res_det = $this->dbF->getRow($sql_det, array($pId));

        $prodet_name = translateFromSerialize($res_det['prodet_name']);

        $sql_price = "SELECT * FROM `product_price_spb` WHERE `propri_prodet_id` = ?";
        $res_price = $this->dbF->getRow($sql_price, array($pId));
         $pPriceActual =       $res_price['propri_price'];    
        //=======================================coupon==============================
       
             @$coupon_id = $_SESSION['webUser']['coupon_id'];
            @$coupon_from = $_SESSION['webUser']['coupon_from'];
            @$coupon_to = $_SESSION['webUser']['coupon_to'];
            @$coupon_hash = $_SESSION['webUser']['coupon_hash'];
            @$coupon_hash2 = $_SESSION['webUser']['coupon_hash2'];
           

            if ($coupon_hash == $coupon_hash2) {
        // echo base64_decode($_GET['coupon']);
            
  $sql1 = "SELECT * FROM product_coupon_spb WHERE pCoupon_pk = ? and (pCoupon_products ='' OR pCoupon_products IN ($pId))";
           $data1 =  $this->dbF->getrow($sql1,array($coupon_id));


           if ($this->dbF->rowCount > 0) {





              $sql2 = "SELECT * FROM `product_coupon_prices_spb` WHERE pSale_price_id = ? ";
              $data2 =  $this->dbF->getrow($sql2,array($coupon_id));
          
       
// if($_SERVER['REMOTE_ADDR'] == '39.48.151.123'){
  
//       echo "<pre>";
//       echo $data1['pCoupon_format'];
//       echo  $data2['pSale_price_price']; 
//       echo "ddddddddddddddddddddddddd";
//       var_dump($_SESSION['webUser']);
//       echo "<pre>";
           
  
  
// }

          if ($data1['pCoupon_format'] == 'price') {
            $Cprice = $data2['pSale_price_price'];
            $pPriceActual = ($pPriceActual - $Cprice  );
          }
          if ($data1['pCoupon_format'] == 'percent') {
            $percentage = $data2['pSale_price_price'];
              
             $percent = ($pPriceActual / 100) * $percentage;
              $pPriceActual = $pPriceActual - $percent;
          }



      }else{}
        }
        //=======================================coupon==============================

        $return = array(
               "pname"   => $prodet_name,
               "validity" => $res_det['validity'],
               "price"  => $pPriceActual,
        );
        echo json_encode($return);
    }

    public function activity_benefit(){
        $txt = htmlspecialchars($_POST['txt']);
        $id  = intval($_POST['id']);
        $sql = "UPDATE `assigned_paper` SET `activity_benefit` = ? WHERE `assigned_paper`.`assign_id` = ?";
        $this->dbF->setRow($sql,array($txt,$id));
        if($this->dbF->rowCount > 0){
            echo '1';
        }else{
            echo '0';
        }
    }

    public function again_login(){
        $user  = intval($_SESSION['webUser']['id']);
        $pin   = hash("md5", $this->functions->encode($_POST['pin']));
        $sql = "SELECT * FROM `accounts_user` WHERE acc_id=? AND MD5(acc_pin)=?";
        $data = $this->dbF->getRow($sql,array($user,$pin));
        if($this->dbF->rowCount > 0){
            setcookie('again', 'true', time() + (3600*2), "/");
            echo '1';
        }else{
            echo 'Invalid Pin';
        }
    }

    public function checkinout(){
        $qr = htmlspecialchars($_POST['qr']);
        $time = htmlspecialchars($_POST['time']);
        $type = htmlspecialchars($_POST['type']);
        $ar = htmlspecialchars($_POST['ar']);
         
         // if ($type == "checkin_rota_not") {
         //     $type = 'checkin';
         // }
      
        $user = intval($_SESSION['webUser']['id']);
        $pid = $this->functions->PracticeId($user);
        $sql = "SELECT * FROM `accounts_user` WHERE `acc_qr`='$qr' AND `acc_id`= ?";
        $data = $this->dbF->getRow($sql,array($pid));
    if(!empty($data) && ($type != "checkin_rota_not") && ($type != "lunch_time_checkin") && ($type != "lunch_time_checkout" )){
          


            $sql = "UPDATE `record` SET `$type`=? WHERE `date`= CURRENT_DATE AND userId='$user'";
            $this->dbF->setRow($sql,array($time));
            if($this->dbF->rowCount > 0){
                if($type == 'checkin' ){
                    $this->functions->setlog("Checkin",$this->functions->UserName($user)." : $user",$user,$time);
                    $email = $this->functions->UserEmail($user);
                    $this->functions->push_notification('Good Morning Sunshine','You have clocked in successfully',$this->functions->getUserPlayerId($user));
                    $this->functions->send_mail($email,'Good Morning Sunshine','You have clocked in successfully');
                    $this->functions->dbF->setRow("DELETE FROM `cronData` WHERE `user`='$user' AND `type`='inlate'"); 
                }
                  elseif($type == 'checkout'){
                    $this->functions->setlog("Checkout",$this->functions->UserName($user)." : $user",$user,$time);
                    $email = $this->functions->UserEmail($user);
                    $this->functions->push_notification('Home Time','You have clocked out successfully',$this->functions->getUserPlayerId($user));
                    $this->functions->send_mail($email,'Home Time','You have clocked out successfully');
                    $this->functions->dbF->setRow("DELETE FROM `cronData` WHERE `user`='$user' AND `type`='outlate'");
                }
                
              


                echo '1';
            }
            else{
                        echo "Error A";
            }
        }
            elseif(!empty($data) && $type == 'checkin_rota_not'){
                  $_POST['submit'] = 'submit';
                 
                    if ($fn = $this->functions->checkin_not_rota_set()) {
                        echo "1";
                    }else{
                           
                        // var_dump($fn);  
                        echo "Error B";
                    }
                }
      
            elseif(!empty($data) && $type == 'lunch_time_checkin'){
                  $_POST['submit'] = 'submit';
                    if ($fn = $this->functions->lunch_time_checkin()) {
                        echo "1";
                    }else{
                           
                         //var_dump($fn);  
                        echo "Error in lunch time checkin";
                    }
                }
      
            elseif(!empty($data) && $type == 'lunch_time_checkout'){
                  $_POST['submit'] = 'submit';
                    if ($fn = $this->functions->lunch_time_checkout()) {
                        echo "1";
                    }else{
                           
                        // var_dump($fn);  
                        echo "Error in lunch time checkout";
                    }
                }
        else{
            echo 'invalid QR code';
        }
    }

    public function GetData()
    {
       $id =   intval($_GET['id']);
        $sql2 = "SELECT * FROM `userevent` WHERE `id`=?";
$data2 = $this->dbF->getRow($sql2,array($id));
$tid = $data2['title_id'];
 $sql5 = "SELECT * FROM `userevent` WHERE `title_id`='$tid' AND `approved` = '1'";
$data5 = $this->dbF->getRow($sql5);

 $data5['title_id'];
      // 
        
    }

    public function addShift(){
            $shift_name    = empty($_POST['shift_name'])     ? ""    : $_POST['shift_name'];
            $dentist_id    = empty($_POST['dentist_id'])   ? ""    : $_POST['dentist_id'];
            $timefrom  = empty($_POST['timefrom']) ? ""    : $_POST['timefrom'];
            $timeto    = empty($_POST['timeto'])   ? ""    : $_POST['timeto'];
            $break     = empty($_POST['tbreak'])    ? ""    : $_POST['tbreak'];
            $color     = empty($_POST['color'])    ? ""    : $_POST['color'];
            $timefrom  = date("H:i", strtotime($timefrom));
            $timeto    = date("H:i", strtotime($timeto));
            $user = $_SESSION['currentUser'];

htmlspecialchars($shift_name);
intval($dentist_id);
htmlspecialchars($timefrom);
htmlspecialchars($timeto);
htmlspecialchars($break);
htmlspecialchars($color);
htmlspecialchars($timefrom);
htmlspecialchars($timeto);
intval($user);
            try{
                $this->db->beginTransaction();
                $sql      =   "INSERT INTO `shift`(`user`,`shift_name`,`dentist_id`,`timefrom`,`timeto`,`break`,`color`) VALUES ('$user','$shift_name','$dentist_id','$timefrom','$timeto','$break','$color')";
                $this->dbF->setRow($sql);
                if($_SESSION['currentUserType'] == 'Employee'){$user=$_SESSION['webUser']['id'];}
                $this->functions->setlog("Shift Add",$this->functions->UserName($user)." : ".$user,"",$shift_name);
                $this->db->commit();
                if($this->dbF->rowCount>0){
                    echo '1';
                }else{
                    return false;
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                return false;
            }
    }
    public function changeStatuses()
{  
$edit_id = intval($_POST['value']);
if (!empty($_POST['value'])) {

$sqlCheck = "SELECT `status` FROM `clientAddIssue` WHERE `id` = ? ";
$totalQty = $this->dbF->getRow($sqlCheck,array($edit_id));


$s = 1;
if($totalQty['status'] == "1"){

$s = 0;

}



$sql      =   "UPDATE `clientAddIssue` SET `status` = ? WHERE `id` = ?";
$array   = array($s,$edit_id);
$this->dbF->setRow($sql,$array,false);


}

}





    public function addTobasket(){
        
                    $value    = empty($_POST['value'])     ? ""    : $_POST['value'];
                    $now    =   date('Y-m-d h:i:a');
$users=$_SESSION['webUser']['id'];
                    $user = intval($_SESSION['currentUser']);
            
            try{
                $this->db->beginTransaction();



                    $sql = "INSERT INTO addTobasket
                            (loginid,practId,hash,now)
                            values (?,?,?,?)";
            $this->dbF->setRow($sql, array($users, $user, $value, $now));




                if($_SESSION['currentUserType'] == 'Employee'){$user=$_SESSION['webUser']['id'];}
                $this->functions->setlog("add To basket",$this->functions->UserName($user)." : ".$user,"",$value);
                $this->db->commit();
                if($this->dbF->rowCount>0){
                    echo '1';
                }else{
                    return false;
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                return false;
            }
    }




    public function editShift(){
        
            $editID    = empty($_POST['editID'])     ? ""    : $_POST['editID'];
            $shift_name    = empty($_POST['shift_name'])     ? ""    : $_POST['shift_name'];
            $dentist_id    = empty($_POST['dentist_id'])   ? ""    : $_POST['dentist_id'];
            $timefrom  = empty($_POST['timefrom']) ? ""    : $_POST['timefrom'];
            $timeto    = empty($_POST['timeto'])   ? ""    : $_POST['timeto'];
            $break     = empty($_POST['tbreak'])    ? ""    : $_POST['tbreak'];
           $color     = empty($_POST['color'])    ? ""    : $_POST['color'];
            $timefrom  = date("H:i", strtotime($timefrom));
            $timeto    = date("H:i", strtotime($timeto));
            $user = intval($_SESSION['currentUser']);
            
            try{
                $this->db->beginTransaction();
                $sql      =   "UPDATE `shift`  SET
                `user`= ?,
                `shift_name`= ?,
                `dentist_id`= ?,
                `timefrom`= ?,
                `timeto`= ?,
                `break`= ?,
                `color` = ?
                  WHERE id = $editID";
                  $array = array($user,$shift_name,$dentist_id,$timefrom,$timeto,$break,$color);
               
                $this->dbF->setRow($sql,$array);
                if($_SESSION['currentUserType'] == 'Employee'){$user=$_SESSION['webUser']['id'];}
                $this->functions->setlog("Shift Edit",$this->functions->UserName($user)." : ".$user,"",$shift_name);
                $this->db->commit();
                if($this->dbF->rowCount>0){
                    echo '1';
                }else{
                    return false;
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                return false;
            }
    }
    
       public function DeleteTrashData(){
          if($_SESSION['currentUserType'] == 'Employee')
        {$user= intval($_SESSION['superid']);}
    else
       {$user = intval($_SESSION['currentUser']);}

   $edit_id = intval($_POST['itemId']);
     $sql =  "SELECT * FROM `trashdata` WHERE id = ? ";
       $data=$this->dbF->getRow($sql,array($edit_id));
       
      $ds = "Page Name::".$data['delete_page_name']."::Description::".$data['delete_desc']."File Name::".$data['delete_file']."Delete User By::".$this->functions->UserName($data['delete_from_user'])."Delete User Of::".$this->functions->UserName($data['delete_to_user'])."Delete Table Name::".$data['delete_table_name']."Delete Table Id::".$data['delete_table_id']."Delete Event Perform::".$data['event_perfom']."";  
     
     $this->functions->setlog("TrashData Record Delete ","User By::".$this->functions->UserName($user)." :User off".$this->functions->UserName($data['delete_to_user']),$user,$ds);
         $sql1 = "DELETE FROM `trashdata` WHERE id = '$edit_id'";
         $this->dbF->setRow($sql1);
          
        if($this->dbF->rowCount > 0){
            echo 1;
        }
     }  




public function trashAllEventsInitialHealthChk(){
$edit_id = intval($_POST['id']);
// $smartQuery = '';

$smartQuery = $this->functions->makeRecoverySQL('userevent','user',$edit_id);

$sql1 = "DELETE FROM `userevent` WHERE user = '$edit_id'";
$this->dbF->setRow($sql1);



          $sql = "UPDATE  accounts_user SET
                               
                                health_form = ?
                                WHERE acc_id = '$edit_id'";
                    $array = array("0");
                    $this->dbF->setRow($sql,$array,false);



$this->functions->TrashData('Admin Reset Initial Health Form',"delete_desc","delete_file",$edit_id,$edit_id,'userevent',$edit_id,'Admin Reset Initial Health Form',$smartQuery);


}


    public function updateIMPORTfromTrash(){
// if($_SESSION['currentUserType'] == 'Employee')
// {$user=$_SESSION['superid'];}
// else
// {$user = $_SESSION['currentUser'];}

$edit_id = $_POST['id'];
$event_perfom = $_POST['event_perfom'];

$sqlc =  "SELECT * FROM `trashdata` WHERE id = '$edit_id'";
$datac=$this->dbF->getRow($sqlc,false);
// var_dump($datac);


if($event_perfom == "deleteDocumentall"){

    $str = str_replace("All Document Delete file (", "", $datac['delete_desc']);
$str = str_replace(") (", "::", $str);
 
$str=explode("::",$str);
 
 

$title=str_replace("Title :","",$str[0]);
$cat=str_replace("category :","",$str[1]);
$subcat=str_replace("sub category is","",$str[2]);
$subcat=str_replace(")","",$subcat);


$aRR = array($title,$cat,$subcat,$datac['delete_to_user'],$datac['delete_file'],"",$datac['delete_table_id']);
}else{


 

    $str = str_replace("delete userdocuments File  (", "", $datac['delete_desc']);
$str = str_replace(")(", "::", $str);
 
$str=explode("::",$str);
 
 

$title=str_replace("title is :","",$str[0]);
$cat=str_replace("category is ","",$str[1]);
 
$cat=str_replace(" )","",$cat);
$aRR = array($title,$cat,"",$datac['delete_to_user'],$datac['delete_file'],"",$datac['delete_table_id']);

}



 




// var_dump($aRR);
  $sql    =   "INSERT INTO userdocuments(title,category,sub_dcategory,user,file,title_id,id) VALUES (?,?,?,?,?,?,?)";
                $this->dbF->setRow($sql,$aRR);
if($this->dbF->rowCount > 0){






$this->functions->setlog("Recover by admin","User By::".$this->functions->UserName($user)." :User off".$this->functions->UserName($data['userID']),$user,$datac['delete_desc']." file: ".$datac['delete_file']);

$sql1c = "DELETE  FROM `trashdata`  WHERE id = '$edit_id'";
$this->dbF->setRow($sql1c);


echo '1';
}
}

public function valueOfCourceData(){
$valueOfCource = $_POST['valueOfCource'];
$dDate = $_POST['valueOfDate'];
$sqlc =  "SELECT * FROM `subjects` WHERE subject_id = '$valueOfCource'";
$datac=$this->dbF->getRow($sqlc,false,true,true);

if($this->dbF->rowCount > 0){


 // $dDate =date('Y-m-d',strtotime($dDate));


 $sqlc1 =  "SELECT * FROM `paper` WHERE subject_id = '$datac[subject_id]'";
$datac1=$this->dbF->getRow($sqlc1,false,true,true);
$expiry_date = date('Y-m-d',strtotime('+ '.$datac['expiration'].' Month', strtotime($dDate)));

$a = array($datac['subject_id'],$datac['subject_title'],$datac['expiration'],$datac['minutes'],$datac1['aim'],$datac1['objectives'],$datac1['learning_content'],$datac1['development_outcomes'],$expiry_date);
echo json_encode($a);

}
}
public function qImport(){
$edit_id = $_POST['id'];
$sqlc =  "SELECT qImport FROM `trashdata` WHERE id = '$edit_id'";
$datac=$this->dbF->getRow($sqlc,false);
$q =trim($datac['qImport'],"; ");
$this->dbF->setRow($q);
if($this->dbF->rowCount > 0){
$sql1c = "DELETE  FROM `trashdata`  WHERE id = '$edit_id'";
$this->dbF->setRow($sql1c);
echo '1';
}
}


    public function deleteClientInCRMpage(){
if($_SESSION['currentUserType'] == 'Employee')
{$user=$_SESSION['superid'];}
else
{$user = $_SESSION['currentUser'];}

$edit_id = $_POST['itemId'];


$sqlc =  "SELECT name FROM `clientAddTbl` WHERE id = '$edit_id'";
$datac=$this->dbF->getRow($sqlc,false);




$sql1 = "DELETE  FROM `clientAddTbl`  WHERE id = '$edit_id'";
$this->dbF->setRow($sql1);

if($this->dbF->rowCount > 0){

$sql =  "SELECT id FROM `clientCreateNotes` WHERE fid = '$edit_id'";
$data=$this->dbF->getRow($sql,false);




$sql11 = "DELETE  FROM `clientCreateNotes`  WHERE fid = '$edit_id'";
$this->dbF->setRow($sql11);


$sql11 = "DELETE  FROM `clientCreateNotes_comments`  WHERE fid = '$data[id]'";
$this->dbF->setRow($sql11);




$this->functions->setlog("Delete Client","User By::".$this->functions->UserName($user)." :User off".$this->functions->UserName($data['userID']),$user,$datac['name']);




echo '1';
}
}



    public function resetCPDform(){
          if($_SESSION['currentUserType'] == 'Employee')
        {$user=intval($_SESSION['superid']);}
    else
       {$user = intval($_SESSION['currentUser']);}


          $edit_id = intval($_POST['resetId']);
      $sql =  "SELECT * FROM `initialCPD` WHERE id = ? ";
       $data=$this->dbF->getRow($sql,array($edit_id));
         
         $ds = "`id::".$data['id']."user::".$data['user']."cycle::".$data['cycle']."start_date::".$data['start_date']."decontaimatnion::".$data['decontaimatnion']."medical_emegerncy::".$data['medical_emegerncy']."radiation::".$data['radiation']."complaint_handling".$data['complaint_handling']."data_protection::".$data['data_protection']."fire_safety::".$data['fire_safety']."health_safety::".$data['health_safety']."level_1::".$data['level_1']. "level_2::".$data['level_2']."level_3::".$data['level_3']. "oral_cancer::".$data['oral_cancer']. "first_aid::".$data['first_aid']. "any_courses::".$data['any_courses']."dateTime".$data['dateTime'].""; 

       $this->functions->setlog("Delete initialCPD","User By::".$this->functions->UserName($user)." :User off".$this->functions->UserName($data['user']),$user,$ds);
        
          $sql1 = "DELETE  FROM `initialCPD`  WHERE id = '$edit_id'";
          $this->dbF->setRow($sql1);
            
        if($this->dbF->rowCount > 0){
         echo '1';
        }
    }
     public function DeleteMyEventFile(){
          if($_SESSION['currentUserType'] == 'Employee')
        {$user=intval($_SESSION['superid']);}
    else
       {$user = intval($_SESSION['currentUser']);}

     $edit_id = intval($_POST['id']);
     $sql =  "SELECT * FROM `myevents` WHERE id = ? ";
       $data=$this->dbF->getRow($sql,array($edit_id));
       // echo 1;
      $ds = "Page Name::Activity Calendar ::Description::".$data['desc']."File Name::".$data['file']."Delete User By::".$this->functions->UserName($user)."Delete User Of::".$this->functions->UserName($data['user'])."Delete Table Name:: myevents :: Delete Table Id::".$data['id']."Delete Event Perform:: Delete File myevent ";  
     
         
      // ========================TrashData========================================
    $ds = "delete Myevent Single File  (title is :".$data['title'].")(category is ".$data['category']." )";
        $this->functions->TrashData('Activity Calendar',$ds,$data['file'],$user,$data['user'],'myevent',$edit_id,'my Event Single File  ajax (Activity Calendar )');
    // ========================TrashData========================================
     $this->functions->setlog("Myevent File Delete ","User By::".$this->functions->UserName($user)." :User off".$this->functions->UserName($data['user']),$user,$ds);
          $sql1 = "UPDATE   `myevents` SET file = '#' WHERE id = '$edit_id'";
          $this->dbF->setRow($sql1);
          
        if($this->dbF->rowCount > 0){
         echo '1';
        }
     }
     public function deleteSingleDocumentFileTrash(){

    if($_SESSION['currentUserType'] == 'Employee')
        {$user=intval($_SESSION['superid']);}
    else
       {$user = intval($_SESSION['currentUser']);}
 // echo  'Index '.$_POST['indx'];
  //echo "<br>";
 // echo 'id'.$_POST['ths'];

   $file = htmlspecialchars($_POST['indx']);
   $edit_id = htmlspecialchars($_POST['ths']);
    $sql =  "SELECT * FROM `userdocuments` WHERE id = ? ";
       $data=$this->dbF->getRow($sql,array($edit_id));
        $title    = $data['title'];
     
     $this->functions->setlog("delete userdocuments Single File",$this->functions->UserName($user)." : ".$data['user'],"Practice Name is",$this->functions->UserName($user));

    // ========================TrashData========================================
    $ds = "delete userdocuments Single File  (title is :".$data['title'].")(category is ".$data['category']." )";
        $this->functions->TrashData('HR File Single Delete',$ds,$data[$file],$user,$data['user'],'userdocuments',$edit_id,'Single File trash ajax (HR Files)');
    // ========================TrashData========================================
    $sql = "UPDATE `userdocuments` SET $file =''  WHERE id = '$edit_id'";
        
        $this->dbF->setRow($sql);
        if($this->dbF->rowCount > 0){
            echo '1';
        }
 
       

     }
     public function EditEventFileTrash(){
    if($_SESSION['currentUserType'] == 'Employee')
        {$user=$_SESSION['superid'];}
    else
       {$user = $_SESSION['currentUser'];}
 // echo  'Index '.$_POST['indx'];
  //echo "<br>";
 // echo 'title id'.$_POST['ths'];

   $index = intval($_POST['indx']);
   $edit_id = intval($_POST['ths']);
    $sql =  "SELECT * FROM `userevent` WHERE id = ?";
       $data=$this->dbF->getRow($sql,array($edit_id));
        $title    = $this->functions->eventTitle($data['title_id']);
     $arr1 =    explode(',',$data['file']);
    // echo "<pre>";
    //  echo print_r($arr1);
    // echo "</pre>";
     // remove item at index 1 which is 'for' 
    // echo "<pre>";
     // echo   $arr1[$index];
    // echo "</pre>";
   //remove item at index 1 which is 'for' 

 // ========================TrashData=======================================================
  $ds ="(Title Name : ".$title." )(user : ".$data['user']." )(assign to : ".$data['assignto']." ) ";
  $this->functions->TrashData('Activity Calendar',$ds,$arr1[$index],$user,$data['user'],'userevent',$edit_id,'Event File Delete');
         // ========================TrashData=======================================================
          
  unset($arr1[$index]);  
//echo "Print modified array"; 
 //echo "<br>"; 
//print_r($arr1); 
//echo "<br>";
//echo "Print Count";
$arr2 = array_values($arr1); 
//$count  = count($arr2);
   
   $imploded = implode(',', $arr2);
  // print_r($imploded); 
     
 if($imploded == ""){
   $imploded ='#';
 } 
    $sql = "UPDATE `userevent` SET file = '$imploded' WHERE id = '$edit_id'";
        $this->dbF->setRow($sql);
        if($this->dbF->rowCount > 0){
            echo '1';
        }

    
}

 public function deleteisholiday(){
   $id =  intval($_POST['itemId']);
    $sql = "DELETE FROM `isholiday` WHERE `id`='$id'";
        $this->dbF->setRow($sql);
        if($this->dbF->rowCount > 0){
            echo '1';

           }

  } 

 public function deleteCertificate(){
   $id =  intval($_POST['itemId']);
    $sql = "DELETE FROM `assigned_paper` WHERE `assign_id`='$id'";
        $this->dbF->setRow($sql);
        if($this->dbF->rowCount > 0){
            echo '1';
           }

  } 
  
  
     public function delete_delegate_cpd_course(){
   $id =  intval($_POST['itemId']);
    
     $sql2="SELECT * FROM `delegate_cpd_course` WHERE `id`= ? ";
        $data2=$this->dbF->getRow($sql2,array($id));

    $sql = "DELETE FROM `delegate_cpd_course` WHERE `id`= ? ";
        $this->dbF->setRow($sql,array($id));
        if($this->dbF->rowCount > 0){
            echo '1';
            }
     $this->functions->setlog("Delegate Course  Delete",$this->functions->UserName($data2['delegate_user'])." : ".$data2['delegate_user'],"Practice Name is",$this->functions->UserName($data2['delegate_user']));
      }
    
    
    
      public function deleteleave(){
   $id =  intval($_POST['itemId']);
     $sql2="SELECT * FROM `leaves` WHERE `id`= ? ";
        $data2=$this->dbF->getRow($sql2,array($id));
    
    $sql = "DELETE FROM `leaves` WHERE `id`= ? ";
        $this->dbF->setRow($sql,array($id));
        if($this->dbF->rowCount > 0){
            echo '1';
            }
     $this->functions->setlog("Leave Delete",$this->functions->UserName($data2['fill_user'])." : ".$data2['fill_user'],"Practice Name is",$this->functions->UserName($data2['user']));
      }



      

  public function customProAdded(){
        
         
  // $this->dbF->prnt($_POST);
  // $this->dbF->prnt($_FILES);

            $slug     = empty($_POST['slug'])    ? ""    : $_POST['slug'];
            $arr     = empty($_POST['arr'])    ? ""  : $_POST['arr'];
            $p_status     = empty($_POST['p_status'])    ? ""    : $_POST['p_status'];
            $size     = empty($_POST['size'])    ? "0"    : $_POST['size'];
            $color     = empty($_POST['color'])    ? "0"    : $_POST['color'];
            $p_code     = empty($_POST['p_code'])    ? ""    : $_POST['p_code'];
            $pName     = empty($_POST['pName'])    ? ""    : $_POST['pName'];

            $img    = empty($_FILES['file']['name'])   ? false      : true;



if($p_status != "1"){

  $p_status     = 0;
}

if($img){


     $dataAll =  $this->functions->uploadSingleImage($_FILES['file'],'ajax/products/','','all');
}else{

 $dataAll = "";

}

           



            $user = $_SESSION['currentUser'];
            


            if($p_status == 1){

$p_code = "";

            }
            try{
                $this->db->beginTransaction();
                $sql      =   "INSERT INTO `proudct_detail`(`slug`,`prodet_name`,`p_status`,`product_update`,`prac_id`,`p_code`) VALUES ('$slug','$pName','$p_status','1',$user,'$p_code')";
                $this->dbF->setRow($sql);
                $lastId = $this->dbF->rowLastId;
                $this->functions->setlog("Custom Product Insert By",$this->functions->UserName($user)." : ".$user);
                $this->db->commit();
                if($this->dbF->rowCount>0){




  $sql2      =   "INSERT INTO `product_setting`(`setting_name`,`setting_val`,`p_id`) VALUES ('publicAccess','0','$lastId')";
                $this->dbF->setRow($sql2);

  $sql12      =   "INSERT INTO `product_setting`(`setting_name`,`setting_val`,`p_id`) VALUES ('launchDate','','$lastId')";
                $this->dbF->setRow($sql12);



$c = $arr.",";
// for ($i=0; $i <count($arr); $i++) { 

// $c .= $arr.",";


// }

$sql1234      =   "INSERT INTO `product_category`(`procat_prodet_id`,`procat_cat_id`) VALUES ('$lastId','$c')";
$this->dbF->setRow($sql1234);


if($dataAll){


    

  $sql123      =   "INSERT INTO `product_image`(`product_id`,`image`) VALUES ('$lastId','$dataAll')";
                $this->dbF->setRow($sql123);



}else{




}





    $sql3="SELECT * FROM scales WHERE scale_id= ? ";
        $data=$this->dbF->getRow($sql3,array($size));





  $sql2a      =   "INSERT INTO `product_size`(`prosiz_name`,`prosiz_prodet_id`,`prosiz_cur_id`,`prosiz_price`,`sizeGroup`) VALUES ('$data[scale_name]','$lastId','20','0','$data[scale_name_id]')";
                $this->dbF->setRow($sql2a);

$sid = $this->dbF->rowLastId;
$sname = $data['scale_name'];


    $sql3a="SELECT * FROM colors WHERE  color_id= ?";
        $data1=$this->dbF->getRow($sql3a,array($color));




  $sql12a      =   "INSERT INTO `product_color`(`proclr_name`,`color_name`,`proclr_prodet_id`,`proclr_cur_id`,`proclr_price`,`sizeGroup`) VALUES ('$data1[color_name]','$data1[color_name]','$lastId','20','0','$data1[color_name_id]')";
                $this->dbF->setRow($sql12a);



$cid = $this->dbF->rowLastId;

$cname = $data1['color_name'];

if(empty($color)){

$cid="";
$cname="";

}
if(empty($size)){

$sid="";
$sname="";


}





$arrayAll=array($lastId,$pName,$sid,$sname,$cid,$cname,$user,$p_status,$p_code);

  // $this->dbF->prnt($arrayAll);
echo json_encode($arrayAll);



                }else{
                    return false;
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                return false;
            }
    }
public function copyEvents()
{  
$edit_id = intval($_POST['value']);
if (!empty($_POST['value'])) {
$user = intval($_SESSION['currentUser']);




$q = "SELECT * FROM `eventmanagement` WHERE `id` = ? ";
 $dD =  $this->dbF->getRow($q,array($edit_id));




  $sql    =   "INSERT INTO myevents(`title`,`due_date`,`recurring_duration`,`recurrence`,`assignto`,`category`,`status`,`desc`,`user`,`file`) VALUES (?,?,?,?,?,?,?,?,?,?)";
$this->dbF->setRow($sql,array($dD['title'], $dD['due_date'], $dD['recurring_duration'], $dD['recurrence'], $dD['assignto'], $dD['category'], "pending", $dD['desc'], $user,'#'));





  $customId = $this->dbF->rowLastId;

$sqlCheck = "SELECT * FROM `eventForms` WHERE `title_id` = ? ";
 $eventFormsData =  $this->dbF->getRows($sqlCheck,array($edit_id));


foreach ($eventFormsData as $key => $value) {
 


      $sqlC = "INSERT INTO `myeventform` SET
                                `title_id`     =?,
                                `question` =?,
                                `category` =?,
                                `radio` =?, 
                                `date`  =?,
                                `time`=?,
                                `field1`    =?,
                                `field2`    =?,
                                `publish`    =?";

      

            $array = array($customId, $value['question'], $value['category'], $value['radio'],
                $value['date'], $value['time'], $value['field1'],$value['field2'],$value['publish']);


            $this->dbF->setRow($sqlC, $array);




}




echo $customId;
}

}

public function chkDuplicateEmail()
{  
$chkDuplicateEmail = $_POST['chkDuplicateEmail'];






$q = "SELECT * FROM `accounts_user` WHERE `acc_email` = ? ";
$dD =  $this->dbF->getRow($q,array($chkDuplicateEmail));



if($this->dbF->rowCount>0){
                    echo '1';
                }else{
                      echo '0';
                }


}

     public function isholiday(){
        
            $date = empty($_POST['date']) ? date('Y-m-d') : date('Y-m-d',strtotime($_POST['date']));
            $reson     = empty($_POST['reason'])    ? ""    : $_POST['reason'];
            $comment     = empty($_POST['comment'])    ? ""    : $_POST['comment'];
            $user = $_SESSION['currentUser'];
            
            try{
                $this->db->beginTransaction();
                $sql      =   "INSERT INTO `isholiday`(`user`,`date`,`reason`,`comment`) VALUES ('$user','$date','$reson','$comment')";
                $this->dbF->setRow($sql);
                
                $this->functions->setlog("Weekend Insert By",$this->functions->UserName($user)." : ".$user);
                $this->db->commit();
                if($this->dbF->rowCount>0){
                    echo '1';
                }else{
                    return false;
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                return false;
            }
    }






 public function deleteAjaxFormId(){
       $ths =  intval($_POST['id']);

    



    $sql = "DELETE FROM `myeventform` WHERE `id`='$ths'";
    $this->dbF->setRow($sql);

        if($this->dbF->rowCount > 0){
            echo '1';
           }
          
    }
 public function deletepost(){
       $id =  intval($_POST['itemId']);

    $sql3="SELECT image FROM post WHERE id= ? ";
        $data=$this->dbF->getRows($sql3,array($id));
        foreach($data as $key=>$val){
            $this->functions->deleteOldSingleImage($val['image']);

        }
   $sql = "DELETE FROM `post` WHERE `id`='$id'";
    $this->dbF->setRow($sql); 
    $sql = "DELETE FROM `comments` WHERE `postid`='$id'";
    $this->dbF->setRow($sql);

        if($this->dbF->rowCount > 0){
            echo '1';
           }
          
    }
      public function post_comment_insert(){
        
            $date = date('Y-m-d');
            $postid     = empty($_POST['reason'])    ? ""    : $_POST['reason'];
            $comment     = empty($_POST['comment'])    ? ""    : $_POST['comment'];
            $user     = empty($_POST['user'])    ? ""    : $_POST['user'];
            
            
            // try{
            //     $this->db->beginTransaction();
            //     $sql      =   "INSERT INTO `comment`(`comment`,`user`,`postid`) VALUES ('$comment','$user','$postid')";
            //     $this->dbF->setRow($sql);
                
            //     $this->functions->setlog("Weekend Insert By",$this->functions->UserName($user)." : ".$user);
            //     $this->db->commit();
            //     if($this->dbF->rowCount>0){
            //         echo '1';
            //     }else{
            //         return false;
            //     }
            // }catch (Exception $e){
            //     $this->db->rollBack();
            //     $this->dbF->error_submit($e);
            //     return false;
            // }
    }
    public function deleteShift(){
        $id = intval($_POST['id']);
        $sql = "DELETE FROM `shift` WHERE `id`='$id'";
        $this->dbF->setRow($sql);
        if($_SESSION['currentUserType'] == 'Employee'){$user=$_SESSION['webUser']['id'];}else{$user = $_SESSION['currentUser'];}
        $this->functions->setlog("Shift Delete",$this->functions->UserName($user)." : ".$user,"",$id);
        if($this->dbF->rowCount > 0){
            echo '1';
        }
    }

    public function deletePDP(){
        $id = intval($_POST['id']);
        $sql = "DELETE FROM `cpd_pdp` WHERE `id`='$id'";
        if($_SESSION['currentUserType'] == 'Employee'){$user=$_SESSION['webUser']['id'];}else{$user = $_SESSION['currentUser'];}
        $this->functions->setlog("PDP Delete",$this->functions->UserName($user)." : ".$user,"",$id);
        $this->dbF->setRow($sql);
        if($this->dbF->rowCount > 0){
            echo '1';
        }
    }

    public function rotaStatus(){
        $id = intval($_POST['id']);
        $sql = "UPDATE `rotaStatus` SET `status`='Confirm' WHERE `id`='$id'";
        $this->dbF->setRow($sql);
        if($this->dbF->rowCount > 0){
            echo '1';
        }
    }

    public function deleteDoc(){
        $id = $_POST['id'];
        $url = $_POST['url'];
        $path = parse_url($url,PHP_URL_PATH);
        $file = $_SERVER['DOCUMENT_ROOT'].$path;
        $new = "https://drive.google.com/uc?id=".$id."&export=download";
        if (copy($new, $file)){
            $url = "https://script.google.com/macros/s/AKfycbyuk1OhMBi_6g4HeCJ8XAnJMVPGItUgTlCAEw7sVQPohEVLYIaa/exec?id=".$id;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl,CURLOPT_FOLLOWLOCATION, true);
            $response = curl_exec($curl);
            curl_close($curl);
            $url = "https://script.google.com/macros/s/AKfycbx24aAS9lcRmRi1XG3iYP4eBtJDt_ec3MUKCBpthg/exec";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl,CURLOPT_FOLLOWLOCATION, true);
            $response = curl_exec($curl);
            curl_close($curl);
            echo "1";
        }else{
            echo "Copy failed.";
        }
    }
    
    public function deleteReminder(){

        $id = intval($_POST['id']);
        $sql2="DELETE FROM `practiceaddreminder` WHERE `id`= '$id'";
        $this->dbF->setRow($sql2);

    }
    public function manageUser(){
        if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){
                    $user = $_SESSION['superid'];
                    $sql = "SELECT * FROM `accounts_user` WHERE `acc_id`= ? and acc_type=1";
                    $data = $this->dbF->getRows($sql,array($user));
                }
                else{
                    $user = $_SESSION['currentUser'];
                    $sql = "SELECT * FROM `accounts_user` WHERE  acc_type=1 and (`acc_id`='$user' OR `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under'))  ORDER BY `acc_type` DESC, `acc_name` ASC ";
                    $data = $this->dbF->getRows($sql);
                }

                foreach ($data as $key => $value) {
                $deactive = "";
                $userid = $value['acc_id'];
                $name  = $value['acc_name'];
                $image = $value['acc_image'];
              
                // if($value['acc_type'] == '0'){
                //     $deactive = "<div class='deactive'>DeActive</div>";
                //      $role = '';
                // }else{
                $data2 =  $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `id_user`='$userid' AND `setting_name`='role'");
                $role = $data2[0];

                // }
               

                 $image = $value['acc_image'];
               
                 $iamge2 = "logo.png";
                  if ($image == "#"||trim($image) == "" ) 
                {
                     @$image = @$image2;
                    @$image = "webImages/d-profile.png";
                 }
                 else
                 {
                     
                    $image = $this->functions->resizeImage($value['acc_image'], 'auto',400, false);
                    
                 
                     
                 }




if($_SESSION['currentUserType'] == 'Employee'){
$pid = $this->functions->PracticeId($_SESSION['superid']);
}
else{
$pid = $_SESSION['currentUser'];
}




             echo "<div class='user-box'>";
             // if ($_SESSION['currentUserType'] == 'Practice'){}
             
     if($value['acc_type'] == '0'){   $echoA =  $percent = "N/A";}else{  
     $echo =  $this->functions->countTTLDoneStaffDocumentsWOcat($value['acc_id'],$pid); 
     $percent = $echo[1]/$echo[0]; if(is_int($percent) || is_float($percent)) $echoA= number_format( $percent * 100); else $echoA= "0";
     }

// echo $echo[0];  echo "<br>";  echo $echo[1];
                     
           echo "<a href='#'  id='$userid' onclick='sendmailrecovery(this.id)'  style=' color:#f2701d;position: absolute;left: 10px;top: 10px;' data-toggle='tooltip' title='Welcome Email' ><i class='fas fa-paper-plane'></i></a>



<a href='#'  id='$userid' onclick='sendmailrecovery(this.id)'  style=' color:#f2701d;left: 10px;top: 10px;' data-toggle='tooltip' title='Total: ".$echo[0]." , Complete: ".$echo[1]."'>$echoA %</a>




        <a href='profile?page=Edit Profile&userId=$value[acc_id]' style='color:#f2701d;position: absolute;right: 10px;top: 10px;'><i class='fas fa-edit' data-toggle='tooltip' title='Edit Profile'></i></a>
                        $deactive

                        <img src='$image' alt=''>
                        <h5>$name</h5>
                        <h6>$role</h6>
                        <button type='button' onclick='folder(this.id)'   id='$userid'>Details</button>
                      

                    <!-----<a href='profile-detail?user=$userid' >Details</a>----->

                    </div>";





                }
                
    }
}

productAjaxCallEndOfThisPage();
?>