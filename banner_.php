<?php
include_once("global.php");
global $webClass;
global $menuClass;
global $functions;
global $_e;
global $menu;
global $db;
?>
<?php 
$bannersData    =   $webClass->web_banners();
$banners = '';
$banners1 = '';
$bannerscount = 1;
foreach($bannersData as $val){
$title  =   $val['title'];
$text   =   $val['text'];
$link   =   $val['link'];
$image  =   $val['layer0'];
$image1  =   $val['layer1'];
$image2  =   $val['layer2'];
$image3  =   $val['layer3'];
$banners .= '

<li>


<img src="'.$image.'" alt="">
<div class="content wow slideInLeft">
<h2>'.$title.'</h2>
<h1>'.$image2.'</h1>
<h4>'.$image3.'</h4>
<div class="content_txt">
'.$text.'
</div>
';







if($link){


$banners .= '

<a href="'.$link.'" class="slider_btn">'.$image1.'</a>
</div>

';

}





$banners .= '


</li>





';



$banners1 .= '

<li> <a href="#">'.$bannerscount.'</a></li>





';

$bannerscount ++;


}



$banners .= '
</li>
</ul>
<div class="pager">
<ul id="slide-pager">
'.$banners1.'
</ul>
</div>';
echo $banners;   ?>
