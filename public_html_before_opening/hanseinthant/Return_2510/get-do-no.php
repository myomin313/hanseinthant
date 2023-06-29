<?php
include_once('../config.php');
session_start();
?>
    <?php
    $q = $_GET['q'];
    $Nokyaku = $_GET['Nokyaku'];
    $Location = $_GET['Location'];

//         $Branches = $_SESSION['Branch'];
// if ($Branches == 'Shwe Pyi Thar Store') { 
//     $sql="SELECT Distinct DO_No FROM delivery Where Customer='".$Nokyaku."' and Location = 'Shwe Pyi Thar Store'";}
// elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') { 
//     $sql="SELECT Distinct DO_No FROM delivery Where Customer='".$Nokyaku."' and Location = 'Shwe Pyi Thar Store Control Panel'";}
// elseif ($Branches == 'Yangon Show Room') { 
//     $sql="SELECT Distinct DO_No FROM delivery Where Customer='".$Nokyaku."' and Location = 'Yangon Show Room'";}
// elseif ($Branches == 'Mandalay Show Room') { 
//     $sql="SELECT Distinct DO_No FROM delivery Where Customer='".$Nokyaku."' and Location = 'Mandalay Show Room'";}
// elseif ($Branches == 'Naypyidaw Show Room') { 
//     $sql="SELECT Distinct DO_No FROM delivery Where Customer='".$Nokyaku."' and Location = 'Naypyidaw Show Room'";}
// else{ 
//     $sql="SELECT Distinct DO_No FROM delivery Where Customer='".$Nokyaku."' ";}
    
    $sql="SELECT Distinct DO_No FROM delivery Where Customer='".$Nokyaku."' and Location = '$Location'";  
    // echo $sql; 
    $result = mysqli_query($con,$sql);

    print'<select name="DO_No" id="DO_No"style="width:20%;height: 30px;font-size:10px;" required=required>';
    
    Print'<option value=""></option>';
     while($row = mysqli_fetch_array($result)) {?>
      <?php 
              $DO_Nos = $row["DO_No"];
              $DO_No=htmlspecialchars($DO_Nos, ENT_COMPAT);
        echo '<option value="'.$DO_No.'" >'.$DO_No.'</option>';

      ?>
    
     <?php
      }
      ?>
    </select>
