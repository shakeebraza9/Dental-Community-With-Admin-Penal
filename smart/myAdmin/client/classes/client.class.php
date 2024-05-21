<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class client extends object_class{
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
$_w['Clients Slider Management'] = '' ;
//clientEdit.php
$_w['Manage Clients Slider'] = '' ;

//client.php
$_w['Active Clients Slider'] = '' ;
$_w['Draft'] = '' ;
$_w['Sort Clients Slider'] = '' ;
$_w['Add New Clients Slider'] = '' ;
$_w['Delete Fail Please Try Again.'] = '' ;
$_w['There is an error, Please Refresh Page and Try Again'] = '' ;
$_w['SNO'] = '' ;
$_w['TITLE'] = '' ;
$_w['IMAGE'] = '' ;
$_w['ACTION'] = '' ;

$_w['Image File Error'] = '' ;
$_w['Image Not Found'] = '' ;
$_w['Clients Slider'] = '' ;
$_w['Added'] = '' ;
$_w['Clients Slider Add Successfully'] = '' ;
$_w['Clients Slider Add Failed'] = '' ;
$_w['Clients Slider Update Failed'] = '' ;
$_w['Clients Slider Update Successfully'] = '' ;
$_w['Update'] = '' ;
$_w['Clients Slider Title'] = '' ;
$_w['Clients Slider Link'] = '' ;
$_w['Short Desc'] = '' ;
$_w['Image Recommended Size : {{size}}'] = '' ;
$_w['Publish'] = '' ;

$_w['SAVE'] = '' ;
$_w['Old Clients Slider Image'] = '' ;
$_w['Heading'] = '' ;
$_w['Sub Heading'] = '' ;
$_w['Image Caption'] = '' ;
$_w['Image Recommended Size : 158px X 83px'] = '' ;
$_w['Title'] = '' ;
$_w['Clients Slider Management'] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;
$_w[''] = '' ;

$_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin Awards & Memberships');

}


