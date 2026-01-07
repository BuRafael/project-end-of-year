<?php


// Fonction temporaire pour créer les pages manquantes
function cinemusic_create_missing_pages() {
    $pages = array(
        array('title' => 'La La Land', 'slug' => 'la-la-land', 'template' => 'template-fiche-film.php'),
        array('title' => 'Parasite', 'slug' => 'parasite', 'template' => 'template-fiche-film.php'),
        array('title' => 'Interstellar', 'slug' => 'interstellar', 'template' => 'template-fiche-film.php'),
    );
    
    $results = array();
    foreach ($pages as $page) {
        $exists = get_page_by_path($page['slug']);
        
        if (!$exists) {
            $id = wp_insert_post(array(
                'post_title' => $page['title'],
                'post_name' => $page['slug'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'comment_status' => 'closed',
                'ping_status' => 'closed'
            ));
            
            if ($id) {
                update_post_meta($id, '_wp_page_template', $page['template']);
                $results[] = 'Créé: ' . $page['title'] . ' (ID: ' . $id . ')';
            }
        } else {
            update_post_meta($exists->ID, '_wp_page_template', $page['template']);
            $results[] = 'Existe: ' . $page['title'];
        }
    }
    
    return $results;
}
// DÉCOMMENTER LA LIGNE SUIVANTE, VISITER LE SITE, PUIS RE-COMMENTER
// add_action('wp_footer', function() { echo '<!-- Pages créées: ' . implode(', ', cinemusic_create_missing_pages()) . ' -->'; });

// Custom Post Type Films
function register_films_post_type() {
    register_post_type('films', [
        'label' => 'Films',
        'public' => true,
        'show_in_menu' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'films'],
    ]);
}
add_action('init', 'register_films_post_type');

