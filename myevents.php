<?php 

include_once("global.php");
$login       =  $webClass->userLoginCheck();
if(!$login){
echo "<script>location.reload();</script>";
}
$option = $functions->eventCategory();
$show = false;

@$id = ($_GET['id']);
$sql = "SELECT * FROM `myevents` WHERE `id`= ? ";
$data = $dbF->getRow($sql,array($id));
@$recurring_duration   = @$data['recurring_duration'];

if (@@$data['recurring_duration'] != '') {

$recurring = '<option Selected  value="'.$recurring_duration.'"> '.$recurring_duration.'</option>';
echo "<script>$('.rd').show();</script>";
}

else 
{

$recurring = '<option  selected disabled  value="">Select Recurring Duration</option>';
// echo "<script>$('.rd').hide();</script>";
}

// if ($id == 'undefined'  ||  @$data['status'] == 'complete'  && @$data['approved'] == '1' ) {
if ($id == 'undefined') {

$chek = '';
$display="style=display:none";

$data2=array();



}
else
{
$display="style=display:block";
 
$chek = '';
@$fetch_id = $data['fetch_id'];




if(empty($data['fetch_id'])){

    $fetch_id = $id;
}




 $sql2 = "SELECT * FROM `myeventform` WHERE `title_id`=? AND `publish`=?";
@$data2 = $dbF->getRows($sql2,array($fetch_id,"1"));



}













?>
<div class="event_details" id="myform">

<div class="form_heading">
    <h1>My Events</h1>
</div>

<div class="inner_forms">
<form method="post" action="calendar" enctype="multipart/form-data" class="main_form">
<?php echo $functions->setFormToken('myEvents',false); ?>
<input type="hidden" name="id" value="<?php echo @$data['id'] ?>">
<input type="hidden" value="<?php echo $id ?>" name="edit_id">
<input type="hidden" value="<?php echo @$fetch_id ?>" name="title_id">
<input type="hidden" value="<?php echo @$data['user'] ?>" name="cur_user">
<input type="hidden" value="<?php echo @$data['file'] ?>" name="old_file">
<div class="form-group-col3">

<div class="form-group mb-0">
<input type="text" class="form-control" name="title" value="<?php echo @$data['title'] ?>" required>
<label for="title" class="label">Event Name</label>
</div>

<div class="form-group mb-0">
 

<input class="datepicker form-control" id="from" type="text" value="<?php if(!empty(@$data['due_date'])) echo date('d-M-Y',strtotime(@$data['due_date'])) ?>" name="date" required autocomplete="off" readonly=''>
<label for="date" class="label">Due Date :</label>
</div>
 





<?php 



//Recurring Duration

echo '








<div class="form-group mb-0 rd">

<select class="form-control "  name="recurring_duration">
'.$recurring .'

<option value="No Recurrence">No Recurrence</option>
<option value="1 day">1 day</option>
<option value="1 week">1 week</option>
<option value="2 weeks">2 weeks</option>
<option value="3 weeks">3 weeks</option>
<option value="1 Month">1 Month</option>
<option value="2 Months">2 Months</option>
<option value="3 Months">3 Months</option>
<option value="4 Months">4 Months</option>
<option value="6 Months">6 Months</option>
<option value="12 Months">12 Months</option>
<option value="24 Months">24 Months</option>
<option value="36 Months">36 Months</option>
<option value="60 Months">60 Months</option>
</select>
<label for="recurring_duration" class="label2">Recurring Duration</label>


</div>'; ?>



</div>

<div class="form-group-flex">
<div class="form-group mb-0">
<select class="form-control " name="category" class="category" required>
<option selected disabled>Select Category</option>
<?php echo $option; ?>
</select>
<label for="category" class="label2">Select Category :</label>
<?php
if(@$data['category'] != ''){ ?>
<script>
$('.category').val('<?php echo @$data['category'] ?>').change();
</script>
<?php } ?>
</div>
<!-- form-group mb-0 -->



<?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0'){  echo '<input type="hidden" value="'.@$data['assignto'].'" name="assignto">';} else {
$selected = '';
if(strpos(@$data['assignto'],'-1') !== false){
$selected = 'selected';
}
?>



