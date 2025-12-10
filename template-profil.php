<?php
/**
 * Template Name: Profil Utilisateur
 */

// Rediriger vers la page d'inscription si pas connecté
if (!is_user_logged_in()) {
    wp_redirect(home_url('/inscription'));
    exit;
}

get_header();
?>

<main class="profil-container">
        <section class="profil-hero">
            <div class="profil-header">
                <h1><?php esc_html_e('Mon Profil', 'project-end-of-year'); ?></h1>
            </div>

            <div class="profil-content">
                <!-- Profil Card -->
                <div class="profil-card">
                    <div class="profil-avatar-section">
                        <div class="profil-avatar-wrapper">
                            <?php
                            $user_id = get_current_user_id();
                            $user = get_user_by('ID', $user_id);
                            $avatar_url = get_user_meta($user_id, 'avatar_url', true);
                            
                            if (!empty($avatar_url)) {
                                echo '<img src="' . esc_url($avatar_url) . '" alt="" class="profil-avatar-img">';
                            } else {
                                ?>
                                <svg class="profil-avatar-default" width="120" height="120" viewBox="0 0 65 72" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M42.2502 28.718C42.2502 34.6656 37.8849 39.4872 32.5002 39.4872C27.1154 39.4872 22.7502 34.6656 22.7502 28.718C22.7502 22.7703 27.1154 17.9487 32.5002 17.9487C37.8849 17.9487 42.2502 22.7703 42.2502 28.718ZM39.0002 28.718C39.0002 32.6831 36.09 35.8974 32.5002 35.8974C28.9103 35.8974 26.0002 32.6831 26.0002 28.718C26.0002 24.7528 28.9103 21.5385 32.5002 21.5385C36.09 21.5385 39.0002 24.7528 39.0002 28.718Z" fill="currentColor"/>
                                    <path d="M32.5002 44.8718C21.9793 44.8718 13.0152 51.7433 9.60059 61.3703C10.4324 62.2827 11.3087 63.1457 12.2255 63.955C14.7682 55.1164 22.7448 48.4616 32.5002 48.4616C42.2555 48.4616 50.2321 55.1164 52.7748 63.955C53.6916 63.1457 54.5679 62.2827 55.3997 61.3704C51.9851 51.7433 43.021 44.8718 32.5002 44.8718Z" fill="currentColor"/>
                                </svg>
                                <?php
                            }
                            ?>
                        </div>
                        <a href="<?php echo esc_url(home_url('/signup-step2')); ?>" class="btn-change-avatar">
                            <?php esc_html_e('Changer la photo', 'project-end-of-year'); ?>
                        </a>
                    </div>

                    <!-- Infos utilisateur -->
                    <div class="profil-info">
                        <div class="info-group">
                            <label><?php esc_html_e('Pseudo', 'project-end-of-year'); ?></label>
                            <p class="info-value"><?php echo esc_html($user->user_login); ?></p>
                        </div>

                        <div class="info-group">
                            <label><?php esc_html_e('Email', 'project-end-of-year'); ?></label>
                            <p class="info-value"><?php echo esc_html($user->user_email); ?></p>
                        </div>

                        <div class="info-group">
                            <label><?php esc_html_e('Nom', 'project-end-of-year'); ?></label>
                            <p class="info-value"><?php echo esc_html($user->first_name ?: '-'); ?></p>
                        </div>

                        <div class="info-group">
                            <label><?php esc_html_e('Prénom', 'project-end-of-year'); ?></label>
                            <p class="info-value"><?php echo esc_html($user->last_name ?: '-'); ?></p>
                        </div>

                        <div class="info-group">
                            <label><?php esc_html_e('Membre depuis', 'project-end-of-year'); ?></label>
                            <p class="info-value"><?php echo esc_html(date_i18n('d F Y', strtotime($user->user_registered))); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="profil-actions">
                    <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="btn-logout">
                        <?php esc_html_e('Déconnexion', 'project-end-of-year'); ?>
                    </a>
                </div>
            </div>
        </section>
    </main>

<?php get_footer(); ?>
