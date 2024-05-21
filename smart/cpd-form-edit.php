<?php 
include_once("global.php");

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}
$lable = htmlspecialchars($_GET['lable']);
$name = htmlspecialchars($_GET['name']);
$Id = htmlspecialchars($_GET['id']);
$lable = str_replace('_',' ',$lable);




?>
<div class="event_details" id="myform">
    <h3>Initial CPD Form</h3>
    <div class="form_side">
        <form method="post" action="cpd-form" enctype="multipart/form-data">
            <?php echo $functions->setFormToken('initial-cpdEdit',false); ?>
           <div class="form-group col-12 col-sm-6">
                        <label><?php echo $lable ?> :</label>
                        <input type="number"  name="cpds[<?php echo $name ?>] " value="">
                        <input type="hidden"  name="cpdId" value="<?php echo $Id ?>">
                    </div>

                     <input  type="submit" class="submit_class" value="Update Information" name="submit">
        </form>
    </div><!-- form_side close -->
</div><!-- event_details -->
<script>
$('[data-toggle="tooltip"]').tooltip();
$(".datepicker").datepicker({ dateFormat: 'd-M-yy',
          changeMonth: true,
          changeYear: true,
      yearRange: "-100:+0",
      showButtonPanel:true,
   
 });

</script>
<script>
        function AjaxDelScript(ths){
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


    </script>