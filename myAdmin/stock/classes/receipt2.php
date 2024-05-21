<?php
require_once(__DIR__."/../../product_management/functions/product_function.php");

class purchase_receipt2 extends object_class{
    public $product;
    public $productF;

    public function __construct(){
        parent::__construct('3');
        $this->product=new product_function();

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
        //purchasereceipt.php
        $_w['View All Goods Transfer Note'] = '' ;
        $_w['Goods Transfer Note'] = '' ;
        $_w['Goods Transfer Note View'] = '' ;
        $_w['Add New Goods Transfer Note'] = '' ;

        //This class
        $_w['SNO'] = '' ;
        $_w['VENDOR'] = '' ;
        $_w['STORE NAME'] = '' ;
        $_w['TRANSFER DATE'] = '' ;
        $_w['REGISTER DATE'] = '' ;
        $_w['ACTION'] = '' ;
        $_w['Vendor Name'] = '' ;
        $_w['Transfer Date'] = '' ;
        $_w['Date'] = '' ;
        $_w['Select Store'] = '' ;
        $_w['Add In store'] = '' ;
        $_w['SINGLE PRICE'] = '' ;
        $_w['QTY'] = '' ;
        $_w['PRODUCT COLOR'] = '' ;
        $_w['PRODUCT SCALE'] = '' ;
        $_w['No Scale Avaiable'] = '' ;
        $_w['No Color Avaiable'] = '' ;
        $_w['Enter Product Color'] = '' ;
        $_w['Enter Product Scale'] = '' ;
        $_w['Enter Product Name'] = '' ;
        $_w['Enter Single Product Price'] = '' ;
        $_w['Enter Product Quantity'] = '' ;
        $_w['Add Product'] = '' ;
        $_w['Remove Checked Items'] = '' ;
        $_w['Check/Uncheck All'] = '' ;
        $_w['PRODUCT'] = '' ;
        $_w['PRICE'] = '' ;
        $_w['Generate Goods Transfer Note'] = '' ;
        $_w['Sender'] = '' ;
        $_w['Select Sender'] = '' ;
        $_w['Delivery By'] = '' ;
        $_w['Select Delivery By'] = '' ;
        $_w['PRICE'] = '' ;
        $_w['Prodcut Quantity Add in {{n}} different products'] = '' ;
        $_w['New Receipt'] = '' ;
        $_w['Receipt'] = '' ;
        $_w['New Receipt Generate Successfully'] = '' ;
        $_w['New Receipt Generate Failed'] = '' ;
        $_w['Note'] = '' ;
        $_w['PO Number'] = '' ;
        $_w['Note'] = '' ;
        $_w['Warehouse'] = '' ;
        $_w['GTN'] = '' ;
        $_w['PRF'] = '' ;
        $_w['Supplier'] = '' ;
        $_w['Receiver'] = '' ;
        $_w['Status'] = '' ;
        $_w['Draft'] = '' ;
        $_w['Complete'] = '' ;
        $_w['Select Supplier'] = '' ;
        $_w['SUPPLIER'] = '' ;
        $_w['RECEIVER'] = '' ;
        $_w['Select Receiver'] = '' ;
        $_w['WAREHOUSE'] = '' ;
        $_w['SOURCE WAREHOUSE'] = '' ;
        $_w['DESTINATION WAREHOUSE'] = '' ;
        $_w['Transfer Initiated'] = '' ;
        $_w['DELIVERY BY'] = '' ;
        $_w['SENDER'] = '' ;

        //Data Range
        $_w['Search By Date Range'] = '' ;
        $_w['Date From'] = '' ;
        $_w['Date To'] = '' ;
        $_w['Inventory Valuation'] = '' ;
        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin StoreReceipt');


    }

    public function GTN(){
            $gtn = $this->functions->ibms_setting('GTN');
            $sql="SELECT gtn FROM `purchase_receipt_gtn` ORDER BY receipt_pk DESC LIMIT 1";
            $data  =  $this->dbF->getRow($sql);
        $numb= $data[0];
        $numb = preg_replace('/\D/', '', $numb);
        @$numb = $numb + 1;
        if($data[0] === null){
        return "$gtn"."1";
        }
        else{
        return "$gtn".$numb;   
        }
    }

