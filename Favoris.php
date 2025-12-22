<?php
/**
 * Template Name: Favoris
 * Template Post Type: page
 * Description: Page des favoris de l'utilisateur
 */

get_header();
?>

<main class="favoris-page container">
    <div class="favoris-header">
        <h1 class="favoris-title">Favoris</h1>
        <p class="favoris-subtitle">Retrouvez tous vos films, séries et musiques préférés en un seul endroit</p>
    </div>

    <!-- Tabs Navigation -->
    <div class="favoris-tabs">
        <button class="favoris-tab active" data-tab="musiques">Musiques</button>
        <button class="favoris-tab" data-tab="films">Films</button>
        <button class="favoris-tab" data-tab="series">Séries</button>
    </div>

    <div class="favoris-divider"></div>

    <!-- Musiques Tab Content -->
    <div class="favoris-content active" id="musiquesContent">
        <div class="favoris-tracks-list" id="musiquesList">
            <!-- Les pistes favorites seront insérées ici par JS -->
        </div>
        
        <!-- État vide -->
        <div class="favoris-empty" id="musiquesEmpty">
            <p class="empty-message">Vous n'avez pas encore de favoris :(</p>
        </div>
    </div>

    <!-- Films Tab Content -->
    <div class="favoris-content" id="filmsContent">
        <div class="favoris-grid" id="filmsGrid">
            <!-- Les films favoris seront insérés ici par JS -->
        </div>
        
        <!-- État vide -->
        <div class="favoris-empty" id="filmsEmpty">
            <p class="empty-message">Vous n'avez pas encore de favoris :(</p>
        </div>
    </div>

    <!-- Séries Tab Content -->
    <div class="favoris-content" id="seriesContent">
        <div class="favoris-grid" id="seriesGrid">
            <!-- Les séries favorites seront insérées ici par JS -->
        </div>
        
        <!-- État vide -->
        <div class="favoris-empty" id="seriesEmpty">
            <p class="empty-message">Vous n'avez pas encore de favoris :(</p>
        </div>
    </div>
</main>

get_footer();
?>