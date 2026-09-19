<?php
// Récupérer les paramètres du menu
$presentation = get_option(
    'pizza_menu_presentation',
    DEFAULT_SETTINGS['pizza_menu_presentation']
);

$pizzas_per_page = absint(get_option(
    'pizza_menu_pizzas_per_page',
    DEFAULT_SETTINGS['pizza_menu_pizzas_per_page']
));
// Le nombre de pizzas par page est au moins 1
$pizzas_per_page = max(1, $pizzas_per_page);

$columns = absint(get_option(
    'pizza_menu_columns',
    DEFAULT_SETTINGS['pizza_menu_columns']
));
// Le nombre de colonnes est compris entre 1 et 6
$columns = min(6, max(1, $columns));

$order_by = get_option(
    'pizza_menu_order_by',
    DEFAULT_SETTINGS['pizza_menu_order_by']
);
// Vérifier que l'option est valide, sinon utiliser la valeur "title" par défaut
if (!in_array($order_by, ['title', 'price'], true)) {
    $order_by = 'title';
}

$show_unavailable = get_option(
    'pizza_menu_show_unavailable',
    DEFAULT_SETTINGS['pizza_menu_show_unavailable']
);

// Préparer les arguments pour la requête WP_Query
$query_args = [
    'post_type' => 'pizza',
    'post_status' => 'publish',
    'posts_per_page' => $pizzas_per_page,
];

// Trier les pizzas selon l'option choisie
if($order_by === 'title'){
    $query_args['orderby'] = 'title';
    $query_args['order'] = 'ASC';
} elseif($order_by === 'price'){
    $query_args['meta_key'] = 'pizza_price';
    $query_args['orderby'] = 'meta_value_num';
    $query_args['order'] = 'ASC';
}

// Afficher uniquement les pizzas disponibles si l'option est activée
if ($show_unavailable === 'no') {
    $query_args['meta_query'] = [
        [
            'key'     => 'pizza_availability',
            'value'   => 'no',
            'compare' => '!=',
        ],
    ];
}

// Exécuter la requête pour récupérer les pizzas
$pizza_query = new WP_Query($query_args);
?>

<section <?= get_block_wrapper_attributes(['class' => 'pizza-menu']); ?>>

    <?php if (!empty($presentation)) : ?>
        <div class="pizza-menu__presentation">
            <?= wp_kses_post(wpautop($presentation)); ?>
        </div>
    <?php endif; ?>

    <?php if ($pizza_query->have_posts()) : ?>
        <div class="pizza-menu__grid" style="grid-template-columns: repeat(<?= esc_attr($columns); ?>, 1fr);">
            <?php while ($pizza_query->have_posts()) : $pizza_query->the_post(); ?>
                <div class="pizza-menu__item">
                    <h2 class="pizza-menu__title"><?= esc_html(get_the_title()); ?></h2>
                    <img class="pizza-menu__image" src="<?= esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" alt="<?= esc_attr(get_the_title()); ?>" />
                    <div class="pizza-menu__price"><?= esc_html(get_post_meta(get_the_ID(), 'pizza_price', true)); ?> €</div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p><?= __('Aucune pizza trouvée.', 'pizza-menu'); ?></p>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>

</section>