<?php
include_once('../config.php');



if($_SERVER["REQUEST_METHOD"] == "POST")
{
        mysqli_autocommit($con,FALSE);
        $DO_No=$_POST['DO_No'].''.$_POST['dep_name'];
        $sql = "SELECT DISTINCT DO_No FROM delivery WHERE DO_No ='$DO_No'";
        // echo $sql;
        $result=mysqli_query($con ,$sql); 
        $row = $result->fetch_assoc();
                  $count=mysqli_num_rows($result);
                  if($count==1)
                  {
                  echo"<script>alert('Your DO NO is not allowed.Please try again!');</script>";                 
                  echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit;
                  }  
      else{     
      $row_data = array();
      $i = 1;
      
      foreach($_POST['NCommodity'] as $row=>$Commoditys) { 
      $Commoditys = mysqli_real_escape_string($con,$_POST['NCommodity'][$row]);
      $okyaku = mysqli_real_escape_string($con,$_POST['okyaku']);
      $BrandName = mysqli_real_escape_string($con,$_POST['BrandName'][$row]);
      $code =  mysqli_real_escape_string($con,$_POST['code'][$row]);
      $Remarks = mysqli_real_escape_string($con,$_POST['NRemark'][$row]);      

      $Delivery_date=$_POST['Delivery_date'];
      $DO_No=$_POST['DO_No'].''.$_POST['dep_name'];
      $JOB_No=$_POST['JOB_No'];
      $Location=$_POST['Location'];
      $Qty=$_POST['NQty'][$row];
   
      $Type=$_POST['NType'][$row];
      $txtHintss=$_POST['txtHintss'][$row];
      $Ntransfer_no =$_POST['Ntransfer_no'][$row];
      $returnss=0;

    $LUser=$_POST['LUser']; 
    $CreateTime= date("Y-m-d H:i:s"); 

      // $row_data[] = "('$Location','$okyaku','$Commoditys','$BrandName','$Type','$txtHintss','$Qty','$Delivery_date','$DO_No','$JOB_No','$Remarks','$returnss','$LUser','$CreateTime')";
      //   var_dump($row_data);


      if( $Ntransfer_no != ''){
      $sqlW="SELECT currentQty,USD FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code ='$code' and Branch ='$Location' and transfer_no='$Ntransfer_no' and Purchase_order_No ='$txtHintss'";
      }else{
        $sqlW="SELECT currentQty,USD FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code ='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss'  AND ( transfer_no IS NULL OR transfer_no='')";  
      }
      $resultW=mysqli_query($con ,$sqlW);

         $sum = 0;
         $deliveryUSD = 0; 
         while($row = mysqli_fetch_array($resultW))
        {
            
           $sum += $row['currentQty'];
           $deliveryUSD = $Qty * $row['USD'];         
        }
          if($Ntransfer_no != ''){
          $row_data[] = "('$Location','$okyaku','$Commoditys','$BrandName','$code','$Type','$txtHintss','$Qty','$Delivery_date','$DO_No','$JOB_No','$Remarks','$returnss','$LUser','$CreateTime','$deliveryUSD','$Ntransfer_no')";
         }else{
          $row_data[] = "('$Location','$okyaku','$Commoditys','$BrandName','$code','$Type','$txtHintss','$Qty','$Delivery_date','$DO_No','$JOB_No','$Remarks','$returnss','$LUser','$CreateTime','$deliveryUSD',NULL)";
         }
         //  var_dump($row_data);
       // var_dump($row);exit();
         
      
     if($Qty > $sum){
                mysqli_rollback($con);
                echo"<script>alert('Your Quantity is not enough .Please try again!');</script>";                   
                echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit; 
     }
    else{
        
      if ($JOB_No <> '') {
      $sqlsss="SELECT balanceWIP FROM job Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Location ='$Location' and PL ='$txtHintss'  and JOB_No ='$JOB_No'"; 
      $resultsss=mysqli_query($con ,$sqlsss); 
      $rowsss = $resultsss->fetch_assoc();  
      $oldWIP= $rowsss['balanceWIP'];
      $newWIP =  $oldWIP + $Qty;        
       $sql = " UPDATE job SET balanceWIP ='$newWIP' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Location ='$Location' and PL ='$txtHintss' and Customer ='$okyaku' and JOB_No ='$JOB_No'"; 

      mysqli_query($con ,$sql);
      $sql="SELECT balanceWIP,WIP,balanceJOB FROM job Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Location ='$Location' and PL ='$txtHintss' and Customer ='$okyaku' and JOB_No ='$JOB_No'"; 
      $result=mysqli_query($con ,$sql); 
      $rows = $result->fetch_assoc();
            
            if ($rows['WIP'] > $rows['balanceWIP'] ) {
               $wipJOB = $rows['WIP']- $rows['balanceWIP'];          
            }elseif ($rows['WIP'] < $rows['balanceWIP'] ) {
                $wipJOB = 0.000;
            }else{
                 $wipJOB= 0.000;
              }  
      $sql = " UPDATE job SET balanceJOB ='$wipJOB' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Location ='$Location' and PL ='$txtHintss' and Customer ='$okyaku' and JOB_No ='$JOB_No'"; 
    //   echo $sql;
      mysqli_query($con ,$sql);
      $sql="SELECT SUM(balanceJOB) as sumJOB FROM job Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Location ='$Location' and PL ='$txtHintss' AND ( transfer_no IS NULL OR transfer_no='')"; 
      $result=mysqli_query($con ,$sql); 
      $rows = $result->fetch_assoc();   
      $sumJOB = $rows['sumJOB'];      
       
      if( $Ntransfer_no != ''){
       $sql = " UPDATE product SET  balanceWIP ='$sumJOB' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no'";     
      }else{
        $sql = " UPDATE product SET  balanceWIP ='$sumJOB' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' AND ( transfer_no IS NULL OR transfer_no='')";   
      }// echo $sql; 
        mysqli_query($con ,$sql);
        if( $Ntransfer_no != ''){
      $sql="SELECT balanceDelivery,balanceQty,USD FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no'";
        }else{
          $sql="SELECT balanceDelivery,balanceQty,USD FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' AND ( transfer_no IS NULL OR transfer_no='')";
        }
      $result=mysqli_query($con ,$sql); 
      $rows = $result->fetch_assoc();
      $remain= $rows['balanceDelivery']+ $Qty;
      if( $Ntransfer_no != ''){     
       $sql = " UPDATE product SET  balanceDelivery ='$remain' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no'";     
      }else{
        $sql = " UPDATE product SET  balanceDelivery ='$remain' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss'AND ( transfer_no IS NULL OR transfer_no='')";
      }  // echo $sql; 
        mysqli_query($con ,$sql);
      if( $Ntransfer_no != ''){
        $sql="SELECT balanceDelivery,balanceQty,USD FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no'";
      }else{
          $sql="SELECT balanceDelivery,balanceQty,USD FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' AND ( transfer_no IS NULL OR transfer_no='')";
      }
      $result=mysqli_query($con ,$sql); 
      $rows = $result->fetch_assoc();
      $balanceUSD = $rows['USD']* $rows['balanceDelivery'];
      if( $Ntransfer_no != ''){
       $sql = " UPDATE product SET  balanceUSD ='$balanceUSD' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no'";     
      }else{
        $sql = " UPDATE product SET  balanceUSD ='$balanceUSD' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' AND ( transfer_no IS NULL OR transfer_no='')"; 
      }  // echo $sql; 
        mysqli_query($con ,$sql);
      if( $Ntransfer_no != ''){
        $sqlss="SELECT balanceDelivery,balanceWIP,Qty,balanceReturn FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and  transfer_no='$Ntransfer_no'";
      }else{
        $sqlss="SELECT balanceDelivery,balanceWIP,Qty,balanceReturn FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss'AND ( transfer_no IS NULL OR transfer_no='')";
      }
      $resultss=mysqli_query($con ,$sqlss); 
      $quantity = $resultss->fetch_assoc();
      $return=$quantity['balanceDelivery']-$quantity['balanceReturn'];
      $bal=$quantity['balanceWIP']+ $return;
      $balanceQty = $quantity['Qty'] - $bal;
      $currentQty = $quantity['Qty'] - $return;
      
    //   $baQty = $quantityd['Qty'] - $bal;
    //   $cuQty = $quantityd['Qty'] - $returnss;

    //   $balanceQty =  $baQty - $quantityd['balanceTransfer'];
    //   $currentQty =  $cuQty - $quantityd['balanceTransfer'];
    if($Ntransfer_no != ''){
      $sql = " UPDATE product SET  balanceQty ='$balanceQty' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no'"; 
      }else{
        $sql = " UPDATE product SET  balanceQty ='$balanceQty' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' AND ( transfer_no IS NULL OR transfer_no='')"; 
      }  // echo $sql;
      mysqli_query($con ,$sql);  
      if($Ntransfer_no != ''){ 
      $sql = " UPDATE product SET  currentQty ='$currentQty' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no'"; 
      }else{
        $sql = " UPDATE product SET  currentQty ='$currentQty' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' AND ( transfer_no IS NULL OR transfer_no='')"; 
      }  // echo $sql;
      mysqli_query($con ,$sql);        

      }

      else{
       
        if($Ntransfer_no != ''){
       $sql="SELECT balanceDelivery,balanceQty,USD,Qty,balanceUSD FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no'";
        }else{
        $sql="SELECT balanceDelivery,balanceQty,USD,Qty,balanceUSD FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' AND ( transfer_no IS NULL OR transfer_no='')"; 
      }
          $resultW=mysqli_query($con ,$sql);
          while($rows = mysqli_fetch_array($resultW))
         { 
            // $sum += $row['balanceQty'];
            if($rows['balanceQty'] < $Qty || $rows['balanceQty'] > $Qty || $rows['balanceQty'] ==  $Qty)
             {
                 if($rows['balanceQty'] < $Qty){ //50 - 30 = 20
                    // update $rows['balanceQty'];
                     $balanceDeliverys =$rows['balanceDelivery']+ $rows['balanceQty'];
                      $balanceQty    = $rows['balanceQty'] - $rows['balanceQty'];
                      $balanceUSDs   = $rows['USD']* $rows['balanceQty'];
                      $balanceUSDss  = $rows['balanceUSD']+ $balanceUSDs;
                      $p             = $rows['Qty'];
                      if($Ntransfer_no != ''){
                   $sql = " UPDATE product SET balanceDelivery ='$balanceDeliverys',balanceUSD ='$balanceUSDss' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no' and balanceQty='".$rows['balanceQty']."'"; 
                        }else{
                          $sql = " UPDATE product SET balanceDelivery ='$balanceDeliverys',balanceUSD ='$balanceUSDss' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss'  and balanceQty='".$rows['balanceQty']."' AND ( transfer_no IS NULL OR transfer_no='')";  
                        } 
                         mysqli_query($con ,$sql);
                if($Ntransfer_no != ''){
                  $sqlss=" SELECT balanceDelivery,balanceWIP,Qty,balanceReturn,balanceTransfer FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no' and balanceQty='".$rows['balanceQty']."'";
                }else{
                  $sqlss=" SELECT balanceDelivery,balanceWIP,Qty,balanceReturn,balanceTransfer FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss'  and  balanceQty='".$rows['balanceQty']."' AND ( transfer_no IS NULL OR transfer_no='')";
                }
                  $resultss=mysqli_query($con ,$sqlss); 
      $quantityss = $resultss->fetch_assoc();
      $returnss=$quantityss['balanceDelivery']-$quantityss['balanceReturn'];
      $bal=$quantityss['balanceWIP']+ $returnss;
    //   $balanceQty = $quantityss['Qty'] - $bal;
    //   $currentQty = $quantityss['Qty'] - $returnss;
      
         $baQty = $quantityss['Qty'] - $bal;
      $cuQty = $quantityss['Qty'] - $returnss;

      $balanceQty =  $baQty - $quantityss['balanceTransfer'];
      $currentQty =  $cuQty - $quantityss['balanceTransfer'];
      
      if($Ntransfer_no != ''){
       $sql = " UPDATE product SET currentQty ='$currentQty' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no' and balanceQty='".$rows['balanceQty']."'"; 
      }else{
        $sql = " UPDATE product SET currentQty ='$currentQty' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and balanceQty='".$rows['balanceQty']."' AND ( transfer_no IS NULL OR transfer_no='')";  
      }
       mysqli_query($con ,$sql);
      
       if($Ntransfer_no != ''){
      $sql = " UPDATE product SET balanceQty ='$balanceQty' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no' and balanceQty='".$rows['balanceQty']."'";
       }else{
        $sql = " UPDATE product SET balanceQty ='$balanceQty' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss'  and balanceQty='".$rows['balanceQty']."' AND ( transfer_no IS NULL OR transfer_no='')";  
       }
      mysqli_query($con ,$sql); 

                    $Qty = $Qty - $rows['balanceQty'];
             
                    $val = 1;

                 }else if($rows['balanceQty'] > $Qty){
                    //$leftdeliQty_db =  $rows['balanceQty'] - $Qty;
                      $balanceDeliverys=$rows['balanceDelivery']+ $Qty;
                      $balanceQty   = $rows['balanceQty'] - $Qty;
                      $balanceUSDs  = $rows['USD']* $Qty;
                      $balanceUSDss = $rows['balanceUSD']+ $balanceUSDs;
                      $p            = $rows['Qty'];
                      if($Ntransfer_no != ''){
              $sql = " UPDATE product SET balanceDelivery ='$balanceDeliverys',balanceUSD ='$balanceUSDss' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no' and balanceQty!=0"; 
                      }else{
                        $sql = " UPDATE product SET balanceDelivery ='$balanceDeliverys',balanceUSD ='$balanceUSDss' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and balanceQty!=0 AND ( transfer_no IS NULL OR transfer_no='')";
                      }
                mysqli_query($con ,$sql);
            if($Ntransfer_no != ''){
               $sqlss=" SELECT balanceDelivery,balanceWIP,Qty,balanceReturn,balanceTransfer FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and  transfer_no='$Ntransfer_no' and balanceQty!=0";
            }else{
              $sqlss=" SELECT balanceDelivery,balanceWIP,Qty,balanceReturn,balanceTransfer FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location'  and Purchase_order_No ='$txtHintss' and balanceQty!=0 AND ( transfer_no IS NULL OR transfer_no='')";
                }
      
               $resultss=mysqli_query($con ,$sqlss); 
      $quantityss = $resultss->fetch_assoc();
      $returnss=$quantityss['balanceDelivery']-$quantityss['balanceReturn'];
      $bal=$quantityss['balanceWIP']+ $returnss;
      
      

    //   $balanceQty = $quantityss['Qty'] - $bal;
    //   $currentQty = $quantityss['Qty'] - $returnss;
      
        $baQty = $quantityss['Qty'] - $bal;
      $cuQty = $quantityss['Qty'] - $returnss;

      $balanceQty =  $baQty - $quantityss['balanceTransfer'];
      $currentQty =  $cuQty - $quantityss['balanceTransfer'];
      
      

      if($Ntransfer_no != ''){
       $sql = " UPDATE product SET currentQty ='$currentQty' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no' and balanceQty!=0"; 
      }else{
        $sql = " UPDATE product SET currentQty ='$currentQty' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and balanceQty!=0 AND ( transfer_no IS NULL OR transfer_no='')";  
      }
       mysqli_query($con ,$sql);
      
       if($Ntransfer_no != ''){
      $sql = " UPDATE product SET  balanceQty ='$balanceQty' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no' and balanceQty!=0";
       }else{
        $sql = " UPDATE product SET  balanceQty ='$balanceQty' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and balanceQty!=0 AND ( transfer_no IS NULL OR transfer_no='')";
       }
      mysqli_query($con ,$sql);
      
     
                    $Qty = $rows['balanceQty'] - $Qty;
                    $val =0;
                 }else if ($rows['balanceQty'] ==  $Qty){  
                                 
                      $balanceDeliverys =$rows['balanceDelivery']+ $Qty;
                      $balanceQty       = $rows['balanceQty'] - $Qty;
                      $balanceUSDs      = $rows['USD']* $Qty;
                      $balanceUSDss     = $rows['balanceUSD']+ $balanceUSDs;
                      $p                = $rows['Qty'];
                     
              if($Ntransfer_no != ''){
              $sql = " UPDATE product SET balanceDelivery ='$balanceDeliverys',balanceUSD ='$balanceUSDss' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no' and balanceQty!=0"; 
              }else{
                $sql = " UPDATE product SET balanceDelivery ='$balanceDeliverys',balanceUSD ='$balanceUSDss' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and balanceQty!=0 AND ( transfer_no IS NULL OR transfer_no='')"; 
              } 
              mysqli_query($con ,$sql);
              
              if($Ntransfer_no != ''){
              $sqlss=" SELECT balanceDelivery,balanceWIP,Qty,balanceReturn,balanceTransfer FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no' and balanceQty!=0";
              }else{
                $sqlss=" SELECT balanceDelivery,balanceWIP,Qty,balanceReturn,balanceTransfer FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and balanceQty!=0 AND ( transfer_no IS NULL OR transfer_no='')"; 
              }
              $resultss=mysqli_query($con ,$sqlss); 
      $quantityss = $resultss->fetch_assoc();
      $returnss=$quantityss['balanceDelivery']-$quantityss['balanceReturn'];
      $bal=$quantityss['balanceWIP']+ $returnss;

    //   $balanceQty = $quantityss['Qty'] - $bal ;
    //   $currentQty = $quantityss['Qty'] - $returnss;
      
      $baQty = $quantityss['Qty'] - $bal;
      $cuQty = $quantityss['Qty'] - $returnss;

      $balanceQty =  $baQty - $quantityss['balanceTransfer'];
      $currentQty =  $cuQty - $quantityss['balanceTransfer'];

      if($Ntransfer_no != ''){
       $sql = " UPDATE product SET  currentQty ='$currentQty' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no' and balanceQty!=0"; 
      }else{
        $sql = " UPDATE product SET  currentQty ='$currentQty' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and balanceQty!=0 AND ( transfer_no IS NULL OR transfer_no='')"; 
      }
       mysqli_query($con ,$sql);
      
       if($Ntransfer_no != ''){
      $sql = " UPDATE product SET  balanceQty ='$balanceQty' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no' and balanceQty!=0";
       }else{
        $sql = " UPDATE product SET  balanceQty ='$balanceQty' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss' and balanceQty!=0 AND ( transfer_no IS NULL OR transfer_no='')"; 
       }
      mysqli_query($con ,$sql);       
     
                    //$leftdeliQty =0;
                     $Qty = $rows['balanceQty'] - $Qty;
                     $val =0;
                 }
                 if($val == 0){
                      break;
                    } 

                 }               
      
         }
          // var_dump($sum);exit(); 


       } 
      $i += 1;
      

    }
           
     }
              
             $sql = 'INSERT INTO delivery(Location,Customer,Commodity,BrandName,code,Type,PL,Qty,Delivery_date,DO_No,JOB_No,Remark_item,returnQty,Creator,CreateTime,deliveryUSD,transfer_no) VALUES '.implode
      (',', $row_data);
    //   echo $sql;
         mysqli_query($con ,$sql);
         mysqli_commit($con);
         mysqli_close($con);
         echo"<script>alert('Success');</script>";
         echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit; 
    }


}
?>
