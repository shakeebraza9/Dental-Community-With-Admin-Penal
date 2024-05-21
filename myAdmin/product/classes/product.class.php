<?php

require_once(__DIR__ . "/../../product_management/classes/currency.class.php");

require_once(__DIR__ . "/../../product_management/classes/scale.class.php");

require_once(__DIR__ . "/../../product_management/classes/color.class.php");



class product extends object_class

{

    use global_setting;

    public $productF;



    public $c_scale;

    public $c_color;

    public $c_currency;



    public $pid;

    public $editPid;



    public $prefix_language = "lang";



    public $prefix_productBasicInformation = "pinfo";

    public $prefix_productCategory = "cats";



    public $prefix_scaleCheckBox = "scale_checkList";

    public $prefix_scaleName = "name_scale";

    public $prefix_scaleCost = "scaleAddCost";



    public $prefix_colorCheckBox = "color_checkList";

    public $prefix_colorName = "name_color";

    public $prefix_colorCost = "colorAddCost";



    public $prefix_setting = "setting";



    public $prefix_currencyArray = "curlist";



    public $prefix_addCostCheckBox = "addCost_checkList";

    public $prefix_addCostName = "addCost_name";

    public $prefix_addCostCost = "addCost_cost";



    public $prefix_editPro = "edit_pro"; // asad



    function __construct()

    {

        parent::__construct();



        if (isset($GLOBALS['productF'])) $this->productF = $GLOBALS['productF'];

        else {

            require_once(__DIR__."/../../product_management/functions/product_function.php");

            $this->productF=new product_function();

        }



        // $con = $GLOBALS['orcl_conn'];



        $this->c_color = new colors();

        $this->c_scale = new scales();

        $this->c_currency = new currency_management();

        $this->additionalCost_name();



        // $sqlTest = "SELECT * FROM `accounts`";

        // $res = $con->getRows($sqlTest);

        // $this->dbF->prnt($res);

        // exit;



        /**

         * MultiLanguage keys Use where echo;

         * define this class words and where this class will call

         * and define words of file where this class will called

         **/

        global $_e;

        global $adminPanelLanguage;

        $_w['Sort Products'] = '' ;

        $_w['Select Product Category'] = '' ;

        $_w['There is an error, Please Refresh Page and Try Again'] = '' ;

        $_w['Product Update'] = '' ;

        $_w['Product Add'] = '' ;

        $_w['Your Product Update Successfully'] = '' ;

        $_w['Your New Product Add Successfully'] = '' ;

        $_w['Your Product Update Fail'] = '' ;

        $_w['Free Gift Product'] = '' ;

        $_w['When this product exist in cart then which free gift add in cart, please select'] = '' ;

        $_w['Mass Update'] = '' ;
        $_w['SERIAL NUMBER'] = '' ;

        //This class

        $_w['Country (Currency)'] = '' ;

        $_w['Price'] = '' ;

        $_w['International Shipping'] = '' ;

        $_w['Price/Percent'] = '' ;

        $_w['Discount'] = '' ;

        $_w['Size Name'] = '' ;

        $_w['Weight In KG'] = '' ;

        $_w['Add More Weight'] = '' ;

        $_w['Select Scale Group'] = '' ;

        $_w['Select Color Group'] = '' ;

        $_w['SNO'] = '' ;

        $_w['PRODUCT NAME'] = '' ;

        $_w['SHORT DESC'] = '' ;

        $_w['CREATE DATE'] = '' ;

        $_w['ACTION'] = '' ;

        $_w['Enter Alt'] = '' ;

        $_w['Update'] = '' ;

        $_w['Remove'] = '' ;

        $_w['Additional Saved Charges'] = '' ;

        $_w['Name'] = '' ;

        $_w['Active/DeActive Feature item'] = '' ;

        $_w['Active/DeActive Feature item2'] = '' ;

        $_w['Are you sure you want to {{state}} Feature Product?'] = '' ;

        $_w['Update Fail Please Try Again.'] = '' ;

        $_w['Active'] = '' ;

        $_w['DeActive'] = '' ;

        $_w['Are you sure you want to {{state}} Feature Item 2?'] = '' ;

        $_w['Charges On Offers'] = '' ;

        $_w['VIEWS'] = '' ;

        $_w['SALES'] = '' ;



        $_w['By Weight'] = '' ;

        $_w['Shipping Class'] = '' ;

        $_w['SALES'] = '' ;

        $_w['SELECT'] = '' ;

        $_w['PRODUCT THUMBNAIL'] = '' ;

        $_w['Please select categories and products both, It is mandatory'] = '' ;

        $_w['Product Category'] = '' ;

        $_w['Do not forget'] = '' ;

        $_w['Do Not Forget To Buy Products'] = '' ;

        $_w['Missing Products'] = '' ;

        $_w['Missing'] = '' ;

        $_w['Missing Products Copied Successfully.'] = '' ;

        $_w[''] = '' ;

        $_w[''] = '' ;

        $_w[''] = '' ;

        $_w[''] = '' ;

        $_w[''] = '' ;

        $_w[''] = '' ;

        $_w[''] = '' ;
        $_w['SKU'] = '' ;
        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin Product Class');


   
    }



public function SKU(){
        $sku = $this->functions->ibms_setting('SKU');
        $sql="SELECT setting_val FROM `product_setting` WHERE setting_name='SKU' ORDER BY set_id DESC LIMIT 1";
        $data  =  $this->dbF->getRow($sql);
        $numb= $data[0];
        $numb = preg_replace('/\D/', '', $numb);
        @$numb = $numb + 1;
       
        if($data[0] === null){
        return "$sku"."1";
        }
        else{
        return "$sku".$numb;   
        }
}




    /*

     * Insert new data on open add product,, this do for upload images by ajax

     *

     * */

public function firstInsert(){

        global $con;
    global $conIntra;
   


    $date=date('Y-m-d');

    try{

        $this->db->beginTransaction();

        $sqlD="SELECT * FROM `proudct_detail`  WHERE `product_update` ='0'

                AND `prodet_timeStamp`<'$date'";

        // PENDING increase time to delete not submit product

        // delete old products...

          $dataDel=$this->dbF->getRows($sqlD,false);



          foreach($dataDel as $key=>$val){

              $id=$val['prodet_id'];



              $sql3="SELECT * FROM `product_image` WHERE `product_id`='$id'";

              $data=$this->dbF->getRows($sql3,false);

              foreach($data as $key=>$val){

                  $this->functions->deleteOldSingleImage($val['image']);

                  //unlink(__DIR__."/../../../images/$val[image]");

              }

              $sql3="DELETE FROM `product_image` WHERE `product_id`='$id'";

              $this->dbF->setRow($sql3,false);



              $sql3="DELETE FROM `proudct_detail` WHERE `prodet_id`='$id'";

              $this->dbF->setRow($sql3);

        }



        $migrate_products = $this->functions->ibms_setting('migrate_product_to_ch');


        $migrate_product_to_intranet = $this->functions->ibms_setting('migrate_product_to_intranet');

        if(!empty($migrate_products) && $migrate_products == 1){



            $dataDelNew=$con->getRows($sqlD,false);



            foreach($dataDelNew as $key=>$val){

                $id=$val['prodet_id'];



                $sql3="SELECT * FROM `product_image` WHERE `product_id`='$id'";

                $data=$con->getRows($sql3,false);

                foreach($data as $key=>$val){

                    $this->functions->deleteOldSingleImage($val['image']);

                    //unlink(__DIR__."/../../../images/$val[image]");

                }

                $sql3="DELETE FROM `product_image` WHERE `product_id`='$id'";

                $con->setRow($sql3,false);



                $sql3="DELETE FROM `proudct_detail` WHERE `prodet_id`='$id'";

                $con->setRow($sql3);

            }

        }






        if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){



            $dataDelNew=$conIntra->getRows($sqlD,false);



            foreach($dataDelNew as $key=>$val){

                $id=$val['prodet_id'];



                $sql3="SELECT * FROM `product_image` WHERE `product_id`='$id'";

                $data=$conIntra->getRows($sql3,false);

                foreach($data as $key=>$val){

                    $this->functions->deleteOldSingleImage($val['image']);

                    //unlink(__DIR__."/../../../images/$val[image]");

                }

                $sql3="DELETE FROM `product_image` WHERE `product_id`='$id'";

                $conIntra->setRow($sql3,false);



                $sql3="DELETE FROM `proudct_detail` WHERE `prodet_id`='$id'";

                $conIntra->setRow($sql3);

            }

        }





        $this->db->commit();

    }catch(Exception $e){

        $this->db->rollBack();

        $this->dbF->error_submit($e);

    }



        $sql        =   "INSERT INTO `proudct_detail` (`product_update`) VALUES ('0')";

        $lastId     =   $this->dbF->setRow($sql);

        $this->pid  =   $lastId;



        if(!empty($migrate_products) && $migrate_products == 1){

            $new_id = "ss".$lastId;

            $sql_ch = "INSERT INTO `proudct_detail`(`prodet_id`, `product_update`) VALUES ('$new_id','0')";

            $res     =   $con->setRow($sql_ch);

            $this->pidch  =   $new_id;

        }



 if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){

            // $new_id = "ss".$lastId;


            $new_id = $lastId;

            $sql_ch = "INSERT INTO `proudct_detail`(`prodet_id`, `product_update`) VALUES ('$new_id','0')";

            $res     =   $conIntra->setRow($sql_ch);

            $this->pidch  =   $new_id;

        }


        // echo $lastIdch;

        // $this->dbF->prnt($new_id);

        // exit;

        //update slug id

        //$sql        =   "UPDATE `proudct_detail` set slug='$lastId' WHERE prodet_id = '$lastId'";

        //$this->dbF->setRow($sql);







}



    public function editProductInformation(){

       if(isset($_POST[$this->prefix_editPro])){

        

           $this->editPid=$_POST[$this->prefix_editPro];

           $this->pid = $_POST[$this->prefix_editPro];

        }

       //  $this->editPid="491";

      //  $this->pid="491";

    }





    /**

     * @param $id

     * Add Product into database!

     * Get/Set Function for individual section.

     */
    ///////Sku Function/////////////
