<?php
get_header();
?>

<main class="home-container">

    <!-- HERO Section -->
    <section class="hero">
        <h1>Trouvez la musique de vos films<br>et séries préférées&nbsp;!</h1>

        <div class="search-bar">
            <input type="text" placeholder="Rechercher…">
            <button class="search-btn" type="button">
                <span class="search-icon">🔍</span>
            </button>
        </div>
    </section>

    <!-- CAROUSEL Section -->
    <section class="carousel-section">
        <div class="carousel-wrapper">
            <button class="carousel-arrow left" aria-label="Image précédente" type="button">❮</button>

            <div class="carousel-viewport">
                <div class="carousel-track">
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Kimi no na wa.webp' ); ?>" alt="Your Name">
                        <div class="slide-content">
                            <span class="slide-title">Your Name</span>
                            <a href="<?php echo esc_url(home_url('/your-name')); ?>" class="btn-voir">Découvrir</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Stranger Things.jpg' ); ?>" alt="Stranger Things">
                        <div class="slide-content">
                            <span class="slide-title">Stranger Things</span>
                            <a href="<?php echo esc_url(home_url('/stranger-things')); ?>" class="btn-voir">Découvrir</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Inception bannière.jpg' ); ?>" alt="Inception">
                        <div class="slide-content">
                            <span class="slide-title">Inception</span>
                            <a href="<?php echo esc_url(home_url('/inception')); ?>" class="btn-voir">Découvrir</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Wicked.jpg' ); ?>" alt="Wicked">
                        <div class="slide-content">
                            <span class="slide-title">Wicked</span>
                            <a href="<?php echo esc_url(home_url('/wicked')); ?>" class="btn-voir">Découvrir</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Attaque des Titans.jpg' ); ?>" alt="L'Attaque des Titans">
                        <div class="slide-content">
                            <span class="slide-title">L'Attaque des Titans</span>
                            <a href="<?php echo esc_url(home_url('/attaque-des-titans')); ?>" class="btn-voir">Découvrir</a>
                        </div>
                    </div>
                </div>
            </div>

            <button class="carousel-arrow right" aria-label="Image suivante" type="button">❯</button>

            <div class="carousel-dots">
                <button class="dot active" data-slide="0" type="button" aria-label="Slide 1"></button>
                <button class="dot" data-slide="1" type="button" aria-label="Slide 2"></button>
                <button class="dot" data-slide="2" type="button" aria-label="Slide 3"></button>
                <button class="dot" data-slide="3" type="button" aria-label="Slide 4"></button>
                <button class="dot" data-slide="4" type="button" aria-label="Slide 5"></button>
            </div>
        </div>
    </section>

    <!-- QUI SOMMES-NOUS? Section -->
    <section class="about-section">
        <h2>Qui sommes-nous ?</h2>

        <div class="about-columns">
            <div class="about-col">
                <p>Ce site réunit les bandes originales de milliers de films et séries pour les retrouver facilement en un instant.</p>
            </div>
            <div class="about-col">
                <p>Une plateforme simple pour explorer les musiques qui accompagnent vos films et séries préférés.</p>
            </div>
            <div class="about-col">
                <p>Un espace pensé pour découvrir, écouter et sauvegarder toutes les bandes originales qui vous marquent.</p>
            </div>
        </div>
    </section>

    <!-- TOP 5 Section -->
    <section class="tops-section">
        <!-- TOP 5 FILMS -->
        <div class="top-card">
            <div class="top-header">Top 5 films</div>
            <ul class="top-list">
                <li>
                    <?php 
                    // Lien vers la page fiche film Inception
                    $inception_page = get_page_by_path('inception');
                    $inception_url = $inception_page ? get_permalink($inception_page->ID) : home_url('/inception/');
                    ?>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Inception.jpg' ); ?>" alt="Inception">
                    <div class="top-info">
                        <a href="<?php echo esc_url($inception_url); ?>" class="top-title-link">Inception</a>
                        <a href="<?php echo esc_url($inception_url); ?>" class="top-composer-link">Christopher Nolan</a>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/La La Land.jpg' ); ?>" alt="La La Land">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/la-la-land')); ?>" class="top-title-link">La La Land</a>
                        <a href="<?php echo esc_url(home_url('/la-la-land')); ?>" class="top-composer-link">Damien Chazelle</a>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Parasite.jpg' ); ?>" alt="Parasite">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-title-link">Parasite</a>
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-composer-link">Bong Joon-ho</a>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Interstellar.png' ); ?>" alt="Interstellar">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-title-link">Interstellar</a>
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-composer-link">Christopher Nolan</a>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Spiderman.jpg' ); ?>" alt="Spider-Man">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-title-link">Spider-Man vs</a>
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-composer-link">Richon Sorairo</a>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
            </ul>
        </div>

        <!-- TOP 5 SERIES -->
        <div class="top-card">
            <div class="top-header">Top 5 séries</div>
            <ul class="top-list">
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Stranger Things.jpg' ); ?>" alt="Stranger Things">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/stranger-things')); ?>" class="top-title-link">Stranger Things</a>
                        <a href="<?php echo esc_url(home_url('/stranger-things')); ?>" class="top-composer-link">The Duffer Brothers</a>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Breaking Bad.jpg' ); ?>" alt="Breaking Bad">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-title-link">Breaking Bad</a>
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-composer-link">Vince Gilligan</a>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Euphoria.jpg' ); ?>" alt="Euphoria">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-title-link">Euphoria</a>
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-composer-link">Sam Levinson</a>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Wednesday.jpg' ); ?>" alt="Wednesday">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-title-link">Wednesday</a>
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-composer-link">Tim Burton</a>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/The Witcher.jpg' ); ?>" alt="The Witcher">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-title-link">The Witcher</a>
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-composer-link">Lauren Schmidt Hissrich</a>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
            </ul>
        </div>

        <!-- TOP 5 ANIMES -->
        <div class="top-card">
            <div class="top-header">Top 5 animés</div>
            <ul class="top-list">
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Kimi no na wa.webp' ); ?>" alt="Your Name">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-title-link">Your Name</a>
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-composer-link">Makoto Shinkai</a>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Chihiro.jpg' ); ?>" alt="Le Voyage de Chihiro">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-title-link">Le Voyage de Chihiro</a>
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-composer-link">Hayao Miyazaki</a>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/SNK.png' ); ?>" alt="L'Attaque des Titans">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-title-link">L'Attaque des Titans</a>
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-composer-link">Hajime Isayama</a>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Demon Slayer.jpg' ); ?>" alt="Demon Slayer">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-title-link">Demon Slayer</a>
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-composer-link">Koyoharu Gotouge</a>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/JJK.jpg' ); ?>" alt="Jujutsu Kaisen">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-title-link">Jujutsu Kaisen</a>
                        <a href="<?php echo esc_url(home_url('/inception')); ?>" class="top-composer-link">Gege Akutami</a>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
            </ul>
        </div>
    </section>

    <!-- CTA Section (Call To Action) -->
    <section class="cta-section">
        <div class="cta-text">
            <p>
                Ne ratez plus jamais vos bandes originales préférées.<br>
                Rejoignez notre communauté et plongez dans<br>
                l'univers musical de tous vos films et séries favoris !
            </p>
            <?php if (!is_user_logged_in()) : ?>
                <?php echo cinemusic_signup_button(); ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop" aria-label="Revenir en haut" type="button" style="display: none;">↑</button>

</main>

<?php
get_footer();
?>
