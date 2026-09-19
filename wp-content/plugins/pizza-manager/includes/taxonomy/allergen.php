<?php
// Custom Taxonomy - Allergène
function pizza_allergen_taxonomy() {
    $labels = [
        'name' => __('Allergènes'),
        'singular_name' => __('Allergène'),
        'search_items' => __('Rechercher des allergènes'),
        'all_items' => __('Tous les allergènes'),
        'parent_item' => __('Allergène parent'),
        'parent_item_colon' => __('Allergène parent :'),
        'edit_item' => __('Modifier l\'allergène'),
        'update_item' => __('Mettre à jour l\'allergène'),
        'add_new_item' => __('Ajouter un nouvel allergène'),
        'new_item_name' => __('Nom du nouvel allergène'),
        'back_to_items' => __('Retour aux allergènes'),
        'menu_name' => __('Allergènes'),
    ];

    $args = [
        'hierarchical' => true, // true pour les cases à cocher, false pour les étiquettes
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'pizza-allergen'],
    ];

    register_taxonomy('pizza_allergen', 'pizza', $args);
}