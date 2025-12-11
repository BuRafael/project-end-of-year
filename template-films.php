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
    
    foreach ($genres as $genre) :
    ?>
        <section class="movies-section mb-5">
            <h2 class="section-title mb-4"><?php echo esc_html($genre); ?></h2>
            
            <div class="movies-carousel" data-type="film" data-genre="<?php echo esc_attr($genre); ?>">
                <button class="carousel-arrow left" aria-label="Précédent">❮</button>
                
                <div class="carousel-viewport">
                    <div class="carousel-track" id="carousel-film-<?php echo strtolower(str_replace('-', '', $genre)); ?>">
                        <!-- JS insère les films ici -->
                    </div>
                </div>
                
                <button class="carousel-arrow right" aria-label="Suivant">❯</button>
            </div>
        </section>
    <?php endforeach; ?>

</main>

<script>
    // Charger les films par genre
    const genres = ['Action', 'Comédie', 'Drame', 'Science-Fiction', 'Horreur', 'Romance'];
    const moviesImagePath = '<?php echo esc_js(get_template_directory_uri()); ?>/assets/image/Fiche films/';
    
    genres.forEach(genre => {
        fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>?action=get_movies_by_genre&type=film&genre=' + encodeURIComponent(genre))
            .then(res => res.json())
            .then(data => {
                if (data.movies && data.movies.length > 0) {
                    const carouselId = 'carousel-film-' + genre.toLowerCase().replace('-', '');
                    const track = document.getElementById(carouselId);
                    
                    if (track) {
                        data.movies.forEach(movie => {
                            const card = document.createElement('div');
                            card.className = 'carousel-card';
                            card.innerHTML = `
                                <div class="movie-card">
                                    <img src="${moviesImagePath}${movie.affiche}" alt="${movie.title}" class="movie-card-img">
                                    <div class="movie-card-title">${movie.title}</div>
                                    <div class="movie-card-year">${movie.year}</div>
                                </div>
                            `;
                            track.appendChild(card);
                        });
                    }
                }
            });
    });
</script>

<?php get_footer(); ?>