<div class="form-group mb-0">
<select class="form-control " name="assignto" class="assignto" required>
<option selected disabled>Select Employee</option>
<option <?php echo "value='-1.$_SESSION[currentUser]' $selected" ?>>All Employee</option>
<?php echo $functions->allEmployee($_SESSION['currentUser'],$data['assignto']) ?>
<option >Unassigned</option>
<option disabled>--Groups</option>
<?php echo $functions->allGroups($_SESSION['currentUser']) ?>
</select>
<label for="assignto" class="label2">Delegate Task :</label>
</div>


<!-- form-group col-sm-6 -->
<?php } ?>

</div>







<?php
if(@$data['status'] != ''){
if(@$data['status'] == 'Pending'){
?>
<div class="form-group-inline mb-0">
<div class="form-group mb-0">


<select class="form-control " name="status" class="status">
<option value="complete">Complete</option>
<option value="pending">Pending</option>


</select>
<label for="status" class="label2">Approved Status :</label>
<!-- <input type="text" class="status" name="status" value="pending"> -->
<script> 
$('.status').val('<?php echo @$data['status'] ?>').change();  
</script>

</div>
</div>
<?php 

}
else
{
   ?>
   <input type="hidden" class="status" name="status" value="pending">
   <?php 
}

}else{
?>






<input type="hidden" class="status" name="status" value="pending">

   <?php  
}
?>
<div class="form-group-flex">
<div class="form-group mb-0">
<select class="form-control" name="event_type" class="event_type" required>
<option selected disabled>Select Type</option>
<option value="recommended">Recommended</option>
<option value="mandatory">Mandatory</option>
</select>
<label for="event_type" class="label2">Select Type :</label>
<?php
if(@$data['type'] != ''){ ?>
<script>
$('.event_type').val('<?php echo @$data['type'] ?>').change();
</script>
<?php } ?>
</div>
<!-- form-group -->

<div class="form-group mb-0">
    <input type="file" id="upload" name="document" hidden>
    <label for="upload" class="upload_btn">Choose file</label>
    <span id="file-chosen">No file chosen</span>
    
<!-- 
    <input type="file" id="upload" hidden="">
    <label for="upload" class="upload_btn">Choose file</label>
    <span id="file-chosen" >No file chosen</span> -->
</div>
</div>

<div class="form-group-fw">
<div class="form-group mb-0">
<textarea class="form-control " id="desc" name="desc" placeholder="Details" cols="30" rows="10"><?php echo @$data['desc'] ?></textarea>
<label for="desc" class="label">Details :</label>

</div>
</div>

<?php
if(@$data['file'] != '' && @$data['file'] != '#'){
        echo $functions->downloadButton($data['file']);
    }
    
// if(@$data['file'] != '' && @$data['file'] != '#'){
// $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
// $ext = pathinfo(@$data['file'], PATHINFO_EXTENSION);
// if (!in_array($ext, $allowed)) {
// echo "<div class='form-group'><a href='http://view.officeapps.live.com/op/view.aspx?src=".WEB_URL."/images/$data[file]' title='View/Download' class='dbtn' data-toggle='tooltip' target='_blank'><i class='fas fa-file'></i>&nbsp;&nbsp;Download File</a>";

// if (@$data['approved'] != '-1') {


// echo "<a data-id='$id' onclick='AjaxDelScriptmy(this);' class='btn  secure_delete' >


// <i class='idbtn glyphicon glyphicon-trash trash fa fa-times-circle' ></i>
// <i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i>
// </a>";

// }

// echo "</div>";
// }
// else {
// echo "<div class='form-group'><a href='$data[file]' title='View/Download' class='dbtn' data-toggle='tooltip' target='_blank'><i class='fas fa-file'></i>&nbsp;&nbsp;Download File</a>
// ";
// if (@$data['approved'] != '-1') {


// echo "<a data-id='$id' onclick='AjaxDelScriptmy(this);' class='btn  secure_delete' >


// <i class='idbtn glyphicon glyphicon-trash trash fas fa-times-circle' ></i>
// <i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i>
// </a>";

// }

// echo "</div>";
// }
// }
 
?>


 