public function clientSort(){
echo '<div class="table-responsive sortDiv">
<div class="container-fluid activeSort">';
$sql ="SELECT client_title,image,id FROM `client` WHERE publish = '1' ORDER BY sort ASC";
$data = $this->dbF->getRows($sql);

$defaultLang = $this->functions->AdminDefaultLanguage();
foreach($data as $val){
$id = $val['id'];
$image = $val['image'];
@$title = unserialize($val['client_title']);
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


public function clientView(){
$sql  = "SELECT id, client_title,image FROM client WHERE publish='1' ORDER BY ID DESC";
$data =  $this->dbF->getRows($sql);
$this->clientPrint($data);
}

public function clientDraft(){
$sql  = "SELECT id, client_title,image FROM client WHERE publish='0' ORDER BY ID DESC";
$data =  $this->dbF->getRows($sql);
$this->clientPrint($data);
}

public function clientPrint($data){
global $_e;
$class=" dTableFull tableIBMS";
$heading = true;
if($this->functions->developer_setting('client_heading')=='1'){
$class=" dTableFull tableIBMS";
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
@$client_heading = unserialize($val['client_title']);
@$client_heading = $client_heading[$defaultLang];
echo "  <td>$client_heading</td>";
}
echo "
<td><img src='../images/$val[image]' style='max-height:200px;max-with:500px;'/></td>
<td>
<div class='btn-group btn-group-sm'>
<a data-id='$id' href='-client?page=edit&clientId=$id' class='btn'>
<i class='glyphicon glyphicon-edit'></i>
</a>
<a data-id='$id' onclick='deleteclient(this);' class='btn'>
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

public function newclientAdd(){
global $_e;
if(isset($_POST['submit']) && !empty($_FILES['image']['name'])){
if(!$this->functions->getFormToken('newclient')){return false;}

$title        = empty($_POST['client_title'])   ? ""    : serialize($_POST['client_title']);
$heading        = empty($_POST['client_heading'])   ? ""    : serialize($_POST['client_heading']);
$sheading        = empty($_POST['client_sheading'])   ? ""    : serialize($_POST['client_sheading']);
$caption        = empty($_POST['client_caption'])   ? ""    : serialize($_POST['client_caption']);
$duration     = empty($_POST['duration'])  ? ""    : serialize($_POST['duration']);
$delegates     = empty($_POST['delegates'])  ? ""    : serialize($_POST['delegates']);
$certificates     = empty($_POST['certificates'])  ? ""    : serialize($_POST['certificates']);
$availability     = empty($_POST['availability'])  ? ""    : serialize($_POST['availability']);
$link           = empty($_POST['client_link'])      ? ""    : $_POST['client_link'];
$short_desc     = empty($_POST['client_shrtDesc'])  ? ""    : serialize($_POST['client_shrtDesc']);
$publish        = empty($_POST['publish'])     ? "0"   : $_POST['publish'];
$file           = empty($_FILES['image']['name'])   ? false    : true;
$returnImage = "";
try{
$this->db->beginTransaction();

$sql      =   "INSERT INTO `client`(
`client_link`,`client_heading`,`client_title`,`client_sheading`,`client_caption`,`client_shrtDesc`,`duration`,`delegates`,`certificates`,`availability`,`image`,`publish`)
VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

if($file){
$returnImage =  $this->functions->uploadSingleImage($_FILES['image'],'Clients Slider');
if($returnImage==false){
throw new Exception(($_e['Image File Error']));
}
}else{
throw new Exception(($_e["Image Not Found"]));
}

$array   = array($link,$heading,$title,$sheading,$caption,$short_desc,$duration,$delegates,$certificates,$availability,$returnImage,$publish);
$this->dbF->setRow($sql,$array,false);
$lastId = $this->dbF->rowLastId;

$this->db->commit();
if($this->dbF->rowCount>0){
$this->functions->notificationError(_uc('Course'),('Course Add Successfully'),'btn-success');
$this->functions->setlog(_uc($_e['Added']),_uc('Course'),$lastId,('Course Add Successfully'));
}else{
$this->functions->notificationError(_uc('Course'),('Course Add Failed'),'btn-danger');
}
}catch (Exception $e){
if($returnImage!==false && $file){
$this->functions->deleteOldSingleImage($returnImage);
}
$this->db->rollBack();
$this->dbF->error_submit($e);
$this->functions->notificationError(_uc('Course'),('Course Add Failed'),'btn-danger');
}
} // If end
}




public function clientEditSubmit(){
global $_e;
if(isset($_POST['submit']) && isset($_POST['editId'])){
if(!$this->functions->getFormToken('editclient')){return false;}

$title        = empty($_POST['client_title'])   ? ""    : serialize($_POST['client_title']);
$heading        = empty($_POST['client_heading'])   ? ""    : serialize($_POST['client_heading']);
$sheading        = empty($_POST['client_sheading'])   ? ""    : serialize($_POST['client_sheading']);
$caption        = empty($_POST['client_caption'])   ? ""    : serialize($_POST['client_caption']);
$link           = empty($_POST['client_link'])      ? ""    : $_POST['client_link'];
$short_desc     = empty($_POST['client_shrtDesc'])  ? ""    : serialize($_POST['client_shrtDesc']);
$duration     = empty($_POST['duration'])  ? ""    : serialize($_POST['duration']);
$delegates     = empty($_POST['delegates'])  ? ""    : serialize($_POST['delegates']);
$certificates     = empty($_POST['certificates'])  ? ""    : serialize($_POST['certificates']);
$availability     = empty($_POST['availability'])  ? ""    : serialize($_POST['availability']);
$publish        = empty($_POST['publish'])     ? "0"   : $_POST['publish'];
$file           = empty($_FILES['image']['name'])   ? false    : true;
$returnImage = "";

$oldImg      = empty($_POST['oldImg'])     ? ""   : $_POST['oldImg'];
$returnImage = $oldImg;
try{
$this->db->beginTransaction();
$lastId   =   $_POST['editId'];

if($file){
$this->functions->deleteOldSingleImage($oldImg);
$returnImage =  $this->functions->uploadSingleImage($_FILES['image'],'Clients Slider');
if($returnImage==false){
throw new Exception(($_e['Image File Error']));
}
}

$sql    =  "UPDATE `client` SET
`client_link`=?,
`client_heading`=?,
`client_title`=?,
`client_sheading`=?,
`client_caption`=?,
`client_shrtDesc`=?,
`duration`=?,
`delegates`=?,
`certificates`=?,
`availability`=?,
`image`=?,
`publish`=?
WHERE id = '$lastId'
";

$array   = array($link,$heading,$title,$sheading,$caption,$short_desc,$duration,$delegates,$certificates,$availability,$returnImage,$publish);
$this->dbF->setRow($sql,$array,false);

$this->db->commit();
if($this->dbF->rowCount>0){
$this->functions->notificationError(_uc('Course'),('Course Update Successfully'),'btn-success');
$this->functions->setlog(_uc($_e['Update']),_uc('Course'),$lastId,('Course Update Successfully'));
}else{
$this->functions->notificationError(_uc('Course'),'Course Update failed','btn-danger');
}
}catch (Exception $e){
if($returnImage!==false && $file){
$this->functions->deleteOldSingleImage($returnImage);
}
$this->db->rollBack();
$this->dbF->error_submit($e);
$this->functions->notificationError(_uc('Course'),('Course Update failed'),'btn-danger');
}

}
}

public function clientNew(){
global $_e;
$this->clientEdit(true);
}

public function clientEdit($new=false){
global $_e;
if($new){
$token       = $this->functions->setFormToken('newclient',false);
}else {
$id = $_GET['clientId'];
$sql = "SELECT * FROM client where id = ? ";
$data = $this->dbF->getRow($sql,array($id));

$token = $this->functions->setFormToken('editclient', false);
$token .= '<input type="hidden" name="editId" value="'.$id.'"/>';
}
//No need to remove any thing,, go in developer setting table and set 0

echo '<form method="post" action="-client?page=client" class="form-horizontal" role="form" enctype="multipart/form-data">'.
$token.
'
<div class="form-horizontal">';

$lang = $this->functions->IbmsLanguages();
if($lang != false){
$lang_nonArray = implode(',', $lang);
}

echo '<input type="hidden" name="lang" value="'.$lang_nonArray.'" />';

echo '<div class="panel-group" id="accordion">';


@$client_heading = unserialize($data['client_heading']);
@$client_title = unserialize($data['client_title']);
@$client_sheading = unserialize($data['client_sheading']);
@$client_caption = unserialize($data['client_caption']);
@$client_shrtDesc =  unserialize($data['client_shrtDesc']);
@$duration =  unserialize($data['duration']);
@$delegates =  unserialize($data['delegates']);
@$certificates =  unserialize($data['certificates']);
@$availability =  unserialize($data['availability']);

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
<label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Title']) .'</label>
<div class="col-sm-10  col-md-9">
<input type="text" name="client_title['.$lang[$i].']" value="'.@$client_title[$lang[$i]].'" class="form-control" placeholder="'. _uc($_e['Title']) .'">
</div>
</div>';

// Heading    
echo '<div class="form-group">
        <label class="col-sm-2 col-md-3  control-label">Short Desc</label>
        <div class="col-sm-10  col-md-9">
        <textarea name="client_sheading['.$lang[$i].']" id="client_sheading"  class="form-control ckeditor" placeholder="'. _uc($_e['Short Desc']) .'">'.@$client_sheading[$lang[$i]].'</textarea>
        </div>
    </div>';




//Image Caption    
// echo '<div class="form-group">
//         <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Image Caption']) .'</label>
//         <div class="col-sm-10  col-md-9">
//             <input type="text" name="client_caption['.$lang[$i].']" value="'.@$client_caption[$lang[$i]].'" class="form-control" placeholder="'. _uc($_e['Image Caption']) .'">
//         </div>
//     </div>';         


//Short Desc

echo '<div class="form-group">
<label class="col-sm-2 col-md-3  control-label">Desc</label>
<div class="col-sm-10  col-md-9">
<textarea name="client_shrtDesc['.$lang[$i].']" id="client_shrtDesc"  class="form-control ckeditor" placeholder="'. _uc($_e['Short Desc']) .'">'.@$client_shrtDesc[$lang[$i]].'</textarea>
</div>
</div>';

//Sub Heading    
echo '<div class="form-group">
        <label class="col-sm-2 col-md-3  control-label">Duration</label>
        <div class="col-sm-10  col-md-9">
            <input type="text" name="duration['.$lang[$i].']" value="'.@$duration[$lang[$i]].'" class="form-control" placeholder="Duration">
        </div>
    </div>';

//Sub Heading    
echo '<div class="form-group">
        <label class="col-sm-2 col-md-3  control-label">Delegates</label>
        <div class="col-sm-10  col-md-9">
            <input type="text" name="delegates['.$lang[$i].']" value="'.@$delegates[$lang[$i]].'" class="form-control" placeholder="Delegates">
        </div>
    </div>';

//Sub Heading    
echo '<div class="form-group">
        <label class="col-sm-2 col-md-3  control-label">Certificates</label>
        <div class="col-sm-10  col-md-9">
            <input type="text" name="certificates['.$lang[$i].']" value="'.@$certificates[$lang[$i]].'" class="form-control" placeholder="Certificates">
        </div>
    </div>';

//Sub Heading    
echo '<div class="form-group">
        <label class="col-sm-2 col-md-3  control-label">Availability</label>
        <div class="col-sm-10  col-md-9">
            <input type="text" name="availability['.$lang[$i].']" value="'.@$availability[$lang[$i]].'" class="form-control" placeholder="Avialability">
        </div>
    </div>';

//Sub Heading    
echo '<div class="form-group">
        <label class="col-sm-2 col-md-3  control-label">Link Text</label>
        <div class="col-sm-10  col-md-9">
            <input type="text" name="client_heading['.$lang[$i].']" value="'.@$client_heading[$lang[$i]].'" class="form-control" placeholder="Link Text">
        </div>
    </div>';



echo '           </div> <!-- panel-body end -->
</div> <!-- collapse end-->
</div><!-- panel end-->';
}

echo '</div> <!-- .accordian end -->';


//Link
@$link = $data['client_link'];
@$link   = $this->functions->addWebUrlInLink($link);

echo '<div class="form-group">
<label class="col-sm-2 col-md-3  control-label">'. _uc('Link') .'</label>
<div class="col-sm-10  col-md-9">
<div class="input-group">
<input type="url" value="'.$link.'" name="client_link" class="pastLinkHere form-control" placeholder="'. _uc('Link') .'">
<div class="input-group-addon linkList pointer"><i class="glyphicon glyphicon-search"></i></div>
</div>
</div>
</div>';


//client
$size = $this->functions->developer_setting('client_size');
$img = "";
if(@$data['image']!=''){
$img=$data['image'];
echo "<input type='hidden' name='oldImg' value='$img' />";
echo '<div class="form-group">
<label  class="col-sm-2 col-md-3  control-label">'. _uc('Old Image') .'</label>
<div class="col-sm-10  col-md-9">
<img src="../images/'.$img.'" style="max-height:250px;" >
</div>
</div>';
}

echo '<div class="form-group">
<label  class="col-sm-2 col-md-3  control-label">Image Recommended Size : 791 px X 461 px</label>
<div class="col-sm-10  col-md-9">
<input type="file" name="image" class="btn-file btn btn-primary">
</div>
</div>';

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

echo '<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">'. _uc($_e['SAVE']) .'</button>';

echo "</div>
</form>";

$this->functions->includeOnceCustom(ADMIN_FOLDER."/menu/classes/menu.class.php");
$menuC  =   new webMenu();
$menuC->menuWidgetLinks();
}
}
?>