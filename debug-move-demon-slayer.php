<?php
// Script temporaire à placer dans le thème, puis à supprimer après usage
add_action('init', function() {
    if (!is_user_logged_in()) return;
    $user_id = get_current_user_id();
    $favorites = get_user_meta($user_id, 'cinemusic_favorites', true);
    if (!is_array($favorites)) return;

    // Remplacer par l'ID réel de Demon Slayer (récupéré via l'admin ou debug)
    $demon_slayer_id = null;
    // Chercher l'ID de Demon Slayer dans les films
    if (isset($favorites['films']) && is_array($favorites['films'])) {
        foreach ($favorites['films'] as $k => $id) {
            $post = get_post($id);
            if ($post && stripos($post->post_title, 'demon slayer') !== false) {
                $demon_slayer_id = $id;
                // Retirer de films
                unset($favorites['films'][$k]);
                break;
            }
        }
    }
    // Ajouter à séries si trouvé
    if ($demon_slayer_id) {
        if (!isset($favorites['series']) || !is_array($favorites['series'])) {
            $favorites['series'] = [];
        }
        if (!in_array($demon_slayer_id, $favorites['series'])) {
            $favorites['series'][] = $demon_slayer_id;
        }
        // Réindexer
        $favorites['films'] = array_values($favorites['films']);
        $favorites['series'] = array_values($favorites['series']);
        update_user_meta($user_id, 'cinemusic_favorites', $favorites);
        error_log('Demon Slayer déplacé dans séries.');
    }
});
