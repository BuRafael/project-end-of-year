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
                <span class="search-icon" aria-hidden="true" style="display: flex; align-items: center;">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="2"/>
                        <line x1="15.4142" y1="15" x2="20" y2="19.5858" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
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
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/your name.jpg' ); ?>" alt="Your Name">
                        <div class="slide-content">
                            <span class="slide-title">Your Name</span>
                            <a href="<?php echo esc_url(home_url('/fiche-film/your-name')); ?>" class="btn-voir">Découvrir</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Stranger Things.jpg' ); ?>" alt="Stranger Things">
                        <div class="slide-content">
                            <span class="slide-title">Stranger Things</span>
                            <a href="<?php echo esc_url(home_url('/fiche-serie/stranger-things')); ?>" class="btn-voir">Découvrir</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Spirited away bannière.jpg' ); ?>" alt="Spirited Away">
                        <div class="slide-content">
                            <span class="slide-title">Spirited Away</span>
                            <a href="<?php echo esc_url(home_url('/fiche-film/spirited-away')); ?>" class="btn-voir">Découvrir</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Wicked.jpg' ); ?>" alt="Wicked">
                        <div class="slide-content">
                            <span class="slide-title">Wicked</span>
                            <a href="<?php echo esc_url(home_url('/fiche-film/wicked')); ?>" class="btn-voir">Découvrir</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Attaque des titans.jpg' ); ?>" alt="L'Attaque des Titans">
                        <div class="slide-content">
                            <span class="slide-title">L'Attaque des Titans</span>
                            <a href="<?php echo esc_url(home_url('/attack-on-titan')); ?>" class="btn-voir">Découvrir</a>
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

    <!-- STATISTIQUES Section (mise en avant) -->
    <section class="front-stats section-animated">
      <div class="front-stats__item">
        <span class="front-stats__icon"><i class="bi bi-music-note-beamed"></i></span>
        <span class="front-stats__number" data-animate-number="1200">+1200</span>
        <span class="front-stats__label">Bandes originales référencées</span>
      </div>
      <div class="front-stats__item">
        <span class="front-stats__icon"><i class="bi bi-person-video3"></i></span>
        <span class="front-stats__number" data-animate-number="350">+350</span>
        <span class="front-stats__label">Compositeurs</span>
      </div>
      <div class="front-stats__item">
        <span class="front-stats__icon"><i class="bi bi-people"></i></span>
        <span class="front-stats__number" data-animate-number="5000">+5000</span>
        <span class="front-stats__label">Utilisateurs</span>
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
                    <button class="like-btn" data-liked="false" data-type="film" data-poster="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Fiche films/inception affiche film.jpg' ); ?>" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/La La Land.jpg' ); ?>" alt="La La Land">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/la-la-land')); ?>" class="top-title-link">La La Land</a>
                        <a href="<?php echo esc_url(home_url('/la-la-land')); ?>" class="top-composer-link">Damien Chazelle</a>
                    </div>
                    <button class="like-btn" data-liked="false" data-type="film" data-poster="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Fiche films/La La Land.jpg' ); ?>" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Parasite.jpg' ); ?>" alt="Parasite">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/parasite')); ?>" class="top-title-link">Parasite</a>
                        <a href="<?php echo esc_url(home_url('/parasite')); ?>" class="top-composer-link">Bong Joon-ho</a>
                    </div>
                    <button class="like-btn" data-liked="false" data-type="film" data-poster="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Fiche films/Parasite.jpg' ); ?>" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Interstellar.jpg' ); ?>" alt="Interstellar">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/interstellar')); ?>" class="top-title-link">Interstellar</a>
                        <a href="<?php echo esc_url(home_url('/interstellar')); ?>" class="top-composer-link">Christopher Nolan</a>
                    </div>
                    <button class="like-btn" data-liked="false" data-type="film" data-poster="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Fiche films/Interstellar.jpg' ); ?>" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Arrival.webp' ); ?>" alt="Arrival">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/arrival')); ?>" class="top-title-link">Arrival</a>
                        <a href="<?php echo esc_url(home_url('/arrival')); ?>" class="top-composer-link">Denis Villeneuve</a>
                    </div>
                    <button class="like-btn" data-liked="false" data-type="film" data-poster="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Fiche films/Arrival.webp' ); ?>" type="button" aria-label="Like">♡</button>
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
                    <button class="like-btn" data-liked="false" data-type="serie" data-poster="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Fiche série/Stranger Things2.jpg' ); ?>" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/breaking bad.webp' ); ?>" alt="Breaking Bad">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/breaking-bad')); ?>" class="top-title-link">Breaking Bad</a>
                        <a href="<?php echo esc_url(home_url('/breaking-bad')); ?>" class="top-composer-link">Vince Gilligan</a>
                    </div>
                    <button class="like-btn" data-liked="false" data-type="serie" data-poster="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Fiche série/breaking bad.webp' ); ?>" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/euphoria.jpg' ); ?>" alt="Euphoria">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/euphoria')); ?>" class="top-title-link">Euphoria</a>
                        <a href="<?php echo esc_url(home_url('/euphoria')); ?>" class="top-composer-link">Sam Levinson</a>
                    </div>
                    <button class="like-btn" data-liked="false" data-type="serie" data-poster="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Fiche série/euphoria.jpg' ); ?>" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/wednesday.jpg' ); ?>" alt="Wednesday">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/wednesday')); ?>" class="top-title-link">Wednesday</a>
                        <a href="<?php echo esc_url(home_url('/wednesday')); ?>" class="top-composer-link">Tim Burton</a>
                    </div>
                    <button class="like-btn" data-liked="false" data-type="serie" data-poster="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Fiche série/wednesday.jpg' ); ?>" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/the witcher.webp' ); ?>" alt="The Witcher">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/the-witcher')); ?>" class="top-title-link">The Witcher</a>
                        <a href="<?php echo esc_url(home_url('/the-witcher')); ?>" class="top-composer-link">Lauren Schmidt Hissrich</a>
                    </div>
                    <button class="like-btn" data-liked="false" data-type="serie" data-poster="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Fiche série/the witcher.webp' ); ?>" type="button" aria-label="Like">♡</button>
                </li>
            </ul>
        </div>

        <!-- TOP 5 ANIMES -->
        <div class="top-card">
            <div class="top-header">Top 5 animés</div>
            <ul class="top-list">
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/your name.jpg' ); ?>" alt="Your Name">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/your-name')); ?>" class="top-title-link">Your Name</a>
                        <a href="<?php echo esc_url(home_url('/your-name')); ?>" class="top-composer-link">Makoto Shinkai</a>
                    </div>
                    <button class="like-btn" data-liked="false" data-type="film" data-poster="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Fiche films/your name.jpg' ); ?>" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/chihiro.jpg' ); ?>" alt="Spirited Away">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/spirited-away')); ?>" class="top-title-link">Spirited Away</a>
                        <a href="<?php echo esc_url(home_url('/spirited-away')); ?>" class="top-composer-link">Hayao Miyazaki</a>
                    </div>
                    <button class="like-btn" data-liked="false" data-type="film" data-poster="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Fiche films/chihiro.jpg' ); ?>" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/attack on titan.jpg' ); ?>" alt="Attack on Titan">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/attack-on-titan')); ?>" class="top-title-link">Attack on Titan</a>
                        <a href="<?php echo esc_url(home_url('/attack-on-titan')); ?>" class="top-composer-link">Hajime Isayama</a>
                    </div>
                    <button class="like-btn" data-liked="false" data-type="serie" data-poster="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Fiche série/attack on titan.jpg' ); ?>" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/demon slayer.jpg' ); ?>" alt="Demon Slayer">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/demon-slayer')); ?>" class="top-title-link">Demon Slayer</a>
                        <a href="<?php echo esc_url(home_url('/demon-slayer')); ?>" class="top-composer-link">Koyoharu Gotouge</a>
                    </div>
                    <button class="like-btn" data-liked="false" data-type="film" data-poster="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Fiche série/demon slayer.jpg' ); ?>" type="button" aria-label="Like">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/jujutsu kaisen.jpg' ); ?>" alt="Jujutsu Kaisen">
                    <div class="top-info">
                        <a href="<?php echo esc_url(home_url('/jujutsu-kaisen')); ?>" class="top-title-link">Jujutsu Kaisen</a>
                        <a href="<?php echo esc_url(home_url('/jujutsu-kaisen')); ?>" class="top-composer-link">Gege Akutami</a>
                    </div>
                    <button class="like-btn" data-liked="false" data-type="film" data-poster="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Fiche série/jujutsu kaisen.jpg' ); ?>" type="button" aria-label="Like">♡</button>
                </li>
            </ul>
        </div>
    </section>



    <!-- CTA Section (Call To Action) -->
    <section class="cta-section section-animated">
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

        <script>
        // Animation au scroll pour .section-animated
        document.addEventListener('DOMContentLoaded', function() {
            const animatedSections = document.querySelectorAll('.section-animated');
            function revealSections() {
                animatedSections.forEach(section => {
                    const rect = section.getBoundingClientRect();
                    if(rect.top < window.innerHeight - 100) {
                        section.classList.add('visible');
                    }
                });
            }
            window.addEventListener('scroll', revealSections);
            revealSections();
        });
        </script>

</main>

<?php
get_footer();
?>
