<?php

/**
 * Template Name: Register Template
 */
// Page sans header/footer : structure minimale + wp_head/wp_footer pour charger les styles/scripts
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/assets/css/base.css'); ?>?v=<?php echo filemtime(get_template_directory() . '/functions.php'); ?>">
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/assets/css/register-step.css'); ?>?v=<?php echo filemtime(get_template_directory() . '/functions.php'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class('page-register'); ?>>

<section class="register-hero">
    <div class="register-hero__title">
        <p><?php esc_html_e('Bienvenue sur', 'project-end-of-year'); ?></p>
        <h1>
            <span style="display:block;">CINEMUSIC</span>
        </h1>
        <div class="register-hero__logo">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/image/Icones et Logo/Logo.svg'); ?>" alt="<?php bloginfo('name'); ?>" loading="lazy">
        </div>
        <div class="register-card">
        <h2><?php esc_html_e('Créez ton profil!', 'project-end-of-year'); ?></h2>

        <?php
        if (isset($_GET['registration']) && $_GET['registration'] == 'success') {
            echo '<div class="success-message">Inscription réussie ! Tu peux maintenant te connecter.</div>';
        }
        if (is_user_logged_in()) {
            echo '<div class="success-message">Tu es déjà connecté. <a href="' . esc_url(wp_logout_url(home_url())) . '">Déconnexion</a></div>';
        } else {
        ?>

            <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" class="register-form">
                <?php wp_nonce_field('register_action', 'register_nonce'); ?>

                <div class="field">
                    <input type="email" name="user_email" id="user_email" placeholder="Adresse email" required>
                    <?php
                    if (isset($_GET['registration']) && $_GET['registration'] == 'email_exists') {
                        echo '<div class="error-message">Cet email est déjà relié à un compte existant.</div>';
                    }
                    ?>
                </div>

                <div class="field">
                    <input type="text" name="user_login" id="user_login" placeholder="Pseudo" required>
                    <?php
                    if (isset($_GET['registration']) && $_GET['registration'] == 'username_exists') {
                        echo '<div class="error-message">Ce pseudo est déjà utilisé. Choisis-en un autre.</div>';
                    }
                    ?>
                </div>

                <div class="field field--password">
                    <input type="password" name="user_pass" id="user_pass" placeholder="Mot de passe" required>
                    <!-- Icône d'œil retirée -->
                    <?php
                    if (isset($_GET['registration']) && $_GET['registration'] == 'error') {
                        echo '<div class="error-message">Les mots de passe ne correspondent pas. Réessaie.</div>';
                    }
                    ?>
                </div>

                <div class="field field--password">
                    <input type="password" name="user_pass_confirm" id="user_pass_confirm" placeholder="Confirme ton mot de passe" required>
                    <!-- Icône d'œil retirée -->
                </div>

                <button type="submit" name="register_submit" class="btn-register-primary">
                    <?php esc_html_e('Suivant', 'project-end-of-year'); ?>
                </button>
            </form>

            <p class="auth-link" style="margin-top: 20px; text-align: center; font-size: 0.95rem;">
                <span style="font-family: 'Futura', 'Futura PT', 'Futura Std', Arial, sans-serif; font-weight: 400; font-size: 16px;">
                    <?php esc_html_e('Vous avez déjà un compte ?', 'project-end-of-year'); ?>
                </span>
                <a href="<?php echo esc_url(home_url('/login')); ?>" style="color: var(--reg-primary); text-decoration: none; font-family: 'Futura', 'Futura PT', 'Futura Std', Arial, sans-serif; font-weight: 700; font-size: 16px;">
                    <?php esc_html_e('Se connecter', 'project-end-of-year'); ?>
                </a>
            </p>

        <?php } ?>
    </div>
</section>

<script src="<?php echo esc_url(get_template_directory_uri() . '/assets/js/register.js'); ?>"></script>
<?php wp_footer(); ?>
</body>
</html>