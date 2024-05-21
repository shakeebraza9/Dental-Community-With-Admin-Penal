 window.onload = function(){
        //hide the preloader
        document.querySelector("#loader").style.display = "none";
    }
var swiper = new Swiper(".mySwiper", {
    slidesPerView: 6,
    effect: "fade-in",
    spaceBetween: 30,
    autoplay: true,
    loop: true,
    centeredSlides: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    keyboard: {
        enabled: true,
    },

    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        300: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        450: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        640: {
            slidesPerView: 3,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 5,
            spaceBetween: 30,
        },
        1200: {
            slidesPerView: 6,
            spaceBetween: 30,
        },

    }
});
var swiper2 = new Swiper(".mySwiper2", {
    slidesPerView: 4,
    effect: "fade-in",
    spaceBetween: 1,
    autoplay: true,
    loop: true,
    centeredSlides: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    keyboard: {
        enabled: true,
    },

    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        300: {
            slidesPerView: 1,
            spaceBetween: 10,
        },
        450: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        640: {
            slidesPerView: 3,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 30,
        },
        1200: {
            slidesPerView: 5,
            spaceBetween: 40,
        },

    }
});
var mySwiperReview = new Swiper(".mySwiperReview", {
    slidesPerView: 4,
    effect: "fade-in",
    spaceBetween: 1,
    autoplay: true,
    loop: true,
    centeredSlides: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    keyboard: {
        enabled: true,
    },

    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        300: {
            slidesPerView: 1,
            spaceBetween: 10,
        },
        450: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        640: {
            slidesPerView: 3,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 30,
        },
        1200: {
            slidesPerView: 5,
            spaceBetween: 40,
        },

    }
});
var swiper3 = new Swiper(".mySwiper3", {
    cssMode: true,
     slidesPerView: 1,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true

    },
    mousewheel: true,
    keyboard: true,

});


var swiper5 = new Swiper(".myswiperfooter", {
    cssMode: true,
     slidesPerView: 1,
     loop: true,
     autoplay: true,
    // navigation: {
    //     nextEl: ".swiper-button-next",
    //     prevEl: ".swiper-button-prev",
    // },
    // pagination: {
    //     el: ".swiper-pagination",
    //     clickable: true

    // },
    mousewheel: true,
    // keyboard: true,

});



// mm-current mm-opened
jQuery(document).ready(function($) {
    $("#menu").mmenu({
        "extensions": ["effect-menu-zoom", "effect-panels-zoom", "pagedim-black", "theme-dark"],
        "slidingSubmenus": true,
        "offCanvas": {
            "position": "right"
        },
        "counters": false,
        "iconPanels": true,
        "navbars": [{
            "position": "right"
        }]
    });
});
// setTimeout(function() {
//     setInterval(function() {
//         $('.logo').attr('src', 'webImages2/logo.svg')
//     }, 1)
// }, 2000);

function hover(element) {
    element.setAttribute('src', 'webImages2/logo.svg');
}

function unhover(element) {
    element.setAttribute('src', 'webImages2/logo_gif.gif');
}


