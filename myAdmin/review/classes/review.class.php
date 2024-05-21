<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class review extends object_class{
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
$_w['Reviews Management'] = '' ;
//bannersEdit.php
$_w['Manage Reviews'] = '' ;

//banners.php
$_w['Active Reviews'] = '' ;
$_w['Draft'] = '' ;
$_w['Sort Reviews'] = '' ;
$_w['Add New Review'] = '' ;
$_w['Delete Fail Please Try Again.'] = '' ;
$_w['There is an error, Please Refresh Page and Try Again'] = '' ;
$_w['SNO'] = '' ;
$_w['LINK'] = '' ;
$_w['IMAGE'] = '' ;
$_w['ACTION'] = '' ;

$_w['Image File Error'] = '' ;
$_w['Image Not Found'] = '' ;
$_w['Reviews'] = '' ;
$_w['Added'] = '' ;
$_w['Review Add Successfully'] = '' ;
$_w['Review Add Failed'] = '' ;
$_w['Review Update Failed'] = '' ;
$_w['Review Update Successfully'] = '' ;
$_w['Update'] = '' ;
$_w['Review Title'] = '' ;
$_w['Review Link'] = '' ;
$_w['Short Desc'] = '' ;
$_w['Image Recommended Size : {{size}}px'] = '' ;
$_w['Publish'] = '' ;
$_w['Layer'] = '' ;
$_w['Description'] = '' ;


$_w['SAVE'] = '' ;
$_w['Old Review Image'] = '' ;

$_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin Reviews');

}


public function reviewView(){
$sql  = "SELECT id, review_img,review_link FROM review WHERE publish='1' ORDER BY ID DESC";
$data =  $this->dbF->getRows($sql);
$this->reviewsPrint($data);
}


