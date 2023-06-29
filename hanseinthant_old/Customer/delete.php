<?php
include_once('../config.php');
$ID=$_GET['ID']; 
        $sql = "SELECT Distinct Customer FROM job WHERE Customer ='$ID'";
        // echo $sql;
        $result=mysqli_query($con ,$sql); 
        $row = $result->fetch_assoc();
       $count=mysqli_num_rows($result);
       
         $sqls = "SELECT Distinct Customer FROM delivery WHERE Customer ='$ID'";
        // echo $sql;
        $results=mysqli_query($con ,$sqls); 
        $rows = $results->fetch_assoc();
       $counts=mysqli_num_rows($results);
       
       
      if($count==1)
                  {
                   echo"<script>alert('Customer Name is connected to WIP.Please remove WIP. first!');</script>";  

                  }  
       elseif($counts==1)
                  {
                   echo"<script>alert('Customer Name is connected to Delivery.Please remove Delivery. first!');</script>";  
                  }                   
      else{
            $sql="DELETE FROM customer WHERE UserId ='$ID'";
            mysqli_query($con ,$sql);
            echo"<script>alert('Successfully Deleted');</script>";
            }
 echo "<script type='text/javascript'>window.top.location='list.php';</script>";exit;

?>