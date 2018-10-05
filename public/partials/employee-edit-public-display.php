<?php

/**
 * Provide a public-facing view for the employee to edit campaign
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/yamenshahin/
 * @since      1.0.0
 *
 * @package    Chmang
 * @subpackage Chmang/public/partials
 */
get_header(); 
if ( $_GET['postID'] ) {
    $post = get_post($_GET['postID']);
    $post_meta = get_post_meta($_GET['postID']);
    $terms = wp_get_post_terms($_GET['postID'], 'campaign_category');
}

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php 
if(!is_can_access('employee')) {
?>
<section>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col">
                <div class="p-3 mb-2 bg-warning text-white">ليس لديك إذن للوصول إلى هذه الصفحة. إذا حدث هذا عن طريق الخطأ ، يرجى الاتصال بالدعم.</div>
                </div>      
            </div> 
        </div>
    </div>
</section>
<?php
} else {
?>
<section>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>Edit Campaign</h1>
                    <div class="message">
                    </div>
                    <form id="campaign" name="campaign" method="post" action="">
                        <div class="form-group">
                            <label for="project_number">رقم</label>
                            <input type="text" class="form-control form-control-validate" id="project_number" value="<?php echo $post_meta['project_number'][0]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="title">اسم</label>
                            <input type="text" class="form-control form-control-validate" id="title" value="<?php echo $post->post_title; ?>">
                        </div>
                        <div class="form-group">
                            <label for="category">نوع</label>
                            <input type="text" class="form-control form-control-validate" id="category" value="<?php echo  $terms[0]->name; ?>">  
                        </div>
                        <div class="form-group">
                            <label for="content">الوصف</label>
                            <small id="contentHelp" class="form-text text-muted">لا تستخدم HTML ولا علامة comma.</small>
                            <textarea class="form-control form-control-validate" id="content" rows="3" aria-describedby="contentHelp"><?php echo $post->post_content; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="order">امر التكلفة</label>
                            <input type="text" class="form-control form-control-validate" id="order" value="<?php echo $post_meta['order'][0]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="price_in_dirhams">السعر بالدرهم</label>
                            <input type="number" class="form-control form-control-validate" id="price_in_dirhams" value="<?php echo $post_meta['price_in_dirhams'][0]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="price_in_francs">السعر بالفرانك</label>
                            <input type="number" class="form-control form-control-validate" id="price_in_francs" value="<?php echo $post_meta['price_in_francs'][0]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="completion_rate">نسبة الانجاز</label>
                            <input type="text" class="form-control form-control-validate" id="completion_rate" value="<?php echo $post_meta['completion_rate'][0]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="project_supervisor">المشرف</label>
                            <input type="text" class="form-control form-control-validate" id="project_supervisor" value="<?php echo $post_meta['project_supervisor'][0]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="contract_price">سعر التعاقد</label>
                            <input type="number" class="form-control form-control-validate" id="contract_price" value="<?php echo $post_meta['contract_price'][0]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="first_installment">الدفعة الاولي</label>
                            <input type="number" class="form-control form-control-validate" id="first_installment" value="<?php echo $post_meta['first_installment'][0]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="second_installment">الدفعة الثانية</label>
                            <input type="number" class="form-control form-control-validate" id="second_installment" value="<?php echo $post_meta['second_installment'][0]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="third_installment">الدفعة الثالثة</label>
                            <input type="number" class="form-control form-control-validate" id="third_installment" value="<?php echo $post_meta['third_installment'][0]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="total_installment">إجمالي الدفعات</label>
                            <input type="number" class="form-control form-control-validate" id="total_installment" value="<?php echo $post_meta['total_installment'][0]; ?>">
                        </div>
                        <button id="add_post" type="button" class="btn btn-primary">إرسال</button>
                        <br>
                        <div class="message">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
(function( $ ) {
    /**
	 * Edit post campaign.
	 *
	 * @since      1.0.0
	 */	
    function validateForm() {
        var valid = true;
        $('.form-control-validate').each(function () {
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
                    'action': 'chmang_edit_campaign_post',
                    'post_id':<?php echo $_GET["postID"]; ?>,
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
                    jQuery('.message').html('<div class="p-3 mb-2 bg-success text-white">تمت التحديث.</div>')
                    console.log(JSON.stringify(response));
                },
                error: function(response) {
                    jQuery('.message').html('<div class="p-3 mb-2 bg-danger text-white">حدث شيء خطأ!.</div>')
                }
            });
        } else {
            jQuery('.message').html('<div class="p-3 mb-2 bg-warning text-white">من فضلك املأ كل الحقول.</div>');
        }
		
	});
})( jQuery );
</script>
<?php
}
get_footer();