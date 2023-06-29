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
      $NRemark = mysqli_real_escape_string($con,$_GET['NRemark']);   
      $okyaku = mysqli_real_escape_string($con,$_GET['okyaku']);   

      $Location=$_GET['Location']; 
      $Delivery_date=$_GET['Delivery_date']; 
      $DO_No=$_GET['DO_No']; 
      $JOB_No=$_GET['JOB_No'];
      
   $sqlA = "SELECT DISTINCT BrandName,Commodity,PL FROM delivery WHERE BrandName ='$NBrandName' and Commodity= '$NCommodity' and PL = '$txtHintss' and Location= '$Location' and Customer = '$okyaku' and DO_No = '$DO_No'";
        $resultA=mysqli_query($con ,$sqlA); 
        $row = $resultA->fetch_assoc();
        $count=mysqli_num_rows($resultA);
 if($count==1)
             {
              echo"<script>alert('Your item  already exist in Delivery.Please try again!');</script>"; 
                echo "<script type='text/javascript'>window.top.location='detail.php?ID=$okyaku&DO=$DO_No';</script>";exit;  
              
              }  
  else{       
      $sqlW="SELECT currentQty FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$txtHintss'";

      $resultW=mysqli_query($con ,$sqlW); 
      $rowsW = $resultW->fetch_assoc();
      
     if($NQty > $rowsW['currentQty']){
                echo"<script>alert('Your Quantity is not enough .Please try again!');</script>"; 
                  
                echo "<script type='text/javascript'>window.top.location='detail.php?ID=$okyaku&DO=$DO_No';</script>";exit;  
               }
    else{
        
      if ($JOB_No <> '') {
      $sql="SELECT balanceWIP FROM job Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Location ='$Location' and PL ='$txtHintss'  and JOB_No ='$JOB_No'"; 
      $result=mysqli_query($con ,$sql); 
      $rowsss = $result->fetch_assoc();  
      $oldWIP= $rowsss['balanceWIP'];
      $newWIP =  $oldWIP + $NQty;
      $sql = " UPDATE job SET balanceWIP ='$newWIP' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Location ='$Location' and PL ='$txtHintss' and Customer ='$okyaku' and JOB_No ='$JOB_No'"; 
      // echo $sql;
      mysqli_query($con ,$sql);
      $sql="SELECT balanceWIP,WIP,balanceJOB FROM job Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Location ='$Location' and PL ='$txtHintss' and Customer ='$okyaku' and JOB_No ='$JOB_No'"; 
      $result=mysqli_query($con ,$sql); 
      $rows = $result->fetch_assoc();
      
              if ($rows['WIP'] > $rows['balanceWIP'] ) {
               $wipJOB = $rows['WIP']-$rows['balanceWIP'];          
                   }
              elseif ($rows['balanceJOB'] < $rows['WIP'] ) {
                $wipJOB = 0;
              }
               else {
                $wipJOB =0;
              }  
      $sql = " UPDATE job SET balanceJOB ='$wipJOB' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Location ='$Location' and PL ='$txtHintss' and Customer ='$okyaku' and JOB_No ='$JOB_No'"; 
      // echo $sql;
      mysqli_query($con ,$sql);
      $sql="SELECT SUM(balanceJOB) as sumJOB FROM job Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Location ='$Location' and PL ='$txtHintss'  "; 
      $result=mysqli_query($con ,$sql); 
      $rows = $result->fetch_assoc();   
      $sumJOB = $rows['sumJOB'];      

       $sql = " UPDATE product SET  balanceWIP ='$sumJOB' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$txtHintss'";     
       // echo $sql; 
        mysqli_query($con ,$sql);


      $sql="SELECT balanceDelivery,balanceQty,USD FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$txtHintss'";
      $result=mysqli_query($con ,$sql); 
      $rows = $result->fetch_assoc();
       $remain= $rows['balanceDelivery']+ $NQty;     
       $sql = " UPDATE product SET  balanceDelivery ='$remain' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$txtHintss'";     
       // echo $sql; 
        mysqli_query($con ,$sql);

      $sqlQ="SELECT balanceDelivery,balanceQty,USD FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$txtHintss'";
      $resultQ=mysqli_query($con ,$sqlQ); 
      $rowQ = $resultQ->fetch_assoc();
      $balanceUSD = $rowQ['USD']* $rowQ['balanceDelivery'];

       $sql = " UPDATE product SET  balanceUSD ='$balanceUSD' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$txtHintss'";     
       // echo $sql; 
        mysqli_query($con ,$sql);
      $sqld="SELECT balanceDelivery,balanceWIP,Qty,balanceReturn FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$txtHintss'";
      $resultd=mysqli_query($con ,$sqld); 
      $quantityd = $resultd->fetch_assoc();
      $return=$quantityd['balanceDelivery']-$quantityd['balanceReturn'];
      $bal=$quantityd['balanceWIP']+ $return;
   
      $balanceQty = $quantityd['Qty'] - $bal ;
      $currentQty = $quantityd['Qty'] - $return;
      $sql = " UPDATE product SET  balanceQty ='$balanceQty' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$txtHintss'"; 
       // echo $sql;
      mysqli_query($con ,$sql);
        // myo min start
       $sqlmyo = " UPDATE product SET  currentQty ='$currentQty' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$txtHintss'"; 
        mysqli_query($con ,$sqlmyo); 
        // echo $sql;
         // myo min end
      
 $returnQty=0;

$sql="INSERT INTO delivery (Location,Customer,Commodity,BrandName,Type,PL,Qty,Delivery_date,DO_No,JOB_No,Remark_item,returnQty,Creator,CreateTime) VALUES ('$Location','$okyaku','$NCommodity','$NBrandName','$NType','$txtHintss','$NQty','$Delivery_date','$DO_No','$JOB_No','$NRemark','$returnQty','$LUser','$CreateTime')";

    // echo $sql;

  mysqli_query($con,$sql);    
                  
                 $status ="New";
                $input_ID=0;
                $sql="INSERT INTO delivery_history(input_ID,Customer,OCustomer,BrandName,OBrandName,Commodity,OCommodity,Remark_Item,ORemark_Item,Delivery_date,ODelivery_date,DO_No,ODO_No,JOB_No,OJOB_No,Qty,OQty,PL,OPL,Type,OType,Location,OLocation,RecordTime,Recorder,status) 
                VALUES ('$input_ID','$okyaku','','$NBrandName','','$NCommodity','','$NRemark','','$Delivery_date','','$DO_No','','$JOB_No','','$NQty','','$txtHintss','','$NType','','$Location','','$CreateTime','$LUser','$status')";      
                    // echo $sql;

                 mysqli_query($con,$sql); 
                                    
                echo "<script type='text/javascript'>window.top.location='detail.php?ID=$okyaku&DO=$DO_No';</script>";exit;       

      }

      else{
      $sql="SELECT balanceDelivery,balanceQty,USD,Qty,balanceUSD FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$txtHintss'";
      $result=mysqli_query($con ,$sql); 
      $rows = $result->fetch_assoc();
      $balanceDeliverys = $rows['balanceDelivery'] + $NQty;
     
      $sql = " UPDATE product SET balanceDelivery ='$balanceDeliverys' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$txtHintss'"; 
      // echo $sql;
      mysqli_query($con ,$sql);

      $sqlsss="SELECT balanceDelivery,balanceQty,USD,Qty,balanceUSD FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$txtHintss'";
      $resultsss=mysqli_query($con ,$sqlsss); 
      $rowsss = $resultsss->fetch_assoc();

      $balanceUSDs = $rowsss['USD']* $rowsss['balanceDelivery']; 

      $sql = " UPDATE product SET balanceUSD ='$balanceUSDs' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$txtHintss'"; 
      // echo $sql;
      mysqli_query($con ,$sql);



       $sqlh="SELECT balanceDelivery,balanceWIP,Qty,balanceReturn FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$txtHintss'";
      $resulth=mysqli_query($con ,$sqlh); 
      $quantityh = $resulth->fetch_assoc();
       $return=$quantityh['balanceDelivery']-$quantityh['balanceReturn'];
       $bal=$quantityh['balanceWIP']+ $return;
   
      $balanceQty = $quantityh['Qty'] - $bal ;

      $sql = " UPDATE product SET  balanceQty ='$balanceQty' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$txtHintss'";
       $sql;
      mysqli_query($con ,$sql); 
      
      // myo min start
        $currentQty = $quantityh['Qty'] - $return;
       $sqlmyo = " UPDATE product SET  currentQty ='$currentQty' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$txtHintss'";
        mysqli_query($con ,$sqlmyo);
       // echo $sql;
       // myo min end
       
 $returnQty=0;

$sql="INSERT INTO delivery (Location,Customer,Commodity,BrandName,Type,PL,Qty,Delivery_date,DO_No,JOB_No,Remark_item,returnQty,Creator,CreateTime) VALUES ('$Location','$okyaku','$NCommodity','$NBrandName','$NType','$txtHintss','$NQty','$Delivery_date','$DO_No','$JOB_No','$NRemark','$returnQty','$LUser','$CreateTime')";

    // echo $sql;

  mysqli_query($con,$sql);    
                  
                 $status ="New";
                $input_ID=0;
                $sql="INSERT INTO delivery_history(input_ID,Customer,OCustomer,BrandName,OBrandName,Commodity,OCommodity,Remark_Item,ORemark_Item,Delivery_date,ODelivery_date,DO_No,ODO_No,JOB_No,OJOB_No,Qty,OQty,PL,OPL,Type,OType,Location,OLocation,RecordTime,Recorder,status) 
                VALUES ('$input_ID','$okyaku','','$NBrandName','','$NCommodity','','$NRemark','','$Delivery_date','','$DO_No','','$JOB_No','','$NQty','','$txtHintss','','$NType','','$Location','','$CreateTime','$LUser','$status')";      
                    // echo $sql;

                 mysqli_query($con,$sql); 
                                    
                echo "<script type='text/javascript'>window.top.location='detail.php?ID=$okyaku&DO=$DO_No';</script>";exit;       
      }
 
}
}
?>