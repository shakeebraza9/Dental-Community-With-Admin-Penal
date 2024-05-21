<?php 
include_once("global.php");
$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

// include_once('header.php'); 

include'dashboardheader.php';

$functions->pin();


$display = "";
if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrreports'] == '0'){
    $display = 'style="display:none;"';
}  


                           

?>
<!--  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
  <script>
  $( function() {
    $( document ).tooltip({
      position: {
        my: "center bottom-20",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      }
    });
  } );
  </script>
  <style>
  .ui-tooltip, .arrow:after {
    background: black;
    border: 2px solid white;
  }
  .ui-tooltip {
    padding: 10px 20px;
    color: white;
    border-radius: 20px;
    font: bold 14px "Helvetica Neue", Sans-Serif;
    text-transform: uppercase;
    box-shadow: 0 0 7px black;
  }
  .arrow {
    width: 70px;
    height: 16px;
    overflow: hidden;
    position: absolute;
    left: 50%;
    margin-left: -35px;
    bottom: -16px;
  }
  .arrow.top {
    top: -16px;
    bottom: auto;
  }
  .arrow.left {
    left: 20%;
  }
  .arrow:after {
    content: "";
    position: absolute;
    left: 20px;
    top: -20px;
    width: 25px;
    height: 25px;
    box-shadow: 6px 5px 9px -9px black;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  }
  .arrow.top:after {
    bottom: -20px;
    top: auto;
  }
  </style>
</head>
<body>
 


<div class="index_content mypage">
    <!-- <div class="left_right_side"> -->
        
        <!-- left_side close -->
        
        <div class="right_side">
            <div class="form-group">
            	
                 <h2> Holiday Entitlement Calculator </h2>
                  <div class="covidshowbtn">
                        <div class="switch-field">
     
                 </div>
                 </div>
                 </div>

            <div class="cpd-table">
                
           



	<form class="holiday-calc-form bg--grey">

	<div class="row row--flex ie-equal-height" id="row2">

		<div class="col--4-12 col__xl--12-12 text-block">

			<fieldset class="holiday-calc-button-set based_on" data-calc-button-set="based_on">

				<h3 class="holiday-calc-button-header">
					Your holiday allowance is based on
				</h3>

				<div class="holiday-calc-buttons">
					<div class="holiday-calc-button days active" data-calc-value="days">
						<i class="fa fa-calendar" aria-hidden="true"></i>
						<span>Days</span>
					</div>
					<div class="holiday-calc-button hours" data-calc-value="hours">
						<i class="fa fa-clock-o" aria-hidden="true"></i>
						<span>Hours</span>
					</div>
				</div>

				<input
					type="hidden"
					id="based_on"
					name="based_on"
					value="days"
				/>

			</fieldset>

			<fieldset class="holiday-calc-button-set period_type" data-calc-button-set="period_type">

				<h3 class="holiday-calc-button-header">
					Period you would like to cover
				</h3>

				<div class="holiday-calc-buttons">
					<div class="holiday-calc-button year active" data-calc-value="year">
						<i class="fa fa-repeat" aria-hidden="true"></i>
						<span>Full Year</span>
					</div>
					<div class="holiday-calc-button custom" data-calc-value="custom">
						<i class="fa fa-arrows-h" aria-hidden="true"></i>
						<span>Select Dates</span>
					</div>
				</div>

				<input
					type="hidden"
					id="period_type"
					name="period_type"
					value="year"
				/>

			</fieldset>

		</div>

		<div class="col--4-12 col__xl--12-12 text-block">

			<fieldset class="holiday-calc-fields">

				<div class="holiday-calc-field working_days days" data-calc-button-set="based_on">
					<label for="working_days">
						Working days per week
					</label>
					<input
						type="number"
						name="working_days"
						id="working_days"
						value="5"
						min="1"
						max="7"
						step="1"
					/>
				</div>

				<div class="holiday-calc-field working_hours hours" data-calc-button-set="based_on" style="display:none;">
					<label for="working_hours">
						Working hours per week
					</label>
					<input
						type="number"
						name="working_hours"
						id="working_hours"
						value="37"
						min="1"
						max="168"
						step="0.5"
					/>
				</div>

				<div class="holiday-calc-field custom start_date" data-calc-button-set="period_type" style="display:none;">
					<label for="start_date">
						Select start date
					</label>
					<input
						type="date"
						name="start_date"
						id="start_date"
						value="<?php echo date('Y-m-d') ?>"
					/>
				</div>

				<div class="holiday-calc-field custom end_date" data-calc-button-set="period_type" style="display:none;">
					<label for="end_date">
						Select end date
					</label>
					<input
						type="date"
						name="end_date"
						id="end_date"
						value="<?php echo date('Y-m-d',strtotime('+ 1 year')) ?>"
					/>
				</div>

				<div class="holiday-calc-error custom date_error" data-calc-button-set="period_type"></div>

			</fieldset>

			<div class="holiday-calc-actions">

				<div class="holiday-calc-submit">

					<button type="submit" class="submit_class">  <!---button surgeriesview------> 
						Calculate
					</button>

				</div>

				<div class="holiday-calc-reset">

					<button type="button" class="submit_class">  <!-------button button--blue surgeriesview ---->
						Reset
					</button>

				</div>

			</div>

		</div>

		<div class="col--4-12 col__xl--12-12 text-block">

			<div class="holiday-calc-results">
				<div class="holiday-calc-allowance" >
					&mdash;
									</div>
			</div>

		</div>

	</div>

