<?php

      include_once('../config.php');

                //   $setutf8 = "SET NAMES utf8";
                //   $q = $con->query($setutf8);
                //   $setutf8c = "SET character_set_results = 'utf8', character_set_client =
                //   'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
                //   character_set_server = 'utf8'";
                //   $qc = $con->query($setutf8c);
                //   $setutf9 = "SET CHARACTER SET utf8";
                //   $q1 = $con->query($setutf9);
                //   $setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
                //   $q2 = $con->query($setutf7);
                  
                  $LUser=$_GET['LUser']; 
                  $CreateTime= date("Y-m-d H:i:s"); 

                  $Type=$_GET['Type']; 
                  $Qty=$_GET['Qty']; 
                  $SubQty=$_GET['SubQty']; 

                  $NBrandName = mysqli_real_escape_string($con,$_GET['NBrandName']);   
                  $NCommodity = mysqli_real_escape_string($con,$_GET['NCommodity']);   
                  $Remarks = mysqli_real_escape_string($con,$_GET['Remarks']);                    

                  $supplier=$_GET['supplier']; 
                  $Return_date=$_GET['Return_date']; 
                  $PL_NO=$_GET['PL_NO']; 
                  $Branch=$_GET['Branch']; 
                  
      $sqlA = "SELECT DISTINCT BrandName,Commodity,PL,Branch FROM supplier_return WHERE BrandName ='$NBrandName' and Commodity= '$NCommodity' and PL = '$PL_NO' and Branch= '$Branch' and Supplier = '$supplier' ";
        $resultA=mysqli_query($con ,$sqlA); 
        $row = $resultA->fetch_assoc();
        $count=mysqli_num_rows($resultA);
        if($count==1)
             {
              echo"<script>alert('Your item already exist in WIP.Please try again!');</script>"; 
                  
                echo "<script type='text/javascript'>window.top.location='detail.php?Supplier=$supplier&PL=$PL_NO&Branch=$Branch';</script>";exit;             
              }  
      else{

                  $sqlA="SELECT balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,rate FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Purchase_order_No ='$PL_NO' AND Branch LIKE '%{$Branch}%' and SupplierName='$supplier'";
                  $resultA=mysqli_query($con ,$sqlA); 
                  $rowA = $resultA->fetch_assoc();
                  $balanceQ= $rowA['Qty']- $Qty;

                  $sqls = " UPDATE product SET Qty='$balanceQ' WHERE SupplierName='$supplier' AND Commodity ='$NCommodity' AND BrandName ='$NBrandName' and Purchase_order_No ='$PL_NO'";
                  // echo $sqls;
                  mysqli_query($con,$sqls);

                  $sqlB="SELECT balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,rate FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Purchase_order_No ='$PL_NO' AND Branch LIKE '%{$Branch}%' and SupplierName='$supplier'";
                  $resultB=mysqli_query($con ,$sqlB); 
                  $rowB = $resultB->fetch_assoc();
                  $balancerate= $rowB['rate']* $rowB['Qty'];

                  $sqls = " UPDATE product SET totalRate='$balancerate' WHERE SupplierName='$supplier' AND Commodity ='$NCommodity'  AND Branch LIKE '%{$Branch}%'  and Purchase_order_No ='$PL_NO' and BrandName = '$NBrandName'";
                  // echo $sqls;
                  mysqli_query($con,$sqls);
                  $sqlC="SELECT balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,rate,Rate_Name,Packing_date,totalRate FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Purchase_order_No ='$PL_NO' AND Branch LIKE '%{$Branch}%' and SupplierName='$supplier'";
                  $resultC=mysqli_query($con ,$sqlC); 
                  $rowC = $resultC->fetch_assoc();
                  $totalUSD= $rowC['USD'] * $rowC['Qty'];
                  
                  $sqls = " UPDATE product SET totalUSD='$totalUSD' WHERE SupplierName='$supplier' AND Commodity ='$NCommodity'  AND Branch LIKE '%{$Branch}%'  and Purchase_order_No ='$PL_NO' and BrandName = '$NBrandName'";
                  // echo $sqls;
                  mysqli_query($con,$sqls);   

                  $sqlD="SELECT balanceWIP,balanceReturn,balanceQty,Qty,balanceDelivery FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Purchase_order_No ='$PL_NO' AND Branch LIKE '%{$Branch}%' and SupplierName='$supplier'";
                  $resultD=mysqli_query($con ,$sqlD); 
                  $rowD = $resultD->fetch_assoc();
                  $balancesss= $rowD['balanceDelivery'] + $rowD['balanceWIP'];
                  $curr= $rowD['balanceDelivery'] - $rowD['balanceReturn'];
                  $balancess= $balancesss - $rowD['balanceReturn'];                 
                  $balance= $rowD['Qty'] - $balancess;
                  $currentQty= $rowD['Qty'] - $curr;
                  $sqls = " UPDATE product SET balanceQty='$balance' WHERE SupplierName='$supplier' AND Commodity ='$NCommodity'  AND Branch LIKE '%{$Branch}%'  and Purchase_order_No ='$PL_NO' and BrandName = '$NBrandName'";
                  // echo $sqls;
                  mysqli_query($con,$sqls);   
                  
                   $sqlsA = " UPDATE product SET currentQty='$currentQty' WHERE SupplierName='$supplier' AND Commodity ='$NCommodity'  AND Branch LIKE '%{$Branch}%'  and Purchase_order_No ='$PL_NO' and BrandName = '$NBrandName'";
                  // echo $sqls;
                  mysqli_query($con,$sqlsA);                    

                 $sql="INSERT INTO supplier_return (Branch,Return_date,PL,Supplier,BrandName,Commodity,Qty,type,Remark_item,Creator,CreateTime) VALUES ('$Branch','$Return_date','$PL_NO','$supplier', '$NBrandName','$NCommodity','$Qty','$Type','$Remarks','$LUser','$CreateTime')";
                //   echo $sql;
                 mysqli_query($con ,$sql);
                
                $status ="New";
                $input_ID=0;                
                
                $sql="INSERT INTO supplierreturn_history(Branch,OBranch,input_ID,Supplier,OSupplier,BrandName,OBrandName,Commodity,OCommodity,Remark_item,ORemark_item,Return_date,OReturn_date,PL,OPL,Qty,OQty,Type,OType,RecordTime,Recorder,status) 
                VALUES ('$Branch','','$input_ID','$supplier','','$NBrandName','','$NCommodity','','$Remarks','','$Return_date','','$PL_NO','','$Qty','','$Type','','$CreateTime','$LUser','$status')";
                //   echo $sql;
                  mysqli_query($con ,$sql);                
                  
                echo "<script type='text/javascript'>window.top.location='detail.php?Supplier=$supplier&PL=$PL_NO&Branch=$Branch';</script>";exit; 

}

?>