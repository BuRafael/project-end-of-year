
<?php
/*
Template Name: Favoris
*/
get_header();
?>
<main class="favoris-page container py-5">
    <h1 class="fw-bold mb-4 text-center">Mes favoris</h1>
    <div id="favorisContent" class="d-flex flex-column align-items-center justify-content-center" style="min-height: 40vh; width:100%;">
        <?php if (!is_user_logged_in()) : ?>
            <div class="alert alert-warning text-center" style="font-size:1.3rem;max-width:500px;">
                Vous devez être connecté ou inscrit pour voir ou ajouter des favoris.<br>
                <a href="/inscription" class="btn btn-primary mt-3">Se connecter / S'inscrire</a>
            </div>
        <?php else : ?>
        <div class="favoris-tabs mb-4 d-flex justify-content-center">
            <button class="favoris-tab active" data-tab="films">Films</button>
            <button class="favoris-tab" data-tab="series">Séries</button>
            <button class="favoris-tab" data-tab="musiques">Musique</button>
        </div>
        <div class="favoris-contents w-100" style="max-width:900px;">
            <div id="filmsContent" class="favoris-content active">
                <div id="filmsGrid" class="favoris-grid"></div>
                <div id="filmsEmpty" class="favoris-empty text-center mt-4" style="display:none; font-size:1.2rem;">Vous n'avez pas encore de films favoris :(</div>
            </div>
            <div id="seriesContent" class="favoris-content">
                <div id="seriesGrid" class="favoris-grid"></div>
                <div id="seriesEmpty" class="favoris-empty text-center mt-4" style="display:none; font-size:1.2rem;">Vous n'avez pas encore de séries favorites :(</div>
            </div>
            <div id="musiquesContent" class="favoris-content">
                <div id="musiquesList" class="favoris-list"></div>
                <div id="musiquesEmpty" class="favoris-empty text-center mt-4" style="display:none; font-size:1.2rem;">Vous n'avez pas encore de musiques favorites :(</div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
