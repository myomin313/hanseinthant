<?php
include_once('../config.php');
session_start();
?>
    <?php
    $q = $_GET['q'];
    $rowNum = $_GET['rowNum'];
    $JOB_Noss = $_GET['JOB_Noss'];
    $CommodityN = mysqli_real_escape_string($con,$_GET['CommodityN']);
    $BrandNameN = mysqli_real_escape_string($con,$_GET['BrandNameN']);
    $Branches = $_SESSION['Branch'];
    $Location = $_GET['Location'];
    $okyaku = $_GET['okyaku'];

// if ($Branches == 'Shwe Pyi Thar Store') {            
//     if ($JOB_Noss == '') {
//     $sql="SELECT Distinct product.Purchase_order_No as PL
//     FROM product 
//     LEFT JOIN job ON product.Commodity=job.Commodity 
//     LEFT JOIN supplier
//     ON product.SupplierName= supplier.UserId Where 
//     product.Commodity='$CommodityN' and product.BrandName='$BrandNameN' and product.Branch='Shwe Pyi Thar Store'";}
//     else{
//     $sql="SELECT Distinct job.PL as PL
//     FROM product 
//     LEFT JOIN job ON product.Commodity=job.Commodity 
//     LEFT JOIN supplier
//     ON product.SupplierName= supplier.UserId Where 
//     product.Commodity='$CommodityN' and product.BrandName='$BrandNameN' and job.Job_No='$JOB_Noss'  and product.Branch='Shwe Pyi Thar Store'";}
// }
// elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {            
//     if ($JOB_Noss == '') {
//     $sql="SELECT Distinct product.Purchase_order_No as PL
//     FROM product 
//     LEFT JOIN job ON product.Commodity=job.Commodity 
//     LEFT JOIN supplier
//     ON product.SupplierName= supplier.UserId Where 
//     product.Commodity='$CommodityN' and product.BrandName='$BrandNameN' and product.Branch='Shwe Pyi Thar Store Control Panel'";}
//     else{
//     $sql="SELECT Distinct job.PL as PL
//     FROM product 
//     LEFT JOIN job ON product.Commodity=job.Commodity 
//     LEFT JOIN supplier
//     ON product.SupplierName= supplier.UserId Where 
//     product.Commodity='$CommodityN' and product.BrandName='$BrandNameN' and job.Job_No='$JOB_Noss'  and product.Branch='Shwe Pyi Thar Store Control Panel'";}
// }
// elseif ($Branches == 'Yangon Show Room') {            
//     if ($JOB_Noss == '') {
//     $sql="SELECT Distinct product.Purchase_order_No as PL
//     FROM product 
//     LEFT JOIN job ON product.Commodity=job.Commodity 
//     LEFT JOIN supplier
//     ON product.SupplierName= supplier.UserId Where 
//     product.Commodity='$CommodityN' and product.BrandName='$BrandNameN' and product.Branch='Yangon Show Room'";}
//     else{
//     $sql="SELECT Distinct job.PL as PL
//     FROM product 
//     LEFT JOIN job ON product.Commodity=job.Commodity 
//     LEFT JOIN supplier
//     ON product.SupplierName= supplier.UserId Where 
//     product.Commodity='$CommodityN' and product.BrandName='$BrandNameN' and job.Job_No='$JOB_Noss'  and product.Branch='Yangon Show Room'";}
// }
// elseif ($Branches == 'Mandalay Show Room') {            
//     if ($JOB_Noss == '') {
//     $sql="SELECT Distinct product.Purchase_order_No as PL
//     FROM product 
//     LEFT JOIN job ON product.Commodity=job.Commodity 
//     LEFT JOIN supplier
//     ON product.SupplierName= supplier.UserId Where 
//     product.Commodity='$CommodityN' and product.BrandName='$BrandNameN' and product.Branch='Mandalay Show Room'";}
//     else{
//     $sql="SELECT Distinct job.PL as PL
//     FROM product 
//     LEFT JOIN job ON product.Commodity=job.Commodity 
//     LEFT JOIN supplier
//     ON product.SupplierName= supplier.UserId Where 
//     product.Commodity='$CommodityN' and product.BrandName='$BrandNameN' and job.Job_No='$JOB_Noss'  and product.Branch='Mandalay Show Room'";}
// }
// elseif ($Branches == 'Naypyidaw Show Room') {            
//     if ($JOB_Noss == '') {
//     $sql="SELECT Distinct product.Purchase_order_No as PL
//     FROM product 
//     LEFT JOIN job ON product.Commodity=job.Commodity 
//     LEFT JOIN supplier
//     ON product.SupplierName= supplier.UserId Where 
//     product.Commodity='$CommodityN' and product.BrandName='$BrandNameN' and product.Branch='Naypyidaw Show Room'";}
//     else{
//     $sql="SELECT Distinct job.PL as PL
//     FROM product 
//     LEFT JOIN job ON product.Commodity=job.Commodity 
//     LEFT JOIN supplier
//     ON product.SupplierName= supplier.UserId Where 
//     product.Commodity='$CommodityN' and product.BrandName='$BrandNameN' and job.Job_No='$JOB_Noss'  and product.Branch='Naypyidaw Show Room'";}
// }
// else{            
//     if ($JOB_Noss == '') {
//     $sql="SELECT Distinct product.Purchase_order_No as PL
//     FROM product 
//     LEFT JOIN job ON product.Commodity=job.Commodity 
//     LEFT JOIN supplier
//     ON product.SupplierName= supplier.UserId Where 
//     product.Commodity='$CommodityN' and product.BrandName='$BrandNameN' ";}
//     else{
//     $sql="SELECT Distinct job.PL as PL
//     FROM product 
//     LEFT JOIN job ON product.Commodity=job.Commodity 
//     LEFT JOIN supplier
//     ON product.SupplierName= supplier.UserId Where 
//     product.Commodity='$CommodityN' and product.BrandName='$BrandNameN' and job.Job_No='$JOB_Noss'  ";}
// }
if ($JOB_Noss == '') {
    $sql="SELECT Distinct product.Purchase_order_No as PL
    FROM product 
    LEFT JOIN job ON product.Commodity=job.Commodity 
    LEFT JOIN supplier
    ON product.SupplierName= supplier.UserId Where 
    product.Commodity='$CommodityN' and product.BrandName='$BrandNameN'  and Branch='$Location' and product.currentQty!=0";    
}else{
    $sql="SELECT Distinct job.PL as PL
    FROM product 
    LEFT JOIN job ON product.Commodity=job.Commodity 
    LEFT JOIN supplier
    ON product.SupplierName= supplier.UserId Where 
    product.Commodity='$CommodityN' and product.BrandName='$BrandNameN' and job.Job_No='$JOB_Noss' and Branch='$Location' and job.Customer='$okyaku' and product.currentQty!=0";}
    
    $result = mysqli_query($con,$sql);
    print'&nbsp&nbsp<select name="NType[]" id="NType'.$rowNum.'"  style="width:4%;height:30px;font-size:10px;" required=required><option value=""></option><option value="Set">Set</option><option value="No">No</option><option value="Lot">Lot</option><option value="ft">ft</option><option value="mtrs">mtrs</option><option value="Coils">Coils</option><option value="kg">kg</option><option value="Yard">Yard</option></select>
    &nbsp&nbsp<input type="text" onblur="fncClearPl(\''.$rowNum.'\')" onkeyup="fncQuantityCheck(this)" name="NQty[]" id="NQty'.$rowNum.'" style="width:4%;height:30px;font-size:10px;" required=required>';
    
    print'&nbsp&nbsp<select name="txtHintss[]" onchange="fncCheckRemainStock(this,\''.$rowNum.'\')" id="txtHintss'.$rowNum.'"style="width:10%;height:30px;background:#f2f2f2;font-size:10px;" required="required" readonly>';
    
    Print'<option value=""></option>';
     while($row = mysqli_fetch_array($result)) {?>
      <?php 

        echo '<option value="'.$row["PL"].'">'.$row["PL"].'</option>';

       ?>
    
     <?php
      }
      ?>
    </select>


&nbsp&nbsp<input type="text" name="NRemark[]" id="NRemark<?php echo $rowNum;?>" style="width:30%;height:30px;">



