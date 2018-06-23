<?php
/*
 * Shortcode describe here. 
 */
 
 /* 1; 
 * Eminds jump_to shortcode
 * How to use
 * [emind_jumpto_form]
 */

 function emind_jumpto_form_callback_shortcode( $atts, $content = "" ) {
 	
	$atts = shortcode_atts( array(), $atts, 'emind_jumpto_form' );

	ob_start();
	?>
	  <form method="GET" action="<?php echo esc_url(get_bloginfo('url')) ?>"> 
                <section class="search-input jumpto">
                    <label class="fl">Jump to:</label>
                    <div class="input-group">
                      <?php 
                      $secNo= "";
                      if(is_single()){
                      //for the single page, we need to show the value i.e section number.
                    //  $secNo = get_post_meta(get_the_ID(),"enter_the_section_no_ca_post",TRUE);
					  }
                      ?>	
                    	<input type="text" value="<?php echo $secNo; ?>" name="s" class="form-control jump_section_number" placeholder="Section No.">
                        
                        <span class="input-group-btn">
                            <button class="btn btn-default jump_section_submit" type="Submit">Go</button> 
                        </span>
                    </div>
                </section>
                </form>   
	<?php
	$output = ob_get_contents();
	ob_get_clean();
	return $output;
	
}
add_shortcode( 'emind_jumpto_form', 'emind_jumpto_form_callback_shortcode' );
 
/*
 * 2: Shortcode used for jump_to and jump_from
 * How to use
 * [jump_to id=''][/jump_to]
 * [jump_from id=''][/jump_from] 
 */
 function emind_jump_to_callback_shortcode( $atts, $content = "" ) {
 	$atts = shortcode_atts( array('id'=>''), $atts, 'jump_to' );
	
	ob_start();
	$id_to = $atts['id'];
	?>
	<div id="<?php echo $id_to; ?>" ><?php echo $content; ?></div>
	<?php 
	$output = ob_get_contents();
	ob_get_clean();
	return $output;
 }
add_shortcode( 'jump_to', 'emind_jump_to_callback_shortcode' );
/*
 * How to use
 *[jump_from id=''].......content .....[/jump_from] 
 */
 function emind_jump_from_callback_shortcode( $atts, $content = "" ) {
 	$atts = shortcode_atts( array('id'=>''), $atts, 'jump_from' );
	
	ob_start();
	$id_to = $atts['id'];
	?>
	<a class="jumper" href="#<?php echo $id_to; ?>"><?php echo $content; ?></a>
	<?php 
	$output = ob_get_contents();
	ob_get_clean();
	return $output;
 }
add_shortcode( 'jump_from', 'emind_jump_from_callback_shortcode' );

/*
 *Footer notes : Pending
 * [footnotes id='12' position='down']12[/footnotes]
 * [footnotes id='12' position='up']13[/footnotes]  
 */
 function emind_footnotes_callback_shortcode( $atts, $content = "" ) {
 	$atts = shortcode_atts( array(
 	                             'id'=>'',
 	                             'position'=>''
	                         ), $atts, 'footnotes' );
	
	ob_start();
	
	$id_to="";
	$pos  ="";
	
	if(isset($atts['id']))
	$id_to = $atts['id'];
	
	if(isset($atts['position']))
	$pos   = $atts['position'];
	
	$pos   = (empty($pos))?"up":$pos;
	
	/*
	 *Functionality to pickup the text in : id and href
	 *if $pos = up then id = down : and vicevera 
	 */
	 $text = ($pos == "up")?"down":"up";
	
	?>
	
	<a id="<?php echo $text.$id_to; ?>" class="jumper" href="#<?php echo $pos.$id_to; ?>"><?php echo $content; ?></a>
	
	<?php 
	$output = ob_get_contents();
	ob_get_clean();
	return $output;
 }
add_shortcode('footnotes', 'emind_footnotes_callback_shortcode' );

/*
 * Shortcode :jumpto_section_number: jumpto section number URL 
 */
 function emind_jumpto_section_number_callback_shortcode( $atts, $content = "" ) {
 	$atts = shortcode_atts( array("num"=>''),$atts,'section' );
	
	//initialize the variables.
	$idmeta="";
	$url   ="#";
	$output ="";
	
	if(isset($atts['num'])){
	  $idmeta	= $atts['num'];
	}else{ 
	  $idmeta	= "#";	
	}
 	//get the post id of the meta value: id : meta_key=enter_the_section_no_ca_post
 	if($idmeta !="#"){
	global $wpdb;
	$sql_section_pid = "SELECT post_id FROM `".$wpdb->prefix."postmeta` WHERE meta_key='enter_the_section_no_ca_post' AND meta_value='$idmeta'";
	$arr_section_pid = $wpdb->get_row($sql_section_pid); //print_r($arr_section_pid);
	//condition to check the content.
	if(count($arr_section_pid)>0){
	$id_section_pid  = $arr_section_pid->post_id;
	$url             = get_permalink($id_section_pid);
	}
	
	} 
	ob_start();
	?>
	<a href="<?php echo $url; ?>" class="section_number"><?php echo $content; ?></a>
    <?php
	$output = ob_get_contents();
	ob_get_clean();
	return $output;
 }
 add_shortcode('section', 'emind_jumpto_section_number_callback_shortcode' );

