<?php
/*
 *
 * Widget :About clr
 * WidgetName: Eminds About clr  
 */
 
 // Creating the widget 
class eminds_aboutclr_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'eminds_aboutclr', 

// Widget name will appear in UI
__('Eminds About CLR', 'Eminds'), 

// Widget description
array( 'description' => __( 'Display About CLR Text', 'Eminds' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];

?>

 	
<?php echo $args['before_title'] . $title . $args['after_title']; ?>
      <?php //all the values
	$content_here  = $instance['content_here'];
	
	//footer logo 
	 $logoURL_footer = clr_of_get_option("footer_logo");
				if (empty($logoURL_footer)) {
					$logoURL_footer = get_stylesheet_directory_uri() . "/images/logo-clr.png";
				}  
                ?>	
                <a href="<?php echo get_bloginfo('url'); ?>" title="CLR" class="clr-logo">
                    <img src="<?php echo $logoURL_footer; ?>" alt="footer logo" width="75" height="57" />
                </a>
                <?php
	$below_content = $instance['below_content'];
       ?>
         
       				<p>
<?php echo $content_here; ?>	
<span class="display-b"><?php echo $below_content; ?></span>
			</p>
								 

<?php echo $args['after_widget'];
	}

	// Widget Backend
	public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
	$title = $instance[ 'title' ];
	}
	else {
	$title = __( 'About CLR', 'Eminds' );
	}
	// Widget admin form
?>
<p>
<label for="<?php echo $this -> get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>

<!-- About clr -->
<p>
<label for="<?php echo $this -> get_field_id('content_here'); ?>"><?php _e('Content:'); ?></label> 
<textarea rows="10" cols="25"  id="<?php echo $this -> get_field_id('content_here'); ?>" name="<?php echo $this -> get_field_name('content_here'); ?>"><?php echo esc_attr($instance['content_here']); ?></textarea>
</p>

<p>
<label for="<?php echo $this -> get_field_id('below_content'); ?>"><?php _e('Below Content:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('below_content'); ?>" name="<?php echo $this -> get_field_name('below_content'); ?>" type="text" value="<?php echo esc_attr($instance['below_content']); ?>" />
</p>

<?php
}

// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title']   = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['content_here'] = ( ! empty( $new_instance['content_here'] ) ) ? $new_instance['content_here'] : '';
$instance['below_content'] = ( ! empty( $new_instance['below_content'] ) ) ? $new_instance['below_content'] : '';

return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function eminds_aboutclr() {
register_widget( 'eminds_aboutclr_widget' );
}
add_action( 'widgets_init', 'eminds_aboutclr' );
?>