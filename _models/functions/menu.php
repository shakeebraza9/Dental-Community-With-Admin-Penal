<?php
// include("global.php");

class menu extends object_class{
    public function __construct(){
        parent::__construct('3');

        global $_e;
        // global $webClass;
        $_w = array();
        $_w['More'] = '';
        $_e = $this->dbF->hardWordsMulti($_w,currentWebLanguage(),'WebMenu');


    }


       public function getBox($boxName,$textCharacters = false, $headingCharacter = false,$subHeadingCharacters = false){
        /* Will Return
            $array['heading']
            $array['heading2']
            $array['text']
            $array['link']
            $array['linkText']
            $array['image']  ;
        */

        $sql = "SELECT * FROM `box` WHERE box ='$boxName' ";
        $data = $this->dbF->getRow($sql);
        $lang = currentWebLanguage();

        $heading = translateFromSerialize($data['heading']);
        $sub_heading =  translateFromSerialize($data['sub_heading']);
        $short_desc =  translateFromSerialize($data['short_desc']);
        $linkText =  translateFromSerialize($data['linktext']);

        $heading        = ($headingCharacter!=false)?substr($heading,0,$headingCharacter)   :   $heading;
        $sub_heading    = ($subHeadingCharacters!=false)?substr($sub_heading,0,$subHeadingCharacters)   :   $sub_heading;
        $short_desc     = ($textCharacters!=false)?substr($short_desc,0,$textCharacters)    :   $short_desc;

        //Link
        $link = $data['redirect'];
        if(preg_match('@http://@i',$link) || preg_match('@https://@i',$link)){
        }else{
            $link = WEB_URL.$link;
        }

        $array = array();
        $array['heading']   = $heading;
        $array['heading2']  = $sub_heading;
        $array['text']      = $short_desc;
        $array['link']      = $link;
        $array['linkText']  = $linkText;
        $array['image']     = WEB_URL.'/images/'.$data['image'];


        return $array;
    }

    public function mobiflexMyMenule_menu($mailUlId='',$mainUlClass='',$liClass='',$aClass='',$ulSubMenuClass='',$liSubMenuClass='',$aSubMenuClass=''){
        //usage not found
        //
        $sql = "SELECT * FROM webmenu WHERE under = '0' ORDER BY sort ASC";
        $data  = $this->dbF->getRows($sql);

        if(!$this->dbF->rowCount){return false;}

        echo "<ul id='$mailUlId'>";
        $webLang = currentWebLanguage();
        foreach($data as $val){
            $id = $val['id'];
            $heading = htmlspecialchars(translateFromSerialize($val['name']));

            $link = $val['link'];
            if(preg_match('@http://@i',$link) || preg_match('@https://@i',$link)){
            }else{
                $link = WEB_URL.$link;
            }

            //get SubMenu
            $getSubMenu = $this->main_menuFindSubMenu($id,$ulSubMenuClass,$liSubMenuClass,$aSubMenuClass);
            echo "<li class='$liClass' id='$id'><a href='$link' class='$aClass'>$heading</a>
                         $getSubMenu
                  </li>";
        }
        echo "</ul>";
        $temp = <<<HTML
        <script>
            $(document).ready(function(){
                $('#$mailUlId').slicknav();
            });
        </script>

HTML;
        echo $temp;
    }


    /**
     * Format <ul><li><a>Menu</a></li</ul>
     * @return string
     */

