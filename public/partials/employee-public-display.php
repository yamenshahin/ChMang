<?php

/**
 * Provide a public-facing view for the employee role
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
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<section>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col">
                <h1>Employee Dashboard</h1>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li><a class="nav-link active" data-toggle="tab" href="#all">All</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#new">New</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#search">Search</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="tab-content">
                        <div id="all" class="tab-pane active">
                            <h3>All</h3>
                            <table class="table">
                                <thead>
                                    <tr>
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
                                <tbody>

                                </tbody>
                            </table>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                        <div id="new" class="tab-pane fade">
                            <h3>ADD/Edit</h3>
                            <?php include(dirname( __FILE__ ) . '/employee-form-public-display.php'); ?>
                        </div>
                        <div id="search" class="tab-pane fade">
                            <h3>Menu 2</h3>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                        </div>
                        <div id="allDonation" class="tab-pane fade">
                            <h3>Menu 2</h3>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                        </div>
                        <div id="newDonation" class="tab-pane fade">
                            <h3>Menu 2</h3>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer();