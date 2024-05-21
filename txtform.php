<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}
@$id = $_GET['id'];
 $id = base64_decode($id);
 
if (@$_GET['id'] !='') {
    $token = $functions->setFormToken('txtUploadsedit',false);

} else {
    $token = $functions->setFormToken('txtUploads',false);
}
// $option = $functions->eventCategory();
// if ($_GET['id'] != '') {

    
 if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0'){
            $user = $_SESSION['superid'];
        }
        else{
            $user = $_SESSION['currentUser'];
        }
$sql = "SELECT * FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND  `publish` = '1'AND id = '$id'";
        $data = $dbF->getRow($sql);


        // var_dump($data);
       $file = $data['file'];
       $title = $data['title'];

       $sql1 = "SELECT * FROM `practiceprofile` WHERE `user_id` = '$_SESSION[currentUser]'";
      $data1 = $dbF->getRow($sql1);
        $logo  = $data1['practice_logo'];
        $pname = $data1['practice_name'];
        $pmname = "<b>".$data1['practice_manager_name']."</b>";
        $subtname = $data1['subtname'];
        $pmname =  $pmname ." &nbsp; &nbsp;(Substitute PM: ".$subtname .")";
      
// }

?>
<div class="event_details" id="myform">
    <h3><?php echo $title ?></h3>

     



    <div class="form_side">
<?php if(!empty($data['ytcode'])){
?>
    <!--<div data-toggle="tooltip" title="Help Video" style="top: 0;" class="help" onclick="video('<?php echo $data['ytcode'] ?>')"><i class="fa fa-question-circle"></i></div>-->
<iframe width="900" height="315" src="https://www.youtube.com/embed/<?php echo $data['ytcode'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<?php    
} ?>

     


    <form method="post" action="<?php echo WEB_URL ?>/filetxt" >
          <!-- enctype="multipart/form-data" -->

           &nbsp;
            &nbsp;
           <?php   $fileopen=str_replace(WEB_URL, $_SERVER['DOCUMENT_ROOT'].'/', $data['file']);
                    $handle = fopen($fileopen, 'r'); 
                    $contents = stream_get_contents($handle);

                        fclose($handle); ?>
                    <div class="contentX"> 

                       <?php 
        
                    $contents = str_replace('{{pname}}',$pname,$contents);
                    $contents = str_replace('{{pmname}}',$pmname,$contents);
                    $contents = str_replace('{{logo}}',$logo,$contents);
        
     
                        echo $contents; 

                        ?>
                     </div>  
<br>



<table>
    <thead>
        <th>Practice Logo:</th>
        <th>Practice Name:</th>
        <th>Practice Manager Name :</th>
        
    </thead>
    <tbody>
        <td><img aria-roledescription="Drawing" src="https://smartdentalcompliance.com/images/<?php echo $logo ?>"  style="font-size: 13px; border: none; width: 100px; height: 80px;" ></td>
        <td><?php echo $data1['practice_name'] ?></td>
        <td><?php echo $pmname ?></td>
    </tbody>
</table>

            &nbsp;
            &nbsp;
         <?php   $ids = base64_encode($id);   ?>  
              <div class="form-group">
                <label style="display: inline-block;font-weight: 600;">Practices Specific Protocol</label>
               <textarea name="txt"  id="ckeditor" class="txt ckeditor"><?php echo $data['psp']; ?></textarea>
               <input type="hidden" name="txtid" value="<?php echo $ids ?>" class="txt ">
            </div>
           

   <script>
  
CKEDITOR.replace( 'ckeditor');
  
</script>
                
             
               
               
            <!-- form-group -->
    <input type="submit" data-toggle="tooltip" title="Edit" href="javascript:;" class="  submit_class ajaxfile"  >

    
            
        </form>
    </div>
    <!-- form_side close -->
</div>
<!-- event_details -->
<!-- <script>
        $('.ajaxfile').on('click', function() {
          
           id = this.id;
           txt = $(".txt").val();
           self = this;
    $.ajax({
        type: 'post',
        data: {id:id},
        url: 'filetxt.php',                
    }).done(function(data) {
        if (data == '1') {
            $(self).html('Confirm&nbsp;&nbsp;<i class="far fa-check-circle"></i>');
        //$(self).parents('tr').find('td:nth-child(2)').text('Confirm');
        }
    

    });
    location.replace("<?php echo WEB_URL ?>/filetxt");
               
            
        });
    </script> -->
