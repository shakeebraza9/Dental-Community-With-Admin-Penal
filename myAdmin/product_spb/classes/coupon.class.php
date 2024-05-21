<?php
require_once(__DIR__ . "/../../product_management_spb/classes/currency.class.php");
require_once(__DIR__ . "/../../product_management_spb/classes/scale.class.php");
require_once(__DIR__ . "/../../product_management_spb/classes/color.class.php");

class coupon extends object_class
{
    use global_setting;
    public $productF;

    public $c_scale;
    public $c_color;
    public $c_currency;
    public $functions;

    public $prefix_editPro = "edit_pro"; // asad

    function __construct()
    {
        parent::__construct();

        if (isset($GLOBALS['productF'])) $this->productF = $GLOBALS['productF'];
        else {
            require_once(__DIR__."/../../product_management_spb/functions/product_function.php");
            $this->productF=new product_function();
        }

        $this->c_color = new colors();
        $this->c_scale = new scales();
        $this->c_currency = new currency_management_spb();


        /**
         * MultiLanguage keys Use where echo;
         * define this class words and where this class will call
         * and define words of file where this class will called
         **/
        global $_e;
        global $adminPanelLanguage;
        $_w=array();
        //pCoupon.php
        $_w['Discount Products'] = '' ;
        $_w['Active Coupons'] = '' ;
        $_w['Coupon Off'] = '' ;
        $_w['Pending'] = '' ;
        $_w['Expire'] = '' ;
        $_w['New Coupon'] = '' ;
        $_w['Delete Fail Please Try Again.'] = '' ;
        $_w['New Sale Offer'] = '' ;
        $_w['Expire Discount Products'] = '' ;
        $_w['Pending Discount Products'] = '' ;
        $_w['Discount Products Status Off'] = '' ;
        $_w['All Products'] = '' ;
        //this class
        $_w['SNO'] = '' ;
        $_w['USE'] = '' ;
        $_w['COUPON'] = '' ;
        $_w['CATEGORY'] = '' ;
        $_w['SALE DATE'] = '' ;
        $_w['ACTION'] = '' ;
        //coupon form
        $_w['Coupon'] = '' ;
        $_w['New Coupon Add Successfully'] = '' ;
        $_w['New Coupon Added With Id: {{id}}'] = '' ;
        $_w['Product'] = '' ;
        $_w['Coupon Add Fail Please Try Again'] = '' ;
        $_w['SUBMIT'] = '' ;
        $_w['Product Category'] = '' ;
        $_w['Only Product Whole Sale Offer'] = '' ;
        $_w['Only Product Discount Offer'] = '' ;
        $_w['Only Coupon Offer (Recommended)'] = '' ;
        $_w['If Product Has Individual Discount Then Which situation apply?'] = '' ;
        $_w['Product Discount'] = '' ;
        $_w['Free Shipping Allow In Country'] = '' ;
        $_w['In Percent %'] = '' ;
        $_w['In Price'] = '' ;
        $_w['Discount Deduct In'] = '' ;
        $_w['Discount End Date: Leave blank for Always'] = '' ;
        $_w['Discount Start Date : Discount will available from start date,Leave blank To Start Now'] = '' ;
        $_w['Active From'] = '' ;
        $_w['Enter Coupon Offer Name'] = '' ;
        $_w['Coupon Name'] = '' ;
        $_w['Coupon Status'] = '' ;
        $_w['Product Coupon Setting'] = '' ;
        $_w['User Type'] = '' ;
        $_w['Gold'] = '' ;
        $_w['Basic'] = '' ;
        $_w['Platinum'] = '' ;
        $_w['Coupon Use'] = '' ;
        $_w['COUPON ID'] = '' ;
        $_w['ORDER ID'] = '' ;
        $_w['User'] = '' ;
        $_w['DATE'] = '' ;
        $_w['User Id'] = '' ;
        $_w['Coupon Limit'] = '' ;
        $_w['Enter Limit'] = '' ;
        $_w['USER'] = '' ;
        $_w['DATE TIME'] = '' ;
       
     
      

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin Product Coupon');
    }


    /************************************/
    /**
     * @param $pId
     * @return bool|MultiArray
     */
    public function saleSettingData($pId){
        $sql ="SELECT `product_coupon_spb`.*, `product_coupon_setting_spb`.* FROM
                    `product_coupon_spb` join `product_coupon_setting_spb`
                    on `product_coupon_spb`.`pCoupon_pk` = `product_coupon_setting_spb`.`pCoupon_id`
                    WHERE `product_coupon_spb`.`pCoupon_pk`    = '$pId' ";
        $data = $this->dbF->getRows($sql);
        if($this->dbF->rowCount>0){
            return $data;
        }
        return false;
    }

