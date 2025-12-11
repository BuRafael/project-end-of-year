<?php
/**
 * Template Name: Fiche Film
 * Template Post Type: page
 * Description: Template pour afficher la fiche détaillée d'un film
 */

get_header();

// Récupérer les infos du film basé sur le slug
global $post;
$page_slug = isset($post->post_name) ? $post->post_name : 'inception';
$movie = get_movie_data_by_slug($page_slug);

// Infos supplémentaires codées pour chaque film
$movie_info = array(
    'inception' => array(
        'duration' => '2h28',
        'rating' => '8,8/10',
        'director' => 'Christopher Nolan',
        'cast' => 'Leonardo DiCaprio, Joseph Gordon-Levitt, Elliot Page, Tom Hardy, Dileep Rao, Ken Watanabe',
        'synopsis' => 'Dom Cobb est un voleur expérimenté dans l\'art périlleux de l\'extraction : sa spécialité consiste à s\'approprier les secrets les plus précieux d\'un individu, enfouis au plus profond de son subconscient, pendant qu\'il rêve et que son esprit est particulièrement vulnérable. Très recherché pour ses talents dans l\'univers trouble de l\'espionnage industriel, Cobb est aussi devenu un fugitif traqué dans le monde entier. Cependant, une ultime mission pourrait lui permettre de retrouver sa vie d\'avant.'
    ),
    'la-la-land' => array(
        'duration' => '2h08',
        'rating' => '8,0/10',
        'director' => 'Damien Chazelle',
        'cast' => 'Ryan Gosling, Emma Stone, John Legend, Rosemarie DeWitt',
        'synopsis' => 'Mia, une actrice en herbe qui sert les clients d\'un café sur les plateaux de cinéma, rencontre Sebastian, un pianiste de jazz passionné. Tous deux rêvent de réussir dans leurs domaines respectifs. Avec l\'aide l\'un de l\'autre, ils se soutiennent et s\'inspirent mutuellement, naviguant dans l\'industrie du divertissement de Los Angeles tout en approfondissant leur relation amoureuse.',
        'genres_display' => 'Comédie • Drame • Musical • Romance'
    ),
    'stranger-things' => array(
        'duration' => '50min/épisode',
        'rating' => '8,7/10',
        'director' => 'Matt Duffer, Ross Duffer',
        'cast' => 'Millie Bobby Brown, Finn Wolfhard, Winona Ryder',
        'synopsis' => 'Dans les années 80, à Hawkins dans l\'Indiana, un jeune garçon disparaît mystérieusement. Ses amis, sa famille et la police locale se lancent dans une quête extraordinaire pour le retrouver.'
    )
);

// Définir les variables
if ($movie) {
    $title = $movie->title;
    $year = $movie->year;
    $affiche = $movie->affiche;
    $info = isset($movie_info[$page_slug]) ? $movie_info[$page_slug] : $movie_info['inception'];
    $genre = isset($info['genres_display']) ? $info['genres_display'] : $movie->genre;
} else if (isset($movie_info[$page_slug])) {
    $info = $movie_info[$page_slug];
    $title = ucwords(str_replace('-', ' ', $page_slug));
    $genre = 'Romance';
    $year = 2016;
    $affiche = $page_slug . ' affiche film.jpg';
        $genre = isset($info['genres_display']) ? $info['genres_display'] : $genre;
} else {
    $title = 'Inception';
    $year = 2010;
    $affiche = 'inception affiche film.jpg';
    $genre = 'Action';
    $info = $movie_info['inception'];
}

?>

