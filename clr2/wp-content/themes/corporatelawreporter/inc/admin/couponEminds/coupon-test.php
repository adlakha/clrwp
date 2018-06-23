<?php
global $wpdb;

$result = $wpdb->get_results ( "SELECT year,status,scratchCode
FROM  wp_eminds_unique_scratchcode
WHERE  status =1
" );


   
echo"<pre>";
    print_r($result);
    echo "</pre>";
    $i;
    ?>
     
     <?php
   foreach($result as $resultvalue)   {
    ?>
   
  
    


<?php echo $resultvalue->year;?>
    

    <?php }?>
    <select name=student value=''>Select Year</option>
    </select>

  