public function log_detail($value,$id){
         $sql="SELECT setting_val FROM `product_setting` WHERE setting_name='$value' AND p_id='$id'";
         $data = $this->dbF->getRow($sql);   
         return @$data[0];
    }
    private function editProductDelOld($id){

            global $con;
    global $conIntra;



        $sql="DELETE  FROM  `product_color` WHERE  `proclr_prodet_id` = '$id'";

        $this->dbF->setRow($sql);

        $sql="";



        $sql="DELETE FROM  `product_addcost` WHERE  `proadc_prodet_id` = '$id'";

        $this->dbF->setRow($sql);

        $sql="";



        $sql="DELETE FROM  `product_size` WHERE  `prosiz_prodet_id` = '$id'";

        $this->dbF->setRow($sql);

        $sql="";



        $sql="DELETE FROM  `product_setting` WHERE  `p_id` = '$id'";

        $this->dbF->setRow($sql);

        $sql="";



        $sql="DELETE FROM  `product_price` WHERE  `propri_prodet_id` = '$id'";

        $this->dbF->setRow($sql);

        $sql="";



        $sql="DELETE FROM  `product_category` WHERE  `procat_prodet_id` = '$id'";

        $this->dbF->setRow($sql);

        $sql="";



        $sql="DELETE FROM `product_size_weight` WHERE `pwPId` = '$id'";

        $this->dbF->setRow($sql);

        $sql="";



        $sql="DELETE FROM product_size_custom WHERE `pId` = '$id'";

        $this->dbF->setRow($sql);

        $sql="";




     $migrate_product_to_intranet = $this->functions->ibms_setting('migrate_product_to_intranet');



        if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){



            // $new_id = 'ss'.$id;
            $new_id = $id;



            $sql="DELETE FROM  `product_size` WHERE  `prosiz_prodet_id` = '$new_id'";

            $conIntra->setRow($sql);

            $sql="";



            $sql="DELETE FROM  `product_setting` WHERE  `p_id` = '$new_id'";

            $conIntra->setRow($sql);

            $sql="";



            $sql = "SELECT `pro_lock` FROM `proudct_detail` WHERE `prodet_id` = '$new_id' ";

            $res_lock = $conIntra->getRow($sql);

            if($res_lock['pro_lock'] == 0){

                $sql="DELETE FROM `product_price` WHERE `propri_prodet_id` = '$new_id'";

                $conIntra->setRow($sql);

                $sql="";

            }



            $sql="DELETE FROM  `product_category` WHERE  `procat_prodet_id` = '$new_id'";

            $conIntra->setRow($sql);

            $sql="";



            $sql="DELETE FROM `product_size_weight` WHERE `pwPId` = '$new_id'";

            $conIntra->setRow($sql);

            $sql="";



            $sql="DELETE  FROM  `product_color` WHERE  `proclr_prodet_id` = '$new_id'";

            $conIntra->setRow($sql);

            $sql="";



            $sql="DELETE FROM `product_size_custom` WHERE `pId` = '$new_id'";

            $conIntra->setRow($sql);



            $sql="DELETE FROM  `product_addcost` WHERE  `proadc_prodet_id` = '$new_id'";

            $conIntra->setRow($sql);

            $sql="";

        }




        $migrate_products = $this->functions->ibms_setting('migrate_product_to_ch');



        if(!empty($migrate_products) && $migrate_products == 1){



            $new_id = 'ss'.$id;



            $sql="DELETE FROM  `product_size` WHERE  `prosiz_prodet_id` = '$new_id'";

            $con->setRow($sql);

            $sql="";



            $sql="DELETE FROM  `product_setting` WHERE  `p_id` = '$new_id'";

            $con->setRow($sql);

            $sql="";



            $sql = "SELECT `pro_lock` FROM `proudct_detail` WHERE `prodet_id` = '$new_id' ";

            $res_lock = $con->getRow($sql);

            if($res_lock['pro_lock'] == 0){

                $sql="DELETE FROM `product_price` WHERE `propri_prodet_id` = '$new_id'";

                $con->setRow($sql);

                $sql="";

            }



            $sql="DELETE FROM  `product_category` WHERE  `procat_prodet_id` = '$new_id'";

            $con->setRow($sql);

            $sql="";



            $sql="DELETE FROM `product_size_weight` WHERE `pwPId` = '$new_id'";

            $con->setRow($sql);

            $sql="";



            $sql="DELETE  FROM  `product_color` WHERE  `proclr_prodet_id` = '$new_id'";

            $con->setRow($sql);

            $sql="";



            $sql="DELETE FROM `product_size_custom` WHERE `pId` = '$new_id'";

            $con->setRow($sql);



            $sql="DELETE FROM  `product_addcost` WHERE  `proadc_prodet_id` = '$new_id'";

            $con->setRow($sql);

            $sql="";

        }







        $migrate_product_to_intranet = $this->functions->ibms_setting('migrate_product_to_intranet');



        if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){



            // $new_id = 'ss'.$id;
            $new_id = $id;



            $sql="DELETE FROM  `product_size` WHERE  `prosiz_prodet_id` = '$new_id'";

            $conIntra->setRow($sql);

            $sql="";



            $sql="DELETE FROM  `product_setting` WHERE  `p_id` = '$new_id'";

            $conIntra->setRow($sql);

            $sql="";



            $sql = "SELECT `pro_lock` FROM `proudct_detail` WHERE `prodet_id` = '$new_id' ";

            $res_lock = $conIntra->getRow($sql);

            if($res_lock['pro_lock'] == 0){

                $sql="DELETE FROM `product_price` WHERE `propri_prodet_id` = '$new_id'";

                $conIntra->setRow($sql);

                $sql="";

            }



            $sql="DELETE FROM  `product_category` WHERE  `procat_prodet_id` = '$new_id'";

            $conIntra->setRow($sql);

            $sql="";



            $sql="DELETE FROM `product_size_weight` WHERE `pwPId` = '$new_id'";

            $conIntra->setRow($sql);

            $sql="";



            $sql="DELETE  FROM  `product_color` WHERE  `proclr_prodet_id` = '$new_id'";

            $conIntra->setRow($sql);

            $sql="";



            $sql="DELETE FROM `product_size_custom` WHERE `pId` = '$new_id'";

            $conIntra->setRow($sql);



            $sql="DELETE FROM  `product_addcost` WHERE  `proadc_prodet_id` = '$new_id'";

            $conIntra->setRow($sql);

            $sql="";

        }

    }



    public function addProductInformation()

    {

        global $_e;

        if(!$this->functions->getFormToken('edit_pro')){return false;}





        if (isset($_POST) && !empty($_POST) && isset($_POST['ProductNewId']) && !empty($_POST['ProductNewId']) )

        {

            

            $this->db->beginTransaction();

            $isEdit=false;

            if(isset($_POST['editProduct']) && $_POST['editProduct']!="" && !isset($_POST['copy'])){

                $this->editProductDelOld($_POST['editProduct']);

                $isEdit=true;

            }



            if(isset($_POST['copy']) && $_POST['copy'] == true){

                $isEdit = true;

            }



            $this->pid=$_POST['ProductNewId'];

            $lang=explode(",",$_POST['lang']);



            $pinfo = $this->getset_proInformation($lang);



          //  echo "<pre>info:" . (($pinfo) ? "ok" : "not") . "</pre>";



            if ($pinfo === true && $this->pid > 0) {



                $desc = "Setting Product Additional Information Prodcut ID : ".$this->pid;

                $status = $this->getset_categoryList1();

                $s = "<pre> cat:" . (($status) ? "ok" : "not") . "</pre>";

                $desc .= $s;

           //     echo $s;
   
   
     
                $status = $this->getset_currency();

                $s = "<pre> currency:" . (($status) ? "ok" : "not") . "</pre>";

                $desc .= $s;

            //    echo $s;

         

                $status = $this->getset_additionalCost();

                $s = "<pre> additional charges:" . (($status) ? "ok: $status item inserted!" : "not") . "</pre>";

                $desc .= $s;

           //     echo $s;
               


                if($isEdit)

                    $status = $this->getsetEdit_scales();

                    else

                        $status = $this->getset_scales();

                $scale_status = $status;

                $s = "<pre> scale charges:" . (($status) ? "ok: $status item inserted!" : "not") . "</pre>";

                if($status!=false){

                    //work For submit Size Weight

                    $this->set_scales_weight();

                }

                $desc .= $s;

            //     echo $s;

                $custom = $this->customScaleSubmit();

                $s = "<pre> scale charges:" . (($status) ? "ok: $status item inserted!" : "not") . "</pre>";

                if($status!=false){

                    //work For submit Size Weight

                    $this->set_scales_weight();

                }

                $desc .= $s;



           //     echo $s;

                if($isEdit){

                    $status = $this->getsetEdit_colors();}

                else{

                    $status = $this->getset_colors();}

                $color_status = $status;

                $s = "<pre> color charges:" . (($status) ? "ok: $status item inserted!" : "not") . "</pre>";

                $desc .= $s;

            //    echo $s;

                $status = $this->getset_setting();

                $s = "<pre> Product Setting:" . (($status) ? "ok: $status item inserted!" : "not") . "</pre>";

                $desc .= $s;

            //    echo $s;

                 $sku = $this->log_detail('sku',$this->pid);
                $this->functions->setlog("Item Add",$sku, $this->pid, $desc);


                $this->functions->setlog("added", "product", $this->pid, $desc);



                if($this->editPid != ""){

                    $this->functions->notificationError(_js($_e["Product Update"]),_js($_e["Your Product Update Successfully"]),"btn-success");

                }else{

                    $this->functions->notificationError(_js($_e["Product Add"]),_js($_e["Your New Product Add Successfully"]),"btn-success");

                }



                $this->db->commit();


// var_dump("expression");
// var_dump($isEdit);

              $freeGift = (int) @$_POST[$this->prefix_setting]["freeGift"];

           if( ($color_status || $scale_status) && $isEdit==false){

header("Location: -stock?page=quickAdd&pid=".$this->pid);

}




if( ($freeGift== '1') && $isEdit==false){
// var_dump("expressionsssssssssssssssss");
header("Location: -stock?page=quickAdd&pid=".$this->pid);


}

            }else{

                $this->functions->notificationError(_js($_e["Product Update"]),_js($_e["Your Product Update Fail"]."<br>".$this->dbF->rowException),"btn-danger");

                $this->db->rollBack();

            }





        }

    }



    private function customScaleSubmit(){

            global $con;
    global $conIntra;



        if(isset($_POST['custom'])){

            $pId = $this->pid;

            $new_pid = 'ss'.$pId;

            $val = $_POST['custom'];

            $migrate_products = $this->functions->ibms_setting('migrate_product_to_ch');
            $migrate_product_to_intranet = $this->functions->ibms_setting('migrate_product_to_intranet');

            $typeId     = empty($val['type_id']) ? "0" : $val['type_id'];

            $currency   = empty($val['currencyId']) ? array() : $val['currencyId'];

            $sql        = "INSERT INTO product_size_custom(type_id,pId,currencyId,price) VALUES";

            $sql_new        = "INSERT INTO product_size_custom(type_id,pId,currencyId,price) VALUES";

            $array = array();

            $new_array = array();

            foreach($currency as $key2=>$val2){

                $currencyId = $key2;

                $price = $val2;

                $sql   .= "(?,?,?,?),";

                $array[] = $typeId;

                $array[] = $pId;

                $array[] = $currencyId;

                $array[] = $price;





                if($key2 == '20' && !empty($migrate_products) && $migrate_products == 1){

                    $sek_price = doubleval($price);

                    $priceCalc = $this->functions->ibms_setting('priceCalc');
                    $priceCalc = unserialize($priceCalc);

                    $country_fr     = $priceCalc['country'][0];
                    $fr_divide      = $priceCalc['divide'][0];
                    $fr_multiply    = $priceCalc['multiply'][0];
                    $fr_price       = doubleval(($sek_price/$fr_divide)*$fr_multiply);
                    $fr_price       = ceil($fr_price);

                    $country_de     = $priceCalc['country'][1];
                    $de_divide      = $priceCalc['divide'][1];
                    $de_multiply    = $priceCalc['multiply'][1];
                    $de_price       = doubleval(($sek_price/$de_divide)*$de_multiply);
                    $de_price       = ceil($de_price);

                    $country_nl     = $priceCalc['country'][2];
                    $nl_divide      = $priceCalc['divide'][2];
                    $nl_multiply    = $priceCalc['multiply'][2];
                    $nl_price       = doubleval(($sek_price/$nl_divide)*$nl_multiply);
                    $nl_price       = ceil($nl_price);

                    $country_us     = $priceCalc['country'][3];
                    $us_divide      = $priceCalc['divide'][3];
                    $us_multiply    = $priceCalc['multiply'][3];
                    $us_price       = doubleval(($sek_price/$us_divide)*$us_multiply);
                    $us_price       = ceil($us_price);

                    $country_be     = $priceCalc['country'][4];
                    $be_divide      = $priceCalc['divide'][4];
                    $be_multiply    = $priceCalc['multiply'][4];
                    $be_price       = doubleval(($sek_price/$be_divide)*$be_multiply);
                    $be_price       = ceil($be_price);

                    $country_uk     = $priceCalc['country'][5];
                    $uk_divide      = $priceCalc['divide'][5];
                    $uk_multiply    = $priceCalc['multiply'][5];
                    $uk_price       = doubleval(($sek_price/$uk_divide)*$uk_multiply);
                    $uk_price       = ceil($uk_price);

                    $country_es     = $priceCalc['country'][6];
                    $es_divide      = $priceCalc['divide'][6];
                    $es_multiply    = $priceCalc['multiply'][6];
                    $es_price       = doubleval(($sek_price/$es_divide)*$es_multiply);
                    $es_price       = ceil($es_price);

                    $country_at     = $priceCalc['country'][7];
                    $at_divide      = $priceCalc['divide'][7];
                    $at_multiply    = $priceCalc['multiply'][7];
                    $at_price       = doubleval(($sek_price/$at_divide)*$at_multiply);
                    $at_price       = ceil($at_price);

                    $country_it     = $priceCalc['country'][8];
                    $it_divide      = $priceCalc['divide'][8];
                    $it_multiply    = $priceCalc['multiply'][8];
                    $it_price       = doubleval(($sek_price/$it_divide)*$it_multiply);
                    $it_price       = ceil($it_price);

                    $country_chf    = $priceCalc['country'][9];
                    $chf_divide     = $priceCalc['divide'][9];
                    $chf_multiply   = $priceCalc['multiply'][9];
                    $chf_price      = doubleval(($sek_price/$chf_divide)*$chf_multiply);
                    $chf_price      = ceil($chf_price);

                    $country_other    = $priceCalc['country'][10];
                    $other_divide     = $priceCalc['divide'][10];
                    $other_multiply   = $priceCalc['multiply'][10];
                    $other_price      = doubleval(($sek_price/$other_divide)*$other_multiply);
                    $other_price      = ceil($other_price);


                    $sql_new = "INSERT " . " INTO `product_size_custom`

                            ( `type_id`,`pId`,`currencyId`,`price`) VALUES 
                                ($typeId, '$new_pid', $country_chf, '$chf_price'),
                                ($typeId, '$new_pid', $country_fr, '$fr_price'),
                                ($typeId, '$new_pid', $country_de, '$de_price'),
                                ($typeId, '$new_pid', $country_nl, '$nl_price'),
                                ($typeId, '$new_pid', $country_us, '$us_price'),
                                ($typeId, '$new_pid', $country_be, '$be_price'),
                                ($typeId, '$new_pid', $country_uk, '$uk_price'),
                                ($typeId, '$new_pid', $country_es, '$es_price'),
                                ($typeId, '$new_pid', $country_at, '$at_price'),
                                ($typeId, '$new_pid', $country_it, '$it_price'),
                                ($typeId, '$new_pid', $country_other, '$other_price')
                            ";

                    $res = $con->setRow($sql_new);

                }





                if($key2 == '20' && !empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){
    $new_pid = $pId;
                    $sek_price = doubleval($price);

                    $priceCalc = $this->functions->ibms_setting('priceCalc');
                    $priceCalc = unserialize($priceCalc);

                    $country_fr     = $priceCalc['country'][0];
                    $fr_divide      = $priceCalc['divide'][0];
                    $fr_multiply    = $priceCalc['multiply'][0];
                    $fr_price       = doubleval(($sek_price/$fr_divide)*$fr_multiply);
                    $fr_price       = ceil($fr_price);

                    $country_de     = $priceCalc['country'][1];
                    $de_divide      = $priceCalc['divide'][1];
                    $de_multiply    = $priceCalc['multiply'][1];
                    $de_price       = doubleval(($sek_price/$de_divide)*$de_multiply);
                    $de_price       = ceil($de_price);

                    $country_nl     = $priceCalc['country'][2];
                    $nl_divide      = $priceCalc['divide'][2];
                    $nl_multiply    = $priceCalc['multiply'][2];
                    $nl_price       = doubleval(($sek_price/$nl_divide)*$nl_multiply);
                    $nl_price       = ceil($nl_price);

                    $country_us     = $priceCalc['country'][3];
                    $us_divide      = $priceCalc['divide'][3];
                    $us_multiply    = $priceCalc['multiply'][3];
                    $us_price       = doubleval(($sek_price/$us_divide)*$us_multiply);
                    $us_price       = ceil($us_price);

                    $country_be     = $priceCalc['country'][4];
                    $be_divide      = $priceCalc['divide'][4];
                    $be_multiply    = $priceCalc['multiply'][4];
                    $be_price       = doubleval(($sek_price/$be_divide)*$be_multiply);
                    $be_price       = ceil($be_price);

                    $country_uk     = $priceCalc['country'][5];
                    $uk_divide      = $priceCalc['divide'][5];
                    $uk_multiply    = $priceCalc['multiply'][5];
                    $uk_price       = doubleval(($sek_price/$uk_divide)*$uk_multiply);
                    $uk_price       = ceil($uk_price);

                    $country_es     = $priceCalc['country'][6];
                    $es_divide      = $priceCalc['divide'][6];
                    $es_multiply    = $priceCalc['multiply'][6];
                    $es_price       = doubleval(($sek_price/$es_divide)*$es_multiply);
                    $es_price       = ceil($es_price);

                    $country_at     = $priceCalc['country'][7];
                    $at_divide      = $priceCalc['divide'][7];
                    $at_multiply    = $priceCalc['multiply'][7];
                    $at_price       = doubleval(($sek_price/$at_divide)*$at_multiply);
                    $at_price       = ceil($at_price);

                    $country_it     = $priceCalc['country'][8];
                    $it_divide      = $priceCalc['divide'][8];
                    $it_multiply    = $priceCalc['multiply'][8];
                    $it_price       = doubleval(($sek_price/$it_divide)*$it_multiply);
                    $it_price       = ceil($it_price);

                    $country_chf    = $priceCalc['country'][9];
                    $chf_divide     = $priceCalc['divide'][9];
                    $chf_multiply   = $priceCalc['multiply'][9];
                    $chf_price      = doubleval(($sek_price/$chf_divide)*$chf_multiply);
                    $chf_price      = ceil($chf_price);

                    $country_other    = $priceCalc['country'][10];
                    $other_divide     = $priceCalc['divide'][10];
                    $other_multiply   = $priceCalc['multiply'][10];
                    $other_price      = doubleval(($sek_price/$other_divide)*$other_multiply);
                    $other_price      = ceil($other_price);


                    $sql_new = "INSERT " . " INTO `product_size_custom`

                            ( `type_id`,`pId`,`currencyId`,`price`) VALUES 
                                ($typeId, '$new_pid', $country_chf, '$chf_price'),
                                ($typeId, '$new_pid', $country_fr, '$fr_price'),
                                ($typeId, '$new_pid', $country_de, '$de_price'),
                                ($typeId, '$new_pid', $country_nl, '$nl_price'),
                                ($typeId, '$new_pid', $country_us, '$us_price'),
                                ($typeId, '$new_pid', $country_be, '$be_price'),
                                ($typeId, '$new_pid', $country_uk, '$uk_price'),
                                ($typeId, '$new_pid', $country_es, '$es_price'),
                                ($typeId, '$new_pid', $country_at, '$at_price'),
                                ($typeId, '$new_pid', $country_it, '$it_price'),
                                ($typeId, '$new_pid', $country_other, '$other_price')
                            ";

                    $res = $conIntra->setRow($sql_new);

                }



            }

            $sql   = trim($sql,",");


            if(!empty($array)){

                $this->dbF->setRow($sql,$array);

            }

        }

    }



    private function getset_additionalCost()

    {

            global $con;
    global $conIntra;

        if (isset($_POST[$this->prefix_addCostCheckBox]) && !empty($_POST[$this->prefix_addCostCheckBox])) {



            $pid = $this->pid;

            $newId = 'ss'.$pid;

            $val_array = array();

            $newArray = array();



            $sql = "INSERT " . " INTO `product_addcost`

                    ( `proadc_name`,`proadc_prodet_id`,

                      `proadc_cur_id`,`proadc_price`

                    ) VALUES ";

            $migrate_products = $this->functions->ibms_setting('migrate_product_to_ch');
            $migrate_product_to_intranet = $this->functions->ibms_setting('migrate_product_to_intranet');

            foreach ($_POST[$this->prefix_addCostCheckBox] as $key => $val) {

                $postvar_name = $val . "-" . $this->prefix_addCostName;

                $postvar_cost = $val . "-" . $this->prefix_addCostCost;

                $charges_name = $_POST[$postvar_name];

                foreach ($_POST[$postvar_cost] as $key2 => $val2) {

                    $sql .= " (?,?,?,?) ,";

                    $val_array[] = $charges_name;

                    $val_array[] = $pid;

                    $val_array[] = intval($key2);

                    $val_array[] = doubleval($val2);



                    if($key2 == '20' && !empty($migrate_products) && $migrate_products == 1){

                        $sek_price = doubleval($val2);

                        $priceCalc = $this->functions->ibms_setting('priceCalc');
                        $priceCalc = unserialize($priceCalc);

                        $country_fr     = $priceCalc['country'][0];
                        $fr_divide      = $priceCalc['divide'][0];
                        $fr_multiply    = $priceCalc['multiply'][0];
                        $fr_price       = doubleval(($sek_price/$fr_divide)*$fr_multiply);
                        $fr_price       = ceil($fr_price);

                        $country_de     = $priceCalc['country'][1];
                        $de_divide      = $priceCalc['divide'][1];
                        $de_multiply    = $priceCalc['multiply'][1];
                        $de_price       = doubleval(($sek_price/$de_divide)*$de_multiply);
                        $de_price       = ceil($de_price);

                        $country_nl     = $priceCalc['country'][2];
                        $nl_divide      = $priceCalc['divide'][2];
                        $nl_multiply    = $priceCalc['multiply'][2];
                        $nl_price       = doubleval(($sek_price/$nl_divide)*$nl_multiply);
                        $nl_price       = ceil($nl_price);

                        $country_us     = $priceCalc['country'][3];
                        $us_divide      = $priceCalc['divide'][3];
                        $us_multiply    = $priceCalc['multiply'][3];
                        $us_price       = doubleval(($sek_price/$us_divide)*$us_multiply);
                        $us_price       = ceil($us_price);

                        $country_be     = $priceCalc['country'][4];
                        $be_divide      = $priceCalc['divide'][4];
                        $be_multiply    = $priceCalc['multiply'][4];
                        $be_price       = doubleval(($sek_price/$be_divide)*$be_multiply);
                        $be_price       = ceil($be_price);

                        $country_uk     = $priceCalc['country'][5];
                        $uk_divide      = $priceCalc['divide'][5];
                        $uk_multiply    = $priceCalc['multiply'][5];
                        $uk_price       = doubleval(($sek_price/$uk_divide)*$uk_multiply);
                        $uk_price       = ceil($uk_price);

                        $country_es     = $priceCalc['country'][6];
                        $es_divide      = $priceCalc['divide'][6];
                        $es_multiply    = $priceCalc['multiply'][6];
                        $es_price       = doubleval(($sek_price/$es_divide)*$es_multiply);
                        $es_price       = ceil($es_price);

                        $country_at     = $priceCalc['country'][7];
                        $at_divide      = $priceCalc['divide'][7];
                        $at_multiply    = $priceCalc['multiply'][7];
                        $at_price       = doubleval(($sek_price/$at_divide)*$at_multiply);
                        $at_price       = ceil($at_price);

                        $country_it     = $priceCalc['country'][8];
                        $it_divide      = $priceCalc['divide'][8];
                        $it_multiply    = $priceCalc['multiply'][8];
                        $it_price       = doubleval(($sek_price/$it_divide)*$it_multiply);
                        $it_price       = ceil($it_price);

                        $country_chf    = $priceCalc['country'][9];
                        $chf_divide     = $priceCalc['divide'][9];
                        $chf_multiply   = $priceCalc['multiply'][9];
                        $chf_price      = doubleval(($sek_price/$chf_divide)*$chf_multiply);
                        $chf_price      = ceil($chf_price);

                        $country_other    = $priceCalc['country'][10];
                        $other_divide     = $priceCalc['divide'][10];
                        $other_multiply   = $priceCalc['multiply'][10];
                        $other_price      = doubleval(($sek_price/$other_divide)*$other_multiply);
                        $other_price      = ceil($other_price);


                        $sqlNew = "INSERT " . " INTO `product_addcost`

                                ( `proadc_name`,`proadc_prodet_id`,

                                  `proadc_cur_id`,`proadc_price`

                                ) VALUES 
                                    ('$charges_name', '$newId', $country_chf, $chf_price),
                                    ('$charges_name', '$newId', $country_fr, $fr_price),
                                    ('$charges_name', '$newId', $country_de, $de_price),
                                    ('$charges_name', '$newId', $country_nl, $nl_price),
                                    ('$charges_name', '$newId', $country_us, $us_price),
                                    ('$charges_name', '$newId', $country_be, $be_price),
                                    ('$charges_name', '$newId', $country_uk, $uk_price),
                                    ('$charges_name', '$newId', $country_es, $es_price),
                                    ('$charges_name', '$newId', $country_at, $at_price),
                                    ('$charges_name', '$newId', $country_it, $it_price),
                                    ('$charges_name', '$newId', $country_other, $other_price)
                                ";

                        $res = $con->setRow($sqlNew);

                    }





                            if($key2 == '20' && !empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){
 $newId = $pid;

                        $sek_price = doubleval($val2);

                        $priceCalc = $this->functions->ibms_setting('priceCalc');
                        $priceCalc = unserialize($priceCalc);

                        $country_fr     = $priceCalc['country'][0];
                        $fr_divide      = $priceCalc['divide'][0];
                        $fr_multiply    = $priceCalc['multiply'][0];
                        $fr_price       = doubleval(($sek_price/$fr_divide)*$fr_multiply);
                        $fr_price       = ceil($fr_price);

                        $country_de     = $priceCalc['country'][1];
                        $de_divide      = $priceCalc['divide'][1];
                        $de_multiply    = $priceCalc['multiply'][1];
                        $de_price       = doubleval(($sek_price/$de_divide)*$de_multiply);
                        $de_price       = ceil($de_price);

                        $country_nl     = $priceCalc['country'][2];
                        $nl_divide      = $priceCalc['divide'][2];
                        $nl_multiply    = $priceCalc['multiply'][2];
                        $nl_price       = doubleval(($sek_price/$nl_divide)*$nl_multiply);
                        $nl_price       = ceil($nl_price);

                        $country_us     = $priceCalc['country'][3];
                        $us_divide      = $priceCalc['divide'][3];
                        $us_multiply    = $priceCalc['multiply'][3];
                        $us_price       = doubleval(($sek_price/$us_divide)*$us_multiply);
                        $us_price       = ceil($us_price);

                        $country_be     = $priceCalc['country'][4];
                        $be_divide      = $priceCalc['divide'][4];
                        $be_multiply    = $priceCalc['multiply'][4];
                        $be_price       = doubleval(($sek_price/$be_divide)*$be_multiply);
                        $be_price       = ceil($be_price);

                        $country_uk     = $priceCalc['country'][5];
                        $uk_divide      = $priceCalc['divide'][5];
                        $uk_multiply    = $priceCalc['multiply'][5];
                        $uk_price       = doubleval(($sek_price/$uk_divide)*$uk_multiply);
                        $uk_price       = ceil($uk_price);

                        $country_es     = $priceCalc['country'][6];
                        $es_divide      = $priceCalc['divide'][6];
                        $es_multiply    = $priceCalc['multiply'][6];
                        $es_price       = doubleval(($sek_price/$es_divide)*$es_multiply);
                        $es_price       = ceil($es_price);

                        $country_at     = $priceCalc['country'][7];
                        $at_divide      = $priceCalc['divide'][7];
                        $at_multiply    = $priceCalc['multiply'][7];
                        $at_price       = doubleval(($sek_price/$at_divide)*$at_multiply);
                        $at_price       = ceil($at_price);

                        $country_it     = $priceCalc['country'][8];
                        $it_divide      = $priceCalc['divide'][8];
                        $it_multiply    = $priceCalc['multiply'][8];
                        $it_price       = doubleval(($sek_price/$it_divide)*$it_multiply);
                        $it_price       = ceil($it_price);

                        $country_chf    = $priceCalc['country'][9];
                        $chf_divide     = $priceCalc['divide'][9];
                        $chf_multiply   = $priceCalc['multiply'][9];
                        $chf_price      = doubleval(($sek_price/$chf_divide)*$chf_multiply);
                        $chf_price      = ceil($chf_price);

                        $country_other    = $priceCalc['country'][10];
                        $other_divide     = $priceCalc['divide'][10];
                        $other_multiply   = $priceCalc['multiply'][10];
                        $other_price      = doubleval(($sek_price/$other_divide)*$other_multiply);
                        $other_price      = ceil($other_price);


                        $sqlNew = "INSERT " . " INTO `product_addcost`

                                ( `proadc_name`,`proadc_prodet_id`,

                                  `proadc_cur_id`,`proadc_price`

                                ) VALUES 
                                    ('$charges_name', '$newId', $country_chf, $chf_price),
                                    ('$charges_name', '$newId', $country_fr, $fr_price),
                                    ('$charges_name', '$newId', $country_de, $de_price),
                                    ('$charges_name', '$newId', $country_nl, $nl_price),
                                    ('$charges_name', '$newId', $country_us, $us_price),
                                    ('$charges_name', '$newId', $country_be, $be_price),
                                    ('$charges_name', '$newId', $country_uk, $uk_price),
                                    ('$charges_name', '$newId', $country_es, $es_price),
                                    ('$charges_name', '$newId', $country_at, $at_price),
                                    ('$charges_name', '$newId', $country_it, $it_price),
                                    ('$charges_name', '$newId', $country_other, $other_price)
                                ";

                        $res = $conIntra->setRow($sqlNew);

                    }




                }  

            }

            $sql = trim($sql, ",");

            // $sql_new = trim($sql_new, ",");

            $qry = $this->dbF->setRow($sql,$val_array);

            if ($qry > 0) return $qry;

            else return false;

        }

    }



    private function getset_currency()

    {

            global $con;
    global $conIntra;

        if (isset($_POST[$this->prefix_currencyArray]) && !empty($_POST[$this->prefix_currencyArray])) {



            // $chf_form = $this->functions->ibms_setting('chfPriceFormula');

            // $chf_form1 = explode(',',$chf_form);

            // $chf_divide = $chf_form1[0];

            // $chf_multiply = $chf_form1[1];



            $migrate_products = $this->functions->ibms_setting('migrate_product_to_ch');
            $migrate_product_to_intranet = $this->functions->ibms_setting('migrate_product_to_intranet');



            if (is_array($_POST[$this->prefix_currencyArray])) {

                $sql = "INSERT " . "INTO `product_price`

                        (`propri_cur_id`,`propri_prodet_id`,`propri_price`,`propri_intShipping`) VALUES ";

                $pid = $this->pid;

                $val_array = array();

                $foreach_loop = false;



                foreach ($_POST[$this->prefix_currencyArray] as $key => $val) {

                    if ($val > 0) {

                        $sql .= " (?,?,?,?) ,";

                        $val_array[] = $key;

                        $val_array[] = $pid;

                        $val_array[] = doubleval($val);



                        $intShipping_var = "intShipping_" . $key;

                        @$intShipping_val = intval($_POST[$intShipping_var]);

                        $val_array[] = $intShipping_val;



                        $foreach_loop = true;

                    }

                }

                $sql = trim($sql, ",");



                if ($foreach_loop) {

                    // $pid_new = 'ss'.$pid;

                    // $sek_price = intval($_POST[$this->prefix_currencyArray][24]);


                    // $priceCalc = $this->functions->ibms_setting('priceCalc');
                    // $priceCalc = unserialize($priceCalc);
                    // // $this->dbF->prnt($priceCalc);

                    // $country_fr     = $priceCalc['country'][0];
                    // $fr_divide      = $priceCalc['divide'][0];
                    // $fr_multiply    = $priceCalc['multiply'][0];
                    // $fr_price       = doubleval(($sek_price/$fr_divide)*$fr_multiply);
                    // $fr_price       = ceil($fr_price);

                    // $country_de     = $priceCalc['country'][1];
                    // $de_divide      = $priceCalc['divide'][1];
                    // $de_multiply    = $priceCalc['multiply'][1];
                    // $de_price       = doubleval(($sek_price/$de_divide)*$de_multiply);
                    // $de_price       = ceil($de_price);

                    // $country_nl     = $priceCalc['country'][2];
                    // $nl_divide      = $priceCalc['divide'][2];
                    // $nl_multiply    = $priceCalc['multiply'][2];
                    // $nl_price       = doubleval(($sek_price/$nl_divide)*$nl_multiply);
                    // $nl_price       = ceil($nl_price);

                    // $country_us     = $priceCalc['country'][3];
                    // $us_divide      = $priceCalc['divide'][3];
                    // $us_multiply    = $priceCalc['multiply'][3];
                    // $us_price       = doubleval(($sek_price/$us_divide)*$us_multiply);
                    // $us_price       = ceil($us_price);

                    // $country_be     = $priceCalc['country'][4];
                    // $be_divide      = $priceCalc['divide'][4];
                    // $be_multiply    = $priceCalc['multiply'][4];
                    // $be_price       = doubleval(($sek_price/$be_divide)*$be_multiply);
                    // $be_price       = ceil($be_price);

                    // $country_uk     = $priceCalc['country'][5];
                    // $uk_divide      = $priceCalc['divide'][5];
                    // $uk_multiply    = $priceCalc['multiply'][5];
                    // $uk_price       = doubleval(($sek_price/$uk_divide)*$uk_multiply);
                    // $uk_price       = ceil($uk_price);

                    // $country_es     = $priceCalc['country'][6];
                    // $es_divide      = $priceCalc['divide'][6];
                    // $es_multiply    = $priceCalc['multiply'][6];
                    // $es_price       = doubleval(($sek_price/$es_divide)*$es_multiply);
                    // $es_price       = ceil($es_price);

                    // $country_at     = $priceCalc['country'][7];
                    // $at_divide      = $priceCalc['divide'][7];
                    // $at_multiply    = $priceCalc['multiply'][7];
                    // $at_price       = doubleval(($sek_price/$at_divide)*$at_multiply);
                    // $at_price       = ceil($at_price);

                    // $country_it     = $priceCalc['country'][8];
                    // $it_divide      = $priceCalc['divide'][8];
                    // $it_multiply    = $priceCalc['multiply'][8];
                    // $it_price       = doubleval(($sek_price/$it_divide)*$it_multiply);
                    // $it_price       = ceil($it_price);

                    // $country_chf    = $priceCalc['country'][9];
                    // $chf_divide     = $priceCalc['divide'][9];
                    // $chf_multiply   = $priceCalc['multiply'][9];
                    // $chf_price      = doubleval(($sek_price/$chf_divide)*$chf_multiply);
                    // $chf_price      = ceil($chf_price);

                    // $country_other    = $priceCalc['country'][10];
                    // $other_divide     = $priceCalc['divide'][10];
                    // $other_multiply   = $priceCalc['multiply'][10];
                    // $other_price      = doubleval(($sek_price/$other_divide)*$other_multiply);
                    // $other_price      = ceil($other_price);

                    // $intShipping_varSEK = "intShipping_20";

                    // @$intShipping_valSEK = intval($_POST[$intShipping_varSEK]);

                    // $sql_new = "INSERT INTO `product_price`

                    //     (`propri_cur_id`,`propri_prodet_id`,`propri_price`,`propri_intShipping`) VALUES 
                    //             ($country_fr, '$pid_new', $fr_price, $intShipping_valSEK),
                    //             ($country_de, '$pid_new', $de_price, $intShipping_valSEK),
                    //             ($country_nl, '$pid_new', $nl_price, $intShipping_valSEK),
                    //             ($country_us, '$pid_new', $us_price, $intShipping_valSEK),
                    //             ($country_be, '$pid_new', $be_price, $intShipping_valSEK),
                    //             ($country_uk, '$pid_new', $uk_price, $intShipping_valSEK),
                    //             ($country_es, '$pid_new', $es_price, $intShipping_valSEK),
                    //             ($country_at, '$pid_new', $at_price, $intShipping_valSEK),
                    //             ($country_it, '$pid_new', $it_price, $intShipping_valSEK),
                    //             ($country_chf, '$pid_new', $chf_price, $intShipping_valSEK),
                    //             ($country_other, '$pid_new', $other_price, $intShipping_valSEK)";

                    



$qry = $this->dbF->setRow($sql,$val_array);

// $sqlLock = "SELECT `pro_lock` FROM `proudct_detail` WHERE `prodet_id` = '$pid_new' ";

// if(!empty($migrate_products) && $migrate_products == 1){

// $res_lock = $con->getRow($sqlLock);
// }
// if(!empty($migrate_products) && $migrate_products == 1 && $res_lock['pro_lock'] == 0){

// $con->setRow($sql_new);

// }



  //                   if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1 && $res_lock['pro_lock'] == 0){
  //                   $pid_new = $pid;


  // $sql_new = "INSERT INTO `product_price`

  //                       (`propri_cur_id`,`propri_prodet_id`,`propri_price`,`propri_intShipping`) VALUES 
  //                               ($country_fr, '$pid_new', $fr_price, $intShipping_valSEK),
  //                               ($country_de, '$pid_new', $de_price, $intShipping_valSEK),
  //                               ($country_nl, '$pid_new', $nl_price, $intShipping_valSEK),
  //                               ($country_us, '$pid_new', $us_price, $intShipping_valSEK),
  //                               ($country_be, '$pid_new', $be_price, $intShipping_valSEK),
  //                               ($country_uk, '$pid_new', $uk_price, $intShipping_valSEK),
  //                               ($country_es, '$pid_new', $es_price, $intShipping_valSEK),
  //                               ($country_at, '$pid_new', $at_price, $intShipping_valSEK),
  //                               ($country_it, '$pid_new', $it_price, $intShipping_valSEK),
  //                               ($country_chf, '$pid_new', $chf_price, $intShipping_valSEK),
  //                               ($country_other, '$pid_new', $other_price, $intShipping_valSEK)";



  //                       $conIntra->setRow($sql_new);

  //                   }



                    if ($qry > 0) return $qry;

                    else return false;

                } else return false;



            }

        }

    }



    private function getset_colors()

    {

            global $con;
    global $conIntra;



        $migrate_products = $this->functions->ibms_setting('migrate_product_to_ch');
        $migrate_product_to_intranet = $this->functions->ibms_setting('migrate_product_to_intranet');

        $priceCalc = $this->functions->ibms_setting('priceCalc');
        $priceCalc = unserialize($priceCalc);

        @$country_fr     = $priceCalc['country'][0];
        @$fr_divide      = $priceCalc['divide'][0];
        @$fr_multiply    = $priceCalc['multiply'][0];

        @$country_de     = $priceCalc['country'][1];
        @$de_divide      = $priceCalc['divide'][1];
        @$de_multiply    = $priceCalc['multiply'][1];

        @$country_nl     = $priceCalc['country'][2];
        @$nl_divide      = $priceCalc['divide'][2];
        @$nl_multiply    = $priceCalc['multiply'][2];

        @$country_us     = $priceCalc['country'][3];
        @$us_divide      = $priceCalc['divide'][3];
        @$us_multiply    = $priceCalc['multiply'][3];

        @$country_be     = $priceCalc['country'][4];
        @$be_divide      = $priceCalc['divide'][4];
        @$be_multiply    = $priceCalc['multiply'][4];

        @$country_uk     = $priceCalc['country'][5];
        @$uk_divide      = $priceCalc['divide'][5];
        @$uk_multiply    = $priceCalc['multiply'][5];

        @$country_es     = $priceCalc['country'][6];
        @$es_divide      = $priceCalc['divide'][6];
        @$es_multiply    = $priceCalc['multiply'][6];

        @$country_at     = $priceCalc['country'][7];
        @$at_divide      = $priceCalc['divide'][7];
        @$at_multiply    = $priceCalc['multiply'][7];

        @$country_it     = $priceCalc['country'][8];
        @$it_divide      = $priceCalc['divide'][8];
        @$it_multiply    = $priceCalc['multiply'][8];

        @$country_chf    = $priceCalc['country'][9];
        @$chf_divide     = $priceCalc['divide'][9];
        @$chf_multiply   = $priceCalc['multiply'][9];

        @$country_other    = $priceCalc['country'][10];
        @$other_divide     = $priceCalc['divide'][10];
        @$other_multiply   = $priceCalc['multiply'][10];
        

        if (isset($_POST[$this->prefix_colorCheckBox]) && !empty($_POST[$this->prefix_colorCheckBox])) {



            $pid = $this->pid;

            $val_array = array();

            $val_array1 = array();



            $sql = "INSERT " . " INTO `product_color` (

                `proclr_name`,`color_name`,`proclr_prodet_id`,

                `proclr_cur_id`,`proclr_price`,`sizeGroup`

            ) VALUES ";



            foreach ($_POST[$this->prefix_colorCheckBox] as $key => $val) {

                $postvar_name = $val . "-" . $this->prefix_colorName;

                $postvar_cost = $val . "-" . $this->prefix_colorCost;



                $color_name = $_POST[$postvar_name];



                foreach ($_POST[$postvar_cost] as $key2 => $val2) {

                    $sql .= " (?,?,?,?,?,?) ,";

                    $val_array[] = $color_name;

                    $val_array[] = HexToColorName($color_name);

                    $val_array[] = $pid;

                    $val_array[] = intval($key2);

                    $val_array[] = doubleval($val2);

                    $val_array[] = $_POST['sizeGroup_color'];

                }  

            }

            $sql = trim($sql, ",");

            $qry = $this->dbF->setRow($sql, $val_array);



            if ($qry > 0){

                if(!empty($migrate_products) && $migrate_products == 1){



                    $chf_form = $this->functions->ibms_setting('chfPriceFormula');

                    $chf_form1 = explode(',',$chf_form);

                    $chf_divide = $chf_form1[0];

                    $chf_multiply = $chf_form1[1];



                    $new_pid = 'ss'.$pid;



                    $sql_new1 = "INSERT " . " INTO `product_color` (

                            `propri_id`,`proclr_name`,`color_name`,`proclr_prodet_id`,

                            `proclr_cur_id`,`proclr_price`,`sizeGroup`

                        ) VALUES (?,?,?,?,?,?,?)";









                $sql_get10 = "SELECT * FROM `product_color` WHERE `proclr_prodet_id` = '$pid' AND `proclr_cur_id` = 20";

                $res0 = $this->dbF->getRows($sql_get10);



                foreach ($res0 as $key => $value) {

                    $sql_getdk = "SELECT * FROM `product_color` WHERE `proclr_prodet_id` = '$pid' AND `proclr_cur_id` = 24 AND `proclr_name` LIKE '%$value[proclr_name]%'";

                    $res_dk = $this->dbF->getRow($sql_getdk);



                    $propri_id          = 'ss'.$res_dk['propri_id'];

                    $proclr_name        = $value['proclr_name'];

                    $color_name         = $value['color_name'];

                    $proclr_prodet_id   = 'ss'.$value['proclr_prodet_id'];

                    $proclr_cur_id      = $value['proclr_cur_id'];


                    $fr_price       = doubleval(($value['proclr_price']/$fr_divide)*$fr_multiply);
                    $fr_price       = ceil($fr_price);
                    $fr_proclr      = 'ssfr'.$res_dk['propri_id'];

                    $de_price       = doubleval(($value['proclr_price']/$de_divide)*$de_multiply);
                    $de_price       = ceil($de_price);
                    $de_proclr      = 'ssde'.$res_dk['propri_id'];

                    $nl_price       = doubleval(($value['proclr_price']/$nl_divide)*$nl_multiply);
                    $nl_price       = ceil($nl_price);
                    $nl_proclr      = 'ssnl'.$res_dk['propri_id'];

                    $us_price       = doubleval(($value['proclr_price']/$us_divide)*$us_multiply);
                    $us_price       = ceil($us_price);
                    $us_proclr      = 'ssus'.$res_dk['propri_id'];

                    $be_price       = doubleval(($value['proclr_price']/$be_divide)*$be_multiply);
                    $be_price       = ceil($be_price);
                    $be_proclr      = 'ssbe'.$res_dk['propri_id'];

                    $uk_price       = doubleval(($value['proclr_price']/$uk_divide)*$uk_multiply);
                    $uk_price       = ceil($uk_price);
                    $uk_proclr      = 'ssuk'.$res_dk['propri_id'];

                    $es_price       = doubleval(($value['proclr_price']/$es_divide)*$es_multiply);
                    $es_price       = ceil($es_price);
                    $es_proclr      = 'sses'.$res_dk['propri_id'];

                    $at_price       = doubleval(($value['proclr_price']/$at_divide)*$at_multiply);
                    $at_price       = ceil($at_price);
                    $at_proclr      = 'ssat'.$res_dk['propri_id'];

                    $it_price       = doubleval(($value['proclr_price']/$it_divide)*$it_multiply);
                    $it_price       = ceil($it_price);
                    $it_proclr      = 'ssit'.$res_dk['propri_id'];

                    $chf_price      = doubleval(($value['proclr_price']/$chf_divide)*$chf_multiply);
                    $chf_price      = ceil($chf_price);

                    $other_price      = doubleval(($value['proclr_price']/$other_divide)*$other_multiply);
                    $other_price      = ceil($other_price);
                    $other_proclr      = 'ssot'.$res_dk['propri_id'];



                    //$proclr_price       = intval($value['proclr_price']);

                    $proclr_price       = doubleval(($value['proclr_price']/$chf_divide)*$chf_multiply);

                    $proclr_price = ceil($proclr_price);

                    $sizeGroup          = $value['sizeGroup'];



                    $new_arrayy = array($propri_id,$proclr_name,$color_name,$proclr_prodet_id,$proclr_cur_id,$proclr_price,$sizeGroup);

                    $sql_new1 = "INSERT " . " INTO `product_color` (

                                    `propri_id`,`proclr_name`,`color_name`,`proclr_prodet_id`,

                                    `proclr_cur_id`,`proclr_price`,`sizeGroup`

                                ) VALUES 
                                ('$propri_id','$proclr_name','$color_name','$proclr_prodet_id',$country_chf,'$chf_price','$sizeGroup'),

                                ('$fr_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_fr,'$fr_price','$sizeGroup'),

                                ('$de_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_de,'$de_price','$sizeGroup'),

                                ('$nl_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_nl,'$nl_price','$sizeGroup'),

                                ('$us_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_us,'$us_price','$sizeGroup'),

                                ('$be_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_be,'$be_price','$sizeGroup'),

                                ('$uk_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_uk,'$uk_price','$sizeGroup'),

                                ('$es_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_es,'$es_price','$sizeGroup'),

                                ('$at_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_at,'$at_price','$sizeGroup'),

                                ('$it_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_it,'$it_price','$sizeGroup'),

                                ('$other_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_other,'$other_price','$sizeGroup')";


                    $res2 = $con->setRow($sql_new1);

                }

            }




           if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){





                    $chf_form = $this->functions->ibms_setting('chfPriceFormula');

                    $chf_form1 = explode(',',$chf_form);

                    $chf_divide = $chf_form1[0];

                    $chf_multiply = $chf_form1[1];



                    // $new_pid = 'ss'.$pid;
                    $new_pid = $pid;



                    $sql_new1 = "INSERT " . " INTO `product_color` (

                            `propri_id`,`proclr_name`,`color_name`,`proclr_prodet_id`,

                            `proclr_cur_id`,`proclr_price`,`sizeGroup`

                        ) VALUES (?,?,?,?,?,?,?)";









                $sql_get10 = "SELECT * FROM `product_color` WHERE `proclr_prodet_id` = '$pid' AND `proclr_cur_id` = 20";

                $res0 = $this->dbF->getRows($sql_get10);



                foreach ($res0 as $key => $value) {

                    $sql_getdk = "SELECT * FROM `product_color` WHERE `proclr_prodet_id` = '$pid' AND `proclr_cur_id` = 24 AND `proclr_name` LIKE '%$value[proclr_name]%'";

                    $res_dk = $this->dbF->getRow($sql_getdk);



                    $propri_id          = $res_dk['propri_id'];

                    $proclr_name        = $value['proclr_name'];

                    $color_name         = $value['color_name'];

                    $proclr_prodet_id   = $value['proclr_prodet_id'];

                    $proclr_cur_id      = $value['proclr_cur_id'];


                    $fr_price       = doubleval(($value['proclr_price']/$fr_divide)*$fr_multiply);
                    $fr_price       = ceil($fr_price);
                    $fr_proclr      = 'fr'.$res_dk['propri_id'];

                    $de_price       = doubleval(($value['proclr_price']/$de_divide)*$de_multiply);
                    $de_price       = ceil($de_price);
                    $de_proclr      = 'de'.$res_dk['propri_id'];

                    $nl_price       = doubleval(($value['proclr_price']/$nl_divide)*$nl_multiply);
                    $nl_price       = ceil($nl_price);
                    $nl_proclr      = 'nl'.$res_dk['propri_id'];

                    $us_price       = doubleval(($value['proclr_price']/$us_divide)*$us_multiply);
                    $us_price       = ceil($us_price);
                    $us_proclr      = 'us'.$res_dk['propri_id'];

                    $be_price       = doubleval(($value['proclr_price']/$be_divide)*$be_multiply);
                    $be_price       = ceil($be_price);
                    $be_proclr      = 'be'.$res_dk['propri_id'];

                    $uk_price       = doubleval(($value['proclr_price']/$uk_divide)*$uk_multiply);
                    $uk_price       = ceil($uk_price);
                    $uk_proclr      = 'uk'.$res_dk['propri_id'];

                    $es_price       = doubleval(($value['proclr_price']/$es_divide)*$es_multiply);
                    $es_price       = ceil($es_price);
                    $es_proclr      = 'es'.$res_dk['propri_id'];

                    $at_price       = doubleval(($value['proclr_price']/$at_divide)*$at_multiply);
                    $at_price       = ceil($at_price);
                    $at_proclr      = 'at'.$res_dk['propri_id'];

                    $it_price       = doubleval(($value['proclr_price']/$it_divide)*$it_multiply);
                    $it_price       = ceil($it_price);
                    $it_proclr      = 'it'.$res_dk['propri_id'];

                    $chf_price      = doubleval(($value['proclr_price']/$chf_divide)*$chf_multiply);
                    $chf_price      = ceil($chf_price);

                    $other_price      = doubleval(($value['proclr_price']/$other_divide)*$other_multiply);
                    $other_price      = ceil($other_price);
                    $other_proclr      = 'ot'.$res_dk['propri_id'];



                    //$proclr_price       = intval($value['proclr_price']);

                    $proclr_price       = doubleval(($value['proclr_price']/$chf_divide)*$chf_multiply);

                    $proclr_price = ceil($proclr_price);

                    $sizeGroup          = $value['sizeGroup'];



                    $new_arrayy = array($propri_id,$proclr_name,$color_name,$proclr_prodet_id,$proclr_cur_id,$proclr_price,$sizeGroup);

                    $sql_new1 = "INSERT " . " INTO `product_color` (

                                    `propri_id`,`proclr_name`,`color_name`,`proclr_prodet_id`,

                                    `proclr_cur_id`,`proclr_price`,`sizeGroup`

                                ) VALUES 
                                ('$propri_id','$proclr_name','$color_name','$proclr_prodet_id',$country_chf,'$chf_price','$sizeGroup'),

                                ('$fr_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_fr,'$fr_price','$sizeGroup'),

                                ('$de_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_de,'$de_price','$sizeGroup'),

                                ('$nl_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_nl,'$nl_price','$sizeGroup'),

                                ('$us_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_us,'$us_price','$sizeGroup'),

                                ('$be_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_be,'$be_price','$sizeGroup'),

                                ('$uk_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_uk,'$uk_price','$sizeGroup'),

                                ('$es_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_es,'$es_price','$sizeGroup'),

                                ('$at_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_at,'$at_price','$sizeGroup'),

                                ('$it_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_it,'$it_price','$sizeGroup'),

                                ('$other_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_other,'$other_price','$sizeGroup')";


                    $res2 = $conIntra->setRow($sql_new1);

                }

            

           }
                return $qry;

            } 

            else return false;

        }

    }



    // private function getsetEdit_colors()

    // {

    //      global $con;
    // global $conIntra;



    //     if (isset($_POST[$this->prefix_colorCheckBox]) && !empty($_POST[$this->prefix_colorCheckBox])) {



    //         $migrate_products = $this->functions->ibms_setting('migrate_product_to_ch');



    //         $chf_form = $this->functions->ibms_setting('chfPriceFormula');

    //         $chf_form1 = explode(',',$chf_form);

    //         $chf_divide = $chf_form1[0];

    //         $chf_multiply = $chf_form1[1];



    //         $pid = $this->pid;

    //         $new_pid = 'ss'.$pid;

    //         $val_array = array();

    //         $val_array2 = array();



    //         $new_array = array();

    //         $new_array2 = array();



    //         $record=array();

    //         $curInsert=array();



    //         $sql = "INSERT " . " INTO `product_color` (

    //             `propri_id`,`proclr_name`,`color_name`,`proclr_prodet_id`,

    //             `proclr_cur_id`,`proclr_price`,`sizeGroup`

    //         ) VALUES ";



    //         $sql_new = "INSERT " . " INTO `product_color` (

    //             `propri_id`,`proclr_name`,`color_name`,`proclr_prodet_id`,

    //             `proclr_cur_id`,`proclr_price`,`sizeGroup`

    //         ) VALUES (?,?,?,?,?,?,?)";

    //         $tempData=false;





    //         foreach ($_POST[$this->prefix_colorCheckBox] as $key => $val) {

    //             $exc=explode('_',$val);

    //             if(isset($exc[3])){

    //                 $oldId=$exc[3];

    //                 //Old id. override id in db,, try to save old color primary id

    //             }else{

    //                 continue;

    //             }

    //             $postvar_name = $val . "-" . $this->prefix_colorName;

    //             $postvar_cost = $val . "-" . $this->prefix_colorCost;



    //             $color_name = $_POST[$postvar_name];



    //             if($color_name==''){

    //                 continue;

    //             }



    //             foreach ($_POST[$postvar_cost] as $key2 => $val2) {

    //                 if(in_array($oldId,$record) && $oldId!='0'){

    //                     continue;

    //                 }else{

    //                     $record[]=$exc[3];

    //                     $curInsert[]=$key2;

    //                 }



    //                 $sql .= " ('$oldId',?,?,?,?,?,?) ,";

    //                 $val_array[] = $color_name;

    //                 $val_array[] = HexToColorName($color_name);

    //                 $val_array[] = $pid;

    //                 $val_array[] = intval($key2);

    //                 $val_array[] = doubleval($val2);

    //                 $val_array[] = $_POST['sizeGroup_color'];



    //               //   if($key2 == '20'){

    //               //       $oldId1 = 'ss'.$oldId;

    //               //     $sql_new .= " ('$oldId1',?,?,?,?,?,?) ,";

    //               //     $new_array[] = $color_name;

          //               // $new_array[] = HexToColorName($color_name);

          //               // $new_array[] = $new_pid;

          //               // $new_array[] = intval($key2);

          //               // $new_array[] = ceil((doubleval($val2)/$chf_divide)*$chf_multiply);

          //               // $new_array[] = $_POST['sizeGroup_color'];

    //               //   } 

    //             }

    //             $tempData=true;



                

    //         }



    //         if($tempData){

    //         $sql = trim($sql, ",");

    //         $sql_new = trim($sql_new, ",");

    //         $qry = $this->dbF->setRow($sql, $val_array);



    //         if(!empty($migrate_products) && $migrate_products == 1){    

    //             //if(!empty($new_array)){

    //                 $sql_get = "SELECT * FROM `product_color` WHERE `proclr_prodet_id` = ? AND `proclr_cur_id` = 20";

    //                 $res = $this->dbF->getRows($sql_get, array($pid));



    //                 foreach ($res as $key => $value) {



    //                     $sql_getdk = "SELECT * FROM `product_color` WHERE `proclr_prodet_id` = '$pid' AND `proclr_cur_id` = 24 AND `proclr_name` LIKE '%$value[proclr_name]%'";

    //                     $res_dk = $this->dbF->getRow($sql_getdk);



    //                     $propri_id      = 'ss'.$res_dk['propri_id'];

    //                     $proclr_name    = $value['proclr_name'];

    //                     $proclr_prodet_id = 'ss'.$value['proclr_prodet_id'];

    //                     $proclr_cur_id  = $value['proclr_cur_id'];

    //                     $proclr_price   = doubleval(($value['proclr_price']/$chf_divide)*$chf_multiply);

    //                     $proclr_price   = ceil($proclr_price);

    //                     $sizeGroup      = $value['sizeGroup'];



    //                     $new_array = array($propri_id,$proclr_name,$proclr_prodet_id,$proclr_cur_id,$proclr_price,$sizeGroup);



    //                     $res2 = $con->setRow($sql_new, $new_array);

    //                 }

                     

    //             //  $res1 = $con->setRow($sql_new, $new_array);

    //             //}

    //         }  







    //         // $sql_new = "INSERT INTO `product_color` (

    //         //     `propri_id`,`proclr_name`,`color_name`,`proclr_prodet_id`,

    //         //     `proclr_cur_id`,`proclr_price`,`sizeGroup`

    //         // ) VALUES ('$oldId',?,?,?,?,?,?)";

    //         if(!empty($new_array)){

    //          $qry_new = $con->setRow($sql_new, $new_array);

    //         }

            





    //         }else{

    //             $qry=0;

    //         }



    //         $tempData=false;

    //         $sql = "INSERT " . " INTO `product_color` (

    //             `proclr_name`,`color_name`,`proclr_prodet_id`,

    //             `proclr_cur_id`,`proclr_price`,`sizeGroup`

    //         ) VALUES ";



    //         $sql_new = "INSERT " . " INTO `product_color` (

    //             `propri_id`,`proclr_name`,`color_name`,`proclr_prodet_id`,

    //             `proclr_cur_id`,`proclr_price`,`sizeGroup`

    //         ) VALUES (?,?,?,?,?,?,?)";



    //         foreach ($_POST[$this->prefix_colorCheckBox] as $key => $val) {

    //             $exc=explode('_',$val);

    //             if(isset($exc[3])){

    //                 $oldId=$exc[3];

    //             }

    //             $postvar_name = $val . "-" . $this->prefix_colorName;

    //             $postvar_cost = $val . "-" . $this->prefix_colorCost;



    //             $color_name = $_POST[$postvar_name];

    //             if($color_name==''){

    //                 continue;

    //             }

    //             foreach ($_POST[$postvar_cost] as $key2 => $val2) {

    //                 if(in_array($key2,$curInsert)){

    //                     if(isset($exc[3])){ continue;}

    //                 }else{



    //                 }

    //                 $sql .= " (?,?,?,?,?,?) ,";

    //                 $val_array2[] = $color_name;

    //                 $val_array2[] = HexToColorName($color_name);

    //                 $val_array2[] = $pid;

    //                 $val_array2[] = intval($key2);

    //                 $val_array2[] = doubleval($val2);

    //                 $val_array2[] = $_POST['sizeGroup_color'];



    //               //   if($key2 == '20'){

    //               //     $sql_new .= " (?,?,?,?,?,?) ,";

    //               //     $new_array21[] = $color_name;

          //               // $new_array21[] = HexToColorName($color_name);

          //               // $new_array21[] = $new_pid;

          //               // $new_array21[] = intval($key2);

          //               // $new_array21[] = doubleval($val2);

          //               // $new_array21[] = $_POST['sizeGroup_color'];

    //               //   }

    //                 $tempData=true;

    //             }



                

                

    //         }

    //         if($tempData){

    //          $sql = trim($sql, ",");

    //          $sql_new = trim($sql_new, ",");

    //         $qry2 = $this->dbF->setRow($sql, $val_array2);



    //         $sql_get = "SELECT * FROM `product_color` WHERE `proclr_prodet_id` = ? AND `proclr_cur_id` = 20";

    //         $res = $this->dbF->getRows($sql_get, array($pid));



    //         foreach ($res as $key => $value) {

    //             $sql_getdk = "SELECT * FROM `product_color` WHERE `proclr_prodet_id` = '$pid' AND `proclr_cur_id` = 24 AND `proclr_name` LIKE '%$value[proclr_name]%'";

    //             $res_dk = $this->dbF->getRow($sql_getdk);



    //             $propri_id          = 'ss'.$res_dk['propri_id'];

    //             $proclr_name        = $value['proclr_name'];

    //             $color_name         = $value['color_name'];

    //             $proclr_prodet_id   = 'ss'.$value['proclr_prodet_id'];

    //             $proclr_cur_id      = $value['proclr_cur_id'];

    //             $proclr_price       = doubleval(($value['proclr_price']/$chf_divide)*$chf_multiply);

    //             $proclr_price       = ceil($proclr_price);

    //             $sizeGroup          = $value['sizeGroup'];



    //             $new_array2 = array($propri_id,$proclr_name,$color_name,$proclr_prodet_id,$proclr_cur_id,$proclr_price,$sizeGroup);



    //             $res2 = $con->setRow($sql_new, $new_array2);

    //         }



    //         // $sql_new1 = "INSERT INTO `product_color` (

    //         //     `proclr_name`,`color_name`,`proclr_prodet_id`,

    //         //     `proclr_cur_id`,`proclr_price`,`sizeGroup`

    //         // ) VALUES (?,?,?,?,?,?)";

    //         // $this->dbF->prnt($new_array21);

    //         // $qry_new1 = $con->setRow($sql_new, $new_array21);



    //         }else{

    //             $qry2 = 0;

    //         }

    //         $qry=$qry+$qry2;

    //         if ($qry > 0) return $qry;

    //         else return false;

    //     }



    // }





    private function getsetEdit_colors()

    {

            global $con;
    global $conIntra;



        if (isset($_POST[$this->prefix_colorCheckBox]) && !empty($_POST[$this->prefix_colorCheckBox])) {



            $migrate_products = $this->functions->ibms_setting('migrate_product_to_ch');
            $migrate_product_to_intranet = $this->functions->ibms_setting('migrate_product_to_intranet');


            $priceCalc = $this->functions->ibms_setting('priceCalc');
            $priceCalc = unserialize($priceCalc);

            // $this->dbF->prnt($priceCalc);

            $country_fr     = $priceCalc['country'][0];
            $fr_divide      = $priceCalc['divide'][0];
            $fr_multiply    = $priceCalc['multiply'][0];

            $country_de     = $priceCalc['country'][1];
            $de_divide      = $priceCalc['divide'][1];
            $de_multiply    = $priceCalc['multiply'][1];

            $country_nl     = $priceCalc['country'][2];
            $nl_divide      = $priceCalc['divide'][2];
            $nl_multiply    = $priceCalc['multiply'][2];

            $country_us     = $priceCalc['country'][3];
            $us_divide      = $priceCalc['divide'][3];
            $us_multiply    = $priceCalc['multiply'][3];

            $country_be     = $priceCalc['country'][4];
            $be_divide      = $priceCalc['divide'][4];
            $be_multiply    = $priceCalc['multiply'][4];

            $country_uk     = $priceCalc['country'][5];
            $uk_divide      = $priceCalc['divide'][5];
            $uk_multiply    = $priceCalc['multiply'][5];

            $country_es     = $priceCalc['country'][6];
            $es_divide      = $priceCalc['divide'][6];
            $es_multiply    = $priceCalc['multiply'][6];

            $country_at     = $priceCalc['country'][7];
            $at_divide      = $priceCalc['divide'][7];
            $at_multiply    = $priceCalc['multiply'][7];

            $country_it     = $priceCalc['country'][8];
            $it_divide      = $priceCalc['divide'][8];
            $it_multiply    = $priceCalc['multiply'][8];

            $country_chf    = $priceCalc['country'][9];
            $chf_divide     = $priceCalc['divide'][9];
            $chf_multiply   = $priceCalc['multiply'][9];

            $country_other    = $priceCalc['country'][10];
            $other_divide     = $priceCalc['divide'][10];
            $other_multiply   = $priceCalc['multiply'][10];


            $pid = $this->pid;

            $new_pid = 'ss'.$pid;

            $val_array = array();

            $val_array2 = array();



            $new_array = array();

            $new_array2 = array();



            $record=array();

            $curInsert=array();



            $sql = "INSERT " . " INTO `product_color` (

                `propri_id`,`proclr_name`,`color_name`,`proclr_prodet_id`,

                `proclr_cur_id`,`proclr_price`,`sizeGroup`

            ) VALUES ";



            $sql_new = "INSERT " . " INTO `product_color` (

                `propri_id`,`proclr_name`,`color_name`,`proclr_prodet_id`,

                `proclr_cur_id`,`proclr_price`,`sizeGroup`

            ) VALUES (?,?,?,?,?,?,?)";

            $tempData=false;





            foreach ($_POST[$this->prefix_colorCheckBox] as $key => $val) {

                $exc=explode('_',$val);

                if(isset($exc[3])){

                    $oldId=$exc[3];

                    //Old id. override id in db,, try to save old color primary id

                }else{

                    continue;

                }

                $postvar_name = $val . "-" . $this->prefix_colorName;

                $postvar_cost = $val . "-" . $this->prefix_colorCost;



                $color_name = $_POST[$postvar_name];



                //($color_name==''){

                 //   continue;

                //}



                foreach ($_POST[$postvar_cost] as $key2 => $val2) {

                    if(in_array($oldId,$record) && $oldId!='0'){

                        continue;

                    }else{

                        $record[]=$exc[3];

                        $curInsert[]=$key2;

                    }



                    $sql .= " ('$oldId',?,?,?,?,?,?) ,";

                    $val_array[] = $color_name;

                    $val_array[] = HexToColorName($color_name);

                    $val_array[] = $pid;

                    $val_array[] = intval($key2);

                    $val_array[] = doubleval($val2);

                    $val_array[] = $_POST['sizeGroup_color'];



                  //   if($key2 == '20'){

                  //       $oldId1 = 'ss'.$oldId;

                  //    $sql_new .= " ('$oldId1',?,?,?,?,?,?) ,";

                  //    $new_array[] = $color_name;

                        // $new_array[] = HexToColorName($color_name);

                        // $new_array[] = $new_pid;

                        // $new_array[] = intval($key2);

                        // $new_array[] = ceil((doubleval($val2)/$chf_divide)*$chf_multiply);

                        // $new_array[] = $_POST['sizeGroup_color'];

                  //   } 

                  $tempData=true;

                }

                



                

            }



            if($tempData){

            $sql = trim($sql, ",");

            $sql_new = trim($sql_new, ",");

            $qry = $this->dbF->setRow($sql, $val_array);


            if(!empty($migrate_products) && $migrate_products == 1){ 

                // $this->dbF->prnt($new_array);   

                // if(!empty($new_array)){

                    $sql_get = "SELECT * FROM `product_color` WHERE `proclr_prodet_id` = '$pid' AND `proclr_cur_id` = '20'";

                    $res_get = $this->dbF->getRows($sql_get);

                    // echo $sql_get;
                    // $this->dbF->prnt($res_get);

                    foreach ($res_get as $key => $value) {



                        $sql_getdk = "SELECT * FROM `product_color` WHERE `proclr_prodet_id` = '$pid' AND `proclr_cur_id` = 24 AND `proclr_name` LIKE '%$value[proclr_name]%'";

                        $res_dk = $this->dbF->getRow($sql_getdk);

                        // $this->dbF->prnt($res_dk);

                        $propri_id      = 'ss'.$res_dk['propri_id'];

                        $proclr_name    = $value['proclr_name'];

                        $proclr_prodet_id = 'ss'.$value['proclr_prodet_id'];

                        $proclr_cur_id  = $value['proclr_cur_id'];


                        $fr_price       = doubleval(($value['proclr_price']/$fr_divide)*$fr_multiply);
                        $fr_price       = ceil($fr_price);
                        $fr_proclr      = 'ssfr'.$res_dk['propri_id'];

                        $de_price       = doubleval(($value['proclr_price']/$de_divide)*$de_multiply);
                        $de_price       = ceil($de_price);
                        $de_proclr      = 'ssde'.$res_dk['propri_id'];

                        $nl_price       = doubleval(($value['proclr_price']/$nl_divide)*$nl_multiply);
                        $nl_price       = ceil($nl_price);
                        $nl_proclr      = 'ssnl'.$res_dk['propri_id'];

                        $us_price       = doubleval(($value['proclr_price']/$us_divide)*$us_multiply);
                        $us_price       = ceil($us_price);
                        $us_proclr      = 'ssus'.$res_dk['propri_id'];

                        $be_price       = doubleval(($value['proclr_price']/$be_divide)*$be_multiply);
                        $be_price       = ceil($be_price);
                        $be_proclr      = 'ssbe'.$res_dk['propri_id'];

                        $uk_price       = doubleval(($value['proclr_price']/$uk_divide)*$uk_multiply);
                        $uk_price       = ceil($uk_price);
                        $uk_proclr      = 'ssuk'.$res_dk['propri_id'];

                        $es_price       = doubleval(($value['proclr_price']/$es_divide)*$es_multiply);
                        $es_price       = ceil($es_price);
                        $es_proclr      = 'sses'.$res_dk['propri_id'];

                        $at_price       = doubleval(($value['proclr_price']/$at_divide)*$at_multiply);
                        $at_price       = ceil($at_price);
                        $at_proclr      = 'ssat'.$res_dk['propri_id'];

                        $it_price       = doubleval(($value['proclr_price']/$it_divide)*$it_multiply);
                        $it_price       = ceil($it_price);
                        $it_proclr      = 'ssit'.$res_dk['propri_id'];

                        $other_price    = doubleval(($value['proclr_price']/$other_divide)*$other_multiply);
                        $other_price    = ceil($other_price);
                        $other_proclr   = 'ssot'.$res_dk['propri_id'];

                        $chf_price      = doubleval(($value['proclr_price']/$chf_divide)*$chf_multiply);
                        $chf_price      = ceil($chf_price);



                        $proclr_price   = doubleval(($value['proclr_price']/$chf_divide)*$chf_multiply);

                        $proclr_price   = ceil($proclr_price);

                        $sizeGroup      = $value['sizeGroup'];



                        $new_array = array($propri_id,$proclr_name,$proclr_prodet_id,$proclr_cur_id,$proclr_price,$sizeGroup);


                        $sql_new = "INSERT " . " INTO `product_color` (

                                        `propri_id`,`proclr_name`,`color_name`,`proclr_prodet_id`,

                                        `proclr_cur_id`,`proclr_price`,`sizeGroup`

                                    ) VALUES

                                    ('$propri_id','$proclr_name','$color_name','$proclr_prodet_id',$country_chf,'$chf_price','$sizeGroup'),

                                    ('$fr_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_fr,'$fr_price','$sizeGroup'),

                                    ('$de_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_de,'$de_price','$sizeGroup'),

                                    ('$nl_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_nl,'$nl_price','$sizeGroup'),

                                    ('$us_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_us,'$us_price','$sizeGroup'),

                                    ('$be_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_be,'$be_price','$sizeGroup'),

                                    ('$uk_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_uk,'$uk_price','$sizeGroup'),

                                    ('$es_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_es,'$es_price','$sizeGroup'),

                                    ('$at_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_at,'$at_price','$sizeGroup'),

                                    ('$it_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_it,'$it_price','$sizeGroup'),

                                    ('$other_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_other,'$other_price','$sizeGroup')";


                        $res2 = $con->setRow($sql_new, $new_array);

                    }

                     

                //  $res1 = $con->setRow($sql_new, $new_array);

                // }

            }  





      if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){ 

                // $this->dbF->prnt($new_array);   

                // if(!empty($new_array)){

                    $sql_get = "SELECT * FROM `product_color` WHERE `proclr_prodet_id` = '$pid' AND `proclr_cur_id` = '20'";

                    $res_get = $this->dbF->getRows($sql_get);

                    // echo $sql_get;
                    // $this->dbF->prnt($res_get);

                    foreach ($res_get as $key => $value) {



                        $sql_getdk = "SELECT * FROM `product_color` WHERE `proclr_prodet_id` = '$pid' AND `proclr_cur_id` = 24 AND `proclr_name` LIKE '%$value[proclr_name]%'";

                        $res_dk = $this->dbF->getRow($sql_getdk);

                        // $this->dbF->prnt($res_dk);

                        $propri_id      = $res_dk['propri_id'];

                        $proclr_name    = $value['proclr_name'];

                        $proclr_prodet_id = $value['proclr_prodet_id'];

                        $proclr_cur_id  = $value['proclr_cur_id'];


                        $fr_price       = doubleval(($value['proclr_price']/$fr_divide)*$fr_multiply);
                        $fr_price       = ceil($fr_price);
                        $fr_proclr      = 'fr'.$res_dk['propri_id'];

                        $de_price       = doubleval(($value['proclr_price']/$de_divide)*$de_multiply);
                        $de_price       = ceil($de_price);
                        $de_proclr      = 'de'.$res_dk['propri_id'];

                        $nl_price       = doubleval(($value['proclr_price']/$nl_divide)*$nl_multiply);
                        $nl_price       = ceil($nl_price);
                        $nl_proclr      = 'nl'.$res_dk['propri_id'];

                        $us_price       = doubleval(($value['proclr_price']/$us_divide)*$us_multiply);
                        $us_price       = ceil($us_price);
                        $us_proclr      = 'us'.$res_dk['propri_id'];

                        $be_price       = doubleval(($value['proclr_price']/$be_divide)*$be_multiply);
                        $be_price       = ceil($be_price);
                        $be_proclr      = 'be'.$res_dk['propri_id'];

                        $uk_price       = doubleval(($value['proclr_price']/$uk_divide)*$uk_multiply);
                        $uk_price       = ceil($uk_price);
                        $uk_proclr      = 'uk'.$res_dk['propri_id'];

                        $es_price       = doubleval(($value['proclr_price']/$es_divide)*$es_multiply);
                        $es_price       = ceil($es_price);
                        $es_proclr      = 'es'.$res_dk['propri_id'];

                        $at_price       = doubleval(($value['proclr_price']/$at_divide)*$at_multiply);
                        $at_price       = ceil($at_price);
                        $at_proclr      = 'at'.$res_dk['propri_id'];

                        $it_price       = doubleval(($value['proclr_price']/$it_divide)*$it_multiply);
                        $it_price       = ceil($it_price);
                        $it_proclr      = 'it'.$res_dk['propri_id'];

                        $other_price    = doubleval(($value['proclr_price']/$other_divide)*$other_multiply);
                        $other_price    = ceil($other_price);
                        $other_proclr   = 'ot'.$res_dk['propri_id'];

                        $chf_price      = doubleval(($value['proclr_price']/$chf_divide)*$chf_multiply);
                        $chf_price      = ceil($chf_price);



                        $proclr_price   = doubleval(($value['proclr_price']/$chf_divide)*$chf_multiply);

                        $proclr_price   = ceil($proclr_price);

                        $sizeGroup      = $value['sizeGroup'];



                        $new_array = array($propri_id,$proclr_name,$proclr_prodet_id,$proclr_cur_id,$proclr_price,$sizeGroup);


                        $sql_new = "INSERT " . " INTO `product_color` (

                                        `propri_id`,`proclr_name`,`color_name`,`proclr_prodet_id`,

                                        `proclr_cur_id`,`proclr_price`,`sizeGroup`

                                    ) VALUES

                                    ('$propri_id','$proclr_name','$color_name','$proclr_prodet_id',$country_chf,'$chf_price','$sizeGroup'),

                                    ('$fr_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_fr,'$fr_price','$sizeGroup'),

                                    ('$de_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_de,'$de_price','$sizeGroup'),

                                    ('$nl_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_nl,'$nl_price','$sizeGroup'),

                                    ('$us_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_us,'$us_price','$sizeGroup'),

                                    ('$be_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_be,'$be_price','$sizeGroup'),

                                    ('$uk_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_uk,'$uk_price','$sizeGroup'),

                                    ('$es_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_es,'$es_price','$sizeGroup'),

                                    ('$at_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_at,'$at_price','$sizeGroup'),

                                    ('$it_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_it,'$it_price','$sizeGroup'),

                                    ('$other_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_other,'$other_price','$sizeGroup')";


                        $res2 = $conIntra->setRow($sql_new, $new_array);

                    }

                     

                //  $res1 = $con->setRow($sql_new, $new_array);

                // }

            }  






            // $sql_new = "INSERT INTO `product_color` (

            //     `propri_id`,`proclr_name`,`color_name`,`proclr_prodet_id`,

            //     `proclr_cur_id`,`proclr_price`,`sizeGroup`

            // ) VALUES ('$oldId',?,?,?,?,?,?)";

            //if(!empty($new_array)){

                //$qry_new = $con->setRow($sql_new, $new_array);

            //}

            





            }else{

                $qry=0;

            }



            $tempData=false;

            $sql = "INSERT " . " INTO `product_color` (

                `proclr_name`,`color_name`,`proclr_prodet_id`,

                `proclr_cur_id`,`proclr_price`,`sizeGroup`

            ) VALUES ";


            foreach ($_POST[$this->prefix_colorCheckBox] as $key => $val) {

                $exc=explode('_',$val);

                if(isset($exc[3])){

                    $oldId=$exc[3];

                }

                $postvar_name = $val . "-" . $this->prefix_colorName;

                $postvar_cost = $val . "-" . $this->prefix_colorCost;



                $color_name = $_POST[$postvar_name];

                //if($color_name==''){

                    //continue;

                //}

                foreach ($_POST[$postvar_cost] as $key2 => $val2) {

                    if(in_array($key2,$curInsert)){

                        if(isset($exc[3])){ continue;}

                    }else{



                    }

                    $sql .= " (?,?,?,?,?,?) ,";

                    $val_array2[] = $color_name;

                    $val_array2[] = HexToColorName($color_name);

                    $val_array2[] = $pid;

                    $val_array2[] = intval($key2);

                    $val_array2[] = doubleval($val2);

                    $val_array2[] = $_POST['sizeGroup_color'];



                  //   if($key2 == '20'){

                  //    $sql_new .= " (?,?,?,?,?,?) ,";

                  //    $new_array21[] = $color_name;

                        // $new_array21[] = HexToColorName($color_name);

                        // $new_array21[] = $new_pid;

                        // $new_array21[] = intval($key2);

                        // $new_array21[] = doubleval($val2);

                        // $new_array21[] = $_POST['sizeGroup_color'];

                  //   }

                    $tempData=true;

                }



                

                

            }

            if($tempData){

                $sql = trim($sql, ",");

            $qry2 = $this->dbF->setRow($sql, $val_array2);



            $sql_get = "SELECT * FROM `product_color` WHERE `proclr_prodet_id` = ? AND `proclr_cur_id` = 20";

            $res = $this->dbF->getRows($sql_get, array($pid));

            // $this->dbF->prnt($res);



            if(!empty($migrate_products) && $migrate_products == 1){


            foreach ($res as $key => $value) {

                $sql_getdk = "SELECT * FROM `product_color` WHERE `proclr_prodet_id` = '$pid' AND `proclr_cur_id` = 24 AND `proclr_name` LIKE '%$value[proclr_name]%'";

                $res_dk = $this->dbF->getRow($sql_getdk);



                $propri_id          = 'ss'.$res_dk['propri_id'];

                $proclr_name        = $value['proclr_name'];

                $color_name         = $value['color_name'];

                $proclr_prodet_id   = 'ss'.$value['proclr_prodet_id'];

                $proclr_cur_id      = $value['proclr_cur_id'];


                $fr_price       = doubleval(($value['proclr_price']/$fr_divide)*$fr_multiply);
                $fr_price       = ceil($fr_price);
                $fr_proclr      = 'ssfr'.$res_dk['propri_id'];

                $de_price       = doubleval(($value['proclr_price']/$de_divide)*$de_multiply);
                $de_price       = ceil($de_price);
                $de_proclr      = 'ssde'.$res_dk['propri_id'];

                $nl_price       = doubleval(($value['proclr_price']/$nl_divide)*$nl_multiply);
                $nl_price       = ceil($nl_price);
                $nl_proclr      = 'ssnl'.$res_dk['propri_id'];

                $us_price       = doubleval(($value['proclr_price']/$us_divide)*$us_multiply);
                $us_price       = ceil($us_price);
                $us_proclr      = 'ssus'.$res_dk['propri_id'];

                $be_price       = doubleval(($value['proclr_price']/$be_divide)*$be_multiply);
                $be_price       = ceil($be_price);
                $be_proclr      = 'ssbe'.$res_dk['propri_id'];

                $uk_price       = doubleval(($value['proclr_price']/$uk_divide)*$uk_multiply);
                $uk_price       = ceil($uk_price);
                $uk_proclr      = 'ssuk'.$res_dk['propri_id'];

                $es_price       = doubleval(($value['proclr_price']/$es_divide)*$es_multiply);
                $es_price       = ceil($es_price);
                $es_proclr      = 'sses'.$res_dk['propri_id'];

                $at_price       = doubleval(($value['proclr_price']/$at_divide)*$at_multiply);
                $at_price       = ceil($at_price);
                $at_proclr      = 'ssat'.$res_dk['propri_id'];

                $it_price       = doubleval(($value['proclr_price']/$it_divide)*$it_multiply);
                $it_price       = ceil($it_price);
                $it_proclr      = 'ssit'.$res_dk['propri_id'];

                $other_price    = doubleval(($value['proclr_price']/$other_divide)*$other_multiply);
                $other_price    = ceil($other_price);
                $other_proclr   = 'ssot'.$res_dk['propri_id'];

                $chf_price      = doubleval(($value['proclr_price']/$chf_divide)*$chf_multiply);
                $chf_price      = ceil($chf_price);


                $proclr_price       = doubleval(($value['proclr_price']/$chf_divide)*$chf_multiply);

                $proclr_price       = ceil($proclr_price);

                $sizeGroup          = $value['sizeGroup'];



                $new_array2 = array($propri_id,$proclr_name,$color_name,$proclr_prodet_id,$proclr_cur_id,$proclr_price,$sizeGroup);

                $sql_new = "INSERT " . " INTO `product_color` (

                                `propri_id`,`proclr_name`,`color_name`,`proclr_prodet_id`,

                                `proclr_cur_id`,`proclr_price`,`sizeGroup`

                            ) VALUES

                            ('$propri_id','$proclr_name','$color_name','$proclr_prodet_id',$country_chf,'$chf_price','$sizeGroup'),

                            ('$fr_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_fr,'$fr_price','$sizeGroup'),

                            ('$de_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_de,'$de_price','$sizeGroup'),

                            ('$nl_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_nl,'$nl_price','$sizeGroup'),

                            ('$us_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_us,'$us_price','$sizeGroup'),

                            ('$be_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_be,'$be_price','$sizeGroup'),

                            ('$uk_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_uk,'$uk_price','$sizeGroup'),

                            ('$es_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_es,'$es_price','$sizeGroup'),

                            ('$at_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_at,'$at_price','$sizeGroup'),

                            ('$it_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_it,'$it_price','$sizeGroup'),

                            ('$other_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_other,'$other_price','$sizeGroup')";

                // echo $sql_new;

                $res2 = $con->setRow($sql_new, $new_array2);

            }

        }    














       if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){


            foreach ($res as $key => $value) {

                $sql_getdk = "SELECT * FROM `product_color` WHERE `proclr_prodet_id` = '$pid' AND `proclr_cur_id` = 24 AND `proclr_name` LIKE '%$value[proclr_name]%'";

                $res_dk = $this->dbF->getRow($sql_getdk);



                $propri_id          = $res_dk['propri_id'];

                $proclr_name        = $value['proclr_name'];

                $color_name         = $value['color_name'];

                $proclr_prodet_id   = $value['proclr_prodet_id'];

                $proclr_cur_id      = $value['proclr_cur_id'];


                $fr_price       = doubleval(($value['proclr_price']/$fr_divide)*$fr_multiply);
                $fr_price       = ceil($fr_price);
                $fr_proclr      = 'fr'.$res_dk['propri_id'];

                $de_price       = doubleval(($value['proclr_price']/$de_divide)*$de_multiply);
                $de_price       = ceil($de_price);
                $de_proclr      = 'de'.$res_dk['propri_id'];

                $nl_price       = doubleval(($value['proclr_price']/$nl_divide)*$nl_multiply);
                $nl_price       = ceil($nl_price);
                $nl_proclr      = 'nl'.$res_dk['propri_id'];

                $us_price       = doubleval(($value['proclr_price']/$us_divide)*$us_multiply);
                $us_price       = ceil($us_price);
                $us_proclr      = 'us'.$res_dk['propri_id'];

                $be_price       = doubleval(($value['proclr_price']/$be_divide)*$be_multiply);
                $be_price       = ceil($be_price);
                $be_proclr      = 'be'.$res_dk['propri_id'];

                $uk_price       = doubleval(($value['proclr_price']/$uk_divide)*$uk_multiply);
                $uk_price       = ceil($uk_price);
                $uk_proclr      = 'uk'.$res_dk['propri_id'];

                $es_price       = doubleval(($value['proclr_price']/$es_divide)*$es_multiply);
                $es_price       = ceil($es_price);
                $es_proclr      = 'es'.$res_dk['propri_id'];

                $at_price       = doubleval(($value['proclr_price']/$at_divide)*$at_multiply);
                $at_price       = ceil($at_price);
                $at_proclr      = 'at'.$res_dk['propri_id'];

                $it_price       = doubleval(($value['proclr_price']/$it_divide)*$it_multiply);
                $it_price       = ceil($it_price);
                $it_proclr      = 'it'.$res_dk['propri_id'];

                $other_price    = doubleval(($value['proclr_price']/$other_divide)*$other_multiply);
                $other_price    = ceil($other_price);
                $other_proclr   = 'ot'.$res_dk['propri_id'];

                $chf_price      = doubleval(($value['proclr_price']/$chf_divide)*$chf_multiply);
                $chf_price      = ceil($chf_price);


                $proclr_price       = doubleval(($value['proclr_price']/$chf_divide)*$chf_multiply);

                $proclr_price       = ceil($proclr_price);

                $sizeGroup          = $value['sizeGroup'];



                $new_array2 = array($propri_id,$proclr_name,$color_name,$proclr_prodet_id,$proclr_cur_id,$proclr_price,$sizeGroup);

                $sql_new = "INSERT " . " INTO `product_color` (

                                `propri_id`,`proclr_name`,`color_name`,`proclr_prodet_id`,

                                `proclr_cur_id`,`proclr_price`,`sizeGroup`

                            ) VALUES

                            ('$propri_id','$proclr_name','$color_name','$proclr_prodet_id',$country_chf,'$chf_price','$sizeGroup'),

                            ('$fr_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_fr,'$fr_price','$sizeGroup'),

                            ('$de_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_de,'$de_price','$sizeGroup'),

                            ('$nl_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_nl,'$nl_price','$sizeGroup'),

                            ('$us_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_us,'$us_price','$sizeGroup'),

                            ('$be_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_be,'$be_price','$sizeGroup'),

                            ('$uk_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_uk,'$uk_price','$sizeGroup'),

                            ('$es_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_es,'$es_price','$sizeGroup'),

                            ('$at_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_at,'$at_price','$sizeGroup'),

                            ('$it_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_it,'$it_price','$sizeGroup'),

                            ('$other_proclr','$proclr_name','$color_name','$proclr_prodet_id',$country_other,'$other_price','$sizeGroup')";

                // echo $sql_new;

                $res2 = $conIntra->setRow($sql_new, $new_array2);

            }

        }



            // $sql_new1 = "INSERT INTO `product_color` (

            //     `proclr_name`,`color_name`,`proclr_prodet_id`,

            //     `proclr_cur_id`,`proclr_price`,`sizeGroup`

            // ) VALUES (?,?,?,?,?,?)";

            // $this->dbF->prnt($new_array21);

            // $qry_new1 = $con->setRow($sql_new, $new_array21);



            }else{

                $qry2 = 0;

            }

            $qry=$qry+$qry2;

            if ($qry > 0) return $qry;

            else return false;

        }



    }









    private function getset_setting()

    {

            global $con;
    global $conIntra;

        $pid = $this->pid;

        $new_pid = 'ss'.$pid;

        $migrate_products = $this->functions->ibms_setting('migrate_product_to_ch');
        $migrate_product_to_intranet = $this->functions->ibms_setting('migrate_product_to_intranet');
 
        if (isset($_POST[$this->prefix_setting]) && !empty($_POST[$this->prefix_setting])) {

           $setting=$_POST[$this->prefix_setting];

            $sql="INSERT INTO `product_setting`(`p_id`,`setting_name`,`setting_val`) VALUES ";



            foreach($setting as $key=>$val){

                $sql .= "('$pid',?,?) ,";

                if(is_array($val)){

                    $val = serialize($val);

                }

                $arry[]= $key ;

                $arry[]= $val ;

            }



            $sql = trim($sql,",");


        $this->dbF->setRow($sql,$arry);


  if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){

           $conIntra->setRow($sql,$arry);
    }
      

            if(!empty($migrate_products) && $migrate_products == 1){




            $sql1="INSERT INTO `product_setting`(`p_id`,`setting_name`,`setting_val`) VALUES ";

            foreach($setting as $key=>$val){

                $sql1 .= "('$new_pid',?,?) ,";



                if($key == 'ldesc' || $key == 'size_chart' || $key == 'tags' || $key == 'specification' || $key == 'featureIcon' || $key == 'featurePoints'){



                    $val_array['Swedish'] = $val['Swedish'];

                    $val_array['German'] = '';

                    $val_array['French'] = '';

                    $val_array['English'] = @$val['English'];

                    $val_array['Dutch']   = '';

                    $val_array['Spanish']  = '';

                    $val_array['Italian']  = '';



                    $val = serialize($val_array);



                    $arry1[]= $key ;

                    $arry1[]= $val ;



                }else if($key == 'related' || $key == 'free_gift' || $key == 'getlook' || $key == 'combineWith'){

                    $arrayForPids = array();

                    for ($i=0; $i < sizeof($val); $i++) { 

                        $arrayForPids[] = 'ss'.$val[$i];

                    }

                    $new_val = serialize($arrayForPids);

                    $arry1[]= $key ;

                    $arry1[]= $new_val ;

                }

                else{

                    if(is_array($val)){

                        $val = serialize($val);

                    }

                    $arry1[]= $key ;

                    $arry1[]= $val ;

                }                

            }



            $sql1 = trim($sql1,",");



                $con->setRow($sql1,$arry1);

            }

   

            if($this->dbF->rowCount>0) return true;

            else return false;

        }else return false;





    }



    /**

     * @param $lang

     * @return bool

     */

    private function getset_proInformation($lang)

    {

            global $con;
    global $conIntra;



        if (isset($_POST[$this->prefix_productBasicInformation]) && !empty($_POST[$this->prefix_productBasicInformation]) ) {

            $pinfo = $_POST[$this->prefix_productBasicInformation];

           $pcode =  $pinfo['p_code'];
          $pstatus = $pinfo['p_status'];
              
            $id=$this->pid;

            $addedOn = date("Y-m-d h:i:s");
  
            $sql = "UPDATE `proudct_detail` SET

                        `prodet_name`=?,

                        `slug` =?,

                        `prodet_shortDesc`=?,

                        `prodet_addOn`='$addedOn',

                        `product_update`='1',

                         `p_status`= '$pstatus',
                       
                        `p_code`= '$pcode'


                    WHERE `prodet_id`='$id'";       



            $slug = sanitize_slug($pinfo['slug']);

            $ref_id = $this->db->productDetail.$id;



            $check = $this->functions->check_slug_duplicate($slug,$ref_id);



                if(!$check){

                    $slug = $slug."-".rand(1, 15);

                }



            $arry= array( serialize($pinfo['name']),$slug, serialize($pinfo['sdesc']));

            $this->dbF->setRow($sql,$arry);



            $migrate_products = $this->functions->ibms_setting('migrate_product_to_ch');



            if(!empty($migrate_products) && $migrate_products == 1){

                $new_id = 'ss'.$id;

                $slug_new = 'ss'.$slug;

                $sql1 = "UPDATE `proudct_detail` SET

                            `prodet_name`=?,

                            `slug` =?,

                            `prodet_shortDesc`=?,

                            `prodet_addOn`='$addedOn',

                            `product_update`='1'

                        WHERE `prodet_id`='$new_id'";

                $name_array['Swedish']  = $pinfo['name']['Swedish'];

                $name_array['German']   = '';

                $name_array['French']   = '';

                $name_array['English']  = @$pinfo['name']['English'];

                $name_array['Dutch']   = '';

                $name_array['Spanish']  = '';

                $name_array['Italian']  = '';



                $sdesc_array['Swedish']  = $pinfo['sdesc']['Swedish'];

                $sdesc_array['German']   = '';

                $sdesc_array['French']   = '';

                $sdesc_array['English']  = @$pinfo['sdesc']['English'];

                $sdesc_array['Dutch']   = '';

                $sdesc_array['Spanish']  = '';

                $sdesc_array['Italian']  = '';



                $arry1= array( serialize($name_array),$slug_new, serialize($sdesc_array));

                $con->setRow($sql1, $arry1); 

            }       










 $migrate_product_to_intranet = $this->functions->ibms_setting('migrate_product_to_intranet');



            if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){

                $new_id = $id;
                // $new_id = 'ss'.$id;

                $slug_new = $slug;
                // $slug_new = 'ss'.$slug;

                $sql1 = "UPDATE `proudct_detail` SET

                            `prodet_name`=?,

                            `slug` =?,

                            `prodet_shortDesc`=?,

                            `prodet_addOn`='$addedOn',

                            `product_update`='1'

                        WHERE `prodet_id`='$new_id'";

                $name_array['Swedish']  = $pinfo['name']['Swedish'];

                $name_array['German']   = '';

                $name_array['French']   = '';

                $name_array['English']  = @$pinfo['name']['English'];

                $name_array['Dutch']   = '';

                $name_array['Spanish']  = '';

                $name_array['Italian']  = '';



                $sdesc_array['Swedish']  = $pinfo['sdesc']['Swedish'];

                $sdesc_array['German']   = '';

                $sdesc_array['French']   = '';

                $sdesc_array['English']  = @$pinfo['sdesc']['English'];

                $sdesc_array['Dutch']   = '';

                $sdesc_array['Spanish']  = '';

                $sdesc_array['Italian']  = '';



                $arry1= array( serialize($name_array),$slug_new, serialize($sdesc_array));

                $conIntra->setRow($sql1, $arry1); 

            }       





            $this->product_seo($arry);

            if (!$this->dbF->hasException) return true;

            else return false;

        }else return false;

    }



    /**

     * @param $array, product basic information

     * @return bool

     */

    private function product_seo($array)

    {

            global $con;
    global $conIntra;

        //$this->dbF->prnt($array);

        # initialize result to false

        $result = false;

        $migrate_products = $this->functions->ibms_setting('migrate_product_to_ch');
        $migrate_product_to_intranet = $this->functions->ibms_setting('migrate_product_to_intranet');

        if(!isset($_POST['edit_proSubmit']) || empty($_POST['edit_proSubmit']) ){



            # Run only if edit is false

            $pinfo  = $_POST[$this->prefix_productBasicInformation];

            //$public = (int) $_POST[$this->prefix_setting]["publicAccess"];

            $public = 1; // always  public



            ### Create keywords

            /*$admin_lang = ($_SESSION["admin"]["lang"]);

            $p_name = $pinfo['name']["$admin_lang"] . ', ';

            $title  = isset($_POST[$this->prefix_setting]["label"]) ? $_POST[$this->prefix_setting]["label"]["$admin_lang"] . ', ' : '';



            $pshort_desc = $pinfo['sdesc']["$admin_lang"];

            */

            ## Get the categories for product

            $cat_names = ''; // <<< initializing $cat_names here



/*///////Edited bu MUD/////////*/



            // if ($_POST[$this->prefix_productCategory]) {

            //     // var_dump('$_POST[$this->prefix_productCategory]:',$_POST[$this->prefix_productCategory]);

            //     $cat_ids = addslashes($_POST[$this->prefix_productCategory]);

            //     $sql = "SELECT `nm` FROM `tree_data` WHERE `id` IN ($cat_ids)";

            //     $cat_res = $this->dbF->getRows($sql);

            //     // var_dump($sql);



            //     foreach ($cat_res as $key => $value) {

            //         $cat_names .= $value['nm'] . ', ';

            //     }

            //     # adding a leading ,(comma) and space

            //     $cat_names =  ', ' . $cat_names;

            //     # remove a trailing ,(comma) and space

            //     $cat_names = rtrim($cat_names, ', ');

            // }



/*///////Edited bu MUD/////////*/



            if ($_POST[$this->prefix_productCategory]) {

                // var_dump('$_POST[$this->prefix_productCategory]:',$_POST[$this->prefix_productCategory]);



                $cat_ids = "";

                foreach ($_POST[$this->prefix_productCategory] as $key => $value) {

                        # code...

                        $cat_ids .= $value.',';

                    } 

                   $cat_ids = rtrim($cat_ids,",");



                //$cat_ids = addslashes($_POST[$this->prefix_productCategory]);

                $sql = "SELECT `name` FROM `categories` WHERE `id` IN ($cat_ids)";

                $cat_res = $this->dbF->getRows($sql);

                // var_dump($sql);



                foreach ($cat_res as $key => $value) {

                    $cat_n = translateFromSerialize($value['name']);

                    $cat_names .= $cat_n . ', ';

                }

                # adding a leading ,(comma) and space

                $cat_names =  ', ' . $cat_names;

                # remove a trailing ,(comma) and space

                $cat_names = rtrim($cat_names, ', ');

            }

            



            $languages = unserialize($this->functions->ibms_setting('Languages'));

            //echo "<br>";

            //var_dump($languages);

            $keywords = array();

            foreach ($languages as $language) {

                $keywords[$language] = $pinfo['name'][$language] . $cat_names . ', ' . $pinfo['sdesc'][$language];

            }



            ### Create Keywords END



            $p_setting = $_POST[$this->prefix_setting];



            $id=$this->pid;

            $addedOn = date("Y-m-d h:i:s");

            $pageLink = "/".sanitize_slug($this->db->productDetail.$array[1]);

            // var_dump('PINFO:',$pinfo['name']);

            $p_name = serialize($pinfo['name']);

            $p_sdesc = serialize($pinfo['sdesc']);

            $keywords = serialize($keywords);



            $slug = $array[1];



            // $check = $this->functions->check_slug_duplicate($slug);



            //     if(!$check){

            //         $slug = $slug."-".rand(1, 15);

            //     }

                

            $ref_id = $this->db->productDetail.$id;

            



            // var_dump('Keywords:', $keywords);

            // $keywords = "";



            # Run Add SEO Query if not editing

            $sql = " INSERT INTO `seo` (

                        `pageLink`,

                        `ref_id`,

                        `slug`,

                        `title`,

                        `keywords`,

                        `dsc`,

                        `sIndex`,

                        `sFollow`,

                        `rewriteTitle`,

                        `revisit-after`,

                        `type`,

                        `publish`

                        )



            VALUES ('$pageLink','$ref_id','$slug','$p_name', '$keywords' , '$p_sdesc' , 1 , 1 , 1, '1 week','product' , $public ) ";

            $this->dbF->setRow($sql);



            if(!empty($migrate_products) && $migrate_products == 1){

            

                $new_id = 'ss'.$id;

                $ref_id_new = $this->db->productDetail.$new_id;

                

                $slug_new = 'ss'.$array[1];

                $pageLink_new = "/".sanitize_slug($this->db->productDetail.'ss'.$array[1]);



                $p_namech['Swedish']  = $pinfo['name']['Swedish'];

                $p_namech['German']   = '';

                $p_namech['French']   = '';

                $p_namech['English']  = $pinfo['name']['English'];

                $p_namech['Dutch']   = '';

                $p_namech['Spanish']  = '';

                $p_namech['Italian']  = '';





                $p_sdescch['Swedish']  = $pinfo['sdesc']['Swedish'];

                $p_sdescch['German']   = '';

                $p_sdescch['French']   = '';

                $p_sdescch['English']  = $pinfo['sdesc']['English'];

                $p_sdescch['Dutch']   = '';

                $p_sdescch['Spanish']  = '';

                $p_sdescch['Italian']  = '';



                $p_sdescch['Swedish']  = $pinfo['sdesc']['Swedish'];

                $p_sdescch['German']   = '';

                $p_sdescch['French']   = '';

                $p_sdescch['English']  = $pinfo['sdesc']['English'];

                $p_sdescch['Dutch']   = '';

                $p_sdescch['Spanish']  = '';

                $p_sdescch['Italian']  = '';



                $keywordsch['Swedish'] = $pinfo['name']['Swedish'] . $cat_names . ', ' . $pinfo['sdesc']['Swedish'];

                $keywordsch['German'] = '';

                $keywordsch['French'] = '';

                $keywordsch['English'] = $pinfo['name']['English'] . $cat_names . ', ' . $pinfo['sdesc']['English'];

                $keywordsch['Dutch']   = '';

                $keywordsch['Spanish']  = '';

                $keywordsch['Italian']  = '';



                $pname_swit = serialize($p_namech);

                $psdesc_swit = serialize($p_sdescch);

                $keyword_swit = serialize($keywordsch);



                $sql_ch = " INSERT INTO `seo` (

                            `pageLink`,

                            `ref_id`,

                            `slug`,

                            `title`,

                            `keywords`,

                            `dsc`,

                            `sIndex`,

                            `sFollow`,

                            `rewriteTitle`,

                            `revisit-after`,

                            `type`,

                            `publish`

                            )



                VALUES ('$pageLink_new','$ref_id_new','$slug_new','$pname_swit', '$keyword_swit' , '$psdesc_swit' , 1 , 1 , 1, '1 week','product' , $public ) ";

                $con->setRow($sql_ch);



            }




    if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){

            

                // $new_id = 'ss'.$id;
                $new_id = $id;

                $ref_id_new = $this->db->productDetail.$new_id;

                

                $slug_new = $array[1];

                $pageLink_new = "/".sanitize_slug($this->db->productDetail.$array[1]);



                $p_namech['Swedish']  = $pinfo['name']['Swedish'];

                $p_namech['German']   = '';

                $p_namech['French']   = '';

                $p_namech['English']  = $pinfo['name']['English'];

                $p_namech['Dutch']   = '';

                $p_namech['Spanish']  = '';

                $p_namech['Italian']  = '';





                $p_sdescch['Swedish']  = $pinfo['sdesc']['Swedish'];

                $p_sdescch['German']   = '';

                $p_sdescch['French']   = '';

                $p_sdescch['English']  = $pinfo['sdesc']['English'];

                $p_sdescch['Dutch']   = '';

                $p_sdescch['Spanish']  = '';

                $p_sdescch['Italian']  = '';



                $p_sdescch['Swedish']  = $pinfo['sdesc']['Swedish'];

                $p_sdescch['German']   = '';

                $p_sdescch['French']   = '';

                $p_sdescch['English']  = $pinfo['sdesc']['English'];

                $p_sdescch['Dutch']   = '';

                $p_sdescch['Spanish']  = '';

                $p_sdescch['Italian']  = '';



                $keywordsch['Swedish'] = $pinfo['name']['Swedish'] . $cat_names . ', ' . $pinfo['sdesc']['Swedish'];

                $keywordsch['German'] = '';

                $keywordsch['French'] = '';

                $keywordsch['English'] = $pinfo['name']['English'] . $cat_names . ', ' . $pinfo['sdesc']['English'];

                $keywordsch['Dutch']   = '';

                $keywordsch['Spanish']  = '';

                $keywordsch['Italian']  = '';



                $pname_swit = serialize($p_namech);

                $psdesc_swit = serialize($p_sdescch);

                $keyword_swit = serialize($keywordsch);



                $sql_ch = " INSERT INTO `seo` (

                            `pageLink`,

                            `ref_id`,

                            `slug`,

                            `title`,

                            `keywords`,

                            `dsc`,

                            `sIndex`,

                            `sFollow`,

                            `rewriteTitle`,

                            `revisit-after`,

                            `type`,

                            `publish`

                            )



                VALUES ('$pageLink_new','$ref_id_new','$slug_new','$pname_swit', '$keyword_swit' , '$psdesc_swit' , 1 , 1 , 1, '1 week','product' , $public ) ";

                $conIntra->setRow($sql_ch);



            }














            if (!$this->dbF->hasException) { $result = true; }

        }

        else{

            $id=$this->pid;

            $slug = $array[1];

            $pageLink = "/".sanitize_slug($this->db->productDetail.$array[1]);

            $ref_id = $this->db->productDetail.$id;



            // $sql = " UPDATE `seo` SET `pageLink` = ?, `slug` = ? WHERE `ref_id` LIKE '%$ref_id%' ";

            // $arr = array($pageLink,$slug);

            // $this->dbF->setRow($sql, $arr);



            if(!empty($migrate_products) && $migrate_products == 1){

                $new_id = 'ss'.$id;

                $ref_id_new = $this->db->productDetail.$new_id;

                $slug_new = 'ss'.$array[1];

                $pageLink_new = $pageLink = "/".sanitize_slug($this->db->productDetail.'ss'.$array[1]);



                $sql_ch = " UPDATE `seo` SET `pageLink` = ?, `slug` = ? WHERE `ref_id` LIKE '%$ref_id_new%' ";

                $arr = array($pageLink_new,$slug_new);

                $con->setRow($sql_ch, $arr);

            }




     if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){

                // $new_id = 'ss'.$id;
                $new_id = $id;

                $ref_id_new = $this->db->productDetail.$new_id;

                $slug_new = $array[1];

                $pageLink_new = $pageLink = "/".sanitize_slug($this->db->productDetail.$array[1]);



                $sql_ch = " UPDATE `seo` SET `pageLink` = ?, `slug` = ? WHERE `ref_id` LIKE '%$ref_id_new%' ";

                $arr = array($pageLink_new,$slug_new);

                $conIntra->setRow($sql_ch, $arr);

            }





            if (!$this->dbF->hasException) { $result = true; }

        }

        return $result;

    }



    private function getset_categoryList()

    {

        if (isset($_POST[$this->prefix_productCategory]) && !empty($_POST[$this->prefix_productCategory])) {

            $cat = $_POST[$this->prefix_productCategory];

            $sql = "INSERT " . "INTO `product_category` (`procat_cat_id`,`procat_prodet_id`) VALUES (?,?)";

            $pid = $this->pid;

            $arry=array($_POST[$this->prefix_productCategory],$pid);

            $this->dbF->setRow($sql,$arry);

            if ($this->dbF->rowCount > 0) return $this->dbF->rowCount;

                else return false;

            } else {

                return false;

            }

    }



    private function getset_categoryList1()

    {

            global $con;
    global $conIntra;


//           $sql = "select * from product_category";

//         $res = $this->dbF->getRows($sql,false);
//         //$this->dbF->prnt($res);
//         foreach ($res as  $category) {
//         $cat_id_with_ss = '';
//             # code...

//           // $cat =  'ss'.$category['procat_cat_id'];
//           $category_array =  explode(',', $category['procat_cat_id']);
//           foreach ($category_array as  $value) {


//               if($value > 0){
//                 $cat_id_with_ss .= 'ss'.$value.',';

                      
//               }

//               // echo "<br>";
//           }
           
//             $pro_cat_p_id = 'ss'.$category['procat_prodet_id'];
//                  $sql  = "UPDATE product_category SET procat_cat_id = '$cat_id_with_ss' WHERE procat_prodet_id =  '$pro_cat_p_id'";
//                  $res2 = $con->setRow($sql,false);


//         }
// die;
        
        
        
        
        
        
        //echo "<pre>"; print_r($_POST); echo "</pre>";

        if (isset($_POST[$this->prefix_productCategory]) && !empty($_POST[$this->prefix_productCategory])) {






                        $cat_format = "";

            // $cat_fromat_ch = "";

            foreach ($_POST[$this->prefix_productCategory] as $key => $value) {

                    # code...

                    $cat_format .= $value.',';

                    // $cat_fromat_ch .= 'ss'.$value.',';

                }    







            $cat = $_POST[$this->prefix_productCategory];

            $sql = "INSERT " . "INTO `product_category` (`procat_cat_id`,`procat_prodet_id`) VALUES (?,?)";

            $pid = $this->pid;

            $arry=array($cat_format,$pid);

            $this->dbF->setRow($sql,$arry);



    


            $migrate_products = $this->functions->ibms_setting('migrate_product_to_ch');



            if(!empty($migrate_products) && $migrate_products == 1){




                        // $cat_format = "";

            $cat_fromat_ch = "";

            foreach ($_POST[$this->prefix_productCategory] as $key => $value) {

                    # code...

                    // $cat_format .= $value.',';

                    $cat_fromat_ch .= 'ss'.$value.',';

                }    







            $cat = $_POST[$this->prefix_productCategory];

            $sql = "INSERT " . "INTO `product_category` (`procat_cat_id`,`procat_prodet_id`) VALUES (?,?)";

            $pid = $this->pid;

            // $arry=array($cat_format,$pid);

            // $this->dbF->setRow($sql,$arry);






                $pid_new = 'ss'.$pid;

                $arry_new=array($cat_fromat_ch,$pid_new);

                $con->setRow($sql,$arry_new);

            }


$migrate_product_to_intranet = $this->functions->ibms_setting('migrate_product_to_intranet');



if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){



        $cat_format = "";

            // $cat_fromat_ch = "";

            foreach ($_POST[$this->prefix_productCategory] as $key => $value) {

                    # code...

                    $cat_format .= $value.',';

                    // $cat_fromat_ch .= $value.',';

                }    







            $cat = $_POST[$this->prefix_productCategory];

            $sql = "INSERT " . "INTO `product_category` (`procat_cat_id`,`procat_prodet_id`) VALUES (?,?)";

            $pid = $this->pid;

            $arry=array($cat_format,$pid);

        $conIntra->setRow($sql,$arry);




                // $pid_new = 'ss'.$pid;
                // $pid_new =$pid;

                // $arry_new=array($cat_fromat_ch,$pid_new);

                // $conIntra->setRow($sql,$arry_new);

            }


            if ($this->dbF->rowCount > 0) return $this->dbF->rowCount;

                else return false;

            } else {

                return false;

            }

    }



    private function getsetEdit_scales()

    {

global $con;
global $conIntra;

        if (isset($_POST[$this->prefix_scaleCheckBox]) && !empty($_POST[$this->prefix_scaleCheckBox])) {



            $migrate_products = $this->functions->ibms_setting('migrate_product_to_ch');
            $migrate_product_to_intranet = $this->functions->ibms_setting('migrate_product_to_intranet');




            // $chf_form = $this->functions->ibms_setting('chfPriceFormula');

            // $chf_form1 = explode(',',$chf_form);

            // $chf_divide = $chf_form1[0];

            // $chf_multiply = $chf_form1[1];

            $priceCalc = $this->functions->ibms_setting('priceCalc');
            $priceCalc = unserialize($priceCalc);

            $country_fr     = $priceCalc['country'][0];
            $fr_divide      = $priceCalc['divide'][0];
            $fr_multiply    = $priceCalc['multiply'][0];

            $country_de     = $priceCalc['country'][1];
            $de_divide      = $priceCalc['divide'][1];
            $de_multiply    = $priceCalc['multiply'][1];

            $country_nl     = $priceCalc['country'][2];
            $nl_divide      = $priceCalc['divide'][2];
            $nl_multiply    = $priceCalc['multiply'][2];

            $country_us     = $priceCalc['country'][3];
            $us_divide      = $priceCalc['divide'][3];
            $us_multiply    = $priceCalc['multiply'][3];

            $country_be     = $priceCalc['country'][4];
            $be_divide      = $priceCalc['divide'][4];
            $be_multiply    = $priceCalc['multiply'][4];

            $country_uk     = $priceCalc['country'][5];
            $uk_divide      = $priceCalc['divide'][5];
            $uk_multiply    = $priceCalc['multiply'][5];

            $country_es     = $priceCalc['country'][6];
            $es_divide      = $priceCalc['divide'][6];
            $es_multiply    = $priceCalc['multiply'][6];

            $country_at     = $priceCalc['country'][7];
            $at_divide      = $priceCalc['divide'][7];
            $at_multiply    = $priceCalc['multiply'][7];

            $country_it     = $priceCalc['country'][8];
            $it_divide      = $priceCalc['divide'][8];
            $it_multiply    = $priceCalc['multiply'][8];

            $country_chf    = $priceCalc['country'][9];
            $chf_divide     = $priceCalc['divide'][9];
            $chf_multiply   = $priceCalc['multiply'][9]; 

            $country_other  = $priceCalc['country'][10];
            $other_divide   = $priceCalc['divide'][10];
            $other_multiply = $priceCalc['multiply'][10];



            $pid = $this->pid;

            $new_pid = 'ss'.$pid;

            $val_array = array();

            $val_array2 = array();



            $new_array = array();

            $new_array2 = array();



            $sql = "INSERT " . " INTO `product_size` (

                `prosiz_id`, `prosiz_name`,`prosiz_prodet_id`,

                `prosiz_cur_id`,`prosiz_price`,`sizeGroup`

            ) VALUES ";



            $tempData=false;

            $record=array();

            $curInsert=array();





            foreach ($_POST[$this->prefix_scaleCheckBox] as $key => $val) {

                //sc_99_227_246

                $postvar_name = $val . "-" . $this->prefix_scaleName;

                $postvar_cost = $val . "-" . $this->prefix_scaleCost;

                $exc=explode('_',$val);

                if(isset($exc[3])){

                    $oldId=$exc[3];

                }else{

                   continue;

                }



                $scale_name = $_POST[$postvar_name];



                foreach ($_POST[$postvar_cost] as $key2 => $val2) {

                    if(in_array($oldId,$record) && $oldId!='0'){

                        continue;

                    }else{

                        $record[]=$exc[3];

                        $curInsert[]=$key2;

                    }



                    $sql .= " ('$oldId',?,?,?,?,?) ,";

                    $val_array[] = $scale_name;

                    $val_array[] = $pid;

                    $val_array[] = intval($key2);

                    $val_array[] = doubleval($val2);

                    $val_array[] = $_POST['sizeGroup_scale'];



                //     if($key2 == '20'){

                //         $oldId1 = 'ss'.$oldId;

                //      $sql_new .= " ('$oldId1',?,?,?,?,?) ,";

                //      $new_array[] = $scale_name;

                      //  $new_array[] = $new_pid;

                      //  $new_array[] = intval($key2);

                      //  $new_array[] = ceil((doubleval($val2)/$chf_divide)*$chf_multiply);

                      //  $new_array[] = $_POST['sizeGroup_scale'];

                //     }

                    $tempData=true;

                }



                



            }



if($tempData){

$sql = trim($sql, ",");

// $sql_new = trim($sql_new, ",");

$qry1 = $this->dbF->setRow($sql, $val_array);
 






                }else{

                    $qry1=0;

                }



            $tempData=false;



            $sql = "INSERT " . " INTO `product_size` (

                `prosiz_name`,`prosiz_prodet_id`,

                `prosiz_cur_id`,`prosiz_price`,`sizeGroup`

            ) VALUES ";



            foreach ($_POST[$this->prefix_scaleCheckBox] as $key => $val) {

                $postvar_name = $val . "-" . $this->prefix_scaleName;

                $postvar_cost = $val . "-" . $this->prefix_scaleCost;

                $exc=explode('_',$val);

                if(isset($exc[3])){

                    $oldId=$exc[3];

                }



                $scale_name = $_POST[$postvar_name];



                foreach ($_POST[$postvar_cost] as $key2 => $val2) {

                    if(in_array($key2,$curInsert)){

                        if(isset($exc[3])){ continue;}

                    }else{



                    }



                    $sql .= " (?,?,?,?,?) ,";

                    $val_array2[] = $scale_name;

                    $val_array2[] = $pid;

                    $val_array2[] = intval($key2);

                    $val_array2[] = doubleval($val2);

                    $val_array2[] = $_POST['sizeGroup_scale'];



                  //   if($key2 == '20'){

                  //    $sql_new .= " (?,?,?,?,?) ,";

                  //    $new_array2[] = $scale_name;

                        // $new_array2[] = $new_pid;

                        // $new_array2[] = intval($key2);

                        // $new_array2[] = doubleval($val2);

                        // $new_array2[] = $_POST['sizeGroup_scale'];

                  //   }



                    $tempData   =   true;

                }

            }

            if($tempData){

                $sql = trim($sql, ",");

                // $sql_new = trim($sql_new, ",");

                $qry2 = $this->dbF->setRow($sql, $val_array2);
















                // $sql_new = "INSERT INTO `product_size` ( `prosiz_name`,`prosiz_prodet_id`, `prosiz_cur_id`,`prosiz_price`,`sizeGroup` ) VALUES (?,?,?,?,?)";

                // $this->dbF->prnt($val_array2);

                

            }else{

                $qry2=0;

            }



            $qry=$qry1+$qry2;

            if ($qry > 0) return $qry;

            else return false;

        }

    }



    private function set_scales_weight(){

            global $con;
    global $conIntra;



        $migrate_products = $this->functions->ibms_setting('migrate_product_to_ch');
        $migrate_product_to_intranet = $this->functions->ibms_setting('migrate_product_to_intranet');

        if (isset($_POST['sizeWeightName']) && !empty($_POST['sizeWeightName'])) {

            $pId = $this->pid;

            foreach($_POST['sizeWeightName'] as $key => $sizeName){

                $sizeWeight = $_POST['sizeWeight'][$key];

                $sizeWeight = floatval($sizeWeight);



                if($sizeName!='' && $sizeWeight != ''){

                    $hash = "$pId:$sizeName:$sizeWeight";

                    $hash = md5($hash);



                    $sql = "INSERT INTO `product_size_weight` (`pwPId`, `pw_size`, `pw_weight`, `pw_unique`)

                              SELECT * FROM ( SELECT ?,?,?,?) AS tmp

                                WHERE NOT EXISTS ( SELECT pw_unique FROM product_size_weight WHERE pw_unique= ?)

                                  LIMIT 1";

                    $arry = array($pId,$sizeName,$sizeWeight,$hash,$hash);

                    $this->dbF->setRow($sql,$arry);



                    if(!empty($migrate_products) && $migrate_products == 1){

                        $new_id = 'ss'.$pId;

                        $hash1 = "$new_id:$sizeName:$sizeWeight";

                        $hash1 = md5($hash1);



                        $arry1 = array($new_id,$sizeName,$sizeWeight,$hash,$hash);

                        $con->setRow($sql,$arry1);

                    }




                    if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){

                        // $new_id = 'ss'.$pId;
                        $new_id = $pId;

                        $hash1 = "$new_id:$sizeName:$sizeWeight";

                        $hash1 = md5($hash1);



                        $arry1 = array($new_id,$sizeName,$sizeWeight,$hash,$hash);

                        $conIntra->setRow($sql,$arry1);

                    }



                }

            }

        } // If end

    } // set_scale_weight



    private function getset_scales()

    {

            global $con;
    global $conIntra;



        $migrate_products = $this->functions->ibms_setting('migrate_product_to_ch');
        $migrate_product_to_intranet = $this->functions->ibms_setting('migrate_product_to_intranet');

        $priceCalc = $this->functions->ibms_setting('priceCalc');
        $priceCalc = unserialize($priceCalc);

        @$country_fr     = $priceCalc['country'][0];
        @$fr_divide      = $priceCalc['divide'][0];
        @$fr_multiply    = $priceCalc['multiply'][0];

        @$country_de     = $priceCalc['country'][1];
        @$de_divide      = $priceCalc['divide'][1];
        @$de_multiply    = $priceCalc['multiply'][1];

        @$country_nl     = $priceCalc['country'][2];
        @$nl_divide      = $priceCalc['divide'][2];
        @$nl_multiply    = $priceCalc['multiply'][2];

        @$country_us     = $priceCalc['country'][3];
        @$us_divide      = $priceCalc['divide'][3];
        @$us_multiply    = $priceCalc['multiply'][3];

        @$country_be     = $priceCalc['country'][4];
        @$be_divide      = $priceCalc['divide'][4];
        @$be_multiply    = $priceCalc['multiply'][4];

        @$country_uk     = $priceCalc['country'][5];
        @$uk_divide      = $priceCalc['divide'][5];
        @$uk_multiply    = $priceCalc['multiply'][5];

        @$country_es     = $priceCalc['country'][6];
        @$es_divide      = $priceCalc['divide'][6];
        @$es_multiply    = $priceCalc['multiply'][6];

        @$country_at     = $priceCalc['country'][7];
        @$at_divide      = $priceCalc['divide'][7];
        @$at_multiply    = $priceCalc['multiply'][7];

        @$country_it     = $priceCalc['country'][8];
        @$it_divide      = $priceCalc['divide'][8];
        @$it_multiply    = $priceCalc['multiply'][8];

        @$country_chf    = $priceCalc['country'][9];
        @$chf_divide     = $priceCalc['divide'][9];
        @$chf_multiply   = $priceCalc['multiply'][9]; 

        @$country_other  = $priceCalc['country'][10];
        @$other_divide   = $priceCalc['divide'][10];
        @$other_multiply = $priceCalc['multiply'][10];

        if (isset($_POST[$this->prefix_scaleCheckBox]) && !empty($_POST[$this->prefix_scaleCheckBox])) {



            $pid = $this->pid;

            $val_array = array();

            $val_array1 = array();



            $sql = "INSERT " . " INTO `product_size` (

                `prosiz_name`,`prosiz_prodet_id`,

                `prosiz_cur_id`,`prosiz_price`,`sizeGroup`

            ) VALUES ";



            foreach ($_POST[$this->prefix_scaleCheckBox] as $key => $val) {

                $postvar_name = $val . "-" . $this->prefix_scaleName;

                $postvar_cost = $val . "-" . $this->prefix_scaleCost;



                $scale_name = $_POST[$postvar_name];



                foreach ($_POST[$postvar_cost] as $key2 => $val2) {

                    $sql .= " (?,?,?,?,?) ,";

                    $val_array[] = $scale_name;

                    $val_array[] = $pid;

                    $val_array[] = intval($key2);

                    $val_array[] = doubleval($val2);

                    $val_array[] = intval($_POST['sizeGroup_scale']);

                }

            }

            $sql = trim($sql, ",");

            $qry = $this->dbF->setRow($sql, $val_array);





            if($qry > 0){

                if(!empty($migrate_products) && $migrate_products == 1){

                    $new_pid = 'ss'.$pid;


                    $sql_get = "SELECT * FROM `product_size` WHERE `prosiz_prodet_id` = '$pid' AND `prosiz_cur_id` = 20";

                    $res = $this->dbF->getRows($sql_get);

                    foreach ($res as $key => $value) {



                        $sql_getdk = "SELECT * FROM `product_size` WHERE `prosiz_prodet_id` = '$pid' AND `prosiz_cur_id` = 24 AND `prosiz_name` = '$value[prosiz_name]'";

                        $res_dk = $this->dbF->getRow($sql_getdk);



                        $prosiz_id      = 'ss'.$res_dk['prosiz_id'];

                        $prosiz_name    = $value['prosiz_name'];

                        $prosiz_prodet_id = 'ss'.$value['prosiz_prodet_id'];

                        $prosiz_cur_id  = $value['prosiz_cur_id'];


                        $fr_price       = doubleval(($value['prosiz_price']/$fr_divide)*$fr_multiply);
                        $fr_price       = ceil($fr_price);
                        $fr_prosiz      = 'ssfr'.$res_dk['prosiz_id'];

                        $de_price       = doubleval(($value['prosiz_price']/$de_divide)*$de_multiply);
                        $de_price       = ceil($de_price);
                        $de_prosiz      = 'ssde'.$res_dk['prosiz_id'];

                        $nl_price       = doubleval(($value['prosiz_price']/$nl_divide)*$nl_multiply);
                        $nl_price       = ceil($nl_price);
                        $nl_prosiz      = 'ssnl'.$res_dk['prosiz_id'];

                        $us_price       = doubleval(($value['prosiz_price']/$us_divide)*$us_multiply);
                        $us_price       = ceil($us_price);
                        $us_prosiz      = 'ssus'.$res_dk['prosiz_id'];

                        $be_price       = doubleval(($value['prosiz_price']/$be_divide)*$be_multiply);
                        $be_price       = ceil($be_price);
                        $be_prosiz      = 'ssbe'.$res_dk['prosiz_id'];

                        $uk_price       = doubleval(($value['prosiz_price']/$uk_divide)*$uk_multiply);
                        $uk_price       = ceil($uk_price);
                        $uk_prosiz      = 'ssuk'.$res_dk['prosiz_id'];

                        $es_price       = doubleval(($value['prosiz_price']/$es_divide)*$es_multiply);
                        $es_price       = ceil($es_price);
                        $es_prosiz      = 'sses'.$res_dk['prosiz_id'];

                        $at_price       = doubleval(($value['prosiz_price']/$at_divide)*$at_multiply);
                        $at_price       = ceil($at_price);
                        $at_prosiz      = 'ssat'.$res_dk['prosiz_id'];

                        $it_price       = doubleval(($value['prosiz_price']/$it_divide)*$it_multiply);
                        $it_price       = ceil($it_price);
                        $it_prosiz      = 'ssit'.$res_dk['prosiz_id'];

                        $other_price    = doubleval(($value['prosiz_price']/$other_divide)*$other_multiply);
                        $other_price    = ceil($other_price);
                        $other_prosiz   = 'ssot'.$res_dk['prosiz_id'];

                        $chf_price      = doubleval(($value['prosiz_price']/$chf_divide)*$chf_multiply);
                        $chf_price      = ceil($chf_price);


                        $prosiz_price   = doubleval(($value['prosiz_price']/$chf_divide)*$chf_multiply);

                        $prosiz_price   = ceil($prosiz_price);

                        $sizeGroup      = $value['sizeGroup'];



                        $new_array1 = array($prosiz_id,$prosiz_name,$prosiz_prodet_id,$prosiz_cur_id,$prosiz_price,$sizeGroup);

                        $sql_new = "INSERT " . " INTO `product_size` (

                                        `prosiz_id`,`prosiz_name`,`prosiz_prodet_id`,

                                        `prosiz_cur_id`,`prosiz_price`,`sizeGroup`

                                    ) VALUES 
                                    ('$prosiz_id','$prosiz_name','$prosiz_prodet_id',$country_chf,'$chf_price','$sizeGroup'),

                                    ('$fr_prosiz','$prosiz_name','$prosiz_prodet_id',$country_fr,'$fr_price','$sizeGroup'),

                                    ('$de_prosiz','$prosiz_name','$prosiz_prodet_id',$country_de,'$de_price','$sizeGroup'),

                                    ('$nl_prosiz','$prosiz_name','$prosiz_prodet_id',$country_nl,'$nl_price','$sizeGroup'),

                                    ('$us_prosiz','$prosiz_name','$prosiz_prodet_id',$country_us,'$us_price','$sizeGroup'),

                                    ('$be_prosiz','$prosiz_name','$prosiz_prodet_id',$country_be,'$be_price','$sizeGroup'),

                                    ('$uk_prosiz','$prosiz_name','$prosiz_prodet_id',$country_uk,'$uk_price','$sizeGroup'),

                                    ('$es_prosiz','$prosiz_name','$prosiz_prodet_id',$country_es,'$es_price','$sizeGroup'),

                                    ('$at_prosiz','$prosiz_name','$prosiz_prodet_id',$country_at,'$at_price','$sizeGroup'),

                                    ('$it_prosiz','$prosiz_name','$prosiz_prodet_id',$country_it,'$it_price','$sizeGroup'),

                                    ('$other_prosiz','$prosiz_name','$prosiz_prodet_id',$country_other,'$other_price','$sizeGroup')";



                        $res2 = $con->setRow($sql_new);

                    }

                }











                if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){

                    // $new_pid = 'ss'.$pid;
                    $new_pid = $pid;


                    $sql_get = "SELECT * FROM `product_size` WHERE `prosiz_prodet_id` = '$pid' AND `prosiz_cur_id` = 20";

                    $res = $this->dbF->getRows($sql_get);

                    foreach ($res as $key => $value) {



                        $sql_getdk = "SELECT * FROM `product_size` WHERE `prosiz_prodet_id` = '$pid' AND `prosiz_cur_id` = 24 AND `prosiz_name` = '$value[prosiz_name]'";

                        $res_dk = $this->dbF->getRow($sql_getdk);



                        $prosiz_id      = $res_dk['prosiz_id'];

                        $prosiz_name    = $value['prosiz_name'];

                        $prosiz_prodet_id = $value['prosiz_prodet_id'];

                        $prosiz_cur_id  = $value['prosiz_cur_id'];


                        $fr_price       = doubleval(($value['prosiz_price']/$fr_divide)*$fr_multiply);
                        $fr_price       = ceil($fr_price);
                        $fr_prosiz      = 'fr'.$res_dk['prosiz_id'];

                        $de_price       = doubleval(($value['prosiz_price']/$de_divide)*$de_multiply);
                        $de_price       = ceil($de_price);
                        $de_prosiz      = 'de'.$res_dk['prosiz_id'];

                        $nl_price       = doubleval(($value['prosiz_price']/$nl_divide)*$nl_multiply);
                        $nl_price       = ceil($nl_price);
                        $nl_prosiz      = 'nl'.$res_dk['prosiz_id'];

                        $us_price       = doubleval(($value['prosiz_price']/$us_divide)*$us_multiply);
                        $us_price       = ceil($us_price);
                        $us_prosiz      = 'us'.$res_dk['prosiz_id'];

                        $be_price       = doubleval(($value['prosiz_price']/$be_divide)*$be_multiply);
                        $be_price       = ceil($be_price);
                        $be_prosiz      = 'be'.$res_dk['prosiz_id'];

                        $uk_price       = doubleval(($value['prosiz_price']/$uk_divide)*$uk_multiply);
                        $uk_price       = ceil($uk_price);
                        $uk_prosiz      = 'uk'.$res_dk['prosiz_id'];

                        $es_price       = doubleval(($value['prosiz_price']/$es_divide)*$es_multiply);
                        $es_price       = ceil($es_price);
                        $es_prosiz      = 'es'.$res_dk['prosiz_id'];

                        $at_price       = doubleval(($value['prosiz_price']/$at_divide)*$at_multiply);
                        $at_price       = ceil($at_price);
                        $at_prosiz      = 'at'.$res_dk['prosiz_id'];

                        $it_price       = doubleval(($value['prosiz_price']/$it_divide)*$it_multiply);
                        $it_price       = ceil($it_price);
                        $it_prosiz      = 'it'.$res_dk['prosiz_id'];

                        $other_price    = doubleval(($value['prosiz_price']/$other_divide)*$other_multiply);
                        $other_price    = ceil($other_price);
                        $other_prosiz   = 'ot'.$res_dk['prosiz_id'];

                        $chf_price      = doubleval(($value['prosiz_price']/$chf_divide)*$chf_multiply);
                        $chf_price      = ceil($chf_price);


                        $prosiz_price   = doubleval(($value['prosiz_price']/$chf_divide)*$chf_multiply);

                        $prosiz_price   = ceil($prosiz_price);

                        $sizeGroup      = $value['sizeGroup'];



                        $new_array1 = array($prosiz_id,$prosiz_name,$prosiz_prodet_id,$prosiz_cur_id,$prosiz_price,$sizeGroup);

                        $sql_new = "INSERT " . " INTO `product_size` (

                                        `prosiz_id`,`prosiz_name`,`prosiz_prodet_id`,

                                        `prosiz_cur_id`,`prosiz_price`,`sizeGroup`

                                    ) VALUES 
                                    ('$prosiz_id','$prosiz_name','$prosiz_prodet_id',$country_chf,'$chf_price','$sizeGroup'),

                                    ('$fr_prosiz','$prosiz_name','$prosiz_prodet_id',$country_fr,'$fr_price','$sizeGroup'),

                                    ('$de_prosiz','$prosiz_name','$prosiz_prodet_id',$country_de,'$de_price','$sizeGroup'),

                                    ('$nl_prosiz','$prosiz_name','$prosiz_prodet_id',$country_nl,'$nl_price','$sizeGroup'),

                                    ('$us_prosiz','$prosiz_name','$prosiz_prodet_id',$country_us,'$us_price','$sizeGroup'),

                                    ('$be_prosiz','$prosiz_name','$prosiz_prodet_id',$country_be,'$be_price','$sizeGroup'),

                                    ('$uk_prosiz','$prosiz_name','$prosiz_prodet_id',$country_uk,'$uk_price','$sizeGroup'),

                                    ('$es_prosiz','$prosiz_name','$prosiz_prodet_id',$country_es,'$es_price','$sizeGroup'),

                                    ('$at_prosiz','$prosiz_name','$prosiz_prodet_id',$country_at,'$at_price','$sizeGroup'),

                                    ('$it_prosiz','$prosiz_name','$prosiz_prodet_id',$country_it,'$it_price','$sizeGroup'),

                                    ('$other_prosiz','$prosiz_name','$prosiz_prodet_id',$country_other,'$other_price','$sizeGroup')";



                        $res2 = $conIntra->setRow($sql_new);

                    }

                }




            return $qry;

            } 

            else return false;

        }

    }



    /*****************************************************/





    public function createPricingViewSystem()

    {

        global $_e;

        $countryCodeList = $this->functions->countrylist();



                echo "<div class='table-responsive '><table class='table table-striped table-hover'>

                <thead>

                    <tr>

                        <th>". _uc($_e['Country (Currency)']) ."</th>

                        <th>". _uc($_e['Price']) ."</th>

                        <th style='white-space: nowrap'>". _uc($_e['International Shipping']) ."</th>

                    </tr>

                </thead>

                ";



        foreach ($this->c_currency->getList() as $data) {

            $country_name = $countryCodeList[$data['cur_country']];

            $currency = $data["cur_name"];

            $symbol = $data['cur_symbol'];

            $currency_id = $data['cur_id'];



            $ePrice="";

            $eShip="";



            if($this->prefix_editPro!=""){

        // If product is edit mode

                $eId=$this->editPid;

                $qry="SELECT * FROM  `product_price` WHERE `propri_prodet_id` = '$eId' AND `propri_cur_id` = '$currency_id'";

                $eData=$this->dbF->getRow($qry);

                if($this->dbF->rowCount>0){

                    $ePrice=$eData['propri_price'];

                    if($eData['propri_intShipping']=='1'){

                        $eShip='checked';

                    }

                }

            }



            echo "

            <tr>

                <td style='white-space: nowrap;'>

                    $country_name ($currency):

                </td>



                <td>

                    <div class='input-group input-group-sm'>

                        <span class='input-group-addon'>$symbol</span>

                        <input type='text' pattern='\d+(\.\d+)?' value='$ePrice' name='$this->prefix_currencyArray[$currency_id]' class='form-control' placeholder='00.00'>

                    </div>

                </td>



                <td style='text-align: center;'>

                    <div class='make-switch' data-on='success' data-off='danger' >

                        <input type='checkbox' value='1' $eShip  name='intShipping_$currency_id' >

                    </div>

                </td>

            </tr>

            ";

        }

        echo "</table></div> ";

    }



    public function discountPriceArrayFind($data,$findKey,$returnKey,$page){

        $find   =    'product_dis_curr_Id';

        if($page=='saleForm'){

            $find   =    'pSale_price_curr_Id';

        }



        foreach($data as $val){

            if($val[$find] == $findKey){

                return $val[$returnKey];

            }

        }

        return '';

    }



    public function discountPricingViewSystem($page='add',$edit=false,$priceData=false)

    {



        global $_e;

        $countryCodeList = $this->functions->countrylist();

            echo "<div class='table-responsive '><table class='table table-striped table-hover'>

                <thead>

                    <tr>

                        <th>". _uc($_e['Country (Currency)']) ."</th>

                        <th>". _uc($_e['Price/Percent']) ."</th>

                        <th style='white-space: nowrap'>". _uc($_e['Discount']) ."</th>

                    </tr>

                </thead>

                ";



        foreach ($this->c_currency->getList() as $data) {

            $country_name = $countryCodeList[$data['cur_country']];

            $currency = $data["cur_name"];

            $symbol = $data['cur_symbol'];

            $currency_id = $data['cur_id'];



            $ePrice="";

            $eShip="";



            if($edit){

                // If product is edit mode

                $eData=$priceData;

                if($page=='saleForm'){

                    $ePrice     =   $this->discountPriceArrayFind($eData,$currency_id,'pSale_price_price',$page);

                    if($this->discountPriceArrayFind($eData,$currency_id,'pSale_price_intShipping',$page)=='1'){

                        $eShip='checked';

                    }



                }else{

                    $ePrice     =   $this->discountPriceArrayFind($eData,$currency_id,'product_dis_price',$page);

                    if($this->discountPriceArrayFind($eData,$currency_id,'product_dis_intShipping',$page)=='1'){

                        $eShip='checked';

                    }

                }

            }





            echo "

            <tr>

                <td style='white-space: nowrap;'>

                    $country_name ($currency):

                </td>



                <td>

                    <div class='input-group input-group-sm'>

                        <span class='input-group-addon'>$symbol</span>

                        <input type='text' pattern='\d+(\.\d{2})?' value='$ePrice' name='$this->prefix_currencyArray[$currency_id]' class='form-control' placeholder='00.00'>

                    </div>

                </td>



                <td style='text-align: center;'>

                    <div class='make-switch' data-on='success' data-off='danger' >

                        <input type='checkbox' value='1' $eShip  name='intShipping_$currency_id' >

                    </div>

                </td>

            </tr>

            ";

        }

        echo "</table></div> ";

    }

    /************************************/

    public function createListOfcategory()

    {

        $this->catTree_starter();

    }



    private function catTree_starter($under_id = 0)

    {



    }





    /************************************/

    public function customSizeArrayFilter($data,$country_id){

        foreach($data as $key=>$val){

            if($val['currencyId'] == $country_id){

                return $val['price'];

            }

        }

        return "";

    }







    public function createListOfCustomSize()

    {

        //old data.

        $isEdit=false;

        if($this->editPid!=""){

            $isEdit=true;

            $pId = $this->editPid;

        }



        $dataOld = array();

        if($isEdit){

            $sql = "SELECT * FROM product_size_custom WHERE `pId` = '$pId'";

            $dataOld = $this->dbF->getRows($sql);

        }



        $format = '<div class="form-group">

                        <label class="col-sm-2 control-label">{{label}}</label>

                        <div class="col-sm-10">

                            {{form}}

                        </div>

                    </div>';



        global $_e;

        $divs = '';

        $form_fields = array();

        if($this->functions->developer_setting('product_customSize')=='1') {

            $countryCodeList    = $this->functions->countrylist(); // country list

            $currency_data      = $this->c_currency->getList(); // get currency list



            $customTypeArray = array();

            //get list of options in custom size table

            $sql    =   "SELECT * FROM `p_custom` WHERE publish = '1'";

            $data   =   $this->dbF->getRows($sql);



            $customTypeArray = array();

            if($this->dbF->rowCount>0) {

                $customTypeArray['value'] = "0";

                $customTypeArray['option'] = "----------";

                $customTypeArray = $this->functions->getSelectValueAndOptions($data, 'id', 'custom_type', false, $customTypeArray);

                @$formVal    = $dataOld[0]['type_id'];

                if(empty($formVal)) $formVal = 0;

                $form_fields[] = array(

                    'label' => _uc($_e['Custom Size Type']),

                    'name'  => 'custom[type_id]',

                    'select' => "$formVal",

                    'value'  => $customTypeArray['value'],

                    'option' => $customTypeArray['option'],

                    'type'  => 'select',

                    'class' => 'form-control',

                );

                $this->functions->print_form($form_fields,$format);

                $form_fields = array();

                $tds    = "<td></td>";

                $tds2   = "<td></td>";

                foreach ($currency_data as $data) {

                    $country_id     = $data['cur_id'];

                    $symbol         = $data['cur_symbol'];

                    $country_name   = $countryCodeList[$data['cur_country']];

                    $currency       = $data["cur_name"];

                    $tds .= "<td>$country_name ($currency)</td>";

                    $curOldPrice    = $this->customSizeArrayFilter($dataOld,$country_id);

                    $tds2 .= '<td>

                                    <div class="input-group input-group-sm">

                                      <span class="input-group-addon">'.$symbol.'</span>

                                      <input type="text" class="form-control" value="'.$curOldPrice.'" name="custom[currencyId]['.$country_id.']" >

                                    </div>

                                </td> ';

                }



                $form_fields[] = array(

                    'format' => "<tr>$tds</tr>"

                );

                $form_fields[] = array(

                    'format' => "<tr>$tds2</tr>"

                );

                $form_fields['main'] = array(

                    'type' => 'main',

                    'format' => "<table class='table table-striped table-hover'>{{form}}</table>"

                );

                $format = "{{form}}";



                $this->functions->print_form($form_fields,$format);



                //echo $divs;

            }





           // $this->customScaleListFormate($data);

        }

    }



    /**

     *

    */

    public function createListOfScales()

    {

        $data = $this->c_scale->getDataSQL();

       $this->scaleListFormate($data);

    }



    /**

     * @param $pId

     * @return bool|MultiArray

     */

    public function scalesWeightEcho($pId){

        $sql = "SELECT * FROM product_size_weight WHERE pwPId = '$pId' ORDER BY id";

        $data = $this->dbF->getRows($sql);

        if($this->dbF->rowCount>0)

            return $data;

        return false;

    }

    /**

     *

     */

    public function createListOfScalesWeight(){

        global $_e;

        $temp1  = _uc($_e['Size Name']);

        $temp2  = ($_e['Weight In KG']);

        echo '<table class="col-sm-24 col-md-10 table" id="sizeWeightDiv">';

        //Edit Section

        $isEdit=false;

        if($this->editPid!=""){

            $pId=$this->editPid;

            $isEdit=true;

            $eData=$this->scalesWeightEcho($pId);

            if($eData==false){$eData=array();}





            foreach($eData as $data){

              echo <<<HTML

        <tr>

            <td>

                <div class="input-group input-group-sm">

                     <span class="input-group-addon">$temp1</span>

                     <input type="text" class="form-control" value="$data[pw_size]" name="sizeWeightName[$data[id]]" placeholder="$temp1">

                </div>

           </td>

           <td>

                <div class="input-group input-group-sm">

                     <span class="input-group-addon">$temp2</span>

                     <input type="text" class="form-control" value="$data[pw_weight]" name="sizeWeight[$data[id]]" placeholder="$temp2,e.g: 200,2,0.2">

                </div>

           </td>

        </tr>

HTML;

            } //foreach end

        } /// edit if end

        //Edit Section End





        $temp3 = _uc($_e['Add More Weight']);

        echo <<<HTML

        <tr>

        <td>

            <div class="input-group input-group-sm">

                 <span class="input-group-addon">$temp1</span>

                 <input type="text" class="form-control" value="" name="sizeWeightName[0]" placeholder="$temp1">

            </div>

       </td>

       <td>

            <div class="input-group input-group-sm">

                 <span class="input-group-addon">$temp2</span>

                 <input type="text" class="form-control" value="" name="sizeWeight[0]" placeholder="$temp2,e.g: 200,2,0.2">

            </div>

       </td>

        </tr>

        </table>



        <div class="clearfix"></div>



<button type="button" class="btn btn-info " onclick="addWeightSlot()">$temp3</button>



HTML;



    }



    /**

     * @param string $var

     */

    public function currencyListJson($var = "cdata")

    {



        $countryCodeList = $this->functions->countrylist();

        $currency_data = $this->c_currency->getList();



        $cur_Data = array();

        foreach ($currency_data as $data) {

            $country_id = $data['cur_id'];

            $country_name = $countryCodeList[$data['cur_country']];

            $currency = $data["cur_name"];

            $symbol = $data['cur_symbol'];



            $cur_Data[] = array(

                "id" => $country_id,

                "country" => $country_name,

                "name" => $currency,

                "symbol" => $symbol

            );

        }

        $cur_json = json_encode($cur_Data);

        echo <<<HTML

<script type="text/javascript">

var $var = $cur_json;

</script>

HTML;



    }





    /**

     * @param $pidKey

     * @param $group

     * @param $array

     * @param $returnKey

     * @return string

     *

     */

    private function searchInArrayGroup($pidKey,$group,$array,$returnKey) {

        foreach ($array as $key2 => $val) {

            if ($val['sizeGroup'] == $group && $val[$pidKey] == $this->editPid) {

                return $val[$returnKey];

            }

        }

        return "";

    }



    /**

     * @param $pidKey

     * @param $group

     * @param $search

     * @param $key

     * @param $array

     * @param $returnKey

     * @return string

     */

    private function searchInArray($pidKey,$group,$search,$key,$array,$returnKey) {

        foreach ($array as $key2 => $val) {

            if ($val[$key] == $search && $val['sizeGroup'] == $group && $val[$pidKey] == $this->editPid) {

                return $val[$returnKey];

            }

        }

        return "";

    }



    /**

     * @param $pidKey

     * @param $search

     * @param $key

     * @param $array

     * @param $returnKey

     * @return string

     */

    private function searchInArrayLeftItem($pidKey,$search,$key,$array,$returnKey) {

        foreach ($array as $key2 => $val) {

            if ($val[$key] == $search && $val[$pidKey] == $this->editPid) {

                return $val[$returnKey];

            }

        }

        return "";

    }



    /**

     * @param $pidKey

     * @param $group

     * @param $match1

     * @param $match2

     * @param $key

     * @param $key2

     * @param $array

     * @param $returnKey

     * @return string

     */

    private function searchInArray2($pidKey,$group,$match1,$match2,$key,$key2,$array,$returnKey) {

        foreach ($array as $keya => $val) {

            if ($val[$key] == $match1 && $val[$key2] == $match2 && $val['sizeGroup'] == $group && $val[$pidKey] == $this->editPid) {

                return $val[$returnKey];

            }

        }

        return "";

    }



    /**

     * @param $pidKey

     * @param $match1

     * @param $match2

     * @param $key

     * @param $key2

     * @param $array

     * @param $returnKey

     * @return string

     */

    private function searchInArray2LeftItems($pidKey,$match1,$match2,$key,$key2,$array,$returnKey) {

        foreach ($array as $keya => $val) {

            if ($val[$key] == $match1 && $val[$key2] == $match2 && $val[$pidKey] == $this->editPid) {

                return $val[$returnKey];

            }

        }

        return "";

    }



    private function scaleListFormateEdit() {



        if($this->prefix_editPro!=""){

            // If product is edit mode

            $eId=$this->editPid;

            $qry="SELECT * FROM  `product_size` WHERE `prosiz_prodet_id` = '$eId'";

            $eData=$this->dbF->getRows($qry);

            return $eData;

        }else{

            return false;

        }

    }





    private function scaleListFormateOld($data)

    {



        global $_e;

        if (is_array($data)) {

            $isEdit=false;

            //Edit Section

            $eData=$this->scaleListFormateEdit();

            if($eData)$isEdit=true;

            //Edit Section End





            $countryCodeList = $this->functions->countrylist(); // country list

            $currency_data = $this->c_currency->getList(); // get currency list



            $options = "<option>". _uc($_e['Select Scale Group']) ."</option>";

            $divs = "";

            foreach ($data as $val) {



                $name = $val["name"];

                $scale = $val["scale"];



                //Edit Section

                $sel="";

                if($isEdit){

                    if($this->searchInArrayGroup('prosiz_prodet_id',$name['scaleName_id'],$eData,'sizeGroup')){

                        $sel="selected=selected";

                    }

                }//Edit Section End



                $options .= "<option $sel value='$name[scaleName_id]'>$name[scaleName_name]</option>";



                $divs .= "<div id='divScaleVal$name[scaleName_id]' class='classScaleVal table-responsive'>

                    <table class='table table-striped table-hover'>

                    <tr>

                        <td></td> ";



                $cur_id_array = array();

                $cur_name_array = array();

                foreach ($currency_data as $data) {

                    //print top scale county name.. first TR

                    $country_id = $data['cur_id'];

                    $country_name = $countryCodeList[$data['cur_country']];

                    $currency = $data["cur_name"];

                    $symbol = $data['cur_symbol'];



                    $cur_id_array[] = $country_id;

                    $cur_name_array[] = "$country_name ($currency)";



                    $divs .= "<td>$country_name ($currency)</td>";

                }



                $divs .= "</tr>";



                foreach ($scale as $sc) {

                    // print scale name with price

                    $rowId = "sc_".$name['scaleName_id']."_".$sc['scale_id']; // sc_parentID_selfId



                    // scale first td checkbox



                    //Edit Section

                    $checked="";

                    if($isEdit){

                        if($this->searchInArray('prosiz_prodet_id',$name['scaleName_id'],$sc['scale_name'],'prosiz_name',$eData,'prosiz_timeStamp')){

                            $checked="checked";

                            echo "<style>

                                    #divScaleVal".$name['scaleName_id']."{

                                    display:block;}

                                   </style>";

                        }

                    }//Edit Section End



                    $divs .= <<<HTML

                    <tr>

                        <td>

                        <label>

                            <input type="checkbox" $checked value="$rowId" data-name="$this->prefix_scaleCheckBox[]">

                            <input type="hidden" value="$sc[scale_name]" data-name="$rowId-$this->prefix_scaleName">

                                $sc[scale_name]

                        </label>

                        </td>

HTML;





                    $cur_Data = array();

                    foreach ($currency_data as $data) {

                        // print input field

                        $country_id = $data['cur_id'];

                        $country_name = $countryCodeList[$data['cur_country']];

                        $currency = $data["cur_name"];

                        $symbol = $data['cur_symbol'];



                        $cur_Data[] = array(

                            "id" => $country_id,

                            "country" => $country_name,

                            "name" => $currency,

                            "symbol" => $symbol

                        );



                        //Edit Section

                        $ePrice="";

                        if($isEdit){

                            $ePrice=$this->searchInArray2('prosiz_prodet_id',$name['scaleName_id'], $sc['scale_name'],$country_id,'prosiz_name','prosiz_cur_id', $eData,'prosiz_price');

                        }//Edit Section End



                        $divs .= <<<HTML

                        <td>

                            <div class="input-group input-group-sm">

                              <span class="input-group-addon">$symbol</span>

                              <input type="text" class="form-control" value="$ePrice" data-name="$rowId-$this->prefix_scaleCost[$country_id]" >

                            </div>

                        </td>

HTML;

                    }



                    $divs .= "</tr>";

                }

                $divs .= "</table>

                </div>";



            }



            echo <<<HTML

          <style>

              .classScaleVal{

                display: none;

              }

          </style>

<script type="text/javascript">







        function seleScale(id){

            var iid = id;

            var divId = "#divScaleVal"+iid;

            $(".classScaleVal input[data-name]").attr("name",null);

            $(".classScaleVal").hide(0,function (){

                $(divId).show(0,function (){

                    $(" input[data-name]",this).each(function  (){

                        var name = $(this).attr("data-name");

                        $(this).attr("name",name);

                    });

                });

            });

        };

</script>



HTML;

            echo "<select id='seleScale' class='selectpicker form-control' name='sizeGroup'>$options</select><br /><br />

                   <script> $(function(){

                                $( '#seleScale' ).selectmenu({

                                    change: function( event, data ) {

                                        seleScale(data.item.value);

                                    }

                                });

                   })</script>";

            echo $divs;



        }

    }



    /**

     * @param $data

     */

    private function scaleListFormate($data)

    {

        global $_e;



        if (is_array($data)) {

            $isEdit=false;

            //Edit Section

            $eData=$this->scaleListFormateEdit();

            if($eData!=false)$isEdit=true;



            //$this->dbF->prnt($eData);



            $uniquename=array();

            $namePrint=array();



            //get all unique scale name in array,

            foreach($eData as $key=>$val){

                if(!in_array ($val['prosiz_name'],$uniquename)){

                    $uniquename[]=$val['prosiz_name'];

                }

            }



         //   $this->dbF->prnt($uniquename);

        //Edit Section End



            $countryCodeList = $this->functions->countrylist(); // country list

            $currency_data = $this->c_currency->getList(); // get currency list



            $options = "<option>". _uc($_e['Select Scale Group']) ."</option>";

            $divs = "";

            foreach ($data as $val) {



                $name = $val["name"];

                $scale = $val["scale"];

                //Edit Section

                $sel="";

                if($isEdit){

                    // which dropdown scale was selected , define here. but currenlty from css it is display none. css is in this function

                    if($this->searchInArrayGroup('prosiz_prodet_id',$name['scaleName_id'],$eData,'sizeGroup')){

                        $sel="selected=selected";

                        $divs .="<script>$(document).ready(function(){

                                    seleScale($name[scaleName_id])

                                    });

                                 </script>";

                    }

                }//Edit Section End



                $options .= "<option $sel value='$name[scaleName_id]'>$name[scaleName_name]</option>";

                $divs .= "<div id='divScaleVal$name[scaleName_id]' class='classScaleVal table-responsive'>

                    <table class='table table-striped table-hover'>

                    <thead>

                    <tr>

                        <th></th> ";



                $cur_id_array = array();

                $cur_name_array = array();

                foreach ($currency_data as $data) {

                    //print top scale county name.. first TR

                    $country_id = $data['cur_id'];

                    $country_name = $countryCodeList[$data['cur_country']];

                    $currency = $data["cur_name"];

                    $symbol = $data['cur_symbol'];



                    $cur_id_array[] = $country_id;

                    $cur_name_array[] = "$country_name ($currency)";



                    $divs .= "<th>$country_name ($currency)</th>";

                }



                $divs .= "</tr></thead><tbody>";

                $scaleId='';

                foreach ($scale as $sc) {

                    //Edit Section

                    $checked="";

                    $saveScaleId=0;



                    if($isEdit){

                        // get previous scale id, so it will be use in updating



                        $saveScaleId = $this->searchInArray('prosiz_prodet_id',$name['scaleName_id'],$sc['scale_name'],'prosiz_name',$eData,'prosiz_id');

                        if($saveScaleId==""){$saveScaleId=0;}



                        //if this array was selected so it is selected

                        if($this->searchInArray('prosiz_prodet_id',$name['scaleName_id'],$sc['scale_name'],'prosiz_name',$eData,'prosiz_timeStamp')){

                            $checked="checked";

                            echo "<style>

                                    #divScaleVal".$name['scaleName_id']."{

                                    display:block;}

                                   </style>";

                        }else{

                            continue; //if scale was not inserted

                            // if you remove continue, all scale group item show, either you were not select

                        }

                    }//Edit Section End



                    //If define scale find so show define group,

                    if(in_array($sc['scale_name'],$uniquename)){

                        $namePrint[]=$sc['scale_name'];

                        $scaleId=$name['scaleName_id'];

                    }

                    //$this->dbF->prnt($eData);

                    // scale first td checkbox



                    @$pro_iddd = $eData[0]['prosiz_prodet_id'];



                    // print scale name with price

                    $rowId = "sc_".$name['scaleName_id']."_".$sc['scale_id']."_".$saveScaleId; // sc_parentID_groupId_scaleSavedId

                    $divs .= <<<HTML

                    <tr class="ui-state-default" id="size_$sc[scale_name]:$pro_iddd">

                        <td>

                        <label>

                            <input type="checkbox" $checked value="$rowId" data-name="$this->prefix_scaleCheckBox[]">

                            <input type="hidden" value="$sc[scale_name]" data-name="$rowId-$this->prefix_scaleName">

                                $sc[scale_name]

                        </label>

                        </td>

HTML;





                    $cur_Data = array();



                    foreach ($currency_data as $data2) {

                        // print input field



                        $country_id = $data2['cur_id'];

                        $country_name = $countryCodeList[$data2['cur_country']];

                        $currency = $data2["cur_name"];

                        $symbol = $data2['cur_symbol'];



                        $cur_Data[] = array(

                            "id" => $country_id,

                            "country" => $country_name,

                            "name" => $currency,

                            "symbol" => $symbol

                        );



                        //Edit Section

                        $ePrice="";

                        if($isEdit){

                            $ePrice=$this->searchInArray2('prosiz_prodet_id',$name['scaleName_id'], $sc['scale_name'],$country_id,'prosiz_name','prosiz_cur_id', $eData,'prosiz_price');

                        }//Edit Section End



                        $divs .= <<<HTML

                        <td>

                            <div class="input-group input-group-sm">

                              <span class="input-group-addon">$symbol</span>

                              <input type="text" class="form-control" value="$ePrice" data-name="$rowId-$this->prefix_scaleCost[$country_id]" >

                            </div>

                        </td>

HTML;

                    }



                    $divs .= "</tr>";

                }





            //    $this->dbF->prnt($namePrint);

             //   $scaleId ='100';

               if($scaleId!="" && $isEdit){

                for($i=0;$i<sizeof($uniquename);$i++){



                    if(!in_array($uniquename[$i],$namePrint))

                    {

                        $saveScaleId=0;

                        if($isEdit){



                            $saveScaleId= $this->searchInArray('prosiz_prodet_id',$name['scaleName_id'],$uniquename[$i],'prosiz_name',$eData,'prosiz_id');

                            if($saveScaleId=="") $saveScaleId=0;

                        }//Edit Section End



                        $rowId = "sc_".$scaleId."_Sav".$i."_".$saveScaleId; // sc_parentID_selfId

                        $divs .= <<<HTML

                        <tr>

                            <td>

                            <label>

                                <input type="checkbox" checked value="$rowId" data-name="$this->prefix_scaleCheckBox[]">

                                <input type="hidden" value="$uniquename[$i]" data-name="$rowId-$this->prefix_scaleName">

                                    $uniquename[$i]

                            </label>

                            </td>

HTML;



                        foreach ($currency_data as $data) {

                            // print input field

                            $country_id = $data['cur_id'];

                            $symbol = $data['cur_symbol'];



                            //Edit Section

                            $ePrice="";

                            if($isEdit){

                                $ePrice=$this->searchInArray2('prosiz_prodet_id',$scaleId, $uniquename[$i],$country_id,'prosiz_name','prosiz_cur_id', $eData,'prosiz_price');

                            }//Edit Section End



                            $divs .= <<<HTML

                            <td>

                                <div class="input-group input-group-sm">

                                  <span class="input-group-addon">$symbol</span>

                                  <input type="text" class="form-control" value="$ePrice" data-name="$rowId-$this->prefix_scaleCost[$country_id]" >

                                </div>

                            </td>

HTML;

                        }



                        $divs .= "</tr>";

                    }

                }

                }



                    $divs .= "</table></tbody>

                 </div>";



            }











            //if no scale print, so left all scale print then upper for loop useless :(

            if(sizeof($uniquename) > 0 && !isset($namePrint[0]) && $isEdit){



                $divs="";

                $divs .= "<div id='divScaleVal' class='table-responsive'>

                    <table class='table table-striped table-hover'>

                    <tr>

                        <td></td> ";



                foreach ($currency_data as $data) {

                    //print top scale county name.. first TR

                    $country_name = $countryCodeList[$data['cur_country']];

                    $currency = $data["cur_name"];

                    $divs .= "<td>$country_name ($currency)</td>";

                }



                $divs .= "</tr>";

                for($i=0;$i<sizeof($uniquename);$i++){



                    if(!in_array($uniquename[$i],$namePrint))

                    {

                        $saveScaleId=0;

                        if($isEdit){

                            $saveScaleId= $this->searchInArrayLeftItem('prosiz_prodet_id',$uniquename[$i],'prosiz_name',$eData,'prosiz_id');

                            if($saveScaleId=="") $saveScaleId=0;

                        }//Edit Section End

                        $scaleId=0;

                        $rowId = "sc_".$scaleId."_Sav".$i."_".$saveScaleId; // sc_parentID_selfId

                        $divs .= <<<HTML

                        <tr>

                            <td>

                            <label>

                                <input type="checkbox" checked value="$rowId" name="$this->prefix_scaleCheckBox[]">

                                <input type="hidden" value="$uniquename[$i]" name="$rowId-$this->prefix_scaleName">

                                    $uniquename[$i]

                            </label>

                            </td>

HTML;



                        foreach ($currency_data as $data) {

                            // print input field

                            $country_id = $data['cur_id'];

                            $symbol = $data['cur_symbol'];



                            //Edit Section

                            $ePrice="";

                            if($isEdit){

                                $ePrice=$this->searchInArray2LeftItems('prosiz_prodet_id', $uniquename[$i],$country_id,'prosiz_name','prosiz_cur_id', $eData,'prosiz_price');

                            }//Edit Section End



                            $divs .= <<<HTML

                            <td>

                                <div class="input-group input-group-sm">

                                  <span class="input-group-addon">$symbol</span>

                                  <input type="text" class="form-control" value="$ePrice" name="$rowId-$this->prefix_scaleCost[$country_id]" >

                                </div>

                            </td>

HTML;

                        }



                        $divs .= "</tr>";



                    }

                }

                $divs .= "</table>

                </div>";

            }









            echo <<<HTML

          <style>

              .classScaleVal{

                display: none;

              }

          </style>

<script type="text/javascript">

        function seleScale(id){

            var iid = id;

            var divId = "#divScaleVal"+iid;

            $(".classScaleVal input[data-name]").attr("name",null);

            $(".classScaleVal").hide(0,function (){

                $(divId).show(0,function (){

                    $(" input[data-name]",this).each(function  (){

                        var name = $(this).attr("data-name");

                        $(this).attr("name",name);

                    });

                });

            });

        };

</script>



HTML;

            if($isEdit)

                $view="style='display:none'";

            else

                $view="id='seleScale'";

            echo "<select  $view class='selectpicker form-control' name='sizeGroup_scale'>
            $options</select><br /><br />

                   <script> $(function(){

                                $( '#seleScale' ).selectmenu({

                                    change: function( event, data ) {

                                        seleScale(data.item.value);

                                    }

                                });

                   })</script> ";

            echo $divs;



        }

    }



    /************************************/





    /************************************/





    private function colorListFormateEdit() {



        if($this->prefix_editPro!=""){

            // If product is edit mode

            $eId=$this->editPid;

            $qry="SELECT * FROM  `product_color` WHERE `proclr_prodet_id` = '$eId'";

            $eData=$this->dbF->getRows($qry);

            return $eData;

        }else{

            return false;

        }

    }





    public function createListOfColor()

    {

        $data = $this->c_color->getDataSQL();

        $this->colorListFormate($data);

    }



    /**

     * @param $data

     */

    private function colorListFormate($data)

    {

        global $_e;

        if (is_array($data)) {



            $isEdit=false;

            //Edit Section

            $eData=$this->colorListFormateEdit();

            if($eData)$isEdit=true;

            $uniquename=array();

            $namePrint=array();

            foreach($eData as $key=>$val){

                if(!in_array ($val['proclr_name'],$uniquename)){

                    $uniquename[]=$val['proclr_name'];

                }

            }

            //Edit Section End









            $countryCodeList = $this->functions->countrylist(); // get country

            $currency_data = $this->c_currency->getList(); //get currency list



            $options = "<option>". _uc($_e['Select Color Group']) ."</option>";

            $divs = "";

            foreach ($data as $val) {

                $name = $val["name"];

                $color = $val["color"];



                //Edit Section

                $sel="";

                if($isEdit){

                    if($this->searchInArrayGroup('proclr_prodet_id',$name['colorName_id'],$eData,'sizeGroup')){

                        $sel="selected=selected";

                        $divs .="<script>$(document).ready(function(){

                                    selecolor($name[colorName_id])

                                    });

                                 </script>";

                    }

                }//Edit Section End



                $options .= "<option $sel value='$name[colorName_id]'>$name[colorName_name]</option>";



                $divs .= "<div id='divcolorVal$name[colorName_id]' class='classcolorVal table-responsive'>

                    <table class='table table-striped table-hover'>

                    <tr>

                        <td></td>

                ";



                foreach ($currency_data as $data) {

                    // print first tr country currency names

                    $country_name = $countryCodeList[$data['cur_country']];

                    $currency = $data["cur_name"];

                    $symbol = $data['cur_symbol'];



                    $divs .= "<td>$country_name ($currency)</td>";

                }



                $divs .= "</tr>";

                // tr country currency names End



                $colorId='';



                foreach ($color as $sc) {



                    //$this->dbF->prnt($sc['color_name']);

                    //Edit Section

                    //Edit section after in_array if, show error, because if color name and define color group are same then

                    //it will go in if condition,, previously it was $isedit are place after in_array if

                    $checked="";

                    $saveScaleId=0;

                    if($isEdit){

                        $saveScaleId    =   $this->searchInArray('proclr_prodet_id',$name['colorName_id'],$sc['color_name'],'proclr_name',$eData,'propri_id');

                        if($saveScaleId==""){$saveScaleId=0;}

                        if($this->searchInArray('proclr_prodet_id',$name['colorName_id'],$sc['color_name'],'proclr_name',$eData,'proclr_timeStamp')){

                            $checked="checked";

                            echo "<style>

                                    #divcolorVal".$name['colorName_id']."{

                                    display:block;}

                                   </style>";

                            //disable color select option,, may be work will go wrong in edit page

                        }else{

                            continue; // if color was not selected

                        }

                    }//Edit Section End



                    if(in_array($sc['color_name'],$uniquename)){

                        $namePrint[]    =   $sc['color_name'];

                        $colorId        =   $name['colorName_id'];

                    }



                    $rowId = "clr_".$name['colorName_id'].'_'.$sc['color_id'].'_'.$saveScaleId; // clr_parentID_selfId

                    // print first td checkbox

                    $divs .= <<<HTML

                    <tr>

                        <td>

                            <label class="color_label">

                                <input type="checkbox" $checked value="$rowId" data-name="$this->prefix_colorCheckBox[]">

                                <input type="hidden" data-name="$rowId-$this->prefix_colorName" value="$sc[color_name]">

                           $sc[color_name] </label>

                        </td>

HTML;



                    foreach ($currency_data as $data) {

                        //print inout field with currency name

                        $country_id     = $data['cur_id'];

                        $country_name   = $countryCodeList[$data['cur_country']];

                        $currency       = $data["cur_name"];

                        $symbol         = $data['cur_symbol'];



                        //Edit Section

                        $ePrice="";



                        if($isEdit){

                            $ePrice=$this->searchInArray2('proclr_prodet_id',$name['colorName_id'], $sc['color_name'],$country_id,'proclr_name','proclr_cur_id', $eData,'proclr_price');

                        }//Edit Section End



                        $divs .= <<<HTML

                            <td>

                                <div class="input-group input-group-sm">

                                  <span class="input-group-addon">$symbol</span>

                                  <input type="text" value="$ePrice" class="form-control" data-name="$rowId-$this->prefix_colorCost[$country_id]" >

                                </div>



                            </td>

HTML;

                    }

                    $divs .= "</tr>";

                }





                if($colorId!=""){

                    for($i=0;$i<sizeof($uniquename);$i++){

                        if(!in_array($uniquename[$i],$namePrint))

                        {

                            $saveScaleId=0;

                            if($isEdit){

                                $saveScaleId= $this->searchInArray('proclr_prodet_id',$name['colorName_id'],$uniquename[$i],'proclr_name',$eData,'propri_id');

                                if($saveScaleId=="") $saveScaleId=0;

                            }//Edit Section End

                            $rowId = "clr_".$colorId."_Sav".$i.'_'.$saveScaleId; // sc_parentID_selfId

                            $divs .= <<<HTML

                        <tr>

                            <td>

                            <label>

                                <input type="checkbox" checked value="$rowId" data-name="$this->prefix_colorCheckBox[]">

                                <input type="hidden" data-name="$rowId-$this->prefix_colorName" value="$uniquename[$i]">

                            $uniquename[$i]

                            </label>

                            </td>

HTML;



                            foreach ($currency_data as $data) {

                                // print input field

                                $country_id = $data['cur_id'];

                                $symbol = $data['cur_symbol'];



                                //Edit Section

                                $ePrice="";

                                if($isEdit){

                                    $ePrice=$this->searchInArray2('proclr_prodet_id',$colorId, $uniquename[$i],$country_id,'proclr_name','proclr_cur_id', $eData,'proclr_price');

                                }//Edit Section End



                                $divs .= <<<HTML

                            <td>

                                <div class="input-group input-group-sm">

                                  <span class="input-group-addon">$symbol</span>

                                  <input type="text" class="form-control" value="$ePrice" data-name="$rowId-$this->prefix_colorCost[$country_id]" >

                                </div>

                            </td>

HTML;

                            }



                            $divs .= "</tr>";

                        }

                    }

                }





                $divs .= "</table>

                </div>";

            }









            if(sizeof($uniquename) > 0 && !isset($namePrint[0]) && $isEdit){

                $divs="";

                $divs .= "<div id='divScaleVal' class='table-responsive'>

                    <table class='table table-striped table-hover'>

                    <tr>

                        <td></td> ";



                foreach ($currency_data as $data) {

                    //print top scale county name.. first TR

                    $country_name = $countryCodeList[$data['cur_country']];

                    $currency = $data["cur_name"];

                    $divs .= "<td>$country_name ($currency)</td>";

                }



                $divs .= "</tr>";

                for($i=0;$i<sizeof($uniquename);$i++){

                    if(!in_array($uniquename[$i],$namePrint))

                    {

                        $saveScaleId=0;

                        if($isEdit){

                            $saveScaleId= $this->searchInArrayLeftItem('proclr_prodet_id',$uniquename[$i],'proclr_name',$eData,'propri_id');

                            if($saveScaleId=="") $saveScaleId=0;

                        }//Edit Section End

                        $colorId='0';

                        $rowId = "clr_".$colorId."_Sav".$i.'_'.$saveScaleId; // sc_parentID_selfId

                        $divs .= <<<HTML

                        <tr>

                            <td>

                            <label>

                                <input type="checkbox" checked value="$rowId" name="$this->prefix_colorCheckBox[]">

                                <input type="hidden" name="$rowId-$this->prefix_colorName" value="$uniquename[$i]">

$uniquename[$i]

                            </label>

                            </td>

HTML;



                        foreach ($currency_data as $data) {

                            // print input field

                            $country_id = $data['cur_id'];

                            $symbol = $data['cur_symbol'];



                            //Edit Section

                            $ePrice="";

                            if($isEdit){

                                $ePrice=$this->searchInArray2LeftItems('proclr_prodet_id', $uniquename[$i],$country_id,'proclr_name','proclr_cur_id', $eData,'proclr_price');

                            }//Edit Section End



                            $divs .= <<<HTML

                            <td>

                                <div class="input-group input-group-sm">

                                  <span class="input-group-addon">$symbol</span>

                                  <input type="text" class="form-control" value="$ePrice" name="$rowId-$this->prefix_colorCost[$country_id]" >

                                </div>

                            </td>

HTML;

                        }



                        $divs .= "</tr>";

                    }

                }

                $divs .= "</table>

                </div>";

            }





            echo <<<HTML

          <style>

              .classcolorVal{

                display: none;

              }

              .colorBox{

                display: inline-block;

                width: 12px;

                height: 12px;

                margin: 0 6px;

              }

          </style>



<script type="text/javascript">

    function selecolor(id){

            var iid = id;

            var divId = "#divcolorVal"+iid;

            $(".classcolorVal input[type='text']").attr("name",null);

            $(".classcolorVal").hide(0,function (){

                $(divId).show(0,function (){

                    $(" input[data-name]",this).each(function  (){

                        var name = $(this).attr("data-name");

                        $(this).attr("name",name);

                    });

                });

            });



        };

</script>



HTML;

            if($isEdit)

                $view="style='display:none'";

            else

                $view="id='selecolor'";

            echo "<select $view class='selectpicker' name='sizeGroup_color'>$options</select> <br /><br />

                    <script> $(function(){

                                $( '#selecolor' ).selectmenu({

                                    change: function( event, data ) {

                                        selecolor(data.item.value);

                                    }

                                });

                   })</script>";

            echo $divs;



        }

    }



    /************************************/
  /****************************************************/

    //my code
    public function productDetail($access){
        $sql="SELECT * FROM `proudct_detail`  WHERE `product_update`='$access' AND `prodet_name` != ''
                ORDER BY `proudct_detail`.`prodet_id` DESC";
        $data = $this->dbF->getRows($sql);
        return $data;
    }

    public function getProductDetail($setting_name,$id){

        $data = $this->dbF->getRow("SELECT setting_val from `product_setting` where p_id='$id' and setting_name='$setting_name'");
        return $data[0];
    }





    public function productView()

    {

       // $qry="SELECT * FROM `proudct_detail` WHERE `product_update` = '1'";

        $qry="SELECT `proudct_detail`.*, `product_setting`.`setting_val`

                FROM

                   `proudct_detail` join `product_setting`

                    on `proudct_detail`.`prodet_id` = `product_setting`.`p_id`

                    WHERE `product_setting`.`setting_name`='publicAccess' AND `product_setting`.`setting_val`='1' AND `proudct_detail`.`product_update`='1'

                    ORDER BY `proudct_detail`.`prodet_id` DESC";

        echo $this->product_list_View($qry);

    }



    public function productDraft()

    {

        $qry="SELECT `proudct_detail`.*, `product_setting`.`setting_val`

                FROM

                   `proudct_detail` join `product_setting`

                    on `proudct_detail`.`prodet_id` = `product_setting`.`p_id`

                    WHERE `product_setting`.`setting_name`='publicAccess' AND `product_setting`.`setting_val`='0' AND `proudct_detail`.`product_update`='1'

                    ORDER BY `proudct_detail`.`prodet_id` DESC";

        echo $this->product_list_View($qry,'draft');



    }



    public function productPending()

    {

       $date=date('m/d/Y');

       $qry="SELECT `proudct_detail`.*, `product_setting`.`setting_val`

                FROM

                   `proudct_detail` join `product_setting`

                    on `proudct_detail`.`prodet_id` = `product_setting`.`p_id`

                    WHERE

                    `product_setting`.`setting_name`='launchDate'

                    AND `product_setting`.`setting_val`>'$date'

                    AND `proudct_detail`.`product_update`='1'

                    ORDER BY `proudct_detail`.`prodet_id` DESC";

        echo $this->product_list_View($qry,'pending');

    }



    /**

     * @param $qry

     */


    private function product_list_View($qry,$page = ''){

        global $_e;

        $data=$this->dbF->getRows($qry);



        # href is used by ajax request

        $href = "product/products_listing_ajax.php?page=active_products";

        $style = 'dTableWidth';



        if($page=='draft'){

            $href = "product/products_listing_ajax.php?page=draft_products";



            $qry="SELECT `proudct_detail`.* FROM `proudct_detail` WHERE `proudct_detail`.`prodet_id` NOT IN (SELECT distinct(p_id) FROM product_setting) AND `proudct_detail`.`product_update`='1'

                    ORDER BY `proudct_detail`.`prodet_id` DESC";

            $data2=$this->dbF->getRows($qry);

            if($this->dbF->rowCount>0){

                $data = array_merge($data,$data2);

            }

            $style = '';

        } elseif ($page == 'pending') {

            $href = "product/products_listing_ajax.php?page=pending_products";

            $style = '';

        }





        $defaultLang= $this->functions->AdminDefaultLanguage();

        if(!empty($data) && $data != false){

            

            



            $uniq=uniqid('id');

            echo  '

            <div class="table-responsive '.$style.'" id="script-width">

            <table class="table table-hover tableIBMS dTable_ajax" data-href="'.$href.'" data-uniq="'.$uniq.'" data-sorting="true">

                <thead>

                    <tr>

                     


                        <th><div class="checkbox delCheckboxOncolvis">

                                    <label>

                                      <input style="display:none !important" type="checkbox" class="checkBoxSelectAll" id="'.$uniq.'" ng-model="'.$uniq.'">'. _u($_e['SNO']) .'

                                    </label>

                                  </div>

                            </th>
                          
                           <th>'. _u($_e['Minimum Stock to Notify']) .'</th>
                                                   
                         
                        <th>'. _u($_e['PRODUCT THUMBNAIL']) .'</th>
                        
                         <th>'. _u($_e['SERIAL NUMBER']) .'</th>

                        <th>'. _u($_e['PRODUCT NAME']) .'</th>

                        <th>'. _u($_e['SHORT DESC']) .'</th>

                        <th>'. _u($_e['CREATE DATE']) .'</th>

                        <th>'. _u($_e['VIEWS']) .'</th>

                        <th>'. _u($_e['SALES']) .'</th>

                        <th>'. _u($_e['ACTION']) .'</th>

                    </tr>

                </thead>

                <tbody>';



                    // $i=0;

                    // foreach($data as $key=>$val){

                    //     $i++;

                    //     $name=unserialize($val['prodet_name']);

                    //     $sDesc=unserialize($val['prodet_shortDesc']);

                    //     $views = $val['view'];

                    //     $sales = $val['sale'];

                    //     $id=$val['prodet_id'];

                    //     $link = $this->functions->getLinkFolder();



                    //     //For featured Item

                    //     $featureProduct = "";

                    //     if($this->functions->developer_setting('featureProduct')=='1') {

                    //         $featureProduct = true;

                    //         $status = $val['feature'];

                    //         if ($status == '1') {

                    //             $class = "glyphicon glyphicon-star";

                    //             $status = '0';

                    //         } else {

                    //             $class = "glyphicon glyphicon-star-empty";

                    //             $status = '1';

                    //         }

                    //         $featureProduct = "<a data-id ='$id' data-val='$status' onclick='featureItem(this);' class='btn'   title='". $_e['Active/DeActive Feature item'] ."'>

                    //                 <i class='$class trash'></i>

                    //                 <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>

                    //             </a>";

                    //     }



                    //     //For Trending Fashion

                    //     $feature2 = "";

                    //     if($this->functions->developer_setting('featureProduct2')=='1') {

                    //         $feature2 = true;

                    //         $statusT = $val['feature'];

                    //         if ($statusT == '2') {

                    //             $classT = "glyphicon glyphicon-heart";

                    //             $statusT = '3';

                    //         } else {

                    //             $classT = "glyphicon glyphicon-heart-empty";

                    //             $statusT = '2';

                    //         }

                    //         $feature2 = "<a data-id ='$id' data-val='$statusT' onclick='trandingItem(this);' class='btn'   title='". $_e['Active/DeActive Feature item2'] ."'>

                    //                 <i class='$classT trash'></i>

                    //                 <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>

                    //             </a>";

                    //     }





                    //     $seoLink = '';

                    //     if($this->functions->developer_setting('seo') == '1'){

                    //         $this->functions->getAdminFile("seo/classes/seo.class.php");

                    //         $seoC = new seo();

                    //         $seoLink = $seoC->seoQuickLink($id,urlencode("/".$this->db->productDetail."$val[slug]"));

                    //     }





                    //     //data-window='new' // use in post link. to open link in new tab

                    //     echo "

                    //     <tr class='p_$id'>

                    //         <td class='tableBgGray'>

                    //             <div class='checkbox'>

                    //                 <label>

                    //                   <input type='checkbox' ng-checked='$uniq' name='productListCheck[]' value='$id'> $i

                    //                 </label>

                    //               </div>

                    //         </td>

                    //         <td>".$name[$defaultLang]."</td>

                    //         <td>".$sDesc[$defaultLang]."</td>

                    //         <td>".$val['prodet_timeStamp']."</td>

                    //         <td>$views</td>

                    //         <td>$sales</td>

                    //         <td class='tableBgGray' width='110'>

                    //             <div class='btn-group btn-group-sm'>

                    //                 $featureProduct

                    //                 $feature2



                    //                 $seoLink



                    //             <a data-id='$id' href='?$this->prefix_editPro=$id'

                    //                 data-method='post' data-action='-$link?page=edit'

                    //                 class='btn'><i class='glyphicon glyphicon-edit'></i></a>

                    //             <a data-id='$id' onclick='AjaxDelScript(this);' class='btn '>

                    //                 <i class='glyphicon glyphicon-trash trash'></i>

                    //                 <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>

                    //             </a>

                    //             </div>

                    //         </td>

                    //     </tr>";

                    // }





            echo <<<HTML

                </tbody>

            </table>

            </div>

HTML;



        }

    }





    /**

     * @return bool|MultiArray

     */

    public function productSettingEdit() {



        if($this->prefix_editPro!=""){

            // If product is edit mode

            $eId=$this->editPid;

            $qry="SELECT * FROM  `product_setting` WHERE `p_id` = '$eId'";

            $eData=$this->dbF->getRows($qry);

            return $eData;

        }else{

            return false;

        }

    }



    /**

     * @param $settingName

     * @param $array

     * @return string

     */

    public function productSettingArray($settingName,$array) {

        // enter setting name and qry execute array.. -> productSettingEdit() array

        foreach ($array as $keya => $val) {

            if ($val['setting_name'] == $settingName && $val['p_id'] == $this->editPid) {

                return $val['setting_val'];

            }

        }

        return "";

    }



    public function productEditImagesMass($idz){

        global $_e;

        // if($this->prefix_editPro!=""){

            // If product is edit mode

            $eId=$this->editPid;

     $qry="SELECT * FROM  `product_image` WHERE `product_id` = '$idz' ORDER BY sort ASC";

            $eData=$this->dbF->getRows($qry);

            if($this->dbF->rowCount>0){



/*                echo "<style>

                            #dropbox .message{

                                    display: none !important;

                            }

                        </style>";*/



                $temp1T = _uc($_e['Enter Alt']);

                $temp2T = _uc($_e['Update']);

                $temp3T = _uc($_e['Remove']);

                foreach($eData as $key=>$val){

                    $img=$val['image'];

                    $imgId=$val['img_id'];

                    $alt = $val['alt'];

                    echo <<<HTML

                    <div class="preview albumPreview" id="image_$imgId">

                            <span class="imageHolder">

                                 <img src="../images/$img" />

                            </span>



                            <div class="progressHolder album" style="">

                                <input type="text" id="alt-$imgId" value="$alt" placeholder="$temp1T" class="form-control" style="margin:3px 0">

                                <a class="pImageAltUpdate$idz  btn btn-default btn-sm" data-id="$imgId" ><span>$temp2T</span>

                                    <i class='glyphicon glyphicon-save trash'></i>

                                    <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>

                                </a>


                            </div>

                        </div>

HTML;

                    }

                }

        // }

    }


    public function productEditImages(){

        global $_e;

        if($this->prefix_editPro!=""){

            // If product is edit mode

            $eId=$this->editPid;

            $qry="SELECT * FROM  `product_image` WHERE `product_id` = '$eId' ORDER BY sort ASC";

            $eData=$this->dbF->getRows($qry);

            if($this->dbF->rowCount>0){



/*                echo "<style>

                            #dropbox .message{

                                    display: none !important;

                            }

                        </style>";*/



                $temp1T = _uc($_e['Enter Alt']);

                $temp2T = _uc($_e['Update']);

                $temp3T = _uc($_e['Remove']);

                foreach($eData as $key=>$val){

                    $img=$val['image'];

                    $imgId=$val['img_id'];

                    $alt = $val['alt'];

                    echo <<<HTML

                    <div class="preview albumPreview" id="image_$imgId">

                            <span class="imageHolder">

                                 <img src="../images/$img" />

                            </span>



                            <div class="progressHolder album">

                                <input type="text" id="alt-$imgId" value="$alt" placeholder="$temp1T" class="form-control" style="margin:3px 0">

                                <a class="pImageAltUpdate  btn btn-default btn-sm" data-id="$imgId" ><span>$temp2T</span>

                                    <i class='glyphicon glyphicon-save trash'></i>

                                    <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>

                                </a>

                                    <a class="productEditImageDel btn btn-danger btn-sm" data-id="$imgId">$temp3T</a>

                            </div>

                        </div>

HTML;

                }

            }

        }

    }





    public function productSelectedNode(){

        $eId=$this->editPid;

        $qry="SELECT * FROM  `product_category` WHERE `procat_prodet_id` = '$eId'";

        $eData=$this->dbF->getRow($qry);

        if($this->dbF->rowCount>0)

            return $eData['procat_cat_id'];

        else

            return "";

    }





    /**

     * @param $name

     * @param $currencyId

     * @param $array

     * @return string

     */

    private function priceAdditionChargesEditArray($name,$currencyId,$array) {

        foreach ($array as $keya => $val) {

            if ($val['proadc_name'] == $name && $val['proadc_cur_id'] == $currencyId && $val['proadc_prodet_id'] == $this->editPid) {

                return $val['proadc_price'];

            }

        }

        return "";

    }





    private  $additionalCost_name;

    private function additionalCost_name(){

        $additionalCost_name        =   array('when_cart_price','checkout_price'); // extra addional price defined...

        if($this->functions->developer_setting("add_free_gift_in_cart") == "1"){

            $additionalCost_name[]  = "giftAdd_when_cart_price";

        }

        $this->additionalCost_name = $additionalCost_name;

    }





    public function priceAdditionChargesEdit(){

        global $_e;



        $notIn  =   "'".implode("','",$this->additionalCost_name)."'";

        $eId    =   $this->editPid;

        $sql    =   "SELECT * FROM  `product_addcost` WHERE `proadc_prodet_id` = '$eId'  AND proadc_name NOT IN ($notIn)  ";

        $eData  =   $this->dbF->getRows($sql);



        if($this->dbF->rowCount>0){

            $name   =   array();

            foreach($eData as $key=>$val){

                if(!in_array ($val['proadc_name'],$name)){

                    $name[] =   $val['proadc_name'];

                }

            }



            $countryCodeList    = $this->functions->countrylist(); // country list

            $currency_data      = $this->c_currency->getList(); // get currency list



             echo '<br>

                    <div class="panel panel-primary">

                        <div class="panel-heading"><h3 class="panel-title">'. _uc($_e['Additional Saved Charges']) .'</h3></div>

                        <div class="panel-body table-responsive">

                            <table id="table_priceEdit"

                                   class="table table-condensed table-responsive">

                                <thead>

                                <tr>

                                    <th>'. _uc($_e['Name']) .'</th>';



                    foreach ($currency_data as $data) {

                        //print top scale county name.. first TR

                        $country_id = $data['cur_id'];

                        $country_name = $countryCodeList[$data['cur_country']];

                        $currency = $data["cur_name"];

                        $symbol = $data['cur_symbol'];



                        $cur_id_array[] = $country_id;

                        $cur_name_array[] = "$country_name ($currency)";



                        echo "<th>$country_name ($currency)</th>";

                    }



              echo '

                        </tr>

                        </thead>

                        <tbody id="tbody_priceEdit">';



                for($i=0;$i<sizeof($name);$i++){

                    echo '<tr>

                            <td><div class="input-group input-group-sm">

                                <span class="input-group-addon">

                                    <input type="checkbox" checked value="rowid_PriceSaved_'.$i.'" name="addCost_checkList[]">

                                </span>

                                <input type="text" value="'.$name[$i].'" name="rowid_PriceSaved_'.$i.'-addCost_name" class="form-control ">

                            </div>

                            </td>';



                            foreach ($currency_data as $data) {

                                //print top scale county name.. first TR

                                $country_id = $data['cur_id'];

                                $symbol = $data['cur_symbol'];



                                $price=$this->priceAdditionChargesEditArray($name[$i],$country_id,$eData);

                                echo '<td>

                                      <div class="input-group input-group-sm">

                                        <span class="input-group-addon">'.$symbol.'</span>

                                        <input type="text" class="form-control" value="'.$price.'"  name="rowid_PriceSaved_'.$i.'-addCost_cost['.$country_id.']">

                                      </div>

                                      </td>';

                            }



                        echo '</tr>';

                }



              echo '</tbody>

                    </table>

                    <div class="panel_note_footer"></div>

                </div>

            </div>';

        }



    }





    public function priceCheckOutChargesEdit(){

        global $_e;

        //$name = array('when_cart_price','checkout_price'); // also update in priceAdditionChargesEdit to not include in that functions

        $name   =   $this->additionalCost_name;

        $additionalCost_in = "'".implode("','",$this->additionalCost_name)."'";

        $eId    =   $this->editPid;

        $sql    =   "SELECT * FROM  `product_addcost` WHERE `proadc_prodet_id` = '$eId' AND proadc_name IN ($additionalCost_in) ";

        $eData  =   $this->dbF->getRows($sql);



        if(!empty($name)){



            foreach($eData as $key=>$val){

                if(!in_array ($val['proadc_name'],$name)){

                    $name[]=$val['proadc_name'];

                }

            }



            $countryCodeList    = $this->functions->countrylist(); // country list

            $currency_data      = $this->c_currency->getList(); // get currency list



            echo '<br>

                    <div class="panel panel-primary">

                        <div class="panel-heading"><h3 class="panel-title">'. _uc($_e['Charges On Offers']) .'</h3></div>

                        <div class="panel-body table-responsive">

                        <small>If you don\'t want to place offer on selected Region left Blank price or 0.</small>

                            <table id="table_priceEdit"

                                   class="table table-condensed table-responsive">

                                <thead>

                                <tr>

                                    <th>'. _uc($_e['Name']) .'</th>';



            foreach ($currency_data as $data) {

                //print top scale county name.. first TR

                $country_id = $data['cur_id'];

                $country_name = $countryCodeList[$data['cur_country']];

                $currency = $data["cur_name"];

                $symbol = $data['cur_symbol'];



                $cur_id_array[] = $country_id;

                $cur_name_array[] = "$country_name ($currency)";



                echo "<th>$country_name ($currency)</th>";

            }



            echo '

                        </tr>

                        </thead>

                        <tbody id="tbody_priceEdit">';



            for($i=0;$i<sizeof($name);$i++){

                echo '<tr>

                            <td><div class="input-group input-group-sm">

                                <span class="input-group-addon">

                                    <input type="checkbox" checked value="rowid_PriceSaved_'.$i.'" name="addCost_checkList[]" class="disable">

                                </span>

                                <input type="text" value="'.$name[$i].'" name="rowid_PriceSaved_'.$i.'-addCost_name" class="form-control ">

                            </div>

                            </td>';



                foreach ($currency_data as $data) {

                    //print top scale county name.. first TR

                    $country_id = $data['cur_id'];

                    $symbol = $data['cur_symbol'];



                    $price=$this->priceAdditionChargesEditArray($name[$i],$country_id,$eData);

                    $price = empty($price)? 0 : $price;

                    echo '<td>

                                      <div class="input-group input-group-sm">

                                        <span class="input-group-addon">'.$symbol.'</span>

                                        <input type="text" class="form-control" value="'.$price.'"  name="rowid_PriceSaved_'.$i.'-addCost_cost['.$country_id.']">

                                      </div>

                                      </td>';

                }



                echo '</tr>';

            }



            echo '</tbody>

                    </table>

                    <div class="panel_note_footer"></div>

                </div>

            </div>';

        }

    }



    /****************************************************/



    public function productLastImage($id){

        $sql ="SELECT * FROM `product_image` WHERE product_id = '$id' ORDER BY sort ASC ";

        $data = $this->dbF->getRow($sql);

        return $data['image'];

    }



    //////////////// Main menu function ///////////////////////////////////////////



    public function menuTypeSingle($type='main',$under='0',$url_function=false){

        global $_e;

        $sql = "SELECT * FROM categories WHERE under = '$under' AND type='$type' ORDER BY sort ASC";

        $data  = $this->dbF->getRows($sql);



        if(!$this->dbF->rowCount){return false;}

        foreach($data as $val){

            $id = $val['id'];

            $heading = htmlspecialchars(translateFromSerialize($val['name']));



            $link = $val['link'];

            if ($url_function) {

                $link = $this->functions->addCatRegexWebUrlInLink($link);

            } else {

                $link = $this->functions->addWebUrlInLink($link);

            }



            $icon = $val['icon'];

            $icon = $this->functions->addWebUrlInLink($icon);



            $array["$id"]['name']   = $heading;

            $array["$id"]['link']   = $link;

            $array["$id"]['icon']   = $icon;

            $array["$id"]['id']     = $id;

            $array["$id"]['active']= '';

            $activeLink = pageLink(false);

            if( ($activeLink) == ($link)){

                $array["$id"]['active']= '1';

            }

        }



        return $array;

    }


    public function countMissingProducts(){
            global $con;
    global $conIntra;

        $sql = "SELECT `prodet_id` FROM `proudct_detail` WHERE `slug` IS NOT NULL";
        $res = $this->dbF->getRows($sql);

        $missing_array = array();
        $return = array();
        
         $migrate_products = $this->functions->ibms_setting('migrate_product_to_ch');
         $migrate_product_to_intranet = $this->functions->ibms_setting('migrate_product_to_intranet');

        if(!empty($migrate_products) && $migrate_products == 1){
         $i = 0;
          foreach ($res as $key => $value) {
            $new_id = 'ss'.$value['prodet_id'];

            $sql_count = "SELECT `prodet_id` FROM `proudct_detail` WHERE `prodet_id` = '$new_id'";
            $res_count = $con->getRow($sql_count);

            if($con->rowCount == 0){
                $missing_array[] = $value['prodet_id'];
                $i++;
            }
        }
        $return['ids'] = json_encode($missing_array);
        $return['count'] = $i; 

        return $return;
     }

 if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){
         $i = 0;
          foreach ($res as $key => $value) {
            $new_id = $value['prodet_id'];

            $sql_count = "SELECT `prodet_id` FROM `proudct_detail` WHERE `prodet_id` = '$new_id'";
            $res_count = $conIntra->getRow($sql_count);

            if($conIntra->rowCount == 0){
                $missing_array[] = $value['prodet_id'];
                $i++;
            }
        }
        $return['ids'] = json_encode($missing_array);
        $return['count'] = $i; 

        return $return;
     }

   }







}



?>