</form>
<div class="row row--flex ie-equal-height" id="row3" style="max-width: 1440px; margin: 0 auto;">

        
                           

            
        
                         
            
        
    </div>
     </div>
            <!-- cpd-table -->
        </div>
        <!-- right_side close -->
    <!-- </div> -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" /> -->

<style>
	.button:hover, .button_field:hover {
    background-color: #b85512;
}
	.holiday-calc-form fieldset.holiday-calc-button-set {
    margin: 0 0 30px 0;
    text-align: center;
}
.col--4-12 {
    width: 31.333333%;
}
.holiday-calc-form .text-block {
    padding: 30px 15px;
}
.row {
    margin-left: -15px;
    margin-right: -15px;
}
.holiday-calc-form > .row--flex {
    align-items: center;
}

.holiday-calc-form > .row--flex {
    align-items: center;
}
.row {
    margin-left: -15px;
    margin-right: -15px;
}
.row--flex {
    -js-display: flex;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -ms-flex-direction: row;
    flex-direction: row;
}

	.holiday-calc-form {
		display: block;
		/*height: 414px;*/
		height: auto;
		margin: 0;
	}
	.holiday-calc-form > .row--flex {
		align-items: center;
	}
	.holiday-calc-form .text-block {
		padding: 30px 15px;
	}
	.holiday-calc-form .text-block:nth-of-type(2) {
		padding: 30px 0px;
	}
	@media (max-width: 1024px) {
		.holiday-calc-form {
			padding: 45px 0px;
		}
		.holiday-calc-form .text-block {
			padding: 15px 40px !important;
		}
	}
	.holiday-calc-form fieldset {
		margin: 0;
		border: 0px none;
		padding: 0;
	}
	.holiday-calc-form fieldset.holiday-calc-button-set {
		margin: 0 0 30px 0;
		text-align: center;
	}
	.holiday-calc-form fieldset.holiday-calc-button-set:last-child {
		margin-bottom: 0;
	}
	.holiday-calc-button-header {
          color: #000 !important;
          font-size: 22px;
         font-family: montserratmedium;
        margin-bottom: 10px; 
	}
	.holiday-calc-buttons {
		display: grid;
		grid-template-columns: auto repeat(2, 100px) auto;
		grid-template-rows: 100px;
		grid-column-gap: 30px;
	}
	.holiday-calc-buttons::before,
	.holiday-calc-buttons::after {
		content: "";
	}
	.holiday-calc-button {
		border: 5px solid #0093a3;
		background-color: #ffffff;
		border-radius: 5px;
		padding: 10px 5px 0 5px;
		align-items: center;
		cursor: pointer;
		color: #0093a3;
		display: grid;
		grid-template-columns: auto;
		grid-template-rows: 30px 50px;
		border-radius: 15px 0px 15px 0px;
	}
	.holiday-calc-button.active {
		    background-color: #f0701e;
            color: #ffffff;
            border-color: #01abbf;
	}
	.holiday-calc-button i.fa {
		align-self: center;
		font-size: 30px;
		line-height: 1em;
	}
	.holiday-calc-button span {
		align-self: center;
		font-size: 20px;
		line-height: 1em;
	}

	.holiday-calc-field {
		display: grid;
		grid-template-columns: 200px auto;
		grid-column-gap: 15px;
		align-items: center;
		margin: 0 0 15px 0;
	}
	@media (max-width: 1280px) {
		.holiday-calc-field {
			grid-template-columns: 100px auto;
		}
	}
	@media (max-width: 1024px) {
		.holiday-calc-field {
			grid-template-columns: 200px auto;
		}
	}
	@media (max-width: 500px) {
		.holiday-calc-field {
			grid-template-columns: 100px auto;
		}
	}	
	.holiday-calc-field label {
		font-size: 18px;
		line-height: 20px;
		margin: 0;
	}
	.holiday-calc-field input {
		   border: 1px solid #0093a3;
    font-size: 20px;
    line-height: 30px;
    padding: 10px;
    text-align: left;
    max-width: 100%;
    color: #777;
	}
	.holiday-calc-field input[type="number"] {
		width: 90px;
		padding-right: 25px;
	}
	.holiday-calc-field input[type="date"] {
		width: 220px;
	}
	.holiday-calc-error {
		display: none;
		font-weight: bold;
		color: #ed1f2b;
		margin: 0 0 15px 0;
	}
	.holiday-calc-actions {
		padding-top: 15px;
		display: grid;
		grid-template-columns: 2fr 1fr;
		grid-column-gap: 15px;
		grid-row-gap: 15px;
	}
	.holiday-calc-actions * {
		align-self: center;
	}

	.holiday-calc-submit {
	}
	.holiday-calc-submit .button {
		width: 100%;
	}
	@media (max-width: 1024px) {
		fieldset.holiday-calc-fields,
		.holiday-calc-actions {
			width: 500px;
			max-width: 100%;
			margin: 0 auto;
		}
	}
	.holiday-calc-reset {
		text-align: center;
	}
	.holiday-calc-reset .button {
		font-size: 14px;
		padding: 5px 20px
	}

	.holiday-calc-results {
		display: block;
		position: relative;
		margin: 0 auto;
		background-color: #0093a3;
		border-radius: 15px 0px 15px 0px;
		width: 240px;
		height: 240px;
	}
	.holiday-calc-results.loading {
		background-repeat: no-repeat;
		background-position: center;
		background-size: 75%;
		background-image: url(../webImages/ajax-loader2.webp);
	}
	.holiday-calc-results.loading * {
		display: none;
	}
	.holiday-calc-allowance {
		position: absolute;
		top: 50%;
		left: 0;
		transform: translateY(-50%);
		width: 100%;
		padding: 5px 5px;
		text-align: center;
		color: #ffffff;
		font-size: 36px;
		line-height: 1em;
		font-weight: bold;
	}
	.holiday-calc-allowance * {
		font-size: inherit;
	}
	.holiday-calc-allowance .allowance-unit::before {
		content: " ";
	}
	.holiday-calc-allowance .mins {
		font-size: 80%;
	}
  .tooltip-inner {
    background-color: #00cc00;
}
.tooltip.bs-tooltip-right .arrow:before {
    border-right-color: #00cc00 !important;
}
.tooltip.bs-tooltip-left .arrow:before {
    border-right-color: #00cc00 !important;
}
.tooltip.bs-tooltip-bottom .arrow:before {
    border-right-color: #00cc00 !important;
}
.tooltip.bs-tooltip-top .arrow:before {
    border-right-color: #00cc00 !important;
}

