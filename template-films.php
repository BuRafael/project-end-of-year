<!-- Carrousels genres sous le carrousel Action -->
	<!-- À placer juste après le carrousel Action, dans <main> -->
	<?php // INSÉRER ICI après le carrousel Action dans <main> ?>

<?php
/**
 * Template Name: Films
 * Template Post Type: page
 * Description: Page listant tous les films par genre
 */

get_header();
$media_type = 'film';
$genres = array('Action', 'Comédie', 'Drame', 'Science-Fiction', 'Horreur', 'Romance');
?>
<!-- Import des styles carrousel films -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/page-media-layout.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/Fiche film.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/movies-series.css">
<script>document.addEventListener('DOMContentLoaded',function(){document.body.setAttribute('data-media-type','film');});</script>
<div class="site-container">
	<main>
		<!-- 1. Section À la une -->
		<section class="featured-media">
			<div class="featured-media-inner">
				<div class="featured-a-la-une-text">À la une</div>
				<div class="featured-card">
					<div class="featured-img-wrap">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/wicked.jpg" alt="Wicked" class="featured-affiche-img" style="border-radius:18px;">
					</div>
					<div class="featured-infos-col">
						<h2 class="featured-title">Wicked</h2>
						<div class="featured-meta improved-meta">
							<span class="meta-year">2024</span>
							<span class="meta-dot">•</span>
							<span class="meta-director">Jon M. Chu</span>
							<span class="meta-dot">•</span>
							<span class="meta-duration">2h 15min</span>
							<span class="meta-dot">•</span>
							<span class="meta-genres">Comédie musicale, Fantastique</span>
						</div>
						<div class="featured-synopsis">
							<p>Découvrez l'histoire inédite des sorcières d'Oz, bien avant l'arrivée de Dorothy. Un film musical spectaculaire, adaptation du célèbre show de Broadway, avec Cynthia Erivo et Ariana Grande.</p>
						</div>
						<a href="/wicked" class="btn-main fiche-a-la-une">Découvrir</a>
					</div>
				</div>
			</div>
		</section>

		<!-- 2. Section Tendance du moment (5 éléments) -->
		<section class="trending-media mb-5">
			<h2 class="section-title mb-4">Tendance du moment</h2>
			<div class="trend-list">
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/ne zha 2.jpg" alt="Ne Zha 2">
					<h4>Ne Zha 2</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/lilo & stitch (2025).jpeg" alt="Lilo & Stitch (2025)">
					<h4>Lilo & Stitch (2025)</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/minecraft - the movie.webp" alt="Minecraft – The Movie">
					<h4>Minecraft – The Movie</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/mission impossible the final reckoning.webp" alt="Mission: Impossible – The Final Reckoning">
					<h4>Mission: Impossible – The Final Reckoning</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/f1 (2025).png" alt="F1 (2025)">
					<h4>F1 (2025)</h4>
				</div>
			</div>
		</section>

		<!-- 3. Section Nouveautés (5 éléments) -->
		<section class="new-media mb-5">
			<h2 class="section-title mb-4">Nouveautés</h2>
			<div class="trend-list">
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/the ice tower.jpg" alt="The Ice Tower">
					<h4>The Ice Tower</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/sinners.avif" alt="Sinners">
					<h4>Sinners</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/one battle after another.jpg" alt="One Battle After Another">
					<h4>One Battle After Another</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/the naked gun.webp" alt="The Naked Gun (2025)">
					<h4>The Naked Gun (2025)</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche films/blue moon.jpg" alt="Blue Moon">
					<h4>Blue Moon</h4>
				</div>
			</div>
		</section>

		<!-- 4. Carrousels par genre (Action, Comédie, Horreur, Romance, Science-Fiction) -->
		<!-- Carrousel Action (structure movies-series.css) -->
		<section class="movies-section mt-5 mb-4" style="max-width:1100px;margin:38px auto 0 auto;width:100%;box-sizing:border-box;">
             <h3 class="section-title mb-3">Action</h3>
             <div class="movies-carousel d-flex align-items-center">
            <div style="display: flex; align-items: center; width: 100%;">
                <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>
                <div class="row flex-grow-1 mx-3 g-3" id="carousel-film-action">
				<?php
				global $wpdb;
				$table_name = $wpdb->prefix . 'movies';
				$action_movies = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT * FROM $table_name WHERE genre LIKE %s AND type = %s",
						'%Action%', 'film'
					)
				);
				if (empty($action_movies)) {
					echo '<div style="color:#a0022c;font-size:14px;">DEBUG : Aucun film d\'action trouvé dans la base (table wp_movies, genre=Action, type=film)</div>';
				}
				   $max_display = 4;
				   $i = 0;
				   foreach ($action_movies as $movie) :
					   if ($i >= $max_display) break;
					   $img_path_films = get_template_directory_uri() . '/assets/image/Films/' . esc_attr($movie->affiche);
					   $img_path_fiche = get_template_directory_uri() . '/assets/image/Fiche films/' . esc_attr($movie->affiche);
					   $file_path_films = get_template_directory() . '/assets/image/Films/' . $movie->affiche;
					   $file_path_fiche = get_template_directory() . '/assets/image/Fiche films/' . $movie->affiche;
					   if (file_exists($file_path_films)) {
						   $img_path = $img_path_films;
					   } elseif (file_exists($file_path_fiche)) {
						   $img_path = $img_path_fiche;
					   } else {
						   $img_path = get_template_directory_uri() . '/assets/image/Fiche films/placeholder.jpg';
					   }
				?>
					<div class="col-6 col-md-3">
						<div class="similar-card">
							<img src="<?php echo $img_path; ?>" alt="<?php echo esc_attr($movie->title); ?>">
							<div class="similar-card-title"><?php echo esc_html($movie->title); ?></div>
						</div>
					</div>
				<?php $i++; endforeach; ?>
				</div>
                <button class="carousel-arrow right d-flex align-items-center justify-content-center" type="button">❯</button>
            </div>
		</section>
		<!-- Carrousel Comédie -->
        <section class="movies-section mt-5 mb-4" style="max-width:1100px;margin:38px auto 0 auto;width:100%;box-sizing:border-box;">
               <h3 class="section-title mb-3">Comédie</h3>
               <div class="movies-carousel d-flex align-items-center">
                       <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>
                <div style="display: flex; align-items: center; width: 100%;">
                    <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>
                    <div class="row flex-grow-1 mx-3 g-3" id="carousel-film-comedie">
                <?php
                $max_display = 4;
                $i = 0;
                $comedie_movies = $wpdb->get_results(
                    $wpdb->prepare(
                        "SELECT * FROM $table_name WHERE genre LIKE %s AND type = %s",
                        '%Comédie%', 'film'
                    )
                );
                foreach ($comedie_movies as $movie) :
                    if ($i >= $max_display) break;
                    $img_path_films = get_template_directory_uri() . '/assets/image/Films/' . esc_attr($movie->affiche);
                    $img_path_fiche = get_template_directory_uri() . '/assets/image/Fiche films/' . esc_attr($movie->affiche);
                    $file_path_films = get_template_directory() . '/assets/image/Films/' . $movie->affiche;
                    $file_path_fiche = get_template_directory() . '/assets/image/Fiche films/' . $movie->affiche;
                    if (file_exists($file_path_films)) {
                        $img_path = $img_path_films;
                    } elseif (file_exists($file_path_fiche)) {
                        $img_path = $img_path_fiche;
                    } else {
                        $img_path = get_template_directory_uri() . '/assets/image/Fiche films/placeholder.jpg';
                    }
                ?>
                    <div class="col-6 col-md-3">
                        <div class="similar-card">
                            <img src="<?php echo $img_path; ?>" alt="<?php echo esc_attr($movie->title); ?>">
                            <div class="similar-card-title"><?php echo esc_html($movie->title); ?></div>
                        </div>
                    </div>
                <?php $i++; endforeach; ?>
                </div>
                <button class="carousel-arrow right d-flex align-items-center justify-content-center" type="button">❯</button>
            </div>
        </section>
        <!-- Carrousel Horreur -->
        <section class="movies-section mt-5 mb-4" style="max-width:1100px;margin:38px auto 0 auto;width:100%;box-sizing:border-box;">
               <h3 class="section-title mb-3">Horreur</h3>
               <div class="movies-carousel d-flex align-items-center">
                       <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>
                <div style="display: flex; align-items: center; width: 100%;">
                    <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>
                    <div class="row flex-grow-1 mx-3 g-3" id="carousel-film-horreur">
                <?php
                $max_display = 4;
                $i = 0;
                $horreur_movies = $wpdb->get_results(
                    $wpdb->prepare(
                        "SELECT * FROM $table_name WHERE genre LIKE %s AND type = %s",
                        '%Horreur%', 'film'
                    )
                );
                foreach ($horreur_movies as $movie) :
                    if ($i >= $max_display) break;
                    $img_path_films = get_template_directory_uri() . '/assets/image/Films/' . esc_attr($movie->affiche);
                    $img_path_fiche = get_template_directory_uri() . '/assets/image/Fiche films/' . esc_attr($movie->affiche);
                    $file_path_films = get_template_directory() . '/assets/image/Films/' . $movie->affiche;
                    $file_path_fiche = get_template_directory() . '/assets/image/Fiche films/' . $movie->affiche;
                    if (file_exists($file_path_films)) {
                        $img_path = $img_path_films;
                    } elseif (file_exists($file_path_fiche)) {
                        $img_path = $img_path_fiche;
                    } else {
                        $img_path = get_template_directory_uri() . '/assets/image/Fiche films/placeholder.jpg';
                    }
                ?>
                    <div class="col-6 col-md-3">
                        <div class="similar-card">
                            <img src="<?php echo $img_path; ?>" alt="<?php echo esc_attr($movie->title); ?>">
                            <div class="similar-card-title"><?php echo esc_html($movie->title); ?></div>
                        </div>
                    </div>
                <?php $i++; endforeach; ?>
                </div>
                <button class="carousel-arrow right d-flex align-items-center justify-content-center" type="button">❯</button>
            </div>
        </section>
        <!-- Carrousel Romance -->
        <section class="movies-section mt-5 mb-4" style="max-width:1100px;margin:38px auto 0 auto;width:100%;box-sizing:border-box;">
               <h3 class="section-title mb-3">Romance</h3>
               <div class="movies-carousel d-flex align-items-center">
                       <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>
                <div style="display: flex; align-items: center; width: 100%;">
                    <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>
                    <div class="row flex-grow-1 mx-3 g-3" id="carousel-film-romance">
                <?php
                $max_display = 4;
                $i = 0;
                $romance_movies = $wpdb->get_results(
                    $wpdb->prepare(
                        "SELECT * FROM $table_name WHERE genre LIKE %s AND type = %s",
                        '%Romance%', 'film'
                    )
                );
                foreach ($romance_movies as $movie) :
                    if ($i >= $max_display) break;
                    $img_path_films = get_template_directory_uri() . '/assets/image/Films/' . esc_attr($movie->affiche);
                    $img_path_fiche = get_template_directory_uri() . '/assets/image/Fiche films/' . esc_attr($movie->affiche);
                    $file_path_films = get_template_directory() . '/assets/image/Films/' . $movie->affiche;
                    $file_path_fiche = get_template_directory() . '/assets/image/Fiche films/' . $movie->affiche;
                    if (file_exists($file_path_films)) {
                        $img_path = $img_path_films;
                    } elseif (file_exists($file_path_fiche)) {
                        $img_path = $img_path_fiche;
                    } else {
                        $img_path = get_template_directory_uri() . '/assets/image/Fiche films/placeholder.jpg';
                    }
                ?>
                    <div class="col-6 col-md-3">
                        <div class="similar-card">
                            <img src="<?php echo $img_path; ?>" alt="<?php echo esc_attr($movie->title); ?>">
                            <div class="similar-card-title"><?php echo esc_html($movie->title); ?></div>
                        </div>
                    </div>
                <?php $i++; endforeach; ?>
                </div>
                <button class="carousel-arrow right d-flex align-items-center justify-content-center" type="button">❯</button>
            </div>
        </section>
        <!-- Carrousel Science-Fiction -->
        <section class="movies-section mt-5 mb-4" style="max-width:1100px;margin:38px auto 0 auto;width:100%;box-sizing:border-box;">
               <h3 class="section-title mb-3">Science-Fiction</h3>
               <div class="movies-carousel d-flex align-items-center">
                       <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>
                <div style="display: flex; align-items: center; width: 100%;">
                    <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>
                    <div class="row flex-grow-1 mx-3 g-3" id="carousel-film-scifi">
                <?php
                $max_display = 4;
                $i = 0;
                $scifi_movies = $wpdb->get_results(
                    $wpdb->prepare(
                        "SELECT * FROM $table_name WHERE genre LIKE %s AND type = %s",
                        '%Science-Fiction%', 'film'
                    )
                );
                foreach ($scifi_movies as $movie) :
                    if ($i >= $max_display) break;
                    $img_path_films = get_template_directory_uri() . '/assets/image/Films/' . esc_attr($movie->affiche);
                    $img_path_fiche = get_template_directory_uri() . '/assets/image/Fiche films/' . esc_attr($movie->affiche);
                    $file_path_films = get_template_directory() . '/assets/image/Films/' . $movie->affiche;
                    $file_path_fiche = get_template_directory() . '/assets/image/Fiche films/' . $movie->affiche;
                    if (file_exists($file_path_films)) {
                        $img_path = $img_path_films;
                    } elseif (file_exists($file_path_fiche)) {
                        $img_path = $img_path_fiche;
                    } else {
                        $img_path = get_template_directory_uri() . '/assets/image/Fiche films/placeholder.jpg';
                    }
                ?>
                    <div class="col-6 col-md-3">
                        <div class="similar-card">
                            <img src="<?php echo $img_path; ?>" alt="<?php echo esc_attr($movie->title); ?>">
                            <div class="similar-card-title"><?php echo esc_html($movie->title); ?></div>
                        </div>
                    </div>
                <?php $i++; endforeach; ?>
                </div>
                <button class="carousel-arrow right d-flex align-items-center justify-content-center" type="button">❯</button>
            </div>
        </section>
	</main>
</div>
<script>
	// Charger les éléments par genre
	const genres = <?php echo json_encode($genres); ?>;
	const mediaType = '<?php echo esc_js($media_type); ?>';
	// ... JS pour charger les films/séries dynamiquement ...
</script>
<?php get_footer(); ?>
