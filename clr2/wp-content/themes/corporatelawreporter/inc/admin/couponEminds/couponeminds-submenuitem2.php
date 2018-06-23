<style>
    .anchorvalue.active
    {
        color: black;
        font-weight: 700;
    }
    .anchorvalue
    {
        margin-left: 5px;
        text-decoration: none;
    }
</style>

<div class="data">
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
  $coupon_per_page = 3;
  $offset = 0;
    global $wpdb;
    $total_no_of_coupons = $wpdb->get_results ( "SELECT COUNT(*) count
FROM wp_users
INNER JOIN wp_eminds_scratchcode_config ON wp_eminds_scratchcode_config.userID = wp_users.ID
INNER JOIN wp_eminds_unique_scratchcode ON wp_eminds_unique_scratchcode.scratchCode = wp_eminds_scratchcode_config.scratchcodeID
WHERE wp_eminds_unique_scratchcode.status =1" );

//print_r( $total_no_of_coupons);
   $totalData = $total_no_of_coupons[0]->count;

$num_of_pages = $totalData / $coupon_per_page ;

    $result = $wpdb->get_results ( "SELECT display_name,user_login,scratchcodeID,status,created_at,updated_at
FROM wp_users
INNER JOIN wp_eminds_scratchcode_config ON wp_eminds_scratchcode_config.userID = wp_users.ID
INNER JOIN wp_eminds_unique_scratchcode ON wp_eminds_unique_scratchcode.scratchCode = wp_eminds_scratchcode_config.scratchcodeID
WHERE wp_eminds_unique_scratchcode.status =1 LIMIT  $coupon_per_page OFFSET $offset" );
?>
<?php
    
    foreach($result as $resultvalue)   {
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

<a href="" class='anchorvalue'>Previous</a>

<?php 
        $i;
      for( $i=1 ; $i<= $num_of_pages;$i++)
      {?>

        <a href='' class='anchorvalue <?php if($i==1) echo"active";?>' ><?php echo $i; ?></a>
       <?php
      }
 
?>
<a href="" class='anchorvalue'>Next</a>
</div>
<script>

      
    
    jQuery(document).ready(function($){
    $('.anchorvalue').click(function(e){
        e.preventDefault();
   
   var pageValue=$(this).html();
    unusualPageValue = 0;
        nextPageValue = 0;
   //alert(pageValue);
   if(pageValue=="Next")
   {
       unusualPageValue = 1;
       pageValue = $(".anchorvalue.active").next().html();
       $(".anchorvalue.active").next().addClass("nextEl");
       $(".anchorvalue.active").next().addClass("active");
       $(".anchorvalue.nextEl").prev().removeClass("active");
         $(".anchorvalue.active").removeClass("nextEl");
   }

   //alert(pageValue);
   if(pageValue && unusualPageValue != 1)
   {
    $(".anchorvalue").removeClass("active");
    $(this).addClass("active");

   }
   var couponperpage = "<?php echo $coupon_per_page;?>";
  
var offsetvalue=(((pageValue-1)*couponperpage));

      $.ajax({
            url: "<?php echo bloginfo('template_directory'); ?>/inc/admin/couponEminds/paginationAjaxresponse.php",
      type: 'post',
      data: {'pageValue': +pageValue,'offsetvalue': +offsetvalue},
      success: function(data, status) {
        
        $(".data").html(data);
        if(data == "ok") {
           // alert(data);
          
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

<table border="1">
<tr>
 <th>User Name</th>
 <th>USer Email</th>
 <th>Scratch code used</th>
 <th>Status</th>
 <th>Created at</th>
 <th>Updated at</th>
</tr><?php
$result = $wpdb->get_results ( "SELECT display_name,user_login,scratchcodeID,status,created_at,updated_at
FROM wp_users
INNER JOIN wp_eminds_scratchcode_config ON wp_eminds_scratchcode_config.userID = wp_users.ID
INNER JOIN wp_eminds_unique_scratchcode ON wp_eminds_unique_scratchcode.scratchCode = wp_eminds_scratchcode_config.scratchcodeID
WHERE wp_eminds_unique_scratchcode.status =1 " );
   
echo"<pre>";
  //  print_r($result);
    echo "</pre>";
    $i;
    foreach($result as $resultvalue)   {
    ?>
    <tr>

    <td><?php echo $resultvalue->display_name;?></td>
    <td><?php echo $resultvalue->user_login;?></td>
    <td><?php echo $resultvalue->scratchcodeID;?></td>
    <td><?php echo $resultvalue->status;?></td>
    <td><?php echo $resultvalue->created_at;?></td>
    <td><?php echo $resultvalue->updated_at;?></td>
 
    </tr>
    <?php }?>
    </table>