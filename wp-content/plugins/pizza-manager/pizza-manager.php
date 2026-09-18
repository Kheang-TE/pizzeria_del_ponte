<?php
/** 
 * Plugin Name: Pizza Manager
 * Description: Extension pour gérer les pizzas.
 * Version: 1.0
 */

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
require_once 'includes/post-type/pizza.php';
add_action('init', 'pizza_post_type');

// Metabox pour le prix
require_once 'includes/metabox/price.php';
add_action('add_meta_boxes', 'pizza_price_metabox'); // Affichage de la metabox pour le prix
add_action('save_post', 'pizza_save_price'); // Sauvegarde de la valeur du prix lors de l'enregistrement du post
