<?php
/*
 * Display the upcoming widget 
 */
 // Creating the widget 
class eminds_upcoming_event_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'eminds_upcoming_widget', 

// Widget name will appear in UI
__('Eminds Upcoming Events', 'Eminds'), 

// Widget description
array( 'description' => __( 'Show the Media Partner Event lists.', 'Eminds' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];

//show authors
$per_page_list  = (empty($instance['per_page_list']))?5:$instance['per_page_list'];
	
// This is where you run the code and display the output
?>
<section class="side-menu clearfix">
       <!-- Post listing START  -->    
       <?php 
       	/*
		 * Special condition : if event end date is not set then  : Event will never expire
		 */
       $currdate  = date('Ymd');
	  // $enddate   = get_post_meta($pid,"event_expire_date",TRUE);
	   
	   $eventcategory = clr_of_get_option("event_category_content_type");
	   
	   $args_upcoming = array(
	                      'post_type'    =>  'post',
	                      'posts_per_page'=> $per_page_list,
	                      'meta_key'      => 'event_expire_date',
	                      'meta_compare'  => '>=',
	                      'meta_value'    => date("Ymd"),
	                     'tax_query' => array(
												array(
													'taxonomy' => 'legal',
													'field'    => 'term_id',
													'terms'    => $eventcategory,
												),
											), 
		                 );
	//  echo '<pre>'; print_r($args_upcoming);echo '</pre>';
	   $query11 = new WP_Query($args_upcoming);
	   
?>

<?php
if($query11->have_posts()) :
	?>
	<?php echo $args['before_title'] . $title . $args['after_title'];  ?>
	<!--
	Design and developed by Shankaranand Maurya	
    -->
<ul class="wpp-list eminds-recent-category-widget">	
	<?php
   while($query11->have_posts()) : $query11->the_post();
    ?>
    <li <?php post_class(); ?>>
      <a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a>
      <br/>  	
      <?php
       $enddate = get_post_meta(get_the_ID(),"event_expire_date",TRUE); 
       $startdate= get_post_meta(get_the_ID(),"event_start_date",TRUE);
	   
	   $dateformate = "M d, Y";
       ?>
      <span>(<small><?php echo date($dateformate ,strtotime($startdate)) ." - ". date($dateformate ,strtotime($enddate)); ?> </small>)</span>
      
    </li> 	
    <?php
   endwhile;
     ?>
 </ul>
   <?php
endif;
?>  

<?php
wp_reset_query();
         ?>  
       <!-- Post listing END  -->    
</section>
<?php
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Recent upcoming Events', 'Eminds' );
}
$per_page_list  = (empty($instance['per_page_list']))?5:$instance['per_page_list'];

?>
<p>
<label for="<?php echo $this -> get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>

<p>
<label for="<?php echo $this -> get_field_id('per_page_list'); ?>"><?php _e('Show posts:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('per_page_list'); ?>" name="<?php echo $this -> get_field_name('per_page_list'); ?>" type="text" value="<?php echo esc_attr($per_page_list); ?>" />
</p>

<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
	$instance = array();
	
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	$instance['per_page_list'] = ( ! empty( $new_instance['per_page_list'] ) ) ? strip_tags( $new_instance['per_page_list'] ) : '5';

	return $instance;
	}
	} // Class wpb_widget ends here

	// Register and load the widget
	function eminds_upcomingwidget() {
	register_widget( 'eminds_upcoming_event_widget' );
	}
	add_action( 'widgets_init', 'eminds_upcomingwidget' );
?>