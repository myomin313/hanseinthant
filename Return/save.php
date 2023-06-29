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
              $transfer_no = array();
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
                  
                  //if(!empty($_POST['Ntransfer_no'][$row])){
                    $transfer_no=$_POST['Ntransfer_no'][$row];
                  //}else{
                   // $transfer_no='';
                 // }

                 // $row_data[] = "('$department','$Return_no','$Return_date', '$okyaku','$DO_No','$PL','$BrandName','$Commodity','$code','$Qty','$Type','$Remarks','$LUser','$CreateTime')";
                      
                 if($transfer_no != ''){
                  $sqldelivery="SELECT returnQty,Qty FROM delivery Where Customer='$okyaku' AND BrandName = '$BrandName' and Commodity ='$Commodity' and code='$code' and PL ='$PL' AND Location='$department' AND DO_No='$DO_No' AND transfer_no='$transfer_no'";
                  }else{
                   $sqldelivery="SELECT returnQty,Qty FROM delivery Where Customer='$okyaku' AND BrandName = '$BrandName' and Commodity ='$Commodity' and code='$code' and PL ='$PL' AND Location='$department' AND DO_No='$DO_No' AND ( transfer_no IS NULL OR transfer_no='')";
                  }
                  $resuldelivery=mysqli_query($con ,$sqldelivery); 
                  $delivery = $resuldelivery->fetch_assoc();

                  $returndelivery=$delivery['returnQty']+$Qty; 
 
                  
                  if( $returndelivery  > $delivery['Qty']){
                   mysqli_rollback($con);
                   echo"<script>alert('Your Quantity is not enough .Please try again!');</script>";                   
                   echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit; 
                  }else{
                  // $transfer_no=$delivery['transfer_no'];
                   if($transfer_no != ''){
                  $sqls = " UPDATE delivery SET returnQty='$returndelivery' WHERE Customer='$okyaku' AND BrandName =  '$BrandName' AND  Commodity ='$Commodity'  and code='$code' AND PL = '$PL' AND Location = '$department' AND DO_No = '$DO_No'  AND transfer_no='$transfer_no'";
                   }else{
                   $sqls = " UPDATE delivery SET returnQty='$returndelivery' WHERE Customer='$okyaku' AND BrandName =  '$BrandName' AND  Commodity ='$Commodity'  and code='$code' AND PL = '$PL' AND Location = '$department' AND DO_No = '$DO_No' AND ( transfer_no IS NULL OR transfer_no='')";
                   }
                  // echo $sqls;
                   mysqli_query($con ,$sqls);   
                   
                   //start myo min change for transfer_no
                  
                   if($transfer_no != ''){
                    $sqlproduct="SELECT balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,totalUSD FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and code='$code' and Purchase_order_No ='$PL' AND Branch='$department' AND transfer_no='$transfer_no'";
                   }else{
                    $sqlproduct="SELECT balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,totalUSD FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and code='$code' and Purchase_order_No ='$PL' AND Branch='$department' AND  ( transfer_no IS NULL OR transfer_no='')"; 
                   }
                 
                  $resultproduct=mysqli_query($con ,$sqlproduct); 
                  $product = $resultproduct->fetch_assoc();
                  $returns=$product['balanceReturn']+$Qty;
                
                  if($transfer_no != ''){
                  $sqls = " UPDATE product SET balanceReturn='$returns' WHERE BrandName =  '$BrandName' AND Commodity ='$Commodity' and code='$code' AND Purchase_order_No='$PL' AND Branch='$department' and transfer_no='$transfer_no'";
                  }else{
                    $sqls = " UPDATE product SET balanceReturn='$returns' WHERE BrandName =  '$BrandName' AND Commodity ='$Commodity' and code='$code' AND Purchase_order_No='$PL' AND Branch='$department' and transfer_no IS NULL"; 
                  }
                    // echo $sqls;
                  mysqli_query($con,$sqls);
                 
                  if($transfer_no != ''){
                  $sqlproducts="SELECT balanceTransfer,balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,totalUSD FROM product Where BrandName = '$BrandName' and code='$code' and Commodity ='$Commodity' and Purchase_order_No ='$PL' AND Branch='$department' AND transfer_no='$transfer_no'";
                  }else{
                    $sqlproducts="SELECT balanceTransfer,balanceWIP,balanceReturn,balanceQty,USD,balanceUSD,Qty,balanceDelivery,totalUSD FROM product Where BrandName = '$BrandName' and code='$code' and Commodity ='$Commodity' and Purchase_order_No ='$PL' AND Branch='$department' AND ( transfer_no IS NULL OR transfer_no='')"; 
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
                       $row_data[] = "('$department','$Return_no','$Return_date', '$okyaku','$DO_No','$PL','$BrandName','$Commodity','$code','$Qty','$Type','$Remarks','$LUser','$CreateTime','$returnUSD','$transfer_no')";
                     }else{
                       $row_data[] = "('$department','$Return_no','$Return_date', '$okyaku','$DO_No','$PL','$BrandName','$Commodity','$code','$Qty','$Type','$Remarks','$LUser','$CreateTime','$returnUSD',NULL)";   
                     }
                  if($transfer_no != ''){
                  $sqls = " UPDATE product SET balanceUSD='$balanceUSD',balanceQty='$totalbalance' WHERE BrandName =  '$BrandName' AND Commodity ='$Commodity' and code='$code' AND Purchase_order_No ='$PL' AND Branch='$department' AND transfer_no='$transfer_no'";
                  }else{
                    $sqls = " UPDATE product SET balanceUSD='$balanceUSD',balanceQty='$totalbalance' WHERE BrandName =  '$BrandName' AND Commodity ='$Commodity' and code='$code' AND Purchase_order_No ='$PL' AND Branch='$department' AND ( transfer_no IS NULL OR transfer_no='')";  
                  }
                  // echo $sqls;
                  mysqli_query($con,$sqls);   
                   
                  if($transfer_no != ''){
                   $sqlAS = " UPDATE product SET currentQty='$currentQty' WHERE BrandName =  '$BrandName' AND Commodity ='$Commodity' and code='$code' AND Purchase_order_No ='$PL' AND Branch='$department' AND transfer_no='$transfer_no'";
                  }else{
                    $sqlAS = " UPDATE product SET currentQty='$currentQty' WHERE BrandName =  '$BrandName' 
                    AND Commodity ='$Commodity' and code='$code' AND Purchase_order_No ='$PL' AND Branch='$department' AND ( transfer_no IS NULL OR transfer_no='')"; 
                  } 
                  mysqli_query($con,$sqlAS);  

                   //end myo min change for transfer_no

                  $i += 1;
                  }

                }

                  $sql = 'INSERT INTO returns (department,Return_no,Return_date,Customer,DO_No,PL,BrandName,Commodity,code,Qty,Type,Remarks_item,Creator,CreateTime,returnUSD,transfer_no)  VALUES '.implode
                  (',', $row_data);
                //   echo $sql;
                  mysqli_query($con ,$sql);   
                          echo"<script>alert('Success');</script>";

                 echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit;
                 
            } 
      }




?>