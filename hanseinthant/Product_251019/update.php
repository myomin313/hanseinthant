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
      $UpdateTime= date("Y-m-d H:i:s"); 

      $SupplierName=$_GET['SupplierName']; 
      $Branch=$_GET['Branch']; 
      $Packing_date=$_GET['Packing_date']; 
      $Purchase_order_No=$_GET['Purchase_order_No']; 
      $PO_NO=$_GET['PO_NO']; 

      $id=$_GET['id']; 
      $Commodity = mysqli_real_escape_string($con,$_GET['Commodity']);
      $BrandName = mysqli_real_escape_string($con,$_GET['BrandName']);
      $Remarks_Item = mysqli_real_escape_string($con,$_GET['Remarks_Item']);  

      $Type=$_GET['Type']; 
      $Rate_Name=$_GET['Rate_Name']; 
      $rate=$_GET['rate']; 
      $Qty=$_GET['Qty'];
      $totalRate=$_GET['totalRate']; 


                  $OSupplierName="";
                  $OBrandName ="";
                  $OCommodity ="";
                  $OBranch ="";
                  $ORemarks_Item ="";
                  $OPacking_date ="";
                  $OPurchase_order_No ="";
                  $OPO_NO ="";
                  $OQty ="";
                  $OtotalRate ="";
                  $ORate_Name ="";
                  $Orate ="";
                  $OType ="";
                  $RecordTime =date("Y-m-d H:i:s");
                  $Recorder =$_SESSION['login_user'];
                  $status ="Update";
                                   
                  $sql="SELECT * FROM product WHERE  id = '$id' and Branch = '$Branch' and SupplierName = '$SupplierName' and Purchase_order_No = '$Purchase_order_No' ";
                  $results=mysqli_query($con ,$sql); 
                  $row = $results->fetch_assoc();
                  $OSupplierName = mysqli_real_escape_string($con,$row['SupplierName']);
                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $ORemarks_Item = mysqli_real_escape_string($con,$row['Remarks_Item']);

                  $OBranch= $row['Branch']; 
                  $OPacking_date= $row['Packing_date'];
                  $OPurchase_order_No= $row['Purchase_order_No'];
                  $OPO_NO= $row['PO_NO'];
                  $OQty= $row['Qty'];
                  $ObalanceQty= $row['balanceQty'];
                  $OtotalRate= $row['totalRate'];
                  $ORate_Name= $row['Rate_Name'];
                  $Orate= $row['rate'];
                  $OType= $row['Type'];
                  $OUSD= $row['USD'];   
                  $OtotalUSD= $row['totalUSD'];   
                  $OcurrentQty= $row['currentQty'];   
                  
                  
                  $balQuantity= $row['balanceWIP'] + ($row['balanceDelivery'] - $row['balanceReturn']);
                  $BalQty= $Qty - $balQuantity;    
                  
                  $currQuantity= $Qty - ($row['balanceDelivery'] - $row['balanceReturn']);
                  
                  $sqls="SELECT Singapore,Europe,Thailand,British,Japan,Australia,Myanmar FROM rate WHERE Rate_date = '$Packing_date'";
                  $resultss=mysqli_query($con ,$sqls); 
                  $rowss = $resultss->fetch_assoc();  

                   if ($Rate_Name == 'Myanmar') {

                    $itemUSD =$rate / $rowss['Myanmar'];
                    $itemtotalUSD = $totalRate /$rowss['Myanmar'];

                  }
                  elseif ($Rate_Name == 'Singapore') {
                    $itemUSD = $rate * $rowss['Singapore'];
                    $itemtotalUSD = $totalRate * $rowss['Singapore'];
                   
                  }
                  elseif ($Rate_Name == 'Europe') {
                    $itemUSD = $rate * $rowss['Europe'];
                    $itemtotalUSD = $totalRate * $rowss['Europe'];

                  }
                  elseif ($Rate_Name == 'Thailand') {
                    $itemUSD = $rate * $rowss['Thailand'];
                    $itemtotalUSD = $totalRate * $rowss['Thailand'];

                  }
                  elseif ($Rate_Name == 'British') {
                    $itemUSD = $rate * $rowss['British'];
                    $itemtotalUSD = $totalRate * $rowss['British'];
                  }
                  elseif ($Rate_Name == 'Japan') {
                    $itemUSD = $rate * $rowss['Japan'];
                    $itemtotalUSD = $totalRate * $rowss['Japan'];

                  }
                  elseif ($Rate_Name == 'Australia') {
                    $itemUSD = $rate * $rowss['Australia'];
                    $itemtotalUSD = $totalRate * $rowss['Australia'];

                  }
                  else{
                    $itemUSD = $rate;
                    $itemtotalUSD = $totalRate;
                  }                   
                  
                           
                  $sql="INSERT INTO product_history(input_ID,SupplierName,OSupplierName,BrandName,OBrandName,Commodity,OCommodity,Branch,OBranch,Remarks_Item,ORemarks_Item,Packing_date,OPacking_date,Purchase_order_No,OPurchase_order_No,PO_NO,OPO_NO,Qty,OQty,totalRate,OtotalRate,Rate_Name,ORate_Name,rate,Orate,Type,OType,RecordTime,Recorder,status) 
                  VALUES ('$id','$SupplierName','$OSupplierName','$BrandName','$OBrandName','$Commodity','$OCommodity','$Branch','$OBranch','$Remarks_Item','$ORemarks_Item','$Packing_date','$OPacking_date','$Purchase_order_No','$OPurchase_order_No','$PO_NO','$OPO_NO','$Qty','$OQty','$totalRate','$OtotalRate','$Rate_Name','$ORate_Name','$rate','$Orate','$Type','$OType','$UpdateTime','$LUser','$status')";
                  //echo $sql;
                  mysqli_query($con ,$sql);                               

                 $sql="UPDATE product SET SupplierName='$SupplierName', BrandName='$BrandName',Commodity='$Commodity',Branch='$Branch', Remarks_Item='$Remarks_Item', Packing_date='$Packing_date',Purchase_order_No='$Purchase_order_No',  PO_NO='$PO_NO',Qty='$Qty', balanceQty='$BalQty',currentQty='$currQuantity',rate='$rate', totalRate='$totalRate',Type='$Type',USD= '$itemUSD',totalUSD='$itemtotalUSD',Rate_Name='$Rate_Name' WHERE  id = '$id' and Branch = '$Branch' and SupplierName = '$SupplierName' and Purchase_order_No = '$Purchase_order_No' ";
      
                mysqli_query($con ,$sql);
                echo"<script>alert('Successfully Updated');</script>"; 
                
                echo "<script type='text/javascript'>window.top.location='detail.php?SupplierID=$SupplierName&PL=$Purchase_order_No';</script>";exit;
                

?>