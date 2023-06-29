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
      
      $LUser=$_GET['LUser']; 
      $UpdateTime= date("Y-m-d H:i:s"); 

      $Location=$_GET['Location']; 
      $okyaku=$_GET['okyaku']; 
      $Job_date=$_GET['Job_date']; 
      $Project=$_GET['Project']; 
      $Job_No=$_GET['JOB_No'].''.$_GET['dep_name'];

      //var_dump($Job_No);exit();
      $id=$_GET['id']; 

      $Commodity = mysqli_real_escape_string($con,$_GET['Commodity']);
      $BrandName = mysqli_real_escape_string($con,$_GET['BrandName']);
      $code = mysqli_real_escape_string($con,$_GET['code']);
      $Remarks_Item = mysqli_real_escape_string($con,$_GET['Remarks_Item']);        

      $Types=$_GET['Type']; 
      $PL=$_GET['PL']; 
      $WIP=$_GET['WIP']; 

                  $OCustomer="";
                  $OBrandName ="";
                  $OCommodity ="";
                  $Ocode ="";
                  $ORemarks_Item ="";
                  $OJob_date ="";
                  $OJob_No ="";
                  $OProject ="";
                  $OWIP ="";
                  $OPL ="";
                  $OType ="";
                  $OLocation ="";
                  $RecordTime =date("Y-m-d H:i:s");
                  $Recorder =$_GET['LUser'];
                  $status ="Update";
                  
                  $sqlq = " UPDATE job SET WIP ='$WIP' WHERE id='$id' and Location = '$Location' and Job_No = '$Job_No' and Customer = '$okyaku'
                    and BrandName = '$BrandName' and Commodity = '$Commodity' and and code = '$code'";
                     mysqli_query($con ,$sqlq);
                                   
                  $sql="SELECT * FROM job WHERE  id = '$id' and Location = '$Location' and Job_No = '$Job_No' and Customer = '$okyaku' and BrandName = '$BrandName' and Commodity = '$Commodity' and code='$code'";
                  $results=mysqli_query($con ,$sql); 
                  $row = $results->fetch_assoc();

                  $OCustomer = mysqli_real_escape_string($con,$row['Customer']);
                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $Ocode = mysqli_real_escape_string($con,$row['code']);
                  $ORemarks_Item = mysqli_real_escape_string($con,$row['Remarks_Item']);

                  $OJob_date= $row['Job_date'];
                  $OJob_No= $row['Job_No'];
                  $OProject= $row['Project'];
                  $OWIP= $row['WIP'];
                  
                  $OPL= $row['PL'];
                  $OType= $row['Type'];
                  $OLocation= $row['Location'];    
                  $ObalanceWIP= $row['balanceWIP'];
                  $ObalanceJOB= $row['balanceJOB']; 
                  
                  
              if ($row['WIP'] > $row['balanceWIP'] ) {
               $BalanceJOB = $row['WIP']-$row['balanceWIP'];          
                   }
              elseif ($row['WIP'] < $row['balanceWIP'] ) {
                $BalanceJOB = 0;
              }
              else{
                $BalanceJOB =0;
              }                       
                 

                           
                $sql="INSERT INTO job_history(input_ID,Customer,OCustomer,BrandName,OBrandName,Commodity,OCommodity,code,Ocode,Remarks_Item,ORemarks_Item,Job_date,OJob_date,Job_No,OJob_No,Project,OProject,WIP,OWIP,Type,OType,Location,OLocation,PL,OPL,RecordTime,Recorder,status) 
                VALUES ('$id','$okyaku','$OCustomer','$BrandName','$OBrandName','$Commodity','$OCommodity','$code','$Ocode','$Remarks_Item','$ORemarks_Item','$Job_date','$OJob_date','$Job_No','$OJob_No','$Project','$OProject','$WIP','$OWIP','$Types','$OType','$Location','$OLocation','$PL','$OPL','$RecordTime','$Recorder','$status')";

                  mysqli_query($con ,$sql);

                //   if($_GET['PL'] !=$row['PL']){
                //   $sqlSAB="SELECT balanceWIP,balanceDelivery,Qty,balanceQty,currentQty,balanceReturn FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='$OPL' ";
                //   $resultSAB=mysqli_query($con ,$sqlSAB); 
                //   $rowsAB = $resultSAB->fetch_assoc();      
                //   $aa=$rowsAB['balanceWIP'];
                //   $bb= $aa-$ObalanceJOB;

                      
                //  $sqlSABC="SELECT Qty FROM delivery Where BrandName = '$BrandName' and Commodity ='$Commodity' and Location ='$Location' and PL ='$OPL' ";
                //   $resultSABC=mysqli_query($con ,$sqlSABC); 
                //   $rowsABC = $resultSABC->fetch_assoc();      
                //   $qq=$rowsABC['Qty']; 
                //   $dd=$rowsAB['balanceDelivery']-$qq; 
                
                //  echo   $sqlA = " UPDATE product SET  balanceWIP='$bb',balanceDelivery='$dd'
                //     WHERE  Branch = '$Location' and Purchase_order_No = '$OPL' and  BrandName = '$BrandName' and Commodity = '$Commodity'";    
                // //  mysqli_query($con ,$sqlA);   
                 
                //      $sqlA = " UPDATE delivery SET  PL='$PL'  WHERE  Location = '$Location' and PL = '$OPL' and  BrandName = '$BrandName' and Commodity = '$Commodity'";    
                // //  mysqli_query($con ,$sqlA);                    
                 
                
                //   }
                //   else{}
 
                  $sql = " UPDATE job SET Location ='$Location',Customer ='$okyaku',Commodity ='$Commodity',BrandName ='$BrandName',WIP ='$WIP',balanceWIP='$ObalanceWIP',balanceJOB = '$BalanceJOB',Type ='$Types',Job_date ='$Job_date',Project ='$Project',Job_No ='$Job_No',PL ='$PL',Remarks_Item ='$Remarks_Item' WHERE id='$id' and Location = '$Location' and Job_No = '$Job_No' and Customer = '$okyaku'
                    and BrandName = '$BrandName' and Commodity = '$Commodity' and code = '$code'"; 
   
                  mysqli_query($con ,$sql);
                  
                  $sqlS="SELECT SUM(balanceJOB) as inputWIP FROM job Where BrandName = '$BrandName' and Commodity ='$Commodity' and Location ='$Location' and PL ='$PL' and  code = '$code' ";
                  $resultS=mysqli_query($con ,$sqlS); 
                  $rows = $resultS->fetch_assoc();
                  $inputWIP = $rows['inputWIP']  ;

                    $sqlA = " UPDATE product SET  balanceWIP='$inputWIP' WHERE  Branch = '$Location' and Purchase_order_No = '$PL' and  BrandName = '$BrandName' and Commodity = '$Commodity' and code = '$code'";    
                 mysqli_query($con ,$sqlA);
                
                  $sqlSA="SELECT balanceWIP,balanceDelivery,Qty,balanceQty,currentQty,balanceReturn FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='$PL' and code = '$code' ";
                  $resultSA=mysqli_query($con ,$sqlSA); 
                  $rowsA = $resultSA->fetch_assoc();

            $deliReturn= $rowsA['balanceDelivery'] - $rowsA['balanceReturn'];
                  $inputWIP =$rowsA['balanceWIP'] + $deliReturn; 
                  $inputBalance= $rowsA['Qty'] - $inputWIP;
                  $currentBalance= $rowsA['Qty'] - ($rowsA['balanceDelivery'] - $rowsA['balanceReturn']);
                
                  $sqlA = " UPDATE product SET  balanceQty='$inputBalance', currentQty='$currentBalance' WHERE  Branch = '$Location' and Purchase_order_No = '$PL' and  BrandName = '$BrandName' and Commodity = '$Commodity' and code = '$code'";    
                 mysqli_query($con ,$sqlA);         
                 
                 
            
                 echo"<script>alert('Successfully Updated');</script>"; 
                
                echo "<script type='text/javascript'>window.top.location='detail.php?Customer=$okyaku&JOB_NO=$Job_No&Branch=$Location';</script>";exit;

                                 
     

?>