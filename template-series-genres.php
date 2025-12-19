<?php
/**
 * Carrousels par genre pour la page séries
 * Structure similaire à template-films.php
 */
$genres = array('Action', 'Comédie', 'Drame', 'Science-Fiction', 'Horreur', 'Romance');
global $wpdb;
$table_name = $wpdb->prefix . 'series';
?>
<div class="site-container">
	<main>
		<?php foreach ($genres as $genre): ?>
		<section class="movies-section mt-5 mb-4" style="max-width:1100px;margin:38px auto 0 auto;width:100%;box-sizing:border-box;">
			<h3 class="section-title mb-3"><?php echo esc_html($genre); ?></h3>
			<div class="d-flex align-items-center">
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
