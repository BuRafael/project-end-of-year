<?php
/**
 * Template Name: Séries
 * Template Post Type: page
 * Description: Page listant toutes les séries par genre
 */

get_header();
?>

<main class="movies-page container py-5">
    <h1 class="text-center mb-5">Toutes les Séries</h1>

    <?php
    $genres = array('Action', 'Comédie', 'Drame', 'Science-Fiction', 'Horreur', 'Romance');
    
    foreach ($genres as $genre) :
    ?>
        <section class="movies-section mb-5">
            <h2 class="section-title mb-4"><?php echo esc_html($genre); ?></h2>
            
            <div class="movies-carousel" data-type="serie" data-genre="<?php echo esc_attr($genre); ?>">
                <button class="carousel-arrow left" aria-label="Précédent">❮</button>
                
                <div class="carousel-viewport">
                    <div class="carousel-track" id="carousel-serie-<?php echo strtolower(str_replace('-', '', $genre)); ?>">
                        <!-- JS insère les séries ici -->
                    </div>
                </div>
                
                <button class="carousel-arrow right" aria-label="Suivant">❯</button>
            <?php
            /**
             * Template Name: Séries
             * Template Post Type: page
             * Description: Page listant toutes les séries par genre
             */
            get_header();
            $media_type = 'serie';
            include(locate_template('template-media-layout.php'));
            get_footer();
                                            <div class="featured-a-la-une-text">À la une</div>
                                            <div class="featured-main-row">
                                                <div class="featured-affiche-col">
                                                    <div class="featured-affiche-wrap">
                                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/stranger things.jpg" alt="Stranger Things" class="featured-affiche-img">
                                                    </div>
                                                </div>
                                                <div class="featured-infos-col">
                                                    <h2 class="featured-title">Stranger Things</h2>
                                                    <div class="featured-meta improved-meta">
                                                        <span class="meta-year">2016</span>
                                                        <span class="meta-dot">•</span>
                                                        <span class="meta-director">Duffer Brothers</span>
                                                        <span class="meta-dot">•</span>
                                                        <span class="meta-duration">4 saisons</span>
                                                        <span class="meta-dot">•</span>
                                                        <span class="meta-genres">Science-fiction, Horreur</span>
                                                    </div>
                                                    <div class="featured-synopsis">
                                                        <p>Dans la petite ville d'Hawkins, des enfants affrontent des phénomènes surnaturels et un monde parallèle terrifiant. Une série culte mêlant mystère, aventure et nostalgie 80s.</p>
                                                    </div>
                                                    <a href="/stranger-things" class="btn-main improved-btn">Voir la fiche</a>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <!-- Top 5 du moment -->
                                    <section class="top-media">
                                        <h2>Top 5 du moment</h2>
                                        <div class="top-list">
                                            <div class="top-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/the last of us.jpg" alt="The Last of Us"><span class="top-rank">#1</span><h4>The Last of Us</h4></div>
                                            <div class="top-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/arcane.jpg" alt="Arcane"><span class="top-rank">#2</span><h4>Arcane</h4></div>
                                            <div class="top-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/dark.jpg" alt="Dark"><span class="top-rank">#3</span><h4>Dark</h4></div>
                                            <div class="top-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/peaky blinders.jpg" alt="Peaky Blinders"><span class="top-rank">#4</span><h4>Peaky Blinders</h4></div>
                                            <div class="top-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/breaking bad.jpg" alt="Breaking Bad"><span class="top-rank">#5</span><h4>Breaking Bad</h4></div>
                                        </div>
                                    </section>

                                    <!-- Nouveautés -->
                                    <section class="new-media">
                                        <h2>Nouveautés</h2>
                                        <div class="new-list">
                                            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/the bear.jpg" alt="The Bear"><h4>The Bear</h4></div>
                                            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/one piece.jpg" alt="One Piece"><h4>One Piece</h4></div>
                                            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/the idol.jpg" alt="The Idol"><h4>The Idol</h4></div>
                                            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/1899.jpg" alt="1899"><h4>1899</h4></div>
                                        </div>
                                    </section>

                                    <!-- Carrousels par genre (2 exemples) -->
                                    <section class="genre-media">
                                        <h2>Science-Fiction <a href="#" class="see-all">Voir tout</a></h2>
                                        <div class="genre-carousel">
                                            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/stranger things.jpg" alt="Stranger Things"><h4>Stranger Things</h4></div>
                                            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/dark.jpg" alt="Dark"><h4>Dark</h4></div>
                                            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/1899.jpg" alt="1899"><h4>1899</h4></div>
                                            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/black mirror.jpg" alt="Black Mirror"><h4>Black Mirror</h4></div>
                                        </div>
                                    </section>
                                    <section class="genre-media">
                                        <h2>Drame <a href="#" class="see-all">Voir tout</a></h2>
                                        <div class="genre-carousel">
                                            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/breaking bad.jpg" alt="Breaking Bad"><h4>Breaking Bad</h4></div>
                                            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/peaky blinders.jpg" alt="Peaky Blinders"><h4>Peaky Blinders</h4></div>
                                            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/the bear.jpg" alt="The Bear"><h4>The Bear</h4></div>
                                            <div class="new-card"><img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/the crown.jpg" alt="The Crown"><h4>The Crown</h4></div>
                                        </div>
                                    </section>
                                </main>
                                </div>

