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

      $LUser = $_SESSION['login_user'];
      $UpdateTime= date("Y-m-d H:i:s"); 

      $okyaku=$_GET['okyaku']; 
      $Location=$_GET['Location']; 
      $Delivery_date=$_GET['Delivery_date']; 
      $DO_No=$_GET['DO_No'].''.$_GET['dep_name']; 
      $JOB_No=$_GET['JOB_No']; 


      $id=$_GET['id']; 

      $Commodity = mysqli_real_escape_string($con,$_GET['Commodity']);
      $BrandName = mysqli_real_escape_string($con,$_GET['BrandName']);
      $Remark_item = mysqli_real_escape_string($con,$_GET['Remark_item']);              

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
                  $OPL ="";
                  $OType ="";
                  $OLocation ="";
                  $RecordTime =date("Y-m-d H:i:s");
                  $Recorder =$_SESSION['login_user'];
                  $status ="Update";
                                   
                  $sql="SELECT * FROM delivery WHERE  id = '$id' and Customer = '$okyaku' and Location = '$Location' and DO_No = '$DO_No' ";
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
                  $OPL= $row['PL'];
                  $OType= $row['Type'];
                  $OLocation= $row['Location'];    
                           
                $sql="INSERT INTO delivery_history(input_ID,Customer,OCustomer,BrandName,OBrandName,Commodity,OCommodity,Remark_Item,ORemark_Item,Delivery_date,ODelivery_date,DO_No,ODO_No,JOB_No,OJOB_No,Qty,OQty,PL,OPL,Type,OType,Location,OLocation,RecordTime,Recorder,status) 
                VALUES ('$id','$okyaku','$OCustomer','$BrandName','$OBrandName','$Commodity','$OCommodity','$Remark_item','$ORemark_Item','$Delivery_date','$ODelivery_date','$DO_No','$ODO_No','$JOB_No','$OJOB_No','$Qty','$OQty','$PL','$OPL','$Types','$OType','$Location','$OLocation','$RecordTime','$Recorder','$status')";
                //   echo $sql;
             mysqli_query($con ,$sql);      

                  $sql = " UPDATE delivery SET Customer ='$OCustomer',Location='$OLocation',Delivery_date='$ODelivery_date',DO_No ='$ODO_No',JOB_No ='$OJOB_No',BrandName ='$OBrandName',Commodity ='$OCommodity',Qty ='$OQty',Type ='$OType',Remark_item ='$Remark_item' WHERE id='$id'";  
                //   echo $sql;

                  mysqli_query($con,$sql);   
                  echo"<script>alert('Successfully Updated');</script>"; 
                
                 echo "<script type='text/javascript'>window.top.location='detail.php?ID=$okyaku&DO=$DO_No';</script>";exit;                
                  


?>