<?php
include_once('../config.php');
?>
    <?php
   // $q = $_GET['q'];
    $rowNum = $_GET['rowNum'];
    $BrandNameN = $_GET['BrandNameN'];
    $CommodityN = $_GET['CommodityN'];
    $transfer_from = $_GET['transfer_from'];
    //  $sql="SELECT id,code FROM code Where brandname='$BrandName' and commodity='$Commodity'";  
    
    $sql="SELECT DISTINCT code.id as code_id,code.code as code_no
    FROM code LEFT JOIN product ON product.code= code.id WHERE 
    product.Commodity='$CommodityN' AND product.BrandName='$BrandNameN' AND product.Branch='$transfer_from' AND product.currentQty!=0"; 

    $result = mysqli_query($con,$sql);

    print'&nbsp&nbsp<select name="code[]" id="code'.$rowNum.'"style="width:20%;height: 30px;font-size:10px;" onchange="showUsers('.$rowNum.')"  required="required">';
    
    Print'<option value=""></option>';
     while($row = mysqli_fetch_array($result)) {?>
      
      <?php 
        echo '<option value="'.$row["code_id"].'" >'.$row["code_no"].'</option>';
      ?>
    
    
     <?php
      }
      ?>
    </select>
