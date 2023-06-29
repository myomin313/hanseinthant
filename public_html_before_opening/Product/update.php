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
      $code = mysqli_real_escape_string($con,$_GET['code']);
      $Remarks_Item = mysqli_real_escape_string($con,$_GET['Remarks_Item']);  

      $Type=$_GET['Type']; 
      $Rate_Name=$_GET['Rate_Name']; 
      $rate=$_GET['rate']; 
      $Qty=$_GET['Qty'];
      $totalRate=$_GET['totalRate'];
     


                  $OSupplierName="";
                  $OBrandName ="";
                  $OCommodity ="";
                  $Ocode ="";
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
                  $Ocode = mysqli_real_escape_string($con,$row['code']);
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
                  $balanceDelivery = $row['balanceDelivery'];
                  $balanceTransfer = $row['balanceTransfer'];
      
       
                  $balancetd = $balanceTransfer + $balanceDelivery;
                  
                  $balQuantity= $row['balanceWIP'] + ($balancetd - $row['balanceReturn']);
                  $BalQty= $Qty - $balQuantity;    
                  
                  $currQuantity= $Qty - ($balancetd - $row['balanceReturn']);
                  
                  $sqls="SELECT Singapore,Europe,Thailand,British,Japan,Australia,Myanmar FROM rate WHERE Rate_date = '$Packing_date'";
                  $resultss=mysqli_query($con ,$sqls); 
                  $rowss = $resultss->fetch_assoc();  

                   if ($Rate_Name == 'Myanmar') {
                    
                   if($rowss['Myanmar'] > 0){
                    // $itemUSD =$rate / (float) str_replace(',', '', $rowss['Myanmar']);
                   // $itemtotalUSD = $totalRate / (float) str_replace(',', '', $rowss['Myanmar']);
                    $getUSD = $rate / str_replace(',', '',$rowss['Myanmar']);
                    $itemUSD=round($getUSD, 4);
                    $itemtotalUSD = $Qty * $itemUSD;
                   }else{
                      $itemUSD =(float) str_replace(',', '',$rowss['Myanmar']);
                    $itemtotalUSD = (float) str_replace(',', '',$rowss['Myanmar']);  
                   }

                  }
                  elseif ($Rate_Name == 'Singapore') {
                    //$itemUSD = $rate * (float) str_replace(',', '',$rowss['Singapore']);
                    //$itemtotalUSD = $totalRate * (float) str_replace(',', '',$rowss['Singapore']);
                     $getUSD = $rate * str_replace(',', '',$rowss['Singapore']);
                     $itemUSD=round($getUSD, 4);
                     $itemtotalUSD = $Qty * $itemUSD;
                  }
                  elseif ($Rate_Name == 'Europe') {
                   // $itemUSD = $rate * (float) str_replace(',', '',$rowss['Europe']);
                   // $itemtotalUSD = $totalRate * (float) str_replace(',', '',$rowss['Europe']);
                     $getUSD = $rate * str_replace(',', '',$rowss['Europe']);
                     $itemUSD=round($getUSD, 4);
                     $itemtotalUSD = $Qty * $itemUSD;
                  }
                  elseif ($Rate_Name == 'Thailand') {
                    //$itemUSD = $rate * (float) str_replace(',', '',$rowss['Thailand']);
                   // $itemtotalUSD = $totalRate * (float) str_replace(',', '',$rowss['Thailand']);
                   
                    $getUSD = $rate * str_replace(',', '',$rowss['Thailand']);
                    $itemUSD=round($getUSD, 4);
                    $itemtotalUSD = $Qty * $itemUSD;
                  }
                  elseif ($Rate_Name == 'British') {
                    //$itemUSD = $rate * (float) str_replace(',', '',$rowss['British']);
                   // $itemtotalUSD = $totalRate * (float) str_replace(',', '',$rowss['British']);
                   $getUSD = $rate * str_replace(',', '',$rowss['British']);
                    $itemUSD=round($getUSD, 4);
                   $itemtotalUSD = $Qty * $itemUSD;
                  }
                  elseif ($Rate_Name == 'Japan') {
                    //$itemUSD = $rate * (float) str_replace(',', '',$rowss['Japan']);
                    //$itemtotalUSD = $totalRate * (float) str_replace(',', '',$rowss['Japan']);
                    $getUSD = $rate * str_replace(',', '',$rowss['Japan']);
                    $itemUSD=round($getUSD, 4);
                    $itemtotalUSD = $Qty * $itemUSD;

                  }
                  elseif ($Rate_Name == 'Australia') {
                    //$itemUSD = $rate * (float) str_replace(',', '',$rowss['Australia']);
                   // $itemtotalUSD = $totalRate * (float) str_replace(',', '',$rowss['Australia']);
                    $getUSD = $rate * str_replace(',', '',$rowss['Australia']);
                    $itemUSD=round($getUSD, 4);
                    $itemtotalUSD = $Qty * $itemUSD;

                  }
                  else{
                     
                    $itemUSD = $rate;
                    $itemtotalUSD = $totalRate;
                  }  
                    $balancetd = $balanceTransfer + $balanceDelivery;
                   $balanceUSD = $itemUSD * $balancetd; 
                   
                    
                   
                   //start
                     $sqldelivery = "SELECT Qty,BrandName,Commodity,PL,DO_No FROM delivery WHERE Location = '$OBranch' and BrandName ='$OBrandName' and Commodity= '$OCommodity' and code='$Ocode' and PL = '$OPurchase_order_No'";
                     
                    $deliveryresults=mysqli_query($con ,$sqldelivery);
                   $dcount= mysqli_num_rows($deliveryresults);
                   $deliveryrows = $deliveryresults->fetch_assoc();
                   
                   
                   $dresult = $con->query($sqldelivery);
                    
                   //start myo min for delivery usd
                    if($dcount >1){
                         foreach($dresult as $drow) {
                            $deliveryUSD = $drow['Qty'] * $itemUSD;
                            $DO_No = $drow['DO_No'];
                            $dsql="UPDATE delivery SET deliveryUSD='$deliveryUSD' WHERE  DO_No='$DO_No' and  Location = '$OBranch' and BrandName ='$OBrandName' and Commodity= '$OCommodity' and code='$Ocode' and PL = '$OPurchase_order_No' ";
                            mysqli_query($con ,$dsql);
                         }
                    }else{
                         $deliveryUSD = $deliveryrows['Qty'] * $itemUSD;
                         $dsql="UPDATE delivery SET deliveryUSD='$deliveryUSD' WHERE  Location = '$OBranch' and BrandName ='$OBrandName' and Commodity= '$OCommodity' and code='$Ocode' and PL = '$OPurchase_order_No' ";
                         mysqli_query($con ,$dsql); 
                    }
                   //end myo min for delivery usd
                    
                   //end
                   
                    //start
                     $sqltransfer = "SELECT Qty,BrandName,Commodity,PL,transfer_no FROM transfer WHERE transfer_from = '$OBranch' and BrandName ='$OBrandName' and Commodity= '$OCommodity' and code='$Ocode' and PL = '$OPurchase_order_No'";
                     
                    $transferresults=mysqli_query($con ,$sqltransfer);
                   $tcount= mysqli_num_rows($transferresults);
                   $transferrows = $transferresults->fetch_assoc();
                   
                   
                   $tresult = $con->query($sqltransfer);
                    
                   //start myo min for transfer usd
                    if($tcount >1){
                       
                         foreach($tresult as $trow) {
                            $transferUSD = $trow['Qty'] * $itemUSD;
                            $transfer_no = $trow['transfer_no'];
                            $tsql="UPDATE transfer SET transferUSD='$transferUSD' WHERE  transfer_no='$transfer_no' and  Location = '$OBranch' and BrandName ='$OBrandName' and Commodity= '$OCommodity' and code='$Ocode' and PL = '$OPurchase_order_No' ";
                            mysqli_query($con ,$tsql);
                         }
                    }else{
                        
                         $transferUSD = $transferrows['Qty'] * $itemUSD;
                         $tsql="UPDATE transfer SET transferUSD='$transferUSD' WHERE  transfer_from = '$OBranch' and BrandName ='$OBrandName' and Commodity= '$OCommodity' and code='$Ocode' and PL = '$OPurchase_order_No' ";
                         mysqli_query($con ,$tsql); 
                    }
                   //end myo min for transfer usd
                    
                   //end
                   
                      
                           
                  $sql="INSERT INTO product_history(input_ID,SupplierName,OSupplierName,BrandName,OBrandName,Commodity,OCommodity,code,Ocode,Branch,OBranch,Remarks_Item,ORemarks_Item,Packing_date,OPacking_date,Purchase_order_No,OPurchase_order_No,PO_NO,OPO_NO,Qty,OQty,totalRate,OtotalRate,Rate_Name,ORate_Name,rate,Orate,Type,OType,RecordTime,Recorder,status) 
                  VALUES ('$id','$SupplierName','$OSupplierName','$BrandName','$OBrandName','$Commodity','$OCommodity','$code','$Ocode','$Branch','$OBranch','$Remarks_Item','$ORemarks_Item','$Packing_date','$OPacking_date','$Purchase_order_No','$OPurchase_order_No','$PO_NO','$OPO_NO','$Qty','$OQty','$totalRate','$OtotalRate','$Rate_Name','$ORate_Name','$rate','$Orate','$Type','$OType','$UpdateTime','$LUser','$status')";
                  //echo $sql;
                  mysqli_query($con ,$sql);                               

                 $usql="UPDATE product SET SupplierName='$SupplierName',BrandName='$BrandName',Commodity='$Commodity',code='$code',Branch='$Branch', Remarks_Item='$Remarks_Item', Packing_date='$Packing_date',Purchase_order_No='$Purchase_order_No',  PO_NO='$PO_NO',Qty='$Qty', balanceQty='$BalQty',currentQty='$currQuantity',rate='$rate', totalRate='$totalRate',Type='$Type',USD= '$itemUSD',totalUSD='$itemtotalUSD',Rate_Name='$Rate_Name',balanceUSD='$balanceUSD' WHERE  id = '$id' and Branch = '$Branch' and SupplierName = '$SupplierName' and Purchase_order_No = '$Purchase_order_No' ";
                  mysqli_query($con ,$usql);
                  
                //  $dsql="UPDATE delivery SET deliveryUSD='$deliveryUSD' WHERE  Location = '$OBranch' and BrandName ='$OBrandName' and Commodity= '$OCommodity' and code='$Ocode' and PL = '$OPurchase_order_No' ";
               
                //  mysqli_query($con ,$dsql);
               
                 $PPL=urlencode($Purchase_order_No);
                echo"<script>alert('Successfully Updated');</script>"; 
                
                echo "<script type='text/javascript'>window.top.location='detail.php?SupplierID=$SupplierName&Branch=$Branch&Packing_date=$Packing_date&PL=$PPL';</script>";exit;
                

?>