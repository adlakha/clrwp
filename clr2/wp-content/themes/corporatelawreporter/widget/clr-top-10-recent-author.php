<?php
/*
 *
 * Widget : Top 10 Recent Author
 * WidgetName: Eminds Recent Author 
 */
 
 // Creating the widget 
class eminds_top_10author_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'eminds_top_10_author1:', 

// Widget name will appear in UI
__('Eminds Latest Author', 'Eminds'), 

// Widget description
array( 'description' => __( 'Show the Recent author list.', 'Eminds' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];

//show authors
$show_authors  = (empty($instance['show_authors']))?10:$instance['show_authors'];
// This is where you run the code and display the output
?>
<section class="contributors-list clearfix">
     <?php echo $args['before_title'] . $title . $args['after_title'];  ?>
         <?php
		 global $wpdb;
		  $sql_last_author ="SELECT DISTINCT post_author FROM `".$wpdb->prefix."posts` WHERE post_status='publish' ORDER BY ID DESC LIMIT 0,$show_authors ";
         $authors = $wpdb->get_results($sql_last_author);
		 // echo '<pre>';
		 // print_r($authors);
		 // echo '</pre>';
     if(is_array($authors)){
     	?>
     <ul class="top-contributer clearfix">	
     	<?php
       foreach($authors as $author) {
	      $authorid = $author->post_author;
		   
		   
		       /*
				 *Special feature
				 * Profile image pickup from linkedin : So at least one time,you need to login via linkedin profile 
				 */
				$profile_image = eminds_get_user_image('linkedin_profile_image',$authorid);
				$linkedin_link = eminds_get_user_image('linkedin_profile_url',$authorid);
			    $flag_profile  = get_user_meta($authorid, 'exclude_linkedin_image', TRUE);
			         	
			    
			    $authorlink    = get_author_posts_url($authorid);
			    $attr_target   ="";
			    		
				//check the flag :Need linkedin profile or uploaded profile.
				if($flag_profile){
				$profile_image = eminds_get_user_image('upload_profile_image',$authorid);
				
				}else{
					
					if(!empty($linkedin_link)){
					  //$attr_target   ="target='_blank'";
					  //$authorlink    = $linkedin_link;
					  //I have remove the linkedin link .
			   $authorlink    = get_author_posts_url($authorid);	
					}
					
				}
			    
			
			    if (empty($profile_image)) {
			        $profile_image = get_stylesheet_directory_uri() . "/images/default-author.jpeg";
			    }
		   
		   
		   
		 ?>
         <li><a <?php echo $attr_target; ?> href="<?php echo $authorlink; ?>">
         <span class="contributors-pic fl">
         	
		  <img src="<?php echo $profile_image; ?>" height="50" width="50" alt="profile image" />
         </span>
         <span class="contributors-name display-b"><?php echo the_author_meta('display_name',$authorid);?> 
		<span class="contributors-organisation display-b"><?php echo the_author_meta('organization',$authorid);?></span>
		 </span>	
            </a>
           </li>
         <?php
         
	        }
	    ?>
	    </ul>
	    <?php
          }
         
         ?>
       
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
$title = __( 'Top Contributors', 'Eminds' );
}
$show_authors  = (empty($instance['show_authors']))?10:$instance['show_authors'];
// Widget admin form
?>
<p>
<label for="<?php echo $this -> get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>

<p>
<label for="<?php echo $this -> get_field_id('show_authors'); ?>"><?php _e('Show Authors:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('show_authors'); ?>" name="<?php echo $this -> get_field_name('show_authors'); ?>" type="text" value="<?php echo esc_attr($show_authors); ?>" />
</p>
<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	$instance['show_authors'] = ( ! empty( $new_instance['show_authors'] ) ) ? strip_tags( $new_instance['show_authors'] ) : '10';
	
	return $instance;
	}
	} // Class wpb_widget ends here

	// Register and load the widget
	function eminds_top_10author() {
	register_widget( 'eminds_top_10author_widget' );
	}
	add_action( 'widgets_init', 'eminds_top_10author' );
?>
