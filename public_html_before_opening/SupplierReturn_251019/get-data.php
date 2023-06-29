<?php
include_once('../config.php');
session_start();
?>

    <?php

    $q =$_GET['q'];
    $rowNum = $_GET['rowNum'];
    $Commodityss = mysqli_real_escape_string($con,$_GET['CommodityN']);
    $BrandNameN = mysqli_real_escape_string($con,$_GET['BrandNameN']);   
    $PL_NON = $_GET['PL_NON'];
    $Location = $_GET['Location'];
    $Branches = $_SESSION['Branch'];
// if ($Branches == 'Shwe Pyi Thar Store') {      
//     $sql="SELECT * FROM product WHERE Commodity =  '$Commodityss' AND Purchase_order_No =  '$PL_NON' AND BrandName =  '$BrandNameN' and Branch= 'Shwe Pyi Thar Store'";}
// elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {      
//     $sql="SELECT * FROM product WHERE Commodity =  '$Commodityss' AND Purchase_order_No =  '$PL_NON' AND BrandName =  '$BrandNameN' and Branch= 'Shwe Pyi Thar Store Control Panel'";}
// elseif ($Branches == 'Yangon Show Room') {      
//     $sql="SELECT * FROM product WHERE Commodity =  '$Commodityss' AND Purchase_order_No =  '$PL_NON' AND BrandName =  '$BrandNameN' and Branch= 'Yangon Show Room'";}
// elseif ($Branches == 'Mandalay Show Room') {      
//     $sql="SELECT * FROM product WHERE Commodity =  '$Commodityss' AND Purchase_order_No =  '$PL_NON' AND BrandName =  '$BrandNameN' and Branch= 'Mandalay Show Room'";}
// elseif ($Branches == 'Naypyidaw Show Room') {      
//     $sql="SELECT * FROM product WHERE Commodity =  '$Commodityss' AND Purchase_order_No =  '$PL_NON' AND BrandName =  '$BrandNameN' and Branch= 'Naypyidaw Show Room'";}
// else {      
//     $sql="SELECT * FROM product WHERE Commodity =  '$Commodityss' AND Purchase_order_No =  '$PL_NON' AND BrandName =  '$BrandNameN' ";}
   $sql="SELECT * FROM product WHERE Commodity =  '$Commodityss' AND Purchase_order_No =  '$PL_NON' AND BrandName =  '$BrandNameN' and Branch='$Location'";
    // echo $sql;

    $result = mysqli_query($con,$sql);

    print'<select name="Type[]" id="Type'.$rowNum.'"style="width:60px;height:30px;background:#f2f2f2;font-size:10px;" readonly>';
    
    Print'';
     while($row = mysqli_fetch_array($result)) {?>
    <option value="<?php echo $row["Type"]?>"><?php echo $row["Type"]?></option>
     <?php
      }
      ?>
    </select>
    
       
    <?php
if ($Branches == 'Shwe Pyi Thar Store') {      
    $sql="SELECT * FROM product WHERE Commodity =  '$Commodityss' AND Purchase_order_No =  '$PL_NON' AND BrandName =  '$BrandNameN' and Branch= 'Shwe Pyi Thar Store'";}
elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {      
    $sql="SELECT * FROM product WHERE Commodity =  '$Commodityss' AND Purchase_order_No =  '$PL_NON' AND BrandName =  '$BrandNameN' and Branch= 'Shwe Pyi Thar Store Control Panel'";}
elseif ($Branches == 'Yangon Show Room') {      
    $sql="SELECT * FROM product WHERE Commodity =  '$Commodityss' AND Purchase_order_No =  '$PL_NON' AND BrandName =  '$BrandNameN' and Branch= 'Yangon Show Room'";}
elseif ($Branches == 'SMandalay Show Room') {      
    $sql="SELECT * FROM product WHERE Commodity =  '$Commodityss' AND Purchase_order_No =  '$PL_NON' AND BrandName =  '$BrandNameN' and Branch= 'Mandalay Show Room'";}
elseif ($Branches == 'Naypyidaw Show Room') {      
    $sql="SELECT * FROM product WHERE Commodity =  '$Commodityss' AND Purchase_order_No =  '$PL_NON' AND BrandName =  '$BrandNameN' and Branch= 'Naypyidaw Show Room'";}
else {      
    $sql="SELECT * FROM product WHERE Commodity =  '$Commodityss' AND Purchase_order_No =  '$PL_NON' AND BrandName =  '$BrandNameN' ";}    
    // echo $sql;

    $result = mysqli_query($con,$sql);
    print'Input&nbsp<select  name="txtHintss[]" id="txtHintss'.$rowNum.'"  style="width:60px;height:30px;background:#f2f2f2;font-size:10px;" readonly onkeyup="calculate('.$rowNum.')">';
    
    while($row = mysqli_fetch_array($result)) {?>
    <option value="<?php echo $row["Qty"]?>"><?php echo $row["Qty"]?></option>
     <?php
      }
      ?>
    </select>
    <?php 
    print'&nbsp&nbspReturn: <input type="number" name="Qty[]" id="Qty'.$rowNum.'" onkeyup="calculate('.$rowNum.')" style="height:30px;width:5%;" required="required" >&nbspSubQty: <input type="text" name="SubQty[]" id="SubQty'.$rowNum.'" onkeyup="calculate('.$rowNum.')" style="height: 30px;width:5%;">&nbspRemark: <input type="text" name="Remarks[]" id="Remarks'.$rowNum.'" style="width:25%;height:30px;">';
?>





