<?php
include_once('../config.php');
$UserID=$_GET['ID']; 

$sql="DELETE FROM users WHERE UserID='$UserID'";
mysqli_query($con ,$sql);
echo"<script>alert('Successfully Deleted');</script>";
echo "<script type='text/javascript'>window.top.location='list.php?namelist=&selected=&month=&day=';</script>";exit;

?>