<?php
include_once('../config.php');

?>
    <?php
    $q = $_GET['q'];
    $rowNum = $_GET['rowNum'];
    $NJOB_No = $_GET['NJOB_No'];
     $Location = $_GET['Location'];
    mysqli_set_charset($con, 'utf8');
    $Brand = mysqli_real_escape_string($con,$_GET['Brand']);
    if ($_GET['NJOB_No'] <> '') {
    
     $sql="SELECT j.Commodity AS cid,c.commodity AS Commodity from job j LEFT JOIN commodity c ON j.Commodity= c.id 
    Where 
    j.BrandName='$Brand' and j.Job_No='$NJOB_No' and j.Location='$Location' "; 
      
    }else{
      $sql="SELECT Distinct  p.Commodity AS cid,c.commodity AS Commodity 
    FROM product p LEFT JOIN commodity c ON p.Commodity= c.id
    Where 
    p.BrandName='$Brand' and p.Branch='$Location' ";        
    }
     

    // product.Commodity NOT IN (SELECT Commodity FROM delivery ) and
    //echo $sql;exit();
    $result = mysqli_query($con,$sql);

    print'<select name="NCommodity[]" id="NCommodity'.$rowNum.'"style="width:20%;height: 30px;font-size:10px;" onchange="showUsers('.$rowNum.')" required="required">';
    
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
