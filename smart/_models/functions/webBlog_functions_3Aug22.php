<?php

class webBlog_functions extends  object_class
{
    public $webClass;
    //public $blogClass;
    function __construct()
    {
        parent::__construct('3');
        $this->webClass =   $GLOBALS['webClass'];
        
        //require_once(__DIR__."/../../".ADMIN_FOLDER."/blog/classes/blog.class.php");
        //$this->blogClass = new blog();
        /**
         * MultiLanguage keys Use where echo;
         * define this class words and where this class will call
         * and define words of file where this class will called
         **/
        
        global $_e;
        $_w=array();
        $_w['Your Review submit Fail Please Try Again'] = '' ;
        $_w['Your Review submit Successfully'] = '' ;
        $_w['Your Review is in pending to approve by admin'] = '' ;
        $_w['SUBMIT'] = '' ;
        $_w['Your Question Submit Successfully'] = '' ;
        $_w['Your Question submit Fail Please Try Again'] = '' ;
        $_w['Reply'] = '' ;
        $_w['Comment'] = '' ;
        $_w['Subject'] = '' ;
        $_w['Link'] = '' ;
        $_w['Place Review'] = '' ;
        $_w['Login Required to place Review'] = '' ;
        $_w['View {{no}} More Reviews'] = '' ;
        $_w['Place Question'] = '' ;$_w['Detail Question'] = '' ;
        $_w['Login Required to place Question'] = '' ;
        $_w['View {{no}} More Questions'] = '' ;
        $_w['READ MORE'] = '' ;
        $_e    =   $this->dbF->hardWordsMulti($_w,currentWebLanguage(),'Website Blog');


    }

    public function getBlog($page){
        $date = date('Y-m-d');
        $sql = "SELECT * FROM `blog` WHERE id = '$page' AND publish = '1' AND (publish_date <= '$date' OR publish_date = '')";
        $data = $this->dbF->getRow($sql);

        if(!$this->dbF->rowCount){return false;}

        $heading       = ($data['heading']);
        $date         =  ($data['date']);
        $short_desc    =  ($data['shortDesc']);
        $desc          =  (($data['dsc']));


        $array = array();
        $array['heading']   = $heading;
        $array['date']      = $date;
        $array['short_desc']= $short_desc;
        $array['desc']      = $desc;
        $array['category']  = $data['category'];
        $array['user']      = $data['user'];
        $array['image']     = WEB_URL.'/images/'.$data['image'];
        $array['comment']   = $data['comment'];
        $array['update']    = $data['dateTime'];
        $array['publish']   = $data['publish_date'];

        return $array;
    }

    public function getBlogCategory(){
        $date = date('Y-m-d');
        $sql  = "SELECT DISTINCT `category` FROM `blog` WHERE publish = '1' ";
        $data = $this->dbF->getRows($sql);
        return $data; 
    }

    public function increamentInViews($id){
        $inc = 1;
        intval($id);
        $sql  = "UPDATE  `blog` SET `views` = `views` + $inc WHERE id = ?  ";
        $data = $this->dbF->setRow($sql,array($id));
        return $data; 
    }

    public  function latestBlog(){
        $limitFrom      =   0;
        $limitT0        =   abs(intval($this->functions->ibms_setting('latestBlogLimit')));
        $today          =   date('Y-m-d');
        $sql            =   "SELECT `id`,`user`, `heading`,`image`,`shortDesc`,`date`,`category`,publish_date,dateTime FROM blog WHERE publish = '1' AND publish_date <= '$today'";
        $sql            .=  "LIMIT $limitFrom,$limitT0";
        $blog           =   '';
        $blogData       =   $this->dbF->getRows($sql);

        return $this->latestBlogPrint($blogData);
    }

    public  function latestBlogOne(){
        $limitFrom      =   0;
        $limitT0        =   abs(intval($this->functions->ibms_setting('latestBlogLimit')));
        $today          =   date('Y-m-d');
        $sql            =   "SELECT `id`,`user`, `heading`,`image`,`shortDesc`,`date`,`category`,publish_date,dateTime FROM blog WHERE publish = '1' AND publish_date <= '$today' ORDER BY id DESC ";
        $sql            .=  "LIMIT $limitFrom,1";
        $blog           =   '';
        $blogData       =   $this->dbF->getRows($sql);

        return $this->latestBlogOnePrint($blogData);
    }

