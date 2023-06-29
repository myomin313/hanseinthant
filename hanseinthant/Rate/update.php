<?php
include_once('../config.php');

if($_SERVER["REQUEST_METHOD"] == "POST")
{

        $id=$_POST['hidID']; 
        $Singapore=$_POST['Singapore']; 
        $Europe=$_POST['Europe']; 
        $Thailand=$_POST['Thailand']; 
        $British=$_POST['British']; 
        $Japan=$_POST['Japan']; 
        $Australia=$_POST['Australia']; 
        $Myanmar=$_POST['Myanmar'];
        $Rate_date=$_POST['Rate_date'];
        $LUser=$_POST['LUser']; 
        $UpdateTime= date("Y-m-d H:i:s"); 

        $sql = "SELECT DISTINCT Rate_date FROM rate WHERE Rate_date ='$Rate_date'";
        $result=mysqli_query($con ,$sql); 
        $row = $result->fetch_assoc();
        $count=mysqli_num_rows($result);
        
        $sqls = "SELECT DISTINCT Packing_date FROM product WHERE Packing_date ='$Rate_date'";
        $results=mysqli_query($con ,$sqls); 
        $rows = $results->fetch_assoc();
        $counts=mysqli_num_rows($results);      
        
        if($count==1)
        {  
            echo"<script>alert('Your Date is connected to Input.Please try again!');</script>"; 
              echo "<script type='text/javascript'>window.top.location='detail.php?ID=$id';</script>";exit;
          } 
        elseif($counts==1)
        {  
            echo"<script>alert('Your Date is connected to Input.Please try again!');</script>"; 
              echo "<script type='text/javascript'>window.top.location='detail.php?ID=$id';</script>";exit;
          }            
          
        else{

    	$sql="UPDATE rate SET  Singapore='$Singapore', Europe='$Europe', Thailand='$Thailand',British='$British', Japan='$Japan', Australia='$Australia', Myanmar='$Myanmar', Rate_date='$Rate_date', UpdateTime='$UpdateTime',  Updator='$LUser' WHERE id='$id'";

        mysqli_query($con ,$sql);
        echo"<script>alert('Successfully Updated');</script>"; 
              echo "<script type='text/javascript'>window.top.location='detail.php?ID=$id';</script>";exit;
       }


}


?>