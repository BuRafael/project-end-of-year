<?php
// Récupérer les infos de la série basé sur le slug
global $post;
$page_slug = isset($post->post_name) ? $post->post_name : 'stranger-things';
add_filter('body_class', function($classes) use ($page_slug) {
    $classes[] = 'slug-' . $page_slug;
    return $classes;
});
/**
 * Template Name: Fiche Série
 * Template Post Type: page
 * Description: Template pour afficher la fiche détaillée d'une série
 */

get_header();

// Récupérer les infos de la série basé sur le slug
global $post;
$page_slug = isset($post->post_name) ? $post->post_name : 'stranger-things';

// Infos supplémentaires codées pour chaque série
$series_info = array(
                'jujutsu-kaisen' => array(
                    'title' => 'Jujutsu Kaisen',
                    'aired' => '2020 - À nos jours',
                    'seasons' => '2',
                    'episodes_detail' => [
                        'Saison 1' => '24 épisodes',
                        'Saison 2' => '23 épisodes',
                    ],
                    'rating' => '8,6/10',
                    'director' => 'Sunghoo Park',
                    'cast' => 'Junya Enoki, Yūma Uchida, Asami Seto, Yūichi Nakamura',
                    'synopsis' => 'Yuji Itadori, lycéen ordinaire, voit sa vie basculer après avoir avalé un objet maudit pour sauver un camarade. Il rejoint une école d’exorcistes pour combattre des fléaux surnaturels. Un shōnen nerveux, sombre et spectaculaire.',
                    'poster' => 'jujutsu kaisen.jpg',
                    'genres_display' => 'Animation • Action • Surnaturel',
                    'total_tracks' => '60'
                ),
            'demon-slayer' => array(
                'title' => 'Demon Slayer',
                'aired' => '2019 - À nos jours',
                'seasons' => '3',
                'episodes_detail' => [
                    'Saison 1' => '26 épisodes',
                    'Saison 2' => '11 épisodes',
                    'Saison 3' => '11 épisodes',
                ],
                'rating' => '8,7/10',
                'director' => 'Haruo Sotozaki',
                'cast' => 'Natsuki Hanae, Akari Kitō, Hiro Shimono, Yoshitsugu Matsuoka',
                'synopsis' => 'Dans un Japon envahi par des démons, Tanjiro Kamado rejoint le corps des pourfendeurs pour sauver sa sœur Nezuko et venger sa famille. Une aventure épique, visuellement spectaculaire et émouvante.',
                'poster' => 'demon slayer.jpg',
                'genres_display' => 'Animation • Action • Surnaturel',
                'total_tracks' => '105'
            ),
        'attack-on-titan' => array(
            'title' => 'Attack on Titan',
            'aired' => '2013 - 2023',
            'seasons' => '4',
            'episodes_detail' => [
                'Saison 1' => '25 épisodes',
                'Saison 2' => '12 épisodes',
                'Saison 3' => '22 épisodes',
                'Saison 4' => '30 épisodes',
            ],
            'rating' => '9,0/10',
            'director' => 'Tetsurō Araki, Masashi Koizuka, Yuichiro Hayashi',
            'cast' => 'Yūki Kaji, Yui Ishikawa, Marina Inoue, Hiroshi Kamiya, Daisuke Ono',
            'synopsis' => 'Dans un monde ravagé par des créatures géantes nommées Titans, l’humanité survit retranchée derrière d’immenses murs. Eren, Mikasa et Armin rejoignent l’armée pour combattre ces monstres et découvrir la vérité sur leur origine. Une série épique, sombre et haletante.',
            'poster' => 'attack on titan.jpg',
            'genres_display' => 'Animation • Action • Drame • Fantastique',
            'total_tracks' => '135'
        ),
    'stranger-things' => array(
        'title' => 'Stranger Things',
        'aired' => '2016 - À nos jours',
        'seasons' => '4',
        'rating' => '8,7/10',
        'director' => 'The Duffer Brothers',
        'cast' => 'Winona Ryder, David Harbour, Finn Wolfhard, Millie Bobby Brown, Gaten Matarazzo, Caleb McLaughlin, Noah Schnapp, Sadie Sink',
        'synopsis' => 'Quand un enfant disparaît mystérieusement en 1983, ses amis, sa famille et la police locale doivent affronter des forces et des mystères bien plus grands que la réalité. Stranger Things mélange l\'angoisse, la nostalgie et la science-fiction pour raconter une histoire captivante où rien n\'est ce qu\'il semble être. Une série qui a captivé des millions de fans à travers le monde.',
        'poster' => 'Stranger Things2.jpg',
        'genres_display' => 'Science-fiction • Drame • Mystère',
        'total_tracks' => '207' // Total de pistes dans toute la série
    ),
    'breaking-bad' => array(
        'title' => 'Breaking Bad',
        'aired' => '2008 - 2013',
        'seasons' => '5',
        'rating' => '9,5/10',
        'director' => 'Vince Gilligan',
        'cast' => 'Bryan Cranston, Aaron Paul, Anna Gunn, Dean Norris, Betsy Brandt, RJ Mitte',
        'synopsis' => 'Walter White, un professeur de chimie surqualifié et père de famille, apprend qu\'il est atteint d\'un cancer du poumon incurable. Pour assurer l\'avenir financier de sa famille, il se lance dans la production de méthamphétamine avec Jesse Pinkman, un de ses anciens élèves. Une descente aux enfers magistrale.',
        'poster' => 'breaking bad.webp',
        'genres_display' => 'Drame • Crime • Thriller',
        'total_tracks' => '156'
    ),
    'euphoria' => array(
        'title' => 'Euphoria',
        'aired' => '2019 - À nos jours',
        'seasons' => '2',
        'rating' => '8,3/10',
        'director' => 'Sam Levinson',
        'cast' => 'Zendaya, Hunter Schafer, Jacob Elordi, Maude Apatow, Angus Cloud, Eric Dane',
        'synopsis' => 'Rue Bennett est une jeune femme qui lutte contre son addiction aux drogues. Elle tente de trouver sa place dans le monde tout en naviguant dans les complexités de l\'amour, des pertes et des traumatismes. Une série audacieuse et visuellement stupéfiante qui explore les défis de la jeunesse moderne.',
        'poster' => 'euphoria.jpg',
        'genres_display' => 'Drame • Teen',
        'total_tracks' => '98'
    ),
    'wednesday' => array(
        'title' => 'Wednesday',
        'aired' => '2022 - À nos jours',
        'seasons' => '1',
        'rating' => '8,1/10',
        'director' => 'Tim Burton',
        'cast' => 'Jenna Ortega, Gwendoline Christie, Riki Lindhome, Jamie McShane, Hunter Doohan',
        'synopsis' => 'Wednesday Addams est envoyée à l\'académie Nevermore, un pensionnat pour jeunes marginaux. Elle tente de maîtriser ses pouvoirs psychiques émergents, de déjouer une monstrueuse série de meurtres qui terrorise la ville locale, et de résoudre le mystère surnaturel qui a impliqué ses parents il y a 25 ans.',
        'poster' => 'wednesday.jpg',
        'genres_display' => 'Comédie noire • Fantasy • Mystère',
        'total_tracks' => '89'
    ),
    'the-witcher' => array(
        'title' => 'The Witcher',
        'aired' => '2019 - À nos jours',
        'seasons' => '3',
        'rating' => '8,2/10',
        'director' => 'Lauren Schmidt Hissrich',
        'cast' => 'Henry Cavill, Anya Chalotra, Freya Allan, Joey Batey, MyAnna Buring',
        'synopsis' => 'Geralt de Riv, un chasseur de monstres solitaire, se bat pour trouver sa place dans un monde où les humains sont souvent plus méchants que les bêtes. Destinée le lie à une puissante sorcière et à une jeune princesse dont le destin pourrait changer le monde.',
        'poster' => 'the witcher.webp',
        'genres_display' => 'Fantasy • Action • Aventure',
        'total_tracks' => '145'
    )
);