// Custom Post Type Series
function register_series_post_type() {
    register_post_type('series', [
        'label' => 'Séries',
        'public' => true,
        'show_in_menu' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'series'],
    ]);
}
add_action('init', 'register_series_post_type');
// Création de la table de likes pour les commentaires de films
if (!function_exists('create_movie_comment_likes_table')) {
    function create_movie_comment_likes_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'movie_comment_likes';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            comment_id BIGINT UNSIGNED NOT NULL,
            user_id BIGINT UNSIGNED NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY unique_like (comment_id, user_id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    add_action('after_switch_theme', 'create_movie_comment_likes_table');
}
// === FAVORIS UTILISATEUR : API AJAX ===
add_action('wp_ajax_get_user_favorites', 'cinemusic_get_user_favorites');
add_action('wp_ajax_add_user_favorite', 'cinemusic_add_user_favorite');
add_action('wp_ajax_remove_user_favorite', 'cinemusic_remove_user_favorite');

function cinemusic_get_user_favorites() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Non connecté.']);
    }
    $user_id = get_current_user_id();
    $favorites = get_user_meta($user_id, 'cinemusic_favorites', true);
    if (!is_array($favorites)) {
        $favorites = [
            'films' => [],
            'series' => [],
            'musiques' => []
        ];
    }

    // Helper pour enrichir les favoris (accepte ID ou slug)
    function enrich_favoris($ids, $type) {
        $result = [];
        foreach ($ids as $id) {
            if (empty($id)) continue;
            if (is_numeric($id)) {
                $post = get_post($id);
            } else {
                $post = get_page_by_path($id, OBJECT, $type);
                if (!$post && $type !== 'series') {
                    // Try series post type if not found and not already series
                    $post = get_page_by_path($id, OBJECT, 'series');
                }
            }
            if (!$post) continue;
            $title = get_the_title($post->ID);
            $url = get_permalink($post->ID);
            $slug = $post->post_name;
            // Récupérer l'image à la une
            $image = get_the_post_thumbnail_url($post->ID, 'medium');
            if (!$image) {
                $theme_dir = get_template_directory_uri();
                $image_map = array(
                    'breaking-bad' => $theme_dir . '/assets/image/Front Page/breaking bad.webp',
                    'euphoria' => $theme_dir . '/assets/image/Front Page/Euphoria.jpg',
                    'wednesday' => $theme_dir . '/assets/image/Front Page/Wednesday.jpg',
                    'the-witcher' => $theme_dir . '/assets/image/Front Page/the witcher.webp',
                    'stranger-things' => $theme_dir . '/assets/image/Front Page/Stranger Things.jpg',
                    'spirited-away' => $theme_dir . '/assets/image/Front Page/Chihiro.jpg',
                    'chihiro' => $theme_dir . '/assets/image/Front Page/Chihiro.jpg',
                    'attack-on-titan' => $theme_dir . '/assets/image/Front Page/attack on titan.jpg',
                    'attaque-des-titans' => $theme_dir . '/assets/image/Front Page/Attaque des titans.jpg',
                    'lattaque-des-titans' => $theme_dir . '/assets/image/Front Page/Attaque des titans.jpg',
                    'demon-slayer' => $theme_dir . '/assets/image/Front Page/Demon Slayer.jpg',
                    'jujutsu-kaisen' => $theme_dir . '/assets/image/Front Page/jujutsu kaisen.jpg',
                    'your-name' => $theme_dir . '/assets/image/Front Page/Your Name.jpg',
                    'la-la-land' => $theme_dir . '/assets/image/Front Page/La La Land.jpg',
                    'inception' => $theme_dir . '/assets/image/Front Page/Inception.jpg',
                    'interstellar' => $theme_dir . '/assets/image/Front Page/Interstellar.jpg',
                    'parasite' => $theme_dir . '/assets/image/Front Page/Parasite.jpg',
                    'arrival' => $theme_dir . '/assets/image/Front Page/Arrival.webp',
                );
                
                if (isset($image_map[$slug])) {
                    $image = $image_map[$slug];
                } else {
                    // Fallback: chercher dans Front Page d'abord
                    $possible_paths = array(
                        $theme_dir . '/assets/image/Front Page/' . $slug . '.jpg',
                        $theme_dir . '/assets/image/Front Page/' . $slug . '.webp',
                        $theme_dir . '/assets/image/Front Page/' . $slug . '.png',
                    );
                    $image = $possible_paths[0]; // Utiliser le premier par défaut
                }
            }
            
            $year = get_post_meta($id, 'annee', true);
            if (!$year && ($type === 'films' || $type === 'series')) {
                $year = get_the_date('Y', $id);
            }
            $result[] = [
                'id' => $id,
                'title' => $title,
                'url' => $url,
                'image' => $image,
                'year' => $year
            ];
        }
        return $result;
    }

    // Pour musiques, enrichir les infos à partir des IDs composites (slug-id)
    $musiques = [];
    $debug_musiques_ids = [];
    $debug_musiques_found = [];
    
    // Fonction helper pour obtenir les pistes de séries
    function get_series_tracks() {
        return array(
            'breaking-bad' => array(
                1 => array(
                    1 => array(
                        array('id' => '1', 'title' => 'Breaking Bad Main Title Theme', 'artist' => 'Dave Porter', 'duration' => '0:56', 'image' => 'Breaking bad piste.png'),
                        array('id' => '2', 'title' => 'Out of Time Man', 'artist' => 'Mick Harvey', 'duration' => '3:34', 'image' => 'Breaking bad piste.png'),
                        array('id' => '3', 'title' => 'Frenesi', 'artist' => 'Artie Shaw', 'duration' => '2:29', 'image' => 'Breaking bad piste.png'),
                        array('id' => '4', 'title' => 'Negro Y Azul: The Ballad of Heisenberg', 'artist' => 'Los Cuates de Sinaloa', 'duration' => '2:16', 'image' => 'Breaking bad piste.png'),
                        array('id' => '5', 'title' => 'Fallacies', 'artist' => 'Twaughthammer', 'duration' => '2:10', 'image' => 'Breaking bad piste.png'),
                        array('id' => '6', 'title' => 'The Morning After', 'artist' => 'Dave Porter', 'duration' => '1:45', 'image' => 'Breaking bad piste.png')
                    )
                )
            ),
            'stranger-things' => array(
                1 => array(
                    1 => array(
                        array('id' => '1', 'title' => 'Stranger Things', 'artist' => 'Kyle Dixon & Michael Stein', 'duration' => '1:12', 'image' => 'stranger-things-piste.png'),
                        array('id' => '2', 'title' => 'Kids', 'artist' => 'Kyle Dixon & Michael Stein', 'duration' => '2:45', 'image' => 'stranger-things-piste.png'),
                        array('id' => '3', 'title' => 'Nancy and Barb', 'artist' => 'Kyle Dixon & Michael Stein', 'duration' => '2:30', 'image' => 'stranger-things-piste.png'),
                        array('id' => '4', 'title' => 'This Isn\'t You', 'artist' => 'Kyle Dixon & Michael Stein', 'duration' => '2:15', 'image' => 'stranger-things-piste.png'),
                        array('id' => '5', 'title' => 'Lay-Z-Boy', 'artist' => 'Kyle Dixon & Michael Stein', 'duration' => '1:50', 'image' => 'stranger-things-piste.png'),
                        array('id' => '6', 'title' => 'Friendship', 'artist' => 'Kyle Dixon & Michael Stein', 'duration' => '2:20', 'image' => 'stranger-things-piste.png'),
                        array('id' => '7', 'title' => 'Eleven', 'artist' => 'Kyle Dixon & Michael Stein', 'duration' => '3:10', 'image' => 'stranger-things-piste.png'),
                        array('id' => '8', 'title' => 'Castle Byers', 'artist' => 'Kyle Dixon & Michael Stein', 'duration' => '2:05', 'image' => 'stranger-things-piste.png'),
                        array('id' => '9', 'title' => 'Can\'t Seem to Make You Mine', 'artist' => 'The Seeds', 'duration' => '2:35', 'image' => 'stranger-things-piste.png'),
                        array('id' => '10', 'title' => 'She Has Funny Cars', 'artist' => 'Jefferson Airplane', 'duration' => '2:58', 'image' => 'stranger-things-piste.png'),
                        array('id' => '11', 'title' => 'I Shall Not Care', 'artist' => 'Pearls Before Swine', 'duration' => '3:20', 'image' => 'stranger-things-piste.png')
                    )
                )
            ),
            'euphoria' => array(
                1 => array(
                    1 => array(
                        array('id' => '1', 'title' => 'Hold Up', 'artist' => 'Beyoncé', 'duration' => '3:41', 'image' => 'euphoria piste.png'),
                        array('id' => '2', 'title' => 'Can\'t Get Used to Losing You', 'artist' => 'Andy Williams', 'duration' => '2:25', 'image' => 'euphoria piste.png'),
                        array('id' => '3', 'title' => 'The Only South I Know', 'artist' => 'Kofa', 'duration' => '2:50', 'image' => 'euphoria piste.png'),
                        array('id' => '4', 'title' => 'Getcha\' Weight Up', 'artist' => 'Rockstar JT', 'duration' => '3:30', 'image' => 'euphoria piste.png'),
                        array('id' => '5', 'title' => 'Brighter Tomorrow', 'artist' => 'Soul Swingers', 'duration' => '2:20', 'image' => 'euphoria piste.png'),
                        array('id' => '6', 'title' => 'Once Again', 'artist' => 'Stratus', 'duration' => '3:00', 'image' => 'euphoria piste.png'),
                        array('id' => '7', 'title' => 'Beckham', 'artist' => 'Yung Baby Tate', 'duration' => '3:01', 'image' => 'euphoria piste.png'),
                        array('id' => '8', 'title' => 'Home', 'artist' => 'Audri & Aaron', 'duration' => '3:15', 'image' => 'euphoria piste.png'),
                        array('id' => '9', 'title' => 'I\'m Gone', 'artist' => 'Jozzy & Tommy Genesis', 'duration' => '2:40', 'image' => 'euphoria piste.png'),
                        array('id' => '10', 'title' => 'Narcos', 'artist' => 'Migos', 'duration' => '3:14', 'image' => 'euphoria piste.png'),
                        array('id' => '11', 'title' => 'Feelings', 'artist' => 'Lil Dude', 'duration' => '2:40', 'image' => 'euphoria piste.png'),
                        array('id' => '12', 'title' => 'Secrets', 'artist' => 'Hass Irv', 'duration' => '3:00', 'image' => 'euphoria piste.png'),
                        array('id' => '13', 'title' => 'G.O.A.T.', 'artist' => 'Kenny Mason', 'duration' => '2:14', 'image' => 'euphoria piste.png'),
                        array('id' => '14', 'title' => 'Cocky AF', 'artist' => 'Megan Thee Stallion', 'duration' => '2:54', 'image' => 'euphoria piste.png'),
                        array('id' => '15', 'title' => '2 True', 'artist' => 'Nesha Nycee', 'duration' => '2:50', 'image' => 'euphoria piste.png'),
                        array('id' => '16', 'title' => 'I Know There\'s Gonna Be (Good Times)', 'artist' => 'Jamie xx ft. Young Thug & Popcaan', 'duration' => '4:04', 'image' => 'euphoria piste.png'),
                        array('id' => '17', 'title' => 'New Level', 'artist' => 'A$AP Ferg ft. Future', 'duration' => '4:27', 'image' => 'euphoria piste.png'),
                        array('id' => '18', 'title' => 'Motivation', 'artist' => 'Sam Austins', 'duration' => '2:50', 'image' => 'euphoria piste.png'),
                        array('id' => '19', 'title' => 'Pusha', 'artist' => 'JAG', 'duration' => '3:00', 'image' => 'euphoria piste.png'),
                        array('id' => '20', 'title' => 'Billy Boy', 'artist' => '$NOT', 'duration' => '2:17', 'image' => 'euphoria piste.png'),
                        array('id' => '21', 'title' => 'Run Cried the Crawling', 'artist' => 'Agnes Obel', 'duration' => '4:08', 'image' => 'euphoria piste.png'),
                        array('id' => '22', 'title' => 'Snowflake', 'artist' => 'Jim Reeves', 'duration' => '2:53', 'image' => 'euphoria piste.png')
                    )
                )
            ),
            'wednesday' => array(
                1 => array(
                    1 => array(
                        array('id' => '1', 'title' => 'Wednesday\'s Theme', 'artist' => 'Danny Elfman & Chris Bacon', 'duration' => '3:14', 'image' => 'wednesday piste.png'),
                        array('id' => '2', 'title' => 'Nevermore Academy', 'artist' => 'Danny Elfman & Chris Bacon', 'duration' => '2:45', 'image' => 'wednesday piste.png'),
                        array('id' => '3', 'title' => 'Wednesday Investigates', 'artist' => 'Danny Elfman & Chris Bacon', 'duration' => '2:12', 'image' => 'wednesday piste.png'),
                        array('id' => '4', 'title' => 'The Monster', 'artist' => 'Danny Elfman & Chris Bacon', 'duration' => '3:30', 'image' => 'wednesday piste.png'),
                        array('id' => '5', 'title' => 'Thing', 'artist' => 'Danny Elfman & Chris Bacon', 'duration' => '1:58', 'image' => 'wednesday piste.png')
                    )
                )
            ),
            'the-witcher' => array(
                1 => array(
                    1 => array(
                        array('id' => '1', 'title' => 'The End\'s Beginning', 'artist' => 'Sonya Belousova & Giona Ostinelli', 'duration' => '1:45', 'image' => 'the witcher piste.png'),
                        array('id' => '2', 'title' => 'Geralt of Rivia', 'artist' => 'Sonya Belousova & Giona Ostinelli', 'duration' => '3:09', 'image' => 'the witcher piste.png'),
                        array('id' => '3', 'title' => 'Ravix of Fourhorn', 'artist' => 'Sonya Belousova & Giona Ostinelli', 'duration' => '1:01', 'image' => 'the witcher piste.png'),
                        array('id' => '4', 'title' => 'The Lesser Evil', 'artist' => 'Sonya Belousova & Giona Ostinelli', 'duration' => '2:39', 'image' => 'the witcher piste.png'),
                        array('id' => '5', 'title' => 'Renfri', 'artist' => 'Sonya Belousova & Giona Ostinelli', 'duration' => '2:12', 'image' => 'the witcher piste.png'),
                        array('id' => '6', 'title' => 'Toss a Coin to Your Witcher', 'artist' => 'Joey Batey', 'duration' => '2:30', 'image' => 'the witcher piste.png')
                    )
                )
            ),
            'jujutsu-kaisen' => array(
                1 => array(
                    1 => array(
                        array('id' => '1', 'title' => 'Kaikai Kitan', 'artist' => 'Eve', 'duration' => '4:05', 'image' => 'jujutsu kaisen piste.png'),
                        array('id' => '2', 'title' => 'Ryomen Sukuna', 'artist' => 'Hiroaki Tsutsumi', 'duration' => '4:01', 'image' => 'jujutsu kaisen piste.png'),
                        array('id' => '3', 'title' => 'Occult Phenomenon Research Club', 'artist' => 'Tsutsumi & Okehazama', 'duration' => '2:05', 'image' => 'jujutsu kaisen piste.png'),
                        array('id' => '4', 'title' => 'Impatience', 'artist' => 'Tsutsumi', 'duration' => '2:39', 'image' => 'jujutsu kaisen piste.png'),
                        array('id' => '5', 'title' => 'As Usual', 'artist' => 'Alisa Okehazama', 'duration' => '2:04', 'image' => 'jujutsu kaisen piste.png'),
                        array('id' => '6', 'title' => 'The Source of The Curse', 'artist' => 'Tsutsumi', 'duration' => '3:12', 'image' => 'jujutsu kaisen piste.png'),
                        array('id' => '7', 'title' => 'Takagi VS Itadori', 'artist' => 'Tsutsumi', 'duration' => '2:17', 'image' => 'jujutsu kaisen piste.png'),
                        array('id' => '8', 'title' => 'Eye Catch B', 'artist' => 'Tsutsumi', 'duration' => '0:33', 'image' => 'jujutsu kaisen piste.png'),
                        array('id' => '9', 'title' => 'A Thousand‑Year Curse', 'artist' => 'Tsutsumi', 'duration' => '1:44', 'image' => 'jujutsu kaisen piste.png')
                    )
                )
            ),
            'attack-on-titan' => array(
                1 => array(
                    1 => array(
                        array('id' => '1', 'title' => 'Guren no Yumiya', 'artist' => 'Linked Horizon', 'duration' => '5:13', 'image' => 'attack on titan piste.png'),
                        array('id' => '2', 'title' => 'Vogel im Käfig', 'artist' => 'Hiroyuki Sawano', 'duration' => '6:28', 'image' => 'attack on titan piste.png'),
                        array('id' => '3', 'title' => 'Attack on Titan', 'artist' => 'Hiroyuki Sawano', 'duration' => '5:40', 'image' => 'attack on titan piste.png'),
                        array('id' => '4', 'title' => 'XL-TT', 'artist' => 'Hiroyuki Sawano', 'duration' => '3:00', 'image' => 'attack on titan piste.png'),
                        array('id' => '5', 'title' => 'The Reluctant Heroes', 'artist' => 'Hiroyuki Sawano', 'duration' => '4:51', 'image' => 'attack on titan piste.png')
                    )
                )
            ),
            'demon-slayer' => array(
                1 => array(
                    1 => array(
                        array('id' => '1', 'title' => 'Gurenge', 'artist' => 'LiSA', 'duration' => '3:59', 'image' => 'demon slayer piste.png'),
                        array('id' => '2', 'title' => 'Kamado Tanjiro no Uta', 'artist' => 'Go Shiina', 'duration' => '4:14', 'image' => 'demon slayer piste.png'),
                        array('id' => '3', 'title' => 'Homura', 'artist' => 'LiSA', 'duration' => '4:18', 'image' => 'demon slayer piste.png'),
                        array('id' => '4', 'title' => 'Akaza', 'artist' => 'Yuki Kajiura & Go Shiina', 'duration' => '3:27', 'image' => 'demon slayer piste.png'),
                        array('id' => '5', 'title' => 'Tanjiro\'s Battle', 'artist' => 'Yuki Kajiura & Go Shiina', 'duration' => '2:54', 'image' => 'demon slayer piste.png')
                    )
                )
            )
        );
    }
    
    // Fonction helper pour obtenir les pistes de films
    function get_film_tracks() {
        return array(
            'la-la-land' => array(
                array('id' => '1', 'title' => 'Another Day of Sun', 'artist' => 'Justin Hurwitz', 'duration' => '3:48', 'image' => 'la la land piste.png'),
                array('id' => '2', 'title' => 'Someone in the Crowd', 'artist' => 'Emma Stone', 'duration' => '4:20', 'image' => 'la la land piste.png'),
                array('id' => '3', 'title' => "Mia & Sebastian's Theme", 'artist' => 'Justin Hurwitz', 'duration' => '1:36', 'image' => 'la la land piste.png'),
                array('id' => '4', 'title' => 'A Lovely Night', 'artist' => 'Ryan Gosling & Emma Stone', 'duration' => '3:56', 'image' => 'la la land piste.png'),
                array('id' => '5', 'title' => "Herman's Habit", 'artist' => 'Justin Hurwitz', 'duration' => '1:51', 'image' => 'la la land piste.png'),
                array('id' => '6', 'title' => 'City of Stars (Pier)', 'artist' => 'Ryan Gosling', 'duration' => '1:51', 'image' => 'la la land piste.png'),
                array('id' => '7', 'title' => 'Planetarium', 'artist' => 'Justin Hurwitz', 'duration' => '4:16', 'image' => 'la la land piste.png'),
                array('id' => '8', 'title' => 'Summer Montage / Madeline', 'artist' => 'Justin Hurwitz', 'duration' => '2:04', 'image' => 'la la land piste.png'),
                array('id' => '9', 'title' => 'City of Stars (Duet)', 'artist' => 'Ryan Gosling & Emma Stone', 'duration' => '2:25', 'image' => 'la la land piste.png'),
                array('id' => '10', 'title' => 'Start a Fire', 'artist' => 'John Legend', 'duration' => '3:11', 'image' => 'la la land piste.png'),
                array('id' => '11', 'title' => 'Engagement Party', 'artist' => 'Justin Hurwitz', 'duration' => '1:25', 'image' => 'la la land piste.png'),
                array('id' => '12', 'title' => 'Audition (The Fools Who Dream)', 'artist' => 'Emma Stone', 'duration' => '3:48', 'image' => 'la la land piste.png'),
                array('id' => '13', 'title' => 'Epilogue', 'artist' => 'Justin Hurwitz', 'duration' => '7:39', 'image' => 'la la land piste.png'),
                array('id' => '14', 'title' => 'The End', 'artist' => 'Justin Hurwitz', 'duration' => '0:46', 'image' => 'la la land piste.png'),
                array('id' => '15', 'title' => 'City of Stars (Humming)', 'artist' => 'Emma Stone', 'duration' => '2:43', 'image' => 'la la land piste.png')
            ),
            'spirited-away' => array(
                array('id' => '1', 'title' => 'One Summer\'s Day', 'artist' => 'Joe Hisaishi', 'duration' => '2:25', 'image' => 'spirited away piste.png'),
                array('id' => '2', 'title' => 'A Road to Somewhere', 'artist' => 'Joe Hisaishi', 'duration' => '3:46', 'image' => 'spirited away piste.png'),
                array('id' => '3', 'title' => 'The Empty Restaurant', 'artist' => 'Joe Hisaishi', 'duration' => '3:27', 'image' => 'spirited away piste.png'),
                array('id' => '4', 'title' => 'Night Coming', 'artist' => 'Joe Hisaishi', 'duration' => '2:21', 'image' => 'spirited away piste.png'),
                array('id' => '5', 'title' => 'The Dragon Boy', 'artist' => 'Joe Hisaishi', 'duration' => '2:28', 'image' => 'spirited away piste.png'),
                array('id' => '6', 'title' => 'Sootballs', 'artist' => 'Joe Hisaishi', 'duration' => '2:35', 'image' => 'spirited away piste.png'),
                array('id' => '7', 'title' => 'Procession of the Spirit', 'artist' => 'Joe Hisaishi', 'duration' => '3:09', 'image' => 'spirited away piste.png'),
                array('id' => '8', 'title' => 'The Sixth Station', 'artist' => 'Joe Hisaishi', 'duration' => '3:39', 'image' => 'spirited away piste.png'),
                array('id' => '9', 'title' => 'The Name of Life', 'artist' => 'Youmi Kimura', 'duration' => '4:28', 'image' => 'spirited away piste.png'),
                array('id' => '10', 'title' => 'Always With Me', 'artist' => 'Youmi Kimura', 'duration' => '3:42', 'image' => 'spirited away piste.png')
            ),
            'your-name' => array(
                array('id' => '1', 'title' => 'Dream Lantern', 'artist' => 'RADWIMPS', 'duration' => '1:48', 'image' => 'your name piste.png'),
                array('id' => '2', 'title' => 'Zenzenzense', 'artist' => 'RADWIMPS', 'duration' => '4:45', 'image' => 'your name piste.png'),
                array('id' => '3', 'title' => 'Sparkle', 'artist' => 'RADWIMPS', 'duration' => '6:50', 'image' => 'your name piste.png'),
                array('id' => '4', 'title' => 'Nandemonaiya', 'artist' => 'RADWIMPS', 'duration' => '5:44', 'image' => 'your name piste.png'),
                array('id' => '5', 'title' => 'Date', 'artist' => 'RADWIMPS', 'duration' => '2:12', 'image' => 'your name piste.png'),
                array('id' => '6', 'title' => 'Mitsuha\'s Theme', 'artist' => 'RADWIMPS', 'duration' => '3:10', 'image' => 'your name piste.png')
            ),
            'inception' => array(
                array('id' => '1', 'title' => 'Half Remembered Dream', 'artist' => 'Hans Zimmer', 'duration' => '1:12', 'image' => 'inception piste.png'),
                array('id' => '2', 'title' => 'We Built Our Own World', 'artist' => 'Hans Zimmer', 'duration' => '1:55', 'image' => 'inception piste.png'),
                array('id' => '3', 'title' => 'Dream Is Collapsing', 'artist' => 'Hans Zimmer', 'duration' => '2:23', 'image' => 'inception piste.png'),
                array('id' => '4', 'title' => 'Radical Notion', 'artist' => 'Hans Zimmer', 'duration' => '3:07', 'image' => 'inception piste.png'),
                array('id' => '5', 'title' => 'Old Souls', 'artist' => 'Hans Zimmer', 'duration' => '7:44', 'image' => 'inception piste.png'),
                array('id' => '6', 'title' => '528491', 'artist' => 'Hans Zimmer', 'duration' => '2:23', 'image' => 'inception piste.png'),
                array('id' => '7', 'title' => 'Mombasa', 'artist' => 'Hans Zimmer', 'duration' => '4:54', 'image' => 'inception piste.png'),
                array('id' => '8', 'title' => 'One Simple Idea', 'artist' => 'Hans Zimmer', 'duration' => '2:28', 'image' => 'inception piste.png'),
                array('id' => '9', 'title' => 'Dream Within a Dream', 'artist' => 'Hans Zimmer', 'duration' => '5:27', 'image' => 'inception piste.png'),
                array('id' => '10', 'title' => 'Waiting for a Train', 'artist' => 'Hans Zimmer', 'duration' => '9:30', 'image' => 'inception piste.png'),
                array('id' => '11', 'title' => 'Paradox', 'artist' => 'Hans Zimmer', 'duration' => '3:39', 'image' => 'inception piste.png'),
                array('id' => '12', 'title' => 'Time', 'artist' => 'Hans Zimmer', 'duration' => '4:35', 'image' => 'inception piste.png')
            )
        );
    }
    
    if (is_array($favorites['musiques'])) {
        // Les musiques sont maintenant stockées directement avec toutes leurs infos
        foreach ($favorites['musiques'] as $m) {
            if (is_array($m)) {
                // Nouveau format : objet complet
                $musiques[] = array(
                    'id' => isset($m['id']) ? $m['id'] : '',
                    'title' => isset($m['title']) ? $m['title'] : 'Titre inconnu',
                    'artist' => isset($m['artist']) ? $m['artist'] : 'Artiste inconnu',
                    'cover' => isset($m['cover']) ? $m['cover'] : 'default-piste.png',
                    'source' => isset($m['source']) ? $m['source'] : '',
                    'duration' => isset($m['duration']) ? $m['duration'] : '',
                    'platforms' => array(),
                );
            }
        }
    }
    $favoris_data = [
        'films' => $favorites['films'], // Retourner directement les objets stockés
        'series' => $favorites['series'], // Retourner directement les objets stockés
        'musiques' => $musiques,
        'debug_favorites_raw' => $favorites,
        'debug_musiques_php' => $musiques,
        'debug_musiques_ids' => $debug_musiques_ids,
        'debug_musiques_found' => $debug_musiques_found,
    ];
    wp_send_json_success($favoris_data);
}

