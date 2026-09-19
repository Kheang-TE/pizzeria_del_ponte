<?php
/** 
 * Plugin Name: Pizza Menu
 * Description: Extension pour gérer les pizzas.
 * Version: 1.0
 */

// Sécurité : Empêche l'accès direct au fichier
defined('ABSPATH') || exit;

// Activation du plugin
register_activation_hook(__FILE__, 'pizza_manager_activate');
function pizza_manager_activate() {
}

// Désactivation du plugin
register_deactivation_hook(__FILE__, 'pizza_manager_deactivate');
function pizza_manager_deactivate() {
}

// Désinstallation du plugin
register_uninstall_hook(__FILE__, 'pizza_manager_uninstall');
function pizza_manager_uninstall() {
}

// Custom Post Type pour les pizzas
if(!function_exists('pizza_post_type') && file_exists(plugin_dir_path(__FILE__) . 'includes/post-type/pizza.php')) {
    require_once 'includes/post-type/pizza.php';
    add_action('init', 'pizza_post_type');
}

// Metabox pour le prix
if(!function_exists('pizza_price_metabox') && file_exists(plugin_dir_path(__FILE__) . 'includes/metabox/price.php')) {
    require_once 'includes/metabox/price.php';
    add_action('add_meta_boxes', 'pizza_price_metabox'); // Affichage de la metabox pour le prix
    add_action('save_post', 'pizza_save_price'); // Sauvegarde de la valeur du prix lors de l'enregistrement du post
}

// Metabox pour la disponibilité
if(!function_exists('pizza_availability_metabox') && file_exists(plugin_dir_path(__FILE__) . 'includes/metabox/available.php')) {
    require_once 'includes/metabox/available.php';
    add_action('add_meta_boxes', 'pizza_availability_metabox'); // Affichage de la metabox pour la disponibilité
    add_action('save_post', 'pizza_save_availability'); // Sauvegarde de la valeur de la disponibilité lors de l'enregistrement du post
}

// Taxonomy pour les catégories
if(!function_exists('pizza_category_taxonomy') && file_exists(plugin_dir_path(__FILE__) . 'includes/taxonomy/category.php')) {
    require_once 'includes/taxonomy/category.php';
    add_action('init', 'pizza_category_taxonomy');
}

// Taxonomy pour les allergènes
if(!function_exists('pizza_allergen_taxonomy') && file_exists(plugin_dir_path(__FILE__) . 'includes/taxonomy/allergen.php')) {
    require_once 'includes/taxonomy/allergen.php';
    add_action('init', 'pizza_allergen_taxonomy');
}