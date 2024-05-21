<?php 
include_once("global.php");
$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

include_once('header.php'); 

$functions->pin();

include'dashboardheader.php';

$display = "";
if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrreports'] == '0'){
    $display = 'style="display:none;"';
}  


                           

?>
 
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            COVID Screening
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'trashdata'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        
        <div class="right_side">
            <h3 class="main-heading_">Trash Data</h3>
            <div class="form-group">
                
                    <div class="covidshowbtn">
                        <div class="switch-field">
     
                 </div>
                 </div>
                 </div>

            <div class="cpd-table">
                <div class="cpd-tbl tableIBMS  table table-hover dTable tableIBMS dataTable no-footer datable table">
                    <table  class="cell-border" style="width:100%">
                        <thead>
                            <tr>
                               <th>No</th>
                               <th>PAGE NAME</th>
                               <th>DESCRIPTION</th>
                               <th>FILE</th>
                               <!--<th>USER BY</th>-->
                               <th>USER OF</th>
                               <th>TABLE NAME</th>
                               <!-- <th>TABLE ID</th> -->
                               <th>EVENT PERFORM</th>
                               <th>DELETED ON</th>
                               <th>ACTION</th>
        
                                <?php
if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){

$user = intval($_SESSION['currentUser']);
$user_fill = intval($_SESSION['superid']);

$sql1 = "SELECT * FROM `trashdata` WHERE `delete_to_user` = ? ORDER BY `trashdata`.`id` DESC";



$data1 = $dbF->getRows($sql1,array($user_fill));

}
else{
$user = intval($_SESSION['currentUser']);
$sql1 = "SELECT * FROM `trashdata` WHERE (`delete_to_user` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') OR `delete_to_user` = '$user' OR `delete_to_user` = '-1.$user' ) ORDER BY `trashdata`.`id` DESC";

$data1 = $dbF->getRows($sql1);

}
                                  
                        ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                           foreach($data1 as $val){
                            $i++;

                        $replace = WEB_URL."/images/".$val['delete_file'];
    echo "       <tr>
                    <td>$i</td>
                    <td>$val[delete_page_name]</td>
                    <td><i class='fas fa-info-circle' data-toggle='tooltip' title='$val[delete_desc]'></i></td>
                    <td>";
    if ($val['delete_page_name'] == 'All HR Files' || $val['delete_page_name'] == 'HR Files') {
                       $link =   explode(",",$val['delete_file']);
                       
                       
foreach ($link as $key => $value) {
$downLink=base64_encode($value.":s:".date('d'));
$dLink = WEB_URL . '/d?f=' . $downLink;

echo " <a href='$dLink' target='_blank'><i class='fas fa-cloud-download-alt'></i></a>";
}
                       
                    }
                    else {





$allF = explode(",", $val['delete_file']);
foreach ($allF as $keys => $values) {
$downLink=base64_encode($values.":s:".date('d'));
$dLink = WEB_URL . '/d?f=' . $downLink;
echo " <a href='$dLink' target='_blank'><i class='fas fa-cloud-download-alt'></i></a>";
}





// $downLink=base64_encode($val['delete_file'].":s:".date('d'));
// $dLink = WEB_URL . '/d?f=' . $downLink;

//                       echo " <a href='$dLink' target='_blank'><i class='fas fa-cloud-download-alt'></i></a>";



                    }
                   echo "</td>";
                //   echo "<td>".$functions->UserName($val['delete_from_user'])."</td>
                    echo "<td>".$functions->UserName($val['delete_to_user'])."</td>
                    <td>$val[delete_table_name]</td>
                    <!---------<td>$val[delete_table_id]</td>--------------->
                    <td>$val[event_perfom]</td>
                    <td>$val[TimeStamp]</td>
                    <td>
                    <button  style='display: inherit; vertical-align: middle;' data-id='$val[id]' onclick='AjaxDelScript(this);' class='btn edit_btn secure_delete' >
                                    <i class='glyphicon glyphicon-trash trash fa fa-trash' ></i>
                                    <i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i>
                                </button>";




if($val['qImport'] != '' && $val['qImport'] != 'notAssign'){
   
echo "<button class='btn edit_btn' style='display: inherit; vertical-align: middle;' data-toggle='tooltip' title='backward all data' class='edit_btn' data-id='$val[id]' onclick='qImport(this)'><i class='glyphicon fa fa-backward'></i></button>";
}else{



if($val['event_perfom'] == 'deleteDocumentall' || $val['event_perfom'] == 'deleteDocument'){
  
echo "<button class='btn edit_btn' style='display: inherit; vertical-align: middle;' data-toggle='tooltip' title='backward' class='edit_btn' data-id='$val[id]' data-event_perfom='$val[event_perfom]' onclick='updateIMPORT(this)'><i class='glyphicon fa fa-backward'></i></button>";
}else{
 
}

}


                                echo "</td>
                  

                  </tr>";    
              } 
              ?>
                        </tbody>
                    </table>
                </div>
                <!-- cpd-tbl -->
            </div>
            <!-- cpd-table -->
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
<script src="<?php echo WEB_ADMIN_URL; ?>/assets/data_table_bs/jquery.dataTables.1.10.2.js"></script>
<script>
    $('.datable table').DataTable();


function AjaxDelScript(ths){
            btn=$(ths);
            if(secure_delete()){
                btn.addClass('disabled');
                btn.children('.trash').hide();
                btn.children('.waiting').show();

                id=btn.attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: 'ajax_call.php?page=DeleteTrashData',   
                    data: { itemId:id }
                }).done(function(data)
                {
                    ift =true;
                        console.log(data);
                      if(data > 0 ){
                      //  console.log(data);
        // Remove row from HTML Table
        $(ths).closest('tr').css('background','e5f3f2');
        $(ths).closest('tr').fadeOut(800,function(){
           $(ths).remove();
        });
          }else{
        alert('Invalid ID.');
          }
                   
                    if(ift){
                        btn.removeClass('disabled');
                        btn.children('.trash').show();
                        btn.children('.waiting').hide();
                    }

                });
            }
        };



function qImport(ths) {
 btn=$(ths);

if(secure_delete('Are you sure you want to Restore All Data?')){

  id=btn.attr('data-id');
$.ajax({
type: 'post',
data: { id:id },
url: '<?php echo WEB_URL ?>/ajax_call.php?page=qImport',
}).done(function(data) {
if (data == '1') {
// location.reload();
 btn.closest('tr').hide(1000,function(){$(this).remove()});
} else {
// $(this).removeAttr('disabled', false);
}
});

}
}



function updateIMPORT(ths) {
 btn=$(ths);

if(secure_delete('Are you sure you want to Restore Trash Data?')){

  id=btn.attr('data-id');
   event_perfom=btn.attr('data-event_perfom');
$.ajax({
type: 'post',
data: { id:id,event_perfom:event_perfom },
url: '<?php echo WEB_URL ?>/ajax_call.php?page=updateIMPORTfromTrash',
}).done(function(data) {
if (data == '1') {
// location.reload();
 btn.closest('tr').hide(1000,function(){$(this).remove()});
} else {
// $(this).removeAttr('disabled', false);
}
});

}
}




        //for small delete in other project
        function secure_delete(text){
            // text = 'view on alert';
            text = typeof text !== 'undefined' ? text : 'Are you sure you want to Delete Perminantly?';

            bool=confirm(text);
            if(bool==false){return false;}else{return true;}

        }


</script>

<?php include_once('footer.php'); ?>