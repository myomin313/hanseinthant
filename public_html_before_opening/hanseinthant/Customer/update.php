<?php
include_once('../config.php');
if($_SERVER["REQUEST_METHOD"] == "POST")
{

$ID=$_POST['hidID']; 
$Name=$_POST['Name']; 
$Address=$_POST['Address']; 
$Phone=$_POST['Phone']; 
$Emergency=$_POST['Emergency']; 
$email=$_POST['email']; 
$LUser=$_POST['LUser']; 
$UpdateTime= date("Y-m-d H:i:s"); 

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
                   echo "<script type='text/javascript'>window.top.location='list.php';</script>";exit; 
                  }  
       elseif($counts==1)
                  {
                   echo"<script>alert('Customer Name is connected to Delivery.Please remove Delivery. first!');</script>";  
                   echo "<script type='text/javascript'>window.top.location='list.php';</script>";exit; 
                  }                   
      else{   
        $sql="UPDATE customer SET CustomerName='$Name', Address='$Address', Phone='$Phone', Emergency='$Emergency',  Email='$email',  UpdateTime='$UpdateTime',  Updator='$LUser' WHERE UserId='$ID'";
        mysqli_query($con ,$sql);
        echo"<script>alert('Successfully Updated');</script>";
        echo "<script type='text/javascript'>window.top.location='detail.php?ID=$ID';</script>";exit;
          
      }


}
?>