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
 $sql = "SELECT Distinct SupplierName FROM product WHERE SupplierName ='$ID'";
        // echo $sql;
        $result=mysqli_query($con ,$sql); 
        $row = $result->fetch_assoc();
       $count=mysqli_num_rows($result);
       

      if($count==1)
                  {
                   echo"<script>alert('Supplier Name is connected to Input.Please remove Input. first!');</script>";  
                   echo "<script type='text/javascript'>window.top.location='list.php';</script>";exit;
       
                  }  
             
      else{
        $sql="UPDATE supplier SET SupplierName='$Name', Address='$Address', Phone='$Phone', Emergency='$Emergency',  Email='$email',  UpdateTime='$UpdateTime',  Updator='$LUser' WHERE UserId='$ID'";
        mysqli_query($con ,$sql);
        echo"<script>alert('Successfully Updated');</script>";
        echo "<script type='text/javascript'>window.top.location='detail.php?ID=$ID';</script>";exit;
    }


}
?>