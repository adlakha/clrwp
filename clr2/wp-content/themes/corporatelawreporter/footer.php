<?php /*
 * Call the footer tempalte file
 */
?>
<footer class="footer">
    <section class="container-fluid">
        <section class="row">

            <section class="col-sm-6">
                
                <?php
				if (is_active_sidebar('footer_widget_1')) {
					dynamic_sidebar('footer_widget_1');
				}
                ?>
            </section>

            <section class="col-sm-5 col-sm-offset-1">
                <section class="footer-nav footer-nav-widget">

                    <?php
					if (is_active_sidebar('footer_widget_2')) {
						dynamic_sidebar('footer_widget_2');
					}
                    ?>
                </section>
            </section>
        </section>
    </section>
    <section class="footer-middle">
        <section class="container-fluid">
            <section class="row">

                <?php
				if (is_active_sidebar('footer_widget_3')) {
					dynamic_sidebar('footer_widget_3');
				}
                ?>

                <?php //footer widget : subscription form
				if (is_active_sidebar('footer_widget_4')) {
					dynamic_sidebar('footer_widget_4');
				}
                ?>	

            </section>
        </section>
    </section>
    <section class="container-fluid">
        <section class="row">
            <section class="col-sm-12">
                <section class="footer-bottom">
                    <p class="margin-none">
                        <?php echo clr_of_get_option('copyrigt_text'); ?>
                    </p>
                </section>
            </section>
        </section>
    </section>
</footer>
<!-- end footer -->
<!-- </div> -->
<!-- outer div : it will open in header -->
</div>
  <!--  **********************************Follow author popup email **************************************************************************** -->
  <!-- Modal -->
  <!-- 
  	//Functionality to show the loggedin user information.
  	-->
  <?php 
  global $current_user;
    get_currentuserinfo();
    $authorid = $current_user->ID;
    $uemail = $current_user->user_email;
    $displayName = $current_user->display_name;
  //when form have been submit
    if(isset($_POST['author_email'])){
    	
		$from_name = $_POST['from_name'];
		$from_email= $_POST['from_email'];
		$from_msg  = $_POST['from_message'];
		
		$to_email  = get_option("admin_email");
    	
		//Step-1 :read the template
		$template_msg = eminds_read_emailtemplatefile("author-email.html");
		
		//Step-2 : Get actual message which is send in email.
		
		$searcharr = array('[authorname]','[name]','[email]','[message]');
		$replacearr= array($to_email,$from_name,$from_email,$from_msg);
		
	    $messge   = eminds_search_replace_with_value($searcharr,$replacearr,$template_msg);
		
		//Step-3 : Send email : END
		eminds_send_email1($to_email,$from_email,$messge,$from_name);
    }
	
	    $displayName = get_the_author_meta('display_name');
	
	/*
	 *Get the author email id : Because we need to send an email. 
	 */	
   $uemail_autohr ="";	 
   if(is_single()){
   		
   	 $uemail_autohr   = get_the_author_meta('user_email');
   	
   }else if(is_page_template('template_author.php')){
   	$uemail_autohr   = $uemail;
   }else{
   	    $authorarr_author = @get_user_by( 'slug', get_query_var( 'author_name' ) );
		if($authorarr_author){
	    $uemail_autohr   = @$authorarr_author->user_email;//get_the_author_meta('user_email');
		}
	}		
  
		
  ?>	
  <div class="modal fade" id="send-authoremail" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        	<form class="form-horizontal" role="form" method="post" action="">
        		<input type="hidden" class="authorname" name="authorname" value="<?php echo $uemail_autohr; ?>">
        		<input type="hidden" name="author_email" value="1">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <input type="text" required="required"  class="fname form-control" id="name" name="from_name" placeholder="First & Last Name" value="<?php echo $displayName; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="email" required="required"  class="emailid form-control" id="email" name="from_email" placeholder="example@domain.com" value="<?php echo $uemail; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="message" class="col-sm-2 control-label">Message</label>
        <div class="col-sm-10">
            <textarea required="required"  class="msg form-control" rows="4" name="from_message"></textarea>
        </div>
    </div>
     
    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
        	<a href="javascript:void(0);" class="fr btn btn-default" data-dismiss="modal">Close</a>
            <input id="submit1" name="submit" type="button"  value="Send" class="wpauthor-msg btn btn-primary">
            <em class="loader-text">Loading ...</em>
        </div>
    </div>
    
</form>	
        </div>
      </div>
     </div>
  </div> 	
  <!--  **********************************Follow author email end************************************************************************* -->



<?php wp_footer(); ?>
<script>
    	jQuery(document).ready(function($) {
    	
    //******************** checkout 
 //************ Email us :Follow author ***********
 /*
  * Functionality :
  * 1: If user logged in then it will allow to user for sending an email.
  * 2: If it is not loggedin then it will go on login page.
  */
 $(".emailus-author").click(function(){
 <?php
 if(is_user_logged_in()){
 	?>
 	 //temporary block;
 	 $('#send-authoremail').modal({
	        show: 'false'
	    }); 
 	
 	<?php	
 }else{
 $pid  = clr_of_get_option("submit_article_page");	
 ?>
 	if(confirm('You need to login befor sending an email')){
 window.location="<?php echo get_permalink($pid); ?>
	";
	}

 <?php } ?>
		});
 //************ Email us :Follow author ***********
 
		});
</script>

<script>
jQuery(document).ready(function($){
   $("#wpsinglepostcontent a").addClass("jumper");
   
   $("#wpsinglepostcontent a").each(function(){
   	var id_a = $(this).attr("name");
   	           $(this).attr("id",id_a);
   	           $(this).removeAttr("name");
   });
 //website speedup work.
 $("script").attr("defer","defer");
 //website speedup work end . 
 //****** jumper work
 $(".jumper").on("click", function(e) {
 	     //e.preventDefault();
            console.log("jumper click");
            $("body").animate({
             scrollTop: $($(this).attr('href')).offset().top - 50
            }, 1000);
        });

 //**** jumper work above   
   
});        
</script>
<!--<script src="<?php //echo get_template_directory_uri().'/js/jquery.jqGrid.min'?>"></script>
<script src="<?php //echo get_template_directory_uri().'/js/jquery.jqGrid.src'?>"></script>-- >

<script src="<?php //echo get_template_directory_uri().'/js/jgrid.locale-en'?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqgrid/4.6.0/js/i18n/grid.locale-en.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqgrid/4.6.0/js/jquery.jqGrid.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqgrid/4.6.0/js/jquery.jqGrid.src.js
"></script>


</body>
</html>
