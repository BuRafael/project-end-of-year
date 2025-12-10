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
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/Your name affiche.jpg' ); ?>" alt="Your Name">
                        <span class="slide-title">Your Name</span>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/Stranger things affiche.jpg' ); ?>" alt="Stranger Things">
                        <span class="slide-title">Stranger Things</span>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/affiche interstellar.png' ); ?>" alt="Interstellar">
                        <span class="slide-title">Interstellar</span>
                    </div>
                </div>
            </div>

            <button class="carousel-arrow right" aria-label="Image suivante" type="button">❯</button>

            <div class="carousel-dots">
                <button class="dot active" data-slide="0" type="button" aria-label="Slide 1"></button>
                <button class="dot" data-slide="1" type="button" aria-label="Slide 2"></button>
                <button class="dot" data-slide="2" type="button" aria-label="Slide 3"></button>
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
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/Inception affiche.jpg' ); ?>" alt="Inception">
                    <div class="top-info">
                        <span class="top-title">Inception</span>
                        <span class="top-sub">Christopher Nolan</span>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/affiche lalaland.jpg' ); ?>" alt="La La Land">
                    <div class="top-info">
                        <span class="top-title">La La Land</span>
                        <span class="top-sub">Damien Chazelle</span>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/affiche Parasite.jpg' ); ?>" alt="Parasite">
                    <div class="top-info">
                        <span class="top-title">Parasite</span>
                        <span class="top-sub">Bong Joon-ho</span>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/affiche interstellar.png' ); ?>" alt="Interstellar">
                    <div class="top-info">
                        <span class="top-title">Interstellar</span>
                        <span class="top-sub">Christopher Nolan</span>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/affiche spiderman.jpg' ); ?>" alt="Spider-Man">
                    <div class="top-info">
                        <span class="top-title">Spider-Man vs</span>
                        <span class="top-sub">Richon Sorairo</span>
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
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/Stranger things affiche.jpg' ); ?>" alt="Stranger Things">
                    <div class="top-info">
                        <span class="top-title">Stranger Things</span>
                        <span class="top-sub">The Duffer Brothers</span>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/Breaking bad affiche.jpg' ); ?>" alt="Breaking Bad">
                    <div class="top-info">
                        <span class="top-title">Breaking Bad</span>
                        <span class="top-sub">Vince Gilligan</span>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/Euphoria affiche.jpg' ); ?>" alt="Euphoria">
                    <div class="top-info">
                        <span class="top-title">Euphoria</span>
                        <span class="top-sub">Sam Levinson</span>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/Mercredi affiche.jpg' ); ?>" alt="Mercredi">
                    <div class="top-info">
                        <span class="top-title">Mercredi</span>
                        <span class="top-sub">Tim Burton</span>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/The witcher affiche.jpg' ); ?>" alt="The Witcher">
                    <div class="top-info">
                        <span class="top-title">The Witcher</span>
                        <span class="top-sub">Lauren Schmidt Hissrich</span>
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
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/Your name affiche.jpg' ); ?>" alt="Your Name">
                    <div class="top-info">
                        <span class="top-title">Your Name</span>
                        <span class="top-sub">Makoto Shinkai</span>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/Chihiro affiche.jpg' ); ?>" alt="Chihiro">
                    <div class="top-info">
                        <span class="top-title">Chihiro</span>
                        <span class="top-sub">Hayao Miyazaki</span>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/attaques des titans affiche.png' ); ?>" alt="Attaque des Titans">
                    <div class="top-info">
                        <span class="top-title">Attaque des Titans</span>
                        <span class="top-sub">Hajime Isayama</span>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/Demon slayer affiche.jpg' ); ?>" alt="Demon Slayer">
                    <div class="top-info">
                        <span class="top-title">Demon Slayer</span>
                        <span class="top-sub">Koyoharu Gotouge</span>
                    </div>
                    <button class="like-btn" data-liked="false" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Imagefrontpage/Image/jujutsu kaisen affiche.jpg' ); ?>" alt="Jujutsu Kaisen">
                    <div class="top-info">
                        <span class="top-title">Jujutsu Kaisen</span>
                        <span class="top-sub">Gege Akutami</span>
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
            <button class="cta-btn" type="button">S'inscrire</button>
        </div>
    </section>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop" aria-label="Revenir en haut" type="button" style="display: none;">↑</button>

</main>

<?php
get_footer();
?>
