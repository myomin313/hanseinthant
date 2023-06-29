<?php
include_once('../config.php');
?>
<?php

  mysqli_set_charset($con, 'utf8');
  $query = "
  SELECT * FROM commodity  
  ORDER BY commodity ASC
  ";
    $data = mysqli_query($con,$query);

  foreach($data as $row)
  {
   $output[] = array(
    'id'  => $row["id"],
    'commodity'  => $row["commodity"]
   );
  }
  
   
  echo json_encode($output);
 
?>