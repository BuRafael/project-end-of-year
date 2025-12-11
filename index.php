<?php
/**
 * The main template file
 * Fichier template principal requis par WordPress
 */

get_header();
?>

<main class="site-main container py-5">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;
    else :
        ?>
        <p><?php esc_html_e( 'Aucun contenu trouvé.', 'project-end-of-year' ); ?></p>
        <?php
    endif;
    ?>
</main>

<?php
get_footer();
?>
