<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

include_once('header.php');

$msg = "";







include'dashboardheader.php'; ?>
<div class="index_content mypage resources">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
           Action Plan
        </div>
        <!--link_menu close -->
        <div class="left_side">
            <?php $active = 'hrm'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">


           <div class="main allReports">
        <div class="Reports">
            <div class="reports_Inner">
                <div class="gridMain">
            <?php
            $mainMenu = $menuClass->menuTypeSingle('report_menu');
            // var_dump($mainMenu);
            foreach ($mainMenu as $val) {
                    $insideActive = false;
                    $innerUl = '';
                    $menuId = $val['id'];
                    $text = ($val['name']);
                    $link = $val['link'];
                    $icon = $val['icon']; 
                    $short_desc = ($val['short_desc']);
                echo '
                <div class="grid_Item mainItem">
                        <div class="leftdiv">
                           <div class="imgdiv">
                            <img src="'.$icon.'" alt="">
                            <h5>'.$text.'</h5>
                           </div>
                            <div class="rightdiv">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                        </div>
                       <p>'.$short_desc.'</p>  
                    </div>
                    <div class="gridMain dropdown">
                    <h5 style="padding: 15px;font-weight: bold;border-bottom: 1px solid lightgrey;">'.$text.'</h5><i class="fa fa-times close"  id="close" aria-hidden="true"></i>';
            $mainMenu2 = $menuClass->menuTypeSingle('report_menu', $menuId);
                        if (!empty($mainMenu2)) {
                        $innerUl .= '<ul>';
                            foreach ($mainMenu2 as $val2) {
                            $innerUl3 = '';
                            $text = ($val2['name']);
                            $menuId = $val2['id'];
                            $link = $val2['link'];
                            $icon = $val['icon'];
                            echo'
                             <a href="'.$link.'">
                        <div class="grid_Item">
                            <div class="leftdiv">
                               <div class="imgdiv">
                               <img src="webImages/file.svg" alt="">
                                <h5>'.$text.'</h5>
                                
                               </div>
                                <div class="rightdiv">
                               <i class="fas fa-info-circle"></i>
                               
                                </div>
                            </div>
                            
                        </div>
                       </a> 
                        
                   ';
                            }
                        }
                        echo '</div>';
            }            

            ?>
                
                    
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
           
         
                                   
        </div>
        <!-- right_side close -->
    </div>
</div>
    <!-- left_right_side -->
<?php include_once('footer.php'); ?>
<script>
    $(document).ready(function(){
    $(".mainItem").click(function(){
       

        if($(this).next().hasClass("show")){
            $(this).next().removeClass("show")
        }else{
        $(".dropdown").removeClass("show")

            $(this).next().addClass("show")
        }

    });
    $(".close").click(function(){
       

       
            $(this).parent().removeClass("show")


    });
  });
</script>