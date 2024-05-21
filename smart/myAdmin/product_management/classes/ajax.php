<?php



require_once (__DIR__."/../../global_ajax.php"); //connection setting db



class ajax extends object_class{



    private $colorC;

    private $scaleC;

    private $var_del;

    private $var_edit;

    private $var_edit_fromName;



    public $product;



    public function  __construct()

    {

        parent::__construct('3');



        $page=$_GET['page'];

     //  $con = $GLOBALS['orcl_conn'];

        if($page=='colorAjax_edit' || $page=='AjaxUpdate_color' ||

            $page=='colorAjax_del' || $page=='AjaxAfterUpdateScript_color'){

            $this->color();

        }else if($page=='scaleAjax_edit' || $page=='AjaxUpdate_scale' ||

            $page=='scaleAjax_del' || $page=='AjaxAfterUpdateScript_scale'){

            $this->scale();

        }

      //  $con = $GLOBALS['orcl_conn'];

        if (isset($GLOBALS['productF'])) $this->product = $GLOBALS['productF'];

        else {

            require_once(__DIR__."/../../product/classes/product.class.php");

            $this->product=new product();

        }





        /**

         * MultiLanguage keys Use where echo;

         * define this class words and where this class will call

         * and define words of file where this class will called

         **/

        global $_e;

        global $adminPanelLanguage;

        $_w=array();

        //This Class

        $_w['Add Slot'] = '' ;

        $_w['Delete'] = '' ;

        $_w['Color Name'] = '' ;

        $_w['Scale Name'] = '' ;

        $_w["Store Is Not Empty.\n Please Delete Store`s Product First."] = '' ;

        $_w['Store In Use'] = '' ;

        $_w['Store Description'] = '' ;

        $_w['Select Country'] = '' ;

        $_w['Store Country'] = '' ;

        $_w['Store City'] = '' ;

        $_w['Store Name'] = '' ;

        $_w['Store Officer Name'] = '' ;



        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin Product ajax');





    }



    private function color(){



        require_once (__DIR__."/color.class.php");

        $this->colorC=new colors();



        $this->var_del = $this->colorC->var_del;

        $this->var_edit = $this->colorC->var_edit;

        $this->var_edit_fromName = $this->colorC->var_edit_fromName;

    }



    private function scale(){

        require_once (__DIR__."/scale.class.php");

        $this->scaleC=new scales();



        $this->var_del = $this->scaleC->var_del;

        $this->var_edit = $this->scaleC->var_edit;

        $this->var_edit_fromName = $this->scaleC->var_edit_fromName;

    }



    public function processEdit($page)

    {

        $id = intval($_GET['id']);

        switch($page){

            case 'color':

                $this->createEditFormColor($id); //Color

                break;

            case 'scale':

                $this->createEditFormScale($id); //scale

                break;

        }



    }



    private function createEditFormColor($id)

    {

        global $_e;

        $data = $this->colorC->getDataSQL($id);



        $name = $data[0]['name'];

        $colors = $data[0]['color'];





        $i = 0;

        $trs = "";



        foreach ($colors as $color) {

            $i++;

            $trs .= "

                <tr>

                    <td> $i) </td>

                    <td>

                     <div class='col-xs-8'>

                        <input type='text' style='border-color: #$color[color_name]; border-width: 3px; '

                         class='inp color_picker form-control'

                         name='$this->var_edit_fromName[color][$color[color_id]]'

                         value='$color[color_name]' >

                     </div>

                     <div class='checkbox col-xs-4'>

                        <label><input type='checkbox' name='$this->var_edit_fromName[colorDel][]' value='$color[color_id]'  >". _uc($_e['Delete']) ."</label>

                     </div>

                    </td>

                </tr>

            ";

        }



        echo '

        <input type="hidden" name="'. $this->var_edit_fromName.'[id]" id="color_edit_id" value="'. $name['colorName_id'].'">



        '. _uc($_e['Color Name']) .' : <input type="text" autocomplete="off" id="color_name" class="inp " name="'.$this->var_edit_fromName.'[name]" value="'. $name['colorName_name'] .'">

        <br><br>



       <table id="slot_table2" class="table slot_table">

                        <tbody>

                        '.$trs .'

                        </tbody>

                    </table>

                    <button type="button" class="btn btn-primary" onclick="addSlot2(); return false;">

                        <i class="icon_bs-plus"></i> '. _uc($_e['Add Slot']) .'

                    </button>

                    <script>

                    color_picker();

                    </script>';



    }





    private function createEditFormScale($id)

    {

        global $_e;

        $data = $this->scaleC->getDataSQL($id);



        $name = $data[0]['name'];

        $scales = $data[0]['scale'];





        $i = 0;

        $trs = "";

        foreach ($scales as $scale) {

            $i++;

            $trs .= "

                <tr>

                    <td> $i) </td>

                    <td>

                    <div class='col-xs-8'>

                        <input type='text' class='inp form-control' name='$this->var_edit_fromName[scale][$scale[scale_id]]' value='$scale[scale_name]' >

                     </div>



                     <div class='checkbox col-xs-4'>

                        <label><input type='checkbox' name='$this->var_edit_fromName[scaleDel][]' value='$scale[scale_id]'>". _uc($_e['Delete']) ."</label>

                     </div>

                     </td>

                </tr>

            ";

        }



        echo '

        <input type="hidden" name="'.$this->var_edit_fromName .'[id]" id="scale_edit_id" value="'.$name['scaleName_id'] .'">



        '. _uc($_e['Scale Name']) .' : <input type="text" autocomplete="off" id="scale_name" class="inp" name="'.$this->var_edit_fromName.'[name]" value="'.$name['scaleName_name'] .'">



        <br /><br />



        <table id="slot_table2" class="table slot_table">

            <tbody>

            '. $trs .'

            </tbody>

        </table>



        <button type="button" class="btn btn-primary" onclick="addSlot2(); return false;">

            <i class="icon_bs-plus"></i> '. _uc($_e['Add Slot']) .'

        </button>';





    }





    public function AjaxAfterUpdateScript_color(){

        $id=$_GET['id'];

        $sql_2 = "SELECT * FROM `colors` WHERE `color_name_id` = '$id' ";

        $data=$this->dbF->getRows($sql_2);



        if($this->dbF->rowCount>0){

            foreach($data as $key=>$val){

                echo "<div class='colorBox' style='background-color:#".$val['color_name']."' ></div>";

            }

        }

    }





    public function AjaxUpdate_color(){

        if (isset($_POST[$this->var_edit_fromName]))

        {

            $form = $_POST[$this->var_edit_fromName];

            $this->updateColorSQL($form);

        }

    }



    private function updateColorSQL($form)

    {

        $id = intval($form['id']);

        @$colors = $form['color'];

        @$name = $form['name'];

        if($name==""){

            echo '0';

            exit;

        }



        $sql = "UPDATE `color_name` SET `colorName_name` =  ? WHERE `colorName_id` = ? ";

        $arry=array($name,$id);

        $this->dbF->setRow($sql,$arry);



        if (is_array($colors) && $id > 0) {



            $sql = "INSERT INTO `colors` (`color_id`,`color_name`,`color_name_id`) VALUES (?,?,?)

                        ON DUPLICATE KEY

                        UPDATE `color_name`= ? ";



            foreach ($colors as $key => $color) {

                $key = intval($key);

                $color_name = $color;

                if (!isset($form['colorDel']) || !in_array(intval($key), $form['colorDel'])) {

                    $arry=array($key, $color_name, $id, $color_name);

                    $this->dbF->setRow($sql,$arry);

                }

            }



            if (isset($form['colorDel']) && is_array($form['colorDel'])) {

                $ids = "";

                foreach ($form['colorDel'] as $del_id) {

                    $ids .= intval($del_id) . ",";

                }

                $ids = trim($ids, ",");

                $sql = "DELETE FROM `colors` WHERE `color_id` IN ($ids) ";

                $qry = $this->dbF->setRow($sql);

            }

        }



        echo "1";

    }





    public function AjaxDelScript_color()

    {

        @$id = intval($_POST['itemId']);

        $sql = "DELETE FROM `color_name` WHERE `colorName_id` = '$id' ";

        $this->dbF->setRow($sql);

        if ($this->dbF->rowCount > 0) {

            echo '1';

        } else {

            echo '0';

        }



    }



    public function AjaxDelScript_scale()

    {

        @$id = intval($_POST['itemId']);

        $sql = "DELETE FROM `scale_name` WHERE `scaleName_id` = '$id' ";

        $this->dbF->setRow($sql);

        if ($this->dbF->rowCount > 0) {

            echo '1';

        } else {

            echo '0';

        }



    }





    public function AjaxUpdate_scale(){

        if (isset($_POST[$this->var_edit_fromName]))

        {

            $form = $_POST[$this->var_edit_fromName];

            $this->updateScaleSQL($form);

        }

    }



    private function updateScaleSQL($form)

    {

        try{

            $this->db->beginTransaction();



            $id = intval($form['id']);

            @$scales = $form['scale'];

            @$name = $form['name'];



            $sql = "UPDATE `scale_name` SET `scaleName_name` =  ? WHERE `scaleName_id` = ? ";

            $arry =array($name,$id);

            $this->dbF->setRow($sql,$arry,false);



            if (is_array($scales) && $id > 0) {



                $sql = "INSERT INTO `scales` (`scale_id`,`scale_name`,`scale_name_id`) VALUES (?,?,?)

                        ON DUPLICATE KEY

                        UPDATE `scale_name`= ? ";



                foreach ($scales as $sid => $scale) {

                    $sid = intval($sid);

                    $scale_name = $scale;

                    $sm_id = $id;

                    if (!isset($form['scaleDel']) || !in_array(intval($sid), $form['scaleDel'])) {

                        $arry =array($sid, $scale_name, $sm_id, $scale_name);

                        $this->dbF->setRow($sql,$arry,false);

                    }

                }



                if (isset($form['scaleDel']) && is_array($form['scaleDel'])) {

                    $ids = "";

                    foreach ($form['scaleDel'] as $del_id) {

                        $ids .= intval($del_id) . ",";

                    }

                    $ids = trim($ids, ",");

                    $sql = "DELETE FROM `scales` WHERE `scale_id` IN ($ids) ";

                    $qry = $this->dbF->setRow($sql,false);

                }

            }



            $this->db->commit();

            echo '1';

        }catch (Exception $e){

            echo '0';

            $this->dbF->error_submit($e);

            $this->db->rollBack();



        }

    }



    public function AjaxAfterUpdateScript_scale(){

        $id=$_GET['id'];

        $sql_2 = "SELECT * FROM `scales` WHERE `scale_name_id` = '$id' ";

        $data=$this->dbF->getRows($sql_2);



        $temp='';

        if($this->dbF->rowCount>0){

            foreach($data as $key=>$val){

                $temp .=  $val['scale_name'] . ', ';

            }

            $temp= trim($temp);

            echo trim($temp,',');

        }

    }









    public function AjaxUpdate_currency(){

        $form_array_prefix ='edit_currency_form';

        if (isset($_POST[$form_array_prefix])) {

            $form = $_POST[$form_array_prefix];

            if (

                isset($form['country']) && !empty($form['country'])

                && isset($form['cid']) && !empty($form['cid'])

                && isset($form['currency']) && !empty($form['currency'])

                && isset($form['symbol']) && !empty($form['symbol'])

            ) {

                $sql = "UPDATE `currency` SET

                            `cur_country` = ?,

                            `cur_name` = ?,

                            `cur_symbol` = ?

                            WHERE `cur_id` = ?";

                $arry=array( $form['country'], $form['currency'], $form['symbol'],$form['cid']);

                $this->dbF->setRow($sql,$arry);

                echo '1';

            }

        }

    }



    public function AjaxAfterUpdateScript_currency(){

        $id=$_GET['id'];

        $data = $this->dbF->getRow("SELECT * FROM `currency` WHERE `cur_id`='$id'");

        if($this->dbF->rowCount > 0){

            $con= $this->functions->countrylist()[$data['cur_country']];

            echo  '<td>'.$con.'</td>

                <td>'.$data['cur_name'].'</td>

                <td>'.$data['cur_symbol'].'</td>

                <td>



                <div class="btn-group btn-group-sm">

                  <a data-toggle="modal" href="#currencyEditModal" onclick="formEditInit(\''.$data['cur_id'].'\',\''.$data['cur_country'].'\',\''.$data['cur_name'].'\',\''.$data['cur_symbol'].'\')"  class="btn"><i class="glyphicon glyphicon-edit"></i></a>

                  <a data-id="'.$data['cur_id'].'" onclick="AjaxDelScript(this);" class="btn secure_delete">

                    <i class="glyphicon glyphicon-trash trash"></i>

                    <i class="fa fa-refresh waiting fa-spin" style="display: none"></i>

                  </a>

                </div>

                </td>';

        }

    }





    public function AjaxDelScript_currency()

    {

        $id = intval($_GET['id']);

        $sql = "DELETE FROM `currency` WHERE `cur_id`= ?";

        $arry=array($id);

        $this->dbF->setRow($sql,$arry);

        if ($this->dbF->rowCount > 0) {

            echo '1';

        } else {

            echo '0';



        }



    }



    public function AjaxDelScript_product()

    {

        try{

            $this->db->beginTransaction();

            @$id = intval($_POST['itemId']);





            $sql3="SELECT * FROM `product_image` WHERE `product_id`='$id'";

            $data=$this->dbF->getRows($sql3,false);

            foreach($data as $key=>$val){

                $this->functions->deleteOldSingleImage($val['image']);

            }

            $sql3="DELETE FROM `product_image` WHERE `product_id`='$id'";

            $this->dbF->setRow($sql3,false);



            $sql3="DELETE FROM `proudct_detail` WHERE `prodet_id`='$id'";

            $this->dbF->setRow($sql3);



            if ($this->dbF->rowCount > 0) {

                echo '1';

            } else {

                echo '0';

            }

            $this->db->commit();

        }catch(Exception $e){

            echo '0';

            $this->db->rollBack();

            $this->dbF->error_submit($e);

        }

    }





    public function AjaxDelScript_productSelected(){

        try{

            $ids=$_POST['id'];

            $this->db->beginTransaction();

            $ids=explode(",",$ids);

            for($i=0;$i<sizeof($ids);$i++){

                $id=$ids[$i];



                $sql3="SELECT * FROM `product_image` WHERE `product_id`='$id'";

                $data=$this->dbF->getRows($sql3,false);

                foreach($data as $key=>$val){

                    unlink(__DIR__."/../../../images/$val[image]");

                }

                $sql3="DELETE FROM `product_image` WHERE `product_id`='$id'";

                $this->dbF->setRow($sql3,false);



                $sql3="DELETE FROM `proudct_detail` WHERE `prodet_id`='$id'";

                $this->dbF->setRow($sql3);

            }





            $this->db->commit();

            echo "1";

        }catch(Exception $e){

            echo "0";

            $this->db->rollBack();

            $this->dbF->error_submit($e);

        }

    }



    public function AjaxDelScript_productImageDel(){
        global $con,$conIntra;

        $id=$_POST['imageId'];



        $sql3="SELECT * FROM `product_image` WHERE `img_id`='$id'";

        $data=$this->dbF->getRow($sql3);



        unlink(__DIR__."/../../../images/$data[image]");


        $sql3="DELETE FROM `product_image` WHERE `img_id`='$id'";

        $this->dbF->setRow($sql3);

             $migrate_products = $this->functions->ibms_setting('migrate_product_to_ch');
            $migrate_product_to_intranet = $this->functions->ibms_setting('migrate_product_to_intranet');
        

if(!empty($migrate_products) && $migrate_products == 1){

$sql4="DELETE FROM `product_image` WHERE `image` = '$data[image]'";
$con->setRow($sql4);

$sql_refer = "INSERT INTO `product_image_refer`(`upload_path`, `remove`) VALUES ('$data[image]',1)";
$con->setRow($sql_refer);

}
if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){
$sql4="DELETE FROM `product_image` WHERE `image` = '$data[image]'";
$conIntra->setRow($sql4);

$sql_refer = "INSERT INTO `product_image_refer`(`upload_path`, `remove`) VALUES ('$data[image]',1)";
$conIntra->setRow($sql_refer);

}

        if($this->dbF->rowCount>0){

            echo "1";

        }else{

            echo "0";

        }



    }



    function AjaxDelScript_storeDel(){

        global $_e;

        $id=$_POST['itemId'];



        $sql="SELECT * FROM  `product_inventory`  WHERE `qty_store_id`='$id' AND `qty_item`>'0'";

        $this->dbF->getRows($sql);

        if($this->dbF->rowCount>0){

            echo "<script>jAlert('". _js($_e["Store Is Not Empty.\n Please Delete Store`s Product First."])."','". _js($_e['Store In Use'])."');</script>";

        }else{

            $sql3="DELETE FROM `store_name` WHERE `store_pk`='$id'";

            $this->dbF->setRow($sql3);



            if($this->dbF->rowCount>0){

                echo "1";

            }else{

                echo "0";

            }

        }

    }



    function AjaxDelScript_receiptDel(){

        $id=$_POST['itemId'];



        $sql3="DELETE FROM `purchase_receipt` WHERE `receipt_pk`='$id'";

        $this->dbF->setRow($sql3);



        if($this->dbF->rowCount>0){

            echo "1";

        }else{

            echo "0";

        }

    }
    function AjaxUpdateScript_inventoryDuplicateUpdate(){
        $id=$_GET['id'];
  

      
          echo $id;  


            if (!$this->functions->getFormToken("productDuplicateEdit")) {
                return false;
            }


          $mysql = "SELECT * FROM `product_inventory_detail`  WHERE `qty_pk` ='$id'  ";
            
            $mydata = $this->dbF->getRow($mysql);
         
                   # code...


            
        echo    $id = $mydata['qty_pk'];
        echo    $qty_store_id = $mydata['qty_store_id'];
        echo    $qty_product_id = $mydata['qty_product_id'];
        echo    $qty_product_scale = $mydata['qty_product_scale'];
        echo    $qty_product_color = $mydata['qty_product_color'];
        echo    $pcode = $_POST['productcode'];
        echo    $hash = $mydata['product_store_hash'];


    

                echo  $sql = " UPDATE   `product_inventory_detail` SET `p_code` = '$pcode' WHERE `qty_pk` = '$id'  (
                                            `qty_pk`,
                                            `qty_store_id`,
                                            `qty_product_id`,
                                            `qty_product_scale`,
                                            `qty_product_color`,
                                            `product_store_hash`,
                                            `p_code`
                                           
                                        ) VALUES (?,?,?,?,?,?) ";
                    $arry=array($id,$qty_store_id,$qty_product_id,$qty_product_scale,$qty_product_color,$pcode,$hash);
                    $this->dbF->setRow($sql,$arry);

 



    }

 function AjaxUpdateScript_receiptUpdate(){
        $id=$_POST['itemId'];
          //   $pcode =  empty($_POST['pcode']) ?  array() : $_POST['pcode'];
               //$this->dbF->prnt($pcode);
            
        $sql5="SELECT `grn`,`store` FROM `purchase_receipt` WHERE `receipt_pk`='$id'";
        $datas = $this->dbF->getRow($sql5);
        $grn = $datas[0];
        $store = $datas[1];

        $sql4="UPDATE `purchase_receipt` SET `publish`='1' WHERE receipt_pk='$id'";
        $this->dbF->setRow($sql4);


        $mysql = "SELECT * FROM `purchase_receipt_pro` WHERE `receipt_id`='$id'";
        $data = $this->dbF->getRows($mysql);

        foreach ($data as $key => $value) {
          
            $pcolor = $value['receipt_product_color'];
            $pid    = $value['receipt_product_id'];
            $pscale = $value['receipt_product_scale'];
            $pqty   = $value['receipt_qty'];
            $hash   = $value['receipt_hash'];
            $hash   = $value['store'];
            $pcode   = $value['p_code'];
             $sku_pcode = explode(',',$pcode);
            
            
            $sqlCheck="SELECT `product_store_hash` FROM `product_inventory_detail` WHERE `product_store_hash` = '$hash'";
            $this->dbF->getRow($sqlCheck);

            // if($this->dbF->rowCount>0){
                // $date =date('Y-m-d H:i:s'); //2014-09-24 13:46:10
                // $sql= "UPDATE `product_inventory` SET `qty_item` = qty_item+$pqty , `updateTime` = '$date' WHERE `product_store_hash` = '$hash'";
                // $this->dbF->setRow($sql);
            // }else{
    
 for ($i=0; $i < count($sku_pcode);  $i++) { 
    

  echo $sku_pcode[$i];

     
                     $sql = "INSERT INTO `product_inventory_detail`(
                                            `qty_store_id`,
                                            `qty_product_id`,
                                            `qty_product_scale`,
                                            `qty_product_color`,
                                            -- `qty_item`,
                                            `product_store_hash`,
                                            `p_code`
                                           
                                        ) VALUES (?,?,?,?,?,'$sku_pcode[$i]') ";
                    $arry=array($store,$pid,$pscale,$pcolor,$hash);
                    $this->dbF->setRow($sql,$arry);
                // }
                }
}
        // if($this->dbF->rowCount>0){
        //     echo "1";
        //     $lastId= $this->dbF->rowLastId;
        //     $desc="Publish";
        //     $this->functions->setlog('Goods Receive Note',$grn,$lastId,$desc);
        // }else{
        //     echo "0";
        // }
    }

 
