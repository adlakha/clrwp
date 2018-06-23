<?php 
/*
 * Functionality : Generate excel file of the order i.e group of order.
 * Excel : http://www.sitepoint.com/generate-excel-files-charts-phpexcel/
 */
 
  //$order = new WC_Order( 31150 );
  //$items = $order->get_items();
  //echo '<pre>';print_r($items);echo '</pre>';

	global $wpdb;
	@session_start();
	?>
	
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			
			jQuery('#MyDate_order_from').datepicker({
			dateFormat : 'yy-mm-dd'
			});
			
			jQuery('#MyDate_order_to').datepicker({
			dateFormat : 'yy-mm-dd'
			});
			
		});
	</script>	
	<div class="wrap">
		<div id="icon-tools" class="icon32"></div>
		 <form class="generate-excel welcome-panel" action="" method="POST" style="text-align:center;">
		  <h2>Generate order in Excel</h2>
		  <center>
		 <table> 
		   <tr class="field-group">
		    <td><label>Order From</label></td>
		    <td>:<input type="text" id="MyDate_order_from" name="MyDate_from" value=""/></td>
		   </tr>
		   
		   <tr class="field-group">
		    <td><label>Order To</label></td>
		    <td>:<input type="text" id="MyDate_order_to" name="MyDate_to" value=""/></td>
		   </tr>
		   
		    <tr class="field-group">
		     <!-- Filter Result -->
		     <?php 
		      $categories = get_terms( 'product_cat', array(
									 	'orderby'    => 'count',
									 	'hide_empty' => 0,
									 ) );
		     ?>
		     <td><label>Filter Order</label></td>
		     <td>:<select class="filter-order" name="filter_order">
		     	<option value="">All</option>
		     	<?php 
		     	if($categories){
		     		foreach($categories as $cat){
		     			?>
		     	<option value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></option>		
		     			<?php 
		     		}
		     	}
		     	?>
		     	
		     </select></td>
		   </tr>
		   
		   <tr class="field-group">
		   	<td>&nbsp;</td>  
			<td><input type="submit" name="generateExcel" value="Generate Excel"></td>
			</tr>
			
			
			
		</table>
		</center>	
		</form>	
		
	</div>
	<?php

	if(isset($_POST['generateExcel'])){
     
	 $from = $_POST['MyDate_from'];
	 $to   = $_POST['MyDate_to'];	
	 
	 $filter_order = $_POST['filter_order'];
	 
	 //clear buffer memory
	 ob_get_clean(); 
	//preparing the query string 
	$argsorder               = array();
	$argsorder['post_type']  = 'shop_order';
	$argsorder['post_status']= 'any';
//************** date query 	
	$date_query              = array();
	if($from){
	$date_query['after']	 = array(
								     'year'  => date("Y",strtotime($from)),
								     'month' => date("m",strtotime($from)),
								     'day'   => date("d",strtotime($from)),
							    );
	}
    if($to){							
	$date_query['before']	 = array(
								     'year'  => date("Y",strtotime($to)),
								     'month' => date("m",strtotime($to)),
								     'day'   => date("d",strtotime($to)),
							    );
	}
	$date_query['inclusive'] = 'TRUE' ;
//************** date query 	
//************** tax query
 if($filter_order){
 	
  $argsorder['meta_query'] = array(
 									array(
 										'key'    => 'product_category_'.$filter_order,
										'value'  => $filter_order,
										'compare'=> "=",
									),
								);
 }

	
//************** tax query  	
	
	if($from || $to){
	$argsorder['date_query']= array($date_query);	
	}
    
    	
 $argsorder['posts_per_page']= -1;
	
	//echo '<pre>';	print_r($argsorder); echo '</pre>';exit;
	
    $query12  = new WP_Query( $argsorder );
	if($query12->have_posts()):
		
	//buffer string	
	ob_start();
		?>
	<table>
    <tr>
    	<th>order#id</th>
    	<th>Order Date</th>
    	<th style="width:79px;">Item Name</th>
    	<th>Quantity</th>
    	<th style="width:500px;" >Billing Details</th>
    	<th style="width:500px;" >Shipping Details</th>
    	<th>Total Price</th>
    	<th>Status</th>
    	<th>Other</th>
    </tr>
		<?php
		while($query12->have_posts()): $query12->the_post();
		
		$orderid    = get_the_ID();
		$orderdate  = get_the_date("F d,Y");
	 
	    //order details
	    $order    = new WC_Order($orderid);
        $items    = $order->get_items();
	    $quantity = 0;
		$item_name="";
		$totoal_price = 0;
		
		$totalrow = count($items);
		
		$inc = 1;

      //billing details 
      $billing_company = get_post_meta($orderid,"_billing_company",TRUE);
      
      $billing_fname   = get_post_meta($orderid,"_billing_first_name",TRUE);
      $billing_lname   = get_post_meta($orderid,"_billing_last_name",TRUE);
	  
	  $billing_addr1   = get_post_meta($orderid,"_billing_address_1",TRUE);
	  $billing_addr2   = get_post_meta($orderid,"_billing_address_2",TRUE);
	  
	  $billing_city    = get_post_meta($orderid,"_billing_city",TRUE); //-
	  $billing_pcode   = get_post_meta($orderid,"_billing_postcode",TRUE);
	  
	  $billing_state  = get_post_meta($orderid,"_billing_state",TRUE);      
	  $billing_country= get_post_meta($orderid,"_billing_country",TRUE);		
   
      //shipping details
      $shipping_company = get_post_meta($orderid,"_shipping_company",TRUE);
      
      $shipping_fname   = get_post_meta($orderid,"_shipping_first_name",TRUE);
      $shipping_lname   = get_post_meta($orderid,"_shipping_last_name",TRUE);
	  
	  $shipping_addr1   = get_post_meta($orderid,"_shipping_address_1",TRUE);
	  $shipping_addr2   = get_post_meta($orderid,"_shipping_address_2",TRUE);
	  
	  $shipping_city    = get_post_meta($orderid,"_shipping_city",TRUE); //-
	  $shipping_pcode   = get_post_meta($orderid,"_shipping_postcode",TRUE);
	  
	  $shipping_state  = get_post_meta($orderid,"_shipping_state",TRUE);      
	  $shipping_country= get_post_meta($orderid,"_shipping_country",TRUE);		
   
     //echo '<pre>';print_r($items);echo '</pre>';exit;
		
	    if($items){
	    	foreach($items as $item){
	        $quantity     = $item['qty'];
		    $item_name    = $item['name'];
		    $totoal_price = $item['line_total'];	
		 
		 $totalrow = ($inc == 1)?"rowspan='$totalrow'":" ";
		
		
		/*
		 *Special case : As per requirement : 28th sep 2015
		 *When selected for category filter then we exclude the product id of other category in one order.
		 *i.e if any order have two product of different category then we will exclude the other category and include only filter category product. 
		 */
		 $productid   = $item['product_id'];
		 
		 $term_list = wp_get_post_terms($productid,'product_cat', array("fields" => "all"));
         $termid    = $term_list[0]->term_id;
			
		if($filter_order != $termid){
				continue;
		} 
		
		
		
		
       ?>
    <tr>
    	
    	<?php if($inc == 1){ ?>
    	<td <?php echo $totalrow; ?> ><?php echo $orderid; ?></td>
    	<td <?php echo $totalrow; ?> ><?php echo $orderdate; ?></td>
    	<?php }  ?>
    	
    	<td><?php echo $item_name; ?></td>
    	<td><?php echo $quantity; ?></td>
    	
    	<?php if($inc == 1){ ?>
    	<td>
    	<!-- billing details -->	
    		<p>
    		<?php echo $billing_company; ?><br/>	
    		<?php echo $billing_fname."&nbsp;".$billing_lname; ?><br/>
    		<?php echo $billing_addr1."&nbsp;".$billing_addr2; ?><br/>
    		<?php echo $billing_city."-&nbsp;".$billing_pcode; ?><br/>
    		<?php echo $billing_state; ?><br/>	
    		</p>
    		<!-- billing details END -->
    	</td>
    	<td><p>
    		<!-- shipping details -->
    		<?php echo $shipping_company; ?><br/>	
    		<?php echo $shipping_fname."&nbsp;".$shipping_lname; ?><br/>
    		<?php echo $shipping_addr1."&nbsp;".$shipping_addr2; ?><br/>
    		<?php echo $shipping_city."-&nbsp;".$shipping_pcode; ?><br/>
    		<?php echo $shipping_state; ?><br/>
    		<!-- shipping details -->	
    		</p></td>
    	<?php } ++$inc; ?>
    	<td><?php echo $totoal_price; ?></td>
    	<td>status</td>
    	<td>&nbsp;</td>
    </tr>   
       <?php
       
        	}
	    }
	   
       endwhile;
		?>
	</table>
		<?php
	$output = ob_get_contents();
	
	$_SESSION['xml_contents_session'] = $output;
	ob_get_clean();
    echo $output;
//	header('Location:'.get_stylesheet_directory_uri().'/inc/admin/member_Excel-download/generateExcel.php'); 
   	
   header("Location:".site_url()."/generateexcel.php");
	endif;
	wp_reset_query();
	}//submit button condition
 ?>