    private $mainParentActive  = false;
    private $subParentActive = false;
    private $subMenuActive  = false;
    private $sub2MenuActive = false;
    public function main_menu($type='main',$responsive = false,$mainUlId='',$mainUlClass='',$liClass='',$aClass='',$ulSubMenuClass='',$liSubMenuClass='',$aSubMenuClass=''){
        global $_e;
        $sql = "SELECT * FROM webmenu WHERE under = '0' AND type= ? ORDER BY sort ASC";
        $data  = $this->dbF->getRows($sql,array($type));

        if(!$this->dbF->rowCount){return false;}

        //finding icon allow or not
        $types  = $this->functions->developer_setting('main_menu_type');
        $types   = explode("/",$types);
        foreach($types as $val){
            $val = explode(",",$val);
            $value = $val[0];
            if($value==$type){
                $iconAllow = $val[1];
                break;
            }
        }

        $IBMSWebMenuClass = '';
        if($type == 'main'){
            $IBMSWebMenuClass = 'IBMSWebMenu flex';
        }

        echo "<ul>";
        $webLang = currentWebLanguage();
        $defaultLang = defaultWebLanguage();
        $main_menu_icon = $iconAllow;
        foreach($data as $val){
            $id = $val['id'];
            $heading = htmlspecialchars(translateFromSerialize($val['name']));

            $link = $val['link'];
            $link = $this->functions->addWebUrlInLink($link);

            $active  = '';
            $activeLink = pageLink(false);
            if($activeLink == $link){
                $active = 'mainActive';
            }

            //get SubMenu
            $getSubMenu = $this->main_menuFindSubMenu($id,$ulSubMenuClass,$liSubMenuClass,$aSubMenuClass,$heading,$main_menu_icon);
            $hasSubMenu = ''; //Use Class Name
            $dropCaret = '';
            if($getSubMenu==false){$getSubMenu='';}else{
                if($this->subMenuActive){
                    $active = 'mainActive';
                }
                $hasSubMenu = 'hasSubMenu';
                $dropCaret = "
                                <span class='fa fa-caret-down menuDropDownCaret'></span>
                                <span class='fa fa-caret-left menuDropDownCaretMore'></span>
                                ";
            }


            $icon = '';
            if($main_menu_icon=='1'){
                $icon = $this->functions->addWebUrlInLink($val['icon']);
                if($icon==""){
                    $icon = WEB_URL."/images/blank.png";
                    $icon = 'style="background-image:url(' . "'$icon'" . ')"';
                }else{
                    $icon = 'style="background-image:url(' . "'$icon'" . ')"';
                }
            }
 // <li class="hvr-sweep-to-right"><a href="#">INVESTOR PORTAL</a></li>

            echo "<li class='hvr-sweep-to-right'>

                        <a href='$link'>$heading</a>
                        
                      </li>";
        }
        echo "</ul>";
        $temp = "
            <script>
               $(document).ready(function(){
                    setTimeout(function(){
                        $('ul.flex').flexMenu({
                            linkText:'<span>"._u($_e['More'])." </span>'
                        });
                    },500);
                });
            </script> ";

        if($responsive && $type='main'){
            $temp .= "
            <script>
                $(document).ready(function(){
                    $('.IBMSWebMenu').slicknav();
                });
            </script>";
        }
        // echo $temp;
    }

    // public function main_menu1($type='main',$responsive = false,$mainUlId='',$mainUlClass='',$liClass='',$aClass='',$ulSubMenuClass='',$liSubMenuClass='',$aSubMenuClass=''){
    //     global $_e;
    //     $sql = "SELECT * FROM webmenu WHERE under = '0' AND type='$type' ORDER BY sort ASC";
    //     $data  = $this->dbF->getRows($sql);

    //     if(!$this->dbF->rowCount){return false;}

    //     //finding icon allow or not
    //     $types  = $this->functions->developer_setting('main_menu_type');
    //     $types   = explode("/",$types);
    //     foreach($types as $val){
    //         $val = explode(",",$val);
    //         $value = $val[0];
    //         if($value==$type){
    //             $iconAllow = $val[1];
    //             break;
    //         }
    //     }

    //     $IBMSWebMenuClass = '';
    //     if($type == 'main'){
    //         $IBMSWebMenuClass = 'IBMSWebMenu flex';
    //     }

    //     //echo "<ul class='$IBMSWebMenuClass $mainUlClass' id='$mainUlId'>";
    //     $webLang = currentWebLanguage();
    //     $defaultLang = defaultWebLanguage();
    //     $main_menu_icon = $iconAllow;
    //     foreach($data as $val){
    //         $id = $val['id'];
    //         $heading = htmlspecialchars(translateFromSerialize($val['name']));

    //         $link = $val['link'];
    //         $link = $this->functions->addWebUrlInLink($link);

    //         $active  = '';
    //         $activeLink = pageLink(false);
    //         if($activeLink == $link){
    //             $active = 'mainActive';
    //         }

    //         //get SubMenu
    //         $getSubMenu = $this->main_menuFindSubMenu($id,$ulSubMenuClass,$liSubMenuClass,$aSubMenuClass,$heading,$main_menu_icon);
    //         $hasSubMenu = ''; //Use Class Name
    //         $dropCaret = '';
    //         if($getSubMenu==false){$getSubMenu='';}else{
    //             if($this->subMenuActive){
    //                 $active = 'mainActive';
    //             }
    //             $hasSubMenu = 'hasSubMenu';
    //             $dropCaret = "
    //                             <span class='fa fa-caret-down menuDropDownCaret'></span>
    //                             <span class='fa fa-caret-left menuDropDownCaretMore'></span>
    //                             ";
    //         }


    //         $icon = '';
    //         if($main_menu_icon=='1'){
    //             $icon = $this->functions->addWebUrlInLink($val['icon']);
    //             if($icon==""){
    //                 $icon = WEB_URL."/images/blank.png";
    //                 $icon = 'style="background-image:url(' . "'$icon'" . ')"';
    //             }else{
    //                 $icon = 'style="background-image:url(' . "'$icon'" . ')"';
    //             }
    //         }

    //         echo "<li class='$liClass $active $hasSubMenu menuFirstLi' id='$id'>
    //                     <a href='$link' class='$aClass' $icon><span>$heading</span> $dropCaret</a>
    //                      $getSubMenu

    //                   </li>";
    //     }
    //     //echo "</ul>";
    //     $temp = "
    //         <script>
    //            $(document).ready(function(){
    //                 setTimeout(function(){
    //                     $('ul.flex').flexMenu({
    //                         linkText:'<span>"._u($_e['More'])." </span>'
    //                     });
    //                 },500);
    //             });
    //         </script> ";

    //     if($responsive && $type='main'){
    //         $temp .= "
    //         <script>
    //             $(document).ready(function(){
    //                 $('.IBMSWebMenu').slicknav();
    //             });
    //         </script>";
    //     }
    //     //echo $temp;
    // }


    public function main_menuFindSubMenu($id,$ulSubMenuClass,$liSubMenuClass,$aSubMenuClass,$heading='',$main_menu_icon=''){
        $temp = '';
        $sql = "SELECT * FROM webmenu WHERE under = ? ORDER BY sort ASC";
        $data  = $this->dbF->getRows($sql,array($id));

        if(!$this->dbF->rowCount){return false;}

        $temp .= "<ul class='firstSubUl menu-sub $ulSubMenuClass'>";
        $webLang = currentWebLanguage();
        $defaultLang = defaultWebLanguage();
        $this->subMenuActive       = false;
        foreach($data as $val){
            $id = $val['id'];
            $heading = htmlspecialchars(translateFromSerialize($val['name']));

            $link = $val['link'];
            $link = $this->functions->addWebUrlInLink($link);


            $active  = '';

            $activeLink = pageLink(false);
            if($activeLink == $link){
                $active = 'subActive';
                $this->subMenuActive   = true;
            }

            //get SubMenu
            $getSubMenu2 = $this->main_menuFindSubMenu2($id,$ulSubMenuClass,$liSubMenuClass,$aSubMenuClass);
            $hasSubMenu2 = ''; //Use Class Name

            $dropCaret = '';
            if($getSubMenu2==false){$getSubMenu2='';}else{
                //var_dump($this->sub2MenuActive);
                if($this->sub2MenuActive){
                    $active = 'subActive';
                    $this->subMenuActive   = true;
                }
                $hasSubMenu2 = 'hasSubMenu2';
                $dropCaret = "
                                <span class='fa fa-caret-right menuDropDownCaretRight'></span>
                                 <span class='fa fa-caret-left menuDropDownCaretRightMore'></span>
                                ";
            }

            $temp .= "<li class='$liSubMenuClass $active $hasSubMenu2' id='$id'><a href='$link'  class='$aSubMenuClass'>$heading $dropCaret</a>
                            $getSubMenu2
                          </li>";
        }
        $temp .= "</ul>";
        return $temp;
    }

    public function main_menuFindSubMenu2($id,$ulSubMenuClass,$liSubMenuClass,$aSubMenuClass){
        $temp = '';
        $sql = "SELECT * FROM webmenu WHERE under = ?  ORDER BY sort ASC";
        $data  = $this->dbF->getRows($sql,array($id));

        if(!$this->dbF->rowCount){return false;}

        $temp .= "<ul class='secondSubUl $ulSubMenuClass'>";
        $webLang = currentWebLanguage();

        $defaultLang = defaultWebLanguage();
        $this->sub2MenuActive       = false;
        foreach($data as $val){
            $id = $val['id'];
            $heading = htmlspecialchars(translateFromSerialize($val['name']));

            $link = $val['link'];
            $link = $this->functions->addWebUrlInLink($link);


            $active  = '';

            $activeLink = pageLink(false);
            if($activeLink == $link){
                $active = 'sub3Active';
                $this->sub2MenuActive       = true;
            }

            $temp .= "<li class='$liSubMenuClass $active' id='$id'><a href='$link' class='$aSubMenuClass'>$heading</a></li>";

        }
        $temp .= "</ul>";
        return $temp;
    }


    /**
     * @param string $type main|top
     * @param string $under Parent Id
     * @return array
     *
    $infoMenu = $menuClass->menuTypeSingle('info');
    $infoMenu = empty($infoMenu) ? array() : $infoMenu;//stop exception
    foreach ($infoMenu as $val) {
    $text   = _u($val['name']);
    $menuId = $val['id'];
    $link   = $val['link'];
    $menuIcon = $val['icon'];

    $infoMenu2 = $menuClass->menuTypeSingle('info',$menuId);
    $infoMenu2 = empty($infoMenu2) ? array() : $infoMenu2; //stop exception
    foreach ($infoMenu2 as $val2) {
    $text   = _u($val2['name']);
    $menuId = $val2['id'];
    $link   = $val2['link'];
    $menuIcon = $val2['icon'];
    echo '<li><a href="' . $link . '" class="">' . $text . '</a></li>';
    }
    }
     */
   public function menuTypeSingle($type='main',$under='0'){
        global $_e;
        $sql = "SELECT * FROM webmenu WHERE under = '$under' AND type='$type' ORDER BY sort ASC";
        $data  = $this->dbF->getRows($sql);

        if(!$this->dbF->rowCount){return false;}
        foreach($data as $val){
            $id = $val['id'];
            $heading    = htmlspecialchars(translateFromSerialize($val['name']));
            $short_desc = htmlspecialchars(translateFromSerialize($val['short_desc']));

            $link = $val['link'];
            $link = $this->functions->addWebUrlInLink($link);

            $icon = $val['icon'];
            $icon = $this->functions->addWebUrlInLink($icon);

            $image_alt = $val['image_alt'];

            $array["$id"]['name']   = $heading;
            $array["$id"]['short_desc'] = $short_desc;
            $array["$id"]['link']   = $link;
            $array["$id"]['icon']   = $icon;
            $array["$id"]['image_alt']   = $image_alt;
            $array["$id"]['id']     = $id;
            $array["$id"]['active']= '';
            $activeLink = pageLink(false);
            if( ($activeLink) == ($link)){
                $array["$id"]['active']= '1';
            }
        }

        return $array;
    }

    /**
     * @param $id
     * @param string $where
     * @param string $type
     * @return mixed
     *
     * Find parent menu by Child menu Id
     */
    public function get_root_menu($id,$where="id",$type="main"){
        global $_e;

        $sql    = "SELECT * FROM webmenu WHERE $where = '$id' AND type='$type'";
        $data   = $this->dbF->getRow($sql);

        if(@intval($data['under']) > 0){
            return $this->get_root_menu($data['under'],"id",$type);
        }

        return $data;

    }

    /**
     * @param bool $limit
     * @param int $limitFrom
     * @param int $limitTo
     * @return array
     */
    public function footerMainSingleMenu($limit = false,$limitFrom=0,$limitTo = 2){
        if($limit==false){
            $limit = '';
        }else{
            $limit = " LIMIT $limitFrom,$limitTo";
        }
        $sql = "SELECT * FROM webfootermenu WHERE under  = '0' ORDER BY sort ASC $limit";
        $data = $this->dbF->getRows($sql);
        $webLang = currentWebLanguage();
        $defaultLang = defaultWebLanguage();
        $array = array();
        foreach($data as $val){
            $id = $val['id'];
            $heading = htmlspecialchars(translateFromSerialize($val['name']));

            $link = $val['link'];
            if(preg_match('@http://@i',$link) || preg_match('@https://@i',$link)){
            }else{
                $link = WEB_URL.$link;
            }

            $array["$id"]['menu']   = $heading;
            $array["$id"]['link']   = $link;
            $array["$id"]['id']     = $id;
        }

        return $array;
    }


