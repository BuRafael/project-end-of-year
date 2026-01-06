        <!-- Scroll to Top Button -->
        <button class="scroll-to-top" id="scrollToTop" aria-label="Remonter en haut" type="button" style="display: none;">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polyline class="scroll-arrow" points="7,17 14,10 21,17" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>
        </button>
<script>
// Affiche le bouton au scroll et remonte en haut au clic
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('scrollToTop');
    window.addEventListener('scroll', function() {
        btn.style.display = window.scrollY > 200 ? 'flex' : 'none';
    });
    btn.addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
</script>
<?php
get_header();
?>

<main class="home-container">

    <!-- HERO Section -->
    <section class="hero">
        <h1>Trouvez la musique de vos films<br>et séries préférées&nbsp;!</h1>

        <!-- Version desktop : barre de recherche -->
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
        <!-- Version mobile : bouton S'inscrire -->
        <?php if ( !is_user_logged_in() ) : ?>
        <div class="hero-register-btn-mobile" style="display: none; justify-content: center; margin-top: 24px;">
            <a href="<?php echo esc_url( home_url('/register') ); ?>" class="btn-register-front" style="padding: 14px 32px; font-size: 1.2rem; border-radius: 32px; background: #700118; color: #fff; text-decoration: none; font-weight: bold; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: background 0.2s;">S'inscrire</a>
        </div>
        <?php endif; ?>
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


    <!-- TOP 5 Section -->
    <section class="tops-section">
        <!-- TOP 5 FILMS -->
        <div class="top-card">
            <div class="top-header">Top 5 films</div>
            <ul class="top-list">
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/inception.jpg' ); ?>" alt="Inception">
                    <div class="top-info">
                        <a href="<?php echo esc_url( home_url('/fiche-film/inception') ); ?>" class="top-title-link">Inception</a>
                        <a href="<?php echo esc_url( home_url('/fiche-film/inception') ); ?>" class="top-composer-link">Christopher Nolan</a>
                    </div>
                    <?php $inception = get_page_by_path('inception', OBJECT, 'films'); ?>
                        <button class="like-btn movie-like-btn" data-liked="false" data-type="films" <?php if($inception) echo 'data-id="inception"'; ?> type="button" aria-label="Like">
                        <svg class="svg-heart-main" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true" focusable="false">
                            <path class="svg-heart-shape" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/La La Land.jpg' ); ?>" alt="La La Land">
                    <div class="top-info">
                        <a href="<?php echo esc_url( home_url('/fiche-film/la-la-land') ); ?>" class="top-title-link">La La Land</a>
                        <a href="<?php echo esc_url( home_url('/fiche-film/la-la-land') ); ?>" class="top-composer-link">Damien Chazelle</a>
                    </div>
                    <?php $lalaland = get_page_by_path('la-la-land', OBJECT, 'films'); ?>
                        <button class="like-btn movie-like-btn" data-liked="false" data-type="films" <?php if($lalaland) echo 'data-id="la-la-land"'; ?> type="button" aria-label="Like">
                        <svg class="svg-heart-main" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true" focusable="false">
                            <path class="svg-heart-shape" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/parasite.jpg' ); ?>" alt="Parasite">
                    <div class="top-info">
                        <a href="<?php echo esc_url( home_url('/fiche-film/parasite') ); ?>" class="top-title-link">Parasite</a>
                        <a href="<?php echo esc_url( home_url('/fiche-film/parasite') ); ?>" class="top-composer-link">Bong Joon-ho</a>
                    </div>
                    <?php $parasite = get_page_by_path('parasite', OBJECT, 'films'); ?>
                        <button class="like-btn movie-like-btn" data-liked="false" data-type="films" <?php if($parasite) echo 'data-id="parasite"'; ?> type="button" aria-label="Like">
                        <svg class="svg-heart-main" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true" focusable="false">
                            <path class="svg-heart-shape" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/interstellar.jpg' ); ?>" alt="Interstellar">
                    <div class="top-info">
                        <a href="<?php echo esc_url( home_url('/fiche-film/interstellar') ); ?>" class="top-title-link">Interstellar</a>
                        <a href="<?php echo esc_url( home_url('/fiche-film/interstellar') ); ?>" class="top-composer-link">Christopher Nolan</a>
                    </div>
                    <?php $interstellar = get_page_by_path('interstellar', OBJECT, 'films'); ?>
                        <button class="like-btn movie-like-btn" data-liked="false" data-type="films" <?php if($interstellar) echo 'data-id="interstellar"'; ?> type="button" aria-label="Like">
                        <svg class="svg-heart-main" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true" focusable="false">
                            <path class="svg-heart-shape" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Arrival.webp' ); ?>" alt="Arrival">
                    <div class="top-info">
                        <a href="<?php echo esc_url( home_url('/fiche-film/arrival') ); ?>" class="top-title-link">Arrival</a>
                        <a href="<?php echo esc_url( home_url('/fiche-film/arrival') ); ?>" class="top-composer-link">Denis Villeneuve</a>
                    </div>
                    <?php $arrival = get_page_by_path('arrival', OBJECT, 'films'); ?>
                        <button class="like-btn movie-like-btn" data-liked="false" data-type="films" <?php if($arrival) echo 'data-id="arrival"'; ?> type="button" aria-label="Like">
                        <svg class="svg-heart-main" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true" focusable="false">
                            <path class="svg-heart-shape" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </li>
            </ul>
            </ul>
        </div>

        <!-- TOP 5 SERIES -->
         <div class="top-card">
            <div class="top-header">Top 5 series</div>
            <ul class="top-list">
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/Stranger Things.jpg' ); ?>" alt="Stranger Things">
                    <div class="top-info">
                        <a href="<?php echo esc_url( home_url('/fiche-serie/stranger-things') ); ?>" class="top-title-link">Stranger Things</a>
                        <a href="<?php echo esc_url( home_url('/fiche-serie/stranger-things') ); ?>" class="top-composer-link">Duffer Brothers</a>
                    </div>
                        <button class="like-btn movie-like-btn" data-liked="false" data-type="series" data-id="stranger-things" type="button" aria-label="Like">
                        <svg class="svg-heart-main" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true" focusable="false">
                            <path class="svg-heart-shape" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/breaking bad.webp' ); ?>" alt="Breaking Bad">
                    <div class="top-info">
                        <a href="<?php echo esc_url( home_url('/fiche-serie/breaking-bad') ); ?>" class="top-title-link">Breaking Bad</a>
                        <a href="<?php echo esc_url( home_url('/fiche-serie/breaking-bad') ); ?>" class="top-composer-link">Vince Gilligan</a>
                    </div>
                        <button class="like-btn movie-like-btn" data-liked="false" data-type="series" data-id="breaking-bad" type="button" aria-label="Like">
                        <svg class="svg-heart-main" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true" focusable="false">
                            <path class="svg-heart-shape" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/euphoria.jpg' ); ?>" alt="Euphoria">
                    <div class="top-info">
                        <a href="<?php echo esc_url( home_url('/fiche-serie/euphoria') ); ?>" class="top-title-link">Euphoria</a>
                        <a href="<?php echo esc_url( home_url('/fiche-serie/euphoria') ); ?>" class="top-composer-link">Sam Levinson</a>
                    </div>
                        <button class="like-btn movie-like-btn" data-liked="false" data-type="series" data-id="euphoria" type="button" aria-label="Like">
                        <svg class="svg-heart-main" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true" focusable="false">
                            <path class="svg-heart-shape" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/wednesday.jpg' ); ?>" alt="Wednesday">
                    <div class="top-info">
                        <a href="<?php echo esc_url( home_url('/fiche-serie/wednesday') ); ?>" class="top-title-link">Wednesday</a>
                        <a href="<?php echo esc_url( home_url('/fiche-serie/wednesday') ); ?>" class="top-composer-link">Tim Burton</a>
                    </div>
                        <button class="like-btn movie-like-btn" data-liked="false" data-type="series" data-id="wednesday" type="button" aria-label="Like">
                        <svg class="svg-heart-main" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true" focusable="false">
                            <path class="svg-heart-shape" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/the witcher.webp' ); ?>" alt="The Witcher">
                    <div class="top-info">
                        <a href="<?php echo esc_url( home_url('/fiche-serie/the-witcher') ); ?>" class="top-title-link">The Witcher</a>
                        <a href="<?php echo esc_url( home_url('/fiche-serie/the-witcher') ); ?>" class="top-composer-link">Lauren Schmidt Hissrich</a>
                    </div>
                        <button class="like-btn movie-like-btn" data-liked="false" data-type="series" data-id="the-witcher" type="button" aria-label="Like">
                        <svg class="svg-heart-main" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true" focusable="false">
                            <path class="svg-heart-shape" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </li>
            </ul>
        </div>

        <!-- TOP 5 ANIMES -->
                 <div class="top-card">
            <div class="top-header">Top 5 anime</div>
            <ul class="top-list">
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/your name.jpg' ); ?>" alt="Your Name">
                    <div class="top-info">
                        <a href="<?php echo esc_url( home_url('/fiche-film/your-name') ); ?>" class="top-title-link">Your Name</a>
                        <a href="<?php echo esc_url( home_url('/fiche-film/your-name') ); ?>" class="top-composer-link">Makoto Shinkai</a>
                    </div>
                    <button class="like-btn movie-like-btn" data-liked="false" data-type="series" data-id="your-name" type="button" aria-label="Like">
                        <svg class="svg-heart-main" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true" focusable="false">
                            <path class="svg-heart-shape" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/chihiro.jpg' ); ?>" alt="Spirited Away">
                    <div class="top-info">
                        <a href="<?php echo esc_url( home_url('/fiche-film/spirited-away') ); ?>" class="top-title-link">Spirited Away</a>
                        <a href="<?php echo esc_url( home_url('/fiche-film/spirited-away') ); ?>" class="top-composer-link">Hayao Miyazaki</a>
                    </div>
                    <button class="like-btn movie-like-btn" data-liked="false" data-type="series" data-id="spirited-away" type="button" aria-label="Like">
                        <svg class="svg-heart-main" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true" focusable="false">
                            <path class="svg-heart-shape" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/attack on titan.jpg' ); ?>" alt="Attack on Titan">
                    <div class="top-info">
                        <a href="<?php echo esc_url( home_url('/fiche-anime/attack-on-titan') ); ?>" class="top-title-link">Attack on Titan</a>
                        <a href="<?php echo esc_url( home_url('/fiche-anime/attack-on-titan') ); ?>" class="top-composer-link">Hajime Isayama</a>
                    </div>
                    <button class="like-btn movie-like-btn" data-liked="false" data-type="series" data-id="attack-on-titan" type="button" aria-label="Like">
                        <svg class="svg-heart-main" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true" focusable="false">
                            <path class="svg-heart-shape" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/demon slayer.jpg' ); ?>" alt="Demon Slayer">
                    <div class="top-info">
                        <a href="<?php echo esc_url( home_url('/fiche-anime/demon-slayer') ); ?>" class="top-title-link">Demon Slayer</a>
                        <a href="<?php echo esc_url( home_url('/fiche-anime/demon-slayer') ); ?>" class="top-composer-link">Koyoharu Gotouge</a>
                    </div>
                    <button class="like-btn movie-like-btn" data-liked="false" data-type="series" data-id="demon-slayer" type="button" aria-label="Like">
                        <svg class="svg-heart-main" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true" focusable="false">
                            <path class="svg-heart-shape" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/image/Front Page/jujutsu kaisen.jpg' ); ?>" alt="Jujutsu Kaisen">
                    <div class="top-info">
                        <a href="<?php echo esc_url( home_url('/fiche-anime/jujutsu-kaisen') ); ?>" class="top-title-link">Jujutsu Kaisen</a>
                        <a href="<?php echo esc_url( home_url('/fiche-anime/jujutsu-kaisen') ); ?>" class="top-composer-link">Gege Akutami</a>
                    </div>
                    <button class="like-btn movie-like-btn" data-liked="false" data-type="series" data-id="jujutsu-kaisen" type="button" aria-label="Like">
                        <svg class="svg-heart-main" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true" focusable="false">
                            <path class="svg-heart-shape" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </li>
            </ul>
        </div>
    </section>








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

<!-- CTA Section (Call To Action) -->


<?php
get_footer();
?>
