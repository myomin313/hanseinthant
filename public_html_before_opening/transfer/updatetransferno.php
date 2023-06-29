<?php
     // start myo min 
      include_once('../config.php');      
        $old_transfer_from=$_POST['old_transfer_from'];
        $old_transfer_no=$_POST['old_transfer_no'];
        $old_transfer_to=$_POST['old_transfer_to'];
        //$Job_No = $_POST['JOB_No'];
        $transfer_no=$_POST['transfer_no'];
        $transfer_date=$_POST['transfer_date']; 
        $LUser=$_POST['LUser'];
         
        
         foreach($_POST['Commodity'] as $row =>$Commodity) { 

           $Commoditys = mysqli_real_escape_string($con,$_POST['Commodity'][$row]);
           $BrandName  = mysqli_real_escape_string($con,$_POST['BrandName'][$row]);
           $code  = mysqli_real_escape_string($con,$_POST['code'][$row]);
           // 11.13.2019 myo min start


           $sqls = "SELECT * FROM transfer where transfer_from= '$old_transfer_from' and transfer_to= '$old_transfer_to' and BrandName = '$BrandName' and code = '$code' and Commodity = '$Commoditys' and transfer_no='$old_transfer_no'";
           $results=mysqli_query($con ,$sqls); 
          $rowdi = $results->fetch_assoc();
          $Otransfer_from = mysqli_real_escape_string($con,$rowdi['transfer_from']);
          $Otransfer_to = mysqli_real_escape_string($con,$rowdi['transfer_to']);
          $OBrandName = mysqli_real_escape_string($con,$rowdi['BrandName']);
          $OCommodity = mysqli_real_escape_string($con,$rowdi['Commodity']);
          $Ocode = mysqli_real_escape_string($con,$rowdi['code']);
          $ORemark_Item = mysqli_real_escape_string($con,$rowdi['Remark_Item']);
          $Oid=$rowdi['id'];   
          $Otransfer_date= $rowdi['transfer_date'];
          $Otransfer_no= $rowdi['transfer_no'];
          $OQty= $rowdi['Qty'];
          $OPL= $rowdi['PL'];
          $OType= $rowdi['Type'];
          $RecordTime= date("Y-m-d H:i:s");
          $status ='Update';
          

        $sqldi="INSERT INTO transfer_history(input_ID,transfer_from,Otransfer_from,transfer_to,Otransfer_to,BrandName,OBrandName,Commodity,OCommodity,code,Ocode,Remark_Item,ORemark_Item,transfer_date,Otransfer_date,transfer_no,Otransfer_no,Qty,OQty,PL,OPL,Type,OType,RecordTime,Recorder,status)
        VALUES ('$Oid','$Otransfer_from','$Otransfer_from','$Otransfer_to','$Otransfer_to','$OBrandName','$OBrandName','$OCommodity','$OCommodity','$Ocode','$Ocode','$ORemark_Item','$ORemark_Item','$Otransfer_date','$Otransfer_date','$transfer_no','$Otransfer_no','$OQty','$OQty','$OPL','$OPL','$OType','$OType','$RecordTime','$LUser','$status')";
          mysqli_query($con ,$sqldi);

         }
         
         $sqlt = "UPDATE transfer SET transfer_no ='$transfer_no' WHERE transfer_from = '$old_transfer_from' and transfer_to = '$old_transfer_to' and transfer_no = '$old_transfer_no'";
         mysqli_query($con ,$sqlt);


         $sqlp = "UPDATE product SET transfer_no ='$transfer_no' WHERE transfer_no = '$old_transfer_no'";
         mysqli_query($con ,$sqlp);
         // 11.13.2019 myo min end 

             echo"<script>alert('Successfully Updated');</script>";
              echo "<script type='text/javascript'>window.top.location='list.php?namelist=&year=&month=&day=';</script>";
        //end myo min 

?>