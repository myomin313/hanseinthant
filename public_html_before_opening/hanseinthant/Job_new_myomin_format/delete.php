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
      $Location=$_GET['Location']; 
      $okyaku=$_GET['okyaku']; 
      $Job_date=$_GET['Job_date']; 
      $Project=$_GET['Project'];      
      $Job_No=$_GET['JOB_No'].''.$_GET['dep_name'];
      $id=$_GET['id']; 
      $Commodity = mysqli_real_escape_string($con,$_GET['Commodity']);
      $BrandName = mysqli_real_escape_string($con,$_GET['BrandName']);
      $Remarks_Item = mysqli_real_escape_string($con,$_GET['Remarks_Item']);        
      $Types=$_GET['Type']; 
      $PL=$_GET['PL']; 
      $WIP=$_GET['WIP']; 

                  $OCustomer="";
                  $OBrandName ="";
                  $OCommodity ="";
                  $ORemarks_Item ="";
                  $OJob_date ="";
                  $OJob_No ="";
                  $OProject ="";
                  $OWIP ="";
                  $OJob_date ="";
                  $OType ="";
                  $OLocation ="";
                  
                  $RecordTime =date("Y-m-d H:i:s");
                  $Recorder =$_GET['LUser'];     
                  $status ="Delete";
                                   
                  $sql="SELECT * FROM job WHERE  id = '$id' ";
                  $results=mysqli_query($con ,$sql); 
                  $row = $results->fetch_assoc();
                  $OCustomer = mysqli_real_escape_string($con,$row['Customer']);
                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $ORemarks_Item = mysqli_real_escape_string($con,$row['Remarks_Item']);                  

                  $OJob_date= $row['Job_date'];
                  $OJob_No= $row['Job_No'];
                  $OProject= $row['Project'];
                  $OWIP= $row['WIP'];
                  $OJob_date= $row['Job_date'];
                  $OType= $row['Type'];
                  $OLocation= $row['Location']; 
                  $OPL = $row['PL'];   
                  
              


        $sql = "SELECT JOB_No,Commodity,BrandName,PL,Location,Customer  FROM delivery WHERE JOB_No ='$Job_No' and Commodity ='$Commodity' and BrandName ='$BrandName' and PL ='$PL' and Location ='$Location' and Customer ='$okyaku'";
        // echo $sql;
        $result=mysqli_query($con ,$sql); 
        $row = $result->fetch_assoc();
                  $count=mysqli_num_rows($result);
      if($count==1)
                  {
                   echo"<script>alert('Your JOB No. is connected to Delivery.Please remove DO No. first!');</script>";  
                  echo "<script type='text/javascript'>window.top.location='detail.php?Customer=$okyaku&JOB_NO=$Job_No';</script>";exit;	 
                  }  
      else{                        

                $sql="INSERT INTO job_history(input_ID,Customer,OCustomer,BrandName,OBrandName,Commodity,OCommodity,Remarks_Item,ORemarks_Item,Job_date,OJob_date,Job_No,OJob_No,Project,OProject,WIP,OWIP,Type,OType,Location,OLocation,PL,OPL,RecordTime,Recorder,status) 
                VALUES ('$id','','$OCustomer','','$OBrandName','','$OCommodity','','$ORemarks_Item','','$OJob_date','','$OJob_No','','$OProject','','$OWIP','','$OType','','$OLocation','','$OPL','$RecordTime','$Recorder','$status')";      
                   
                  mysqli_query($con ,$sql);

                  $sql="SELECT * FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='$PL'";
                  $result=mysqli_query($con ,$sql); 
                  $rows = $result->fetch_assoc();

                 $sqljob="SELECT * FROM job Where BrandName = '$BrandName' and Commodity ='$Commodity' and Location ='$Location' and PL ='$PL' and Job_No ='$Job_No'";
                 $resultjob=mysqli_query($con ,$sqljob); 
                 $job = $resultjob->fetch_assoc();                    

                  $balanceWIP = $rows['balanceWIP'] - $job['WIP'];
                  $sql = " UPDATE product SET balanceWIP ='$balanceWIP' Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='$PL'"; 
                  mysqli_query($con ,$sql);

                  $sqlproduct="SELECT * FROM product Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='$PL'";
                  $resultproduct=mysqli_query($con ,$sqlproduct); 
                  $product = $resultproduct->fetch_assoc();  

                  $balanceQtys = $product['balanceDelivery'] -  $product['balanceReturn'];
                  $balanceQty = $product['balanceWIP'] +  $balanceQtys;
                  $balances = $product['Qty'] -  $balanceQty;
                  $sql = " UPDATE product SET balanceQty ='$balances' Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location' and Purchase_order_No ='$PL'"; 
                  mysqli_query($con ,$sql);

                  $balanceUSDs = $product['USD'] * $balanceQtys;

                  $sql = " UPDATE product SET  balanceUSD='$balanceUSDs' Where BrandName = '$BrandName' and Commodity ='$Commodity' and Branch ='$Location'  and Purchase_order_No ='".$_GET['PL']."'"; 
                  mysqli_query($con ,$sql);                 

            		 $sql="DELETE FROM job WHERE id='$id'";
            		mysqli_query($con,$sql);
                    echo"<script>alert('Successfully Deleted');</script>"; 


                   echo "<script type='text/javascript'>window.top.location='detail.php?Customer=$okyaku&JOB_NO=$Job_No&Branch=$Location';</script>";exit;	

}

?>