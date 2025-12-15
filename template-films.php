
<?php
/**
 * Template Name: Films
 * Template Post Type: page
 * Description: Page listant tous les films par genre
 */
get_header();
?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/page-media-layout.css">
<div class="site-container">
    <main>
    <!-- À la une -->
        <section class="featured-media">
            <div class="featured-banner-bg">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/bannière wicked.jpg" alt="Bannière Wicked" class="banner-img">
            </div>
            <div class="featured-media-inner">
                <div class="featured-a-la-une-text">À la une</div>
                <div class="featured-main-row center-featured">
                    <div class="featured-affiche-col">
                        <div class="featured-affiche-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/wicked.jpg" alt="Wicked" class="featured-affiche-img">
                        </div>
                    </div>
                    <div class="featured-infos-col">
                        <h2 class="featured-title">Wicked</h2>
                        <div class="featured-meta improved-meta">
                            <span class="meta-year">2024</span>
                            <span class="meta-dot">•</span>
                            <span class="meta-director">Jon M. Chu</span>
                            <span class="meta-dot">•</span>
                            <span class="meta-duration">2h 15min</span>
                            <span class="meta-dot">•</span>
                            <span class="meta-genres">Comédie musicale, Fantastique</span>
                        </div>
                        <div class="featured-synopsis">
                            <p>Découvrez l'histoire inédite des sorcières d'Oz, bien avant l'arrivée de Dorothy. Un film musical spectaculaire, adaptation du célèbre show de Broadway, avec Cynthia Erivo et Ariana Grande.</p>
                        </div>
                        <a href="/wicked" class="btn-main improved-btn">Voir la fiche</a>
                    </div>
                </div>
            </div>
        </section>

    <!-- Top 5 du moment -->
    <section class="top-media">
        <h2>Top 5 du moment</h2>
        <div class="top-list">
            <div class="top-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/Arrival.webp" alt="Arrival"><span class="top-rank">#1</span><h4>Arrival</h4></div>
            <div class="top-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/chihiro.jpg" alt="Chihiro"><span class="top-rank">#2</span><h4>Chihiro</h4></div>
            <div class="top-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/your name.jpg" alt="Your Name"><span class="top-rank">#3</span><h4>Your Name</h4></div>
            <div class="top-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/parasite.jpg" alt="Parasite"><span class="top-rank">#4</span><h4>Parasite</h4></div>
            <div class="top-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/la la land affiche.jpg" alt="La La Land"><span class="top-rank">#5</span><h4>La La Land</h4></div>
        </div>
    </section>

    <!-- Nouveautés -->
    <section class="new-media">
        <h2>Nouveautés</h2>
        <div class="new-list">
            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/oppenheimer.jpg" alt="Oppenheimer"><h4>Oppenheimer</h4></div>
            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/barbie.jpg" alt="Barbie"><h4>Barbie</h4></div>
            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/dune.jpg" alt="Dune"><h4>Dune</h4></div>
            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/poor things.jpg" alt="Poor Things"><h4>Poor Things</h4></div>
        </div>
    </section>

    <!-- Carrousels par genre (2 exemples) -->
    <section class="genre-media">
        <h2>Action <a href="#" class="see-all">Voir tout</a></h2>
        <div class="genre-carousel">
            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/inception affiche film.jpg" alt="Inception"><h4>Inception</h4></div>
            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/mad max.jpg" alt="Mad Max"><h4>Mad Max</h4></div>
            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/john wick.jpg" alt="John Wick"><h4>John Wick</h4></div>
            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/avengers.jpg" alt="Avengers"><h4>Avengers</h4></div>
        </div>
    </section>
    <section class="genre-media">
        <h2>Comédie <a href="#" class="see-all">Voir tout</a></h2>
        <div class="genre-carousel">
            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/intouchables.jpg" alt="Intouchables"><h4>Intouchables</h4></div>
            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/the mask.jpg" alt="The Mask"><h4>The Mask</h4></div>
            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/very bad trip.jpg" alt="Very Bad Trip"><h4>Very Bad Trip</h4></div>
            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/les bronzes.jpg" alt="Les Bronzés"><h4>Les Bronzés</h4></div>
        </div>
    </section>
    </main>
</div>

<?php get_footer(); ?>
