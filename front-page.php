<?php
get_header();
?>

<!-- CINEMUSIC - Front Page Template -->

<main class="home-container">

    <!-- HERO -->
    <section class="hero">
        <h1>Trouvez la musique de vos films<br>et séries préférées&nbsp;!</h1>

        <div class="search-bar">
            <input type="text" placeholder="Rechercher…">
            <button class="search-btn">
                <span class="search-icon">🔍</span>
            </button>
        </div>
    </section>

    <!-- CARROUSEL -->
    <section class="carousel-section">
        <div class="carousel-wrapper">
            <button class="carousel-arrow left" aria-label="Image précédente">❮</button>

            <div class="carousel-viewport">
                <div class="carousel-track">
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/your-name.jpg' ); ?>" alt="Your Name">
                        <span class="slide-title">Your Name</span>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/stranger-things.jpg' ); ?>" alt="Stranger Things">
                        <span class="slide-title">Stranger Things</span>
                    </div>
                    <div class="slide">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/interstellar.jpg' ); ?>" alt="Interstellar">
                        <span class="slide-title">Interstellar</span>
                    </div>
                </div>
            </div>

            <button class="carousel-arrow right" aria-label="Image suivante">❯</button>
        </div>

        <div class="carousel-dots">
            <button class="dot active" data-slide="0"></button>
            <button class="dot" data-slide="1"></button>
            <button class="dot" data-slide="2"></button>
        </div>
    </section>

    <!-- QUI SOMMES-NOUS ? -->
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

    <!-- TOP 5 -->
    <section class="tops-section">
        <div class="top-card">
            <div class="top-header">Top 5 films</div>
            <ul class="top-list">
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/inception.jpg' ); ?>" alt="Inception">
                    <div class="top-info">
                        <span class="top-title">Inception</span>
                        <span class="top-sub">Christopher Nolan</span>
                    </div>
                    <button class="like-btn" data-liked="false">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/lalaland.jpg' ); ?>" alt="La La Land">
                    <div class="top-info">
                        <span class="top-title">La La Land</span>
                        <span class="top-sub">Damien Chazelle</span>
                    </div>
                    <button class="like-btn" data-liked="false">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/parasite.jpg' ); ?>" alt="Parasite">
                    <div class="top-info">
                        <span class="top-title">Parasite</span>
                        <span class="top-sub">Bong Joon-ho</span>
                    </div>
                    <button class="like-btn" data-liked="false">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/interstellar.jpg' ); ?>" alt="Interstellar">
                    <div class="top-info">
                        <span class="top-title">Interstellar</span>
                        <span class="top-sub">Christopher Nolan</span>
                    </div>
                    <button class="like-btn" data-liked="false">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/spiderman.jpg' ); ?>" alt="Spider-Man">
                    <div class="top-info">
                        <span class="top-title">Spider-Man vs</span>
                        <span class="top-sub">Richon Sorairo</span>
                    </div>
                    <button class="like-btn" data-liked="false">♡</button>
                </li>
            </ul>
        </div>

        <div class="top-card">
            <div class="top-header">Top 5 séries</div>
            <ul class="top-list">
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/stranger-things.jpg' ); ?>" alt="Stranger Things">
                    <div class="top-info">
                        <span class="top-title">Stranger Things</span>
                        <span class="top-sub">The Duffer Brothers</span>
                    </div>
                    <button class="like-btn" data-liked="false">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/breaking-bad.jpg' ); ?>" alt="Breaking Bad">
                    <div class="top-info">
                        <span class="top-title">Breaking Bad</span>
                        <span class="top-sub">Vince Gilligan</span>
                    </div>
                    <button class="like-btn" data-liked="false">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/euphoria.jpg' ); ?>" alt="Euphoria">
                    <div class="top-info">
                        <span class="top-title">Euphoria</span>
                        <span class="top-sub">Sam Levinson</span>
                    </div>
                    <button class="like-btn" data-liked="false">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/mercredi.jpg' ); ?>" alt="Mercredi">
                    <div class="top-info">
                        <span class="top-title">Mercredi</span>
                        <span class="top-sub">Tim Burton</span>
                    </div>
                    <button class="like-btn" data-liked="false">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/witcher.jpg' ); ?>" alt="The Witcher">
                    <div class="top-info">
                        <span class="top-title">The Witcher</span>
                        <span class="top-sub">Lauren Schmidt Hissrich</span>
                    </div>
                    <button class="like-btn" data-liked="false">♡</button>
                </li>
            </ul>
        </div>

        <div class="top-card">
            <div class="top-header">Top 5 animés</div>
            <ul class="top-list">
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/your-name.jpg' ); ?>" alt="Your Name">
                    <div class="top-info">
                        <span class="top-title">Your Name</span>
                        <span class="top-sub">Makoto Shinkai</span>
                    </div>
                    <button class="like-btn" data-liked="false">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/chihiro.jpg' ); ?>" alt="Chihiro">
                    <div class="top-info">
                        <span class="top-title">Chihiro</span>
                        <span class="top-sub">Hayao Miyazaki</span>
                    </div>
                    <button class="like-btn" data-liked="false">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/attack-on-titan.jpg' ); ?>" alt="Attaque des Titans">
                    <div class="top-info">
                        <span class="top-title">Attaque des Titans</span>
                        <span class="top-sub">Hajime Isayama</span>
                    </div>
                    <button class="like-btn" data-liked="false">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/demon-slayer.jpg' ); ?>" alt="Demon Slayer">
                    <div class="top-info">
                        <span class="top-title">Demon Slayer</span>
                        <span class="top-sub">Koyoharu Gotouge</span>
                    </div>
                    <button class="like-btn" data-liked="false">♡</button>
                </li>
                <li>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/Image/jujutsu-kaisen.jpg' ); ?>" alt="Jujutsu Kaisen">
                    <div class="top-info">
                        <span class="top-title">Jujutsu Kaisen</span>
                        <span class="top-sub">Gege Akutami</span>
                    </div>
                    <button class="like-btn" data-liked="false">♡</button>
                </li>
            </ul>
        </div>
    </section>

    <!-- TEXTE + BOUTON D'INSCRIPTION -->
    <section class="cta-section">
      <div class="cta-text">
        <p>
          Ne ratez plus jamais vos bandes originales préférées.<br>
          Rejoignez notre communauté et plongez dans<br>
          l'univers musical de tous vos films et séries favoris !
        </p>
        <button class="cta-btn">S'inscrire</button>
      </div>
    </section>

    <!-- SCROLL TO TOP -->
    <button class="scroll-to-top" id="scrollToTop" aria-label="Revenir en haut" style="display: none;">↑</button>

</main>

<?php
get_footer();
?>
