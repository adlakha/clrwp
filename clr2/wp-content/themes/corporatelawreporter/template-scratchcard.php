<?php
/*
 * Template Name: Scratch card 
 */
get_header();
?>
<!-- end header -->
<section class="container-fluid middle-container">
    <section class="row" >
        <section class=" col-sm-8 posts-content author-detail">

            
              <?php
              if(is_user_logged_in()){
    
                            global $current_user;
                            get_currentuserinfo();
                            $userid = $current_user->ID;
                            $useremail = $current_user->user_email;
                            $displayName = $current_user->display_name;
                            }
                ?>


<?php
if (isset($_POST['updatescratchcode'])) 
{
    $scratchcodeValue=$_POST['updatedscratchcodevalue'];
   
             if($scratchcodeValue)
             {
    
                   $uniquescratchdata= eminds_validate_scratchcode($scratchcodeValue);
                   if($uniquescratchdata)
                   {
                   //echo $uniquescratchdata;
                     emind_custom_data_save_config($userid, $uniquescratchdata);
                    emind_custom_scratchcode_updatestatusexisting($scratchcodeValue);
                                    

                                     global $current_user;
                                $user_roles = $current_user->roles;
                                $user_role = array_shift($user_roles);
                                 $userid = $current_user->ID;
                               // shilpa
                                //allow for author ,contributor and customer
                                if(in_array($user_role,array("contributor","author","customer")))
                                {

                                     $u = new WP_User($userid);
                                               // Remove role
                                               $u->remove_role( 'contributor' );
                                              /*
                                                Remove role - customer for book user - 13th oct
                                                Functinality Updated for book user as this role is created during bokk purchasing*/
                                               $u->remove_role( 'customer' );

                                                // Add role
                                                $u->add_role( 'author' );
                                    echo "<p id='thankyou'> Your Account has been Updated</p>";
                                                
                                }  
                  
                         }

                 else
           
                    {          
                     echo '<p class="errormsg" >Please enter unique scratch code</p>';
                    // wp_redirect(get_permalink(get_the_ID());
                    }
            }

            
}

?>

 <form class="form-horizontal col-sm-12" method="POST" action="" >
 <section class="login-box">
 <h3 style="margin-left: 14px;">Hi, <strong><?php echo $displayName;?> </strong> </h3>
                    
                    <section class="input-box col-sm-6">
                    <h3 >Update ScratchCode Here</h3>                    
                      <label for="password" class="display-b" for="scratchcode">Scratch Code:</label>
                        <input class="forminput " type="text" id="updatedscratchcodevalue" placeholder="Enter scratchcode" maxlength="7" name="updatedscratchcodevalue" required >  
                       
                        <button type="submit" class="submit-button" name="updatescratchcode" id="updatescratchcode" >Submit</button>
                       
                    </section>
                  
                </section>


</form> 


<!-- <form id="updatemyaccount" method="post" action="">
                <section class="login-box ">
                    <h3>Update My account</h3> 
                    <section class="input-box">
                       
                        <!-- changes for scratch code 6th october-->  
                           <!-- <label for="scratchcode" class="display-b">Enter 
                           The Scratch Code </label>
                        <input type="text" class="forminput" name="updatedscratchcodevalue" id="updatedscratchcodevalue" size="30" minlength="7"  required=""> 
                        <br>            
                        End of scratch code  
                    
                       

                        <button type="submit" class="submit-button" name="updatescratchcode" id="updatescratchcode">Update My account</button>
                        
                    </section>
                   
                </section>
     </form> -->
            
                <!-- end post -->	

            </section>
      <?php get_sidebar(); ?>
    </section>
</section>

<!-- start footer -->
<?php
get_footer();
?>

