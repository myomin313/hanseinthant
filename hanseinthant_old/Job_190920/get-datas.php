<?php
session_start();
include_once('../config.php');

?>
    <?php
    $q = $_GET['q'];
    $rowNum = $_GET['rowNum'];
    $CommodityN = mysqli_real_escape_string($con,$_GET['CommodityN']);
    $BrandNameN = mysqli_real_escape_string($con,$_GET['BrandNameN']);
   $Branches = $_SESSION['Branch'];
    $Location = $_GET['Location'];

// if ($Branches == 'Shwe Pyi Thar Store') {            
//     $sql="SELECT Distinct Purchase_order_No FROM product Where Commodity='$CommodityN' and BrandName='$BrandNameN' and Branch='Shwe Pyi Thar Store'";
// }
// elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {            
//     $sql="SELECT Distinct Purchase_order_No FROM product Where Commodity='$CommodityN' and BrandName='$BrandNameN' and Branch='Shwe Pyi Thar Store Control Panel'";
// }
// elseif ($Branches == 'Yangon Show Room') {            
//     $sql="SELECT Distinct Purchase_order_No FROM product Where Commodity='$CommodityN' and BrandName='$BrandNameN' and Branch='Yangon Show Room'";
// }
// elseif ($Branches == 'Mandalay Show Room') {            
//     $sql="SELECT Distinct Purchase_order_No FROM product Where Commodity='$CommodityN' and BrandName='$BrandNameN' and Branch='Mandalay Show Room'";
// }
// elseif ($Branches == 'Naypyidaw Show Room') {            
//     $sql="SELECT Distinct Purchase_order_No FROM product Where Commodity='$CommodityN' and BrandName='$BrandNameN' and Branch='Naypyidaw Show Room'";
// }
// else{            
//     $sql="SELECT Distinct Purchase_order_No FROM product Where Commodity='$CommodityN' and BrandName='$BrandNameN'";
// }
$sql="SELECT Distinct Purchase_order_No FROM product Where Commodity='$CommodityN' and BrandName='$BrandNameN' and Branch='$Location'";

    $result = mysqli_query($con,$sql);
    print'&nbsp&nbsp<select name="NType[]" id="NType'.$rowNum.'"  style="width:4%;height:30px;font-size:10px;" required=required><option value=""></option><option value="Set">Set</option><option value="No">No</option><option value="Lot">Lot</option><option value="ft">ft</option><option value="mtrs">mtrs</option><option value="Coils">Coils</option><option value="kg">kg</option><option value="Yard">Yard</option></select>
    &nbsp&nbsp<input type="text"  onblur="fncClearPl(\''.$rowNum.'\')" onkeyup="fncQuantityCheck(this)" name="NWIP[]" id="NWIP'.$rowNum.'" style="width:4%;height:30px;font-size:10px;" required=required>';
    
    print'&nbsp&nbsp<select name="NPL[]" onchange="fncCheckRemainStock(this,\''.$rowNum.'\')" id="NPL'.$rowNum.'"style="width:10%;height:30px;background:#f2f2f2;font-size:10px;" required="required" readonly>';
    
    Print'<option value=""></option>';
     while($row = mysqli_fetch_array($result)) {?>
      <?php 

        echo '<option value="'.$row["Purchase_order_No"].'">'.$row["Purchase_order_No"].'</option>';

       ?>
    
     <?php
      }
      ?>
    </select>


&nbsp&nbsp<input type="text" name="NRemark[]" id="NRemark<?php echo $rowNum;?>" style="width:30%;height:30px;">