function cinemusic_add_user_favorite() {
    if (!is_user_logged_in() || !isset($_POST['type']) || !isset($_POST['item'])) {
        if (ob_get_length()) ob_clean();
wp_send_json_error(['message' => 'Non autorisé.']);
    }
    $user_id = get_current_user_id();
    $type = sanitize_text_field($_POST['type']);
    $item = json_decode(stripslashes($_POST['item']), true);
    $allowed = ['films', 'series', 'musiques'];
    if (!in_array($type, $allowed) || !is_array($item) || !isset($item['id'])) {
        if (ob_get_length()) ob_clean();
wp_send_json_error(['message' => 'Type ou item invalide.']);
    }
    $favorites = get_user_meta($user_id, 'cinemusic_favorites', true);
    if (!is_array($favorites)) {
        $favorites = [ 'films' => [], 'series' => [], 'musiques' => [] ];
    }
    
    // Nettoyage des anciennes données : supprimer les entrées avec "undefined" pour films et séries
    foreach (['films', 'series'] as $cat) {
        if (isset($favorites[$cat]) && is_array($favorites[$cat])) {
            $favorites[$cat] = array_values(array_filter($favorites[$cat], function($f) {
                // Garder seulement les objets valides avec titre et image non-undefined
                if (!is_array($f)) return false;
                if (!isset($f['title']) || $f['title'] === 'undefined' || $f['title'] === '') return false;
                return true;
            }));
        }
    }
    
    // Pour musiques, stocker l'objet complet avec toutes les infos
    if ($type === 'musiques') {
        $slug = isset($item['slug']) ? $item['slug'] : (isset($item['source']) ? sanitize_title($item['source']) : 'film');
        $id = (string)$item['id'];
        $composite_id = (strpos($id, $slug . '-') === 0) ? $id : ($slug . '-' . $id);
        
        // Créer l'objet musique complet
        $music_item = array(
            'id' => $composite_id,
            'title' => isset($item['title']) ? $item['title'] : 'Titre inconnu',
            'artist' => isset($item['artist']) ? $item['artist'] : 'Artiste inconnu',
            'cover' => isset($item['cover']) ? $item['cover'] : 'default-piste.png',
            'source' => isset($item['source']) ? $item['source'] : ucwords(str_replace('-', ' ', $slug)),
            'duration' => isset($item['duration']) ? $item['duration'] : '',
        );
        
        // Vérifier si déjà dans les favoris
        $already_exists = false;
        foreach ($favorites[$type] as $fav) {
            if (is_array($fav) && isset($fav['id']) && $fav['id'] === $composite_id) {
                $already_exists = true;
                break;
            }
        }
        
        if (!$already_exists) {
            $favorites[$type][] = $music_item;
        }
        
        update_user_meta($user_id, 'cinemusic_favorites', $favorites);
        if (ob_get_length()) ob_clean();
wp_send_json_success($favorites);
    }
    // Pour films/séries : stocker l'objet complet comme pour les musiques
    // Nettoyer les valeurs "undefined" qui peuvent venir du JavaScript
    $title = isset($item['title']) && $item['title'] !== 'undefined' ? $item['title'] : 'Titre inconnu';
    $image = isset($item['image']) && $item['image'] !== 'undefined' && $item['image'] !== '' ? $item['image'] : '';
    $url = isset($item['url']) && $item['url'] !== 'undefined' ? $item['url'] : '';
    
    $film_or_serie_item = array(
        'id' => $item['id'],
        'title' => $title,
        'image' => $image,
        'url' => $url,
    );
    
    // Vérifier si déjà dans les favoris
    $already_exists = false;
    foreach ($favorites[$type] as $fav) {
        $fav_id = is_array($fav) && isset($fav['id']) ? $fav['id'] : $fav;
        if ((string)$fav_id === (string)$item['id']) {
            $already_exists = true;
            break;
        }
    }
    
    if (!$already_exists) {
        $favorites[$type][] = $film_or_serie_item;
    }
    
    update_user_meta($user_id, 'cinemusic_favorites', $favorites);
    if (ob_get_length()) ob_clean();
wp_send_json_success($favorites);
}

function cinemusic_remove_user_favorite() {
    if (!is_user_logged_in() || !isset($_POST['type']) || !isset($_POST['id'])) {
        if (ob_get_length()) ob_clean();
wp_send_json_error(['message' => 'Non autorisé.']);
    }
    $user_id = get_current_user_id();
    $type = sanitize_text_field($_POST['type']);
    $id = sanitize_text_field($_POST['id']);
    $allowed = ['films', 'series', 'musiques'];
    if (!in_array($type, $allowed)) {
        if (ob_get_length()) ob_clean();
wp_send_json_error(['message' => 'Type invalide.']);
    }
    $favorites = get_user_meta($user_id, 'cinemusic_favorites', true);
    if (!is_array($favorites)) {
        $favorites = [ 'films' => [], 'series' => [], 'musiques' => [] ];
    }
    // Pour musiques, comparer l'ID unique string strictement
    if ($type === 'musiques') {
        $favorites[$type] = array_values(array_filter($favorites[$type], function($fav) use ($id) {
            if (is_array($fav) && isset($fav['id'])) {
                return $fav['id'] !== $id;
            }
            return $fav !== $id;
        }));
        // Nettoyage musiques : supprimer vides et doublons
        $favorites[$type] = array_filter($favorites[$type], function($f) { return !empty($f); });
        $favorites[$type] = array_values(array_unique($favorites[$type], SORT_REGULAR));
        update_user_meta($user_id, 'cinemusic_favorites', $favorites);
        if (ob_get_length()) ob_clean();
wp_send_json_success($favorites);
    }
    // Pour films/séries, comparer l'ID dans les objets stockés
    $favorites[$type] = array_values(array_filter($favorites[$type], function($fav) use ($id) {
        if (empty($fav)) return false;
        $favId = is_array($fav) && isset($fav['id']) ? $fav['id'] : $fav;
        return (string)$favId !== (string)$id;
    }));
    
    update_user_meta($user_id, 'cinemusic_favorites', $favorites);
    if (ob_get_length()) ob_clean();
wp_send_json_success($favorites);
}