    private function latestBlogOnePrint($data){
        $temp = '';
        global $functions, $_e;
        foreach($data as $val){
            $id         =   $val['id'];
            $user       =   $val['user'];
            $heading    =   $val['heading'];
            $category   =   $val['category'];
            $shortDesc  =   $this->functions->unserializeTranslate($val['shortDesc']);

            $publish_date  = $val['publish_date'];
            $dateTime   =   $val['dateTime'];
            $image      =  $val['image'];
            $image      =  $functions->resizeImage($image,'308','265',false);
            $readmore   = $_e['READ MORE'];

            $link       = WEB_URL."/page-blog/$id";
            $full_path  = WEB_URL;

            $time  = strtotime($dateTime);
            $day   = date("d", $time);
            $month = date("M", $time);
            
            $temp .='
            <div class="blog_left">
                <img src="'.$image.'" alt="blogger">
                <div class="blog_txt">
                    <h6>'.$category.' Date : '.$publish_date.' </h6> 
                    <a href="'.$link.'">
                        <h2>'.$shortDesc.' </h2>
                    </a>
                </div>
                <!-- blog_txt close -->
            </div>';

        }

        return $temp;
    }

    public  function getBlogDetail($id){
        $limitFrom      =   0;
        $limitT0        =   abs(intval($this->functions->ibms_setting('latestBlogLimit')));
        $today          =   date('Y-m-d');
        $sql            =   "SELECT `id`,`dsc`,`user`, `heading`,`image`,`shortDesc`,`date`,`category`,publish_date,dateTime FROM blog WHERE publish = ? AND  id = ? ";
        $blog           =   '';
        $blogData       =   $this->dbF->getRow($sql,array('1',$id));
        return $blogData;
    }

    public  function latestBlogDetail($id){
        $limitFrom      =   0;
        $limitT0        =   abs(intval($this->functions->ibms_setting('latestBlogLimit')));
        $today          =   date('Y-m-d');
        $sql            =   "SELECT `id`,`dsc`,`user`, `heading`,`image`,`shortDesc`,`date`,`category`,publish_date,dateTime FROM blog WHERE publish = '1' AND  id = $id ";
         
        $blog           =   '';
        $blogData       =   $this->dbF->getRows($sql);

        return $this->latestBlogDetailPrint($blogData);
    }



    private function latestBlogDetailPrint($data){
        $temp = '';
        global $functions, $_e;
        foreach($data as $val){
            $id         =   $val['id'];
            $user       =   $val['user'];
            $heading    =   $val['heading'];
            $category   =   $val['category'];
            
            $shortDesc  =   $this->functions->unserializeTranslate($val['shortDesc']);
            $desc       =   $this->functions->unserializeTranslate($val['dsc']);
            
            $publish_date  = $val['publish_date'];
            $dateTime   =   $val['dateTime'];
            $image      =  $val['image'];
            $image      =  $functions->resizeImage($image,'308','265',false);
            $readmore   = $_e['READ MORE'];

                
            $link       = WEB_URL."/page-blog/$id";
            $full_path  = WEB_URL;

            $time  = strtotime($dateTime);
            $day   = date("d", $time);
            $month = date("M", $time);
            
            $temp .='
            <div class="blog_left">
                <img src="'.$image.'" alt="blogger">
                <div class="blog_txt">
                    <h6> Category '.$category.'</h6> <h6> Date '.$dateTime.' </h6>  
                    <a href="'.$link.'">
                        <h2>'.$desc.' </h2>
                    </a>
                </div>
                <!-- blog_txt close -->
            </div>';

        }

        return $temp;
    }

    public function popularBlogs($data){
            $limitFrom      =   0;
            $limitT0        =   abs(intval($this->functions->ibms_setting('latestBlogLimit')));
            $today          =   date('Y-m-d');
            
            $sql = "SELECT `id`,`user`, `heading`,`image`,`shortDesc`,`date`,`category`,publish_date,dateTime
            FROM blog 
            WHERE 
            (
            views IN 
            (
            SELECT views
            FROM blog as blog1
            GROUP BY views
            ORDER BY views DESC
            )
            )";

            // $sql            =   "SELECT `id`,`user`, `heading`,`image`,`shortDesc`,`date`,`category`,publish_date,dateTime FROM blog WHERE publish = '1' AND publish_date <= '$today'";
            // $sql            .=  " LIMIT $limitFrom,10";
            
            $blog           =   '';
            $blogData       =   $this->dbF->getRows($sql);
            // echo "<pre>";
            // print_r($blogData);
            return $this->popularBlogPrint($blogData);
    }

