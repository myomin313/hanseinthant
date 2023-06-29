<?php
include_once('../config.php');
if($_SERVER["REQUEST_METHOD"] == "POST")
{

$id=$_POST['id']; 
$branch=$_POST['branch']; 
$short_term=$_POST['short_term'];
$LUser=$_POST['LUser']; 
$UpdateTime= date("Y-m-d H:i:s"); 

        $sql = "SELECT Distinct id FROM job WHERE Location ='$id'";
        // echo $sql;
        $result=mysqli_query($con ,$sql); 
        $row = $result->fetch_assoc();
       $count=mysqli_num_rows($result);
       
         $sqls = "SELECT Distinct id FROM delivery WHERE Location ='$id'";
        // echo $sql;
        $results=mysqli_query($con ,$sqls); 
        $rows = $results->fetch_assoc();
       $counts=mysqli_num_rows($results);
       
       
      if($count==1)
                  {
                   echo"<script>alert('Brandname  is connected to WIP.Please remove WIP. first!');</script>";  
                   echo "<script type='text/javascript'>window.top.location='list.php';</script>";exit; 
                  }  
       elseif($counts==1)
                  {
                   echo"<script>alert('Brandname  is connected to Delivery.Please remove Delivery. first!');</script>";  
                   echo "<script type='text/javascript'>window.top.location='list.php';</script>";exit; 
                  }                   
      else{   
        $sql="UPDATE branch SET branch='$branch', updated_at='$UpdateTime',  updated_by='$LUser', short_term='$short_term' WHERE id='$id'";
        mysqli_query($con ,$sql);
        echo"<script>alert('Successfully Updated');</script>";
        echo "<script type='text/javascript'>window.top.location='detail.php?id=$id';</script>";exit;
          
      }


}
?>