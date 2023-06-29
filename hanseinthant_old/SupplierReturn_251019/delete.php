<?php

include_once('../config.php');
session_start();

$ID=$_GET['id']; 
$BrandNames=$_GET['BrandName'];
$PL =$_GET['PL'];
$PO=$_GET['PO'];

$sql="DELETE FROM supplier_return WHERE Supplier ='$ID' and BrandName='$BrandNames' and PL='$PL' and PO='$PO'";
mysqli_query($con ,$sql);
header("location:list.php?namelist=&selected=&month=&day=");

// echo $sql;
?>