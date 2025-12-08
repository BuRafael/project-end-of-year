<?php
get_header();
?>

<main>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <h1>
                Trouvez la musique de vos films<br>
                et séries préférées&nbsp;!
            </h1>

            <div class="search-bar">
                <input type="text" placeholder="Rechercher...">
                <button class="search-btn">
                    <span class="search-icon">🔍</span>
                </button>
            </div>
        </div>
    </section>

    <!-- CARROUSEL -->
    <section class="carousel-section">
        <div class="carousel">
            <button class="carousel-arrow left">&#10094;</button>

            <div class="carousel-image-wrapper">
                <img src="<?php echo get_template_directory_uri(); ?>/img/inception-banner.jpg" alt="Inception" class="carousel-image">
                <img src="<?php echo get_template_directory_uri(); ?>/img/carousel-2.jpg" alt="Carousel 2" class="carousel-image">
                <img src="<?php echo get_template_directory_uri(); ?>/img/carousel-3.jpg" alt="Carousel 3" class="carousel-image">
            </div>

            <button class="carousel-arrow right">&#10095;</button>
        </div>

        <div class="carousel-dots">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </section>

    <!-- QUI SOMMES-NOUS -->
    <section class="about">
        <h2>Qui sommes-nous ?</h2>

        <div class="about-columns">
            <div class="about-col">
                <p>
                    Ce site réunit les bandes<br>
                    originales de milliers de films<br>
                    et séries pour les retrouver<br>
                    facilement en un instant.
                </p>
            </div>

            <div class="about-col">
                <p>
                    Une plateforme simple pour<br>
                    explorer les musiques qui<br>
                    accompagnent vos films et<br>
                    séries préférés.
                </p>
            </div>

            <div class="about-col">
                <p>
                    Un espace pensé pour<br>
                    découvrir, écouter et<br>
                    sauvegarder toutes les<br>
                    bandes originales qui vous<br>
                    marquent.
                </p>
            </div>
        </div>
    </section>

    <!-- TOP 5 -->
    <section class="top-lists">
        <div class="top-card">
            <h3>Top 5 films</h3>
            <ul>
                <li>
                    <div class="item-left">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/posters/inception.jpg" alt="Inception">
                        <div>
                            <span class="item-title">Inception</span>
                            <span class="item-sub">Christopher Nolan</span>
                        </div>
                    </div>
                    <button class="heart-btn">&#9825;</button>
                </li>
                <!-- ... les autres films pareil avec get_template_directory_uri() ... -->
            </ul>
        </div>

        <div class="top-card">
            <h3>Top 5 séries</h3>
            <ul>
                <li>
                    <div class="item-left">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/posters/strangerthings.jpg" alt="Stranger Things">
                        <div>
                            <span class="item-title">Stranger Things</span>
                            <span class="item-sub">The Duffer Brothers</span>
                        </div>
                    </div>
                    <button class="heart-btn">&#9825;</button>
                </li>
                <!-- ... -->
            </ul>
        </div>

        <div class="top-card">
            <h3>Top 5 musiques</h3>
            <ul>
                <li>
                    <div class="item-left">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/covers/utopia.jpg" alt="Utopia">
                        <div>
                            <span class="item-title">Utopia</span>
                            <span class="item-sub">Travis Scott</span>
                        </div>
                    </div>
                    <button class="heart-btn">&#9825;</button>
                </li>
                <!-- ... -->
            </ul>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <p class="cta-text">
            Ne ratez plus jamais vos bandes originales<br>
            préférées. Rejoignez notre communauté et plongez dans<br>
            l'univers musical de tous vos films et séries favoris&nbsp;!
        </p>
        <button class="btn-primary">S'inscrire</button>
    </section>

</main>

<button class="scroll-top" id="scrollTopBtn">
    ↑
</button>

<?php
get_footer();
?>
