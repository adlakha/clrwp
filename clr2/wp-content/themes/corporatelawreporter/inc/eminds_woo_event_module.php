<?php
/*
 * Describe all the available options for adding the : EVENT MODULE ACTION .
 * 
 * Guess : this file is not used : 14th sep 2015
 **/
 
 
 /*
  *Describing the Table . 
  */
 function clr_event_member_records($product_id,$totalqty){
 	@session_start();
 	ob_start();
	
	//**************** member record *****
	/*
		 *List all the members address here. 
		 */
		 if($totalqty){
		 	?>
		 <tr class="member-<?php echo $product_id; ?>">
             		<th colspan="2" class="name">Member Name </th>
             		<th colspan="2" class="name">Designation</th>
             		<th class="name">Phone</th>
              	</tr>
		 	<?php
			for($i=1;$i<=$totalqty;$i++){
				
		 //update the value into the session and update here.
		     $memberkey     = 'member_name_'.$product_id."_".$i;
			 $designationkey= 'designation_'.$product_id."_".$i;
			 $phonekey      = 'phone_'.$product_id."_".$i;
			     		
			$_SESSION[$memberkey]      = empty($_POST[$memberkey]) ? $_SESSION[$memberkey]  :  $_POST[$memberkey];
			$_SESSION[$designationkey] = empty($_POST[$designationkey]) ? $_SESSION[$designationkey] : $_POST[$designationkey];
			$_SESSION[$phonekey]       = empty($_POST[$phonekey])  ? $_SESSION[$phonekey]   :  $_POST[$phonekey];	
				
             	?>
             	<tr class="member-<?php echo $product_id; ?>">
             		<td colspan="2" class="name"><input class="input-text form-control" type="text" name="<?php echo $memberkey; ?>" value="<?php echo $_SESSION[$memberkey]; ?>" /> </td>
             		<td colspan="2" class="name"><input class="input-text form-control" type="text" name="<?php echo $designationkey; ?>" value="<?php echo $_SESSION[$designationkey]; ?>" /></td>
             		<td class="name">            <input type="text" class="input-text form-control" name="<?php echo $phonekey; ?>" value="<?php echo $_SESSION[$phonekey]; ?>" /></td>
              	</tr>	
             	<?php	
             	}
		 }
 //print_r($_SESSION);
	//**************** member record *****
	$output = ob_get_contents();
	ob_get_clean();
	echo $output;
 }


/*
 *Add the data into the cart object  
 */
	add_filter('woocommerce_add_cart_item_data','wdm_add_item_data',1,2);
				if(!function_exists('wdm_add_item_data'))
				{
				    function wdm_add_item_data($cart_item_data,$product_id)
				    {
				        /*Here, We are adding item in WooCommerce session with, wdm_user_custom_data_value name*/
				        global $woocommerce;
						session_start();
						
						$_SESSION['wdm_user_custom_data'] ="shank_product";
						    
				        if (isset($_SESSION['wdm_user_custom_data'])) {
				            $option = $_SESSION['wdm_user_custom_data'];       
				            $new_value = array('wdm_user_custom_data_value' => $option);
				        }
				        if(empty($option))
				            return $cart_item_data;
				        else
				        {    
				            if(empty($cart_item_data))
				                return $new_value;
				            else
				                return array_merge($cart_item_data,$new_value);
				        }
				        unset($_SESSION['wdm_user_custom_data']); 
				        //Unset our custom session variable, as it is no longer needed.
				    }
				}?>