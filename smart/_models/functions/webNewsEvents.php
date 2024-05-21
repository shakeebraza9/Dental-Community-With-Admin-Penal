<?php



class web_news extends  object_class

{

public $webClass;

function __construct()

{

parent::__construct('3');

$this->webClass =   $GLOBALS['webClass'];



/**

* MultiLanguage keys Use where echo;

* define this class words and where this class will call

* and define words of file where this class will called

**/

global $_e;

$_w=array();

$_w['Read More..'] = '';

$_w['Show All News'] = '';

$_e    =   $this->dbF->hardWordsMulti($_w,currentWebLanguage(),'Website News');

}





public function newsSlide(){

global $_e;

// $today  = date('Y-m-d');

$sql    = "SELECT * FROM news WHERE publish = '1' ORDER BY `date` ";

$data   =  $this->dbF->getRows($sql);



$temp = '';

foreach($data as $key=>$val){

// $date       = date('d/m/Y',strtotime($val['date']));

// $heading    = translateFromSerialize($val['heading']);

$shortDesc  = translateFromSerialize($val['shortDesc']);

// $dsc        = translateFromSerialize($val['dsc']);

// $imageR     = ($val['image']);

// $comment    = $val['comment'];

// $publishDate    = date('d-m-Y',strtotime($val['publish_date']));
// 
// $updateTime     = date('d-m-Y',strtotime($val['dateTime']));

// $id         = $val['id'];
// 
// $link       =   WEB_URL."/news?n=$id&title=$heading";



// $imageR     = $this->functions->resizeImage($val['image'],'290','175',false);



// $shortDesc = strip_tags($shortDesc);





//Print Your View Here

$temp .= "
$shortDesc ....|| ";



}



// $temp .= '</ul>';

return $temp;

}





public function newsCollapse(){

global $_e;

 global $functions;

$today  = date('Y-m-d');

$sql    = "SELECT * FROM news WHERE publish = '1' AND publish_date <= ? ORDER BY `date` ";

$data   =  $this->dbF->getRows($sql,array($today));



$temp = "<div class='mainContainerInnerPage padding_inner_content'>

<div class='container-fluid well well-sm h3'>



<h1 class='page_heading'>News</h1></div>

<div class='ContainerInnerPage'>

<div class='blogPageFull'>

<ul>

";



foreach($data as $key=>$val){

$date       = date('d/m/Y',strtotime($val['date']));

$heading    = translateFromSerialize($val['heading']);

$shortDesc  = translateFromSerialize($val['shortDesc']);

$dsc        = translateFromSerialize($val['dsc']);

// $imageR     = $val['image'];

// $image2     = WEB_URL."/images/".$imageR;



            $imageR      =   $val['image'];

            $image2      =   $functions->resizeImage($imageR,'308','265',false);







$comment    = $val['comment'];

$publishDate    = date('d-m-Y',strtotime($val['publish_date']));

$updateTime     = date('d-m-Y',strtotime($val['dateTime']));

$id         = $val['id'];

$link       =   WEB_URL."/news?n=$id&title=$heading";



$shortDesc = strip_tags($shortDesc);

// $imageDiv = "";

// if(!empty($imageR)) {

// $imageDiv = "<div class='text-center col-xs-12 '>

// <img src='$image2' class='img-responsive'/>

// </div>";

// }



//Print Your View Here

$temp .= "







<div>

<div class='slider_three_slidess'>

<div class='slider_three_img wobble-horizontal'>

<img src=".$image2." />

</div>

<div class='all_slider_text'>

<div class='slider_three_cap'>

<p>".$heading."<small>($date)</small></p>

</div>

<div class='slider_three_dis'>

<p>".$shortDesc."</p>

</div>

<div class='slider_three_read'>

<a href=".$link." class='push'>Read more...</a>

</div>

</div>

</div>

</div>

















";



}



$temp .= '

</ul>

</div>

</div>

</div>';

return $temp;

}





public function newsDetail($id){

global $_e;

$today  = date('Y-m-d');

$sql    = "SELECT * FROM news WHERE publish = '1' AND publish_date <= ? AND id = ? ORDER BY `date` ";

$data   =  $this->dbF->getRows($sql,array($today,$id));



$temp = '';

foreach($data as $key=>$val){

$date       = date('d/m/Y',strtotime($val['date']));

$heading    = translateFromSerialize($val['heading']);

$shortDesc  = translateFromSerialize($val['shortDesc']);

$dsc        = translateFromSerialize(base64_decode($val['dsc']));

$imageR     = $val['image'];

$image2     = WEB_URL."/images/".$imageR;

$comment    = $val['comment'];

$publishDate    = date('d-m-Y',strtotime($val['publish_date']));

$updateTime     = date('d-m-Y',strtotime($val['dateTime']));

$id         = $val['id'];

$link       =   WEB_URL."/news?n=$id&title=$heading";



$showAllNews = "<div class='pull-right' style='display: inline-block;'>



<a href='".WEB_URL."/news' class='btn btn-xs btn-default themeButton-xs'>



".$_e['Show All News'] ."



</a>

</div>";





$imageDiv = "";

if(!empty($imageR)) {

$imageDiv = "<div class='slider_three_img'>

<img src='$image2' class=''/>

</div>";

}



// $reviewMsg = "";

// if(@$comment=='1'){

//     $this->functions->require_once_custom('webBlog_functions');

//     $blogC = new webBlog_functions();

//     $reviewMsg = $blogC->reviewSubmit();

//     $reviews =  $blogC->reviews($id,'page',2);

//     $reviews = '<div class="pageReview container-fluid padding-0 table-bordered">'.$reviews.'</div>';

// }else{

//     $reviews = '';

// }



//Print Your View Here

$temp .= "

<div class='mainContainerInnerPage'>

<div class='container-fluid well well-sm h3'>



<h1 class='page_heading'>News heading</h1></div>

<div class='standard'>











<div class='ContainerInnerPage'>

<div class='slider_three_slidess'>

$imageDiv



<div class='all_slider_text'>

<div class='slider_three_cap'>$heading <small>($date)</small></div>

<div class='slider_three_dis'>

$dsc

</div>

</div>

$showAllNews

</div>



</div>





</div>

</div>





";



}



$temp .= '';

return $temp;

}





public function newsAll(){



}



}



?>

