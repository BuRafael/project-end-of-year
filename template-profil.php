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



<main class="home-container profil-simple" style="max-width:1100px;margin:0 auto;padding-left:24px;padding-right:24px;">
    <section class="hero" style="margin-bottom:48px;">
        <div style="max-width:100%;margin:0 auto;">
            <h1 class="section-title" style="font-size:48px;font-family:'Futura','Futura Std','FuturaPT',Arial,sans-serif;font-weight:bold;color:#F4EFEC;letter-spacing:0.5px;margin-bottom:24px;">Mon profil</h1>
        </div>
    </section>
    <section class="profil-section" style="max-width:100%;margin:0 auto 48px auto;padding:0;display:flex;flex-direction:column;align-items:flex-start;gap:32px;background:none;box-shadow:none;">
        <form method="POST" enctype="multipart/form-data" style="display:flex;flex-direction:column;align-items:flex-start;gap:18px;margin-bottom:0;width:100%;">
            <?php wp_nonce_field('update_profil', 'profil_nonce'); ?>
            <div style="position:relative;width:110px;height:110px;margin-bottom:10px;">
                <img src="<?php echo esc_url($avatar_url ?: get_avatar_url($user_id)); ?>" alt="Photo de profil" style="width:110px;height:110px;object-fit:cover;border-radius:50%;border:2.5px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.10);">
                <button type="button" onclick="document.getElementById('avatarInput').click();" title="Modifier la photo" style="position:absolute;top:8px;right:-8px;background:rgba(255,255,255,0.98);border:none;border-radius:50%;padding:7px;cursor:pointer;color:#700118;font-size:1.1rem;box-shadow:0 4px 16px rgba(0,0,0,0.22);transition:background 0.2s;display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24"><path fill="#700118" d="M16.862 5.487a2.1 2.1 0 0 1 2.97 2.97l-8.8 8.8a1.5 1.5 0 0 1-.53.35l-3.13 1.13a.5.5 0 0 1-.64-.64l1.13-3.13a1.5 1.5 0 0 1 .35-.53l8.8-8.8Zm2.263-1.263a3.1 3.1 0 0 0-4.384 0l-8.8 8.8a2.5 2.5 0 0 0-.58.92l-1.13 3.13a1.5 1.5 0 0 0 1.92 1.92l3.13-1.13a2.5 2.5 0 0 0 .92-.58l8.8-8.8a3.1 3.1 0 0 0 0-4.384Z"/></svg>
                </button>
                <input type="file" id="avatarInput" name="avatar_file" accept="image/*" style="display:none;">
                <button type="submit" id="avatarSubmit" style="display:none;"></button>
            </div>
        </form>
        <div style="width:100%;text-align:left;">
            <div style="font-size:1.25rem;font-weight:700;color:#F4EFEC;margin-bottom:2px;word-break:break-all;"> <?php echo esc_html($user->display_name); ?> </div>
        </div>
        <?php if ($updated) : ?>
            <div class="profil-success-message" style="margin:0 0 0 0;">Modifications enregistrées !</div>
        <?php endif; ?>
        <?php if (!empty($profil_error)) : ?>
            <div class="profil-error-message" style="margin:0 0 0 0;"> <?php echo esc_html($profil_error); ?> </div>
        <?php endif; ?>
        <form method="POST" style="display:flex;flex-direction:column;gap:18px;margin-bottom:0;align-items:flex-start;width:100%;padding-top:0;">
            <?php wp_nonce_field('update_pseudo', 'pseudo_nonce'); ?>
            <input type="hidden" name="action" value="update_pseudo">
            <div style="display:flex;flex-direction:column;gap:8px;">
                <label for="new_pseudo" style="font-size:24px;font-family:'Futura Demi','Futura PT Demi','Futura Std Demi','Futura',Arial,sans-serif;font-weight:600;color:#F4EFEC;margin-bottom:2px;">Pseudo</label>
                    <input type="text" id="new_pseudo" name="new_pseudo" class="form-control" value="<?php echo esc_attr($user->display_name); ?>" maxlength="20" style="font-size:14px;font-family:'Futura','Futura Std','FuturaPT',Arial,sans-serif;font-weight:400;padding:4px 32px;border-radius:9px;border:1.5px solid #fff;width:100%;max-width:80vw;min-width:400px;margin:0 auto;display:block;background:rgba(255,255,255,0.13);color:#fff;transition:border-color 0.2s;">
            </div>
            <button type="submit" class="btn-profil-action" style="margin-top:8px;align-self:flex-end;font-size:14px;font-family:'Futura Demi','Futura PT Demi','Futura Std Demi','Futura',Arial,sans-serif;font-weight:600;">Modifier le pseudo</button>
        </form>
            <!-- Section Email -->
            <form method="POST" style="display:flex;flex-direction:column;gap:18px;margin-bottom:0;align-items:flex-start;width:100%;padding-top:0;">
                <?php wp_nonce_field('update_email', 'email_nonce'); ?>
                <input type="hidden" name="action" value="update_email">
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <label for="new_email" style="font-size:24px;font-family:'Futura Demi','Futura PT Demi','Futura Std Demi','Futura',Arial,sans-serif;font-weight:600;color:#F4EFEC;margin-bottom:2px;">Email</label>
                    <input type="email" id="new_email" name="new_email" class="form-control" value="<?php echo esc_attr($user->user_email); ?>" maxlength="100" style="font-size:14px;font-family:'Futura','Futura Std','FuturaPT',Arial,sans-serif;font-weight:400;padding:4px 32px;border-radius:9px;border:1.5px solid #fff;width:100%;max-width:80vw;min-width:400px;margin:0 auto;display:block;background:rgba(255,255,255,0.13);color:#fff;transition:border-color 0.2s;">
                </div>
                <button type="submit" class="btn-profil-action" style="margin-top:8px;align-self:flex-end;font-size:14px;font-family:'Futura Demi','Futura PT Demi','Futura',Arial,sans-serif;font-weight:600;">Modifier l'email</button>
            </form>
        <form method="POST" style="display:flex;flex-direction:column;gap:18px;margin-bottom:0;align-items:flex-start;width:100%;padding-top:0;">
            <?php wp_nonce_field('update_password', 'password_nonce'); ?>
            <div style="font-size:24px;font-family:'Futura Demi','Futura PT Demi','Futura Std Demi','Futura',Arial,sans-serif;font-weight:600;color:#F4EFEC;margin-bottom:2px;">Mot de passe</div>
            <input type="hidden" name="action" value="update_password">
            <div style="display:flex;flex-direction:column;gap:8px;">
                <label for="current_password" style="font-size:1.05rem;color:#F4EFEC;font-weight:500;margin-bottom:2px;">Ancien mot de passe</label>
                <input type="password" id="current_password" name="current_password" class="form-control" required style="font-size:14px;font-family:'Futura','Futura Std','FuturaPT',Arial,sans-serif;font-weight:400;padding:4px 32px;border-radius:9px;border:1.5px solid #fff;width:100%;max-width:80vw;min-width:400px;margin:0 auto;display:block;background:rgba(255,255,255,0.13);color:#fff;transition:border-color 0.2s;">
            </div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <label for="new_password" style="font-size:1.05rem;color:#F4EFEC;font-weight:500;margin-bottom:2px;">Nouveau mot de passe</label>
                <input type="password" id="new_password" name="new_password" class="form-control" minlength="6" required style="font-size:14px;font-family:'Futura','Futura Std','FuturaPT',Arial,sans-serif;font-weight:400;padding:4px 32px;border-radius:9px;border:1.5px solid #fff;width:100%;max-width:80vw;min-width:400px;margin:0 auto;display:block;background:rgba(255,255,255,0.13);color:#fff;transition:border-color 0.2s;">
            </div>
            <button type="submit" class="btn-profil-action" style="margin-top:8px;align-self:flex-end;font-size:14px;font-family:'Futura Demi','Futura PT Demi','Futura Std Demi','Futura',Arial,sans-serif;font-weight:600;">Changer le mot de passe</button>
        </form>
            <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="btn-logout-profil" style="font-size:14px;font-family:'Futura Demi','Futura PT Demi','Futura Std Demi','Futura',Arial,sans-serif;font-weight:600;">Déconnexion</a>
    </section>