    public function newReceiptFormEdit2(){
       $this->newReceiptForm2(true);
    }

    public function newReceiptForm2($edit = false){  
        global $_e;
        $isEdit = false;
        $gtn = $this->GTN();
        $token = $this->functions->setFormToken('purchaseReceiptAdd',false);
        if($edit === true){
            $id = $_GET['id'];
            $isEdit = true;
            $sql = "SELECT * FROM `purchase_receipt_gtn` WHERE receipt_pk = '$id'";
            $data  =  $this->dbF->getRow($sql);
            $gtn = $data['gtn'];
            $sql = "SELECT * FROM `purchase_receipt_pro_gtn` WHERE receipt_id = '$id'";
            $data2  =  $this->dbF->getRows($sql);
            $token = $this->functions->setFormToken('purchaseReceiptEdit',false);
        }
        echo '
    <form method="post" class="form-horizontal" role="form">
    '.$token;
    if($isEdit){
            echo "<input type='hidden' name='oldId' value='$id'/>";
        }
        echo '<div class="form-horizontal">

            <div class="col-md-6" style="z-index:2">

                <div class="form-group">
                    <label for="receipt_grn" class="col-sm-2 col-md-3 control-label">GTN</label>
                    <div class="col-sm-10 col-md-9">
                        <input type="hidden" name="receipt_gtn" class="form-control receipt_gtn" value="'.@$data['gtn'].'">
                        <input type="text" class="form-control" required id="receipt_gtn" value="'.$gtn.'" placeholder="'. _u($_e['GTN']) .'"  disabled>
                    </div>
                </div>

                 <div class="form-group">
                    <label for="receipt_prf" class="col-sm-2 col-md-3 control-label">'. _u($_e['PRF']) .'</label>
                    <div class="col-sm-10 col-md-9">
                        <input type="text" name="receipt_prf" class="form-control" required id="receipt_prf" placeholder="'. _u($_e['PRF']) .'" value="'.@$data['prf'].'">
                    </div>
                </div>

                <div class="form-group">
                    <label for="receipt_date" class="col-sm-2 col-md-3 control-label">'. _uc($_e['Transfer Date']) .'</label>
                    <div class="col-sm-10 col-md-9">
                        <input type="text" name="receipt_date" class="form-control date" required id="receipt_date" placeholder="'. _uc($_e['Transfer Date']) .'" value="'.@$data['receipt_date'].'">
                    </div>
                </div>

                <div class="form-group">
                    <label for="receipt_sender" class="col-sm-2 col-md-3 control-label">'. _uc($_e['Sender']) .'</label>
                    <div class="col-sm-10 col-md-9">
                    <input type="hidden"  value="'.@$data['sender'].'" name="receipt_sender" class="form-control receipt_sender" data-val="" required>
                        <fieldset id ="sender">
                        <select required  id="receipt_sender" class="form-control product_color">
                        <option value="">'. _uc($_e['Select Sender']) .'</option>';
                            echo $this->SelectStaff();
                        echo '</select>
                        <script>$("#receipt_sender").val("'.@$data['sender'].'").change()</script>
                    </fieldset>
                    </div>
                </div>

                <div class="form-group">
                    <label for="receipt_delivery" class="col-sm-2 col-md-3 control-label">'. _uc($_e['Delivery By']) .'</label>
                    <div class="col-sm-10 col-md-9">
                    <input type="hidden" name="receipt_delivery" value="'.@$data['delivery'].'" class="form-control receipt_delivery" data-val="" required>
                        <fieldset id ="delivery">
                        <select required  id="receipt_delivery" class="form-control product_color">
                        <option value="">'. _uc($_e['Select Delivery By']) .'</option>';
                            echo $this->SelectStaff();
                        echo '</select>
                        <script>$("#receipt_delivery").val("'.@$data['delivery'].'").change()</script>
                    </fieldset>
                    </div>
                </div>

                <div class="form-group">
                    <label for="receipt_receiver" class="col-sm-2 col-md-3 control-label">'. _uc($_e['Receiver']) .'</label>
                    <div class="col-sm-10 col-md-9">
                    <input type="hidden" name="receipt_receiver" value="'.@$data['receiver'].'" class="form-control receipt_receiver" data-val="" required>
                        <fieldset id ="receiver">
                        <select required  id="receipt_receiver" class="form-control product_color">
                        <option value="">'. _uc($_e['Select Receiver']) .'</option>';
                            echo $this->SelectStaff();
                        echo '</select>
                        <script>$("#receipt_receiver").val("'.@$data['receiver'].'").change()</script>
                    </fieldset>
                    </div>
                </div>

                <div class="form-group">
                    <label for="receipt_note" class="col-sm-2 col-md-3 control-label">'. _uc($_e['Note']) .'</label>
                    <div class="col-sm-10 col-md-9">
                        <textarea name="receipt_note" class="form-control" required id="receipt_note" placeholder="'. _uc($_e['Note']) .'">'.@$data['note'].'</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="receipt_status" class="col-sm-2 col-md-3 control-label">'. _uc($_e['Status']) .'</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" class="user_type" name="receipt_publish" value="publish" '.(@$data['publish']=="publish"?"checked":"").'>' . _uc($_e['Complete']) . '
                        </label>
                        <label class="radio-inline">
                            <input type="radio" class="user_type" name="receipt_publish" value="draft" '.(@$data['publish']=="draft"?"checked":"").'>' . _uc($_e['Draft']) . '
                        </label>
                        <label class="radio-inline">
                            <input type="radio" class="user_type" name="receipt_publish" value="transfer" '.(@$data['publish']=="transfer"?"checked":"").'>' . _uc($_e['Transfer Initiated']) . '
                        </label>
                    </div>
                </div>

            </div><!-- First col-md-6 end -->


            <div class="table-responsive bootTable" >
              <table id="selected" class="table sTable table-hover" style="min-width: 570px;" width="100%" border="0" cellpadding="0" cellspacing="0">
            	<thead>
                	<tr>
                        <th>'. _u($_e['PRODUCT']) .'</th>
                        <th>'. _u($_e['SOURCE WAREHOUSE']) .'</th>
                        <th>'. _u($_e['DESTINATION WAREHOUSE']) .'</th>
                        <th>'. _u($_e['QTY']) .'</th>
                    </tr>
                </thead>
                <tbody>
                    <td>
                            <input type="text" class="form-control" id="receipt_product_id" placeholder="'. _uc($_e['Enter Product Name']) .'">
                            <input type="hidden" class="form-control receipt_product_id" data-val="">
                    </td>
                    <td class="allowProductScale">
                    <fieldset id ="store1">
                        <select  id="receipt_store_id1" class="form-control product_color" name="receipt_store_id1">
                        <option value="">'. _uc($_e['Select Store']) .'</option>';
                            //echo $this->storeNamesOption();
                        echo '</select>
                    </fieldset>
                    </td>
                    <td class="allowProductScale">
                    <fieldset id ="store2">
                        <select  id="receipt_store_id2" class="form-control product_color" name="receipt_store_id2">
                        <option value="">'. _uc($_e['Select Store']) .'</option>';
                            echo $this->storeNamesOption();
                        echo '</select>
                    </fieldset>
                    </td>
                    <td>
                           <input type="number" class="form-control" id="receipt_qty" placeholder="'. _uc($_e['Enter Product Quantity']) .'" min="0">
                    </td>

                </tbody>

                </table>
            </div>

                <div class="form-group">
                    <div class="col-sm-10">
                        <button type="button" onclick="receiptFormValid2();" id="AddProduct" class="btn btn-default">'. _uc($_e['Add Product']) .'</button>
                    </div>
                </div>


            </div> <!-- form-horizontal end -->


            <div style="margin:50px 0 0 0;">
                <input type="button" class="btn btn-danger" onclick="removechecked()" value="'. _uc($_e['Remove Checked Items']) .'" >
                <input type="button" class="btn btn-danger" onclick="uncheckall()" value="'. _uc($_e['Check/Uncheck All']) .'">
                <br><br>


             <div class="table-responsive" >
              <table id="selected" class="table sTable table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            	<thead>
                	<tr>
                    	<th>'. _u($_e['SNO']) .'</th>
                        <th>'. _u($_e['PRODUCT']) .'</th>
                        <th>'. _u($_e['SOURCE WAREHOUSE']) .'</th>
                        <th>'. _u($_e['DESTINATION WAREHOUSE']) .'</th>
                        <th>'. _u($_e['QTY']) .'</th>
                    </tr>
                </thead>
                <tbody id="vendorProdcutList">';
                if($isEdit){
                foreach ($data2 as $key => $value) {
                $trpid = "p_".$value['receipt_product_id']."-"."-".$value['receipt_product_color'];
                $qty   = $value['receipt_qty'];
                $pid   = $value['receipt_product_id'];
                $store = $value['receipt_product_color'];
                $store2 = $value['receipt_product_scale'];
                $sn =  $this->dbF->getRow("SELECT `store_name` FROM `store_name` WHERE `store_pk`=$store");
                $storeName = $sn[0];
                $sn =  $this->dbF->getRow("SELECT `store_name` FROM `store_name` WHERE `store_pk`=$store2");
                $storeName2 = $sn[0];
                $nm =  $this->dbF->getRow("SELECT `prodet_name` FROM `proudct_detail` WHERE `prodet_id`=$pid");
                $pName = translateFromSerialize($nm[0]);
                $sku   = $this->dbF->getRow("SELECT `setting_val` FROM `product_setting` WHERE `setting_name`='SKU' AND `p_id`=$pid");
                $sku   = $sku[0];
                    echo "<tr  id='tr_$trpid'>
                            <td>
                                <input type='checkbox' id='$trpid' onchange='checkchange(this.id)' value='$trpid' class='checkboxclass' />
                            <input type='hidden' name='cart_list[]' value='$trpid' /><span>".($key+1)."</span>
                            </td>
                            <td>
                                $pName [$sku]<input type='hidden' name='pid_$trpid' value='$pid' />
                            </td>
                            <td>
                                $storeName<input type='hidden' name='pstore1_$trpid' value='$store' />
                            </td>
                            <td>
                                $storeName2<input type='hidden' name='pstore2_$trpid' value='$store2' />
                            </td>
                            <td>
                                $qty<input type='hidden' name='pqty_$trpid' value='$qty' />
                            </td>
                          </tr>";
                }}
                echo'</tbody>
                </table>
            </div>

            <br>
				    <button type="submit" onclick="return formSubmit();" name="submit" value="Generate Goods Transfer Note" class="submit btn btn-primary btn-lg pull-right">'. _uc($_e['Generate Goods Transfer Note']) .'</button>

         </div> <!-- add product script div end -->
       </form>';

    }


