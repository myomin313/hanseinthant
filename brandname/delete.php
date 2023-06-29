<?php
include_once('../config.php');

$ID=$_GET['ID']; 
 $sql = "SELECT Distinct BrandName FROM product WHERE BrandName ='$ID'";
        // echo $sql;
        $result=mysqli_query($con ,$sql); 
        $row = $result->fetch_assoc();
       $count=mysqli_num_rows($result);
       

      if($count==1)
                  {
                   echo"<script>alert('BrandName is connected to Input.Please remove Input. first!');</script>";  
       
                  }  
             
      else{
        $sql="DELETE FROM brandname WHERE id ='$ID'";
        mysqli_query($con ,$sql);
        echo"<script>alert('Successfully Deleted');</script>";
          }
 echo "<script type='text/javascript'>window.top.location='list.php?';</script>";exit;
?>