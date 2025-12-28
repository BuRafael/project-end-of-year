<?php
/**
 * Template Name: Login Template
 */

// Page sans header/footer : structure minimale + wp_head/wp_footer pour charger les styles/scripts
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/assets/css/base.css'); ?>?v=<?php echo filemtime(get_template_directory() . '/functions.php'); ?>">
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/assets/css/Connexion.css'); ?>?v=<?php echo filemtime(get_template_directory() . '/functions.php'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class('page-login'); ?>>

<section class="register-hero">
    <div class="register-hero__title">
        <p><?php esc_html_e('Bienvenue sur', 'project-end-of-year'); ?></p>
        <h1>
            <span style="display:block; margin-top: 12px;">CINEMUSIC</span>
        </h1>
        <div class="register-hero__logo">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/image/Icones et Logo/Logo.svg'); ?>" alt="<?php bloginfo('name'); ?>" loading="lazy">
        </div>
    </div>

    <div class="register-card">
        <h2 class="login-title-custom"><?php esc_html_e('Se connecter', 'project-end-of-year'); ?></h2>

        <?php
        if (isset($_GET['login']) && $_GET['login'] == 'failed') {
            echo '<div class="error-message">Identifiants invalides.</div>';
        }
        if (isset($_GET['login']) && $_GET['login'] == 'success') {
            echo '<div class="success-message">Connexion réussie !</div>';
        }
        if (is_user_logged_in()) {
            echo '<div class="success-message">Tu es déjà connecté. <a href="' . esc_url(wp_logout_url(home_url())) . '">Déconnexion</a></div>';
        } else {
        ?>

            <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" class="register-form">
                <?php wp_nonce_field('login_action', 'login_nonce'); ?>

                <div class="field">
                    <input type="text" name="log" id="user_login" placeholder="Adresse email / Pseudo" required>
                </div>

                <div class="field field--password">
                    <input type="password" name="pwd" id="user_pass" placeholder="Mot de passe" required>
                    <button type="button" class="password-toggle" data-toggle-password="user_pass" aria-label="<?php esc_attr_e('Afficher / masquer le mot de passe', 'project-end-of-year'); ?>">
                        <span class="toggle-icon" aria-hidden="true">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/image/Icones et Logo/eye.svg'); ?>" alt="Afficher le mot de passe" style="width:22px;height:22px;vertical-align:middle;filter:invert(0);">
                        </span>
                    </button>
                </div>

                <button type="submit" name="login_submit" class="btn-register-primary">
                    <span style="font-family: 'Futura Demi', 'Futura PT Demi', 'Futura Std Demi', 'Futura', Arial, sans-serif; font-weight: 600; font-size: 14px;"><?php esc_html_e('Suivant', 'project-end-of-year'); ?></span>
                </button>
            </form>

            <p class="auth-link login-link-custom" style="margin-top: 20px;">
                <span class="no-account-text"><?php esc_html_e('Pas de compte ?', 'project-end-of-year'); ?></span>
                <a href="<?php echo esc_url(home_url('/inscription')); ?>" class="signup-link-custom">
                    <?php esc_html_e("S'inscrire", 'project-end-of-year'); ?>
                </a>
            </p>

        <?php } ?>
    </div>
</section>

<script src="<?php echo esc_url(get_template_directory_uri() . '/assets/js/Connexion.js'); ?>"></script>
<?php wp_footer(); ?>
</body>
</html>
