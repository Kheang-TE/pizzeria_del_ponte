<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Pizzeria_Del_Ponte
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'pizzeria-del-ponte' ); ?></a>

	<header id="masthead" class="site-header position-relative py-3">

		<div class="container">
			<div class="row justify-content-between">

				<div class="site-branding col">
					<?php the_custom_logo(); ?>
					<h1 class="site-title text-uppercase"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
					$pizzeria_del_ponte_description = get_bloginfo( 'description', 'display' );
					if ( $pizzeria_del_ponte_description || is_customize_preview() ) :
						?>
						<p class="site-description"><?php echo $pizzeria_del_ponte_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<?php endif; ?>
				</div><!-- .site-branding -->

				<nav id="site-navigation" class="main-navigation col-auto d-flex justify-content-end">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'pizzeria-del-ponte' ); ?></button>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
							'menu_class' 	 => 'align-items-center'
						)
					);
					?>
				</nav><!-- #site-navigation -->
			</div>
		</div>
		
	</header><!-- #masthead -->