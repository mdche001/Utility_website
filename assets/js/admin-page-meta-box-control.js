(function($){
$(document).ready(function() {

    var page_template = $('#page_template');
    var metabox = $('#di_business_page_meta_box_cntnr');

    page_template.change(function() {
        if ( $(this).val() == 'template-landing-page.php' ) {
            metabox.hide();
        } else {
            metabox.show();
        }
    }).change();

});
})(jQuery);
