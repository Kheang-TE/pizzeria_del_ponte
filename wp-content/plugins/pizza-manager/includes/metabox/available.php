<?php
// Sécurité : Empêche l'accès direct au fichier
defined('ABSPATH') || exit;

// Metabox pour la disponibilité de la pizza
function pizza_availability_metabox() {
    add_meta_box(
        'pizza_availability', // ID de la metabox
        __('Disponibilité de la pizza'), // Titre de la metabox
        'pizza_availability_metabox_callback', // Fonction de rappel pour afficher le contenu de la metabox
        'pizza', // Type de post pour lequel la metabox sera affichée
        'side', // Position de la metabox (side, normal, advanced)
        'default' // Priorité de la metabox (default, high, low)
    );
}

// Callback pour afficher le contenu de la metabox
function pizza_availability_metabox_callback($post) {
    // Récupérer la valeur actuelle de la disponibilité
    $get_availability = get_post_meta($post->ID, 'pizza_availability', true);
    $availability = ($get_availability == 'no') ? $get_availability : 'yes'; // Valeur par défaut : "yes" (disponible)
    ?>

    <label for="pizza_availability"><?php _e('Disponible :'); ?></label>
    <input type="hidden" name="pizza_availability_nonce" value="<?php echo wp_create_nonce('pizza_availability_nonce'); ?>" />
    <select name="pizza_availability" id="pizza_availability">
        <option value="yes" <?php selected($availability, 'yes'); ?>><?php _e('Oui'); ?></option>
        <option value="no" <?php selected($availability, 'no'); ?>><?php _e('Non'); ?></option>
    </select>

    <?php
}

// Sauvegarder la valeur de la disponibilité lors de l'enregistrement du post
function pizza_save_availability($post_id) {
    // Vérifier le nonce pour la sécurité
    if(!isset($_POST['pizza_availability_nonce']) || !wp_verify_nonce($_POST['pizza_availability_nonce'], 'pizza_availability_nonce')) {
        return;
    }

    // Vérifier si l'utilisateur a la permission d'éditer le post
    if(!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Vérifier si le champ de disponibilité est défini
    $availability_choices = ['yes', 'no'];
    if(isset($_POST['pizza_availability']) && in_array($_POST['pizza_availability'], $availability_choices)) {
        $availability = sanitize_text_field($_POST['pizza_availability']);
        update_post_meta($post_id, 'pizza_availability', $availability);
    } else {
        // Si la valeur n'est pas valide, on sauvegarde "yes" par défaut
        update_post_meta($post_id, 'pizza_availability', 'yes');
    }
}