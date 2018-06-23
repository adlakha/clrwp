<?php
/*
 *Newsletter setting file
 */
 
 //saving all the values as well as initialize the previous values.
 if(isset($_POST['newsletter_save_stg'])){
 	
$mainheading      = $_POST['main_heading'];
$headertext1      = stripslashes($_POST['headertext1']);
//$headertext2      = stripslashes($_POST['headertext2']);	 	
/*$footermainheading= stripslashes($_POST['footermainheading']);
$footerfocustext  = stripslashes($_POST['footerfocustext']);

$footertext1      = stripslashes($_POST['footertext1']);
$footerlink1      = stripslashes($_POST['footerlink1']);
$footerdesc1      = stripslashes($_POST['footerdesc1']);
				
$footertext2      = stripslashes($_POST['footertext2']);
$footerlink2      = stripslashes($_POST['footerlink2']);
$footerdesc2      = stripslashes($_POST['footerdesc2']);

$otherlinkheading = stripslashes($_POST['otherlinkheading']);
$subscribe_link   = stripslashes($_POST['subscribe_our_update_link']);

$facebook         = stripslashes($_POST['facebook']);
$twitter          = stripslashes($_POST['twitter']);
$linkedin         = stripslashes($_POST['linkedin']);
$gplus            = stripslashes($_POST['gplus']);
$feedbacklink     = stripslashes($_POST['feedbacklink']);

$whatsup_title    = stripslashes($_POST['whatsup_title']);
$whatsup_text     = stripslashes($_POST['whatsup_text']);
$query_title      = stripslashes($_POST['query_title']);
$query_text       = stripslashes($_POST['query_text']);
$job_title        = stripslashes($_POST['job_title']);
$job_text         = stripslashes($_POST['job_text']);

$thanks_signature = stripslashes($_POST['thanks_signature']); */
$disclaimer       = stripslashes($_POST['disclaimer_newsletter']);
$poweredby        = stripslashes($_POST['poweredby']);
$email_lastlink   = stripslashes($_POST['email_lastlink']);
$address_infooter = stripslashes($_POST['address_infooter']);

//update all the values 
update_option("newsletter_main_heading",$mainheading);
update_option("newsletter_headertext1" ,$headertext1);
//update_option("newsletter_headertext2" ,$headertext2);
/*update_option("newsletter_footermainheading",$footermainheading);
update_option("newsletter_footerfocustext",$footerfocustext);

update_option("newsletter_footertext1",$footertext1);
update_option('newsletter_footerlink1',$footerlink1);
update_option('newsletter_footerdesc1',$footerdesc1);

update_option("newsletter_footertext2",$footertext2);
update_option('newsletter_footerlink2',$footerlink2);
update_option('newsletter_footerdesc2',$footerdesc2);

update_option("newsletter_otherlinkheading",$otherlinkheading);
update_option("newsletter_subscribe_link",$subscribe_link);
update_option("newsletter_facebook",$facebook);
update_option("newsletter_linkedin",$linkedin);
update_option("newsletter_twitter",$twitter);
update_option("newsletter_gplus",$gplus);
update_option("newsletter_feedbacklink",$feedbacklink);

update_option("newsletter_whatsup_title",$whatsup_title);
update_option("newsletter_whatsup_text",$whatsup_text);
update_option("newsletter_query_title",$query_title);
update_option("newsletter_query_text",$query_text);

update_option("newsletter_job_title",$job_title);
update_option("newsletter_job_text",$job_text);
update_option("newsletter_thanks_signature",$thanks_signature); */
update_option("newsletter_disclaimer",$disclaimer);
update_option("newsletter_poweredby",$poweredby);
update_option("newsletter_email_lastlink",$email_lastlink);
update_option("newsletter_address_infooter",$address_infooter);
//redirect
//$url = admin_url('admin.php?page=newsletter_settings');
//wp_redirect( $url ); exit;
//********************************* END************	
 }
 
?>

<div class="wrap">

	<div id="icon-tools" class="icon32"></div>

	<h2>Email Setting here </h2><a target="_blank" href="<?php echo get_stylesheet_directory_uri(); ?>/inc/admin/newsletter/setting-demo.png" title="Setting demo">Download setting demo</a>