     private function popularBlogPrint($data){
        $temp = '';
        global $functions, $_e;
        foreach($data as $val){

            $id         =   $val['id'];
            $user       =   $val['user'];
            $heading    =   $this->functions->unserializeTranslate($val['heading']);
            $category   =   $val['category'];
            $shortDesc  =   $this->functions->unserializeTranslate($val['shortDesc']);

            $publish_date  = $val['publish_date'];
            $dateTime   =   $val['dateTime'];
            $image      =  $val['image'];
            $image      =  $functions->resizeImage($image,'308','265',false);
            $readmore   = $_e['READ MORE'];

            $link       = WEB_URL."/page-blog/$id";
            $full_path  = WEB_URL;

            $time  = strtotime($dateTime);
            $day   = date("d", $time);
            $month = date("M", $time);

            echo'<li>
                    <a href="'.$link.'">
                        '.$heading.'
                    </a>
                    <h6>'.$publish_date.'</h6>
                </li>';

        }
    }

    public function blogBoxes($data){
            $limitFrom      =   0;
            $limitT0        =   abs(intval($this->functions->ibms_setting('latestBlogLimit')));
            $today          =   date('Y-m-d');
            $sql            =   "SELECT `id`,`user`, `heading`,`image`,`shortDesc`,`date`,`category`,publish_date,dateTime FROM blog WHERE publish = '1' AND publish_date <= '$today'";
            $sql            .=  " LIMIT $limitFrom,50";
            $blog           =   '';
            $blogData       =   $this->dbF->getRows($sql);
            // echo "<pre>";
            // print_r($blogData);
            return $this->blogBoxesPrint($blogData);
    }

    private function blogBoxesPrint($data){
        $temp = '';
        global $functions, $_e;
        foreach($data as $val){

            $id         =   $val['id'];
            $user       =   $val['user'];
            $heading    =   $this->functions->unserializeTranslate($val['heading']);
            $category   =   $val['category'];
            $shortDesc  =   $this->functions->unserializeTranslate($val['shortDesc']);

            $publish_date = $val['publish_date'];
            $dateTime   =   $val['dateTime'];
            $image      =  $val['image'];
            $image      =  $functions->resizeImage($image,'308','265',false);
            $readmore   = $_e['READ MORE'];

            $link       = WEB_URL."/page-blog/$id";
            $full_path  = WEB_URL;

            $time  = strtotime($dateTime);
            $day   = date("d", $time);
            $month = date("M", $time);
  
            $stripped = str_replace(' ', '', $category);

            $temp .='<div class="blog_box '.$stripped.'">
                <a href="'.$link.'">
                    <div class="blog_img">
                        <img src="'.$image.'" alt="'.$image.'">
                    </div>
                    <div class="blog_box_txt">
                        <h2>'.$heading.'
                        </h2>
                        <h6>
                            '.$publish_date.'
                        </h6>
                    </div>
                </a>
            </div> ';
        }
        return $temp;
    }

    public  function latestRandomBlog($limit){
        $limitFrom      =   0;
        $limitT0        =   abs(intval($limit));
        $today          =   date('Y-m-d');
        $sql            =   "SELECT `id`,`user`, `heading`,`image`,`shortDesc`,`date`,`category`,publish_date,dateTime FROM blog WHERE publish = '1' AND publish_date <= '$today'";
        $sql            .=  " ORDER BY  RAND() LIMIT $limitFrom,$limitT0";
        $blog           =   '';
        $blogData       =   $this->dbF->getRows($sql);

        return $blogData;
    }


    private function latestBlogPrint($data){
        $temp = '';
        global $functions, $_e;
        foreach($data as $val){
            $id         =   $val['id'];
            $user       =   $val['user'];
            $heading    =   $val['heading'];
            $category   =   $val['category'];
            $shortDesc  =   $val['shortDesc'];
            $publish_date  = $val['publish_date'];
            $dateTime   =   $val['dateTime'];
            $image      =  $val['image'];
            $image      =  $functions->resizeImage($image,'308','265',false);
            $readmore   = $_e['READ MORE'];

            $link       =   WEB_URL."/page-blog/$id";
            $full_path  = WEB_URL;

            $time  = strtotime($dateTime);
            $day   = date("d", $time);
            $month = date("M", $time);

            //Print Structure
    $temp .='



      <div class="blog">
         <div class="loremispumtext">
            <h2>'.$heading.'</h2>
         </div>
         <div class="sevensep">

          <div class="sevenseptext">
            <h2>'.$day.'</h2>
          </div>
          <!--end of sevenseptext-->

          <div class="sevenseptext2">
            <h2>'.$month.'</h2>
          </div>
          <!--end of sevenseptext-->

        </div>
        <!--end of sevensep-->

        <div class="applediv">
          <div class="apple"><a href="'.$link.'"> <img src="'.$image.'"  alt=""/></a> </div>
          <!--end of apple-->
         
          <!--end of loremispumtext-->

          <div class="loremispumpara">
            <p>'.$shortDesc.'</p>
          </div>
          <!--end of loremispumpara-->

          <div class="readmorebutton"> 
            <a href="'.$link.'">' . $readmore . '</a> 
          </div>

        </div>
        <!--end of applediv--> 

      </div>
      <!--end of blog-->';
            //Print Structure End
        }

        return $temp;
    }


