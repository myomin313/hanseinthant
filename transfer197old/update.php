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

      $transfer_from=$_GET['transfer_from']; 
      $transfer_to=$_GET['transfer_to']; 
      $transfer_date=$_GET['transfer_date']; 
      $transfer_no=$_GET['transfer_no']; 


      $id=$_GET['id']; 

      $Commodity = mysqli_real_escape_string($con,$_GET['Commodity']);
      $BrandName = mysqli_real_escape_string($con,$_GET['BrandName']);
      $code = mysqli_real_escape_string($con,$_GET['code']);
      $Remark_Item = mysqli_real_escape_string($con,$_GET['Remark_item']);              

      $Types=$_GET['Type']; 
      $Qty=$_GET['Qty']; 
      $PL=$_GET['PL']; 


                  $Otransfer_from="";
                  $Otransfer_to ="";
                  $OBrandName ="";
                  $OCommodity ="";
                  $Ocode ="";
                  $ORemark_Item ="";
                  $Otransfer_date ="";
                  $Otransfer_no ="";
                  $OQty ="";
                  $OPL ="";
                  $OType ="";
                 
                  $RecordTime =date("Y-m-d H:i:s");
                  $Recorder =$_SESSION['login_user'];
                  $status ="Update";
                                   
                  $sql="SELECT * FROM transfer WHERE  id = '$id' and transfer_from = '$transfer_from' and transfer_to = '$transfer_to' and transfer_no = '$transfer_no' ";
                  $results=mysqli_query($con ,$sql); 
                  $row = $results->fetch_assoc();
                  $Otransfer_from = mysqli_real_escape_string($con,$row['transfer_from']);
                  $Otransfer_to = mysqli_real_escape_string($con,$row['transfer_to']);
                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $Ocode = mysqli_real_escape_string($con,$row['code']);
                  $ORemark_Item = mysqli_real_escape_string($con,$row['Remark_Item']);

                  $Otransfer_date= $row['transfer_date'];
                  $Otransfer_no= $row['transfer_no'];
                  $OQty= $row['Qty'];
                  $OPL= $row['PL'];
                  $OType= $row['Type'];  
                           
                $sql="INSERT INTO transfer_history(input_ID,transfer_from,Otransfer_from,BrandName,OBrandName,Commodity,OCommodity,code,Ocode,Remark_Item,ORemark_Item,transfer_date,Otransfer_date,transfer_no,Otransfer_no,Qty,OQty,PL,OPL,Type,OType,transfer_to,Otransfer_to,RecordTime,Recorder,status) 
                VALUES ('$id','$transfer_from','$Otransfer_from','$BrandName','$OBrandName','$Commodity','$OCommodity','$code','$Ocode','$Remark_Item','$ORemark_Item','$transfer_date','$Otransfer_date','$transfer_no','$Otransfer_no','$Qty','$OQty','$PL','$OPL','$Types','$OType','$transfer_to','$Otransfer_to','$RecordTime','$Recorder','$status')";
                //   echo $sql;
             mysqli_query($con ,$sql);      

                  $sql = "UPDATE transfer SET transfer_from ='$Otransfer_from',transfer_to='$Otransfer_to',transfer_date='$Otransfer_date',transfer_no ='$Otransfer_no',BrandName ='$OBrandName',Commodity ='$OCommodity',code='$Ocode',Qty ='$OQty',Type ='$OType',Remark_Item ='$Remark_Item' WHERE id='$id'";  
                //   echo $sql;

                  mysqli_query($con,$sql);   
                  echo"<script>alert('Successfully Updated');</script>"; 
                
                 echo "<script type='text/javascript'>window.top.location='detail.php?transfer_no=$transfer_no';</script>";exit;                
                  


?>