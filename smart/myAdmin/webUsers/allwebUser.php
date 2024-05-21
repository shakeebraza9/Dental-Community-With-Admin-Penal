<?php
ob_start();

require_once("classes/webUsers.class.php");
global $dbF;

$webUsers  =   new webUsers();

?>
<h2 class="sub_heading"><?php echo $_e['All WebUser'];?></h2>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo $_e['All WebUser'];?></a></li>
       
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active container-fluid" id="home">
            <h2  class="tab_heading"><?php echo $_e['All Web Users'];?></h2>
            <?php $webUsers->allWebUser(); ?>
        </div>

        
    </div>


<script src="webUsers/js/user.js"></script>
<script>
      $(function(){
        tableHoverClasses();
        dateJqueryUi();
      });

    function deleteWebUser(ths){
        btn=$(ths);
        if(secure_delete()){
            btn.addClass('disabled');
            btn.children('.trash').hide();
            btn.children('.waiting').show();

            id=btn.attr('data-id');
            $.ajax({
                type: 'POST',
                url: 'webUsers/webUsers_ajax.php?page=deleteWebUser',
                data: { id:id }
            }).done(function(data)
                {
                    ift =true;
                    if(data=='1'){
                        ift = false;
                        btn.closest('tr').hide(1000,function(){$(this).remove()});
                    }
                    else if(data=='0'){
                        jAlertifyAlert('<?php echo $_e['Delete Fail Please Try Again.']; ?>');
                    }

                    if(ift){
                        btn.removeClass('disabled');
                        btn.children('.trash').show();
                        btn.children('.waiting').hide();
                    }
                });
        }
    }


      function activeWebUser(ths){
          btn=$(ths);
          if(secure_delete('<?php echo $_e['Are You Sure You Want TO Update?']; ?>')){
              btn.addClass('disabled');
              btn.children('.trash').hide();
              btn.children('.waiting').show();

              id=btn.attr('data-id');
              val =btn.attr('data-val');
              $.ajax({
                  type: 'POST',
                  url: 'webUsers/webUsers_ajax.php?page=activeWebUser',
                  data: { id:id,val:val }
              }).done(function(data)
                  {
                      ift =true;
                      if(data=='1'){
                          ift = false;
                          btn.closest('tr').hide(1000,function(){$(this).remove()});
                      }
                      else if(data=='0'){
                          jAlertifyAlert('<?php echo $_e['Update Fail Please Try Again.']; ?>');
                      }
                      if(ift){
                          btn.removeClass('disabled');
                          btn.children('.trash').show();
                          btn.children('.waiting').hide();
                      }

                  });
          }
      }


      function activeSponsor(ths){
          btn=$(ths);
          if(secure_delete('<?php echo $_e['Are You Sure You Want TO Change Sponsor Status?']; ?>')){
              btn.addClass('disabled');
              btn.children('.trash').hide();
              btn.children('.waiting').show();

              id=btn.attr('data-id');
              val =btn.attr('data-val');
              if(val=='0'){
                  val = '1';
              }else{
                  val = '0';
              }

              $.ajax({
                  type: 'POST',
                  url: 'webUsers/webUsers_ajax.php?page=activeSponsor',
                  data: { id:id,val:val }
              }).done(function(data)
              {
                  ift =true;
                  if(data=='1'){
                      ift = false;
                      btn.attr('data-val',val);
                      btn.children('.trash').removeClass('glyphicon-pushpin');
                      btn.children('.trash').removeClass('glyphicon-usd');
                      if(val=='1'){
                          btn.children('.trash').addClass('glyphicon-usd');
                          btn.attr('title','<?php echo  $_e['DeActive Sponsor'];?>');
                      }
                      else{
                          btn.children('.trash').addClass('glyphicon-pushpin');
                          btn.attr('title','<?php echo $_e['Make Sponsor'];?>');
                      }
                  }
                  else if(data=='0'){
                      jAlertifyAlert('<?php echo $_e['Update Fail Please Try Again.']; ?>');
                  }
                      btn.removeClass('disabled');
                      btn.children('.trash').show();
                      btn.children('.waiting').hide();

              });
          }
      }

      $('.account_type').on('click', function() {
          val = this.value;
          if(val == 'Master'){
            $('.master').show();
            $('.employee').hide();
            $('.practice').hide();
            $('.practice select,.employee select').removeAttr('name');
            $('.master select').attr('name','signUp[account_under][]');
          }
          else if(val == 'Practice'){
            //$('.practice').show();
            $('.employee').hide();
            $('.master').hide();
            $('.master select,.employee select').removeAttr('name');
            // $('.practice select').attr('name','signUp[account_under][]');
          }
          else if(val == 'Employee'){
            $('.employee').show();
            $('.practice').hide();
            $('.master').hide();
            $('.practice select,.master select').removeAttr('name');
            $('.employee select').attr('name','signUp[account_under][]');
          }
      });

</script>
<?php return ob_get_clean(); ?>