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
                            <p>
                                Avant Dorothy, Oz cachait déjà bien des secrets... "Wicked" raconte l'histoire inattendue d'Elphaba et Glinda, deux sorcières que tout oppose, dans une amitié bouleversée par le destin. Adapté du succès de Broadway, ce film musical spectaculaire, avec Cynthia Erivo et Ariana Grande, vous invite à redécouvrir Oz sous un nouveau jour, entre magie, rivalités et chansons inoubliables.
                            </p>
                        </div>
                        <a href="/wicked" class="btn-main fiche-a-la-une">Découvrir</a>
                    </div>
                </div>
            </div>
        </section>

		<!-- 2. Section Tendance du moment (5 éléments) -->
        <section class="trending-media">
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
        <section class="new-media">
            <h2 class="section-title mb-4" style="text-align:left !important;justify-content:flex-start !important;">Nouveautés</h2>
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

           <!-- 4. GENRES POPULAIRES section title + Carrousels par genre (Action, Comédie, Horreur, Romance, Science-Fiction) -->
           <section class="movies-section mt-5 mb-4 genres-populaires-block" style="max-width:1100px;width:100%;box-sizing:border-box;">
               <h2 id="genres-populaires-title" class="section-title">GENRES POPULAIRES</h2>
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
            $max_display = 10;
            $fiche_dir = get_template_directory() . '/assets/image/Fiche films/';
            $fiche_uri = get_template_directory_uri() . '/assets/image/Fiche films/';
            $action_list = array(
                'district 9.jpg',
                'mission impossible the final reckoning.webp',
                'ne zha 2.jpg',
                'princess mononoke.jpg',
                'snowpiercer.jpg',
                'the martian.jpg',
                'mad max fury road.jpg',
                'edge of tomorrow.jpg',
                'blade runner 2049.webp',
                'dune part two.jpg'
            );
            $i = 0;
            foreach ($action_list as $file) {
                $img_path = $fiche_uri . rawurlencode($file);
                $title = preg_replace('/\.[^.]+$/', '', $file);
                $title = ucwords(str_replace(array('-', '_'), ' ', $title));
                if (file_exists($fiche_dir . $file)) {
            ?>
                <div class="col-6 col-md-3">
                    <div class="similar-card">
                        <img src="<?php echo $img_path; ?>" alt="<?php echo esc_attr($title); ?>">
                        <div class="similar-card-title"><?php echo esc_html($title); ?></div>
                    </div>
                </div>
            <?php $i++; }}
            for (; $i < $max_display; $i++): ?>
                <div class="col-6 col-md-3">
                    <div class="similar-card" style="background:#2a2a2a;opacity:0.5;min-height:220px;display:flex;align-items:center;justify-content:center;">
                        <span style="color:#888;font-size:1.1rem;">(vide)</span>
                    </div>
                </div>
            <?php endfor; ?>
                </div>
                <button class="carousel-arrow right d-flex align-items-center justify-content-center" type="button">❯</button>
            </div>
        </section>
        <!-- Carrousel Comédie -->
        <section class="movies-section mt-5 mb-4" style="max-width:1100px;width:100%;box-sizing:border-box;">
            <h3 class="section-title mb-3">Comédie</h3>
            <div class="movies-carousel d-flex align-items-center" style="display: flex; align-items: center; width: 100%;">
                <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>
                <div class="row flex-grow-1 mx-3 g-3" id="carousel-film-comedie">
                <?php
                $max_display = 10;
                $fiche_dir = get_template_directory() . '/assets/image/Fiche films/';
                $fiche_uri = get_template_directory_uri() . '/assets/image/Fiche films/';
                $comedie_list = array(
                    'the naked gun.webp',
                    'lilo & stitch (2025).jpeg',
                    'my neighbor totoro.jpeg',
                    'ponyo.webp',
                    'singin in the rain.jpg',
                    'paddington 2.webp',
                    'the grand budapest hotel.jpg',
                    'little miss sunshine.webp',
                    'the truman show.jpg',
                    'shaun of the dead.jpg'
                );
                $i = 0;
                foreach ($comedie_list as $file) {
                    $img_path = $fiche_uri . rawurlencode($file);
                    $title = preg_replace('/\.[^.]+$/', '', $file);
                    $title = ucwords(str_replace(array('-', '_'), ' ', $title));
                    if (file_exists($fiche_dir . $file)) {
                ?>
                    <div class="col-6 col-md-3">
                        <div class="similar-card">
                            <img src="<?php echo $img_path; ?>" alt="<?php echo esc_attr($title); ?>">
                            <div class="similar-card-title"><?php echo esc_html($title); ?></div>
                        </div>
                    </div>
                <?php $i++; }}
                for (; $i < $max_display; $i++): ?>
                    <div class="col-6 col-md-3">
                        <div class="similar-card" style="background:#2a2a2a;opacity:0.5;min-height:220px;display:flex;align-items:center;justify-content:center;">
                            <span style="color:#888;font-size:1.1rem;">(vide)</span>
                        </div>
                    </div>
                <?php endfor; ?>
                </div>
                <button class="carousel-arrow right d-flex align-items-center justify-content-center" type="button">❯</button>
            </div>
        </section>
        <!-- Carrousel Drame -->
        <section class="movies-section mt-5 mb-4" style="max-width:1100px;margin:38px auto 0 auto;width:100%;box-sizing:border-box;">
            <h3 class="section-title mb-3">Drame</h3>
            <div class="movies-carousel d-flex align-items-center" style="display: flex; align-items: center; width: 100%;">
                <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>
                <div class="row flex-grow-1 mx-3 g-3" id="carousel-film-drame">
                <?php
                $max_display = 10;
                $fiche_dir = get_template_directory() . '/assets/image/Fiche films/';
                $fiche_uri = get_template_directory_uri() . '/assets/image/Fiche films/';
                $drame_list = array(
                    'parasite.jpg',
                    'memories of murder.jpg',
                    'burning.jpg',
                    'shoplifters.jpg',
                    'whiplash.jpg',
                    'joker.JPG',
                    'the handmaiden.jpg',
                    'triangle of sadness.jpg',
                    'solaris.jpg',
                    'blue moon.jpg'
                );
                $i = 0;
                foreach ($drame_list as $file) {
                    $img_path = $fiche_uri . rawurlencode($file);
                    $title = preg_replace('/\.[^.]+$/', '', $file);
                    $title = ucwords(str_replace(array('-', '_'), ' ', $title));
                    if (file_exists($fiche_dir . $file)) {
                ?>
                    <div class="col-6 col-md-3">
                        <div class="similar-card">
                            <img src="<?php echo $img_path; ?>" alt="<?php echo esc_attr($title); ?>">
                            <div class="similar-card-title"><?php echo esc_html($title); ?></div>
                        </div>
                    </div>
                <?php $i++; }}
                for (; $i < $max_display; $i++): ?>
                    <div class="col-6 col-md-3">
                        <div class="similar-card" style="background:#2a2a2a;opacity:0.5;min-height:220px;display:flex;align-items:center;justify-content:center;">
                            <span style="color:#888;font-size:1.1rem;">(vide)</span>
                        </div>
                    </div>
                <?php endfor; ?>
                </div>
                <button class="carousel-arrow right d-flex align-items-center justify-content-center" type="button">❯</button>
            </div>
        </section>
        <!-- Carrousel Horreur -->
        <section class="movies-section mt-5 mb-4" style="max-width:1100px;margin:38px auto 0 auto;width:100%;box-sizing:border-box;">
            <h3 class="section-title mb-3">Horreur</h3>
            <div class="movies-carousel d-flex align-items-center" style="display: flex; align-items: center; width: 100%;">
                <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>
                <div class="row flex-grow-1 mx-3 g-3" id="carousel-film-horreur">
                <?php
                $max_display = 10;
                $fiche_dir = get_template_directory() . '/assets/image/Fiche films/';
                $fiche_uri = get_template_directory_uri() . '/assets/image/Fiche films/';
                $horreur_list = array(
                    'annihilation.jpg',
                    'get out.jpg',
                    'mother.webp',
                    'under the skin.jpg',
                    'hereditary.jpg',
                    'the witch.jpg',
                    'midsommar .webp',
                    'it follows.webp',
                    'the badabook.jpg',
                    'the lighthouse.jpg'
                );
                $i = 0;
                foreach ($horreur_list as $file) {
                    $img_path = $fiche_uri . rawurlencode($file);
                    $title = preg_replace('/\.[^.]+$/', '', $file);
                    $title = ucwords(str_replace(array('-', '_'), ' ', $title));
                    if (file_exists($fiche_dir . $file)) {
                ?>
                    <div class="col-6 col-md-3">
                        <div class="similar-card">
                            <img src="<?php echo $img_path; ?>" alt="<?php echo esc_attr($title); ?>">
                            <div class="similar-card-title"><?php echo esc_html($title); ?></div>
                        </div>
                    </div>
                <?php $i++; }}
                for (; $i < $max_display; $i++): ?>
                    <div class="col-6 col-md-3">
                        <div class="similar-card" style="background:#2a2a2a;opacity:0.5;min-height:220px;display:flex;align-items:center;justify-content:center;">
                            <span style="color:#888;font-size:1.1rem;">(vide)</span>
                        </div>
                    </div>
                <?php endfor; ?>
                </div>
                <button class="carousel-arrow right d-flex align-items-center justify-content-center" type="button">❯</button>
            </div>
        </section>
        <!-- Carrousel Romance -->
        <section class="movies-section mt-5 mb-4" style="max-width:1100px;margin:38px auto 0 auto;width:100%;box-sizing:border-box;">
            <h3 class="section-title mb-3">Romance</h3>
            <div class="movies-carousel d-flex align-items-center" style="display: flex; align-items: center; width: 100%;">
                <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>
                <div class="row flex-grow-1 mx-3 g-3" id="carousel-film-romance">
                <?php
                $max_display = 10;
                $fiche_dir = get_template_directory() . '/assets/image/Fiche films/';
                $fiche_uri = get_template_directory_uri() . '/assets/image/Fiche films/';
                $romance_list = array(
                    'a star is born.jpg',
                    'begin again.jpg',
                    'la la land.jpg',
                    'moulin rouge.jpg',
                    'once.jpg',
                    'sing street.jpg',
                    'the umbrellas of cherbourg.jpg',
                    'weathering with you.webp',
                    'your name.jpg',
                    'before sunrise.webp'
                );
                $i = 0;
                foreach ($romance_list as $file) {
                    $img_path = $fiche_uri . rawurlencode($file);
                    $title = preg_replace('/\.[^.]+$/', '', $file);
                    $title = ucwords(str_replace(array('-', '_'), ' ', $title));
                    if (file_exists($fiche_dir . $file)) {
                ?>
                    <div class="col-6 col-md-3">
                        <div class="similar-card">
                            <img src="<?php echo $img_path; ?>" alt="<?php echo esc_attr($title); ?>">
                            <div class="similar-card-title"><?php echo esc_html($title); ?></div>
                        </div>
                    </div>
                <?php $i++; }}
                for (; $i < $max_display; $i++): ?>
                    <div class="col-6 col-md-3">
                        <div class="similar-card" style="background:#2a2a2a;opacity:0.5;min-height:220px;display:flex;align-items:center;justify-content:center;">
                            <span style="color:#888;font-size:1.1rem;">(vide)</span>
                        </div>
                    </div>
                <?php endfor; ?>
                </div>
                <button class="carousel-arrow right d-flex align-items-center justify-content-center" type="button">❯</button>
            </div>
        </section>
        <!-- Carrousel Science-Fiction -->
        <section class="movies-section mt-5 mb-4" style="max-width:1100px;margin:38px auto 0 auto;width:100%;box-sizing:border-box;">
            <h3 class="section-title mb-3">Science-Fiction</h3>
            <div class="movies-carousel d-flex align-items-center" style="display: flex; align-items: center; width: 100%;">
                <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>
                <div class="row flex-grow-1 mx-3 g-3" id="carousel-film-scifi">
                <?php
                $max_display = 10;
                $fiche_dir = get_template_directory() . '/assets/image/Fiche films/';
                $fiche_uri = get_template_directory_uri() . '/assets/image/Fiche films/';
                $scifi_list = array(
                    '2001 a space odyssey.jpg',
                    'ad astra.jpg',
                    'arrival.webp',
                    'close encounters of the third kind.jpg',
                    'contact.webp',
                    'gravity.jpg',
                    'interstellar.jpg',
                    'inception affiche film.jpg',
                    'solaris.jpg',
                    'sunshine.jpg'
                );
                $i = 0;
                foreach ($scifi_list as $file) {
                    $img_path = $fiche_uri . rawurlencode($file);
                    $title = preg_replace('/\.[^.]+$/', '', $file);
                    $title = ucwords(str_replace(array('-', '_'), ' ', $title));
                    if (file_exists($fiche_dir . $file)) {
                ?>
                    <div class="col-6 col-md-3">
                        <div class="similar-card">
                            <img src="<?php echo $img_path; ?>" alt="<?php echo esc_attr($title); ?>">
                            <div class="similar-card-title"><?php echo esc_html($title); ?></div>
                        </div>
                    </div>
                <?php $i++; }}
                for (; $i < $max_display; $i++): ?>
                    <div class="col-6 col-md-3">
                        <div class="similar-card" style="background:#2a2a2a;opacity:0.5;min-height:220px;display:flex;align-items:center;justify-content:center;">
                            <span style="color:#888;font-size:1.1rem;">(vide)</span>
                        </div>
                    </div>
                <?php endfor; ?>
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







        <!-- Scroll to Top Button styled like front-page -->
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/front-page.css">
        <button class="scroll-to-top" id="scrollToTop" aria-label="Remonter en haut" type="button" style="display: none;">
            <svg width="40" height="40" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polyline class="scroll-arrow" points="7,17 14,10 21,17" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>
        </button>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('scrollToTop');
            window.addEventListener('scroll', function() {
                btn.style.display = window.scrollY > 200 ? 'flex' : 'none';
            });
            btn.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
        </script>

<?php get_footer(); ?>
