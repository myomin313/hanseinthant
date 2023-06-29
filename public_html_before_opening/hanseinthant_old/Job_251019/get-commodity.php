<?php session_start();
include_once('../config.php');

?>
    <?php
    $q = $_GET['q'];
    $rowNum = $_GET['rowNum'];
    $Brands = $_GET['Brand'];
    $Location = $_GET['Location'];
    $Brand = mysqli_real_escape_string($con,$_GET['Brand']);

    $Branches = $_SESSION['Branch'];

        //   if ($Branches == 'Shwe Pyi Thar Store') {
        //     $sqlp="SELECT Distinct Commodity FROM product Where Branch='Shwe Pyi Thar Store' and  BrandName='$Brand'";}
        //   elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {
        //     $sqlp="SELECT Distinct Commodity FROM product Where Branch='Shwe Pyi Thar Store Control Panel' and  BrandName='$Brand'";}
        //   elseif ($Branches == 'Yangon Show Room') {
        //     $sqlp="SELECT Distinct Commodity FROM product Where Branch='Yangon Show Room' and  BrandName='$Brand'";}
        //   elseif ($Branches == 'Mandalay Show Room') {
        //     $sqlp="SELECT Distinct Commodity FROM product Where Branch='Mandalay Show Room' and  BrandName='$Brand'";}
        //   elseif ($Branches == 'Naypyidaw Show Room') {
        //     $sqlp="SELECT Distinct Commodity FROM product Where Branch='Naypyidaw Show Room' and  BrandName='$Brand'";}
        //   else {
        //     $sqlp="SELECT Distinct Commodity FROM product Where BrandName='$Brand'";}    
          $sqlp="SELECT Distinct Commodity FROM product Where BrandName='$Brand' and Branch ='$Location'";

    $result = mysqli_query($con,$sqlp);

    print'<select name="Commodity[]" id="Commodity'.$rowNum.'"style="width:20%;height: 30px;font-size:10px;" onchange="showUsers('.$rowNum.')" required="required">';
    
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
