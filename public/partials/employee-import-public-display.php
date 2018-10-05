<?php

/**
 * Provide a public-facing view for the employee to upload/import CSV campaign
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/yamenshahin/
 * @since      1.0.0
 *
 * @package    Chmang
 * @subpackage Chmang/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<form class="upload-csv">
استيراد من CSV:
    <input type="file" name="file" id="file">
    <button id="upload_csv" type="button" class="btn btn-primary">حمل ملف CSV</button>
</form>

<script>
(function( $ ) {
	jQuery("#upload_csv").click(function(e) {
        e.preventDefault();
        
        if(jQuery('#file')[0].files[0] != undefined) {
            var fd = new FormData();
            fd.append( 'file', jQuery('#file')[0].files[0]);
            fd.append( 'action', 'upload_csv'); 
            jQuery.ajax({
                type: "POST",
                url: frontend_ajax_url.ajaxurl,
                contentType: false,
                processData: false,
                crossDomain: true,
                cache: false,
                data: fd,
                success: function(response) {
                    jQuery('.message').html(response);
                    console.log(JSON.stringify(response));
                },
                error: function(response) {
                    jQuery('.message').html('<div class="p-3 mb-2 bg-danger text-white">حدث شيء خطأ!.</div>');
                    console.log(JSON.stringify(response));
                }
            });
        } else {
            jQuery('.message').html('<div class="p-3 mb-2 bg-warning text-white">قم باختيار الملف أولا.</div>');
        }
		
	});
})( jQuery );
</script>