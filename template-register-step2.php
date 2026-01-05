<?php
if (!function_exists('wp_handle_upload')) {
    require_once ABSPATH . 'wp-admin/includes/file.php';
}

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
            <span style="display:block;">CINEMUSIC</span>
        </h1>
        <div class="register-hero__logo">
            <?php
            $svg_path = get_template_directory() . '/assets/image/Icones et Logo/Logo_cinemusic_modif.svg';
            if (file_exists($svg_path)) {
                $svg = file_get_contents($svg_path);
                // Réduit la taille du SVG
                $svg = preg_replace('/<svg ([^>]*)width="[0-9]+" height="[0-9]+"/', '<svg $1width="38" height="48"', $svg, 1);
                // Met tout en blanc du site
                $svg = preg_replace('/fill="#([0-9A-Fa-f]{6})"/', 'fill="#F4EFEC"', $svg);
                // Mets les 3 petits ronds (paths avec fill="#1A1A1A") en noir du site
                // On cible les 3 paths qui sont à la position 2, 3 et 4 dans le SVG
                $svg = preg_replace_callback('/(<path[^>]+fill=")#F4EFEC("[^>]*>)/', function($m) {
                    static $i = 0; $i++;
                    if ($i >= 2 && $i <= 4) return $m[1] . '#1A1A1A' . $m[2];
                    return $m[1] . '#F4EFEC' . $m[2];
                }, $svg);
                echo $svg;
            }
            ?>
        </div>
    </div>

    <div class="register-card register-card--avatar">
        <h2 style="margin-bottom: 18px;"><?php esc_html_e('Ajoute une photo de profil!', 'project-end-of-year'); ?></h2>
        <?php
        if (!empty($upload_feedback)) {
            echo $upload_feedback; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
        ?>
        <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" class="register-form register-form--avatar" enctype="multipart/form-data" style="margin-top: 0;">
            <div class="avatar-preview" style="margin-bottom: 18px;">
                <div class="avatar-circle">
                    <?php if (!empty($current_avatar)) : ?>
                        <img src="<?php echo esc_url($current_avatar); ?>" alt="<?php esc_attr_e('Photo de profil', 'project-end-of-year'); ?>" id="avatarPreviewImg">
                                        <?php else : ?>
                                            <svg class="profil-svg" width="65" height="65" viewBox="0 0 65 72" xmlns="http://www.w3.org/2000/svg" style="opacity:0.7;">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M42.2502 28.718C42.2502 34.6656 37.8849 39.4872 32.5002 39.4872C27.1154 39.4872 22.7502 34.6656 22.7502 28.718C22.7502 22.7703 27.1154 17.9487 32.5002 17.9487C37.8849 17.9487 42.2502 22.7703 42.2502 28.718ZM39.0002 28.718C39.0002 32.6831 36.09 35.8974 32.5002 35.8974C28.9103 35.8974 26.0002 32.6831 26.0002 28.718C26.0002 24.7528 28.9103 21.5385 32.5002 21.5385C36.09 21.5385 39.0002 24.7528 39.0002 28.718Z" fill="#c7c8cc"/>
                                                <path d="M32.5002 44.8718C21.9793 44.8718 13.0152 51.7433 9.60059 61.3703C10.4324 62.2827 11.3087 63.1457 12.2255 63.955C14.7682 55.1164 22.7448 48.4616 32.5002 48.4616C42.2555 48.4616 50.2321 55.1164 52.7748 63.955C53.6916 63.1457 54.5679 62.2827 55.3997 61.3704C51.9851 51.7433 43.021 44.8718 32.5002 44.8718Z" fill="#c7c8cc"/>
                                            </svg>
                                        <?php endif; ?>
                </div>
            </div>
            <?php wp_nonce_field('upload_avatar', 'avatar_nonce'); ?>
            <input type="file" name="avatar_file" id="avatar_file" accept="image/*" hidden>
            <button type="button" class="btn-upload" onclick="document.getElementById('avatar_file').click();">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/image/Icones et Logo/upload.svg'); ?>" alt="" class="upload-icon">
                <?php esc_html_e('Importer une image', 'project-end-of-year'); ?>
            </button>
            <div class="avatar-actions">
                <a class="btn-skip" href="<?php echo esc_url(home_url()); ?>" style="border: 1.5px solid #F4EFEC !important; border-radius: 24px !important; background: var(--reg-panel) !important; color: #F4EFEC !important; width: 140px !important; height: 40px !important; padding: 0 18px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; text-align: center !important; font-family: 'Futura Demi', 'Futura PT Demi', 'Futura Std Demi', 'Futura', Arial, sans-serif !important; font-weight: 600 !important; font-size: 14px !important; letter-spacing: 0.4px !important; box-sizing: border-box !important;">
                    <?php esc_html_e('Passer', 'project-end-of-year'); ?>
                </a>
                <button type="submit" name="avatar_submit" class="btn-register-primary">
                    <span style="font-family: 'Futura Demi', 'Futura PT Demi', 'Futura Std Demi', 'Futura', Arial, sans-serif; font-weight: 600; font-size: 14px;">
                        <?php esc_html_e('Terminer', 'project-end-of-year'); ?>
                    </span>
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

