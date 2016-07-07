<?php
/**
 * Footer Widget Areas
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */

	$num = absint( apply_filters('hana_homewidget_number', 4) );
	$col = 0;
	$section = 0;
	for ( $i = 1; $i <= $num; $i++ ) {
		$width = absint( get_theme_mod( 'home_width_' . $i, 12) );
		$column = absint( get_theme_mod( 'home_column_' . $i, 3) );
		$id = 'home-' . $i;
		if ( $width > 0 && is_active_sidebar( $id ) ) { //Has widgets
			if ( 0 == $col ) { //New section
				$section = $section + 1; ?>
	<div class="row column"><hr class="section-divider"></div>
	<section id="home-section-<?php echo esc_attr($i); ?>" class="home-section home-section-<?php echo ($i % 2 == 0) ? 'odd' : 'even'; ?>" role="complementary">
		<div class="row">
			
<?php		} ?>
			<div id="<?php echo esc_attr($id); ?>" class="<?php hana_grid()->column_class( $width, $width); ?>">
<?php		$title = get_theme_mod( 'home_title_' . $i );
			$subtilte = get_theme_mod( 'home_subtitle_' . $i );
			if ( !empty( $title) || !empty( $subtilte) ) { ?>
				<div class="widget-area-title">
<?php			if ( !empty( $title) ) { ?>
					<h2><?php echo esc_html($title); ?></h2>
<?php			}
				if ( !empty( $subtilte) ) { ?>
					<h4 class="subheader"><?php echo esc_html($subtilte); ?></h4>
<?php			} ?>	
				</div>				
<?php		}
			if ( $column > 1 ) {
				if (12 == $width) { ?>
					<div class="row" data-equalizer data-equalize-on="medium">					
<?php			} else { ?>
					<div class="row">						
<?php			}
			}
			dynamic_sidebar( $id );
			if ( $column > 1 ) { ?>
					</div>
<?php		} ?>			
			</div>
<?php		$col = $col + $width;
			if ($col >= 12 ) { //End of section
				$col = 0; ?>
		</div>
	</section>
<?php
			}	
		}
	}

