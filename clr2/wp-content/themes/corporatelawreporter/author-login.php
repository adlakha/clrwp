<?php
/*
 * Author loign file will how if user not logged in
 */
 @session_start();

/*
 * As per change condition, we will use the :woocommerce function: for lost password
URL : wc_lostpassword_url();
 */


 /*
  *This file used in woocommerce login page and our template login page 
  *So we need to change the class 
  */
 $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
 $clsname           = ($myaccount_page_id == get_the_ID())? "col-sm-12" :"col-sm-8";
 ?>
        <section class="<?php echo $clsname; ?>">
<?php
/*
 * login HTML define the login Form and social services options for login the user. 
 */
//******************** Set password field ********************* 
 if(isset($_POST['submit_setpass'])){
 	
	$pass    = $_POST['password'];
	$conpass = $_POST['conpassword'];
	$username = $_POST['key2'];
	$key1     = $_POST['key1'];
	
	$userid  = eminds_get_userid($username);
	
	if($pass == $conpass){
	  //set password		
		wp_set_password( $pass, $userid );
	//reset the activation key 
	$flag = eminds_update_activation_key($userid,"");
	
    echo '<p class="succmsg">Password have been reset,please login.<a href="'.get_permalink(get_the_ID()).'" class="btn btn-xs btn-primary">Login</a></p>';
				
	}else{
     echo '<p class="errormsg">Password and confirm password should be same.</p>';	
	 
	}
	
	
 }
 
//********************end set passwrod. 
//*******************  Submit Reset Pass: Send email *********************************
 if(isset($_REQUEST['submit_resetpass'])){
     //get the username or email.
     $user_email = $_POST['username'];
     //validated user
     if(eminds_validate_username_emailid($user_email)){
      //send email to user.
      $template_file = "reset-password.html";
      $msgTemplate   = eminds_read_emailtemplatefile($template_file);
	  
	  $key_arr       = array("[username]","[link]");
	  
	  //before sending email, we need to set the : user_activation_key  :
	  $generatedKey = sha1(mt_rand(10000,99999).time().$user_email); 
	  $flag = eminds_update_activation_key($user_email,$generatedKey);
	  
	  $link          = get_permalink(get_the_ID())."?action=resetpassword&key1=$generatedKey&key2=$user_email";
	  
	  $value_arr     = array($user_email,$link);
	  
	  $plane_message = eminds_search_replace_with_value($key_arr,$value_arr,$msgTemplate);
	  //send an email to user
	  $subject = "Reset Password";
	  
	  $output = eminds_send_email_touser($user_email,$subject,$plane_message);
	  
	  echo '<p class="succmsg">Check your e-mail for the confirmation link.</p>';
	  
	 // if($output){
	  //	echo '<p class="succmsg">Check your e-mail for the confirmation link.</p>';
	  //}
	 
     }else{
           echo '<p class="errormsg">ERROR: There is no user registered with that email address.</p>'; 
     }
 }

