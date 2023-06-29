<?php

      include_once('../config.php');
      
      $LUser=$_GET['LUser']; 
      $CreateTime= date("Y-m-d H:i:s"); 


      $NType=$_GET['NType']; 
      $Qty=$_GET['Qty']; 

      $NBrandName = mysqli_real_escape_string($con,$_GET['NBrandName']);   
      $NCommodity = mysqli_real_escape_string($con,$_GET['NCommodity']);   
      $Remarks = mysqli_real_escape_string($con,$_GET['Remarks']);   
      $okyaku = mysqli_real_escape_string($con,$_GET['okyaku']);   

      $DO_No=$_GET['DO_No']; 
      $PL=$_GET['PL']; 
      $department=$_GET['department']; 
      $Return_no=$_GET['Return_no']; 
      $Return_date=$_GET['Return_date']; 

       $sqlA = "SELECT DISTINCT BrandName,Commodity,PL,Return_no,DO_No,department FROM returns WHERE BrandName ='$NBrandName' and Commodity= '$NCommodity' and PL = '$PL' and department= '$department' and Customer = '$okyaku' and Return_no = '$Return_no'and DO_No='$DO_No'";
        $resultA=mysqli_query($con ,$sqlA); 
        $row = $resultA->fetch_assoc();
        $count=mysqli_num_rows($resultA);
        if($count==1)
             {
              echo"<script>alert('Your item already exist in WIP.Please try again!');</script>"; 
              echo "<script type='text/javascript'>window.top.location='detail.php?Customer=$okyaku&Return_no=$Return_no&DO_No=$DO_No';</script>";exit;              
              }  
      else{   
                  $sqlproduct="SELECT balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,totalUSD FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Purchase_order_No ='$PL' AND Branch = '$department'";
                  $resultproduct=mysqli_query($con ,$sqlproduct); 
                  $product = $resultproduct->fetch_assoc();
                  $returns=$product['balanceReturn']+$Qty;

                 $sqls = " UPDATE product SET balanceReturn='$returns' WHERE BrandName =  '$NBrandName' AND Commodity = '$NCommodity'  AND Purchase_order_No = '$PL' AND Branch = '$department'";

                  mysqli_query($con,$sqls);

                  $sqlproducts="SELECT balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,totalUSD FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Purchase_order_No ='$PL' AND Branch = '$department'";
                  $resultproducts=mysqli_query($con ,$sqlproducts); 
                  $products = $resultproducts->fetch_assoc();                 

                  $qtys = $products['balanceDelivery'] - $products['balanceReturn'];
                  $balanceqtys = $products['balanceWIP'] + $qtys;
                  $totalbalance = $products['Qty'] - $balanceqtys;
                  $currentQty = $products['Qty'] - $qtys;
                  $balanceUSD = $products['USD']* $qtys;

                  $sqls = " UPDATE product SET balanceUSD='$balanceUSD',balanceQty='$totalbalance' WHERE BrandName =  '$NBrandName' AND Commodity = '$NCommodity'  AND Purchase_order_No = '$PL' AND Branch = '$department'";

                  mysqli_query($con,$sqls);        
                  
                  $sqlsAA = " UPDATE product SET currentQty='$currentQty' WHERE BrandName =  '$NBrandName' AND Commodity = '$NCommodity'  AND Purchase_order_No = '$PL' AND Branch = '$department'";

                  mysqli_query($con,$sqlsAA);                    
               
                  $sqldelivery="SELECT returnQty FROM delivery Where Customer='$okyaku' AND BrandName = '$NBrandName' and Commodity ='$NCommodity' and PL ='$PL' AND Location = '$department' AND DO_No = '$DO_No'";
                  $resuldelivery=mysqli_query($con ,$sqldelivery); 
                  $delivery = $resuldelivery->fetch_assoc();

                  $returndelivery=$delivery['returnQty']+$Qty;  

                  $sqls = " UPDATE delivery SET returnQty='$returndelivery' WHERE Customer='$okyaku' AND BrandName =  '$NBrandName' AND  Commodity ='$NCommodity'  AND PL = '$PL' AND Location = '$department' AND DO_No = '$DO_No'";
                  mysqli_query($con ,$sqls);                   

                  $sql="INSERT INTO returns (department,Return_no, Return_date,Customer,DO_No,BrandName,Commodity,Qty,PL,Type,Remarks_item,Creator,CreateTime) VALUES ('$department','$Return_no','$Return_date', '$okyaku','$DO_No','$NBrandName','$NCommodity','$Qty','$PL','$NType','$Remarks','$LUser','$CreateTime')";

                  mysqli_query($con ,$sql);  
                $status ="New";
                $input_ID=0;
                          
                $sql="INSERT INTO customerreturn_history(input_ID,Customer,OCustomer,BrandName,OBrandName,Commodity,OCommodity,Remarks_item,ORemarks_item,Return_date,OReturn_date,Return_no,OReturn_no,DO_No,ODO_No,PL,OPL,department,Odepartment,Qty,OQty,Type,OType,RecordTime,Recorder,status) 
                VALUES ('$input_ID','$okyaku','','$NBrandName','','$NCommodity','','$Remarks','','$Return_date','','$Return_no','','$DO_No','','$PL','','$department','','$Qty','','$NType','','$CreateTime','$LUser','$status')";

                  mysqli_query($con ,$sql);                
                
                echo "<script type='text/javascript'>window.top.location='detail.php?Customer=$okyaku&Return_no=$Return_no&DO_No=$DO_No';</script>";exit; 

}
?>