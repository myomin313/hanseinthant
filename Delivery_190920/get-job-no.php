<?php
include_once('../config.php');
session_start();
?>
    <?php
    $q = $_GET['q'];
    $Nokyaku = $_GET['Nokyaku'];
    $Location = $_GET['Location'];
    
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
    $result = mysqli_query($con,$sql);
    print'<select name="JOB_No" id="JOB_No"style="width:20%;height: 30px;font-size:10px;" >';
    
    Print'<option value=""></option>';
     while($row = mysqli_fetch_array($result)) {?>
      <?php 
              $Job_Nos = $row["Job_No"];
              $Job_No=htmlspecialchars($Job_Nos, ENT_COMPAT);
        echo '<option value="'.$Job_No.'" >'.$Job_No.'</option>';

      ?>
    
     <?php
      }
      ?>
    </select>
