/**
 * Theme Customizer custom scripts
 * Control of show/hide events on feature slider type selection
 */
(function($) {
    //Add More Theme Options Button
    $('.preview-notice').prepend('<span id="catchflames_upgrade"><a target="_blank" class="button btn-upgrade" href="' + catchflames_misc_links.upgrade_link + '">' + catchflames_misc_links.upgrade_text + '</a></span>');
    jQuery('#customize-info .btn-upgrade, .misc_links').click(function(event) {
        event.stopPropagation();
    });
})(jQuery);

//Change value of hidden field below custom checkboxes
jQuery( document ).ready( function() {
    jQuery( '.customize-control-catchflames_custom_checkbox input[type="checkbox"]' ).on(
        'change',
        function() {
        	checkbox_value = "0";
            
            if ( jQuery( this ).is(":checked") ) {
            	checkbox_value = "1";
            }
            
            jQuery( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( checkbox_value ).trigger( 'change' );
        }
    );

} ); // jQuery( document ).ready