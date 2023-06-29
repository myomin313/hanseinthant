<?php 
include_once('../config.php');

if($_SERVER["REQUEST_METHOD"] == "POST")
{
        $Singapore=$_POST['Singapore']; 
        $Europe=$_POST['Europe']; 
        $Thailand=$_POST['Thailand']; 
        $British=$_POST['British']; 
        $Japan=$_POST['Japan']; 
        $Australia=$_POST['Australia']; 
        $Myanmar=$_POST['Myanmar'];
        $Rate_date=$_POST['Rate_date'];
        $LUser=$_POST['LUser']; 
        $CreateTime= date("Y-m-d H:i:s");
        
        $sql = "SELECT DISTINCT Rate_date FROM rate WHERE Rate_date ='$Rate_date'";
        $result=mysqli_query($con ,$sql); 
        $row = $result->fetch_assoc();
        $count=mysqli_num_rows($result);
        if($count==1)
        {  
            echo"<script>alert('Your Date already exist.Please try again!');</script>";    
          }  
        else{ 
        $sql="INSERT INTO rate (Singapore,Europe,Thailand,British,Japan,Australia,Myanmar,Rate_date,CreateTime,UpdateTime,Creator,Updator) VALUES ('$Singapore','$Europe' ,'$Thailand','$British','$Japan' ,'$Australia', '$Myanmar','$Rate_date','$CreateTime','','$LUser','')";
        mysqli_query($con ,$sql);
        echo"<script>alert('Success');</script>";       
        }
         echo "<script type='text/javascript'>window.top.location='list.php?namelist=&selected=&month=&day=';</script>";exit;
} 
?>
