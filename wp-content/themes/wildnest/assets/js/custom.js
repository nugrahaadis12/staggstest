/*
 Project name:       wildnest
 Project author:     ModelTheme
 File name:          Custom JS
*/

(function ($) {
    'use strict';

    $(document).ready(function() {
        MTPopups.init();
        //Header part
        jQuery('.h-cart').on('hover', function() {
            /* Stuff to do when the mouse enters the element */
            jQuery('.header_mini_cart').addClass('visible_cart');
        }, function() {
            /* Stuff to do when the mouse leaves the element */
            jQuery('.header_mini_cart').removeClass('visible_cart');
        });

        jQuery('.header_mini_cart').on('hover', function() {
            /* Stuff to do when the mouse enters the element */
            jQuery(this).addClass('visible_cart');
        }, function() {
            /* Stuff to do when the mouse leaves the element */
            jQuery(this).removeClass('visible_cart');
        });
        
        // CHECKBOX TO LAYERED NAVIGATION
        if ( jQuery( ".woocommerce-widget-layered-nav-list" ).length ) {
            jQuery('.widget .product-categories > li').addClass('active');
            jQuery('.woocommerce-widget-layered-nav-list .chosen .checkbox').prop('checked', true);
            jQuery('.woocommerce-widget-layered-nav-list .checkbox').on('click', function(){
                jQuery(this).next()[0].trigger('click');
            });
        } 
        //Instant search in header
        jQuery('.wildnest-header-searchform input#keyword').on('blur', function(){
            jQuery('.data_fetch').removeClass('focus');
        }).on('focus', function(){
            jQuery('.data_fetch').addClass('focus');
        });

        //Begin: Search Form
        if ( jQuery( "#wildnest-search" ).length ) {
            new UISearch( document.getElementById( 'wildnest-search' ) );
        }
        //End: Search Form

        // browser window scroll (in pixels) after which the "back to top" link is shown
        var offset = 300,
        //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
        offset_opacity = 1200,
        //duration of the top scrolling animation (in ms)
        scroll_top_duration = 300,
        //grab the "back to top" link
        $back_to_top = jQuery('.wildnest-back-to-top');

        //hide or show the "back to top" link
        jQuery(window).scroll(function(){
            ( jQuery(this).scrollTop() > offset ) ? $back_to_top.addClass('wildnest-is-visible') : $back_to_top.removeClass('wildnest-is-visible wildnest-fade-out');
            if( jQuery(this).scrollTop() > offset_opacity ) { 
                $back_to_top.addClass('wildnest-fade-out');
            }
        });

         $back_to_top.on('click touchstart', function(event){
            // event.preventDefault();
            $('body,html').animate({
                scrollTop: 0 ,
                }, scroll_top_duration
            );
        });

    });
    
    var MTPopups = {
        init: function () {
            var $popup = $(".popup");
            
            if ($popup.length) {
                $(function(){
                    jQuery('#exit-popup').on('click', function(e) { 
                        jQuery('.popup').fadeOut(1000);
                        jQuery('.popup').removeClass("modeltheme-show");
                    });

                    var expireDate = jQuery('.popup').attr('data-expire');
                    var timeShow = jQuery('.popup').attr('show');
                    var visits = jQuery.cookie('visits') || 0;
                    visits++;
                    
                    if(expireDate = 1) {
                        jQuery.cookie('visits', visits, { expires: 1, path: '/' });
                    } else if(expireDate = 3){
                        jQuery.cookie('visits', visits, { expires: 3, path: '/' });
                    } else if(expireDate = 7){
                        jQuery.cookie('visits', visits, { expires: 7, path: '/' });
                    } else if(expireDate = 30){
                        jQuery.cookie('visits', visits, { expires: 30, path: '/' });
                    } else {
                        jQuery.cookie('visits', visits, { expires: 3000, path: '/' });
                    }
                    
                    if ( jQuery.cookie('visits') > 1 ) {
                        jQuery('.popup').removeClass("modeltheme-show");
                        jQuery.cookie();
                    } else {
                        jQuery(function() {
                             setTimeout(function(){
                                 showElement();
                              }, timeShow);
                             function showElement() {
                                jQuery('.popup').addClass("modeltheme-show");
                             }
                        });
                        
                    }
                });
            }
        }
    };

    jQuery('.fixed-search-overlay .icon-close').on( "click touchstart tap", function() {
        jQuery('.fixed-search-overlay').removeClass('visible');
    });
    jQuery(document).keyup(function(e) {
         if (e.keyCode == 27) { // escape key maps to keycode `27`
            jQuery('.fixed-search-overlay').removeClass('visible');
            jQuery('.fixed-sidebar-menu').removeClass('open');
            jQuery('.fixed-sidebar-menu-overlay').removeClass('visible');
        }
    });
    
    var baseUrl = document.location.origin;
    if ($(window).width() < 768) { 
        jQuery("#dropdown-user-profile").on("click touchstart tap", function() {
            window.location.href = (baseUrl + '/my-account');
        });
    } 

} (jQuery) );


