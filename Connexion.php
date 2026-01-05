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
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/assets/css/connexion.css'); ?>?v=<?php echo filemtime(get_template_directory() . '/functions.php'); ?>">
    <script>
        window.themeBasePath = '<?php echo esc_js(get_template_directory_uri()); ?>';
    </script>
    <?php wp_head(); ?>
</head>
<body <?php body_class('page-login'); ?>>

<section class="register-hero">
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
                // Mets les 3 points en noir du site (remplace tout fill sur les paths points, même si déjà noir)
                $svg = preg_replace('/(<path[^>]+d="M6\.82432[^>]+)fill="#([0-9A-Fa-f]{6})"/i', '$1fill="#1A1A1A"', $svg);
                $svg = preg_replace('/(<path[^>]+d="M6\.82432[^>]+)fill="#([0-9A-Fa-f]{6})"/i', '$1fill="#1A1A1A"', $svg);
                $svg = preg_replace('/(<path[^>]+d="M6\.82432[^>]+)fill="#([0-9A-Fa-f]{6})"/i', '$1fill="#1A1A1A"', $svg);
                // Pour être sûr, repasse tout le SVG en blanc sauf les points
                $svg = preg_replace('/(<path[^>]+d="M6\.82432[^>]+)fill="#1A1A1A"/i', '$1fill="#1A1A1A"', $svg); // points restent noirs
                $svg = preg_replace('/(<path(?![^>]+d="M6\.82432)[^>]+)fill="#([0-9A-Fa-f]{6})"/i', '$1fill="#F4EFEC"', $svg); // tout le reste en blanc
                echo $svg;
            }
            ?>
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
