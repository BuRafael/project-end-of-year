    </main>


    <!-- Scroll to Top Button removed: now handled globally by main.js -->
    </main>

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
                    <?php
                    $footer_logo_path = get_template_directory() . '/assets/image/Icones et Logo/Logo.svg';
                    $footer_logo_uri  = get_template_directory_uri() . '/assets/image/Icones et Logo/Logo.svg';
                    if (file_exists($footer_logo_path)) {
                        echo '<img src="' . esc_url($footer_logo_uri) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="logo-img" loading="lazy">';
                    } elseif (has_custom_logo()) {
                        $logo_id = get_theme_mod('custom_logo');
                        echo wp_get_attachment_image($logo_id, 'full', false, array('class' => 'logo-img', 'loading' => 'lazy'));
                    }
                    ?>
                </div>
                <div class="footer-logo-text">CINEMUSIC</div>
            </div>

            <div class="footer-right">
                <a href="https://facebook.com" class="social-icon" aria-label="Facebook" target="_blank" rel="noopener">
                    <svg class="social-svg" width="20" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                        <path d="M9.04623 5.865V8.613H7.03223V11.973H9.04623V21.959H13.1802V11.974H15.9552C15.9552 11.974 16.2152 10.363 16.3412 8.601H13.1972V6.303C13.1972 5.96 13.6472 5.498 14.0932 5.498H16.3472V2H13.2832C8.94323 2 9.04623 5.363 9.04623 5.865Z" fill="currentColor"/>
                    </svg>
                </a>
                <a href="https://www.tiktok.com/@cinemusic" class="social-icon tiktok-icon" aria-label="TikTok" target="_blank" rel="noopener">
                    <svg class="social-svg" width="20" height="20" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                        <path class="tiktok-path" d="M16.656 1.029c1.637-0.025 3.262-0.012 4.886-0.025 0.054 2.031 0.878 3.859 2.189 5.213l-0.002-0.002c1.411 1.271 3.247 2.095 5.271 2.235l0.028 0.002v5.036c-1.912-0.048-3.71-0.489-5.331-1.247l0.082 0.034c-0.784-0.377-1.447-0.764-2.077-1.196l0.052 0.034c-0.012 3.649 0.012 7.298-0.025 10.934-0.103 1.853-0.719 3.543-1.707 4.954l0.020-0.031c-1.652 2.366-4.328 3.919-7.371 4.011l-0.014 0c-0.123 0.006-0.268 0.009-0.414 0.009-1.73 0-3.347-0.482-4.725-1.319l0.040 0.023c-2.508-1.509-4.238-4.091-4.558-7.094l-0.004-0.041c-0.025-0.625-0.037-1.25-0.012-1.862 0.49-4.779 4.494-8.476 9.361-8.476 0.547 0 1.083 0.047 1.604 0.136l-0.056-0.008c0.025 1.849-0.050 3.699-0.050 5.548-0.423-0.153-0.911-0.242-1.42-0.242-1.868 0-3.457 1.194-4.045 2.861l-0.009 0.030c-0.133 0.427-0.21 0.918-0.21 1.426 0 0.206 0.013 0.41 0.037 0.61l-0.002-0.024c0.332 2.046 2.086 3.59 4.201 3.59 0.061 0 0.121-0.001 0.181-0.004l-0.009 0c1.463-0.044 2.733-0.831 3.451-1.994l0.010-0.018c0.267-0.372 0.45-0.822 0.511-1.311l0.001-0.014c0.125-2.237 0.075-4.461 0.087-6.698 0.012-5.036-0.012-10.060 0.025-15.083z" fill="#fff"/>
                    </svg>
                </a>
                </footer>

                <style>
                .tiktok-icon .tiktok-path {
                    transition: fill 0.2s;
                    fill: #fff;
                }
                .tiktok-icon:hover .tiktok-path {
                    fill: #111;
                }
                </style>
                <a href="https://www.linkedin.com/company/cinemusic" class="social-icon" aria-label="LinkedIn" target="_blank" rel="noopener">
                    <svg class="social-svg" width="20" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                        <path d="M19 3A2 2 0 0 1 21 5V19A2 2 0 0 1 19 21H5A2 2 0 0 1 3 19V5A2 2 0 0 1 5 3H19ZM8.5 17V10.5H6V17H8.5ZM7.25 9.5A1.25 1.25 0 1 0 7.25 7A1.25 1.25 0 0 0 7.25 9.5ZM18 17V13.25C18 11.45 16.55 10.5 15.25 10.5C14.09 10.5 13.5 11.25 13.25 11.75V10.5H10.75V17H13.25V13.5C13.25 12.95 13.7 12.5 14.25 12.5C14.8 12.5 15.25 12.95 15.25 13.5V17H18Z" fill="currentColor"/>
                    </svg>
                </a>
                <a href="https://instagram.com" class="social-icon" aria-label="Instagram" target="_blank" rel="noopener">
                    <svg class="social-svg" width="28" height="21" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                        <rect x="2" y="2" width="20" height="20" rx="4" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <circle cx="17" cy="7" r="1" fill="currentColor"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="footer-legal">
            © <?php echo esc_html(date_i18n('Y')); ?> <?php echo esc_html(get_bloginfo('name')); ?>.
            <?php esc_html_e('Tous droits réservés.', 'project-end-of-year'); ?>
            <a href="<?php echo esc_url(home_url('/mentions-legales')); ?>"><?php esc_html_e('Mentions légales', 'project-end-of-year'); ?></a>
            <?php esc_html_e('et', 'project-end-of-year'); ?>
            <a href="<?php echo esc_url(home_url('/politique-de-confidentialite')); ?>"><?php esc_html_e('politique de confidentialité', 'project-end-of-year'); ?></a>.
        </div>


    </footer>





    <?php wp_footer(); ?>
    </body>

    </html>