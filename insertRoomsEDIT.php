<?php 
include_once("global.php");
$login       =  $webClass->userLoginCheck();
if(!$login){
echo "<script>location.reload();</script>";
exit();
}
$show = false;
$id = intval($_GET['id']);
$sql = "SELECT * FROM `insertRooms` WHERE `id`='$id'";
$data = $dbF->getRow($sql);
?>
<div class="event_details" id="myform">
<h3>Room Management Edit</h3>
<div class="form_side">
<form method="post" id="myForm" action="practice-profile">
<?php echo $functions->setFormToken('insertRoomsEDIT',false); ?>


<div class="form-group">
<label>Name :</label>
<input type="text" name="changename" value="<?php echo $data['name'] ?>" required>

 


</div>











<div class="form-group">
<label>Select Color :</label>
<!-- <input type="color" name="changeColor" value="<?php //echo $data['color'] ?>" required> -->


<select name="changeColor">
<option value="<?php echo $data['color'] ?>" selected=""><?php echo $data['color'] ?></option>  


<option value="Black" style="background:black;">Black</option>             
<option value="Navy" style="background:navy;">Navy</option>
<option value="DarkBlue" style="background:darkBlue;">DarkBlue</option>        
<option value="MediumBlue" style="background:MediumBlue;">MediumBlue</option>
<option value="Blue" style="background:blue;">Blue</option>
<option value="DarkGreen" style="background:darkGreen;">DarkGreen</option>
<option value="Green" style="background:green;">Green</option>
<option value="Teal" style="background:teal;">Teal</option>
<option value="DarkCyan" style="background:darkcyan;">DarkCyan</option>
<option value="DeepSkyBlue" style="background:deepskyblue;">DeepSkyBlue</option>
<option value="DarkTurquoise" style="background:darkturquoise;">DarkTurquoise</option>
<option value="MediumSpringGreen" style="background:mediumspringgreen;">MediumSpringGreen</option>
<option value="Lime" style="background:lime;">Lime</option>
<option value="SpringGreen" style="background:springgreen;">SpringGreen</option>
<option value="Aqua" style="background:aqua;">Aqua</option>
<option value="Cyan" style="background:cyan;">Cyan</option>
<option value="MidnightBlue" style="background:midnightblue;">MidnightBlue</option>
<option value="DodgerBlue" style="background:dodgerblue;">DodgerBlue</option>
<option value="LightSeaGreen" style="background:lightseagreen;">LightSeaGreen</option>
<option value="ForestGreen" style="background:forestgreen;">ForestGreen</option>
<option value="SeaGreen" style="background:seagreen;">SeaGreen</option>
<option value="DarkSlateGray" style="background:darkslategray;">DarkSlateGray</option>
<option value="arkSlateGrey" style="background:arkslategrey;">DarkSlateGrey</option>
<option value="LimeGreen" style="background:limegreen;">LimeGreen</option>
<option value="MediumSeaGreen" style="background:mediumseagreen;">MediumSeaGreen</option>
<option value="Turquoise" style="background:turquoise;">Turquoise</option>
<option value="RoyalBlue" style="background:royalblue;">RoyalBlue</option>
<option value="SteelBlue" style="background:steelblue;">SteelBlue</option>
<option value="DarkSlateBlue" style="background:darkslateblue;">DarkSlateBlue</option>
<option value="MediumTurquoise" style="background:mediumturquoise;">MediumTurquoise</option>
<option value="Indigo" style="background:indigo;">Indigo  </option>  
<option value="DarkOliveGreen" style="background:darkolivegreen;">DarkOliveGreen</option>
<option value="CadetBlue" style="background:cadetblue;">CadetBlue</option>
<option value="CornflowerBlue" style="background:cornflowerblue;">CornflowerBlue</option>
<option value="RebeccaPurple" style="background:rebeccapurple;">RebeccaPurple</option>
<option value="MediumAquaMarine" style="background:mediumaquamarine;">MediumAquaMarine</option>
<option value="DimGray" style="background:dimgray;">DimGray</option>
<option value="DimGrey" style="background:dimgrey;">DimGrey</option>
<option value="SlateBlue" style="background:slateblue;">SlateBlue</option>
<option value="OliveDrab" style="background:olivedrab;">OliveDrab</option>
<option value="SlateGray" style="background:slategray;">SlateGray</option>
<option value="SlateGrey" style="background:slategrey;">SlateGrey</option>
<option value="LightSlateGray" style="background:lightslategray;">LightSlateGray</option>
<option value="LightSlateGrey" style="background:lightslategrey;">LightSlateGrey</option>
<option value="MediumSlateBlue" style="background:mediumslateblue;">MediumSlateBlue</option>
<option value="LawnGreen" style="background:lawngreen;">LawnGreen</option>
<option value="Chartreuse" style="background:chartreuse;">Chartreuse</option>
<option value="Aquamarine" style="background:aquamarine;">Aquamarine</option>
<option value="Maroon" style="background:Maroon;">Maroon</option>
<option value="Purple" style="background:purple;">Purple</option>
<option value="Olive" style="background:olive;">Olive</option>
<option value="Gray" style="background:gray;">Gray</option>
<option value="Grey" style="background:grey;">Grey</option>
<option value="SkyBlue" style="background:skyblue;">SkyBlue</option>
<option value="LightSkyBlue" style="background:lightskyblue;">LightSkyBlue</option>
<option value="BlueViolet" style="background:blueviolet;">BlueViolet</option>
<option value="DarkRed" style="background:darkred;">DarkRed</option>
<option value="DarkMagenta" style="background:darkmagenta;">DarkMagenta</option>
<option value="SaddleBrown" style="background:saddlebrown;">SaddleBrown</option>
<option value="DarkSeaGreen" style="background:darkseagreen;">DarkSeaGreen</option>
<option value="LightGreen" style="background:lightgreen;">LightGreen</option>
<option value="MediumPurple" style="background:mediumpurple;">MediumPurple</option>
<option value="DarkViolet" style="background:darkviolet;">DarkViolet</option>
<option value="PaleGreen" style="background:palegreen;">PaleGreen</option>
<option value="DarkOrchid" style="background:darkorchid;">DarkOrchid</option>
<option value="YellowGreen" style="background:yellowgreen;">YellowGreen</option>
<option value="Sienna" style="background:sienna;">Sienna</option>
<option value="Brown" style="background:brown;">Brown</option>
<option value="DarkGray" style="background:darkgray;">DarkGray</option>
<option value="DarkGrey" style="background:darkgrey;">DarkGrey</option>
<option value="LightBlue" style="background:lightblue;">LightBlue</option>
<option value="GreenYellow" style="background:greenyellow;">GreenYellow</option>
<option value="PaleTurquoise" style="background:paleturquoise;">PaleTurquoise</option>
<option value="LightSteelBlue" style="background:lightsteelblue;">LightSteelBlue</option>
<option value="PowderBlue" style="background:powderblue;">PowderBlue</option>
<option value="FireBrick" style="background:firebrick;">FireBrick</option>
<option value="DarkGoldenRod" style="background:darkgoldenrod;">DarkGoldenRod</option>
<option value="MediumOrchid" style="background:mediumorchid;">MediumOrchid</option>
<option value="RosyBrown" style="background:rosybrown;">RosyBrown</option>
<option value="DarkKhaki" style="background:darkkhaki;">DarkKhaki</option>
<option value="Silver" style="background:silver;">Silver</option>
<option value="MediumVioletRed" style="background:mediumvioletred;">MediumVioletRed</option>
<option value="IndianRed" style="background:indianred;">IndianRed </option> 
<option value="Peru" style="background:peru;">Peru</option>
<option value="Chocolate" style="background:chocolate;">Chocolate</option>
<option value="Tan" style="background:tan;">Tan</option>
<option value="TanLightGray" style="background:tanlightgray;">LightGray</option>
<option value="LightGrey" style="background:lightgrey;">LightGrey</option>
<option value="Thistle" style="background:thistle;">Thistle</option>
<option value="Orchid" style="background:orchid;">Orchid</option>
<option value="GoldenRod" style="background:goldenrod;">GoldenRod</option>
<option value="PaleVioletRed" style="background:palevioletred;">PaleVioletRed</option>
<option value="Crimson" style="background:crimson;">Crimson</option>
<option value="Gainsboro" style="background:gainsboro;">Gainsboro</option>
<option value="Plum" style="background:plum;">Plum</option>
<option value="BurlyWood" style="background:burlywood;">BurlyWood</option>
<option value="LightCyan" style="background:lightcyan;">LightCyan</option>
<option value="Lavender" style="background:lavender;">Lavender</option>
<option value="DarkSalmon" style="background:darksalmon;">DarkSalmon</option>
<option value="Violet" style="background:Violet;">Violet</option>
<option value="PaleGoldenRod" style="background:palegoldenrod;">PaleGoldenRod</option>
<option value="LightCoral" style="background:lightcoral;">LightCoral</option>
<option value="Khaki" style="background:khaki;">Khaki</option>
<option value="AliceBlue" style="background:aliceblue;">AliceBlue</option>
<option value="HoneyDew" style="background:honeydew;">HoneyDew</option>
<option value="Azure" style="background:azure;">Azure</option>
<option value="SandyBrown" style="background:sandybrown;">SandyBrown</option>
<option value="Wheat" style="background:wheat;">Wheat</option>
<option value="Beige" style="background:beige;">Beige</option>
<option value="WhiteSmoke" style="background:whitesmoke;">WhiteSmoke</option>
<option value="MintCream" style="background:mintcream;">MintCream</option>
<option value="GhostWhite" style="background:ghostwhite;">GhostWhite</option>
<option value="Salmon" style="background:salmon;">Salmon</option>
<option value="AntiqueWhite" style="background:antiquewhite;">AntiqueWhite</option>
<option value="Linen" style="background:linen;">Linen</option>
<option value="LightGoldenRodYellow" style="background:lightgoldenrodyellow;">LightGoldenRodYellow</option>
<option value="OldLace" style="background:oldLace;">OldLace</option>
<option value="Red" style="background:red;">Red</option>
<option value="Fuchsia" style="background:fuchsia;">Fuchsia</option>
<option value="Magenta" style="background:magenta;">Magenta</option>
<option value="DeepPink" style="background:deeppink;">DeepPink</option>
<option value="OrangeRed" style="background:orangered;">OrangeRed</option>
<option value="Tomato" style="background:tomato;">Tomato</option>
<option value="HotPink" style="background:hotpink;">HotPink</option>
<option value="Coral" style="background:coral;">Coral</option>
<option value="DarkOrange" style="background:darkorange;">DarkOrange</option>
<option value="LightSalmon" style="background:lightsalmon;">LightSalmon</option>
<option value="Orange" style="background:orange;">Orange</option>
<option value="LightPink" style="background:lightPink;">LightPink</option>
<option value="Pink" style="background:pink;">Pink</option>
<option value="Gold" style="background:gold;">Gold</option>
<option value="PeachPuff" style="background:peachpuff;">PeachPuff</option>
<option value="NavajoWhite" style="background:navajowhite;">NavajoWhite</option>
<option value="Moccasin" style="background:moccasin;">Moccasin</option>
<option value="Bisque" style="background:bisque;">Bisque</option>
<option value="MistyRose" style="background:mistyrose;">MistyRose</option>
<option value="BlanchedAlmond" style="background:blanchedalmond;">BlanchedAlmond</option>
<option value="PapayaWhip" style="background:papayawhip;">PapayaWhip</option>
<option value="LavenderBlush" style="background:lavenderblush;">LavenderBlush</option>
<option value="SeaShell" style="background:seashell;">SeaShell</option>
<option value="Cornsilk" style="background:cornsilk;">Cornsilk</option>
<option value="LemonChiffon" style="background:lemonchiffon;">LemonChiffon</option>
<option value="FloralWhite" style="background:floralwhite;">FloralWhite</option>
<option value="Snow" style="background:snow;">Snow</option>
<option value="Yellow" style="background:yellow;">yellow</option>
<option value="LightYellow" style="background:lightyellow;">LightYellow</option>
<option value="Ivory" style="background:ivory;">Ivory</option>
<option value="White" style="background:white;">White</option>

</select>




<input type='hidden' name='refId' value='<?php echo $id ?>'>


</div>




<div class="form-group">
<label>Description :</label>
<input type="text" name="changedesc" value="<?php echo $data['desc'] ?>">

 


</div>






<?php
echo '<input type="submit" class="submit_class" value="Save" name="submit">';
?>
</form>
</div><!-- form_side close -->
</div><!-- event_details -->
<script>

// wait for the DOM to be loaded
$(function() {
// bind 'myForm' and provide a simple callback function
$('#myForm').ajaxForm(function() {

$(".fixed_side").removeClass("fixed_side_");
$(".col5").removeClass("col5_");
$(".myevents-div").removeClass("myevents-div_");
$(".myevents-div").removeClass("redborder");
$(".myevents-div").removeClass("blueborder");
$(".myevents-div").removeClass("greenborder");
$("[title='chat widget']").parent('div').attr("style", "display: block !important;position: fixed !important");
setTimeout(function(){
$(".myevents-form").empty();
$('.myevents-div #loader').show();



$(".updateTableroom").load("practice-profile.php .updateTableroom", function() {


});



},1000); 





});




});







</script>