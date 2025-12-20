<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Démarrer la session uniquement si besoin, après l'ouverture PHP
}
// Rediriger si non connecté
if (!is_user_logged_in()) {
    wp_redirect(home_url('/inscription'));
    exit;
}

// Gestion avatar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profil_nonce']) && wp_verify_nonce($_POST['profil_nonce'], 'update_profil')) {
    $user_id = get_current_user_id();
    if (!empty($_FILES['avatar_file']) && $_FILES['avatar_file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['avatar_file'];
        $allowed_types = array('image/jpeg', 'image/png', 'image/gif', 'image/webp');
        if (in_array($file['type'], $allowed_types)) {
            $upload = wp_upload_bits($file['name'], null, file_get_contents($file['tmp_name']));
            if (!$upload['error']) {
                update_user_meta($user_id, 'avatar_url', $upload['url']);
            }
        }
    }
    $_SESSION['profil_updated'] = true;
    wp_redirect(home_url('/profil'));
    exit;
}

// Modification pseudo
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['action'])
    && $_POST['action'] === 'update_pseudo'
    && isset($_POST['pseudo_nonce'])
    && wp_verify_nonce($_POST['pseudo_nonce'], 'update_pseudo')
) {
    $user_id = get_current_user_id();
    $new_pseudo = sanitize_user($_POST['new_pseudo']);
    if ($new_pseudo && $new_pseudo !== '') {
        if (mb_strlen($new_pseudo) > 20) {
            echo '<div class="profil-error-message">Le pseudo ne doit pas dépasser 20 caractères.</div>';
        } else {
            // Vérifier si le pseudo existe déjà pour un autre utilisateur
            $existing = get_user_by('slug', $new_pseudo);
            if ($existing && $existing->ID != $user_id) {
                echo '<div class="profil-error-message">Ce pseudo est déjà utilisé par un autre utilisateur.</div>';
            } else {
                wp_update_user([
                    'ID' => $user_id,
                    'display_name' => $new_pseudo,
                    'user_nicename' => $new_pseudo,
                ]);
                // Redirection pour PRG
                $_SESSION['profil_updated'] = true;
                wp_redirect(home_url('/profil'));
                exit;
            }
        }
    }
}


// Modification mot de passe

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['action']) &&
    $_POST['action'] === 'update_password' &&
    isset($_POST['password_nonce']) &&
    wp_verify_nonce($_POST['password_nonce'], 'update_password')
) {
    $user_id = get_current_user_id();
    $user = get_user_by('ID', $user_id);
    $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    if (empty($current_password) || empty($new_password)) {
        $_SESSION['profil_error'] = 'Veuillez remplir tous les champs.';
    } elseif (!wp_check_password($current_password, $user->user_pass, $user_id)) {
        $_SESSION['profil_error'] = "L'ancien mot de passe est incorrect.";
    } elseif (strlen($new_password) < 6) {
        $_SESSION['profil_error'] = 'Le nouveau mot de passe doit contenir au moins 6 caractères.';
    } else {
        wp_set_password($new_password, $user_id);
        $_SESSION['profil_updated'] = true;
    }
    wp_redirect(home_url('/profil'));
    exit;
}

get_header();

$user_id = get_current_user_id();
$user = get_user_by('ID', $user_id);
$avatar_url = get_user_meta($user_id, 'avatar_url', true);
// Gestion des messages de succès et d'erreur (PRG)
$updated = false;
if (!empty($_SESSION['profil_updated'])) {
    $updated = true;
    unset($_SESSION['profil_updated']);
}
$profil_error = '';
if (!empty($_SESSION['profil_error'])) {
    $profil_error = $_SESSION['profil_error'];
    unset($_SESSION['profil_error']);
}
// Compter les commentaires approuvés par email (plus fiable)
$comment_count = get_comments([
    'author_email' => $user->user_email,
    'status' => 'approve',
    'count' => true,
]);

// Affichage des messages d'erreur et de succès
if (!empty($profil_error)) {
    echo '<div class="profil-error-message">' . esc_html($profil_error) . '</div>';
}
?>
<main class="profil-container profil-simple">
    <section class="profil-hero">
        <h1 class="profil-title">Mon profil</h1>
        <?php if ($updated) : ?>
            <div class="profil-success-message">Modifications enregistrées !</div>
        <?php endif; ?>
        <div class="profil-vertical">
            <div class="profil-avatar-block">
                <div class="profil-avatar-img-block">
                    <img src="<?php echo esc_url($avatar_url ?: get_avatar_url($user_id)); ?>" alt="Photo de profil" class="profil-avatar-img" id="avatarPreview">
                    <button type="button" class="profil-avatar-edit-btn-simple" onclick="document.getElementById('avatarInput').click();" title="Modifier la photo de profil"></button>
                </div>
                <form method="POST" enctype="multipart/form-data" class="profil-avatar-form">
                    <?php wp_nonce_field('update_profil', 'profil_nonce'); ?>
                    <input type="file" id="avatarInput" name="avatar_file" accept="image/*" style="display: none;">
                    <button type="submit" id="avatarSubmit" style="display:none;"></button>
                </form>
                <button type="button" class="btn-profil-simple" onclick="document.getElementById('avatarInput').click();">Changer la photo</button>
            </div>
            <div class="profil-infos-block">
                <form method="POST" class="profil-form-simple">
                    <?php wp_nonce_field('update_pseudo', 'pseudo_nonce'); ?>
                    <input type="hidden" name="action" value="update_pseudo">
                    <label for="new_pseudo">Pseudo</label>
                    <input type="text" id="new_pseudo" name="new_pseudo" value="<?php echo esc_attr($user->display_name); ?>" maxlength="20" class="form-control-simple">
                    <button type="submit" class="btn-profil-simple">Modifier le pseudo</button>
                </form>
                <form method="POST" class="profil-form-simple">
                    <?php wp_nonce_field('update_password', 'password_nonce'); ?>
                    <input type="hidden" name="action" value="update_password">
                    <label for="current_password">Ancien mot de passe</label>
                    <input type="password" id="current_password" name="current_password" class="form-control-simple" placeholder="Ancien mot de passe" required>
                    <label for="new_password">Nouveau mot de passe</label>
                    <input type="password" id="new_password" name="new_password" minlength="6" class="form-control-simple" placeholder="Nouveau mot de passe" required>
                    <button type="submit" class="btn-profil-simple">Changer le mot de passe</button>
                </form>
                <div class="profil-infos-list">
                    <div><span>Email :</span> <?php echo esc_html($user->user_email); ?></div>
                    <div><span>Membre depuis :</span> <?php echo date_i18n('d/m/Y', strtotime($user->user_registered)); ?></div>
                    <div><span>Commentaires :</span> <?php echo $comment_count; ?></div>
                </div>
                <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="btn-profil-simple btn-logout-simple">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:8px;"><path fill="currentColor" d="M16.5 12a1 1 0 0 1 1-1H20a1 1 0 1 1 0 2h-2.5a1 1 0 0 1-1-1Zm-2.21-4.79a1 1 0 0 1 1.42 1.42L13.41 11H20a1 1 0 1 1 0 2h-6.59l2.3 2.29a1 1 0 1 1-1.42 1.42l-4-4a1 1 0 0 1 0-1.42l4-4Z"/></svg>
                    Déconnexion
                </a>
            </div>
        </div>
    </section>
</main>
<script>
// Soumission auto du formulaire d'avatar
document.getElementById('avatarInput')?.addEventListener('change', function() {
    document.getElementById('avatarSubmit').click();
});

</script>

<?php get_footer(); ?>



