<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MetkasPostach
 */

?>
		<footer class="footer">
			<div class="footer__cont">
				<div class="footer__logo">
					<?php
						$home_link = is_front_page() ? 'javascript:void(0);' : get_home_url();
					?>
					<a href="<?= $home_link; ?>" class="footer__logo--image">
						<img src="<?= get_field('special_logo', 'options') ;?>" alt="Gartenpark Korneuburg">
					</a>
				</div>

				<div class="footer_mobile_cont">
					<div class="footer__menu_mobile">
						<?php 
							render_menu_inline('footer', 'footer');
						?>
					</div>
					<div class="footer__socials_mobile">
						<?php
							while( have_rows('social_links', 'options') ) {
								the_row();
								echo '<a target="_blank" href="'. get_sub_field('social_link') .'" class="social-link"><img src="'. get_sub_field('social_icon') .'" alt="social link"></a>';
							}
						?>
					</div>
				</div>
				
				<div class="footer__socials">
                	<?php
						while( have_rows('social_links', 'options') ) {
							the_row();
							echo '<a target="_blank" href="'. get_sub_field('social_link') .'" class="social-link"><img src="'. get_sub_field('social_icon') .'" alt="social link"></a>';
						}
					?>
				</div>
				<div class="footer__menu">
					<?php 
						render_menu_inline('footer', 'footer');
					?>
				</div>
			</div>
		</footer>

		<div class="mobileMenu">
			<div class="mobileMenu__line close-line">
					<?php
						$home_link = is_front_page() ? 'javascript:void(0);' : get_home_url();
					?>
					<a href="<?= $home_link; ?>" class="mobileMenu__logo--image">
						<img src="<?= get_field('special_logo', 'options') ;?>" alt="Gartenpark Korneuburg">
					</a>
				<button class="mobileMenu__close">
					<span class="line"></span>
					<span class="line"></span>
				</button>
			</div>

			<div class="mobileMenu__list">
				<?php
					render_langmenu('mobileMenu');
				?>

				<?php
					render_menu_inline('primary','','mobileMenu__nav');
				?>
				
			</div>
		</div>

		<?php wp_footer(); ?>
		
		<?php
			if( !$_COOKIE['cookieBanner'] == 'yes' ) {
		?>

		<div class="cookieBanner">
            Diese Website verwendet Cookies. Durch die Nutzung der Website stimmen Sie der Verwendung von Cookies zu. <a href="<?= get_home_url() ?>/datenschutz/">Datenschutzinformationen</a> <button class="acceptCookie">Schließen</button>
		</div>
		<?php
			}
		?>
	</body>
</html>
