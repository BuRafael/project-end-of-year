<?php
/**
 * Search Results Template
 *
 * Used to display search results pages.
 */
get_header();
?>
<main id="primary" class="site-main">
    <section class="search-results">
        <header class="page-header">
            <h1 class="page-title">
                <?php printf( esc_html__( 'Résultats de recherche pour : %s', 'project-end-of-year' ), '<span>' . get_search_query() . '</span>' ); ?>
            </h1>
        </header>
        <?php if ( have_posts() ) : ?>
            <ul class="search-list">
                <?php while ( have_posts() ) : the_post(); ?>
                    <li class="search-item">
                        <a href="<?php the_permalink(); ?>">
                            <h2><?php the_title(); ?></h2>
                            <div class="search-excerpt"><?php the_excerpt(); ?></div>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
            <?php the_posts_navigation(); ?>
        <?php else : ?>
            <div class="no-results">
                <h2><?php esc_html_e( 'Aucun résultat trouvé.', 'project-end-of-year' ); ?></h2>
                <p><?php esc_html_e( 'Essayez un autre mot-clé.', 'project-end-of-year' ); ?></p>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php get_footer(); ?>
