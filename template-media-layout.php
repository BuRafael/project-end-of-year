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
            <div class="featured-media-inner" style="position: relative; z-index: 2; margin-top: 0;">
                <div class="featured-a-la-une-text" style="margin-top: 40px;">À la une</div>
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
            <div class="media-trend-list">
                <!-- JS ou PHP insère ici les 5 films/séries tendance -->
            </div>
        </section>

        <!-- 3. Section Nouveautés (5 éléments) -->
        <section class="new-media mb-5">
            <h2 class="section-title mb-4">Nouveautés</h2>
            <div class="media-new-list">
                <!-- JS ou PHP insère ici les 5 nouveautés -->
            </div>
        </section>

        <!-- 4. Carrousels par genre (Action, Comédie, Horreur, Romance, Science-Fiction) -->
        <?php
        $display_genres = array('Action', 'Comédie', 'Horreur', 'Romance', 'Science-Fiction');
        foreach ($display_genres as $genre) : ?>
            <section class="movies-section mb-5">
                <h2 class="section-title mb-4"><?php echo esc_html($genre); ?></h2>
                <div class="movies-carousel" data-type="<?php echo esc_attr($media_type); ?>" data-genre="<?php echo esc_attr($genre); ?>">
                    <button class="carousel-arrow left" aria-label="Précédent">&#x276e;</button>
                    <div class="carousel-viewport">
                        <div class="carousel-track" id="carousel-<?php echo esc_attr($media_type); ?>-<?php echo strtolower(str_replace('-', '', $genre)); ?>">
                            <!-- JS insère les éléments ici -->
                        </div>
                    </div>
                    <button class="carousel-arrow right" aria-label="Suivant">&#x276f;</button>
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
