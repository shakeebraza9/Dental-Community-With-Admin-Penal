<?php

include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

// include_once('header.php'); 



$msg = "";
$chk1 = $functions->Add_lab();
// var_dump($_POST);
if($chk1){
    $msg = "Form Submit Successfully";
}
$chk2 = $functions->EDITLabReports();
if($chk2){
    $msg = "Form EDit Successfully";
}
$chk3 = $functions->Add_lab_Note();
if($chk2){
    $msg = "Note Add Successfully";
}



include'dashboardheader.php';
$functions->pin();
// $display = "";

// $displayblock = '';
// if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){
//     $display = 'style="display:none;"';
//     $displayblock = 'style="display:inline-block"';

// }else{

//     $display = 'style="display: inline-block"';
//     $displayblock = 'style="display:none;"';
// }

?>
<div class="index_content mypage">
    <!-- <div class="left_right_side"> -->
        
        <div class="right_side hrm">
            <h3 class="main-heading_">Lab Management</h3>
             <?php if($msg !=''){ ?>
            <div class="col-sm-12 alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <div class="right_side_top">
            </div>
            <!-- right_side_top close -->
            
            <!-- cpd-main-box -->

            <div class="hr-absence profile">
                <div id="tabs">
                    <ul>
                        <li>
                            <a href="#tabs-1">Add</a>
                        </li>
                        <li>
                            <a href="#tabs-2">Calender</a>
                        </li>
                        <li>
                            <a href="#tabs-3">Report</a>
                        </li>
                  
                        
                    </ul>
                    <!-- hr-absence-box -->
                    <div class="hr-absence-hub" id="tabs-1">
                        <div class="">
                           

<form method="post" class="add_Lab" action="lab-management" id="add_lab">

<div class="row">
<div class="form-group col-md-3">
<label>Name of Patient</label>
<input type="text" id="name_of_patient" name="name_of_patient"/>
</div>
<!-- form-group -->
<div class="form-group col-md-3">
<label>Patient ID</label>    
<input type="text" id="patient_id" name="patient_id"/>     
</div>
<!-- form-group -->
<div class="form-group col-md-3">
<label>Lab</label>    
<input type="text" id="lab" name="lab"/>     
</div>
<!-- form-group -->
<div class="form-group col-md-3">
<label>Surgery Number</label>    
<input type="text" id="surgery_num" name="surgery_num"/>     
</div>
<!-- form-group -->

<div class="form-group col-md-3">
<label>Name of Dentist</label>
<input class="name_of_dentist" id="name_of_dentist" type="text" value="" name="name_of_dentist" required autocomplete="off">
</div>
<!-- form-group -->
<!-- form-group -->
<div class="form-group col-md-3">
<label>Date Lab Work Sent</label>    
<input type="date" id="work_sent" name="work_sent" min='<?php echo date('Y-m-d')?>' style="padding-right: 7px;" oninput="myFunction()"/>     
</div>
<script>
function myFunction() {
  var x = document.getElementById("work_sent").value;
  document.getElementById("arrival_date").setAttribute('min', x);

  console.log(x);
}
</script>
<!-- form-group -->
<div class="form-group col-md-3">
<label>Estimated Arrival Date</label>    
<input type="date" id="arrival_date" name="arrival_date" style="padding-right: 7px;" />     
</div>

<div class="form-group col-12">
<button style="display: inline-block;" class="submit_class" value="Submit Information" name="submit">Submit Information</button>
</div> 
<!-- form-group -->
</div>
</form>

                        </div>
                        <!-- hr-absence-hub-tbl -->
                    </div>
                    <!-- hr-absence-hub -->
                    <div class="hr-absence-hub" id="tabs-2">
                        <div class="">

                                                 </div>
                        <!-- hr-absence-hub-tbl -->
                    </div>
                    <!-- hr-absence-hub -->
                    <div class="hr-absence-hub" id="tabs-3">
                        <div class="hr-absence-hub-tbl">
                            <table class="updateTableGroup">
                                <thead>
                                    <tr>    
                                        <th>Name</th>
                                        <th>Date of Submission</th>
                                        <th>Date of Arriving</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php
                                    $user=$_SESSION['currentUser'];
                                    $sql="SELECT * FROM `lab_management` WHERE user_id='$user'";
                                    $data = $dbF->getRows($sql);
                                    foreach ($data as $value) {
                                       echo'<tr><td>'.$value['name_of_patient'].'</td>
                                       <td>'.date("d-M-Y", strtotime($value['lab_work_sent'])).'</td>
                                       <td>'.date("d-M-Y", strtotime($value['arrival_date'])).'</td>
                                       <td><button class="del-btn" type="button" id="'.$value['id'].'" onclick="DltLabReport(this.id)"><i class="far fa-trash-alt"></i></button>
                                       <a data-toggle="tooltip" title="Edit" class="ablue" id="'.$value['id'].'" onclick="EditLabReport(this.id)"><i class="fas fa-edit"></i></a>
                                       </td></tr>
                                       ';

                                    }
                                    ?>
                                
                                </tbody>
                            </table>
                        </div>
                        <!-- hr-absence-hub-tbl -->
                    </div>
                    
                                     
                    <!-- hr-absence-hub -->
                </div>
            </div>
            <!-- hr-absence -->
           
        <div class="calendar">        

            <div id='calendar'></div>
        </div>
    </div>
    <!-- close -->
</div>
</div>
<!-- right_side close -->
<!-- </div> -->
<!-- left_right_side -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.js"></script>
<script>

$('#calendar').fullCalendar({
    header: {
        theme: true,
        left: 'prev,title,next ',
        center: '',
        right: 'month,basicWeek,basicDay,today',
    },
     eventMouseover: function(data, event) {
         if(data.sqltype == 'labManagement') {
          
         
         
        //  tooltip = '<div class="tooltiptopicevent" style="background-color: ' + data.color + '">Name : ' + data.title  + '<br>Patient ID : ' + data.patient_id  +'<br>Lab Name : ' + data.lab  + '<br>Surgery Number : ' + data.surgery_number  + '<br>Lab Work Sent : ' + data.fdate + '<br>Note : ' + data.note  + '</div>';
         
         
             tooltip = `<div class="tooltiptopicevent" style="border-bottom:15px solid  ${data.color} "><div><div class="arrow"><div style="position:relative">
         <div class="outer"></div><div class="inner"></div></div>
  </div><span>Name :</span>  ${data.title} <br><span>Patient ID :</span>  ${data.patient_id}<br><span>Lab Name :</span>   ${data.lab} <br><span>Surgery Number :</span>   ${data.surgery_number}<br><span>Lab Work Sent :</span>   ${data.fdate}<br><span>Note :</span>   ${data.note} </div></div>`;
         
         
        }else if(data.sqltype == 'labManagement2') {
          
          
        tooltip = `<div class="tooltiptopicevent" style="border-bottom:15px solid  ${data.color} "><div><div class="arrow"><div style="position:relative">
         <div class="outer"></div><div class="inner"></div></div>
  </div><span>Name :</span>  ${data.title} <br><span>Patient ID :</span>  ${data.patient_id}<br><span>Lab Name :</span>   ${data.lab} <br><span>Surgery Number :</span>   ${data.surgery_number}<br><span>Arrival date :</span>   ${data.fdate}<br><span>Note :</span>   ${data.note} </div></div>`;
          
          
         
        // tooltip = '<div class="tooltiptopicevent" style="background-color: ' + data.color + '">Name : ' + data.title  + '<br>Patient ID : ' + data.patient_id  +'<br>Lab Name : ' + data.lab  + '<br>Surgery Number : ' + data.surgery_number  + '<br>Arrival date : ' + data.fdate + '<br>Note : ' + data.note  + '</div>';
        }


        $("body").append(tooltip);
     
        $(this).mouseover(function(e) {
            $('.tooltiptopicevent').fadeIn('500');
            $('.tooltiptopicevent').fadeTo('10', 1.9);
        }).mousemove(function(e) {
            $('.tooltiptopicevent').css('top', e.pageY + 10);
            $('.tooltiptopicevent').css('left', e.pageX + 20);
        });

    },
    eventMouseout: function(data, event) {
        $(this).css('z-index', 8);
        $('.tooltiptopicevent').remove();

    },
    columnFormat: {
        week: 'D-MMM-YYYY\ndddd',
    },            
    firstDay: 1,
    defaultView: 'month',
    editable: false,
    eventLimit: true, // allow "more" link when too many events
    eventRender: function(event, element) {
        element.attr('id', event.id);
        element.attr('onclick', event.click);
        element.attr('data-type', event.type);
    },
    events: <?php echo $functions->UserslaBCalendar() ?>,
    // eventAfterAllRender: function() {
    //     $('.fc-head thead tr').prepend('<th class="fc-day-header fc-widget-header fc-sun">Image</th>');
    //     $('.fc-bg tbody tr').prepend('<td></td>');
    // },
    // eventAfterRender: function(event, element) {
    //     var data = element.parents('.fc-body .fc-content-skeleton table tbody tr').html();
    //     element.parents('.fc-body .fc-content-skeleton table tbody tr').html('<td class="fc-event-container"><img  src="images/' + event.image + '"></td>' + data);
    // }
});



        //for small delete in other project


</script>
<script>
    // $(function() {
// bind 'myForm' and provide a simple callback function
// $('#add_lab').ajaxForm(function() {
    // $('#loader').fadeIn(600);
// $(".updateTableGroup").load("lab-management.php .updateTableGroup", function() {
// $('#name_of_patient').val("");
    // $('#add_room_contact').val("");
    // $('#patient_id').val("");
    // $('#lab').val("");
    // $('#surgery_num').val("");
    // $('#name_of_dentist').val("");
    // $('#work_sent').val("");
    // $('#arrival_date').val("");
// });
// $('#loader').fadeOut(600);
// });
    
// 
// });

</script>
    <script>
    function DltLabReport(id){
        var result = confirm("Are you sure you want to delete?");
        if (result) {
            $.ajax({
                type: 'post',
                data: {id:id},
                url: 'ajax_call.php?page=dltLabReport',                
            }).done(function(data) {
                if (data == '1') {
                    $('#'+id).parents('tr').hide('slow');
                    location.reload();
                }
            });
        }
    }
    </script>
<?php include_once('dashboardfooter.php'); ?>