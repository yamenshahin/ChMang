<?php

/**
 * Provide a public-facing view for the employee form to "all/search/edit" campaign
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
<div class="search-wrap">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <input id="project_number_search" type="text" class="form-control" placeholder="رقم">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <input id="title_search" type="text" class="form-control" placeholder="اسم">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <input id="category_search" type="text" class="form-control" placeholder="نوع">
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col">
            <div class="form-group">
                <input id="order_search" type="text" class="form-control" placeholder="امر التكلفة">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <input id="completion_rate_search" type="text" class="form-control" placeholder="نسبة الانجاز">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <input id="project_supervisor_search" type="text" class="form-control" placeholder="المشرف">
            </div>
        </div>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th>تعديل</th>
            <th>رقم</th>
            <th>اسم</th>
            <th>نوع</th>
            <th>امر التكلفة</th>
            <th>السعر بالدرهم</th>
            <th>بالفرانك</th>
            <th>نسبة الانجاز</th>
            <th>المشرف</th>
            <th>سعر التعاقد</th>
            <th>الدفعة الاولي</th>
            <th>الثانية</th>
            <th>الثالثة</th>
            <th>إجمالي</th>
        </tr>
    </thead>
    <tbody id="results">
        <?php print_r( result_content() ); ?>
    </tbody>
</table>
<script>
(function( $ ) {
    /**
	 * Fetch results.
	 *
	 * @since      1.0.0
	 */	
	jQuery(".search-wrap .form-control").keyup(function() {
        jQuery.ajax({
            type: "POST",
            url: frontend_ajax_url.ajaxurl,
            data: { 
                'action': 'fetch_result',
                'project_number_search': jQuery('#project_number_search').val(),
                'title_search': jQuery('#title_search').val(),
                'category_search': jQuery('#category_search').val(),
                'order_search': jQuery('#order_search').val(),
                'completion_rate_search': jQuery('#completion_rate_search').val(),
                'project_supervisor_search': jQuery('#project_supervisor_search').val()
            },
            success: function(response) {
                jQuery('#results').html(response);
            },
            error: function(response) {
                jQuery('#results').html('<div class="p-3 mb-2 bg-danger text-white">حدث شيء خطأ!.</div>')
            }
        });
		
	});
})( jQuery );
</script>