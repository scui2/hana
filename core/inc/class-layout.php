<?php
/**
 * Foundaiton Grid Class
 * 
 * @package	  hanacore
 * @since     1.0
 * @author	  Stephen Cui
 * @copyright Copyright 2016, Stephen Cui
 * @license   GPL v3 or later
 * @link      http://rewindcreation.com/
 */
if ( ! class_exists( 'HANA_Layout' ) ) {
	
	class HANA_Layout {
		public $layouts = array();

		private function __construct() {
			// Core uses the own defaults if theme do not add them in customizer
            $this->core_layouts();
		}

		public function core_layouts() {
            $this->layouts = array(
                'post5' => array(
                    'count' => 5,
                    'class' => array(
                        '1' => 'medium-6 medium-push-3 columns',
                        '2' => 'medium-3 small-6 medium-pull-6 columns',
                        '3' => 'medium-3 small-6 columns',
                        '4' => 'medium-3 small-6 medium-pull-6 columns',
                        '5' => 'medium-3 small-6 columns',
                    ),
                ), 
            );
		}
        
		public function display( $layout, $posts, $template ) {
            global $post;
            $i = 0;
            echo '<div class="row collapse">';

            foreach ( $posts as $order => $post ) {
                $i = $i + 1;
                if ($i > $this->layouts[$layout]['count'] )
                    exit;
                setup_postdata( $post );
                echo '<div class="' . $this->layouts[$layout]['class'][$i] . '">';
                echo '<div id="post-' . esc_attr($post->ID) . '" class="block"><div class="block-inner">';
                get_template_part( 'parts/content', $template );
                echo '</div></div></div>';
            }
            echo '</div>';
            wp_reset_postdata();
        }
		/**
		 * Create the object when called for the 1st time
		 */
		public static function get_instance() {
			static $instance = null;

			if ( is_null( $instance ) )
				$instance = new HANA_Layout;

			return $instance;
		}

	}

	function hana_layout() {
		return HANA_Layout::get_instance();
	}

}