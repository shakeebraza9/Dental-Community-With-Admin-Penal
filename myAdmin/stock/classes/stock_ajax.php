<?php

if(!isset($_POST['loadFromWeb'])) {
    require_once(__DIR__ . "/../../global_ajax.php"); //connection setting db
}else{
    require_once(__DIR__ . "/../../../global.php"); //connection setting db
}


class stock_ajax extends object_class{
    public $productF;

    public function  __construct()
    {
        parent::__construct('3');
        if (isset($GLOBALS['productF'])) $this->productF = $GLOBALS['productF'];
        else {
            require_once(__DIR__."/../../product_management/functions/product_function.php");
            $this->productF=new product_function();
        }

        /**
         * MultiLanguage keys Use where echo;
         * define this class words and where this class will call
         * and define words of file where this class will called
         **/
        global $_e;
        global $adminPanelLanguage;
        $_w=array();
        $_w['Some Thing Is Wrong Please Try Again.'] = '' ;
        $_w['SNO'] = '' ;
        $_w['Product Stock Location Update'] = '' ;
        $_w['PRODUCT'] = '' ;
        $_w['PURCHASE PRICE'] = '' ;
        $_w['PURCHASE QTY'] = '' ;
        $_w['Product Add QTY {{qty}}'] = '' ;
        $_w['Product Add'] = '' ;
        $_w['Product QTY'] = '' ;
        $_w['Product Deduct QTY {{qty}}'] = '' ;
        $_w['Product Deduct'] = '' ;
        $_w['Product QTY From Stock'] = '' ;
        $_w['WAREHOUSE'] = '' ;
        $_w['NEW CONDITION'] = '' ;
        $_w['SOURCE WAREHOUSE'] = '' ;
        $_w['QTY'] = '' ;
        $_w['DESTINATION WAREHOUSE'] = '' ;
        $_w['STORE NAME'] = '' ;
        $_w['QUANTITY'] = '' ;



        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin StockAjax');

    }

///mycodde
     public function getdetails(){
        $pId =$_REQUEST['pId'];
        $storeId =$_REQUEST['storeId'];
        $sql = "SELECT qty_item FROM `product_inventory` WHERE qty_product_id='$pId' AND qty_store_id='$storeId'";
        $data=$this->dbF->getRow($sql);
        $qty = $data[0];
        $sql2 = "SELECT setting_val FROM `product_setting` WHERE setting_name='condition' AND p_id='$pId'";
        $data2=$this->dbF->getRow($sql2);
        $condition = $data2[0];
        $arry = array("qty" => $qty , "condition" => $condition);
        echo json_encode($arry);
    }
public function getstorename_grn($id){
        $sql  =   "SELECT * FROM `product_size_weight` WHERE `pwPId`='$id'";
        $data   =   $this->dbF->getRows($sql);
        $op='<option>Select Store</option>';
            foreach($data as $val){
                
                    $sql  =   "SELECT * FROM `store_name` WHERE `store_name`='$val[pw_size]'";
                    $vl   =   $this->dbF->getRow($sql); 
                    $op .="<option value='$vl[store_pk]'>$val[pw_size] - $vl[store_location]&nbsp;($val[pw_weight])</option>";
                    
            }
            echo $op;
    }

    public function getstorename($id){
        $data = $this->receiptStoreSQL("`store_pk`,`store_name`,`store_location`");
        $op='<option>Select Store</option>';
            foreach($data as $val){
                $sql  =   "SELECT sum(qty_item) FROM `product_inventory` WHERE qty_store_id=$val[store_pk] AND `qty_product_id`='$id'";
                $cont   =   $this->dbF->getRow($sql); 
                if (empty($cont[0])) {
                    continue;
                }
                else{
                    $op .="<option value='$val[store_pk]'>$val[store_name] - $val[store_location]&nbsp;($cont[0])</option>";
                    }
            }
            echo $op;
    }
 public function receiptStoreSQL($column){
        $sql="SELECT ".$column." FROM `store_name` ORDER BY `store_pk` ASC";
        return $this->dbF->getRows($sql);
    }

