
/*global jQuery:false*/

jQuery(document).ready(function () {
    MT_Addons_JS.init();
});

// Init all fields functions (invoked from ajax)
var MT_Addons_JS = {
    init: function () {
        // Load colorpicker if field exists
        MT_Addons_ColorPicker.init();
    }
};


var MT_Addons_ColorPicker = {
    init: function () {
        var $colorPicker = jQuery('.mtfe-colorpicker');
        if ($colorPicker.length > 0) {

            $colorPicker.wpColorPicker();

        }
    }
};