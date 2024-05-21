<?php
require_once(__DIR__."/../../product_management/functions/product_function.php");

class purchase_receipt4 extends object_class{
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
        $_w['View All Inventory Adjustment Note'] = '' ;
        $_w['Inventory Adjustment Note'] = '' ;
        $_w['Inventory Adjustment Note View'] = '' ;
        $_w['Add New Inventory Adjustment Note'] = '' ;

        //This class
        $_w['SNO'] = '' ;
        $_w['Adjustment Initiated'] = '' ;
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
        $_w['Generate Inventory Adjustment Note'] = '' ;

        $_w['Prodcut Quantity Add in {{n}} different products'] = '' ;
        $_w['New Receipt'] = '' ;
        $_w['Receipt'] = '' ;
        $_w['New Receipt Generate Successfully'] = '' ;
        $_w['New Receipt Generate Failed'] = '' ;
        $_w['Note'] = '' ;
        $_w['Attachment'] = '' ;
        $_w['Note'] = '' ;
        $_w['Warehouse'] = '' ;
        $_w['IAN'] = '' ;
        $_w['PRF'] = '' ;
        $_w['Inspected By'] = '' ;
        $_w['Reason'] = '' ;
        $_w['Status'] = '' ;
        $_w['Draft'] = '' ;
        $_w['Approved'] = '' ;
        $_w['Select Inspected By'] = '' ;
        $_w['DATE'] = '' ;
        $_w['RECEIVER'] = '' ;
        $_w['Select Reason'] = '' ;
        $_w['WAREHOUSE'] = '' ;
        $_w['Description'] = '' ;
        $_w['REASON'] = '' ;
        $_w['INSPECTED BY'] = '' ;
        $_w['EXISTING CONDITION'] = '' ;
        $_w['NEW CONDITION'] = '' ;
        $_w['EXISTING QTY'] = '' ;
        $_w['NEW QTY'] = '' ;