    ///mycoddeEnd
     public function receiptDetailGTN()
    {
        global $_e;
        if(isset($_POST['itemId'])){
        $id = $_POST['itemId'];
        }else{
            echo _uc($_e['Some Thing Is Wrong Please Try Again.']);
            exit;
        }
        $sql = "SELECT * FROM  `purchase_receipt_gtn`,`purchase_receipt_pro_gtn`
                    WHERE `purchase_receipt_pro_gtn`.`receipt_id`='$id'
                            AND  `purchase_receipt_gtn`.`receipt_pk` ='$id'";
        $data=$this->dbF->getRows($sql);

      echo '<div class="table-responsive">
                <table class="table table-hover dTable tableIBMS mydt">
                    <thead>
                    <!--<th>'. _u($_e['SNO']) .'</th>-->
                    <th>'. _u($_e['PRODUCT']) .'</th>
                    <th>'. _u($_e['SOURCE WAREHOUSE']) .'</th>
                    <th>'. _u($_e['DESTINATION WAREHOUSE']) .'</th>
                    <th>'. _u($_e['QTY']) .'</th>
                    </thead>
                <tbody>';


        $i=0;
        foreach($data as $val){
            $i++;
            $pName= $this->productF->getProductFullName($val['receipt_product_id'],$val['receipt_product_scale'],$val['receipt_product_color']);
            $pStoreName= $this->productF->getProductStoreName($val['receipt_product_color']);
            $pStoreName2= $this->productF->getProductStoreName($val['receipt_product_scale']);
                    echo "<tr>
                        <!--<td>$i</td>-->
                        <td>$pName</td>
                        <td>$pStoreName</td>
                        <td>$pStoreName2</td>
                        <td>$val[receipt_qty]</td>
                    </tr>";
        }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo '<script>setTimeout(function(){ $(".mydt").DataTable(); }, 0);</script>';
    }

    public function receiptDetailDN()
    {
        global $_e;
        if(isset($_POST['itemId'])){
        $id = $_POST['itemId'];
        }else{
            echo _uc($_e['Some Thing Is Wrong Please Try Again.']);
            exit;
        }
        $sql = "SELECT * FROM  `purchase_receipt_dn`,`purchase_receipt_pro_dn`
                    WHERE `purchase_receipt_pro_dn`.`receipt_id`='$id'
                            AND  `purchase_receipt_dn`.`receipt_pk` ='$id'";
        $data=$this->dbF->getRows($sql);

      echo '<div class="table-responsive">
                <table class="table table-hover dTable tableIBMS mydt">
                    <thead>
                    <!--<th>'. _u($_e['SNO']) .'</th>-->
                    <th>'. _u($_e['PRODUCT']) .'</th>
                    <th>'. _u($_e['WAREHOUSE']) .'</th>
                    <th>'. _u($_e['QUANTITY']) .'</th>
                    </thead>
                <tbody>';
        $i=0;
        foreach($data as $val){
            $i++;
            $pName= $this->productF->getProductFullName($val['receipt_product_id'],$val['receipt_product_scale'],$val['receipt_product_color']);
            $pStoreName= $this->productF->getProductStoreName($val['receipt_product_color']);
                    echo "<tr>
                        <!--<td>$i</td>-->
                        <td>$pName</td>
                        <td>$pStoreName</td>
                        <td>$val[receipt_qty]</td>
                    </tr>";
        }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo '<script>setTimeout(function(){ $(".mydt").DataTable(); }, 0);</script>';
    }
    