    public function receiptList2(){
        global $_e;
        $this->functions->dataTableDateRange();
        echo '
            <div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                    <th>'. _u($_e['SNO']) .'</th>
                    <th>GTN</th>
                    <th>PRF</th>
                    <th>'. _u($_e['TRANSFER DATE']) .'</th>
                    <th>DELIVERY BY</th>
                    <th>NOTE</th>
                    <th>'. _u($_e['SENDER']) .'</th>
                    <th>'. _u($_e['RECEIVER']) .'</th>
                    <th>'. _u($_e['REGISTER DATE']) .'</th>
                    <th>'. _u($_e['ACTION']) .'</th>
                    </thead>
                <tbody>

                ';
        $purchase_receipt=$this->receiptPurchaseSQL("*",'publish');
        $data=$this->receiptStoreSQL("*");
        $i=0;
        foreach($purchase_receipt as $val){
            $i++;
            $id=$val['receipt_pk'];
            // $storeName =$this->StoreNameSQL($val['store']);
            $receiptDate = date('Y-m-d',strtotime($val['receipt_date']));
            echo "<tr class='tr_$id'>
                    <td>$i</td>
                    <td>$val[gtn]</td>
                    <td>$val[prf]</td>
                    <td>$receiptDate</td>
                    <td>$val[delivery]</td>
                    <td>$val[note]</td>
                    <td>$val[sender]</td>
                    <td>$val[receiver]</td>
                    <td>$val[dateTime]</td>
                    <td> <div class='btn-group btn-group-sm'>
                        <a data-id='$id'  data-target='#ViewReceiptModal' class='btn receiptEdit'><i class='glyphicon glyphicon-list-alt'></i>
                        </a>
                        <a data-id='$id' onclick='AjaxDelScript2(this);' class='btn'>
                                 <i class='glyphicon glyphicon-trash trash'></i>
                                 <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                         </a>
                        <a href='stock/printgoodstransfernote.php?id=$id' target='_blank' class='btn'><i class='glyphicon glyphicon-print'></i>
                        </a>
                         </div>
                    </td>
                </tr>";
        }

        echo '</tbody>
            </table>
          </div><!-- .table-responsive End -->';
        $this->productF->AjaxDelScript2('receiptAjax_del_gtn_reverse','receipt');

    }