// === SYSTÈME DE LIKE SUR COMMENTAIRES ===
add_action('wp_ajax_like_comment', 'theme_like_comment');
add_action('wp_ajax_unlike_comment', 'theme_unlike_comment');
add_action('wp_ajax_get_liked_comments', 'theme_get_liked_comments');
function theme_like_comment() {
    if (!is_user_logged_in() || !isset($_POST['comment_id'])) {
        if (ob_get_length()) ob_clean();
wp_send_json_error(['message' => 'Non autorisé.']);
    }
    global $wpdb;
    $comment_id = intval($_POST['comment_id']);
    $user_id = get_current_user_id();
    $table = $wpdb->prefix . 'movie_comment_likes';
    // Vérifier si déjà liké
    $exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE comment_id = %d AND user_id = %d", $comment_id, $user_id));
    if ($exists) {
        wp_send_json_error(['message' => 'Déjà liké.']);
    }
    // Si la table n'existe pas, on la crée automatiquement
    if($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS $table (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            comment_id BIGINT UNSIGNED NOT NULL,
            user_id BIGINT UNSIGNED NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY unique_like (comment_id, user_id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    $result = $wpdb->insert($table, [
        'comment_id' => $comment_id,
        'user_id' => $user_id
    ]);
    if ($result === false) {
        error_log('theme_like_comment SQL error: ' . $wpdb->last_error);
        wp_send_json_error(['message' => 'Erreur SQL lors de l\'ajout du like', 'sql_error' => $wpdb->last_error]);
    }
    // Compter les likes
    $like_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE comment_id = %d", $comment_id));
    wp_send_json_success(['like_count' => intval($like_count)]);
}

// Nouvelle fonction : unlike un commentaire
function theme_unlike_comment() {
    if (!is_user_logged_in() || !isset($_POST['comment_id'])) {
        if (ob_get_length()) ob_clean();
wp_send_json_error(['message' => 'Non autorisé.']);
    }
    global $wpdb;
    $comment_id = intval($_POST['comment_id']);
    $user_id = get_current_user_id();
    $table = $wpdb->prefix . 'movie_comment_likes';
    $wpdb->delete($table, [
        'comment_id' => $comment_id,
        'user_id' => $user_id
    ]);
    // Compter les likes
    $like_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE comment_id = %d", $comment_id));
    wp_send_json_success(['like_count' => intval($like_count)]);
}

// Nouvelle fonction : récupérer les IDs des commentaires likés par l'utilisateur pour un film
function theme_get_liked_comments() {
    if (!is_user_logged_in() || !isset($_POST['movie_id'])) {
        if (ob_get_length()) ob_clean();
wp_send_json_error(['message' => 'Non autorisé.']);
    }
    global $wpdb;
    $user_id = get_current_user_id();
    $movie_id = sanitize_text_field($_POST['movie_id']);
    $comments_table = $wpdb->prefix . 'movie_comments';
    $likes_table = $wpdb->prefix . 'movie_comment_likes';
    // Récupérer tous les commentaires de ce film
    $comments = $wpdb->get_results($wpdb->prepare("SELECT id FROM $comments_table WHERE movie_id = %s", $movie_id));
    $comment_ids = array_map(function($c){return $c->id;}, $comments);
    $liked_comment_ids = [];
    if (!empty($comment_ids)) {
        $placeholders = implode(',', array_fill(0, count($comment_ids), '%d'));
        $query = $wpdb->prepare(
            "SELECT comment_id FROM $likes_table WHERE user_id = %d AND comment_id IN ($placeholders)",
            array_merge([$user_id], $comment_ids)
        );
        $results = $wpdb->get_col($query);
        $liked_comment_ids = array_map('intval', $results);
    }
    wp_send_json_success(['liked_comment_ids' => $liked_comment_ids]);
}
/**
 * Helper: render site-wide Sign Up (S'inscrire) button only when logged out
 */
function cinemusic_signup_button() {
    if ( is_user_logged_in() ) {
        return '';
    }
    $url = esc_url( home_url('/inscription') );
    // Use double quotes in the translation string to avoid escaping the apostrophe
    return '<a class="cta-btn" href="' . $url . '">' . esc_html__("S'inscrire", 'project-end-of-year') . '</a>';
}
/**
 * Theme Functions
 */

// Theme setup
function theme_setup()
{
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    register_nav_menus([
        'primary' => __('Primary Menu', 'project-end-of-year'),
        'footer'  => __('Footer Menu', 'project-end-of-year'),
    ]);
}
add_action('after_setup_theme', 'theme_setup');

// Create default pages on theme activation
function create_theme_pages()
{
    // All pages to create in one array
    $all_pages = array(
        // Core pages
        array('title' => 'Inscription', 'slug' => 'inscription', 'template' => 'template-register.php'),
        array('title' => 'Inscription - Étape 2', 'slug' => 'signup-step2', 'template' => 'template-register-step2.php'),
        array('title' => 'Connexion', 'slug' => 'login', 'template' => 'Connexion.php'),
        array('title' => 'Mon Profil', 'slug' => 'profil', 'template' => 'template-profil.php'),
        array('title' => 'Favoris', 'slug' => 'favoris', 'template' => 'Favoris.php'),
        
        // Composers
        array('title' => 'Hans Zimmer', 'slug' => 'hans-zimmer', 'template' => 'template-fiche-compositeur.php'),
        
        // Films
        array('title' => 'Inception', 'slug' => 'inception', 'template' => 'template-fiche-film.php'),
        array('title' => 'La La Land', 'slug' => 'la-la-land', 'template' => 'template-fiche-film.php'),
        array('title' => 'Parasite', 'slug' => 'parasite', 'template' => 'template-fiche-film.php'),
        array('title' => 'Interstellar', 'slug' => 'interstellar', 'template' => 'template-fiche-film.php'),
        array('title' => 'Arrival', 'slug' => 'arrival', 'template' => 'template-fiche-film.php'),
        array('title' => 'Wicked', 'slug' => 'wicked', 'template' => 'template-fiche-film.php'),
        
        // Series
        array('title' => 'Stranger Things', 'slug' => 'stranger-things', 'template' => 'template-fiche-serie.php'),
        array('title' => 'Breaking Bad', 'slug' => 'breaking-bad', 'template' => 'template-fiche-serie.php'),
        array('title' => 'Euphoria', 'slug' => 'euphoria', 'template' => 'template-fiche-serie.php'),
        array('title' => 'Wednesday', 'slug' => 'wednesday', 'template' => 'template-fiche-serie.php'),
        array('title' => 'The Witcher', 'slug' => 'the-witcher', 'template' => 'template-fiche-serie.php'),
        
        // Animes
        array('title' => 'Your Name', 'slug' => 'your-name', 'template' => 'template-fiche-film.php'),
        array('title' => 'Spirited Away', 'slug' => 'spirited-away', 'template' => 'template-fiche-film.php'),
        array('title' => 'Attack on Titan', 'slug' => 'attack-on-titan', 'template' => 'template-fiche-serie.php'),
        array('title' => 'Demon Slayer', 'slug' => 'demon-slayer', 'template' => 'template-fiche-serie.php'),
        array('title' => 'Jujutsu Kaisen', 'slug' => 'jujutsu-kaisen', 'template' => 'template-fiche-serie.php')
    );

    foreach ($all_pages as $page_data) {
        $existing_page = get_page_by_path($page_data['slug']);
        if (!$existing_page) {
            $page_id = wp_insert_post([
                'post_title'     => $page_data['title'],
                'post_name'      => $page_data['slug'],
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'post_content'   => ''
            ]);
            
            if ($page_id && !is_wp_error($page_id)) {
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
        } else {
            // Update template if page exists
            $current_template = get_post_meta($existing_page->ID, '_wp_page_template', true);
            if ($current_template !== $page_data['template']) {
                update_post_meta($existing_page->ID, '_wp_page_template', $page_data['template']);
            }
        }
    }

    // Create Films page
    $films_page = get_page_by_path('films');
    if (!$films_page) {
        $page_id = wp_insert_post([
            'post_title'     => 'Films',
            'post_name'      => 'films',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_content'   => ''
        ]);
        
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'template-films.php');
        }
    } else {
        $current_template = get_post_meta($films_page->ID, '_wp_page_template', true);
        if ($current_template !== 'template-films.php') {
            update_post_meta($films_page->ID, '_wp_page_template', 'template-films.php');
        }
    }

    // Create Series page
    $series_page = get_page_by_path('series');
    if (!$series_page) {
        $page_id = wp_insert_post([
            'post_title'     => 'Séries',
            'post_name'      => 'series',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_content'   => ''
        ]);
        
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'template-series.php');
        }
    } else {
        $current_template = get_post_meta($series_page->ID, '_wp_page_template', true);
        if ($current_template !== 'template-series.php') {
            update_post_meta($series_page->ID, '_wp_page_template', 'template-series.php');
        }
    }
}
add_action('after_switch_theme', 'create_theme_pages');
add_action('admin_init', 'create_theme_pages'); // Also run on admin init to ensure page exists

// Enqueue styles and scripts
function theme_scripts() {
    $version = filemtime(get_template_directory() . '/functions.php'); // Use file modification time as cache buster
    // Bouton scroll-to-top sur toutes les pages
    wp_enqueue_script('scroll-to-top', get_template_directory_uri() . '/assets/js/scroll-to-top.js', array(), $version, true);
    $version = filemtime(get_template_directory() . '/functions.php'); // Use file modification time as cache buster
    
    // Disable script/style concatenation for Local environment
    if (!defined('CONCATENATE_SCRIPTS')) {
        define('CONCATENATE_SCRIPTS', false);
    }
    
    // External fonts / vendors
    wp_enqueue_style('typekit-cinemusic', 'https://use.typekit.net/isz1tod.css', array(), null);
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), '5.3.3');
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css', array(), '1.11.1');
    
    // jQuery (already in WordPress but ensure it's loaded)
    wp_enqueue_script('jquery');
    
    // Bootstrap JS (depends on jQuery for some components)
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.3', true);

    // Base styles (reset + global)
    wp_enqueue_style('base-style', get_template_directory_uri() . '/assets/css/base.css', array('bootstrap'), $version);
    
    // Animations & Transitions
    wp_enqueue_style('animations-style', get_template_directory_uri() . '/assets/css/animations.css', array('base-style'), $version);
    
    // Header and Footer styles (loaded on all pages)
    wp_enqueue_style('header-style', get_template_directory_uri() . '/assets/css/Header.css', array('base-style'), $version);
    wp_enqueue_style('footer-style', get_template_directory_uri() . '/assets/css/footer.css', array('base-style'), $version);
    
    // Header and Footer scripts (loaded on all pages)
    wp_enqueue_script('header-script', get_template_directory_uri() . '/assets/js/Header.js', array(), $version, true);
    wp_enqueue_script('footer-script', get_template_directory_uri() . '/assets/js/footer.js', array(), $version, true);
    
    // Initialisation sûre de $current_template pour éviter les warnings
    $current_template = '';
    if (function_exists('get_page_template_slug')) {
        $current_template = get_page_template_slug(get_the_ID());
        if (empty($current_template) && is_page()) {
            $current_template = basename(get_post_meta(get_the_ID(), '_wp_page_template', true));
        }
    }
    // Front page & fiche série : charger front-page.js pour la gestion des cœurs séries/animés
    if (is_front_page() || is_page_template('template-fiche-serie.php') || $current_template === 'template-fiche-serie.php') {
        wp_enqueue_style('front-page-style', get_template_directory_uri() . '/assets/css/front-page.css', array('header-style', 'footer-style'), $version);
        wp_enqueue_script('front-page-script', get_template_directory_uri() . '/assets/js/front-page.js', array(), $version, true);
        // Passer l'URL AJAX à front-page.js
        wp_localize_script('front-page-script', 'cinemusicAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
        ));
    }
    
    // Get current page template (handle both is_page_template() and fallback method)
    $current_template = get_page_template_slug(get_the_ID());
    if (empty($current_template) && is_page()) {
        $current_template = basename(get_post_meta(get_the_ID(), '_wp_page_template', true));
    }
    
    // Fiche film template styles and scripts
    if (is_page_template('template-fiche-film.php') || $current_template === 'template-fiche-film.php') {
        wp_enqueue_style('fiche-film-style', get_template_directory_uri() . '/assets/css/Fiche film.css', array('header-style', 'footer-style', 'bootstrap'), filemtime(get_template_directory() . '/assets/css/Fiche film.css'));
        // Make fiche-film.js depend on main.js (theme-script) so carrousel is always available (casse corrigée)
        wp_enqueue_script('fiche-film-script', get_template_directory_uri() . '/assets/js/Fiche-film.js', array('theme-script','bootstrap-js'), filemtime(get_template_directory() . '/assets/js/Fiche-film.js'), true);
        
        // Récupérer le slug de la page actuelle pour le movie_id
        global $post;
        $movie_slug = isset($post->post_name) ? $post->post_name : 'inception';
        
        // Passer les variables AJAX au JS
        wp_localize_script('fiche-film-script', 'movieComments', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('movie_comment_nonce'),
            'movie_id' => $movie_slug
        ));
    }
    
    // Fiche série template styles and scripts
    if (is_page_template('template-fiche-serie.php') || $current_template === 'template-fiche-serie.php') {
        wp_enqueue_style('fiche-film-style', get_template_directory_uri() . '/assets/css/Fiche film.css', array('header-style', 'footer-style', 'bootstrap'), filemtime(get_template_directory() . '/assets/css/Fiche film.css'));
        wp_enqueue_style('fiche-serie-style', get_template_directory_uri() . '/assets/css/Fiche serie.css', array('fiche-film-style'), filemtime(get_template_directory() . '/assets/css/Fiche serie.css'));
        wp_enqueue_script('fiche-serie-script', get_template_directory_uri() . '/assets/js/Fiche-serie.js', array('bootstrap-js'), filemtime(get_template_directory() . '/assets/js/Fiche-serie.js'), true);
        
        // Passer les variables AJAX au JS
        // Récupérer le slug de la page actuelle pour le movie_id (comme pour les films)
        global $post;
        $serie_slug = isset($post->post_name) ? $post->post_name : 'stranger-things';
        wp_localize_script('fiche-serie-script', 'movieComments', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('movie_comment_nonce'),
            'movie_id' => $serie_slug // ID unique de la série courante
        ));
    }
    
    // Fiche compositeur template styles and scripts
    if (is_page_template('template-fiche-compositeur.php') || $current_template === 'template-fiche-compositeur.php') {
        wp_enqueue_style('fiche-compositeur-style', get_template_directory_uri() . '/assets/css/Fiche-compositeur.css', array('header-style', 'footer-style', 'bootstrap'), time());
        wp_enqueue_script('fiche-compositeur-script', get_template_directory_uri() . '/assets/js/fiche-compositeur.js', array('bootstrap-js'), time(), true);

        // Passer les variables AJAX au JS (pour les commentaires)
        global $post;
        $composer_slug = isset($post->post_name) ? $post->post_name : '';
        wp_localize_script('fiche-compositeur-script', 'composerComments', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('composer_comment_nonce'),
            'composer_id' => $composer_slug // ID dynamique du compositeur actuel
        ));
    }
    
    // Registration template styles and scripts
    if (is_page_template('template-register.php') || $current_template === 'template-register.php') {
        wp_enqueue_style('register-style', get_template_directory_uri() . '/assets/css/register-step.css', array('base-style'), $version);
        wp_enqueue_script('register-script', get_template_directory_uri() . '/assets/js/register-step2.js', array(), $version, true);
    }
    
    // Login template styles and scripts
    if (is_page_template('Connexion.php') || $current_template === 'Connexion.php') {
        wp_enqueue_style('login-style', get_template_directory_uri() . '/assets/css/Connexion.css', array('base-style'), $version);
        wp_enqueue_script('login-script', get_template_directory_uri() . '/assets/js/Connexion.js', array(), $version, true);
    }
    
    // Profile page styles and scripts
    if (is_page_template('template-profil.php') || $current_template === 'template-profil.php') {
        wp_enqueue_style('profil-style', get_template_directory_uri() . '/assets/css/profil.css', array('header-style', 'footer-style'), $version);
        wp_enqueue_script('profil-script', get_template_directory_uri() . '/assets/js/profil.js', array(), $version, true);
    }
    
    // Films & Series pages styles and scripts
    if (is_page_template('template-films.php') || is_page_template('template-series.php') || 
        $current_template === 'template-films.php' || $current_template === 'template-series.php') {
        wp_enqueue_style('movies-series-style', get_template_directory_uri() . '/assets/css/movies-series.css', array('header-style', 'footer-style', 'bootstrap'), filemtime(get_template_directory() . '/assets/css/movies-series.css'));
        wp_enqueue_style('page-media-layout-style', get_template_directory_uri() . '/assets/css/page-media-layout.css', array('movies-series-style'), filemtime(get_template_directory() . '/assets/css/page-media-layout.css'));
        wp_enqueue_script('movies-series-script', get_template_directory_uri() . '/assets/js/movies-series.js', array('bootstrap-js'), filemtime(get_template_directory() . '/assets/js/movies-series.js'), true);
    }
    
    // Favoris page styles and scripts
    if (is_page_template('Favoris.php') || $current_template === 'Favoris.php' || is_page('favoris')) {
        wp_enqueue_style('favoris-style', get_template_directory_uri() . '/assets/css/favoris.css', array('header-style', 'footer-style', 'bootstrap'), filemtime(get_template_directory() . '/assets/css/favoris.css'));
        wp_enqueue_script('favoris-script', get_template_directory_uri() . '/assets/js/favoris.js', array(), filemtime(get_template_directory() . '/assets/js/favoris.js'), true);
        wp_localize_script('favoris-script', 'ajaxurl', array('url' => admin_url('admin-ajax.php')));
    }
    
    // Global script (smooth scroll)
    wp_enqueue_script('theme-script', get_template_directory_uri() . '/assets/js/main.js', array('bootstrap-js'), $version, true);
}
add_action('wp_enqueue_scripts', 'theme_scripts');

