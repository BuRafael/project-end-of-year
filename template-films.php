<?php
/**
 * Template Name: Films
 * Template Post Type: page
 * Description: Page listant tous les films par genre
 */

get_header();
?>

<main class="movies-page container py-5">
    <h1 class="text-center mb-5">Tous les Films</h1>

    <?php
    $genres = array('Action', 'Comédie', 'Drame', 'Science-Fiction', 'Horreur', 'Romance');
    
    // Récupérer tous les films depuis la base de données
    global $wpdb;
    $table_name = $wpdb->prefix . 'movies';
    $all_movies = $wpdb->get_results("SELECT * FROM $table_name WHERE type = 'film'", ARRAY_A);
    
    foreach ($genres as $genre) :
        // Filtrer les films par genre
        $genre_movies = array_filter($all_movies, function($movie) use ($genre) {
            return $movie['genre'] === $genre;
        });
    ?>
        <section class="movies-section mb-5">
            <h2 class="section-title mb-4"><?php echo esc_html($genre); ?></h2>
            
            <div class="movies-carousel" data-type="film" data-genre="<?php echo esc_attr($genre); ?>">
                <button class="carousel-arrow left" aria-label="Précédent">❮</button>
                
                <div class="carousel-viewport">
                    <div class="carousel-track" id="carousel-film-<?php echo strtolower(str_replace('-', '', $genre)); ?>">
                        <?php foreach ($genre_movies as $movie) : ?>
                            <div class="carousel-card">
                                <div class="movie-card">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/image/Films/' . $movie['affiche']); ?>" 
                                         alt="<?php echo esc_attr($movie['title']); ?>" 
                                         class="movie-card-img">
                                    <div class="movie-card-title"><?php echo esc_html($movie['title']); ?></div>
                                    <div class="movie-card-year"><?php echo esc_html($movie['year']); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <button class="carousel-arrow right" aria-label="Suivant">❯</button>
            </div>
        </section>
    <?php endforeach; ?>

</main>

<?php get_footer(); ?>
