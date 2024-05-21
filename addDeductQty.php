<?php 
include_once("global.php");
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}



//   $token = $functions->makeRecoverySQL('myeventsFilled','user',10);
// var_dump($token);
//  $sql = "INSERT INTO `ibms_setting`(`setting_name`,`setting_val`,`info`) VALUES (?,?,?)";

// $array =   array('setting_name1', $token, 'info');
// $dbF->setRow($sql, $array, false);



//      $sql = "SELECT setting_val FROM `ibms_setting` WHERE `setting_name` = ? ";
//             $data = $dbF->getRow($sql,array('setting_name1'));

// $q = $data['setting_val'];

// $q =trim($q,"; ");


// $a = $dbF->setRow($q,null,true);
// var_dump($a);


// INSERT INTO `myeventsFilled` SET  `id` = '1',  `my_e_id` = '1886',  `title_id` = '1886',  `q_id` = '1',  `user` = '10',  `radio` = 'Yes',  `date` = '',  `time` = '',  `field1` = 'i am fine',  `field2` = 'and im in office',  `dateTime` = '2021-10-15 01:56:48'; INSERT INTO `myeventsFilled` SET  `id` = '21',  `my_e_id` = '1933',  `title_id` = '1933',  `q_id` = '260',  `user` = '10',  `radio` = '',  `date` = '',  `time` = '',  `field1` = 'a',  `field2` = 'asdf',  `dateTime` = '2021-10-16 06:19:03'; INSERT INTO `myeventsFilled` SET  `id` = '17522',  `my_e_id` = '3847',  `title_id` = '3847',  `q_id` = '5660',  `user` = '10',  `radio` = '',  `date` = '',  `time` = '',  `field1` = '',  `field2` = '',  `dateTime` = '2021-11-23 21:29:01'

// $servername = "localhost";
// $username = "doxu10vne1mw_portal_2022";
// $password = "1UF}R[NbYL20";
// $dbname = "doxu10vne1mw_portal_2022";

// try {
//   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//   // set the PDO error mode to exception
//   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   // $sql = "INSERT INTO MyGuests (firstname, lastname, email)
//   // VALUES ('John', 'Doe', 'john@example.com')";
//   // use exec() because no results are returned
//   $conn->exec($q);
//   echo "New record created successfully";
// } catch(PDOException $e) {
//   echo $q . "<br>" . $e->getMessage();
// }

// $conn = null;




@$id = $_GET['id'];
 // $id = base64_decode($id);
 
if (@$_GET['id'] !='') {
    $token = $functions->setFormToken('min_stockEdit',false);


     $sql = "SELECT * FROM `product_inventory` WHERE `qty_pk` = ? ";
            $data = $dbF->getRow($sql,array($id));






} else {
    $token = $functions->setFormToken('min_stockAdd',false);
}
?>
<div class="event_details" id="myform">
    <h3><?php echo "Add / Deduct Quantity"; ?></h3>
    <div class="form_side">


        <div class="form-group"> <label><?php echo $productClass->getProductFullNameWeb( $data['qty_product_id'], $data['qty_product_scale'], $data['qty_product_color'] ); ?></label></div>




    <form method="post" action="<?php echo WEB_URL ?>/stockView">
    <?php echo $token ?>
               <input type="hidden" value="<?php echo $id; ?>" name="qty_itemPK">



              <div class="form-group">
                <label style="display: inline-block;font-weight: 600;">Add New Quantity</label>
               <!-- <textarea name="txt"  id="ckeditor" class="txt ckeditor"></textarea> -->
               <input type="number" value="<?php echo $data['qty_item'] ?>" name="qty_item" class="txt">
            </div>
           

    <input type="submit" value="Save" class="submit_class">
            
        </form>
    </div>
    <!-- form_side close -->
</div>

