<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class icons extends object_class{
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
$_w['Icons Management'] = '' ;
//IconsEdit.php
$_w['Manage Icons'] = '' ;

//Icons.php
$_w['Active Icons'] = '' ;
$_w['Draft'] = '' ;
$_w['Sort Icons'] = '' ;
$_w['Add New Icon'] = '' ;
$_w['Delete Fail Please Try Again.'] = '' ;
$_w['There is an error, Please Refresh Page and Try Again'] = '' ;
$_w['SNO'] = '' ;
$_w['TITLE'] = '' ;
$_w['IMAGE'] = '' ;
$_w['ACTION'] = '' ;

$_w['Image File Error'] = '' ;
$_w['Image Not Found'] = '' ;
$_w['Icons'] = '' ;
$_w['Added'] = '' ;
$_w['Icon Add Successfully'] = '' ;
$_w['Icon Add Failed'] = '' ;
$_w['Icon Update Failed'] = '' ;
$_w['Icon Update Successfully'] = '' ;
$_w['Update'] = '' ;
$_w['Icon Title'] = '' ;
$_w['Icon Link'] = '' ;
$_w['Short Desc'] = '' ;
$_w['Image Recommended Size : {{size}}px'] = '' ;
$_w['Publish'] = '' ;
$_w['Layer'] = '' ;
$_w['Description'] = '' ;


$_w['SAVE'] = '' ;
$_w['Old Icon Image'] = '' ;

$_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin Icons');

}


public function iconsView(){
$sql  = "SELECT id, icon_heading,image FROM icons WHERE publish='1' ORDER BY ID DESC";
$data =  $this->dbF->getRows($sql);
$this->iconsPrint($data);
}

public function iconsDraft(){
$sql  = "SELECT id, icon_heading,image FROM icons WHERE publish='0' ORDER BY ID DESC";
$data =  $this->dbF->getRows($sql);
$this->iconsPrint($data);
}

public function iconsPrint($data){
global $_e;
$class = 'tableIBMS';
$heading = true;
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
<td>$i</td>

";

if($heading){
@$icon_heading = unserialize($val['icon_heading']);
@$icon_heading = $icon_heading[$defaultLang];
echo "<td>$icon_heading</td>";
}

@$image    =   unserialize($val['image']);
@$image    =   $this->functions->addWebUrlInLink($image[$defaultLang]);

echo "
<td><img src='$image' style='max-height:200px;max-with:500px;'/></td>
<td>
<div class='btn-group btn-group-sm'>
<a data-id='$id' href='-setting?page=edit&iconId=$id' class='btn'>
<i class='glyphicon glyphicon-edit'></i>
</a>
<a data-id='$id' onclick='deleteIcon(this);' class='btn'>
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

public function IconsAddSubmit(){
global $_e;
if(isset($_POST['submit'])){
if(!$this->functions->getFormToken('newIcon')){return false;}

$heading        = empty($_POST['icon_heading'])   ? ""    : serialize($_POST['icon_heading']);
$short_desc     = empty($_POST['icon_shrtDesc'])  ? ""    : serialize($_POST['icon_shrtDesc']);
$publish        = empty($_POST['publish'])          ? "0"   : $_POST['publish'];
$image         = empty($_POST['image'])          ? ""    : ($_POST['image']);


$image         = serialize($this->functions->removeWebUrlFromLink($image));


try{
$this->db->beginTransaction();

$sql      =   "INSERT INTO `icons`(
`icon_heading`, `icon_shrtDesc`,`image`,`publish`)
VALUES (?,?,?,?)";

$array   = array($heading,$short_desc,$image,$publish);
$this->dbF->setRow($sql,$array,false);
$lastId = $this->dbF->rowLastId;

$this->db->commit();
if($this->dbF->rowCount>0){
$this->functions->notificationError(_uc($_e['Icons']),($_e['Icon Add Successfully']),'btn-success');
$this->functions->setlog(_uc($_e['Added']),_uc($_e['Icons']),$lastId,($_e['Icon Add Successfully']));
}else{
$this->functions->notificationError(_uc($_e['Icons']),($_e['Icon Add Failed']),'btn-danger');
}
}catch (Exception $e){
$this->db->rollBack();
$this->dbF->error_submit($e);
$this->functions->notificationError(_uc($_e['Icons']),($_e['Icon Add Failed']),'btn-danger');
}
} // If end
}




