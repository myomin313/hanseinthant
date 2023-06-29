<?php
include_once('../config.php');
?>
<?php


  $query = "
  SELECT * FROM commodity  
  ORDER BY commodity ASC
  ";
    $data = mysqli_query($con,$query);

  // $statement = $con->prepare($query);
  // echo $statement->execute();exit();
  // $statement->execute();
  // $data = $statement->fetchAll();
  foreach($data as $row)
  {
   $output[] = array(
    'id'  => $row["id"],
    'commodity'  => $row["commodity"]
   );
  }
  echo json_encode($output);
 
?>