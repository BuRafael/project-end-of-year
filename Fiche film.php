<?php
/**
 * Template Name: Fiche Film
 * Description: Template pour afficher la fiche détaillée d'un film
 */

get_header();

// Passer le chemin des images au JavaScript
$template_uri = get_template_directory_uri();
?>

<script>
    // Chemin des images pour JavaScript
    const themeImagePath = '<?php echo esc_js($template_uri); ?>/assets/image/Fiche films/';
</script>

<!-- ===== CONTENU FICHE FILM ===== -->
<main class="movie-page container py-5">

    <!-- TITRE + INFOS GENERALES -->
    <section class="movie-header mb-5">
        <h1 class="fw-bold mb-1">Inception</h1>
        <p class="movie-sub small text-secondary mb-4">2010 – 12 pistes</p>

        <div class="row g-4">
            <!-- POSTER -->
            <div class="col-md-4 col-lg-3">
                <div class="movie-poster-wrapper text-center text-md-start">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Fiche films/inception affiche film.jpg' ); ?>" alt="Affiche Inception"
                         class="movie-poster img-fluid shadow">
                    <button id="movieLikeBtn" class="btn btn-link fs-4 p-0 movie-like-btn" aria-pressed="false" type="button">
                        <i class="bi bi-heart" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <!-- SYNOPSIS + META -->
            <div class="col-md-8 col-lg-9">
                <h5 class="mb-2" style="color: rgba(112, 1, 24, 1);">Synopsis</h5>
                <p class="movie-synopsis small text-light mb-4">
                    Dom Cobb est un voleur expérimenté dans l'art périlleux de l'extraction : sa spécialité
                    consiste à s'approprier les secrets les plus précieux d'un individu, enfouis au plus
                    profond de son subconscient, pendant qu'il rêve et que son esprit est particulièrement
                    vulnérable. Très recherché pour ses talents dans l'univers trouble de l'espionnage
                    industriel, Cobb est aussi devenu un fugitif traqué dans le monde entier. Cependant,
                    une ultime mission pourrait lui permettre de retrouver sa vie d'avant.
                </p>

                <div class="row movie-meta small">
                    <div class="col-6 col-sm-3 mb-3">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Durée</div>
                        <div class="movie-meta-value">2h28</div>
                    </div>
                    <div class="col-6 col-sm-3 mb-3">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Note</div>
                        <div class="movie-meta-value">8,8/10</div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Réalisateur</div>
                        <div class="movie-meta-value text-white">Christopher Nolan</div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Acteurs</div>
                        <div class="movie-meta-value text-white">
                            Leonardo DiCaprio, Joseph Gordon-Levitt, Elliot Page, Tom Hardy,
                            Dileep Rao, Ken Watanabe
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Genre</div>
                        <div class="movie-meta-value text-white">
                            Science-fiction, Thriller.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PISTES ===== -->
    <section class="movie-section mt-4">
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

        <div class="comment-input-row d-flex align-items-center gap-3 pb-3 mb-4">
            <div class="comment-avatar rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-person"></i>
            </div>
            <div class="flex-grow-1">
                <input type="text"
                       class="form-control comment-input"
                       placeholder="Écrire un commentaire">
            </div>
        </div>

        <div class="row g-3" id="commentsZone">
            <!-- JS charge les commentaires -->
        </div>

        <div class="text-center mt-4">
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

</main>

<?php
get_footer();
?>
