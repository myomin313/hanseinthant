<?php
include_once('../config.php');

?>
    <?php
    $q = $_GET['q'];
    $rowNum = $_GET['rowNum'];
    $Brands = $_GET['Brand'];
    $NDO_No = $_GET['NDO_No'];
    $department = $_GET['department'];
    $okyaku = $_GET['okyaku'];
    $Brand = mysqli_real_escape_string($con,$_GET['Brand']);
    $sql="SELECT Distinct delivery.Commodity as Commodity
    FROM product 
    LEFT JOIN delivery
    ON product.Commodity = delivery.Commodity
    Where 
    delivery.BrandName='$Brand'  and delivery.DO_No = '$NDO_No' and delivery.Customer = '$okyaku' and delivery.Location = '$department' ";
    // and delivery.DO_No = '$NDO_No'
    // echo $sql;
    $result = mysqli_query($con,$sql);

    print'<select name="NCommodity[]" id="NCommodity'.$rowNum.'"style="width:20%;height: 30px;font-size:10px;" onchange="showUsers('.$rowNum.')" required="required">';
    
    Print'<option value=""></option>';
     while($row = mysqli_fetch_array($result)) {?>
      <?php 
              // $Commoditys = $row["Commodity"];
         $Commoditys = mysqli_real_escape_string($con,$row["Commodity"]);
        echo '<option value="'.htmlspecialchars($row["Commodity"], ENT_QUOTES).'" >'.$row["Commodity"].'</option>';

      ?>
    
     <?php
      }
      ?>
    </select>
