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
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/assets/css/register-step.css'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class('page-register'); ?>>

<section class="register-hero">
    <div class="register-hero__logo">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/image/Icones et Logo/Logo.svg'); ?>" alt="<?php bloginfo('name'); ?>" loading="lazy">
    </div>

    <div class="register-hero__title">
        <p><?php esc_html_e('Bienvenue sur', 'project-end-of-year'); ?></p>
        <h1><?php esc_html_e('CINEMUSIC!', 'project-end-of-year'); ?></h1>
    </div>

    <div class="register-card">
        <h2><?php esc_html_e('Créez ton profil!', 'project-end-of-year'); ?></h2>

        <?php
        if (isset($_GET['registration']) && $_GET['registration'] == 'success') {
            echo '<div class="success-message">Inscription réussie ! Tu peux maintenant te connecter.</div>';
        }
        if (isset($_GET['registration']) && $_GET['registration'] == 'error') {
            echo '<div class="error-message">Inscription impossible. Vérifie les champs et réessaie.</div>';
        }
        if (is_user_logged_in()) {
            echo '<div class="success-message">Tu es déjà connecté. <a href="' . esc_url(wp_logout_url(home_url())) . '">Déconnexion</a></div>';
        } else {
        ?>

            <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" class="register-form">
                <?php wp_nonce_field('register_action', 'register_nonce'); ?>

                <div class="field">
                    <input type="email" name="user_email" id="user_email" placeholder="Adresse email" required>
                </div>

                <div class="field">
                    <input type="text" name="user_login" id="user_login" placeholder="Pseudo" required>
                </div>

                <div class="field field--password">
                    <input type="password" name="user_pass" id="user_pass" placeholder="Mot de passe" required>
                    <button type="button" class="password-toggle" data-toggle-password="user_pass" aria-label="<?php esc_attr_e('Afficher / masquer le mot de passe', 'project-end-of-year'); ?>">
                        <span class="toggle-icon" aria-hidden="true">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/image/Icones et Logo/eye.svg'); ?>" alt="Afficher le mot de passe" style="width:22px;height:22px;vertical-align:middle;filter:invert(0);">
                        </span>
                    </button>
                </div>

                <div class="field field--password">
                    <input type="password" name="user_pass_confirm" id="user_pass_confirm" placeholder="Confirme ton mot de passe" required>
                    <button type="button" class="password-toggle" data-toggle-password="user_pass_confirm" aria-label="<?php esc_attr_e('Afficher / masquer le mot de passe', 'project-end-of-year'); ?>">
                        <span class="toggle-icon" aria-hidden="true">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/image/Icones et Logo/eye.svg'); ?>" alt="Afficher le mot de passe" style="width:22px;height:22px;vertical-align:middle;filter:invert(0);">
                        </span>
                    </button>
                </div>

                <button type="submit" name="register_submit" class="btn-register-primary">
                    <?php esc_html_e('Suivant', 'project-end-of-year'); ?>
                </button>
            </form>

        <?php } ?>
    </div>
</section>

<?php wp_footer(); ?>
</body>
</html>