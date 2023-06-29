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

                  $supplier=$_GET['supplier']; 
                  $Return_date=$_GET['Return_date']; 
                  $PL_NO=$_GET['PL_NO']; 

                  $id=$_GET['id']; 
                  $Commodity = mysqli_real_escape_string($con,$_GET['Commodity']);
                  $BrandName = mysqli_real_escape_string($con,$_GET['BrandName']);
                  $code = mysqli_real_escape_string($con,$_GET['code']);
                  $Remarks_item = mysqli_real_escape_string($con,$_GET['Remarks_item']);          

                  $Types=$_GET['Types']; 
                  $quan=$_GET['quan']; 
                  $Branch=$_GET['Branch']; 

                  $OSupplier="";
                  $OBrandName ="";
                  $OCommodity ="";
                  $Ocode="";
                  $ORemark_item ="";
                  $OReturn_date ="";
                  $OPL ="";               
                  $OQty ="";
                  $OType ="";
                  $RecordTime =date("Y-m-d H:i:s");
                  $Recorder =$_GET['LUser'];     
                  $status ="Delete";
                                   
                  $sql="SELECT * FROM supplier_return WHERE  id = '$id' ";
                  $results=mysqli_query($con ,$sql); 
                  $row = $results->fetch_assoc();
                  $OSupplier= $row['Supplier'];   

                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $Ocode = mysqli_real_escape_string($con,$row['code']);
                  $ORemark_item = mysqli_real_escape_string($con,$row['Remark_item']);  

                  $OReturn_date= $row['Return_date'];
                  $OBranch= $row['Branch'];
                  $OPL= $row['PL'];
                  $OQty= $row['Qty'];
                  $OType= $row['type'];
                           

                $sql="INSERT INTO supplierreturn_history(Branch,OBranch,input_ID,Supplier,OSupplier,BrandName,OBrandName,Commodity,OCommodity,code,Ocode,Remark_item,ORemark_item,Return_date,OReturn_date,PL,OPL,Qty,OQty,Type,OType,RecordTime,Recorder,status) 
                VALUES ('','$Branch','$id','','$OSupplier','','$OBrandName','','$OCommodity','','$Ocode','','$ORemark_item','','$OReturn_date','','$OPL','','$OQty','','$OType','$RecordTime','$Recorder','$status')";
                //   echo $sql;
                  mysqli_query($con ,$sql);		

            	  $sqlA="SELECT Qty FROM product WHERE SupplierName='$supplier' AND Commodity = '$Commodity'  AND code='$code' AND BrandName = '$BrandName'  AND Purchase_order_No='$PL_NO' AND Branch='$Branch' ";
            	  $resultA=mysqli_query($con ,$sqlA); 
            	  $rowA = $resultA->fetch_assoc();
            	  $ResQty=$quan+$rowA['Qty'];
  
                 $sqls = " UPDATE product SET Qty='$ResQty' WHERE SupplierName='$supplier' AND Commodity = '$Commodity' AND code='$code' AND BrandName = '$BrandName'  AND Purchase_order_No='$PL_NO'  AND Branch='$Branch'";
                  // echo $sqls;
                 mysqli_query($con,$sqls);


                  $sqlB="SELECT balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,rate FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and code='$code' and Purchase_order_No ='$PL_NO' AND Branch LIKE '%{$Branch}%' and SupplierName='$supplier'";
                  $resultB=mysqli_query($con ,$sqlB); 
                  $rowB = $resultB->fetch_assoc();
                  $balancerate= $rowB['rate']* $rowB['Qty'];

                  $sqls = " UPDATE product SET totalRate='$balancerate' WHERE SupplierName='$supplier' AND Commodity = '$Commodity' AND code='$code' AND BrandName = '$BrandName'  AND Purchase_order_No='$PL_NO'  AND Branch='$Branch'";

                  // echo $sqls;
                 mysqli_query($con,$sqls);

                  $sqlC="SELECT balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,rate,Rate_Name,Packing_date,totalRate FROM product  WHERE SupplierName='$supplier' AND Commodity = '$Commodity' AND code='$code' AND BrandName = '$BrandName'  AND Purchase_order_No='$PL_NO'  AND Branch='$Branch'";
                  $resultC=mysqli_query($con ,$sqlC); 
                  $rowC = $resultC->fetch_assoc();
                  $totalUSD= $rowC['USD'] * $rowC['Qty'];

                
                  $sqls = " UPDATE product SET totalUSD='$totalUSD' WHERE SupplierName='$supplier' AND Commodity = '$Commodity' AND code='$code' AND BrandName = '$BrandName'  AND Purchase_order_No='$PL_NO'  AND Branch='$Branch'";
                  // echo $sqls;
                  mysqli_query($con,$sqls); 

                  $sqlD="SELECT balanceWIP,balanceReturn,balanceQty,Qty,balanceDelivery FROM product WHERE SupplierName='$supplier' AND Commodity = '$Commodity' AND code='$code' AND BrandName = '$BrandName'  AND Purchase_order_No='$PL_NO'  AND Branch='$Branch'";
                  $resultD=mysqli_query($con ,$sqlD); 
                  $rowD = $resultD->fetch_assoc();
                  $balancesss= $rowD['balanceDelivery'] + $rowD['balanceWIP'];
                  $balancess= $balancesss - $rowD['balanceReturn']; 
                  $curr= $rowD['balanceDelivery'] - $rowD['balanceReturn']; 
                  $balance= $rowD['Qty'] - $balancess;
                  $currentQty= $rowD['Qty'] - $curr;
                  $sqls = " UPDATE product SET balanceQty='$balance' WHERE SupplierName='$supplier' AND Commodity = '$Commodity' AND code='$code' AND BrandName = '$BrandName'  AND Purchase_order_No='$PL_NO'  AND Branch='$Branch'";
                  // echo $sqls;
                  mysqli_query($con,$sqls);   
                  
                  $sqlsA = " UPDATE product SET currentQty='$currentQty' WHERE SupplierName='$supplier' AND Commodity = '$Commodity' AND code='$code' AND BrandName = '$BrandName'  AND Purchase_order_No='$PL_NO'  AND Branch='$Branch'";
                  // echo $sqls;
                  mysqli_query($con,$sqlsA);                     
        
         		$sql="DELETE FROM supplier_return WHERE id='$id'";
		          //echo $sql;
              mysqli_query($con ,$sql);
                    echo"<script>alert('Successfully Deleted');</script>"; 

                    echo "<script type='text/javascript'>window.top.location='detail.php?Supplier=$supplier&PL=$PL_NO&Branch=$Branch';</script>";exit;	                
               
       

?>