var params = {
    container: document.getElementById('lottie'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    animationData: animationData
};

var anim;

anim = lottie.loadAnimation(params);
var params2 = {
    container: document.getElementById('lottie2'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    animationData: animationData2
};

var anim2;

anim2 = lottie.loadAnimation(params2);

var params3 = {
    container: document.getElementById('lottie3'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    animationData: animationData2
};

var anim3;

anim3 = lottie.loadAnimation(params3);

var params4 = {
    container: document.getElementById('lottie4'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    animationData: animationData2
};

var anim4;

anim4 = lottie.loadAnimation(params4);



var params5 = {
    container: document.getElementById('lottie5'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    animationData: animationData2
};

var anim5;

anim5 = lottie.loadAnimation(params5);


var params6 = {
    container: document.getElementById('lottie6'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    animationData: animationData2
};

var anim6;

anim6 = lottie.loadAnimation(params6);



var params7 = {
    container: document.getElementById('lottie7'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    animationData: animationData2
};

var anim7;

anim7 = lottie.loadAnimation(params7);
jQuery(function($) {

    $(".accordion-content").css("display", "none");
    $(".activ_").css("display", "block");



    $(".accordion-title").click(function() {

        $(".accordion-title").not(this).removeClass("open");

        $(".accordion-title").not(this).next().slideUp(300);

        $(this).toggleClass("open");

        $(this).next().slideToggle(300);
    });
});






window.renderBadge = function() {
    var ratingBadgeContainer = document.createElement("div");
    document.body.appendChild(ratingBadgeContainer);
    window.gapi.load('ratingbadge', function() {
        window.gapi.ratingbadge.render(
            ratingBadgeContainer, {
                "merchant_id": 2345454,
                "position": "BOTTOM_LEFT"
            });
    });
}





window.___gcfg = {
    lang: 'en_US'
};

$(".shop-table-toggle-btn").click(function() {
    var a = document.querySelector(".shop-table ");
    let b = document.querySelector(".no-shadow");

    if (a.style.transform === "scaleY(1)") {
        a.style.transform = "scaleY(0)";
        a.style.height = "0";
        // b.style.display = "none";

        $(".shop-table-toggle-btn i").removeClass("fa-regular fa-chevron-up");
        $(".shop-table-toggle-btn i").addClass("fa-regular fa-chevron-down");
    } else {
        a.style.transform = "scaleY(1)";
        a.style.height = "auto";
        // b.style.display = "block";
        $(".shop-table-toggle-btn i").removeClass("fa-regular fa-chevron-down");
        $(".shop-table-toggle-btn i").addClass("fa-regular fa-chevron-up");

    }
    // $(".shop-table").fadeToggle();


});
// $(".webBtn").click((function() {
//         $("html, body").animate({
//             scrollTop: 0
//         }, "slow"),

       
//     }));
 $(".webBtn").click((function() {
        $(".fix-side").addClass("fix_side_"),$(".background_side").fadeToggle(), $(".col101_webinar").fadeToggle(),
        $(".webinarTitle").val($(this).children(".webinarName").val()),
        $(".webinarId").val($(this).children(".webinarId").val()),
        $(".zoomLink").val($(this).children(".zoomLink").val())
    }));
// function webinarForm() {
//     console.log($(this).children(".webinarName").val(),1,$(this));
//     $(".fix-side").addClass("fix_side_");
//     $(".background_side").fadeToggle(), $(".col101_webinar").fadeToggle(),
//      $(".webinarTitle").val($(this).children(".webinarName").val()),
//         $(".zoomLink").val($(this).children(".zoomLink").val())
        
// }
$(".fix-side").click(function() {
    $(".fix-side").removeClass("fix_side_");
    $(".col101").fadeOut();
   

});

$(".close_popup").click(function() {
    $(".fix-side").removeClass("fix_side_");
    $(".col101").fadeOut()
});

$(".freeResourseDownloadBtn").click((function() {
        if($("#resourceFormSubmit").val() == 1){
            alert('Please refresh the page to download again');
           location.reload();
            return false
        }
        // $("html, body").animate({
        //     scrollTop: 0
        // }, "slow"),
        $(".fix-side").addClass("fix_side_"), $(".col101_free_resource_registration").fadeToggle(),
        $(".resourceTitle").val($(this).children(".title").val()),
        $(".resourceLink").val($(this).children(".file_id").val())
    }));
$(".demoBookBtn").click((function() {
        // $("html, body").animate({
        //     scrollTop: 0
        // }, "slow"), 
        $(".fix-side").addClass("fix_side_"), $(".col101_book").fadeToggle()
    }));

  $(".pricingTable-firstTable_table__getstart ,.book-btn-form").click((function() {
        // $("html, body").animate({
        //     scrollTop: 0
        // }, "slow"), 
        
        $(".fix-side").addClass("fix_side_"), $(".col101_cart").fadeToggle(), $("#checkoutBtn").prop("disabled", !0)
    })), $(".book-btn-form2").click((function() {
        name = $(this).attr("data-name"), $(".col101_cart2 h1").text(name), $(".col101_cart2").find(".pname").val(name), 
        // $("html, body").animate({
        //     scrollTop: 0
        // }, "slow"), 
        $(".fix-side").addClass("fix_side_"), $(".col101_cart2").fadeToggle()
    }));
    
    
    
     $('.all9').owlCarousel({
        loop: false,
        items: 1,
        margin: 0,
        nav: true,
        autoHeight: true,
        URLhashListener: true,
        onTranslate: function(event) {

            var currentSlide, player, command;

            currentSlide = $('.owl-item.active');

            player = currentSlide.find(".flex-video iframe").get(0);

            command = {
                "event": "command",
                "func": "pauseVideo"
            };

            if (player != undefined) {
                player.contentWindow.postMessage(JSON.stringify(command), "*");

            }

        }
    });
function close_newpopup() {
     $(".new-popup,.fix-side2").css("transform", "scaleX(0)");
     
     
}   
 $( window ).on( "load", abc());
    function abc() {
        $(".text_advan").hide();
        $(".text_inter").hide();
        $(".begin").addClass("active_");
    };

    $(window).on("load",function() {
        $(".begin").click(function() {
            $(".text_begin").show();
            $(".text_inter").hide();
            $(".text_advan").hide();
            $(".begin").addClass("active_");
            $(".advan").removeClass("active_");
            $(".inter").removeClass("active_");
        });
        $(".inter").click(function() {
            $(".text_inter").show();
            $(".text_advan").hide();
            $(".text_begin").hide();
            $(".begin").removeClass("active_");
            $(".inter").addClass("active_");
            $(".advan").removeClass("active_");
        });
        $(".advan").click(function() {
            $(".text_advan").show();
            $(".text_inter").hide();
            $(".text_begin").hide();
            $(".begin").removeClass("active_");
            $(".inter").removeClass("active_");
            $(".advan").addClass("active_");
        });
    });
    
    lazyload();
     AOS.init({
            duration: 500,
            // easing: 'ease',
            once: true,
            mirror: false,
        });

var swiper4 = new Swiper(".mySwiper4", {
    cssMode: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true

    },
    mousewheel: true,
    keyboard: true,
});
     