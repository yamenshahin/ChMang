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
$current_user = wp_get_current_user();
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<section>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col">
                <h1>Donor <?= $current_user->user_firstname . ' ' . $current_user->user_lastname; ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer();