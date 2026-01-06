

    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-left">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_class'     => 'footer-menu',
                    'container'      => false,
                    'fallback_cb'    => function () {
                        ?>
                        <ul class="footer-menu">
                            <li><a href="<?php echo esc_url(home_url('/films')); ?>">Films</a></li>
                            <li><a href="<?php echo esc_url(home_url('/series')); ?>">Séries</a></li>
                            <li><a href="<?php echo esc_url(home_url('/favoris')); ?>">Favoris</a></li>
                        </ul>
                        <?php
                    },
                ));
                ?>
            </div>

            <div class="footer-center">
                <div class="footer-picto">
                    <!-- Logo SVG direct -->
                    <?php
                    $svg_path = get_template_directory() . '/assets/image/Icones et Logo/Logo cinemusic.svg';
                    if (file_exists($svg_path)) {
                        $svg = file_get_contents($svg_path);
                        // Ajoute la classe logo-svg au SVG
                        $svg = preg_replace('/<svg /', '<svg class="logo-svg" ', $svg, 1);
                        echo $svg;
                    }
                    ?>
                </div>
                <div class="footer-logo-text">CINEMUSIC</div>
            </div>

            <div class="footer-right">
                <div class="social-icons-row">
                    <a href="https://facebook.com" class="social-icon" aria-label="Facebook" target="_blank" rel="noopener">
                        <svg class="social-svg" width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                            <path d="M12 2.03998C6.5 2.03998 2 6.52998 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.84998C10.44 7.33998 11.93 5.95998 14.22 5.95998C15.31 5.95998 16.45 6.14998 16.45 6.14998V8.61998H15.19C13.95 8.61998 13.56 9.38998 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96C15.9164 21.5878 18.0622 20.3855 19.6099 18.57C21.1576 16.7546 22.0054 14.4456 22 12.06C22 6.52998 17.5 2.03998 12 2.03998Z" fill="#F4EFEC"/>
                        </svg>
                    </a>
                    <a href="https://instagram.com" class="social-icon" aria-label="Instagram" target="_blank" rel="noopener">
                        <svg class="social-svg" width="28" height="28" viewBox="0 0 256 256" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                            <path d="M160,128a32,32,0,1,1-32-32A32.03667,32.03667,0,0,1,160,128Zm68-44v88a56.06353,56.06353,0,0,1-56,56H84a56.06353,56.06353,0,0,1-56-56V84A56.06353,56.06353,0,0,1,84,28h88A56.06353,56.06353,0,0,1,228,84Zm-52,44a48,48,0,1,0-48,48A48.05436,48.05436,0,0,0,176,128Zm16-52a12,12,0,1,0-12,12A12,12,0,0,0,192,76Z" fill="#F4EFEC"/>
                        </svg>
                    </a>
                    <a href="https://www.tiktok.com/@cinemusic" class="social-icon" aria-label="TikTok" target="_blank" rel="noopener">
                        <svg class="social-svg" width="28" height="28" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                            <path d="M16.656 1.029c1.637-0.025 3.262-0.012 4.886-0.025 0.054 2.031 0.878 3.859 2.189 5.213l-0.002-0.002c1.411 1.271 3.247 2.095 5.271 2.235l0.028 0.002v5.036c-1.912-0.048-3.71-0.489-5.331-1.247l0.082 0.034c-0.784-0.377-1.447-0.764-2.077-1.196l0.052 0.034c-0.012 3.649 0.012 7.298-0.025 10.934-0.103 1.853-0.719 3.543-1.707 4.954l0.020-0.031c-1.652 2.366-4.328 3.919-7.371 4.011l-0.014 0c-0.123 0.006-0.268 0.009-0.414 0.009-1.73 0-3.347-0.482-4.725-1.319l0.040 0.023c-2.508-1.509-4.238-4.091-4.558-7.094l-0.004-0.041c-0.025-0.625-0.037-1.25-0.012-1.862 0.49-4.779 4.494-8.476 9.361-8.476 0.547 0 1.083 0.047 1.604 0.136l-0.056-0.008c0.025 1.849-0.050 3.699-0.050 5.548-0.423-0.153-0.911-0.242-1.42-0.242-1.868 0-3.457 1.194-4.045 2.861l-0.009 0.030c-0.133 0.427-0.21 0.918-0.21 1.426 0 0.206 0.013 0.41 0.037 0.61l-0.002-0.024c0.332 2.046 2.086 3.59 4.201 3.59 0.061 0 0.121-0.001 0.181-0.004l-0.009 0c1.463-0.044 2.733-0.831 3.451-1.994l0.010-0.018c0.267-0.372 0.45-0.822 0.511-1.311l0.001-0.014c0.125-2.237 0.075-4.461 0.087-6.698 0.012-5.036-0.012-10.060 0.025-15.083z" fill="#F4EFEC"/>
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/company/cinemusic" class="social-icon" aria-label="LinkedIn" target="_blank" rel="noopener">
                        <svg class="social-svg" width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                            <path d="M6.5 8C7.32843 8 8 7.32843 8 6.5C8 5.67157 7.32843 5 6.5 5C5.67157 5 5 5.67157 5 6.5C5 7.32843 5.67157 8 6.5 8Z" fill="#F4EFEC"/>
                            <path d="M5 10C5 9.44772 5.44772 9 6 9H7C7.55228 9 8 9.44771 8 10V18C8 18.5523 7.55228 19 7 19H6C5.44772 19 5 18.5523 5 18V10Z" fill="#F4EFEC"/>
                            <path d="M11 19H12C12.5523 19 13 18.5523 13 18V13.5C13 12 16 11 16 13V18.0004C16 18.5527 16.4477 19 17 19H18C18.5523 19 19 18.5523 19 18V12C19 10 17.5 9 15.5 9C13.5 9 13 10.5 13 10.5V10C13 9.44771 12.5523 9 12 9H11C10.4477 9 10 9.44772 10 10V18C10 18.5523 10.4477 19 11 19Z" fill="#F4EFEC"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M20 1C21.6569 1 23 2.34315 23 4V20C23 21.6569 21.6569 23 20 23H4C2.34315 23 1 21.6569 1 20V4C1 2.34315 2.34315 1 4 1H20ZM20 3C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3H20Z" fill="#F4EFEC"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-legal">
            © <?php echo esc_html(date_i18n('Y')); ?> <?php echo esc_html(get_bloginfo('name')); ?>.
            <?php esc_html_e('Tous droits réservés.', 'project-end-of-year'); ?>
            <a href="<?php echo esc_url(home_url('/mentions-legales')); ?>"><?php esc_html_e('Mentions légales', 'project-end-of-year'); ?></a>
            <?php esc_html_e('et', 'project-end-of-year'); ?>
            <a href="<?php echo esc_url(home_url('/politique-de-confidentialite')); ?>"><?php esc_html_e('politique de confidentialité', 'project-end-of-year'); ?></a>.
        </div>



    <style>
                .footer-menu li a {
                    color: #F4EFEC;
                    text-decoration: none;
                    font-size: 20px !important;
                    font-weight: 700 !important;
                    font-family: "futura-pt", "Futura", Arial, sans-serif !important;
                    transition: all .2s ease;
                }
        .footer-container {
            width: calc(100% - 160px);
            margin: 40px 80px 0 80px;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 24px;
        }
        .footer-left, .footer-center, .footer-right {
            display: flex;
            flex-direction: column;
        }
        .footer-left {
            align-items: flex-start;
        }
        .footer-center {
            align-items: center;
        }
        .footer-right {
            align-items: flex-end;
        }
        .footer-menu {
            margin-bottom: 0;
        }
        .social-icons-row {
            margin-bottom: 0;
        }
        .social-icons-row {
            display: flex;
            gap: 24px;
            justify-content: center;
            align-items: center;
            margin-bottom: 18px;
        }
        .social-svg {
            width: 28px;
            height: 28px;
            transition: fill 0.2s;
            fill: #F4EFEC;
            display: block;
        }
        .social-icon:hover .social-svg path,
        .social-icon:focus .social-svg path {
            fill: #111;
        }
    </style>
    </footer>





    <?php wp_footer(); ?>
    </body>

    </html>