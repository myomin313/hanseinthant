<?php
include_once('../config.php');

?>
    <?php
    $q = $_GET['q'];
    $rowNum = $_GET['rowNum'];
     $transfer_from = $_GET['transfer_from'];
    mysqli_set_charset($con, 'utf8');
    $Brand = mysqli_real_escape_string($con,$_GET['Brand']);
   
      $sql="SELECT Distinct  p.Commodity AS cid,c.commodity AS Commodity 
    FROM product p LEFT JOIN commodity c ON p.Commodity= c.id
    Where p.BrandName='$Brand' and p.Branch='$transfer_from' ";  
     

    // product.Commodity NOT IN (SELECT Commodity FROM delivery ) and
    //echo $sql;exit();
    $result = mysqli_query($con,$sql);

    print'<select name="NCommodity[]" id="NCommodity'.$rowNum.'"style="width:20%;height: 30px;font-size:10px;" onchange="getCode('.$rowNum.')" required="required">';
    
    Print'<option value=""></option>';
     while($row = mysqli_fetch_array($result)) {?>
      <?php 
              // $Commoditys = $row["Commodity"];
         $Commoditys = mysqli_real_escape_string($con,$row["Commodity"]);
        echo '<option value="'.$row["cid"].'" >'.$row["Commodity"].'</option>';

      ?>
    
     <?php
      }
      ?>
    </select>
