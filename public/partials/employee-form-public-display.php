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
<div class="message">
</div>
<form id="campaign" name="campaign" method="post" action="">
    <div class="form-group">
        <label for="project_number">رقم</label>
        <input type="text" class="form-control" id="project_number">
    </div>
    <div class="form-group">
        <label for="title">اسم</label>
        <input type="text" class="form-control" id="title">
    </div>
    <div class="form-group">
        <label for="category">نوع</label>
        <input type="text" class="form-control" id="category">
    </div>
    <div class="form-group">
        <label for="content">الوصف</label>
        <small id="contentHelp" class="form-text text-muted">لا تستخدم HTML ولا علامة comma.</small>
        <textarea class="form-control" id="content" rows="3" aria-describedby="contentHelp" ></textarea>
    </div>
    <div class="form-group">
        <label for="order">امر التكلفة</label>
        <input type="text" class="form-control" id="order">
    </div>
    <div class="form-group">
        <label for="price_in_dirhams">السعر بالدرهم</label>
        <input type="number" class="form-control" id="price_in_dirhams">
    </div>
    <div class="form-group">
        <label for="price_in_francs">السعر بالفرانك</label>
        <input type="number" class="form-control" id="price_in_francs">
    </div>
    <div class="form-group">
        <label for="completion_rate">نسبة الانجاز</label>
        <input type="text" class="form-control" id="completion_rate">
    </div>
    <div class="form-group">
        <label for="project_supervisor">المشرف</label>
        <input type="text" class="form-control" id="project_supervisor">
    </div>
    <div class="form-group">
        <label for="contract_price">سعر التعاقد</label>
        <input type="number" class="form-control" id="contract_price">
    </div>
    <div class="form-group">
        <label for="first_installment">الدفعة الاولي</label>
        <input type="number" class="form-control" id="first_installment">
    </div>
    <div class="form-group">
        <label for="second_installment">الدفعة الثانية</label>
        <input type="number" class="form-control" id="second_installment">
    </div>
    <div class="form-group">
        <label for="third_installment">الدفعة الثالثة</label>
        <input type="number" class="form-control" id="third_installment">
    </div>
    <div class="form-group">
        <label for="total_installment">إجمالي الدفعات</label>
        <input type="number" class="form-control" id="total_installment">
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
        $('.form-control').each(function () {
            if ($(this).val() === '') {
                valid = false;
                return false;
            }
        });
        return valid;
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
                    jQuery('.message').html('<div class="p-3 mb-2 bg-success text-white">تمت الاضافة.</div>')
                    console.log(JSON.stringify(response));
                },
                error: function(response) {
                    jQuery('.message').html('Something wrong happened!');
                    jQuery('.message').html('<div class="p-3 mb-2 bg-danger text-white">حدث شيء خطأ!.</div>')
                }
            });
        } else {
            jQuery('.message').html('<div class="p-3 mb-2 bg-warning text-white">من فضلك املأ كل الحقول.</div>');
        }
		
	});
})( jQuery );
</script>