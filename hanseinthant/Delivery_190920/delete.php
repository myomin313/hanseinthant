<?php

include_once('../config.php');
session_start();
$Customer =$_GET['Customer'];
$BrandNames=$_GET['BrandName'];
$DO=$_GET['DO'];
$ID=$_GET['id']; 

$sql="DELETE FROM delivery WHERE Customer ='$ID'  AND Customer='$Customer' AND DO_No='$DO'  AND BrandName='$BrandNames' ";
mysqli_query($con ,$sql);
$_SESSION['err'] = "Deleted!"; 
header("location:list.php?namelist=&selected=&month=&day=");

// echo $sql;
?>