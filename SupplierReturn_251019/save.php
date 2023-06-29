<?php 
include_once('../config.php');

                  $setutf8 = "SET NAMES utf8";
                  $q = $con->query($setutf8);
                  $setutf8c = "SET character_set_results = 'utf8', character_set_client =
                  'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
                  character_set_server = 'utf8'";
                  $qc = $con->query($setutf8c);
                  $setutf9 = "SET CHARACTER SET utf8";
                  $q1 = $con->query($setutf9);
                  $setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
                  $q2 = $con->query($setutf7);

                  foreach($_POST['Qty'] as $row=>$Qty) { 
                  $Qty=$Qty;
                  $Commodity= mysqli_real_escape_string($con,$_POST['NCommodity'][$row]);
                  $Supplier = mysqli_real_escape_string($con,$_POST['supplier']);
                  $BrandName = mysqli_real_escape_string($con,$_POST['BrandName'][$row]);
                  $Remark_item = mysqli_real_escape_string($con,$_POST['Remarks'][$row]);   

                  $SubQty=$_POST['SubQty'][$row];
                  $type = $_POST['Type'][$row]; 
                  $PL=$_POST['PL_NO'];
                  $Branch=$_POST['Branch'];
                  $Return_date = $_POST['Return_date'];                                      
           
            	  $LUser=$_POST['LUser']; 
            	  $CreateTime= date("Y-m-d H:i:s"); 

                  $row_data[] = "('$Branch','$Return_date','$PL','$Supplier', '$BrandName','$Commodity','$Qty','$type','$Remark_item','$LUser','$CreateTime')";

                  $sql="SELECT balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,rate FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and Purchase_order_No ='$PL' AND Branch LIKE '%{$Branch}%' and SupplierName='$Supplier'";
                  $result=mysqli_query($con ,$sql); 
                  $rows = $result->fetch_assoc();
                  $balanceQ= $rows['Qty']- $Qty;

                  $sqls = " UPDATE product SET Qty='$balanceQ' WHERE SupplierName='$Supplier' AND Commodity ='$Commodity' AND BrandName ='$BrandName' and Purchase_order_No ='$PL'";
                  // echo $sqls;
                  mysqli_query($con,$sqls);

                  $sqlA="SELECT balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,rate FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and Purchase_order_No ='$PL' AND Branch LIKE '%{$Branch}%' and SupplierName='$Supplier'";
                  $resultA=mysqli_query($con ,$sqlA); 
                  $rowA = $resultA->fetch_assoc();
                  $balancerate= $rowA['rate']* $rowA['Qty'];

                  $sqls = " UPDATE product SET totalRate='$balancerate' WHERE SupplierName='$Supplier' AND Commodity ='$Commodity'  AND Branch LIKE '%{$Branch}%'  and Purchase_order_No ='$PL' and BrandName = '$BrandName'";
                  // echo $sqls;
                  mysqli_query($con,$sqls);
                  $sqlB="SELECT balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,rate,Rate_Name,Packing_date,totalRate FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and Purchase_order_No ='$PL' AND Branch LIKE '%{$Branch}%' and SupplierName='$Supplier'";
                  $resultB=mysqli_query($con ,$sqlB); 
                  $rowB = $resultB->fetch_assoc();
                  $totalUSD= $rowB['USD'] * $rowB['Qty'];
                  
                  $sqls = " UPDATE product SET totalUSD='$totalUSD' WHERE SupplierName='$Supplier' AND Commodity ='$Commodity'  AND Branch LIKE '%{$Branch}%'  and Purchase_order_No ='$PL' and BrandName = '$BrandName'";
                  // echo $sqls;
                  mysqli_query($con,$sqls);   

                  $sqlC="SELECT balanceWIP,balanceReturn,balanceQty,Qty,balanceDelivery FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and Purchase_order_No ='$PL' AND Branch LIKE '%{$Branch}%' and SupplierName='$Supplier'";
                  $resultC=mysqli_query($con ,$sqlC); 
                  $rowC = $resultC->fetch_assoc();
                  $balancesss= $rowC['balanceDelivery'] - $rowC['balanceReturn'];       
                  $balancess= $balancesss + $rowC['balanceWIP'];                 
                  $balance= $rowC['Qty'] - $balancess;
                  $currentQty= $rowC['Qty'] - $balancesss;
                  
                  $sqls = " UPDATE product SET balanceQty='$balance' WHERE SupplierName='$Supplier' AND Commodity ='$Commodity'  AND Branch LIKE '%{$Branch}%'  and Purchase_order_No ='$PL' and BrandName = '$BrandName'";
                  // echo $sqls;
                  mysqli_query($con,$sqls);   
                  
                  $sqlsA = " UPDATE product SET currentQty='$currentQty' WHERE SupplierName='$Supplier' AND Commodity ='$Commodity'  AND Branch LIKE '%{$Branch}%'  and Purchase_order_No ='$PL' and BrandName = '$BrandName'";
                  // echo $sqls;
                  mysqli_query($con,$sqlsA);                     
                  
                  $i += 1;
                  }
                  
                  $return='INSERT INTO supplier_return (Branch,Return_date,PL,Supplier,BrandName,Commodity,Qty,type,Remark_item,Creator,CreateTime
                  ) VALUES '.implode
                  (',', $row_data);
                //   echo $return;
                  mysqli_query($con,$return);
                  echo"<script>alert('Success');</script>";

echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit;                       
           
            


?>