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

if($_SERVER["REQUEST_METHOD"] == "POST")
{ 
$Return_no=$_POST['Return_no'];
        $sql = "SELECT DISTINCT Return_no FROM returns WHERE Return_no ='$Return_no'";
        // echo $sql;
        $result=mysqli_query($con ,$sql); 
        $row = $result->fetch_assoc();
                  $count=mysqli_num_rows($result);
                  if($count==1)
                  {
                echo"<script>alert('Your Return NO is not allowed.Please try again!');</script>";                     
                  $_SESSION['message'] = "Your Return No. is not allowed.Please Try again!"; 
                echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit;
                  }  
      else{  
              $row_data = array();
             $i = 1;
      
                  foreach($_POST['Qty'] as $row=>$Qty) { 
                  $Qty=$Qty;
                  $Commodity= mysqli_real_escape_string($con,$_POST['NCommodity'][$row]);
                  $okyaku = mysqli_real_escape_string($con,$_POST['okyaku']);
                  $BrandName = mysqli_real_escape_string($con,$_POST['BrandName'][$row]);
                  $code= mysqli_real_escape_string($con,$_POST['code'][$row]);
                  $Remarks = mysqli_real_escape_string($con,$_POST['Remarks'][$row]);   

                  $department=$_POST['department'];
                  $Return_no=$_POST['Return_no'];
                  $Return_date = $_POST['Return_date'];                                     
                  $DO_No=$_POST['DO_No'];
                  $Type=$_POST['NType'][$row];
                  $PL=$_POST['PL'][$row];
            	  $LUser=$_POST['LUser']; 
            	  $CreateTime= date("Y-m-d H:i:s"); 
                  $row_data[] = "('$department','$Return_no','$Return_date', '$okyaku','$DO_No','$PL','$BrandName','$Commodity','$code','$Qty','$Type','$Remarks','$LUser','$CreateTime')";

                  $sqlproduct="SELECT balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,totalUSD FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and code='$code' and Purchase_order_No ='$PL' AND Branch='$department'";
                  $resultproduct=mysqli_query($con ,$sqlproduct); 
                  $product = $resultproduct->fetch_assoc();
                  $returns=$product['balanceReturn']+$Qty;

                 $sqls = " UPDATE product SET balanceReturn='$returns' WHERE BrandName =  '$BrandName' AND Commodity ='$Commodity' and code='$code' AND Purchase_order_No='$PL' AND Branch='$department'";
                  // echo $sqls;
                  mysqli_query($con,$sqls);

                  $sqlproducts="SELECT balanceTransfer,balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,totalUSD FROM product Where BrandName = '$BrandName' and code='$code' and Commodity ='$Commodity' and Purchase_order_No ='$PL' AND Branch='$department'";
                  $resultproducts=mysqli_query($con ,$sqlproducts); 
                  $products = $resultproducts->fetch_assoc();                  

                  $tdreturn = $products['balanceDelivery']+$products['balanceTransfer'];
                  $qtys = $tdreturn - $products['balanceReturn'];
                  $balanceqtys = $products['balanceWIP'] + $qtys;
                  $totalbalance = $products['Qty'] - $balanceqtys;
                  $currentQty = $products['Qty'] - $qtys;

                  $balanceUSD = $products['USD']* $qtys;

                  $sqls = " UPDATE product SET balanceUSD='$balanceUSD',balanceQty='$totalbalance' WHERE BrandName =  '$BrandName' AND Commodity ='$Commodity' and code='$code' AND Purchase_order_No ='$PL' AND Branch='$department'";
                  // echo $sqls;
                  mysqli_query($con,$sqls);   
                  
                   $sqlAS = " UPDATE product SET currentQty='$currentQty' WHERE BrandName =  '$BrandName' AND Commodity ='$Commodity' and code='$code' AND Purchase_order_No ='$PL' AND Branch='$department'";
                  
                  mysqli_query($con,$sqlAS);                        
               
                  $sqldelivery="SELECT returnQty FROM delivery Where Customer='$okyaku' AND BrandName = '$BrandName' and Commodity ='$Commodity' and code='$code' and PL ='$PL' AND Location='$department' AND DO_No='$DO_No'";
                  $resuldelivery=mysqli_query($con ,$sqldelivery); 
                  $delivery = $resuldelivery->fetch_assoc();

                  $returndelivery=$delivery['returnQty']+$Qty;  

                  $sqls = " UPDATE delivery SET returnQty='$returndelivery' WHERE Customer='$okyaku' AND BrandName =  '$BrandName' AND  Commodity ='$Commodity'  and code='$code' AND PL = '$PL' AND Location = '$department' AND DO_No = '$DO_No'";
                  // echo $sqls;
                   mysqli_query($con ,$sqls);               

                  $i += 1;
                  }

                  $sql = 'INSERT INTO returns (department,Return_no,Return_date,Customer,DO_No,PL,BrandName,Commodity,code,Qty,Type,Remarks_item,Creator,CreateTime)  VALUES '.implode
                  (',', $row_data);
                //   echo $sql;
                  mysqli_query($con ,$sql);   
                          echo"<script>alert('Success');</script>";

                 echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit;

                 
            } 
      }




?>