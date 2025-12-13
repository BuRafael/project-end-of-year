<?php
/**
 * Template Name: Fiche Film
 * Template Post Type: page
 * Description: Template pour afficher la fiche détaillée d'un film
 */

get_header();

// Récupérer les infos du film basé sur le slug
global $post;
$page_slug = isset($post->post_name) ? $post->post_name : 'inception';

// Infos supplémentaires codées pour chaque film
$movie_info = array(
    'inception' => array(
        'duration' => '2h28',
        'rating' => '8,8/10',
        'director' => 'Christopher Nolan',
        'cast' => 'Leonardo DiCaprio, Joseph Gordon-Levitt, Elliot Page, Tom Hardy, Dileep Rao, Ken Watanabe',
        'synopsis' => 'Dom Cobb est un voleur expérimenté dans l\'art périlleux de l\'extraction : sa spécialité consiste à s\'approprier les secrets les plus précieux d\'un individu, enfouis au plus profond de son subconscient, pendant qu\'il rêve et que son esprit est particulièrement vulnérable. Très recherché pour ses talents dans l\'univers trouble de l\'espionnage industriel, Cobb est aussi devenu un fugitif traqué dans le monde entier. Cependant, une ultime mission pourrait lui permettre de retrouver sa vie d\'avant.',
        'genres_display' => 'Action • Science-fiction • Thriller',
        'affiche' => 'inception affiche film.jpg',
        'year' => 2010
    ),
    'la-la-land' => array(
        'duration' => '2h08',
        'rating' => '8,0/10',
        'director' => 'Damien Chazelle',
        'cast' => 'Ryan Gosling, Emma Stone, John Legend, Rosemarie DeWitt',
        'synopsis' => 'Mia, une actrice en herbe qui sert les clients d\'un café sur les plateaux de cinéma, rencontre Sebastian, un pianiste de jazz passionné. Tous deux rêvent de réussir dans leurs domaines respectifs. Avec l\'aide l\'un de l\'autre, ils se soutiennent et s\'inspirent mutuellement, naviguant dans l\'industrie du divertissement de Los Angeles tout en approfondissant leur relation amoureuse.',
        'genres_display' => 'Comédie • Drame • Musical • Romance',
        'affiche' => 'La La Land.jpg',
        'year' => 2016
    ),
    'parasite' => array(
        'duration' => '2h12',
        'rating' => '8,5/10',
        'director' => 'Bong Joon-ho',
        'cast' => 'Song Kang-ho, Lee Sun-kyun, Cho Yeo-jeong, Choi Woo-shik, Park So-dam',
        'synopsis' => 'Toute la famille de Ki-taek est au chômage, et s\'intéresse fortement au train de vie de la richissime famille Park. Un jour, leur fils réussit à se faire recommander pour donner des cours particuliers d\'anglais chez les Park. C\'est le début d\'un engrenage incontrôlable, dont personne ne sortira véritablement indemne.',
        'genres_display' => 'Thriller • Drame • Comédie noire',
        'affiche' => 'Parasite.jpg',
        'year' => 2019
    ),
    'interstellar' => array(
        'duration' => '2h49',
        'rating' => '8,6/10',
        'director' => 'Christopher Nolan',
        'cast' => 'Matthew McConaughey, Anne Hathaway, Jessica Chastain, Michael Caine',
        'synopsis' => 'Dans un futur proche, la Terre est devenue hostile à toute forme de vie. Un groupe d\'explorateurs utilise un vaisseau interstellaire récemment découvert pour repousser les limites humaines et partir à la conquête des distances astronomiques dans un voyage interstellaire.',
        'genres_display' => 'Science-fiction • Drame • Aventure',
        'affiche' => 'Interstellar.jpg',
        'year' => 2014
    ),
    'arrival' => array(
        'duration' => '1h56',
        'rating' => '7,9/10',
        'director' => 'Denis Villeneuve',
        'cast' => 'Amy Adams, Jeremy Renner, Forest Whitaker, Michael Stuhlbarg',
        'synopsis' => 'Lorsque de mystérieux vaisseaux venus du fond de l\'espace surgissent un peu partout sur Terre, une équipe d\'experts est rassemblée sous la direction de la linguiste Louise Banks afin de tenter de comprendre leurs intentions. Face à l\'énigme que constituent leur présence et leurs messages mystérieux, les réactions dans le monde sont contrastées et l\'humanité se trouve bientôt au bord d\'une guerre absolue.',
        'genres_display' => 'Science-fiction • Drame • Thriller',
        'affiche' => 'Arrival.webp',
        'year' => 2016
    ),
    'wicked' => array(
        'duration' => '2h40',
        'rating' => '8,2/10',
        'director' => 'Jon M. Chu',
        'cast' => 'Cynthia Erivo, Ariana Grande, Jonathan Bailey, Michelle Yeoh',
        'synopsis' => 'L\'histoire méconnue des sorcières du Pays d\'Oz. Avant que Dorothy n\'arrive du Kansas, deux jeunes femmes se rencontrent à l\'Université de Shiz. L\'une, née avec une peau vert émeraude, est intelligente et incomprise. L\'autre est belle, ambitieuse et très populaire. Comment sont-elles devenues Glinda la Bonne et la Méchante Sorcière de l\'Ouest ?',
        'genres_display' => 'Fantasy • Musical • Romance',
        'affiche' => 'inception affiche film.jpg',
        'year' => 2024
    ),
    'your-name' => array(
        'duration' => '1h46',
        'rating' => '8,4/10',
        'director' => 'Makoto Shinkai',
        'cast' => 'Ryūnosuke Kamiki, Mone Kamishiraishi, Ryō Narita, Aoi Yūki',
        'synopsis' => 'Mitsuha, une lycéenne coincée dans une petite ville de montagne, et Taki, un lycéen de Tokyo, se retrouvent mystérieusement liés. Quand un jour ils se réveillent dans le corps de l\'autre, cette connexion étrange va bouleverser leurs vies.',
        'genres_display' => 'Animation • Romance • Fantasy',
        'affiche' => 'your name.jpg',
        'year' => 2016
    ),
    'chihiro' => array(
        'duration' => '2h05',
        'rating' => '8,6/10',
        'director' => 'Hayao Miyazaki',
        'cast' => 'Rumi Hiiragi, Miyu Irino, Mari Natsuki, Takashi Naitō',
        'synopsis' => 'Chihiro, 10 ans, a tout d\'une petite fille capricieuse. Elle s\'apprête à emménager avec ses parents dans une nouvelle demeure. Sur la route, la petite famille se retrouve face à un immense bâtiment. Le père décide de visiter les lieux, mais très vite, la promenade tourne au cauchemar : les parents de Chihiro sont transformés en cochons.',
        'genres_display' => 'Animation • Aventure • Fantasy',
        'affiche' => 'chihiro.jpg',
        'year' => 2001
    ),
    'attaque-des-titans' => array(
        'duration' => '1h54',
        'rating' => '8,1/10',
        'director' => 'Hajime Isayama',
        'cast' => 'Yūki Kaji, Marina Inoue, Yui Ishikawa, Hiroshi Kamiya',
        'synopsis' => 'Il y a plus d\'un siècle, l\'humanité a été presque entièrement décimée par des titans, des créatures gigantesques apparemment dénuées d\'intelligence. Les survivants se sont barricadés dans une cité protégée par des murailles. Mais un jour, un titan colossal défonce la première muraille...',
        'genres_display' => 'Animation • Action • Dark Fantasy',
        'affiche' => 'attack on titan.jpg',
        'year' => 2013
    ),
    'demon-slayer' => array(
        'duration' => '1h57',
        'rating' => '8,3/10',
        'director' => 'Koyoharu Gotouge',
        'cast' => 'Natsuki Hanae, Akari Kitō, Yoshitsugu Matsuoka, Hiro Shimono',
        'synopsis' => 'Depuis les temps anciens, il existe des rumeurs concernant des démons mangeurs d\'hommes qui se cachent dans les bois. Tanjiro Kamado vit dans les montagnes avec sa famille. Un jour, il rentre chez lui pour découvrir que toute sa famille a été massacrée par un démon. Sa petite sœur Nezuko est la seule survivante, mais elle a été transformée en démon.',
        'genres_display' => 'Animation • Action • Fantasy',
        'affiche' => 'demon slayer.jpg',
        'year' => 2019
    ),
    'jujutsu-kaisen' => array(
        'duration' => '1h45',
        'rating' => '8,5/10',
        'director' => 'Gege Akutami',
        'cast' => 'Junya Enoki, Yūma Uchida, Asami Seto, Mikako Komatsu',
        'synopsis' => 'Yûji Itadori, un lycéen au talent athlétique exceptionnel, vit avec son grand-père dans une ville de province. Avant de mourir, ce dernier lui transmet deux messages importants : "aide toujours les gens" et "meurs entouré de gens". Un soir, des monstres appelés Fléaux, attirés par un objet maudit, se manifestent dans son lycée...',
        'genres_display' => 'Animation • Action • Fantasy',
        'affiche' => 'jujutsu kaisen.jpg',
        'year' => 2020
    )
);

