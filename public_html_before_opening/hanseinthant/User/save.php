<?php 
include_once('../config.php');

if($_SERVER["REQUEST_METHOD"] == "POST")
{

$UserID=$_POST['hidUserID']; 
$UserName=$_POST['UserName']; 
$Password=$_POST['Password']; 
$Authority=$_POST['Authority']; 
$Permission=$_POST['Permission']; 
$Export=$_POST['Export']; 
$Branch=$_POST['Branch']; 
$LUser=$_POST['LUser']; 
$CreateTime= date("Y-m-d H:i:s");


$sql="INSERT INTO users (UserName, Password, Authority, Permission,Export,Branch,CreateTime,UpdateTime,Creator,Updator) VALUES ('$UserName', '$Password','$Authority' ,'$Permission','$Export','$Branch','$CreateTime','','$LUser','')";
// echo $sql;

mysqli_query($con ,$sql);
echo"<script>alert('Success');</script>";
echo "<script type='text/javascript'>window.top.location='list.php?namelist=&selected=&month=&day=';</script>";exit;

}
?>
