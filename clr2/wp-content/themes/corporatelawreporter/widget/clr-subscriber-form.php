<?php
/*
 *
 * Widget : Subscription form
 * WidgetName: Eminds Subscription form 
 */
 
 // Creating the widget 
class eminds_subscription_form_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'eminds_subscriptionform', 

// Widget name will appear in UI
__('Eminds Subscription form', 'Eminds'), 

// Widget description
array( 'description' => __( 'Display the subscription form', 'Eminds' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];

?>

 	<div class="subscribe">
<?php echo $args['before_title'] . $title . $args['after_title'];  ?>
        <form onClick="target='_blank';" action="http://feedburner.google.com/fb/a/mailverify?uri=corporatelawreporter" method="post" class="searchform" onsubmit="return subcheck();">
         
         <section class="search-input">
										<div class="input-group">
											<input type="text" name="email" id="email" class="subscribe_input form-control" placeholder="Enter your email ID to subscribe">
											<span class="input-group-btn">
												<button name="search" class="btn btn-default subscribebt" type="submit">Subscribe</button> 
											</span>
										</div>
									</section>
		</form>
          
      </div>

<?php
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Subscribe to the Daily Journal', 'Eminds' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this -> get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>
<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

	
	return $instance;
	}
	} // Class wpb_widget ends here

	// Register and load the widget
	function eminds_subscription_form() {
	register_widget( 'eminds_subscription_form_widget' );
	}
	add_action( 'widgets_init', 'eminds_subscription_form' );
?>