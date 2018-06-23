<?php

function urlprocessphp(){
  return sprintf(
    "%s://%s%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME'],
    $_SERVER['REQUEST_URI']
  );
}

function urlwebsite(){
  return sprintf(
    "%s://%s%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME'],
    ""
  );
}

function get_db_value_from_optiontable($key){
	
$servername = DB_HOST;//"localhost";
$username = DB_USER;//"corporat_clr21";
$password = DB_PASSWORD;//"clr21@1212";
$dbname   = DB_NAME;//"corporat_clr21";
// Create connection

$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//print_r($conn);
//echo "connection established ";//exit;

$prefix ="wp_";

//query 
 $sql_linkedininfo ="SELECT * FROM ".$prefix."options WHERE option_name='$key' ";
$result = $conn->query($sql_linkedininfo);
 
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        return $row["option_value"];
    }
} else {
    return 0;
}
//close the connection 
//mysql_close($conn);	
$conn->close();
}
//********* option framework theme
function get_optionframeworktheme_value_from_db($key){
	
	$arr_opt = get_option("options-framework-theme");
	$value   = $arr_opt[$key];
	
	if($value){
		return $value;
	}else{
		return 0;
	}
   return 0;	
}
//use in below : table : wp_options

@session_start(); 


//site url
$siteurl = get_db_value_from_optiontable("siteurl");


$siteurl = $siteurl;//urlwebsite();
$baseURL = $siteurl;//urlwebsite();
$callbackURL =urlprocessphp();//get_stylesheet_directory_uri().'/process.php';

//linkedin API key and secret key
$linkedin_apikey = get_optionframeworktheme_value_from_db("linkedin_apikey");

if($linkedin_apikey == 0){
	$linkedin_apikey ='75lcocy019kwum';
}

$linkedin_secretkey = get_optionframeworktheme_value_from_db("linkedin_secretkey");

if($linkedin_secretkey == 0){
	$linkedin_secretkey ='v6CHSqKAl3V2RXjX';
}

$linkedinApiKey = $linkedin_apikey;//'75bee8gqiqj0hn';
$linkedinApiSecret = $linkedin_secretkey;//'zNmOv41tQKVxUiHC';

$linkedinScope = 'r_basicprofile r_emailaddress';
//define constants
define('SITE_URL',$siteurl);
define('BASE_URL',$siteurl);
define('CALLBACK_URL',urlprocessphp());
  
define("LINKEDIN_API_KEY",$linkedin_apikey);
define("LINKEDIN_SECRET_KEY",$linkedin_secretkey);

define("LINKEDIN_SCOPE",'r_basicprofile r_emailaddress');

//redirect URL

$redirectURL = get_optionframeworktheme_value_from_db("linkedin_redirecturl");

if(!$redirectURL){
    $redirectURL = "http://corporatelawreporter.com/submit-article/";	
}


define("LINKEDIN_REDIRECT_URI",$redirectURL);

?>
