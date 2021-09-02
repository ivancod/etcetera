<?php

/**
 * Template Name: About us
 */

get_header();
?>

    <section id="primary" class="content-area col-sm-12 col-lg-8">
        <div id="main" class="site-main" role="main">
            <div class="container">
               <h1><? the_title() ?></h1>
               <div><? the_content() ?></div>
            </div>
        </div><!-- #main -->
    </section><!-- #primary -->

<?php
get_sidebar();
get_footer();