    public function footerInnerMenu($parentId,$limit = false,$limitFrom=0,$limitTo = 10){
        if($limit==false){
            $limit = '';
        }else{
            $limit = " LIMIT $limitFrom,$limitTo";
        }
        $sql = "SELECT * FROM webfootermenu WHERE under  = ?  ORDER BY sort ASC $limit";
        $data = $this->dbF->getRows($sql,array($parentId));
        if(!$this->dbF->rowCount){return false;}
        $webLang = currentWebLanguage();
        $defaultLang = defaultWebLanguage();
        $array = array();
        foreach($data as $val){
            $id = $val['id'];
            $heading = htmlspecialchars(translateFromSerialize($val['name']));

            $link = $val['link'];
            if(preg_match('@http://@i',$link) || preg_match('@https://@i',$link)){
            }else{
                $link = WEB_URL.$link;
            }

            $array["$id"]['menu']   = $heading;
            $array["$id"]['link']   = $link;
            $array["$id"]['id']     = $id;
        }

        return $array;

    }





    public function footerAllMenu()
    {
        $footerMenu = $this->footerMainSingleMenu();
        if(empty($footerMenu)){
            return false;
        }
        foreach ($footerMenu as $val) {
            $text = ($val['menu']);
            $footerMenuId = $val['id'];
            $FooterLink = $val['link'];

                // echo '<li><a href="' . $FooterLink . '" class="hvr-underline-from-center">' . $text . '</a></li>';



echo '
<div class="footer_link1">
<h3>'.$text.'</h3>

<ul>
';


          $footerMenu2 = $this->footerInnerMenu($footerMenuId);
            if(empty($footerMenu2)){
                // echo '
                //         ';
               // continue;
            }
            foreach ($footerMenu2 as $val2) {
                $text = ($val2['menu']);
                $footerMenuId = $val2['id'];
                $FooterLink = $val2['link'];
                // echo '<li><a href="' . $FooterLink . '" class="sliding-u-t-b">' . $text . '</a></li>';



                echo '<li><span><img src="webImages/btn5.png" alt=""></span>

<a href="' . $FooterLink . '" class="">' . $text . '</a></li>';



            }
echo '</ul>

</div>
';


  

     }
    }






// public function footerAllMenu()
// {

// global $functions;

// $footerMenu = $this->footerMainSingleMenu();

// if(empty($footerMenu)){

// return false;

// }

// $count = 0;

// $h3 ="";

// $add_div = "";

// $ulli = "";

// foreach ($footerMenu as $val) {

// $text = ($val['menu']);

// $footerMenuId = $val['id'];

// // $FooterLink = $val['link'];


// // $FooterLink = $this->functions->addWebUrlInLink($FooterLink);



// $count++;
// echo '
// <div class="footer_boxes2_side hide1">
// <h2>'.$text.'</h2>
// <div class="footer_links_main">
// <ul>';
// $footerMenu2 = $this->footerInnerMenu($footerMenuId);

// if(empty($footerMenu2)){

// echo '';

// continue;

// }

// foreach ($footerMenu2 as $val2) {

// $text = ($val2['menu']);

// $footerMenuId = $val2['id'];

// $FooterLink = $val2['link'];


// $FooterLink = $this->functions->addWebUrlInLink($FooterLink);


// echo '<li class="">

// <a href="' . $FooterLink . '" class="">' . $text . '</a></li>';


// }
// echo '</ul>
// </div>
// </div>
// ';


// }

// }



public function top_navigation( $url = '', $default_heading = '' )

{
if (!$url) { $url = '{{WEB_URL}}' . $this->functions->currentUrl(); }

$result_array = array();

# get the first main link, this can be second level menu too not just first level, so don't check for under = 0, it won't work.
$sql = "SELECT * FROM `webmenu` WHERE `link` = ? AND `type` = 'main' ";
$data = $this->dbF->getRow($sql,array($url));
$under_id = $data['id'];


# if this is top most menu
if( $data['under'] == 0 ){
$heading = translateFromSerialize($data['name']);
$top_link = $this->functions->addWebUrlInLink($data['link']);


# get the parent's children excluding this one
$sql_children  = " SELECT * FROM `webmenu` WHERE `under` = ? ";
$data_children = $this->dbF->getRows($sql_children , array($data['id']) );
( $this->dbF->rowCount == 0 ) ? $data_inner = $this->get_default_menu() : $data_inner    = $data_children ;

// $data_inner    = $data_children;

// $data_inner = $this->get_default_menu();

} else {

# get the parent
$sql_top  = "SELECT * FROM `webmenu` WHERE `id` = ? ";
$data_top = $this->dbF->getRow($sql_top,array($data['under']));

# get the parent's children excluding this one
$sql_children  = "SELECT * FROM `webmenu` WHERE `under` = ? AND `id` != ? ";
$data_children = $this->dbF->getRows($sql_children, array($data_top['id'],$data['id']) );
$data_inner    = $data_children;


// # get the parent's heading
// $sql_top = " SELECT * FROM webmenu WHERE id = ( SELECT under FROM `webmenu` WHERE `link` = ? AND `type` = 'main' ) ";
// $data_top = $this->dbF->getRow($sql_top,array($url));
$heading = translateFromSerialize($data_top['name']);
$top_link = $this->functions->addWebUrlInLink($data_top['link']);


# set a default heading.
if( !$data_top ) { $heading = $default_heading; }

}



// # get the second link
// $sql_inner  = "SELECT * FROM `webmenu` WHERE `under` = ? ";
// $data_inner = $this->dbF->getRows($sql_inner,array($under_id));

# save links in array
$result_array['inner_lis'] = '';
foreach ($data_inner as $inner_menu) {
$link   = $this->functions->addWebUrlInLink($inner_menu['link']);
$result_array['inner_lis'] .= '<li><a href="' . $link . '"><span><img src="webImages/icon17.png" alt=""></span>
' . translateFromSerialize($inner_menu['name']) . '</a>
</li>';
}



// ( $data['under'] == 0 &&  ) 
# get the related links
$related_links = $this->get_related_links($url);
# if the default name given through page and the heading is same then this is same page, so we don't make the breadcrumb heading.
$result_array['heading_simple']          = ( $heading == $default_heading || !$heading ) ? NULL : $heading;
$result_array['heading']          = ( $heading == $default_heading || !$heading ) ? NULL : '<a href="' . $top_link .'"><span><img src="webImages/icon17.png" alt=""></span>' .  $heading . '</a>' ;
$result_array['related_links']    = $related_links['related_links'];



return $result_array;
}





public function get_menu_links1( $url = '', $default_heading = '' )
{
if (!$url) { $url = '{{WEB_URL}}' . $this->functions->currentUrl(); }


// var_dump($url);
$result_array = array();

# get the first main link, this can be second level menu too not just first level, so don't check for under = 0, it won't work.
$sql = " SELECT * FROM `webmenu` WHERE `link` = ?";
$data = $this->dbF->getRow($sql,array($url));
$under_id = $data['id'];


# if this is top most menu
if( $data['under'] == 0 ){
$heading = translateFromSerialize($data['name']);
$top_link = $this->functions->addWebUrlInLink($data['link']);


# get the parent's children excluding this one
$sql_children  = " SELECT * FROM `webmenu` WHERE `under` = ? ";
$data_children = $this->dbF->getRows($sql_children, array($data['id']) );
( $this->dbF->rowCount == 0 ) ? $data_inner = $this->get_default_menu1() : $data_inner    = $data_children ;

// $data_inner    = $data_children;

// $data_inner = $this->get_default_menu();

} else {

# get the parent
$sql_top  = " SELECT * FROM `webmenu` WHERE `id` = ? ";
$data_top = $this->dbF->getRow($sql_top,array($data['under']));

# get the parent's children excluding this one
$sql_children  = " SELECT * FROM `webmenu` WHERE `under` = ?";
$data_children = $this->dbF->getRows($sql_children, array($data_top['id']) );
$data_inner    = $data_children;


// # get the parent's heading
// $sql_top = " SELECT * FROM webmenu WHERE id = ( SELECT under FROM `webmenu` WHERE `link` = ? AND `type` = 'main' ) ";
// $data_top = $this->dbF->getRow($sql_top,array($url));
$heading = translateFromSerialize($data_top['name']);
$top_link = $this->functions->addWebUrlInLink($data_top['link']);


# set a default heading.
if( !$data_top ) { $heading = $default_heading; }

}



// # get the second link
// $sql_inner  = "SELECT * FROM `webmenu` WHERE `under` = ? ";
// $data_inner = $this->dbF->getRows($sql_inner,array($under_id));

# save links in array



$result_array['inner_lis'] = '';
foreach ($data_inner as $inner_menu) {
$link   = $this->functions->addWebUrlInLink($inner_menu['link']);
$a = $inner_menu['link'];

// $url =  $this->functions->currentUrl();


// str_replace(WEB_URL,"",$a);


// print_r($a);
//  echo "<br>";
//   echo "<br>";
// echo "<br>";
// print_r($url);

// var_dump($a."sss");

$abs = str_replace("{{WEB_URL}}","",$a);

$abc = str_replace(WEB_URL,"",$a);


// var_dump($abs);

// var_dump("hhhh");


// var_dump($url);
$active4="";

if($abs == $url || $abc == $url){

$active4 = "active";
}

$result_array['inner_lis'] .= '<li><a href="' . $link . '" class="'.$active4.'">' . translateFromSerialize($inner_menu['name']) . '</a></li>';
}

// ( $data['under'] == 0 &&  ) 
# get the related links
$related_links = $this->get_related_links($url);
# if the default name given through page and the heading is same then this is same page, so we don't make the breadcrumb heading.
$result_array['heading_simple']          = ( $heading == $default_heading || !$heading ) ? NULL : $heading;
$result_array['heading']          = ( $heading == $default_heading || !$heading ) ? NULL : '<li class="2"><a href="' . $top_link .'">' .  $heading . '</a></li>' ;
$result_array['related_links']    = $related_links['related_links'];

// <li class="active"><a href="#"><span><img src="webImages/11.png" alt=""></span>Hospital Introduction</a></li>
return $result_array;
}





public function get_default_menu1(){
/**
* $return default main menu as an array.
*/

$sql   =  " SELECT * FROM `webmenu` WHERE `under` = 0 and `type` = 'main_menu' and `type` = 'footer_menu' ORDER BY `sort` ASC ";

$data  = $this->dbF->getRows($sql);

if(!$this->dbF->rowCount){return false;}
$data2 = $data;
$i = 0;
foreach ($data2 as $val) {

//get title and set into data so developer no need to translate it
if(isset($val['name'])) {
$title = getTextFromSerializeArray($val['name']);
$data[$i]['name'] = $title;
}

//LINK
if(isset($val['link'])) {
$data[$i]['link'] = $this->functions->addWebUrlInLink($val['link']);
}

$i++;

}


return $data;
}

