<?php
include_once('../config.php');

/*$setutf8 = "SET NAMES utf8";
$q = $con->query($setutf8);
$setutf8c = "SET character_set_results = 'utf8', character_set_client =
'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
character_set_server = 'utf8'";
$qc = $con->query($setutf8c);
$setutf9 = "SET CHARACTER SET utf8";
$q1 = $con->query($setutf9);
$setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
$q2 = $con->query($setutf7);*/

$LUser=$_GET['LUser']; 
$CreateTime= date("Y-m-d H:i:s"); 

$Branch=$_GET['Branch']; 
$Packing_date=$_GET['Packing_date']; 
$Purchase_order_No=$_GET['Purchase_order_No']; 
$PO_NO=$_GET['PO_NO']; 

$itemBrandName = mysqli_real_escape_string($con,$_GET['itemBrandName']);   
$itemCommodity = mysqli_real_escape_string($con,$_GET['itemCommodity']);   
$itemRemarks_Item = mysqli_real_escape_string($con,$_GET['itemRemarks_Item']);   
$SupplierName = mysqli_real_escape_string($con,$_GET['SupplierName']);   

$itemType=$_GET['itemType']; 
$Rate_Names=$_GET['Rate_Names']; 
$itemrate=$_GET['itemrate']; 
$itemQty=$_GET['itemQty']; 
$totalRates=$_GET['totalRates']; 
$balanceWIP=0;$balanceDelivery=0;$balanceUSD=0;$balanceReturn=0;


      $sqlA = "SELECT DISTINCT BrandName,Commodity,Purchase_order_No FROM product WHERE BrandName ='$itemBrandName' and Commodity= '$itemCommodity' and Purchase_order_No = '$Purchase_order_No'";
        $resultA=mysqli_query($con ,$sqlA); 
        $row = $resultA->fetch_assoc();
        $count=mysqli_num_rows($resultA);
        if($count==1)
             {
              echo"<script>alert('Your Input already exist.Please try again!');</script>"; 
              }  
      else{   

                  $sqls="SELECT Singapore,Europe,Thailand,British,Japan,Australia,Myanmar FROM rate WHERE Rate_date = '$Packing_date'";
                  $resultss=mysqli_query($con ,$sqls); 
                  $rowss = $resultss->fetch_assoc();  

                   if ($Rate_Names == 'Myanmar') {

                    $itemUSD =$itemrate / $rowss['Myanmar'];
                    $itemtotalUSD = $totalRates /$rowss['Myanmar'];

                  }
                  elseif ($Rate_Names == 'Singapore') {
                    $itemUSD = $itemrate * $rowss['Singapore'];
                    $itemtotalUSD = $totalRates * $rowss['Singapore'];
                   
                  }
                  elseif ($Rate_Names == 'Europe') {
                    $itemUSD = $itemrate * $rowss['Europe'];
                    $itemtotalUSD = $totalRates * $rowss['Europe'];

                  }
                  elseif ($Rate_Names == 'Thailand') {
                    $itemUSD = $itemrate * $rowss['Thailand'];
                    $itemtotalUSD = $totalRates * $rowss['Thailand'];

                  }
                  elseif ($Rate_Names == 'British') {
                    $itemUSD = $itemrate * $rowss['British'];
                    $itemtotalUSD = $totalRates * $rowss['British'];
                  }
                  elseif ($Rate_Names == 'Japan') {
                    $itemUSD = $itemrate * $rowss['Japan'];
                    $itemtotalUSD = $totalRates * $rowss['Japan'];

                  }
                  elseif ($Rate_Names == 'Australia') {
                    $itemUSD = $itemrate * $rowss['Australia'];
                    $itemtotalUSD = $totalRates * $rowss['Australia'];

                  }
                  else{
                    $itemUSD = $itemrate;
                    $itemtotalUSD = $totalRates;
                  } 
                  $sql="INSERT INTO product (SupplierName,BrandName,Commodity,Branch,Remarks_Item,Packing_date,Purchase_order_No,PO_NO,Qty,Type,Rate_Name,rate,totalRate,USD,totalUSD,balanceQty,currentQty,balanceWIP,balanceDelivery,balanceUSD,balanceReturn,CreateTime,Creator) VALUES ('$SupplierName', '$itemBrandName','$itemCommodity','$Branch','$itemRemarks_Item','$Packing_date','$Purchase_order_No','$PO_NO','$itemQty','$itemType','$Rate_Names','$itemrate','$totalRates','$itemUSD','$itemtotalUSD','$itemQty','$itemQty','$balanceWIP','$balanceDelivery','$balanceUSD','$balanceReturn','$CreateTime','$LUser')";
            

                  mysqli_query($con ,$sql);
                $status ="New";
                $input_ID=0;
                     

                  $sql="INSERT INTO product_history(input_ID,SupplierName,OSupplierName,BrandName,OBrandName,Commodity,OCommodity,Branch,OBranch,Remarks_Item,ORemarks_Item,Packing_date,OPacking_date,Purchase_order_No,OPurchase_order_No,PO_NO,OPO_NO,Qty,OQty,totalRate,OtotalRate,Rate_Name,ORate_Name,rate,Orate,Type,OType,RecordTime,Recorder,status) 
                  VALUES ('','$SupplierName','','$itemBrandName','','$itemCommodity','','$Branch','','$itemRemarks_Item','','$Packing_date','','$Purchase_order_No','','$PO_NO','','$itemQty','','$totalRates','','$Rate_Names','','$itemrate','','$itemType','','$CreateTime','$LUser','$status')";                  

                  mysqli_query($con ,$sql);                       
      }        
                
                echo "<script type='text/javascript'>window.top.location='detail.php?SupplierID=$SupplierName&PL=$Purchase_order_No';</script>";exit;                  



?>