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
                        <svg width="60" height="59" viewBox="0 0 100 99" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M0 0H100V99H0V0Z" fill="url(#pattern0_349_3447)"/>
                            <defs>
                                <pattern id="pattern0_349_3447" patternContentUnits="objectBoundingBox" width="1" height="1">
                                    <use xlink:href="#image0_349_3447" transform="matrix(0.00168067 0 0 0.00169765 0 -0.21471)"/>
                                </pattern>
                                <image id="image0_349_3447" width="595" height="842" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
                            </defs>
                        </svg>
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
                <!-- Bouton loupe visible uniquement sur mobile -->
                <button class="header-search-mobile" aria-label="Recherche" style="display:none;"></button>
                <a href="<?php echo esc_url(home_url('/profil')); ?>" class="profil-icon" aria-label="<?php esc_attr_e('Profil', 'project-end-of-year'); ?>">
                <?php
                if (is_user_logged_in()) {
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
            </div>
        </div>
    </header>

    <main id="main-content">