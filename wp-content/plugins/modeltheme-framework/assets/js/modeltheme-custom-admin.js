/*
 File name:          Custom Admin JS
*/
(function ($) {
  'use strict';

	jQuery( document ).ready(function() {

 		var selected =  jQuery("#wildnest_custom_header_options_status").val();
    if (selected == 'yes') {
    	jQuery('.cmb_id_wildnest_header_custom_variant').show();
    	jQuery('.cmb_id_wildnest_metabox_header_logo').show();
    }else{
    	jQuery('.cmb_id_wildnest_header_custom_variant').hide();
    	jQuery('.cmb_id_wildnest_metabox_header_logo').hide();
    }

    jQuery( "#wildnest_custom_header_options_status" ).change(function () {
	 		var selected =  jQuery(this).val();
      if (selected == 'yes') {
      	jQuery('.cmb_id_wildnest_header_custom_variant').show();
      	jQuery('.cmb_id_wildnest_metabox_header_logo').show();
      }else{
      	jQuery('.cmb_id_wildnest_header_custom_variant').hide();
      	jQuery('.cmb_id_wildnest_metabox_header_logo').hide();
      }
    });
	});
} (jQuery) )