// Add inline styles for pages with custom template structure (runs during wp_head())
function enqueue_custom_template_styles() {
    $version = filemtime(get_template_directory() . '/functions.php');
    
    // Profile page
    if (is_page_template('template-profil.php')) {
        echo '<link rel="stylesheet" href="' . esc_url(get_template_directory_uri() . '/assets/css/profil.css') . '?v=' . $version . '">' . "\n";
    }
    
    // Fiche film page
    if (is_page_template('template-fiche-film.php')) {
        echo '<link rel="stylesheet" href="' . esc_url(get_template_directory_uri() . '/assets/css/Fiche film.css') . '?v=' . $version . '">' . "\n";
    }
    
    // Fiche compositeur page
    if (is_page_template('template-fiche-compositeur.php')) {
        echo '<link rel="stylesheet" href="' . esc_url(get_template_directory_uri() . '/assets/css/Fiche-compositeur.css') . '?v=' . $version . '">' . "\n";
    }
}
add_action('wp_head', 'enqueue_custom_template_styles', 5);

// Handle user registration
function handle_user_registration()
{
    if (isset($_POST['register_submit']) && isset($_POST['register_nonce']) && wp_verify_nonce($_POST['register_nonce'], 'register_action')) {
        $username = sanitize_user($_POST['user_login']);
        $email = sanitize_email($_POST['user_email']);
        $password = $_POST['user_pass'];
        $password_confirm = $_POST['user_pass_confirm'];

        if ($password !== $password_confirm) {
            wp_redirect(home_url('/inscription?registration=error'));
            exit;
        }

        // Vérifier si l'email existe déjà
        if (email_exists($email)) {
            wp_redirect(home_url('/inscription?registration=email_exists'));
            exit;
        }

        // Vérifier si l'username existe déjà
        if (username_exists($username)) {
            wp_redirect(home_url('/inscription?registration=username_exists'));
            exit;
        }

        $user_id = wp_create_user($username, $password, $email);

        if (!is_wp_error($user_id)) {
            if (isset($_POST['first_name'])) {
                update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
            }
            if (isset($_POST['last_name'])) {
                update_user_meta($user_id, 'last_name', sanitize_text_field($_POST['last_name']));
            }
            if (isset($_POST['phone'])) {
                update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
            }
            if (isset($_POST['student_id'])) {
                update_user_meta($user_id, 'student_id', sanitize_text_field($_POST['student_id']));
            }

            $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
            $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
            if ($first_name || $last_name) {
                wp_update_user(array(
                    'ID' => $user_id,
                    'display_name' => trim($first_name . ' ' . $last_name),
                    'first_name' => $first_name,
                    'last_name' => $last_name
                ));
            }

            // Connecter automatiquement l'utilisateur
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id, true, is_ssl());
            do_action('wp_login', $username, get_user_by('ID', $user_id));
            // Rediriger vers la 2e étape si besoin
            $step2_page = get_page_by_path('signup-step2');
            if ($step2_page) {
                wp_redirect(get_permalink($step2_page->ID));
            } else {
                wp_redirect(home_url('/signup-step2'));
            }
            exit;
        } else {
            wp_redirect(home_url('/signup?registration=error'));
            exit;
        }
    }
}
add_action('template_redirect', 'handle_user_registration');

// Handle user login
function handle_user_login()
{
    if (isset($_POST['login_submit']) && isset($_POST['login_nonce']) && wp_verify_nonce($_POST['login_nonce'], 'login_action')) {
        $username = sanitize_user($_POST['log']);
        $password = $_POST['pwd'];
        $remember = isset($_POST['rememberme']) ? true : false;

        if (empty($username) || empty($password)) {
            wp_redirect(home_url('/login?login=empty'));
            exit;
        }

        $creds = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => $remember
        );

        $user = wp_signon($creds, false);

        if (!is_wp_error($user)) {
            wp_redirect(home_url());
            exit;
        } else {
            wp_redirect(home_url('/login?login=failed'));
            exit;
        }
    }
}
add_action('template_redirect', 'handle_user_login');

// Redirect after login
function redirect_after_login($redirect_to, $request, $user)
{
    if (!is_wp_error($user)) {
        return home_url();
    }
    return $redirect_to;
}
add_filter('login_redirect', 'redirect_after_login', 10, 3);

// Helper function to get user custom field
function get_user_custom_field($user_id, $field_name)
{
    return get_user_meta($user_id, $field_name, true);
}

// Add custom fields to user profile in admin
function add_custom_user_profile_fields($user)
{
?>
    <h3>Additional Information</h3>
    <table class="form-table">
        <tr>
            <th><label for="phone">Phone Number</label></th>
            <td>
                <input type="tel" name="phone" id="phone" value="<?php echo esc_attr(get_user_meta($user->ID, 'phone', true)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="student_id">Student ID</label></th>
            <td>
                <input type="text" name="student_id" id="student_id" value="<?php echo esc_attr(get_user_meta($user->ID, 'student_id', true)); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
<?php
}
add_action('show_user_profile', 'add_custom_user_profile_fields');
add_action('edit_user_profile', 'add_custom_user_profile_fields');

// Save custom fields in admin
function save_custom_user_profile_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    if (isset($_POST['phone'])) {
        update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
    }
    if (isset($_POST['student_id'])) {
        update_user_meta($user_id, 'student_id', sanitize_text_field($_POST['student_id']));
    }
}
add_action('personal_options_update', 'save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'save_custom_user_profile_fields');

// Add custom columns to users list table
function add_custom_user_columns($columns)
{
    $columns['phone'] = 'Phone';
    $columns['student_id'] = 'Student ID';
    return $columns;
}
add_filter('manage_users_columns', 'add_custom_user_columns');

// Display custom column data in users list
function show_custom_user_column_data($value, $column_name, $user_id)
{
    if ($column_name == 'phone') {
        return get_user_meta($user_id, 'phone', true) ?: '—';
    }
    if ($column_name == 'student_id') {
        return get_user_meta($user_id, 'student_id', true) ?: '—';
    }
    return $value;
}
add_filter('manage_users_custom_column', 'show_custom_user_column_data', 10, 3);

// ===== GESTION DES FILMS ET SÉRIES =====

// Créer une table personnalisée pour les films et séries
function create_movies_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'movies';
    $charset_collate = $wpdb->get_charset_collate();


    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title varchar(255) NOT NULL,
        type varchar(20) NOT NULL,
        genre varchar(100) NOT NULL,
        year varchar(4),
        affiche varchar(255),
        synopsis text,
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id),
        KEY type (type),
        KEY genre (genre)
    ) $charset_collate;";

    if (!function_exists('dbDelta')) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    }
    dbDelta($sql);

    
    // Insérer les données si la table est vide
    $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    if ($count == 0) {
        insert_default_movies();
    }
}
add_action('after_switch_theme', 'create_movies_table');
add_action('admin_init', 'create_movies_table');

