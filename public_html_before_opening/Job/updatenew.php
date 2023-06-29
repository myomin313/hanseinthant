<?php
      
       // var_dump("update new");exit();
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
      
        $LUser=$_GET['LUser']; 
        $CreateTime= date("Y-m-d H:i:s"); 
        $NType=$_GET['NType']; 
        $NPL=$_GET['NPL']; 
        $NWIP=$_GET['NWIP']; 
        $balanceWIPss=0;
    
        $NBrandName = mysqli_real_escape_string($con,$_GET['NBrandName']);   
        $NCommodity = mysqli_real_escape_string($con,$_GET['NCommodity']);
        $Ncode = mysqli_real_escape_string($con,$_GET['Ncode']); 
        $NRemark = mysqli_real_escape_string($con,$_GET['NRemark']);   
        $okyaku = mysqli_real_escape_string($con,$_GET['okyaku']);   

      $Location=$_GET['Location']; 
      $Job_date=$_GET['Job_date']; 
      $Project=$_GET['Project']; 
      $Job_No=$_GET['JOB_No'].''.$_GET['dep_name'];

      //var_dump($Job_No);exit();
      //$dep_name=$_GET['dep_name']; 

       $sqlA = "SELECT DISTINCT BrandName,Commodity,PL FROM job WHERE BrandName ='$NBrandName' and Commodity= '$NCommodity' and code='$Ncode' and PL = '$NPL' and Location= '$Location' and Customer = '$okyaku' and JOB_No = '$Job_No'";
        $resultA=mysqli_query($con ,$sqlA); 
        $row = $resultA->fetch_assoc();
        $count=mysqli_num_rows($resultA);
        if($count==1)
             {
              echo"<script>alert('Your item already exist in WIP.Please try again!');</script>"; 
              }  
      else{   

      $sql="SELECT Qty,balanceWIP,balanceDelivery,balanceReturn FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$Ncode' and Branch ='$Location' and Purchase_order_No ='$NPL'";
      $result=mysqli_query($con ,$sql); 
      $rows = $result->fetch_assoc();
      
      $balanceWIP = $rows['balanceWIP'] + $NWIP;

      $sql = " UPDATE product SET balanceWIP ='$balanceWIP' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$Ncode' and Branch ='$Location' and Purchase_order_No ='$NPL'"; 
      // echo $sql;
      mysqli_query($con ,$sql);
      
      $sqlresult="SELECT Qty,balanceWIP,balanceDelivery,balanceReturn,USD FROM product Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and code='$Ncode' and Branch ='$Location' and Purchase_order_No ='$NPL'";
      $results=mysqli_query($con ,$sqlresult); 
      $rowsreesult = $results->fetch_assoc();

      $btd=$rowsreesult['balanceDelivery']+$rowsreesult['balanceTransfer'];
      $balanceUSDs = $rowsreesult['USD']* $btd;

       $sq = " UPDATE product SET balanceUSD ='$balanceUSDs' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$NPL' and code='$Ncode'"; 
      
      mysqli_query($con ,$sq);        

       $wtd=$rowsreesult['balanceDelivery']+$rowsreesult['balanceTransfer'];
       $return=$wtd-$rowsreesult['balanceReturn'];
       $rowsreesult['balanceWIP'];
       $bal=$rowsreesult['balanceWIP']+ $return;
       $balanceQtyss = $rowsreesult['Qty'] - $bal;
       $s = " UPDATE product SET balanceQty ='$balanceQtyss' Where BrandName = '$NBrandName' and Commodity ='$NCommodity' and Branch ='$Location' and Purchase_order_No ='$NPL'"; 
      
      mysqli_query($con ,$s);          

      $sql="INSERT INTO job (Location,Customer,Commodity,BrandName,code,WIP,balanceJOB,Type,PL,Job_date,Project,JOB_No,balanceWIP,Remarks_Item,Creator,CreateTime) VALUES ('$Location','$okyaku','$NCommodity','$NBrandName','$Ncode','$NWIP','$NWIP','$NType','$NPL','$Job_date','$Project','$Job_No','$balanceWIPss','$NRemark','$LUser','$CreateTime')";

                mysqli_query($con ,$sql);
                $status ="New";
                $input_ID=0;
                  
                 $sql="INSERT INTO job_history(input_ID,Customer,OCustomer,BrandName,OBrandName,Commodity,OCommodity,code,Ocode,Remarks_Item,ORemarks_Item,Job_date,OJob_date,Job_No,OJob_No,Project,OProject,WIP,OWIP,Type,OType,Location,OLocation,PL,OPL,RecordTime,Recorder,status) 
                VALUES ('$input_ID','$okyaku','','$NBrandName','','$NCommodity','','$Ncode','','$NRemark','','$Job_date','','$Job_No','','$Project','','$NWIP','','$NType','','$Location','','$NPL','','$CreateTime','$LUser','$status')";  

                mysqli_query($con ,$sql); 
      }
                  
                echo "<script type='text/javascript'>window.top.location='detail.php?Customer=$okyaku&JOB_NO=$Job_No&Branch=$Location';</script>";exit;                     
                  

?>