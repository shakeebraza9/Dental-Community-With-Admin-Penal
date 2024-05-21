<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

include_once('header.php'); 

$category = $_GET['category'];
$category = str_replace("-"," ",$category);
?>
<?php 
    if ( $category=='Practice Management Resources' ) { $active = 'practice'; }
    elseif ($category=='Compliance Templates') { $active = 'compliance'; }
    elseif ($category=='HR Management') { $active = 'resources'; }
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
            <div class="resources_search">
                <div data-toggle="tooltip" title="Help Video" style="position: absolute;top: -35px;" class="help" onclick="video('CfAI0hen4tc')"><i class="fa fa-question-circle"></i>
                 <?php if($_GET['category'] == 'Compliance-Templates'){ ?>
 <h5 style="display: inline-block;margin-left: 5px;">Compliance Templates</h5>
<?php } ?>
                </div>
                <select id="optn" class="optn">
                    <?php echo $functions->resourcesName($category,$_SESSION['currentUser']) ?>
                </select>
                <input type="text" placeholder="Keywords" id="kywd" class="optn">
                <button type="submit" id="resources_search"><i class='fas fa-search'></i></button>
            </div>
            <!-- resources_search -->
            <div class="mr">
                <?php $functions->resources($category,$_SESSION['currentUser']) ?>
            </div>
            <!-- mr -->
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
    <script>
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
<?php include_once('footer.php'); ?>