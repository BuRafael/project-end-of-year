<?php
/**
 * Template for La La Land page
 */

// Forcer le slug pour La La Land
global $post;
if ($post) {
    $post->post_name = 'la-la-land';
}

// Inclure le template de fiche film
include(get_template_directory() . '/template-fiche-film.php');
?>
