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
        
 		public function __construct( $_blocks ) {
            $this->blocks = $_blocks;
            $this->num_of_blocks = count( $_blocks );
        }      
    }
 }

if ( ! class_exists( 'HANA_Layout' ) ) {
    
	class HANA_Layout {
		public $layouts = array();
        public $default_block = 'block';

		public function __construct() {
			// Core uses the own defaults if theme do not add them in customizer
            $this->core_layouts();
		}

		public function core_layouts() {
            $this->layouts['block-1'] = new Hana_Layout_Set( //default layout
                    array(
                    '1' => array( 'column' => 'medium-12 columns' ),
                    ) );
            $this->layouts['block-2'] = new Hana_Layout_Set(
                    array(
                    '1' => array( 'column' => 'small-6 columns' ),
                    '2' => array( 'column' => 'small-6 columns' ),
                    ) );
            $this->layouts['block-3'] = new Hana_Layout_Set( 
                    array(
                    '1' => array( 'column' => 'medium-8 columns' ),
                    '2' => array( 'column' => 'medium-4 small-6 columns' ),
                    '3' => array( 'column' => 'medium-4 small-6 columns' ),
                    ) );
            $this->layouts['block-4'] = new Hana_Layout_Set( 
                    array(
                    '1' => array( 'column' => 'medium-8 columns' ),
                    '2' => array( 'column' => 'small-4 columns', 'block' => 'block block-44 image-center' ),
                    '3' => array( 'column' => 'small-4 columns', 'block' => 'block block-44 image-center' ),
                    '4' => array( 'column' => 'small-4 columns', 'block' => 'block block-44 image-center' ),
                    ) );
            $this->layouts['block-5'] = new Hana_Layout_Set( 
                    array(
                    '1' => array( 'column' => 'medium-6 medium-push-3 columns' ),
                    '2' => array( 'column' => 'medium-3 small-6 medium-pull-6 columns' ),
                    '3' => array( 'column' => 'medium-3 small-6 columns' ),
                    '4' => array( 'column' => 'medium-3 small-6 medium-pull-6 columns' ),
                    '5' => array( 'column' => 'medium-3 small-6 columns' ),
                    ) );
            $this->layouts['block-6'] = new Hana_Layout_Set( 
                    array(
                    '1' => array( 'column' => 'medium-6 columns' ),
                    '2' => array( 'column' => 'medium-6 columns' ),
                    '3' => array( 'column' => 'medium-3 small-6 columns' ),
                    '4' => array( 'column' => 'medium-3 small-6 columns' ),
                    '5' => array( 'column' => 'medium-3 small-6 columns' ),
                    '6' => array( 'column' => 'medium-3 small-6 columns' ),
                    ) );
            $this->layouts['block-7'] = new Hana_Layout_Set( 
                    array(
                    '1' => array( 'column' => 'medium-4 columns' ),
                    '2' => array( 'column' => 'medium-4 small-4 columns' ),
                    '3' => array( 'column' => 'medium-4 small-4 columns' ),
                    '4' => array( 'column' => 'medium-3 small-4 columns' ),
                    '5' => array( 'column' => 'medium-3 small-4 columns' ),
                    '6' => array( 'column' => 'medium-3 small-4 columns' ),
                    '7' => array( 'column' => 'medium-3 small-4 columns' ),
                    ) );
            $this->layouts['block-8'] = new Hana_Layout_Set( 
                    array(
                    '1' => array( 'column' => 'medium-6 columns' ),
                    '2' => array( 'column' => 'medium-6 small-4 columns' ),
                    '3' => array( 'column' => 'medium-2 small-4 columns' ),
                    '4' => array( 'column' => 'medium-2 small-4 columns' ),
                    '5' => array( 'column' => 'medium-2 small-4 columns' ),
                    '6' => array( 'column' => 'medium-2 small-4 columns' ),
                    '7' => array( 'column' => 'medium-2 small-4 columns' ),
                    '8' => array( 'column' => 'medium-2 small-4 columns' ),
                    ) );
            $this->layouts['block-9'] = new Hana_Layout_Set( 
                    array(
                    '1' => array( 'column' => 'medium-6 medium-push-3 small-6 columns' ),
                    '2' => array( 'column' => 'medium-3 small-6 medium-pull-6 columns' ),
                    '3' => array( 'column' => 'medium-3 small-4 columns' ),
                    '4' => array( 'column' => 'medium-3 small-4 medium-pull-6 columns' ),
                    '5' => array( 'column' => 'medium-3 small-4 columns' ),
                    '6' => array( 'column' => 'medium-3 small-3 columns' ),
                    '7' => array( 'column' => 'medium-3 small-3 columns' ),
                    '8' => array( 'column' => 'medium-3 small-3 columns' ),
                    '9' => array( 'column' => 'medium-3 small-3 columns' ),
                    ) );
            $this->layouts['block-10'] = new Hana_Layout_Set( 
                    array(
                    '1' => array( 'column' => 'medium-6 small-6 columns' ),
                    '2' => array( 'column' => 'medium-3 small-6 columns' ),
                    '3' => array( 'column' => 'medium-3 small-3 columns' ),
                    '4' => array( 'column' => 'medium-3 small-3 columns' ),
                    '5' => array( 'column' => 'medium-3 small-3 columns' ),
                    '6' => array( 'column' => 'medium-6 medium-push-6 small-3 columns' ),
                    '7' => array( 'column' => 'medium-3 medium-pull-6 small-3 columns' ),
                    '8' => array( 'column' => 'medium-3 medium-pull-6 small-3 columns' ),
                    '9' => array( 'column' => 'medium-3 medium-pull-6 small-3 columns' ),
                   '10' => array( 'column' => 'medium-3 medium-pull-6 small-3 columns' ),
                    ) );
            $this->layouts['portfolio-2'] = new Hana_Layout_Set( 
                    array(
                    '1' => array( 'column' => 'small-6 columns', 'block' => 'block block-portfolio' ),
                    ) );
            $this->layouts['portfolio-3'] = new Hana_Layout_Set( 
                    array(
                    '1' => array( 'column' => 'medium-4 small-6 columns', 'block' => 'block block-portfolio' ),
                    ) );
            $this->layouts['portfolio-4'] = new Hana_Layout_Set( 
                    array(
                    '1' => array( 'column' => 'medium-3 small-4 columns', 'block' => 'block block-portfolio' ),
                    ) );
            $this->layouts['portfolio-6'] = new Hana_Layout_Set( 
                    array(
                    '1' => array( 'column' => 'large-2 medium-3 small-4 columns', 'block' => 'block block-portfolio' ),
                    ) );
        }
        
		public function display( $key, $posts, $template ) {
            global $post;
            
            if ( empty( $template ) )
                return;
            if ( ! isset( $this->layouts[$key] ) )
                $layout = $this->layouts['block-1'];
            else
                $layout = $this->layouts[$key];
            
            $i = 0;
            foreach ( $posts as $order => $post ) {
                $i = $i + 1;
                setup_postdata( $post );
                
                $num = ( ( $i - 1 ) % $layout->num_of_blocks ) + 1;
                if ( isset( $layout->blocks[ $num ] ) ) {
                    $block = $layout->blocks[ $num ] ;  
                    
                    if ( isset( $block['block'] ) )
                        $block_class = $block['block'];
                    else
                        $block_class = $this->default_block; ?>
                    <div id="block-<?php the_ID(); ?>" class="<?php echo hana_kses()->sanitize_html_classes( $block['column'] ); ?>">
                        <div class="<?php echo hana_kses()->sanitize_html_classes( $block_class ); ?>">
                            <div class="block-inner">
                                <?php get_template_part( $template ); ?>
                            </div>
                        </div>
                    </div>
<?php
                }
                
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