//******************** Registration *******************
if (isset($_POST['submit_register'])) {
    $email   = $_POST['email'];
    $pass    = $_POST['password'];
    $conpass = $_POST['confirmpassword'];
   //other two extra field.
    $fname   = $_POST['fname'];
    $lname   = $_POST['lname'];
    //changes on 26 september-- for scratchcode
    $scratchcode   = $_POST['scratchcode'];

    // changes on 29 september --- for updating profile of book user


    $organisation   = $_POST['oragnisation'];
    $designation    = $_POST['designation'];
    $mobileno       = $_POST['mobilenumber'];
    $address        = $_POST['address'];
    $city           = $_POST['city'];
    $state          = $_POST['state'];
    $country        = $_POST['country'];
        

    

    //step-1 : validate the email id : if email id is not exists then we allow for new registration.
    //echo eminds_validate_username_emailid($email);
    if( !(email_exists( $email ))) {


        //step-2: validate the password and confirm password	
        if ($pass == $conpass) 
        {
          //28 sept
          if($scratchcode)
          {
       
         $matchedscratchID = eminds_validate_scratchcode($scratchcode);

        
         if ($matchedscratchID) 
          {
           echo email_exists( $email );
        //step-3: Create an account.
                 $userdata = array(
                   'user_login' => $email,
                  'user_email' => $email,
                 'user_pass' => $pass, // When creating an user, `user_pass` is expected.
                'first_name' => $fname,
                'last_name' => $lname,
                'display_name' => $fname ."&nbsp;".$lname,
                'role' => 'author'
                );

             $user_id = wp_insert_user($userdata);
   
             if( !(is_wp_error($user_id)))
             {
              //  30 sept 2016 - for scratch card
                  emind_custom_data_save_config($user_id, $matchedscratchID);
                 emind_custom_scratchcode_updatestatus($scratchcode);

    
                    // create user login session        
                 $sessionCheck = eminds_user_login_session($email, $pass, 0);
                //redirect if all successfull
                 // wp_redirect(get_permalink(get_the_ID()));
            //echo  get_the_author_meta('description', $userID );
                 // to add meta values at the registration time
                 add_user_meta( $user_id, 'organization',$organisation); 
                 add_user_meta( $user_id, 'designation', $designation ); 
                 add_user_meta( $user_id, 'phone', $mobileno );
                 add_user_meta( $user_id, 'address', $address ); 
                 add_user_meta( $user_id, 'city', $city ); 
                 add_user_meta( $user_id, 'state', $state);
                 add_user_meta( $user_id, 'country', $country);
                 //10th oct**** end*****
                  // for check box default 
               
                 add_user_meta( $user_id, 'check_for_telephone_number_private', true);
                 add_user_meta( $user_id, 'check_for_mobile_number_private', true);
                 add_user_meta( $user_id, 'check_for_address_private', true);
                   /*// 10th october -- hide city,state,country 
                 add_user_meta( $user_id, 'check_for_city', true);
                 add_user_meta( $user_id, 'check_for_state', true);
                 add_user_meta( $user_id, 'check_for_country', true);
                  // 10th oct End************/
                 // for check box default 
                

            


                 if ($sessionCheck) 
                {
              
                 // echo get_the_author_meta( string $field = '', int $user_id  );
                     wp_redirect(get_permalink(get_the_ID()));
                }
                else
                {
                  echo "unable to create session";
                }
            }
            else
            {
              
              echo $user_id->get_error_message();
            }  
             
          }
          else
            {            
             echo '<p class="errormsg">Please enter unique scratch code</p>';
            }
          }
         else
         {
           echo "not entered value";
                $userdata = array(
                   'user_login' => $email,
                  'user_email' => $email,
                 'user_pass' => $pass, // When creating an user, `user_pass` is expected.
                'first_name' => $fname,
                'last_name' => $lname,
                'display_name' => $fname ."&nbsp;".$lname,
                'role' => 'contributor'
                );

             $user_id = wp_insert_user($userdata);
              $sessionCheck = eminds_user_login_session($email, $pass, 0);
              wp_redirect(get_permalink(get_the_ID()));

         }   

        }  
        else 
       {
            echo '<p class="errormsg">Please enter password and confirm password are same.</p>';
       }
    } 
    else
    {
        echo '<p class="errormsg">Email allready exists.</p>';
    }

}

//************************************************** when login form submit

