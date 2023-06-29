<?php
include_once('../config.php');
?>
    <?php
   // $q = $_GET['q'];
    $rowNum = $_GET['rowNum'];
    $BrandName = $_GET['BrandName'];
    $Commodity = $_GET['Commodity'];
     $sql="SELECT id,code FROM code Where brandname='$BrandName' and commodity='$Commodity'";   
    
    $result = mysqli_query($con,$sql);

    print'<select name="code[]" id="code'.$rowNum.'"style="width:20%;height: 30px;font-size:10px;"  required="required">';
    
    Print'<option value=""></option>';
     while($row = mysqli_fetch_array($result)) {?>
      
      <?php 
        echo '<option value="'.$row["id"].'" >'.$row["code"].'</option>';
      ?>
    
    
     <?php
      }
      ?>
    </select>
