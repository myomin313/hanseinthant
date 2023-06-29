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
      $Delivery_date=$_GET['Delivery_date']; 
      $DO_No=$_GET['DO_No'].''.$_GET['dep_name']; 
      $JOB_No=$_GET['JOB_No']; 

      $id=$_GET['id']; 

      $Commodity = mysqli_real_escape_string($con,$_GET['Commodity']);
      $BrandName = mysqli_real_escape_string($con,$_GET['BrandName']);
      $Remark_item = mysqli_real_escape_string($con,$_GET['Remark_item']);    
      
      /*$Commodity = $_GET['Commodity'];
      $BrandName = $_GET['BrandName'];
      $Remark_item = $_GET['Remark_item']; */
      

      $Types=$_GET['Type']; 
      $Qty=$_GET['Qty']; 
      $PL=$_GET['PL']; 
                  $OCustomer="";
                  $OBrandName ="";
                  $OCommodity ="";
                  $ORemark_Item ="";
                  $ODelivery_date ="";
                  $ODO_No ="";
                  $OJOB_No ="";
                  $OQty ="";
                  $PL ="";
                  $OType ="";
                  $OLocation ="";
                  $RecordTime =date("Y-m-d H:i:s");
                  $Recorder =$_GET['LUser'];     
                  $status ="Delete";
                                   
                  $sql="SELECT * FROM delivery WHERE  id = '$id' ";
                  $results=mysqli_query($con ,$sql); 
                  $row = $results->fetch_assoc();
                  $OCustomer = mysqli_real_escape_string($con,$row['Customer']);
                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $ORemark_Item = mysqli_real_escape_string($con,$row['Remark_item']);

                  $ODelivery_date= $row['Delivery_date'];
                  $ODO_No= $row['DO_No'];
                  $OJOB_No= $row['JOB_No'];
                  $OQty= $row['Qty'];
                  $ODelivery_date= $row['Delivery_date'];
                  $OPL= $row['PL'];
                  $OType= $row['Type'];
                  $OLocation= $row['Location'];    
       $sqlS = "SELECT Distinct DO_No,department,Customer,Commodity,BrandName,PL  FROM returns WHERE DO_No ='$DO_No' and Commodity ='$Commodity' and BrandName ='$BrandName'and Customer ='$okyaku' and department ='$Location'  and PL ='".$_GET['PL']."'";
        // echo $sqlS;
        $resultS=mysqli_query($con ,$sqlS); 
        $rowS = $resultS->fetch_assoc();
                  $countS=mysqli_num_rows($resultS);
      if($countS==1)
                  {
                   echo"<script>alert('Your DO No. is connected to Customer Return.Please remove Customer Return. first!');</script>";  
                echo "<script type='text/javascript'>window.top.location='detail.php?ID=$okyaku&DO=$DO_No';</script>";exit;
                  }  
      else{   
          
                $sql="INSERT INTO delivery_history(input_ID,Customer,OCustomer,BrandName,OBrandName,Commodity,OCommodity,Remark_Item,ORemark_Item,Delivery_date,ODelivery_date,DO_No,ODO_No,JOB_No,OJOB_No,Qty,OQty,PL,OPL,Type,OType,Location,OLocation,RecordTime,Recorder,status) 
                VALUES ('$id','','$OCustomer','','$OBrandName','','$OCommodity','','$ORemark_Item','','$ODelivery_date','','$ODO_No','','$OJOB_No','','$OQty','','$OPL','','$OType','','$OLocation','$RecordTime','$Recorder','$status')";                   
                //   echo $sql;
                  mysqli_query($con ,$sql);
      $sqlproduct="SELECT Qty,balanceQty,USD,balanceUSD,balanceWIP,balanceDelivery,balanceReturn FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='".$_GET['PL']."'";
      $resultproduct=mysqli_query($con ,$sqlproduct); 
      $product = $resultproduct->fetch_assoc();   

      $sqljob="SELECT * FROM job Where BrandName = '$BrandName' and Commodity ='$Commodity' and Location ='$Location' and PL ='".$_GET['PL']."' and Job_No ='$JOB_No'";
      $resultjob=mysqli_query($con ,$sqljob); 
      $job = $resultjob->fetch_assoc();  

      //$sqldelivery="SELECT * FROM delivery Where BrandName = '$BrandName' and Commodity ='$Commodity' and Location ='$Location' and PL ='".$_GET['PL']."' and JOB_No ='$JOB_No'";
      $sqldelivery="SELECT * FROM delivery Where id = '$id' and JOB_No ='$JOB_No'";
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

      $sql = " UPDATE product SET  balanceWIP ='$productJob',balanceDelivery ='$productDelivery' Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='".$_GET['PL']."'"; 
      // echo $sql;
      mysqli_query($con ,$sql); 

      $sql = " UPDATE job SET  balanceWIP ='$jobbalanceWIP',balanceJOB ='$wipJOB' Where BrandName = '$BrandName' and Commodity ='$Commodity' and Location ='$Location'and Job_No ='$JOB_No' and PL ='".$_GET['PL']."'"; 
      // echo $sql;
      mysqli_query($con ,$sql);           
      }

      else{
      $productDelivery = $product['balanceDelivery']-$delivery['Qty'];
      $productJob = $product['balanceWIP']+ $delivery['Qty'];
      $jobbalanceWIP = $job['balanceWIP'] - $delivery['Qty'];   
      $wipJOBs = $job['balanceWIP'] + $job['balanceJOB'];
    
      $sql = " UPDATE product SET  balanceWIP ='$productJob',balanceDelivery ='$productDelivery' Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='".$_GET['PL']."'"; 
      // echo $sql;
      mysqli_query($con ,$sql); 

      $sql = " UPDATE job SET  balanceWIP ='$jobbalanceWIP',balanceJOB ='$wipJOBs' Where BrandName = '$BrandName' and Commodity ='$Commodity' and Location ='$Location'and Job_No ='$JOB_No' and PL ='".$_GET['PL']."'"; 
      // echo $sql;
      mysqli_query($con ,$sql); 

      }
      $deliresult = $product['balanceDelivery']-$product['balanceReturn'];
      $productremain = $deliresult+$product['balanceWIP'];
      $remain = $product['Qty']- $productremain;

      $sql = " UPDATE product SET  balanceQty ='$remain' Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='".$_GET['PL']."'"; 
      // echo $sql;
      mysqli_query($con ,$sql); 

      $sqlQ="SELECT * FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='".$_GET['PL']."' ";
      $resultQ=mysqli_query($con ,$sqlQ); 
      $rowQ = $resultQ->fetch_assoc();    
      
      $deliresultQ = $rowQ['balanceDelivery']-$rowQ['balanceReturn'];
      $currentQty = $rowQ['Qty']- $deliresultQ;
      
      $balanceUSD = $rowQ['USD'] * $deliresultQ;

      $sqlSSaa = " UPDATE product SET  currentQty ='$currentQty' Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='".$_GET['PL']."'"; 
    //   echo $sqlSSaa;
      mysqli_query($con ,$sqlSSaa);        

      $sql = " UPDATE product SET  balanceUSD ='$balanceUSD' where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='".$_GET['PL']."'"; 
    //   echo $sql;
      mysqli_query($con ,$sql);