<!-- ===== CONTENU FICHE FILM ===== -->
<main class="movie-page container py-5">

    <!-- TITRE + INFOS GENERALES -->
    <section class="movie-header mb-5">
        <h1 class="fw-bold mb-1"><?php echo esc_html($title); ?></h1>
        <p class="movie-sub small text-secondary mb-4"><?php echo esc_html($year); ?> – 12 pistes</p>

        <div class="row g-4">
            <!-- POSTER -->
            <div class="col-md-4 col-lg-3">
                <div class="movie-poster-wrapper text-center text-md-start">
                    <?php 
                    $poster_path = get_template_directory() . '/assets/image/Fiche films/' . $affiche;
                    $poster_url = get_template_directory_uri() . '/assets/image/Fiche films/' . $affiche;
                    
                    // Si l'affiche n'existe pas, utiliser celle d'Inception par défaut
                    if (!file_exists($poster_path)) {
                        $poster_url = get_template_directory_uri() . '/assets/image/Fiche films/inception affiche film.jpg';
                    }
                    ?>
                    <img src="<?php echo esc_url($poster_url); ?>" alt="Affiche <?php echo esc_attr($title); ?>"
                         class="movie-poster img-fluid shadow">
                    <button id="movieLikeBtn" class="movie-like-btn p-0" aria-pressed="false" type="button">
                        <i class="bi bi-heart" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <!-- SYNOPSIS + META -->
            <div class="col-md-8 col-lg-9">
                <h5 class="mb-2" style="color: rgba(112, 1, 24, 1);">Synopsis</h5>
                <p class="movie-synopsis small text-light mb-4">
                    <?php echo esc_html($info['synopsis']); ?>
                </p>

                <div class="row movie-meta small">
                    <div class="col-6 col-sm-3 mb-3">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Durée</div>
                        <div class="movie-meta-value"><?php echo esc_html($info['duration']); ?></div>
                    </div>
                    <div class="col-6 col-sm-3 mb-3">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Note</div>
                        <div class="movie-meta-value"><?php echo esc_html($info['rating']); ?></div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Réalisateur</div>
                        <div class="movie-meta-value text-white"><?php echo esc_html($info['director']); ?></div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Acteurs</div>
                        <div class="movie-meta-value text-white">
                            <?php echo esc_html($info['cast']); ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Genre</div>
                        <div class="movie-meta-value text-white">
                            <?php echo esc_html($genre); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PISTES ===== -->
    <section class="movie-section mt-5">
        <div class="table-responsive">
            <table class="table movie-tracks-table align-middle mb-3">
                <thead>
                <tr>
                    <th class="col-num">#</th>
                    <th class="col-title">Pistes</th>
                    <th class="col-links">Liens</th>
                    <th class="col-duration text-center">Durée</th>
                    <th class="col-like"></th>
                </tr>
                </thead>
                <tbody id="tracksTable">
                <!-- JS génère ici les pistes -->
                </tbody>
            </table>
        </div>

        <div class="text-center">
            <button id="tracksMoreBtn" class="btn movie-btn-light small px-5">Afficher plus…</button>
        </div>
    </section>

    <!-- ===== COMMENTAIRES ===== -->
    <section class="movie-section mt-5">
        <h3 class="section-title mb-3">Commentaires</h3>

        <?php if ( is_user_logged_in() ) : 
            $current_user = wp_get_current_user();
            $profile_photo = get_user_meta( $current_user->ID, 'avatar_url', true );
        ?>
        <div class="comment-input-row d-flex align-items-center gap-3 pb-3 mb-4">
            <div class="comment-avatar rounded-circle overflow-hidden d-flex align-items-center justify-content-center">
                <?php if ( ! empty( $profile_photo ) ) : ?>
                    <img src="<?php echo esc_url( $profile_photo ); ?>" alt="Photo de profil" class="w-100 h-100" style="object-fit: cover;">
                <?php else : ?>
                    <i class="bi bi-person"></i>
                <?php endif; ?>
            </div>
            <div class="flex-grow-1">
                <input type="text"
                       class="form-control comment-input"
                       placeholder="Écrire un commentaire"
                       data-user-name="<?php echo esc_attr( $current_user->display_name ); ?>"
                       maxlength="200">
            </div>
        </div>
        <?php else : ?>
        <div class="comment-input-row d-flex align-items-center gap-3 pb-3 mb-4">
            <div class="comment-avatar rounded-circle d-flex align-items-center justify-content-center" style="opacity: 0.5;">
                <i class="bi bi-person"></i>
            </div>
            <div class="flex-grow-1">
                <input type="text"
                       class="form-control comment-input"
                       placeholder="Connectez-vous pour commenter"
                       maxlength="200"
                       disabled>
            </div>
        </div>
        <?php endif; ?>

        <div class="row g-3" id="commentsZone">
            <!-- JS charge les commentaires -->
        </div>

        <div class="text-center mt-4" id="commentsMoreBtnWrapper" style="display: none;">
            <button id="commentsMoreBtn" class="btn movie-btn-light small px-5">Afficher plus…</button>
        </div>
    </section>

    <!-- ===== FILMS SIMILAIRES ===== -->
    <section class="movie-section mt-5 mb-4">
        <h3 class="section-title mb-3">Films similaires</h3>

        <div class="d-flex align-items-center">
            <button class="carousel-arrow d-flex align-items-center justify-content-center">
                <i class="bi bi-chevron-left"></i>
            </button>

            <div class="row flex-grow-1 mx-3 g-3" id="similarMovies">
                <!-- JS insère 4 films -->
            </div>

            <button class="carousel-arrow d-flex align-items-center justify-content-center" type="button">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </section>

    <!-- ===== CTA SECTION ===== -->
    <section class="cta-section">
        <div class="cta-text">
            <p>
                Ne ratez plus jamais vos bandes originales préférées.<br>
                Rejoignez notre communauté et plongez dans<br>
                l'univers musical de tous vos films et séries favoris !
            </p>
            <?php if (!is_user_logged_in()) : ?>
                <a href="<?php echo esc_url(home_url('/inscription')); ?>" class="cta-btn">S'inscrire</a>
            <?php endif; ?>
        </div>
    </section>

</main>

<script>
    // Chemin des images pour JavaScript
    const themeImagePath = '<?php echo esc_js(get_template_directory_uri()); ?>/assets/image/Fiche films/';
    window.currentMovieSlug = '<?php echo esc_js($page_slug); ?>';
</script>

<?php
get_footer();
?>
