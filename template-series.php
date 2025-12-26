
<?php
/**
 * Template Name: Séries
 * Template Post Type: page
 * Description: Page listant toutes les séries par genre
 */

get_header();
$media_type = 'serie';
$genres = array('Action', 'Comédie', 'Drame', 'Horreur', 'Romance', 'Science-Fiction');
?>
<!-- Import des styles carrousel séries -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/page-media-layout.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/Fiche serie.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/movies-series.css">
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/series-carousel.js"></script>
<script>document.addEventListener('DOMContentLoaded',function(){document.body.setAttribute('data-media-type','serie');});</script>
<div class="site-container">
	<main>
		<!-- 1. Section À la une -->
		<section class="featured-media">
			<div class="featured-media-inner">
				<div class="featured-a-la-une-text">À la une</div>
				<div class="featured-card">
					<div class="featured-img-wrap">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/the last of us.jpg" alt="The Last of Us" class="featured-affiche-img" style="border-radius:18px;">
					</div>
					<div class="featured-infos-col">
						<h2 class="featured-title">The Last of Us</h2>
						<div class="featured-meta improved-meta">
							<span class="meta-year">2023</span>
							<span class="meta-dot">•</span>
							<span class="meta-director">Craig Mazin, Neil Druckmann</span>
							<span class="meta-dot">•</span>
							<span class="meta-duration">1 saison</span>
							<span class="meta-dot">•</span>
							<span class="meta-genres">Drame, Post-apocalyptique</span>
						</div>
						<div class="featured-synopsis">
							<p>Dans un monde ravagé par une pandémie fongique, Joel doit escorter Ellie, une adolescente immunisée, à travers les États-Unis. Adaptation du célèbre jeu vidéo.</p>
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
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/squid game saison 3.jpg" alt="Squid Game Saison 3">
					<h4>Squid Game Saison 3</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/reacher.webp" alt="Reacher">
					<h4>Reacher</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/tracker.webp" alt="Tracker">
					<h4>Tracker</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/adolescence.jpg" alt="Adolescence">
					<h4>Adolescence</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/house of the dragon.jpg" alt="House of the Dragon">
					<h4>House of the Dragon</h4>
				</div>
			</div>
		</section>

		<!-- 3. Section Nouveautés (5 éléments) -->
		<section class="new-media mb-5">
			<h2 class="section-title mb-4">Nouveautés</h2>
			<div class="trend-list">
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/the night agent.jpg" alt="The Night Agent">
					<h4>The Night Agent</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/fallout.webp" alt="Fallout">
					<h4>Fallout</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/captain fall.jpg" alt="Captain Fall">
					<h4>Captain Fall</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/the spiderwick chronicles.jpg" alt="The Spiderwick Chronicles">
					<h4>The Spiderwick Chronicles</h4>
				</div>
				<div class="trend-card">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/image/Fiche série/a gentleman in moscow.jpg" alt="A Gentleman in Moscow">
					<h4>A Gentleman in Moscow</h4>
				</div>
			</div>
		</section>

		<!-- 4. Carrousels par genre (Action, Comédie, Horreur, Romance, Science-Fiction) -->

		<?php
		$exclude_titles = array(
			'The Last of Us',
			'Squid Game Saison 3',
			'Reacher',
			'Tracker',
			'Adolescence',
			'House of the Dragon',
			'The Night Agent',
			'Fallout',
			'Captain Fall',
			'The Spiderwick Chronicles',
			'A Gentleman in Moscow',
		);
		$files = scandir(get_template_directory() . '/assets/image/Fiche série/');
		$series_files = array();
		// Exclure les films connus du dossier Fiche série
		$film_titles = array(
			'La La Land', 'A Star Is Born', 'Begin Again', 'Moulin Rouge', 'Once', 'Sing Street', 'The Umbrellas Of Cherbourg', 'Weathering With You', 'Your Name',
			'Paddington 2', 'The Grand Budapest Hotel', 'Little Miss Sunshine', 'The Truman Show', 'Shaun Of The Dead',
			'Hereditary', 'The Witch', 'Midsommar', 'It Follows', 'The Babadook', 'The Lighthouse',
			'District 9', 'Mission Impossible The Final Reckoning', 'Ne Zha 2', 'Princess Mononoke', 'Snowpiercer', 'The Martian', 'Mad Max Fury Road', 'Edge Of Tomorrow', 'Blade Runner 2049', 'Dune Part Two',
			// Ajouter d'autres titres de films si besoin
		);
		foreach ($files as $file) {
			if (preg_match('/\.(jpg|jpeg|png|webp)$/i', $file)) {
				$title = ucwords(str_replace(array('-', '_'), ' ', preg_replace('/\.[^.]+$/', '', $file)));
				if (!in_array($title, $exclude_titles) && !in_array($title, $film_titles)) {
					$series_files[$title] = $file;
				}
			}
		}
		$genres_map = array(
			'Action' => array(),
			'Comédie' => array(),
			'Drame' => array(),
			'Science-Fiction' => array(),
			'Horreur' => array(),
			'Romance' => array(),
		);
		// Répartition manuelle cohérente par genre
		$genres_map['Action'] = array(
			'attack on titan.jpg',
			'akame ga kill!.webp',
			'fire force.jpg',
			'fullmetal alchemist brotherhood.jpg',
			'the witcher.webp',
			'vikings.jpg',
			'vikings valhalla.jpg',
			'reacher.webp',
			'the last kingdom.jpg',
			'demon slayer.jpg',
		);
		$genres_map['Comédie'] = array(
			'sex education.jpg',
			'trinkets.jpg',
			'captain fall.jpg',
			'the end of the fing world.webp',
			'gossip girl (2021).jpg',
			'wednesday.jpg',
			'sabrina the teenage witch (1996).jpg',
			'skam.jpg',
			'elite.webp',
		);
		$genres_map['Drame'] = array(
			'breaking bad.webp',
			'better call saul.jpg',
			'euphoria.jpg',
			'boardwalk empire.jpg',
			'the sopranos.webp',
			'ozark.webp',
			'peaky blinders.jpg',
			'fargo.webp',
			'the leftovers.jpg',
			'snowfall.JPG',
		);
		$genres_map['Horreur'] = array(
			'stranger things2.jpg',
			'the chilling adventures of sabrina.jpg',
			'devilman crybaby.jpg',
			'tokyo ghoul.jpg',
			'it.webp',
			'locke and key.jpg',
			'the sandman.webp',
			'supernatural.webp',
			'the spiderwick chronicles.jpg',
			'deadly class.webp',
		);
		$genres_map['Romance'] = array(
			'noragami.jpg',
			'we are who we are.jpg',
			'generation.jpg',
			'sense8.jpg',
			'riverdale.jpg',
			'shadow and bone.jpg',
			'merlin.jpg',
			'i am not okay with this.jpg',
			'the oa.webp',
			'a gentleman in moscow.jpg',
		);
		$genres_map['Science-Fiction'] = array(
			'dark.jpg',
			'fringe.jpg',
			'1899.jpg',
			'the x-files.jpg',
			'neon genesis evangelion.jpg',
			'dorohedoro.jpg',
			'blue exorcist.webp',
			'mob psycho 100.jpg',
			'the umbrella academy.webp',
			'wheel of time.jpg',
		);


		// Affichage des carrousels par genre
		$first = true;
		foreach ($genres as $genre) {
			if (!empty($genres_map[$genre])) {
				$carousel_id = 'carousel-serie-' . strtolower(str_replace(' ', '-', $genre));
				// Pour le premier carrousel (Action), on met le titre dans la même section
				if ($first) {
					echo '<section class="movies-section mt-5 mb-4 genres-populaires-block" style="max-width:1100px;margin:38px auto 0 auto;width:100%;box-sizing:border-box;">';
					echo '<h2 id="genres-populaires-title" class="section-title">GENRES POPULAIRES</h2>';
					$first = false;
				} else {
					echo '<section class="movies-section mt-5 mb-4" style="max-width:1100px;margin:38px auto 0 auto;width:100%;box-sizing:border-box;">';
				}
				echo '<h3 class="section-title mb-3">' . $genre . '</h3>';
				echo '<div class="movies-carousel d-flex align-items-center" style="display: flex; align-items: center; width: 100%;">';
				echo '<button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>';
				echo '<div class="row flex-grow-1 mx-3 g-3" id="' . $carousel_id . '">';
				$max_display = 10;
				$fiche_uri = get_template_directory_uri() . '/assets/image/Fiche série/';
				$fiche_dir = get_template_directory() . '/assets/image/Fiche série/';
				$i = 0;
				foreach ($genres_map[$genre] as $file) {
					$img_path = $fiche_uri . rawurlencode($file);
					$title = preg_replace('/\.[^.]+$/', '', $file);
					$title = ucwords(str_replace(array('-', '_'), ' ', $title));
					if (file_exists($fiche_dir . $file)) {
						echo '<div class="col-6 col-md-3">';
						echo '<div class="similar-card">';
						echo '<img src="' . $img_path . '" alt="' . esc_attr($title) . '">';
						echo '<div class="similar-card-title">' . esc_html($title) . '</div>';
						echo '</div>';
						echo '</div>';
						$i++;
					}
				}
				for (; $i < $max_display; $i++) {
					echo '<div class="col-6 col-md-3">';
					echo '<div class="similar-card" style="background:#2a2a2a;opacity:0.5;min-height:220px;display:flex;align-items:center;justify-content:center;">';
					echo '<span style="color:#888;font-size:1.1rem;">(vide)</span>';
					echo '</div>';
					echo '</div>';
				}
				echo '</div>';
				echo '<button class="carousel-arrow right d-flex align-items-center justify-content-center" type="button">❯</button>';
				echo '</div>';
				echo '</section>';
			}
		}
?>

<!-- CTA Section (Call To Action) -->


<section class="cta-section section-animated">
	<hr class="cta-hr">
	<div class="cta-text">
		<p>
			Ne ratez plus jamais vos bandes originales préférées.<br>
			Rejoignez notre communauté et plongez dans<br>
			l'univers musical de tous vos films et séries favoris !
		</p>
		<?php if (!is_user_logged_in()) : ?>
			<div style="width:100%;display:flex;justify-content:center;margin-top:18px;">
				<?php echo cinemusic_signup_button(); ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>



