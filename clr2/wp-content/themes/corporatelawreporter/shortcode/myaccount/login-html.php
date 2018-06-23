<?php
/*
 *login HTML define the login Form and social services options for login the user. 
 */
 
 //******************** Registration *******************
 if(isset($_POST['submit_register'])){
 	$email = $_POST['email'];
	$pass  = $_POST['password'];
	$conpass=$_POST['confirmpassword'];
	//step-1 : validate the email id : if email id is not exists then we allow for new registration.
		if (!eminds_validate_username_emailid($email)) {
			
		 //step-2: validate the password and confirm password	
		   if($pass == $conpass){
		      //step-3: Create an account.
		      $userdata = array(
							    'user_login'  =>  $email,
							    'user_email'  =>  $email,
							    'user_pass'   =>  $pass, // When creating an user, `user_pass` is expected.
							    'role'        => 'contributor'
							);
							
							$user_id = wp_insert_user( $userdata ) ;  
				// create user login session        
				 eminds_user_login_session($email,$pass,0);
	             //redirect if all successfull
	             wp_redirect( get_permalink(get_the_ID())); 
				 
		   }else{
		   	echo 'Please enter password and confirm password are same.';
		   }	   
		   	
		}else{
		 echo 'Email allready exists.';	
		}
 }
 
 //************************************************************************ when login form submit
 if(isset($_POST['submit_login'])){
 	
    $username = $_POST['username'];
	$pass     = $_POST['password'];
	$rememberme=$_POST['rememberme'];
		//custom login code.
		if (eminds_validate_username_emailid($username)) {
			  // Go ahead and save the user...
			  $user = get_user_by( 'login', $username );
				if ( $user && wp_check_password( $pass, $user->data->user_pass, $user->ID) ){
				
				// create user login session        
					    eminds_user_login_session($username,$pass,1);
	             //redirect if all successfull
	             wp_redirect( get_permalink(get_the_ID()) ); exit;
	
				}else{
				   echo "Invalid Password";
				}
	    }else{
	   echo "invalid Username !";	
	    }
 }
 //************************************************************************ when login form submit 
 ?>
 <div class="login-container">
 	<div class="login-left-container">
 		        
        <form id="auth-email-frm" method="post" action="<?php echo get_permalink(get_the_ID()); ?>?action=register">
      <?php 
      //registration form 
      if(isset($_REQUEST['action']) AND $_REQUEST['action']=="register"){
      	?>
      	<h3>Create an Account</h3> 
            <div class="form-group">
                <label for="eee">Email Address </label>
            </div>
            <div class="form-group">
                    <input id="eee" class="forminput" name="email" type="text" value="" size="30" required="">                    
            </div>

            <div class="form-group">
               <label for="password">Password</label>
            </div>
            <div class="form-group">
                    <input id="password" class="forminput" name="password" type="password" size="30" required="">                    
            </div>

        <div class="form-group">
               <label for="password">Confirm Password</label>
            </div>
            <div class="form-group">
                    <input id="password" class="forminput" name="confirmpassword" type="password" size="30" required="">                    
            </div>
            

            <p class="mt10">
                <input type="submit" value="Register" class="submit-button" name="submit_register" id="sign_up_submit">
            </p>
           <div class="container-foot">
			    <a id="createAccountLink" href="<?php echo get_permalink(get_the_ID()); ?>">Sign In</a> 	    
		  </div>
      	<?php 
	  }else{
      ?> 
       <!--    ---------------Login Form ----------------     -->
       <h3>Sign In</h3> 
            <div class="form-group">
                <label for="eee">UserName /Email Address </label>
            </div>
            <div class="form-group">
                    <input id="eee" class="forminput" name="username" type="text" value="" size="30" required="">                    
            </div>

            <div class="form-group">
           <label for="password">Password</label>
            </div>
            <div class="form-group">
                    <input id="password" class="forminput" name="password" type="password" size="30" required="">                    
            </div>
            <div class="form-group"> <!-- signin-rem -->
                    <input type="checkbox" name="rememberme" id="rememberme" value="1"> <label for="rememberme" class="inline normal">Keep Me Signed In</label>
                                       
            </div>
            <p class="mt10">
                <input type="submit" value="Sign In" class="submit-button" name="submit_login" id="sign_in_submit">
            </p>
           <div class="container-foot">
			    <a href="<?php echo site_url(); ?>/wp-login.php?action=lostpassword">Forgot Password?</a>
			    <a id="createAccountLink" href="<?php echo get_permalink(get_the_ID()); ?>?action=register">Create an Account</a> 	    
		  </div>
       <!--    ---------------Login Form END ----------------     -->
       <?php } ?>     
        </form>
        
    </div>
    <div class="login-right-container">
    <?php
       //1: When user not logged in
	   echo  do_shortcode('[social_connect]');
	?>	
    </div>
    		
 </div>