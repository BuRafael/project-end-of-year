if (!function_exists('wp_upload_bits')) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
}
<?php
/**
 * Template Name: Profil Utilisateur
 */

// Rediriger vers la page d'inscription si pas connecté
if (!is_user_logged_in()) {
    wp_redirect(home_url('/inscription'));
    exit;
}

// Traiter la mise à jour du profil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profil_nonce']) && wp_verify_nonce($_POST['profil_nonce'], 'update_profil')) {
    $user_id = get_current_user_id();
    
    // Traiter l'upload de l'avatar si un fichier est présent
    if (!empty($_FILES['avatar_file']) && $_FILES['avatar_file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['avatar_file'];
        
        // Vérifier le type de fichier
        $allowed_types = array('image/jpeg', 'image/png', 'image/gif', 'image/webp');
        if (in_array($file['type'], $allowed_types)) {
            // Upload le fichier dans WordPress
            $upload = wp_upload_bits($file['name'], null, file_get_contents($file['tmp_name']));
            
            if (!$upload['error']) {
                // Enregistrer l'URL dans user meta
                update_user_meta($user_id, 'avatar_url', $upload['url']);
            }
        }
    }
    $user_id = get_current_user_id();
    
    // Mettre à jour le pseudo
    if (!empty($_POST['user_login'])) {
        $new_login = sanitize_user($_POST['user_login']);
        // Vérifier que le pseudo est unique (sauf si c'est le même)
        if ($new_login !== get_userdata($user_id)->user_login && username_exists($new_login)) {
            wp_die('Ce pseudo est déjà utilisé.');
        }
        wp_update_user([
            'ID' => $user_id,
            'user_login' => $new_login,
            'user_nicename' => $new_login,
        ]);
    }
    
    // Mettre à jour le nom
    if (isset($_POST['first_name'])) {
        update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
    }
    
    // Mettre à jour le prénom
    if (isset($_POST['last_name'])) {
        update_user_meta($user_id, 'last_name', sanitize_text_field($_POST['last_name']));
    }
    
    wp_redirect(home_url('/profil?updated=1'));
    exit;
}

get_header();

$user_id = get_current_user_id();
$user = get_user_by('ID', $user_id);
$avatar_url = get_user_meta($user_id, 'avatar_url', true);
$updated = isset($_GET['updated']) && $_GET['updated'] === '1';
?>

<main class="profil-container">
    <section class="profil-hero">
        <div class="profil-header">
            <h1><?php esc_html_e('Information du profil', 'project-end-of-year'); ?></h1>
            <?php if ($updated) : ?>
                <div class="profil-success-message">
                    <?php esc_html_e('Vos modifications ont été enregistrées avec succès !', 'project-end-of-year'); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="profil-content">
            <!-- Avatar Section -->
            <div class="profil-avatar-section">
                <div class="profil-avatar-wrapper">
                    <?php
                    if (!empty($avatar_url)) {
                        echo '<img src="' . esc_url($avatar_url) . '" alt="" class="profil-avatar-img" id="avatarPreview">';
                    } else {
                        ?>
                        <svg class="profil-avatar-default" id="avatarDefault" width="120" height="120" viewBox="0 0 65 72" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M42.2502 28.718C42.2502 34.6656 37.8849 39.4872 32.5002 39.4872C27.1154 39.4872 22.7502 34.6656 22.7502 28.718C22.7502 22.7703 27.1154 17.9487 32.5002 17.9487C37.8849 17.9487 42.2502 22.7703 42.2502 28.718ZM39.0002 28.718C39.0002 32.6831 36.09 35.8974 32.5002 35.8974C28.9103 35.8974 26.0002 32.6831 26.0002 28.718C26.0002 24.7528 28.9103 21.5385 32.5002 21.5385C36.09 21.5385 39.0002 24.7528 39.0002 28.718Z" fill="currentColor"/>
                            <path d="M32.5002 44.8718C21.9793 44.8718 13.0152 51.7433 9.60059 61.3703C10.4324 62.2827 11.3087 63.1457 12.2255 63.955C14.7682 55.1164 22.7448 48.4616 32.5002 48.4616C42.2555 48.4616 50.2321 55.1164 52.7748 63.955C53.6916 63.1457 54.5679 62.2827 55.3997 61.3704C51.9851 51.7433 43.021 44.8718 32.5002 44.8718Z" fill="currentColor"/>
                        </svg>
                        <img src="" alt="" class="profil-avatar-img" id="avatarPreview" style="display: none;">
                        <?php
                    }
                    ?>
                </div>
                
                <button type="button" class="btn-change-avatar" id="changeAvatarBtn">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <?php esc_html_e('Changer la photo', 'project-end-of-year'); ?>
                </button>
            </div>

            <!-- Formulaire d'édition -->
            <form method="POST" class="profil-form" enctype="multipart/form-data">
                    <?php wp_nonce_field('update_profil', 'profil_nonce'); ?>
                    
                    <!-- Input file caché pour l'avatar -->
                    <input type="file" id="avatarInput" name="avatar_file" accept="image/*" style="display: none;">

                    <!-- Pseudo -->
                    <div class="form-group">
                        <label for="user_login"><?php esc_html_e('Pseudo', 'project-end-of-year'); ?></label>
                        <input 
                            type="text" 
                            id="user_login" 
                            name="user_login" 
                            value="<?php echo esc_attr($user->user_login); ?>"
                            class="form-control"
                            required
                        >
                        <small class="form-text"><?php esc_html_e("C'est ainsi que vous apparaîtrez aux autres utilisateurs. Maximum 8 caractères.", 'project-end-of-year'); ?></small>
                    </div>

                    <!-- Email (non modifiable) -->
                    <div class="form-group">
                        <label for="user_email"><?php esc_html_e('Email', 'project-end-of-year'); ?></label>
                        <input 
                            type="email" 
                            id="user_email" 
                            value="<?php echo esc_attr($user->user_email); ?>"
                            class="form-control"
                            disabled
                        >
                        <small class="form-text"><?php esc_html_e('E-mail ne peut pas être changé', 'project-end-of-year'); ?></small>
                    </div>

                    <!-- Membre depuis -->
                    <div class="form-group">
                        <label><?php esc_html_e('Membre depuis', 'project-end-of-year'); ?></label>
                        <p class="form-control-static"><?php echo esc_html(date_i18n('d F Y', strtotime($user->user_registered))); ?></p>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="profil-actions">
                        <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="btn-logout">
                            <?php esc_html_e('Se déconnecter', 'project-end-of-year'); ?>
                        </a>
                        <button type="submit" class="btn-save">
                            <?php esc_html_e('Enregistrer les modifications', 'project-end-of-year'); ?>
                        </button>
                    </div>
                </form>
        </div>
    </section>
</main>

<?php get_footer(); ?>