if (isset($_POST['submit_login'])) {

    $username = $_POST['username'];
    $pass = $_POST['password'];
    $rememberme = $_POST['rememberme'];
    //custom login code.
    if (eminds_validate_username_emailid($username)) {
        // Go ahead and save the user...
        //get the login name : by username or email id.
        $loginName = eminds_get_username_by_username_or_emailid($username);
        
        $user = get_user_by('login', $loginName);

        if ($user && wp_check_password($pass, $user->data->user_pass, $user->ID)) {


                    // create user login session        
            eminds_user_login_session($username, $pass, 1);

/*  7th october  ----- Changes For Role change to contributor for coupon expire login time  as expiry date get matched */
        // To get  the current user id 
        $current_eminds_userid = $user->ID;
         // echo $current_eminds_userid ;
        $user_info = get_userdata( $current_eminds_userid);
        // To get the Current user role
          $current_user_role = $user_info->roles[0];
           
          //To get the Matched Expiry Date of scratchcard/coupon
// changes wednesday -12th oct
          $matchedExpiryDate = eminds_coupons_expiry_date_match($current_eminds_userid );
          $matchedExpiryDate[0]->ExpiryDate;

          //var_dump( $matchedExpiryDate);
         $scratchcodeused = $matchedExpiryDate[0];
        // echo $scratchcodeused;
         $scratchcodeexpirydate =$matchedExpiryDate[1];
        // echo $scratchcodeexpirydate;
        
     
          // To set current time calculation in yyyy-mm-dd format
          $current_time=time();
          $current_time_login = date("Y-m-d",$current_time);
            if($scratchcodeused)
            {
                if($scratchcodeexpirydate == $current_time_login)
                {
                 $u = new WP_User($current_eminds_userid);
                // Remove role
                $u->remove_role( 'author' );
                // Add role
                $u->add_role( 'contributor' );

                }
                else
                {
                 $u = new WP_User($current_eminds_userid);
                // Remove role
                $u->remove_role( 'contributor' );
                // Add role
                $u->add_role( 'author' );

                }
            }
            // 12oct
           
            // End  7th october ----- Login time Expiry Date MAtched value of Scratch card
            //redirect if all successfull
            wp_redirect(get_permalink(get_the_ID()));
            exit;
        } else {
            echo "<p class='errormsg'>Invalid Password</p>";
        }
    } else {
        echo "<p class='errormsg'>invalid Username !</p>";
    }

}
//*********************************************** when login form submit 
?>
        
            <?php
