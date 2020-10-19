<?php
/**
 * Theme functions
 */
add_action( 'after_setup_theme', 'gartenpark_initMenu' );
function gartenpark_initMenu() {
	register_nav_menu( 'primary', 'Hauptmenü' );
	register_nav_menu( 'footer', 'Fußzeilenmenüs');
	register_nav_menu( 'mobile', 'Mobiles Menü');
}


 /*if( !function_exists('render_langmenu') ) {
     function render_langmenu( array $langs = ['de','en'] ) {
        if( !function_exists('display_menu') ){
			function display_menu( $items, $currentLang ) {
				if( is_array( $items ) ) {
					$output = '<div class="page__langSwitch">';
					foreach ( $items as $item ) {
						$item == $currentLang ? $link = 'javascript:void(0);' : $link = qtranxf_convertURL( "", $item );
                        $item == $currentLang ? $activeClass = 'current' : $activeClass = '';
						$output.= '<a href="'. $link .'" class="page__langSwitch--link '. $activeClass .'">'. $item .'</a>';
					}
					$output.= '</div>';
				} else {
					return;
				}

				echo $output;
			}
		}

        display_menu($langs, qtrans_getLanguage() );
     }
 }*/

if( !function_exists('render_langmenu') ) {
	function render_langmenu( string $cont_class = 'header' ) {
		$languages = icl_get_languages('skip_missing=0&orderby=code&order=desc');
		if(!empty($languages)){
			echo '<div class="'.$cont_class.'__langSwitch">';
			foreach($languages as $l){
				if(!$l['active']) {
					echo '<a href="'.$l['url'].'" class="'.$cont_class.'__langSwitch--link">'. $l['language_code'] .'</a>';
				} else {
					echo '<a href="javascript:void(0);" class="'.$cont_class.'__langSwitch--link current">'. $l['language_code'] .'</a>';
				}
			}
			echo '</div>';
		}
	}
}

 if( !function_exists('render_menu_inline') ) {
    function render_menu_inline( string $menuLocations = '', string $menuPosition = '', string $menuAdditionalClass = '' ) {
        $locations = get_nav_menu_locations();
		if( $locations && $locations[ $menuLocations ] ) {
			$menuLinkArray = wp_get_nav_menu_items( $locations[ $menuLocations ] );

			switch( $menuPosition ) {
				case 'header':
					$menuClass = 'header__nav';
				break;

				case 'footer':
					$menuClass = 'footer__nav';
				break;

				default:
					$menuClass = $menuAdditionalClass;
				break;
			}

			$outputMarkup = '<nav class="'. $menuClass .'">';
			
			foreach( (array) $menuLinkArray as $key => $menuItem ) {
				$current_from_id = ( $menuItem->object_id == get_queried_object_id() ) ? 'current' : '';
				$current_from_url = ( $_SERVER['REQUEST_URI'] == parse_url( $menuItem->url, PHP_URL_PATH ) ) ? 'current' : '';
				$menuItemClasses = join(' ',$menuItem->classes);

				if( get_field( 'has_child' , $menuItem->object_id) ) {
					$outputMarkup .= '<div class="'. $menuClass .'--link '. $current_from_id .' '. $current_from_url . $menuItemClasses .' hasDropdownMenu">';
					if(have_rows('child_items', $menuItem->object_id)) {
						$outputMarkup .= '<a href="'. get_home_url() .'" class="menuLabel">'. $menuItem->title .'</a>';
						
						$outputMarkup .= '<div class="menuDropdown">';
						while(have_rows('child_items', $menuItem->object_id)) {
							the_row();
							if( get_sub_field('active_item') ) {
								$outputMarkup .= '<a href="'. get_sub_field('link') .'" class="link basic">'. get_sub_field('item_name') .'</a>';
							} else {
								$outputMarkup .= '<span class="link disabled">'. get_sub_field('item_name') .'</span>';
							}
						}
						$outputMarkup .= '</div>';
					}
					$outputMarkup .= '</div>';
				} else {
					$outputMarkup .= '<a class="'. $menuClass .'--link '. $current_from_id .' '. $current_from_url . $menuItemClasses .'" href="'. $menuItem->url .'">'. $menuItem->title .'</a>';
				}
				
			}

			$outputMarkup .= '</nav>';
			echo $outputMarkup;

		} else {	
			 return false;
		}
    }
 }