// Définir les variables par défaut

// Par défaut, fiche vide
$title = '';
$aired = '';
$poster = '';
$genre = '';
$info = array();
// Si les infos de la série existent, les utiliser
if (isset($series_info[$page_slug])) {
    $title = $series_info[$page_slug]['title'];
    $aired = $series_info[$page_slug]['aired'];
    $poster = $series_info[$page_slug]['poster'];
    $genre = $series_info[$page_slug]['genres_display'];
    $info = $series_info[$page_slug];
}

?>

<!-- ===== CONTENU FICHE SERIE ===== -->
<main class="movie-page container py-5">

    <!-- Inject current series slug for JS -->
    <script>window.currentSerieSlug = '<?php echo esc_js($page_slug); ?>';</script>
    <!-- TITRE + INFOS GENERALES -->
    <section class="movie-header mb-5">
        <h1 class="fw-bold mb-1"><?php echo esc_html($title); ?></h1>
        <p class="movie-sub small text-secondary mb-4"><?php echo esc_html($aired); ?> – <?php echo esc_html($info['total_tracks']); ?> pistes</p>

        <div class="row g-4">
            <!-- POSTER -->
            <div class="col-md-4 col-lg-3">
                <div class="movie-poster-wrapper text-center text-md-start">
                    <?php 
                    $poster_url = get_template_directory_uri() . '/assets/image/Fiche série/' . $poster;
                    ?>
                    <img src="<?php echo esc_url($poster_url); ?>" alt="Affiche <?php echo esc_attr($title); ?>"
                         class="movie-poster img-fluid shadow" id="moviePosterImg">
                    <button id="movieLikeBtn" class="movie-like-btn p-0" aria-pressed="false" type="button"
                            data-serie-image="<?php echo esc_url($poster_url); ?>"
                            data-serie-title="<?php echo esc_attr($title); ?>"
                            data-serie-year="<?php echo esc_attr($aired); ?>"
                            data-serie-slug="<?php echo esc_attr($page_slug); ?>">
                        <i class="bi bi-heart" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <!-- SYNOPSIS + META -->
            <div class="col-md-8 col-lg-9">
                <h5 class="mb-2" style="color: rgba(112, 1, 24, 1);">Synopsis</h5>
                <p class="movie-synopsis small text-light mb-4">
                    <?php echo esc_html($info['synopsis']); ?>
                </p>
                <div class="row movie-meta small">
                    <div class="col-6 col-sm-3 mb-3">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Saisons</div>
                        <div class="movie-meta-value"><?php echo esc_html($info['seasons']); ?></div>
                    </div>
                    <div class="col-6 col-sm-3 mb-3">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Note</div>
                        <div class="movie-meta-value"><?php echo esc_html($info['rating']); ?></div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Réalisateur</div>
                        <div class="movie-meta-value text-white"><?php echo esc_html($info['director']); ?></div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Acteurs</div>
                        <div class="movie-meta-value text-white">
                            <?php echo esc_html($info['cast']); ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Genre</div>
                        <div class="movie-meta-value text-white">
                            <?php echo esc_html($genre); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PISTES ===== -->
    <section class="movie-section mt-5">
            <!-- SELECTS SAISON / EPISODE (déplacés ici) -->
            <div class="series-selects mb-4" style="justify-content: flex-start;">
                <select id="seasonSelect" class="form-select form-select-sm" aria-label="Choisir une saison">
                    <option value="" disabled selected hidden>Saison</option>
                </select>
                <select id="episodeSelect" class="form-select form-select-sm" aria-label="Choisir un épisode">
                    <option value="" disabled selected hidden>Épisode</option>
                </select>
            </div>
        <div class="table-responsive">
            <table class="table movie-tracks-table align-middle mb-3">
                <thead>
                <tr>
                    <th class="col-num">#</th>
                    <th class="col-title">Pistes</th>
                    <th class="col-links">Liens</th>
                    <th class="col-duration text-center">Durée</th>
                    <th class="col-like"></th>
                </tr>
                </thead>
                <tbody id="tracksTable">
                <!-- JS génère ici les pistes -->
                </tbody>
            </table>
        </div>

        <div class="text-center">
            <button id="tracksMoreBtn" class="btn movie-btn-light small px-5">Afficher plus…</button>
        </div>
    </section>

    <!-- ===== COMMENTAIRES ===== -->
    <section class="movie-section mt-5">
        <h3 class="section-title mb-3">Commentaires</h3>

        <?php if ( is_user_logged_in() ) : 
            $current_user = wp_get_current_user();
            $profile_photo = get_user_meta( $current_user->ID, 'avatar_url', true );
        ?>
        <div class="comment-input-row d-flex align-items-center gap-3 pb-3 mb-4">
            <div class="comment-avatar rounded-circle overflow-hidden d-flex align-items-center justify-content-center">
                <?php if ( ! empty( $profile_photo ) ) : ?>
                    <img src="<?php echo esc_url( $profile_photo ); ?>" alt="Photo de profil" class="w-100 h-100" style="object-fit: cover;">
                <?php else : ?>
                    <i class="bi bi-person"></i>
                <?php endif; ?>
            </div>
            <div class="flex-grow-1">
                <input type="text"
                       class="form-control comment-input"
                       placeholder="Écrire un commentaire"
                       data-user-name="<?php echo esc_attr( $current_user->display_name ); ?>"
                       maxlength="200">
            </div>
        </div>
        <?php else : ?>
        <div class="comment-input-row d-flex align-items-center gap-3 pb-3 mb-4">
            <div class="comment-avatar rounded-circle d-flex align-items-center justify-content-center" style="opacity: 0.5;">
                <i class="bi bi-person"></i>
            </div>
            <div class="flex-grow-1">
                <input type="text"
                       class="form-control comment-input"
                       placeholder="Connectez-vous pour commenter"
                       maxlength="200"
                       disabled>
            </div>
        </div>
        <?php endif; ?>

        <div class="row g-3" id="commentsZone">
            <!-- JS charge les commentaires -->
        </div>

        <div class="text-center mt-4" id="commentsMoreBtnWrapper" style="display: none;">
            <button id="commentsMoreBtn" class="btn movie-btn-light small px-5">Afficher plus…</button>
        </div>
    </section>

    <!-- ===== SERIES SIMILAIRES ===== -->
    <section class="movie-section mt-5 mb-4">
        <h3 class="section-title mb-3">Séries similaires</h3>

        <div class="d-flex align-items-center">
            <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">
                <i class="bi bi-chevron-left"></i>
            </button>

            <div class="row flex-grow-1 mx-3 g-3" id="similarMovies">
                <!-- JS insère 4 séries -->
            </div>

            <button class="carousel-arrow right d-flex align-items-center justify-content-center" type="button">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </section>

    <!-- ===== CTA SECTION ===== -->
    <section class="cta-section">
        <div class="cta-text">
            <p>
                Ne ratez plus jamais vos bandes originales préférées.<br>
                Rejoignez notre communauté et plongez dans<br>
                l'univers musical de tous vos films et séries favoris !
            </p>
            <?php echo cinemusic_signup_button(); ?>
        </div>
    </section>

