<?php

include_once('../config.php');

        $setutf8 = "SET NAMES utf8";
        $q = $con->query($setutf8);
        $setutf8c = "SET character_set_results = 'utf8', character_set_client =
        'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
        character_set_server = 'utf8'";
        $qc = $con->query($setutf8c);
        $setutf9 = "SET CHARACTER SET utf8";
        $q1 = $con->query($setutf9);
        $setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
        $q2 = $con->query($setutf7);
        
      $LUser=$_GET['LUser']; 
      $UpdateTime= date("Y-m-d H:i:s"); 

      $supplier=$_GET['supplier']; 
      $Return_date=$_GET['Return_date']; 
      $PL_NO=$_GET['PL_NO'];
      $Branch=$_GET['Branch']; 

      $id=$_GET['id']; 
      $Commodity = mysqli_real_escape_string($con,$_GET['Commodity']);
      $BrandName = mysqli_real_escape_string($con,$_GET['BrandName']);
      $Remarks_item = mysqli_real_escape_string($con,$_GET['Remarks_item']);          

      $Types=$_GET['Types']; 
      $quan=$_GET['quan']; 



                  $OSupplier="";
                  $OBrandName ="";
                  $OCommodity ="";
                  $ORemark_item ="";
                  $OReturn_date ="";
                  $OPL ="";                
                  $OQty ="";
                  $OType ="";
                  $RecordTime =date("Y-m-d H:i:s");
                  $Recorder =$_GET['LUser'];
                  $status ="Update";
                                   
                  $sql="SELECT * FROM supplier_return WHERE  id = '$id'  and Supplier = '$supplier' and PL = '$PL_NO' and Branch = '$Branch' ";
                  $results=mysqli_query($con ,$sql); 
                  $row = $results->fetch_assoc();
                  $OSupplier = mysqli_real_escape_string($con,$row['Supplier']);
                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $ORemark_item = mysqli_real_escape_string($con,$row['Remark_item']);

                  $OReturn_date= $row['Return_date'];
                  $OBranch= $row['Branch'];
                  $OPL= $row['PL'];
                  $OQty= $row['Qty'];
                  $OType= $row['type'];
                           
                $sql="INSERT INTO supplierreturn_history(Branch,OBranch,input_ID,Supplier,OSupplier,BrandName,OBrandName,Commodity,OCommodity,Remark_item,ORemark_item,Return_date,OReturn_date,PL,OPL,Qty,OQty,Type,OType,RecordTime,Recorder,status) 
                VALUES ('$Branch','$OBranch','$id','$supplier','$OSupplier','$BrandName','$OBrandName','$Commodity','$OCommodity','$Remarks_item','$ORemark_item','$Return_date','$OReturn_date','$PL_NO','$OPL','$quan','$OQty','$Types','$OType','$RecordTime','$Recorder','$status')";
                //   echo $sql;
                  mysqli_query($con ,$sql);

                           
                  $sql = " UPDATE supplier_return SET Supplier ='$OSupplier',PL='$OPL',Return_date ='$OReturn_date',BrandName ='$OBrandName',Commodity ='$OCommodity',Qty ='$OQty',Remark_item ='$Remarks_item',Type ='$OType',Branch ='$OBranch' WHERE id='$id'  and Supplier = '$supplier' and PL = '$PL_NO' and Branch = '$Branch'";  
                //   echo $sql;

                  mysqli_query($con ,$sql);
                  echo"<script>alert('Successfully Updated');</script>"; 
                
                 echo "<script type='text/javascript'>window.top.location='detail.php?Supplier=$supplier&PL=$PL_NO&Branch=$Branch';</script>";exit; 



?>