//$sql="DELETE FROM delivery where BrandName = '$BrandName' and Commodity ='$Commodity' and Location ='$Location'and  id='$id' AND Customer='$okyaku' AND DO_No='$DO_No' ";
     $sql="DELETE FROM delivery where id = '$id'";
	   mysqli_query($con ,$sql);
   echo"<script>alert('Successfully Deleted');</script>"; 
    echo "<script type='text/javascript'>window.top.location='detail.php?ID=$okyaku&DO=$DO_No';</script>";exit;	   	

}

else{

      $nojob = $product['balanceDelivery'] - $delivery['Qty'];

      $sql = " UPDATE product SET  balanceDelivery ='$nojob' Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='".$_GET['PL']."'"; 
      // echo $sql;
      mysqli_query($con ,$sql);    
      $sqlproducts="SELECT Qty,balanceQty,USD,balanceUSD,balanceWIP,balanceDelivery,balanceReturn FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='".$_GET['PL']."'";
      $resultproducts=mysqli_query($con ,$sqlproducts); 
      $products = $resultproducts->fetch_assoc();   

      $deliresults = $products['balanceDelivery']-$products['balanceReturn'];
      $productremains = $deliresults+$products['balanceWIP'];
      $remains = $products['Qty']- $productremains;
      
      $currentQty = $products['Qty']- $deliresults;

      $sql = " UPDATE product SET  balanceQty ='$remains' Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='".$_GET['PL']."'"; 
      // echo $sql;
      mysqli_query($con ,$sql);     
      
      
      $sqlQs="SELECT * FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='".$_GET['PL']."' ";
      $resultQs=mysqli_query($con ,$sqlQs); 
      $rowQs = $resultQs->fetch_assoc();    
      
      $deliresultQs = $rowQs['balanceDelivery']-$rowQs['balanceReturn'];
      $currentQtys = $rowQs['Qty']- $deliresultQs;
      
      $balanceUSDs = $rowQs['USD'] * $deliresultQs;      
      
      
      $sqlSS = " UPDATE product SET  currentQty ='$currentQtys' Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='".$_GET['PL']."'"; 
    //   echo $sql;
      mysqli_query($con ,$sqlSS);        

      $sql = " UPDATE product SET  balanceUSD='$balanceUSDs' Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='".$_GET['PL']."'"; 
    //   echo $sql;
      mysqli_query($con ,$sql);  


      $sql="DELETE FROM delivery WHERE id='$id'";
      
      mysqli_query($con ,$sql);
   echo"<script>alert('Successfully Deleted');</script>"; 
   echo "<script type='text/javascript'>window.top.location='detail.php?ID=$okyaku&DO=$DO_No';</script>";exit;
}
}
?>