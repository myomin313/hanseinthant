<?php

include_once('../config.php');
session_start();
                  if (isset($_POST['users'])) {
                    $rowCount = count($_POST['users']);
                  }
                  else{
                    $rowCount = 0;
                  }
               
                  if ($rowCount > 0) {
                    for($i=0;$i<$rowCount;$i++) {
                      $history= $_POST["users"][$i];
                      
$sql="DELETE FROM customerreturn_history WHERE id ='" . $_POST["users"][$i] . "'";

// echo $sql;
mysqli_query($con ,$sql);
header("location:list.php?namelist=&year=&month=&day=");

echo $sql;
}
}
?>