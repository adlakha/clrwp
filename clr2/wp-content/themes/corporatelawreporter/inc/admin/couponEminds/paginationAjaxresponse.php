<?php 
$data=$_POST['pageValue'];
$offsetValue=$_POST['offsetvalue'];

echo $data;
echo "<br>";
echo $offsetValue;
require_once('../../../../../../wp-load.php');

global $wpdb;
$querySelectdata = $wpdb->get_results("SELECT display_name,user_login,scratchcodeID,status,created_at,updated_at
FROM wp_users
INNER JOIN wp_eminds_scratchcode_config ON wp_eminds_scratchcode_config.userID = wp_users.ID
INNER JOIN wp_eminds_unique_scratchcode ON wp_eminds_unique_scratchcode.scratchCode = wp_eminds_scratchcode_config.scratchcodeID
WHERE wp_eminds_unique_scratchcode.status =1 LIMIT 3 OFFSET $offsetValue");
//var_dump($querySelectdata );
?>
<table border="1">
<tr>
 <th>User Name</th>
 <th>USer Email</th>
 <th>Scratch code used</th>
 <th>Status</th>
 <th>Created at</th>
 <th>Updated at</th>
</tr>

<?php

    foreach($querySelectdata as $resultvalue)   {
    ?>
    <tr>

    <td><?php echo $resultvalue->display_name;?></td>
    <td><?php echo $resultvalue->user_login;?></td>
    <td><?php echo $resultvalue->scratchcodeID;?></td>
    <td><?php echo $resultvalue->status;?></td>
    <td><?php echo $resultvalue->created_at;?></td>
    <td><?php echo $resultvalue->updated_at;?></td>
 
    </tr>
        <?php }


	
?>

</table>

