<?php
/**
 * Hana Block Layout
 * 
 * @package	  hanacore
 * @since     1.0
 * @author	  Stephen Cui
 * @copyright Copyright 2016, Stephen Cui
 * @license   GPL v3 or later
 * @link      http://rewindcreation.com/
 */

 if ( ! class_exists( 'Hana_Layout_Set' ) ) {   
     
	class Hana_Layout_Set {
        public $num_of_blocks = 0;
        public $blocks = array();
        public $default_block = 'block';
        
 		public function __construct( $_blocks ) {
            $this->blocks = $_blocks;
            $this->num_of_blocks = count( $_blocks );
        }
        
 		public function display( $count, $template = '') {
            $num = ( ( $count - 1 ) % $this->num_of_blocks ) + 1;
            if ( isset( $this->blocks[ $num ] ) )
                $block = $this->blocks[ $num ] ;
            else
                return false;
                   
            if ( isset( $block['inner'] ) )
                $block_class = $block['inner'];
            else
                $block_class = $this->default_block; ?>
            <div class="<?php echo esc_attr( $block['column'] ); ?>">
                <div class="<?php echo esc_attr( $block_class ); ?>">
                    <div class="block-inner">
<?php                   if ( '' != locate_template( $template . '.php' ) )
                            get_template_part( $template );
                        elseif ( file_exists( $template ) )
                            require( $template ); ?>
                    </div>
                </div>
            </div>
<?php       return true;
        }         
    }
 }

if ( ! class_exists( 'HANA_Layout' ) ) {
    
	class HANA_Layout {
		public $layouts = array();

		public function __construct() {
			// Core uses the own defaults if theme do not add them in customizer
            $this->core_layouts();
		}

		public function core_layouts() {
            $this->layouts['block-5'] = new Hana_Layout_Set( 
                    array(
                    '1' => array( 'column' => 'medium-6 medium-push-3 columns' ),
                    '2' => array( 'column' => 'medium-3 small-6 medium-pull-6 columns' ),
                    '3' => array( 'column' => 'medium-3 small-6 columns' ),
                    '4' => array( 'column' => 'medium-3 small-6 medium-pull-6 columns' ),
                    '5' => array( 'column' => 'medium-3 small-6 columns' ),
                    ) );
        }
        
		public function display( $layout, $posts, $template ) {
            global $post;
            
            if ( empty( $template ) )
                return;
            if ( ! isset( $this->layouts[$layout] ) )
                return;
            $i = 0;
            foreach ( $posts as $order => $post ) {
                $i = $i + 1;
                setup_postdata( $post );
                $this->layouts[$layout]->display( $i, $template );
            }
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