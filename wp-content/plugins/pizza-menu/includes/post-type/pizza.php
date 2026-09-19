<?php
// Sécurité : Empêche l'accès direct au fichier
defined('ABSPATH') || exit;

/* Custom Post Type - Pizza */
function pizza_post_type() {
    $labels = [
        'name' => __('Pizzas'),
        'singular_name' => __('Pizza'),
        'add_new' => __('Ajouter une pizza'),
        'add_new_item' => __('Ajouter une nouvelle pizza'),
        'edit_item' => __('Modifier la pizza'),
        'new_item' => __('Nouvelle pizza'),
        'view_item' => __('Voir la pizza'),
        'search_items' => __('Rechercher des pizzas'),
        'not_found' => __('Aucune pizza trouvée'),
        'not_found_in_trash' => __('Aucune pizza trouvée dans la corbeille'),
    ];

    $args = [
        'labels' => $labels,
        'description' => __('Un type de contenu pour gérer les pizzas.'),
        'public' => true,
        'hierarchical' => false,
        'show_in_rest' => true,
        'show_in_menu' => true,
        'menu_position' => 21,
        'menu_icon' => 'dashicons-image-filter',
        'has_archive' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
    ];

    register_post_type('pizza', $args);
}