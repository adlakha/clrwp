<body>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
      <input type="file" name="file">
      <input type="submit" name = "csvSubmit">
   </form>
</body>



<?php

    if(isset($_POST['csvSubmit'])){
      global $wpdb;
    //  $wpdb->show_errors(); 
      $csvfile = fopen($_FILES['file']['tmp_name'],'rb');       //open csv file ,$filepath is path of the file
                while(!feof($csvfile)) {
                  $betarray[] = fgetcsv($csvfile);        //read csv file
                }
                fclose($csvfile);   
                array_pop($betarray);                      //close csv file
              //echo "<pre>"; var_dump($betarray);echo "</pre>";
?>

<table border="1">

<?php
$arrayData=array();
      foreach(array_slice($betarray,1) as $bet) // to escape column name in csv file started from 1
      {
          $scratchCode = $bet[0];
          $year = $bet[1];
          $SQLuniquecoupon = "SELECT * FROM wp_eminds_unique_scratchcode where scratchCode='$scratchCode'";
                    $arr_scratchcode_unique = $wpdb->get_results($SQLuniquecoupon);


                      if(is_array($arr_scratchcode_unique) AND count($arr_scratchcode_unique)>0)
                        {

                       $result =  $wpdb->query( 
                                  $wpdb->prepare( 
                                    "INSERT IGNORE INTO wp_eminds_unique_scratchcode
                                     (scratchCode,year) VALUES( %s,%d )",
                                     array(
                                          $scratchCode, 
                                          $year
                                          )
                                        )
                                );
                        echo count($result);
                      
/*                echo "<tr>";
                echo "<td>";
                    echo "<pre>";
                    echo ($arr_scratchcode=$arr_scratchcode_unique[0]->scratchCode);
                    echo "</pre>";
                    echo "</td>";
                echo "</tr>";
*/
                array_push($arrayData,$arr_scratchcode_unique[0]->scratchCode);
                
                  }
                  else
                  {

                    $result = $wpdb->insert( 
                      'wp_eminds_unique_scratchcode', 
                      array( 
                        'scratchCode' => $scratchCode, 
                        'year' => $year  
                      ), 
                      array( 
                        '%s', 
                        '%d' 
                      ) 
                    );
                    echo count($result);
                   // var_dump($result);
                    //echo "uploaded successfully";
                  }
             }   
             echo "</table>"; 
      test($arrayData);
          }
          function test($arrayData)
          {
         $arrlength = count($arrayData);
         if($arrlength > 0){
          echo "<table border='1'>";
          echo "<tr>";
                echo "<td>";
                
                    echo ("Error Codes");
       
                    echo "</td>";
                echo "</tr>";
          for ($i=0; $i < $arrlength; $i++) 
          { 
          
          echo "<tr>";
                echo "<td>";
                    echo "<pre>";
                    echo ($arrayData[$i]);
                    echo "</pre>";
                    echo "</td>";
                echo "</tr>";
          }
           echo "</table>";

         }
         else
         {
          echo 'File Uploaded successfully';
         }
      
     }
//$wpdb->last_error();
//$wpdb->print_error();
?>
