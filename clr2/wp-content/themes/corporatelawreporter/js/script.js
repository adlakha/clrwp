/*
 *Scripts file for common functionality
  */
jQuery(document).ready(function($) {
    if ($.browser.msie) {
        $("body").addClass("ie-browser");
    };
       
     $(window).scroll(function(){
    if($(this).scrollTop()>=206){
        $(".sticky-table-header").addClass("active");

    }else{
        $(".sticky-table-header").removeClass("active");
    }
  });
    
    
	$(".menu-icon-left").click(function() {
		$(".leftdropdown").slideToggle();
	}); 
	
	$(".menu-icon-left,.category-nav ul li a").blur(function() {
		$(".leftdropdown").slideUp();
	});

  //for the setting icons
 	$(".setting-icon").click(function() {
		$(".rightdropdown").slideToggle();
	});

	$(".setting-icon,.category-nav ul li a").blur(function() {
		$(".rightdropdown").slideUp();
	});


/*
 *Adding class in footer nav menu 
 */
var inc=1;
$('.footer-nav-widget ul.menu').each(function(){
	var classcustom = (inc%2==0)?"fl":"first fl";
	$(this).addClass(classcustom);
	++inc;
});

//Sidebar menu :

$('.right-content .menu').parent("div").addClass("side-menu");
$('.right-content .textwidget').wrap("<section class='side-description '></section>");

//*************** Header searchform *******************
   $(".wp_searchbutton").click(function(){
   	var searchString = $(".searchbox").val();
   	if(searchString == ""){
   		$(".searchbox").focus();
   		$(".searchbox").attr("placeholder","");
   	  return false;	
   	}
   	return true;
   });
   $("#emailpopup").click(function(){
   	  $(this).attr("placeholder","");
   });
  
   $("#emailpopup").blur(function(){
   	  $(this).attr("placeholder","Subscribe to DAILY JOURNAL");
   });
   //*************** End Header searchform
   //*********** jumpto section.
   $(".jump_section_submit").click(function(){
   	var searchString = $(".jump_section_number").val();
   	if(searchString == ""){
   		$(".jump_section_number").focus();
   		$(".jump_section_number").attr("placeholder","");
   	  return false;	
   	}
   	return true;
   });
   $(".jump_section_number").click(function(){
   	  $(this).attr("placeholder","");
   });
   $(".jump_section_number").blur(function(){
   	  $(this).attr("placeholder","Section No.");
   });
   //*************** Subscription validation : when click remove placeholder and viceversa
   $("div.subscribe #email").click(function(){
   	  $(this).attr("placeholder","");
   });
   $("div.subscribe #email").blur(function(){
   	  $(this).attr("placeholder","Enter your email ID to subscribe");
   });
   //*************** Subscription validation : when click remove placeholder and viceversa
   //sidebar
   $(".right-column .right-content ul").wrap("<section class='side-menu '></section>");
   $(".miw-container section").addClass("border-none");
   $(".right-content:first").addClass('margin-top-none');

//************************************ Single company act page ******************************
   var themepath = obj.theme_path;
   $(".single-pagination .next a").append("<img src='"+themepath+"/images/next.png' title='Click to see Next Section' alt='icon' />");
   $(".single-pagination .prev a").append("<img src='"+themepath+"/images/prev.png' title='Click to see Previous Section' alt='icon' />");
   
   //corporate single
   $("li.schedulepost").parent().css("margin","0 0 10px 25px");
//***************************************

//checkout page : update the member via ajax
 $(".ajax-update-member").click(function(){
    
    var total_qty = $(this).attr("data-qty");
    var productid = $(this).attr("data-productid");
    //preparing the data string
    
    var data_string = "&qty="+total_qty+"&pid="+productid;
    
    for(var i=1;i<= total_qty;i++){
    	
    var member_name  = $('.member_name_'+productid+"_"+i).val();
    var organisation = $('.organization_'+productid+"_"+i).val();
    var designation  = $('.designation_'+productid+"_"+i).val();
    var member_phone = $('.phone_'+productid+"_"+i).val();
    var member_email = $('.member_email_'+productid+"_"+i).val(); 	
  
   data_string  +='&member_name_'+productid+"_"+i+"="+member_name+"&organization_"+productid+"_"+i+"="+organisation+"&designation_"+productid+"_"+i+"="+designation+"&phone_"+productid+"_"+i+"="+member_phone+"&member_email_"+productid+"_"+i+"="+member_email+"";
   
   } //for loop  
   //alert(data_string);	
  //establish AJAX request
    $.ajax({
            type : "POST",
            url  : obj.ajaxURL,
            data : 'action=event_member_info'+data_string ,
            beforeSend: function(){
              $(".ajax-update-member").html("Loading ...");
            },
            success: function(response) {
              // alert(response);
               $(".ajax-update-member").html("Update Member");  
               location.href = response;       
            }
        });  
  //ajax end.
   
    	
 });
//checkout page : END
//woocommerce category page
$(".tax-product_cat #container").addClass("col-sm-8");

 $('.social_connect_login_facebook').html("Sign in with Facebook");
 $('.social_connect_login_google_plus').html("Sign in with Google+");
 $('.social_connect_login_yahoo').html("Sign in with Yahoo");
 $('.social_connect_login_twitter').html("Sign in with Twitter");

//product archive.
$(".post-type-archive-product #container").addClass("col-sm-8");	
//copy protection .
 //product single
 $("#content").addClass("container-fluid");
//mobile view
$(".mobile-search-icon").click(function(){
	$(".search.desktop-view").addClass("active");
});
$(".search-cross").live("click",function(){
	$(".search.desktop-view").removeClass("active");
});


//******************* Header JS : inline added previously .
	$(".wpauthor-msg").click(function(){
		
		var sender_name = $("#send-authoremail .fname").val();
		var sender_email= $("#send-authoremail .emailid").val();
		var sender_msg  = $("#send-authoremail .msg").val();
		
		var authorname  = $(".authorname").val();
		
		//validation :
		/*
		 * iserror = 1 : valid value
		 * iseroor = 0 : error need the validation value.
		 */
		var iserror = 1;
		if(sender_name == ""){
			iserror = 0;
			$("#send-authoremail .fname").addClass("error");
		}
		
		if(sender_email == ""){
			iserror = 0;
			$("#send-authoremail .emailid").addClass("error");
		}
		
		if(sender_msg == "" ){
			iserror = 0;
			$("#send-authoremail .msg").addClass("error");
		}
	
	  if(iserror == 1){	
	    //start AJAX call and send the message.
	       $.ajax({
            type : "POST",
            url : obj.ajaxURL,
            data: 'action=eminds_sendemail_toauthor&sender='+ sender_name + '&email='+sender_email +'&msg='+sender_msg+'&authorname='+authorname,
            beforeSend: function(){
                jQuery('em.loader-text').css('display','inline-block');
            },
            success: function(response) {
                //alert(response); 
                jQuery('em.loader-text').html(response); 
            }
        });		
		}// condition
	});
//validation for reset
$(".error").live('click',function(){
	jQuery(this).removeClass("error");
});
//height of the conent and sidebar.
/*
setTimeout(function(){ 
var content_height = $(".left-manageheight").innerHeight();
var sidebar_height = $(".right-manageheight").innerHeight();

var apply_height   = sidebar_height;
if(sidebar_height < content_height){
	apply_height   = content_height;
}
//alert("1st="+content_height +"=sidebar="+sidebar_height+"=apply"+apply_height); 
//add this height to both the div.
$(".left-manageheight").css('height',apply_height);
$(".right-manageheight").css('height',apply_height);	
	},
	 3999); */
/*
 *Special case: width > 768 : right sidebar becomes display none.
 */	 
/*var window_width = window.innerWidth;;
if(window_width < 768 ){
	
	$(".right-manageheight").html("");
	
	//we need setTimeout :when height added then it creats blank space because i have remove the content. see above stmt.
	setTimeout(function(){
	$(".right-manageheight").css('height',0);
	},
	 3999);
}	 
*/	 
//*************** END *****
//for blank div : add the : &nbsp; ********* Single page
$("#wpsinglepostcontent div,#wpsinglepostcontent p").each(function(){

var content11_text = $(this).html();
if(content11_text == ""){
	$(this).html("&nbsp;");
}
	
});
//********************** End Single 
//******* animation effect in : microsoft -header and footer - jumper effect
    
        // $(".jumper").on("click", function(e) {
            // e.preventDefault();
            // $("body, html").animate({
                // scrollTop: $($(this).attr('href')).offset().top
            // }, 100);
        // });
//*********************** jumping end ***********

msieversion();
function msieversion() {
 if (!!navigator.userAgent.match(/Trident\/7\./)) {
     $('body').addClass('ie-browser');
 }
}

//dom ready end 
});