// Définir les variables à partir du tableau $movie_info
if (isset($movie_info[$page_slug])) {
    $info = $movie_info[$page_slug];
    $title = ucwords(str_replace('-', ' ', $page_slug));
    $year = $info['year'];
    $affiche = $info['affiche'];
    $genre = $info['genres_display'];
} else {
    // Fallback sur Inception si le film n'existe pas
    $title = 'Inception';
    $year = 2010;
    $affiche = 'inception affiche film.jpg';
    $genre = 'Action';
    $info = $movie_info['inception'];
}

?>

<!-- ===== CONTENU FICHE FILM ===== -->
<main class="movie-page container py-5">

    <!-- TITRE + INFOS GENERALES -->
    <section class="movie-header mb-5">
        <h1 class="fw-bold mb-1"><?php echo esc_html($title); ?></h1>
        <p class="movie-sub small text-secondary mb-4"><?php echo esc_html($year); ?> – 12 pistes</p>

        <div class="row g-4">
            <!-- POSTER -->
            <div class="col-md-4 col-lg-3">
                <div class="movie-poster-wrapper text-center text-md-start">
                    <?php 
                    $poster_url = get_template_directory_uri() . '/assets/image/Fiche films/' . $affiche;
                    ?>
                    <img src="<?php echo esc_url($poster_url); ?>" alt="Affiche <?php echo esc_attr($title); ?>"
                         class="movie-poster img-fluid shadow">
                    <button id="movieLikeBtn" class="movie-like-btn p-0" aria-pressed="false" type="button">
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
                        <div class="movie-meta-label" style="color: rgba(112, 1, 24, 1);">Durée</div>
                        <div class="movie-meta-value"><?php echo esc_html($info['duration']); ?></div>
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

    <!-- ===== FILMS SIMILAIRES ===== -->
    <section class="movie-section mt-5 mb-4">
        <h3 class="section-title mb-3">Films similaires</h3>

        <div class="d-flex align-items-center">
            <button class="carousel-arrow d-flex align-items-center justify-content-center">
                <i class="bi bi-chevron-left"></i>
            </button>

            <div class="row flex-grow-1 mx-3 g-3" id="similarMovies">
                <!-- JS insère 4 films -->
            </div>

            <button class="carousel-arrow d-flex align-items-center justify-content-center" type="button">
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
            <?php if (!is_user_logged_in()) : ?>
                <?php echo cinemusic_signup_button(); ?>
            <?php endif; ?>
        </div>
    </section>

</main>

<script>
    // Chemin des images pour JavaScript
    const themeImagePath = '<?php echo esc_js(get_template_directory_uri()); ?>/assets/image/Fiche films/';
    const themeTrackImagePath = '<?php echo esc_js(get_template_directory_uri()); ?>/assets/image/Pistes film/';
    window.currentMovieSlug = '<?php echo esc_js($page_slug); ?>';
</script>

<?php
get_footer();
?>