    // my code
    public function receiptListDraft2(){
        global $_e;
        // $this->functions->dataTableDateRange();
        echo '
            <div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                    <th>'. _u($_e['SNO']) .'</th>
                    <th>GTN</th>
                    <th>PRF</th>
                    <th>'. _u($_e['TRANSFER DATE']) .'</th>
                    <th>DELIVERY BY</th>
                    <th>NOTE</th>
                    <th>'. _u($_e['SENDER']) .'</th>
                    <th>'. _u($_e['RECEIVER']) .'</th>
                    <th>'. _u($_e['REGISTER DATE']) .'</th>
                    <th>'. _u($_e['ACTION']) .'</th>
                    </thead>
                <tbody>

                ';
        $purchase_receipt=$this->receiptPurchaseSQL("*",'draft');
        $data=$this->receiptStoreSQL("*");
        $i=0;
        foreach($purchase_receipt as $val){
            $i++;
            $id=$val['receipt_pk'];
            // $storeName =$this->StoreNameSQL($val['store']);
            $receiptDate = date('Y-m-d',strtotime($val['receipt_date']));
            echo "<tr class='tr_$id'>
                    <td>$i</td>
                    <td>$val[gtn]</td>
                    <td>$val[prf]</td>
                    <td>$receiptDate</td>
                    <td>$val[delivery]</td>
                    <td>$val[note]</td>
                    <td>$val[sender]</td>
                    <td>$val[receiver]</td>
                    <td>$val[dateTime]</td>
                    <td> <div class='btn-group btn-group-sm'>
                        <a data-id='$id'  data-target='#ViewReceiptModal' class='btn receiptEdit2'><i class='glyphicon glyphicon-list-alt'></i></a>

                        <a data-id='$id' class='btn' href='-stock?page=gtnEdit&id=$id'>
                                 <i class='glyphicon glyphicon-edit'></i>
                         </a>

                         <a data-id='$id' onclick='AjaxUpdateScript2_d(this);' class='btn'>
                                 <i class='glyphicon glyphicon-thumbs-up'></i>
                                 <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                         </a>

                         <a data-id='$id' onclick='AjaxDelScript(this);' class='btn'>
                                 <i class='glyphicon glyphicon-trash trash'></i>
                                 <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                         </a>

                         </div>
                    </td>
                </tr>";
        }

        echo '</tbody>
            </table>
          </div><!-- .table-responsive End -->';
        $this->productF->AjaxDelScript('receiptAjax_del_gtn','receipt');
        $this->productF->AjaxUpdateScript2_d('receiptAjax_update_gtn_d','receipt');

    }
    public function receiptListTransfer2(){
        global $_e;
        // $this->functions->dataTableDateRange();
        echo '
            <div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                    <th>'. _u($_e['SNO']) .'</th>
                    <th>GTN</th>
                    <th>PRF</th>
                    <th>'. _u($_e['TRANSFER DATE']) .'</th>
                    <th>DELIVERY BY</th>
                    <th>NOTE</th>
                    <th>'. _u($_e['SENDER']) .'</th>
                    <th>'. _u($_e['RECEIVER']) .'</th>
                    <th>'. _u($_e['REGISTER DATE']) .'</th>
                    <th>'. _u($_e['ACTION']) .'</th>
                    </thead>
                <tbody>

                ';
        $purchase_receipt=$this->receiptPurchaseSQL("*",'transfer');
        $data=$this->receiptStoreSQL("*");
        $i=0;
        foreach($purchase_receipt as $val){
            $i++;
            $id=$val['receipt_pk'];
            // $storeName =$this->StoreNameSQL($val['store']);
            $receiptDate = date('Y-m-d',strtotime($val['receipt_date']));
            echo "<tr class='tr_$id'>
                    <td>$i</td>
                    <td>$val[gtn]</td>
                    <td>$val[prf]</td>
                    <td>$receiptDate</td>
                    <td>$val[delivery]</td>
                    <td>$val[note]</td>
                    <td>$val[sender]</td>
                    <td>$val[receiver]</td>
                    <td>$val[dateTime]</td>
                    <td> <div class='btn-group btn-group-sm'>
                        <a data-id='$id'  data-target='#ViewReceiptModal' class='btn receiptEdit3'><i class='glyphicon glyphicon-list-alt'></i></a>

                        <a data-id='$id' class='btn' href='-stock?page=gtnEdit&id=$id'>
                                 <i class='glyphicon glyphicon-edit'></i>
                         </a>

                         <a data-id='$id' onclick='AjaxUpdateScript2(this);' class='btn'>
                                 <i class='glyphicon glyphicon-thumbs-up'></i>
                                 <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                         </a>

                         <a data-id='$id' onclick='AjaxDelScript(this);' class='btn'>
                                 <i class='glyphicon glyphicon-trash trash'></i>
                                 <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                         </a>

                         </div>
                    </td>
                </tr>";
        }

        echo '</tbody>
            </table>
          </div><!-- .table-responsive End -->';
        $this->productF->AjaxDelScript('receiptAjax_del_gtn','receipt');
        $this->productF->AjaxUpdateScript2('receiptAjax_update_gtn','receipt');

    }
    // mycode
    public function storeNamesOption(){
        $data = $this->receiptStoreSQL("`store_pk`,`store_name`,`store_location`");
        $op='';
        if($this->dbF->rowCount > 0){
            foreach($data as $val){
                $op .="<option value='$val[store_pk]'>$val[store_name] - $val[store_location]</option>";

            }
            return $op;
        }
        return "";
    }

