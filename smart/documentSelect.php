<?php 
include_once("global.php");
global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}

 $id = htmlspecialchars($_GET['id']);
 $getUser = htmlspecialchars($_GET['user']);
// echo $certificate_title = htmlspecialchars($_GET['title']);
// echo $certificate_expDate = htmlspecialchars($_GET['expDate']);
// echo $certificate_comDate = htmlspecialchars($_GET['comDates']);

$type = @htmlspecialchars($_GET['type']);

if($_SESSION['currentUserType'] == 'Employee'){
    $pid = $functions->PracticeId($_SESSION['superid']);
    $user =intval($_SESSION['superid']);
}
else{
    $pid = intval($_SESSION['currentUser']);
    $user = intval($_SESSION['currentUser']);
}
//  $data = $dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='Training' AND `id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `title_id` > 0 AND`user`='$user' AND `title_id` > 0) GROUP BY `sub_dcategory`");
 $data = $dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='Training' AND ( `id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `title_id` > 0 AND`user`='$user') OR `title` NOT IN (SELECT `title` FROM `userdocuments` WHERE `user`='$user') ) GROUP BY `sub_dcategory`");


 
               
?>
<div class="event_details" id="myform">
    <h3>Training</h3>
    


<div class="right-side">
<div class="mr">
      
 <?php foreach ($data as $key => $value) { 

if($value['sub_dcategory'] == '' ){$subCategory = "Main Folder"; }
  else{$subCategory = $value['sub_dcategory'];}



    ?>

<div class="main-row">
    <div class="main-row-top"><h5><?php echo $subCategory ?></h5><i class="fas fa-chevron-down"></i></div>
        <div class="main-row-down">
         <ul class="sub-menu" style="list-style: none;">
           <form method="POST" action="<?php echo WEB_URL.'/cpd' ?>" >
            <li><div class="row-title">
            <input type="hidden" name="certificate_paper_id" value="<?php echo $id ?>">
            <input type="hidden" name="certificate_user" value="<?php echo $getUser  ?>">
            <input type="hidden" name="sub_dcategory" value="">
            <input type="hidden" name="category" value="<?php echo $value['category'] ?>">
            <input type="hidden" name="title_id" value="-1">
            <input type="hidden" name="title_ducment" value="">

            &nbsp; Add New<span></span>&nbsp;&nbsp;
            <!-- <input type="submit" id="submit:<?php echo $value['id'] ?>" name="submit" class="btn edit_btn" style="float: right;" value=""> -->
         <button type="submit"  id="submit:-1" name="submit" class="btn edit_btn" style="float:right;"><i class="fa fa-address-card" ></i></button>
        </div></li>
            <input type="hidden" name="id" value="-1">
              </form>
           <?php if ($value['sub_dcategory'] == '') { 

          $data1 = $dbF->getRows("SELECT * FROM `documents` WHERE `sub_dcategory` ='' AND assignto ='$value[assignto]' AND `category`='Training'  "); 
          foreach ($data1 as $key1 => $value1) {  ?>   
              <form method="POST" action="<?php echo WEB_URL.'/cpd' ?>">
            <li class="red"><div class="row-title">
            <input type="hidden" name="certificate_paper_id" value="<?php echo $id ?>">
            <input type="hidden" name="certificate_user" value="<?php echo $getUser  ?>">
            <input type="hidden" name="sub_dcategory" value="<?php echo $value1['sub_dcategory'] ?>">
            <input type="hidden" name="category" value="<?php echo $value1['category'] ?>">
             <input type="hidden" name="title_id" value="<?php echo $value1['id'] ?>">
            <input type="hidden" name="title_ducment" value="<?php echo $value1['title'] ?>">

            &nbsp; <?php echo $value1['title'] ?><span></span>&nbsp;&nbsp;
            <!-- <input type="submit"  id="submit:<?php echo $value['id'] ?>" name="submit" class="btn edit_btn" style="float:"> -->
          <button type="submit"  id="submit:<?php echo $value1['id'] ?>" name="submit" class="btn edit_btn" style="float:right;"><i class="fa fa-address-card" ></i></button>
        </div>
            </li>
           <input type="hidden" name="id" value="<?php echo $value1['id'] ?>">
            </form>
<?php 
} 
}else{ 
$datas1 = $dbF->getRows("SELECT * FROM `documents` WHERE `sub_dcategory` ='$value[sub_dcategory]' AND assignto ='$value[assignto]' AND `category`='Training'  "); 
          foreach ($datas1 as $keys1 => $values1) {
?>


              <form method="POST" action="<?php echo WEB_URL.'/cpd' ?>">
            <li class="red"><div class="row-title">
            <input type="hidden" name="certificate_paper_id" value="<?php echo $id ?>">
            <input type="hidden" name="certificate_user" value="<?php echo $getUser  ?>">
            <input type="hidden" name="sub_dcategory" value="<?php echo $values1['sub_dcategory'] ?>">
            <input type="hidden" name="category" value="<?php echo $values1['category'] ?>">
             <input type="hidden" name="title_id" value="<?php echo $values1['id'] ?>">
            <input type="hidden" name="title_ducment" value="<?php echo $values1['title'] ?>">

            &nbsp; <?php echo $values1['title'] ?><span></span>&nbsp;&nbsp;
            <!-- <input type="submit"  id="submit:<?php echo $values1['id'] ?>" name="submit" class="btn edit_btn" style="float:"> -->
          <button type="submit"  id="submit:<?php echo $values1['id'] ?>" name="submit" class="btn edit_btn" style="float:right;"><i class="fa fa-address-card" ></i></button>
        </div>
            </li>
           <input type="hidden" name="id" value="<?php echo $values1['id'] ?>">
            </form>
 

<?php } } ?>
        </ul>
         </div>
    

</div>
<?php } ?>


</div>
<!-- event_details -->
<script>
 $('.main-row-top').click(function() {
        $(this).next('.main-row-down').slideToggle('slow');
        $(this).toggleClass('fa-chevron-up');
    });


 


//  $("ul.menu").find('> li').click(
//     function(e) {

//         $(this).find('> ul').slideToggle();


//       //  $(this).find('> ul').toggle();
//     }
// );

// $("ul.sub-menu").find('> li').click(
//     function(e) { 
//         e.stopPropagation()

//         $(this).find('> ul').slideToggle();

//        // $(this).find('> ul').toggle();
//     }
// );
</script>

<!-- 
<div class="row-icons"><a href="editevent_print.php?id=MTQ2" target="_blank" data-toggle="tooltip" title="Print/Save" class="ablue"><i class="fas fa-print"></i></a><a data-toggle="tooltip" title="View" onclick="editevent(this.id)" id="146" data-type="redborder" class="ablue"><i class="fas fa-eye"></i></a>
</div> -->