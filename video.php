<?php
$url = htmlspecialchars($_GET['url']);
include('global.php');
?>
<style type="text/css">
	iframe{
		border: 0;
		width: 100%;
		height: 500px;
		margin-top: 40px;
	}
	.ytp-chrome-top-buttons{
		display: none !important; 
	}
	.top{
		z-index: 99;
		height: 80px;
		width: 100%;
		position: fixed;
		/*top: 50px;*/
		left: 0;
	}
	.bottom{
		z-index: 99;
		height: 150px;
		width: 100%;
		position: fixed;
		bottom: 0;
		left: 0;
	}
</style>
 <?php                       $user = $_SESSION['currentUser'];
                            $sql1 = "SELECT * FROM `accounts_user` WHERE `acc_id` = ? ";
                            $data1 = $dbF->getRow($sql1,array($user)); ?>
                           

 <?php if ($data1['wellcome_video'] == '0' ) {?>







                        <div class="col-sm-4 btnvideo">
                        	
 <label><input type="checkbox" name="shwovideo" value="1" >&nbsp; Dont show again</label>

</div>
        
                 










<?php } ?>

<!-- <iframe frameborder="0" allowfullscreen="1" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" title="YouTube video player" width="600" height="400" src="https://www.youtube.com/embed/<?php echo $url; ?>?color=white&amp;autoplay=1&amp;controls=0&amp;fs=1&amp;loop=0&amp;modestbranding=0&amp;rel=0&amp;showinfo=0&amp;origin=https%3A%2F%2Fsmartdentalcompliance.com&amp;enablejsapi=1&amp;widgetid=1"></iframe> -->
<iframe width="600" height="400" src="https://www.youtube.com/embed/xLMOPtNauQk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
<div class="top"></div>
<div class="bottom"></div>



<script>
	

 $('input[type=checkbox][name="shwovideo"]').change(function() {
                                         var value =  $(this).val();
                                      console.log(value);
     // $("#action1").change(function(){

           // var value = $(this).val();
           // console.log(value);
          // var url = $(this).attr("url"); 

             $.ajax({
                type: 'POST',
                url: 'ajax_call.php?page=newuserwellcomevideo',
                data:"value="+value,  
            }).done(function(data){
               console.log(data);
                 
                  
                });
     }); 




</script>