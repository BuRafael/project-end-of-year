<?php


/**
 * Template Part: Media Layout (Films & Séries)
 * Utilisé par les pages Films et Séries pour afficher le même layout
 * Usage : include 'template-media-layout.php';
 * Nécessite la variable $media_type = 'film' ou 'serie';
 */

if (!isset($media_type)) {
    $media_type = 'film'; // Par défaut
}

$genres = array('Action', 'Comédie', 'Drame', 'Science-Fiction', 'Horreur', 'Romance');

?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/page-media-layout.css">
<div class="site-container">
    <main>
        <!-- 1. Section À la une -->
        <section class="featured-media">
            <div class="featured-media-inner">
                <div class="featured-a-la-une-text">À la une</div>
                <div class="featured-card">
                    <div class="featured-img-wrap">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/wicked.jpg" alt="Wicked" class="featured-affiche-img">
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
                        <a href="/wicked" class="btn-main fiche-a-la-une">Découvrir</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. Section Tendance du moment (5 éléments) -->
        <section class="trending-media mb-5">
            <h2 class="section-title mb-4">Tendance du moment</h2>
            <div class="trend-list">
                <div class="trend-card">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/ne zha 2.jpg" alt="Ne Zha 2">
                    <h4>Ne Zha 2</h4>
                </div>
                <div class="trend-card">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/lilo & stitch (2025).jpeg" alt="Lilo & Stitch (2025)">
                    <h4>Lilo & Stitch (2025)</h4>
                </div>
                <div class="trend-card">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/minecraft - the movie.webp" alt="Minecraft – The Movie">
                    <h4>Minecraft – The Movie</h4>
                </div>
                <div class="trend-card">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/mission impossible the final reckoning.webp" alt="Mission: Impossible – The Final Reckoning">
                    <h4>Mission: Impossible – The Final Reckoning</h4>
                </div>
                <div class="trend-card">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/f1 (2025).png" alt="F1 (2025)">
                    <h4>F1 (2025)</h4>
                </div>
            </div>
        </section>

        <!-- 3. Section Nouveautés (5 éléments) -->
        <section class="new-media mb-5">
            <h2 class="section-title mb-4">Nouveautés</h2>
            <div class="trend-list">
                <div class="trend-card">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/the ice tower.jpg" alt="The Ice Tower">
                    <h4>The Ice Tower</h4>
                </div>
                <div class="trend-card">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/sinners.avif" alt="Sinners">
                    <h4>Sinners</h4>
                </div>
                <div class="trend-card">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/one battle after another.jpg" alt="One Battle After Another">
                    <h4>One Battle After Another</h4>
                </div>
                <div class="trend-card">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/the naked gun.webp" alt="The Naked Gun (2025)">
                    <h4>The Naked Gun (2025)</h4>
                </div>
                <div class="trend-card">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/blue moon.jpg" alt="Blue Moon">
                    <h4>Blue Moon</h4>
                </div>
            </div>
        </section>

        <!-- 4. Carrousels par genre (Action, Comédie, Horreur, Romance, Science-Fiction) -->
        <?php
        $display_genres = array('Action', 'Comédie', 'Horreur', 'Romance', 'Science-Fiction');
        foreach ($display_genres as $genre) : ?>
            <section class="movie-section mt-5 mb-4">
                <h3 class="section-title mb-3"><?php echo esc_html($genre); ?></h3>
                <div class="d-flex align-items-center">
                    <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <div class="row flex-grow-1 mx-3 g-3" id="carousel-<?php echo esc_attr($media_type); ?>-<?php echo strtolower(str_replace('-', '', $genre)); ?>">
                        <!-- JS insère les éléments ici -->
                    </div>
                    <button class="carousel-arrow right d-flex align-items-center justify-content-center" type="button">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </section>
        <?php endforeach; ?>
    </main>
</div>
<script>
    // Charger les éléments par genre
    const genres = <?php echo json_encode($genres); ?>;
    const mediaType = '<?php echo esc_js($media_type); ?>';
    // ... JS pour charger les films/séries dynamiquement ...
</script>
