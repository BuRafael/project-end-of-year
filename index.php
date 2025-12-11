<?php
/**
 * The main template file
 * 
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php
    if ( have_posts() ) :

        // Load posts loop
        while ( have_posts() ) :
            the_post();
            
            the_content();
            
        endwhile;

        // Pagination
        the_posts_navigation();

    else :
        ?>
        <section class="no-results not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'project-end-of-year' ); ?></h1>
            </header>

            <div class="page-content">
                <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'project-end-of-year' ); ?></p>
            </div>
        </section>
        <?php
    endif;
    ?>

</main>

<?php
get_footer();
