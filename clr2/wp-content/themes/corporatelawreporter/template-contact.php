<?php
/*
 * Template Name:Contact
 *  */
get_header();
?>

<!-- end header -->
<section class="container-fluid middle-container">
    <section class="row position-rel">
        <section class="col-sm-8">
            <section class="posts-content">
                <!-- start post -->
                <section class="post-column clearfix">
                    
                    <strong class="main-heading display-b">
                    	<?php the_title(); ?>
                    	  <?php
					  /*
                       *Post sharing in right direction
                       */
                       get_template_part('post','sharing-right');
						?>
                    </strong>
                  
                    <?php 
                    if(have_posts()):
                        while (have_posts()):the_post();
                    $imgHTML=eminds_get_thumbnail_html_with_customsize(get_the_ID(),'full',"thumbnailimage");
                    if(!empty($imgHTML)){
                    ?>
                     <section class="full-view-advertise fl">
                          <?php echo $imgHTML; ?>
                     </section>
                    <?php } ?>
                    
                    <?php 
                    /*
					 * Remove the map  
					 */
					 if(!get_post_meta(get_the_ID(),"hide_the_map",TRUE)){
                    ?>
                    
                    <div id="googleMap" style="width:830px;height:300px;"></div>
                    <br/>
                    <?php } ?>
                    
                   <?php the_content(); ?>   
                   
                   <!-- 
                   	Google map api code
                   	-->
                   	<?php 
                   	$addr = get_post_meta(get_the_ID(),"enter_the_address_contact",TRUE);
					$lat  = get_post_meta(get_the_ID(),"enter_the_latitude",TRUE);
					$long = get_post_meta(get_the_ID(),"enter_the_longitude",TRUE);
                   	//set default values
                   	if(empty($addr)){
                   	$addr =	"<b>Corporate Law Reporter</b>,<br/>Unit-544,Spaze itech park,Sohan Road,<br/>Gurgaon India 122001";
                   	}
					if(empty($lat)){
                   	$lat  =	"28.45956362";
                   	}
				    if(empty($long)){
                   	$long = "77.03977112";	
                   	}
                   	?>
                   	
                   	<script>
						var myCenter=new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $long; ?>);
						
						function initialize()
						{
						var mapProp = {
						  center:myCenter,
						  zoom:10,
						  mapTypeId:google.maps.MapTypeId.ROADMAP
						  };
						
						var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
						
						var marker=new google.maps.Marker({
						  position:myCenter,
				 		  });
						
						marker.setMap(map);
						
						var infowindow = new google.maps.InfoWindow({
						  content:"<?php echo $addr; ?>"
						  });
						
						infowindow.open(map,marker);
						}
						
						google.maps.event.addDomListener(window, 'load', initialize);
						</script>

                   	<!-- Google map api code -->
                   
                  <?php 
                    endwhile;
                  endif;
                  ?>
                </section>
                <!-- end post -->
            </section>
        </section>
        <?php
        //get  the sidebar
        get_sidebar();
        ?>
    </section>
</section>

<!-- start footer -->
<?php
get_footer();
?>