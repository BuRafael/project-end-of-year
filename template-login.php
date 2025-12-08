<?php
/**
 * Template Name: Login Template
 */
get_header();
?>

<div class="page-wrapper">

    <!-- Logo -->
    <div class="logo-box">
        <span class="logo-icon">🎵</span>
    </div>

    <!-- Titre -->
    <h1 class="main-title">
        Bienvenue sur<br>CINEMUSIC&nbsp;!
    </h1>

    <!-- Carte connexion -->
    <div class="login-card">

        <h2>Se connecter</h2>

        <?php if ( isset($_GET['login']) && $_GET['login'] === 'failed' ) : ?>
            <div class="error-message">Identifiants invalides.</div>
        <?php endif; ?>

        <?php if ( is_user_logged_in() ) : ?>
            <div class="success-message">Vous êtes déjà connecté. <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>">Se déconnecter</a></div>
        <?php else : ?>

            <form method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" class="login-form">
                <?php wp_nonce_field( 'login_action', 'login_nonce' ); ?>

                <div class="mb-3">
                    <input class="form-control custom-input" type="text" name="log" id="user_login" placeholder="Nom d'utilisateur ou email" required>
                </div>

                <div class="mb-4 password-wrapper">
                    <input class="form-control custom-input" type="password" name="pwd" id="passwordField" placeholder="Mot de passe" required>
                    <span class="toggle-password" id="togglePassword">👁️</span>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="rememberme" value="forever"> Se souvenir de moi
                    </label>
                </div>

                <div class="text-center" style="margin-top:16px;">
                    <button type="submit" name="login_submit" class="btn-submit">Se connecter</button>
                </div>
            </form>

            <p class="register-link">Pas de compte ? <a href="<?php echo esc_url( home_url('/signup') ); ?>">Inscrivez-vous</a></p>

        <?php endif; ?>

    </div>
</div>

<?php
get_footer();
?>