    /**
     * @param $pId
     * @return bool|MultiArray
     */
    public function salePriceData($pId){
        $sql ="SELECT `product_coupon_spb`.*, `product_coupon_prices_spb`.* FROM
                    `product_coupon_spb` join `product_coupon_prices_spb`
                    on `product_coupon_spb`.`pCoupon_pk` = `product_coupon_prices_spb`.`pSale_price_id`
                    WHERE `product_coupon_spb`.`pCoupon_pk`    = '$pId' ";
        $data = $this->dbF->getRows($sql);
        if($this->dbF->rowCount>0){
            return $data;
        }
        return false;
    }

    public function discountArrayFound($data,$findKey){
        foreach($data as $val){
            if($val['pCoupon_setting_name'] == $findKey){
                return $val['pCoupon_setting_value'];
            }
        }
        return '';
    }

    /**
     *
     */
    public function UserName($id){
        $sql = "SELECT `acc_name` FROM `accounts_user` WHERE `acc_id`= ? ";
        $data = $this->dbF->getRow($sql,array($id));
        return $data[0];

    }
    public function couponUse()
    {

        // $qry="SELECT * FROM `proudct_detail_spb` WHERE `product_update` = '1'";
       // coupon_useage_record(`user`,`order_id`,`coupon`,`info`,`dateTime`)
        $today  = date('Y-m-d');
        $qry="
         SELECT * FROM `coupon_useage_record`";

        echo $this->product_list_View_use($qry);
    
    }
    public function couponView()
    {
        // $qry="SELECT * FROM `proudct_detail_spb` WHERE `product_update` = '1'";
       // coupon_useage_record(`user`,`order_id`,`coupon`,`info`,`dateTime`)
        $today  = date('Y-m-d');
        $qry="SELECT 
        pCoupon_pk,
        pCoupon_from,
        pCoupon_to,
        pCoupon_category,
        pCoupon_name,
        pCoupon_format,
        pCoupon_status, 
        pCoupon_limit,

    (SELECT count(`coupon_id`) as cnt  FROM `coupon_useage_record`  WHERE `coupon_id` =  c.pCoupon_pk ) as sale
                    FROM product_coupon_spb as c
                     WHERE pCoupon_status = '1'
                      AND pCoupon_from <= '$today'
                      AND pCoupon_to  >= '$today' OR pCoupon_to  = '' ";

        echo $this->product_list_View($qry,'Active');
    }

    public function productDiscountDraft()
    {
        $today  = date('Y-m-d');
        $qry="SELECT 
        pCoupon_pk,
        pCoupon_from,
        pCoupon_to,
        pCoupon_category,
        pCoupon_name,
        pCoupon_format,
        pCoupon_status, 
        pCoupon_limit,

    (SELECT count(`coupon_id`) as cnt  FROM `coupon_useage_record`  WHERE `coupon_id` =  c.pCoupon_pk ) as sale
                    FROM product_coupon_spb as c
                 WHERE pCoupon_status = '0' ";
        echo $this->product_list_View($qry);
    }

    public function productDiscountPending()
    {
        $today  = date('Y-m-d');
        $qry="SELECT 
        pCoupon_pk,
        pCoupon_from,
        pCoupon_to,
        pCoupon_category,
        pCoupon_name,
        pCoupon_format,
        pCoupon_status, 
        pCoupon_limit,

    (SELECT count(`coupon_id`) as cnt  FROM `coupon_useage_record`  WHERE `coupon_id` =  c.pCoupon_pk ) as sale
                    FROM product_coupon_spb as c
                 WHERE pCoupon_status != '1'  ";//AND pCoupon_from > '$today'
        echo $this->product_list_View($qry);
    }

    public function productDiscountExpire()
    {
        $today  = date('Y-m-d');
        $qry="SELECT 
        pCoupon_pk,
        pCoupon_from,
        pCoupon_to,
        pCoupon_category,
        pCoupon_name,
        pCoupon_format,
        pCoupon_status, 
        pCoupon_limit,

    (SELECT count(`coupon_id`) as cnt  FROM `coupon_useage_record`  WHERE `coupon_id` =  c.pCoupon_pk ) as sale
                    FROM product_coupon_spb as c
                     WHERE pCoupon_status = '1'
                      AND pCoupon_from < '$today'
                      AND pCoupon_to  < '$today' OR pCoupon_to  = '' ";
     
        echo $this->product_list_View($qry);
    }

