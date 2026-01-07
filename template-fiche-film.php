<?php
// Récupérer les infos du film basé sur le slug
global $post;
$page_slug = isset($post->post_name) ? $post->post_name : 'inception';
add_filter('body_class', function($classes) use ($page_slug) {
    $classes[] = 'slug-' . $page_slug;
    return $classes;
});
/**
 * Template Name: Fiche Film
 * Template Post Type: page
 * Description: Template pour afficher la fiche détaillée d'un film
 */

get_header();
// Import du CSS harmonisé pour tous les carrousels

// Récupérer les infos du film basé sur le slug
global $post;
$page_slug = isset($post->post_name) ? $post->post_name : 'inception';

// Infos supplémentaires codées pour chaque film
$movie_info = array(
    'inception' => array(
        'duration' => '2h28',
        'rating' => '9/10',
        'director' => 'Christopher Nolan',
        'cast' => 'Leonardo DiCaprio, Joseph Gordon-Levitt, Elliot Page, Tom Hardy, Dileep Rao, Ken Watanabe',
        'synopsis' => 'Dom Cobb est un voleur expérimenté, considéré comme le meilleur dans l’art dangereux de l’extraction : il s’introduit dans le subconscient des gens via une technologie de rêve partagé pour voler leurs secrets quand leur esprit est le plus vulnérable. Recherché et fugitif à travers le monde, il a tout perdu de ce qu’il aimait. Une dernière mission pourrait lui permettre de retrouver sa vie d’avant : au lieu de subtiliser une idée, Cobb et son équipe doivent implanter une idée dans l’esprit d’une cible — une opération appelée inception. S’ils y parviennent, cela pourrait être le crime parfait, mais rien ne les avait préparés à un ennemi aussi redoutable, qui semble avoir systématiquement un temps d’avance.',
        'genres_display' => 'Action • Science-fiction • Thriller',
        'affiche' => 'inception affiche film.jpg',
        'year' => 2010
    ),
    'wicked' => array(
        'title' => 'Wicked',
        'duration' => '2h35',
        'rating' => '8,2/10',
        'director' => 'Jon M. Chu',
        'cast' => 'Cynthia Erivo, Ariana Grande, Jonathan Bailey, Ethan Slater',
        'synopsis' => 'Dans le pays d’Oz, Elphaba, une jeune femme incomprise à la peau verte, se lie d’amitié avec la populaire Glinda. Leur destin bascule lorsque le pouvoir, l’amour et la magie les opposent, révélant la véritable histoire des sorcières d’Oz.',
        'genres_display' => 'Comédie musicale • Fantastique • Aventure',
        'affiche' => 'wicked.jpg',
        'year' => 2024
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
    'spirited-away' => array(
        'duration' => '2h05',
        'rating' => '8,6/10',
        'director' => 'Hayao Miyazaki',
        'cast' => 'Rumi Hiiragi, Miyu Irino, Mari Natsuki, Takashi Naitô',
        'synopsis' => 'Chihiro, une fillette de 10 ans, découvre un monde magique dominé par des dieux, des sorcières et des esprits, où les humains sont transformés en bêtes. Pour sauver ses parents, elle devra faire preuve de courage et de persévérance.',
        'genres_display' => 'Animation • Aventure • Fantastique',
        'affiche' => 'chihiro.jpg',
        'year' => 2001
    ),
    'your-name' => array(
        'duration' => '1h46',
        'rating' => '8,4/10',
        'director' => 'Makoto Shinkai',
        'cast' => 'Ryûnosuke Kamiki, Mone Kamishiraishi, Ryô Narita, Aoi Yûki',
        'synopsis' => 'Deux lycéens, Mitsuha et Taki, vivent chacun dans une région différente du Japon et échangent mystérieusement leurs corps. Leur quête pour se retrouver bouleverse le temps et l’espace.',
        'genres_display' => 'Animation • Drame • Romance',
        'affiche' => 'your name.jpg',
        'year' => 2016
    ),
    'la-la-land' => array(
        'duration' => '2h08',
        'rating' => '8,0/10',
        'director' => 'Damien Chazelle',
        'cast' => 'Ryan Gosling, Emma Stone, John Legend, J.K. Simmons',
        'synopsis' => 'Mia, une actrice en devenir, et Sebastian, un passionné de jazz, tentent de réaliser leurs rêves à Los Angeles. Leur histoire d’amour est mise à l’épreuve par leurs ambitions.',
            'synopsis' => 'Au cœur de Los Angeles, Mia, une actrice en devenir, sert des cafés entre deux auditions. De son côté, Sebastian, passionné de jazz, joue du piano dans des clubs miteux pour joindre les deux bouts. Tous deux sont bien loin de la vie rêvée à laquelle ils aspirent… Le destin va réunir ces doux rêveurs, mais leur coup de foudre résistera-t-il aux tentations, aux déceptions et à la vie trépidante d’Hollywood ?',
        'genres_display' => 'Comédie musicale • Drame • Romance',
        'affiche' => 'La La Land.jpg',
        'year' => 2016
    ),
    'parasite' => array(
        'duration' => '2h12',
        'rating' => '8,6/10',
        'director' => 'Bong Joon-ho',
        'cast' => 'Song Kang-ho, Lee Sun-kyun, Cho Yeo-jeong, Choi Woo-shik',
        'synopsis' => 'Toute la famille de Ki-taek est au chômage, et s’intéresse fortement au train de vie de la richissime famille Park. Un jour, leur fils réussit à se faire recommander pour donner des cours particuliers d’anglais chez les Park. C’est le début d’un engrenage incontrôlable, dont personne ne sortira véritablement indemne…',
        'genres_display' => 'Thriller • Drame • Comédie noire',
        'affiche' => 'Parasite.jpg',
        'year' => 2019
    ),
    'interstellar' => array(
        'duration' => '2h49',
        'rating' => '8,6/10',
        'director' => 'Christopher Nolan',
        'cast' => 'Matthew McConaughey, Anne Hathaway, Jessica Chastain, Michael Caine',
        'synopsis' => 'Dans un futur proche, la Terre se meurt. Un groupe d’explorateurs utilise un trou de ver pour franchir les limites du voyage spatial humain et sauver l’humanité.',
        'genres_display' => 'Science-fiction • Drame • Aventure',
        'affiche' => 'Interstellar.jpg',
        'year' => 2014
    ),
);

// Ajouter les pistes pour chaque film
$movie_tracks = array(
            'spirited-away' => array(
                array('id' => 1, 'title' => 'One Summer’s Day', 'artist' => 'Joe Hisaishi', 'duration' => '2:25', 'cover' => 'spirited away piste.png'),
                array('id' => 2, 'title' => 'A Road to Somewhere', 'artist' => 'Joe Hisaishi', 'duration' => '3:46', 'cover' => 'spirited away piste.png'),
                array('id' => 3, 'title' => 'The Empty Restaurant', 'artist' => 'Joe Hisaishi', 'duration' => '3:27', 'cover' => 'spirited away piste.png'),
                array('id' => 4, 'title' => 'Nighttime Coming', 'artist' => 'Joe Hisaishi', 'duration' => '2:20', 'cover' => 'spirited away piste.png'),
                array('id' => 5, 'title' => 'Dragon Boy', 'artist' => 'Joe Hisaishi', 'duration' => '1:55', 'cover' => 'spirited away piste.png'),
                array('id' => 6, 'title' => 'Sootballs', 'artist' => 'Joe Hisaishi', 'duration' => '2:57', 'cover' => 'spirited away piste.png'),
                array('id' => 7, 'title' => 'Procession of the Gods', 'artist' => 'Joe Hisaishi', 'duration' => '3:00', 'cover' => 'spirited away piste.png'),
                array('id' => 8, 'title' => 'Yubaba', 'artist' => 'Joe Hisaishi', 'duration' => '2:38', 'cover' => 'spirited away piste.png'),
                array('id' => 9, 'title' => 'Bathhouse Morning', 'artist' => 'Joe Hisaishi', 'duration' => '2:42', 'cover' => 'spirited away piste.png'),
                array('id' => 10, 'title' => 'Day of the River', 'artist' => 'Joe Hisaishi', 'duration' => '3:05', 'cover' => 'spirited away piste.png'),
                array('id' => 11, 'title' => 'It’s Hard Work', 'artist' => 'Joe Hisaishi', 'duration' => '2:30', 'cover' => 'spirited away piste.png'),
                array('id' => 12, 'title' => 'The Stink Spirit', 'artist' => 'Joe Hisaishi', 'duration' => '3:20', 'cover' => 'spirited away piste.png'),
                array('id' => 13, 'title' => 'Sen’s Courage', 'artist' => 'Joe Hisaishi', 'duration' => '3:23', 'cover' => 'spirited away piste.png'),
                array('id' => 14, 'title' => 'The Sixth Station', 'artist' => 'Joe Hisaishi', 'duration' => '3:57', 'cover' => 'spirited away piste.png'),
                array('id' => 15, 'title' => 'Yubaba’s Panic', 'artist' => 'Joe Hisaishi', 'duration' => '1:48', 'cover' => 'spirited away piste.png'),
                array('id' => 16, 'title' => 'The House at Swamp Bottom', 'artist' => 'Joe Hisaishi', 'duration' => '2:50', 'cover' => 'spirited away piste.png'),
                array('id' => 17, 'title' => 'Reprise', 'artist' => 'Joe Hisaishi', 'duration' => '2:35', 'cover' => 'spirited away piste.png'),
                array('id' => 18, 'title' => 'The Return', 'artist' => 'Joe Hisaishi', 'duration' => '3:30', 'cover' => 'spirited away piste.png'),
                array('id' => 19, 'title' => 'Always with Me', 'artist' => 'Joe Hisaishi', 'duration' => '3:35', 'cover' => 'spirited away piste.png'),
            ),
        'your-name' => array(
            array('id' => 1, 'title' => 'Dream Lantern', 'artist' => 'RADWIMPS', 'duration' => '2:09', 'cover' => 'your name piste.png'),
            array('id' => 2, 'title' => 'School Road', 'artist' => 'RADWIMPS', 'duration' => '1:11', 'cover' => 'your name piste.png'),
            array('id' => 3, 'title' => 'Itomori High School', 'artist' => 'RADWIMPS', 'duration' => '1:37', 'cover' => 'your name piste.png'),
            array('id' => 4, 'title' => 'First View of Tokyo', 'artist' => 'RADWIMPS', 'duration' => '1:43', 'cover' => 'your name piste.png'),
            array('id' => 5, 'title' => 'Cafe at Last', 'artist' => 'RADWIMPS', 'duration' => '1:57', 'cover' => 'your name piste.png'),
            array('id' => 6, 'title' => 'Theme of Mitsuha', 'artist' => 'RADWIMPS', 'duration' => '2:28', 'cover' => 'your name piste.png'),
            array('id' => 7, 'title' => 'Unusual Changes of Two', 'artist' => 'RADWIMPS', 'duration' => '1:42', 'cover' => 'your name piste.png'),
            array('id' => 8, 'title' => 'Zenzenzense (movie ver.)', 'artist' => 'RADWIMPS', 'duration' => '4:46', 'cover' => 'your name piste.png'),
            array('id' => 9, 'title' => 'Goshintai', 'artist' => 'RADWIMPS', 'duration' => '2:01', 'cover' => 'your name piste.png'),
            array('id' => 10, 'title' => 'Date', 'artist' => 'RADWIMPS', 'duration' => '2:18', 'cover' => 'your name piste.png'),
            array('id' => 11, 'title' => 'Autumn Festival', 'artist' => 'RADWIMPS', 'duration' => '1:45', 'cover' => 'your name piste.png'),
            array('id' => 12, 'title' => 'Memories of Time', 'artist' => 'RADWIMPS', 'duration' => '1:47', 'cover' => 'your name piste.png'),
            array('id' => 13, 'title' => 'Visit to Hida', 'artist' => 'RADWIMPS', 'duration' => '2:11', 'cover' => 'your name piste.png'),
            array('id' => 14, 'title' => 'Disappeared Town', 'artist' => 'RADWIMPS', 'duration' => '2:50', 'cover' => 'your name piste.png'),
            array('id' => 15, 'title' => 'Library', 'artist' => 'RADWIMPS', 'duration' => '2:01', 'cover' => 'your name piste.png'),
            array('id' => 16, 'title' => 'Two People', 'artist' => 'RADWIMPS', 'duration' => '2:17', 'cover' => 'your name piste.png'),
            array('id' => 17, 'title' => 'Katawaredoki', 'artist' => 'RADWIMPS', 'duration' => '2:47', 'cover' => 'your name piste.png'),
            array('id' => 18, 'title' => 'Sparkle (movie ver.)', 'artist' => 'RADWIMPS', 'duration' => '8:54', 'cover' => 'your name piste.png'),
            array('id' => 19, 'title' => 'Date 2', 'artist' => 'RADWIMPS', 'duration' => '2:18', 'cover' => 'your name piste.png'),
            array('id' => 20, 'title' => 'Nandemonaiya (movie ver.)', 'artist' => 'RADWIMPS', 'duration' => '5:45', 'cover' => 'your name piste.png'),
            array('id' => 21, 'title' => 'Dreams of Tomorrow', 'artist' => 'RADWIMPS', 'duration' => '1:55', 'cover' => 'your name piste.png'),
            array('id' => 22, 'title' => 'Reunion', 'artist' => 'RADWIMPS', 'duration' => '1:26', 'cover' => 'your name piste.png'),
            array('id' => 23, 'title' => 'Epilogue', 'artist' => 'RADWIMPS', 'duration' => '2:21', 'cover' => 'your name piste.png')
        ),
    'inception' => array(
        array('id' => 1, 'title' => 'Half Remembered Dream'),
        array('id' => 2, 'title' => 'We Built Our Own World'),
        array('id' => 3, 'title' => 'Dream Is Collapsing'),
        array('id' => 4, 'title' => 'Radical Notion'),
        array('id' => 5, 'title' => 'Old Souls'),
        array('id' => 6, 'title' => '528491'),
        array('id' => 7, 'title' => 'Mombasa'),
        array('id' => 8, 'title' => 'One Simple Idea'),
        array('id' => 9, 'title' => 'Dream Within a Dream'),
        array('id' => 10, 'title' => 'Waiting for a Train'),
        array('id' => 11, 'title' => 'Paradox'),
        array('id' => 12, 'title' => 'Time'),
    ),
    'la-la-land' => array(
        array('id' => 1, 'title' => 'Another Day of Sun'),
        array('id' => 2, 'title' => 'Someone in the Crowd'),
        array('id' => 3, 'title' => "Mia & Sebastian's Theme"),
        array('id' => 4, 'title' => 'A Lovely Night'),
        array('id' => 5, 'title' => "Herman's Habit"),
        array('id' => 6, 'title' => 'City of Stars (Pier)'),
        array('id' => 7, 'title' => 'Planetarium'),
        array('id' => 8, 'title' => 'Summer Montage / Madeline'),
        array('id' => 9, 'title' => 'City of Stars (Duet)'),
        array('id' => 10, 'title' => 'Start a Fire'),
        array('id' => 11, 'title' => 'Engagement Party'),
        array('id' => 12, 'title' => 'Audition (The Fools Who Dream)'),
        array('id' => 13, 'title' => 'Epilogue'),
        array('id' => 14, 'title' => 'The End'),
        array('id' => 15, 'title' => 'City of Stars (Humming)'),
    ),
    'parasite' => array(
        array('id' => 1, 'title' => 'Opening'),
        array('id' => 2, 'title' => 'Conciliation I'),
        array('id' => 3, 'title' => 'On the Way to Rich House'),
        array('id' => 4, 'title' => 'Conciliation II'),
        array('id' => 5, 'title' => 'Plum Juice'),
        array('id' => 6, 'title' => 'Mr. Yoon and Park'),
        array('id' => 7, 'title' => 'Conciliation III'),
        array('id' => 8, 'title' => 'The Belt of Faith'),
        array('id' => 9, 'title' => 'Moon Gwang Left'),
        array('id' => 10, 'title' => 'Camping'),
        array('id' => 11, 'title' => 'The Hellgate'),
        array('id' => 12, 'title' => 'Heartrending Story of Bubu'),
        array('id' => 13, 'title' => 'Zappaguri'),
        array('id' => 14, 'title' => 'Ghost'),
        array('id' => 15, 'title' => 'The Family Is Busy'),
        array('id' => 16, 'title' => 'Busy to Survive'),
        array('id' => 17, 'title' => 'The Frontal Lobe of Ki Taek'),
        array('id' => 18, 'title' => 'Water, Ocean'),
        array('id' => 19, 'title' => 'Water, Ocean Again'),
        array('id' => 20, 'title' => 'It Is Sunday Morning'),
        array('id' => 21, 'title' => 'Blood and Sword'),
        array('id' => 22, 'title' => 'Yasan'),
        array('id' => 23, 'title' => 'Moving'),
        array('id' => 24, 'title' => 'Ending'),
        array('id' => 25, 'title' => 'Soju One Glass'),
        array('id' => 26, 'title' => 'Extraits de Rodelinda'),
        array('id' => 27, 'title' => 'In ginocchio da te'),
    ),
    'interstellar' => array(
        array('id' => 1, 'title' => 'Dreaming of the Crash'),
        array('id' => 2, 'title' => 'Cornfield Chase'),
        array('id' => 3, 'title' => 'Dust'),
        array('id' => 4, 'title' => 'Day One'),
        array('id' => 5, 'title' => 'Message from Home'),
        array('id' => 6, 'title' => 'The Wormhole'),
        array('id' => 7, 'title' => 'Mountains'),
        array('id' => 8, 'title' => 'Afraid of Time'),
        array('id' => 9, 'title' => 'Detach'),
        array('id' => 10, 'title' => 'Running Out'),
        array('id' => 11, 'title' => 'Tick-Tock'),
        array('id' => 12, 'title' => "Where We're Going"),
        array('id' => 13, 'title' => 'Do Not Go Gentle'),
        array('id' => 14, 'title' => 'No Time for Caution'),
        array('id' => 15, 'title' => 'Murph'),
        array('id' => 16, 'title' => 'Stay')
    ),
    'arrival' => array(
        array('id' => 1, 'title' => 'On the Nature of Daylight'),
        array('id' => 2, 'title' => 'Arrival'),
        array('id' => 3, 'title' => 'Heptapod B'),
        array('id' => 4, 'title' => 'Sapir-Whorf'),
        array('id' => 5, 'title' => 'Transmutation at a Distance'),
        array('id' => 6, 'title' => 'Logograms'),
        array('id' => 7, 'title' => 'Decyphering'),
        array('id' => 8, 'title' => 'Kangaru'),
        array('id' => 9, 'title' => 'Hydraulic Lift'),
        array('id' => 10, 'title' => 'First Encounter'),
        array('id' => 11, 'title' => 'Strange Atmosphere'),
        array('id' => 12, 'title' => 'Ultimatum'),
        array('id' => 13, 'title' => 'Hitting the Egg'),
        array('id' => 14, 'title' => 'The Casio'),
        array('id' => 15, 'title' => 'One of Twelve'),
        array('id' => 16, 'title' => 'Rise'),
        array('id' => 17, 'title' => 'Extreme Hectopods'),
        array('id' => 18, 'title' => 'This Is Not a Dream'),
        array('id' => 19, 'title' => 'War'),
        array('id' => 20, 'title' => 'Birth')
    ),
);


if (isset($movie_info[$page_slug])) {
    $info = $movie_info[$page_slug];
    // Use the actual movie title from the info array if available, else fallback to slug
    if (isset($info['title']) && !empty($info['title'])) {
        $title = $info['title'];
    } else {
        $title = ucwords(str_replace('-', ' ', $page_slug));
    }
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

// Calculer le nombre de pistes
$num_tracks = 12; // Default
if (isset($movie_tracks[$page_slug])) {
    $num_tracks = count($movie_tracks[$page_slug]);
}

?>

<!-- ===== CONTENU FICHE FILM ===== -->
<main class="movie-page container py-5">

    <!-- TITRE + INFOS GENERALES -->
    <section class="movie-header">
        <h1 class="fw-bold mb-1">
            <?php echo esc_html($title); ?>
        </h1>
        <p class="movie-sub small text-secondary mb-4"><?php echo esc_html($year); ?> – <?php echo intval($num_tracks); ?> piste<?php echo $num_tracks > 1 ? 's' : ''; ?></p>

        <div class="row g-4">
            <!-- POSTER -->
            <div class="col-md-4 col-lg-3">
                <div class="movie-poster-wrapper text-center text-md-start">
                    <?php 
                    $poster_url = get_template_directory_uri() . '/assets/image/Fiche films/' . $affiche;
                    ?>
                    <img src="<?php echo esc_url($poster_url); ?>" alt="Affiche <?php echo esc_attr($title); ?>"
                         class="movie-poster img-fluid shadow" id="moviePosterImg">
                    <button id="movieLikeBtn" class="like-btn movie-like-btn p-0"
                        data-type="films"
                        data-id="<?php echo esc_attr($page_slug); ?>"
                        data-movie-title="<?php echo esc_attr($title); ?>"
                        data-movie-image="<?php echo esc_attr($affiche); ?>"
                        aria-pressed="false" type="button">
                        <svg class="svg-heart-main" viewBox="0 0 24 24" width="38" height="38" aria-hidden="true" focusable="false">
                            <path class="svg-heart-shape" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- SYNOPSIS + META -->
            <div class="col-md-8 col-lg-9">
                <h5 class="mb-2 movie-section-label">SYNOPSIS</h5>
                <p class="movie-synopsis small text-light mb-4">
                    <?php echo esc_html($info['synopsis']); ?>
                </p>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var btn = document.querySelector('.show-more-synopsis');
                    if (btn) {
                        btn.addEventListener('click', function() {
                            var short = document.querySelector('.synopsis-short');
                            var full = document.querySelector('.synopsis-full');
                            if (short && full) {
                                short.style.display = 'none';
                                full.style.display = 'inline';
                                btn.style.display = 'none';
                            }
                        });
                    }
                });
                </script>
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
    <section class="movie-section">
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
    <section class="movie-section">
        <h3 class="section-title mb-3 film-section-title">Commentaires</h3>

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
    <section class="movie-section">
        <h3 class="section-title mb-3 film-section-title">Films similaires</h3>
        <div class="movies-carousel d-flex align-items-center">
            <button class="carousel-arrow left d-flex align-items-center justify-content-center" type="button">❮</button>
            <div class="row flex-grow-1 mx-3 g-3" id="similarMovies">
                <!-- JS insère 4 films -->
            </div>
            <button class="carousel-arrow right d-flex align-items-center justify-content-center" type="button">❯</button>
        </div>
    </section>



</main>

<script>
    // Chemin des images pour JavaScript
    const themeImagePath = '<?php echo esc_js(get_template_directory_uri()); ?>/assets/image/Fiche films/';
    const themeTrackImagePath = '<?php echo esc_js(get_template_directory_uri()); ?>/assets/image/Pistes film/';
    window.currentMovieSlug = '<?php echo esc_js($page_slug); ?>';
    window.movieTracks = <?php echo json_encode($movie_tracks[$page_slug] ?? []); ?>;
</script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/front-page.js"></script>

<!-- DEBUG: Vérification présence bouton like-btn -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var btn = document.querySelector('.like-btn');
    console.log('[DEBUG HTML] Bouton .like-btn trouvé ?', !!btn, btn);
});
</script>

<!-- Place JS d'init à la toute fin -->
<script>
window.cinemusicAjax = {
    ajaxurl: '<?php echo admin_url('admin-ajax.php'); ?>'
};
</script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/front-page.js"></script>
<script>
if(typeof initHearts==='function'){initHearts();}
</script>




<?php get_footer(); ?>
