<?php
include_once('../config.php');
session_start();
?>
    <?php
    $q = $_GET['q'];
    $Nsupplier = $_GET['Nsupplier'];
    $Location = $_GET['Location'];
//         $Branches = $_SESSION['Branch'];
// if ($Branches == 'Shwe Pyi Thar Store') { 
//     $sql="SELECT Distinct Purchase_order_No FROM product Where SupplierName='".$Nsupplier."' and Branch = 'Shwe Pyi Thar Store'";}
// elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') { 
//     $sql="SELECT Distinct Purchase_order_No FROM product Where SupplierName='".$Nsupplier."' and Branch = 'Shwe Pyi Thar Store Control Panel'";}
// elseif ($Branches == 'Yangon Show Room') { 
//     $sql="SELECT Distinct Purchase_order_No FROM product Where SupplierName='".$Nsupplier."' and Branch = 'Yangon Show Room'";}
// elseif ($Branches == 'Mandalay Show Room') { 
//     $sql="SELECT Distinct Purchase_order_No FROM product Where SupplierName='".$Nsupplier."' and Branch = 'Mandalay Show Room'";}
// elseif ($Branches == 'Naypyidaw Show Room') { 
//     $sql="SELECT Distinct Purchase_order_No FROM product Where SupplierName='".$Nsupplier."' and Branch = 'Naypyidaw Show Room'";}
// else{ 
//     $sql="SELECT Distinct Purchase_order_No FROM product Where SupplierName='".$Nsupplier."' ";}
    $sql="SELECT Distinct Purchase_order_No FROM product Where SupplierName='".$Nsupplier."' and Branch='$Location' ";
    // echo $sql;
    $result = mysqli_query($con,$sql);

    print'<select name="PL_NO" id="PL_NO"style="width:20%;height: 30px;font-size:10px;" >';
    
    Print'<option value=""></option>';
     while($row = mysqli_fetch_array($result)) {?>
      <?php 
              $PL_NOs = $row["Purchase_order_No"];
        echo '<option value="'.$PL_NOs.'" >'.$PL_NOs.'</option>';

      ?>
    
     <?php
      }
      ?>
    </select>
