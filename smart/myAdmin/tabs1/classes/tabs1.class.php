<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class tabs1 extends object_class{
public $productF;
public function __construct(){
parent::__construct('3');

/**
* MultiLanguage keys Use where echo;
* define this class words and where this class will call
* and define words of file where this class will called
**/
global $_e;
global $adminPanelLanguage;
$_w=array();
//Index
$_w['Slider Management'] = '' ;
//tabs1Edit.php
$_w['Manage Slider'] = '' ;

//tabs1.php
$_w['Active Slider'] = '' ;
$_w['Draft'] = '' ;
$_w['Sort Slider'] = '' ;
$_w['Add New Slider'] = '' ;
$_w['Delete Fail Please Try Again.'] = '' ;
$_w['There is an error, Please Refresh Page and Try Again'] = '' ;
$_w['SNO'] = '' ;
$_w['TITLE'] = '' ;
$_w['IMAGE'] = '' ;
$_w['ACTION'] = '' ;

$_w['Image File Error'] = '' ;
$_w['Image Not Found'] = '' ;
$_w['Slider'] = '' ;
$_w['Added'] = '' ;
$_w['Slider Add Successfully'] = '' ;
$_w['Slider Add Failed'] = '' ;
$_w['Slider Update Failed'] = '' ;
$_w['Slider Update Successfully'] = '' ;
$_w['Update'] = '' ;
$_w['Slider Title'] = '' ;
$_w['Slider Link'] = '' ;
$_w['Short Desc'] = '' ;
$_w['Image Recommended Size : {{size}}'] = '' ;
$_w['Publish'] = '' ;
$_w['Image Recommended Size : 380px X 307px'] = '' ;
$_w['Tab Image Recommended Size : 73px X 67px'] = '' ;
$_w['Slider Link'] = '' ;
$_w['Slider Update failed'] = '' ;
$_w['Image Recommended Size : 73px X 67px'] = '' ;
$_w['Tab Old Slider Image'] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;

$_w['SAVE'] = '' ;
$_w['Old Slider Image'] = '' ;

$_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin Tabs Management');

}


public function tabs1Sort(){
echo '<div class="table-responsive sortDiv">
<div class="container-fluid activeSort">';
$sql ="SELECT * FROM `tabs1` WHERE publish = '1' ORDER BY sort ASC";
$data = $this->dbF->getRows($sql);

$defaultLang = $this->functions->AdminDefaultLanguage();
foreach($data as $val){
$id = $val['id'];
$image = $val['image'];
$image2 = $val['image2'];
@$title = unserialize($val['tabs1_heading']);
@$title = $title[$defaultLang];
echo '  <div class="singleAlbum " id="album_'.$id.'">
<div class="col-sm-12 albumSortTop"> ::: </div>
<div class="albumImage"><img src="../images/'.$image.'"  class="img-responsive"/></div>
<div class="clearfix"></div>
<div class="albumMange col-sm-12">
<div class="col-sm-12 btn-default" style="">'.$title.'</div>
</div>
</div>';
}

echo '</div>';
echo '</div>';
}


public function tabs1View(){
$sql  = "SELECT * FROM tabs1 WHERE publish='1' ORDER BY ID DESC";
$data =  $this->dbF->getRows($sql);
$this->tabs1Print($data);
}

public function tabs1Draft(){
$sql  = "SELECT id, tabs1_heading,image FROM tabs1 WHERE publish='0' ORDER BY ID DESC";
$data =  $this->dbF->getRows($sql);
$this->tabs1Print($data);
}

public function tabs1Print($data){
global $_e;
$class=" dTableFull tableIBMS";
$heading = true;
if($this->functions->developer_setting('tabs1_heading')=='1'){
$class=" dTable tableIBMS";
$heading = true;
}
echo '<div class="table-responsive">
<table class="table table-hover '.$class.'">
<thead>
<th>'. _u($_e['SNO']) .'</th>';
if($heading){
echo        '<th>'. _u($_e['TITLE']) .'</th>';
}
echo            '<th>'. _u($_e['IMAGE']) .'</th>
<th>'. _u($_e['ACTION']) .'</th>
</thead>
<tbody>';

$i = 0;
$defaultLang = $this->functions->AdminDefaultLanguage();
foreach($data as $val){

$i++;
$id = $val['id'];
echo "<tr>
<td>$i</td>";
if($heading){
@$tabs1_heading = unserialize($val['tabs1_heading']);
@$tabs1_heading = $tabs1_heading[$defaultLang];
echo "  <td>$tabs1_heading</td>";
}
echo "
<td><img src='../images/$val[image]' style='max-height:200px;max-with:500px;'/></td>
<td>
<div class='btn-group btn-group-sm'>
<a data-id='$id' href='-tabs1?page=edit&tabs1Id=$id' class='btn'>
<i class='glyphicon glyphicon-edit'></i>
</a>
<a data-id='$id' onclick='deletetabs1(this);' class='btn'>
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

public function newtabs1Add(){
global $_e;
if(isset($_POST['submit']) && !empty($_FILES['image']['name'])){
if(!$this->functions->getFormToken('newtabs1')){return false;}

$heading        = empty($_POST['tabs1_heading'])   ? ""    : serialize($_POST['tabs1_heading']);
$link           = empty($_POST['tabs1_link'])      ? ""    : $_POST['tabs1_link'];
$short_desc     = empty($_POST['tabs1_shrtDesc'])  ? ""    : serialize($_POST['tabs1_shrtDesc']);
$publish        = empty($_POST['publish'])     ? "0"   : $_POST['publish'];


$shortDesc     = empty($_POST['shortDesc'])    ? ""    : $_POST['shortDesc'];





$file           = empty($_FILES['image']['name'])   ? false    : true;
$returnImage = "";

$file2           = empty($_FILES['image2']['name'])   ? false    : true;
$returnImage2 = "";
try{
$this->db->beginTransaction();

$sql      =   "INSERT INTO `tabs1`(
`tabs1_link`, `tabs1_heading`, `tabs1_shrtDesc`,`image`,`image2`,`publish`,`shortDesc`)
VALUES (?,?,?,?,?,?,?)";

if($file){
$returnImage =  $this->functions->uploadSingleImage($_FILES['image'],'Slider');
if($returnImage==false){
throw new Exception(($_e['Image File Error']));
}
}else{
throw new Exception(($_e["Image Not Found"]));
}


// if($file2){
//     $returnImage2 =  $this->functions->uploadSingleImage($_FILES['image2'],'Slider');
//     if($returnImage2==false){
//         throw new Exception(($_e['Image File Error']));
//     }
// }else{
//     throw new Exception(($_e["Image Not Found"]));
// }

$array   = array($link,$heading,$short_desc,$returnImage,$returnImage2,$publish,$shortDesc);
$this->dbF->setRow($sql,$array,false);
$lastId = $this->dbF->rowLastId;

$this->db->commit();
if($this->dbF->rowCount>0){
$this->functions->notificationError(_uc($_e['Slider']),($_e['Slider Add Successfully']),'btn-success');
$this->functions->setlog(_uc($_e['Added']),_uc($_e['Slider']),$lastId,($_e['Slider Add Successfully']));
}else{
$this->functions->notificationError(_uc($_e['Slider']),($_e['Slider Add Failed']),'btn-danger');
}
}catch (Exception $e){
if($returnImage!==false && $file){
$this->functions->deleteOldSingleImage($returnImage);
}
//      if($returnImage2!==false && $file2){
//     $this->functions->deleteOldSingleImage($returnImage2);
// }

$this->db->rollBack();
$this->dbF->error_submit($e);
$this->functions->notificationError(_uc($_e['Slider']),($_e['Slider Add Failed']),'btn-danger');
}
} // If end
}




public function tabs1EditSubmit(){
global $_e;
if(isset($_POST['submit']) && isset($_POST['editId'])){
if(!$this->functions->getFormToken('edittabs1')){return false;}

$heading        = empty($_POST['tabs1_heading'])   ? ""    : serialize($_POST['tabs1_heading']);
$link           = empty($_POST['tabs1_link'])      ? ""    : $_POST['tabs1_link'];
$short_desc     = empty($_POST['tabs1_shrtDesc'])  ? ""    : serialize($_POST['tabs1_shrtDesc']);
$publish        = empty($_POST['publish'])     ? "0"   : $_POST['publish'];

$file           = empty($_FILES['image']['name'])   ? false    : true;
$returnImage = "";

$oldImg      = empty($_POST['oldImg'])     ? ""   : $_POST['oldImg'];
$returnImage = $oldImg;

$shortDesc           = empty($_POST['shortDesc'])      ? ""    : $_POST['shortDesc'];

$file2           = empty($_FILES['image2']['name'])   ? false    : true;
$returnImage2 = "";

$oldImg2      = empty($_POST['oldImg2'])     ? ""   : $_POST['oldImg2'];
$returnImage2 = $oldImg2;
try{
$this->db->beginTransaction();
$lastId   =   $_POST['editId'];

if($file){
$this->functions->deleteOldSingleImage($oldImg);
$returnImage =  $this->functions->uploadSingleImage($_FILES['image'],'Slider');
if($returnImage==false){
throw new Exception(($_e['Image File Error']));
}


}

if($file2){
$this->functions->deleteOldSingleImage($oldImg2);
$returnImage2 =  $this->functions->uploadSingleImage($_FILES['image2'],'Slider');
if($returnImage2==false){
throw new Exception(($_e['Image File Error']));
}


}


$sql    =  "UPDATE `tabs1` SET
`tabs1_link`=?,
`tabs1_heading`=?,
`tabs1_shrtDesc`=?,
`image`=?,
`image2`=?,
`publish`=?,
shortDesc=?
WHERE id = '$lastId'
";

$array   = array($link,$heading,$short_desc,$returnImage,$returnImage2,$publish,$shortDesc);
$this->dbF->setRow($sql,$array,false);

$this->db->commit();
if($this->dbF->rowCount>0){
$this->functions->notificationError(_uc($_e['Slider']),($_e['Slider Update Successfully']),'btn-success');
$this->functions->setlog(_uc($_e['Update']),_uc($_e['Slider']),$lastId,($_e['Slider Update Successfully']));
}else{
$this->functions->notificationError(_uc($_e['Slider']),($_e['Slider Update failed']),'btn-danger');
}
}catch (Exception $e){
if($returnImage!==false && $file){
$this->functions->deleteOldSingleImage($returnImage);
}
if($returnImage2!==false && $file2){
$this->functions->deleteOldSingleImage($returnImage2);
}

$this->db->rollBack();
$this->dbF->error_submit($e);
$this->functions->notificationError(_uc($_e['Slider']),($_e['Slider Update failed']),'btn-danger');
}

}
}

public function tabs1New(){
global $_e;
$this->tabs1Edit(true);
}

public function tabs1Edit($new=false){
global $_e;
if($new){
$token       = $this->functions->setFormToken('newtabs1',false);
}else {
$id = $_GET['tabs1Id'];
$sql = "SELECT * FROM tabs1 where id = '$id' ";
$data = $this->dbF->getRow($sql);

$token = $this->functions->setFormToken('edittabs1', false);
$token .= '<input type="hidden" name="editId" value="'.$id.'"/>';
}
//No need to remove any thing,, go in developer setting table and set 0

echo '<form method="post" action="-tabs1?page=tabs1" class="form-horizontal" role="form" enctype="multipart/form-data">'.
$token.
'
<div class="form-horizontal">';

$lang = $this->functions->IbmsLanguages();
if($lang != false){
$lang_nonArray = implode(',', $lang);
}

echo '<input type="hidden" name="lang" value="'.$lang_nonArray.'" />';

echo '<div class="panel-group" id="accordion">';


@$tabs1_heading = unserialize($data['tabs1_heading']);
@$tabs1_shrtDesc =  unserialize($data['tabs1_shrtDesc']);
// $tabs1_shrtDesc = $tabs1_shrtDesc[$defaultLang];
//var_dump($data['tabs1_shrtDesc']);


for ($i = 0; $i < sizeof($lang); $i++) {
if ($i == 0) {
$collapseIn = ' in ';
} else {
$collapseIn = '';
}

echo '<div class="panel panel-default">
<div class="panel-heading">
<a data-toggle="collapse" data-parent="#accordion" href="#'.$lang[$i].'">
<h4 class="panel-title">
'.$lang[$i].'
</h4>
</a>
</div>
<div id="'.$lang[$i].'" class="panel-collapse collapse '.$collapseIn.'">
<div class="panel-body">';

//Title

echo '<div class="form-group">
<label class="col-sm-2 col-md-3  control-label">'. _uc($_e['TITLE']) .'</label>
<div class="col-sm-10  col-md-9">
<input type="text" name="tabs1_heading['.$lang[$i].']" value="'.@$tabs1_heading[$lang[$i]].'" class="form-control" placeholder="'. _uc($_e['Slider Title']) .'">
</div>
</div>';


//Short Desc

echo '<div class="form-group">
<label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Short Desc']) .'</label>
<div class="col-sm-10  col-md-9">
<textarea name="tabs1_shrtDesc['.$lang[$i].']v" id="tabs1_shrtDesc"  class="form-control ckeditor" placeholder="'. _uc($_e['Short Desc']) .'">'.$tabs1_shrtDesc[$lang[$i]].'</textarea>
</div>
</div>';



echo '           </div> <!-- panel-body end -->
</div> <!-- collapse end-->
</div><!-- panel end-->';
}

echo '</div> <!-- .accordian end -->';








$course_names = '';
$course_names = '<option disabled="disabled" selected="" value="">Select</option>';
// $sql_course   = "SELECT * from pages";
// $data_course  = $this->dbF->getRows($sql_course);
// foreach ($data_course as $value) {  
// $course_names .= '<option '.($value['page_pk'] == $shortDesc ? ' selected="" ' : "").' value="' . _l(trim($value['page_pk'])) . '"> '.$this->functions->unserializeTranslate($value['heading']) . '</option>' ;
// }



// echo '<div class="form-group">
// <label class="col-sm-2 col-md-3  control-label">Select Manpower:</label>

// <div class="col-sm-10  col-md-9">
// <div class="select-group">
// <select id="cou_id" name="shortDesc" class="form-control" placeholder="Select">
// <option disabled selected>Select</option>
// <option value="Demand" '.($data['shortDesc'] == "Demand" ? ' selected="" ' : "").'>Demand</option>
// <option value="Supply" '.($data['shortDesc'] == "Supply" ? ' selected="" ' : "").'>Supply</option>
// </select>      
// </div>
// </div>
// </div>';


// echo '<div class="form-group">
// <label class="col-sm-2 col-md-3  control-label">'. _uc('Font Owsum') .'</label>
// <div class="col-sm-10  col-md-9">
// <input type="text" name="shortDesc" value="'.@$data['shortDesc'].'" class="form-control" placeholder="'. _uc('Font Owsum') .'">
// </div>
// </div>';










// //Link

//     echo '<div class="form-group">
//             <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Slider Link']) .'</label>
//             <div class="col-sm-10  col-md-9">
//                 <input type="url" name="tabs1_link" value="'.@$data['tabs1_link'].'" class="form-control" placeholder="'. _uc($_e['Slider Link']) .'">
//             </div>
//         </div>';
//Link
@$link = $data['tabs1_link'];
@$link   = $this->functions->addWebUrlInLink($link);

// echo '<div class="form-group">
// <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Slider Link']) .'</label>
// <div class="col-sm-10  col-md-9">
// <div class="input-group">
// <input type="url" value="'.$link.'" name="tabs1_link" class="pastLinkHere form-control" placeholder="'. _uc($_e['Slider Link']) .'">
// <div class="input-group-addon linkList pointer"><i class="glyphicon glyphicon-search"></i></div>
// </div>
// </div>
// </div>';

//tabs1
$size = $this->functions->developer_setting('tabs1_size');
$img = "";
$req = "required";

if(@$data['image']!=''){
$img=$data['image'];
echo "<input type='hidden' name='oldImg' value='$img' />";
echo '<div class="form-group">
<label  class="col-sm-2 col-md-3  control-label">'. _uc('Old Image') .'</label>
<div class="col-sm-10  col-md-9">
<img src="../images/'.$img.'" style="max-height:250px;" >
</div>
</div>';


$req = "";
}

echo '<div class="form-group">
<label  class="col-sm-2 col-md-3  control-label">Image Recommended Size : 71px X 56px</label>
<div class="col-sm-10  col-md-9">
<input type="file" name="image" '.$req.' class="btn-file btn btn-primary">
</div>
</div>';

//          $img2 = "";
// if(@$data['image2']!=''){
//     $img2=$data['image2'];
//     echo "<input type='hidden' name='oldImg2' value='$img2' />";
//     echo '<div class="form-group">
//             <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Tab Old Slider Image']) .'</label>
//             <div class="col-sm-10  col-md-9">
//                 <img src="../images/'.$img2.'" style="max-height:250px;" >
//             </div>
//        </div>';
// }

// echo '<div class="form-group">
//             <label  class="col-sm-2 col-md-3  control-label">'. _replace('{{size}}',$size,$_e['Tab Image Recommended Size : 73px X 67px']) .'</label>
//             <div class="col-sm-10  col-md-9">
//                 <input type="file" name="image2" class="btn-file btn btn-primary">
//             </div>
//        </div>';

//Publish
$checked = "";
if(@$data['publish']=='1'){$checked='checked';}
echo '<div class="form-group">
<label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Publish']) .'</label>
<div class="col-sm-10  col-md-9">
<div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Publish']) .'" data-off-label="'. _uc($_e['Draft']) .'">
<input type="checkbox" name="publish" value="1" '.$checked.'>
</div>
</div>
</div>';

//echo '<input type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary"/>';
echo '<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">'. _uc($_e['SAVE']) .'</button>';

echo "</div>
</form>";

$this->functions->includeOnceCustom(ADMIN_FOLDER."/menu/classes/menu.class.php");
$menuC  =   new webMenu();
$menuC->menuWidgetLinks();
}
}
?>