<?php
if (!empty(@$data2)) {
?>

<h4 style="    text-align: center;">Add / Update Custom Questions</h4>

<?php

    $ij = 0;
foreach ($data2 as $keyc => $valuec) {


?>


<div class="delWhole" id="paa<?php echo $valuec['id'] ?>"><input type="hidden" name="fid[]" value="<?php echo $valuec['id'] ?>">
<div class="sub-form">
<hr>

<div class="form-group-fw">
<div class="form-group mb-0">
<textarea class="form-control" id="question" name="question[]" placeholder="Question" required><?php echo @$valuec['question'] ?></textarea>
<label for="question" class="label">Question</label>
</div>
</div>


<div class="form-group-col3">
<div class="form-group mb-0">
<input type="text" name="categoryS[]" class="form-control" value="<?php echo $valuec['category'] ?>"  autocomplete="off" placeholder="Category">
<label for="categoryS" class="label">Category :</label>
</div>


<div class="form-group mb-0">
<input class="form-control" type="text" name="field1[]" value="<?php echo $valuec['field1'] ?>" placeholder="e.g. Comments, Actions" autocomplete="off">
<label for="field1" class="label">Field 1 :</label>
</div>

<div class="form-group mb-0">
<input class="form-control" type="text" name="field2[]" value="<?php echo $valuec['field2'] ?>" placeholder="e.g. Temperature" autocomplete="off">
<label for="field2" class="label">Field 2 :</label>

</div>
</div>
<div class="form-group mb-0">
<label>Response :</label>


<div class="covidshowbtn">
<div class="switch-field">
<input type="checkbox" id="radio-yes<?php echo $valuec['id'] ?>" name="rRadio[<?php echo $ij ?>]" value="Radio" <?php  if(@$valuec['radio']=="Radio" )echo "checked" ; ?>  />
<label for="radio-yes<?php echo $valuec['id'] ?>">Radio</label>
<input type="checkbox" id="radio-Date<?php echo $valuec['id'] ?>" name="rDate[<?php echo $ij ?>]" value="Date" <?php  if(@$valuec['date']=="Date" )echo "checked" ; ?>  />
<label for="radio-Date<?php echo $valuec['id'] ?>">Date</label>
<input type="checkbox" id="radio-Time<?php echo $valuec['id'] ?>" name="rTime[<?php echo $ij ?>]" value="Time" <?php  if(@$valuec['time']=="Time" )echo "checked" ; ?>  />
<label for="radio-Time<?php echo $valuec['id'] ?>">Time</label>
</div>
</div>




 
 
     <p class="btn btn-danger" onclick="deleteAjaxFormId(<?php echo $valuec['id'] ?>)"><i class="fas fa-trash"></i></p>
</div>
</div>
</div>
<?php
$ij++;
 
}
?>

<div id="addmoreEdit"></div>
<button type="button" class="submit_class add_field_button"  onclick="add_contactEdit(<?php echo $ij ?>)" style="
    float: right;
"><?php  $dbF->hardWords('Add more'); ?></button> 
<?php
}else{
?>
<h4 style="    text-align: center;">Add Custom Questions</h4>
<div class="sub-form">
<hr>

<div class="delWhole" id="p0">

<div class="form-group-fw">
<div class="form-group mb-0">
<textarea class="form-control" id="question" name="question[]" placeholder="Question" required><?php echo @$valuec['question'] ?></textarea>
<label for="question" class="label">Question</label>
</div>
</div>



<div class="form-group-col3">
<div class="form-group mb-0">
<input type="text" name="categoryS[]" class="form-control"  autocomplete="off" placeholder="Category">
<label for="categoryS" class="label">Category :</label>
</div>


<div class="form-group mb-0">
<input class="form-control" type="text" name="field1[]" value="" placeholder="e.g. Comments, Actions" autocomplete="off">
<label for="field1" class="label">Field 1 :</label>
</div>

<div class="form-group mb-0">
<input class="form-control" type="text" name="field2[]" value="" placeholder="e.g. Temperature" autocomplete="off">
<label for="field2" class="label">Field 2 :</label>

</div>
</div>

<div class="form-group mb-0">
<label>Response :</label>
<div class="covidshowbtn">
<div class="switch-field">

<input type="checkbox" id="radio-Radio" name="rRadio[0]" value="Radio" />
<label for="radio-Radio">Radio</label>


<input type="checkbox" id="radio-Date" name="rDate[0]" value="Date" />
<label for="radio-Date">Date</label>

<input type="checkbox" id="radio-Time" name="rTime[0]" value="Time" />
<label for="radio-Time">Time</label>

</div>
</div>




    <p class="btn btn-primary" onclick="add_contact(this)">Add more</p>  
 
     <p class="btn btn-danger" onclick="del_contact('0')"><i class="fas fa-trash"></i></p>

</div>
</div>
<div class="addmore"></div>
<!-- <br>
<button type="button" class="submit_class add_field_button"  onclick="add_contact(this)" >+    &nbsp;&nbsp;&nbsp;<?php  $dbF->hardWords('Add more'); ?></button> 
<br> -->

</div>
<?php
} ?>
<?php if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['ccalendar'] == 'edit' || $_SESSION['superUser']['ccalendar'] == 'full'){ ?>
<?php echo $chek; ?>
<?php } ?>
<!-- form-group -->




