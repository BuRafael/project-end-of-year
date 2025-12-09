<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <link rel="stylesheet" href="https://use.typekit.net/isz1tod.css">
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <!-- DEBUG MARKER: header.php from project-end-of-year theme (2025-12-09) -->
    <main id="main-content">
    <header class="site-header">
    <div class="header-container">

        <!-- LOGO -->
        <div class="header-logo">
            <a href="<?php echo esc_url(home_url('/')); ?>">CINEMUSIC</a>
        </div>

        <!-- MENU CENTRAL -->
        <nav class="header-nav">
            <?php
                wp_nav_menu([
                    'theme_location' => 'main-menu',
                    'container'      => false,
                    'menu_class'     => 'header-menu',
                    'fallback_cb'    => 'wp_page_menu',
                ]);
            ?>
        </nav>

        <!-- ZONE DROITE (bouton + icône profil) -->
        <div class="header-right">

            <?php if (!is_user_logged_in()) : ?>

                <!-- Bouton S'inscrire -->
                <a href="<?php echo esc_url(site_url('/inscription')); ?>" class="btn-inscription">
                    S'inscrire
                </a>

                <!-- Icône profil vers inscription -->
                <a href="<?php echo esc_url(site_url('/inscription')); ?>" class="profil-icon">
                    <span class="dashicons dashicons-admin-users"></span>
                </a>

            <?php else : ?>

                <!-- Icône profil vers page profil -->
                <a href="<?php echo esc_url(site_url('/profil')); ?>" class="profil-icon">
                    <span class="dashicons dashicons-admin-users"></span>
                </a>

            <?php endif; ?>

        </div>

    </div>
</header>