    public function reviewRandom($id,$type='product',$myReview='1',$reviewOff=false){
        global $_e;
        if($this->functions->developer_setting('reviews') == '0'){
            return ""; // not allow from developer
        }

        if($this->functions->ibms_setting('showReview')!='1'){ //not show from admin setting

            if($reviewOff==false) {
                $reviewOff = $this->functions->ibms_setting('reviewOffMsg'); //review off msg
            }
            if($reviewOff != ''){
                return  "<div class='reviewoffMsg alert alert-warning margin-0'>$reviewOff</div>";
            }
            return "";
        }
        if(empty($myReview)){
            return ""; // in case when user single page review setting not found...
        }


         $sql    =   "SELECT * FROM `reviews` WHERE r_id = ? AND `type` =  ? AND status = ? ORDER BY RAND()";
        $data   =   $this->dbF->getRow($sql,array($id,$type,'1'));

        return $data;
    }


    public function askQuestion($id,$type,$form=true,$questionAllow='1', $questionOff=''){
        global $_e;
        //$myReview 1 or 0 from single product
        //$reviewOff msg if single product is off
        $userId     =   clientId();
        $userId     =   intval($userId);

        if($this->functions->developer_setting('askQuestion') == '0'){
            return ""; // not allow from developer
        }

        if($questionAllow === '0' && $questionOff != ''){
            return  "<div class='reviewoffMsg alert alert-warning margin-0'>$questionOff</div>";
        }

        if($this->functions->ibms_setting('showQuestion')!='1'){ //not show from admin setting
            if(empty($questionOff)) {
                $questionOff = $this->functions->ibms_setting('questionOffMsg'); //review off msg
            }
            if($questionOff != ''){
                return  "<div class='reviewoffMsg alert alert-warning margin-0'>$questionOff</div>";
            }
            return "";
        }
        if(empty($questionAllow)){
            return ""; // in case when user single page review setting not found...
        }

        $askQuestionOrderBY    =   $this->functions->ibms_setting('askQuestionOrderBY');

        $limitTo    =   $this->functions->ibms_setting('askQuestionLimit');
        $limit      =   " LIMIT 0,$limitTo";
        if(isset($_GET['askQuestionAll'])){
            $limit = '';
        }
        $rest = '';
        if(isset($_GET['qS'])) {
            $qS = $_GET['qS'];
            $sql = "SELECT * FROM `reviews` WHERE r_id = '$id' AND `type` = '$type' AND (status = '1' OR user_id = '$userId') AND (subject LIKE '%$qS%' OR comment LIKE '%$qS%' OR text2 LIKE '%$qS%' OR reply LIKE '%$qS%') ORDER BY id $askQuestionOrderBY";
            $data = $this->dbF->getRows($sql);
            $rest = '<a href="'.WEB_URL.'/detail?pId='.$id.'" class="btn btn-default">Reset</a>';
            $count = 0;
        }else{
            $sql = "SELECT * FROM `reviews` WHERE r_id = '$id' AND `type` = '$type' AND (status = '1' OR user_id = '$userId') ORDER BY id $askQuestionOrderBY $limit";
            $data = $this->dbF->getRows($sql);

            //count comments
            $sql = "SELECT COUNT(id) as id FROM `reviews` WHERE r_id = '$id' AND `type` = '$type' AND (status = '1' OR user_id = '$userId')";
            $data2 = $this->dbF->getRow($sql);
            $count = $data2['id'];
        }

        $temp   =   '
                    <form class="form-inline" action="detail.php">
                        <input type="hidden" name="pId"  value="'.$id.'"/>
                      <div class="form-group">
                        <input type="search" name="qS" value="'.@$_GET['qS'].'" class="form-control" placeholder="Search">
                      </div>
                      <button type="submit" class="btn btn-default">Search</button>
                      '.$rest.'
                    </form>

                    <div class="accordionAskQuestion">';

        foreach($data as $val) {

            $sql        =   "SELECT * FROM `accounts_user` WHERE acc_id = '$val[user_id]'";
            $userData   =   $this->dbF->getRow($sql);
            if($this->dbF->rowCount>0){
                $name       =   $userData['acc_name'];
                $email      =   $userData['acc_email'];
            }else{
                $name       =   "Anonymox";
                $email      =   "";
            }

            $comment    =   textArea(htmlentities($val['comment']));
            $reply      =   textArea(htmlentities($val['reply']));
            if(!empty($reply)){
                $reply = "{$_e['Reply']} : $reply";
            }
            $subject    =   htmlentities($val['subject']);
            $date       =   date('Y-m-d H:i',strtotime($val['dateTime']));
            $reviewId   = $val['id'];

            $adminViewClass = "";
            if(isset($_GET['askQuestionId']) && $_GET['askQuestionId'] == $reviewId){
                $adminViewClass = "alert-success";
            }


                $temp .= "<h3 class='container-fluid $adminViewClass singleQuestion' id='askQuestion_$reviewId'>$subject </h3>
                                <div>
                                    <div class='col-sm-12 text-justify $adminViewClass padding-0'>
                                        <div class='container-fluid padding-0'>
                                            $comment
                                            <blockquote class='small padding-F10 margin-5'>($name - $date)</blockquote>
                                            <div class='container-fluid'>
                                                $reply
                                            </div>
                                        </div>
                                    </div>
                                </div>";
        }

        $temp .= "</div>";

        if($count>$limitTo && !isset($_GET['askQuestionAll'])){
            $linkPage   =   pageLink();
            $linkPage .= "askQuestionAll";
            $rest       =   intval($count)-intval($limitTo);
            $viewMore = _replace("{{no}}",$rest,$_e['View {{no}} More Questions']);
            $temp       .=  "<div class='text-center'><a href='$linkPage' class='btn btn-default'>$viewMore</a></div><br>";
        }else{
            $temp .= "<br>";
        }

        if($form){
            $temp .= $this->askQuestionForm($id, $type);
        }

        $temp .= '<script>
                      $(document).ready(function(){
                        $( ".accordionAskQuestion" ).accordion({
                          heightStyle: "content",
                          collapsible: true
                        });
                    });
                    </script>';
        return $temp;

    }