    public function receiptDetailIAN()
    {
        global $_e;
        if(isset($_POST['itemId'])){
        $id = $_POST['itemId'];
        }else{
            echo _uc($_e['Some Thing Is Wrong Please Try Again.']);
            exit;
        }
        $sql = "SELECT * FROM  `purchase_receipt_ian`,`purchase_receipt_pro_ian`
                    WHERE `purchase_receipt_pro_ian`.`receipt_id`='$id'
                            AND  `purchase_receipt_ian`.`receipt_pk` ='$id'";
        $data=$this->dbF->getRows($sql);

      echo '<div class="table-responsive">
                <table class="table table-hover dTable tableIBMS mydt">
                    <thead>
                    <!--<th>'. _u($_e['SNO']) .'</th>-->
                    <th>'. _u($_e['PRODUCT']) .'</th>
                    <th>'. _u($_e['WAREHOUSE']) .'</th>
                    <th>EXISTING QUANTITY</th>
                    <th>NEW QUANTITY</th>
                    <th>EXISTING CONDITION</th>
                    <th>'. _u($_e['NEW CONDITION']) .'</th>
                    </thead>
                <tbody>';
        $i=0;
        foreach($data as $val){
            $i++;
            $pName= $this->productF->getProductName($val['receipt_product_id']);
            $pStoreName= $this->productF->getProductStoreName($val['receipt_product_store']);
                    echo "<tr>
                        <!--<td>$i</td>-->
                        <td>$pName</td>
                        <td>$pStoreName</td>
                        <td>$val[receipt_product_eqty]</td>
                        <td>$val[receipt_product_nqty]</td>
                        <td>$val[receipt_product_ec]</td>
                        <td>$val[receipt_product_nc]</td>
                    </tr>";
        }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo '<script>setTimeout(function(){ $(".mydt").DataTable(); }, 0);</script>';
    }
    public function receiptInfo()
    {
        global $_e;
        if(isset($_POST['itemId'])){
        $id = $_POST['itemId'];
        }else{
            echo _uc($_e['Some Thing Is Wrong Please Try Again.']);
            exit;
        }
        $sql = "SELECT * FROM  `purchase_receipt` WHERE `receipt_pk` IN (SELECT `receipt_id` FROM `purchase_receipt_pro` WHERE `receipt_product_id`='$id')";
        $data=$this->dbF->getRows($sql);
      echo '<div class="table-responsive">
                <table class="table table-hover dTable tableIBMS mydt">
                    <thead>
                    <!--<th>'. _u($_e['SNO']) .'</th>-->
                    <th>'. _u($_e['SUPPLIER']) .'</th>
                    <th>'. _u($_e['RECEIVER']) .'</th>
                    <th>'. _u($_e['DELIVERY DATE']) .'</th>
                    </thead>
                <tbody>';


        $i=0;
        foreach($data as $val){
            $i++;
                    echo "<tr>
                        <!--<td>$i</td>-->
                        <td>$val[supplier]</td>
                        <td>$val[receiver]</td>
                        <td>$val[receipt_date]</td>
                    </tr>";
        }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo '<script>setTimeout(function(){ $(".mydt").DataTable(); }, 0);</script>';
    }
    //mycode

