<?php

/**
 * Provide a public-facing view for the donor role
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
$user_history = new Chmang_Public('chmang', '1.0.0');

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php 
if(!is_can_access('donor')) {
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
                <h1>المتبرع <?= $current_user->user_firstname . ' ' . $current_user->user_lastname; ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h3>تاريخ التبرع الخاص بك</h3>
                    
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">اسم المشروع</th>
                            <th scope="col">مبلغ التبرع</th>
                            <th scope="col">تاريخ التبرع</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  echo $user_history->chmang_get_donor_history(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
}
get_footer();