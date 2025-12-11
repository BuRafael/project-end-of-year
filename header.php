<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <?php
    // Vérifier si l'utilisateur vient de terminer son inscription
    if (!is_user_logged_in() && isset($_COOKIE['cinemusic_just_registered'])) {
        // Trouver l'utilisateur le plus récent
        $recent_user = get_users(array(
            'orderby' => 'ID',
            'order' => 'DESC',
            'number' => 1,
        ));
        if (!empty($recent_user)) {
            $user = $recent_user[0];
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID, true, is_ssl());
            // Supprimer le cookie après utilisation
            setcookie('cinemusic_just_registered', '', time() - 3600, '/', '', is_ssl(), true);
        }
    }
    ?>

    <header class="site-header">
        <div class="header-container container-fluid">
            <div class="header-logo">
                <?php
                $theme_logo_uri = get_template_directory_uri() . '/assets/image/Icones et Logo/Logo.svg';
                ?>
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo esc_url($theme_logo_uri); ?>" class="brand-logo" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" loading="lazy">
                    <span class="brand-text"><?php echo esc_html(get_bloginfo('name', 'display')); ?></span>
                </a>
            </div>

            <nav class="header-nav" aria-label="<?php esc_attr_e('Navigation principale', 'project-end-of-year'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'header-menu',
                    'container'      => false,
                    'fallback_cb'    => function () {
                        ?>
                        <ul class="header-menu">
                            <li><a href="<?php echo esc_url(home_url('/films')); ?>">Films</a></li>
                            <li><a href="<?php echo esc_url(home_url('/series')); ?>">Séries</a></li>
                            <li><a href="<?php echo esc_url(home_url('/favoris')); ?>">Favoris</a></li>
                        </ul>
                        <?php
                    },
                ));
                ?>
            </nav>

            <div class="header-right">
                <?php if ( ! is_front_page() ) : ?>
                    <form role="search" method="get" class="header-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input type="search" name="s" placeholder="Rechercher..." aria-label="<?php esc_attr_e('Rechercher', 'project-end-of-year'); ?>">
                        <button type="submit" aria-label="<?php esc_attr_e('Valider la recherche', 'project-end-of-year'); ?>">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                <?php endif; ?>

                <div class="header-actions">
                    <?php if (!is_user_logged_in()) : ?>
                        <a class="btn-inscription" href="<?php echo esc_url(home_url('/inscription')); ?>">
                            <?php esc_html_e("S'inscrire", 'project-end-of-year'); ?>
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo esc_url(home_url('/profil')); ?>" class="profil-icon" aria-label="<?php esc_attr_e('Profil', 'project-end-of-year'); ?>">
                    <?php
                    if (is_user_logged_in()) {
                        $user_id = get_current_user_id();
                        $avatar_url = get_user_meta($user_id, 'avatar_url', true);
                        
                        // Debug: Vérifier les valeurs
                        // error_log('User ID: ' . $user_id . ' Avatar URL: ' . $avatar_url);
                        
                        if (!empty($avatar_url)) {
                            // Afficher l'image de profil
                            echo '<img src="' . esc_url($avatar_url) . '" alt="" class="profil-avatar">';
                        } else {
                            // Afficher l'icône par défaut
                            ?>
                            <svg class="profil-svg" width="65" height="72" viewBox="0 0 65 72" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M42.2502 28.718C42.2502 34.6656 37.8849 39.4872 32.5002 39.4872C27.1154 39.4872 22.7502 34.6656 22.7502 28.718C22.7502 22.7703 27.1154 17.9487 32.5002 17.9487C37.8849 17.9487 42.2502 22.7703 42.2502 28.718ZM39.0002 28.718C39.0002 32.6831 36.09 35.8974 32.5002 35.8974C28.9103 35.8974 26.0002 32.6831 26.0002 28.718C26.0002 24.7528 28.9103 21.5385 32.5002 21.5385C36.09 21.5385 39.0002 24.7528 39.0002 28.718Z" fill="currentColor"/>
                                <path d="M32.5002 44.8718C21.9793 44.8718 13.0152 51.7433 9.60059 61.3703C10.4324 62.2827 11.3087 63.1457 12.2255 63.955C14.7682 55.1164 22.7448 48.4616 32.5002 48.4616C42.2555 48.4616 50.2321 55.1164 52.7748 63.955C53.6916 63.1457 54.5679 62.2827 55.3997 61.3704C51.9851 51.7433 43.021 44.8718 32.5002 44.8718Z" fill="currentColor"/>
                            </svg>
                            <?php
                        }
                    } else {
                        // Afficher l'icône par défaut pour utilisateur non connecté
                        ?>
                        <svg class="profil-svg" width="65" height="72" viewBox="0 0 65 72" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M42.2502 28.718C42.2502 34.6656 37.8849 39.4872 32.5002 39.4872C27.1154 39.4872 22.7502 34.6656 22.7502 28.718C22.7502 22.7703 27.1154 17.9487 32.5002 17.9487C37.8849 17.9487 42.2502 22.7703 42.2502 28.718ZM39.0002 28.718C39.0002 32.6831 36.09 35.8974 32.5002 35.8974C28.9103 35.8974 26.0002 32.6831 26.0002 28.718C26.0002 24.7528 28.9103 21.5385 32.5002 21.5385C36.09 21.5385 39.0002 24.7528 39.0002 28.718Z" fill="currentColor"/>
                            <path d="M32.5002 44.8718C21.9793 44.8718 13.0152 51.7433 9.60059 61.3703C10.4324 62.2827 11.3087 63.1457 12.2255 63.955C14.7682 55.1164 22.7448 48.4616 32.5002 48.4616C42.2555 48.4616 50.2321 55.1164 52.7748 63.955C53.6916 63.1457 54.5679 62.2827 55.3997 61.3704C51.9851 51.7433 43.021 44.8718 32.5002 44.8718Z" fill="currentColor"/>
                        </svg>
                        <?php
                    }
                    ?>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main id="main-content">