public function iconsEditSubmit(){
global $_e;
if(isset($_POST['submit'])){
if(!$this->functions->getFormToken('editIcon')){return false;}

$heading        = empty($_POST['icon_heading'])   ? ""    : serialize($_POST['icon_heading']);
$short_desc     = empty($_POST['icon_shrtDesc'])  ? ""    : serialize($_POST['icon_shrtDesc']);
$publish        = empty($_POST['publish'])          ? "0"   : $_POST['publish'];
$image         = empty($_POST['image'])          ? ""    : ($_POST['image']);

$image         = serialize($this->functions->removeWebUrlFromLink($image));


try{
$this->db->beginTransaction();
$lastId   =   $_POST['editId'];

$sql    =  "UPDATE `icons` SET
`icon_heading`=?,
`icon_shrtDesc`=?,
`image`=?,
`publish`=?
WHERE id = '$lastId'
";

$array   = array($heading, $short_desc,$image,$publish);
$this->dbF->setRow($sql,$array,false);

$this->db->commit();
if($this->dbF->rowCount>0){
$this->functions->notificationError(_uc($_e['Icons']),($_e['Icon Update Successfully']),'btn-success');
$this->functions->setlog(_uc($_e['Update']),_uc($_e['Icons']),$lastId,($_e['Icon Update Successfully']));
}else{
$this->functions->notificationError(_uc($_e['Icons']),($_e['Icon Update Failed']),'btn-danger');
}
}catch (Exception $e){
$this->db->rollBack();
$this->dbF->error_submit($e);
$this->functions->notificationError(_uc($_e['Iconss']),($_e['Icons Update Failed']),'btn-danger');
}

}
}

public function newIconsAdd(){
global $_e;
$this->iconsEdit(true);
}

public function iconsEdit($new=false){
global $_e;
if($new){
$token       = $this->functions->setFormToken('newIcon',false);
}else {
$id = $_GET['iconId'];
$sql = "SELECT * FROM icons where id = ? ";
$data = $this->dbF->getRow($sql,array($id));

$token = $this->functions->setFormToken('editIcon', false);
$token .= '<input type="hidden" name="editId" value="'.$id.'"/>';
}

//No need to remove any thing,, go in developer setting table and set 0

echo '<form method="post" action="-setting?page=icons" class="form-horizontal" role="form" enctype="multipart/form-data">'.
$token.
'
<div class="form-horizontal">';

$lang = $this->functions->IbmsLanguages();
if($lang != false){
$lang_nonArray = implode(',', $lang);
}

echo '<input type="hidden" name="lang" value="'.$lang_nonArray.'" />';

echo '<div class="panel-group" id="accordion">';


@$icon_heading = unserialize($data['icon_heading']);
@$icon_shrtDesc =  unserialize($data['icon_shrtDesc']);
@$image = unserialize($data['image']);


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

$image0 = empty($image[$lang[$i]]) ? "" : $this->functions->addWebUrlInLink(@$image[$lang[$i]]);
echo '<div class="form-group">
<label class="col-sm-2 col-md-3  control-label"></label>
<div class="col-sm-10  col-md-9 ">
<img src="'.$image0.'" class="layer0 kcFinderImage"/>
</div>
</div>';

echo '<div class="form-group">
<label class="col-sm-2 col-md-3  control-label">Icon Image</label>
<div class="col-sm-10  col-md-9">
<div class="input-group">
<input type="url"  name="image['.$lang[$i].']" value="'.$image0.'" class="layer0 form-control" placeholder="">
<div class="input-group-addon pointer " onclick="'."openKCFinderImageWithImg('layer0')".'"><i class="glyphicon glyphicon-picture"></i></div>
</div>
</div>
</div>';


echo '<div class="form-group">
<label class="col-sm-2 col-md-3  control-label">'. _uc($_e['TITLE']) .'</label>
<div class="col-sm-10  col-md-9">
<input type="text" name="icon_heading['.$lang[$i].']" value="'.@$icon_heading[$lang[$i]].'" class="form-control" placeholder="'. _uc($_e['Icon Title']) .'">
</div>
</div>';


//Short Desc

echo '<div class="form-group">
<label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Short Desc']) .'</label>
<div class="col-sm-10  col-md-9">
<textarea name="icon_shrtDesc['.$lang[$i].']" id="icon_shrtDesc" maxlength="500" class=" form-control" placeholder="'. _uc($_e['Short Desc']) .'">'.@$icon_shrtDesc[$lang[$i]].'</textarea>
</div>
</div>';









echo '           </div> <!-- panel-body end -->
</div> <!-- collapse end-->
</div><!-- panel end-->';
}

echo '</div> <!-- .accordian end -->';



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