    public function InventoryInfo()
    {

        global $_e;
        if(isset($_POST['itemId'])){
        $pid = $_POST['itemId'];
        }else{
            echo _uc($_e['Some Thing Is Wrong Please Try Again.']);
            exit;
        }
        $sql = "SELECT * FROM  product_inventory WHERE `qty_pk`='$pid'";
        $data=$this->dbF->getRows($sql);

      echo '<div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                 <th>' . _u($_e['SNO']) . '</th>
                        <th>Expiry Date</th> 
                        <th>' . _u($_e['PRODUCT']) . '</th>
                        <th>Location</th>
                        <th>' . _u($_e['QUANTITY']) . '</th>                      
                        <th>Min Stock Notify</th>
                        <th> LAST UPDATE </th>
                        <th class="qtyAddTDLast">User</th>               
                        
                    </thead>
                <tbody>';


        $i=0;
        foreach($data as $val){
            $i++;


                $qty_pk = $val['qty_pk'];
            $qty_store_id = $val['qty_store_id'];
            $qty_product_id = $val['qty_product_id'];
            $qty_product_scale = $val['qty_product_scale'];
            $qty_product_color = $val['qty_product_color'];
            $qty_item = $val['qty_item'];
            $location = $val['location'];
            $min_stock = $val['min_stock'];
            $expiryDate = $val['expiryDate'];
            $product_store_hash = $val['product_store_hash'];
            $updateTime = $val['updateTime'];


          $pName = $this->productF->getProductFullNameSTOCK($qty_product_id, $qty_product_scale, $qty_product_color);
  $qty = $val['qty_item'];
            if ($qty == '0') {
                $qty0 = 'style="background-color:#E64444;color:#fff;"';
                $count0Qty++;
            } else {
                $qty0 = '';
            }
            $sql = "SELECT acc_name FROM accounts_user WHERE  acc_id='$qty_store_id'";
            $data = $this->dbF->getRow($sql);
            $qty_store_id = $data[0];
                    echo "<tr>
                        <td>$i</td>
             <td>$expiryDate</td> 
                    <td>$pName</td>
                    <td>$location</td>
                    <td  class='currentQTY'>$qty_item</td>
                


                    <td>$min_stock</td>
                    <td>$updateTime</td>
                    <td>$qty_store_id</td>
                     
                   
                    
                    </tr>";
        }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    

    }
       public function receiptDetail()
    {
        global $_e;
        if(isset($_POST['itemId'])){
        $id = $_POST['itemId'];
        }else{
            echo _uc($_e['Some Thing Is Wrong Please Try Again.']);
            exit;
        }
        $sql = "SELECT * FROM  `purchase_receipt`,`purchase_receipt_pro`
                    WHERE `purchase_receipt_pro`.`receipt_id`='$id'
                            AND  `purchase_receipt`.`receipt_pk` ='$id' ";
        $data=$this->dbF->getRows($sql);

      echo '<div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                    <th>'. _u($_e['SNO']) .'</th>
                    <th>'. _u($_e['PRODUCT']) .'</th>
                    <th>'. _u($_e['PURCHASE PRICE']) .'</th>
                    <th>'. _u($_e['PURCHASE QTY']) .'</th>
                    </thead>
                <tbody>';


        $i=0;
        foreach($data as $val){
            $i++;
            $pName= $this->productF->getProductFullNameSTOCK($val['receipt_product_id'],$val['receipt_product_scale'],$val['receipt_product_color']);
                    echo "<tr>
                        <td>$i</td>
                        <td>$pName</td>
                        <td>$val[receipt_price]</td>
                        <td>$val[receipt_qty]</td>
                    </tr>";
        }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    }

    public  function countCurrentQTY(){
        $pId=$_POST['pId'];
        $storeID=$_POST['storeID'];
        $scaleId=$_POST['scaleId'];
        $colorId=$_POST['colorId'];
        $exact = false;//call from admin stock inventory
        if(isset($_POST['loadFromWeb'])){
            $exact = true; // call from website
        }

        $qty = $this->productF->productQTY($pId,$storeID,$scaleId,$colorId,$exact);
        if($qty < 1) {
            // echo "0";
            // return false;
        }

        $location_ = $this->productF->productLocation($pId,$storeID,$scaleId,$colorId,$exact);
        echo json_encode(array("qty"=>$qty,"location_"=>$location_));
    }

