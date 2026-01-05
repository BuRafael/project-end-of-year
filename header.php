<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.typekit.net/isz1tod.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>html,body{background:#1A1A1A!important;}</style>
    <?php wp_head(); ?>
    <script>window.ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';</script>
</head>

<body <?php body_class(); ?> data-user-logged-in="<?php echo is_user_logged_in() ? 'true' : 'false'; ?>">
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

    <div id="menu-overlay" class="menu-overlay"></div>
    <header class="site-header">
        <div class="header-container container-fluid">
            <div class="header-burger" id="header-burger" aria-label="Ouvrir le menu" tabindex="0">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" aria-hidden="true">
                    <rect y="6" width="32" height="4" rx="2" fill="#F4EFEC"/>
                    <rect y="14" width="32" height="4" rx="2" fill="#F4EFEC"/>
                    <rect y="22" width="32" height="4" rx="2" fill="#F4EFEC"/>
                </svg>
            </div>

            <div class="header-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <span class="brand-logo" aria-label="Logo Cinemusic">
                        <?php
                        $svg_path = get_template_directory() . '/assets/image/Icones et Logo/Logo cinemusic.svg';
                        if (file_exists($svg_path)) {
                            $svg = file_get_contents($svg_path);
                            // Ajoute un style inline pour forcer le décalage vertical
                            $svg = preg_replace('/<svg /', '<svg class="logo-svg" width="50" height="50" style="position:relative; top:-24px;" ', $svg, 1);
                            echo $svg;
                        }
                        ?>
                    </span>
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
                            <li><a href="<?php echo esc_url(home_url('/films')); ?>" class="<?php echo (is_page('films') || is_singular('film') || is_post_type_archive('films')) ? 'active' : ''; ?>">Films</a></li>
                            <li><a href="<?php echo esc_url(home_url('/series')); ?>" class="<?php echo (is_page('series') || is_singular('serie') || is_post_type_archive('series')) ? 'active' : ''; ?>">Séries</a></li>
                            <li><a href="<?php echo esc_url(home_url('/favoris')); ?>" class="<?php echo (is_page('favoris')) ? 'active' : ''; ?>">Favoris</a></li>
                        </ul>
                        <?php
                    },
                ));
                ?>
            </nav>

            <div class="header-right" style="display: flex; align-items: center; gap: 8px;">
                <div class="header-search-mobile-bg" id="header-search-mobile-bg"></div>
                <form role="search" method="get" class="header-search" id="header-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="margin: 0; display: none;">
                    <button type="submit" aria-label="<?php esc_attr_e('Valider la recherche', 'project-end-of-year'); ?>" style="background: none; border: none; padding: 0 6px 0 0; display: flex; align-items: center; cursor: pointer;">
                        <span class="search-icon">🔍</span>
                    </button>
                    <input type="search" name="s" placeholder="Rechercher..." aria-label="<?php esc_attr_e('Rechercher', 'project-end-of-year'); ?>">
                </form>
                <button class="header-search-mobile" aria-label="Recherche">
                    <span class="search-icon" aria-hidden="true" style="display: flex; align-items: center;">
                        <svg width="28" height="28" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="2"/>
                            <line x1="15.4142" y1="15" x2="20" y2="19.5858" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </span>
                </button>
                <?php if (!is_user_logged_in()) : ?>
                    <a href="<?php echo esc_url(home_url('/inscription')); ?>" class="btn-inscription" aria-label="S'inscrire">S'inscrire</a>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/profil')); ?>" class="profil-icon" aria-label="<?php esc_attr_e('Profil', 'project-end-of-year'); ?>">
                        <?php
                        $user_id = get_current_user_id();
                        $avatar_url = get_user_meta($user_id, 'avatar_url', true);
                        if (!empty($avatar_url)) {
                            echo '<img src="' . esc_url($avatar_url) . '" alt="" class="profil-avatar">';
                        } else {
                            ?>
                            <svg class="profil-svg" width="65" height="72" viewBox="0 0 65 72" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M42.2502 28.718C42.2502 34.6656 37.8849 39.4872 32.5002 39.4872C27.1154 39.4872 22.7502 34.6656 22.7502 28.718C22.7502 22.7703 27.1154 17.9487 32.5002 17.9487C37.8849 17.9487 42.2502 22.7703 42.2502 28.718ZM39.0002 28.718C39.0002 32.6831 36.09 35.8974 32.5002 35.8974C28.9103 35.8974 26.0002 32.6831 26.0002 28.718C26.0002 24.7528 28.9103 21.5385 32.5002 21.5385C36.09 21.5385 39.0002 24.7528 39.0002 28.718Z" fill="currentColor"/>
                                <path d="M32.5002 44.8718C21.9793 44.8718 13.0152 51.7433 9.60059 61.3703C10.4324 62.2827 11.3087 63.1457 12.2255 63.955C14.7682 55.1164 22.7448 48.4616 32.5002 48.4616C42.2555 48.4616 50.2321 55.1164 52.7748 63.955C53.6916 63.1457 54.5679 62.2827 55.3997 61.3704C51.9851 51.7433 43.021 44.8718 32.5002 44.8718Z" fill="currentColor"/>
                            </svg>
                            <?php
                        }
                        ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main id="main-content">