public function reviewsPrint($data){
global $_e;

$class=" dTable tableIBMS";

echo '<div class="table-responsive">
<table class="table table-hover '.$class.'">
<thead>
<th>'. _u($_e['SNO']) .'</th>';

echo        '<th>'. _u($_e['LINK']) .'</th>';

echo            '<th>'. _u($_e['IMAGE']) .'</th>
<th>'. _u($_e['ACTION']) .'</th>
</thead>
<tbody>';

$i = 0;

foreach($data as $val){
$i++;
$id = $val['id'];
echo "<tr>
<td>$i</td>";

@$review_link = $val['review_link'];
echo "<td>$review_link</td>";


@$image    =   $val['review_img'];


echo "
<td><img src='$image' style='max-height:200px;max-with:500px;'/></td>
<td>
<div class='btn-group btn-group-sm'>
<a data-id='$id' href='-review?page=edit&reviewId=$id' class='btn'>
<i class='glyphicon glyphicon-edit'></i>
</a>
<a data-id='$id' onclick='deleteReview(this);' class='btn'>
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


public function newReviewsAdd(){
global $_e;
if(isset($_POST['submit'])){
if(!$this->functions->getFormToken('newReview')){return false;}

$image         = empty($_POST['rev_img'])          ? ""    : $_POST['rev_img'];
$link           = empty($_POST['review_link'])      ? ""    : $_POST['review_link'];
$publish        = empty($_POST['publish'])          ? "0"   : $_POST['publish'];



try{
$this->db->beginTransaction();

$sql      =   "INSERT INTO `review`(
`review_img`, `review_link`,`publish`)
VALUES (?,?,?)";

$array   = array($image,$link,$publish);
$this->dbF->setRow($sql,$array,false);
$lastId = $this->dbF->rowLastId;

$this->db->commit();
if($this->dbF->rowCount>0){
$this->functions->notificationError(_uc($_e['Reviews']),($_e['Review Add Successfully']),'btn-success');
$this->functions->setlog(_uc($_e['Added']),_uc($_e['Reviews']),$lastId,($_e['Review Add Successfully']));
}else{
$this->functions->notificationError(_uc($_e['Reviews']),($_e['Review Add Failed']),'btn-danger');
}
}catch (Exception $e){
$this->db->rollBack();
$this->dbF->error_submit($e);
$this->functions->notificationError(_uc($_e['Reviews']),($_e['Review Add Failed']),'btn-danger');
}
} // If end
}




public function reviewsEditSubmit(){
global $_e;

if(isset($_POST['submit'])){
    
if(!$this->functions->getFormToken('editReview')){return false;}

$image         = empty($_POST['rev_img'])          ? ""    : $_POST['rev_img'];
$link           = empty($_POST['review_link'])      ? ""    : $_POST['review_link'];
$publish        = empty($_POST['publish'])          ? "0"   : $_POST['publish'];

try{
$this->db->beginTransaction();
$lastId   =   $_POST['editId'];

$sql    =  "UPDATE `review` SET
`review_img`=?,
`review_link`=?,
`publish`=?
WHERE id = '$lastId'
";

$array   = array($image, $link, $publish);
$this->dbF->setRow($sql,$array,false);

$this->db->commit();
if($this->dbF->rowCount>0){
$this->functions->notificationError(_uc($_e['Reviews']),($_e['Review Update Successfully']),'btn-success');
$this->functions->setlog(_uc($_e['Update']),_uc($_e['Reviews']),$lastId,($_e['Review Update Successfully']));
}else{
$this->functions->notificationError(_uc($_e['Reviews']),($_e['Review Update Failed']),'btn-danger');
}
}catch (Exception $e){
$this->db->rollBack();
$this->dbF->error_submit($e);
$this->functions->notificationError(_uc($_e['Reviews']),($_e['Review Update Failed']),'btn-danger');
}

}
}



public function reviewsNew(){
global $_e;
$this->reviewsEdit(true);
}



public function reviewsEdit($new=false){
global $_e;
if($new){

$token       = $this->functions->setFormToken('newReview',false);
}else {
$id = $_GET['reviewId'];
$sql = "SELECT * FROM review where id = ? ";
$data = $this->dbF->getRow($sql,array($id));

$token = $this->functions->setFormToken('editReview', false);
$token .= '<input type="hidden" name="editId" value="'.$id.'"/>';
}

$size = $this->functions->developer_setting('review_img_size');
//No need to remove any thing,, go in developer setting table and set 0

echo '<form method="post" action="-review?page=review" class="form-horizontal" role="form" enctype="multipart/form-data">'.
$token.
'
<div class="form-horizontal">';

$lang = $this->functions->IbmsLanguages();
if($lang != false){
$lang_nonArray = implode(',', $lang);
}

echo '<input type="hidden" name="lang" value="'.$lang_nonArray.'" />';

echo '<div class="panel-group" id="accordion">';


// @$banner_heading = unserialize($data['banner_heading']);
// @$banner_shrtDesc =  unserialize($data['banner_shrtDesc']);
// @$layer0 = unserialize($data['layer0']);
// @$layer1 = unserialize($data['layer1']);
// @$layer2 = unserialize($data['layer2']);
// @$layer3 = unserialize($data['layer3']);

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



//banner_layer0

$image = $data['review_img'];

echo '<div class="form-group">
<label class="col-sm-2 col-md-3  control-label"></label>
<div class="col-sm-10  col-md-9 ">
<img src="'.$image.'" class="layer0 kcFinderImage"/>
</div>
</div>';

echo '<div class="form-group">
<label class="col-sm-2 col-md-3  control-label">'. _replace('{{size}}',$size,$_e['Image Recommended Size : {{size}}px']) .'</label>
<div class="col-sm-10  col-md-9">
<div class="input-group">
<input type="url"  name="rev_img" value="'.@$image.'" class="layer0 form-control" placeholder="">
<div class="input-group-addon pointer " onclick="'."openKCFinderImageWithImg('layer0')".'"><i class="glyphicon glyphicon-picture"></i></div>
</div>
</div>
</div>';



echo '           </div> <!-- panel-body end -->
</div> <!-- collapse end-->
</div><!-- panel end-->';
}

echo '</div> <!-- .accordian end -->';


//Link

@$link = $data['review_link'];
// @$link   = $this->functions->addWebUrlInLink($link);

echo '
<div class="form-group">
<label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Review Link']) .'</label>
<div class="col-sm-10  col-md-9">
<div class="input-group">
<input type="url" value="'.@$link.'" name="review_link" class="pastLinkHere form-control" placeholder="'. _uc($_e['Review Link']) .'">
<div class="input-group-addon linkList pointer"><i class="glyphicon glyphicon-search"></i></div>
</div>
</div>
</div>

';


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