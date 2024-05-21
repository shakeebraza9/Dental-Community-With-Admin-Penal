<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

include_once('header.php');

$msg = "";
$chk = $functions->submitmyCompliance();
if($chk){
    $msg = "File Submit Successfully";
} 
    if($_GET['category'] != 'Compliance-Templates' && $_GET['category'] != 'HR-Management' && $_GET['category'] != 'Practice-Management-Resources' ){$_GET['category'] = 'Compliance-Templates';}
// $_GET['sub_category']=htmlspecialchars(strip_tags($_GET['sub_category']));
$category = isset($_GET['category']) ? $_GET['category'] : "";
$category = !empty($category) ? str_replace("-"," ",$category) : "";

$sub_category = isset($_GET['sub_category']) ? $_GET['sub_category'] : "";
// $sub_category = !empty($sub_category) ? str_replace("-"," ",$sub_category) : "";


// $categotry = $functions->resourcesApiCat($category,$_SESSION['currentUser']);


?>
<?php 
    if ( $category=='Practice Management Resources' ) { $active = 'practice'; }
    elseif ($category=='Compliance Templates') { $active = 'compliance'; }
    elseif ($category=='HR Management') { $active = 'resources'; }
    else {$category=='Compliance Templates';}
    include'dashboardheader.php';
?>

<div class="index_content mypage resources">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            <?php echo str_replace("-"," ",$category) ?>
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
            <div data-toggle="tooltip" title="Help Video" style="position: absolute;top: 10px;right: 15px;margin: auto;display: block;" class="help" onclick="video('CfAI0hen4tc')"><i class="fa fa-question-circle"></i></div>
                 <?php if($_GET['category'] == 'Compliance-Templates'){ ?>
                    <h3 class="main-heading_">Compliance Templates</h3><?php }else{
                        ?>
                    <h3 class="main-heading_">HR Management</h3><?php 
                    } ?>
             <div class="right_side_top">
                <div class="change-session">
                <?php
                    $functions->changeSession();
                ?>
               
                         <div class="col1_btnn col1_btn22">
                   <a href="javascript:;" onclick="uploadcompliancetemplate('<?php echo str_replace(" ","-",$category);?>')">Upload Template</a>
                         </div>

          
                
                </div>
                <!-- change-session -->
            </div>
              <?php if($msg!=''){ ?>
            <div class="col-sm-12 alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
                
            <div class="resources_search resources_search___  ">
               
                
               
                
                <input type="text" placeholder="Keywords" id="<?php echo !isset($_GET['sub_category']) ? 'card-key': 'kywd' ?>" class="optn">
                <button type="submit" id="resources_search"><i class='fas fa-search'></i></button>
            </div>
            <!-- resources_search -->
            <?php if(isset($_GET['sub_category'])){
            
                    $link = WEB_URL . '/resources?category='.$_GET['category']; 
            ?>
                <div class="backBtn">
                    <a class="_back" href="<?php echo $link ?>"><?php echo $_GET['category'] ?></a>/
                    <span class="_current"><?php echo $_GET['sub_category'] ?></span>
                </div>
            <?php } ?>
            
            <div class="mr compliance-template-card">
                
                 <?php 
                 
                    if(isset($_GET['category']) && isset($_GET['sub_category'])){
                        // $functions->resources2($category,$_SESSION['currentUser']);
                        $functions->resources_innner_ui($category,$sub_category,$_SESSION['currentUser']);
                    }
                    else if(isset($_GET['category']) ){
                         $functions->resources2($category,$_SESSION['currentUser']);
                    }
                    else{
                        echo "<div class='data_not_found'>Data not found</div>";
                    }
                    
                 ?>

            </div>
            <!-- mr -->
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
    <script>
        // function changeTable{
        //     alert(id)
        // }
         $('.left > .card').on('click',function(){
             $(".card").removeClass("active");
             $(this).addClass("active");
             $(".right > .table").removeClass("active");
             let id = '#'+$(this).attr("data-id");
             
             $(id).addClass("active");
            //  alert(id)
         });
         
        //  $('#card-key').on('change',function(){
        //      console.log($(this).val())
        //  })
         $('#card-key').keyup(function(){
             let searchItem = ($(this).val()).toLowerCase();
             if(searchItem !== ""){
                 $('.card ').removeClass('block');
                $('.card ').removeClass('none');
                 $('.card ').map((item,  index)=>{
                    if((($(index).find('h5').html())).toLowerCase().includes(searchItem)){
                        // console.log();
                        $(index).addClass('block');
                    }else{
                        $(index).addClass('none');
                    }
                 });
             }else{
                 console.log("jawwad")
                $('.card ').removeClass('block');
                $('.card ').removeClass('none');
             }
            //  $('.card > .name > h5').innerHTML()
         });
         
        $('.APIedit').on('click', function() {
            start_loader();
            var url = this.id;
            $.get("https://script.google.com/macros/s/AKfycbyF0ZruTXnjYPGrD02L306gOd50I9LSEjHcN6wVCR_Qaa4ReJNY/exec?url="+url, function(id) {
                localStorage.setItem("url",url);
                document.cookie="id="+id;
                $.get("https://script.google.com/macros/s/AKfycbwYy6HL5H9O85RtbH5YXBIJxnrO_Pd175XZJRW0ww/exec?id="+id, function(editurl) {
                    document.cookie="editurl="+editurl;
                    $.get("https://script.google.com/macros/s/AKfycbx_uPRmTSV6kXAKe4Lhw-xwSG_y9giQHEaMeFwNcHGMun6doBqr/exec?id="+id);
                    location.replace("<?php echo WEB_URL ?>/files");
                });
            });
        });
    </script>
    <script type="text/javascript">
    function deleteuserCompliance(ths){
        btn=$(ths);
        if(secure_delete()){
            // btn.addClass('disabled');
            // btn.children('.trash').hide();
            // btn.children('.waiting').show();

            id=btn.attr('id');
            console.log(id);
            $.ajax({
                type: 'POST',
                url: 'ajax_call.php?page=deleteUserComplianceTemplate',
                data: { id:id }
            }).done(function(data)
                {
                   
                   if (data == '1') {

                   location.reload();
                }

                });
        }
    }
 </script>
<?php include_once('footer.php'); ?>