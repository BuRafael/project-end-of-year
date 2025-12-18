
<?php
/**
 * Template Name: Films
 * Template Post Type: page
 * Description: Page listant tous les films par genre
 */
get_header();
$media_type = 'film';
include(locate_template('template-media-layout.php'));
get_footer();
