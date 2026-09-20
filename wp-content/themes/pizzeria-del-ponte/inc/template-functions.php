<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Pizzeria_Del_Ponte
 */

/**
 * CONSTANTES
 */
const COMPANY_PAGE_ADMIN = 'pizzeria-del-ponte';
const DEFAULT_SETTINGS = [
	'pizzeria-del-ponte_address' => '',
	'pizzeria-del-ponte_hourly' => '',
	'pizzeria-del-ponte_phone' => '',
];
const SECTION_NAME = 'pizzeria-del-ponte_informations_section';

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function pizzeria_del_ponte_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'pizzeria_del_ponte_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function pizzeria_del_ponte_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'pizzeria_del_ponte_pingback_header' );

/**
 * Ajouter la page d'administration pour les paramètres de la société
 */
function company_menu_page() {
	add_menu_page(
        __('Société', 'pizzeria-del-ponte'), // Titre de la page
        __('Société', 'pizzeria-del-ponte'), // Titre du menu
        'manage_options', // Capacité requise pour accéder à cette page
        COMPANY_PAGE_ADMIN, // Slug de la page
        'company_menu_page_content', // Fonction de rappel pour afficher le contenu de la page
        'dashicons-store', // Icône du menu
        99 // Position du menu
    );
}
add_action('admin_menu', 'company_menu_page');

/**
 * Contenu de la page d'administration Société
 */
function company_menu_page_content() {
    echo '<div class="wrap">
        <h1>' . __('Société', 'pizzeria-del-ponte') . '</h1>
        <form method="post" action="options.php">';
			settings_fields(COMPANY_PAGE_ADMIN); // Champs de validation du formulaire
			do_settings_sections(COMPANY_PAGE_ADMIN); // Sections de paramètres pour afficher les options
			submit_button(); // Bouton de sauvegarde
        echo'</form>
    </div>';
}

/**
 * Ajouter la sections et les champs à renseigner
 */
function company_informations_sections() {
    // Enregistrer les paramètres pour la page d'information
    register_setting(COMPANY_PAGE_ADMIN, 'pizzeria-del-ponte_address', [
        'default' => DEFAULT_SETTINGS['pizzeria-del-ponte_address'],
    ]);
    register_setting(COMPANY_PAGE_ADMIN, 'pizzeria-del-ponte_hourly', [
        'sanitize_callback' => 'wp_kses_post',
        'default' => DEFAULT_SETTINGS['pizzeria-del_hourly'],
    ]);
    register_setting(COMPANY_PAGE_ADMIN, 'pizzeria-del-ponte_phone', [
        'default' => DEFAULT_SETTINGS['pizzeria-del-ponte_phone'],
    ]);

    // Ajouter une section pour informations pratiques
    add_settings_section(
        'pizzeria-del-ponte_informations_section', // ID de la section
        __('Informations pratiques', 'pizzeria-del-ponte'), // Titre de la section
        function () { // Fonction de rappel pour afficher le contenu de la section
            echo '<p>' . __('Veuillez renseigner les informations de la société.', 'pizzeria-del-ponte') . '</p>';
        },
        COMPANY_PAGE_ADMIN // Page sur laquelle la section sera affichée
    );

    // Ajouter les champs de paramètres pour la présentation du menu
    add_settings_field(
        'pizzeria-del-ponte_address', // ID du champ
        __('Adresse', 'pizzeria-del-ponte'), // Titre du champ
        function () { // Fonction de rappel pour afficher le champ
            $address = get_option('pizzeria-del-ponte_address', DEFAULT_SETTINGS['pizzeria-del-ponte_address']);
            echo '<input type="text" name="pizzeria-del-ponte_address" style="width: 100%;" value="' . esc_attr($address) .'" />';
        }, 
        COMPANY_PAGE_ADMIN, // Page sur laquelle le champ sera affiché
        SECTION_NAME // Section à laquelle le champ appartient
    );

    add_settings_field(
        'pizzeria-del-ponte_hourly',
        __('Horaire', 'pizzeria-del-ponte'),
        function () {
            $hourly = get_option('pizzeria-del-ponte_hourly', DEFAULT_SETTINGS['pizzeria-del-ponte_hourly']);
            echo '<textarea name="pizzeria-del-ponte_hourly" rows="10" style="width:100%">' . wp_kses_post($hourly) . '</textarea>';
        },
        COMPANY_PAGE_ADMIN,
        SECTION_NAME
    );

    add_settings_field(
        'pizzeria-del-ponte_phone',
        __('Numéro de téléphone', 'pizzeria-del-ponte'),
        function () {
            $phone = get_option('pizzeria-del-ponte_phone', DEFAULT_SETTINGS['pizzeria-del-ponte_phone']);
            echo '<input type="text" name="pizzeria-del-ponte_phone" value="' . esc_attr($phone) . '" />';
        },
        COMPANY_PAGE_ADMIN,
        SECTION_NAME
    );
}
add_action('admin_init', 'company_informations_sections');