</main>
<style>
    .btn-logout-profil {
        display: inline-block;
        background: #700118;
        color: #fff;
        border: 2px solid #700118;
        border-radius: 9px;
        padding: 10px 24px;
        font-weight: 600;
        text-decoration: none;
        font-size: 1.02rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        margin-left: 0;
        transition: background 0.2s, color 0.2s, border 0.2s;
        cursor: pointer;
    }
    .btn-logout-profil:hover {
        background: #232323;
        color: #fff;
        border: 2px solid #232323;
    }
    .btn-profil-action {
        background: #fff;
        color: #700118;
        border: 1.5px solid #700118;
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 600;
        font-size: 0.98rem;
        box-shadow: none;
        transition: background 0.2s, color 0.2s, border 0.2s;
        cursor: pointer;
    }
    .btn-profil-action:hover, .btn-profil-action:focus {
        background: #700118;
        color: #fff;
        border: 1.5px solid #700118;
    }
    .btn-profil-action {
        background: #fff;
        color: #700118;
        border: 1.5px solid #700118;
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 600;
        font-size: 0.98rem;
        box-shadow: none;
        transition: background 0.2s, color 0.2s, border 0.2s;
    }
    .btn-profil-action:hover {
        background: #700118;
        color: #fff;
        border: 1.5px solid #700118;
    }
    .profil-section input[type="text"],
    .profil-section input[type="password"] {
        border: 1.5px solid #fff !important;
        outline: none !important;
        transition: border 0.2s;
        color: #fff;
        background: rgba(255,255,255,0.13);
    }
    .profil-section input[type="text"]:focus,
    .profil-section input[type="password"]:focus {
        border: 1.5px solid #700118 !important;
        outline: none !important;
    }
</style>
<script>
document.getElementById('avatarInput')?.addEventListener('change', function() {
        document.getElementById('avatarSubmit').click();
});
</script>

<style>
    .scroll-to-top { display: none !important; }
</style>
<?php get_footer(); ?>

<script>