<?php
if($_SESSION['userType']=='Trial')
  { 
      echo'<input type="button" class="submit_class" value="Save event" onclick="alertbx()" name="">';
  }else{
if ($id == 'undefined') {
echo '<input type="submit" class="submit_class" value="Save event" name="submit">';
}
else{
echo '<input type="submit" class="submit_class" value="Save event" name="edit">';
if (!isset($_GET['new']) && $_SESSION['currentUserType'] != 'Employee') {
    
echo '<input type="submit" class="submit_class asNewEvent"  value="Save new event" name="submit">';
}
}
}
?>
</div>
</form>
</div><!-- form_side close -->
</div><!-- event_details -->

<!-- <style type="text/css">
    
    p.delCSS {
    position: absolute;
    right: 0;
    /* bottom: 0; */
    transform: translateY(-50%);
    top: 50%;
}


div.delWhole {
    position: relative;
}
</style> -->

<script>
  document.getElementById('upload').addEventListener('change', function() {
    var fileChosen = document.getElementById('file-chosen');
    var fileName = this.value.split("\\").pop();
    fileChosen.textContent = fileName;
  });
  
  
  
  
  $((function() {
    (new WOW).init(), $('[data-toggle="tooltip"]').tooltip(), $(".datepicker").datepicker({
        dateFormat: "d-M-yy",
        changeMonth: !0,
        changeYear: !0,
        yearRange: "-80:+20",
        showButtonPanel: !0
    }),
     $(".datepickerr").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: !0,
        changeYear: !0,
        yearRange: "-80:+20",
        showButtonPanel: !0
    }), 
    $(".datepickerr").datepicker({
        dateFormat: "d-M-yy",
        changeMonth: !0,
        changeYear: !0,
        yearRange: "-80:+20",
        showButtonPanel: !0
    }), $(".timepicker").timepicker({
        hourGrid: 4,
        minuteGrid: 10,
        timeFormat: "hh:mm tt"
    }), $("#banner").ulslide({
        effect: {
            type: "crossfade",
            axis: "x",
            showCount: 0,
            distance: 20
        },
        pager: "#slide-pager a",
        nextButton: ".banner_left",
        prevButton: ".banner_right",
        duration: 900,
        mousewheel: !1,
        autoslide: 14e3,
        animateOut: "fadeOut",
        animateIn: "fadeIn"
    }), $(".fancybox").fancybox(), $(".header_side .col1_btn,.col10 .col1_btn").click((function() {
        $("html, body").animate({
            scrollTop: 0
        }, "slow"), $(".background_side").fadeToggle(), $(".col101_book").fadeToggle()
    }))
    // , $(".webBtn").click((function() {
    //     $("html, body").animate({
    //         scrollTop: 0
    //     }, "slow"), $(".background_side").fadeToggle(), $(".col101_webinar").fadeToggle(),
    //     $(".webinarTitle").val($(this).children(".webinarName").val()),
    //     $(".zoomLink").val($(this).children(".zoomLink").val())
    // })),$(".freeResourseDownloadBtn").click((function() {
    //     if($("#resourceFormSubmit").val() == 1){
    //         alert('Please refresh the page to download again');
    //       location.reload();
    //         return false
    //     }
    
    //     $("html, body").animate({
    //         scrollTop: 0
    //     }, "slow"), $(".background_side").fadeToggle(), $(".col101_free_resource_registration").fadeToggle(),
    //     $(".resourceTitle").val($(this).children(".title").val()),
    //     $(".resourceLink").val($(this).children(".file_id").val())

    // }))
    , $("#tabs .col4_top_box .col1_btn,#tabs .col15 .col1_btn,#tabs .col3 .col1_btn").click((function() {
        $("html, body").animate({
            scrollTop: 0
        }, "slow"), $(".background_side").fadeToggle(), $(".col101_cart").fadeToggle(), $("#checkoutBtn").prop("disabled", !0)
    })), $("#tabs .col1_btn22").click((function() {
        name = $(this).find("a").attr("data-name"), $(".col101_cart2 h1").text(name), $(".col101_cart2").find(".pname").val(name), $("html, body").animate({
            scrollTop: 0
        }, "slow"), $(".background_side").fadeIn(), $(".col101_cart2").fadeToggle()
    })), $(".close_popup").click((function() {
        $(".background_side").fadeOut(), $(".col101").fadeOut()
    })), $("#menu").mmenu({
        extensions: ["effect-menu-zoom", "effect-panels-zoom", "pagedim-black", "theme-dark"],
        offCanvas: {
            position: "left"
        },
        counters: !0,
        iconPanels: !0,
        navbars: [{
            position: "top"
        }]
    }), $(window).scroll((function() {
        var e = $(".header");
        $(window).scrollTop() >= 100 ? e.addClass("sticky") : e.removeClass("sticky")
    })), $(".next_button").click((function() {
        $(".next_button1").show(), $(this).hide()
    })), $("#tabs").tabs(), $("#tabs_").tabs(), $("#stocktabs").tabs(), $(".col1_btn2").click((function() {
        $(".col5").toggleClass("col5_")
    })), $(".col1_btn2").click((function() {
        $(".fixed_side").toggleClass("fixed_side_")
    })), $(".col5_close").click((function() {
        $(".fixed_side").removeClass("fixed_side_"), $(".col5").removeClass("col5_"), $(".myevents-div").removeClass("myevents-div_"), $(".myevents-div").removeClass("redborder"), $(".myevents-div").removeClass("blueborder"), $(".myevents-div").removeClass("greenborder"), $("[title='chat widget']").parent("div").attr("style", "display: block !important;position: fixed !important"), setTimeout((function() {
            $(".myevents-form").empty(), $(".myevents-div #loader").show()
        }), 1e3)
    })), $(".col4_main h5").click((function() {
        var e = $(this).attr("class");
        $(this).hasClass("atv") || ($(this).parent("div").find("h5").removeClass("atv"), $(this).addClass("atv"), $(this).parent("div").find(".col4_main_left ul li").hide(), $(this).parent("div").find(".col4_main_left ul li." + e).show(), $(this).parent("div").find(".file-box .file-box-desc").hide(), $(this).parent("div").find(".file-box div." + e).show())
    })), $(".cpd-courses h5").click((function() {
        $(".cpd-courses h5").removeClass("atv"), $(this).addClass("atv");
        var e = $(this).attr("data-filter");
        return $(".grid").isotope({
            filter: e,
            animationOptions: {
                duration: 750,
                easing: "linear",
                queue: !1
            }
        }), !1
    })), $(".optn").on("change", (function() {
        var e = $("#optn").val();
        "all" == e ? $(".main-row").show() : $(".main-row").hide(), $(".main-row").find("h5:contains(" + e + ")").parents(".main-row").show()
    })), jQuery.expr[":"].contains = function(e, t, i) {
        return jQuery(e).text().toUpperCase().indexOf(i[3].toUpperCase()) >= 0
    }, $("#kywd").bind("keyup change", (function() {
        var e = $("#kywd").val();
        $(".main-row-down ul li").hide(), $(".main-row-down ul li:contains(" + e + ")").show(), "all" == $("#optn").val() && $(".main-row").each((function() {
            if ($(this).find('.main-row-down ul li[style="display: flex;"]').length > 0) return $(this).show();
            $(this).hide()
        }))
    })), $(".close_btn").click((function() {
        $(".popup").fadeOut(600)
    })), $(".fancybox").fancybox();
    // var e = setInterval((function() {
    //     var t, i;
    //     new Date;
    //     t = document.createElement("script"), i = document.getElementsByTagName("script")[0], t.async = !0, t.src = "https://embed.tawk.to/5cdbdb8ed07d7e0c6393b33a/default", t.charset = "UTF-8", t.setAttribute("crossorigin", "*"), i.parentNode.insertBefore(t, i), clearInterval(e)
    // }), 100);
    setTimeout((function() {
        $("#loader").fadeOut(600), $(".col5 .tble table td:first-child,.col5 .tble table th:first-child").each((function() {
            var e = $(this).innerHeight();
            e = parseInt(e) - 1;
            $(this).css({
                position: "fixed",
                display: "flex",
                height: e
            })
        }))
    }), 500),
    
 $(".link_menu").click((function() {
        $(".links_area").addClass("showmenu")
    })),
    
    $(".close_side").click((function() {
        $(".links_area").removeClass("showmenu")
    })), 
    
    $(".u-vmenu").vmenuModule({
        Speed: 100,
        autostart: !0,
        autohide: !0
    }), $("#tabs").tabs(), $("#dialog").dialog({
        title: "Notice!",
        dialogClass: "alert",
        width: 400,
        position: {
            my: "left bottom",
            at: "left bottom",
            of: window
        }
    }), $(".noti").click((function() {
        $("body").css("overflow", "hidden"), $(".notify").css("transform", "scaleX(1)"), $(".fixed_side").toggleClass("fixed_side_")
    })), $(".notif").click((function() {
        $("body").css("overflow", "hidden"), $(".notifys").css("transform", "scaleX(1)"), $(".fixed_side").toggleClass("fixed_side_")
    })), $(".notify-top i").click((function() {
        $(".notify").css("transform", "scaleX(0)"), $(".fixed_side").toggleClass("fixed_side_"), $("body").css("overflow", "visible")
    })), "interactive" === document.readyState && $(".listitems").html((function() {
        return $(this).children().sort(((e, t) => $(e).text().trim().localeCompare($(t).text().trim())))
    })), $(".main-row-top i").click((function() {
        $(this).parent("div").next(".main-row-down").slideToggle("slow"), $(this).toggleClass("fa-chevron-up")
    })), $(".main-row-tops i").click((function() {
        $(this).next(".main-row-down").slideToggle("slow"), $(this).toggleClass("fa-chevron-up")
    })), $("#src-event").bind("keyup", (function() {
        var e = $(this).val();
        $(".col4_main_left ul li").hide(), $(".col4_main_left ul li:contains(" + e + ")").show()
    })), $("#profile-src-event").bind("keyup", (function() {
        var e = $(this).val();
        $(".user-box").hide(), $(".user-box:contains(" + e + ")").show()
    })), $("#pro-src-notif").bind("keyup", (function() {
        var e = $(this).val();
        $(".notifall").hide(), $(".notifall:contains(" + e + ")").show()
    })), $('[data-toggle="tooltip"]').tooltip()
}))