    function SelectStaff(){
        $sql    =   "SELECT acc_name FROM `accounts`";
        $data   =   $this->dbF->getRows($sql);
        $op='';
        if($this->dbF->rowCount > 0){
            foreach($data as $val){
                $op .="<option value='$val[acc_name]'>$val[acc_name]</option>";
            }
            return $op;
        }
        return "";
    }

    public function receiptPurchaseSQL($column,$publish){
        $sql="SELECT ".$column." FROM `purchase_receipt_gtn` where `publish`='$publish' ORDER BY `receipt_pk` DESC";
        return $this->dbF->getRows($sql);
    }

    public function receiptStoreSQL($column){
        $sql="SELECT ".$column." FROM `store_name` ORDER BY `store_pk` ASC";
        return $this->dbF->getRows($sql);
    }

    public function StoreNameSQL($id){
        $sql="SELECT `store_name`,`store_location` FROM `store_name` WHERE `store_pk` = '$id'";
        $data = $this->dbF->getRow($sql);

        return $data['store_name']." - ".$data['store_location'];
    }



    public function receiptAdd2(){
        global $_e;
        if(!$this->functions->getFormToken('purchaseReceiptAdd')){
            return false;
        }

        if(!empty($_POST) && !empty($_POST['submit']) && !empty($_POST['cart_list'])){
         //$this->dbF->prnt($_POST);
            $sql="INSERT INTO `purchase_receipt_gtn`(`receipt_date`, `gtn`, `prf`, `delivery`, `sender`, `receiver`, `note` , `publish`) VALUES (?,?,?,?,?,?,?,?)";
            $arry= array($_POST['receipt_date'],$this->GTN(),$_POST['receipt_prf'],$_POST['receipt_delivery'],$_POST['receipt_sender'],$_POST['receipt_receiver'],$_POST['receipt_note'],$_POST['receipt_publish']);
            @$store1=$_POST['receipt_store_id1'];
            @$store2=$_POST['receipt_store_id2'];
            $this->dbF->setRow($sql,$arry);
            $lastId= $this->dbF->rowLastId;
            $i=0;
            foreach($_POST['cart_list'] as $itemId){
               $id=$itemId;
                $i++;

                $temp="pid_".$id;
                $pid=abs($_POST[$temp]);

                $temp="pstore2_".$id;
                @$pscale=abs($_POST[$temp]);

                $temp="pstore1_".$id;
                @$pcolor=abs($_POST[$temp]);

                $temp="pqty_".$id;
                @$pqty=abs($_POST[$temp]);

                $temp="pprice_".$id;
                @$pprice=abs($_POST[$temp]);

                @$hashVal=$pid.":".$pscale;
                $hash = md5($hashVal);

                $qry_order="INSERT INTO `purchase_receipt_pro_gtn`(
                            `receipt_id`,
                            `receipt_product_id`,
                            `receipt_product_scale`,
                            `receipt_product_color`,
                            `receipt_price`,
                            `receipt_qty`,
                            `receipt_hash`
                            ) VALUES (?,?,?,?,?,?,?)";
                $arry=array($lastId,$pid,$pscale,$pcolor,$pprice,$pqty,$hash);
                $this->dbF->setRow($qry_order,$arry);
                if($_POST['receipt_publish']=='publish'){
                    $sql1="UPDATE `product_inventory` SET `qty_item` = qty_item-$pqty WHERE `qty_product_id`='$pid' AND `qty_store_id`='$pcolor'";
                   $this->dbF->setRow($sql1);
                   $sqlCheck="SELECT `product_store_hash` FROM `product_inventory` WHERE `product_store_hash` = '$hash'";
                   $this->dbF->getRow($sqlCheck);
                   if($this->dbF->rowCount>0){
                    $date =date('Y-m-d H:i:s'); //2014-09-24 13:46:10
                    $sql2= "UPDATE `product_inventory` SET `qty_item` = qty_item+$pqty , `updateTime` = '$date' WHERE `product_store_hash` = '$hash'";
                    $this->dbF->setRow($sql2);
                   }
                   else{
                   $sql3= "INSERT INTO `product_inventory`(
                                                    `qty_store_id`,
                                                    `qty_product_id`,
                                                    `qty_product_scale`,
                                                    `qty_product_color`,
                                                    `qty_item`,
                                                    `product_store_hash`
                                                ) VALUES(?,?,?,?,?,?)";
                    $arry=array($pscale,$pid,$pscale,$pscale,$pqty,$hash);
                    $this->dbF->setRow($sql3,$arry);
                    }
                }

            } // foreach

