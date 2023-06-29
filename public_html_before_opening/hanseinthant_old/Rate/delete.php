<?php
include_once('../config.php');
$id=$_GET['id']; 
       $Rate_date=$_GET['Rate_date']; 

        $sqls = "SELECT DISTINCT Packing_date FROM product WHERE Packing_date ='$Rate_date'";
        $results=mysqli_query($con ,$sqls); 
        $rows = $results->fetch_assoc();
        $counts=mysqli_num_rows($results);      
        
        if($counts==1)
        {  
            echo"<script>alert('Your Date is connected to Input.Please try again!');</script>"; 
              echo "<script type='text/javascript'>window.top.location='list.php?namelist=&selected=&month=&day=';</script>";exit;
          } 
          else{
        $sql="DELETE FROM rate WHERE id='$id'";
        mysqli_query($con ,$sql);
        echo"<script>alert('Successfully Deleted');</script>";
echo "<script type='text/javascript'>window.top.location='list.php?namelist=&selected=&month=&day=';</script>";exit;              
          }




?>