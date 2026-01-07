<?php
/**
 * Template Name: Fiche Compositeur
 * Template Post Type: page
 * Description: Template pour afficher la fiche détaillée d'un compositeur
 */

get_header();
?>

<!-- ===== CONTENU FICHE COMPOSITEUR ===== -->
<main class="composer-page container py-5">

    <!-- TITRE + INFOS GENERALES -->
    <section class="composer-header mb-5">
        <h1 class="mb-1">Hans Zimmer</h1>

        <div class="row g-4">
            <!-- PHOTO -->
            <div class="col-md-4 col-lg-3">
                <div class="composer-poster-wrapper text-center text-md-start">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Fiche Compositeur/Hans Zimmer.jpg' ); ?>" alt="Photo Hans Zimmer"
                        class="composer-poster img-fluid shadow">
                </div>
            </div>

            <!-- BIOGRAPHIE + META -->
            <div class="col-md-8 col-lg-9">
                <h5 class="mb-2" style="color: rgba(112, 1, 24, 1);">Biographie</h5>
                <p class="composer-bio small text-light mb-4">
                    Hans Florian Zimmer est un compositeur de musiques de films allemand naturalisé américain. 
                    Il est l'un des compositeurs les plus prolifiques et influents de l'industrie cinématographique. 
                    Son style unique mêle musique électronique et orchestrations épiques, créant des bandes originales 
                    inoubliables. Avec plus de 150 films à son actif, il a collaboré avec les plus grands réalisateurs 
                    comme Christopher Nolan, Ridley Scott, Ron Howard et Denis Villeneuve. Il a remporté deux Oscars, 
                    quatre Grammy Awards et deux Golden Globes, confirmant son statut de légende vivante de la musique 
                    de film.
                </p>

                <div class="row composer-meta small">
                    <div class="col-auto mb-3">
                        <div class="composer-meta-label" style="color: rgba(112, 1, 24, 1);">Naissance</div>
                        <div class="composer-meta-value">12 septembre 1957</div>
                    </div>
                    <div class="col-auto mb-3">
                        <div class="composer-meta-label" style="color: rgba(112, 1, 24, 1);">Nationalité</div>
                        <div class="composer-meta-value">Allemand, Américain</div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="composer-meta-label" style="color: rgba(112, 1, 24, 1);">Films composés</div>
                        <div class="composer-meta-value text-white">150+</div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="composer-meta-label" style="color: rgba(112, 1, 24, 1);">Récompenses</div>
                        <div class="composer-meta-value text-white">
                            2 Oscars, 4 Grammy Awards, 2 Golden Globes, 3 Classical BRIT Awards
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PISTES CELEBRES ===== -->
    <section class="composer-section mt-5">
        <div class="table-responsive">
            <table class="table composer-tracks-table align-middle mb-3">
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
    <section class="composer-section mt-5">
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

    <!-- ===== COMPOSITEURS SIMILAIRES ===== -->
    <section class="composer-section mt-5 mb-4">
        <h3 class="section-title mb-3">Compositeurs similaires</h3>
        <div class="d-flex align-items-center movies-carousel composer-carousel">
            <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>
            <div class="row flex-grow-1 mx-3 g-3" id="similarComposers">

            </div>
            <button class="carousel-arrow right d-flex align-items-center justify-content-center" type="button">❯</button>
        </div>
    </section>

    <!-- ===== CTA SECTION ===== -->


</main>

<script>
    // Chemin des images pour JavaScript
    const composerImagePath = '<?php echo esc_js(get_template_directory_uri()); ?>/assets/image/Fiche Compositeur/';
    
    // Variables pour les commentaires
    const composerComments = {
        ajax_url: '<?php echo esc_js(admin_url('admin-ajax.php')); ?>',
        nonce: '<?php echo wp_create_nonce('composer_comments_nonce'); ?>',
        composer_id: 'hans-zimmer'
    };
</script>

<?php get_footer(); ?>
