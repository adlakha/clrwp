<?php
/*
 *Recent category posts  
 */
 // Creating the widget 
class eminds_recentcategoryposts_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'eminds_recent_category_postwidget', 

// Widget name will appear in UI
__('Eminds Recent category post', 'Eminds'), 

// Widget description
array( 'description' => __( 'Show the Recent category post.', 'Eminds' ), ) 
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

$taxonomy_name = ( ! empty( $instance['taxonomy_name'] ) ) ? $instance['taxonomy_name']  : 'legal';
$category_slug = ( ! empty( $instance['category_slug'] ) ) ? $instance['category_slug']  : 'articles';
	
// This is where you run the code and display the output
?>
       
       <!-- Post listing START  -->    
       <?php 
       $argslisting = array(
					'post_type' => 'post',
					'posts_per_page'=>"$per_page_list",
					'tax_query' => array(
						array(
							'taxonomy' => "$taxonomy_name",
							'field'    => 'slug',
							'terms'    => "$category_slug",
						),
					),
				);
$query = new WP_Query( $argslisting );

if($query->have_posts()) :
	?>
<section class="side-menu clearfix">

     <?php echo $args['before_title'] . $title . $args['after_title'];  ?>

	<!--
	Design and developed by Shankaranand Maurya	
    -->
	<ul class="wpp-list eminds-recent-category-widget">
	<?php
	$incClass=1;
   while($query->have_posts()) : $query->the_post();
    
    $cls = ($incClass%2==0)?"event":"odd";
    ?>
    <li class="clr-cat-post <?php echo $cls; ?>" >
      <a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a>  	
    </li> 	
    <?php
    ++$incClass;
   endwhile;
   ?>
   </ul>
  </section>
   <?php
endif;
wp_reset_query();
         ?>  
       <!-- Post listing END  -->    
<?php
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Recent Legal updates', 'Eminds' );
}
$per_page_list  = (empty($instance['per_page_list']))?5:$instance['per_page_list'];
//initialize the taxonomy
$taxonomy_name  = (empty($instance['taxonomy_name'])) ?"legal":$instance['taxonomy_name'];
$category_slug  = (empty($instance['category_slug'])) ?"articles" :$instance['category_slug'];
// Widget admin form
?>
<p>
<label for="<?php echo $this -> get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>

<p>
<label for="<?php echo $this -> get_field_id('per_page_list'); ?>"><?php _e('Show posts:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('per_page_list'); ?>" name="<?php echo $this -> get_field_name('per_page_list'); ?>" type="text" value="<?php echo esc_attr($per_page_list); ?>" />
</p>

<p style="display:none;">
<label for="<?php echo $this -> get_field_id('taxonomy_name'); ?>"><?php _e('Enter Taxonomy:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('taxonomy_name'); ?>" name="<?php echo $this -> get_field_name('taxonomy_name'); ?>" type="text" value="<?php echo esc_attr($taxonomy_name); ?>" />
</p>

<p>
<label for="<?php echo $this -> get_field_id('category_slug'); ?>"><?php _e('Category slug'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('category_slug'); ?>" name="<?php echo $this -> get_field_name('category_slug'); ?>" type="text" value="<?php echo esc_attr($category_slug); ?>" />
</p>

<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
	$instance = array();
	
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	$instance['per_page_list'] = ( ! empty( $new_instance['per_page_list'] ) ) ? strip_tags( $new_instance['per_page_list'] ) : '5';
	$instance['taxonomy_name'] = ( ! empty( $new_instance['taxonomy_name'] ) ) ?             $new_instance['taxonomy_name']  : 'legal';
	$instance['category_slug'] = ( ! empty( $new_instance['category_slug'] ) ) ?             $new_instance['category_slug']  : 'articles';
	
	
	return $instance;
	}
	} // Class wpb_widget ends here

	// Register and load the widget
	function eminds_recentcategoryposts() {
	register_widget( 'eminds_recentcategoryposts_widget' );
	}
	add_action( 'widgets_init', 'eminds_recentcategoryposts' );
?>
