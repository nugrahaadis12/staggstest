(function ($) {
    'use strict';

    $(document).ready(function() {
        // BEGIN: GRID / LIST SWITCHER
        jQuery('#grid').on('click', function() {
            jQuery(this).addClass('active');
            jQuery('#list').removeClass('active');
            jQuery.cookie('gridcookie','grid', { path: '/' });
            jQuery('.woocommerce-page ul.products').fadeOut(300, function() {
                jQuery(this).addClass('grid').removeClass('list').fadeIn(300);
            });
            return false;
        });

        jQuery('#list').on('click', function() {
            jQuery(this).addClass('active');
            jQuery('#grid').removeClass('active');
            jQuery.cookie('gridcookie','list', { path: '/' });
            jQuery('.woocommerce-page ul.products').fadeOut(300, function() {
                jQuery(this).removeClass('grid').addClass('list').fadeIn(300);
            });
            return false;
        });

        if (jQuery.cookie('gridcookie')) {
            jQuery('.woocommerce-page ul.products, #gridlist-toggle').addClass(jQuery.cookie('gridcookie'));
        }

        if (jQuery.cookie('gridcookie') == 'grid') {
            jQuery('.gridlist-toggle #grid').addClass('active');
            jQuery('.gridlist-toggle #list').removeClass('active');
        }

        if (jQuery.cookie('gridcookie') == 'list') {
            jQuery('.gridlist-toggle #list').addClass('active');
            jQuery('.gridlist-toggle #grid').removeClass('active');
        }

        jQuery('#gridlist-toggle a').on('click', function(event) {
            event.preventDefault();
        });
        // END: GRID / LIST SWITCHER


    });
}) (jQuery);

// Responsive Set Height Products
(function ($) {
    'use strict';

    jQuery(function() {

        if ( jQuery( ".woocommerce-tabs .tabs.wc-tabs" ).length ) {
            jQuery(".woocommerce-tabs .tabs.wc-tabs > li > a").matchHeight({
                byRow: true
            });
        }

        if (jQuery("body").hasClass("woocommerce-js")) {
            jQuery('.products .product .woocommerce-title-metas').matchHeight({
                byRow: true
            });
        }
    });
})(jQuery);

//Begin: WooCommerce Quantity
(function ($) {
    'use strict';

    jQuery( function( $ ) {
    if ( ! String.prototype.getDecimals ) {
        String.prototype.getDecimals = function() {
            var num = this,
                match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
            if ( ! match ) {
                return 0;
            }
            return Math.max( 0, ( match[1] ? match[1].length : 0 ) - ( match[2] ? +match[2] : 0 ) );
        }
    }
    // Quantity "plus" and "minus" buttons
    $( document.body ).on( 'click', '.plus, .minus', 
        function() {
                
            if (jQuery('form.auction_form.cart').length){
                // nothing
            }else{
                var $qty        = $( this ).closest( '.quantity' ).find( '.qty'),
                    currentVal  = parseFloat( $qty.val() ),
                    max         = parseFloat( $qty.attr( 'max' ) ),
                    min         = parseFloat( $qty.attr( 'min' ) ),
                    step        = $qty.attr( 'step' );

                // Format values
                if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
                if ( max === '' || max === 'NaN' ) max = '';
                if ( min === '' || min === 'NaN' ) min = 0;
                if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

                // Change the value
                if ( $( this ).is( '.plus' ) ) {
                    if ( max && ( currentVal >= max ) ) {
                        $qty.val( max );
                    } else {
                        $qty.val( ( currentVal + parseFloat( step )).toFixed( step.getDecimals() ) );
                    }
                } else {
                    if ( min && ( currentVal <= min ) ) {
                        $qty.val( min );
                    } else if ( currentVal > 0 ) {
                        $qty.val( ( currentVal - parseFloat( step )).toFixed( step.getDecimals() ) );
                    }
                }

                // Trigger change event
                $qty.trigger( 'change' );
            }
        });
    });
})(jQuery);

// Style the select fields
(function ($) {
    'use strict';

    if( jQuery( '.variations select' ).length == 0 ||  jQuery( '.wildnest-header-searchform select' ).length == 0 || jQuery( '.widget_archive select' ).length == 0 || jQuery( '.widget_categories select' ).length == 0 || jQuery( '.widget_text select' ).length == 0  || jQuery( '.woocommerce-ordering select' ).length == 0 ) {
        jQuery('.variations select, .wildnest-header-searchform select, .widget_archive select, .widget_categories select, .widget_text select, .woocommerce-ordering select').select2({
            containerCssClass: "wildnest-select2",
            dropdownCssClass: "wildnest-open-dropdown"
        });
    }
})(jQuery);

// Shop filters sidebar button (mobile)
(function ($) {
    'use strict';
    
    $(document).ready(function() {
        jQuery( '.wildnest-shop-filters-button' ).on( "click", function(event) {
            event.preventDefault();
            jQuery('.wildnest-shop-sidebar').toggleClass('is-active');
        });

        // Shop filters sidebar closing
        jQuery( '.wildnest-shop-sidebar-close-btn' ).on( "click", function(event) {
            event.preventDefault();
            jQuery('.wildnest-shop-sidebar').removeClass('is-active');
        });
    });
})(jQuery);
