<?php

      global $wpdb;
	$sql_year_data = "SELECT DISTINCT year FROM wp_eminds_unique_scratchcode;";
	$arr_year_value = $wpdb->get_results($sql_year_data);

	//var_dump($arr_year_value);
 ?>
	

<h3>Change Expiry Date</h3>
<form action="" method="POST"> 
<label>Coupon Year</label>
<select name="bulkexpiryDate" class="bulkexpiryDate" required=""> 
<option value="">Select Year to bulk update:</option>
 <?php
 foreach($arr_year_value as $resultvalue)
 {
 	?>
  <option value="<?php echo $resultvalue->year ;?>"> <?php echo $resultvalue->year ;?></option> 
   <?php
}
?>
</select>


<label>Enter the ExpiryDate</label>
<input type="date" name="expirydate" id="expirydate" placeholder="Enter Expiry Date" class="expirydate" required>

<input type="submit" value="Submit" name="expirydatebutton" id="expirydatebutton" required>
</form>
<div class="data"></div>
<script type="text/javascript">
jQuery(document).ready(function($){
	$("#expirydatebutton").click(function(e) {
		e.preventDefault();
   
        var selectedYear = $(".bulkexpiryDate").val(); 
       // if(selectedYear == "")
       //  {
       //      jQuery(".bulkexpiryDate").css('outline', 'solid 1px red'); 
       //      return false;
       //  }
       //  else
       //  {
       //  	jQuery(".bulkexpiryDate").css('outline', 'solid 1px green'); 
       //  	return true;
       //  }
        if ($('.bulkexpiryDate').val() == '') {
    $('.bulkexpiryDate').css('border-color', 'red');
    }
else 
{
    $('.bulkexpiryDate').css('border-color', '');
}

    
       var ExpiryDate= $(".expirydate").val();
        if(ExpiryDate == "")
        {
            jQuery(".expirydate").css('outline', 'solid 1px red');
            
        }
        else
        {
        	jQuery(".expirydate").css('outline', '');
           
        }
//var ExpiryDate= $(".expirydate").val();
        
       
               $.ajax({
            url: "<?php echo bloginfo('template_directory'); ?>/inc/admin/couponEminds/bulkexpiryUpdate.php",
      type: 'post',
      data: {'selectedYear': selectedYear,'ExpiryDate': ExpiryDate},
      success: function(data, status) {
      	if(data)
      	{
        $(".data").html(data);
   		 }

      },
      error: function(xhr, desc, err) {
        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
      }
    }); // end ajax call
});
});
	

</script>