</main>


<?php
// Construction dynamique de la structure allTracks côté PHP pour chaque série
$all_tracks_data = [
                    'jujutsu-kaisen' => [
                        1 => [
                            1 => [
                                [ 'id' => 1, 'title' => 'Kaikai Kitan', 'artist' => 'Eve', 'duration' => '4:05', 'image' => 'jujutsu kaisen piste.png' ],
                                [ 'id' => 2, 'title' => 'Ryomen Sukuna', 'artist' => 'Hiroaki Tsutsumi', 'duration' => '4:01', 'image' => 'jujutsu kaisen piste.png' ],
                                [ 'id' => 3, 'title' => 'Occult Phenomenon Research Club', 'artist' => 'Tsutsumi & Okehazama', 'duration' => '2:05', 'image' => 'jujutsu kaisen piste.png' ],
                                [ 'id' => 4, 'title' => 'Impatience', 'artist' => 'Tsutsumi', 'duration' => '2:39', 'image' => 'jujutsu kaisen piste.png' ],
                                [ 'id' => 5, 'title' => 'As Usual', 'artist' => 'Alisa Okehazama', 'duration' => '2:04', 'image' => 'jujutsu kaisen piste.png' ],
                                [ 'id' => 6, 'title' => 'The Source of The Curse', 'artist' => 'Tsutsumi', 'duration' => '3:12', 'image' => 'jujutsu kaisen piste.png' ],
                                [ 'id' => 7, 'title' => 'Takagi VS Itadori', 'artist' => 'Tsutsumi', 'duration' => '2:17', 'image' => 'jujutsu kaisen piste.png' ],
                                [ 'id' => 8, 'title' => 'Eye Catch B', 'artist' => 'Tsutsumi', 'duration' => '0:33', 'image' => 'jujutsu kaisen piste.png' ],
                                [ 'id' => 9, 'title' => 'A Thousand‑Year Curse', 'artist' => 'Tsutsumi', 'duration' => '1:44', 'image' => 'jujutsu kaisen piste.png' ]
                            ],
                            2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => [], 12 => [], 13 => [], 14 => [], 15 => [], 16 => [], 17 => [], 18 => [], 19 => [], 20 => [], 21 => [], 22 => [], 23 => [], 24 => []
                        ],
                        2 => [
                            1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => [], 12 => [], 13 => [], 14 => [], 15 => [], 16 => [], 17 => [], 18 => [], 19 => [], 20 => [], 21 => [], 22 => [], 23 => []
                        ]
                    ],
                'demon-slayer' => [
                    1 => [
                        1 => [
                            [ 'id' => 1, 'title' => 'Kamado Tanjiro no Uta', 'artist' => 'Yuki Kajiura & Go Shiina', 'duration' => '2:45', 'image' => 'demon slayer piste.png' ],
                            [ 'id' => 2, 'title' => 'Tanjiro’s Scent', 'artist' => 'Go Shiina', 'duration' => '3:10', 'image' => 'demon slayer piste.png' ],
                            [ 'id' => 3, 'title' => 'Muzan Appears', 'artist' => 'Go Shiina', 'duration' => '2:50', 'image' => 'demon slayer piste.png' ],
                            [ 'id' => 4, 'title' => 'Demon Slayer Corps', 'artist' => 'Go Shiina', 'duration' => '3:05', 'image' => 'demon slayer piste.png' ],
                            [ 'id' => 5, 'title' => 'Tanjiro vs Demon', 'artist' => 'Go Shiina', 'duration' => '2:58', 'image' => 'demon slayer piste.png' ],
                            [ 'id' => 6, 'title' => 'Nezuko Awakens', 'artist' => 'Yuki Kajiura', 'duration' => '2:35', 'image' => 'demon slayer piste.png' ],
                            [ 'id' => 7, 'title' => 'Tragedy', 'artist' => 'Yuki Kajiura', 'duration' => '2:47', 'image' => 'demon slayer piste.png' ],
                            [ 'id' => 8, 'title' => 'Family', 'artist' => 'Yuki Kajiura', 'duration' => '3:00', 'image' => 'demon slayer piste.png' ],
                            [ 'id' => 9, 'title' => 'To Destroy Demons', 'artist' => 'Go Shiina', 'duration' => '3:12', 'image' => 'demon slayer piste.png' ]
                        ],
                        2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => [], 12 => [], 13 => [], 14 => [], 15 => [], 16 => [], 17 => [], 18 => [], 19 => [], 20 => [], 21 => [], 22 => [], 23 => [], 24 => [], 25 => [], 26 => []
                    ],
                    2 => [
                        1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => []
                    ],
                    3 => [
                        1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => []
                    ]
                ],
            'attack-on-titan' => [
                1 => [
                    1 => [
                        [ 'id' => 1, 'title' => 'ətˈæk 0N tάɪtn', 'artist' => 'Hiroyuki Sawano', 'duration' => '4:17', 'image' => 'attack on titan piste.png' ],
                        [ 'id' => 2, 'title' => 'Vogel im Käfig', 'artist' => 'Hiroyuki Sawano', 'duration' => '6:22', 'image' => 'attack on titan piste.png' ],
                        [ 'id' => 3, 'title' => 'XL-TT', 'artist' => 'Hiroyuki Sawano', 'duration' => '4:09', 'image' => 'attack on titan piste.png' ],
                        [ 'id' => 4, 'title' => 'Bauklötze', 'artist' => 'Hiroyuki Sawano', 'duration' => '4:37', 'image' => 'attack on titan piste.png' ],
                        [ 'id' => 5, 'title' => 'DOA', 'artist' => 'Hiroyuki Sawano', 'duration' => '4:12', 'image' => 'attack on titan piste.png' ],
                        [ 'id' => 6, 'title' => 'Kyojin Shinkou', 'artist' => 'Hiroyuki Sawano', 'duration' => '4:28', 'image' => 'attack on titan piste.png' ],
                        [ 'id' => 7, 'title' => 'Anzenchitai', 'artist' => 'Hiroyuki Sawano', 'duration' => '2:10', 'image' => 'attack on titan piste.png' ],
                        [ 'id' => 8, 'title' => 'T-KT', 'artist' => 'Hiroyuki Sawano', 'duration' => '3:58', 'image' => 'attack on titan piste.png' ],
                        [ 'id' => 9, 'title' => 'Eye-Water', 'artist' => 'Hiroyuki Sawano', 'duration' => '2:47', 'image' => 'attack on titan piste.png' ]
                    ],
                    2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => [], 12 => [], 13 => [], 14 => [], 15 => [], 16 => [], 17 => [], 18 => [], 19 => [], 20 => [], 21 => [], 22 => [], 23 => [], 24 => [], 25 => []
                ],
                2 => [
                    1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => [], 12 => []
                ],
                3 => [
                    1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => [], 12 => [], 13 => [], 14 => [], 15 => [], 16 => [], 17 => [], 18 => [], 19 => [], 20 => [], 21 => [], 22 => []
                ],
                4 => [
                    1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => [], 12 => [], 13 => [], 14 => [], 15 => [], 16 => [], 17 => [], 18 => [], 19 => [], 20 => [], 21 => [], 22 => [], 23 => [], 24 => [], 25 => [], 26 => [], 27 => [], 28 => [], 29 => [], 30 => []
                ]
            ],
        'wednesday' => [
            1 => [
                1 => [
                    [ 'id' => 1, 'title' => 'Non, Je Ne Regrette Rien', 'artist' => 'Édith Piaf', 'duration' => '2:23', 'image' => 'wednesday piste.png' ],
                    [ 'id' => 2, 'title' => 'Main Titles', 'artist' => 'Danny Elfman & Chris Bacon', 'duration' => '0:56', 'image' => 'wednesday piste.png' ],
                    [ 'id' => 3, 'title' => 'Wednesday Addams Theme', 'artist' => 'Danny Elfman & Chris Bacon', 'duration' => '1:36', 'image' => 'wednesday piste.png' ],
                    [ 'id' => 4, 'title' => 'This Isn’t Normal', 'artist' => 'Danny Elfman & Chris Bacon', 'duration' => '1:42', 'image' => 'wednesday piste.png' ],
                    [ 'id' => 5, 'title' => 'Nevermore Academy', 'artist' => 'Danny Elfman & Chris Bacon', 'duration' => '2:09', 'image' => 'wednesday piste.png' ],
                    [ 'id' => 6, 'title' => 'Hyde Attacks', 'artist' => 'Danny Elfman & Chris Bacon', 'duration' => '2:31', 'image' => 'wednesday piste.png' ],
                    [ 'id' => 7, 'title' => 'Psychic Vision', 'artist' => 'Danny Elfman & Chris Bacon', 'duration' => '1:58', 'image' => 'wednesday piste.png' ],
                    [ 'id' => 8, 'title' => 'In Dreams', 'artist' => 'Roy Orbison', 'duration' => '2:49', 'image' => 'wednesday piste.png' ],
                    [ 'id' => 9, 'title' => 'Thing’s Mission', 'artist' => 'Danny Elfman & Chris Bacon', 'duration' => '1:44', 'image' => 'wednesday piste.png' ],
                    [ 'id' => 10, 'title' => 'Can’t Stop', 'artist' => 'Rhythmking', 'duration' => '2:38', 'image' => 'wednesday piste.png' ],
                    [ 'id' => 11, 'title' => 'La Llorona', 'artist' => 'Chavela Vargas', 'duration' => '3:03', 'image' => 'wednesday piste.png' ],
                    [ 'id' => 12, 'title' => 'Wednesday Investigates', 'artist' => 'Danny Elfman & Chris Bacon', 'duration' => '2:12', 'image' => 'wednesday piste.png' ],
                    [ 'id' => 13, 'title' => 'End Titles', 'artist' => 'Danny Elfman & Chris Bacon', 'duration' => '1:32', 'image' => 'wednesday piste.png' ]
                ]
            ]
        ],
    'breaking-bad' => [
        1 => [
            1 => [
                [ 'id' => 1, 'title' => 'Breaking Bad Main Title Theme', 'artist' => 'Dave Porter', 'duration' => '0:56', 'image' => 'Breaking bad piste.png' ],
                [ 'id' => 2, 'title' => 'Out of Time Man', 'artist' => 'Mick Harvey', 'duration' => '3:34', 'image' => 'Breaking bad piste.png' ],
                [ 'id' => 3, 'title' => 'Frenesi', 'artist' => 'Artie Shaw', 'duration' => '2:29', 'image' => 'Breaking bad piste.png' ],
                [ 'id' => 4, 'title' => 'Negro Y Azul: The Ballad of Heisenberg', 'artist' => 'Los Cuates de Sinaloa', 'duration' => '2:16', 'image' => 'Breaking bad piste.png' ],
                [ 'id' => 5, 'title' => 'Fallacies', 'artist' => 'Twaughthammer', 'duration' => '2:10', 'image' => 'Breaking bad piste.png' ],
                [ 'id' => 6, 'title' => 'The Morning After', 'artist' => 'Dave Porter', 'duration' => '1:45', 'image' => 'Breaking bad piste.png' ]
            ],
            2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => []
        ],
        2 => [1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => [], 12 => [], 13 => []],
        3 => [1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => [], 12 => [], 13 => []],
        4 => [1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => [], 12 => [], 13 => []],
        5 => [1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => [], 12 => [], 13 => [], 14 => [], 15 => [], 16 => []],
    ],
    'stranger-things' => [
        1 => [
            1 => [
                [ 'id' => 1, 'title' => 'Stranger Things', 'artist' => 'Kyle Dixon & Michael Stein', 'duration' => '', 'image' => 'stranger-things-piste.png' ],
                [ 'id' => 2, 'title' => 'Kids', 'artist' => 'Kyle Dixon & Michael Stein', 'duration' => '', 'image' => 'stranger-things-piste.png' ],
                [ 'id' => 3, 'title' => 'Nancy and Barb', 'artist' => 'Kyle Dixon & Michael Stein', 'duration' => '', 'image' => 'stranger-things-piste.png' ],
                [ 'id' => 4, 'title' => 'This Isn’t You', 'artist' => 'Kyle Dixon & Michael Stein', 'duration' => '', 'image' => 'stranger-things-piste.png' ],
                [ 'id' => 5, 'title' => 'Lay-Z-Boy', 'artist' => 'Kyle Dixon & Michael Stein', 'duration' => '', 'image' => 'stranger-things-piste.png' ],
                [ 'id' => 6, 'title' => 'Friendship', 'artist' => 'Kyle Dixon & Michael Stein', 'duration' => '', 'image' => 'stranger-things-piste.png' ],
                [ 'id' => 7, 'title' => 'Eleven', 'artist' => 'Kyle Dixon & Michael Stein', 'duration' => '', 'image' => 'stranger-things-piste.png' ],
                [ 'id' => 8, 'title' => 'Castle Byers', 'artist' => 'Kyle Dixon & Michael Stein', 'duration' => '', 'image' => 'stranger-things-piste.png' ],
                [ 'id' => 9, 'title' => 'Can’t Seem to Make You Mine', 'artist' => 'The Seeds', 'duration' => '', 'image' => 'stranger-things-piste.png' ],
                [ 'id' => 10, 'title' => 'She Has Funny Cars', 'artist' => 'Jefferson Airplane', 'duration' => '', 'image' => 'stranger-things-piste.png' ],
                [ 'id' => 11, 'title' => 'I Shall Not Care', 'artist' => 'Pearls Before Swine', 'duration' => '', 'image' => 'stranger-things-piste.png' ]
            ],
            2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => []
        ],
        2 => [1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => []],
        3 => [1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => []],
        4 => [1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => []],
    ],
    'euphoria' => [
        1 => [
            1 => [
                [ 'id' => 1, 'title' => 'Hold Up', 'artist' => 'Beyoncé', 'duration' => '3:41', 'image' => 'euphoria piste.png' ],
                [ 'id' => 2, 'title' => 'Can’t Get Used to Losing You', 'artist' => 'Andy Williams', 'duration' => '2:25', 'image' => 'euphoria piste.png' ],
                [ 'id' => 3, 'title' => 'The Only South I Know', 'artist' => 'Kofa', 'duration' => '2:50', 'image' => 'euphoria piste.png' ],
                [ 'id' => 4, 'title' => 'Getcha’ Weight Up (feat. Big Yae, CBM Muley & Cet Dollar)', 'artist' => 'Rockstar JT', 'duration' => '3:30', 'image' => 'euphoria piste.png' ],
                [ 'id' => 5, 'title' => 'Brighter Tomorrow', 'artist' => 'Soul Swingers', 'duration' => '2:20', 'image' => 'euphoria piste.png' ],
                [ 'id' => 6, 'title' => 'Once Again', 'artist' => 'Stratus', 'duration' => '3:00', 'image' => 'euphoria piste.png' ],
                [ 'id' => 7, 'title' => 'Beckham', 'artist' => 'Yung Baby Tate', 'duration' => '3:01', 'image' => 'euphoria piste.png' ],
                [ 'id' => 8, 'title' => 'Home', 'artist' => 'Audri & Aaron', 'duration' => '3:15', 'image' => 'euphoria piste.png' ],
                [ 'id' => 9, 'title' => 'I’m Gone', 'artist' => 'Jozzy & Tommy Genesis', 'duration' => '2:40', 'image' => 'euphoria piste.png' ],
                [ 'id' => 10, 'title' => 'Narcos', 'artist' => 'Migos', 'duration' => '3:14', 'image' => 'euphoria piste.png' ],
                [ 'id' => 11, 'title' => 'Feelings', 'artist' => 'Lil Dude', 'duration' => '2:40', 'image' => 'euphoria piste.png' ],
                [ 'id' => 12, 'title' => 'Secrets', 'artist' => 'Hass Irv', 'duration' => '3:00', 'image' => 'euphoria piste.png' ],
                [ 'id' => 13, 'title' => 'G.O.A.T.', 'artist' => 'Kenny Mason', 'duration' => '2:14', 'image' => 'euphoria piste.png' ],
                [ 'id' => 14, 'title' => 'Cocky AF', 'artist' => 'Megan Thee Stallion', 'duration' => '2:54', 'image' => 'euphoria piste.png' ],
                [ 'id' => 15, 'title' => '2 True', 'artist' => 'Nesha Nycee', 'duration' => '2:50', 'image' => 'euphoria piste.png' ],
                [ 'id' => 16, 'title' => 'I Know There’s Gonna Be (Good Times)', 'artist' => 'Jamie xx ft. Young Thug & Popcaan', 'duration' => '4:04', 'image' => 'euphoria piste.png' ],
                [ 'id' => 17, 'title' => 'New Level', 'artist' => 'A$AP Ferg ft. Future', 'duration' => '4:27', 'image' => 'euphoria piste.png' ],
                [ 'id' => 18, 'title' => 'Motivation', 'artist' => 'Sam Austins', 'duration' => '2:50', 'image' => 'euphoria piste.png' ],
                [ 'id' => 19, 'title' => 'Pusha', 'artist' => 'JAG', 'duration' => '3:00', 'image' => 'euphoria piste.png' ],
                [ 'id' => 20, 'title' => 'Billy Boy', 'artist' => '$NOT', 'duration' => '2:17', 'image' => 'euphoria piste.png' ],
                [ 'id' => 21, 'title' => 'Run Cried the Crawling', 'artist' => 'Agnes Obel', 'duration' => '4:08', 'image' => 'euphoria piste.png' ],
                [ 'id' => 22, 'title' => 'Snowflake', 'artist' => 'Jim Reeves', 'duration' => '2:53', 'image' => 'euphoria piste.png' ]
            ]
        ]
    ],
    // Ajoute ici d'autres séries si besoin
    'the-witcher' => [
        1 => [
            1 => [
                [ 'id' => 1, 'title' => 'The End’s Beginning', 'artist' => 'Sonya Belousova & Giona Ostinelli', 'duration' => '1:45', 'image' => 'the witcher piste.png' ],
                [ 'id' => 2, 'title' => 'Geralt of Rivia', 'artist' => 'Sonya Belousova & Giona Ostinelli', 'duration' => '3:09', 'image' => 'the witcher piste.png' ],
                [ 'id' => 3, 'title' => 'Ravix of Fourhorn', 'artist' => 'Sonya Belousova & Giona Ostinelli', 'duration' => '1:01', 'image' => 'the witcher piste.png' ],
                [ 'id' => 4, 'title' => 'The Lesser Evil', 'artist' => 'Sonya Belousova & Giona Ostinelli', 'duration' => '2:39', 'image' => 'the witcher piste.png' ],
                [ 'id' => 5, 'title' => 'Renfri', 'artist' => 'Sonya Belousova & Giona Ostinelli', 'duration' => '2:12', 'image' => 'the witcher piste.png' ],
                [ 'id' => 6, 'title' => 'Blaviken Inn', 'artist' => 'Sonya Belousova & Giona Ostinelli', 'duration' => '1:18', 'image' => 'the witcher piste.png' ],
                [ 'id' => 7, 'title' => 'Butcher of Blaviken', 'artist' => 'Sonya Belousova & Giona Ostinelli', 'duration' => '3:01', 'image' => 'the witcher piste.png' ],
                [ 'id' => 8, 'title' => 'Yennefer of Vengerberg', 'artist' => 'Sonya Belousova & Giona Ostinelli', 'duration' => '3:09', 'image' => 'the witcher piste.png' ],
                [ 'id' => 9, 'title' => 'The Girl in the Woods', 'artist' => 'Sonya Belousova & Giona Ostinelli', 'duration' => '1:55', 'image' => 'the witcher piste.png' ],
                [ 'id' => 10, 'title' => 'Cintra', 'artist' => 'Sonya Belousova & Giona Ostinelli', 'duration' => '1:45', 'image' => 'the witcher piste.png' ],
                [ 'id' => 11, 'title' => 'The Song of the White Wolf', 'artist' => 'Sonya Belousova & Giona Ostinelli', 'duration' => '1:32', 'image' => 'the witcher piste.png' ],
                [ 'id' => 12, 'title' => 'Toss a Coin to Your Witcher', 'artist' => 'Joey Batey / Sonya Belousova & Giona Ostinelli', 'duration' => '3:09', 'image' => 'the witcher piste.png' ]
            ],
            2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => []
        ],
        2 => [1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => []],
        3 => [1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => []]
    ],
];
$tracks_js = isset($all_tracks_data[$page_slug]) ? json_encode($all_tracks_data[$page_slug]) : '{}';
// Ajouter d'autres séries ici si besoin
?>
<script>
    // Chemin des images pour JavaScript
    const themeImagePath = '<?php echo esc_js(get_template_directory_uri()); ?>/assets/image/Piste séries/';
    // Structure dynamique des saisons/épisodes/pistes
    window.allTracks = <?php echo $tracks_js ? $tracks_js : '{}'; ?>;
</script>

<?php
get_footer();
?>
