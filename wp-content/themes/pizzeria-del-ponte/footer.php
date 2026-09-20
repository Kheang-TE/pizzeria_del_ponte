<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Pizzeria_Del_Ponte
 */

?>
	
	<footer id="colophon" class="site-footer">

		<?php
			$address = get_option('pizzeria-del-ponte_address', false);
			$phone = get_option('pizzeria-del-ponte_phone', false);
			$hourly = get_option('pizzeria-del-ponte_hourly', false);
		?>
		<div class="company-info">
			<div class="container">
				<div class="row text-center">

					<div class="col-12 col-md-4 py-5">
						<h1><?= strtoupper(get_bloginfo('name')) ?></h1>
						<?php if($address){ echo '<address>'.esc_html($address).'</address>'; } ?>
					</div>

					<?php if($hourly): ?>
						<div class="col-12 col-md-4 py-5">
							<h2 class="text-uppercase">Horaires d'ouverture</h2>
							<p><?= wp_kses_post($hourly); ?></p>
						</div>
					<?php endif; ?>

					<?php if($phone): ?>
						<div class="col-12 col-md-4 py-5">
							<h2 class="text-uppercase">Nous joindre</h2>
							<a href="tel:<?= str_replace(' ','',esc_attr($phone)) ?>"><?= esc_html($phone) ?></a>
						</div>
					<?php endif; ?>

				</div>
			</div>
		</div>

		<div class="site-copy col text-center">
			<div class="container">
				<div class="row">
					<div class="col py-3">
						Tous droits réservé &copy; 2026 - <a href="<?= get_bloginfo('url') ?>" rel="nofollow" target="_self"><?= strtoupper(get_bloginfo('name')) ?></a>
					</div>
				</div>
			</div>
		</div><!-- .site-info -->

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
