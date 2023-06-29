<?php
include_once('../config.php');
?>
    <?php
    $q = $_GET['q'];
    $rowNum = $_GET['rowNum'];
    $Brands = $_GET['Brand'];
    $JOB_Nos = $_GET['JOB_Nos'];
    $Location = $_GET['Location'];
    $Brand = mysqli_real_escape_string($con,$_GET['Brand']);
    if ($JOB_Nos == '') {
     $sql="SELECT Distinct  Commodity
    FROM product
    Where 
    BrandName='$Brand' and Branch='$Location' and currentQty!=0";
    // echo $sql;
    }
    else{
     $sql="SELECT Distinct Commodity from job Where BrandName='$Brand' and Job_No='$JOB_Nos' and Location='$Location'";   
    //  echo $sql;
    }
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