    public function askQuestionForm($id,$type){
        global $_e;
        $login = '1';



        $tempT = "<input type='hidden' name='id' value='$id'/>
                    <input type='hidden' name='type' value='$type'/>";

        $token = $this->functions->setFormToken('askQuestion',false);
        $temp  = "<div class='container-fluid reviewForm myreviews'>

                <div class='panel-group' role='tablist' aria-multiselectable='true'>
                  <div class='panel panel-primary'>
                    <div class='panel-heading' role='tab' id='headingOne'>
                      <a data-toggle='collapse' data-parent='#accordionQuestion' href='.collapseOneQuestion' aria-expanded='true' aria-controls='collapseOneQuestion'>
                          <h4 class='panel-title'>
                             ". _uc($_e['Place Question']) ."
                          </h4>
                      </a>
                    </div>

                    <div id='collapseOneQuestion' class='panel-collapse collapse collapseOneQuestion' role='tabpanel' aria-labelledby='headingOne'>
                     <div class='panel-body panel_color'>

                <form method='post' class='form-horizontal'>
                    $token $tempT
                    ";


        if($login=='1'){
            //Login Required
            if(!userLoginCheck()){
                //when user not login
                $temp .= "
                        <div class='form-group'>
                         <label class='col-sm-2 control-label'></label>
                         <div class='col-sm-10'><a href='".WEB_URL."/login' class='btn btn-default'>". _n($_e['Login Required to place Question']) ."</a></div>
                        </div>
                    </form>
                 </div><!--panel-body End-->
                </div><!--collapseOne End-->
            </div><!--panel End-->
            </div><!--panel-group End-->
         </div><!--reviewForm End-->";
                return $temp;
            }
        }


        $temp .= "<div class='form-group'>
                    <label class='col-sm-2 control-label'>". _uc($_e['Subject']) ." </label>
                    <div class='col-sm-10'>
                      <input required type='text' class='form-control' name='subject'/>
                    </div>
                </div>";


        $temp .= "<div class='form-group'>
                        <label class='col-sm-2 control-label'>". _uc($_e['Detail Question']) ." </label>
                        <div class='col-sm-10'><textarea required class='form-control' name='review'></textarea>
                    </div>
                 </div>";

        $temp .= "
                        <div class='form-group'>
                         <label class='col-sm-2 control-label'></label>
                            <div class='col-sm-10'>
                                <input type='submit' class='btn btn-default' name='submit' value='". _u($_e['SUBMIT']) ."'/>
                            </div>

                        </div>
                    </form>
                 </div><!--panel-body End-->
                </div><!--collapseOne End-->
            </div><!--panel End-->
            </div><!--panel-group End-->
         </div><!--reviewForm End-->";

        return $temp;
    }