            $desc = "New Goods Transfer Note Created";
            $desc .= "<pre>PRF:$_POST[receipt_prf]</pre>";
            $desc .= "<pre>Transfer Date:$_POST[receipt_date]</pre>";
            $desc .= "<pre>Sender:$_POST[receipt_sender]</pre>";
            $desc .= "<pre>Delivery By:$_POST[receipt_delivery]</pre>";
            $desc .= "<pre>Receiver:$_POST[receipt_receiver]</pre>";
            $desc .= "<pre>Note:$_POST[receipt_note]</pre>";
            if($this->dbF->rowCount>0){
                $this->functions->setlog('Goods Transfer Note',$_POST['receipt_gtn'],$lastId,$desc);
                $this->functions->notificationError(_js(_uc($_e["New Receipt"])),_js(_uc($_e["New Receipt Generate Successfully"])),'btn-success');
            }else{
                $this->functions->notificationError(_js(_uc($_e["New Receipt"])),_js(_uc($_e["New Receipt Generate Failed"])),'btn-danger');
            }

        } // if end
    }

    public function receiptEdit2(){
        global $_e;
        if(!$this->functions->getFormToken('purchaseReceiptEdit')){
            return false;
        }
        $oldId = $_POST['oldId'];
        $sql = "UPDATE `purchase_receipt_gtn` SET 
                `receipt_date` = '$_POST[receipt_date]',
                `prf`       = '$_POST[receipt_prf]',
                `receiver`  = '$_POST[receipt_receiver]',
                `sender`    = '$_POST[receipt_sender]',
                `delivery`  = '$_POST[receipt_delivery]',
                `note`      = '$_POST[receipt_note]',
                `publish`   = '$_POST[receipt_publish]'
                WHERE `receipt_pk` = '$oldId'";
        $this->dbF->setRow($sql);
        $this->dbF->setRow("DELETE FROM `purchase_receipt_pro_gtn` WHERE `receipt_id`='$oldId'");
        @$store=$_POST['receipt_store_id'];
        $i=0;
            foreach($_POST['cart_list'] as $itemId){
               $id=$itemId;
                $i++;

                $temp="pid_".$id;
                $pid=abs($_POST[$temp]);

                $temp="pstore2_".$id;
                @$pscale=abs($_POST[$temp]);

                $temp="pstore1_".$id;
                @$pcolor=abs($_POST[$temp]);

                $temp="pqty_".$id;
                @$pqty=abs($_POST[$temp]);

                $temp="pprice_".$id;
                @$pprice=abs($_POST[$temp]);

                @$hashVal=$pid.":".$pscale;
                $hash = md5($hashVal);

                $qry_order="INSERT INTO `purchase_receipt_pro_gtn`(
                            `receipt_id`,
                            `receipt_product_id`,
                            `receipt_product_scale`,
                            `receipt_product_color`,
                            `receipt_price`,
                            `receipt_qty`,
                            `receipt_hash`
                            ) VALUES (?,?,?,?,?,?,?)";
                $arry=array($oldId,$pid,$pscale,$pcolor,$pprice,$pqty,$hash);
                $this->dbF->setRow($qry_order,$arry);
                if($_POST['receipt_publish']=='publish'){
                    $sql1="UPDATE `product_inventory` SET `qty_item` = qty_item-$pqty WHERE `qty_product_id`='$pid' AND `qty_store_id`='$pcolor'";
                   $this->dbF->setRow($sql1);
                   $sqlCheck="SELECT `product_store_hash` FROM `product_inventory` WHERE `product_store_hash` = '$hash'";
                   $this->dbF->getRow($sqlCheck);
                   if($this->dbF->rowCount>0){
                    $date =date('Y-m-d H:i:s'); //2014-09-24 13:46:10
                    $sql2= "UPDATE `product_inventory` SET `qty_item` = qty_item+$pqty , `updateTime` = '$date' WHERE `product_store_hash` = '$hash'";
                    $this->dbF->setRow($sql2);
                   }
                   else{
                   $sql3= "INSERT INTO `product_inventory`(
                                                    `qty_store_id`,
                                                    `qty_product_id`,
                                                    `qty_product_scale`,
                                                    `qty_product_color`,
                                                    `qty_item`,
                                                    `product_store_hash`
                                                ) VALUES(?,?,?,?,?,?)";
                    $arry=array($pscale,$pid,$pscale,$pcolor,$pqty,$hash);
                    $this->dbF->setRow($sql3,$arry);
                    }
                }

            } // foreach

            $desc="Goods Transfer Note Update";
            $desc .= "<pre>PRF:$_POST[receipt_prf]</pre>";
            $desc .= "<pre>Transfer Date:$_POST[receipt_date]</pre>";
            $desc .= "<pre>Sender:$_POST[receipt_sender]</pre>";
            $desc .= "<pre>Delivery By:$_POST[receipt_delivery]</pre>";
            $desc .= "<pre>Receiver:$_POST[receipt_receiver]</pre>";
            $desc .= "<pre>Note:$_POST[receipt_note]</pre>";
            if($this->dbF->rowCount>0){
                $this->functions->setlog('Goods Transfer Note',$_POST['receipt_gtn'],$oldId,$desc);
                $this->functions->notificationError(_js(_uc("Receipt")),_js(_uc("Receipt Update Successfully")),'btn-success');
            }else{
                $this->functions->notificationError(_js(_uc("Receipt")),_js(_uc("Receipt Update Failed")),'btn-danger');
            }
    }


}

?>