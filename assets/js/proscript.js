jQuery(document).ready(function($){
    $('.faq-color-picker').wpColorPicker();
    jQuery(".jltmaf-fonticon-picker, #jltmaf_mb_open_icon, #jltmaf_mb_close_icon").fontIconPicker();

    jQuery('.faq_collapse_style td').addClass('jltmaf-disabled');
    jQuery('.faq_collapse_style').append( jltmaf_admin_scripts.upgrade_pro );
    
    jQuery('.faq_heading_tags td').addClass('jltmaf-disabled');
    jQuery('.faq_heading_tags').append( jltmaf_admin_scripts.upgrade_pro );

});