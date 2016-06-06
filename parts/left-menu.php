<?php
/**
 * The template part to display off canvas menu
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
	if ( has_nav_menu( 'section' ) ) { ?>
	 	<div class="off-canvas position-left" id="offCanvasLeft" data-off-canvas>
    		<button class="close-button" aria-label="Close menu" type="button" data-close><span aria-hidden="true">&times;</span></button>
			<nav class="leftmenu">
				<?php wp_nav_menu( array( 'theme_location'  => 'section', 'menu_class' => '', 'container' => false, )); ?>
			</nav>
		</div>
<?php
	} ?>
