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
                            <li><a href="<?php echo esc_url(home_url('/musique')); ?>">Musique</a></li>
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
                <a href="https://x.com" class="social-icon" aria-label="X" target="_blank" rel="noopener">
                    <svg class="social-svg" width="20" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                        <path d="M22 5.90692C21.2504 6.2343 20.4565 6.44896 19.644 6.54392C20.4968 6.04315 21.138 5.24903 21.448 4.30992C20.64 4.78025 19.7587 5.11152 18.841 5.28992C18.4545 4.88513 17.9897 4.56331 17.4748 4.3441C16.9598 4.12489 16.4056 4.01289 15.846 4.01492C13.58 4.01492 11.743 5.82492 11.743 8.05492C11.743 8.37092 11.779 8.67992 11.849 8.97492C10.2236 8.89761 8.63212 8.48233 7.17617 7.75556C5.72022 7.02879 4.43176 6.0065 3.393 4.75392C3.02883 5.36832 2.83742 6.0697 2.839 6.78392C2.8397 7.45189 3.00683 8.10915 3.32529 8.69631C3.64375 9.28348 4.1035 9.78203 4.663 10.1469C4.01248 10.1259 3.37602 9.95225 2.805 9.63992V9.68992C2.805 11.6479 4.22 13.2809 6.095 13.6529C5.74261 13.7464 5.37958 13.7938 5.015 13.7939C4.75 13.7939 4.493 13.7689 4.242 13.7189C4.51008 14.5268 5.02311 15.2312 5.70982 15.7343C6.39653 16.2373 7.22284 16.514 8.074 16.5259C6.61407 17.6505 4.82182 18.258 2.979 18.2529C2.647 18.2529 2.321 18.2329 2 18.1969C3.88125 19.3876 6.06259 20.0182 8.289 20.0149C15.836 20.0149 19.962 13.8579 19.962 8.51892L19.948 7.99592C20.7529 7.42959 21.4481 6.72177 22 5.90692Z" fill="currentColor"/>
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



    <!-- Scroll to Top Button -->
    <?php 
    // Ne pas afficher sur la page profil
    if (!is_page('profil') && !is_page('mon-profil') && !is_page_template('template-profil.php') && !is_page_template('template-userprofil.php')) : 
    ?>
    <button class="scroll-to-top" id="scrollToTop" aria-label="Revenir en haut" type="button" style="display: none;">↑</button>
    <?php endif; ?>

    <?php wp_footer(); ?>
    </body>

    </html>