//Header part : Category button
(function ($) {
    'use strict';

    var openBtn = $('.category_button_wrap'),
    slideMenu = $('.button_dropdown'),
    headerBotClass = $('header');
    
    if (jQuery(window).width() > 1024) {
        if (slideMenu.hasClass("cat_open_default")) {
            openBtn.addClass("active");
            slideMenu.addClass("active");
            slideMenu.slideDown(300);
        }
    } else {
        slideMenu.slideUp(0);
        openBtn.removeClass("active");
        slideMenu.removeClass("active");
    }

    openBtn.on("click", function() {
        if (slideMenu.is(':hidden')) {
            slideMenu.slideDown(300);
            openBtn.addClass("active");
            openBtn.removeClass("close");
        } else {
            slideMenu.slideUp(300);
            openBtn.removeClass("active");
            openBtn.addClass("close");
            slideMenu.removeClass("active");
        }
    });
   
})(jQuery);

//Header part : Category button
(function ($) {
    'use strict';

    jQuery("#dropdown-user-profile").on({
        mouseenter: function () {
            jQuery(this).addClass("open");
        },
        mouseleave: function () {
            if(jQuery(this).hasClass("open")) {
                jQuery(this).removeClass("open");
            }
        }
    });
})(jQuery);


//Begin: Sticky Head
(function ($) {
    'use strict';

    jQuery(function(){
        if (jQuery('body').hasClass('wildnest_is_nav_sticky')) {
            jQuery(".site-header-inner").sticky({
                topSpacing:0
            });
        }
    });
})(jQuery);


// Navigation Submenus dropdown direction (right or left)
(function ($) { 
    'use strict';

            
})(jQuery);

