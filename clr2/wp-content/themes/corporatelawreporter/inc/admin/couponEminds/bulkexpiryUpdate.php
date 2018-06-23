<?php 
$selectedYear=$_POST['selectedYear'];
$ExpiryDate=$_POST['ExpiryDate'];

//echo $ExpiryDate;

require_once('../../../../../../wp-load.php');

 // $my_date = date('Y-m-d', strtotime($ExpiryDate));
 // echo $my_date;

if(($selectedYear) && ($ExpiryDate))
{
	global $wpdb;
	$sql_expiry_year_bulk_update =	"SELECT * 
FROM wp_eminds_unique_scratchcode
WHERE year = '".$selectedYear."'";


	$arr_expiry_dateupdate_result = $wpdb->get_results($sql_expiry_year_bulk_update);
	//print_r($arr_scratchcode_validate);
	
     $yearMatched = $arr_expiry_dateupdate_result[0]->year;
   
$nowtime = current_time('mysql', false);
     $dataValue =	$wpdb->update( 
	'wp_eminds_unique_scratchcode', 
	array( 
			// integer (number) 
		//'updated_at' => 	'2016-10-01 07:10:00'
		'ExpiryDate' => 	 $ExpiryDate
		//'Expirymodifiedstatus' => 1
	), 
	array( 'year' =>  $yearMatched ), 
	array( 
		'%s'	// value2
		
	), 
	array( '%s' ) 
);
   // print_r($dataValue);
if($dataValue && $dataValue !=0)
{
 //$wpdb->print_error(); 
 echo "<p>Expiry Date Updated</p>";
}
else
{
echo "<p>Expiry Date Not Updated</p>";
 }
}
else
{
	echo "<p>Values are not entered</p>";
}
 ?>
 