//GTN
    function AjaxDelScript_receiptDel_gtn(){
        $id=$_POST['itemId'];

        $sql4="SELECT `gtn` FROM `purchase_receipt_gtn` WHERE `receipt_pk`='$id'";
        $data = $this->dbF->getRow($sql4);
        $gtn = $data[0];

        $sql3="DELETE FROM `purchase_receipt_gtn` WHERE `receipt_pk`='$id'; DELETE FROM `purchase_receipt_pro_gtn` WHERE `receipt_id`='$id'";
        $this->dbF->setRow($sql3);

        if($this->dbF->rowCount>0){
            echo "1";
            $lastId= $this->dbF->rowLastId;
            $desc="Delete";
             $this->functions->setlog('Goods Transfer Note',$gtn,$lastId,$desc);
        }else{
            echo "0";
        }
    }

    function AjaxDelScript_receiptDel_gtn_reverse(){
        $id=$_POST['itemId'];

        $sql4="SELECT `gtn` FROM `purchase_receipt_gtn` WHERE `receipt_pk`='$id'";
        $data = $this->dbF->getRow($sql4);
        $gtn = $data[0];

        $sql1="SELECT * FROM `purchase_receipt_pro_gtn` WHERE receipt_id='$id'";
        $data1=$this->dbF->getRows($sql1);

        foreach ($data1 as $key => $value) {
            $qty=$value['receipt_qty'];
            $pid=$value['receipt_product_id'];
            $pcolor=$value['receipt_product_color'];
            $pcolor2=$value['receipt_product_scale'];

            $sql2="UPDATE `product_inventory` SET `qty_item` = qty_item+$qty WHERE `qty_product_id`='$pid' AND `qty_store_id`='$pcolor'";
            $this->dbF->setRow($sql2);

            $sql3= "UPDATE `product_inventory` SET `qty_item` = qty_item-$qty WHERE `qty_product_id`='$pid' AND `qty_store_id` = '$pcolor2'";
            $this->dbF->setRow($sql3);
        }

        $sql5="DELETE FROM `purchase_receipt_gtn` WHERE `receipt_pk`='$id';
               DELETE FROM `purchase_receipt_pro_gtn` WHERE `receipt_id`='$id'";
        $this->dbF->setRow($sql5);

        if($this->dbF->rowCount>0){
            echo "1";
            $lastId= $this->dbF->rowLastId;
            $desc="Delete";
             $this->functions->setlog('Goods Transfer Note',$gtn,$lastId,$desc);
        }else{
            echo "0";
        }
    }

    function AjaxUpdateScript_receiptUpdate_gtn(){
        $id=$_POST['itemId'];

        $sql5="SELECT `gtn` FROM `purchase_receipt_gtn` WHERE `receipt_pk`='$id'";
        $data = $this->dbF->getRow($sql5);
        $gtn = $data[0];

        $sql4="UPDATE `purchase_receipt_gtn` SET `publish`='publish' WHERE receipt_pk='$id'";
        $this->dbF->setRow($sql4);
        $sql1="SELECT * FROM `purchase_receipt_pro_gtn` WHERE receipt_id='$id'";
        $data=$this->dbF->getRows($sql1);
        foreach ($data as $key => $value) {
        $qty=$value['receipt_qty'];
        $pid=$value['receipt_product_id'];
        $pscale=$value['receipt_product_scale'];
        $pcolor=$value['receipt_product_color'];
        @$hashVal=$pid.":".$pscale;
        $hash = md5($hashVal);

        $sql2="UPDATE `product_inventory` SET `qty_item` = qty_item-$qty WHERE `qty_product_id`='$pid' AND `qty_store_id`='$pcolor'";
        $this->dbF->setRow($sql2);

        $sqlCheck="SELECT `product_store_hash` FROM `product_inventory` WHERE `product_store_hash` = '$hash'";
        $this->dbF->getRow($sqlCheck);
        if($this->dbF->rowCount>0){
            $date =date('Y-m-d H:i:s'); //2014-09-24 13:46:10
            $sql6= "UPDATE `product_inventory` SET `qty_item` = qty_item+$pqty , `updateTime` = '$date' WHERE `product_store_hash` = '$hash'";
            $this->dbF->setRow($sql6);
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
        $arry=array($pscale,$pid,$pscale,$pscale,$qty,$hash);
        $this->dbF->setRow($sql3,$arry);
        }
        }

        if($this->dbF->rowCount>0){
            echo "1";
            $lastId= $this->dbF->rowLastId;
            $desc="Publish";
            $this->functions->setlog('Goods Transfer Note',$gtn,$lastId,$desc);
        }else{
            echo "0";
        }
    }
        function AjaxUpdateScript_receiptUpdate_gtn_d(){
        $id=$_POST['itemId'];

        $sql5="SELECT `gtn` FROM `purchase_receipt_gtn` WHERE `receipt_pk`='$id'";
        $data = $this->dbF->getRow($sql5);
        $gtn = $data[0];

        $sql4="UPDATE `purchase_receipt_gtn` SET `publish`='transfer' WHERE receipt_pk='$id'";
        $this->dbF->setRow($sql4);

        if($this->dbF->rowCount>0){
            echo "1";
            $lastId= $this->dbF->rowLastId;
            $desc="Transfer Initiated";
            $this->functions->setlog('Goods Transfer Note',$gtn,$lastId,$desc);
        }else{
            echo "0";
        }
    }
    //GTN
    // DN
    function AjaxDelScript_receiptDel_dn(){
        $id=$_POST['itemId'];

        $sql5="SELECT `dn` FROM `purchase_receipt_dn` WHERE `receipt_pk`='$id'";
        $data = $this->dbF->getRow($sql5);
        $dn = $data[0];

        $sql3="DELETE FROM `purchase_receipt_dn` WHERE `receipt_pk`='$id'; DELETE FROM `purchase_receipt_pro_dn` WHERE `receipt_id`='$id'";
        $this->dbF->setRow($sql3);

        if($this->dbF->rowCount>0){
            $lastId= $this->dbF->rowLastId;
            $desc="Delete";
            $this->functions->setlog('Delivery Note',$dn,$lastId,$desc);
            echo "1";
        }else{
            echo "0";
        }
    }

    function AjaxDelScript_receiptDel_dn_reverse(){
        $id=$_POST['itemId'];

        $sql5="SELECT `dn` FROM `purchase_receipt_dn` WHERE `receipt_pk`='$id'";
        $data = $this->dbF->getRow($sql5);
        $dn = $data[0];

        $sql1="SELECT * FROM `purchase_receipt_pro_dn` WHERE receipt_id='$id'";
        $data=$this->dbF->getRows($sql1);
        foreach ($data as $key => $value) {
        $pqty=$value['receipt_qty'];
        $pcolor=$value['receipt_product_color'];
        $pid=$value['receipt_product_id'];
        $sql2="UPDATE `product_inventory` SET `qty_item` = qty_item+$pqty WHERE `qty_product_id`='$pid' AND `qty_store_id`='$pcolor'";
        $this->dbF->setRow($sql2);
        }

        $sql3="DELETE FROM `purchase_receipt_dn` WHERE `receipt_pk`='$id'; DELETE FROM `purchase_receipt_pro_dn` WHERE `receipt_id`='$id'";
        $this->dbF->setRow($sql3);

        if($this->dbF->rowCount>0){
            $lastId= $this->dbF->rowLastId;
            $desc="Delete";
            $this->functions->setlog('Delivery Note',$dn,$lastId,$desc);
            echo "1";
        }else{
            echo "0";
        }
    }

    function AjaxUpdateScript_receiptUpdate_dn(){
        $id=$_POST['itemId'];

        $sql5="SELECT `dn` FROM `purchase_receipt_dn` WHERE `receipt_pk`='$id'";
        $data = $this->dbF->getRow($sql5);
        $dn = $data[0];

        $sql4="UPDATE `purchase_receipt_dn` SET `publish`='publish' WHERE receipt_pk='$id'";
        $this->dbF->setRow($sql4);

        $sql1="SELECT * FROM `purchase_receipt_pro_dn` WHERE receipt_id='$id'";
        $data=$this->dbF->getRows($sql1);
        foreach ($data as $key => $value) {
        $pqty=$value['receipt_qty'];
        $pcolor=$value['receipt_product_color'];
        $pid=$value['receipt_product_id'];
        $sql2="UPDATE `product_inventory` SET `qty_item` = qty_item-$pqty WHERE `qty_product_id`='$pid' AND `qty_store_id`='$pcolor'";
        $this->dbF->setRow($sql2);
        }

        if($this->dbF->rowCount>0){
            echo "1";
            $lastId= $this->dbF->rowLastId;
            $desc="Publish";
            $this->functions->setlog('Delivery Note',$dn,$lastId,$desc);
        }else{
            echo "0";
        }
    }

    function AjaxUpdateScript_receiptUpdate_dn_d(){
        $id=$_POST['itemId'];

        $sql5="SELECT `dn` FROM `purchase_receipt_dn` WHERE `receipt_pk`='$id'";
        $data = $this->dbF->getRow($sql5);
        $dn = $data[0];

        $sql4="UPDATE `purchase_receipt_dn` SET `publish`='transfer' WHERE receipt_pk='$id'";
        $this->dbF->setRow($sql4);

        if($this->dbF->rowCount>0){
            echo "1";
            $lastId= $this->dbF->rowLastId;
            $desc="Delivery Initiated";
            $this->functions->setlog('Delivery Note',$dn,$lastId,$desc);
        }else{
            echo "0";
        }
    }
    // DN
    // IAN
    function AjaxDelScript_receiptDel_ian(){
        $id=$_POST['itemId'];

        $sql5="SELECT `ian` FROM `purchase_receipt_ian` WHERE `receipt_pk`='$id'";
        $data = $this->dbF->getRow($sql5);
        $ian = $data[0];

        $sql3="DELETE FROM `purchase_receipt_ian` WHERE `receipt_pk`='$id'; DELETE FROM `purchase_receipt_pro_ian` WHERE `receipt_id`='$id'";
        $this->dbF->setRow($sql3);

        if($this->dbF->rowCount>0){
            echo "1";
            $lastId= $this->dbF->rowLastId;
            $desc="Delete";
             $this->functions->setlog('Inventory Adjustment Note',$ian,$lastId,$desc);
        }else{
            echo "0";
        }
    }

    function AjaxUpdateScript_receiptUpdate_ian(){
        $id=$_POST['itemId'];
        
        $sql5="SELECT `ian` FROM `purchase_receipt_ian` WHERE `receipt_pk`='$id'";
        $data = $this->dbF->getRow($sql5);
        $ian = $data[0];

        $sql4="UPDATE `purchase_receipt_ian` SET `publish`='publish' WHERE receipt_pk='$id'";
        $this->dbF->setRow($sql4);
        $sql1="SELECT * FROM `purchase_receipt_pro_ian` WHERE receipt_id='$id'";
        $data=$this->dbF->getRows($sql1);
        foreach ($data as $key => $value) {
        $pqty=$value['receipt_product_nqty'];
        $pstore=$value['receipt_product_store'];
        $pid=$value['receipt_product_id'];
        $hash=$value['receipt_hash'];

        $sqlCheck="SELECT `product_store_hash` FROM `product_inventory` WHERE `product_store_hash` = '$hash'";
        $this->dbF->getRow($sqlCheck);

        if($this->dbF->rowCount>0){
        $sql2="UPDATE `product_inventory` SET `qty_item` = $pqty WHERE `qty_product_id`='$pid' AND `qty_store_id`='$pstore' AND `qty_product_color`='$pstore'";
        $this->dbF->setRow($sql2);
        }
        else{
            $sql3= "INSERT INTO `product_inventory`(
                                    `qty_store_id`,
                                    `qty_product_id`,
                                    `qty_product_color`,
                                    `qty_item`,
                                    `product_store_hash`
                                ) VALUES(?,?,?,?,?)";
            $arry=array($pstore,$pid,$pstore,$pqty,$hash);
            $this->dbF->setRow($sql3,$arry);
        }

        $nme = $_SESSION['_name'];
        $sql = "UPDATE `purchase_receipt_ian` SET `approved_by`='$nme'
                   WHERE receipt_pk='$id'";
        $this->dbF->setRow($sql);
        }

        if($this->dbF->rowCount>0){
            echo "1";
            $lastId= $this->dbF->rowLastId;
            $desc="Publish";
            $this->functions->setlog('Inventory Adjustment Note',$ian,$lastId,$desc);
        }else{
            echo "0";
        }
    }    

    function AjaxUpdateScript_receiptUpdate_ian_d(){
        $id=$_POST['itemId'];
        
        $sql5="SELECT `ian` FROM `purchase_receipt_ian` WHERE `receipt_pk`='$id'";
        $data = $this->dbF->getRow($sql5);
        $ian = $data[0];

        $sql4="UPDATE `purchase_receipt_ian` SET `publish`='initiated' WHERE receipt_pk='$id'";
        $this->dbF->setRow($sql4);

        if($this->dbF->rowCount>0){
            echo "1";
            $lastId= $this->dbF->rowLastId;
            $desc="Adjustment Initiated";
            $this->functions->setlog('Inventory Adjustment Note',$ian,$lastId,$desc);
        }else{
            echo "0";
        }
    }    
    // IAN

    public function AjaxEditStore(){

        global $_e;

        $id = $_GET['id'];

        $sql="SELECT * FROM `store_name` WHERE `store_pk` = '$id' ";

        $data = $this->dbF->getRow($sql);

        $country_list = $this->functions->countrySelectOption();



        echo '<div class="form-horizontal">

                <div class="form-group">

                    <label for="input1" class="col-sm-4 control-label">'. _uc($_e['Store Officer Name']) .'</label>

                    <div class="col-sm-8">

                        <input type="hidden" value="'.$data['store_pk'].'" id="store_edit_id" name="storeId" />

                        <input type="text" value="'.$data['store_owner'].'" name="storeOfficer" class="form-control" required id="input2" placeholder="'. _uc($_e['Store Officer Name']) .'">

                    </div>

                </div>



                <div class="form-group">

                    <label for="input3" class="col-sm-4 control-label">'. _uc($_e['Store Name']) .'</label>

                    <div class="col-sm-8">

                        <input type="text" value="'.$data['store_name'].'"  name="storeName" class="form-control" required id="input3" placeholder="'. _uc($_e['Store Name']) .'">

                    </div>

                </div>



                <div class="form-group">

                    <label for="input2" class="col-sm-4 control-label">'. _uc($_e['Store City']) .'</label>

                    <div class="col-sm-8">

                        <input type="text" value="'.$data['store_location'].'" name="storeLocation" class="form-control" required id="input2" placeholder="'. _uc($_e['Store City']) .'">

                    </div>

                </div>



                <div class="form-group">

                    <label for="input2" class="col-sm-4 control-label">'. _uc($_e['Store Country']) .'</label>

                    <div class="col-sm-8">

                    <select name="storCountry" id="storCountry" class="form-control" required="required">

                        <option value="">'. _uc($_e['Select Country']) .'</option>

                            '.$country_list.'

                        </select>

                        <script>

                        $(document).ready(function(){

                            $("#storCountry").val("'.$data['store_country'].'").change();

                        });

                        </script>

                    </div>

                </div>



                <div class="form-group">

                    <label for="input4" class="col-sm-4 control-label">'. _uc($_e['Store Description']) .'</label>

                    <div class="col-sm-8">

                        <textarea  name="storeDesc" class="form-control" rows="3" id="input4" placeholder="'. _uc($_e['Store Description']) .'">'.$data['store_desc'].'</textarea>

                    </div>

                </div>



                </div>';

    }



    public function AjaxEditRequestStore(){

        if( isset($_POST['storeOfficer'])  && isset($_POST['storeLocation']) && isset($_POST['storeName']) &&

            !empty($_POST['storeOfficer']) && !empty($_POST['storeLocation']) && !empty($_POST['storeName']) && !empty($_POST['storCountry'])

        ){

            $id =$_POST['storeId'];



            $sql="UPDATE `store_name` SET

                    `store_owner`=?,

                    `store_location`=?,

                    `store_country`=?,

                    `store_name`=?,

                    `store_desc`=?

                    WHERE `store_pk` = '$id'";

            $arry=array($_POST['storeOfficer'],$_POST['storeLocation'],$_POST['storCountry'],$_POST['storeName'],$_POST['storeDesc']);



            $this->dbF->setRow($sql,$arry);

            if($this->dbF->rowCount>0)  echo '1';

            else  echo '0';

        }else{

            echo '0';

        }

    }





    public function AjaxAfterUpdateScript_store(){

        $id = $_GET['id'];

        $sql="SELECT * FROM `store_name` WHERE `store_pk` = '$id' ";

        $val = $this->dbF->getRow($sql);

        echo "

                    <td>*</td>

                    <td>$val[store_owner]</td>

                    <td>$val[store_name]</td>

                    <td>$val[store_location] - $val[store_country]</td>

                    <td>$val[store_desc]</td>

                    <td><div class='btn-group btn-group-sm'>

                        <a data-id='$id'  data-target='#storeEditModal' onclick='AjaxEditScript(this);' class='btn _storeEdit'><i class='glyphicon glyphicon-edit '></i></a>



                         <a data-id='$id' onclick='AjaxDelScript(this);' class='btn'>

                                 <i class='glyphicon glyphicon-trash trash'></i>

                                 <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>

                         </a>

                         </div>

                    </td>

                ";

    }



    public function AjaxDelScript_discountDel(){

        $id     =   $_POST['id'];

        $sql ="DELETE FROM `product_discount` WHERE product_discount_pk = '$id'";

        $this->dbF->setRow($sql);

        if($this->dbF->rowCount>0){

            echo "1";

        }else{

            echo "0";

        }

    }

    public function AjaxDelScript_holeSaleDel(){

        $id     =   $_POST['id'];

        $sql ="DELETE FROM `product_sale` WHERE pSale_pk = '$id'";

        $this->dbF->setRow($sql);

        if($this->dbF->rowCount>0){

            echo "1";

        }else{

            echo "0";

        }

    }

    public function AjaxDelScript_couponDel(){

        $id     =   $_POST['id'];

        $sql ="DELETE FROM `product_coupon` WHERE pCoupon_pk = '$id'";

        $this->dbF->setRow($sql);

        if($this->dbF->rowCount>0){

            echo "1";

        }else{

            echo "0";

        }

    }





    public  function sortProductImage(){

        $list=$_POST['image'];

        for ($i = 0; $i < count($list); $i++) {

            $sql3="UPDATE `product_image` SET sort='$i' WHERE `img_id`='$list[$i]'";

            $data=$this->dbF->setRow($sql3);

        }

    }



    public  function pImageAltUpdate(){

        $id=$_POST['imageId'];

        $alt=$_POST['altT'];

        $sql3="UPDATE `product_image` SET alt=? WHERE `img_id`='$id'";

        $array = array($alt);

        $data=$this->dbF->setRow($sql3,$array);

        if($this->dbF->rowCount>0){

            echo "1";

        }else{

            echo "0";

        }

    }



    public  function sortProducts(){

        $list=$_POST['sort'];

        for ($i = 0; $i < count($list); $i++) {

            $sql3="UPDATE `proudct_detail` SET sort='$i' WHERE `prodet_id`='$list[$i]'";

            $data=$this->dbF->setRow($sql3);

        }

    }





    public  function featureItem(){

        global $_e;

            $id     =   $_POST['id'];

            $val    =   $_POST['val'];



            $sql2   =   "UPDATE proudct_detail set feature = '$val' WHERE prodet_id = '$id'";

            $this->dbF->setRow($sql2,false);

            if($this->dbF->rowCount) echo '1';

            else echo '0';

    }

 public function getProductDetail($setting_name,$id){
        $data = $this->dbF->getRow("SELECT setting_val from `product_setting` where p_id='$id' and setting_name='$setting_name'");
        return $data[0];
    }

    public  function sortProductSize(){

        print_r($_POST);

        $list=$_POST['size'];

        $count_list = count($list);

        for ($i = 0; $i < count($list); $i++) {

            $list_ex = explode(':',$list[$i]);

            $size_name = $list_ex[0];

            $pro_id = $list_ex[1];







            $sql3="UPDATE `product_size` SET sort='$i' WHERE `prosiz_name`= ? AND `prosiz_prodet_id` = ?";

            $data=$this->dbF->setRow($sql3, array($size_name,$pro_id));

        }

    }





    public  function fetch_products(){

        global $_e, $functions;

        $start  = ( isset($_POST['start']) )  ? $_POST['start']             : 0;

        $length = ( isset($_POST['length']) ) ? $_POST['length']            : 10;

        $draw   = ( isset($_POST['draw']) )   ? (int) $_POST['draw']        : null;

        $search = ( isset($_POST['search']) ) ? ($_POST['search']['value']) : null;

        $orderBy = ( isset($_POST['order'][0]['column']) ) ? ($_POST['order'][0]['column']) : null;

        $orderDir = ( isset($_POST['order'][0]['dir']) ) ? ($_POST['order'][0]['dir']) : null;



        $columnss = array( 

            // datatable column index  => database column name 

                1 => 'prodet_name',

                2 => 'prodet_shortDesc',

                4 => 'prodet_timeStamp',

                5 => 'view',

                6 => 'sale'

            );



        $selectedCheck = @$_POST['selectedCheck'];



        #### Search Query #####

        @$page  = $_GET['page'];

        $setting_val = " '1' ";

        if($page == 'draft_products'){

            $setting_val = " '0' ";

        }



        $categories = @$_POST['catego'];



        if($search) { $search_sql = "

                                        ( `proudct_detail`.`prodet_shortDesc` LIKE '%{$search}%'

                                            OR `proudct_detail`.`prodet_name` LIKE '%{$search}%' )

                                        AND

                                    ";

        } else { $search_sql = ''; }



        if($orderBy) {

            $order_sql = " ORDER BY `". $columnss[$orderBy]."` ".$orderDir."";

        }

        else{

            $order_sql = " ORDER BY `proudct_detail`.`prodet_id` DESC";

        }



        $cat_pro = array();

        $cat_filter = '';

        if(isset($categories) && !empty($categories)){

            // $cat_pro = $this->productByCategoryNew('1200');

            $cat_exp = explode(',',$categories);

            foreach ($cat_exp as $key => $value) {

                $cat_pro[] = $this->productByCategoryNew($value);

                 

            }

            $count_cat_pro = count($cat_pro);

            $c = 0;



            if(!empty($cat_pro[0])){



                // $this->dbF->prnt($cat_pro);



                $pIdd = '';



                foreach ($cat_pro as $key => $value) {

                    for ($i=0; $i < sizeof($value) ; $i++) { 

                        $product_id = $value[$i]['prodet_id'];



                        $pIdd .= '\''.$product_id.'\',';

                    }

                }



                $pIdd = rtrim($pIdd, ',');



                $cat_filter = " `proudct_detail`.`prodet_id` IN({$pIdd}) AND ";

                $c++;

            }

            else{

                $cat_filter = "";

                $columns["data"] = array();                

                echo json_encode( $columns );

                exit;

            }

        }



        $cat_proSelect = array();

        $product_idSelect = array();

        if(isset($selectedCheck) && !empty($selectedCheck)){

            // $cat_proSelect = $this->productByCategoryNew('1200');

            $cat_expSelect = explode(',',$selectedCheck);

            foreach ($cat_expSelect as $key => $value) {

                $cat_proSelect[] = $this->productByCategoryNew($value);

                 

            }

            foreach ($cat_proSelect as $key => $value) {

                for ($i=0; $i < sizeof($value) ; $i++) { 

                    $product_idSelect[] = $value[$i]['prodet_id'];

                }

            }

        }





        ############# GET TOTAL ROWS #############

        $total_count_sql = " SELECT `proudct_detail`.*, `product_setting`.`setting_val` 

                FROM `proudct_detail` 

                join `product_setting`  on `proudct_detail`.`prodet_id` = `product_setting`.`p_id`

                WHERE 



                {$search_sql} {$cat_filter}



                `product_setting`.`setting_name`='publicAccess' 

                AND `product_setting`.`setting_val`={$setting_val} 

                AND `proudct_detail`.`product_update`='1' 

        ";



        // echo $total_count_sql.' | <br>';



        # overriding sql for pending products, for total count and normal count

        if ($page == 'pending_products') {



            $date=date('m/d/Y');

            $total_count_sql = $qry="  SELECT `proudct_detail`.*, `product_setting`.`setting_val`

                    FROM `proudct_detail` join `product_setting`

                    on `proudct_detail`.`prodet_id` = `product_setting`.`p_id`

                    WHERE 



                        {$search_sql} 



                    `product_setting`.`setting_name`='launchDate'

                    AND `product_setting`.`setting_val` > '$date'

                    AND `proudct_detail`.`product_update` = '1'

                    ORDER BY `proudct_detail`.`prodet_id` DESC ";



        }







        $all_data = $this->dbF->getRows($total_count_sql);

        $recordsTotal = $this->dbF->rowCount;





        ###### Get Data ######

        $qry = "SELECT `proudct_detail`.*, `product_setting`.`setting_val`

                FROM `proudct_detail` 

                join `product_setting` on `proudct_detail`.`prodet_id` = `product_setting`.`p_id`

                WHERE 



                {$search_sql} {$cat_filter}



                `product_setting`.`setting_name`='publicAccess' 

                AND `product_setting`.`setting_val`={$setting_val} 

                AND `proudct_detail`.`product_update`='1'

                {$order_sql} LIMIT {$start},{$length} ";



                // echo $qry.' | <br>';



        # overriding sql for pending products, for total count and normal count

        if ($page == 'pending_products') {

            $qry = $total_count_sql;

        }



        $data = $this->dbF->getRows($qry);





        $columns = array();

        if($draw == 1){ $draw - 1; }



        $columns["draw"] =$draw+1;

        $columns["recordsTotal"] = $recordsTotal; //total record,

        $columns["recordsFiltered"] = $recordsTotal; //filter record, same as total record, then next button will appear



        $i = $start;

        foreach($data as $key => $val){

            $i++;

            $defaultLang= $this->functions->AdminDefaultLanguage();
   $prac_id = $this->functions->UserName($val['prac_id']);
            $name=getTextFromSerializeArray($val['prodet_name'])." (".$prac_id.")";

            $sDesc = getTextFromSerializeArray($val['prodet_shortDesc']);

            $views = $val['view'];

            $sales = $val['sale'];

            $id    = $val['prodet_id'];
            
            # this functions uses $_SERVER['REQUEST_URI'], as now we are using ajax request so the link in $_SERVER['REQUEST_URI'] is of the ajax request not the current url in browser, so we are hardcoding this for the time being, new way / function will have to be created.

            // $link  = $this->functions->getLinkFolder();

            $link  = 'product';



            $pro_img = $this->product->productF->getProductSingleImage($id);

            $img_pa = WEB_URL.'/images/'.$pro_img['image'];



            $smlImage = $this->functions->resizeImage($pro_img['image'], '80', '90', false);





            // $grpOption  =   $this->email->emailGrpOption($val['grp']);

            // $group      = "<div class='btn-group grpDiv btn-group-sm  col-sm-12' data-id='$id'>

            //                     <select class='form-control emailGrp col-sm-10' onchange='emailGroup(this);' style='width: 80%'>

            //                         $grpOption

            //                     </select>

            //                     <div class='col-sm-2' style='padding: 8px 0'>

            //                         <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>

            //                     </div>

            //                     <div class='col-sm-12 padding-0 emailOtherGrp displaynone' style='padding: 8px 0'>

            //                         <div class='col-sm-8 padding-0'>

            //                             <input type='text' class='form-control emailOtherInput' style='width: 100%'/>

            //                         </div>

            //                         <div class='col-sm-4 padding-0'>

            //                             <button class='btn btn-sm btn-primary emailOtherButton' onclick='emailOtherGroup(this)' type='button'>". _uc($_e['Update']) ."</button>

            //                         </div>

            //                     </div>

            //                 </div>";

            $group = "";







            //For featured Item

            $featureProduct = "";

            if($this->functions->developer_setting('featureProduct')=='1') {

                $featureProduct = true;

                $status = $val['feature'];

                if ($status == '1') {

                    $class = "glyphicon glyphicon-star";

                    $status = '0';

                } else {

                    $class = "glyphicon glyphicon-star-empty";

                    $status = '1';

                }

                $featureProduct = "<a data-id ='$id' data-val='$status' onclick='featureItem(this);' class='btn'   title='". $_e['Active/DeActive Feature item'] ."'>

                        <i class='$class trash'></i>

                        <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>

                    </a>";

            }



            //For Trending Fashion

            $feature2 = "";

            if($this->functions->developer_setting('featureProduct2')=='1') {

                $feature2 = true;

                $statusT = $val['feature'];

                if ($statusT == '2') {

                    $classT = "glyphicon glyphicon-heart";

                    $statusT = '3';

                } else {

                    $classT = "glyphicon glyphicon-heart-empty";

                    $statusT = '2';

                }

                $feature2 = "<a data-id ='$id' data-val='$statusT' onclick='trandingItem(this);' class='btn'   title='". $_e['Active/DeActive Feature item2'] ."'>

                        <i class='$classT trash'></i>

                        <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>

                    </a>";

            }





            $seoLink = '';

            if($this->functions->developer_setting('seo') == '1'){

                $this->functions->getAdminFile("seo/classes/seo.class.php");

                $seoC = new seo();

                $seoLink = $seoC->seoQuickLink($id,urlencode("/".$this->db->productDetail."$val[slug]"));

            }











            // $action = "<div class='btn-group btn-group-sm'>

            //                 <a data-id='$id' data-val='0' onclick='activeEmail(this);' class='btn'   title='". $_e['DeActive Email'] ."'>

            //                     <i class='glyphicon glyphicon-thumbs-down trash'></i>

            //                     <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>

            //                 </a>

            //                 <a data-id='$id' onclick='deleteEmail(this);' class='btn'   title='". $_e['Delete Email'] ."'>

            //                     <i class='glyphicon glyphicon-trash trash'></i>

            //                     <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>

            //                 </a>

            //             </div>";

            // if($page == 'data_ajax_unactive_email') {

            //     $action = "<div class='btn-group btn-group-sm'>

            //                 <a data-id='$id' data-val='1' onclick='activeEmail(this);' class='btn'  title='" . $_e['Active Email'] . "'>

            //                     <i class='glyphicon glyphicon-thumbs-up trash'></i>

            //                     <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>

            //                 </a>

            //                 <a data-id='$id' onclick='deleteEmail(this);' title='" . $_e['Delete'] . "' class='btn'>

            //                     <i class='glyphicon glyphicon-trash trash'></i>

            //                     <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>

            //                 </a>

            //             </div>";

            // }





            $uniq = ( isset($_GET['uniq']) ) ? $_GET['uniq'] : 'no-uniq';

            $first_column = " 

                        <div class='checkbox'>

                            <label>

                                <input type='checkbox' ng-checked='$uniq' name='productListCheck[]' value='$id'> $i

                            </label>

                        </div>

            ";

            $myprefix = $this->product->prefix_editPro;

            // var_dump($this->product);

            $action = "

                            

                                <div class='btn-group btn-group-sm'>

                                    $featureProduct

                                    $feature2



                                    $seoLink



                                <a data-id='$id' href='?{$myprefix}=$id'

                                    data-method='post' data-action='-$link?page=edit'

                                    class='btn'><i class='glyphicon glyphicon-edit'></i></a>

                                <a data-id='$id' onclick='AjaxDelScript(this);' class='btn '>

                                    <i class='glyphicon glyphicon-trash trash'></i>

                                    <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>

                                </a>

                                <a data-id='$id' href='?{$myprefix}=$id&copy=true'

                                    data-method='post' data-action='-$link?page=edit'

                                    class='btn'><i class='fa fa-clipboard'></i></a>
                                </div>

                           

                    ";



            $checked = (in_array($id, $product_idSelect) || in_array($id, $cat_pro)) ? 'checked' : '';



            $checkbox = "<input type='checkbox' id='$id' value='$id' name='prod_check' class='prod_check' $checked>";



            //6 columns
          $sn  = unserialize($this->getProductDetail('sn',$id));
          $smin_stock  = $this->getProductDetail('min_stock',$id);
            $columns["data"][$key] = array(

                // $checkbox,

                $i, ##### disabling this for the time being needs work "{$first_column}",
               ///  $this->getProductDetail('SKU',$id),
                 $smin_stock,
    
                "<img src='$smlImage'>",

                "{$sn[$defaultLang]}",

                "{$name}",

                "{$sDesc}",

                "{$val['prodet_timeStamp']}",

                $views,

                $sales,

                $action

            );

        }

        if($recordsTotal =='0'){

            $columns["data"] = array();

        }

        //Jason Encode

        

        echo json_encode( $columns );

    }



    public function productByCategoryNew($category, $QuickViewId = false, $hasId = true)

    {



        $sql = "SELECT * FROM `categories` WHERE id = ? ";

        if ($hasId == false) {

            $sql = "SELECT * FROM `categories` WHERE name = ?";

        }

        $catData = $this->dbF->getRow($sql, array($category));



        if (!$this->dbF->rowCount) {

            return false;

        }



        $catId = $catData['id'];

        $catId = $this->getSubCatIdsNew($catId); //array





        $LIKE = "";

        foreach ($catId as $val) {

            $cId = $val;

            $LIKE .= " `product_category`.`procat_cat_id` LIKE '%$cId%' OR";

        }

        $LIKE = trim($LIKE, "OR");



        //Find Product That in this category

        $sql = "SELECT `procat_prodet_id`,`prodet_id`

                                FROM `product_category`

                                JOIN

                                `proudct_detail` as detail

                                  on `product_category`.`procat_prodet_id` = `detail`.`prodet_id`

                                    WHERE $LIKE

                                      GROUP BY `detail`.`prodet_id`";

        

        $productIds = $this->dbF->getRows($sql);

        return $productIds;

        // return $this->productPrint($mergerd_products, $QuickViewId, $products);

        //return $catId;

    }



    public function getSubCatIdsNew($parent)

    {

        //4 dept first query is 2 dept.

        $sql = "SELECT * FROM `categories` WHERE id = '$parent'";

        $data = $this->dbF->getRows($sql);

        $cat = array();

        if ($this->dbF->rowCount > 0) {

            //1 2 dept

            foreach ($data as $val) {

                $id = $val['id'];

                $cat[] = $id;

                $sql = "SELECT * FROM `categories` WHERE id = '$id'";

                $data2 = $this->dbF->getRows($sql);

                if ($this->dbF->rowCount > 0) {

                    //3 dept

                    foreach ($data2 as $val2) {

                        $id = $val2['id'];

                        $cat[] = $id;

                        $sql = "SELECT * FROM `categories` WHERE id = '$id'";

                        $data3 = $this->dbF->getRows($sql);

                        foreach ($data3 as $val3) {

                            //4 dept

                            $id = $val3['id'];

                            $cat[] = $id;

                        } //4 dept end

                    }

                }//3 dept end

            }

        } //1 2 dept end



        $cat = array_unique($cat);

        return $cat;

    }



    public function addProToCat(){

        $catArray = $_POST['catArray'];

        $proArray = $_POST['proArray'];

        $newCat = array();



        foreach ($proArray as $key => $value) {

            $cat_exp[] = '';

            $sql = "SELECT * FROM `product_category` WHERE `procat_prodet_id` = ?";

            $res = $this->dbF->getRow($sql, array($value));

            $cat_exp = explode(',', $res['procat_cat_id']);



            foreach ($catArray as $key1 => $value1) {

                if(!in_array($value1,$cat_exp)){

                   array_push($cat_exp,$value1); 

                }

            }

            $proNewCat = join(',',$cat_exp);



            $sql1 = "UPDATE `product_category` SET `procat_cat_id` = ? WHERE `procat_prodet_id` = ?";

            $res1 = $this->dbF->setRow($sql1, array($proNewCat, $value));



            if($this->dbF->rowCount)echo "1";

            else{echo "0";}

        }

    }



    public function removeProFromCat(){

        $catArray = $_POST['catArray'];

        $proArray = $_POST['proArray'];

        $newCat = array();



        foreach ($proArray as $key => $value) {

            $cat_exp[] = '';

            $sql = "SELECT * FROM `product_category` WHERE `procat_prodet_id` = ?";

            $res = $this->dbF->getRow($sql, array($value));

            $cat_exp = explode(',', $res['procat_cat_id']);



            foreach ($catArray as $key1 => $value1) {



                if (($key = array_search($value1, $cat_exp)) !== false) {

                    unset($cat_exp[$key]);

                }



                // if(in_array($value1,$cat_exp)){

                //    array_pop($cat_exp,$value1); 

                // }

            }

            $proNewCat = join(',',$cat_exp);



            $sql1 = "UPDATE `product_category` SET `procat_cat_id` = ? WHERE `procat_prodet_id` = ?";

            $res1 = $this->dbF->setRow($sql1, array($proNewCat, $value));



            if($this->dbF->rowCount)echo "1";

            else{echo "0";}

        }

    }

    public function copyMissingProducts(){
        global $con;
        $ids        = json_decode($_POST['ids']);
        $copyData   = array();

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
        
        $country_other    = $priceCalc['country'][10];
        $other_divide     = $priceCalc['divide'][10];
        $other_multiply   = $priceCalc['multiply'][10];
        

        #############  GET PRODUCT ORIGINAL DATA  #############
        
            foreach ($ids as $key => $value) {

                $new_id = 'ss'.$value;
            /* -------  ##############  PRODUCT_DETAIL TABLE  #############  -------- */

            

                $sql_proInfo = "SELECT `prodet_id`, `slug`, `prodet_name`, `prodet_shortDesc`, `product_update`, `sort`, `feature` FROM `proudct_detail` WHERE `prodet_id` = $value";
                $res_proInfo = $this->dbF->getRow($sql_proInfo);

                $copyData[$new_id]['proInfo'] = $res_proInfo;

                $check_ref = '%product-'.$res_proInfo['prodet_id'].'%';

                $sql_proSeo = "SELECT * FROM `seo` WHERE `ref_id` LIKE '$check_ref'";
                $res_proSeo = $this->dbF->getRow($sql_proSeo);

                $copyData[$new_id]['proInfo']['seo'] = $res_proSeo;



            /* ----------  ##############  PRODUCT_PRICE TABLE  ############# ------------  */


                $sql_proPrice = "SELECT `propri_cur_id`, `propri_price`, `propri_intShipping` FROM `product_price` WHERE `propri_prodet_id` = $value AND `propri_cur_id` = 20";
                $res_proPrice = $this->dbF->getRow($sql_proPrice);

                $copyData[$new_id]['proPrice'] = $res_proPrice;


            /* ---------  ##############  PRODUCT_ADDCOST TABLE  ############# -----------  */


                $sql_proaddcost = "SELECT `proadc_name`, `proadc_price` FROM `product_addcost` WHERE `proadc_prodet_id` = $value AND `proadc_cur_id` = 20";
                $res_proaddcost = $this->dbF->getRow($sql_proaddcost);

                if(!empty($res_proaddcost)){
                    $copyData[$new_id]['proadc'] = $res_proaddcost; 
                }               


            /* ---------  ##############  PRODUCT_IMAGE TABLE  ############# -----------  */


                $sql_proimg = "SELECT `image`, `alt`, `sort` FROM `product_image` WHERE `product_id` = $value";
                $res_proimg = $this->dbF->getRows($sql_proimg);

                if(!empty($res_proimg)){
                    $copyData[$new_id]['proimg'] = $res_proimg; 
                }


            /* ---------  ##############  PRODUCT_SETTING TABLE  ############# -----------  */


                $sql_proSetting = "SELECT * FROM `product_setting` WHERE `p_id` = $value";
                $res_proSetting = $this->dbF->getRows($sql_proSetting);

                if(!empty($res_proSetting)){
                    $copyData[$new_id]['proSetting'] = $res_proSetting; 
                }
                

            /* ---------  ##############  PRODUCT_DISCOUNT/PRICES/SETTING TABLE  ############# -----------  */


                $sql_proDiscount = "SELECT `product_dis_id`, `product_dis_price`, `product_dis_status`, `product_dis_intShipping` FROM `product_discount` d JOIN `product_discount_prices` dp ON d.`product_discount_pk` = dp.`product_dis_id` WHERE d.`discount_PId` = $value AND `product_dis_curr_Id` = 20";
                $res_proDiscount = $this->dbF->getRow($sql_proDiscount);

                if(!empty($res_proDiscount)){
                 $copyData[$new_id]['proDiscount'] = $res_proDiscount; 

                    $sql_proDiscSetting = "SELECT `product_dis_name`, `product_dis_value` FROM `product_discount_setting` WHERE `product_dis_id` = ?";
                    $res_proDiscSetting = $this->dbF->getRows($sql_proDiscSetting, array($res_proDiscount['product_dis_id']));

                    $copyData[$new_id]['proDiscount']['setting'] = $res_proDiscSetting;
                }


            /* ---------  ##############  PRODUCT_COLOR TABLE  ############# -----------  */


                $sql_proColorId = "SELECT `propri_id`,`proclr_name` FROM `product_color` WHERE `proclr_prodet_id` = $value AND `proclr_cur_id` = 24";
                $res_proColorId = $this->dbF->getRows($sql_proColorId);

                if(!empty($res_proColorId)){
                    $countColor = 0;
                    foreach ($res_proColorId as $keyid => $valueid) {
                        
                        $sql_proColor = "SELECT `proclr_name`, `color_name`, `proclr_price`, `sizeGroup` FROM `product_color` WHERE `proclr_prodet_id` = $value AND `proclr_cur_id` = 20 AND `proclr_name` = ?";
                        $res_proColor = $this->dbF->getRow($sql_proColor, array($valueid['proclr_name']));


                        $copyData[$new_id]['proColor'][] = $res_proColor;
                        $copyData[$new_id]['proColor'][$countColor]['id'] = $valueid['propri_id'];
                        $countColor++;
                    }   
                }


            /* ---------  ##############  PRODUCT_SCALE TABLE  ############# -----------  */


                $sql_proScaleId = "SELECT `prosiz_id`,`prosiz_name` FROM `product_size` WHERE `prosiz_prodet_id` = $value AND `prosiz_cur_id` = 24";
                $res_proScaleId = $this->dbF->getRows($sql_proScaleId);

                if(!empty($res_proScaleId)){
                    $countScale = 0;
                    foreach ($res_proScaleId as $keyid => $valueid) {
                        
                        $sql_proScale = "SELECT `prosiz_name`, `prosiz_price`, `sizeGroup` FROM `product_size` WHERE `prosiz_prodet_id` = $value AND `prosiz_cur_id` = 20 AND `prosiz_name` = ?";
                        $res_proScale = $this->dbF->getRow($sql_proScale, array($valueid['prosiz_name']));


                        $copyData[$new_id]['proScale'][] = $res_proScale;
                        $copyData[$new_id]['proScale'][$countScale]['id'] = $valueid['prosiz_id'];
                        $countScale++;
                    }   
                }


            /* ---------  ##############  PRODUCT_SIZECUSTOM TABLE  ############# -----------  */


                $sql_proSizCustom = "SELECT `type_id`, `price` FROM `product_size_custom` WHERE `pId` = $value AND `currencyId` = 20";
                $res_proSizCustom = $this->dbF->getRow($sql_proSizCustom);

                if(!empty($res_proSizCustom)){
                    $copyData[$new_id]['proSizeCustom'] = $res_proSizCustom;
                }
                


            /* ---------  ##############  PRODUCT_CATEGORY TABLE  ############# -----------  */


                $sql_proCategory = "SELECT `procat_cat_id` FROM `product_category` WHERE `procat_prodet_id` = $value";
                $res_proCategory = $this->dbF->getRow($sql_proCategory);

                $copyData[$new_id]['proCategory'] = trim($res_proCategory['procat_cat_id'], ',');


            }

            

        // $this->dbF->prnt($copyData);
        // exit;

        #############  GET PRODUCT ORIGINAL DATA END  #############
        









        if(!empty($migrate_products) && $migrate_products == 1){

        ######################  SET PRODUCT DATA  #######################
        
        foreach ($copyData as $key => $value) {   
        // var_dump($key);
        /* ---------  ##############  SET PRODUCT_DETAIL/SEO TABLE  ############# -----------  */

            if(isset($value['proInfo'])){
                $proName = unserialize($value['proInfo']['prodet_name']);
                $proName = $proName['Swedish'];

                $now     = date('Y-m-d H:i:s');

                $proNameUpdArray['Swedish'] = $proName;
                $proNameUpdArray['French'] = '';
                $proNameUpdArray['German'] = '';
                $proNameUpdArray['English'] = '';
                $proNameUpdArray['Dutch'] = '';
                $proNameUpdArray['Italian'] = '';
                $proNameUpdArray['Spanish'] = '';

                $proNameUpd = serialize($proNameUpdArray);

                $proShortDesc = unserialize($value['proInfo']['prodet_shortDesc']);
                $proShortDesc = $proShortDesc['Swedish'];

                $proShortDescUpdArray['Swedish'] = $proShortDesc;
                $proShortDescUpdArray['French'] = '';
                $proShortDescUpdArray['German'] = '';
                $proShortDescUpdArray['English'] = '';
                $proShortDescUpdArray['Dutch'] = '';
                $proShortDescUpdArray['Italian'] = '';
                $proShortDescUpdArray['Spanish'] = '';

                $proShortDescUpd = serialize($proShortDescUpdArray);

                $slug = 'ss'.$value['proInfo']['slug'];
                $product_update = $value['proInfo']['product_update'];
                $sort = (isset($value['proInfo']['sort'])) ? $value['proInfo']['sort'] : '';
                $feature = $value['proInfo']['feature'];

                $sqlDetailCheck = "SELECT `prodet_id` FROM `proudct_detail` WHERE `prodet_id` = '$key'";
                $resDetailCheck = $con->getRow($sqlDetailCheck);

                if(empty($resDetailCheck)){
                    $sql_proDetail_upd = "INSERT INTO `proudct_detail`(`prodet_id`, `slug`, `prodet_name`, `prodet_shortDesc`, `product_update`, `prodet_addOn`, `feature`)
                                        VALUES ('$key','$slug','$proNameUpd','$proShortDescUpd','$product_update','$now',$feature)";

                    $res_proDetail_upd = $con->setRow($sql_proDetail_upd);
                }
            }


            $pageLink = '/product-'.$slug;
            $ref_id   = '/product-'.$key;

            if(!empty($value['proInfo']['seo'])){

                $seoTitle = unserialize($value['proInfo']['seo']['title']);
                $seoTitle = $seoTitle['Swedish'];

                $seoTitleUpdArray['Swedish']    = $seoTitle;
                $seoTitleUpdArray['French']     = '';
                $seoTitleUpdArray['German']     = '';
                $seoTitleUpdArray['English']    = '';
                $seoTitleUpdArray['Dutch']      = '';
                $seoTitleUpdArray['Italian']    = '';
                $seoTitleUpdArray['Spanish']    = '';

                $seoTitleUpd = serialize($seoTitleUpdArray);

                $seoKeyword = unserialize($value['proInfo']['seo']['keywords']);
                $seoKeyword = $seoKeyword['Swedish'];

                $seoKeywordUpdArray['Swedish']  = $seoKeyword;
                $seoKeywordUpdArray['French']   = '';
                $seoKeywordUpdArray['German']   = '';
                $seoKeywordUpdArray['English']  = '';
                $seoKeywordUpdArray['Dutch']        = '';
                $seoKeywordUpdArray['Italian']  = '';
                $seoKeywordUpdArray['Spanish']  = '';

                $seoKeywordUpd = serialize($seoKeywordUpdArray);

                $seoDsc = unserialize($value['proInfo']['seo']['dsc']);
                $seoDsc = $seoDsc['Swedish'];

                $seoDscUpdArray['Swedish']  = $seoDsc;
                $seoDscUpdArray['French']   = '';
                $seoDscUpdArray['German']   = '';
                $seoDscUpdArray['English']  = '';
                $seoDscUpdArray['Dutch']        = '';
                $seoDscUpdArray['Italian']  = '';
                $seoDscUpdArray['Spanish']  = '';

                $seoDscUpd = serialize($seoDscUpdArray);

                $seoCanonical = unserialize($value['proInfo']['seo']['canonical']);
                $seoCanonical = $seoCanonical['Swedish'];

                $seoCanonicalUpdArray['Swedish']    = $seoCanonical;
                $seoCanonicalUpdArray['French']     = '';
                $seoCanonicalUpdArray['German']     = '';
                $seoCanonicalUpdArray['English']    = '';
                $seoCanonicalUpdArray['Dutch']      = '';
                $seoCanonicalUpdArray['Italian']    = '';
                $seoCanonicalUpdArray['Spanish']    = '';

                $seoCanonicalUpd = serialize($seoCanonicalUpdArray);

                $seoAuthor = unserialize($value['proInfo']['seo']['author']);
                $seoAuthor = $seoAuthor['Swedish'];

                $seoAuthorUpdArray['Swedish']   = $seoAuthor;
                $seoAuthorUpdArray['French']    = '';
                $seoAuthorUpdArray['German']    = '';
                $seoAuthorUpdArray['English']   = '';
                $seoAuthorUpdArray['Dutch']         = '';
                $seoAuthorUpdArray['Italian']   = '';
                $seoAuthorUpdArray['Spanish']   = '';

                $seoAuthorUpd = serialize($seoAuthorUpdArray);

                $seoSpecial         = empty($value['proInfo']['seo']['special']) ? $value['proInfo']['seo']['special'] : '';
                $seosIndex          = empty($value['proInfo']['seo']['sIndex']) ? $value['proInfo']['seo']['sIndex'] : 0;
                $seosFollow         = empty($value['proInfo']['seo']['sFollow']) ? $value['proInfo']['seo']['sFollow'] : 0;
                $seoRewriteTitle    = empty($value['proInfo']['seo']['rewriteTitle']) ? $value['proInfo']['seo']['rewriteTitle'] : 0;
                $seoRevisitAfter    = empty($value['proInfo']['seo']['revisit-after']) ? $value['proInfo']['seo']['revisit-after'] : '';
                $seoType            = empty($value['proInfo']['seo']['type']) ? $value['proInfo']['seo']['type'] : '';
                $seoPublish         = empty($value['proInfo']['seo']['publish']) ? $value['proInfo']['seo']['publish'] : '';

                $sqlSeoCheck = "SELECT `slug` FROM `seo` WHERE `ref_id` LIKE '%product-$key%'";
                $resSeoCheck = $con->getRow($sqlSeoCheck);

                if(empty($resSeoCheck)){

                    $sqlSeo = "INSERT INTO `seo`(`pageLink`, `ref_id`, `slug`, `title`, `keywords`, `dsc`, `special`, `canonical`, `sIndex`, `sFollow`, `rewriteTitle`, `author`, `revisit-after`, `type`, `publish`) VALUES ('$pageLink','$ref_id','$slug','$seoTitleUpd','$seoKeywordUpd','$seoDscUpd','$seoSpecial','$seoCanonicalUpd','$seosIndex','$seosFollow','$seoRewriteTitle','$seoAuthorUpd','$seoRevisitAfter','$seoType','$seoPublish')";

                    $resSeo = $con->setRow($sqlSeo);
                     
                }      

            }


            /* ---------  ##############  SET PRODUCT_PRICE TABLE  ############# -----------  */


            if(!empty($value['proPrice'])){

                $priceIntShip   = $value['proPrice']['propri_intShipping'];
                $sek_price      = $value['proPrice']['propri_price'];

                $fr_price       = doubleval(($sek_price/$fr_divide)*$fr_multiply);
                $fr_price       = ceil($fr_price);

                $de_price       = doubleval(($sek_price/$de_divide)*$de_multiply);
                $de_price       = ceil($de_price);

                $nl_price       = doubleval(($sek_price/$nl_divide)*$nl_multiply);
                $nl_price       = ceil($nl_price);

                $us_price       = doubleval(($sek_price/$us_divide)*$us_multiply);
                $us_price       = ceil($us_price);

                $be_price       = doubleval(($sek_price/$be_divide)*$be_multiply);
                $be_price       = ceil($be_price);

                $uk_price       = doubleval(($sek_price/$uk_divide)*$uk_multiply);
                $uk_price       = ceil($uk_price);

                $es_price       = doubleval(($sek_price/$es_divide)*$es_multiply);
                $es_price       = ceil($es_price);

                $at_price       = doubleval(($sek_price/$at_divide)*$at_multiply);
                $at_price       = ceil($at_price);

                $it_price       = doubleval(($sek_price/$it_divide)*$it_multiply);
                $it_price       = ceil($it_price);

                $chf_price      = doubleval(($sek_price/$chf_divide)*$chf_multiply);
                $chf_price      = ceil($chf_price);

                $other_price      = doubleval(($sek_price/$other_divide)*$other_multiply);
                $other_price      = ceil($other_price);

                $sqlPriceCheck = "SELECT `propri_prodet_id` FROM `product_price` WHERE `propri_prodet_id` = '$key' AND `propri_cur_id` = 20";
                $resPriceCheck = $con->getRow($sqlPriceCheck);

                if(empty($resPriceCheck)){
                    $sql_price = "INSERT INTO `product_price`(`propri_prodet_id`, `propri_cur_id`, `propri_price`, `propri_intShipping`) VALUES 
                            ('$key',$country_chf,$chf_price,$priceIntShip),
                            ('$key',$country_fr,$fr_price,$priceIntShip),
                            ('$key',$country_de,$de_price,$priceIntShip),
                            ('$key',$country_nl,$nl_price,$priceIntShip),
                            ('$key',$country_us,$us_price,$priceIntShip),
                            ('$key',$country_be,$be_price,$priceIntShip),
                            ('$key',$country_uk,$uk_price,$priceIntShip),
                            ('$key',$country_es,$es_price,$priceIntShip),
                            ('$key',$country_at,$at_price,$priceIntShip),
                            ('$key',$country_it,$it_price,$priceIntShip),
                            ('$key',$country_other,$other_price,$priceIntShip)";
                    
                    $res_price = $con->setRow($sql_price);

                }

            }


            /* ---------  ##############  SET PRODUCT_IMAGE/REFER IMAGE TABLE  ############# -----------  */
        

            if(!empty($value['proimg'])){
                foreach ($value['proimg'] as $keyImg => $valueImg) {
                    $proImg     = $valueImg['image'];
                    $proAlt     = $valueImg['alt'];
                    $proSort    = $valueImg['sort'];

                    $referLink  = WEB_URL.'/images/'.$proImg;   

                    $sqlImgCheck = "SELECT `image` FROM `product_image` WHERE `product_id` = '$key'";
                    $resImgCheck = $con->getRow($sqlImgCheck);

                    if(empty($resImgCheck)){

                        $sqlImg = "INSERT INTO `product_image`(`product_id`, `image`, `alt`, `sort`) 
                                        VALUES ('$key', '$proImg', '$proAlt', '$proSort')";

                        $resImg = $con->setRow($sqlImg);
                        
                        $sqlImgRefer = "INSERT INTO `product_image_refer`(`p_id`, `img_link`, `upload_path`, `remove`) VALUES ('$key', '$referLink', '$proImg', 0)";

                        $resImgRefer = $con->setRow($sqlImgRefer);
                        
                    }

                    
                }
            }


            /* ---------  ##############  SET PRODUCT_SETTING TABLE  ############# -----------  */


            if(!empty($value['proSetting'])){

                $sqlSettingCheck = "SELECT `p_id` FROM `product_setting` WHERE `p_id` = '$key'";
                $resSettingCheck = $con->getRow($sqlSettingCheck);

                if(empty($resSettingCheck)){

                    $sqlSetting = "INSERT INTO `product_setting`(`p_id`, `setting_name`, `setting_val`) VALUES ";
                    foreach ($value['proSetting'] as $keySet => $valueSet) {
                        $sqlSetting .= "(?,?,?),";

                        $proSettingArray[] = $key;
                        $proSettingArray[] = $valueSet['setting_name'];

                        if($valueSet['setting_name'] == 'ldesc'){
                            $setting_val = unserialize($valueSet['setting_val']);
                            $setting_val = $setting_val['Swedish'];

                            $settingldescArray['Swedish']   = $setting_val;
                            $settingldescArray['French']    = '';
                            $settingldescArray['German']    = '';
                            $settingldescArray['English']   = '';
                            $settingldescArray['Dutch']     = '';
                            $settingldescArray['Italian']   = '';
                            $settingldescArray['Spanish']   = '';

                            $settingldesc = serialize($settingldescArray);


                            $proSettingArray[] = $settingldesc;
                        }
                        elseif($valueSet['setting_name'] == 'size_chart'){

                            $setting_val = unserialize($valueSet['setting_val']);
                            $setting_val = $setting_val['Swedish'];

                            $settingSchartArray['Swedish']  = $setting_val;
                            $settingSchartArray['French']   = '';
                            $settingSchartArray['German']   = '';
                            $settingSchartArray['English']  = '';
                            $settingSchartArray['Dutch']    = '';
                            $settingSchartArray['Italian']  = '';
                            $settingSchartArray['Spanish']  = '';

                            $settingSchart = serialize($settingSchartArray);

                            $proSettingArray[] = $settingSchart;

                        }
                        elseif($valueSet['setting_name'] == 'tags'){

                            $setting_val = unserialize($valueSet['setting_val']);
                            $setting_val = $setting_val['Swedish'];

                            $settingTagsArray['Swedish']    = $setting_val;
                            $settingTagsArray['French']     = '';
                            $settingTagsArray['German']     = '';
                            $settingTagsArray['English']    = '';
                            $settingTagsArray['Dutch']      = '';
                            $settingTagsArray['Italian']    = '';
                            $settingTagsArray['Spanish']    = '';

                            $settingTags = serialize($settingTagsArray);

                            $proSettingArray[] = $settingTags;

                        }
                        elseif($valueSet['setting_name'] == 'specification'){

                            $setting_val = unserialize($valueSet['setting_val']);
                            $setting_val = $setting_val['Swedish'];

                            $settingSpecsArray['Swedish']   = $setting_val;
                            $settingSpecsArray['French']    = '';
                            $settingSpecsArray['German']    = '';
                            $settingSpecsArray['English']   = '';
                            $settingSpecsArray['Dutch']     = '';
                            $settingSpecsArray['Italian']   = '';
                            $settingSpecsArray['Spanish']   = '';

                            $settingSpecs = serialize($settingSpecsArray);

                            $proSettingArray[] = $settingSpecs;

                        }
                        elseif($valueSet['setting_name'] == 'featureIcon'){

                            $setting_val = unserialize($valueSet['setting_val']);
                            $setting_val = $setting_val['Swedish'];

                            $settingFeaturIconArray['Swedish']  = $setting_val;
                            $settingFeaturIconArray['French']   = '';
                            $settingFeaturIconArray['German']   = '';
                            $settingFeaturIconArray['English']  = '';
                            $settingFeaturIconArray['Dutch']    = '';
                            $settingFeaturIconArray['Italian']  = '';
                            $settingFeaturIconArray['Spanish']  = '';

                            $settingFeaturIcon = serialize($settingFeaturIconArray);

                            $proSettingArray[] = $settingFeaturIcon;

                        }
                        elseif($valueSet['setting_name'] == 'featurePoints'){

                            $setting_val = unserialize($valueSet['setting_val']);
                            $setting_val = $setting_val['Swedish'];

                            $settingFeaturPointArray['Swedish']     = $setting_val;
                            $settingFeaturPointArray['French']      = '';
                            $settingFeaturPointArray['German']      = '';
                            $settingFeaturPointArray['English']     = '';
                            $settingFeaturPointArray['Dutch']       = '';
                            $settingFeaturPointArray['Italian']     = '';
                            $settingFeaturPointArray['Spanish']     = '';

                            $settingFeaturPoint = serialize($settingFeaturPointArray);

                            $proSettingArray[] = $settingFeaturPoint;

                        }
                        elseif($valueSet['setting_name'] == 'combineWith'){
                            $setting_val = unserialize($valueSet['setting_val']);
                            $settingCombineArray = array();
                            foreach ($setting_val as $row) {
                                $newCat = 'ss'.$row;
                                $settingCombineArray[] = $newCat;
                            }

                            $settingCombineSer = serialize($settingCombineArray);

                            $proSettingArray[] = $settingCombineSer;
                        }
                        else {
                            $proSettingArray[] = $valueSet['setting_val'];
                        }

                    }
                    $sqlSetting = trim($sqlSetting, ',');

                    $resSetting = $con->setRow($sqlSetting, $proSettingArray);

                }
                
            }


            /* ---------  ##############  SET PRODUCT_DISCOUNT TABLE  ############# -----------  */


            if(!empty($value['proDiscount'])){

                $sqlDiscountCheck = "SELECT * FROM `product_discount` WHERE `discount_PId` = '$key'";
                $resDiscountCheck = $con->getRow($sqlDiscountCheck);

                if(empty($resDiscountCheck)){

                    $proDiscId = 'ss'.$value['proDiscount']['product_dis_id'];
                    $proDisPrice = $value['proDiscount']['product_dis_price'];
                    $proDisStatus = $value['proDiscount']['product_dis_status'];
                    $proDisShipping = $value['proDiscount']['product_dis_intShipping'];

                    $sql_discount = "INSERT INTO `product_discount`(`product_discount_pk`, `discount_PId`, `product_dis_status`) VALUES ('$proDiscId', '$key', $proDisStatus)";

                    $res_discount = $con->setRow($sql_discount);

                    $fr_price       = doubleval(($proDisPrice/$fr_divide)*$fr_multiply);
                    $fr_price       = ceil($fr_price);

                    $de_price       = doubleval(($proDisPrice/$de_divide)*$de_multiply);
                    $de_price       = ceil($de_price);

                    $nl_price       = doubleval(($proDisPrice/$nl_divide)*$nl_multiply);
                    $nl_price       = ceil($nl_price);

                    $us_price       = doubleval(($proDisPrice/$us_divide)*$us_multiply);
                    $us_price       = ceil($us_price);

                    $be_price       = doubleval(($proDisPrice/$be_divide)*$be_multiply);
                    $be_price       = ceil($be_price);

                    $uk_price       = doubleval(($proDisPrice/$uk_divide)*$uk_multiply);
                    $uk_price       = ceil($uk_price);

                    $es_price       = doubleval(($proDisPrice/$es_divide)*$es_multiply);
                    $es_price       = ceil($es_price);

                    $at_price       = doubleval(($proDisPrice/$at_divide)*$at_multiply);
                    $at_price       = ceil($at_price);

                    $it_price       = doubleval(($proDisPrice/$it_divide)*$it_multiply);
                    $it_price       = ceil($it_price);

                    $chf_price      = doubleval(($proDisPrice/$chf_divide)*$chf_multiply);
                    $chf_price      = ceil($chf_price);

                    $other_price      = doubleval(($proDisPrice/$other_divide)*$other_multiply);
                    $other_price      = ceil($other_price);

                    $sqlDiscountSetting = "INSERT INTO `product_discount_prices`(`product_dis_id`, `product_dis_curr_Id`, `product_dis_price`, `product_dis_intShipping`) 
                                    VALUES ('$proDiscId','$country_chf', $chf_price, $proDisShipping),
                                            ('$proDiscId','$country_fr', $fr_price, $proDisShipping),
                                            ('$proDiscId','$country_de', $de_price, $proDisShipping),
                                            ('$proDiscId','$country_nl', $nl_price, $proDisShipping),
                                            ('$proDiscId','$country_us', $us_price, $proDisShipping),
                                            ('$proDiscId','$country_be', $be_price, $proDisShipping),
                                            ('$proDiscId','$country_uk', $uk_price, $proDisShipping),
                                            ('$proDiscId','$country_es', $es_price, $proDisShipping),
                                            ('$proDiscId','$country_at', $at_price, $proDisShipping),
                                            ('$proDiscId','$country_it', $it_price, $proDisShipping),
                                            ('$proDiscId','$country_other', $other_price, $proDisShipping)";
                    
                    $resDiscountSetting = $con->setRow($sqlDiscountSetting);
                    

                    if(!empty($value['proDiscount']['setting'])){
                        $sqlDisSetting = "INSERT INTO `product_discount_setting`(`product_dis_id`, `product_dis_name`, `product_dis_value`) VALUES ";
                        $disSettingArray = array();
                        foreach ($value['proDiscount']['setting'] as $keyDisSetting => $valueDisSetting) {
                            $sqlDisSetting .= "(?,?,?),";

                            $disSettingArray[] = $proDiscId;
                            $disSettingArray[] = $valueDisSetting['product_dis_name'];
                            $disSettingArray[] = $valueDisSetting['product_dis_value'];
                        }

                        $sqlDisSetting = trim($sqlDisSetting, ',');

                        $resDisSetting = $con->setRow($sqlDisSetting, $disSettingArray);
                    }



                }

            }


            /* ---------  ##############  SET PRODUCT_SCALE TABLE  ############# -----------  */


            if(!empty($value['proScale'])){

                foreach ($value['proScale'] as $keyScale => $valueScale) {
                    
                    $proSizName     = $valueScale['prosiz_name'];
                    $proSizPrice    = $valueScale['prosiz_price'];
                    $proSizGroup    = $valueScale['sizeGroup'];
                    $proSizId       = 'ss'.$valueScale['id'];

                    $fr_price       = doubleval(($proSizPrice/$fr_divide)*$fr_multiply);
                    $fr_price       = ceil($fr_price);
                    $fr_prosiz      = 'ssfr'.$valueScale['id'];

                    $de_price       = doubleval(($proSizPrice/$de_divide)*$de_multiply);
                    $de_price       = ceil($de_price);
                    $de_prosiz      = 'ssde'.$valueScale['id'];

                    $nl_price       = doubleval(($proSizPrice/$nl_divide)*$nl_multiply);
                    $nl_price       = ceil($nl_price);
                    $nl_prosiz      = 'ssnl'.$valueScale['id'];

                    $us_price       = doubleval(($proSizPrice/$us_divide)*$us_multiply);
                    $us_price       = ceil($us_price);
                    $us_prosiz      = 'ssus'.$valueScale['id'];

                    $be_price       = doubleval(($proSizPrice/$be_divide)*$be_multiply);
                    $be_price       = ceil($be_price);
                    $be_prosiz      = 'ssbe'.$valueScale['id'];

                    $uk_price       = doubleval(($proSizPrice/$uk_divide)*$uk_multiply);
                    $uk_price       = ceil($uk_price);
                    $uk_prosiz      = 'ssuk'.$valueScale['id'];

                    $es_price       = doubleval(($proSizPrice/$es_divide)*$es_multiply);
                    $es_price       = ceil($es_price);
                    $es_prosiz      = 'sses'.$valueScale['id'];

                    $at_price       = doubleval(($proSizPrice/$at_divide)*$at_multiply);
                    $at_price       = ceil($at_price);
                    $at_prosiz      = 'ssat'.$valueScale['id'];

                    $it_price       = doubleval(($proSizPrice/$it_divide)*$it_multiply);
                    $it_price       = ceil($it_price);
                    $it_prosiz      = 'ssit'.$valueScale['id'];

                    $other_price    = doubleval(($proSizPrice/$other_divide)*$other_multiply);
                    $other_price    = ceil($other_price);
                    $other_prosiz   = 'ssot'.$valueScale['id'];

                    $chf_price      = doubleval(($proSizPrice/$chf_divide)*$chf_multiply);
                    $chf_price      = ceil($chf_price);

                    $sqlScale = "INSERT INTO `product_size`(`prosiz_id`, `prosiz_name`, `prosiz_prodet_id`, `prosiz_cur_id`, `prosiz_price`, `sizeGroup`) 
                                VALUES ('$proSizId', '$proSizName', '$key', $country_chf, $chf_price, $proSizGroup),
                                ('$fr_prosiz', '$proSizName', '$key', $country_fr, $fr_price, $proSizGroup),
                                ('$de_prosiz', '$proSizName', '$key', $country_de, $de_price, $proSizGroup),
                                ('$nl_prosiz', '$proSizName', '$key', $country_nl, $nl_price, $proSizGroup),
                                ('$us_prosiz', '$proSizName', '$key', $country_us, $us_price, $proSizGroup),
                                ('$be_prosiz', '$proSizName', '$key', $country_be, $be_price, $proSizGroup),
                                ('$uk_prosiz', '$proSizName', '$key', $country_uk, $uk_price, $proSizGroup),
                                ('$es_prosiz', '$proSizName', '$key', $country_es, $es_price, $proSizGroup),
                                ('$at_prosiz', '$proSizName', '$key', $country_at, $at_price, $proSizGroup),
                                ('$it_prosiz', '$proSizName', '$key', $country_it, $it_price, $proSizGroup),
                                ('$other_prosiz', '$proSizName', '$key', $country_other, $other_price, $proSizGroup)";

                    $resScale = $con->setRow($sqlScale);

                }

            }


            /* ---------  ##############  SET PRODUCT_COLOR TABLE  ############# -----------  */



            if(!empty($value['proColor'])){
                foreach ($value['proColor'] as $keyColor => $valueColor) {
                    $proclrName     = $valueColor['proclr_name'];
                    $procolorName   = $valueColor['color_name'];
                    $proclrPrice    = $valueColor['proclr_price'];
                    $proclrGroup    = $valueColor['sizeGroup'];
                    $proclrId       = 'ss'.$valueColor['id'];

                    $fr_price       = doubleval(($proclrPrice/$fr_divide)*$fr_multiply);
                    $fr_price       = ceil($fr_price);
                    $fr_proclr      = 'ssfr'.$valueColor['id'];

                    $de_price       = doubleval(($proclrPrice/$de_divide)*$de_multiply);
                    $de_price       = ceil($de_price);
                    $de_proclr      = 'ssde'.$valueColor['id'];

                    $nl_price       = doubleval(($proclrPrice/$nl_divide)*$nl_multiply);
                    $nl_price       = ceil($nl_price);
                    $nl_proclr      = 'ssnl'.$valueColor['id'];

                    $us_price       = doubleval(($proclrPrice/$us_divide)*$us_multiply);
                    $us_price       = ceil($us_price);
                    $us_proclr      = 'ssus'.$valueColor['id'];

                    $be_price       = doubleval(($proclrPrice/$be_divide)*$be_multiply);
                    $be_price       = ceil($be_price);
                    $be_proclr      = 'ssbe'.$valueColor['id'];

                    $uk_price       = doubleval(($proclrPrice/$uk_divide)*$uk_multiply);
                    $uk_price       = ceil($uk_price);
                    $uk_proclr      = 'ssuk'.$valueColor['id'];

                    $es_price       = doubleval(($proclrPrice/$es_divide)*$es_multiply);
                    $es_price       = ceil($es_price);
                    $es_proclr      = 'sses'.$valueColor['id'];

                    $at_price       = doubleval(($proclrPrice/$at_divide)*$at_multiply);
                    $at_price       = ceil($at_price);
                    $at_proclr      = 'ssat'.$valueColor['id'];

                    $it_price       = doubleval(($proclrPrice/$it_divide)*$it_multiply);
                    $it_price       = ceil($it_price);
                    $it_proclr      = 'ssit'.$valueColor['id'];

                    $chf_price      = doubleval(($proclrPrice/$chf_divide)*$chf_multiply);
                    $chf_price      = ceil($chf_price);

                    $other_price      = doubleval(($proclrPrice/$other_divide)*$other_multiply);
                    $other_price      = ceil($other_price);
                    $other_proclr      = 'ssot'.$valueColor['id'];


                    $sqlColor = "INSERT INTO `product_color`(`propri_id`, `proclr_name`, `color_name`, `proclr_prodet_id`, `proclr_cur_id`, `proclr_price`, `sizeGroup`) 
                                VALUES ('$proSizId', '$proSizName', '$key', '$country_chf', '$chf_price'),
                                ('$fr_proclr', '$proclrName', '$procolorName', '$key', '$country_fr', '$fr_price',$proclrGroup),
                                ('$de_proclr', '$proclrName', '$procolorName', '$key', '$country_de', '$de_price',$proclrGroup),
                                ('$nl_proclr', '$proclrName', '$procolorName', '$key', '$country_nl', '$nl_price',$proclrGroup),
                                ('$us_proclr', '$proclrName', '$procolorName', '$key', '$country_us', '$us_price',$proclrGroup),
                                ('$be_proclr', '$proclrName', '$procolorName', '$key', '$country_be', '$be_price',$proclrGroup),
                                ('$uk_proclr', '$proclrName', '$procolorName', '$key', '$country_uk', '$uk_price',$proclrGroup),
                                ('$es_proclr', '$proclrName', '$procolorName', '$key', '$country_es', '$es_price',$proclrGroup),
                                ('$at_proclr', '$proclrName', '$procolorName', '$key', '$country_at', '$at_price',$proclrGroup),
                                ('$it_proclr', '$proclrName', '$procolorName', '$key', '$country_it', '$it_price',$proclrGroup),
                                ('$other_proclr', '$proclrName', '$procolorName', '$key', '$country_other', '$other_price',$proclrGroup),";

                    $resColor = $con->setRow($sqlColor);
                }
            }



            /* ---------  ##############  SET PRODUCT_SIZE CUSTOM TABLE  ############# -----------  */



            if(!empty($value['proSizeCustom'])){

                $sqlSizeCustomCheck = "SELECT `pId` FROM `product_size_custom` WHERE `pId` = '$key'";
                $resSizeCustomCheck = $con->getRow($sqlSizeCustomCheck);

                $sizeCustTypeId = $value['proSizeCustom']['type_id'];
                $sizeCustPrice = empty($value['proSizeCustom']['price']) ? $value['proSizeCustom']['price'] : 0;

                $fr_price       = doubleval(($sizeCustPrice/$fr_divide)*$fr_multiply);
                $fr_price       = ceil($fr_price);

                $de_price       = doubleval(($sizeCustPrice/$de_divide)*$de_multiply);
                $de_price       = ceil($de_price);

                $nl_price       = doubleval(($sizeCustPrice/$nl_divide)*$nl_multiply);
                $nl_price       = ceil($nl_price);

                $us_price       = doubleval(($sizeCustPrice/$us_divide)*$us_multiply);
                $us_price       = ceil($us_price);

                $be_price       = doubleval(($sizeCustPrice/$be_divide)*$be_multiply);
                $be_price       = ceil($be_price);

                $uk_price       = doubleval(($sizeCustPrice/$uk_divide)*$uk_multiply);
                $uk_price       = ceil($uk_price);

                $es_price       = doubleval(($sizeCustPrice/$es_divide)*$es_multiply);
                $es_price       = ceil($es_price);

                $at_price       = doubleval(($sizeCustPrice/$at_divide)*$at_multiply);
                $at_price       = ceil($at_price);

                $it_price       = doubleval(($sizeCustPrice/$it_divide)*$it_multiply);
                $it_price       = ceil($it_price);

                $chf_price      = doubleval(($sizeCustPrice/$chf_divide)*$chf_multiply);
                $chf_price      = ceil($chf_price);

                $other_price      = doubleval(($sizeCustPrice/$other_divide)*$other_multiply);
                $other_price      = ceil($other_price);



                if(empty($resSizeCustomCheck)){

                    $sqlSizeC = "INSERT INTO `product_size_custom`(`type_id`, `pId`, `currencyId`, `price`) VALUES($sizeCustTypeId, '$key', '$country_chf', $chf_price),
                        ($sizeCustTypeId, '$key', '$country_fr', $fr_price),
                        ($sizeCustTypeId, '$key', '$country_de', $de_price),
                        ($sizeCustTypeId, '$key', '$country_nl', $nl_price),
                        ($sizeCustTypeId, '$key', '$country_us', $us_price),
                        ($sizeCustTypeId, '$key', '$country_be', $be_price),
                        ($sizeCustTypeId, '$key', '$country_uk', $uk_price),
                        ($sizeCustTypeId, '$key', '$country_es', $es_price),
                        ($sizeCustTypeId, '$key', '$country_at', $at_price),
                        ($sizeCustTypeId, '$key', '$country_it', $it_price),
                        ($sizeCustTypeId, '$key', '$country_other', $other_price)";

                    
                    $resSizeC = $con->setRow($sqlSizeC);
                }
            }



            /* ---------  ##############  SET PRODUCT_CATEGORY TABLE  ############# -----------  */


            if(!empty($value['proCategory'])){

                $sqlCatCheck = "SELECT * FROM `product_category` WHERE `procat_prodet_id` = '$key'";
                $resCatCheck = $con->getRow($sqlCatCheck);

                if(empty($resCatCheck)){

                    $rawCategories = trim($value['proCategory'],',');
                    $catExp = explode(',', $rawCategories);
                    $updCat = '';

                    foreach ($catExp as $row) {
                        $newCat = 'ss'.$row;
                        $updCat .= $newCat.',';
                    }

                    $updCat = trim($updCat, ',');

                    $sqlCategory = "INSERT INTO `product_category`(`procat_prodet_id`, `procat_cat_id`) 
                                        VALUES ('$key', '$updCat')";
                    
                    $resCategory = $con->setRow($sqlCategory);

                }

            }


            /* ---------  ##############  SET PRODUCT_INVENTORY TABLE  ############# -----------  */


            if(!empty($value['proScale'])){

                foreach ($value['proScale'] as $keyScaleInv => $valueScaleInv) {
                    
                    $scaleInvId = 'ss'.$valueScaleInv['id'];
                    $scaleInv = $scaleInvId;
                    $storeID = 6;

                    if(empty($value['proColor'])){
                        $colorInv = 0;

                        $invHash    = $key.":".$scaleInv.":".$colorInv.":".$storeID;
                        $hash       = md5($invHash);

                        $sqlInventoryCheck = "SELECT `product_store_hash` FROM `product_inventory` WHERE `product_store_hash` = '$hash'";
                        $resInventoryCheck = $con->getRow($sqlInventoryCheck);

                        if(empty($resInventoryCheck)){
                            $sqlInventory = "INSERT INTO `product_inventory`(`qty_store_id`, `qty_product_id`, `qty_product_scale`, `qty_product_color`, `qty_item`, `product_store_hash`) VALUES ($storeID, '$key', '$scaleInv', '$colorInv', 99999, '$hash')";
                            $resInventory = $con->setRow($sqlInventory);
                        }

                        

                    }else{

                        foreach ($value['proColor'] as $keyColorInv => $valueColorInv) {
                            $colorInv = 'ss'.$valueColorInv['id'];

                            $invHash    = $key.":".$scaleInv.":".$colorInv.":".$storeID;
                            $hash       = md5($invHash);

                            $sqlInventoryCheck = "SELECT `product_store_hash` FROM `product_inventory` WHERE `product_store_hash` = '$hash'";
                            $resInventoryCheck = $con->getRow($sqlInventoryCheck);

                            if(empty($resInventoryCheck)){

                                $sqlInventory = "INSERT INTO `product_inventory`(`qty_store_id`, `qty_product_id`, `qty_product_scale`, `qty_product_color`, `qty_item`, `product_store_hash`) VALUES ($storeID, '$key', '$scaleInv', '$colorInv', 99999, '$hash')";
                                $resInventory = $con->setRow($sqlInventory);
                            }
                        }

                    }
                }

            }

            echo '1';


        }
            }
 if(!empty($migrate_product_to_intranet) && $migrate_product_to_intranet == 1){
       foreach ($copyData as $key => $value) {    
        // var_dump($key);
        /* ---------  ##############  SET PRODUCT_DETAIL/SEO TABLE  ############# -----------  */

            if(isset($value['proInfo'])){
                $proName = unserialize($value['proInfo']['prodet_name']);
                $proName = $proName['Swedish'];

                $now     = date('Y-m-d H:i:s');

                $proNameUpdArray['Swedish'] = $proName;
                $proNameUpdArray['French'] = '';
                $proNameUpdArray['German'] = '';
                $proNameUpdArray['English'] = '';
                $proNameUpdArray['Dutch'] = '';
                $proNameUpdArray['Italian'] = '';
                $proNameUpdArray['Spanish'] = '';

                $proNameUpd = serialize($proNameUpdArray);

                $proShortDesc = unserialize($value['proInfo']['prodet_shortDesc']);
                $proShortDesc = $proShortDesc['Swedish'];

                $proShortDescUpdArray['Swedish'] = $proShortDesc;
                $proShortDescUpdArray['French'] = '';
                $proShortDescUpdArray['German'] = '';
                $proShortDescUpdArray['English'] = '';
                $proShortDescUpdArray['Dutch'] = '';
                $proShortDescUpdArray['Italian'] = '';
                $proShortDescUpdArray['Spanish'] = '';

                $proShortDescUpd = serialize($proShortDescUpdArray);

                $slug = 'ss'.$value['proInfo']['slug'];
                $product_update = $value['proInfo']['product_update'];
                $sort = (isset($value['proInfo']['sort'])) ? $value['proInfo']['sort'] : '';
                $feature = $value['proInfo']['feature'];

                $sqlDetailCheck = "SELECT `prodet_id` FROM `proudct_detail` WHERE `prodet_id` = '$key'";
                $resDetailCheck = $conIntra->getRow($sqlDetailCheck);

                if(empty($resDetailCheck)){
                    $sql_proDetail_upd = "INSERT INTO `proudct_detail`(`prodet_id`, `slug`, `prodet_name`, `prodet_shortDesc`, `product_update`, `prodet_addOn`, `feature`)
                                        VALUES ('$key','$slug','$proNameUpd','$proShortDescUpd','$product_update','$now',$feature)";

                    $res_proDetail_upd = $conIntra->setRow($sql_proDetail_upd);
                }
            }


            $pageLink = '/product-'.$slug;
            $ref_id   = '/product-'.$key;

            if(!empty($value['proInfo']['seo'])){

                $seoTitle = unserialize($value['proInfo']['seo']['title']);
                $seoTitle = $seoTitle['Swedish'];

                $seoTitleUpdArray['Swedish']    = $seoTitle;
                $seoTitleUpdArray['French']     = '';
                $seoTitleUpdArray['German']     = '';
                $seoTitleUpdArray['English']    = '';
                $seoTitleUpdArray['Dutch']      = '';
                $seoTitleUpdArray['Italian']    = '';
                $seoTitleUpdArray['Spanish']    = '';

                $seoTitleUpd = serialize($seoTitleUpdArray);

                $seoKeyword = unserialize($value['proInfo']['seo']['keywords']);
                $seoKeyword = $seoKeyword['Swedish'];

                $seoKeywordUpdArray['Swedish']  = $seoKeyword;
                $seoKeywordUpdArray['French']   = '';
                $seoKeywordUpdArray['German']   = '';
                $seoKeywordUpdArray['English']  = '';
                $seoKeywordUpdArray['Dutch']        = '';
                $seoKeywordUpdArray['Italian']  = '';
                $seoKeywordUpdArray['Spanish']  = '';

                $seoKeywordUpd = serialize($seoKeywordUpdArray);

                $seoDsc = unserialize($value['proInfo']['seo']['dsc']);
                $seoDsc = $seoDsc['Swedish'];

                $seoDscUpdArray['Swedish']  = $seoDsc;
                $seoDscUpdArray['French']   = '';
                $seoDscUpdArray['German']   = '';
                $seoDscUpdArray['English']  = '';
                $seoDscUpdArray['Dutch']        = '';
                $seoDscUpdArray['Italian']  = '';
                $seoDscUpdArray['Spanish']  = '';

                $seoDscUpd = serialize($seoDscUpdArray);

                $seoCanonical = unserialize($value['proInfo']['seo']['canonical']);
                $seoCanonical = $seoCanonical['Swedish'];

                $seoCanonicalUpdArray['Swedish']    = $seoCanonical;
                $seoCanonicalUpdArray['French']     = '';
                $seoCanonicalUpdArray['German']     = '';
                $seoCanonicalUpdArray['English']    = '';
                $seoCanonicalUpdArray['Dutch']      = '';
                $seoCanonicalUpdArray['Italian']    = '';
                $seoCanonicalUpdArray['Spanish']    = '';

                $seoCanonicalUpd = serialize($seoCanonicalUpdArray);

                $seoAuthor = unserialize($value['proInfo']['seo']['author']);
                $seoAuthor = $seoAuthor['Swedish'];

                $seoAuthorUpdArray['Swedish']   = $seoAuthor;
                $seoAuthorUpdArray['French']    = '';
                $seoAuthorUpdArray['German']    = '';
                $seoAuthorUpdArray['English']   = '';
                $seoAuthorUpdArray['Dutch']         = '';
                $seoAuthorUpdArray['Italian']   = '';
                $seoAuthorUpdArray['Spanish']   = '';

                $seoAuthorUpd = serialize($seoAuthorUpdArray);

                $seoSpecial         = empty($value['proInfo']['seo']['special']) ? $value['proInfo']['seo']['special'] : '';
                $seosIndex          = empty($value['proInfo']['seo']['sIndex']) ? $value['proInfo']['seo']['sIndex'] : 0;
                $seosFollow         = empty($value['proInfo']['seo']['sFollow']) ? $value['proInfo']['seo']['sFollow'] : 0;
                $seoRewriteTitle    = empty($value['proInfo']['seo']['rewriteTitle']) ? $value['proInfo']['seo']['rewriteTitle'] : 0;
                $seoRevisitAfter    = empty($value['proInfo']['seo']['revisit-after']) ? $value['proInfo']['seo']['revisit-after'] : '';
                $seoType            = empty($value['proInfo']['seo']['type']) ? $value['proInfo']['seo']['type'] : '';
                $seoPublish         = empty($value['proInfo']['seo']['publish']) ? $value['proInfo']['seo']['publish'] : '';

                $sqlSeoCheck = "SELECT `slug` FROM `seo` WHERE `ref_id` LIKE '%product-$key%'";
                $resSeoCheck = $conIntra->getRow($sqlSeoCheck);

                if(empty($resSeoCheck)){

                    $sqlSeo = "INSERT INTO `seo`(`pageLink`, `ref_id`, `slug`, `title`, `keywords`, `dsc`, `special`, `canonical`, `sIndex`, `sFollow`, `rewriteTitle`, `author`, `revisit-after`, `type`, `publish`) VALUES ('$pageLink','$ref_id','$slug','$seoTitleUpd','$seoKeywordUpd','$seoDscUpd','$seoSpecial','$seoCanonicalUpd','$seosIndex','$seosFollow','$seoRewriteTitle','$seoAuthorUpd','$seoRevisitAfter','$seoType','$seoPublish')";

                    $resSeo = $conIntra->setRow($sqlSeo);
                     
                }      

            }


            /* ---------  ##############  SET PRODUCT_PRICE TABLE  ############# -----------  */


            if(!empty($value['proPrice'])){

                $priceIntShip   = $value['proPrice']['propri_intShipping'];
                $sek_price      = $value['proPrice']['propri_price'];

                $fr_price       = doubleval(($sek_price/$fr_divide)*$fr_multiply);
                $fr_price       = ceil($fr_price);

                $de_price       = doubleval(($sek_price/$de_divide)*$de_multiply);
                $de_price       = ceil($de_price);

                $nl_price       = doubleval(($sek_price/$nl_divide)*$nl_multiply);
                $nl_price       = ceil($nl_price);

                $us_price       = doubleval(($sek_price/$us_divide)*$us_multiply);
                $us_price       = ceil($us_price);

                $be_price       = doubleval(($sek_price/$be_divide)*$be_multiply);
                $be_price       = ceil($be_price);

                $uk_price       = doubleval(($sek_price/$uk_divide)*$uk_multiply);
                $uk_price       = ceil($uk_price);

                $es_price       = doubleval(($sek_price/$es_divide)*$es_multiply);
                $es_price       = ceil($es_price);

                $at_price       = doubleval(($sek_price/$at_divide)*$at_multiply);
                $at_price       = ceil($at_price);

                $it_price       = doubleval(($sek_price/$it_divide)*$it_multiply);
                $it_price       = ceil($it_price);

                $chf_price      = doubleval(($sek_price/$chf_divide)*$chf_multiply);
                $chf_price      = ceil($chf_price);

                $other_price      = doubleval(($sek_price/$other_divide)*$other_multiply);
                $other_price      = ceil($other_price);

                $sqlPriceCheck = "SELECT `propri_prodet_id` FROM `product_price` WHERE `propri_prodet_id` = '$key' AND `propri_cur_id` = 20";
                $resPriceCheck = $conIntra->getRow($sqlPriceCheck);

                if(empty($resPriceCheck)){
                    $sql_price = "INSERT INTO `product_price`(`propri_prodet_id`, `propri_cur_id`, `propri_price`, `propri_intShipping`) VALUES 
                            ('$key',$country_chf,$chf_price,$priceIntShip),
                            ('$key',$country_fr,$fr_price,$priceIntShip),
                            ('$key',$country_de,$de_price,$priceIntShip),
                            ('$key',$country_nl,$nl_price,$priceIntShip),
                            ('$key',$country_us,$us_price,$priceIntShip),
                            ('$key',$country_be,$be_price,$priceIntShip),
                            ('$key',$country_uk,$uk_price,$priceIntShip),
                            ('$key',$country_es,$es_price,$priceIntShip),
                            ('$key',$country_at,$at_price,$priceIntShip),
                            ('$key',$country_it,$it_price,$priceIntShip),
                            ('$key',$country_other,$other_price,$priceIntShip)";
                    
                    $res_price = $conIntra->setRow($sql_price);

                }

            }


            /* ---------  ##############  SET PRODUCT_IMAGE/REFER IMAGE TABLE  ############# -----------  */
        

            if(!empty($value['proimg'])){
                foreach ($value['proimg'] as $keyImg => $valueImg) {
                    $proImg     = $valueImg['image'];
                    $proAlt     = $valueImg['alt'];
                    $proSort    = $valueImg['sort'];

                    $referLink  = WEB_URL.'/images/'.$proImg;   

                    $sqlImgCheck = "SELECT `image` FROM `product_image` WHERE `product_id` = '$key'";
                    $resImgCheck = $conIntra->getRow($sqlImgCheck);

                    if(empty($resImgCheck)){

                        $sqlImg = "INSERT INTO `product_image`(`product_id`, `image`, `alt`, `sort`) 
                                        VALUES ('$key', '$proImg', '$proAlt', '$proSort')";

                        $resImg = $conIntra->setRow($sqlImg);
                        
                        $sqlImgRefer = "INSERT INTO `product_image_refer`(`p_id`, `img_link`, `upload_path`, `remove`) VALUES ('$key', '$referLink', '$proImg', 0)";

                        $resImgRefer = $conIntra->setRow($sqlImgRefer);
                        
                    }

                    
                }
            }


            /* ---------  ##############  SET PRODUCT_SETTING TABLE  ############# -----------  */


            if(!empty($value['proSetting'])){

                $sqlSettingCheck = "SELECT `p_id` FROM `product_setting` WHERE `p_id` = '$key'";
                $resSettingCheck = $conIntra->getRow($sqlSettingCheck);

                if(empty($resSettingCheck)){

                    $sqlSetting = "INSERT INTO `product_setting`(`p_id`, `setting_name`, `setting_val`) VALUES ";
                    foreach ($value['proSetting'] as $keySet => $valueSet) {
                        $sqlSetting .= "(?,?,?),";

                        $proSettingArray[] = $key;
                        $proSettingArray[] = $valueSet['setting_name'];

                        if($valueSet['setting_name'] == 'ldesc'){
                            $setting_val = unserialize($valueSet['setting_val']);
                            $setting_val = $setting_val['Swedish'];

                            $settingldescArray['Swedish']   = $setting_val;
                            $settingldescArray['French']    = '';
                            $settingldescArray['German']    = '';
                            $settingldescArray['English']   = '';
                            $settingldescArray['Dutch']     = '';
                            $settingldescArray['Italian']   = '';
                            $settingldescArray['Spanish']   = '';

                            $settingldesc = serialize($settingldescArray);


                            $proSettingArray[] = $settingldesc;
                        }
                        elseif($valueSet['setting_name'] == 'size_chart'){

                            $setting_val = unserialize($valueSet['setting_val']);
                            $setting_val = $setting_val['Swedish'];

                            $settingSchartArray['Swedish']  = $setting_val;
                            $settingSchartArray['French']   = '';
                            $settingSchartArray['German']   = '';
                            $settingSchartArray['English']  = '';
                            $settingSchartArray['Dutch']    = '';
                            $settingSchartArray['Italian']  = '';
                            $settingSchartArray['Spanish']  = '';

                            $settingSchart = serialize($settingSchartArray);

                            $proSettingArray[] = $settingSchart;

                        }
                        elseif($valueSet['setting_name'] == 'tags'){

                            $setting_val = unserialize($valueSet['setting_val']);
                            $setting_val = $setting_val['Swedish'];

                            $settingTagsArray['Swedish']    = $setting_val;
                            $settingTagsArray['French']     = '';
                            $settingTagsArray['German']     = '';
                            $settingTagsArray['English']    = '';
                            $settingTagsArray['Dutch']      = '';
                            $settingTagsArray['Italian']    = '';
                            $settingTagsArray['Spanish']    = '';

                            $settingTags = serialize($settingTagsArray);

                            $proSettingArray[] = $settingTags;

                        }
                        elseif($valueSet['setting_name'] == 'specification'){

                            $setting_val = unserialize($valueSet['setting_val']);
                            $setting_val = $setting_val['Swedish'];

                            $settingSpecsArray['Swedish']   = $setting_val;
                            $settingSpecsArray['French']    = '';
                            $settingSpecsArray['German']    = '';
                            $settingSpecsArray['English']   = '';
                            $settingSpecsArray['Dutch']     = '';
                            $settingSpecsArray['Italian']   = '';
                            $settingSpecsArray['Spanish']   = '';

                            $settingSpecs = serialize($settingSpecsArray);

                            $proSettingArray[] = $settingSpecs;

                        }
                        elseif($valueSet['setting_name'] == 'featureIcon'){

                            $setting_val = unserialize($valueSet['setting_val']);
                            $setting_val = $setting_val['Swedish'];

                            $settingFeaturIconArray['Swedish']  = $setting_val;
                            $settingFeaturIconArray['French']   = '';
                            $settingFeaturIconArray['German']   = '';
                            $settingFeaturIconArray['English']  = '';
                            $settingFeaturIconArray['Dutch']    = '';
                            $settingFeaturIconArray['Italian']  = '';
                            $settingFeaturIconArray['Spanish']  = '';

                            $settingFeaturIcon = serialize($settingFeaturIconArray);

                            $proSettingArray[] = $settingFeaturIcon;

                        }
                        elseif($valueSet['setting_name'] == 'featurePoints'){

                            $setting_val = unserialize($valueSet['setting_val']);
                            $setting_val = $setting_val['Swedish'];

                            $settingFeaturPointArray['Swedish']     = $setting_val;
                            $settingFeaturPointArray['French']      = '';
                            $settingFeaturPointArray['German']      = '';
                            $settingFeaturPointArray['English']     = '';
                            $settingFeaturPointArray['Dutch']       = '';
                            $settingFeaturPointArray['Italian']     = '';
                            $settingFeaturPointArray['Spanish']     = '';

                            $settingFeaturPoint = serialize($settingFeaturPointArray);

                            $proSettingArray[] = $settingFeaturPoint;

                        }
                        elseif($valueSet['setting_name'] == 'combineWith'){
                            $setting_val = unserialize($valueSet['setting_val']);
                            $settingCombineArray = array();
                            foreach ($setting_val as $row) {
                                $newCat = 'ss'.$row;
                                $settingCombineArray[] = $newCat;
                            }

                            $settingCombineSer = serialize($settingCombineArray);

                            $proSettingArray[] = $settingCombineSer;
                        }
                        else {
                            $proSettingArray[] = $valueSet['setting_val'];
                        }

                    }
                    $sqlSetting = trim($sqlSetting, ',');

                    $resSetting = $conIntra->setRow($sqlSetting, $proSettingArray);

                }
                
            }


            /* ---------  ##############  SET PRODUCT_DISCOUNT TABLE  ############# -----------  */


            if(!empty($value['proDiscount'])){

                $sqlDiscountCheck = "SELECT * FROM `product_discount` WHERE `discount_PId` = '$key'";
                $resDiscountCheck = $conIntra->getRow($sqlDiscountCheck);

                if(empty($resDiscountCheck)){

                    $proDiscId = 'ss'.$value['proDiscount']['product_dis_id'];
                    $proDisPrice = $value['proDiscount']['product_dis_price'];
                    $proDisStatus = $value['proDiscount']['product_dis_status'];
                    $proDisShipping = $value['proDiscount']['product_dis_intShipping'];

                    $sql_discount = "INSERT INTO `product_discount`(`product_discount_pk`, `discount_PId`, `product_dis_status`) VALUES ('$proDiscId', '$key', $proDisStatus)";

                    $res_discount = $conIntra->setRow($sql_discount);

                    $fr_price       = doubleval(($proDisPrice/$fr_divide)*$fr_multiply);
                    $fr_price       = ceil($fr_price);

                    $de_price       = doubleval(($proDisPrice/$de_divide)*$de_multiply);
                    $de_price       = ceil($de_price);

                    $nl_price       = doubleval(($proDisPrice/$nl_divide)*$nl_multiply);
                    $nl_price       = ceil($nl_price);

                    $us_price       = doubleval(($proDisPrice/$us_divide)*$us_multiply);
                    $us_price       = ceil($us_price);

                    $be_price       = doubleval(($proDisPrice/$be_divide)*$be_multiply);
                    $be_price       = ceil($be_price);

                    $uk_price       = doubleval(($proDisPrice/$uk_divide)*$uk_multiply);
                    $uk_price       = ceil($uk_price);

                    $es_price       = doubleval(($proDisPrice/$es_divide)*$es_multiply);
                    $es_price       = ceil($es_price);

                    $at_price       = doubleval(($proDisPrice/$at_divide)*$at_multiply);
                    $at_price       = ceil($at_price);

                    $it_price       = doubleval(($proDisPrice/$it_divide)*$it_multiply);
                    $it_price       = ceil($it_price);

                    $chf_price      = doubleval(($proDisPrice/$chf_divide)*$chf_multiply);
                    $chf_price      = ceil($chf_price);

                    $other_price      = doubleval(($proDisPrice/$other_divide)*$other_multiply);
                    $other_price      = ceil($other_price);

                    $sqlDiscountSetting = "INSERT INTO `product_discount_prices`(`product_dis_id`, `product_dis_curr_Id`, `product_dis_price`, `product_dis_intShipping`) 
                                    VALUES ('$proDiscId','$country_chf', $chf_price, $proDisShipping),
                                            ('$proDiscId','$country_fr', $fr_price, $proDisShipping),
                                            ('$proDiscId','$country_de', $de_price, $proDisShipping),
                                            ('$proDiscId','$country_nl', $nl_price, $proDisShipping),
                                            ('$proDiscId','$country_us', $us_price, $proDisShipping),
                                            ('$proDiscId','$country_be', $be_price, $proDisShipping),
                                            ('$proDiscId','$country_uk', $uk_price, $proDisShipping),
                                            ('$proDiscId','$country_es', $es_price, $proDisShipping),
                                            ('$proDiscId','$country_at', $at_price, $proDisShipping),
                                            ('$proDiscId','$country_it', $it_price, $proDisShipping),
                                            ('$proDiscId','$country_other', $other_price, $proDisShipping)";
                    
                    $resDiscountSetting = $conIntra->setRow($sqlDiscountSetting);
                    

                    if(!empty($value['proDiscount']['setting'])){
                        $sqlDisSetting = "INSERT INTO `product_discount_setting`(`product_dis_id`, `product_dis_name`, `product_dis_value`) VALUES ";
                        $disSettingArray = array();
                        foreach ($value['proDiscount']['setting'] as $keyDisSetting => $valueDisSetting) {
                            $sqlDisSetting .= "(?,?,?),";

                            $disSettingArray[] = $proDiscId;
                            $disSettingArray[] = $valueDisSetting['product_dis_name'];
                            $disSettingArray[] = $valueDisSetting['product_dis_value'];
                        }

                        $sqlDisSetting = trim($sqlDisSetting, ',');

                        $resDisSetting = $conIntra->setRow($sqlDisSetting, $disSettingArray);
                    }



                }

            }


            /* ---------  ##############  SET PRODUCT_SCALE TABLE  ############# -----------  */


            if(!empty($value['proScale'])){

                foreach ($value['proScale'] as $keyScale => $valueScale) {
                    
                    $proSizName     = $valueScale['prosiz_name'];
                    $proSizPrice    = $valueScale['prosiz_price'];
                    $proSizGroup    = $valueScale['sizeGroup'];
                    $proSizId       = $valueScale['id'];

                    $fr_price       = doubleval(($proSizPrice/$fr_divide)*$fr_multiply);
                    $fr_price       = ceil($fr_price);
                    $fr_prosiz      = 'fr'.$valueScale['id'];

                    $de_price       = doubleval(($proSizPrice/$de_divide)*$de_multiply);
                    $de_price       = ceil($de_price);
                    $de_prosiz      = 'de'.$valueScale['id'];

                    $nl_price       = doubleval(($proSizPrice/$nl_divide)*$nl_multiply);
                    $nl_price       = ceil($nl_price);
                    $nl_prosiz      = 'nl'.$valueScale['id'];

                    $us_price       = doubleval(($proSizPrice/$us_divide)*$us_multiply);
                    $us_price       = ceil($us_price);
                    $us_prosiz      = 'us'.$valueScale['id'];

                    $be_price       = doubleval(($proSizPrice/$be_divide)*$be_multiply);
                    $be_price       = ceil($be_price);
                    $be_prosiz      = 'be'.$valueScale['id'];

                    $uk_price       = doubleval(($proSizPrice/$uk_divide)*$uk_multiply);
                    $uk_price       = ceil($uk_price);
                    $uk_prosiz      = 'uk'.$valueScale['id'];

                    $es_price       = doubleval(($proSizPrice/$es_divide)*$es_multiply);
                    $es_price       = ceil($es_price);
                    $es_prosiz      = 'es'.$valueScale['id'];

                    $at_price       = doubleval(($proSizPrice/$at_divide)*$at_multiply);
                    $at_price       = ceil($at_price);
                    $at_prosiz      = 'at'.$valueScale['id'];

                    $it_price       = doubleval(($proSizPrice/$it_divide)*$it_multiply);
                    $it_price       = ceil($it_price);
                    $it_prosiz      = 'it'.$valueScale['id'];

                    $other_price    = doubleval(($proSizPrice/$other_divide)*$other_multiply);
                    $other_price    = ceil($other_price);
                    $other_prosiz   = 'ot'.$valueScale['id'];

                    $chf_price      = doubleval(($proSizPrice/$chf_divide)*$chf_multiply);
                    $chf_price      = ceil($chf_price);

                    $sqlScale = "INSERT INTO `product_size`(`prosiz_id`, `prosiz_name`, `prosiz_prodet_id`, `prosiz_cur_id`, `prosiz_price`, `sizeGroup`) 
                                VALUES ('$proSizId', '$proSizName', '$key', $country_chf, $chf_price, $proSizGroup),
                                ('$fr_prosiz', '$proSizName', '$key', $country_fr, $fr_price, $proSizGroup),
                                ('$de_prosiz', '$proSizName', '$key', $country_de, $de_price, $proSizGroup),
                                ('$nl_prosiz', '$proSizName', '$key', $country_nl, $nl_price, $proSizGroup),
                                ('$us_prosiz', '$proSizName', '$key', $country_us, $us_price, $proSizGroup),
                                ('$be_prosiz', '$proSizName', '$key', $country_be, $be_price, $proSizGroup),
                                ('$uk_prosiz', '$proSizName', '$key', $country_uk, $uk_price, $proSizGroup),
                                ('$es_prosiz', '$proSizName', '$key', $country_es, $es_price, $proSizGroup),
                                ('$at_prosiz', '$proSizName', '$key', $country_at, $at_price, $proSizGroup),
                                ('$it_prosiz', '$proSizName', '$key', $country_it, $it_price, $proSizGroup),
                                ('$other_prosiz', '$proSizName', '$key', $country_other, $other_price, $proSizGroup)";

                    $resScale = $conIntra->setRow($sqlScale);

                }

            }


            /* ---------  ##############  SET PRODUCT_COLOR TABLE  ############# -----------  */



            if(!empty($value['proColor'])){
                foreach ($value['proColor'] as $keyColor => $valueColor) {
                    $proclrName     = $valueColor['proclr_name'];
                    $procolorName   = $valueColor['color_name'];
                    $proclrPrice    = $valueColor['proclr_price'];
                    $proclrGroup    = $valueColor['sizeGroup'];
                    $proclrId       = 'ss'.$valueColor['id'];

                    $fr_price       = doubleval(($proclrPrice/$fr_divide)*$fr_multiply);
                    $fr_price       = ceil($fr_price);
                    $fr_proclr      = 'fr'.$valueColor['id'];

                    $de_price       = doubleval(($proclrPrice/$de_divide)*$de_multiply);
                    $de_price       = ceil($de_price);
                    $de_proclr      = 'de'.$valueColor['id'];

                    $nl_price       = doubleval(($proclrPrice/$nl_divide)*$nl_multiply);
                    $nl_price       = ceil($nl_price);
                    $nl_proclr      = 'nl'.$valueColor['id'];

                    $us_price       = doubleval(($proclrPrice/$us_divide)*$us_multiply);
                    $us_price       = ceil($us_price);
                    $us_proclr      = 'us'.$valueColor['id'];

                    $be_price       = doubleval(($proclrPrice/$be_divide)*$be_multiply);
                    $be_price       = ceil($be_price);
                    $be_proclr      = 'be'.$valueColor['id'];

                    $uk_price       = doubleval(($proclrPrice/$uk_divide)*$uk_multiply);
                    $uk_price       = ceil($uk_price);
                    $uk_proclr      = 'uk'.$valueColor['id'];

                    $es_price       = doubleval(($proclrPrice/$es_divide)*$es_multiply);
                    $es_price       = ceil($es_price);
                    $es_proclr      = 'es'.$valueColor['id'];

                    $at_price       = doubleval(($proclrPrice/$at_divide)*$at_multiply);
                    $at_price       = ceil($at_price);
                    $at_proclr      = 'at'.$valueColor['id'];

                    $it_price       = doubleval(($proclrPrice/$it_divide)*$it_multiply);
                    $it_price       = ceil($it_price);
                    $it_proclr      = 'it'.$valueColor['id'];

                    $chf_price      = doubleval(($proclrPrice/$chf_divide)*$chf_multiply);
                    $chf_price      = ceil($chf_price);

                    $other_price      = doubleval(($proclrPrice/$other_divide)*$other_multiply);
                    $other_price      = ceil($other_price);
                    $other_proclr      = 'ot'.$valueColor['id'];


                    $sqlColor = "INSERT INTO `product_color`(`propri_id`, `proclr_name`, `color_name`, `proclr_prodet_id`, `proclr_cur_id`, `proclr_price`, `sizeGroup`) 
                                VALUES ('$proSizId', '$proSizName', '$key', '$country_chf', '$chf_price'),
                                ('$fr_proclr', '$proclrName', '$procolorName', '$key', '$country_fr', '$fr_price',$proclrGroup),
                                ('$de_proclr', '$proclrName', '$procolorName', '$key', '$country_de', '$de_price',$proclrGroup),
                                ('$nl_proclr', '$proclrName', '$procolorName', '$key', '$country_nl', '$nl_price',$proclrGroup),
                                ('$us_proclr', '$proclrName', '$procolorName', '$key', '$country_us', '$us_price',$proclrGroup),
                                ('$be_proclr', '$proclrName', '$procolorName', '$key', '$country_be', '$be_price',$proclrGroup),
                                ('$uk_proclr', '$proclrName', '$procolorName', '$key', '$country_uk', '$uk_price',$proclrGroup),
                                ('$es_proclr', '$proclrName', '$procolorName', '$key', '$country_es', '$es_price',$proclrGroup),
                                ('$at_proclr', '$proclrName', '$procolorName', '$key', '$country_at', '$at_price',$proclrGroup),
                                ('$it_proclr', '$proclrName', '$procolorName', '$key', '$country_it', '$it_price',$proclrGroup),
                                ('$other_proclr', '$proclrName', '$procolorName', '$key', '$country_other', '$other_price',$proclrGroup),";

                    $resColor = $conIntra->setRow($sqlColor);
                }
            }



            /* ---------  ##############  SET PRODUCT_SIZE CUSTOM TABLE  ############# -----------  */



            if(!empty($value['proSizeCustom'])){

                $sqlSizeCustomCheck = "SELECT `pId` FROM `product_size_custom` WHERE `pId` = '$key'";
                $resSizeCustomCheck = $conIntra->getRow($sqlSizeCustomCheck);

                $sizeCustTypeId = $value['proSizeCustom']['type_id'];
                $sizeCustPrice = empty($value['proSizeCustom']['price']) ? $value['proSizeCustom']['price'] : 0;

                $fr_price       = doubleval(($sizeCustPrice/$fr_divide)*$fr_multiply);
                $fr_price       = ceil($fr_price);

                $de_price       = doubleval(($sizeCustPrice/$de_divide)*$de_multiply);
                $de_price       = ceil($de_price);

                $nl_price       = doubleval(($sizeCustPrice/$nl_divide)*$nl_multiply);
                $nl_price       = ceil($nl_price);

                $us_price       = doubleval(($sizeCustPrice/$us_divide)*$us_multiply);
                $us_price       = ceil($us_price);

                $be_price       = doubleval(($sizeCustPrice/$be_divide)*$be_multiply);
                $be_price       = ceil($be_price);

                $uk_price       = doubleval(($sizeCustPrice/$uk_divide)*$uk_multiply);
                $uk_price       = ceil($uk_price);

                $es_price       = doubleval(($sizeCustPrice/$es_divide)*$es_multiply);
                $es_price       = ceil($es_price);

                $at_price       = doubleval(($sizeCustPrice/$at_divide)*$at_multiply);
                $at_price       = ceil($at_price);

                $it_price       = doubleval(($sizeCustPrice/$it_divide)*$it_multiply);
                $it_price       = ceil($it_price);

                $chf_price      = doubleval(($sizeCustPrice/$chf_divide)*$chf_multiply);
                $chf_price      = ceil($chf_price);

                $other_price      = doubleval(($sizeCustPrice/$other_divide)*$other_multiply);
                $other_price      = ceil($other_price);



                if(empty($resSizeCustomCheck)){

                    $sqlSizeC = "INSERT INTO `product_size_custom`(`type_id`, `pId`, `currencyId`, `price`) VALUES($sizeCustTypeId, '$key', '$country_chf', $chf_price),
                        ($sizeCustTypeId, '$key', '$country_fr', $fr_price),
                        ($sizeCustTypeId, '$key', '$country_de', $de_price),
                        ($sizeCustTypeId, '$key', '$country_nl', $nl_price),
                        ($sizeCustTypeId, '$key', '$country_us', $us_price),
                        ($sizeCustTypeId, '$key', '$country_be', $be_price),
                        ($sizeCustTypeId, '$key', '$country_uk', $uk_price),
                        ($sizeCustTypeId, '$key', '$country_es', $es_price),
                        ($sizeCustTypeId, '$key', '$country_at', $at_price),
                        ($sizeCustTypeId, '$key', '$country_it', $it_price),
                        ($sizeCustTypeId, '$key', '$country_other', $other_price)";

                    
                    $resSizeC = $conIntra->setRow($sqlSizeC);
                }
            }



            /* ---------  ##############  SET PRODUCT_CATEGORY TABLE  ############# -----------  */


            if(!empty($value['proCategory'])){

                $sqlCatCheck = "SELECT * FROM `product_category` WHERE `procat_prodet_id` = '$key'";
                $resCatCheck = $conIntra->getRow($sqlCatCheck);

                if(empty($resCatCheck)){

                    $rawCategories = trim($value['proCategory'],',');
                    $catExp = explode(',', $rawCategories);
                    $updCat = '';

                    foreach ($catExp as $row) {
                        $newCat = $row;
                        $updCat .= $newCat.',';
                    }

                    $updCat = trim($updCat, ',');

                    $sqlCategory = "INSERT INTO `product_category`(`procat_prodet_id`, `procat_cat_id`) 
                                        VALUES ('$key', '$updCat')";
                    
                    $resCategory = $conIntra->setRow($sqlCategory);

                }

            }


            /* ---------  ##############  SET PRODUCT_INVENTORY TABLE  ############# -----------  */


            if(!empty($value['proScale'])){

                foreach ($value['proScale'] as $keyScaleInv => $valueScaleInv) {
                    
                    $scaleInvId = $valueScaleInv['id'];
                    $scaleInv = $scaleInvId;
                    $storeID = 6;

                    if(empty($value['proColor'])){
                        $colorInv = 0;

                        $invHash    = $key.":".$scaleInv.":".$colorInv.":".$storeID;
                        $hash       = md5($invHash);

                        $sqlInventoryCheck = "SELECT `product_store_hash` FROM `product_inventory` WHERE `product_store_hash` = '$hash'";
                        $resInventoryCheck = $conIntra->getRow($sqlInventoryCheck);

                        if(empty($resInventoryCheck)){
                            $sqlInventory = "INSERT INTO `product_inventory`(`qty_store_id`, `qty_product_id`, `qty_product_scale`, `qty_product_color`, `qty_item`, `product_store_hash`) VALUES ($storeID, '$key', '$scaleInv', '$colorInv', 99999, '$hash')";
                            $resInventory = $conIntra->setRow($sqlInventory);
                        }

                        

                    }else{

                        foreach ($value['proColor'] as $keyColorInv => $valueColorInv) {
                            $colorInv = $valueColorInv['id'];

                            $invHash    = $key.":".$scaleInv.":".$colorInv.":".$storeID;
                            $hash       = md5($invHash);

                            $sqlInventoryCheck = "SELECT `product_store_hash` FROM `product_inventory` WHERE `product_store_hash` = '$hash'";
                            $resInventoryCheck = $conIntra->getRow($sqlInventoryCheck);

                            if(empty($resInventoryCheck)){

                                $sqlInventory = "INSERT INTO `product_inventory`(`qty_store_id`, `qty_product_id`, `qty_product_scale`, `qty_product_color`, `qty_item`, `product_store_hash`) VALUES ($storeID, '$key', '$scaleInv', '$colorInv', 99999, '$hash')";
                                $resInventory = $conIntra->setRow($sqlInventory);
                            }
                        }

                    }
                }

            }

            // echo '1';


        }

    }

}

    public function getMassData(){

        $fields_select = $_POST['field_select'];
        $language = $_POST['lang_select'];

        $check_array = array(
            "proudct_detail" => array(
                                    'prodet_name',
                                    'prodet_shortDesc',
                                    'slug'
                                ),

            "product_setting" => array(
                            'ldesc',
                            'publicAccess',
                            'Model',
                            'label',
                            'launchDate',
                            'shippingClass',
                            'size_chart',
                            'tags',
                            'specification',
                            'featureIcon',
                            'featurePoints'
                        )
        );

        $update_array = array();
        $columns = array();
        // $columns[] = array('SNO');
        $columns[] = array('Product Image');
        $columns[] = array('Product Name');
        $table = '';
        foreach ($check_array as $key => $value) {
            foreach ($fields_select as $row) {
                if(in_array($row, $value)){
                    $update_array[$key][] = $row;
                    $columns[] = array($row);
                }
            }    
        }

        $columns[] = array('Action');

        $detail_col = join(',',$update_array['proudct_detail']);
        $det_col = (empty($detail_col)) ? '*' : $detail_col;

        $sql_pro = "SELECT `prodet_id`,`prodet_name`,$det_col FROM `proudct_detail` WHERE `product_update` = 1";
        $res_pro = $this->dbF->getRows($sql_pro);

        $data_array = array();
        $pcount = 0;
        foreach ($res_pro as $key => $value) {
            $pId = $value['prodet_id'];
            // $data_array[$pcount][] = $pcount;
            $pName = unserialize($value['prodet_name']);
            $pNameSe = $pName['Swedish'];
            $productImage = $this->productSpecialImage($pId, 'main');
            $productThumb = $this->resizeImage($productImage, 300, 300, false);
            // $productImage = WEB_URL . '/images/' . $productImage;
            $data_array[$pcount][] = '<img src="'.$productThumb.'" width="70px"/>';
            $data_array[$pcount][] = '<p>'.$pNameSe.'</p>';
            foreach ($value as $keyy => $valuee) {
                for ($i=0; $i < sizeof($update_array['proudct_detail']); $i++) { 
                    if($keyy == $update_array['proudct_detail'][$i]){
                        @$a = unserialize($valuee);
                        if($a === false){
                            $un_val = empty($valuee) ? '-' : $valuee;
                            $data_array[$pcount][] = '<input type="text" id="area'.$keyy.$pId.'" class="form-control" name="'.$keyy.'" value="'.$un_val.'" />';
                        }else{
                            $empty = '';
                            if(empty(@$a[$language])){
                                $empty = 'empty_div';
                            }

                            if($keyy == 'prodet_name'){
                                $data_array[$pcount][] = '<input type="text" id="area'.$keyy.$pId.'" class="form-control" name="'.$keyy.'" value="'.@$a[$language].'" />';
                            }else{
                                $remove = "'remove'";
                                $data_array[$pcount][] = '<div id="area'.$keyy.$pId.'" data-id="'.$pId.'" onclick="toggleArea1(this);" name="'.$keyy.'" class="dt_div '.$empty.'">'.@$a[$language].'</div><div class="btn btn-primary btn-xs remove" onclick="toggleArea1(this, '.$remove.')" style="display:none;">X</div>';
                            }
                            
                        }  
                    }   
                }
            }

            // $this->dbF->prnt($update_array);
            $pSetting = $this->product->productF->getProductSetting($pId);
            if(!empty($pSetting)){
                if(isset($update_array['product_setting']) && !empty($update_array['product_setting'])){
                    foreach ($update_array['product_setting'] as $set_key => $set_value) {
                        $set_val = $this->product->productF->productSettingArray($set_value, $pSetting, $pId);

                        @$unse_var = unserialize($set_val);

                        if($unse_var === false){
                            $sett_val = empty($set_val) ? ' ':$set_val;
                            $data_array[$pcount][] = '<input type="text" id="area'.$set_value.$pId.'" data-id="abc" class="form-control" name="'.$keyy.'" value="'.$sett_val.'" />';
                        }else{

                            $content = @$unse_var[$language];

                            $emptys = '';
                            if(trim($content) == ""){
                                $emptys = 'empty_div';
                            }

                            /////// Remove Style attribute from data, just for some time for data correction  ///////
                            
                            if($set_value == 'ldesc'){

                                $dom = new DOMDocument;
                                $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED);
                                $nodes = $dom->getElementsByTagName('*');

                                if(!empty($nodes)){
                                    foreach($nodes as $node)
                                    {
                                        if ($node->hasAttribute('style'))
                                        {
                                            $node->removeAttribute('style');
                                        }
                                    }

                                    $content = $dom->saveHTML($dom->documentElement);
                                }
                            }

                            /////// Remove Style attribute from data, just for some time for data correction END ///////

                            // $chk_content = str_replace(" ", "", $content);
                            // $chk_content = str_replace("<br>", "", $chk_content);
                            // $chk_content = trim($content);


                            $remove = "'remove'";
                            $data_array[$pcount][] = '<div id="area'.$set_value.$pId.'" data-id="'.$pId.'" onclick="toggleArea1(this);" name="'.$set_value.'" data-id="'.$pId.'" class="dt_div '.$emptys.'">'.@trim($content).'</div><div class="btn btn-primary btn-xs remove" onclick="toggleArea1(this, '.$remove.')" style="display:none;">X</div>';
                        }                   
                    }
                }
            }else{
                if(isset($update_array['product_setting'])){
                    foreach (@$update_array['product_setting'] as $set_key => $set_value) {
                        $data_array[$pcount][] = '<input type="text" id="area'.$set_value.$pId.'" class="form-control" name="'.$keyy.'" value="" />';
                    }
                }
            }
            
            if(!intval($pId)){
                $pId = "'".$pId."'";
            }

            $data_array[$pcount][] = '<a class="btn btn-primary" data-id="'.$pId.'" id="update_'.$pId.'" onclick="updateProduct('.$pId.')">Update</a>';
            $pcount++;
        }

        $final_array = array(
                        "data" => $data_array,
                        "columns" => $columns
                    );

        $final_array = json_encode($final_array);
        echo $final_array;

    }






    public function getMassData1(){

        $underMenu = $_POST['underMenu'];
        // $language = $_POST['lang_select'];

  
// $qry="SELECT DISTINCT product_id FROM product_image WHERE sort IS NULL order by product_id desc limit 25";




       $LIKE = "";

        // foreach ($catId as $val) {

        //     $cId = $val;

            $LIKE = " `product_category`.`procat_cat_id` LIKE '%$underMenu%' OR";

        // }

        $LIKE = trim($LIKE, "OR");




                // $qry = "SELECT `procat_prodet_id`,`prodet_id` as ppiidd

                //                 FROM `product_category`

                //                 JOIN

                //                 `proudct_detail` as detail

                //                   on `product_category`.`procat_prodet_id` = `detail`.`prodet_id`

                //                     WHERE $LIKE

                //                       GROUP BY `product_category`.`procat_cat_id`";

      $qry = "SELECT `procat_prodet_id` as ppiidd

                                FROM `product_category`
                              

                                    WHERE `product_category`.`procat_cat_id` LIKE '%$underMenu%' 
                                      ";





                                      
                                      
                                      


$eData=$this->dbF->getRows($qry);

if($this->dbF->rowCount>0){

foreach($eData as $key=>$val){


?>







<!-- <div class="tab-pane container-fluid fade" id="tab_images"> -->

<h2 class="tab_heading"><?php 


$qrys="SELECT prodet_name
FROM proudct_detail
WHERE prodet_id = $val[ppiidd]";

$eDatas=$this->dbF->getRow($qrys);


$defaultLang = $this->functions->AdminDefaultLanguage();


$heading = unserialize($eDatas['prodet_name']);
$heading = $heading[$defaultLang];

echo $heading;










 ?></h2>
<input type="hidden" id="AjaxFileNewId" name="ProductNewId"

value="<?php echo $val['ppiidd']; ?>">

<input type="hidden" id="AjaxFileNewPage" value="products">

<div id="dropbox" class="dropbox<?php echo $val['ppiidd']; ?>">
<?php

// if product edit

// if ($isEdit && !isset($_POST['copy'])) {

$this->product->productEditImagesMass($val['ppiidd']);

// }

?>

<style>

.dropbox .preview {

height: 255px !important;

padding: 4px;

background: #eee;

}


.dropbox<?php echo $val['ppiidd']; ?> {

    background: url(../img/background_tile_3.jpg);
    border-radius: 10px;
    position: relative;
    min-height: 290px;
    overflow: hidden;
    padding-bottom: 40px;
}
#dropbox<?php echo $val['ppiidd']; ?> {

    background: url(../img/background_tile_3.jpg);
    border-radius: 10px;
    position: relative;
    min-height: 290px;
    overflow: hidden;
    padding-bottom: 40px;
}
.dropbox .progressHolder.album {

height: 80px !important;

padding: 5px;

}

</style>





</div>


<script>

$(document).ready(function () {

$(".dropbox<?php echo $val['ppiidd']; ?>").sortable({

handle: '.imageHolder',

containment: "parent",

update: function () {

serial = $(this).sortable('serialize');

$.ajax({

url: 'product_management/product_ajax.php?page=sortProductImage',

type: "post",

data: serial,

error: function () {

jAlertifyAlert("There is an error, Please Refresh Page and Try Again");

}

});

}

});


/////////////////////////////////////////////////////////



$(".pImageAltUpdate<?php echo $val['ppiidd']; ?>").click(function () {

btn = $(this);

btn.addClass('disabled');

btn.children('.trash').hide();

btn.children('.waiting').show();



id = btn.attr('data-id');

alt = $('#alt-' + id).val();

btn.children('span').text('Wait...');

$.ajax({

type: 'POST',

url: 'product_management/product_ajax.php?page=pImageAltUpdate',

data: {imageId: id, altT: alt}

}).done(function (data) {

ift = true;

if (data == '1') {

btn.children('span').text('Done');

}

else {

btn.children('span').text('Fail');

}

btn.removeClass('disabled');

btn.children('.trash').show();

btn.children('.waiting').hide();



});

});

////////////////////////////////////////////














});
</script>

<?php
}

}



}



    public function productSpecialImage($id, $alt)
    {
        $sql = "SELECT image FROM `product_image` WHERE product_id = '$id' AND alt = '$alt' ORDER BY sort ASC ";
        $data = $this->dbF->getRow($sql);
        if ($this->dbF->rowCount > 0) {
            $imag = $data['image'];
        } else {
            //get first Image
            $imag = $this->productFirstImage($id);
        }
        return $imag;
    }


    public function resizeImage($image,$width='auto',$height='auto',$echo = true,$pngBgColor=false,$imageWithWebUrl=true,$cache=true){
        //It has one setting also in src/image.php development folder name
        return $this->functions->resizeImage($image,$width,$height,$echo,$pngBgColor,$imageWithWebUrl,$cache);
    }



    public function productFirstImage($pId)
    {
        $data = $this->productAllImage($pId, '1', true);
        if (!empty($data)) {
            $imag = $data['image'];
            return $imag;
        }
        return "";
    }



    public function productAllImage($id, $limitP = false, $OnlyFirstImage = false)
    {
        $limit = '';
        if ($limitP != false) {
            $limit = " LIMIT 0,$limitP";
        }
        if ($OnlyFirstImage == true) {
            $limit = " LIMIT 0,1";
        }
        $sql = "SELECT * FROM `product_image` WHERE product_id = '$id' ORDER BY sort ASC $limit";

        if ($OnlyFirstImage == true || $limitP == '1') {
            $data = $this->dbF->getRow($sql);
        } else {
            $data = $this->dbF->getRows($sql);
        }
        return $data;
    }
}

?>