<form method="POST" action="<?php echo admin_url('admin.php?page=newsletter_settings'); ?>">
	<table class="form-table">
		<tbody>
			
			<tr>
				<th scope="row">
					<label for="main_heading">Main Heading </label><br/>
					<small>It will display besides the logo.</small>
				</th>
				<td>
				<?php 
				//initalize default value
				$main_heading = get_option('newsletter_main_heading');
				if(empty($main_heading)){
				$main_heading = "http://www.emindslegal.com : Daily Updates & News";	
				}
				?>	
				<textarea class="regular-text" cols="50" rows="5"  id="main_heading" name="main_heading"><?php echo $main_heading; ?></textarea>
				</td>
			</tr>
			
			<tr>
				<th scope="row"><label for="headertext1">Header Text</label></th>
				<td>
				<?php 
				//initalize default value
				$headettext1 = get_option('newsletter_headertext1');
				if(empty($headettext1)){
				$headettext1 = 'Visit our website <a href="http://www.emindslegal.com">www.emindslegal.com</a>';	
				}
				?>		
				<textarea cols="50" rows="5" id="headertext1" name="headertext1" ><?php echo $headettext1; ?></textarea>
				</td>
			</tr>
			
			<!-- <tr>
				<th scope="row"><label for="headertext2">Header Text2</label></th>
				<td>
				<?php 
				//initalize default value
				$headettext2 = get_option('newsletter_headertext2');
				if(empty($headettext2)){
				$headettext2 = 'Subscribe our updates on tax/law:<a href="#">Click here</a>';	
				}
				?>			
				<textarea rows="5" cols="50" id="headertext2" name="headertext2" ><?php echo $headettext2; ?></textarea>
				</td>
			</tr> -->
			
		<!--	<tr>
				<th scope="row"><label for="footermainheading">Footer main heading</label></th>
				<td>
				<?php 
				//initalize default value
				$footmain1 = get_option('newsletter_footermainheading');
				if(empty($footmain1)){
				$footmain1 = 'Impanmelment';	
				}
				?>
				
				<input type="text" class="regular-text" value="<?php echo $footmain1; ?>" id="footermainheading" name="footermainheading" />
				</td>
			</tr>
			
			<tr>
				<th scope="row"><label for="footerfocustext">Footer Focus text</label></th>
				<td>
				<?php 
				//initalize default value
				$footerfocus = get_option('newsletter_footerfocustext');
				if(empty($footerfocus)){
				$footerfocus = 'New:';	
				}
				?>	
				<input type="text" class="regular-text" value="<?php echo $footerfocus; ?>" id="footerfocustext" name="footerfocustext" />
				</td>
			</tr>
			
			
			<tr>
				<th scope="row"><label for="footertext1">Footer Text 1</label></th>
				<td>
				<?php 
				//initalize default value
				$footertext1 = get_option('newsletter_footertext1');
				if(empty($footertext1)){
				$footertext1 = 'Dummy Company';	
				}
				//other two 
				$footerlink1 = get_option('newsletter_footerlink1');
			    
			    if(empty($footerlink1)){
				$footerlink1 = '#';	
				}
						
				$footerdesc1 = get_option('newsletter_footerdesc1');
				
				if(empty($footerdesc1)){
				$footerdesc1 = 'Concurrent Audit : Last Date : 15 Jul 2015 09:09 PM PDT';	
				}
				?>		
				<label>Text 1</label>
				<input type="text" class="regular-text" value="<?php echo $footertext1; ?>" id="footertext1" name="footertext1" />
			    <br/>
				<label>Link 1</label>
				<input type="text" class="regular-text" value="<?php echo $footerlink1; ?>" id="footerlink1" name="footerlink1" />
			    <br/>
				<label>Desc.</label>
				<input type="text" class="regular-text" value="<?php echo $footerdesc1; ?>" id="footerdesc1" name="footerdesc1" />
			
				</td>
			</tr>
			
			<tr>
				<th scope="row"><label for="footertext2">Footer Text2</label></th>
				<td>
				<?php 
				//initalize default value
				$footertext2 = get_option('newsletter_footertext2');
				if(empty($footertext2)){
				$footertext2 = 'Dummy Company';	
				}
				//other two 
				$footerlink2 = get_option('newsletter_footerlink2');
			    
			    if(empty($footerlink2)){
				$footerlink2 = '#';	
				}
						
				$footerdesc2 = get_option('newsletter_footerdesc2');
				
				if(empty($footerdesc2)){
				$footerdesc2 = 'Concurrent Audit : Last Date : 15 Jul 2015 09:09 PM PDT';	
				}
				?>			
				<label>Text 2</label>	
				<input type="text" class="regular-text" value="<?php echo $footertext2; ?>" id="footertext2" name="footertext2" />
				<br/>
				<label>Link 2</label>	
				<input type="text" class="regular-text" value="<?php echo $footerlink2; ?>" id="footerlink2" name="footerlink2" />
				<br/>
				<label>Desc</label>	
				<input type="text" class="regular-text" value="<?php echo $footerdesc2; ?>" id="footerdesc2" name="footerdesc2" />
				
				</td>
			</tr>
			<hr/>
			<tr>
				<th scope="row"><label for="otherlinkheading">Other links heading</label></th>
				<td>
			   <?php 
				//initalize default value
				$other = get_option('newsletter_otherlinkheading');
				if(empty($other)){
				$other = 'OTHER LINKS (CLICK TO FOLLOW):';	
				}
				?>	
				<input type="text" class="regular-text" value="<?php echo $other; ?>" id="otherlinkheading" name="otherlinkheading" />
				</td>
			</tr>
			
			<tr>
				<th scope="row"><label for="subscribe_our_update_link">Subscribe our updates link</label></th>
				<td>
				<?php 
				//initalize default value
				$subscriberlink = get_option('newsletter_subscribe_link');
				if(empty($subscriberlink)){
				$other = '#';	
				}
				?>	
				<input type="text" class="regular-text" value="<?php echo $subscriberlink; ?>" id="subscribe_our_update_link" name="subscribe_our_update_link" />
				</td>
			</tr>
			
			
			<tr>
				<th>Social Link</th>
				<td>
				<?php 
				//initalize default value
				$facebook = get_option('newsletter_facebook');
				$twitter  = get_option('newsletter_twitter');
				$gplus    = get_option('newsletter_gplus');
				$linkedin = get_option('newsletter_linkedin');
				
				if(empty($facebook)){
				$facebook = '#';	
				}
				if(empty($twitter)){
				$twitter = '#';	
				}
				if(empty($gplus)){
				$gplus = '#';	
				}
				if(empty($linkedin)){
				$linkedin = '#';	
				}
				
				?>	
				<label for="facebook">Facebook</label>
				<input type="text" class="regular-text" value="<?php echo $facebook; ?>" id="facebook" name="facebook" />
				<br/>
				<label for="twitter">Twitter &nbsp;&nbsp;  </label>
				<input type="text" class="regular-text" value="<?php echo $twitter; ?>" id="twitter" name="twitter" />
				<br/>
				<label for="gplus">Gplus &nbsp;&nbsp;&nbsp;</label>
				<input type="text" class="regular-text" value="<?php echo $gplus; ?>" id="gplus" name="gplus" />
				<br/>
				<label for="linkedin">Linkedin  </label>
				<input type="text" class="regular-text" value="<?php echo $linkedin; ?>" id="linkedin" name="linkedin" />
				<br/>
				
				</td>
			</tr>
			
			<tr>
				<th scope="row"><label for="feedbacklink">Provide us feedback link</label></th>
				<td>
				<?php 
				//initalize default value
				$feedbacklink = get_option('newsletter_feedbacklink');
				if(empty($feedbacklink)){
				$feedbacklink = '#';	
				}
				
				?>	
				<input type="text" class="regular-text" value="<?php echo $feedbacklink; ?>" id="feedbacklink" name="feedbacklink" />
				</td>
			</tr>
			
			<tr>
				<th>Contact with</th>
				<td>
				<?php 
				//initalize default value
				$whatsup_title = get_option('newsletter_whatsup_title');
				$whatsup_text  = get_option('newsletter_whatsup_text');
				$query_title   = get_option('newsletter_query_title');
				$query_text    = get_option('newsletter_query_text');
				$job_title     = get_option('newsletter_job_title');
				$job_text      = get_option('newsletter_job_text');
				$feedbacklink = get_option('newsletter_feedbacklink');
				$feedbacklink = get_option('newsletter_feedbacklink');
				
				if(empty($whatsup_title)){
				$whatsup_title = 'WHATS APP:';	
				}
				if(empty($whatsup_text)){
				$whatsup_text = 'Now get instant updates (in brief) on whats app. To subscribe, message us at +91-9999999999 (number will not be made public).';	
				}
				if(empty($query_title)){
				$query_title = 'QUERY:';	
				}
				if(empty($query_text)){
				$query_text = 'For any query regarding updates or tax/law, do mail us at <a href="mailto:email@email.com">email@email.com</a> ';	
				}
				if(empty($job_title)){
				$job_title = 'ARTICLES/JOB & ARTICLES VACANCIES/ EDITOR:';	
				}
				if(empty($job_text)){
				$job_text = 'mail us at <a href="mailto:email@email.com">email@email.com</a>';	
				}
				
				?>		
					
				<label for="whatsup_title">Whatsup Title</label>
				<input type="text" class="regular-text" value="<?php echo $whatsup_title; ?>" id="whatsup_title" name="whatsup_title" />
				<br/>
				<label for="whatsup_text">Whatsup Text </label>
				<input type="text" class="regular-text" value="<?php echo $whatsup_text; ?>" id="whatsup_text" name="whatsup_text" />
				<br/>
				<label for="query_title">Query Title</label>
				<input type="text" class="regular-text" value="<?php echo $query_title; ?>" id="query_title" name="query_title" />
				<br/>
				<label for="query_text">Query Text  </label>
				<textarea rows="2" cols="50" id="query_text" name="query_text"><?php echo $query_text; ?></textarea>
				<br/>
			
				<label for="job_title">Job Title</label>
				<input type="text" class="regular-text" value="<?php echo $job_title; ?>" id="job_title" name="job_title" />
				<br/>
				<label for="job_text">Job Text  </label>
				<textarea rows="2" cols="50" id="job_text" name="job_text" ><?php echo $job_text; ?></textarea>
				<br/>
				</td>
			</tr>
			
			<tr>
				<th scope="row"><label for="thanks_signature">Thanks Signature</label></th>
				<td>
			<?php 
			$thanksignature = get_option('newsletter_thanks_signature');
			if(empty($thanksignature)){
			$thanksignature ="<span>Thanks & Regards</span><br><span>Team</span><br><span>Information Department</span><br>
                             <a style='font-weight: bold' href='http://www.emindslegal.com'>www.emindslegal.com </a><br>";
			}		
					?>
				<textarea rows="10" cols="39"  id="thanks_signature" name="thanks_signature" ><?php echo $thanksignature; ?></textarea>
				</td>
			</tr>
		-->
			<tr>
				<th scope="row"><label for="thanks_signature">Footer Text </label></th>
				<td>
         	<?php
         	   $disclaimer_text  = get_option('newsletter_disclaimer');
         	  
			   if(empty($disclaimer_text)){
	 			$disclaimer_text ="Disclaimer: This e-mail is confidential and for the purpose of knowledge 
						 			sharing among the professionals and shall not be treated as solicitation in any manner or 
						 			for any other purpose whatsoever. It may also be legally privileged. If you are not the addressee you may not copy,
						 			 forward, disclose or use any part of it. If you have received this message in error, please delete it and all copies 
						 			 from your system and notify the sender immediately by return e-mail. Internet communications cannot be guaranteed to be timely, 
						 			 secure, error or virus-free. The sender does not accept liability for any errors or omissions. You are kindly requested to verify
						 			  & confirm the updates from the genuine sources before acting on any of the information's provided here above. Thanks."
									;
			   }
			   			
                $editor_id = 'disclaimer_newsletter';
			
                wp_editor( $disclaimer_text, $editor_id );
                 ?>
				</td>
			</tr>
	<!--		
			<tr>
			<?php 
			//initialize the default 
			$poweredby = get_option('newsletter_poweredby');
			if(empty($poweredby)){
			$poweredby = "Email delivery powered by Google";	
			}
			?>	
				<th scope="row"><label for="poweredby">Powered By</label></th>
				<td>
				<input type="text" class="regular-text" value="<?php echo $poweredby; ?>" id="poweredby" name="poweredby" />
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="email_lastlink">Email Last Link</label></th>
				<td>
				<?php 
				//initialize the default 
				$lastlink  = get_option('newsletter_email_lastlink');
				if(empty($lastlink)){
				$lastlink = "
				            <span>
							You are subscribed to email updates from
							<a href='#'>www.emindslegal.com </a>
							</span>
							<br>
							<span>
							To stop receiving these emails, you may
							<a href='#'>unsubscribe now. </a>
							</span>
				             ";	
				}
				?>		
				<textarea rows="10" cols="100"  id="email_lastlink" name="email_lastlink" ><?php echo $lastlink; ?></textarea>
				</td>
			</tr>
				
			<tr>
				<th scope="row"><label for="address_infooter">Address in footer</label></th>
				<td>
			<?php 
			//initialize the default
			$add = get_option('newsletter_address_infooter');
			if(empty($add)){
			$add  = "Google Inc., 1600 Amphitheatre Parkway, Mountain View, CA 94043, United States";	
			}		
			?>
				<input type="text" class="regular-text" value="<?php echo $add; ?>" id="address_infooter" name="address_infooter" />
				</td>
			</tr> -->
			<tr>
				<th>&nbsp;</th>
				<td><input type="submit" class="button button-primary" value="Save Settings" name="newsletter_save_stg" /></td>
			</tr>
		</tbody>
		
		</form>
	</table>
</div>