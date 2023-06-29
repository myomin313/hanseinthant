<?php

      include_once('../config.php');
      session_start();
    //   $setutf8 = "SET NAMES utf8";
    //   $q = $con->query($setutf8);
    //   $setutf8c = "SET character_set_results = 'utf8', character_set_client =
    //   'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
    //   character_set_server = 'utf8'";
    //   $qc = $con->query($setutf8c);
    //   $setutf9 = "SET CHARACTER SET utf8";
    //   $q1 = $con->query($setutf9);
    //   $setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
    //   $q2 = $con->query($setutf7);
      
      $LUser = $_SESSION['login_user'];
      $UpdateTime= date("Y-m-d H:i:s"); 

      $okyaku=$_GET['okyaku']; 
      $DO_No=$_GET['DO_No']; 
      $department=$_GET['department']; 
      $Return_no=$_GET['Return_no']; 
      $Return_date=$_GET['Return_date']; 

      $id=$_GET['id'];
      $Commodity = mysqli_real_escape_string($con,$_GET['Commodity']);
      $BrandName = mysqli_real_escape_string($con,$_GET['BrandName']);
      $Remark_item = mysqli_real_escape_string($con,$_GET['Remarks_item']);             

      $Types=$_GET['Type']; 
      $quan=$_GET['quan'];
      $PL=$_GET['PL']; 


                  $OCustomer="";
                  $OBrandName ="";
                  $OCommodity ="";
                  $ORemarks_item ="";
                  $OReturn_date ="";
                  $OReturn_no ="";
                  $OJOB_No ="";
                  $ODO_No ="";                  
                  $Odepartment ="";
                  $OQty ="";
                  $OType ="";
                  $RecordTime =date("Y-m-d H:i:s");
                  $Recorder =$_GET['LUser'];
                  $status ="Update";
                                   
                  $sql="SELECT * FROM returns WHERE  id = '$id' and Customer = '$okyaku' and Return_no = '$Return_no' and department = '$department'  ";
                  $results=mysqli_query($con ,$sql); 
                  $row = $results->fetch_assoc();

                  $OCustomer = mysqli_real_escape_string($con,$row['Customer']);
                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $ORemarks_item = mysqli_real_escape_string($con,$row['Remarks_item']);

                  $OReturn_date= $row['Return_date'];
                  $OReturn_no= $row['Return_no'];
                  $ODO_No= $row['DO_No'];
                  $OPL= $row['PL'];                                  
                  $Odepartment= $row['department'];
                  $OQty= $row['Qty'];
                  $OType= $row['Type'];
                           
                $sql="INSERT INTO customerreturn_history(input_ID,Customer,OCustomer,BrandName,OBrandName,Commodity,OCommodity,Remarks_item,ORemarks_item,Return_date,OReturn_date,Return_no,OReturn_no,DO_No,ODO_No,PL,OPL,department,Odepartment,Qty,OQty,Type,OType,RecordTime,Recorder,status) 
                VALUES ('$id','$okyaku','$OCustomer','$BrandName','$OBrandName','$Commodity','$OCommodity','$Remark_item','$ORemarks_item','$Return_date','$OReturn_date','$Return_no','$OReturn_no','$DO_No','$ODO_No','$PL','$OPL','$department','$Odepartment','$quan','$OQty','$Types','$OType','$RecordTime','$Recorder','$status')";
                //   echo $sql;
                  mysqli_query($con ,$sql);
                               
                  $sql = " UPDATE returns SET Customer ='$OCustomer',department='$Odepartment',DO_No='$ODO_No',Return_no ='$OReturn_no',Return_date ='$OReturn_date',BrandName ='$OBrandName',Commodity ='$OCommodity',Qty ='$OQty',PL ='$OPL',Remarks_item ='$Remark_item',Type ='$OType'  WHERE id='$id' and Customer = '$okyaku' and Return_no = '$Return_no' and department = '$department'";  

                //   echo $sql;
                  mysqli_query($con,$sql);
                 echo"<script>alert('Successfully Updated');</script>"; 
                
                 echo "<script type='text/javascript'>window.top.location='detail.php?Customer=$okyaku&Return_no=$Return_no&DO_No=$DO_No';</script>";exit;                  


?>