<?php

include_once('../config.php');

// $setutf8 = "SET NAMES utf8";
// $q = $con->query($setutf8);
// $setutf8c = "SET character_set_results = 'utf8', character_set_client =
// 'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
// character_set_server = 'utf8'";
// $qc = $con->query($setutf8c);
// $setutf9 = "SET CHARACTER SET utf8";
// $q1 = $con->query($setutf9);
// $setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
// $q2 = $con->query($setutf7);

      $okyaku=$_GET['okyaku']; 
      $DO_No=$_GET['DO_No']; 
      $department=$_GET['department']; 
      $Return_no=$_GET['Return_no']; 
      $Return_date=$_GET['Return_date']; 

      $id=$_GET['id'];
      $Commodity = mysqli_real_escape_string($con,$_GET['Commodity']);
      $BrandName = mysqli_real_escape_string($con,$_GET['BrandName']);
      $Remark_item = mysqli_real_escape_string($con,$_GET['Remarks_item']);             

      $Types=$_GET['Type']; 
      $quan=$_GET['quan'];
      $PL=$_GET['PL']; 

                  $OCustomer="";
                  $OBrandName ="";
                  $OCommodity ="";
                  $ORemarks_item ="";
                  $OReturn_date ="";
                  $OReturn_no ="";
                  $OJOB_No ="";
                  $ODO_No ="";                  
                  $Odepartment ="";
                  $OQty ="";
                  $OType ="";
                  $RecordTime =date("Y-m-d H:i:s");
                  $Recorder =$_GET['LUser'];     
                  $status ="Delete";
                                   
                  $sql="SELECT * FROM returns WHERE  id = '$id' ";
                  $results=mysqli_query($con ,$sql); 
                  $row = $results->fetch_assoc();
                  $OCustomer = mysqli_real_escape_string($con,$row['Customer']);
                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $ORemarks_item = mysqli_real_escape_string($con,$row['Remarks_item']);

                  $OReturn_date= $row['Return_date'];
                  $OReturn_no= $row['Return_no'];
                  $Odepartment= $row['department'];
                  $OQty= $row['Qty'];
                  $OType= $row['Type'];
                  $ODO_No= $row['DO_No']; 
                  $OPL= $row['PL'];
                  $Odepartment= $row['department'];

                 $sql="INSERT INTO customerreturn_history(input_ID,Customer,OCustomer,BrandName,OBrandName,Commodity,OCommodity,Remarks_item,ORemarks_item,Return_date,OReturn_date,Return_no,OReturn_no,DO_No,ODO_No,PL,OPL,department,Odepartment,Qty,OQty,Type,OType,RecordTime,Recorder,status) 
                VALUES ('$id','','$OCustomer','','$OBrandName','','$OCommodity','','$ORemarks_item','','$OReturn_date','','$OReturn_no','','$ODO_No','','$OPL','','$Odepartment','','$OQty','','$OType','$RecordTime','$Recorder','$status')";
                //   echo $sql;                  
                  mysqli_query($con ,$sql);		

                  $sqlproduct="SELECT balanceReturn,USD,balanceUSD,balanceDelivery,balanceWIP,Qty FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$department' and Purchase_order_No ='$PL'";

                  $resultproduct=mysqli_query($con ,$sqlproduct); 
                  $product = $resultproduct->fetch_assoc();
                  $balanceReturn = $product['balanceReturn'] - $_GET['quan'];

                 $sql = " UPDATE product SET  balanceReturn ='$balanceReturn' Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$department' and Purchase_order_No ='$PL'";               
                 // echo $sql;
                 mysqli_query($con ,$sql); 
                 
                  $sqlproductA="SELECT balanceReturn,USD,balanceUSD,balanceDelivery,balanceWIP,Qty FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$department' and Purchase_order_No ='$PL'";

                  $resultproductA=mysqli_query($con ,$sqlproductA); 
                  $productA = $resultproductA->fetch_assoc();                 
                 
                  $deli = $productA['balanceDelivery'] - $productA['balanceReturn'];
                  $resultDelivery = $productA['balanceWIP'] + $deli;
                  $totalQty = $productA['Qty'] - $resultDelivery;
                  $currentQty= $productA['Qty'] - $deli;

                  $balanceUSD = $productA['USD'] * $deli;

                 $sql = " UPDATE product SET balanceUSD='$balanceUSD',balanceQty='$totalQty' Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$department' and Purchase_order_No ='$PL'";
                 // echo $sql;
                 mysqli_query($con ,$sql); 
                 
                   $sqlA = " UPDATE product SET currentQty='$currentQty' Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$department' and Purchase_order_No ='$PL'";
             
                 mysqli_query($con ,$sqlA); 
                 
                $sqldelivery="SELECT returnQty FROM delivery Where BrandName = '$BrandName' and Commodity ='$Commodity' and Location ='$department' and PL ='$PL' and DO_No = '$DO_No'";
                $resultdelivery=mysqli_query($con ,$sqldelivery); 
                $delivery = $resultdelivery->fetch_assoc();
                $returnQty = $delivery['returnQty'] - $_GET['quan'];

                 $sql = " UPDATE delivery SET  returnQty ='$returnQty' Where BrandName = '$BrandName' and Commodity ='$Commodity' and Location ='$department' and PL ='$PL' and DO_No = '$DO_No'";
                 // echo $sql;
                 mysqli_query($con ,$sql); 
                 $sql="DELETE FROM returns WHERE id='$id'";
		             // echo $sql;
                 mysqli_query($con ,$sql);
                      echo"<script>alert('Successfully Deleted');</script>"; 

                    echo "<script type='text/javascript'>window.top.location='detail.php?Customer=$okyaku&Return_no=$Return_no&DO_No=$DO_No';</script>";exit;	               
                 



?>