    public function reviews($id,$type,$view=1,$form=true,$myReview='1',$reviewOff=false){
        global $_e;
        //$myReview 1 or 0 from single product
        //$reviewOff msg if single product is off
        $userId     =   clientId();
        $isLogin    =   userLoginCheck();

        if($this->functions->developer_setting('reviews') == '0'){
            return ""; // not allow from developer
        }

        if($myReview === '0' && $reviewOff != ''){
            return  "<div class='reviewoffMsg alert alert-warning margin-0'>$reviewOff</div>";
        }

        if($this->functions->ibms_setting('showReview')!='1'){ //not show from admin setting
            if(empty($reviewOff)) {
                $reviewOff = $this->functions->ibms_setting('reviewOffMsg'); //review off msg
            }
            if($reviewOff != ''){
                return  "<div class='reviewoffMsg alert alert-warning margin-0'>$reviewOff</div>";
            }
            return "";
        }

        if(empty($myReview)){
            return ""; // in case when user single page review setting not found...
        }

        $reviewOrderBY    =   $this->functions->ibms_setting('reviewOrderBY');

        $limitTo    =   $this->functions->ibms_setting('reviewLimit');
        $limit      =    " LIMIT 0,$limitTo";
        if(isset($_GET['reviewAll'])){
            $limit = '';
        }

        $sql    =   "SELECT * FROM `reviews` WHERE r_id = '$id' AND `type` = '$type' AND (status = '1' OR user_id = '$userId') ORDER BY id $reviewOrderBY $limit";
        $data   =   $this->dbF->getRows($sql);

        //count comments
        $sql    =   "SELECT COUNT(id) as id FROM `reviews` WHERE r_id = '$id' AND `type` = '$type' AND (status = '1' OR user_id = '$userId')";
        $data2   =   $this->dbF->getRow($sql);
        $count  =   $data2['id'];

        $temp = '<div class="reviewMainDiv">
                    <div class="reviewResultDiv">';
        $subjectAllow   = $this->functions->developer_setting('review_heading');
        $linkAllow      = $this->functions->developer_setting('review_link');

        foreach($data as $val) {

                $sql        =   "SELECT * FROM `accounts_user` WHERE acc_id = '$val[user_id]'";
                $userData   =   $this->dbF->getRow($sql);
                if($this->dbF->rowCount>0){
                    $name       =   $userData['acc_name'];
                    $email      =   $userData['acc_email'];
                }else{
                    $name       =   "Anonymox";
                    $email      =   "";
                }

            $comment    =   textArea(htmlentities($val['comment']));
            $subjectR    =   htmlentities($val['subject']);
            $link       =   htmlentities($val['text2']);
            $date       =   date('Y-m-d H:i',strtotime($val['dateTime']));
            $reviewId   = $val['id'];

            if($subjectAllow=='1'){
                if($view==3)
                    $subject = "$subjectR";
                else
                    $subject = "<span class='reviewSubject text-primary'>$subjectR</span><br>";

            }else{
                $subject =  "";
            }
            if($linkAllow=='1'){
                $link = "<a href='$link' target='_blank' class='reviewLink text-primary'>$link</a>";
            }else{
                $link = "";
            }

            $adminViewClass = "";
            if(isset($_GET['reviewId']) && $_GET['reviewId'] == $reviewId){
                $adminViewClass = "alert-success";
            }

            if($view==1) {
                $temp .= "<div class='container-fluid $adminViewClass singleReview view1' id='review_$reviewId'>
                                <div class='col-sm-4 col-md-3 text-left padding-0'>
                                    <img class='reviewImg' src='' />
                                    <span class='reviewName text-danger'>$name</span><br>
                                    <span class='reviewDate'>$date</span>
                                </div>
                                <div class='col-sm-8 text-justify'>
                                    $subject
                                    $link
                                    <p class='reviewComment'>$comment</p>
                                </div>
                            </div>";

            }else if($view==2){
                $temp .= "<div class='container-fluid $adminViewClass singleReview view2' id='review_$reviewId'>
                                <div class='col-sm-12 text-justify padding-0'>
                                    <span class='reviewName text-danger'>$name</span><br>
                                    <div style='padding:5px;'>
                                        <span class='reviewDate'><small>$date</small></span><br>
                                        $subject
                                        <small>$link</small>
                                        <p class='reviewComment'>$comment</p>
                                    </div>
                                </div>
                            </div>";
            }else if($view==3){
                //collapse
                $temp .= "<h3 class='container-fluid $adminViewClass view3' id='review_$reviewId'>$subject</h3>
                                <div>
                                    <div class='col-sm-12 text-justify $adminViewClass padding-0'>
                                        <div class='container-fluid padding-0'>
                                            <p class='reviewComment'>$comment</p>
                                            <small>$link</small>
                                            <blockquote class='small padding-F10 margin-5'>($name - $date)</blockquote>
                                        </div>
                                    </div>
                                </div>";
            }
        }

        $temp .= "</div>";
        if($count>$limitTo && !isset($_GET['reviewAll'])){
            $linkPage   =   pageLink();
            $linkPage .= "reviewAll";
            $rest       =   intval($count)-intval($limitTo);
            $viewMore = _replace("{{no}}",$rest,$_e['View {{no}} More Reviews']);
            $temp       .=  "<div class='text-center'><a href='$linkPage' class='btn btn-default'>$viewMore</a></div><br>";
        }else{
            $temp .= "<br>";
        }

        if($form){
            $temp .= $this->reviewForm($id,$type);
        }

        $temp .= "</div>";

        if($view==3){
            //collapse
            $temp .= '<script>
                              $(document).ready(function(){
                                $( ".reviewResultDiv" ).accordion({
                                  heightStyle: "content",
                                  collapsible: true
                                });
                            });
                            </script>';
        }
        return $temp;

    }

