<?php
include_once('../config.php');
if($_SERVER["REQUEST_METHOD"] == "POST")
{

$id=$_POST['id']; 
//$commodity=$_POST['commodity']; 
$commodity = mysqli_real_escape_string($con,$_POST['commodity']);
$LUser=$_POST['LUser']; 
$UpdateTime= date("Y-m-d H:i:s"); 

          
        $sql="UPDATE commodity SET commodity='$commodity', updated_at='$UpdateTime',  updated_by='$LUser' WHERE id='$id'";
        mysqli_query($con ,$sql);
        echo"<script>alert('Successfully Updated');</script>";
        echo "<script type='text/javascript'>window.top.location='detail.php?id=$id';</script>";exit;
          
     


}
?>