<?php
/**
 * Template Name: Fiche Série
 * Template Post Type: page
 * Description: Template pour afficher la fiche détaillée d'une série
 */

get_header();
?>

<!-- ===== CONTENU FICHE SERIE ===== -->
<main class="movie-page container py-5">

    <!-- TITRE + INFOS GENERALES -->
    <section class="movie-header mb-5">
        <h1 class="fw-bold mb-1">Stranger Things</h1>
        <p class="movie-sub small text-secondary mb-4">2016 - À nos jours – 42 épisodes</p>

        <div class="row g-4">
            <!-- POSTER -->
            <div class="col-md-4 col-lg-3">
                <div class="movie-poster-wrapper text-center text-md-start">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Stranger Things2.jpg' ); ?>" alt="Affiche Stranger Things"
                         class="movie-poster img-fluid shadow">
                    <button id="movieLikeBtn" class="movie-like-btn p-0" aria-pressed="false" type="button">
                        <i class="bi bi-heart" aria-hidden="true"></i>
                    </button>
                </div>

                <!-- SELECTS SAISON / EPISODE -->
                <div class="series-selects mt-5">
                    <select id="seasonSelect" class="form-select form-select-sm" aria-label="Choisir une saison">
                        <option value="1">Saison 1</option>
                        <option value="2">Saison 2</option>
                        <option value="3">Saison 3</option>
                        <option value="4">Saison 4</option>
                    </select>
                    <select id="episodeSelect" class="form-select form-select-sm" aria-label="Choisir un épisode">
                        <option value="1">Épisode 1</option>
                        <option value="2">Épisode 2</option>
                        <option value="3">Épisode 3</option>
                        <option value="4">Épisode 4</option>
                        <option value="5">Épisode 5</option>
                        <option value="6">Épisode 6</option>
                        <option value="7">Épisode 7</option>
                        <option value="8">Épisode 8</option>
                        <option value="9">Épisode 9</option>
                    </select>
                </div>
            </div>

            <!-- SYNOPSIS + META -->
            <div class="col-md-8 col-lg-9">
                <h5 class="mb-2" style="color: rgba(112, 1, 24, 1);">Synopsis</h5>
                <p class="movie-synopsis small text-light mb-4">
                    Quand un enfant disparaît mystérieusement en 1983, ses amis, sa famille et la police locale 
                    doivent affronter des forces et des mystères bien plus grands que la réalité. Stranger Things 
                    mélange l'angoisse, la nostalgie et la science-fiction pour raconter une histoire captivante 
                    où rien n'est ce qu'il semble être. Une série qui a captivé des millions de fans à travers le monde.
                </p>

                <div class="row movie-meta small">
                    <div class="col-6 col-sm-3 mb-3">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Saisons</div>
                        <div class="movie-meta-value">4</div>
                    </div>
                    <div class="col-6 col-sm-3 mb-3">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Note</div>
                        <div class="movie-meta-value">8,7/10</div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Réalisateur</div>
                        <div class="movie-meta-value text-white">The Duffer Brothers</div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Acteurs</div>
                        <div class="movie-meta-value text-white">
                            Winona Ryder, David Harbour, Finn Wolfhard, Millie Bobby Brown,
                            Gaten Matarazzo, Caleb McLaughlin, Noah Schnapp, Sadie Sink
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Genre</div>
                        <div class="movie-meta-value text-white">
                            Science-fiction, Drame, Mystère
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

    <!-- ===== SERIES SIMILAIRES ===== -->
    <section class="movie-section mt-5 mb-4">
        <h3 class="section-title mb-3">Séries similaires</h3>

        <div class="d-flex align-items-center">
            <button class="carousel-arrow d-flex align-items-center justify-content-center">
                <i class="bi bi-chevron-left"></i>
            </button>

            <div class="row flex-grow-1 mx-3 g-3" id="similarMovies">
                <!-- JS insère 4 séries -->
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
</script>

<?php
get_footer();
?>
