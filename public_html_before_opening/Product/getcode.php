<?php
include_once('../config.php');
?>
<?php

   mysqli_set_charset($con, 'utf8');
  $query = "
  SELECT * FROM code  
  ORDER BY code ASC
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
    'code'  => $row["code"]
   );
  }

  echo json_encode($output);
 
?>