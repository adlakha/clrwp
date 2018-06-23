<?php
/**
* WordPress Landing Page Config File
* Template Name:  Minimal Responsive Template
*
* @package  WordPress Landing Pages
* @author 	Dholakiya kirit
*
*/

lp_global_config(); // The lp_global_config function is for global code added by 3rd party extensions

//gets template directory name to use as identifier - do not edit - include in all template files
$key = lp_get_parent_directory(dirname(__FILE__)); 

// Add in global templata data
//EDIT - START - defines template information - helps categorize template and provides additional popup information
// Add Landing Page to a specific category. 
$lp_data[$key]['category'] = "Miscellaneous"; 
// Add version control to your template.
$lp_data[$key]['version'] = "1.0.1.2"; 
// Add description visible to the user
$lp_data[$key]['description'] = "Minimal Responsive Template"; 
// Add a live demo link to illustration the page functionality to the user
$lp_data[$key]['features'][] = lp_list_feature("Demo Link","http://demo.inboundnow.com/go/demo-template-preview/"); 
// Description of the landing page visible to the user.
$lp_data[$key]['features'][] = lp_list_feature("Minimal Responsive"); 
//EDIT - END

//DO NOT EDIT - adds template to template selection dropdown 
$lp_data[$key]['value'] = $key; //do not edit this
$lp_data[$key]['label'] = ucwords(str_replace('-',' ',$key)); //do not edit this

//*************************************************************************************************
/* Add User Options to Your Landing Page Template Below */
// For more on adding meta-boxes to templates head to:
// http://plugins.inboundnow.com/docs/dev/creating-templates/template-config/
//*************************************************************************************************

// ADD IN META BOX OPTIONS TO YOUR TEMPLATE BELOW
// Text Color Scheme
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","text-color-picker","A5C100","Color Scheme","Choose the Main Color Scheme", $options=null);

/* Logo Option */

$lp_data[$key]['options'][] = 
	lp_add_option($key,"media","logo-file-id","/wp-content/uploads/landing-pages/templates/minimal-responsive/img/inboundlogo.png","Logo of site","Upload logo of site", $options=null);

/* Landing Page Intro text Option*/
$lp_data[$key]['options'][] = 
	lp_add_option($key,"textarea","page-intro-text-id","Write some compelling copy here explaining your value proposition to the visitor..<br><br>Convince them to fill out the form below.","Landing Page Intro","Write the Landing page intro", $options=null);


/* Main Hero Shot */
$lp_data[$key]['options'][] = 
	lp_add_option($key,"wysiwyg","main-hero-shot-id","<img src='/wp-content/uploads/landing-pages/templates/minimal-responsive/img/placeholder.jpg'>","Main Hero Shot","This is the main hero image or video", $options=null);

// Add Colorpicker
$lp_data[$key]['options'][] = 
  lp_add_option($key,"colorpicker","submit-button-color","11b709","Submit Button Color","Use this setting to change the template's submit button color.", $options=null); 

/* Seconday Content Area */
// Config option with the HTML defaults from the original page
$lp_data[$key]['options'][] = 
	lp_add_option($key,"wysiwyg","seconday-content-area-id",'
                        <div class="grid-4 grid"> 
                            <h4>Title 1</h4>
                            <p><b>This template is responsive!</b> It is based on the <a href="http://csswizardry.com/inuitcss/" title="The Inuit CSS Framework">Inuit-framework</a>. 
                           Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc tincidunt.</p>
                        </div>
                        
                          <div class="grid-3 grid">
                       	 <h4>Title 2</h4>
                            <p>The grid used here has a max-width of 1120 px for larger screens and 16 columns with no end or last in use to stop the flow - self-clearing!</p>
                        </div>
                        
                        <div class="grid-3 grid">
                       	 <h4>Title 3</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc tincidunt ante quis turpis fringilla ac accumsan erat aliquam. Donec diam neque, sagittis in tincidunt et, imperdiet id lorem.</p>
                        </div>
                        
                        <div class="grid-3 grid">
                        
                        <h4>Title 4</h4>
                          	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc tincidunt ante quis turpis fringilla ac accumsan erat aliquam. Donec diam neque, sagittis in tincidunt et, imperdiet id lorem.</p>     
                        </div>

                        <div class="grid-3 grid">
                        
                        <h4>Title 5</h4>
                            <p>The social icons were made by Alex Peattie, you can 
                            <a href="http://www.alexpeattie.com/blog/justvector-icons-update/" title="Icon set by Alex Peattie">
                            download the set on his website</a> and even use them as a webfont with @font-face!</p>
                        </div>',"Seconday Content Area","", $options=null);

/* Bottom Content Area */

$lp_data[$key]['options'][] = 
	lp_add_option($key,"wysiwyg","bottom-content-area-id","Bottom Content Area. Add in additional stuff here or leave this blank.","Bottom Content Area","", $options=null);

$lp_data[$key]['options'][] = 
	lp_add_option($key,"text","copy-right-text-id","Copy right text","Copy right text","oliveconcepts.com", $options=null);

// Add a textarea input field for Facebook
$lp_data[$key]['options'][] = 
  lp_add_option($key,"text","facebook-link",'http://www.facebook.com/inboundnow',"Facebook Url","Enter your Facebook url", $options=null);
  
// Add a textarea input field for Google plus
$lp_data[$key]['options'][] = 
  lp_add_option($key,"text","linkedin-link",'https://linkedin.com',"Linkedin Url","Enter your Linkedin url", $options=null);  

// Add a textarea input field for Twitter
$lp_data[$key]['options'][] = 
  lp_add_option($key,"text","twitter-link",'https://twitter.com/davidwells',"Twitter Url","Enter your Twitter url", $options=null);    

/*
$lp_data[$key]['options'][] = 
  lp_add_option($key,"colorpicker","body-background","ffffff","Body Background","Choose the Body Background Color", $options=null);

// Text Color Scheme
$lp_data[$key]['options'][] = 
  lp_add_option($key,"colorpicker","alt-text-color","888888","Text Color","Choose the other text Color", $options=null);
*/
