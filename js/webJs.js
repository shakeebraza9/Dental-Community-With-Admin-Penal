jAlertifyAlert = function(title){
    //Required Alertify cs /js
    alertify.alert(title);
}

function loading_progress(){
    //work with bootstrap.
    return '<div class="progress"><div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="r-only">Loading...</span></div></div>';
}



function remove_tr(ths,time){
    // remove_tr(this,time for wait);
    if(typeof ths == 'undefined')return false;

    time = typeof text !== 'undefined' ? time : 400;
    remv=time+500;
    $(ths).closest("tr").hide(time);

    setTimeout(function(){
        $(ths).closest("tr").remove();
    },remv);

}

function remove_div(ths,time){
    // remove_tr(this,time for wait);
    if(typeof ths == 'undefined')return false;

    time = typeof text !== 'undefined' ? time : 500;
    remv=time+500;
    $(ths).closest("div").hide(time);

    setTimeout(function(){
        $(ths).closest("div").remove();
    },remv);

}
/********************************/

notification = function(heading,text,clas){
    var uniqueNum = Math.floor( Math.random()*99999 );
    notifi = "<div  id='noti_"+uniqueNum+"' class='notification'>" +
        " <div class='notification_close btn btn-default'>x</div>" +
        "<div class='notification_heading navbar-inverse'>" +
        ""+heading+""+
        "</div>"+
        "<div class='notification_text "+clas+"'>" +
        ""+text+"</div>"+
        "</div>";

    $('.notifications').prepend(notifi);
    $('#noti_'+uniqueNum).hide().fadeIn('slow');
};

$(document).on('click','.notification_close',function(){
    ths= $(this).closest('.notification');
    ths.stop().slideUp(800,function(){
        ths.remove();
    });
});

function dateJqueryUi(){
    $( ".date" ).datepicker();
}


function ourLazyImages(){
    $('img.myLazy').each(function(){
        //Use <img data-original="imgUrl" src="default.png" />
        var imageSrc = $(this).attr("data-original");
        $(this).attr("src", imageSrc).removeAttr("data-original");
    });
}

function shipping_country_selection_form_actions() {
     setTimeout(function(){
            // $('#$name').modal('show');
            $('#ShippingCountrySelection').modal({ backdrop: 'static', keyboard: false })
            .one('click', '#delete', function() {
                //$form.trigger('submit'); // submit the form
                // console.log('Form Submitted!');
            });
        },1);
    // $('#shipping_form').on('change', '#shipping_select', function(event) {
    //     event.preventDefault();
    //     /* Act on the event */
    //     $('#shipping_form').submit();
    // });

    // $('#index_menu_country_container, #page_menu_country_container').on('change', '#menu_shipping_select', function(event) {
    //     event.preventDefault();
    //     /* Act on the event */
    //     $('#menu_shipping_form_index').submit();
    // });

    // $("#ShippingCountrySelection").on("hidden.bs.modal", function () {
    //     // put your default event here
    //     console.log('Closed');
    // });

    // detect click inside modal
    // var modal_clicked = false;
    // $('#ShippingCountrySelection').on('click', '.modal-content', function(event) {
    //     event.preventDefault();
    //     // console.log('modal clicked');
    //     modal_clicked = true;
    //     /* Act on the event */
    // });

    // detect click inside window
    // var window_clicked = false;
    // $(window).click( function(){ 
    //     // console.log('window clicked');
    //     window_clicked = true;
    //     // if modal has not been clicked, then we have clicked outside the modal, so we animate the modal
    //     if ( modal_clicked == false ) {
    //         // console.log('Run nudge effect');
    //         $('#ShippingCountrySelection').effect( "shake", "swing", 400 );
    //     } else {
    //         // reset the modal checking variable, after use.
    //         modal_clicked = false;
    //     }
    // });

    // open modal after specified time
    // $(document).ready(function(){
       
    // });



}