    public function reviewForm($id,$type){
        global $_e;
        $login = $this->functions->ibms_setting('loginForComment');


        $tempT = "<input type='hidden' name='id' value='$id'/>
                    <input type='hidden' name='type' value='$type'/>";

        $token = $this->functions->setFormToken('review',false);
        $temp = "<div class='container-fluid reviewForm myreviews'>

                <div class='panel-group' role='tablist' aria-multiselectable='true'>
                  <div class='panel panel-primary'>
                    <div class='panel-heading' role='tab' id='headingOne'>
                      <a data-toggle='collapse' data-parent='#accordion' href='.collapseOne' aria-expanded='true' aria-controls='collapseOne'>
                          <h4 class='panel-title'>
                             ". _uc($_e['Place Review']) ."
                          </h4>
                      </a>
                    </div>

                    <div id='collapseOne' class='panel-collapse collapse collapseOne' role='tabpanel' aria-labelledby='headingOne'>
                     <div class='panel-body panel_color'>

                <form method='post' class='form-horizontal'>
                    $token $tempT
                    ";


        if($login=='1'){
            //Login Required
            if(!userLoginCheck()){
                //when user not login
                $temp .= "
                        <div class='form-group'>
                         <label class='col-sm-2 control-label'></label>
                         <div class='col-sm-10'><a href='".WEB_URL."/login' class='btn btn-default'>". _n($_e['Login Required to place Review']) ."</a></div>
                        </div>
                    </form>
                 </div><!--panel-body End-->
                </div><!--collapseOne End-->
            </div><!--panel End-->
            </div><!--panel-group End-->
         </div><!--reviewForm End-->";
                return $temp;
            }
        }


        if($this->functions->developer_setting('review_heading')=='1'){
            $temp .= "<div class='form-group'>
                        <label class='col-sm-2 control-label'>". _uc($_e['Subject']) ." </label>
                        <div class='col-sm-10'>
                          <input required type='text' class='form-control' name='subject'/>
                        </div>
                    </div>";
        }
        if($this->functions->developer_setting('review_link')=='1'){
            $temp .= "<div class='form-group'>
                        <label class='col-sm-2 control-label'>". _uc($_e['Link']) ." </label>
                        <div class='col-sm-10'>
                          <input type='url' class='form-control' name='link'/>
                        </div>
                    </div>";
        }

        $temp .= "<div class='form-group'>
                        <label class='col-sm-2 control-label'>". _uc($_e['Comment']) ." </label>
                        <div class='col-sm-10'><textarea required class='form-control' name='review'></textarea>
                    </div>
                 </div>";

        $temp .= "
                        <div class='form-group'>
                         <label class='col-sm-2 control-label'></label>
                            <div class='col-sm-10'>
                                <input type='submit' class='btn btn-default' name='submit' value='". _u($_e['SUBMIT']) ."'/>
                            </div>

                        </div>
                    </form>
                 </div><!--panel-body End-->
                </div><!--collapseOne End-->
            </div><!--panel End-->
            </div><!--panel-group End-->
         </div><!--reviewForm End-->";

        return $temp;
    }

