<?php
/*
 * Widget : Advertisement 
 * WidgetName: Eminds Advertisement 
 */
 
 // Creating the widget 
class eminds_advertisement_form_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'eminds_advertisementform', 

// Widget name will appear in UI
__('Eminds Advertisement code', 'Eminds'), 

// Widget description
array( 'description' => __( 'Enter the advertisement code here.', 'Eminds' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];

if(!empty($title)){
echo $args['before_title'] . $title . $args['after_title'];
}

$eminds_advertisement=$instance['eminds_advertisement'];
?>
<div class="ad1">
  <?php echo $eminds_advertisement; ?>  
 </div>
        
<?php
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
// Widget admin form
$eminds_advertisement=$instance['eminds_advertisement'];
?>
<p>
<label for="<?php echo $this -> get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>

<p>
<label for="<?php echo $this -> get_field_id('eminds_advertisement'); ?>"><?php _e('Enter the advertise code:'); ?></label> 
<textarea rows="10" cols="30" class="widefat" id="<?php echo $this -> get_field_id('eminds_advertisement'); ?>" name="<?php echo $this -> get_field_name('eminds_advertisement'); ?>" ><?php echo esc_attr($eminds_advertisement); ?></textarea>
</p>

<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['eminds_advertisement'] = ( ! empty( $new_instance['eminds_advertisement'] ) ) ? $new_instance['eminds_advertisement']  : '';
	
	return $instance;
	}
	} // Class wpb_widget ends here

	// Register and load the widget
	function eminds_advertisement_form() {
	register_widget( 'eminds_advertisement_form_widget' );
	}
	add_action( 'widgets_init', 'eminds_advertisement_form' );
?>