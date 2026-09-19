<?php
// Sécurité : Empêche l'accès direct au fichier
defined('ABSPATH') || exit;

// Custom Taxonomy - Catégorie de pizza
function pizza_category_taxonomy() {
    $labels = [
        'name' => __('Catégories de pizzas'),
        'singular_name' => __('Catégorie de pizza'),
        'search_items' => __('Rechercher des catégories'),
        'all_items' => __('Toutes les catégories'),
        'parent_item' => __('Catégorie parente'),
        'parent_item_colon' => __('Catégorie parente :'),
        'edit_item' => __('Modifier la catégorie'),
        'update_item' => __('Mettre à jour la catégorie'),
        'add_new_item' => __('Ajouter une nouvelle catégorie'),
        'new_item_name' => __('Nom de la nouvelle catégorie'),
        'back_to_items' => __('Retour aux catégories'),
        'menu_name' => __('Catégories'),
    ];

    $args = [
        'hierarchical' => true, // true pour les cases à cocher, false pour les étiquettes
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'pizza-category'],
    ];

    register_taxonomy('pizza_category', 'pizza', $args);
}