</script>





<script>
$(".asNewEvent").click(function(event)
  {
    if(!confirm("Are You Sure You Want To Copy This Event To As A New Event?")){
        event.preventDefault(); 
       return false;   
    }
    
  });

$('[data-toggle="tooltip"]').tooltip();
$(".datepicker").datepicker({ dateFormat: 'd-M-yy',
changeMonth: true,
changeYear: true,
yearRange: "-80:+20",
showButtonPanel:true,
});
$('.file input').on('change', function() {
filename = this.files[0].name;
$(this).parent('div').find('div').text(filename);
});







function deleteAjaxFormId(ths){
// btn=$(ths);
// console.log(btn);
// console.log(ths);
if(secure_delete()){
// btn.addClass('disabled');
// btn.children('.trash').hide();
// btn.children('.waiting').show();

// id=btn.attr('data-id');
$.ajax({
type: 'POST',
url: 'ajax_call.php?page=deleteAjaxFormId',   
data: { id:ths }
}).done(function(data)
{


    $('#paa'+ths).remove();




});
}
};

function AjaxDelScriptmy(ths){
btn=$(ths);
console.log(btn);
console.log(ths);
if(secure_delete()){
btn.addClass('disabled');
btn.children('.trash').hide();
btn.children('.waiting').show();

id=btn.attr('data-id');
$.ajax({
type: 'POST',
url: 'ajax_call.php?page=DeleteMyEventFile',   
data: { id:id }
}).done(function(data)
{
ift =true;
console.log(data);
if(data > 0 ){
console.log(data);




// Remove row from HTML Table
$(ths).closest('div').css('background','e5f3f2');
$(ths).closest('div').fadeOut(800,function(){
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


//for small delete in other project
function secure_delete(text){
// text = 'view on alert';
text = typeof text !== 'undefined' ? text : 'Are you sure you want to Delete?';

bool=confirm(text);
if(bool==false){return false;}else{return true;}


}








var c = 0;
function add_contactEdit(ths){


var contact_texts = '<div id ="pa'+c+'" class="delWhole"><div class="form-group-fw"><div class="form-group mb-0"><textarea class="form-control" id="question" name="question[]" placeholder="Question" required=""></textarea><label for="question" class="label">Question</label></div></div><div class="form-group-col3"><div class="form-group mb-0"><input class="form-control" type="text" name="categoryS[]"   autocomplete="off" placeholder="Category"><label for="categoryS" class="label">Category :</label></div><div class="form-group mb-0"><input class="form-control" type="text" name="field1[]" value="" placeholder="e.g. Comments, Actions" autocomplete="off"><label for="field1" class="label">Field 1 :</label></div><div class="form-group mb-0"><input class="form-control" type="text" name="field2[]" value="" placeholder="e.g. Temperature" autocomplete="off"><label for="field2" class="label">Field 2 :</label></div></div><div class="form-group col-5 mb-0"><label>Response :</label><div class="covidshowbtn"><div class="switch-field"><input type="checkbox" id="radio-Radio'+c+'" name="erRadio['+c+']" value="Radio" /><label for="radio-Radio'+c+'">Radio</label><input type="checkbox" id="radio-Date'+c+'" name="erDate['+c+']" value="Date" /><label for="radio-Date'+c+'">Date</label><input type="checkbox" id="radio-Time'+c+'" name="erTime['+c+']" value="Time" /><label for="radio-Time'+c+'">Time</label></div><p class="btn btn-danger pa'+c+' delCSS" onclick="del_contactde('+c+')"><i class="fas fa-trash"></i></p></div></div><!-- <p onclick="del_contactde('+c+')" class ="pa'+c+' delCSS"><i class="fas fa-trash"></i></p> --></div>';
$('#addmoreEdit').append(contact_texts);
c++;}



function del_contactde(c){

$('#pa'+c).remove();
$('.pa'+c).remove();
}

var c = 0;
function add_contact(ths){

    // console.log(ths);
    // console.log(this);
    // $(this).remove();
c++;



var contact_text = '<div id ="p'+c+'" class="delWhole"><div class="form-group-fw"><div class="form-group mb-0"><textarea class="form-control" id="question" name="question[]" placeholder="Question" required=""></textarea><label for="question" class="label">Question</label></div></div><div class="form-group-col3"><div class="form-group mb-0"><input class="form-control" type="text" name="categoryS[]"   autocomplete="off" placeholder="Category"><label for="categoryS" class="label">Category :</label></div><div class="form-group mb-0"><input class="form-control" type="text" name="field1[]" value="" placeholder="e.g. Comments, Actions" autocomplete="off"><label for="field1" class="label">Field 1 :</label></div> <div class="form-group mb-0"><input class="form-control" type="text" name="field2[]" value="" placeholder="e.g. Temperature" autocomplete="off"><label for="field2" class="label">Field 2 :</label></div></div><div class="form-group mb-0"><label>Response :</label><div class="covidshowbtn"><div class="switch-field"><input type="checkbox" id="radio-Radio'+c+'" name="rRadio['+c+']" value="Radio" /><label for="radio-Radio'+c+'">Radio</label><input type="checkbox" id="radio-Date'+c+'" name="rDate['+c+']" value="Date" /><label for="radio-Date'+c+'">Date</label><input type="checkbox" id="radio-Time'+c+'" name="rTime['+c+']" value="Time" /><label for="radio-Time'+c+'">Time</label></div></div><p class="btn btn-primary" onclick="add_contact(this)">Add more</p>&nbsp;<p class="btn btn-danger" onclick="del_contact('+c+')"><i class="fas fa-trash"></i></p><!-- <p onclick="del_contact('+c+')" class ="delCSS p'+c+'"><i class="fas fa-trash"></i></p> --></div></div></div>';
$('.addmore').append(contact_text);
}



function del_contact(c){

$('#p'+c).remove();
$('.p'+c).remove();
}

// function delAddmore(){

// $('.alert').remove();
 
// }
var $dropzone = document.querySelector('.form_side');
    var input = document.getElementById('file-upload');
if($dropzone != null){
    $dropzone.ondragover = function (e) { 
      e.preventDefault(); 
      this.classList.add('dragover');
    };
    $dropzone.ondragleave = function (e) { 
        e.preventDefault();
        this.classList.remove('dragover');
    };
    $dropzone.ondrop = function (e) {
        e.preventDefault();
        this.classList.remove('dragover');
        input.files = e.dataTransfer.files;
        filename =  e.dataTransfer.files[0].name;
        $('#file-upload').parent('div').find('div').text(filename);




        }
    function alertbx(){
  alert("To unlock this feature please upgrade your package...");
}
}

</script>