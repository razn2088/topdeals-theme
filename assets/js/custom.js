jQuery(function($) {
    // Magnific Popup for footer links
    $('.open-popup-link').magnificPopup({
        type: 'inline',
        mainClass: 'popup-white',
        midClick: true
    });

    // How We Rank popup
    $('#rank').on('click', function(e) {
        e.preventDefault();
        $('#pop_overlay').fadeIn();
    });

    // Advertising Disclaimer popup
    $('#disclosure').on('click', function() {
        $('#pop_overlay2').fadeIn();
    });

    // Close buttons
    $('.close').on('click', function() {
        $('#pop_overlay, #pop_overlay2').fadeOut();
    });

    // Close on overlay click
    $('#pop_overlay, #pop_overlay2').on('click', function(e) {
        if (e.target === this) {
            $(this).fadeOut();
        }
    });
});
