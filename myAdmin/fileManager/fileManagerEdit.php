<?php
ob_start();

require_once("classes/fileManager.class.php");
global $dbF;

$filesManager  =   new filesManager();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$filesManager->filesManagerEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Files']); ?></h2>
<?php $filesManager->filesManagerEdit(); ?>

<script>
    $(function(){
        dateJqueryUi();
    });

$('#make-switch0').on('change', function() {
var chk = $('.checkboxHidden').val();
if(chk=='1'){
$('#users').show();
$('#users select').attr("name","assignto");
}
else {
$('#users select').removeAttr("name");
$('#users').hide();
}
});
///===========================================
 $(document).ready(function() {
 $('#make-switch1').on('switch-change', function (e, data) {
            console.log(data.value);
        if(data.value  == false ){
        console.log("bad");
        $('.layer1').attr("name","file");
        $(".ly1").show();
        $(".ly0").hide();
        $(".ly3").hide();
        $('.layer0').removeAttr("name");
      }
      else
      {

        console.log("good");
        $(".ly0").show();
        $(".ly3").show();
        $(".ly1").hide();
        $('.ly0 .layer0').attr("name","file");
       $('.ly1 .layer1').removeAttr("name");


        
      }
           
               });  

      
    });
$('.APIedit').on('click', function() {
    $(this).prop('disabled', true);
    var url = this.id;
    $.get("https://script.google.com/macros/s/AKfycbyF0ZruTXnjYPGrD02L306gOd50I9LSEjHcN6wVCR_Qaa4ReJNY/exec?url="+url, function(id) {
        localStorage.setItem("url",url);
        document.cookie="id="+id;
        $.get("https://script.google.com/macros/s/AKfycbwYy6HL5H9O85RtbH5YXBIJxnrO_Pd175XZJRW0ww/exec?id="+id, function(editurl) {
            document.cookie="editurl="+editurl; 
            $.get("https://script.google.com/macros/s/AKfycbx_uPRmTSV6kXAKe4Lhw-xwSG_y9giQHEaMeFwNcHGMun6doBqr/exec?id="+id);
            location.replace("<?php echo WEB_ADMIN_URL ?>/-fileManager?page=fileEdit");
        });
    });
});


</script>
<?php return ob_get_clean(); ?>