// Insérer les films et séries par défaut
function insert_default_movies() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'movies';
    
    $movies = [
        // FILMS - ACTION
        ['title' => 'Inception', 'type' => 'film', 'genre' => 'Action', 'year' => '2010', 'affiche' => 'inception affiche film.jpg'],
        ['title' => 'The Matrix', 'type' => 'film', 'genre' => 'Action', 'year' => '1999', 'affiche' => 'matrix affiche similaire.jpg'],
        ['title' => 'Tenet', 'type' => 'film', 'genre' => 'Action', 'year' => '2020', 'affiche' => 'Tenet2.jpg'],
        ['title' => 'Edge of Tomorrow', 'type' => 'film', 'genre' => 'Action', 'year' => '2014', 'affiche' => 'Edge of Tomorrow.jpg'],
        ['title' => 'Minority Report', 'type' => 'film', 'genre' => 'Action', 'year' => '2002', 'affiche' => 'Minority report.jpg'],
        
        // FILMS - COMÉDIE
        ['title' => 'La La Land', 'type' => 'film', 'genre' => 'Comédie', 'year' => '2016', 'affiche' => 'La La Land.jpg'],
        ['title' => 'Amélie', 'type' => 'film', 'genre' => 'Comédie', 'year' => '2001', 'affiche' => 'Amélie.jpg'],
        ['title' => 'The Grand Budapest Hotel', 'type' => 'film', 'genre' => 'Comédie', 'year' => '2014', 'affiche' => 'TheGrandBudapestHotel.jpg'],
        ['title' => 'Superbad', 'type' => 'film', 'genre' => 'Comédie', 'year' => '2007', 'affiche' => 'superbad.jpg'],
        ['title' => 'Jumanji', 'type' => 'film', 'genre' => 'Comédie', 'year' => '1995', 'affiche' => 'jumanji.jpg'],
        
        // FILMS - DRAME
        ['title' => 'Interstellar', 'type' => 'film', 'genre' => 'Drame', 'year' => '2014', 'affiche' => 'interstellar affiche similaire.jpg'],
        ['title' => 'The Prestige', 'type' => 'film', 'genre' => 'Drame', 'year' => '2006', 'affiche' => 'The Prestige.webp'],
        ['title' => 'Memento', 'type' => 'film', 'genre' => 'Drame', 'year' => '2000', 'affiche' => 'Momento.jpg'],
        ['title' => 'Shutter Island', 'type' => 'film', 'genre' => 'Drame', 'year' => '2010', 'affiche' => 'Shutter island.webp'],
        ['title' => 'Paprika', 'type' => 'film', 'genre' => 'Drame', 'year' => '2006', 'affiche' => 'Paprika.webp'],
        
        // FILMS - SCIENCE-FICTION
        ['title' => 'Dark City', 'type' => 'film', 'genre' => 'Science-Fiction', 'year' => '1998', 'affiche' => 'Dark city.jpg'],
        ['title' => 'Arrival', 'type' => 'film', 'genre' => 'Science-Fiction', 'year' => '2016', 'affiche' => 'arrival affiche similaire.jpg'],
        ['title' => 'Ex Machina', 'type' => 'film', 'genre' => 'Science-Fiction', 'year' => '2014', 'affiche' => 'Ex machina.jpg'],
        ['title' => 'Source Code', 'type' => 'film', 'genre' => 'Science-Fiction', 'year' => '2011', 'affiche' => 'Source code.jpg'],
        ['title' => 'Coherence', 'type' => 'film', 'genre' => 'Science-Fiction', 'year' => '2013', 'affiche' => 'Coherence.webp'],
        
        // FILMS - HORREUR
        ['title' => 'The Shining', 'type' => 'film', 'genre' => 'Horreur', 'year' => '1980', 'affiche' => 'shining.jpg'],
        ['title' => 'Hereditary', 'type' => 'film', 'genre' => 'Horreur', 'year' => '2018', 'affiche' => 'hereditary.jpg'],
        ['title' => 'The Ring', 'type' => 'film', 'genre' => 'Horreur', 'year' => '2002', 'affiche' => 'ring.jpg'],
        ['title' => 'A Quiet Place', 'type' => 'film', 'genre' => 'Horreur', 'year' => '2018', 'affiche' => 'quiet-place.jpg'],
        ['title' => 'The Conjuring', 'type' => 'film', 'genre' => 'Horreur', 'year' => '2013', 'affiche' => 'conjuring.jpg'],
        
        // FILMS - ROMANCE
        ['title' => 'The Notebook', 'type' => 'film', 'genre' => 'Romance', 'year' => '2004', 'affiche' => 'notebook.jpg'],
        ['title' => 'Titanic', 'type' => 'film', 'genre' => 'Romance', 'year' => '1997', 'affiche' => 'titanic.jpg'],
        ['title' => 'Pride and Prejudice', 'type' => 'film', 'genre' => 'Romance', 'year' => '2005', 'affiche' => 'pride-prejudice.jpg'],
        ['title' => 'About Time', 'type' => 'film', 'genre' => 'Romance', 'year' => '2013', 'affiche' => 'about-time.jpg'],
        ['title' => 'Crazy Rich Asians', 'type' => 'film', 'genre' => 'Romance', 'year' => '2018', 'affiche' => 'crazy-rich.jpg'],
        
        // FILMS ANIMÉS - ACTION
        ['title' => 'Your Name', 'type' => 'film', 'genre' => 'Action', 'year' => '2016', 'affiche' => 'inception affiche film.jpg'],
        ['title' => 'Demon Slayer Movie', 'type' => 'film', 'genre' => 'Action', 'year' => '2020', 'affiche' => 'Dark city.jpg'],
        ['title' => 'Jujutsu Kaisen 0', 'type' => 'film', 'genre' => 'Action', 'year' => '2021', 'affiche' => 'matrix affiche similaire.jpg'],
        
        // SÉRIES - ACTION
        ['title' => 'Stranger Things', 'type' => 'serie', 'genre' => 'Action', 'year' => '2016', 'affiche' => 'Tenet.jpg'],
        ['title' => 'Breaking Bad', 'type' => 'serie', 'genre' => 'Action', 'year' => '2008', 'affiche' => 'Dark city.jpg'],
        ['title' => 'Game of Thrones', 'type' => 'serie', 'genre' => 'Action', 'year' => '2011', 'affiche' => 'the-prestige-md-web.jpg'],
        ['title' => 'The Witcher', 'type' => 'serie', 'genre' => 'Action', 'year' => '2019', 'affiche' => 'matrix affiche similaire.jpg'],
        ['title' => 'Arrow', 'type' => 'serie', 'genre' => 'Action', 'year' => '2012', 'affiche' => 'inception affiche film.jpg'],
        
        // SÉRIES - COMÉDIE
        ['title' => 'The Office', 'type' => 'serie', 'genre' => 'Comédie', 'year' => '2005', 'affiche' => 'La La Land.jpg'],
        ['title' => 'Parks and Recreation', 'type' => 'serie', 'genre' => 'Comédie', 'year' => '2009', 'affiche' => 'arrival affiche similaire.jpg'],
        ['title' => 'Brooklyn Nine-Nine', 'type' => 'serie', 'genre' => 'Comédie', 'year' => '2013', 'affiche' => 'shutter island affiche similaire.jpg'],
        ['title' => 'The Good Place', 'type' => 'serie', 'genre' => 'Comédie', 'year' => '2016', 'affiche' => 'interstellar affiche similaire.jpg'],
        ['title' => 'Community', 'type' => 'serie', 'genre' => 'Comédie', 'year' => '2009', 'affiche' => 'inception affiche film.jpg'],
        
        // SÉRIES - DRAME
        ['title' => 'Euphoria', 'type' => 'serie', 'genre' => 'Drame', 'year' => '2019', 'affiche' => 'Dark city.jpg'],
        ['title' => 'True Detective', 'type' => 'serie', 'genre' => 'Drame', 'year' => '2014', 'affiche' => 'the-prestige-md-web.jpg'],
        ['title' => 'The Crown', 'type' => 'serie', 'genre' => 'Drame', 'year' => '2016', 'affiche' => 'interstellar affiche similaire.jpg'],
        ['title' => 'Better Call Saul', 'type' => 'serie', 'genre' => 'Drame', 'year' => '2015', 'affiche' => 'shutter island affiche similaire.jpg'],
        ['title' => 'The Marvelous Mrs. Maisel', 'type' => 'serie', 'genre' => 'Drame', 'year' => '2017', 'affiche' => 'La La Land.jpg'],
        
        // SÉRIES - SCIENCE-FICTION
        ['title' => 'The Mandalorian', 'type' => 'serie', 'genre' => 'Science-Fiction', 'year' => '2019', 'affiche' => 'Tenet.jpg'],
        ['title' => 'Westworld', 'type' => 'serie', 'genre' => 'Science-Fiction', 'year' => '2016', 'affiche' => 'matrix affiche similaire.jpg'],
        ['title' => 'Dark', 'type' => 'serie', 'genre' => 'Science-Fiction', 'year' => '2017', 'affiche' => 'Dark city.jpg'],
        ['title' => 'The Expanse', 'type' => 'serie', 'genre' => 'Science-Fiction', 'year' => '2015', 'affiche' => 'arrival affiche similaire.jpg'],
        ['title' => 'Orphan Black', 'type' => 'serie', 'genre' => 'Science-Fiction', 'year' => '2013', 'affiche' => 'inception_2010_advance_original_film_art_f4801a23-edb3-4db0-b382-1e2aec1dc927_5000x.jpg'],
        
        // SÉRIES - HORREUR
        ['title' => 'Wednesday', 'type' => 'serie', 'genre' => 'Horreur', 'year' => '2022', 'affiche' => 'shutter island affiche similaire.jpg'],
        ['title' => 'Supernatural', 'type' => 'serie', 'genre' => 'Horreur', 'year' => '2005', 'affiche' => 'Dark city.jpg'],
        ['title' => 'The Haunting of Hill House', 'type' => 'serie', 'genre' => 'Horreur', 'year' => '2018', 'affiche' => 'the-prestige-md-web.jpg'],
        ['title' => 'American Horror Story', 'type' => 'serie', 'genre' => 'Horreur', 'year' => '2011', 'affiche' => 'matrix affiche similaire.jpg'],
        ['title' => 'The Twilight Zone', 'type' => 'serie', 'genre' => 'Horreur', 'year' => '1959', 'affiche' => 'inception affiche film.jpg'],
        
        // SÉRIES - ROMANCE
        ['title' => 'Bridgerton', 'type' => 'serie', 'genre' => 'Romance', 'year' => '2020', 'affiche' => 'La La Land.jpg'],
        ['title' => 'Outlander', 'type' => 'serie', 'genre' => 'Romance', 'year' => '2014', 'affiche' => 'Tenet.jpg'],
        ['title' => 'The Crown', 'type' => 'serie', 'genre' => 'Romance', 'year' => '2016', 'affiche' => 'arrival affiche similaire.jpg'],
        ['title' => 'You', 'type' => 'serie', 'genre' => 'Romance', 'year' => '2018', 'affiche' => 'interstellar affiche similaire.jpg'],
        ['title' => 'Emily in Paris', 'type' => 'serie', 'genre' => 'Romance', 'year' => '2020', 'affiche' => 'shutter island affiche similaire.jpg'],
        
        // SÉRIES ANIMÉS
        ['title' => 'Attack on Titan', 'type' => 'serie', 'genre' => 'Action', 'year' => '2013', 'affiche' => 'Dark city.jpg'],
        ['title' => 'Jujutsu Kaisen', 'type' => 'serie', 'genre' => 'Action', 'year' => '2020', 'affiche' => 'matrix affiche similaire.jpg'],
    ];
    
    foreach ($movies as $movie) {
        $wpdb->insert($table_name, $movie);
    }
}

// ===== GESTION DES COMMENTAIRES AJAX =====

// Créer une table personnalisée pour les commentaires de films
function create_movie_comments_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'movie_comments';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        movie_id varchar(100) NOT NULL,
        user_id bigint(20) NOT NULL,
        comment_text text NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    dbDelta($sql);

}
add_action('after_switch_theme', 'create_movie_comments_table');

// Ajouter un commentaire
function add_movie_comment() {
    // Temporairement désactiver la vérification nonce pour debug
    // check_ajax_referer('movie_comment_nonce', 'nonce');
    
    if (!is_user_logged_in()) {
        if (ob_get_length()) ob_clean();
wp_send_json_error(['message' => 'Vous devez être connecté']);
        return;
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'movie_comments';
    
    // Vérifier que la table existe
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        create_movie_comments_table();
    }
    
    $movie_id = sanitize_text_field($_POST['movie_id']);
    $comment_text = sanitize_textarea_field($_POST['comment_text']);
    $user_id = get_current_user_id();
    
    $inserted = $wpdb->insert(
        $table_name,
        [
            'movie_id' => $movie_id,
            'user_id' => $user_id,
            'comment_text' => $comment_text
        ],
        ['%s', '%d', '%s']
    );
    
    if ($inserted) {
        $comment_id = $wpdb->insert_id;
        $user = get_userdata($user_id);
        $avatar = get_user_meta($user_id, 'avatar_url', true);
        
        // Récupérer le timestamp exact de la base de données
        $created_at = $wpdb->get_var($wpdb->prepare(
            "SELECT created_at FROM $table_name WHERE id = %d",
            $comment_id
        ));
        
        wp_send_json_success([
            'comment_id' => $comment_id,
            'user_name' => $user->display_name,
            'avatar' => $avatar,
            'comment_text' => $comment_text,
            'created_at' => $created_at ? $created_at : current_time('mysql') // Utiliser le timestamp de la BD
        ]);
    } else {
        wp_send_json_error(['message' => 'Erreur lors de l\'ajout du commentaire']);
    }
}
add_action('wp_ajax_add_movie_comment', 'add_movie_comment');
add_action('wp_ajax_nopriv_add_movie_comment', 'add_movie_comment');

// Modifier un commentaire
function edit_movie_comment() {
    // check_ajax_referer('movie_comment_nonce', 'nonce');
    
    if (!is_user_logged_in()) {
        if (ob_get_length()) ob_clean();
wp_send_json_error(['message' => 'Vous devez être connecté']);
        return;
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'movie_comments';
    
    $comment_id = intval($_POST['comment_id']);
    $comment_text = sanitize_textarea_field($_POST['comment_text']);
    $user_id = get_current_user_id();
    
    // Vérifier que l'utilisateur est bien l'auteur
    $comment = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE id = %d AND user_id = %d",
        $comment_id, $user_id
    ));
    
    if (!$comment) {
        wp_send_json_error(['message' => 'Commentaire non trouvé ou non autorisé']);
    }
    
    $updated = $wpdb->update(
        $table_name,
        ['comment_text' => $comment_text],
        ['id' => $comment_id, 'user_id' => $user_id],
        ['%s'],
        ['%d', '%d']
    );
    
    if ($updated !== false) {
        wp_send_json_success(['comment_text' => $comment_text]);
    } else {
        wp_send_json_error(['message' => 'Erreur lors de la modification']);
    }
}
add_action('wp_ajax_edit_movie_comment', 'edit_movie_comment');