/*LOGIN MODAL */
(function ($) {
    'use strict';

    var ModalEffects = (function() {
        function init_modal() {

            var overlay = document.querySelector( '.modeltheme-overlay' );
            var overlay_inner = document.querySelector( '.modeltheme-overlay-inner' );
            var modal_holder = document.querySelector( '.modeltheme-modal-holder' );
            var html = document.querySelector( 'html' );

            [].slice.call( document.querySelectorAll( '.modeltheme-trigger' ) ).forEach( function( el, i ) {

                var modal = document.querySelector( '#' + el.getAttribute( 'data-modal' ) ),
                    close = modal.querySelector( '.modeltheme-close' );

                function removeModal( hasPerspective ) {
                    classie.remove( modal, 'modeltheme-show' );
                    classie.remove( modal_holder, 'modeltheme-show' );
                    classie.remove( html, 'modal-open' );

                    if( hasPerspective ) {
                        classie.remove( document.documentElement, 'modeltheme-perspective' );
                    }
                }

                function removeModalHandler() {
                    removeModal( classie.has( el, 'modeltheme-setperspective' ) ); 
                }

                el.addEventListener( 'click', function( ev ) {
                    classie.add( modal, 'modeltheme-show' );
                    classie.add( modal_holder, 'modeltheme-show' );
                    classie.add( html, 'modal-open' );
                    overlay.removeEventListener( 'click', removeModalHandler );
                    overlay.addEventListener( 'click', removeModalHandler );

                    overlay_inner.removeEventListener( 'click', removeModalHandler );
                    overlay_inner.addEventListener( 'click', removeModalHandler );

                    if( classie.has( el, 'modeltheme-setperspective' ) ) {
                        setTimeout( function() {
                            classie.add( document.documentElement, 'modeltheme-perspective' );
                        }, 25 );
                    }
                });
            });
        }

        if (!jQuery("body").hasClass("login-register-page")) {
            init_modal();
        }

    })();

    jQuery("#modal-log-in #register-modal").on("click",function(){                       
        jQuery("#login-modal-content").fadeOut("fast", function(){
            jQuery("#signup-modal-content").fadeIn(500);
        });
    }); 
    jQuery("#modal-log-in .btn-login-p").on("click",function(){                       
        jQuery("#signup-modal-content").fadeOut("fast", function(){
            jQuery("#login-modal-content").fadeIn(500);
        });
    }); 

    jQuery("#login-content-shortcode .btn-register-shortcode").on("click",function(){                       
        jQuery("#login-content-shortcode").fadeOut("fast", function(){
           jQuery("#register-content-shortcode").fadeIn(500);
        });
    });    

    jQuery('#nav-menu-login').on("click",function(){ 
        jQuery(".modeltheme-show ~ .modeltheme-overlay, .modeltheme-show .modeltheme-overlay-inner").on("click",function(){ 
            jQuery("#signup-modal-content").fadeOut("fast");
            jQuery("#login-modal-content").fadeIn(500);
        });
    });

    jQuery('#register .user-role input[value="customer"]').on('click', function() {
        if(jQuery(this).is(':checked')) {
            jQuery('#signup-modal-content .show_if_seller').hide();
            jQuery('#signup-modal-content .show_if_seller input').each(function(){
                jQuery(this).prop('disabled', true);
            });
        }
    });

    jQuery('#register .user-role input[value="seller"]').on('click', function() {
        if(jQuery(this).is(':checked')) {
            jQuery('#register .show_if_seller').show(300);
            jQuery('#register .show_if_seller input').each(function(){
                jQuery(this).prop('disabled', false);
            });
        }
    });

    jQuery('#register .user-role input[value="customer"]').on('click', function() {
        if(jQuery(this).is(':checked')) {
            jQuery('#register .show_if_seller').hide(300);
        }
    });
    
    //accordeon footer
    if(jQuery(window).width() <= 991) {
        jQuery(".footer-column .widget-area .widget").each(function(){
            var heading = jQuery(this).find('h3.widget-title');
            jQuery(heading).on('click', function(){
                jQuery(heading).toggleClass("active");
                var siblings = jQuery(this).nextAll();
                jQuery(siblings).slideToggle();
            })
        });
    }   

})(jQuery);


(function ($) {
    'use strict';

    jQuery('.hamburger').on( "click", function() {
            // jQuery(this).toggleClass('open');
            jQuery('.fixed-sidebar-menu').toggleClass('open');
            jQuery(this).parent().find('#navbar').toggleClass('hidden');
            jQuery('.fixed-sidebar-menu-overlay').addClass('visible');
        });

        /* Click on Overlay - Hide Overline / Slide Back the Sidebar header */
        jQuery('.fixed-sidebar-menu-overlay').on( "click", function() {
            jQuery('.fixed-sidebar-menu').removeClass('open');
            jQuery(this).removeClass('visible');
        });    
        /* Click on Overlay - Hide Overline / Slide Back the Sidebar header */
        jQuery('.fixed-sidebar-menu .icon-close').on( "click", function() {
            jQuery('.fixed-sidebar-menu').removeClass('open');
            jQuery('.fixed-sidebar-menu-overlay').removeClass('visible');
        });
})(jQuery);


//eamo theme
(function ($) {
    'use strict';

    jQuery('#field_7').val('Relationship');
    jQuery('#field_2').val('Women'); 
    jQuery('#field_6_range').val('20');
    jQuery('input[name="field_6_range[max]"]').val('29');
})(jQuery);

//MT Preloader
(function ($) {
    'use strict';

    jQuery(window).on("load", function(){
        jQuery( '.wildnest_preloader_holder' ).fadeOut( 1000, function() {
            jQuery( this ).fadeOut();
        });
    });
})(jQuery);

//mt mega menu expand
(function ($) {
'use strict';

if (jQuery(window).width() < 768) {
    var expand = '<span class="nav-toggle-icon"><i class="nav-icon-angle"></i></span>';
    jQuery('.nav-menu-mobile .mega_menu').append(expand);
            jQuery(".mega_menu .nav-toggle-icon").on("click",function() {
            jQuery('.nav-menu-mobile .cf-mega-menu').toggle();
            jQuery('.nav-menu-mobile .cf-mega-menu').toggleClass("show-menu");
        });
} else {
   var expand = '<span class="nav-icon-angle">&nbsp;</span>';
    jQuery('.site-navigation .mega_menu .link-before').append(expand); 
}
})(jQuery); 