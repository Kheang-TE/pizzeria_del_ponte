<?php
// Sécurité : Empêche l'accès direct au fichier
defined('ABSPATH') || exit;

// Constantes pour la page d'administration et les paramètres par défaut
const GROUP_PAGE = 'pizza-menu-settings';
const DEFAULT_SETTINGS = [
    'pizza_menu_presentation' => '',
    'pizza_menu_pizzas_per_page' => 10,
    'pizza_menu_columns_default' => 3,
    'pizza_menu_columns_max' => 4,
    'pizza_menu_order_by' => 'title',
    'pizza_menu_show_unavailable' => 'yes',
];

// Ajouter la page d'administration pour les paramètres du plugin
function pizza_menu_page() {
    add_menu_page(
        __('Pizza Menu', 'pizza-menu'), // Titre de la page
        __('Pizza Menu', 'pizza-menu'), // Titre du menu
        'manage_options', // Capacité requise pour accéder à cette page
        GROUP_PAGE, // Slug de la page
        'pizza_menu_page_content', // Fonction de rappel pour afficher le contenu de la page
        'dashicons-analytics', // Icône du menu
        81 // Position du menu
    );
}

// Contenu de la page d'administration
function pizza_menu_page_content() {
    ?>
    <div class="wrap">
        <h1><?php _e('Pizza Menu', 'pizza-menu'); ?></h1>
        <form method="post" action="options.php">
            <?php
                settings_fields(GROUP_PAGE); // Champs de validation du formulaire
                do_settings_sections(GROUP_PAGE); // Sections de paramètres pour afficher les options
                submit_button(); // Bouton de sauvegarde
            ?>
        </form>
    </div>
    <?php
}

// Ajouter les sections et les champs de paramètres
function pizza_settings_sections() {
    // Enregistrer les paramètres pour la présentation du menu
    register_setting(GROUP_PAGE, 'pizza_menu_presentation', [
        'sanitize_callback' => 'wp_kses_post',
        'default' => DEFAULT_SETTINGS['pizza_menu_presentation'],
    ]);
    register_setting(GROUP_PAGE, 'pizza_menu_pizzas_per_page', [
        'sanitize_callback' => function ($value) {
            return max(1, absint($value));
        },
        'default' => DEFAULT_SETTINGS['pizza_menu_pizzas_per_page'],
    ]);
    register_setting(GROUP_PAGE, 'pizza_menu_columns', [
        'sanitize_callback' => function ($value) {
            return min(6, max(1, absint($value)));
        },
        'default' => DEFAULT_SETTINGS['pizza_menu_columns'],
    ]);
    register_setting(GROUP_PAGE, 'pizza_menu_order_by', [
        'sanitize_callback' => function ($value) {
            return in_array($value, ['title', 'price'], true)
                ? $value
                : 'title';
        },
        'default' => DEFAULT_SETTINGS['pizza_menu_order_by'],
    ]);
    register_setting(GROUP_PAGE, 'pizza_menu_show_unavailable', [
        'sanitize_callback' => function ($value) {
            return $value === 'no' ? 'no' : 'yes';
        },
        'default' => DEFAULT_SETTINGS['pizza_menu_show_unavailable'],
    ]);

    // Ajouter une section pour les paramètres d'affichage des pizzas
    add_settings_section(
        'pizza_menu_settings_section', // ID de la section
        __('Paramètres d\'affichage des pizzas', 'pizza-menu'), // Titre de la section
        function () { // Fonction de rappel pour afficher le contenu de la section
            echo '<p>' . __('Un bloc Gutenberg est disponible pour afficher les pizzas selon les paramètres ci-dessous.', 'pizza-menu') . '</p>';
        },
        GROUP_PAGE // Page sur laquelle la section sera affichée
    );

    // Ajouter les champs de paramètres pour la présentation du menu
    add_settings_field(
        'pizza_menu_presentation', // ID du champ
        __('Texte de présentation', 'pizza-menu'), // Titre du champ
        function () { // Fonction de rappel pour afficher le champ
            $presentation = get_option('pizza_menu_presentation', DEFAULT_SETTINGS['pizza_menu_presentation']);
            echo '<textarea name="pizza_menu_presentation" rows="5" style="width: 100%;">' . wp_kses_post($presentation) . '</textarea>';
        }, 
        GROUP_PAGE, // Page sur laquelle le champ sera affiché
        'pizza_menu_settings_section' // Section à laquelle le champ appartient
    );

    add_settings_field(
        'pizza_menu_pizzas_per_page',
        __('Nombre de pizzas par page', 'pizza-menu'),
        function () {
            $pizzas_per_page = get_option('pizza_menu_pizzas_per_page', DEFAULT_SETTINGS['pizza_menu_pizzas_per_page']);
            echo '<input type="number" name="pizza_menu_pizzas_per_page" value="' . esc_attr($pizzas_per_page) . '" min="1" />';
        },
        GROUP_PAGE,
        'pizza_menu_settings_section'
    );

    add_settings_field(
        'pizza_menu_columns',
        __('Nombre de colonnes', 'pizza-menu'),
        function () {
            $columns = get_option('pizza_menu_columns', DEFAULT_SETTINGS['pizza_menu_columns_default']);
            echo '<input type="number" name="pizza_menu_columns" value="' . esc_attr($columns) . '" min="1" max="' . esc_attr(DEFAULT_SETTINGS['pizza_menu_columns_max']) . '" />';
        },
        GROUP_PAGE,
        'pizza_menu_settings_section'
    );

    add_settings_field(
        'pizza_menu_order_by',
        __('Trier les pizzas par', 'pizza-menu'),
        function () {
            $order_by = get_option('pizza_menu_order_by', DEFAULT_SETTINGS['pizza_menu_order_by']);
            echo '<select name="pizza_menu_order_by">
                    <option value="title" ' . selected($order_by, 'title', false) . '>Titre</option>
                    <option value="price" ' . selected($order_by, 'price', false) . '>Prix</option>
                  </select>';
        },
        GROUP_PAGE,
        'pizza_menu_settings_section'
    );

    add_settings_field(
        'pizza_menu_show_unavailable',
        __('Afficher les pizzas non disponibles', 'pizza-menu'),
        function () {
            $show_unavailable = get_option('pizza_menu_show_unavailable', DEFAULT_SETTINGS['pizza_menu_show_unavailable']);
            echo '<select name="pizza_menu_show_unavailable">
                    <option value="yes" ' . selected($show_unavailable, 'yes', false) . '>Oui</option>
                    <option value="no" ' . selected($show_unavailable, 'no', false) . '>Non</option>
                  </select>';
        },
        GROUP_PAGE,
        'pizza_menu_settings_section'
    );

}