    /**
     * function can be used for side links, this will get the inner links of main menu, only second level currently.
     *
     * @return  array of side links for current page url
     * @author 
     **/
    public function get_menu_links( $url = '', $default_heading = '' )
    {



if (!$url) { $url = '{{WEB_URL}}' . $this->functions->currentUrl(); }

$result_array = array();

# get the first main link, this can be second level menu too not just first level, so don't check for under = 0, it won't work.
$sql = " SELECT * FROM `webmenu` WHERE `link` = ? ";
$data = $this->dbF->getRow($sql,array($url));
$under_id = $data['id'];


# if this is top most menu
if( $data['under'] == 0 ){

$heading = translateFromSerialize($data['name']);
$top_link = $this->functions->addWebUrlInLink($data['link']);


# get the parent's children excluding this one
$sql_children  = " SELECT * FROM `webmenu` WHERE `under` = ?";
$data_children = $this->dbF->getRows($sql_children, array($data['id']) );

( $this->dbF->rowCount == 0 ) ? $data_inner = $this->get_default_menu() : $data_inner    = $data_children ;

// $data_inner    = $data_children;

// $data_inner = $this->get_default_menu();


// var_dump($data['link']);





} else {



# get the parent
$sql_top  = " SELECT * FROM `webmenu` WHERE `id` = ?";
$data_top = $this->dbF->getRow($sql_top,array($data['under']));

# get the parent's children excluding this one
$sql_children  = " SELECT * FROM `webmenu` WHERE `under` = ?";
$data_children = $this->dbF->getRows($sql_children, array($data_top['id']));
$data_inner    = $data_children;


// # get the parent's heading
// $sql_top = " SELECT * FROM webmenu WHERE id = ( SELECT under FROM `webmenu` WHERE `link` = ? AND `type` = 'main' ) ";
// $data_top = $this->dbF->getRow($sql_top,array($url));
$heading = translateFromSerialize($data_top['name']);
$top_link = $this->functions->addWebUrlInLink($data_top['link']);

$name =  translateFromSerialize($data['name']);



//   echo " <li class='active4'> 

//            <a href=''>

//  <span><img src='webImages/dot3.png' alt=''></span><div class='link_set'>

//  $name


//  </div>
// </a>


// </li>";

# set a default heading.
if( !$data_top ) { $heading = $default_heading; }


// var_dump($data_inner);

}



// # get the second link
// $sql_inner  = "SELECT * FROM `webmenu` WHERE `under` = ? ";
// $data_inner = $this->dbF->getRows($sql_inner,array($under_id));

# save links in array










$result_array['inner_lis'] = '';

$url =  $this->functions->currentUrl();

// var_dump($url);
// str_replace("{{WEB_URL}}",WEB_URL,$Url);

foreach ($data_inner as $inner_menu) {


$link   = $this->functions->addWebUrlInLink($inner_menu['link']);
// echo $url;


//foreach($link as $key){
//echo "<pre>"; print_r($key);

$a = $inner_menu['link'];

// $url =  $this->functions->currentUrl();


// str_replace(WEB_URL,"",$a);


// print_r($a);
//  echo "<br>";
//   echo "<br>";
// echo "<br>";
// print_r($url);

// var_dump($a."sss");

$abs = str_replace("{{WEB_URL}}","",$a);

$abc = str_replace(WEB_URL,"",$a);


// var_dump($abs);

// var_dump("hhhh");

// <li class="hvr-sweep-to-bottom"><a href="#">Management</a></li>
// var_dump($url);
$active4="";

if($abs == $url || $abc == $url){

$active4 = "active";
}

$result_array['inner_lis'] .= '









<li class=""> 




<a href="' . $link . '" class="'.$active4.'">



' . translateFromSerialize($inner_menu['name']) . '

</a></li>


<li><i class="fas fa-chevron-right"></i></li>



';

// }

// else{






// $result_array['inner_lis'] .= '


// <li> 




// <a href="' . $link . '" >

// <span>
// <img src="webImages/dot3.png" alt="">
// </span>
// <div class="link_set">
// ' . translateFromSerialize($inner_menu['name']) . '
// </div>
// </a></li>';


}
//}
// } 




// ( $data['under'] == 0 &&  ) 
# get the related links
$related_links = $this->get_related_links($url);
# if the default name given through page and the heading is same then this is same page, so we don't make the breadcrumb heading.
$result_array['heading_simple']          = ( $heading == $default_heading || !$heading ) ? NULL : $heading;
$result_array['heading']          = ( $heading == $default_heading || !$heading ) ? NULL : '<li><a href="' . $top_link .'">' .  $heading . '</a></li><li><i class="fas fa-chevron-right"></i></li>





' ;
// $result_array['related_links']    = $related_links['related_links'];


return $result_array;
}


