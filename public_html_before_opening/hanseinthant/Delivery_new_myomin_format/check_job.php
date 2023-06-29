<?php
include_once('../config.php');
session_start();
?>
    <?php
    $q = $_POST['q'];
    $Nokyaku = $_POST['Nokyaku'];
    $Location = $_POST['Location'];
    
        $Branches = $_SESSION['Branch'];
// if ($Branches == 'Shwe Pyi Thar Store') { 
//     $sql="SELECT Distinct Job_No FROM job Where Customer='".$Nokyaku."' and Location = 'Shwe Pyi Thar Store'";}
// elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') { 
//     $sql="SELECT Distinct Job_No FROM job Where Customer='".$Nokyaku."' and Location = 'Shwe Pyi Thar Store Control Panel'";}
// elseif ($Branches == 'Yangon Show Room') { 
//     $sql="SELECT Distinct Job_No FROM job Where Customer='".$Nokyaku."' and Location = 'Yangon Show Room'";}
// elseif ($Branches == 'Mandalay Show Room') { 
//     $sql="SELECT Distinct Job_No FROM job Where Customer='".$Nokyaku."' and Location = 'Mandalay Show Room'";}
// elseif ($Branches == 'Naypyidaw Show Room') { 
//     $sql="SELECT Distinct Job_No FROM job Where Customer='".$Nokyaku."' and Location = 'Naypyidaw Show Room'";}
// else{ 
//     $sql="SELECT Distinct Job_No FROM job Where Customer='".$Nokyaku."' ";}   
  $sql="SELECT Distinct Job_No FROM job Where Customer='".$Nokyaku."' and Location='$Location'";
        $results=mysqli_query($con ,$sql); 
        $row = $results->fetch_assoc();
        if (count($row['Job_No']) > 0 ) {
        $message = "This item have wip";
        echo "<p>$message</p>";
        }
