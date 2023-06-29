<?php

include_once('../config.php');
session_start();

$ID=$_GET['id']; 
$BrandNames=$_GET['BrandName'];
$DO_No =$_GET['DO_No'];
$JOB_No=$_GET['JOB_No'];

$sql="DELETE FROM returns WHERE Customer ='$ID' and BrandName='$BrandNames' and DO_No='$DO_No' and JOB_No='$JOB_No'";
echo $sql;

// mysqli_query($con ,$sql);
// header("location:list.php?namelist=&selected=&month=&day=");

?>