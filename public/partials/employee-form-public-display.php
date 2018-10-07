<?php

/**
 * Provide a public-facing view for the employee form to add/edit campaign
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
<div class="row">
    <div class="col">
        <!-- Upload/import CSV files. --> 
        <?php include(dirname( __FILE__ ) . '/employee-import-public-display.php'); ?>
    </div>
</div>
<div class="message">
</div>
<form id="campaign" name="campaign" method="post" action="">
    <div class="form-group">
        <label for="project_number">رقم</label>
        <input type="text" class="form-control form-control-validate" id="project_number">
    </div>
    <div class="form-group">
        <label for="title">اسم</label>
        <input type="text" class="form-control form-control-validate" id="title">
    </div>
    <div class="form-group">
        <label for="category">نوع</label>
        <input type="text" class="form-control form-control-validate" id="category">
    </div>
    <div class="form-group">
        <label for="content">الوصف</label>
        <small id="contentHelp" class="form-text text-muted">لا تستخدم HTML ولا علامة comma.</small>
        <textarea class="form-control form-control-validate" id="content" rows="3" aria-describedby="contentHelp" ></textarea>
    </div>
    <div class="form-group">
        <label for="order">امر التكلفة</label>
        <input type="text" class="form-control form-control-validate" id="order">
    </div>
    <div class="form-group">
        <label for="price_in_dirhams">السعر بالدرهم</label>
        <input type="number" class="form-control form-control-validate" id="price_in_dirhams">
    </div>
    <div class="form-group">
        <label for="price_in_francs">السعر بالفرانك</label>
        <input type="number" class="form-control form-control-validate" id="price_in_francs">
    </div>
    <div class="form-group">
        <label for="completion_rate">نسبة الانجاز</label>
        <input type="text" class="form-control form-control-validate" id="completion_rate">
    </div>
    <div class="form-group">
        <label for="project_supervisor">المشرف</label>
        <input type="text" class="form-control form-control-validate" id="project_supervisor">
    </div>
    <div class="form-group">
        <label for="contract_price">سعر التعاقد</label>
        <input type="number" class="form-control form-control-validate" id="contract_price">
    </div>
    <div class="form-group">
        <label for="first_installment">الدفعة الاولي</label>
        <input type="number" class="form-control form-control-validate" id="first_installment">
    </div>
    <div class="form-group">
        <label for="second_installment">الدفعة الثانية</label>
        <input type="number" class="form-control form-control-validate" id="second_installment">
    </div>
    <div class="form-group">
        <label for="third_installment">الدفعة الثالثة</label>
        <input type="number" class="form-control form-control-validate" id="third_installment">
    </div>
    <div class="form-group">
        <label for="total_installment">إجمالي الدفعات</label>
        <input type="number" class="form-control form-control-validate" id="total_installment">
    </div>
    <button id="add_post" type="button" class="btn btn-primary">إرسال</button>
    <br>
    <div class="message">
    </div>
</form>
<script>
(function( $ ) {
    /**
	 * Add new post campaign.
	 *
	 * @since      1.0.0
	 */	
    function validateForm() {
        var valid = true;
        $('.form-control-validate').each(function () {
            if($(this).attr('id') === 'second_installment' || $(this).attr('id') === 'third_installment' || $(this).attr('id') === 'content') {
                return valid;
            } else if ($(this).val() === '') {
                valid = false;
                return false;
            }
        });
        return valid;
    }
    /**
     * Refresh search section.
     *
     * @since      1.0.0
     */
    function refresh_search_page() {
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
                console.log('Refresh search section is done;');
            },
            error: function(response) {
                console.log('Refresh search section is NOTE done;');
            }
        });
    }
	jQuery("#add_post").click(function(e) {
        e.preventDefault();
        if( validateForm() ) {
            jQuery.ajax({
                type: "POST",
                url: frontend_ajax_url.ajaxurl,
                data: { 
                    'action': 'chmang_add_campaign_post',
                    'project_number': jQuery('#project_number').val(),
                    'title': jQuery('#title').val(),
                    'category': jQuery('#category').val(),
                    'order': jQuery('#order').val(),
                    'content': jQuery('#content').val(),
                    'price_in_dirhams': jQuery('#price_in_dirhams').val(),
                    'price_in_francs': jQuery('#price_in_francs').val(),
                    'completion_rate': jQuery('#completion_rate').val(),
                    'project_supervisor': jQuery('#project_supervisor').val(),
                    'contract_price': jQuery('#contract_price').val(),
                    'first_installment': jQuery('#first_installment').val(),
                    'second_installment': jQuery('#second_installment').val(),
                    'third_installment': jQuery('#third_installment').val(),
                    'total_installment': jQuery('#total_installment').val()
                },
                success: function(response) {
                    jQuery('.message').html(response);
                    jQuery('.message').html('<div class="p-3 mb-2 bg-success text-white">تمت الاضافة.</div>');
                    refresh_search_page();
                    console.log(JSON.stringify(response));
                },
                error: function(response) {
                    jQuery('.message').html('Something wrong happened!');
                    jQuery('.message').html('<div class="p-3 mb-2 bg-danger text-white">حدث شيء خطأ!.</div>');
                }
            });
        } else {
            jQuery('.message').html('<div class="p-3 mb-2 bg-warning text-white">من فضلك املأ كل الحقول.</div>');
        }
		
	});
})( jQuery );
</script>