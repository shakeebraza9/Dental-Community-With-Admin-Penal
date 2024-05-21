<?php
require_once(__DIR__."/../../product_management/functions/product_function.php");

class purchase_receipt3 extends object_class{
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
        $_w['View All Delivery Note'] = '' ;
        $_w['Delivery Note'] = '' ;
        $_w['Delivery Note View'] = '' ;
        $_w['Add New Delivery Note'] = '' ;

        //This class
        $_w['SNO'] = '' ;
        $_w['Customer'] = '' ;
        $_w['DLEIVERY TO'] = '' ;
        $_w['Select Customer'] = '' ;
        $_w['Select Staff'] = '' ;
        $_w['Staff'] = '' ;
        $_w['VENDOR'] = '' ;
        $_w['STORE NAME'] = '' ;
        $_w['DELIVERY DATE'] = '' ;
        $_w['REGISTER DATE'] = '' ;
        $_w['ACTION'] = '' ;
        $_w['Vendor Name'] = '' ;
        $_w['Delivery Date'] = '' ;
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
        $_w['Generate Delivery Note'] = '' ;
        $_w['Prodcut Quantity Add in {{n}} different products'] = '' ;
        $_w['New Receipt'] = '' ;
        $_w['Receipt'] = '' ;
        $_w['New Receipt Generate Successfully'] = '' ;
        $_w['New Receipt Generate Failed'] = '' ;
        $_w['Note'] = '' ;
        $_w['PO Number'] = '' ;
        $_w['Note'] = '' ;
        $_w['Warehouse'] = '' ;
        $_w['DN'] = '' ;
        $_w['PRF'] = '' ;
        $_w['Sender'] = '' ;
        $_w['Delivery By'] = '' ;
        $_w['Status'] = '' ;
        $_w['Draft'] = '' ;
        $_w['Delivery Initiated'] = '' ;
        $_w['Complete'] = '' ;
        $_w['Select Sender'] = '' ;
        $_w['SENDER'] = '' ;
        $_w['DELIVERY BY'] = '' ;
        $_w['Select Delivery By'] = '' ;
        $_w['WAREHOUSE'] = '' ;
        $_w['Delivery To'] = '' ;
        $_w['Select Customer/Staff'] = '' ;
        $_w['Additional contact details'] = '';
        $_w['Customer PO ref'] = '';
        //Data Range
        $_w['Search By Date Range'] = '' ;
        $_w['Date From'] = '' ;
        $_w['Date To'] = '' ;
        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin StoreReceipt');


    }

    public function DN(){
            $dn = $this->functions->ibms_setting('DN');
            $sql="SELECT dn FROM `purchase_receipt_dn` ORDER BY receipt_pk DESC LIMIT 1";
            $data  =  $this->dbF->getRow($sql);
        $numb= $data[0];
        $numb = preg_replace('/\D/', '', $numb);
        $numb = $numb + 1;
        if($data[0] === null){
        return "$dn"."1";
        }
        else{
        return "$dn".$numb;   
        }
    }

    public function newReceiptFormEdit3(){
       $this->newReceiptForm3(true);
    }

    public function newReceiptForm3($edit = false){  
        global $_e;
        $isEdit = false;
        $dn = $this->DN();
        $token = $this->functions->setFormToken('purchaseReceiptAdd',false);
        if($edit === true){
            $id = $_GET['id'];
            $isEdit = true;
            $sql = "SELECT * FROM `purchase_receipt_dn` WHERE receipt_pk = '$id'";
            $data  =  $this->dbF->getRow($sql);
            $dn = $data['dn'];
            $sql = "SELECT * FROM `purchase_receipt_pro_dn` WHERE receipt_id = '$id'";
            $data2  =  $this->dbF->getRows($sql);
            $token = $this->functions->setFormToken('purchaseReceiptEdit',false);
        }
        echo '
    <form method="post" class="form-horizontal" role="form">
    '.$token;
    if($isEdit){
            echo "<input type='hidden' name='oldId' value='$id'/>";
        }
        echo '
        <div class="form-horizontal">

            <div class="col-md-6" style="z-index:2">

                <div class="form-group">
                    <label for="receipt_dn" class="col-sm-2 col-md-3 control-label">'. _u($_e['DN']) .'</label>
                    <div class="col-sm-10 col-md-9">
                     <input type="hidden" name="receipt_dn" class="receipt_dn" value="'.@$data['dn'].'">
                        <input type="text" class="form-control" required id="receipt_dn" value="'.$dn.'" placeholder="'. _u($_e['DN']) .'"  disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="receipt_ddate" class="col-sm-2 col-md-3 control-label">'. _uc($_e['Delivery Date']) .'</label>
                    <div class="col-sm-10 col-md-9">
                        <input type="text" name="receipt_ddate" class="form-control date" required id="receipt_ddate" placeholder="'. _uc($_e['Delivery Date']) .'" value="'.@$data['receipt_date'].'">
                    </div>
                </div>

                <div class="form-group">
                <label class="col-sm-2 col-md-3 control-label"> </label>
                <div class="col-sm-10 col-md-9">
                    <input type="hidden" name="receipt_type" class="receipt_type"  value="'.@$data['receipt_type'].'">
                        <div class="make-switch" data-off="warning" data-on="success" data-on-label="' . _uc($_e['Customer']) . '" data-off-label="' . _uc($_e['Staff']) . '" style="min-width: 130px;">
                        <input type="checkbox" value="0" placeholder="Public Access">
                        <input type="hidden" class="checkboxHidden" id="type" value="0">
                        </div>

                    </div><br><br>
                    <label for="receipt_cp" class="col-sm-2 col-md-3 control-label">'. _uc($_e['Delivery To']) .'</label>
                    <div class="col-sm-10 col-md-9">
                    <input type="hidden" name="receipt_cp" value="'.@$data['cp'].'" class="form-control receipt_cp" data-val="" required>
                        <fieldset id ="receipt_cp">
                        <select  id="receipt_cp1" class="form-control cp" style="display:none">
                        <option value="">'. _uc($_e['Select Customer']) .'</option>';
                            echo $this->SelectCustomer();
                        echo '</select>
                        <select  id="receipt_cp2" class="form-control cp">
                        <option value="">'. _uc($_e['Select Staff']) .'</option>';
                            echo $this->SelectStaff();
                        echo '</select>
                        <script>$(".cp").val("'.@$data['cp'].'").change();
                        $(window).load(function() {
                        if($("#receipt_cp2").val() == null){
                           $(".switch-animate").removeClass("switch-off").addClass("switch-animate switch-on");
                           $("#receipt_cp1").show();
                           $("#receipt_cp2").hide();
                           console.log($("#receipt_cp2").val());
                        }
                        });
                        </script>
                    </fieldset>
                    </div>
                </div>

                <div class="form-group">
                    <label for="receipt_acd" class="col-sm-2 col-md-3 control-label">'. _uc($_e['Additional contact details']) .'</label>
                    <div class="col-sm-10 col-md-9">
                        <input type="text" name="receipt_acd" class="form-control" required id="receipt_acd" placeholder="'. _uc($_e['Additional contact details']) .'" value="'.@$data['account_cd'].'">
                    </div>
                </div>

                 <div class="form-group">
                    <label for="receipt_prf" class="col-sm-2 col-md-3 control-label">'. _u($_e['PRF']) .'</label>
                    <div class="col-sm-10 col-md-9">
                        <input type="text" name="receipt_prf" class="form-control" required id="prf" placeholder="'. _u($_e['PRF']) .'" value="'.@$data['prf'].'">
                    </div>
                </div>

                 <div class="form-group">
                    <label for="receipt_cpr" class="col-sm-2 col-md-3 control-label">'. $_e['Customer PO ref'] .'</label>
                    <div class="col-sm-10 col-md-9">
                        <input type="text" name="receipt_cpr" class="form-control" id="receipt_cpr" placeholder="'. $_e['Customer PO ref'] .'" value="'.@$data['customer_po_ref'].'">
                    </div>
                </div>

                 <div class="form-group">
                    <label for="receipt_sender" class="col-sm-2 col-md-3 control-label">'. _uc($_e['Sender']) .'</label>
                    <div class="col-sm-10 col-md-9">
                    <input type="hidden" value="'.@$data['sender'].'" name="receipt_sender" class="form-control receipt_sender" data-val="" required>
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
                    <label for="receipt_deliveryby" class="col-sm-2 col-md-3 control-label">'. _uc($_e['Delivery By']) .'</label>
                    <div class="col-sm-10 col-md-9">
                    <input type="hidden" value="'.@$data['delivery_by'].'" name="receipt_deliveryby" class="form-control receipt_deliveryby" data-val="" required>
                        <fieldset id ="deliveryby">
                        <select required  id="receipt_deliveryby" class="form-control product_color">
                        <option value="">'. _uc($_e['Delivery By']) .'</option>';
                            echo $this->SelectStaff();
                        echo '</select>
                        <script>$("#receipt_deliveryby").val("'.@$data['delivery_by'].'").change()</script>
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
                            <input type="radio" class="user_type" name="receipt_publish" value="transfer" '.(@$data['publish']=="transfer"?"checked":"").'>' . _uc($_e['Delivery Initiated']) . '
                        </label>
                    </div>
                </div>

            </div><!-- First col-md-6 end -->


            <div class="table-responsive bootTable" >
              <table id="selected" class="table sTable table-hover" style="min-width: 570px;" width="100%" border="0" cellpadding="0" cellspacing="0">
            	<thead>
                	<tr>
                        <th>'. _u($_e['PRODUCT']) .'</th>
                        <th>'. _u($_e['Warehouse']) .'</th>
                        <th>'. _u($_e['QTY']) .'</th>
                    </tr>
                </thead>
                <tbody>
                    <td>
                            <input type="text" class="form-control" id="receipt_product_id" placeholder="'. _uc($_e['Enter Product Name']) .'">
                            <input type="hidden" class="form-control receipt_product_id" data-val="">
                    </td>
                    <td class="allowProductScale">
                    <fieldset id ="store">
                        <select  id="receipt_store_id" class="form-control product_color" name="receipt_store_id">
                        <option value="">'. _uc($_e['Select Store']) .'</option>';
                            //echo $this->storeNamesOption();
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
                        <button type="button" onclick="receiptFormValid3();" id="AddProduct" class="btn btn-default">'. _uc($_e['Add Product']) .'</button>
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
                        <th>'. _u($_e['WAREHOUSE']) .'</th>
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
                $sn =  $this->dbF->getRow("SELECT `store_name` FROM `store_name` WHERE `store_pk`=$store");
                $storeName = $sn[0];
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
                                $storeName<input type='hidden' name='pstore_$trpid' value='$store' />
                            </td>
                            <td>
                                $qty<input type='hidden' name='pqty_$trpid' value='$qty' />
                            </td>
                          </tr>";
                }}
                echo'
                </tbody>

                </table>
            </div>

            <br>
				    <button type="submit" onclick="return formSubmit();" name="submit" value="Generate Delivery Note" class="submit btn btn-primary btn-lg pull-right">'. _uc($_e['Generate Delivery Note']) .'</button>

         </div> <!-- add product script div end -->
       </form>';

    }


    public function receiptList3(){
        global $_e;
        $this->functions->dataTableDateRange();
        echo '
            <div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                    <th>'. _u($_e['SNO']) .'</th>
                    <th>DN</th>
                    <th>PRF</th>
                    <th>'. _u($_e['DELIVERY DATE']) .'</th>
                    <th>DELIVERY TYPE</th>
                    <th>DELIVERY TO</th>
                    <th>ADDITINAL CONTACT DETAILS</th>
                    <th>CUSTOMER PO REF</th>
                    <th>NOTE</th>
                    <th>'. _u($_e['SENDER']) .'</th>
                    <th>'. _u($_e['DELIVERY BY']) .'</th>
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
                    <td>$val[dn]</td>
                    <td>$val[prf]</td>
                    <td>$receiptDate</td>
                    <td>"._uc($val['type'])."</td>
                    <td>$val[cp]</td>
                    <td>$val[account_cd]</td>
                    <td>$val[customer_po_ref]</td>
                    <td>$val[note]</td>
                    <td>$val[sender]</td>
                    <td>$val[delivery_by]</td>
                    <td>$val[dateTime]</td>
                    <td> <div class='btn-group btn-group-sm'>
                        <a data-id='$id'  data-target='#ViewReceiptModal' class='btn receiptEdit'><i class='glyphicon glyphicon-list-alt'></i>
                        </a>
                         <a data-id='$id' onclick='AjaxDelScript2(this);' class='btn'>
                                 <i class='glyphicon glyphicon-trash trash'></i>
                                 <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                         </a>
                        <a href='stock/printdeliverynote.php?id=$id' target='_blank' class='btn'><i class='glyphicon glyphicon-print'></i>
                        </a>
                         </div>
                    </td>
                </tr>";
        }

        echo '</tbody>
            </table>
          </div><!-- .table-responsive End -->';
        $this->productF->AjaxDelScript2('receiptAjax_del_dn_reverse','receipt');

    }

    // my code
    public function receiptListDraft3(){
        global $_e;
        // $this->functions->dataTableDateRange();
        echo '
            <div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                    <th>'. _u($_e['SNO']) .'</th>
                    <th>DN</th>
                    <th>PRF</th>
                    <th>'. _u($_e['DELIVERY DATE']) .'</th>
                    <th>DELIVERY TYPE</th>
                    <th>DELIVERY TO</th>
                    <th>ADDITINAL CONTACT DETAILS</th>
                    <th>CUSTOMER PO REF</th>
                    <th>NOTE</th>
                    <th>'. _u($_e['SENDER']) .'</th>
                    <th>'. _u($_e['DELIVERY BY']) .'</th>
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
                    <td>$val[dn]</td>
                    <td>$val[prf]</td>
                    <td>$receiptDate</td>
                    <td>"._uc($val['type'])."</td>
                    <td>$val[cp]</td>
                    <td>$val[account_cd]</td>
                    <td>$val[customer_po_ref]</td>
                    <td>$val[note]</td>
                    <td>$val[sender]</td>
                    <td>$val[delivery_by]</td>
                    <td>$val[dateTime]</td>
                    <td> <div class='btn-group btn-group-sm'>
                        <a data-id='$id'  data-target='#ViewReceiptModal' class='btn receiptEdit2'><i class='glyphicon glyphicon-list-alt'></i></a>

                        <a data-id='$id' class='btn' href='-stock?page=dnEdit&id=$id'>
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
        $this->productF->AjaxDelScript('receiptAjax_del_dn','receipt');
        $this->productF->AjaxUpdateScript2_d('receiptAjax_update_dn_d','receipt');

    }
    public function receiptListDI3(){
        global $_e;
        // $this->functions->dataTableDateRange();
        echo '
            <div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                    <th>'. _u($_e['SNO']) .'</th>
                    <th>DN</th>
                    <th>PRF</th>
                    <th>'. _u($_e['DELIVERY DATE']) .'</th>
                    <th>DELIVERY TYPE</th>
                    <th>DELIVERY TO</th>
                    <th>ADDITINAL CONTACT DETAILS</th>
                    <th>CUSTOMER PO REF</th>
                    <th>NOTE</th>
                    <th>'. _u($_e['SENDER']) .'</th>
                    <th>'. _u($_e['DELIVERY BY']) .'</th>
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
                    <td>$val[dn]</td>
                    <td>$val[prf]</td>
                    <td>$receiptDate</td>
                    <td>"._uc($val['type'])."</td>
                    <td>$val[cp]</td>
                    <td>$val[account_cd]</td>
                    <td>$val[customer_po_ref]</td>
                    <td>$val[note]</td>
                    <td>$val[sender]</td>
                    <td>$val[delivery_by]</td>
                    <td>$val[dateTime]</td>
                    <td> <div class='btn-group btn-group-sm'>
                        <a data-id='$id'  data-target='#ViewReceiptModal' class='btn receiptEdit3'><i class='glyphicon glyphicon-list-alt'></i></a>

                        <a data-id='$id' class='btn' href='-stock?page=dnEdit&id=$id'>
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
        $this->productF->AjaxDelScript('receiptAjax_del_dn','receipt');
        $this->productF->AjaxUpdateScript2('receiptAjax_update_dn','receipt');

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

    function SelectCustomer(){
        $sql    =   "SELECT acc_name FROM `accounts_user` WHERE acc_id IN (SELECT id_user FROM `accounts_user_detail` where setting_val='customer' OR setting_val='both')";
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
        $sql="SELECT ".$column." FROM `purchase_receipt_dn` where `publish`='$publish' ORDER BY `receipt_pk` DESC";
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



    public function receiptAdd3(){
        global $_e;
        if(!$this->functions->getFormToken('purchaseReceiptAdd')){
            return false;
        }

        if(!empty($_POST) && !empty($_POST['submit']) && !empty($_POST['cart_list'])){
         //$this->dbF->prnt($_POST);
            $type = "staff";
            $ck = $_POST['receipt_type'];
            if($ck=="1"){
                $type = "customer";
            }
            $sql="INSERT INTO `purchase_receipt_dn`(`receipt_date`, `cp` ,`type`, `dn`, `prf`, `customer_po_ref`, `sender`, `delivery_by`, `account_cd`, `note` , `publish`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
            $arry= array($_POST['receipt_ddate'],$_POST['receipt_cp'],$type,$this->DN(),$_POST['receipt_prf'],$_POST['receipt_cpr'],$_POST['receipt_sender'],$_POST['receipt_deliveryby'],$_POST['receipt_acd'],$_POST['receipt_note'],$_POST['receipt_publish']);

            @$store=$_POST['receipt_store_id'];
            $this->dbF->setRow($sql,$arry);
            $lastId= $this->dbF->rowLastId;
            $i=0;
            foreach($_POST['cart_list'] as $itemId){
               $id=$itemId;
                $i++;

                $temp="pid_".$id;
                $pid=abs($_POST[$temp]);

                $temp="pscale_".$id;
                @$pscale=abs($_POST[$temp]);

                $temp="pstore_".$id;
                @$pcolor=abs($_POST[$temp]);

                $temp="pqty_".$id;
                @$pqty=abs($_POST[$temp]);

                $temp="pprice_".$id;
                @$pprice=abs($_POST[$temp]);

                @$hashVal=$pid.":".$store;
                $hash = md5($hashVal);

                $qry_order="INSERT INTO `purchase_receipt_pro_dn`(
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
                   $sql="UPDATE `product_inventory` SET `qty_item` = qty_item-$pqty WHERE `qty_product_id`='$pid' AND `qty_store_id`='$pcolor'";
                    $this->dbF->setRow($sql);
                }
            } // foreach

            $desc = "New Delivery Note Generate Created";
            $desc .= "<pre>Delivery Date:$_POST[receipt_ddate]</pre>";
            $desc .= "<pre>Delivery To:$_POST[receipt_cp]</pre>";
            $desc .= "<pre>Additional Contact Details:$_POST[receipt_acd]</pre>";
            $desc .= "<pre>PRF:$_POST[receipt_prf]</pre>";
            $desc .= "<pre>Customer PO ref:$_POST[receipt_cpr]</pre>";
            $desc .= "<pre>Sender:$_POST[receipt_sender]</pre>";
            $desc .= "<pre>Delivery By:$_POST[receipt_deliveryby]</pre>";
            $desc .= "<pre>Note:$_POST[receipt_note]</pre>";
            if($this->dbF->rowCount>0){
                $this->functions->setlog('Delivery Note',$_POST['receipt_dn'],$lastId,$desc);
                $this->functions->notificationError(_js(_uc($_e["New Receipt"])),_js(_uc($_e["New Receipt Generate Successfully"])),'btn-success');
            }else{
                $this->functions->notificationError(_js(_uc($_e["New Receipt"])),_js(_uc($_e["New Receipt Generate Failed"])),'btn-danger');
            }

        } // if end
    }

        public function receiptEdit3(){
        global $_e;
        if(!$this->functions->getFormToken('purchaseReceiptEdit')){
            return false;
        }
        $oldId = $_POST['oldId'];
        $type = "staff";
            $ck = $_POST['receipt_type'];
            if($ck=="1"){
                $type = "customer";
            }
        $sql = "UPDATE `purchase_receipt_dn` SET 
                `receipt_date`    = '$_POST[receipt_ddate]',
                `prf`             = '$_POST[receipt_prf]',
                `customer_po_ref` = '$_POST[receipt_cpr]',
                `cp`              = '$_POST[receipt_cp]',
                `sender`          = '$_POST[receipt_sender]',
                `delivery_by`     = '$_POST[receipt_deliveryby]',
                `note`            = '$_POST[receipt_note]',
                `account_cd`      = '$_POST[receipt_acd]',
                `type`            = '$type',
                `publish`         = '$_POST[receipt_publish]'
                WHERE `receipt_pk` = '$oldId'";
        $this->dbF->setRow($sql);
        $this->dbF->setRow("DELETE FROM `purchase_receipt_pro_dn` WHERE `receipt_id`='$oldId'");
        @$store=$_POST['receipt_store_id'];
        $i=0;
        foreach($_POST['cart_list'] as $itemId){
               $id=$itemId;
                $i++;

                $temp="pid_".$id;
                $pid=abs($_POST[$temp]);

                $temp="pstore_".$id;
                @$pcolor=abs($_POST[$temp]);

                $temp="pqty_".$id;
                @$pqty=abs($_POST[$temp]);

                @$hashVal=$pid.":".$store;
                $hash = md5($hashVal);

                $qry_order="INSERT INTO `purchase_receipt_pro_dn`(
                            `receipt_id`,
                            `receipt_product_id`,
                            `receipt_product_color`,
                            `receipt_qty`,
                            `receipt_hash`
                            ) VALUES (?,?,?,?,?)";
                $arry=array($oldId,$pid,$pcolor,$pqty,$hash);
                $this->dbF->setRow($qry_order,$arry);

                if($_POST['receipt_publish']=='publish'){
                   $sql="UPDATE `product_inventory` SET `qty_item` = qty_item-$pqty WHERE `qty_product_id`='$pid' AND `qty_store_id`='$pcolor'";
                    $this->dbF->setRow($sql);
                }
            } // foreach

            $desc="Delivery Note Update";
            $desc .= "<pre>Delivery Date:$_POST[receipt_ddate]</pre>";
            $desc .= "<pre>Delivery To:$_POST[receipt_cp]</pre>";
            $desc .= "<pre>Additional Contact Details:$_POST[receipt_acd]</pre>";
            $desc .= "<pre>PRF:$_POST[receipt_prf]</pre>";
            $desc .= "<pre>Customer PO ref:$_POST[receipt_cpr]</pre>";
            $desc .= "<pre>Sender:$_POST[receipt_sender]</pre>";
            $desc .= "<pre>Delivery By:$_POST[receipt_deliveryby]</pre>";
            $desc .= "<pre>Note:$_POST[receipt_note]</pre>";
            if($this->dbF->rowCount>0){
                $this->functions->setlog('Delivery Note',$_POST['receipt_dn'],$oldId,$desc);
                $this->functions->notificationError(_js(_uc("Receipt")),_js(_uc("Receipt Update Successfully")),'btn-success');
            }else{
                $this->functions->notificationError(_js(_uc("Receipt")),_js(_uc("Receipt Update Failed")),'btn-danger');
            }
    }

}

?>