<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package gartenpark
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<link rel="shortcut icon" href="<?= get_template_directory_uri();?>/dist/images/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" sizes="57x57" href="<?= get_template_directory_uri();?>/dist/images/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?= get_template_directory_uri();?>/dist/images/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?= get_template_directory_uri();?>/dist/images/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?= get_template_directory_uri();?>/dist/images/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?= get_template_directory_uri();?>/dist/images/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?= get_template_directory_uri();?>/dist/images/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?= get_template_directory_uri();?>/dist/images/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= get_template_directory_uri();?>/dist/images/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?= get_template_directory_uri();?>/dist/images/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= get_template_directory_uri();?>/dist/images/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?= get_template_directory_uri();?>/dist/images/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= get_template_directory_uri();?>/dist/images/favicon/favicon-16x16.png">
	<link rel="manifest" href="<?= get_template_directory_uri();?>/dist/images/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?= get_template_directory_uri();?>/dist/images/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-177072345-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-177072345-1');
	</script>


	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<header class="header">
		<div class="header__cont descktop">
			<?php
				render_menu_inline('primary','header');
			?>
			<div class="header__langBtns">
				<?php
					render_langmenu();
				?>
			</div>
		</div>

		<div class="header__cont mobile">
			<div class="header__line">
				<?php
					if( !is_front_page() ) {
						echo '
						<a href="'. get_home_url() .'" class="header__logo">
							<img src="'. get_field('special_logo', 'options') .'" alt="Gartenpark Korneuburg">
						</a>';
					} else {
						echo '
						<span class="header__logo">
							<img src="'. get_field('special_logo', 'options') .'" alt="Gartenpark Korneuburg">
						</span>';
					}
				?>
				
				<button class="header__burger">
					<span class="line"></span>
					<span class="line"></span>
					<span class="line"></span>
				</button>
			</div>
			<div class="header__line">
				<div class="header__socials">
					<div class="header__socials--hidden">
						<?php
							if( have_rows('social_links', 'options') ) {
								while( have_rows('social_links', 'options') ) {
									the_row();
									echo '<a target="_blank" href="'. get_sub_field('social_link') .'" class="social-link"><img src="'. get_sub_field('social_icon') .'" alt="social link"></a>';
								}
							}
						?>
					</div>
					<button class="header__socials--btn"></button>
				</div>
			</div>
		</div>
	</header>