    /**
     * @param $qry
     */
    private function product_list_View_use($qry,$calledFrom='Active'){

        global $_e;
        $data=$this->dbF->getRows($qry);
          
//table dTable 
            echo  '
            <div class="table-responsive">
            <table class="dTable table table-hover tableIBMS ">
                <thead>
                    <tr>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>'. _u($_e['COUPON']) .'</th>
                       
                        <th>'. _u($_e['ORDER ID']) .'</th>
                        <th>'. _u($_e['DATE TIME']) .'</th>
                                            
                    </tr>
                </thead>
                <tbody>';
            $i=0;
            foreach($data as $key=>$val){
                $i++;
                
                 $saleId  =  $val['id_pk'];
                $coupon  =  $val['coupon'];
               // $user  =  base64_decode($val['user']);
               // echo $user;
               // $user=  $this->UserName($user);
                // <td>$user</td>
                // <th>'. _u($_e['USER']) .'</th>
                $orderid  =  $val['order_id'];
                $dateTime  =  $val['dateTime'];
                $dateTime  = date("Y-m-d H:i:s",strtotime($dateTime));
                 
             
                echo "
                        <tr>
                        <td>$i</td>
                            <td>$coupon</td>
                           
                            <td>$orderid</td>
                            <td> $dateTime </td>
                           </tr>";
            }

            echo '
                </tbody>
            </table>
            </div>';

        
    }
    private function product_list_View($qry,$calledFrom='Active'){
        global $_e;
        $data=$this->dbF->getRows($qry);
            $uniq   =   uniqid('id');

            echo  '
            <div class="table-responsive">
            <table class="table dTable table-hover tableIBMS ">
                <thead>
                    <tr>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>'. _u($_e['COUPON']) .'</th>
                        <th>'. _u($_e['SALE DATE']) .'</th>
                        <th>'. _u($_e['USE']) .'</th>
                        <th>'. _u($_e['Coupon Limit']) .'</th>
                        <th>Link</th>
                        <th>price Format</th>
                        <th>'. _u($_e['ACTION']) .'</th>
                    </tr>
                </thead>
                <tbody>';
            $i=0;
            foreach($data as $key=>$val){
                $i++;
                $saleId  =  $val['pCoupon_pk'];
                $pCoupon_limit  =  $val['pCoupon_limit'];
                $dateFrom=  base64_encode($val['pCoupon_from']);
                $dateTo  =  base64_encode($val['pCoupon_to']);
                $pCoupon_limit   =  $val['pCoupon_limit'];
                $pCouponname = base64_encode($val['pCoupon_name']);
                $pCoupon_pk = base64_encode($val['pCoupon_pk']);
        $hash = hash("md5", $this->functions->encode("id=".$pCoupon_pk."&from=".$dateFrom."&to=".$dateTo.""));
                $encode = "".$pCoupon_pk."::".$dateFrom."::".$dateTo."::".$hash."";
               $hashs = WEB_URL."/index.php?id=".base64_encode($encode);

                $categoryNames  =   $this->productF->getCategoryNames($val['pCoupon_category']);
                $dateRange  =   "From : ".base64_decode($dateFrom)." ; Expire : ". base64_decode($dateTo)."";
                echo "
                        <tr class='p_$saleId'>
                            <td class='tableBgGray'>
                                <div class='checkbox'>
                                    <label>$i</label>
                                </div>
                            </td>
                            <td>".$val['pCoupon_name']."</td>
    
                            <td>".$dateRange."</td>
                            <td>".$val['sale']."</td>
                            <td>".$pCoupon_limit."</td>
                            <td>$hashs</td>
                            <td>".$val['pCoupon_format']."</td>
                            <td class='tableBgGray' width='110'>
                                <div class='btn-group btn-group-sm'>
                                <a href='-product_spb?page=pCouponForm&sId=$saleId' class='btn'><i class='glyphicon glyphicon-edit'></i></a>
                                <a data-id='$saleId' onclick='discountProductDel(this);' class='btn '>
                                    <i class='glyphicon glyphicon-trash trash'></i>
                                    <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                                </a>
                                </div>
                            </td>
                        </tr>";
            }

            echo '
                </tbody>
            </table>
            </div>';

        }

}

?>