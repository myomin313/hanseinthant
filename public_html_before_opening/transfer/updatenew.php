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

      $LUser =$_GET['LUser'];
      $CreateTime= date("Y-m-d H:i:s"); 

      $NType=$_GET['NType']; 
      $txtHintss=$_GET['txtHintss']; 
      $NQty=$_GET['NQty']; 

      $NBrandName = mysqli_real_escape_string($con,$_GET['NBrandName']);   
      $NCommodity = mysqli_real_escape_string($con,$_GET['NCommodity']); 
      $code = mysqli_real_escape_string($con,$_GET['code']);  
      $NRemark = mysqli_real_escape_string($con,$_GET['NRemark']); 

      $transfer_from=$_GET['transfer_from'];
      $transfer_to=$_GET['transfer_to'];  
      $transfer_date=$_GET['transfer_date']; 
      $transfer_no=$_GET['transfer_no'];
      $Ntransfer_no=$_GET['Ntransfer_no'];

      $id=$_GET['id'];

      
     if( $Ntransfer_no != ''){  
   $sqlA = "SELECT DISTINCT BrandName,Commodity,PL FROM transfer WHERE BrandName ='$NBrandName' and Commodity= '$NCommodity' and code='$code' and PL = '$txtHintss' and transfer_from= '$transfer_from' and transfer_to = '$transfer_to' and transfer_no = '$transfer_no' and ptransfer_no='$Ntransfer_no'";
    }else{
     $sqlA = "SELECT DISTINCT BrandName,Commodity,PL FROM transfer WHERE BrandName ='$NBrandName' and Commodity= '$NCommodity' and code='$code' and PL = '$txtHintss' and transfer_from= '$transfer_from' and transfer_to = '$transfer_to' and transfer_no = '$transfer_no' AND ( ptransfer_no IS NULL OR ptransfer_no='')";
    }
        $resultA=mysqli_query($con ,$sqlA); 
        $row = $resultA->fetch_assoc();
        $count=mysqli_num_rows($resultA);
 if($count==1)
             {
              echo"<script>alert('Your item  already exist in transfer.Please try again!');</script>"; 
                echo "<script type='text/javascript'>window.top.location='detail.php?ID=$id&transfer_no=$transfer_no';</script>";exit;  
              
              }  
  else{ 
    
    if( $Ntransfer_no != ''){
      $sqlW="SELECT currentQty,USD FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$code' and Branch ='$transfer_from' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no'";
    }else{
      $sqlW="SELECT currentQty,USD FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$code' and Branch ='$transfer_from' 
      and Purchase_order_No ='$txtHintss' AND ( transfer_no IS NULL OR transfer_no='')";
    }
      $resultW=mysqli_query($con ,$sqlW); 
      $rowsW = $resultW->fetch_assoc();
      $transferUSD =  $NQty * $rowsW['USD'];

    //  var_dump($deliveryUSD);exit();      
      
     if($NQty > $rowsW['currentQty']){
                echo"<script>alert('Your Quantity is not enough .Please try again!');</script>"; 
                  
                echo "<script type='text/javascript'>window.top.location='detail.php?ID=$id&transfer_no=$transfer_no';</script>";exit;  
               }
    else{
        
      if( $Ntransfer_no != ''){
        $sql="SELECT balanceTransfer,balanceDelivery,balanceQty,USD,Qty,balanceUSD FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$code' and Branch ='$transfer_from' and Purchase_order_No ='$txtHintss'  and transfer_no='$Ntransfer_no'";
      }else{
        $sql="SELECT balanceTransfer,balanceDelivery,balanceQty,USD,Qty,balanceUSD FROM product Where BrandName = '$NBrandName' and 
        Commodity ='$NCommodity' and code='$code' and Branch ='$transfer_from' and Purchase_order_No ='$txtHintss' AND ( transfer_no IS NULL OR transfer_no='')"; 
      }
      $result=mysqli_query($con ,$sql); 
      $rows = $result->fetch_assoc();
      $balanceTransfers = $rows['balanceTransfer'] + $NQty;
      if( $Ntransfer_no != ''){
      $sql = "UPDATE product SET balanceTransfer ='$balanceTransfers' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$code' and Branch ='$transfer_from' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no'"; 
      }else{
        $sql = "UPDATE product SET balanceTransfer ='$balanceTransfers' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$code' and Branch ='$transfer_from' 
        and Purchase_order_No ='$txtHintss' AND ( transfer_no IS NULL OR transfer_no='')"; 
      }
      // echo $sql;
      mysqli_query($con ,$sql);
      
      if( $Ntransfer_no != ''){
      $sqlsss="SELECT balanceDelivery,balanceTransfer,balanceQty,USD,Qty,balanceUSD,currentQty FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$code' and Branch ='$transfer_from' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no'";
      }else{
        $sqlsss="SELECT balanceDelivery,balanceTransfer,balanceQty,USD,Qty,balanceUSD,currentQty FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$code' and Branch ='$transfer_from' and Purchase_order_No ='$txtHintss' AND ( transfer_no IS NULL OR transfer_no='')";  
      }
      
      $resultsss=mysqli_query($con ,$sqlsss); 
      $rowsss = $resultsss->fetch_assoc();
 
       $batd = $rowsss['balanceTransfer']+$rowsss['balanceDelivery'];
      $balanceUSDs = $rowsss['USD']* $batd; 
      if( $Ntransfer_no != ''){
      $sql = " UPDATE product SET balanceUSD ='$balanceUSDs' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$code' and Branch ='$transfer_from' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no'"; 
      }else{
        $sql = " UPDATE product SET balanceUSD ='$balanceUSDs' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$code' and Branch ='$transfer_from' and Purchase_order_No ='$txtHintss' AND ( transfer_no IS NULL OR transfer_no='')"; 
      }// echo $sql;
      mysqli_query($con ,$sql);



     
      $remain_currentQty=$rowsss['currentQty'] - $NQty;
      $remain_balanceQty=$rowsss['balanceQty'] - $NQty;

      if( $Ntransfer_no != ''){
       $sqlpupdate = "UPDATE product SET balanceQty='$remain_balanceQty',currentQty ='$remain_currentQty' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$code' and Branch ='$transfer_from' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no'";  
      }else{
        $sqlpupdate = "UPDATE product SET balanceQty='$remain_balanceQty',currentQty ='$remain_currentQty' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$code' and Branch ='$transfer_from' and Purchase_order_No ='$txtHintss' AND ( transfer_no IS NULL OR transfer_no='')"; 
      }
      mysqli_query($con,$sqlpupdate); 






      // $sqlh="SELECT balanceTransfer,balanceDelivery,balanceWIP,Qty,balanceReturn FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss'";
      // $resulth=mysqli_query($con,$sqlh); 
      // $quantityh = $resulth->fetch_assoc();
      // $return=$quantityh['balanceTransfer'] - $quantityh['balanceReturn'];
      // $bal=$quantityh['balanceWIP']+$return;
   
      // $balanceQty = $quantityh['Qty'] - $bal;

      // $sql = " UPDATE product SET  balanceQty ='$balanceQty' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss'";
      //  $sql;
      // mysqli_query($con ,$sql); 
      
      // myo min start
      //  $currentQty = $quantityh['Qty'] - $return;
      //  $sqlmyo = " UPDATE product SET  currentQty ='$currentQty' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$code' and Branch ='$Location' and Purchase_order_No ='$txtHintss'";
      //  mysqli_query($con ,$sqlmyo);
       // echo $sql;
       // myo min end
       
   $returnQty=0;
   $sqlda="INSERT INTO transfer(transfer_from,transfer_to,BrandName,Commodity,code,Type,Qty,transferUSD,PL,Remark_Item,transfer_date,transfer_no,ptransfer_no,Creator,CreateTime) VALUES ('$transfer_from','$transfer_to','$NBrandName','$NCommodity','$code','$NType','$NQty','$transferUSD','$txtHintss','$NRemark','$transfer_date','$transfer_no','$Ntransfer_no','$LUser','$CreateTime')";
   mysqli_query($con,$sqlda);    
                  
                 $status ="New";
                $input_ID=0;
                $sql="INSERT INTO transfer_history(input_ID,transfer_from,Otransfer_from,BrandName,OBrandName,Commodity,OCommodity,code,Ocode,Remark_Item,ORemark_Item,transfer_date,Otransfer_date,transfer_no,Otransfer_no,Qty,OQty,PL,OPL,Type,OType,transfer_to,Otransfer_to,RecordTime,Recorder,status) 
                VALUES ('$input_ID','$transfer_from','','$NBrandName','','$NCommodity','','$code','','$NRemark','','$transfer_date','','$transfer_no','','$NQty','','$txtHintss','','$NType','','$transfer_to','','$CreateTime','$LUser','$status')";      
                    // echo $sql;
                
                  if( $Ntransfer_no != ''){
                    $sqlp="SELECT * FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$transfer_from' and Purchase_order_No ='$txtHintss' and transfer_no='$Ntransfer_no'";
                  }else{
                     $sqlp="SELECT * FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$transfer_from' and Purchase_order_No ='$txtHintss' AND ( transfer_no IS NULL OR transfer_no='')";  
                  }
                    $resultp=mysqli_query($con ,$sqlp);
                    $rowp = $resultp->fetch_assoc();
                    $OSupplierName=$rowp['SupplierName'];
                    $OBrandName=$rowp['BrandName'];
                    $OCommodity=$rowp['Commodity'];
                    $Ocode=$rowp['code'];
                    $Branch=$transfer_to;
                    $Remarks_Item= $NRemark;
                    $Packing_date= $rowp['Packing_date'];
                    $Purchase_order_no= $transfer_no;
                    $OPO_NO=$rowp['PO_NO'];
                    $Qty=$NQty;
                    $ORate_Name=$rowp['Rate_Name'];
                    $Orate=$rowp['rate'];
                    $OtotalRate=$rowp['rate'] * $NQty;
                    $OUSD=$rowp['USD'];
                    $OtotalUSD=$rowp['USD'] * $NQty;
                    $OType=$rowp['Type'];
                    $ObalanceQty=$rowp['balanceQty'];
                    $OcurrentQty=$rowp['currentQty'];
                    $ObalanceWIP=0;
                    $ObalanceDelivery=0;
                    $ObalanceUSD=0;
                    $ObalanceReturn=0;
                    $OCreateTime=date("Y-m-d H:i:s");
                    $OCreator=$LUser;

                    $row_pdatas[]="('$OSupplierName','$NBrandName','$NCommodity','$code','$Branch','$Remarks_Item','$transfer_date',
        '$txtHintss','$OPO_NO','$Qty','$OType','USD','$OUSD','$OtotalUSD','$OUSD','$OtotalUSD','$NQty','$NQty','$ObalanceWIP','$ObalanceDelivery',
        '$ObalanceUSD','$ObalanceReturn','$OCreateTime','$OCreator','$transfer_no')";


        $osql='INSERT INTO product(SupplierName,BrandName,Commodity,code,Branch,Remarks_Item,Packing_date,Purchase_order_No,PO_NO,Qty,Type,Rate_Name,rate,totalRate,USD,totalUSD,balanceQty,currentQty,balanceWIP,balanceDelivery,balanceUSD,balanceReturn,CreateTime,Creator,transfer_no) VALUES '.implode(',', $row_pdatas);
          mysqli_query($con,$osql);
        //end            
                echo "<script type='text/javascript'>window.top.location='detail.php?ID=$id&transfer_no=$transfer_no';</script>";exit;       
    
 
}
}
?>