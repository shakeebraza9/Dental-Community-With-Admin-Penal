<style>
    

.new {
  padding: 50px;
}

.checkboxx {
  display: block;
  margin-bottom: 15px;
}

.checkboxx input {
  padding: 0;
  height: initial;
  width: initial;
  margin-bottom: 0;
  display: none;
  cursor: pointer;
}

.checkboxx label {
  position: relative;
  cursor: pointer;
  display: block;
}

.checkboxx label:before {
  content:'';
  -webkit-appearance: none;
  background-color: transparent;
  border: 2px solid #54aa54;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
  padding: 10px;
  display: inline-block;
  position: relative;
  vertical-align: middle;
  cursor: pointer;
  margin-right: 5px;
}

.checkboxx input:checked + label:after {
  content: '';
  display: block;
  position: absolute;
  top: 2px;
  left: 9px;
  width: 6px;
  height: 14px;
  border: solid #0079bf;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}
/*select Box*/

.box {
  /*position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);*/

}

.box select {
    background-color: #01abbf;
    color: white;
    padding: 9px;
    width: 463px;
    border: none;
    font-size: 20px;
    box-shadow: 0 5px 25px rgb(0 0 0 / 20%);
    -webkit-appearance: button;
    appearance: button;
    outline: none;

}

.box::before {
  content: "\f13a";
  font-family: FontAwesome;
  position: absolute;
  top: 0;
  right: 0;
  width: 20%;
  height: 100%;
  text-align: center;
  font-size: 28px;
  line-height: 45px;
  color: rgba(255, 255, 255, 0.5);
  background-color: rgba(255, 255, 255, 0.1);
  pointer-events: none;
}

.box:hover::before {
  color: rgba(255, 255, 255, 0.6);
  background-color: rgba(255, 255, 255, 0.2);
}

.box select option {
  padding: 30px;
}
</style>
<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class domain extends object_class{
public $productF;
public $imageName;
public $script_js;
public function __construct(){
parent::__construct('3');

# saving script
$this->script_js = array();


/**
* MultiLanguage keys Use where echo;
* define this class words and where this class will call
* and define words of image where this class will called
**/
global $_e;
global $adminPanelLanguage;
$_w=array();//homePage.php

//homePageEdit.php
$_w['SAVE'] = '' ;
$_w['Close'] = '' ;
$_w['Delete Fail Please Try Again.'] = '' ;
$_w['Domain Entry'] = '' ;
$_w['Added'] = '' ;
$_w['Domains'] = '' ;
$_w['ACTION'] = '' ;
$_w['PAYMENT'] = '' ;

$_w['Date'] = '' ;
$_w['Select Agent'] = '' ;
$_w['Title'] = '' ;
$_w['Payment'] = '' ;
$_w['Add New'] = '' ;
$_w['View Entries'] = '' ;
$_w['Domain'] = '' ;
$_w['File Save Successfully'] = '' ;
$_w['Course Entry'] = '' ;
$_w['Course Entry Save Successfully'] = '' ;
$_w['Course Entry Save Failed,Please Enter Correct Values, And unique slug'] = '' ;
$_w['SNO'] = '' ;
$_w['DATE'] = '' ;
$_w['TITLE'] = '' ;
$_w['AGENT'] = '' ;
$_w['Description'] = '' ;
$_w['DESCIRPTION'] = '' ;
$_w['Update'] = '' ;
$_w['Course Not Found For Update'] = '' ;

$_w['test category'] = '' ;
$_w['Course Dentist Category'] = '' ;
$_w['Image'] = '' ;
$_w['Link'] = '' ;
$_w['Draft'] = '' ;
$_w['Course'] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;


$_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin File Management');

}


public function domainView($userFor=false){

$sql  = "SELECT * FROM `subjects` WHERE `publish` = '1' ORDER BY `subject_id` DESC ";
$data =  $this->dbF->getRows($sql);
$this->printViewTable($data);
}

public function domainDraft($userFor=false){

$sql  = "SELECT * FROM `subjects` WHERE `publish` = '0' ORDER BY `subject_id` DESC ";
$data =  $this->dbF->getRows($sql);
$this->printViewTable($data);
}


private function printViewTable($data){
global $_e;
echo '<div class="table-responsive">
<table class="table table-hover dTable tableIBMS">
<thead>
<th>'. _u($_e['SNO']) .'</th>
<th>'. _u($_e['TITLE']) .'</th>
<th>'. _u($_e['test category']) .'</th>
<th>'. _u($_e['Course Dentist Category']) .'</th>
<th>'. _u('under') .'</th>
<th>'. _u($_e['DESCIRPTION']) .'</th>
<th>'. _u($_e['DATE']) .'</th>
<th>'. _u($_e['ACTION']) .'</th>
</thead>';

$i = 0;
$defaultLang = $this->functions->AdminDefaultLanguage();
foreach($data as $val){
$i++;
$id = $val['subject_id'];
$date_timestamp = $val['date_timestamp'];
$title = $val['subject_title'];
$desc = $val['subject_desc'];
$test_category = $val['test_category'];
$course_dental_category = $val['course_dental_category'];
$under = $this->dbF->getRow("SELECT `subject_title` FROM `subjects` WHERE `subject_id`='$val[under]'");
echo "<tr>
<td>$i</td>
<td>$title</td>
<td>$test_category</td>
<td>$course_dental_category</td>
<td>$under[0]</td>
<td>$desc</td>
<td>$date_timestamp</td>

<td>
    <div class='btn-group btn-group-sm'>
        <a data-id='$id' href='-".$this->functions->getLinkFolder()."?page=edit&domainId=$id' class='btn'>
            <i class='glyphicon glyphicon-edit'></i>
        </a>
        <a data-id='$id' onclick='deleteDomain(this);' class='btn'>
            <i class='glyphicon glyphicon-trash trash'></i>
            <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
        </a>
    </div>
</td>

</tr>";
}
echo '</tbody>
</table>
</div> <!-- .table-responsive End -->';

}


public function newDomainAdd(){
global $_e;
if(isset($_POST['title']) && isset($_POST['submit'])){
if(!$this->functions->getFormToken('newDomain')){return false;}
// echo "<pre>"; print_r($_POST); echo "</pre>";
// exit;
$publish    = empty($_POST['publish'])      ? "0"   : $_POST['publish'];
$under      = empty($_POST['under'])        ? "0"    : $_POST['under'];
$desc    	= empty($_POST['desc']) 	    ? ""    : $_POST['desc'];
$title     	= empty($_POST['title'])  	    ? ""    : $_POST['title'];
$expiration   = empty($_POST['expiration']) ? ""    : $_POST['expiration'];
$minutes      = empty($_POST['minutes'])    ? ""    : $_POST['minutes'];
$test_category      = empty($_POST['test_category'])       ? ""    : $_POST['test_category'];
$coursearray      = empty($_POST['coursearray'])       ?  array()    : $_POST['coursearray'];
$image      = empty($_POST['image'])       ? ""    : $_POST['image'];
$link       = empty($_POST['link'])        ? ""    : $_POST['link'];
$color      = empty($_POST['color'])       ? ""    : $_POST['color'];

htmlspecialchars($publish);
htmlspecialchars($under);
htmlspecialchars($desc);
htmlspecialchars($title);
htmlspecialchars($expiration);
htmlspecialchars($minutes);
htmlspecialchars($test_category);
htmlspecialchars($color);

$coursearray = implode(',',$coursearray);

try{
$this->db->beginTransaction();

$sql  =  "INSERT INTO `subjects`(`subject_title`,`expiration`,`minutes`,`image`,`link`,`subject_desc`,test_category,`course_dental_category`,`under`,`publish`,`color`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

$array   = array($title,$expiration,$minutes,$image,$link,$desc,$test_category,$coursearray,$under,$publish,$color);

$this->dbF->setRow($sql,$array,false);
$lastId  =   $this->dbF->rowLastId;

$subject='New CPD Course uploaded';
$msg='Great News !!! We have just uploaded a Brand Spanking New CPD course for you to complete.';
$this->db->commit();
if($this->dbF->rowCount>0){
$noti=$functions->push_notification($subject, $msg,'all');
$functions->send_mail('samratbutani@gmail.com',$subject,$noti);
$this->functions->notificationError(_js(_uc($_e['Course'])),_js(_uc($_e['Course Entry Save Successfully'])),'btn-success');
$this->functions->setlog(_js(_uc($_e['Course'])),_js(_uc($_e['Course Entry'])),_js(_uc($_e['Course Entry Save Successfully'])));
}else{
$this->functions->notificationError(_js(_uc($_e['Course'])),_js(_uc($_e['Course Entry Save Failed,Please Enter Correct Values, And unique slug'])),'btn-danger');
}
}catch (Exception $e){
$this->db->rollBack();
$this->dbF->error_submit($e);
$this->functions->notificationError(_js(_uc($_e['Course'])),_js(_uc($_e['Course Entry Save Failed,Please Enter Correct Values, And unique slug'])),'btn-danger');
}
} //If end
}

public function domainEditSubmit(){
global $_e;

if(isset($_POST['title']) && isset($_POST['submit'])){

if(!$this->functions->getFormToken('editDomain')){return false;}

$desc       = empty($_POST['desc'])        ? ""    : $_POST['desc'];
$title      = empty($_POST['title'])       ? ""    : $_POST['title'];
$expiration      = empty($_POST['expiration'])       ? ""    : $_POST['expiration'];
$minutes      = empty($_POST['minutes'])       ? ""    : $_POST['minutes'];
$test_category= empty($_POST['test_category'])       ? ""    : $_POST['test_category'];


$publish        = empty($_POST['publish'])     ? "0"   : $_POST['publish'];
$image      = empty($_POST['image'])        ? ""    : $_POST['image'];
$link       = empty($_POST['link'])         ? ""    : $_POST['link'];
$under      = empty($_POST['under'])        ? "0"   : $_POST['under'];
$color      = empty($_POST['color'])       ? ""    : $_POST['color'];


$coursearray      = empty($_POST['coursearray'])       ?  array()    : $_POST['coursearray'];
$coursearray = implode(',',$coursearray);
echo "<pre>";
print_r($coursearray);
echo "</pre>";

htmlspecialchars($desc);
htmlspecialchars($title);
htmlspecialchars($expiration);
htmlspecialchars($minutes);
htmlspecialchars($test_category);
htmlspecialchars($publish);
htmlspecialchars($image);
htmlspecialchars($link);
htmlspecialchars($under);
htmlspecialchars($color);


try{
$this->db->beginTransaction();

$lastId   =   $_POST['domainId'];

$sql  =  "UPDATE `subjects` SET 
                `subject_title` = ?,
                `expiration` = ?,
                `minutes` = ?,
                `image` = ?,
                `link` = ?,
                `subject_desc` = ?,
                `test_category`=?,
                `course_dental_category`=?,
                `under`=?,
                `publish`=?,
                `color`=?
                WHERE `subject_id` = ?";

$array   = array($title,$expiration,$minutes,$image,$link,$desc,$test_category,$coursearray,$under,$publish,$color,$lastId);

$this->dbF->setRow($sql,$array,false);
$lastId  =   $this->dbF->rowLastId;

$this->db->commit();
if($this->dbF->rowCount>0){
$this->functions->notificationError(_js(_uc($_e['Course'])),_js(_uc($_e['Course Entry Save Successfully'])),'btn-success');
$this->functions->setlog(_js(_uc($_e['Course'])),_js(_uc($_e['Course Entry'])),0);
}else{
$this->functions->notificationError(_js(_uc($_e['Course'])),_js(_uc($_e['Course Entry Save Failed,Please Enter Correct Values, And unique slug'])),'btn-danger');
}
}catch (Exception $e){
$this->db->rollBack();
$this->dbF->error_submit($e);
$this->functions->notificationError(_js(_uc($_e['Course'])),_js(_uc($_e['Course Entry Save Failed,Please Enter Correct Values, And unique slug'])),'btn-danger');
}
} //If end
}

public function domainNew(){
$this->domainEdit(true);
return '';
}

public function domainEdit($new = false){
global $_e;

$isEdit = false;
if($new ===true){
    $token       = $this->functions->setFormToken('newDomain',false);
}else{
    //For Edit Page.
    $isEdit = true;
    $token = $this->functions->setFormToken('editDomain', false);
    $id = $_GET['domainId'];
    $sql = "SELECT * FROM `subjects` WHERE `subject_id` = '$id' ";
    $data = $this->dbF->getRow($sql);

    if($this->dbF->rowCount==0){
    echo  _uc($_e["Domain Not Found For Update"]);
    return false;
    }
}

//No need to remove any thing,, go in developer setting table and set 0
echo '<form method="post" action="-domain?page=domain" class="form-horizontal" role="form" enctype="multipart/form-data">
<input type="hidden" name="domainId" value="'.@$id.'"/>'.
$token.
'
<div class="form-horizontal">

<!-- Tab panes -->

';

if($isEdit) {
$subject_title = ($data['subject_title']);
$subject_desc = ($data['subject_desc']);
$test_category = ($data['test_category']);
$course_dental_categorys = $data['course_dental_category'];
$expiration = ($data['expiration']);
$minutes = ($data['minutes']);
$under = ($data['under']);
$image = ($data['image']);
$link = ($data['link']);
$color = ($data['color']);
}

$lang = $this->functions->IbmsLanguages();
if($lang != false){
$lang_nonArray = implode(',', $lang);
}
echo '<input type="hidden" name="lang" value="'.$lang_nonArray.'" />';

//Title
echo '  <div class="form-group">
	        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Title']) .'</label>
	        <div class="col-sm-10  col-md-9">
	            <input type="text" name="title" value="'.@$subject_title.'" class="form-control" placeholder="'. _uc($_e['Title']) .'">
	        </div>
	    </div>';

//Expiration
echo '  <div class="form-group">
            <label class="col-sm-2 col-md-3  control-label">'. _uc('Expiration (in months)') .'</label>
            <div class="col-sm-10  col-md-9">
                <input type="text" name="expiration" value="'.@$expiration.'" class="form-control" placeholder="'. _uc('Expiration (in months)') .'">
            </div>
        </div>';

//Minutes
echo '  <div class="form-group">
            <label class="col-sm-2 col-md-3  control-label">'. _uc('CPD Minutes') .'</label>
            <div class="col-sm-10  col-md-9">
            ';?>

              <select  name="minutes"  class="form-control">
         
          <option value=""  disable="">Select cpd Hours</option>
    <option value="60" <?php if ($minutes == '60') {echo 'selected';} ?> >1 Hours</option>
  <option value="120" <?php if ($minutes == '120') {echo 'selected';} ?> >2 Hours</option>
        </select>

             <!-----   <input type="text"  value="'.@$minutes.'" class="form-control" placeholder="'. _uc('CPD Minutes') .'">--------->
<?php echo '
            </div> 
        </div>';

        //Image
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Image']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <div class="input-group">
                                 <input type="text"  name="image" value="'.@$image.'" class="layer1 form-control" placeholder="">
                                 <div class="input-group-addon pointer " onclick="'."openKCFinderImage($('.layer1'))".'"><i class="glyphicon glyphicon-picture"></i></div>
                             </div>
                        </div>
                    </div>';

//Link
echo '  <div class="form-group">
            <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Link']) .'</label>
            <div class="col-sm-10  col-md-9">
                <input type="text" name="link" value="'.@$link.'" class="form-control" placeholder="'. _uc($_e['Link']) .'">
            </div>
        </div>';

        //test_category
        echo '
        <div class="form-group">
        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['test category']) .'

        </label>
          <div class="col-sm-10  col-md-9">
<select name="test_category"  required="required" class="test_category form-control">

';
 $applied_for_fields_array = explode(',', $this->functions->ibms_setting('test_categories'));

foreach ($applied_for_fields_array as $field): 
echo'
<option value="'.$field.'"> 
'.$field.'
</option>
 ';

 endforeach;  
echo '
</select>
</div>
</div>
<script>
$(".test_category").val("'.@$test_category.'").change();
</script>
';
//test_category
        echo '
        <div class="form-group"  >
        <label class="col-sm-2 col-md-3  control-label" style="font-size: 23px;">'. _uc($_e['Course Dentist Category']) .'

        </label>
          <div class="checkboxx col-sm-10  col-md-9">

';

 @$fields_array_IBMS = explode(',', $this->functions->ibms_setting('course_dental_category'));
 @$course_dental_categorys  = explode(',',$course_dental_categorys);

 
        $chbox = "";
 for ($i=0; $i < count($fields_array_IBMS); $i++) { 
    
    
       if (in_array($fields_array_IBMS[$i],$course_dental_categorys)) {
         $chbox = 'checked';   
      }else
      {
        $chbox = ''; 
      }
     
  
    
      echo'<input type="checkbox" id="'.$fields_array_IBMS[$i].'" name="coursearray[]" value="'.$fields_array_IBMS[$i].'"  '.$chbox.'>
      <label for="'.$fields_array_IBMS[$i].'">'.$fields_array_IBMS[$i].'</label>';

 }
echo '

</div>
</div>
';


$checked1 = "";
$dspy = 'style="display:none"';
if(@$under!='0'){$checked1='checked';$dspy = '';}
echo '<div class="form-group">
<label  class="col-sm-2 col-md-3  control-label">Under</label>
<div class="col-sm-10  col-md-9">
<div id="make-switch0" class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc('Yes') .'" data-off-label="'. _uc('No') .'">
<input type="checkbox" value="1" '.$checked1.'>
<input type="hidden" class="checkboxHidden" value="1">
</div>
</div>
</div>';

//test_category
echo '
<div class="form-group shwunder" '.$dspy.'>
<label class="col-sm-2 col-md-3  control-label">'. _uc('Course') .'
</label>
<div class="col-sm-10  col-md-9">
<select name="under" class="under form-control">
<option value="0">Select Course</option>
';
 $courses = $this->dbF->getRows("SELECT `subject_id`,`subject_title` FROM `subjects` WHERE `publish`='1' AND `subject_id` NOT IN (SELECT `subject_id` FROM `subjects` WHERE `under` != '0')");

foreach ($courses as $value): 
    if($value['subject_id'] == $id){
        continue;
    }
echo'
<option value="'.$value['subject_id'].'"> 
'.$value['subject_title'].'
</option>
 ';

 endforeach;  
echo '
</select>
</div>
</div>
<script>
$(".under").val("'.@$under.'").change();
</script>
';

echo '  <div class="form-group">
	        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Description']) .'</label>
	        <div class="col-sm-10  col-md-9">
                <textarea name="desc" class="form-control" placeholder="'. _uc($_e['Description']) .'">'.@$subject_desc.'</textarea>
	        </div>
	    </div>';

        // Color
echo '  <div class="form-group">
            <label class="col-sm-2 col-md-3  control-label">'. _uc('Color') .'</label>
            <div class="col-sm-10  col-md-9">
                <input type="text" name="color" value="'.@$color.'" class="form-control" placeholder="'. _uc('Color') .'">
            </div>
        </div>';

$checked2 = "";
if(@$data['publish']=='1'){$checked2='checked';}
echo '<div class="form-group">
<label  class="col-sm-2 col-md-3  control-label">Publish</label>
<div class="col-sm-10  col-md-9">
<div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc('Yes') .'" data-off-label="'. _uc('No') .'">
<input type="checkbox" name="publish" value="1" '.$checked2.'>
</div>
</div>
</div>';




echo '<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">'. _u($_e['SAVE']) .'</button>';

echo "
</div> <!-- container end -->
</form>";

} //function end

}
?>