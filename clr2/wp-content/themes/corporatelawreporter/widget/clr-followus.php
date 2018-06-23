	<?php
/*
 *
 * Widget :Follow us
 * WidgetName: Eminds follow us link 
 */
 
 // Creating the widget 
class eminds_followus_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'eminds_followus', 

// Widget name will appear in UI
__('Eminds Follow us', 'Eminds'), 

// Widget description
array( 'description' => __( 'Display the social link', 'Eminds' ), ) 
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
	$tt_link = $instance['tt_link'];
	$fb_link = $instance['fb_link'];
	$rss_link = $instance['rss_link'];
	$gp_link = $instance['gp_link'];
	$li_link = $instance['li_link'];
       ?>  
        <section class="follow-us fl clearfix">
									<ul>
										<li class=""></li>
								  <?php if(!empty($fb_link)){ ?>
									<li class="fb margin-none"><a target="_blank" href="<?php echo $fb_link; ?>"></a></li>
									<?php }if(!empty($tt_link)){ ?>
									<li class="twitter"><a target="_blank" href="<?php echo $tt_link; ?>"></a></li>
									<?php }if(!empty($rrs_link)){ ?>
									<li class="rss"><a target="_blank" href="<?php echo $rrs_link; ?>"></a></li>
									<?php }if(!empty($gp_link)){ ?>
									<li class="google"><a target="_blank" href="<?php echo $gp_link; ?>"></a></li>
									<?php }if(!empty($li_link)){ ?>
									<li class="linkedin"><a target="_blank" href="<?php echo $li_link; ?>"></a></li>
									<?php }?>
									</ul>
								</section>
        
     

<?php echo $args['after_widget'];
	}

	// Widget Backend
	public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
	$title = $instance[ 'title' ];
	}
	else {
	$title = __( 'Follow us', 'Eminds' );
	}
	// Widget admin form
?>
<p>
<label for="<?php echo $this -> get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>

<!-- Social links -->
<p>
<label for="<?php echo $this -> get_field_id('tt_link'); ?>"><?php _e('Twitter Link:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('tt_link'); ?>" name="<?php echo $this -> get_field_name('tt_link'); ?>" type="text" value="<?php echo esc_attr($instance['tt_link']); ?>" />
</p>

<p>
<label for="<?php echo $this -> get_field_id('fb_link'); ?>"><?php _e('Facebook Link:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('fb_link'); ?>" name="<?php echo $this -> get_field_name('fb_link'); ?>" type="text" value="<?php echo esc_attr($instance['fb_link']); ?>" />
</p>
<p>
<label for="<?php echo $this -> get_field_id('rss_link'); ?>"><?php _e('RSS Link:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('rss_link'); ?>" name="<?php echo $this -> get_field_name('rss_link'); ?>" type="text" value="<?php echo esc_attr($instance['rss_link']); ?>" />
</p>

<p>
<label for="<?php echo $this -> get_field_id('gp_link'); ?>"><?php _e('G+ Link:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('gp_link'); ?>" name="<?php echo $this -> get_field_name('gp_link'); ?>" type="text" value="<?php echo esc_attr($instance['gp_link']); ?>" />
</p>
<p>
<label for="<?php echo $this -> get_field_id('li_link'); ?>"><?php _e('Linkedin Link:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('li_link'); ?>" name="<?php echo $this -> get_field_name('li_link'); ?>" type="text" value="<?php echo esc_attr($instance['li_link']); ?>" />
</p>


<?php
}

// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title']   = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['tt_link'] = ( ! empty( $new_instance['tt_link'] ) ) ? $new_instance['tt_link'] : '';
$instance['fb_link'] = ( ! empty( $new_instance['fb_link'] ) ) ? $new_instance['fb_link'] : '';
$instance['rss_link']= ( ! empty( $new_instance['rss_link'] ) ) ? $new_instance['rss_link'] : '';
$instance['gp_link'] = ( ! empty( $new_instance['gp_link'] ) ) ? $new_instance['gp_link'] : '';
$instance['li_link'] = ( ! empty( $new_instance['li_link'] ) ) ? $new_instance['li_link'] : '';

return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function eminds_followus() {
register_widget( 'eminds_followus_widget' );
}
add_action( 'widgets_init', 'eminds_followus' );
?>