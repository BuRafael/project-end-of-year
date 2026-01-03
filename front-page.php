<?php
get_header();
?>

<main class="home-container">

    <!-- HERO Section -->
    <section class="hero">
        <h1>Trouvez la musique de vos films<br>et séries préférées&nbsp;!</h1>

        <div class="search-bar">
            <input type="text" placeholder="Rechercher…">
            <button class="search-btn" type="button">
                <span class="search-icon">🔍</span>
            </button>
        </div>
    </section>

    <!-- CAROUSEL Section -->
    <section class="carousel-section">
        <div class="carousel-wrapper">
            <button class="carousel-arrow left" aria-label="Image précédente" type="button">❮</button>

            <div class="carousel-viewport">
                <div class="carousel-track">
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/your name.jpg' ); ?>" alt="Your Name">
                        <div class="slide-content">
                            <span class="slide-title">Your Name</span>
                            <a href="<?php echo esc_url(home_url('/your-name')); ?>" class="btn-voir">Découvrir</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Stranger Things.jpg' ); ?>" alt="Stranger Things">
                        <div class="slide-content">
                            <span class="slide-title">Stranger Things</span>
                            <a href="<?php echo esc_url(home_url('/stranger-things')); ?>" class="btn-voir">Découvrir</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/chihiro.jpg' ); ?>" alt="Spirited Away">
                        <div class="slide-content">
                            <span class="slide-title">Spirited Away</span>
                            <a href="<?php echo esc_url(home_url('/spirited-away')); ?>" class="btn-voir">Découvrir</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Wicked.jpg' ); ?>" alt="Wicked">
                        <div class="slide-content">
                            <span class="slide-title">Wicked</span>
                            <a href="<?php echo esc_url(home_url('/wicked')); ?>" class="btn-voir">Découvrir</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Attaque des titans.jpg' ); ?>" alt="L'Attaque des Titans">
                        <div class="slide-content">
                            <span class="slide-title">L'Attaque des Titans</span>
                            <a href="<?php echo esc_url(home_url('/attack-on-titan')); ?>" class="btn-voir">Découvrir</a>
                        </div>
                    </div>
                </div>
            </div>

            <button class="carousel-arrow right" aria-label="Image suivante" type="button">❯</button>

            <div class="carousel-dots">
                <button class="dot active" data-slide="0" type="button" aria-label="Slide 1"></button>
                <button class="dot" data-slide="1" type="button" aria-label="Slide 2"></button>
                <button class="dot" data-slide="2" type="button" aria-label="Slide 3"></button>
                <button class="dot" data-slide="3" type="button" aria-label="Slide 4"></button>
                <button class="dot" data-slide="4" type="button" aria-label="Slide 5"></button>
            </div>
        </div>
    </section>

    <!-- QUI SOMMES-NOUS? Section -->
    <section class="about-section">
        <h2>Qui sommes-nous ?</h2>

        <div class="about-columns">
            <div class="about-col">
                <p>Ce site réunit les bandes originales de milliers de films et séries pour les retrouver facilement en un instant.</p>
            </div>
            <div class="about-col">
                <p>Une plateforme simple pour explorer les musiques qui accompagnent vos films et séries préférés.</p>
            </div>
            <div class="about-col">
                <p>Un espace pensé pour découvrir, écouter et sauvegarder toutes les bandes originales qui vous marquent.</p>
            </div>
        </div>
    </section>

    <!-- TOP 5 Section -->
    <section class="tops-section">
        <!-- TOP 5 FILMS -->
        <div class="top-card">
            <div class="top-header">Top 5 films</div>
            <?php 
            $movie_query = new WP_Query(array(
                'post_type'      => 'movie',
                'posts_per_page' => 5,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'media_type',
                        'field'    => 'slug',
                        'terms'    => 'film',
                    ),
                ),
            ));
            ?>
            <ul class="top-list">
                <?php 
                if ($movie_query->have_posts()) :
                    while ($movie_query->have_posts()) : $movie_query->the_post();
                        $director = get_post_meta(get_the_ID(), '_movie_director', true);
                        $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                        $poster = get_the_post_thumbnail_url(get_the_ID(), 'full');
                        $movie_url = get_permalink();
                ?>
                <li>
                    <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                    <div class="top-info">
                        <a href="<?php echo esc_url($movie_url); ?>" class="top-title-link"><?php the_title(); ?></a>
                        <a href="<?php echo esc_url($movie_url); ?>" class="top-composer-link"><?php echo esc_html($director); ?></a>
                    </div>
                    <button class="like-btn" data-liked="false" data-type="film" 
                            data-poster="<?php echo esc_url($poster); ?>" 
                            type="button" aria-label="Like">♡</button>
                </li>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </ul>
        </div>

        <!-- TOP 5 SERIES -->
         <div class="top-card">
            <div class="top-header">Top 5 series</div>
            <?php 
            $serie_query = new WP_Query(array(
                'post_type'      => 'movie',
                'posts_per_page' => 5,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'media_type',
                        'field'    => 'slug',
                        'terms'    => 'serie',
                    ),
                ),
            ));
            ?>
            <ul class="top-list">
                <?php 
                if ($serie_query->have_posts()) :
                    while ($serie_query->have_posts()) : $serie_query->the_post();
                        $director = get_post_meta(get_the_ID(), '_movie_director', true);
                        $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                        $poster = get_the_post_thumbnail_url(get_the_ID(), 'full');
                        $movie_url = get_permalink();
                ?>
                <li>
                    <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                    <div class="top-info">
                        <a href="<?php echo esc_url($movie_url); ?>" class="top-title-link"><?php the_title(); ?></a>
                        <a href="<?php echo esc_url($movie_url); ?>" class="top-composer-link"><?php echo esc_html($director); ?></a>
                    </div>
                    <button class="like-btn" data-liked="false" data-type="film" 
                            data-poster="<?php echo esc_url($poster); ?>" 
                            type="button" aria-label="Like">♡</button>
                </li>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </ul>
        </div>

        <!-- TOP 5 ANIMES -->
                 <div class="top-card">
            <div class="top-header">Top 5 anime</div>
            <?php 
            $anime_query = new WP_Query(array(
                'post_type'      => 'movie',
                'posts_per_page' => 5,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'media_type',
                        'field'    => 'slug',
                        'terms'    => 'anime',
                    ),
                ),
            ));
            ?>
            <ul class="top-list">
                <?php 
                if ($anime_query->have_posts()) :
                    while ($anime_query->have_posts()) : $anime_query->the_post();
                        $director = get_post_meta(get_the_ID(), '_movie_director', true);
                        $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                        $poster = get_the_post_thumbnail_url(get_the_ID(), 'full');
                        $movie_url = get_permalink();
                ?>
                <li>
                    <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                    <div class="top-info">
                        <a href="<?php echo esc_url($movie_url); ?>" class="top-title-link"><?php the_title(); ?></a>
                        <a href="<?php echo esc_url($movie_url); ?>" class="top-composer-link"><?php echo esc_html($director); ?></a>
                    </div>
                    <button class="like-btn" data-liked="false" data-type="film" 
                            data-poster="<?php echo esc_url($poster); ?>" 
                            type="button" aria-label="Like">♡</button>
                </li>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </ul>
        </div>
    </section>

    <!-- CTA Section (Call To Action) -->
    <section class="cta-section">
        <div class="cta-text">
            <p>
                Ne ratez plus jamais vos bandes originales préférées.<br>
                Rejoignez notre communauté et plongez dans<br>
                l'univers musical de tous vos films et séries favoris !
            </p>
            <?php if (!is_user_logged_in()) : ?>
                <?php echo cinemusic_signup_button(); ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop" aria-label="Revenir en haut" type="button" style="display: none;">↑</button>

</main>

<?php
get_footer();
?>