//registration form 
            if (isset($_REQUEST['action']) AND $_REQUEST['action'] == "register") {
                ?>
<form id="auth-email-frm" method="post" action="<?php echo get_permalink(get_the_ID()); ?>?action=register">
                <section class="login-box register-forms">
                    
                    <section class="form-bottom-link">
                     <!-- 10th oct  Monday - For Existing user Shifted singin -->
                    <h3>Existing User <b><a id="createAccountLink " href="<?php echo get_permalink(get_the_ID()); ?>">Sign In</a></b> Here </h3>
                                  
                        </section>
                        <h3>Create Account</h3>
                        <!-- End 10th october- signin -->
                    <section class="input-box">
                       
                        <label for="fname" class="display-b">FirstName </label>
                        <input id="fname" class="forminput" name="fname" type="text" value="<?php echo $_POST['fname']; ?>" size="30" required="">                      
                        <label for="lname" class="display-b">LastName </label>
                        <input id="lname" class="forminput" name="lname" type="text" value="<?php echo $_POST['lname']; ?>" size="30" required="">


                        <label for="eee" class="display-b">Email Address </label>
                        <input id="eee" class="forminput" name="email" type="email" value="" size="30" required="">                    
                        <label for="password" class="display-b">Password</label>
                        <input id="password" class="forminput" name="password" type="password" size="30" required="">                    
                      <label for="password" class="display-b">Confirm Password</label>
                        <input id="password" class="forminput" name="confirmpassword" type="password" size="30" required="">  
                        <br>   
                        <!-- changes for scratch code 26th september-->  
                           <label for="scratch  code" class="display-b">Enter 
                           The Scratch Code (optional)</label>
                        <input type="text" class="forminput" name="scratchcode" id="scratchcodeInput" size="30" minlength="7"  > 
                        <br>            
                        <!-- End of scratch code --> 

                        <!--Changes For Book USER  29th september-->  
                        <div id="show" style = "display:none;" >
                         <label for="oragnisation" class="display-b">Enter 
                           your Organisation</label>
                        <input  class="forminput" name="oragnisation" id="oragnisation" type="text" size="30" value="<?php echo $_POST['oragnisation']; ?>" > 
                        <br>  
                         <label for="designation" class="display-b">Enter 
                           your Designation</label>
                        <input  class="forminput" name="designation" id="designation" type="text" size="30" value="<?php echo $_POST['designation']; ?>"  > 
                        <br>  
                         <label for="mobileno" class="display-b">Enter 
                           your Mobile number</label>
                        <input  class="forminput" name="mobilenumber" id="mobilenumber" type="number" size="30" minlength="10" value="<?php echo $_POST['mobilenumber']; ?>"> 
                        <br>  
                       
                         <label for="address" class="display-b">Enter 
                           your Address</label>
                        <input  class="forminput" name="address" id="address" type="text" size="30" value="<?php echo $_POST['address']; ?>" > 
                        <br>  
                                  
                         <label for="city" class="display-b">Enter 
                           your City</label>
                        <input  class="forminput" name="city" id="city" type="text" size="30" value="<?php echo $_POST['city']; ?>"> 
                        <br>  
                         
                         <label for="state" class="display-b">Enter 
                           your State</label>
                        <input  class="forminput" name="state" id="state" type="text" size="30" value="<?php echo $_POST['state']; ?>"  > 
                        <br>  
                          <label for="Country" class="display-b">Enter 
                           your Country</label>
                           <input  class="forminput" name="country" id="country" type="text" size="30" value="<?php echo $_POST['country']; ?>"  > 
                         
                        <br>  
                        </div> 
                        <!-- End of scratch -->

                        <button type="submit" class="submit-button" name="submit_register" id="sign_up_submit">Register</button>
                       <!-- Earlier Functionality 10oct  <section class="form-bottom-link">
                            <a id="createAccountLink" href="<?php //echo get_permalink(get_the_ID()); ?>">Sign In</a> 	    
                        </section> -->
                    </section>
                    <section class="social-login fl">
        <?php
//1: When user not logged in
        //echo do_shortcode('[social_connect]');
		//get_template_part("linkedin","link");
        ?>	
                    </section>
                </section>
     </form>
    <!-- *************************** Lost password : send an email . --> 
                <?php
            }else if(isset($_REQUEST['action']) AND $_REQUEST['action'] == "lostpassword"){ 
            ?>
               <form id="auth-email-frm" method="post" action="<?php echo get_permalink(get_the_ID())."?action=lostpassword"; ?>">
                <section class="login-box fl">
                    <h3>Reset Password</h3> 
                    <section class="input-box fl">
                        <label for="eee" class="display-b">UserName /Email Address </label>
                        <input id="eee" class="forminput" name="username" type="text" value="" size="30" required="required">                    
                        <button type="submit" class="submit-button" name="submit_resetpass" id="reset_submit">Get New Password</button>
                        <section class="form-bottom-link">
                             <a id="createAccountLink" href="<?php echo get_permalink(get_the_ID()); ?>?action=register" class="fr">Create an Account</a> 	    
                        </section>
                    </section>
                    <section class="social-login fl">
                        <?php
                        //1: When user not logged in
                      //  echo do_shortcode('[social_connect]');
		              //  get_template_part("linkedin","link");
                        ?>	
                    </section>
                    <!--    ---------------Login Form END ----------------     -->
                </section>
              </form>   
             <?php
        //**************************** Reset password : set password field ***********************     
        
            }else if(isset($_REQUEST['action']) AND $_REQUEST['action'] == "resetpassword"){
            	
            $key1     = $_REQUEST['key1'];
			$username = $_REQUEST['key2'];
	        	 $url = get_permalink(get_the_ID())."?action=resetpassword&key1=$key1&key2=$username";
            ?>
               <form id="auth-email-frm" method="post" action="<?php echo $url; ?>">
                <section class="login-box fl">
                	<section class="input-box fl">&nbsp;
                	<?php 
                	//validate the username
                		/*
						 *Inner validate two field.
						 * 1: username
						 * 2: key  
						 */ 
					$username = $_REQUEST['key2'];
					if(eminds_validate_username_emailid($username) AND eminds_validate_activation_key($username,$key1)){
						
                	?>
                        <h3>Enter Password</h3>
                        <input type="hidden" name="key2" value="<?php echo $_REQUEST['key2']; ?>" />
                        <input type="hidden" name="key1" value="<?php echo $_REQUEST['key1']; ?>" />
                         
                        <label for="eee" class="display-b">Password </label>
                        <input id="eee" class="forminput" name="password" type="password" value="" size="30" required="">
                        <br/> 
                       <label for="eee1" class="display-b">Confirm Password </label>
                        <input id="eee1" class="forminput" name="conpassword" type="password" value="" size="30" required="">
                        <br/>                    
                        <button type="submit" class="submit-button" name="submit_setpass" id="setpass">Submit Password</button>
                   <?php } ?>
                        <section class="form-bottom-link">
                             <a id="createAccountLink" href="<?php echo get_permalink(get_the_ID()); ?>?action=register" class="fr">Create an Account</a> 	    
                        </section>
                   
                  
                    </section> 
                    <section class="social-login fl">
                        <?php
                        //1: When user not logged in
                       // echo do_shortcode('[social_connect]');
					//	get_template_part("linkedin","link");
                        ?>	
                    </section>
                    <!--    ---------------Login Form END ----------------     -->
                </section>
              </form>   
             <?php
            
            }else {
                ?> 
                <!--    ---------------Login Form ----------------     -->
             <form id="auth-email-frm" method="post" action="<?php echo get_permalink(get_the_ID()); ?>">
                <section class="login-box register-forms">
                    <h3>Sign In</h3> 
                    <section class="input-box">
                        <label for="eee" class="display-b">UserName /Email Address </label>
                        <input id="eee" class="forminput" name="username" type="text" value="" size="30" required="">                    
                        <label for="password" class="display-b">Password</label>
                        <input id="password" class="forminput" name="password" type="password" size="30" required="">                    
                        <label for="rememberme" class="display-b remember-me"><input type="checkbox" name="rememberme" id="rememberme" value="1" class="auto-height" checked> Keep Me Signed In</label>
                        <button type="submit" class="submit-button" name="submit_login" id="sign_in_submit">Sign In</button>
                        <section class="form-bottom-link">
                            <a href="<?php echo wc_lostpassword_url(); ?>" class="fl">Forgot Password?</a> 
                            <a id="createAccountLink" href="<?php echo get_permalink(get_the_ID()); ?>?action=register" class="fr">Create an Account</a> 	    
                        </section>
                    </section>
                    <section class="social-login fl">
                        <?php
                        //1: When user not logged in
                     //   echo do_shortcode('[social_connect]');
					//	get_template_part("linkedin","link");
						
                        ?>	
                    </section>
                    <!--    ---------------Login Form END ----------------     -->
                </section>
              </form>   
            <?php } ?>     
        
</section>


<script>
// 30 september - for scratch code
jQuery(document).ready(function($){
$("#scratchcodeInput").blur(function(){ 

    var data = $('#scratchcodeInput').val();
    
    if(data.length != 0)
    {
          $("#show").show();
      $("#designation").attr("required","true");
      $("#oragnisation").attr("required","true");
       $("#mobilenumber").attr("required","true");
      $("#address").attr("required","true");
      $("#city").attr("required","true");
      $("#state").attr("required","true");
      $("#country").attr("required","true");
    }

    else
    {
 // alert("test");
        $("#designation").removeAttr("required");
      $("#oragnisation").removeAttr("required");
       $("#mobilenumber").removeAttr("required");
      $("#address").removeAttr("required");
      $("#city").removeAttr("required");
      $("#state").removeAttr("required");
      $("#country").removeAttr("required");
        $("#show").hide(); 
    }
});
 });
</script>

