jQuery(document).ready(function($) {
    // Toggle submenu visibility on tab click
    $('.knowledge-accordion .accordion .link').click(function() {
        var $accordionItem = $(this).parent();
        var $submenu = $accordionItem.find('.submenu');
        
        // Check if the current tab is already open
        var isOpen = $accordionItem.hasClass('open');
        
        // Close all open tabs
        $('.knowledge-accordion .accordion .open').removeClass('open').find('.submenu').slideUp();
        
        // If the clicked tab was not already open, open it
        if (!isOpen) {
            $accordionItem.addClass('open');
            $submenu.slideDown();
        }
    });
});