// Supprimer un commentaire
function delete_movie_comment() {
    // check_ajax_referer('movie_comment_nonce', 'nonce');
    
    if (!is_user_logged_in()) {
        if (ob_get_length()) ob_clean();
wp_send_json_error(['message' => 'Vous devez être connecté']);
        return;
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'movie_comments';
    
    $comment_id = intval($_POST['comment_id']);
    $user_id = get_current_user_id();
    
    $deleted = $wpdb->delete(
        $table_name,
        ['id' => $comment_id, 'user_id' => $user_id],
        ['%d', '%d']
    );
    
    if ($deleted) {
        wp_send_json_success(['message' => 'Commentaire supprimé']);
    } else {
        wp_send_json_error(['message' => 'Erreur lors de la suppression']);
    }
}
add_action('wp_ajax_delete_movie_comment', 'delete_movie_comment');

// Récupérer les commentaires d'un film
function get_movie_comments() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'movie_comments';
    
    $movie_id = sanitize_text_field($_POST['movie_id']);
    $current_user_id = get_current_user_id();
    
    $comments = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table_name WHERE movie_id = %s ORDER BY created_at DESC",
        $movie_id
    ));
    
    $comments_data = [];
    $likes_table = $wpdb->prefix . 'movie_comment_likes';
    foreach ($comments as $comment) {
        $user = get_userdata($comment->user_id);
        $avatar = get_user_meta($comment->user_id, 'avatar_url', true);
        // Récupérer le nombre de likes pour ce commentaire
        $like_count = (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $likes_table WHERE comment_id = %d", $comment->id));
        $liked_by_user = false;
        if ($current_user_id) {
            $liked_by_user = (bool) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $likes_table WHERE comment_id = %d AND user_id = %d", $comment->id, $current_user_id));
        }
        $comments_data[] = [
            'id' => $comment->id,
            'user_name' => $user->display_name,
            'avatar' => $avatar,
            'comment_text' => $comment->comment_text,
            'is_author' => ($comment->user_id == $current_user_id),
            'created_at' => $comment->created_at,
            'like_count' => $like_count,
            'liked_by_user' => $liked_by_user
        ];
    }
    wp_send_json_success(['comments' => $comments_data]);
}
add_action('wp_ajax_get_movie_comments', 'get_movie_comments');
add_action('wp_ajax_nopriv_get_movie_comments', 'get_movie_comments');

// ===== GESTION DES COMMENTAIRES COMPOSITEURS =====

// Créer une table pour les commentaires de compositeurs
function create_composer_comments_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'composer_comments';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        composer_id varchar(100) NOT NULL,
        user_id bigint(20) NOT NULL,
        comment_text text NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    dbDelta($sql);

// Mutualisé pour toutes les fonctions qui en ont besoin
if (!function_exists('dbDelta')) {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
}
}
add_action('after_switch_theme', 'create_composer_comments_table');

// Ajouter un commentaire compositeur
function add_composer_comment() {
    if (!is_user_logged_in()) {
        if (ob_get_length()) ob_clean();
wp_send_json_error(['message' => 'Vous devez être connecté']);
        return;
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'composer_comments';
    
    // Vérifier que la table existe
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        create_composer_comments_table();
    }
    
    $composer_id = sanitize_text_field($_POST['composer_id']);
    $comment_text = sanitize_textarea_field($_POST['comment_text']);
    $user_id = get_current_user_id();
    
    $inserted = $wpdb->insert(
        $table_name,
        [
            'composer_id' => $composer_id,
            'user_id' => $user_id,
            'comment_text' => $comment_text
        ],
        ['%s', '%d', '%s']
    );
    
    if ($inserted) {
        $comment_id = $wpdb->insert_id;
        $user = get_userdata($user_id);
        $avatar = get_user_meta($user_id, 'avatar_url', true);
        
        // Récupérer le timestamp exact de la base de données
        $comment = $wpdb->get_row($wpdb->prepare("SELECT created_at FROM $table_name WHERE id = %d", $comment_id), ARRAY_A);
        
        wp_send_json_success([
            'comment_id' => $comment_id,
            'user_name' => $user->display_name,
            'avatar' => $avatar,
            'comment_text' => $comment_text,
            'created_at' => $comment['created_at']
        ]);
    } else {
        wp_send_json_error(['message' => 'Erreur lors de l\'ajout du commentaire']);
    }
}
add_action('wp_ajax_add_composer_comment', 'add_composer_comment');

// Modifier un commentaire compositeur
function edit_composer_comment() {
    if (!is_user_logged_in()) {
        if (ob_get_length()) ob_clean();
wp_send_json_error(['message' => 'Vous devez être connecté']);
        return;
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'composer_comments';
    
    $comment_id = intval($_POST['comment_id']);
    $comment_text = sanitize_textarea_field($_POST['comment_text']);
    $user_id = get_current_user_id();
    
    // Vérifier que l'utilisateur est bien l'auteur
    $comment = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE id = %d AND user_id = %d",
        $comment_id, $user_id
    ));
    
    if (!$comment) {
        wp_send_json_error(['message' => 'Commentaire non trouvé ou non autorisé']);
    }
    
    $updated = $wpdb->update(
        $table_name,
        ['comment_text' => $comment_text],
        ['id' => $comment_id, 'user_id' => $user_id],
        ['%s'],
        ['%d', '%d']
    );
    
    if ($updated !== false) {
        wp_send_json_success(['comment_text' => $comment_text]);
    } else {
        wp_send_json_error(['message' => 'Erreur lors de la modification']);
    }
}
add_action('wp_ajax_edit_composer_comment', 'edit_composer_comment');

// Supprimer un commentaire compositeur
function delete_composer_comment() {
    if (!is_user_logged_in()) {
        if (ob_get_length()) ob_clean();
wp_send_json_error(['message' => 'Vous devez être connecté']);
        return;
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'composer_comments';
    
    $comment_id = intval($_POST['comment_id']);
    $user_id = get_current_user_id();
    
    $deleted = $wpdb->delete(
        $table_name,
        ['id' => $comment_id, 'user_id' => $user_id],
        ['%d', '%d']
    );
    
    if ($deleted) {
        wp_send_json_success(['message' => 'Commentaire supprimé']);
    } else {
        wp_send_json_error(['message' => 'Erreur lors de la suppression']);
    }
}
add_action('wp_ajax_delete_composer_comment', 'delete_composer_comment');

// Récupérer les commentaires d'un compositeur
function get_composer_comments() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'composer_comments';
    
    $composer_id = sanitize_text_field($_POST['composer_id']);
    $current_user_id = get_current_user_id();
    
    $comments = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table_name WHERE composer_id = %s ORDER BY created_at DESC",
        $composer_id
    ));
    
    $comments_data = [];
    foreach ($comments as $comment) {
        $user = get_userdata($comment->user_id);
        $avatar = get_user_meta($comment->user_id, 'avatar_url', true);
        
        $comments_data[] = [
            'id' => $comment->id,
            'user_name' => $user->display_name,
            'avatar' => $avatar,
            'comment_text' => $comment->comment_text,
            'is_author' => ($comment->user_id == $current_user_id),
            'created_at' => $comment->created_at
        ];
    }
    
    wp_send_json_success(['comments' => $comments_data]);
}
add_action('wp_ajax_get_composer_comments', 'get_composer_comments');
add_action('wp_ajax_nopriv_get_composer_comments', 'get_composer_comments');

// ===== SEARCH MOVIES API =====

// Fonction pour obtenir les infos d'un film par slug
function get_movie_data_by_slug($slug) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'movies';
    
    // Mapping des slugs vers les titres de films
    $slug_mapping = array(
        'inception' => 'Inception',
        'la-la-land' => 'La La Land',
        'the-matrix' => 'The Matrix',
        'john-wick' => 'John Wick',
        'mad-max' => 'Mad Max: Fury Road',
        'the-dark-knight' => 'The Dark Knight',
        'jumanji' => 'Jumanji',
        'superbad' => 'Superbad',
        'grand-budapest' => 'The Grand Budapest Hotel',
        'amelie' => 'Amélie',
        'interstellar' => 'Interstellar',
        'shawshank' => 'The Shawshank Redemption',
        'forrest-gump' => 'Forrest Gump',
        'pursuit-happiness' => 'The Pursuit of Happyness',
        'parasite' => 'Parasite',
        'blade-runner' => 'Blade Runner 2049',
        'dune' => 'Dune',
        'avatar' => 'Avatar',
        'tenet' => 'Tenet',
        'minority-report' => 'Minority Report',
        'the-shining' => 'The Shining',
        'hereditary' => 'Hereditary',
        'the-ring' => 'The Ring',
        'quiet-place' => 'A Quiet Place',
        'conjuring' => 'The Conjuring',
        'the-notebook' => 'The Notebook',
        'titanic' => 'Titanic',
        'pride-prejudice' => 'Pride and Prejudice',
        'crazy-rich-asians' => 'Crazy Rich Asians',
        'about-time' => 'About Time',
        'your-name' => 'Your Name',
        'demon-slayer-movie' => 'Demon Slayer Movie',
        'jjk-0' => 'Jujutsu Kaisen 0'
    );
    
    $title = isset($slug_mapping[$slug]) ? $slug_mapping[$slug] : null;
    
    if (!$title) {
        return null;
    }
    
    return $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE title = %s",
        $title
    ));
}

// Fonction pour obtenir les infos d'une série par slug
function get_series_data_by_slug($slug) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'movies';
    
    // Mapping des slugs vers les titres de séries
    $slug_mapping = array(
        'stranger-things' => 'Stranger Things',
        'the-crown' => 'The Crown',
        'breaking-bad' => 'Breaking Bad',
        'game-of-thrones' => 'Game of Thrones',
        'the-office' => 'The Office',
        'friends' => 'Friends',
        'the-last-of-us' => 'The Last of Us'
    );
    
    $title = isset($slug_mapping[$slug]) ? $slug_mapping[$slug] : null;
    
    if (!$title) {
        return null;
    }
    
    return $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE title = %s",
        $title
    ));
}

// Endpoint AJAX pour la recherche autocomplete
function search_movies() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'movies';
    
    $search = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
    
    if (strlen($search) < 2) {
        wp_send_json([]);
        return;
    }
    
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT id, title, type, genre FROM $table_name WHERE title LIKE %s LIMIT 10",
        '%' . $wpdb->esc_like($search) . '%'
    ));
    
    wp_send_json($results);
}
add_action('wp_ajax_search_movies', 'search_movies');
add_action('wp_ajax_nopriv_search_movies', 'search_movies');

// Récupérer les films/séries par genre
function get_movies_by_genre() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'movies';
    
    $type = sanitize_text_field($_GET['type']); // 'film' ou 'serie'
    $genre = sanitize_text_field($_GET['genre']);
    
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table_name WHERE type = %s AND genre = %s ORDER BY year DESC",
        $type, $genre
    ));
    
    wp_send_json(['movies' => $results]);
}
add_action('wp_ajax_get_movies_by_genre', 'get_movies_by_genre');
add_action('wp_ajax_nopriv_get_movies_by_genre', 'get_movies_by_genre');

// Fonction pour mettre à jour la base de données avec les nouvelles images
function update_movies_database() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'movies';
    
    // Vider la table
    $wpdb->query("TRUNCATE TABLE $table_name");
    
    // Réinsérer les films avec les nouvelles données
    insert_default_movies();
    
}
// Décommenter la ligne suivante et visiter n'importe quelle page du site pour mettre à jour la DB
add_action('wp_head', 'update_movies_database', 1);


