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
     mysqli_set_charset($con, 'utf8');
    if ($JOB_Nos == '') {
     $sql="SELECT Distinct  p.Commodity AS cid,c.commodity AS Commodity FROM product p LEFT JOIN Commodity c ON p.Commodity= c.id
    Where 
    p.BrandName='$Brand' and Branch='$Location' and currentQty!=0";
    // echo $sql;
    }
    else{
     $sql="SELECT j.Commodity AS cid,c.commodity AS Commodity from job j LEFT JOIN Commodity c ON j.Commodity= c.id Where j.BrandName='$Brand' and Job_No='$JOB_Nos' and Location='$Location'";   
    //  echo $sql;
    }
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
