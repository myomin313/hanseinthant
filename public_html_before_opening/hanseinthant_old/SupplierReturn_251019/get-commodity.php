<?php
include_once('../config.php');

?>
    <?php
    $q = $_GET['q'];
    $rowNum = $_GET['rowNum'];
    $Brand = mysqli_real_escape_string($con,$_GET['Brand']);
    $NPL_NO = $_GET['NPL_NO'];
    $Location = $_GET['Location'];
    $sql="SELECT Distinct Commodity
    FROM product     
    Where 
    BrandName='$Brand' and Purchase_order_No = '$NPL_NO' and Branch ='$Location'";
     //echo $sql;
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