</style>


<!-- holdiay --- calculate -->

<script>


jQuery(document).ready( function($) {
	// On 'calc button' click, change the hidden input value
	$(document).on('click', '.holiday-calc-button[data-calc-value]', function(event) {
		let calc_button = $(this);
		let value = calc_button.attr('data-calc-value');
		let calc_button_set = calc_button.closest('.holiday-calc-button-set');
		let field_id = calc_button_set.attr('data-calc-button-set');
		calc_button_set.find('#' + field_id).val(value);
		let calc_form = calc_button_set.closest('.holiday-calc-form');
		$(calc_button_set).find('.holiday-calc-button').removeClass('active');
		calc_button.addClass('active');
		$('.holiday-calc-field, .holiday-calc-error').each(function() {
			let field_button_set = $(this).attr('data-calc-button-set');
			if ( field_id === field_button_set ) {
				$(this).hide();
				if ( $(this).hasClass(value) ) {
					$(this).show();
				}
			}
		});
		if ( field_id == 'based_on' ) {
			calc_form.find('.holiday-calc-actions').removeClass('hidden');
		}
		calc_form.find('.holiday-calc-results .holiday-calc-allowance').html('&mdash;');
	});

	// On form submit, make ajax request for allowance
	$(document).on('submit', '.holiday-calc-form', function(event) {
		event.preventDefault();
		holiday_calc_ajax( $(this), true );
	});

	// On form field change, make ajax request for allowance
	$(document).on('change', '.holiday-calc-field input', function(event) {
		event.preventDefault();

		let calc_form = $(this).closest('.holiday-calc-form');

		// Validate/cleanse the input before running ajax
		let validated = true;
		let field_type = $(this).attr('type');
		switch ( field_type ) {
			case 'number':
				holiday_calc_cleanse_number_field( $(this) );
			break;
		}

		// If validated, run ajax
		if ( validated ) {
			holiday_calc_ajax( calc_form, false );
		}

	});

	/**
	 * Cleanse number field (stop invalid figures being entered)
	 */
	function holiday_calc_cleanse_number_field( input ) {

		let min		= parseInt( input.attr('min') );
		let max		= parseInt( input.attr('max') );
		let value	= parseFloat( input.val() );

		if ( value < min ) {
			input.val(min); // reset to min
		} else if ( value > max ) {
			input.val(max); // reset to max
		} else {
			// Make sure the value is integer or 0.5
			if ( !Number.isInteger(value) && !Number.isInteger(value * 2) ) {
				value = Math.round(value);
			}
			input.val(value); 
		}

	}

	/**
	 * Send ajax request to HolidayEntitlement API
	 */
	function holiday_calc_ajax( calc_form, scroll_to_result ) {

		// Add loading class
		calc_form.find('.holiday-calc-results').addClass('loading');

		// Build ajax data array
		let ajax_data = {
			'action'		: 'hol-ent',
			'based_on'		: calc_form.find('#based_on').val(),
			'period_type'	: calc_form.find('#period_type').val(),
			'working_days'	: calc_form.find('#working_days').val(),
			'working_hours'	: calc_form.find('#working_hours').val(),
			'start_date'	: calc_form.find('#start_date').val(),
			'end_date'		: calc_form.find('#end_date').val(),
		};

		// Make AJAX request
		$.ajax({
type:'POST',
url: 		'ajax_call.php?page=holidayhourdays',
data: 		ajax_data,
success: function(result) {
      if(!result){
          return false;
      }
      else if(result){
        resultObj = eval (result);

			calc_form.find('.holiday-calc-results').removeClass('loading');
       // calc_form.find('.holiday-calc-allowance').html('-Smart--Dental-');     
             // if (response > 0 ) {
            console.log(resultObj[0]);
            console.log(resultObj[1]);
        if ( resultObj[1] == 'hours'){

        var decimalTimeString = resultObj[0];
// var decimalTime = parseFloat(decimalTimeString);
// decimalTimeH = decimalTime * 24;
// var hours = Math.floor((decimalTime / (60 * 60)));
// decimalTime = decimalTime - (hours * 60 * 60);
// var minutes = Math.floor((decimalTime / 60/8));
// decimalTime = decimalTime - (minutes * 60);
// var seconds = Math.round(decimalTime);
// if(hours < 10)
// {
// 	hours = "0" + hours;
// }
// if(minutes < 10)
// {
// 	minutes = "0" + minutes;
// }
// if(seconds < 10)
// {
// 	seconds = "0" + seconds;
// }



 


decimalTimeString = decimalTimeString.toFixed(2)
var decimalTime1 = decimalTimeString.toString();

var mMinutes = decimalTime1.split('.');


var newMinutes  = mMinutes[1]/100 * 60;
var newMinutes1  = newMinutes.toString();

var newMinutes12 = newMinutes1.split('.');

if(isNaN(newMinutes12[0])){
	 var tms ="";
}else{
	 var tms =newMinutes12[0]+ " : Minutes";
}




var tm = "" + mMinutes[0] + " : Hours " + tms;
// alert("" + hours + ":" + minutes + ":" + seconds);

calc_form.find('.holiday-calc-results .holiday-calc-allowance').html("<span id='age' data-toggle='tooltip' title='"+resultObj[0].toFixed(2)+"'>"+tm+"</span>");     
// calc_form.find('.holiday-calc-results .holiday-calc-allowance').attr('title',""+ hours + " :Hour "+ minutes+" :minutes ");     
// calc_form.find('.holiday-calc-results .holiday-calc-allowance').html("Hour: "+ hours + "<br> minutes:"+minutes);     
}
if ( resultObj[1] == 'days'){
        var decimalTimeString = resultObj[0];
        var n = decimalTimeString.toString();

      // var array = decimalTimeString.split(".");
var result = n.split('.');

hourMult = "."+result[1]; 
var h = hourMult * 8;

if(isNaN(h)){
	 var tm =result[0]+ " : Days";
}else{
	 var tm =result[0]+ " : Days "+ Math.round(h)+ " : Hours";
}


  

calc_form.find('.holiday-calc-results .holiday-calc-allowance').html("<span id='age' data-toggle='tooltip' title='"+resultObj[0].toFixed(2)+"'>"+tm+"</span>");     
// calc_form.find('.holiday-calc-results .holiday-calc-allowance').attr('title',""+ hours + " :Hour "+ minutes+" :minutes "); 

  console.log(resultObj[0]);

}



  
      }
      //$("#cartLoading").toggle(500);
    }
}); 


	}

	/**
	 * Reset the whole holiday calculator to default status
	 */
	function holiday_calc_reset( calc_form ) {

		calc_form.find('.holiday-calc-button').removeClass('active');
		calc_form.find('.holiday-calc-button-set.based_on .holiday-calc-button.days').addClass('active');
		calc_form.find('.holiday-calc-button-set.period_type .holiday-calc-button.year').addClass('active');
		calc_form.find('#based_on').val('');
		calc_form.find('#period_type').val('year');

		calc_form.find('.holiday-calc-field, .holiday-calc-error').hide();
		calc_form.find('.holiday-calc-field.working_days').show();

		calc_form.find('#working_days').val(5);
		calc_form.find('#working_hours').val(37);
		calc_form.find('#start_date').val('2021-05-04');
		calc_form.find('#end_date').val('2022-05-03');

		// calc_form.find('.holiday-calc-results .holiday-calc-allowance').html('saad');
		calc_form.find('.holiday-calc-results').removeClass('loading');

	}
	$(document).on('click', '.holiday-calc-reset button', function(event) {
		let calc_form = $(this).closest('.holiday-calc-form');
		holiday_calc_reset(calc_form);
	});

});

/**
 * Is the element in view?
 * https://medium.com/talk-like/detecting-if-an-element-is-in-the-viewport-jquery-a6a4405a3ea2
 */
$.fn.inView = function() {
	var elementTop = $(this).offset().top;
	var elementBottom = elementTop + $(this).outerHeight();
	var viewportTop = $(window).scrollTop();
	var viewportBottom = viewportTop + $(window).height();
	return elementBottom > viewportTop && elementTop < viewportBottom;
};

  
</script>

	



<?php include("dashboardfooter.php") ?>