/*
  * Shortcode for embed content on ifram
  * How to use : [iframe src="http://oodlesbit.in/clr/media/CommercialCorporatelaw.htm" width="700" height="800"]  
  */
  
  add_shortcode('iframe', 'eminds_iframe');
 
function eminds_iframe($atts, $content) {
	
 	$atts = shortcode_atts( array("height"=>'','src'=>''),$atts,'iframe' );

 // if (!$atts['width']) { $atts['width'] = 630; }
  if (!$atts['height']) { $atts['height'] = 1300; }
 $output_url = $srcfile  = $atts['src'];
 
 /*
 *Rule how it works
 * 1: First it will check the file i.e file is exists or not 
 * 2: if file is exists i.e allready added script file is exists then don't create a new file
 * 3: if file is not exists then create a new file with the script i.e Replacing the href with javascript:; .
 * 4: After replacing we will add the file name : _complete : and save on same location.
 * 5: After that we will show this file on iframe. 
 */

 //step - 1 : check file is exists or not
 
//1.1 get file name .
 $fileURL = $srcfile;//"http://localhost/clr/wp-content/uploads/2015/09/commercial-corporate-law.htm";
 /*
     * file operation,
     * 1: get filename
     * 2: get filepath after upload 
     */
$upload_dir = wp_upload_dir(); 
 
 $predefined_path =  $upload_dir['path']; // [path] => C:\path\to\wordpress\wp-content\uploads\2010\05
 $predefined_url  = $upload_dir['url'] ;//[url] => http://example.com/wp-content/uploads/2010/05
        
 
 $fileName = get_operation_fromURL($fileURL,1);
 //newfilename with URL
 $newfile_path  =$predefined_path."/excluded_href-".$fileName;
 
 if(file_exists($newfile_path)){
   //just use this newfile url : no change.
 $output_url = $predefined_url."/excluded_href-".$fileName;    
 }else{
    //create a new file and use this url
  //step -3 :
  $myfile = fopen($newfile_path, "w");
  // Open the file to get existing content
   $current = file_get_contents($fileURL);
  // Append a new person to the file
  $current .= '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
    jQuery(document).ready(function(){
       $("a").attr("href","javascript:;");
        $("a").attr("target","_self");
        $("area").attr("href","javascript:;");
        $("area").attr("target","_self");
      });
      </script>
   ';
  
 file_put_contents($newfile_path, $current,FILE_APPEND | LOCK_EX);
 $output_url = $predefined_url."/excluded_href-".$fileName;    

 }
 
 //Event expired message :start
$event_expired_msg = eminds_is_event_expire(get_the_ID());
//Event expired message :END 
 
 return $event_expired_msg.'<iframe border="0" class="shortcode_iframe" src="' . $output_url . '" height="' . $atts['height'] . '" style="width:100%;border:none;"></iframe>';
 }

/*
 *Event expired message  
 */
function eminds_is_event_expire($pid){
	
	$event_msg ="";
	$enddate   = get_post_meta($pid,"event_expire_date",TRUE);
    $currdate  = date('Ymd');
	
	/*
	 * Special condition : if event end date is not set then  : Event will never expire
	 */
	
	if(!empty($enddate)){
	if(strtotime($enddate) >= strtotime($currdate) ){
	  	 ;
	 /*
	  * When use in single.php file then show a message for registration i.e subscribe here.: Subscribe To The Event
	  */	
		 if(is_single() || is_category()){
		 			
		 $wooproduct = get_post_meta($pid,"link_woocommerce_product",TRUE);
			 		
		 $event_msg ="      
		   <div class='media-partner event-registeration'><i class='register-symbol icon'>&nbsp;</i>
	                     ".do_shortcode('[add_to_cart id='.$wooproduct.']')."
	                        </div>
	                        "; 	
		 }	
	 
	 
	 }else{
	  $event_msg ="
	                        <div class='media-partner event-expired'><i class='expired-symbol icon'>&nbsp;</i>
	                        Event has expired.
	                        </div>
	                        ";
	  }
	}
	return $event_msg;
}

	  
    /*
     * file operation,
     * 1: get filename
     * 2: get filepath after upload 
     */
    function get_operation_fromURL($url,$key=1){
        $filename_arr = explode("/",strrev($url));
        $filename     = strrev($filename_arr[0]);
        return $filename;
                
    }