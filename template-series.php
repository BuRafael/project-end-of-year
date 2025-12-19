
<?php
/**
 * Template Name: Séries
 * Template Post Type: page
 * Description: Page listant toutes les séries par genre
 */

get_header();
$media_type = 'serie';
$genres = array('Action', 'Comédie', 'Drame', 'Science-Fiction', 'Horreur', 'Romance');
?>
<!-- Import des styles carrousel séries -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/page-media-layout.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/Fiche serie.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/movies-series.css">
<script>document.addEventListener('DOMContentLoaded',function(){document.body.setAttribute('data-media-type','serie');});</script>
<div class="site-container">
	<main>
		<!-- 1. Section À la une -->
		<section class="featured-media">
			<div class="featured-media-inner">
				<div class="featured-a-la-une-text">À la une</div>
				<div class="featured-card">
					<div class="featured-img-wrap">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/placeholder.jpg" alt="Série à la une" class="featured-affiche-img" style="border-radius:18px;">
					</div>
					<div class="featured-infos-col">
						<h2 class="featured-title">Titre de la série</h2>
						<div class="featured-meta improved-meta">
							<span class="meta-year">2024</span>
							<span class="meta-dot">•</span>
							<span class="meta-director">Réalisateur</span>
							<span class="meta-dot">•</span>
							<span class="meta-duration">3 saisons</span>
							<span class="meta-dot">•</span>
							<span class="meta-genres">Genre, Genre</span>
						</div>
						<div class="featured-synopsis">
							<p>Résumé de la série à la une. À personnaliser.</p>
						</div>
						<a href="#" class="btn-main fiche-a-la-une">Découvrir</a>
					</div>
				</div>
			</div>
		</section>

		<!-- 2. Section Tendance du moment (5 éléments) -->
		<section class="trending-media mb-5">
			<h2 class="section-title mb-4">Tendance du moment</h2>
			<div class="trend-list">
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/placeholder.jpg" alt="Série 1">
					<h4>Série 1</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/placeholder.jpg" alt="Série 2">
					<h4>Série 2</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/placeholder.jpg" alt="Série 3">
					<h4>Série 3</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/placeholder.jpg" alt="Série 4">
					<h4>Série 4</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/placeholder.jpg" alt="Série 5">
					<h4>Série 5</h4>
				</div>
			</div>
		</section>

		<!-- 3. Section Nouveautés (5 éléments) -->
		<section class="new-media mb-5">
			<h2 class="section-title mb-4">Nouveautés</h2>
			<div class="trend-list">
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/placeholder.jpg" alt="Série 6">
					<h4>Série 6</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/placeholder.jpg" alt="Série 7">
					<h4>Série 7</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/placeholder.jpg" alt="Série 8">
					<h4>Série 8</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/placeholder.jpg" alt="Série 9">
					<h4>Série 9</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/placeholder.jpg" alt="Série 10">
					<h4>Série 10</h4>
				</div>
			</div>
		</section>

		<!-- 4. Carrousels par genre (Action, Comédie, Horreur, Romance, Science-Fiction) -->
		<?php
		global $wpdb;
		$table_name = $wpdb->prefix . 'series';
		foreach ($genres as $genre): ?>
		<section class="movies-section mt-5 mb-4" style="max-width:1100px;margin:38px auto 0 auto;width:100%;box-sizing:border-box;">
			<h3 class="section-title mb-3"><?php echo esc_html($genre); ?></h3>
			<div class="movies-carousel d-flex align-items-center">
			<div style="display: flex; align-items: center; width: 100%;">
				<button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>
				<div class="row flex-grow-1 mx-3 g-3" id="carousel-serie-<?php echo strtolower(str_replace(' ', '-', $genre)); ?>">
				<?php
				$max_display = 4;
				$i = 0;
				$series = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT * FROM $table_name WHERE genre LIKE %s AND type = %s",
						'%' . $genre . '%', 'serie'
					)
				);
				foreach ($series as $serie) :
					if ($i >= $max_display) break;
					$img_path_series = get_template_directory_uri() . '/assets/image/Series/' . esc_attr($serie->affiche);
					$img_path_fiche = get_template_directory_uri() . '/assets/image/Fiche série/' . esc_attr($serie->affiche);
					$file_path_series = get_template_directory() . '/assets/image/Series/' . $serie->affiche;
					$file_path_fiche = get_template_directory() . '/assets/image/Fiche série/' . $serie->affiche;
					if (file_exists($file_path_series)) {
						$img_path = $img_path_series;
					} elseif (file_exists($file_path_fiche)) {
						$img_path = $img_path_fiche;
					} else {
						$img_path = get_template_directory_uri() . '/assets/image/Fiche série/placeholder.jpg';
					}
				?>
					<div class="col-6 col-md-3">
						<div class="similar-card">
							<img src="<?php echo $img_path; ?>" alt="<?php echo esc_attr($serie->title); ?>">
							<div class="similar-card-title"><?php echo esc_html($serie->title); ?></div>
						</div>
					</div>
				<?php $i++; endforeach; ?>
				</div>
				<button class="carousel-arrow right d-flex align-items-center justify-content-center" type="button">❯</button>
			</div>
		</section>
		<?php endforeach; ?>
	</main>
</div>
<script>
	// Charger les éléments par genre
	const genres = <?php echo json_encode($genres); ?>;
	const mediaType = '<?php echo esc_js($media_type); ?>';
	// ... JS pour charger les films/séries dynamiquement ...
</script>
<?php get_footer(); ?>