    /**
     * function can be used for side links, this will get the inner links of main menu, only second level currently.
     *
     * @return array of realted links for current page url
     * @author 
     **/
    public function get_related_links( $url = '' )
    {
        if (!$url) { $url = '{{WEB_URL}}' . $this->functions->currentUrl(); }

        $result_array = array();

        # get the related links
        $sql  = "SELECT * FROM `webmenu` WHERE `link` = ?";
        $data = $this->dbF->getRows($sql,array($url));

        # save links
        $result_array['related_links'] = '';
        foreach ($data as $related_link) {
            $link   = $this->functions->addWebUrlInLink($related_link['link_for']);
            $result_array['related_links'] .= '<li class="inner_link"><a href="' . $link . '">' . translateFromSerialize($related_link['name']) . '</a></li>';
        }

        # return links
        return $result_array;
    }

    public function get_default_menu(){
        /**
         * $return default main menu as an array.
         */

        $sql   =  " SELECT * FROM `webmenu` WHERE  `under` = 0 ORDER BY `sort` ASC ";

        $data  = $this->dbF->getRows($sql);

        if(!$this->dbF->rowCount){return false;}
        $data2 = $data;
        $i = 0;
        foreach ($data2 as $val) {

            //get title and set into data so developer no need to translate it
            if(isset($val['name'])) {
                $title = getTextFromSerializeArray($val['name']);
                $data[$i]['name'] = $title;
            }

            //LINK
            if(isset($val['link'])) {
                $data[$i]['link'] = $this->functions->addWebUrlInLink($val['link']);
            }

        $i++;

        }


        return $data;
    }

} ?>