    public  function directQTYAdd(){
        global $_e;
        $pId=$_POST['pId'];
        $storeID=$_POST['storeID'];
        $scaleId=$_POST['scaleId'];
        $colorId=$_POST['colorId'];
        $pqty =intval($_POST['pqty']);

        @$hashVal=$pId.":".$scaleId.":".$colorId.":".$storeID;
        $hash = md5($hashVal);

        $sqlCheck="SELECT `product_store_hash` FROM `product_inventory` WHERE `product_store_hash` = '$hash'";
        $this->dbF->getRow($sqlCheck);
        if($this->dbF->rowCount>0){
            $date =date('Y-m-d H:i:s'); //2014-09-24 13:46:10
            $sql= "UPDATE `product_inventory` SET `qty_item` = qty_item+$pqty , `updateTime` = '$date' WHERE `product_store_hash` = '$hash'";
            $this->dbF->setRow($sql);
        }else{
            $sql = "INSERT INTO `product_inventory`(
                                            `qty_store_id`,
                                            `qty_product_id`,
                                            `qty_product_scale`,
                                            `qty_product_color`,
                                            `qty_item`,
                                            `product_store_hash`
                                        ) VALUES (?,?,?,?,?,?) ";
            $arry=array($storeID,$pId,$scaleId,$colorId,$pqty,$hash);
            $this->dbF->setRow($sql,$arry);

        }
        if($this->dbF->rowCount>0){
            echo '1';
            $desc= _replace('{{qty}}',$pqty,$_e['Product Add QTY {{qty}}']);
            $this->functions->setlog(_uc($_e['Product Add']),_uc($_e['Product QTY']),$pId,$desc);
        }else{
            echo '0';
        }

    }


    public  function directQTYRemove(){
        global $_e;
        $pId=$_POST['pId'];
        $storeID=$_POST['storeID'];
        $scaleId=$_POST['scaleId'];
        $colorId=$_POST['colorId'];
        $pqty =$_POST['pqty'];

        @$hashVal=$pId.":".$scaleId.":".$colorId.":".$storeID;
        $hash = md5($hashVal);

        $sqlCheck="SELECT `product_store_hash`,`qty_item` FROM `product_inventory` WHERE `product_store_hash` = '$hash'";
        $data=$this->dbF->getRow($sqlCheck);
        if($this->dbF->rowCount>0){
            $oldQty=$data['qty_item'];
            if($oldQty<$pqty){
                echo '0';
                exit;
            }
            $date =date('Y-m-d H:i:s'); //2014-09-24 13:46:10
            $sql= "UPDATE `product_inventory` SET `qty_item` = qty_item-$pqty , `updateTime` = '$date' WHERE `product_store_hash` = '$hash'";
            $this->dbF->setRow($sql);

            if($this->dbF->rowCount>0) {
                $desc = _replace('{{qty}}', $pqty, $_e['Product Deduct QTY {{qty}}']);
                $this->functions->setlog(_uc($_e['Product Deduct']), _uc($_e['Product QTY']), $pId, $desc);
                echo '1';
            }else{
                echo "0";
            }

        }
        else{
            echo '0';
        }

    }


    public function directStockQTYAdd(){
        global $_e;
        $id     =   $_POST['id'];
        $pqty   =   intval($_POST['pqty']);

        $sql    =   "UPDATE product_inventory SET qty_item = qty_item+$pqty WHERE qty_pk = '$id'";
        $this->dbF->setRow($sql);
        if($this->dbF->rowCount>0){
            echo '1';
            $desc= _replace('{{qty}}',$pqty,$_e['Product Add QTY {{qty}}']);
            $this->functions->setlog(_uc($_e['Product Add']),_uc($_e['Product QTY From Stock']),$id,$desc);
        }else{
            echo '0';
        }
    }

    public function directStockQTYRemove(){
        global $_e;
        $id     =   $_POST['id'];
        $pqty   =   intval($_POST['pqty']);

        $sql    =   "SELECT qty_item FROM  product_inventory WHERE qty_pk = '$id'";
        $data   =   $this->dbF->getRow($sql);
        $oldQty =   $data['qty_item'];
        if($oldQty<$pqty){
            echo '0';
            exit;
        }

        $sql    =   "UPDATE product_inventory SET qty_item = qty_item-$pqty  WHERE qty_pk = '$id'";
        $this->dbF->setRow($sql);
        if($this->dbF->rowCount>0){
            echo '1';
            $desc = _replace('{{qty}}', $pqty, $_e['Product Deduct QTY {{qty}}']);
            $this->functions->setlog(_uc($_e['Product Deduct']), _uc($_e['Product QTY From Stock']), $id, $desc);
        }else{
            echo '0';
        }
    }

    public function directStockLocationAdd(){
        global $_e;
        $id         =   $_POST['id'];
        $location   =   $_POST['location'];

        $sql    =   "UPDATE product_inventory SET location = ?  WHERE qty_pk = '$id'";
        $this->dbF->setRow($sql,array($location));
        if($this->dbF->rowCount>0){
            echo '1';
            $desc = $_e['Product Stock Location Update'];
            $this->functions->setlog(_uc($_e['Product Deduct']), _uc($_e['Product Stock Location Update']), $id, "$desc <br> Product : $id");
        }else{
            echo '0';
        }
    }

}
?>