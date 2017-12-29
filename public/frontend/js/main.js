var demoSlider;

jQuery( document ).ready(function( $ ) {
    
    playAnimation();
    setTimeout(playBottomAnimation, 6000);
    
    if ($('#demo-slider').length > 0) {
    
    $('#demo-slider').verticalSlider({
    	scrollThreshold: 3,

        // Element on which informational classes will be put (current section index, last section...)
        infoSelector: 'html',

        // Autoplay functionality
        autoplay: false,
        autoplayDuration: 6000,

        // Animations settings
        animVisible: 'vs_translateNone',
        animUp: 'vs_translateUp',
        animUpHalf: 'vs_translateUp.half',
        animBottom: 'vs_translateDown',
        animBottomHalf: 'vs_translateDown.half',
        animBounceUp: 'vs_bounceUp',
        animBounceDown: 'vs_bounceDown',
        animEasing: [0.77, 0, 0.175, 1],
        animDuration: 800,
        scrollDelay: 0,

        // Callback functions
        afterInit: function( currentSection, sectionsNumber ) {
            //playAnimation();
            //setTimeout(playBottomAnimation, 6000);
        },

        beforeMove: function( currentSection, sectionsNumber ) {
            //console.log( 'beforeMove: ' + currentSection + ' ' + sectionsNumber );
            //$('.page-nav > li > a').addClass('active');
            
        },

        afterMove: function( currentSection, sectionsNumber ) {
        	//console.log( 'afterMove: ' + currentSection + ' ' + sectionsNumber );
            if ($('.sview-section').hasClass('active')) {
                $('.overlay-map-layer').fadeIn();
                $('.left-layer-show').removeClass('open');
                $('#street-view').removeClass('open');
                $('.footer-bottom').fadeIn();
                $('.navbar').fadeIn();
                $('.page-nav').fadeIn();
            }
            //$(".visible-section").empty();
            //playAnimation();
        }
    });

    // Store the instance in a variable
    demoSlider = $('#demo-slider').data('verticalSlider');

    // All the next functions are now usable using the demoSlider instance
    // demoSlider.next();
    // demoSlider.prev();
    // demoSlider.moveTo(3); 

    };
    
    //play video on hover
    
    // $('.hiring-thumb').mouseenter(function(){
    //     $('video', this).get(0).play(); 
    // }).mouseleave(function(){
    //    $('video', this).get(0).pause();  
    // });
    
    $('.go-to-next').click(function(){
        demoSlider.next();
        return false;
    });
    
    $('.slider-first').click(function(){
        demoSlider.moveTo(0); 
        return false;
    });
    
    $('.slider-second').click(function(){
        demoSlider.moveTo(1); 
        return false;
    });
    
    $('.slider-third').click(function(){
        demoSlider.moveTo(2); 
        return false;
    });
    
    $('.slider-fourth').click(function(){
        demoSlider.moveTo(3); 
        return false;
    });
    
    $(".popup-open").click(function(e){
        var dataTargetId = $(this).data('target');
        //console.log(dataTargetId);
        $(dataTargetId).addClass('opened');
        $('#demo-slider').addClass('scaled');
        $('.border-element').addClass('show');
        $('html').addClass('not-scrolling');
        $( dataTargetId + " .overlay-content" ).scrollTop(0);
        demoSlider.disableHammer(true);
        event.preventDefault();
        return false;
    })
    
    
    $('.close-button, .mob-close, .velina').click(function(){
        $('.popup-outer').removeClass('opened');
        $('#demo-slider').removeClass('scaled');
        $('.border-element').removeClass('show');
        $('html').removeClass('not-scrolling');
        demoSlider.disableHammer(false);
        return false;
    });

    
    //footer
    
    $('.social-open').click(function(){
        //$('.footer-bottom').toggleClass('open');
        return false;
    });
    
    //menu opens
    
    $('#nav-icon').click(function(){
        $(this).toggleClass('open');
        $('body').toggleClass('menu-open');
    });
    
    //street view google map section
    
    $('.map-show').click(function(){
        $('.overlay-map-layer').fadeOut();
        $('.left-layer-show').addClass('open');
        $('#street-view').addClass('open');
        $('.footer-bottom').fadeOut();
        $('.navbar').fadeOut();
        $('.page-nav').fadeOut();
        return false;
    });
    
    $('.street-view-toggle').click(function(){
        $('.overlay-map-layer').fadeIn();
        $('.left-layer-show').removeClass('open');
        $('#street-view').removeClass('open');
        $('.footer-bottom').fadeIn();
        $('.navbar').fadeIn();
        $('.page-nav').fadeIn();
        return false;
    });
    
    $('.social-open').click(function(){
        $('.social-popup').addClass('open');
        $(".social-close").delay(200).queue(function(next){
            $(this).addClass('from-right');
            next();
        }).delay(600).queue(function(next){
            $('.social-container').addClass('from-right');
            next();
        });
        return false;
    });
    
    $('.social-close').click(function(){
        $('.social-popup').removeClass('open');
        $(".social-close").removeClass('from-right');
        $('.social-container').removeClass('from-right');
        return false;
    });
    
    //uncomment all this to reactivate gifs in the second slide
    
    //addGifsHtml();
        
    //setGifsPosition();
    
    /*function setGifsPosition(){
        var $gifs = $(".randomgifs"),
        l = $gifs.length;
        var top = 0;
        var left = 0;
        var maxNum = 7;

        for(var i=0; i<l;i++){
            var $container = $($gifs[i]).parent();

            top = parseInt(Math.random() * ($container.outerHeight() - 20));
            //console.log(top)
            if(top<145){
                //console.log("MINORE: "+$($stars[i]).text()+"PRIMA: "+top);
                top = top+145;
            }else if(top>($container.outerHeight()-240)){
                top = top-240;
                //console.log("MAGGIO$RE: "+$($stars[i]).text())
            }
            left = parseInt(Math.random() * ($container.outerWidth() - 20));

            //var planetClass = "planet"+(Math.round(Math.random() * (maxNum - 1)) + 1);

            $($gifs[i]).css({
                top: top+"px",
                left: left+"px"
            })//.addClass(planetClass);
        }

    }
    
        
    function addGifsHtml() {
        var length = 40;
        var html= "";
        var gifNumber= ["first","second","third","fourth","fifth","sixth","seventh","eight","ninth","tenth"];
        //console.log(length);
        //console.log(html);
        for(var i=0; i<length;i++) {
            var c= Math.floor(Math.random() * gifNumber.length);
            //console.log(gifNumber[c]);
            html+= "<div class='randomgifs "+gifNumber[c]+"'></div>"
        }
        $(".vs-section-1 .absolute-full-container").append(html);
    }*/
    
    
    
    /*$(window).scroll(function() {
        var offset = jQuery(document).scrollTop();
        if( offset>=500 ){
            jQuery('body').addClass('header-solid');
        }else{
            jQuery('body').removeClass('header-solid');
        }
    });*/
    
   

    $('#mobile-slider').lightSlider({
        adaptiveHeight:false,
        controls:true,
        pager:false,
        item:1,
        slideMargin:0,
        loop:true,
        responsive : [
            {
                breakpoint:800,
                settings: {
                    item:2,
                  }
            },
            {
                breakpoint:600,
                settings: {
                    item:1,
                  }
            }
        ]
    });
    
    
    checkForm();
    
    function checkForm(){
        $('.form-group input').blur(function() {
            if (!$(this).val()) {
              $(this).siblings('.error-text').removeClass('show'); 
            } 
        });
        
    }
    
    
    $("#formDefault input, #formDefault textarea").blur(function(){
        var el = $(this);
        if(el.val() != ""){
            el.addClass("filled");
        }else{
            el.removeClass("filled");
        }
    });
    
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    }; 
    
    $('.submit').click(function(){
        var email = $("#contactEmail").val();
        if( !$('.required').val() ) {
            $('.empty-text').addClass('show');
        } else {
            if(!isValidEmailAddress(email)) {
                $('.mail').addClass('show');
            } else {
                sendForm();  
            }
        }
        return false;
    });
    
    function sendForm(){
        $(".submit").addClass("disabled");
        $(".loading-container").fadeIn();
        var nome = $(".form-group").find("#contactName").val();
        $.ajax({
            type: "post",
            url: "form.php",
            data: $("#formDefault").serialize(),
            success: function(data){
                console.log(data);
                if(data=="1"){
                    $("#formDefault .submit").removeClass("disabled");
                    $("#formDefault .text-success").removeClass("hidden");  
                    $("#formDefault")[0].reset();
                    $("#formDefault").fadeOut();
                    $("#formDefault input, #formDefault textarea").removeClass("filled");
                    $(".success-message").fadeIn();
                    $("#formDefault .error-text").removeClass("show");
                    $(".loading-container").fadeOut();
                    $('.name-value').text(nome);
                    
                }else{
                    $("#formDefault .error-message").fadeIn();
                }
            },
            error: function(){
                 alert("error!");
            }
        });	
    }
    
    $('.mostra-form').click(function(){
        $("#formDefault").fadeIn();
        $(".success-message").fadeOut();
        return false;
    });
    
    
    if (window.innerWidth <= 1023) {
        playAnimation();
        setTimeout(playBottomAnimation, 6000);
    };
    
    // function playVideoLanding(){
    //     $('.composizione').get(0).play();
    // };
    
    // function stopVideoLanding(){
    //     $('.composizione').get(0).pause();
    // };
    
    // if ($('.vs-section').hasClass('active')) {
    //    playVideoLanding(); 
    // } else {
    //    stopVideoLanding(); 
    // };
    
    // scroll magic controller
    
    controller = new $.ScrollMagic.Controller();
    
    //var controller = new ScrollMagic.Controller();
    if (window.innerWidth <= 1023) {
        var scene = new $.ScrollMagic.Scene({
            duration: 150,    
            offset: 0
        })
        //.addIndicators({name: "1 - add a class"})
        .addTo(controller);   

        $(".scene .toshow").each(function() {
            new $.ScrollMagic.Scene({
                triggerElement: this,
                reverse:false,
                triggerHook:0.9
            })
            .setClassToggle(this, "visible")
            .addTo(controller);
        });
        
    };
    
    if (window.innerWidth >= 1024) {
        var scene1 = new ScrollMagic.Scene({
          triggerElement: '#scene1', // starting scene, when reaching this element
          duration: 400,
          reverse:true
        }).setClassToggle('#scene1', "visible").addTo(controller);
        
        var scene2 = new ScrollMagic.Scene({
          triggerElement: '#scene2', // starting scene, when reaching this element
          duration: 400 // pin the element for a total of 400px
        }).setClassToggle('#scene2', "visible").addTo(controller);
        
        var scene3 = new ScrollMagic.Scene({
          triggerElement: '#scene3', // starting scene, when reaching this element
          duration: 400 // pin the element for a total of 400px
        }).setClassToggle('#scene3', "visible").addTo(controller);
        
        var scene4 = new ScrollMagic.Scene({
          triggerElement: '#scene4', // starting scene, when reaching this element
          duration: 400 // pin the element for a total of 400px
        }).setClassToggle('#scene4', "visible").addTo(controller);

        var scene5 = new ScrollMagic.Scene({
          triggerElement: '#scene5', // starting scene, when reaching this element
          duration: 400 // pin the element for a total of 400px
        }).setClassToggle('#scene5', "visible").addTo(controller);

        var scene6 = new ScrollMagic.Scene({
          triggerElement: '#scene6', // starting scene, when reaching this element
          duration: 400 // pin the element for a total of 400px
        }).setClassToggle('#scene6', "visible").addTo(controller);

        var scene7 = new ScrollMagic.Scene({
          triggerElement: '#scene7', // starting scene, when reaching this element
          duration: 400 // pin the element for a total of 400px
        }).setClassToggle('#scene7', "visible").addTo(controller);
    };
    
    scene = new ScrollMagic.Scene();
    
    $( window ).resize(function() {
        scene.refresh();
    });
    
    $(".scrollTo").click(function(){
        var tg = $(this).attr("href");
        $("html, body").animate({
            scrollTop: $(tg).offset().top-50
        }, 600);
        return false;
    });
    
    /*var animData = {
        container: document.getElementById('container'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: 'js/res/data.json'
    };
    var anim = bodymovin.loadAnimation(animData);*/

});



