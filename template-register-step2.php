<?php
/**
 * Template Name: Register Step 2 (Avatar)
 */

// Page sans header/footer : structure minimale + wp_head/wp_footer pour charger les styles/scripts

$upload_feedback = '';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/assets/css/register-step.css'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class('page-register-avatar'); ?>>

<section class="register-hero register-hero--step2">
<?php wp_footer(); ?>
</body>
</html>

<?php
/**
 * Template Name: Register Step 2 (Avatar)
 */

// Page sans header/footer

$upload_feedback = '';

// Handle avatar upload for logged-in users.
if (is_user_logged_in() && isset($_POST['avatar_submit']) && isset($_POST['avatar_nonce']) && wp_verify_nonce($_POST['avatar_nonce'], 'upload_avatar')) {
    if (!empty($_FILES['avatar_file']['name'])) {
        $file      = $_FILES['avatar_file'];
        $allowed   = array('image/jpeg', 'image/png', 'image/webp', 'image/gif');
        if (in_array($file['type'], $allowed, true)) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            $overrides = array('test_form' => false);
            $movefile  = wp_handle_upload($file, $overrides);
            if ($movefile && !isset($movefile['error'])) {
                // Save URL in user meta.
                update_user_meta(get_current_user_id(), 'avatar_url', esc_url_raw($movefile['url']));
                $upload_feedback = '<div class="success-message">Photo enregistrée !</div>';
            } else {
                $upload_feedback = '<div class="error-message">Erreur lors de l\'upload : ' . esc_html($movefile['error']) . '</div>';
            }
        } else {
            $upload_feedback = '<div class="error-message">Format non supporté. Utilise JPG, PNG, WEBP ou GIF.</div>';
        }
    } else {
        $upload_feedback = '<div class="error-message">Choisis une image avant de terminer.</div>';
    }
}
?>

<section class="register-hero register-hero--step2">
    <div class="register-hero__logo">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/image/Icones et Logo/Logo.svg'); ?>" alt="<?php bloginfo('name'); ?>" loading="lazy">
    </div>

    <div class="register-hero__title">
        <p><?php esc_html_e('Bienvenue sur', 'project-end-of-year'); ?></p>
        <h1><?php esc_html_e('CINEMUSIC!', 'project-end-of-year'); ?></h1>
    </div>

    <div class="register-card register-card--avatar">
        <h2><?php esc_html_e('Ajoute une photo de profil!', 'project-end-of-year'); ?></h2>

        <?php
        if (!empty($upload_feedback)) {
            echo $upload_feedback; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
        ?>

        <?php if (is_user_logged_in()) : ?>
            <?php
            $current_avatar = get_user_meta(get_current_user_id(), 'avatar_url', true);
            ?>
            <div class="avatar-preview">
                <div class="avatar-circle">
                    <?php if ($current_avatar) : ?>
                        <img src="<?php echo esc_url($current_avatar); ?>" alt="<?php esc_attr_e('Photo de profil', 'project-end-of-year'); ?>" id="avatarPreviewImg">
                    <?php else : ?>
                        <div class="avatar-placeholder" id="avatarPlaceholder">
                            <span class="avatar-x">✕</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" class="register-form register-form--avatar" enctype="multipart/form-data">
                <?php wp_nonce_field('upload_avatar', 'avatar_nonce'); ?>
                <label class="btn-upload">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/image/Icones et Logo/upload.svg'); ?>" alt="" class="upload-icon">
                    <?php esc_html_e('Importer une image', 'project-end-of-year'); ?>
                    <input type="file" name="avatar_file" id="avatar_file" accept="image/*" hidden>
                </label>

                <div class="avatar-actions">
                    <a class="btn-ghost" href="<?php echo esc_url(home_url()); ?>">
                        <?php esc_html_e('Passer', 'project-end-of-year'); ?>
                    </a>
                    <button type="submit" name="avatar_submit" class="btn-register-primary">
                        <?php esc_html_e('Terminer', 'project-end-of-year'); ?>
                    </button>
                </div>
            </form>
        <?php else : ?>
            <div class="error-message">
                <?php esc_html_e('Connecte-toi pour ajouter ta photo de profil.', 'project-end-of-year'); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php

