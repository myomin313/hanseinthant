<?php
include_once('../config.php');
session_start();
?>
    <?php
    $q = $_GET['q'];
    $rowNum = $_GET['rowNum'];
    $CommodityN = mysqli_real_escape_string($con,$_GET['CommodityN']);
    $BrandNameN = mysqli_real_escape_string($con,$_GET['BrandNameN']);
    $Branches = $_SESSION['Branch'];
    $transfer_from = $_GET['transfer_from'];
    $code = mysqli_real_escape_string($con,$_GET['code']);


    $sql="SELECT product.Purchase_order_No as PL,product.transfer_no as transfer_no
    FROM product LEFT JOIN supplier ON product.SupplierName= supplier.UserId WHERE 
    product.Commodity='$CommodityN' AND product.BrandName='$BrandNameN' AND product.Branch='$transfer_from' AND code='$code' AND product.currentQty!=0"; 
  
    $result = mysqli_query($con,$sql);

    // start myo
    
    // end myo
    print'&nbsp&nbsp<select name="NType[]" id="NType'.$rowNum.'"  style="width:4%;height:30px;font-size:10px;" required=required><option value=""></option><option value="Set">Set</option><option value="No">No</option><option value="Lot">Lot</option><option value="ft">ft</option><option value="mtrs">mtrs</option><option value="Coils">Coils</option><option value="kg">kg</option><option value="Yard">Yard</option></select>
    &nbsp&nbsp<input type="text" onblur="fncClearPl(\''.$rowNum.'\')" onkeyup="fncQuantityCheck(this)" name="NQty[]" id="NQty'.$rowNum.'" style="width:4%;height:30px;font-size:10px;" required=required>';
    
    // start
   
   $sqlt="SELECT product.transfer_no as transfer_no
   FROM product LEFT JOIN supplier ON product.SupplierName= supplier.UserId WHERE 
   product.Commodity='$CommodityN' AND product.BrandName='$BrandNameN' AND product.Branch='$transfer_from' AND code='$code' AND product.currentQty!=0"; 
   
   $resultt = mysqli_query($con,$sqlt);
   
       print'&nbsp&nbsp<select  name="Ntransfer_no[]"  id="Ntransfer_no'.$rowNum.'" style="width:10%;height:30px;background:#f2f2f2;font-size:10px;" readonly>';
   
   Print'<option value="">Transfer No</option>';
    while($rowt = mysqli_fetch_array($resultt)) {?>
     <?php 
                
                
       echo '<option value="'.htmlspecialchars($rowt["transfer_no"], ENT_QUOTES).'">'.$rowt["transfer_no"].'</option>';
   
      ?>
   
    <?php
     }
     ?>
  <?php  Print'</select>' ?>


  <?php   print'&nbsp&nbsp<select name="txtHintss[]"  onchange="fncCheckRemainStock(this,\''.$rowNum.'\')"  id="txtHintss'.$rowNum.'" style="width:10%;height:30px;background:#f2f2f2;font-size:10px;" required="required" readonly>';

    Print'<option value="">PL</option>';
     while($row = mysqli_fetch_array($result)) {?>
      <?php 
                 
                 
        echo '<option value="'.htmlspecialchars($row["PL"], ENT_QUOTES).'">'.$row["PL"].'</option>';

       ?>
    
     <?php
      }
      ?>
     
      <?php  Print'</select>' ?>

&nbsp&nbsp<input type="text" name="NRemark[]" id="NRemark<?php echo $rowNum;?>" style="width:30%;height:30px;">



