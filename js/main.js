// menu

function selectProduct(id) {
    var pId = id;
    $.ajax({
        url: 'ajax_call.php?page=selectProduct',
        type: 'post',
        data: { pId: pId }
    }).done(function(res) {
        var parsed = JSON.parse(res);
        console.log(parsed);
        
        // return 0
        
        pname = parsed.pname;
        validity = parsed.validity;
        price = parsed.price;
        $('.customprice_div.customprice_div_ #pro_heading').text(pname);
        $('input[name=pname]').val(pname);
        $('input[name=validity]').val(validity);
        $('input[name=price]').val(price);
        $('input[name=productId]').val(pId);
        $('.customprice_div.customprice_div_ #checkoutBtn').prop('disabled',false);
    });
}


jQuery(document).ready(function ($) {
  $("#menu").mmenu({
    extensions: [
      "effect-menu-zoom",
      "effect-panels-zoom",
      "pagedim-black",
      "theme-dark",
    ],
    offCanvas: {
      position: "left",
    },
    counters: true,
    iconPanels: true,
    navbars: [
      {
        position: "top",
      },
    ],
  });
  
  $(".mmenu_icon").click(function(){
      $("#menu").css("display", "block");
  });
});



// menu close

// POPUP for custom package
// $("#customprice_btn").click(function(ths){
//   let proName = $(ths.target).siblings('.p_detail').children('.pro_name').text()
    
//   $(".fixed_side").addClass("fixed_side_");
//   $("#custom_price_form").addClass("customprice_div_");
//   $('.customprice_div.customprice_div_ #pro_heading').text(proName)
//   $("body").addClass("flow_hidden");
// });
 
 
//  POPUP for product package
$(".pricing_btn").click(function(ths){
    
  let pId = $(ths.target).attr('data-id');
  let type = $(ths.target).attr('data-ref');
  console.log(pId, type)
  
  if(type == 'monthly_payment' || type  == 'yearly_payment'){
       let proName = $(ths.target).siblings('.p_detail').children('.pro_name').text()
       $(".fixed_side").addClass("fixed_side_");
       $(`#${type}`).addClass("customprice_div_");
       $('.customprice_div.customprice_div_ #pro_heading').text(proName)
       $("body").addClass("flow_hidden");    
  }else{
        let proName = $(ths.target).siblings('.p_detail').children('.pro_name').text()
        $(".fixed_side").addClass("fixed_side_"); 
        $(`#${type}`).addClass("customprice_div_");
        $("body").addClass("flow_hidden"); 
        selectProduct(pId)

        $('.customprice_div.customprice_div_ #pro_heading').text(proName) 
        $('.customprice_div.customprice_div_ #proName').val(proName)
        $('.customprice_div.customprice_div_ #proId').val(pId)
       
       console.log(proName);
  }
//   $(".fixed_side").addClass("fixed_side_"); 
//   $("#product_price_form").addClass("customprice_div_");
//   $("body").addClass("flow_hidden");
//   selectProduct(pId)
  
//   let proName = $(ths.target).siblings('.p_detail').children('.pro_name').text()
  
//   $('.customprice_div.customprice_div_ #pro_heading').text(proName)
//   $('.customprice_div.customprice_div_ #proName').val(proName)
//   $('.customprice_div.customprice_div_ #proId').val(pId)
  
});

$(".col5_close").click(function(){
  $(".fixed_side").removeClass("fixed_side_");
  $(".customprice_div").removeClass("customprice_div_");
  $("body").removeClass("flow_hidden");
});
$(document).keydown(function(event) {
  if (event.keyCode == 27) { 
    $(".fixed_side").removeClass("fixed_side_");
    $(".customprice_div").removeClass("customprice_div_");
    $("body").removeClass("flow_hidden");
  }
});
// POPUP

  var swiper = new Swiper(".mySwiper1", {
        effect: "coverflow",
        grabCursor: true,
        spaceBetween: 50,
        centeredSlides: true,
        autoplay: true,
        // loop: true,
        loop: true,
        slidesPerView: 3,
        coverflowEffect: {
            rotate: 0,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: true,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1
            },
            // when window width is >= 480px
            580: {
                slidesPerView: 2,
                centeredSlides: false,
            },
            // when window width is >= 640px
            768: {
                slidesPerView: 3
            }
        }
    });
    
    
     $(function () {
        $("#tabs").tabs({

            hide: 'fade',
            show: 'fade'


        }

        );
    });

    
    var swiper2 = new Swiper(".swiper1", {
    slidesPerView: 1,
    effect: "fade-in",
    autoplay: true,
    loop: true,
    centeredSlides: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
     autoplay: {
    delay: 5000,
  }, 
    keyboard: {
        enabled: true,
    },

    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    }

});
    


var SwiperCon = new Swiper(".mySwiperCon", {
    pagination: {
      el: ".swiper-pagination"
     
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });




//   js of tabs



function openCity(evt, cityName) {
    // Declare all variables
    var i, tabcontent, tablinks;
  
    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
  
    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
  
    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
  }



//   end js of tabs
  

    new WOW().init();
        AOS.init();

// Tabs JS
  //   end js of tabs

$(document).ready(function(){

  $(".tabs-list li a").click(function(e){
     e.preventDefault();
  });

  $(".tabs-list li").click(function(){
     var tabid = $(this).find("a").attr("href");
     $(".tabs-list li,.tabs div.p_tab").removeClass("active");   // removing active class from tab

     $(".p_tab").hide();   // hiding open tab
     $(tabid).show();    // show tab
     $(this).addClass("active"); //  adding active class to clicked tab

  });

});