<?php
include_once('../config.php');

?>
    <?php
     mysqli_set_charset($con, 'utf8');
    $q = $_GET['q'];
    $rowNum = $_GET['rowNum'];
    $Brand = mysqli_real_escape_string($con,$_GET['Brand']);
    $NPL_NO = $_GET['NPL_NO'];
    $Location = $_GET['Location'];
    $sql="SELECT Distinct p.Commodity AS cid,c.commodity AS Commodity FROM product p LEFT JOIN commodity c ON p.Commodity= c.id    
    Where 
    BrandName='$Brand' and Purchase_order_No = '$NPL_NO' and Branch ='$Location'";
     //echo $sql;
    $result = mysqli_query($con,$sql);

    print'<select name="NCommodity[]" id="NCommodity'.$rowNum.'"style="width:20%;height: 30px;font-size:10px;" onchange="showUsers('.$rowNum.')" required="required">';
    
    Print'<option value=""></option>';
     while($row = mysqli_fetch_array($result)) {?>
      <?php 
        echo '<option value="'.$row["cid"].'" >'.$row["Commodity"].'</option>';
      ?>
    
    
     <?php
      }
      ?>
    </select>