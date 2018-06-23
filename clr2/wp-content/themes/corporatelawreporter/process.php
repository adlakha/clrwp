<?php
/*
 *Template Name:linkedin 
 */


require_once dirname( __FILE__ ) ."/config.php"; 
//include_once("includes/db.php");
require_once("LinkedIn/http.php");
require_once("LinkedIn/oauth_client.php");

//db class instance
//$db = new DB;

if (isset($_GET["oauth_problem"]) && $_GET["oauth_problem"] <> "") {
  // in case if user cancel the login. redirect back to home page.
$_SESSION["err_msg"] = $_GET["oauth_problem"];
 // header("location:".LINKEDIN_REDIRECT_URI);
  exit;
}

$client = new oauth_client_class;

$client->debug = false;
$client->debug_http = true;
$client->redirect_uri = CALLBACK_URL;

$client->client_id = LINKEDIN_API_KEY;
$client->state     = uniqid('', true);
$application_line = __LINE__;
$client->client_secret = LINKEDIN_SECRET_KEY;

if (strlen($client->client_id) == 0 || strlen($client->client_secret) == 0)
  die('Please go to LinkedIn Apps page https://www.linkedin.com/secure/developer?newapp= , '.
			'create an application, and in the line '.$application_line.
			' set the client_id to Consumer key and client_secret with Consumer secret. '.
			'The Callback URL must be '.$client->redirect_uri).' Make sure you enable the '.
			'necessary permissions to execute the API calls your application needs.';


/* API permissions
 */
 
$client->scope = LINKEDIN_SCOPE;

//echo '<pre>'; print_R($client);echo '</pre>';exit;

if (($success = $client->Initialize())) { //echo '<pre>'; print_R($client);echo '</pre>';echo 'success='.$success;exit;
  if (($success = $client->Process())) { // echo '<pre>'; print_R($client);echo '</pre>';echo 'success='.$success;exit;
    if (strlen($client->authorization_error)) {
      $client->error = $client->authorization_error;
      $success = false;
    } elseif (strlen($client->access_token)) {
    
      $success = $client->CallAPI(
					'http://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,location,picture-urls::(original),public-profile-url,formatted-name)', 
					'GET', array(
						'format'=>'json'
					), array('FailOnAccessError'=>true), $user);
    }
  }
  $success = $client->Finalize($success);
}
if ($client->exit) exit;

//echo '<pre>';print_R($client);echo '</pre>ssssssssss===';exit;

if ($success) {
    // echo '<pre>';
	// print_r($user);
	// echo '</pre>';exit;
    //Generate the session and store on it.
    
    $_SESSION['linkedin_id']   = $user->id;
    $_SESSION['user_email']    = $user->emailAddress;
    $_SESSION['formattedName'] = $user->formattedName;
   // $_SESSION['pictureUrl']    = $user->pictureUrl;
    $_SESSION['pictureUrl']    = $user->pictureUrls->values[0];
    $_SESSION['publicProfileUrl'] = $user->publicProfileUrl;

    //extra values
    $_SESSION['linkedin_firstname'] = $user->firstName;
    $_SESSION['linkedin_lastname'] = $user->lastName;
	    
    //verify linkedin login session
    $_SESSION['linkedin']=1;
    
} else {
 	 $_SESSION["err_msg"] = $client->error;
}
header("location:".LINKEDIN_REDIRECT_URI);
exit;
?>
