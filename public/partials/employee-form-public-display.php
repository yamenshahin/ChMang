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
    <input type="hidden" name="action" value="post" />
    <?php wp_nonce_field( 'new-post' ); ?>
    <button type="submit" class="btn btn-primary">إرسال</button>
</form>
