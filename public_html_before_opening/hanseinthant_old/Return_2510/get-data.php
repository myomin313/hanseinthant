<?php
include_once('../config.php');
session_start();
?>

    <?php
    $q =$_GET['q'];
    $rowNum = $_GET['rowNum'];
    $okyaku = $_GET['okyaku'];

    $Commodityss = mysqli_real_escape_string($con,$_GET['CommodityN']);
    $BrandNameN = mysqli_real_escape_string($con,$_GET['BrandNameN']);    
    $DO_Noss = $_GET['DO_NoN'];
    $Location = $_GET['Location'];
    $Branches = $_SESSION['Branch'];


// if ($Branches == 'Shwe Pyi Thar Store') {         
//     $sql="SELECT Distinct PL,Qty,returnQty FROM delivery Where BrandName='$BrandNameN' and Commodity ='$Commodityss' and DO_No = '$DO_Noss' and Location = 'Shwe Pyi Thar Store' and Customer = '$okyaku' ";}
// elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {         
//     $sql="SELECT Distinct PL,Qty,returnQty FROM delivery Where BrandName='$BrandNameN' and Commodity ='$Commodityss' and DO_No = '$DO_Noss' and Location = 'Shwe Pyi Thar Store Control Panel' and Customer = '$okyaku'";}
// elseif ($Branches == 'Yangon Show Room') {         
//     $sql="SELECT Distinct PL,Qty,returnQty  FROM delivery Where BrandName='$BrandNameN' and Commodity ='$Commodityss' and DO_No = '$DO_Noss' and Location = 'Yangon Show Room' and Customer = '$okyaku'";}
// elseif ($Branches == 'Mandalay Show Room') {         
//     $sql="SELECT Distinct PL,Qty,returnQty  FROM delivery Where BrandName='$BrandNameN' and Commodity ='$Commodityss' and DO_No = '$DO_Noss' and Location = 'Mandalay Show Room' and Customer = '$okyaku'";}
// elseif ($Branches == 'Naypyidaw Show Room') {         
//     $sql="SELECT Distinct PL,Qty,returnQty  FROM delivery Where BrandName='$BrandNameN' and Commodity ='$Commodityss' and DO_No = '$DO_Noss' and Location = 'Naypyidaw Show Room' and Customer = '$okyaku'";}
// else{         
//     $sql="SELECT Distinct PL,Qty,returnQty FROM delivery Where BrandName='$BrandNameN' and Commodity ='$Commodityss' and DO_No = '$DO_Noss' and Customer = '$okyaku' ";}                    
    $sql="SELECT Distinct PL,Qty,returnQty FROM delivery Where BrandName='$BrandNameN' and Commodity ='$Commodityss' and DO_No = '$DO_Noss' and Customer = '$okyaku' and Location='$Location' ";
    // echo $sql;
    $result = mysqli_query($con,$sql);    



     while($row = mysqli_fetch_array($result)) {?>
      <?php

     if ($row["Qty"] != $row["returnQty"] and $row["Qty"] > $row["returnQty"]) {
    print'&nbsp<select name="PL[]" id="PL'.$rowNum.'"style="width:10%;height:30px;font-size:10px;" required="required" ><option value=""></option>';         
     echo '<option value="'.$row["PL"].'" >'.$row["PL"].'</option> </select> ';
     
     print'&nbsp<select name="NType[]" id="NType'.$rowNum.'" style="width:4%;height:30px;"  required="required"><option value=""></option><option value="Set">Set</option><option value="No">No</option><option value="Lot">Lot</option><option value="ft">ft</option><option value="mtrs">mtrs</option><option value="Coils">Coils</option><option value="kg">kg</option></select>';

     print'&nbsp&nbspReturn: <input type="number" name="Qty[]" id="Qty'.$rowNum.'" onkeyup="calculate('.$rowNum.')" style="height:30px;width:5%;" required="required" >
     &nbspRemark: <input type="text" name="Remarks[]" id="Remarks'.$rowNum.'" style="width:30%;height:30px;">';         
     }
     
     else{
        // echo'';
     echo '<span style="color:red;">You have no return.</span>';
     }

      ?>
 
     <?php
      }
      ?> 


