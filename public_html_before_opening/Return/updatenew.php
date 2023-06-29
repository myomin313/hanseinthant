<?php

      include_once('../config.php');
      
      $LUser=$_GET['LUser']; 
      $CreateTime= date("Y-m-d H:i:s"); 


      $NType=$_GET['NType']; 
      $Qty=$_GET['Qty']; 

      $NBrandName =mysqli_real_escape_string($con,$_GET['NBrandName']);   
      $NCommodity =mysqli_real_escape_string($con,$_GET['NCommodity']); 
      $Ncode =mysqli_real_escape_string($con,$_GET['code']);  
      $Remarks    =mysqli_real_escape_string($con,$_GET['Remarks']);   
      $okyaku     =mysqli_real_escape_string($con,$_GET['okyaku']);   

      $DO_No=$_GET['DO_No']; 
      $PL=$_GET['PL']; 
      $department=$_GET['department']; 
      $Return_no=$_GET['Return_no']; 
      $Return_date=$_GET['Return_date'];
      $transfer_no=$_GET['transfer_no']; 
      
       if($transfer_no != ''){
       $sqlA = "SELECT DISTINCT BrandName,Commodity,PL,Return_no,DO_No,department FROM returns WHERE BrandName ='$NBrandName' and Commodity= '$NCommodity' and code='$Ncode' and PL = '$PL' and department= '$department' and Customer = '$okyaku' and Return_no = '$Return_no'and DO_No='$DO_No' AND transfer_no='$transfer_no'";
       }else{
         $sqlA = "SELECT DISTINCT BrandName,Commodity,PL,Return_no,DO_No,department FROM returns WHERE BrandName ='$NBrandName' and Commodity= '$NCommodity' and code='$Ncode' and PL = '$PL' and department= '$department' and Customer = '$okyaku' and Return_no = '$Return_no'and DO_No='$DO_No' AND ( transfer_no IS NULL OR transfer_no='')"; 
       }
       
        $resultA=mysqli_query($con ,$sqlA); 
        $row = $resultA->fetch_assoc();
        $count=mysqli_num_rows($resultA);
        if($count==1)
             {
              echo"<script>alert('Your item already exist in return.Please try again!');</script>"; 
              echo "<script type='text/javascript'>window.top.location='detail.php?Customer=$okyaku&Return_no=$Return_no&DO_No=$DO_No';</script>";exit;              
              }  
      else{   
                                    
               
                 if($transfer_no != ''){
                  $sqldelivery="SELECT returnQty,Qty FROM delivery Where Customer='$okyaku' AND BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$Ncode' and PL ='$PL' AND Location = '$department' AND DO_No = '$DO_No' AND transfer_no='$transfer_no'";
                 }else{
                  $sqldelivery="SELECT returnQty,Qty FROM delivery Where Customer='$okyaku' AND BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$Ncode' and PL ='$PL' AND Location = '$department' AND DO_No = '$DO_No' AND ( transfer_no IS NULL OR transfer_no='')"; 
                 }
                  $resuldelivery=mysqli_query($con ,$sqldelivery); 
                  $delivery = $resuldelivery->fetch_assoc();

                  $returndelivery=$delivery['returnQty']+$Qty;
                 // $transfer_no = $delivery['transfer_no'];
                   if( $returndelivery  > $delivery['Qty']){
                   mysqli_rollback($con);
                   echo"<script>alert('Your Quantity is not enough .Please try again!');</script>"; 
                   echo "<script type='text/javascript'>window.top.location='detail.php?Customer=$okyaku&Return_no=$Return_no&DO_No=$DO_No';</script>";exit;  
                  }else{
                  //start myo min transfer
                  if($transfer_no != ''){
                    $sqlproduct="SELECT balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,totalUSD FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$Ncode' and Purchase_order_No ='$PL' AND Branch = '$department' AND transfer_no='$transfer_no'";
                  }else{
                    $sqlproduct="SELECT balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,totalUSD FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$Ncode' and Purchase_order_No ='$PL' AND Branch = '$department' AND ( transfer_no IS NULL OR transfer_no='')"; 
                  }
                 
                  $resultproduct=mysqli_query($con ,$sqlproduct); 
                  $product = $resultproduct->fetch_assoc();
                  $returns=$product['balanceReturn']+$Qty;
                
                  if($transfer_no != ''){
                 $sqls = " UPDATE product SET balanceReturn='$returns' WHERE BrandName =  '$NBrandName' AND Commodity = '$NCommodity' AND code='$Ncode'  AND Purchase_order_No = '$PL' AND Branch = '$department' and transfer_no='$transfer_no'";
                  }else{
                    $sqls = " UPDATE product SET balanceReturn='$returns' WHERE BrandName =  '$NBrandName' AND Commodity = '$NCommodity' AND code='$Ncode'  AND Purchase_order_No = '$PL' AND Branch = '$department' AND ( transfer_no IS NULL OR transfer_no='')";  
                  }
                  mysqli_query($con,$sqls);
                  
                  if($transfer_no != null){
                  $sqlproducts="SELECT balanceTransfer,balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,totalUSD FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$Ncode' and Purchase_order_No ='$PL' AND Branch = '$department' AND transfer_no='$transfer_no'";
                  }else{
                    $sqlproducts="SELECT balanceTransfer,balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,totalUSD FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$Ncode' and Purchase_order_No ='$PL' AND Branch = '$department' AND ( transfer_no IS NULL OR transfer_no='')";
                  }
                  $resultproducts=mysqli_query($con ,$sqlproducts); 
                  $products = $resultproducts->fetch_assoc();                 

                  $tdreturn = $products['balanceDelivery']+$products['balanceTransfer'];
                  $qtys = $tdreturn - $products['balanceReturn'];
                  $balanceqtys = $products['balanceWIP'] + $qtys;
                  $totalbalance = $products['Qty'] - $balanceqtys;
                  $currentQty = $products['Qty'] - $qtys;
                  $balanceUSD = $products['USD']* $qtys;
                  
                  $returnUSD = $products['USD'] * $Qty;
                 
                  if($transfer_no != ''){
                  $sqls = " UPDATE product SET balanceUSD='$balanceUSD',balanceQty='$totalbalance' WHERE BrandName =  '$NBrandName' AND Commodity = '$NCommodity' and code='$Ncode'  AND Purchase_order_No = '$PL' AND Branch = '$department' AND transfer_no='$transfer_no'";
                  }else{
                    $sqls = " UPDATE product SET balanceUSD='$balanceUSD',balanceQty='$totalbalance' WHERE BrandName =  '$NBrandName' AND Commodity = '$NCommodity' and code='$Ncode'  AND Purchase_order_No = '$PL' AND Branch = '$department' AND ( transfer_no IS NULL OR transfer_no='')"; 
                  }
                  mysqli_query($con,$sqls);        
                  
                  if($transfer_no != ''){
                  $sqlsAA = " UPDATE product SET currentQty='$currentQty' WHERE BrandName =  '$NBrandName' AND Commodity = '$NCommodity' and code='$Ncode' AND Purchase_order_No = '$PL' AND Branch = '$department' and transfer_no='$transfer_no'";
                  }else{
                    $sqlsAA = " UPDATE product SET currentQty='$currentQty' WHERE BrandName =  '$NBrandName' AND Commodity = '$NCommodity' and code='$Ncode' AND Purchase_order_No = '$PL' AND Branch = '$department' AND ( transfer_no IS NULL OR transfer_no='')"; 
                  }
                  mysqli_query($con,$sqlsAA);

                  //end myo min transfer
                  if($transfer_no != ''){
                  $sqls = " UPDATE delivery SET returnQty='$returndelivery' WHERE Customer='$okyaku' AND BrandName =  '$NBrandName' AND  Commodity ='$NCommodity' and code='$Ncode'  AND PL = '$PL' AND Location = '$department' AND DO_No = '$DO_No' and  transfer_no='$transfer_no'";
                  }else{
                    $sqls = " UPDATE delivery SET returnQty='$returndelivery' WHERE Customer='$okyaku' AND BrandName =  '$NBrandName' AND  Commodity ='$NCommodity' and code='$Ncode'  AND PL = '$PL' AND Location = '$department' AND DO_No = '$DO_No' AND ( transfer_no IS NULL OR transfer_no='')"; 
                  }
                  
                  mysqli_query($con ,$sqls);  
                  $sql="INSERT INTO returns (department,Return_no,Return_date,Customer,DO_No,BrandName,Commodity,code,Qty,PL,Type,Remarks_item,Creator,CreateTime,returnUSD,transfer_no) VALUES ('$department','$Return_no','$Return_date', '$okyaku','$DO_No','$NBrandName','$NCommodity','$Ncode','$Qty','$PL','$NType','$Remarks','$LUser','$CreateTime','$returnUSD','$transfer_no')";

                  mysqli_query($con ,$sql);  
                $status ="New";
                $input_ID=0;
                          
                $sql="INSERT INTO customerreturn_history(input_ID,Customer,OCustomer,BrandName,OBrandName,Commodity,OCommodity,code,Ocode,Remarks_item,ORemarks_item,Return_date,OReturn_date,Return_no,OReturn_no,DO_No,ODO_No,PL,OPL,department,Odepartment,Qty,OQty,Type,OType,RecordTime,Recorder,status) 
                VALUES ('$input_ID','$okyaku','','$NBrandName','','$NCommodity','','$Ncode','','$Remarks','','$Return_date','','$Return_no','','$DO_No','','$PL','','$department','','$Qty','','$NType','','$CreateTime','$LUser','$status')";

                  mysqli_query($con ,$sql);                
                
                echo "<script type='text/javascript'>window.top.location='detail.php?Customer=$okyaku&Return_no=$Return_no&DO_No=$DO_No';</script>";exit; 

}
      }
?>