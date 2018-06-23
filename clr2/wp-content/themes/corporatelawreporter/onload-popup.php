<?php
/*
 *This file describe the onload popup functionality 
 */
 ?>
 <script>
	

function checkEmail(emailString) {

		splitVal = emailString.split('@');
		if(splitVal.length <= 1) {
			alert("Please enter a valid email address");
			return false;
		}
		if(splitVal[0].length <= 0 || splitVal[1].length <= 0) {
			alert("Please enter a valid email address");
			return false;
		}
		splitDomain = splitVal[1].split('.');
		if(splitDomain.length <= 1) {
			alert("Please enter a valid email address");
			return false;
		}
		if(splitDomain[0].length <= 0 || splitDomain[1].length <= 1) {
			alert("Please enter a valid email address");
			return false;
		}
		return true;
	}
//end 
</script>
<style>
    .popup {
        background: rgba(0,0,0,0.8);
        width: 100%;
        height: 100%;
        position:fixed;
        top: 0;
        left: 0;
        z-index: 9999;
        display:none; 
    }
    .popup-content {
    	width: 40%;
        border: 1px solid #ccc; 
        background: #fff;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        padding: 30px 20px;
        box-shadow: rgba(0,0,0,0.5) 0px 0px 15px;
        -webkit-box-shadow: rgba(0,0,0,0.5) 0px 0px 15px;
        -moz-box-shadow: rgba(0,0,0,0.5) 0px 0px 15px;
    }
    .popup-content h2 {
	margin: 0 0 10px 0;
	font-weight: 700;
	font-size: 20px;
	}
	.popup-content input[type="text"] {
	width: 100%;
	padding: 10px;
	border-radius: 2px;
	border: 1px solid #ccc;
	margin-bottom: 10px;
	font-size: 18px;
	line-height: 18px;
}
.popup-content input[type="submit"]  {
border: 0px;
padding: 10px;
font-size: 15px;
border-radius: 2px;
color: #fff;
background: #e57f03;
}
    .closePopup {
        width:30px;
        height: 30px;
        text-align: center;
        text-decoration: none;
        line-height: 30px;
        background: #fff;
        border:1px solid #000;
        border-radius: 50%;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        position: absolute;
        top: -15px;
        right: -15px;
        display: block;
    }
</style>
 
<!-- *****************popup ***********************  -->

<?php 


if(isset($_REQUEST['utm_source'])){
    
    /*
     *When browser open from feedburner 
     * $is_feedburner = 0 it means we need to disable the popup 
     */
     if(@$_REQUEST['utm_source'] == "feedburner"){
     	    $_SESSION['is_close'] =1;  
        ?>
    <script>
    jQuery(document).ready(function($){
       $(".popup").css("display","none");
      
    });
    </script>      
        <?php
     	} 
    
}
//session ********************* case
if(isset($_SESSION)){
    
    if(@$_SESSION['is_close'] == 1){
        ?>
    <script>
    jQuery(document).ready(function($){
       $(".popup").css("display","none");
      
    });
    </script>      
        <?php 
    }else{
      //when browser open first time and don't close the close button  
        ?>
    <script>
        jQuery(document).ready(function($){

            setTimeout(function(){
       		
        $(".popup").fadeIn( "slow", function() {
            // Animation complete
            //$(this).css("display","block");
          });  
      //Under code will run after 10 sec
	        },5000);
            
        });
      
    </script>     
            
            <?php
    }
    
}else{
   //forcely open the popup
?>
    <script>
        jQuery(document).ready(function($){
          console.log("$_SESSION ELSE PART");
            setTimeout(function(){
       		
        $(".popup").fadeIn( "slow", function() {
            // Animation complete
            //$(this).css("display","block");
          });  
      //Under code will run after 10 sec
	        },5000);
            
        });
      
    </script>
    <?php
}


?>
<!-- 
//We will close the popup via ajax : Why use ajax
Reason : We will also create a session so it can be maintain when page redirect as well as when close the browser
:Note: javasccript file : jquery.session.js is not working completely : So need the AJAX .
--> 
<script>
    jQuery(document).ready(function($){
        $(".ajax-closepopup").click(function(){
        //close the browser 
       $(".popup").css("display","none");
       //Need the session so I 'm using the AJAX.
          jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : '<?php echo admin_url("admin-ajax.php"); ?>',
                data: 'action=enable_session_close_popup',
                success: function(response) {
                   //alert(response);
                   $(".popup").css("display","none");
                   //console.log(response);
                   
                }
            });  
     });
     
  $(".ajax-closepopup-btn").click(function(){
    
    var emailval = $("#emailpopup").val();
    //Remove validation - 09-dec-2015 - client Requirement.
   /* if(emailval =="" ){
    
      alert("Please Enter your email id");
	  document.getElementById('emailpopup').focus();
	  return false;
	  
    }
   

   if(!checkEmail(emailval))
	{
	   //alert("Please enter a valid Email");
		document.getElementById('emailpopup').focus();
		return false;	
	}*/	
	//when successfull call this ajax.
	 	  jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : '<?php echo admin_url("admin-ajax.php"); ?>',
                data: 'action=enable_session_close_popup',
                success: function(response) {
                   //alert(response);
                   $(".popup").css("display","none");
                   //console.log(response);
                  }
            });
     	
     });
     //subscription button      
    });


/*
 * when :esc: button pressed.
 */

    jQuery(document).keyup(function(e) {
     if (e.keyCode == 27) { // escape key maps to keycode `27`
       console.log("esc button pressed");
              jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : '<?php echo admin_url("admin-ajax.php"); ?>',
                data: 'action=enable_session_close_popup',
                success: function(response) {
                   //alert(response);
                   jQuery(".popup").css("display","none");
                   //console.log(response);
                  }
            });
    }
});



</script>     
    
<!-- *****************popup ***********************  -->
<div id="popup-automatic" class="popup desktop-view">
<div class="popup-content">
     <a href="javascript:void(0);" class="closePopup closebtn ajax-closepopup">X</a>
    <h2>Get Free Legal Updates</h2> <!--  onsubmit="return subpopupcheck();" -->
<form onClick="target='_blank';" action="http://feedburner.google.com/fb/a/mailverify?uri=corporatelawreporter" method="post" class="searchform">
     <input name="email" id="emailpopup" type="text" value="" class="subscribe_input" placeholder="Enter your email ID to subscribe"  />
        <input name="Subscribe" value="Subscribe" type="submit" class="subscribebt ajax-closepopup-btn" /> 
 </form>
</div>

    </div>