// create custom post type for films / series / animes
function register_media_post_types() {
    // Custom Post Type unique pour tous les médias (Films, Séries, Animes)
    register_post_type('movie', array(
        'labels' => array(
            'name' => __('Médias', 'project-end-of-year'),
            'singular_name' => __('Média', 'project-end-of-year'),
            'add_new' => __('Ajouter un média', 'project-end-of-year'),
            'add_new_item' => __('Ajouter un nouveau média', 'project-end-of-year'),
            'edit_item' => __('Modifier le média', 'project-end-of-year'),
            'new_item' => __('Nouveau média', 'project-end-of-year'),
            'view_item' => __('Voir le média', 'project-end-of-year'),
            'search_items' => __('Rechercher des médias', 'project-end-of-year'),
            'not_found' => __('Aucun média trouvé', 'project-end-of-year'),
            'not_found_in_trash' => __('Aucun média dans la corbeille', 'project-end-of-year'),
        ),
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'comments'),
        'menu_icon' => 'dashicons-format-video',
        'rewrite' => array('slug' => 'movie'),
        'taxonomies' => array('media_type', 'genre', 'annee'),
        'show_in_menu' => true,
        'menu_position' => 5,
        'capability_type' => 'post',
    ));

    // Taxonomie: Type de média (Film, Série, Anime)
    register_taxonomy('media_type', array('movie'), array(
        'labels' => array(
            'name' => __('Types de média', 'project-end-of-year'),
            'singular_name' => __('Type de média', 'project-end-of-year'),
            'search_items' => __('Rechercher des types', 'project-end-of-year'),
            'all_items' => __('Tous les types', 'project-end-of-year'),
            'edit_item' => __('Modifier le type', 'project-end-of-year'),
            'update_item' => __('Mettre à jour le type', 'project-end-of-year'),
            'add_new_item' => __('Ajouter un nouveau type', 'project-end-of-year'),
            'new_item_name' => __('Nom du nouveau type', 'project-end-of-year'),
        ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'type'),
    ));

    // Taxonomie: Genre
    register_taxonomy('genre', array('movie'), array(
        'labels' => array(
            'name' => __('Genres', 'project-end-of-year'),
            'singular_name' => __('Genre', 'project-end-of-year'),
            'search_items' => __('Rechercher des genres', 'project-end-of-year'),
            'all_items' => __('Tous les genres', 'project-end-of-year'),
            'edit_item' => __('Modifier le genre', 'project-end-of-year'),
            'update_item' => __('Mettre à jour le genre', 'project-end-of-year'),
            'add_new_item' => __('Ajouter un nouveau genre', 'project-end-of-year'),
            'new_item_name' => __('Nom du nouveau genre', 'project-end-of-year'),
        ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'genre'),
    ));

    // Taxonomie: Année
    register_taxonomy('annee', array('movie'), array(
        'labels' => array(
            'name' => __('Années', 'project-end-of-year'),
            'singular_name' => __('Année', 'project-end-of-year'),
            'search_items' => __('Rechercher des années', 'project-end-of-year'),
            'all_items' => __('Toutes les années', 'project-end-of-year'),
            'edit_item' => __('Modifier l\'année', 'project-end-of-year'),
            'update_item' => __('Mettre à jour l\'année', 'project-end-of-year'),
            'add_new_item' => __('Ajouter une nouvelle année', 'project-end-of-year'),
            'new_item_name' => __('Nom de la nouvelle année', 'project-end-of-year'),
        ),
        'hierarchical' => false,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'annee'),
    ));
}
add_action('init', 'register_media_post_types');

// Créer les termes par défaut pour la taxonomie media_type
function create_default_media_types() {
    $types = array('Film', 'Série', 'Anime');
    
    foreach ($types as $type) {
        if (!term_exists($type, 'media_type')) {
            wp_insert_term($type, 'media_type');
        }
    }
}
add_action('init', 'create_default_media_types');

// Ajouter des meta boxes pour les champs personnalisés du CPT movie
function add_movie_meta_boxes() {
    add_meta_box(
        'movie_details',
        __('Détails du média', 'project-end-of-year'),
        'render_movie_meta_box',
        'movie',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_movie_meta_boxes');

// Afficher les champs personnalisés dans la meta box
function render_movie_meta_box($post) {
    // Nonce pour la sécurité
    wp_nonce_field('movie_meta_box', 'movie_meta_box_nonce');
    
    // Récupérer les valeurs existantes
    $duration = get_post_meta($post->ID, '_movie_duration', true);
    $rating = get_post_meta($post->ID, '_movie_rating', true);
    $director = get_post_meta($post->ID, '_movie_director', true);
    $cast = get_post_meta($post->ID, '_movie_cast', true);
    ?>
    
    <div style="display: grid; gap: 15px;">
        <div>
            <label for="movie_duration" style="display: block; margin-bottom: 5px; font-weight: 600;">
                <?php _e('Durée', 'project-end-of-year'); ?>
            </label>
            <input type="text" id="movie_duration" name="movie_duration" 
                   value="<?php echo esc_attr($duration); ?>" 
                   placeholder="Ex: 2h28" 
                   style="width: 100%; padding: 8px;">
            <p class="description">Format: 2h28, 1h45, etc.</p>
        </div>
        
        <div>
            <label for="movie_rating" style="display: block; margin-bottom: 5px; font-weight: 600;">
                <?php _e('Note', 'project-end-of-year'); ?>
            </label>
            <input type="text" id="movie_rating" name="movie_rating" 
                   value="<?php echo esc_attr($rating); ?>" 
                   placeholder="Ex: 8,8/10" 
                   style="width: 100%; padding: 8px;">
            <p class="description">Format: 8,8/10, 7,5/10, etc.</p>
        </div>
        
        <div>
            <label for="movie_director" style="display: block; margin-bottom: 5px; font-weight: 600;">
                <?php _e('Réalisateur', 'project-end-of-year'); ?>
            </label>
            <input type="text" id="movie_director" name="movie_director" 
                   value="<?php echo esc_attr($director); ?>" 
                   placeholder="Ex: Christopher Nolan" 
                   style="width: 100%; padding: 8px;">
        </div>
        
        <div>
            <label for="movie_cast" style="display: block; margin-bottom: 5px; font-weight: 600;">
                <?php _e('Acteurs', 'project-end-of-year'); ?>
            </label>
            <textarea id="movie_cast" name="movie_cast" 
                      rows="3" 
                      placeholder="Ex: Leonardo DiCaprio, Joseph Gordon-Levitt, Elliot Page" 
                      style="width: 100%; padding: 8px;"><?php echo esc_textarea($cast); ?></textarea>
            <p class="description">Séparez les acteurs par des virgules.</p>
        </div>
    </div>
    
    <?php
}

// Sauvegarder les champs personnalisés
function save_movie_meta_box($post_id) {
    // Vérifier le nonce
    if (!isset($_POST['movie_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['movie_meta_box_nonce'], 'movie_meta_box')) {
        return;
    }
    
    // Vérifier l'autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Vérifier les permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Sauvegarder les champs
    if (isset($_POST['movie_duration'])) {
        update_post_meta($post_id, '_movie_duration', sanitize_text_field($_POST['movie_duration']));
    }
    
    if (isset($_POST['movie_rating'])) {
        update_post_meta($post_id, '_movie_rating', sanitize_text_field($_POST['movie_rating']));
    }
    
    if (isset($_POST['movie_director'])) {
        update_post_meta($post_id, '_movie_director', sanitize_text_field($_POST['movie_director']));
    }
    
    if (isset($_POST['movie_cast'])) {
        update_post_meta($post_id, '_movie_cast', sanitize_textarea_field($_POST['movie_cast']));
    }
}
add_action('save_post_movie', 'save_movie_meta_box');

// Créer des posts de démonstration pour les films
function create_demo_movies() {
    // Vérifier si les posts existent déjà
    $existing = get_posts(array(
        'post_type' => 'movie',
        'name' => 'inception',
        'posts_per_page' => 1
    ));
    
    if (!empty($existing)) {
        return; // Les posts existent déjà
    }
    
    $demo_movies = array(
        array(
            'title' => 'Inception',
            'slug' => 'inception',
            'duration' => '2h28',
            'rating' => '8,8/10',
            'director' => 'Christopher Nolan',
            'cast' => 'Leonardo DiCaprio, Joseph Gordon-Levitt, Elliot Page, Tom Hardy, Dileep Rao, Ken Watanabe',
            'synopsis' => 'Dom Cobb est un voleur expérimenté dans l\'art périlleux de l\'extraction : sa spécialité consiste à s\'approprier les secrets les plus précieux d\'un individu, enfouis au plus profond de son subconscient, pendant qu\'il rêve et que son esprit est particulièrement vulnérable. Très recherché pour ses talents dans l\'univers trouble de l\'espionnage industriel, Cobb est aussi devenu un fugitif traqué dans le monde entier. Cependant, une ultime mission pourrait lui permettre de retrouver sa vie d\'avant.',
            'year' => '2010',
            'image' => 'inception affiche film.jpg'
        ),
        array(
            'title' => 'La La Land',
            'slug' => 'la-la-land',
            'duration' => '2h08',
            'rating' => '8,0/10',
            'director' => 'Damien Chazelle',
            'cast' => 'Ryan Gosling, Emma Stone, John Legend, J.K. Simmons',
            'synopsis' => 'Mia, une actrice en devenir, et Sebastian, un passionné de jazz, tentent de réaliser leurs rêves à Los Angeles. Leur histoire d\'amour est mise à l\'épreuve par leurs ambitions.',
            'year' => '2016',
            'image' => 'La La Land.jpg'
        ),
        array(
            'title' => 'Parasite',
            'slug' => 'parasite',
            'duration' => '2h12',
            'rating' => '8,6/10',
            'director' => 'Bong Joon-ho',
            'cast' => 'Song Kang-ho, Lee Sun-kyun, Cho Yeo-jeong, Choi Woo-shik',
            'synopsis' => 'La famille Kim, au chômage, s\'intéresse de près à la richissime famille Park. Un enchaînement d\'événements inattendus va lier leur destin.',
            'year' => '2019',
            'image' => 'Parasite.jpg'
        ),
        array(
            'title' => 'Interstellar',
            'slug' => 'interstellar',
            'duration' => '2h49',
            'rating' => '8,6/10',
            'director' => 'Christopher Nolan',
            'cast' => 'Matthew McConaughey, Anne Hathaway, Jessica Chastain, Michael Caine',
            'synopsis' => 'Dans un futur proche, la Terre se meurt. Un groupe d\'explorateurs utilise un trou de ver pour franchir les limites du voyage spatial humain et sauver l\'humanité.',
            'year' => '2014',
            'image' => 'interstellar affiche similaire.jpg'
        ),
        array(
            'title' => 'Arrival',
            'slug' => 'arrival',
            'duration' => '1h56',
            'rating' => '7,9/10',
            'director' => 'Denis Villeneuve',
            'cast' => 'Amy Adams, Jeremy Renner, Forest Whitaker, Michael Stuhlbarg',
            'synopsis' => 'Lorsque de mystérieux vaisseaux venus du fond de l\'espace surgissent un peu partout sur Terre, une équipe d\'experts est rassemblée sous la direction de la linguiste Louise Banks afin de tenter de comprendre leurs intentions. Face à l\'énigme que constituent leur présence et leurs messages mystérieux, les réactions dans le monde sont contrastées et l\'humanité se trouve bientôt au bord d\'une guerre absolue.',
            'year' => '2016',
            'image' => 'arrival affiche similaire.jpg'
        ),
        array(
            'title' => 'Breaking Bad',
            'slug' => 'breaking-bad-film',
            'duration' => '2h02',
            'rating' => '9,5/10',
            'director' => 'Vince Gilligan',
            'cast' => 'Bryan Cranston, Aaron Paul, Anna Gunn, Dean Norris',
            'synopsis' => 'Walter White, professeur de chimie, découvre qu\'il est atteint d\'un cancer. Pour assurer l\'avenir financier de sa famille, il décide de fabriquer de la méthamphétamine avec l\'aide de son ancien élève Jesse Pinkman.',
            'year' => '2008',
            'image' => 'breaking bad.webp'
        ),
    );
    
    foreach ($demo_movies as $movie_data) {
        // Créer le post
        $post_id = wp_insert_post(array(
            'post_title' => $movie_data['title'],
            'post_name' => $movie_data['slug'],
            'post_content' => $movie_data['synopsis'],
            'post_status' => 'publish',
            'post_type' => 'movie',
        ));
        
        if ($post_id && !is_wp_error($post_id)) {
            // Assigner la taxonomie "Film"
            wp_set_object_terms($post_id, 'film', 'media_type');
            
            // Ajouter les meta fields
            update_post_meta($post_id, '_movie_duration', $movie_data['duration']);
            update_post_meta($post_id, '_movie_rating', $movie_data['rating']);
            update_post_meta($post_id, '_movie_director', $movie_data['director']);
            update_post_meta($post_id, '_movie_cast', $movie_data['cast']);
            
            // Ajouter l'image à la une si elle existe
            $image_path = get_template_directory() . '/assets/image/Fiche films/' . $movie_data['image'];
            if (file_exists($image_path)) {
                $upload_dir = wp_upload_dir();
                $filename = basename($image_path);
                $target_path = $upload_dir['path'] . '/' . $filename;
                
                // Copier l'image dans le dossier uploads si elle n'existe pas déjà
                if (!file_exists($target_path)) {
                    copy($image_path, $target_path);
                }
                
                // Créer l'attachement
                $filetype = wp_check_filetype($filename, null);
                $attachment = array(
                    'guid' => $upload_dir['url'] . '/' . $filename,
                    'post_mime_type' => $filetype['type'],
                    'post_title' => sanitize_file_name($filename),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                
                $attach_id = wp_insert_attachment($attachment, $target_path, $post_id);
                
                if ($attach_id && !is_wp_error($attach_id)) {
                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                    $attach_data = wp_generate_attachment_metadata($attach_id, $target_path);
                    wp_update_attachment_metadata($attach_id, $attach_data);
                    set_post_thumbnail($post_id, $attach_id);
                }
            }
        }
    }
}
// Décommenter la ligne suivante et visiter n'importe quelle page pour créer les posts (puis re-commenter)
// add_action('wp_footer', 'create_demo_movies', 1);

