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

    <!-- Filtre -->
    <?php
        $pizza_categories = get_terms([
            'taxonomy' => 'pizza_category',
            'hide_empty' => true,
        ]);

        if(!empty($pizza_categories)):
    ?>
        <div class="pizza-menu__header">
            <span>Filtre :</span>
            <select id="pizza_categories">
                <option value="all">Toutes les pizzas</option>
                <?php foreach($pizza_categories as $category): ?>
                    <option value="<?= $category->slug ?>"><?= $category->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endif; ?>
    <!-- Fin du filtre -->

    <!-- Présentation -->
    <?php if (!empty($presentation)) : ?>
        <div class="pizza-menu__presentation">
            <?= wp_kses_post(wpautop($presentation)); ?>
        </div>
    <?php endif; ?>
    <!-- Fin de la présentation -->

    <!-- Affichage des pizzas -->
    <?php if ($pizza_query->have_posts()) : ?>

        <div class="pizza-menu__flex">

            <?php while ($pizza_query->have_posts()) : $pizza_query->the_post(); ?>

            <?php
                $categories = get_the_terms(get_the_ID(), 'pizza_category');
                $pizza_cat = [];
                foreach($categories as $category):
                    array_push($pizza_cat, $category->slug);
                endforeach;
            ?>

                <div class="pizza-menu__item pizza-menu__flex--columns-<?= esc_attr($columns); ?> <?=  implode(' ', $pizza_cat); ?>">
                    <h3 class="pizza-menu__item-title"><?= esc_html(get_the_title()); ?></h3>
                    
                    <?php if (has_post_thumbnail()): ?>
                        <div class="pizza-menu__item-image">
                            <?php if (get_post_meta(get_the_ID(), 'pizza_availability', true) === 'no'): ?>
                                <div class="pizza-menu__item-availability"><?= __('Indisponible', 'pizza-menu'); ?></div>
                            <?php endif; ?>
                            <img src="<?= esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" alt="<?= esc_attr(get_the_title()); ?>" />
                        </div>
                    <?php endif; ?>
                    <div class="pizza-menu__item-price"><?= esc_html(get_post_meta(get_the_ID(), 'pizza_price', true)); ?> €</div>
                </div>

            <?php endwhile; ?>

        </div>

    <?php else : ?>
        <p><?= __('Aucune pizza trouvée.', 'pizza-menu'); ?></p>
    <?php endif; ?>
    <!-- Fin de l'affichage des pizzas -->

    <?php wp_reset_postdata(); // Réinitialisation les données ?>

</section>