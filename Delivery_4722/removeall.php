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

      $okyaku=$_GET['okyaku']; 
      $Location=$_GET['Location']; 
      // $Delivery_date=$_GET['Delivery_date']; 
      $DO_No=$_GET['DO_No'].''.$_GET['dep_name']; 
      $JOB_No=$_GET['JOB_No'];
      $ids=$_GET['ids']; 

      // $Commodity = mysqli_real_escape_string($con,$_GET['Commodity']);
      // $BrandName = mysqli_real_escape_string($con,$_GET['BrandName']);
      // $Remark_item = mysqli_real_escape_string($con,$_GET['Remark_item']);              

      // $Types=$_GET['Type']; 
      // $Qty=$_GET['Qty']; 
      // $PL=$_GET['PL']; 
                  $OCustomer="";
                  $OBrandName ="";
                  $OCommodity ="";
                  $Ocode="";
                  $ORemark_Item ="";
                  $ODelivery_date ="";
                  $ODO_No ="";
                  $OJOB_No ="";
                  $OQty ="";
                  $PL ="";
                  $Otransfer_no ="";
                  $OType ="";
                  $OLocation ="";
                  $RecordTime =date("Y-m-d H:i:s");
                  $Recorder =$_GET['LUser'];     
                  $status ="Delete";
                  $idarray = explode(',', $ids);

       foreach($idarray as $id) {
                                   
                  $sql="SELECT * FROM delivery WHERE  id = '$id' ";
                  $results=mysqli_query($con ,$sql); 
                  $row = $results->fetch_assoc();
                  $OCustomer = mysqli_real_escape_string($con,$row['Customer']);
                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $Ocode = mysqli_real_escape_string($con,$row['code']);
                  $ORemark_Item = mysqli_real_escape_string($con,$row['Remark_item']);

                  $ODelivery_date= $row['Delivery_date'];
                  $ODO_No= $row['DO_No'];
                  $OJOB_No= $row['JOB_No'];
                  $OQty= $row['Qty'];
                  $ODelivery_date= $row['Delivery_date'];
                  $OPL= $row['PL'];
                  $Otransfer_no =$row['transfer_no'];
                  $OType= $row['Type'];
                  $OLocation= $row['Location'];    
       $sqlS = "SELECT Distinct DO_No,department,Customer,Commodity,BrandName,PL  FROM returns WHERE DO_No ='$DO_No' and Commodity ='$OCommodity' and code='$Ocode' and BrandName ='$OBrandName'and Customer ='$okyaku' and department ='$Location'  and PL ='$OPL'";
        // echo $sqlS;
        $resultS=mysqli_query($con ,$sqlS); 
        $rowS = $resultS->fetch_assoc();
                  $countS=mysqli_num_rows($resultS);
      if($countS==1)
                  {
                   echo"<script>alert('Your DO No. is connected to Customer Return.Please remove Customer Return. first!');</script>";  
                echo "<script type='text/javascript'>window.top.location='detail.php?ID=$okyaku&DO=$DO_No';</script>";exit;
                  }else{ 
                $sql="INSERT INTO delivery_history(input_ID,Customer,OCustomer,OBrandName,OCommodity,Ocode,Remark_Item,ORemark_Item,Delivery_date,ODelivery_date,DO_No,ODO_No,JOB_No,OJOB_No,Qty,OQty,PL,OPL,Type,OType,Location,OLocation,RecordTime,Recorder,status) 
                VALUES ('$id','','$OCustomer','$OBrandName','$OCommodity','$Ocode','','$ORemark_Item','','$ODelivery_date','','$ODO_No','','$OJOB_No','','$OQty','','$OPL','','$OType','','$OLocation','$RecordTime','$Recorder','$status')";                   
                //   echo $sql;
                  mysqli_query($con ,$sql);
      if( $Otransfer_no != ''){
        $sqlproduct="SELECT balanceTransfer,Qty,balanceQty,USD,balanceUSD,balanceWIP,balanceDelivery,balanceReturn FROM product Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL' and transfer_no='$Otransfer_no'";
      }else{
        $sqlproduct="SELECT balanceTransfer,Qty,balanceQty,USD,balanceUSD,balanceWIP,balanceDelivery,balanceReturn FROM product Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL'";
      }
      $resultproduct=mysqli_query($con ,$sqlproduct); 
      $product = $resultproduct->fetch_assoc();   

      $sqljob="SELECT * FROM job Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Location ='$Location' and PL ='$OPL' and Job_No ='$JOB_No'";
      $resultjob=mysqli_query($con ,$sqljob); 
      $job = $resultjob->fetch_assoc();  

    //   $sqldelivery="SELECT * FROM delivery Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and Location ='$Location' and PL ='$OPL' and JOB_No ='$JOB_No'";
      $sqldelivery="SELECT * FROM delivery WHERE  id = '$id' and JOB_No ='$JOB_No'";
      
      
      $resultdelivery=mysqli_query($con ,$sqldelivery); 
      $delivery = $resultdelivery->fetch_assoc();    

      if ($JOB_No <> '') {

      if ($delivery['Qty']> $job['WIP']) {
            $big = $delivery['Qty']-$job['WIP'];
            $bigResult= $delivery['Qty']- $big;

      $productDelivery = $product['balanceDelivery']-$delivery['Qty'];
      $productJob = $product['balanceWIP']+ $job['WIP'];
      $jobbalanceWIP = $job['balanceWIP'] - $delivery['Qty'];

              if ($job['WIP'] > $job['balanceWIP'] ) {
               $wipJOB = $job['WIP']-$job['balanceWIP'];          
                   }

              else{
                $wipJOB =$job['WIP'];
              }       
      
    if($Otransfer_no != ''){
      $sql = " UPDATE product SET  balanceWIP ='$productJob',balanceDelivery ='$productDelivery' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL' and transfer_no='$Otransfer_no'"; 
    }else{
      $sql = " UPDATE product SET  balanceWIP ='$productJob',balanceDelivery ='$productDelivery' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL'"; 
    } // echo $sql;
      mysqli_query($con ,$sql); 

      $sql = " UPDATE job SET  balanceWIP ='$jobbalanceWIP',balanceJOB ='$wipJOB' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Location ='$Location'and Job_No ='$JOB_No' and PL ='$OPL'"; 
      // echo $sql;
      mysqli_query($con ,$sql);           
      }else{
        
      $productDelivery = $product['balanceDelivery']-$delivery['Qty'];
      $productJob = $product['balanceWIP']+ $delivery['Qty'];
      $jobbalanceWIP = $job['balanceWIP'] - $delivery['Qty'];   
      $wipJOBs = $job['balanceWIP'] + $job['balanceJOB'];
      
      if( $Otransfer_no != ''){
      $sql = " UPDATE product SET  balanceWIP ='$productJob',balanceDelivery ='$productDelivery' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL' and transfer_no='$Otransfer_no'"; 
      }else{
        $sql = " UPDATE product SET  balanceWIP ='$productJob',balanceDelivery ='$productDelivery' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL'"; 
      }
      // echo $sql;
      mysqli_query($con ,$sql); 

      $sql = " UPDATE job SET  balanceWIP ='$jobbalanceWIP',balanceJOB ='$wipJOBs' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Location ='$Location'and Job_No ='$JOB_No' and PL ='$OPL'"; 
      // echo $sql;
      mysqli_query($con ,$sql); 

      }

      $tdresult = $product['balanceDelivery']+$product['balanceTransfer'];
      $deliresult =  $tdresult - $product['balanceReturn'];
      $productremain = $deliresult+$product['balanceWIP'];
      $remain = $product['Qty']- $productremain;

      if( $Otransfer_no != ''){
      $sql = " UPDATE product SET  balanceQty ='$remain' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL' and transfer_no='$Otransfer_no'"; 
       }else{
        $sql = " UPDATE product SET  balanceQty ='$remain' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL'"; 
       } // echo $sql;
      mysqli_query($con ,$sql); 
      if( $Otransfer_no != ''){
      $sqlQ="SELECT * FROM product Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL' and transfer_no='$Otransfer_no'";
      }else{
        $sqlQ="SELECT * FROM product Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL'"; 
      }
      $resultQ=mysqli_query($con ,$sqlQ); 
      $rowQ = $resultQ->fetch_assoc();    
      
      $tdresultQ = $rowQ['balanceDelivery']+$rowQ['balanceTransfer'];
      $deliresultQ = $tdresultQ - $rowQ['balanceReturn'];
      $currentQty = $rowQ['Qty']- $deliresultQ;
      
      $balanceUSD = $rowQ['USD'] * $deliresultQ;

      if( $Otransfer_no != ''){
      $sqlSSaa = " UPDATE product SET  currentQty ='$currentQty' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL' and transfer_no='$Otransfer_no'"; 
      }else{
        $sqlSSaa = " UPDATE product SET  currentQty ='$currentQty' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL'";  
      }
      //   echo $sqlSSaa;
      mysqli_query($con ,$sqlSSaa);        
      if( $Otransfer_no != ''){
      $sql = " UPDATE product SET  balanceUSD ='$balanceUSD' where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL' and transfer_no='$Otransfer_no'"; 
      }else{
        $sql = " UPDATE product SET  balanceUSD ='$balanceUSD' where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL'";  
      }
      //   echo $sql;
      mysqli_query($con ,$sql);
 
      
$sql="DELETE FROM delivery where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Location ='$Location'and  id='$id' AND Customer='$okyaku' AND DO_No='$DO_No' ";

  mysqli_query($con ,$sql);
  // echo"<script>alert('Successfully Deleted');</script>"; 
  // echo "<script type='text/javascript'>window.top.location='detail.php?ID=$okyaku&DO=$DO_No';</script>";exit;     

}else{

      $nojob = $product['balanceDelivery'] - $delivery['Qty'];
  
      if( $Otransfer_no != ''){
      $sql = " UPDATE product SET  balanceDelivery ='$nojob' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL' and transfer_no='$Otransfer_no'"; 
      }else{
        $sql = " UPDATE product SET  balanceDelivery ='$nojob' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL'";
      }// echo $sql;
      mysqli_query($con ,$sql);  
      if( $Otransfer_no != ''){  
      $sqlproducts="SELECT balanceTransfer,Qty,balanceQty,USD,balanceUSD,balanceWIP,balanceDelivery,balanceReturn FROM product Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL' and transfer_no='$Otransfer_no'";
      }else{
        $sqlproducts="SELECT balanceTransfer,Qty,balanceQty,USD,balanceUSD,balanceWIP,balanceDelivery,balanceReturn FROM product Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL'";  
      }
      $resultproducts=mysqli_query($con ,$sqlproducts); 
      $products = $resultproducts->fetch_assoc();   

      $tdresults = $products['balanceDelivery']+$products['balanceTransfer'];
      $deliresults = $tdresults-$products['balanceReturn'];
      $productremains = $deliresults+$products['balanceWIP'];
      $remains = $products['Qty']- $productremains;
      
      $currentQty = $products['Qty']- $deliresults;
      
      if( $Otransfer_no != ''){
      $sql = " UPDATE product SET  balanceQty ='$remains' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL' and transfer_no='$Otransfer_no'"; 
      }else{
        $sql = " UPDATE product SET  balanceQty ='$remains' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL'";
      }// echo $sql;
      mysqli_query($con ,$sql);     
      
      if( $Otransfer_no != ''){
      $sqlQs="SELECT * FROM product Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL' and transfer_no='$Otransfer_no'";
      }else{
        $sqlQs="SELECT * FROM product Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL'";
      }
      $resultQs=mysqli_query($con ,$sqlQs); 
      $rowQs = $resultQs->fetch_assoc();    
      
      $tdresultQs = $rowQs['balanceDelivery']+$rowQs['balanceTransfer'];
      $deliresultQs = $tdresultQs-$rowQs['balanceReturn'];
      $currentQtys = $rowQs['Qty']- $deliresultQs;
      
      $balanceUSDs = $rowQs['USD'] * $deliresultQs;      
      
      if( $Otransfer_no != ''){
      $sqlSS = " UPDATE product SET  currentQty ='$currentQtys' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL' and transfer_no='$Otransfer_no'"; 
      }else{
        $sqlSS = " UPDATE product SET  currentQty ='$currentQtys' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL'";  
      }
       //   echo $sql;
      mysqli_query($con ,$sqlSS);        
    if( $Otransfer_no != ''){
      $sql = " UPDATE product SET  balanceUSD='$balanceUSDs' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL' and transfer_no='$Otransfer_no'"; 
    }else{
      $sql = " UPDATE product SET  balanceUSD='$balanceUSDs' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$Location' and Purchase_order_No ='$OPL'";
    }
      //   echo $sql;
      mysqli_query($con ,$sql);  

        
      $sqld="DELETE FROM delivery WHERE id='$id'";       
      mysqli_query($con ,$sqld);

      
    }

  }    
}
echo"<script>alert('Successfully Deleted');</script>"; 
echo "<script type='text/javascript'>window.top.location='detail.php?ID=$okyaku&DO=$DO_No';</script>";exit;
// }
?>