    public function askQuestionSubmit(){
        if(isset($_POST['review']) && isset($_POST['id']) && isset($_POST['type'])){
            if(!$this->functions->getFormToken('askQuestion')){return false;}

            return $this->reviewSubmit(false);

        }
    }

    public function reviewSubmit($checkToken=true){
        global $_e;

        if(isset($_POST['review']) && isset($_POST['id']) && isset($_POST['type'])){
            if($checkToken) {
                if (!$this->functions->getFormToken('review')) { return false; }
            }

            $review         =   empty($_POST['review'])     ? "" : $_POST['review'];
            $reviewSubject  =   empty($_POST['subject'])    ? "" : $_POST['subject'];
            $reviewLink     =   empty($_POST['link'])       ? "" : $_POST['link'];
            $id             =   empty($_POST['id'])         ? "" : $_POST['id'];
            $type           =   empty($_POST['type'])       ? "" : $_POST['type'];
            $userId         =   clientId();
            $place          =   $this->functions->currentUrl();
         // htnlspecialChar
            htmlspecialchars($review);
            htmlspecialchars($reviewSubject);
            htmlspecialchars($id);
            htmlspecialchars($type);

            $status         =   $this->functions->ibms_setting('commentStatus');

            $sql        = "INSERT INTO reviews SET
                            `r_id` = ?,
                            `type` = ?,
                            `user_id` = ?,
                            `comment` = ?,
                            `subject` = ?,
                            `text2` = ?,
                            `status` = ?,
                            `place` = ?";
            $array      = array($id,$type,$userId,$review,$reviewSubject,$reviewLink,$status,$place);
            $this->dbF->setRow($sql,$array);

            if($this->dbF->rowCount>0) {
                if($type == 'question') {
                    return "<div class='alert alert-success'>" . $_e['Your Question Submit Successfully'] . "</div>";
                }else{
                    if ($status == '0') {
                        return "<div class='alert alert-success'>" . $_e['Your Review is in pending to approve by admin'] . "</div>";
                    } else {
                        return "<div class='alert alert-success'>" . $_e['Your Review submit Successfully'] . "</div>";
                    }
                }
            }
            if($type == 'question') {
                return "<div class='alert alert-danger'>".$_e['Your Question submit Fail Please Try Again']."</div>";
            }
            return "<div class='alert alert-danger'>".$_e['Your Review submit Fail Please Try Again']."</div>";
        }
        return "";
    }

    public function reviewDelete(){

    }

    public function reviewReferenceDelete($id,$type){

    }

    public function facebookComment(){
        $link = $this->functions->currentUrl(false);
        if($this->functions->developer_setting('isFacebookComments')=='0'){
            return "";
        }


        if($this->functions->ibms_setting('showFacebookComment')=='1') {
            $numPost = intval($this->functions->ibms_setting('facebookCommentLimit'));
            if ($numPost < 1) {
                $numPost = 5;
            }
            $colorscheme = $this->functions->ibms_setting('facebookColorScheme');
            $facebookOrder_by = $this->functions->ibms_setting('facebookOrder_by');

            $temp = '<div class="fb-comments" data-href="' . $link . '"
                        data-numposts       =   "' . $numPost . '"
                        data-colorscheme    =   "' . $colorscheme . '"
                        order_by            =   "'.$facebookOrder_by.'"
                        data-width          =   "100%"
                    ></div>';

            return $temp;
        }

        else{
            $fbOffMsg = $this->functions->ibms_setting('fbOffMsg');
            if($fbOffMsg !='') {
                return "<div class='fbOffMsg alert alert-warning'>$fbOffMsg</div>";
            }else {
                return "";
            }
        }
    }




}

?>