<?php
// Metabox pour le prix de la pizza
function pizza_price_metabox() {
    add_meta_box(
        'pizza_price', // ID de la metabox
        __('Prix de la pizza'), // Titre de la metabox
        'pizza_price_metabox_callback', // Fonction de rappel pour afficher le contenu de la metabox
        'pizza', // Type de post pour lequel la metabox sera affichée
        'side', // Position de la metabox (side, normal, advanced)
        'default' // Priorité de la metabox (default, high, low)
    );
}

// Callback pour afficher le contenu de la metabox
/**
 * $post : L'objet post actuel.
 */
function pizza_price_metabox_callback($post) {

    // Récupérer la valeur actuelle du prix
    $get_price = get_post_meta($post->ID, 'pizza_price', true);
    $price = ($get_price) ? $get_price : $price = '0';
    ?>

    <label for="pizza_price"><?php _e('Prix de la pizza :'); ?></label>
    <input type="text" id="pizza_price" name="pizza_price" value="<?php echo esc_attr(number_format((float)$price, 2, '.', '')); ?>" /> €
    <input type="hidden" name="pizza_price_nonce" value="<?php echo wp_create_nonce('pizza_price_nonce'); ?>" />

    <?php
}

// Sauvegarder la valeur du prix lors de l'enregistrement du post
/**
 * $post_id : L'ID du post en cours de sauvegarde.
 */
function pizza_save_price($post_id) {
    // Vérifier le nonce pour la sécurité
    if(!isset($_POST['pizza_price_nonce']) || !wp_verify_nonce($_POST['pizza_price_nonce'], 'pizza_price_nonce')) {
        return;
    }

    // Vérifier si l'utilisateur a la permission d'éditer le post
    if(!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Vérifier si le champ de prix est défini
    if(isset($_POST['pizza_price'])) {
        // Vérifier si la valeur du prix est un nombre valide (entier ou décimal)
        if(function_exists('preg_match') && preg_match('/^[0-9]+(\.[0-9]+){0,2}?$/', $_POST['pizza_price'])) {
            $price = sanitize_text_field($_POST['pizza_price']);
            update_post_meta($post_id, 'pizza_price', $price);
        } else {
            // Si le prix n'est pas un nombre valide, on sauvegarde "0" par défaut
            update_post_meta($post_id, 'pizza_price', '0');
        }
    }
}