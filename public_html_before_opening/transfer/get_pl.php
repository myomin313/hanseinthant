<?php
include_once('../config.php');
?>
    <?php
    $q = $_GET['q'];
    $BrandName = $_GET['BrandName'];
    $Location = $_GET['Location'];
    $transfer_no = $_GET['transfer_no'];
    $code = $_GET['code'];
    $Commodity = mysqli_real_escape_string($con,$_GET['Commodity']);

    // if ($JOB_Nos == '') {
    //  $sql="SELECT Distinct  p.Commodity AS cid,c.commodity AS Commodity FROM product p LEFT JOIN commodity c ON p.Commodity= c.id
    // Where p.BrandName='$Brand' and Branch='$Location' and currentQty!=0";
    // // echo $sql;
    // }
    // else{
    //  $sql="SELECT j.Commodity AS cid,c.commodity AS Commodity from job j LEFT JOIN commodity c ON j.Commodity= c.id Where j.BrandName='$Brand' and Job_No='$JOB_Nos' and Location='$Location'";   
    // //  echo $sql;
    // }

       
    $sqlt="SELECT product.Purchase_order_No as Pl
    FROM product LEFT JOIN supplier ON product.SupplierName= supplier.UserId WHERE 
    product.Commodity='$Commodity' AND product.BrandName='$BrandName' AND product.code='$code' AND product.Branch='$Location' AND  product.transfer_no='$transfer_no' AND product.currentQty!=0"; 
    
    // $resultt = mysqli_query($con,$sqlt);



    
    $result = mysqli_query($con,$sqlt);

    // print'<select name="NCommodity[]" id="NCommodity'.$rowNum.'"style="width:20%;height: 30px;font-size:10px;" onchange="showUsers('.$rowNum.')" required="required">';
    
    Print'<option value=""></option>';
     while($row = mysqli_fetch_array($result)) {?>
      
      <?php 
        echo '<option value="'.$row["Pl"].'" >'.$row["Pl"].'</option>';
      ?>
    
    
     <?php
      }
      ?>
    </select>
