<?php
/*
 *
 * Widget : Subscription form
 * WidgetName: Eminds Subscription form 
 */
 
 // Creating the widget 
class eminds_related_post_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'eminds_relatedpostwidget', 

// Widget name will appear in UI
__('Eminds Related Post Section', 'Eminds'), 

// Widget description
array( 'description' => __( 'Display related posts.', 'Eminds' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];

?>
<?php //echo $args['before_title'] . $title . $args['after_title']; ?>

     <?php
     global $wpdb;
	 
	 $postType_sql =$instance['related_type'];
	 $idcurr = get_the_ID();
	  $post_title = get_the_title(get_the_ID());
	  
	  $perpage  = $instance['perpage'];
  /*
   *New Feature :-
   * For legal update check title and match title
   * For company act - check subtitle and match with title.  
   */
   $postType = get_post_type();
    if($postType == "companies_act"){
     $post_title = get_post_meta(get_the_ID(), 'enter_the_subtitle_ca2013', TRUE);	
    }
	
	
	 $sql_related ="SELECT ID,post_type,post_author, post_title,MATCH(post_title) AGAINST ('$post_title') AS Similarity FROM ".$wpdb->prefix."posts WHERE MATCH(post_title) AGAINST('$post_title') GROUP BY post_title HAVING post_type IN($postType_sql) AND ID NOT IN('$idcurr') ORDER BY Similarity DESC Limit 0,$perpage ";
    $arr_related = $wpdb->get_results($sql_related);
?>
 
<?php
    if(count($arr_related)){
	  ?>
<section class="related-articles"> 
        <section class="posts-content">               
 <strong class="main-heading display-b"><?php echo $title; ?></strong>
           
            <ul>           	
    <?php
         foreach ($arr_related as  $value) {
          $postid     = $value->ID;   
          $Similarity = $value->Similarity; //see how many similarty occurs
          $postTitle  = $value->post_title;
		  $authorid   = $value->post_author;
                ?>   
    <li>
    	<a class="related-link" href="<?php echo get_permalink($postid); ?>"><?php echo $postTitle; ?></a>
    	<span class="display-block"><?php echo get_the_date("M d, Y",$postid); ?></span>
    </li>

                <?php } ?>
            	
        </ul>    
        </section>
 </section>    
        <?php } ?>
                   	

<?php echo $args['after_widget'];
}

// Widget Backend
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Related Posts', 'Eminds' );
}
// Widget admin form
$related_type = $instance['related_type'];
$perpage      = $instance['perpage'];
?>
<p>
<label for="<?php echo $this -> get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>

<p>
<label for="<?php echo $this -> get_field_id('related_type'); ?>"><?php _e('Related Post Type:'); ?></label>
 
<select class="widefat" id="<?php echo $this -> get_field_id('related_type'); ?>" name="<?php echo $this -> get_field_name('related_type'); ?>">
	<option value="'post'" <?php echo ($related_type =="post")?"selected='selected'":""; ?>  >Legal Update</option>
	<option value="'companies_act'" <?php echo ($related_type =="companies_act")?"selected='selected'":""; ?> >Company Act 2013</option>
	<option value="'companies_act','post'" <?php echo ($related_type =="'companies_act','post'")?"selected='selected'":""; ?> >Legal Updte & Company Act 2013</option>
</select>	
</p>

<p>
<label for="<?php echo $this -> get_field_id('perpage'); ?>"><?php _e('Show posts:'); ?></label> 
<input class="widefat" id="<?php echo $this -> get_field_id('perpage'); ?>" name="<?php echo $this -> get_field_name('perpage'); ?>" type="text" value="<?php echo esc_attr($perpage); ?>" />
</p>

<?php
}

// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['related_type'] = ( ! empty( $new_instance['related_type'] ) ) ? strip_tags( $new_instance['related_type'] ) : '';
$instance['perpage']      = (!empty($new_instance['perpage']))           ? strip_tags( $new_instance['perpage']) : '10';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function eminds_relatedpostwidget() {
register_widget( 'eminds_related_post_widget' );
}
add_action( 'widgets_init', 'eminds_relatedpostwidget' );
?>