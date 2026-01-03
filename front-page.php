        <!-- Scroll to Top Button -->
        <button class="scroll-to-top" id="scrollToTop" aria-label="Remonter en haut" type="button" style="display: none;">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polyline class="scroll-arrow" points="7,17 14,10 21,17" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>
        </button>
<script>
// Affiche le bouton au scroll et remonte en haut au clic
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('scrollToTop');
    window.addEventListener('scroll', function() {
        btn.style.display = window.scrollY > 200 ? 'flex' : 'none';
    });
    btn.addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
</script>
<?php
get_header();
?>

<main class="home-container">

    <!-- HERO Section -->
    <section class="hero">
        <h1>Trouvez la musique de vos films<br>et séries préférées&nbsp;!</h1>

        <!-- Version desktop : barre de recherche -->
        <div class="search-bar">
            <input type="text" placeholder="Rechercher…">
            <button class="search-btn" type="button">
                <span class="search-icon" aria-hidden="true" style="display: flex; align-items: center;">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="2"/>
                        <line x1="15.4142" y1="15" x2="20" y2="19.5858" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
            </button>
        </div>
        <!-- Version mobile : bouton S'inscrire -->
        <?php if ( !is_user_logged_in() ) : ?>
        <div class="hero-register-btn-mobile" style="display: none; justify-content: center; margin-top: 24px;">
            <a href="<?php echo esc_url( home_url('/register') ); ?>" class="btn-register-front" style="padding: 14px 32px; font-size: 1.2rem; border-radius: 32px; background: #700118; color: #fff; text-decoration: none; font-weight: bold; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: background 0.2s;">S'inscrire</a>
        </div>
        <?php endif; ?>
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
                            <a href="<?php echo esc_url(home_url('/fiche-film/your-name')); ?>" class="btn-voir">Découvrir</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Stranger Things.jpg' ); ?>" alt="Stranger Things">
                        <div class="slide-content">
                            <span class="slide-title">Stranger Things</span>
                            <a href="<?php echo esc_url(home_url('/fiche-serie/stranger-things')); ?>" class="btn-voir">Découvrir</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Spirited away bannière.jpg' ); ?>" alt="Spirited Away">
                        <div class="slide-content">
                            <span class="slide-title">Spirited Away</span>
                            <a href="<?php echo esc_url(home_url('/fiche-film/spirited-away')); ?>" class="btn-voir">Découvrir</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Wicked.jpg' ); ?>" alt="Wicked">
                        <div class="slide-content">
                            <span class="slide-title">Wicked</span>
                            <a href="<?php echo esc_url(home_url('/fiche-film/wicked')); ?>" class="btn-voir">Découvrir</a>
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
                    <button class="like-btn" data-liked="false" data-type="serie" 
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
                    <button class="like-btn" data-liked="false" data-type="anime" 
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








        <script>
        // Animation au scroll pour .section-animated
        document.addEventListener('DOMContentLoaded', function() {
            const animatedSections = document.querySelectorAll('.section-animated');
            function revealSections() {
                animatedSections.forEach(section => {
                    const rect = section.getBoundingClientRect();
                    if(rect.top < window.innerHeight - 100) {
                        section.classList.add('visible');
                    }
                });
            }
            window.addEventListener('scroll', revealSections);
            revealSections();
        });
        </script>

</main>

<!-- CTA Section (Call To Action) -->


<?php
get_footer();
?>
