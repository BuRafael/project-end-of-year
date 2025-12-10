<?php
/**
 * Template Name: Register Step 2 (Avatar)
 */

// Page sans header/footer : structure minimale + wp_head/wp_footer pour charger les styles/scripts

$upload_feedback = '';

// Handle avatar upload for logged-in users.
if (isset($_POST['avatar_submit'])) {
    // Verify nonce
    if (!isset($_POST['avatar_nonce']) || !wp_verify_nonce($_POST['avatar_nonce'], 'upload_avatar')) {
        wp_die('Nonce verification failed');
    }
    
    // Si une image a été sélectionnée, la traiter
    if (!empty($_FILES['avatar_file']['name'])) {
        $file      = $_FILES['avatar_file'];
        $allowed   = array('image/jpeg', 'image/png', 'image/webp', 'image/gif');
        if (in_array($file['type'], $allowed, true)) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            $overrides = array('test_form' => false);
            $movefile  = wp_handle_upload($file, $overrides);
            if ($movefile && !isset($movefile['error'])) {
                // Save URL in user meta if user is logged in
                if (is_user_logged_in()) {
                    $avatar_url = $movefile['url'];
                    $current_user_id = get_current_user_id();
                    update_user_meta($current_user_id, 'avatar_url', esc_url_raw($avatar_url));
                    
                    // Créer un cookie temporaire pour confirmer la redirection
                    setcookie('cinemusic_just_registered', wp_hash($current_user_id), time() + 3600, '/', '', is_ssl(), true);
                }
                // Rediriger vers la page d'accueil
                wp_redirect(home_url('/'));
                exit;
            } else {
                $upload_feedback = '<div class="error-message">Erreur lors de l\'upload : ' . esc_html($movefile['error']) . '</div>';
            }
        } else {
            $upload_feedback = '<div class="error-message">Format non supporté. Utilise JPG, PNG, WEBP ou GIF.</div>';
        }
    } else {
        // Si pas d'image sélectionnée, rediriger quand même vers la page d'accueil
        if (is_user_logged_in()) {
            $current_user_id = get_current_user_id();
            setcookie('cinemusic_just_registered', wp_hash($current_user_id), time() + 3600, '/', '', is_ssl(), true);
        }
        wp_redirect(home_url('/'));
        exit;
    }
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/assets/css/base.css'); ?>">
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/assets/css/register-step.css'); ?>">
</head>
<body <?php body_class('page-register-avatar'); ?>>

<section class="register-hero register-hero--step2">
    <div class="register-hero__title">
        <p><?php esc_html_e('Bienvenue sur', 'project-end-of-year'); ?></p>
        <h1>
            <?php esc_html_e('CINEMUSIC!', 'project-end-of-year'); ?>
            <div class="register-hero__logo">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/image/Icones et Logo/Logo.svg'); ?>" alt="<?php bloginfo('name'); ?>" loading="lazy">
            </div>
        </h1>
    </div>

    <div class="register-card register-card--avatar">
        <h2><?php esc_html_e('Ajoute une photo de profil!', 'project-end-of-year'); ?></h2>

        <?php
        if (!empty($upload_feedback)) {
            echo $upload_feedback; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
        ?>

        <?php
        // Afficher le formulaire TOUJOURS (pas de vérification is_user_logged_in)
        // Les utilisateurs non connectés verront juste le formulaire
        $current_avatar = is_user_logged_in() ? get_user_meta(get_current_user_id(), 'avatar_url', true) : false;
        ?>
            <div class="avatar-preview">
                <div class="avatar-circle">
                    <?php if ($current_avatar) : ?>
                        <img src="<?php echo esc_url($current_avatar); ?>" alt="<?php esc_attr_e('Photo de profil', 'project-end-of-year'); ?>" id="avatarPreviewImg">
                    <?php else : ?>
                        <svg width="60" height="60" viewBox="0 0 65 72" xmlns="http://www.w3.org/2000/svg" style="color: #c7c8cc;">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M42.2502 28.718C42.2502 34.6656 37.8849 39.4872 32.5002 39.4872C27.1154 39.4872 22.7502 34.6656 22.7502 28.718C22.7502 22.7703 27.1154 17.9487 32.5002 17.9487C37.8849 17.9487 42.2502 22.7703 42.2502 28.718ZM39.0002 28.718C39.0002 32.6831 36.09 35.8974 32.5002 35.8974C28.9103 35.8974 26.0002 32.6831 26.0002 28.718C26.0002 24.7528 28.9103 21.5385 32.5002 21.5385C36.09 21.5385 39.0002 24.7528 39.0002 28.718Z" fill="currentColor"/>
                            <path d="M32.5002 44.8718C21.9793 44.8718 13.0152 51.7433 9.60059 61.3703C10.4324 62.2827 11.3087 63.1457 12.2255 63.955C14.7682 55.1164 22.7448 48.4616 32.5002 48.4616C42.2555 48.4616 50.2321 55.1164 52.7748 63.955C53.6916 63.1457 54.5679 62.2827 55.3997 61.3704C51.9851 51.7433 43.021 44.8718 32.5002 44.8718Z" fill="currentColor"/>
                        </svg>
                    <?php endif; ?>
                </div>
            </div>

            <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" class="register-form register-form--avatar" enctype="multipart/form-data">
                <?php wp_nonce_field('upload_avatar', 'avatar_nonce'); ?>
                <input type="file" name="avatar_file" id="avatar_file" accept="image/*" hidden>
                <button type="button" class="btn-upload" onclick="document.getElementById('avatar_file').click();">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/image/Icones et Logo/upload.svg'); ?>" alt="" class="upload-icon">
                    <?php esc_html_e('Importer une image', 'project-end-of-year'); ?>
                </button>

                <div class="avatar-actions">
                    <a class="btn-ghost" href="<?php echo esc_url(home_url()); ?>">
                        <?php esc_html_e('Passer', 'project-end-of-year'); ?>
                    </a>
                    <button type="submit" name="avatar_submit" class="btn-register-primary">
                        <?php esc_html_e('Terminer', 'project-end-of-year'); ?>
                    </button>
                </div>
            </form>
        <?php
        // Fin du formulaire - pas de else/endif
        ?>
    </div>
</section>

<script src="<?php echo esc_url(get_template_directory_uri() . '/assets/js/register-step2.js'); ?>"></script>
<?php wp_footer(); ?>
</body>
</html>

