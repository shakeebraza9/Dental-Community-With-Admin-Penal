<?php
ob_start();

//require_once("classes/setting.class.php");
global $dbF;

$functions->require_once_custom('setting.class.php');
$setting    =  new setting();


echo '<h4 class="sub_heading borderIfNotabs">'. _uc($_e['IBMS Trash Data']) .'</h4>';
echo '<h1 class="">'. _uc($_e['Trash Data']) .'</h1>';
///$functions->dataTableDateRange();

echo '<div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                        <th>'. _uc($_e['SNO']) .'</th>
                        <th>'. _uc($_e['PAGE NAME']) .'</th>
                        <th>'. _uc($_e['DESCRIPTION']) .'</th>
                        <th>'. _uc($_e['FILE']) .'</th>
                        <th>'. _uc($_e['FROM USER']) .'</th>
                        <th>'. _uc($_e['TO USER']) .'</th>
                        <th>'. _uc($_e['TABLE NAME']) .'</th>
                        <th>'. _uc($_e['TABLE ID']) .'</th>
                        <th>'. _uc($_e['EVENT PERFORM']) .'</th>
                       

                    </thead>
                <tbody>';

$sql  = "SELECT * FROM trashdata ORDER by id DESC ";
               if(isset($_GET['id'])){$id =  $_GET['id'];
$sql  = "SELECT * FROM trashdata WHERE delete_table_name LIKE '%$id%' OR delete_table_id LIKE '%$id%' ORDER by id DESC ";
}
$data =  $dbF->getRows($sql);
$i = 0;
foreach($data as $val){
    $i++;

$replace =  $val['delete_file'];

$delete_from_user = $functions->UserName($val['delete_from_user']);

$delete_to_user = $functions->UserName($val['delete_to_user']);


    echo "       <tr>
                    <td>$i</td>
                    <td>$val[delete_page_name]</td>
                    <td>$val[delete_desc]</td>
                    <td>$replace</td>
                    <td>$val[delete_from_user]<button class='btn btn-success'>$delete_from_user</button></td>
                    <td>$val[delete_to_user]<button class='btn btn-success'>$delete_to_user</button></td>
                    <td>$val[delete_table_name]</td>
                    <td>$val[delete_table_id]</td>
                    <td>";


if($val['event_perfom'] == 'deleteDocumentall'){
echo $val['event_perfom'];  
echo "<button class='btn btn-success' style='display: inherit; vertical-align: middle;' data-toggle='tooltip' title='backward' class='edit_btn' data-id='$val[id]' onclick='updateIMPORT(this)'><i class='fa fa-refresh icon'></i></button>";
}else{
echo $val['event_perfom'];
}
echo "</td>
</tr>";
}


echo '</tbody>
      </table>
     </div> <!-- .table-responsive End -->';

$deleteDay = $functions->ibms_setting('historyDeleteAfterDays');
$days = date('Y-m-d',strtotime("-"."$deleteDay days"));
$sql = "DELETE FROM activity_log WHERE log_time < '$days' ";
$dbF->setRow($sql);
?>


    <script>
        $(document).ready(function(){
            tableHoverClasses();
            dateJqueryUi();
            minMaxDate();
            dTableRangeSearch();
        });


function updateIMPORT(ths) {
 btn=$(ths);
  id=btn.attr('data-id');
$.ajax({
type: 'post',
data: { id:id },
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


    </script>


<?php return ob_get_clean(); ?>