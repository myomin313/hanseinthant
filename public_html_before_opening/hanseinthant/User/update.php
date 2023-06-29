<?php
include_once('../config.php');
if($_SERVER["REQUEST_METHOD"] == "POST")
{

$UserID=$_POST['hidUserID']; 
$UserName=$_POST['UserName']; 

if ($_POST['NewPassword'] <> ""){
	$Password=$_POST['NewPassword']; 
}else
{
	$Password=$_POST['Password']; 
}

$Authority=$_POST['Authority'];
$Permission=$_POST['Permission'];
$Export=$_POST['Export'];
$Branch=$_POST['Branch'];
$LUser=$_POST['LUser']; 
$UpdateTime= date("Y-m-d H:i:s"); 

$UPass = "";
$sqls="SELECT Password FROM users where  UserID ='$UserID'";
$results=mysqli_query($con ,$sqls);

while($row = $results->fetch_assoc()){ 

$UPass= $row['Password'];
}

	$sql="UPDATE users SET UserName='$UserName', Password='$Password', Authority='$Authority', Permission='$Permission',Export='$Export',Branch='$Branch',UpdateTime='$UpdateTime',  Updator='$LUser' WHERE UserID='$UserID'";
// echo $sql;
mysqli_query($con ,$sql);
echo"<script>alert('Successfully Updated');</script>";
 echo "<script type='text/javascript'>window.top.location='detail.php?UserID=$UserID';</script>";exit;

}
?>