        //Data Range
        $_w['Search By Date Range'] = '' ;
        $_w['Date From'] = '' ;
        $_w['Date To'] = '' ;
        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin StoreReceipt');


    }

    public function btn(){
        $id     = $_SESSION['_roleGrp'];
        if($id==='0' || $id === 0){
            return true;
        }
        $sql    = "SELECT * FROM accounts_prm_grp WHERE id = '$id'";
        $userData   =   $this->dbF->getRow($sql);
        $userData   =   unserialize($userData['permission']);
        $userData   =   $userData['stock'];
        return $userData['inventory-approved'];
    }

    public function docsEdit($id){
        global $_e;
            // If product is edit mode
            $qry="SELECT * FROM  `ian_image` WHERE `receipt_id` = '$id' ORDER BY sort ASC";
            $eData=$this->dbF->getRows($qry);
            if($this->dbF->rowCount>0){

                foreach($eData as $key=>$val){
                    $img=$val['image'];
                    $imgId=$val['img_id'];
                    echo <<<HTML
                    <div class="preview albumPreview" id="image_$imgId" style="height: 120px !important;width: 120px !important;">
                           
                           <a href="../images/$img">Download File</a>
                            <div class="progressHolder album">
                                    <a class="docEditDel btn btn-danger btn-sm" data-id="$imgId">Remove</a>
                            </div>
                        </div>
HTML;
                }
            }
    }
    public function IAN(){
            $ian = $this->functions->ibms_setting('IAN');
            $sql="SELECT ian FROM `purchase_receipt_ian` ORDER BY receipt_pk DESC LIMIT 1";
            $data  =  $this->dbF->getRow($sql);
        $numb= $data[0];
        $numb = preg_replace('/\D/', '', $numb);
        @@$numb = $numb + 1;
        if($data[0] === null){
        return "$ian"."1";
        }
        else{
        return "$ian".$numb;   
        }
    }

    public function RID(){
            $sql="SELECT `receipt_pk` FROM `purchase_receipt_ian` ORDER BY `receipt_pk` DESC LIMIT 1";
            $data  =  $this->dbF->getRow($sql);
            $id = $data[0]+1;
            if($id === null){
                return 1;
            }
            else{
            return $id;   
            }
    }

    public function newReceiptFormEdit4(){
       $this->newReceiptForm4(true);
    }

    public function newReceiptForm4($edit = false){  
        global $_e;
        $isEdit = false;
        $sql2="DELETE FROM `ian_image` WHERE receipt_id='".$this->RID()."'";
            $this->dbF->setRow($sql2);
        $ian = $this->IAN();
        $rid = $this->RID();
        $token = $this->functions->setFormToken('purchaseReceiptAdd',false);
        if($edit === true){
            $id = $_GET['id'];
            $isEdit = true;
            $sql = "SELECT * FROM `purchase_receipt_ian` WHERE receipt_pk = '$id'";
            $data =  $this->dbF->getRow($sql);
            $ian = $data['ian'];
            $rid = $id;
            $sql = "SELECT * FROM `purchase_receipt_pro_ian` WHERE receipt_id = '$id'";
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
                    <label for="receipt_ian" class="col-sm-2 col-md-3 control-label">'. _u($_e['IAN']) .'</label>
                    <div class="col-sm-10 col-md-9">
                    <input type="hidden" name="receipt_ian" class="receipt_ian" value="'.@$data['ian'].'">
                        <input type="text"  class="form-control" id="receipt_ian" value="'.$ian.'" placeholder="'. _u($_e['IAN']) .'"  disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="receipt_reason" class="col-sm-2 col-md-3 control-label">'. _uc($_e['Reason']) .'</label>
                    <div class="col-sm-10 col-md-9">
                    <input type="hidden" name="receipt_reason" value="'.@$data['reason'].'" class="form-control receipt_reason" data-val="" required>
                        <fieldset id ="reason">
                        <select required  id="receipt_reason" class="form-control product_color">
                        <option value="">'. _uc($_e['Select Reason']) .'</option>';
                            echo $this->SelectReason();
                        echo '</select>
                        <script>$("#receipt_reason").val("'.@$data['reason'].'").change()</script>
                    </fieldset>
                    </div>
                </div>

                 <div class="form-group">
                    <label for="receipt_ponumber" class="col-sm-2 col-md-3 control-label">'. $_e['Attachment'] .'</label>
                    <div class="col-sm-10 col-md-9">
                        <!-- Attament-->
                        <input type="hidden" id="AjaxFileNewId" name="ProductNewId"
                                   value="'.$rid.'">
                            <input type="hidden" id="AjaxFileNewPage" value="ian">
                            <div id="dropbox">

                                
                                <!-- if product edit-->';
                                if ($isEdit) {
                                    $this->docsEdit($_GET['id']);
                                }
                                
                                echo '<style>
                                    #dropbox .preview {
                                        height: 255px !important;
                                        padding: 4px;
                                        background: #eee;
                                    }

                                    #dropbox .progressHolder.album {
                                        height: 80px !important;
                                        padding: 5px;
                                    }

                                </style>
                            </div>
                            <!-- Attament-->
                    </div>
                </div>

                 <div class="form-group">
                    <label for="receipt_inspectedby" class="col-sm-2 col-md-3 control-label">'. _uc($_e['Inspected By']) .'</label>
                    <div class="col-sm-10 col-md-9">
                    <input type="hidden" name="receipt_inspectedby" value="'.@$data['inspected_by'].'" class="form-control receipt_inspectedby" data-val="" required>
                        <fieldset id ="inspectedby">
                        <select required  id="receipt_inspectedby" class="form-control product_color">
                        <option value="">'. _uc($_e['Select Inspected By']) .'</option>';
                            echo $this->SelectStaff();
                        echo '</select>
                        <script>$("#receipt_inspectedby").val("'.@$data['inspected_by'].'").change()</script>
                    </fieldset>
                    </div>
                </div>

                <div class="form-group">
                    <label for="receipt_date" class="col-sm-2 col-md-3 control-label">'. _uc($_e['Date']) .'</label>
                    <div class="col-sm-10 col-md-9">
                        <input type="text" name="receipt_date" class="form-control date" required id="receipt_date" placeholder="'. _uc($_e['Date']) .'" value="'.@$data['receipt_date'].'">
                    </div>
                </div>

                <div class="form-group">
                    <label for="receipt_description" class="col-sm-2 col-md-3 control-label">'. _uc($_e['Description']) .'</label>
                    <div class="col-sm-10 col-md-9">
                        <textarea name="receipt_description" class="form-control" required id="receipt_description" placeholder="'. _uc($_e['Description']) .'">'.@$data['description'].'</textarea>
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
                    <div class="col-sm-9">';
                        if($this->btn()=="1")
                        {
                        echo '<label class="radio-inline">
                            <input type="radio" class="user_type" name="receipt_publish" value="publish" '.(@$data['publish']=="publish"?"checked":"").'>' . _uc($_e['Approved']) . '
                        </label>';
                        }
                        echo '<label class="radio-inline">
                            <input type="radio" class="user_type" name="receipt_publish" value="draft" '.(@$data['publish']=="draft"?"checked":"").'>' . _uc($_e['Draft']) . '
                        </label>
                        <label class="radio-inline">
                            <input type="radio" class="user_type" name="receipt_publish" value="initiated" '.(@$data['publish']=="initiated"?"checked":"").'>' . _uc($_e['Adjustment Initiated']) . '
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
                        <th>'. _u($_e['EXISTING QTY']) .'</th>
                        <th>'. _u($_e['NEW QTY']) .'</th>
                        <th>'. _u($_e['EXISTING CONDITION']) .'</th>
                        <th>'. _u($_e['NEW CONDITION']) .'</th>
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
                            echo $this->storeNamesOption();
                        echo '</select>
                    </fieldset>
                    </td>
                    <td>
                           <input type="number" class="form-control" id="receipt_eqty" placeholder="'. _uc($_e['Enter Existing Quantity']) .'" min="0">
                    </td>
                    <td>
                           <input type="number" class="form-control" id="receipt_nqty" placeholder="'. _uc($_e['Enter New Quantity']) .'" min="0">
                    </td>
                    <td>
                           <input type="text" class="form-control" id="receipt_econd" placeholder="'. _uc($_e['Enter Existing Condition']) .'">
                    </td>
                    <td>
                           <input type="text" class="form-control" placeholder="'. _uc($_e['Enter New Condition']) .'" id="receipt_ncond">
                           <!--<select class="form-control">
                           '.$this->SelectNewCondition().'
                           </select>-->
                    </td>

                </tbody>

                </table>
            </div>

                <div class="form-group">
                    <div class="col-sm-10">
                        <button type="button" onclick="receiptFormValid4();" id="AddProduct" class="btn btn-default">'. _uc($_e['Add Product']) .'</button>
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
                        <th>'. _u($_e['EXISTING QTY']) .'</th>
                        <th>'. _u($_e['NEW QTY']) .'</th>
                        <th>'. _u($_e['EXISTING CONDITION']) .'</th>
                        <th>'. _u($_e['NEW CONDITION']) .'</th>
                    </tr>
                </thead>
                <tbody id="vendorProdcutList">';
                if($isEdit){
                foreach ($data2 as $key => $value) {
                $trpid = "p_".$value['receipt_product_id']."-"."-".$value['receipt_product_store'];
                $nqty   = $value['receipt_product_nqty'];
                $pid   = $value['receipt_product_id'];
                $store = $value['receipt_product_store'];
                $eqty = $value['receipt_product_eqty'];
                $econd = $value['receipt_product_ec'];
                $ncond = $value['receipt_product_nc'];
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
                                $eqty<input type='hidden' name='peqty_$trpid' value='$eqty' />
                            </td>
                            <td>
                                $nqty<input type='hidden' name='pnqty_$trpid' value='$nqty' />
                            </td>
                            <td>
                                $econd<input type='hidden' name='pecond_$trpid' value='$econd' />
                            </td>
                            <td>
                                $ncond<input type='hidden' name='pncond_$trpid' value='$ncond' />
                            </td>
                          </tr>";
                }}
                echo'</tbody>
                </table>
            </div>

            <br>
				    <button type="submit" onclick="return formSubmit();" name="submit" value="Generate Inventory Adjustment Note" class="submit btn btn-primary btn-lg pull-right">'. _uc($_e['Generate Inventory Adjustment Note']) .'</button>

         </div> <!-- add product script div end -->
       </form>';

    }


    public function receiptList4(){
        global $_e;
        $this->functions->dataTableDateRange();
        echo '
            <div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                    <th>'. _u($_e['SNO']) .'</th>
                    <th>IAN</th>
                    <th>DOCMENTS</th>
                    <th>'. _u($_e['DATE']) .'</th>
                    <th>'. _u($_e['INSPECTED BY']) .'</th>
                    <th>DESCRIPTION</th>
                    <th>NOTE</th>
                    <th>'. _u($_e['REASON']) .'</th>
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
            $fl = "";
            $id=$val['receipt_pk'];
            $lnk = $this->dbF->getRows("SELECT image FROM `ian_image` WHERE receipt_id='$val[receipt_pk]'");
            foreach ($lnk as $value) {
                $fl .= "<a href='".WEB_URL."/images/$value[image]' target='_blank'>Download</a><br>";
            }
            
            // $storeName =$this->StoreNameSQL($val['store']);
            $receiptDate = date('Y-m-d',strtotime($val['receipt_date']));
            echo "<tr class='tr_$id'>
                    <td>$i</td>
                    <td>$val[ian]</td>
                    <td>$fl</td>
                    <td>$receiptDate</td>
                    <td>$val[inspected_by]</td>
                    <td>$val[description]</td>
                    <td>$val[note]</td>
                    <td>$val[reason]</td>
                    <td>$val[dateTime]</td>
                    <td> <div class='btn-group btn-group-sm'>
                        <a data-id='$id'  data-target='#ViewReceiptModal' class='btn receiptEdit'><i class='glyphicon glyphicon-list-alt'></i></a>
                        <a data-id='$id' onclick='AjaxDelScript(this);' class='btn'>
                                 <i class='glyphicon glyphicon-trash trash'></i>
                                 <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                         </a>
                        <a href='stock/printinventoryadjustmentnote.php?id=$id' target='_blank' class='btn'><i class='glyphicon glyphicon-print'></i>
                        </a>
                         </div>
                    </td>
                </tr>";
        }

        echo '</tbody>
            </table>
          </div><!-- .table-responsive End -->';
        $this->productF->AjaxDelScript('receiptAjax_del','receipt');

    }

    // my code
    public function receiptListDraft4(){
        global $_e;
        // $this->functions->dataTableDateRange();
        echo '
            <div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                    <th>'. _u($_e['SNO']) .'</th>
                    <th>IAN</th>
                    <th>DOCMENTS</th>
                    <th>'. _u($_e['DATE']) .'</th>
                    <th>'. _u($_e['INSPECTED BY']) .'</th>
                    <th>DESCRIPTION</th>
                    <th>NOTE</th>
                    <th>'. _u($_e['REASON']) .'</th>
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
            $fl = "";
            $id=$val['receipt_pk'];
            $lnk = $this->dbF->getRows("SELECT image FROM `ian_image` WHERE receipt_id='$val[receipt_pk]'");
            foreach ($lnk as $value) {
                $fl .= "<a href='".WEB_URL."/images/$value[image]' target='_blank'>Download</a><br>";
            }
            // $storeName =$this->StoreNameSQL($val['store']);
            $receiptDate = date('Y-m-d',strtotime($val['receipt_date']));
            echo "<tr class='tr_$id'>
                    <td>$i</td>
                    <td>$val[ian]</td>
                    <td>$fl</td>
                    <td>$receiptDate</td>
                    <td>$val[inspected_by]</td>
                    <td>$val[description]</td>
                    <td>$val[note]</td>
                    <td>$val[reason]</td>
                    <td>$val[dateTime]</td>
                    <td> <div class='btn-group btn-group-sm'>
                        <a data-id='$id'  data-target='#ViewReceiptModal' class='btn receiptEdit2'><i class='glyphicon glyphicon-list-alt'></i></a>
                        ";
                        if($this->btn()=="1")
                        {
                         echo "
                         <a data-id='$id' onclick='AjaxUpdateScript2_d(this);' class='btn'>
                                 <i class='glyphicon glyphicon-thumbs-up'></i>
                                 <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                         </a>";
                        }
                         echo "<a data-id='$id' class='btn' href='-stock?page=ianEdit&id=$id'>
                                 <i class='glyphicon glyphicon-edit'></i>
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
        $this->productF->AjaxDelScript('receiptAjax_del_ian','receipt');
        $this->productF->AjaxUpdateScript2_d('receiptAjax_update_ian_d','receipt');

    }
    public function receiptListInitiated4(){
        global $_e;
        // $this->functions->dataTableDateRange();
        echo '
            <div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                    <th>'. _u($_e['SNO']) .'</th>
                    <th>IAN</th>
                    <th>DOCMENTS</th>
                    <th>'. _u($_e['DATE']) .'</th>
                    <th>'. _u($_e['INSPECTED BY']) .'</th>
                    <th>DESCRIPTION</th>
                    <th>NOTE</th>
                    <th>'. _u($_e['REASON']) .'</th>
                    <th>'. _u($_e['REGISTER DATE']) .'</th>
                    <th>'. _u($_e['ACTION']) .'</th>
                    </thead>
                <tbody>

                ';
        $purchase_receipt=$this->receiptPurchaseSQL("*",'initiated');
        $data=$this->receiptStoreSQL("*");
        $i=0;
        foreach($purchase_receipt as $val){
             $i++;
            $fl = "";
            $id=$val['receipt_pk'];
            $lnk = $this->dbF->getRows("SELECT image FROM `ian_image` WHERE receipt_id='$val[receipt_pk]'");
            foreach ($lnk as $value) {
                $fl .= "<a href='".WEB_URL."/images/$value[image]' target='_blank'>Download</a><br>";
            }
            // $storeName =$this->StoreNameSQL($val['store']);
            $receiptDate = date('Y-m-d',strtotime($val['receipt_date']));
            echo "<tr class='tr_$id'>
                    <td>$i</td>
                    <td>$val[ian]</td>
                    <td>$fl</td>
                    <td>$receiptDate</td>
                    <td>$val[inspected_by]</td>
                    <td>$val[description]</td>
                    <td>$val[note]</td>
                    <td>$val[reason]</td>
                    <td>$val[dateTime]</td>
                    <td> <div class='btn-group btn-group-sm'>
                        <a data-id='$id'  data-target='#ViewReceiptModal' class='btn receiptEdit3'><i class='glyphicon glyphicon-list-alt'></i></a>";
                        if($this->btn()=="1")
                        {
                         echo "
                         <a data-id='$id' onclick='AjaxUpdateScript2(this);' class='btn'>
                                 <i class='glyphicon glyphicon-thumbs-up'></i>
                                 <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                         </a>";
                        }
                         echo "<a data-id='$id' class='btn' href='-stock?page=ianEdit&id=$id'>
                                 <i class='glyphicon glyphicon-edit'></i>
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
        $this->productF->AjaxDelScript('receiptAjax_del_ian','receipt');
        $this->productF->AjaxUpdateScript2('receiptAjax_update_ian','receipt');

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

     function SelectReason(){
        $sql    =   "SELECT setting_val FROM `ibms_setting` WHERE setting_name='Reason'";
        $data   =   $this->dbF->getRow($sql);
        $op='';
        $pos= $data[0];
        $array=explode(",",$pos);
        foreach($array as $key => $value){
            $op .="<option value='$value'>$value</option>";
        }
        return $op;
    }

    function SelectNewCondition(){
        $sql    =   "SELECT setting_val FROM `ibms_setting` WHERE setting_name='ncond'";
        $data   =   $this->dbF->getRow($sql);
        $op='';
        $pos= $data[0];
        $array=explode(",",$pos);
        foreach($array as $key => $value){
            $op .="<option value='$value'>$value</option>";
        }
        return $op;
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
        $sql="SELECT ".$column." FROM `purchase_receipt_ian` where `publish`='$publish' ORDER BY `receipt_pk` DESC";
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



    public function receiptAdd4(){
        global $_e;
        if(!$this->functions->getFormToken('purchaseReceiptAdd')){
            return false;
        }

        if(!empty($_POST) && !empty($_POST['submit']) && !empty($_POST['cart_list'])){
         //$this->dbF->prnt($_POST);
            $sql="INSERT INTO `purchase_receipt_ian`(`receipt_date`, `ian`, `inspected_by`, `reason`, `description`, `note` , `publish`) VALUES (?,?,?,?,?,?,?)";
            $arry= array($_POST['receipt_date'],$this->IAN(),$_POST['receipt_inspectedby'],$_POST['receipt_reason'],$_POST['receipt_description'],$_POST['receipt_note'],$_POST['receipt_publish']);
            @$store=$_POST['receipt_store_id'];
            $this->dbF->setRow($sql,$arry);
            $lastId= $this->dbF->rowLastId;
            $i=0;
            foreach($_POST['cart_list'] as $itemId){
               $id=$itemId;
                $i++;

                $temp="pid_".$id;
                $pid=abs($_POST[$temp]);

                // $temp="pscale_".$id;
                // @$pscale=abs($_POST[$temp]);

                $temp="pstore_".$id;
                @$pstore=abs($_POST[$temp]);

                $temp="peqty_".$id;
                @$peqty=abs($_POST[$temp]);

                $temp="pnqty_".$id;
                @$pnqty=abs($_POST[$temp]);

                $temp="pecond_".$id;
                @$pecond=$_POST[$temp];

                $temp="pncond_".$id;
                @$pncond=$_POST[$temp];

                @$hashVal=$pid.":".$pstore;
                $hash = md5($hashVal);

                $qry_order="INSERT INTO `purchase_receipt_pro_ian`(
                            `receipt_id`,
                            `receipt_product_id`,
                            `receipt_product_store`,
                            `receipt_product_ec`,
                            `receipt_product_nc`,
                            `receipt_product_eqty`,
                            `receipt_product_nqty`,
                            `receipt_hash`
                            ) VALUES (?,?,?,?,?,?,?,?)";
                $arry=array($lastId,$pid,$pstore,$pecond,$pncond,$peqty,$pnqty,$hash);
                $this->dbF->setRow($qry_order,$arry);

                if($_POST['receipt_publish']=='publish'){ 
                   $temp="pnqty_".$id;
                   @$qty=$_POST[$temp];

                   $sqlCheck="SELECT `product_store_hash` FROM `product_inventory` WHERE `product_store_hash` = '$hash'";
                   $this->dbF->getRow($sqlCheck);

                   if($this->dbF->rowCount>0){
                       $sql="UPDATE `product_inventory` SET `qty_item` = $qty WHERE `qty_product_id`='$pid' AND `qty_store_id`='$pstore' AND `qty_product_color`='$pstore'";
                       $this->dbF->setRow($sql);
                   }
                   else{
                        $sql3= "INSERT INTO `product_inventory`(
                                                    `qty_store_id`,
                                                    `qty_product_id`,
                                                    `qty_product_color`,
                                                    `qty_item`,
                                                    `product_store_hash`
                                                ) VALUES(?,?,?,?,?)";
                        $arry=array($pstore,$pid,$pstore,$pnqty,$hash);
                        $this->dbF->setRow($sql3,$arry);
                   }

                   $sql = "SELECT receipt_pk FROM `purchase_receipt_ian` ORDER BY receipt_pk DESC LIMIT 1";
                   $data= $this->dbF->getRow($sql);

                   $nme = $_SESSION['_name'];
                   $id = $data[0];
                   $sql = "UPDATE `purchase_receipt_ian` SET `approved_by`='$nme'
                   WHERE receipt_pk='$id'";
                   $this->dbF->setRow($sql);
               }

            } // foreach

            $desc= "New Inventory Adjustment Note Created";
            $desc .= "<pre>Reason:$_POST[receipt_reason]</pre>";
            $desc .= "<pre>Inspected By:$_POST[receipt_inspectedby]</pre>";
            $desc .= "<pre>Date:$_POST[receipt_date]</pre>";
            $desc .= "<pre>Description:$_POST[receipt_description]</pre>";
            $desc .= "<pre>Note:$_POST[receipt_note]</pre>";
            if($this->dbF->rowCount>0){
                $this->functions->setlog('Inventory Adjustment Note',$_POST['receipt_ian'],$lastId,$desc);
                $this->functions->notificationError(_js(_uc($_e["New Receipt"])),_js(_uc($_e["New Receipt Generate Successfully"])),'btn-success');
            }else{
                $this->functions->notificationError(_js(_uc($_e["New Receipt"])),_js(_uc($_e["New Receipt Generate Failed"])),'btn-danger');
            }

        } // if end
    }


    public function receiptEdit4(){
        global $_e;
        if(!$this->functions->getFormToken('purchaseReceiptEdit')){
            return false;
        }
        $oldId = $_POST['oldId'];
        $sql = "UPDATE `purchase_receipt_ian` SET 
                `receipt_date`  = '$_POST[receipt_date]',
                `inspected_by`  = '$_POST[receipt_inspectedby]',
                `approved_by`   = '$_SESSION[_name]',
                `reason`        = '$_POST[receipt_reason]',
                `description`   = '$_POST[receipt_description]',
                `note`          = '$_POST[receipt_note]',
                `publish`       = '$_POST[receipt_publish]'
                WHERE `receipt_pk` = '$oldId'";
        $this->dbF->setRow($sql);
        $this->dbF->setRow("DELETE FROM `purchase_receipt_pro_ian` WHERE `receipt_id`='$oldId'");
        @$store=$_POST['receipt_store_id'];
        $i=0;
        foreach($_POST['cart_list'] as $itemId){
                $id=$itemId;
                $i++;

                $temp="pid_".$id;
                $pid=abs($_POST[$temp]);

                $temp="pstore_".$id;
                @$pstore=abs($_POST[$temp]);

                $temp="peqty_".$id;
                @$peqty=abs($_POST[$temp]);

                $temp="pnqty_".$id;
                @$pnqty=abs($_POST[$temp]);

                $temp="pecond_".$id;
                @$pecond=$_POST[$temp];

                $temp="pncond_".$id;
                @$pncond=$_POST[$temp];

                @$hashVal=$pid.":".$pstore;
                $hash = md5($hashVal);

                $qry_order="INSERT INTO `purchase_receipt_pro_ian`(
                            `receipt_id`,
                            `receipt_product_id`,
                            `receipt_product_store`,
                            `receipt_product_ec`,
                            `receipt_product_nc`,
                            `receipt_product_eqty`,
                            `receipt_product_nqty`,
                            `receipt_hash`
                            ) VALUES (?,?,?,?,?,?,?,?)";
                $arry=array($oldId,$pid,$pstore,$pecond,$pncond,$peqty,$pnqty,$hash);
                $this->dbF->setRow($qry_order,$arry);
                
                if($_POST['receipt_publish']=='publish'){ 
                   $temp="pnqty_".$id;
                   @$qty=$_POST[$temp];
                   $sql="UPDATE `product_inventory` SET `qty_item` = $qty WHERE `qty_product_id`='$pid' AND `qty_store_id`='$pstore'";
                   $this->dbF->setRow($sql);
                   $nme = $_SESSION['_name'];
                   $sql = "SELECT receipt_pk FROM `purchase_receipt_ian` ORDER BY receipt_pk DESC LIMIT 1";
                   $data= $this->dbF->getRow($sql);
                   $id = $data[0];
                   $sql = "UPDATE `purchase_receipt_ian` SET `approved_by`='$nme'
                   WHERE receipt_pk='$id'";
                   $this->dbF->setRow($sql);
               }

            } // foreach

            $desc="Inventory Adjustment Note Update";
            $desc .= "<pre>Reason:$_POST[receipt_reason]</pre>";
            $desc .= "<pre>Inspected By:$_POST[receipt_inspectedby]</pre>";
            $desc .= "<pre>Date:$_POST[receipt_date]</pre>";
            $desc .= "<pre>Description:$_POST[receipt_description]</pre>";
            $desc .= "<pre>Note:$_POST[receipt_note]</pre>";
            if($this->dbF->rowCount>0){
                $this->functions->setlog('Inventory Adjustment Note',$_POST['receipt_ian'],$oldId,$desc);
                $this->functions->notificationError(_js(_uc("Receipt")),_js(_uc("Receipt Update Successfully")),'btn-success');
            }else{
                $this->functions->notificationError(_js(_uc("Receipt")),_js(_uc("Receipt Update Failed")),'btn-danger');
            }
    }


}

?>