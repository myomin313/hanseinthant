<?php
     // start myo min 
      include_once('../config.php');      
        $oldCustomer=$_POST['oldCustomer'];
        $oldJOB_NO=$_POST['oldJOB_NO'];   
        $oldBranch=$_POST['oldBranch'];      
        $Job_date=$_POST['Job_date'];
        $Job_No = $_POST['JOB_No'];
        $Location=$_POST['Location']; 
        $okyaku=$_POST['okyaku'];
        $Project=$_POST['Project']; 
        $LUser=$_POST['LUser'];
        
        foreach($_POST['Commodity'] as $row =>$Commodity) {             
           $Commoditys = mysqli_real_escape_string($con,$_POST['Commodity'][$row]);
           $BrandName  = mysqli_real_escape_string($con,$_POST['BrandName'][$row]);
           //11.8.2019 myo min
              $sqls = "SELECT * FROM job where Customer= '$oldCustomer' and Location= '$oldBranch' and BrandName = '$BrandName' and Commodity = '$Commoditys'";              
                  $result= mysqli_query($con,$sqls);      
                  $row = $result->fetch_assoc();                    
                  $OCustomer = mysqli_real_escape_string($con,$row['Customer']);
                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $ORemarks_Item = mysqli_real_escape_string($con,$row['Remarks_Item']);
                  $Oid=$row['id'];                 
                  $OJob_date= $row['Job_date'];
                  $OJob_No= $row['Job_No'];
                  $OProject= $row['Project'];
                  $OWIP= $row['WIP'];                 
                  $OPL= $row['PL'];
                  $OType= $row['Type'];
                  $OLocation= $row['Location'];    
                  $ObalanceWIP= $row['balanceWIP'];
                  $ObalanceJOB= $row['balanceJOB'];
                  $RecordTime= date("Y-m-d H:i:s"); 
                  $status ='Update';                 
                  $sqli="INSERT INTO job_history(input_ID,Customer,OCustomer,BrandName,OBrandName,Commodity,OCommodity,Remarks_Item,ORemarks_Item,Job_date,OJob_date,Job_No,OJob_No,Project,OProject,WIP,OWIP,Type,OType,Location,OLocation,PL,OPL,RecordTime,Recoder,status)
                 VALUES ('$Oid','$okyaku','$OCustomer','$OBrandName','$OBrandName','$OCommodity','$OCommodity','$ORemarks_Item','$ORemarks_Item','$Job_date','$Job_date','$Job_No','$oldJOB_NO','$OProject','$OProject','$OWIP','$OWIP','$OType','$OType','$Location','$oldBranch','$OPL','$OPL','$RecordTime','$LUser','$status')";
                  mysqli_query($con ,$sqli);
                  $sqls = "SELECT * FROM delivery where Customer= '$oldCustomer' and Location= '$oldBranch' and BrandName = '$BrandName' and Commodity = '$Commoditys'";
                   $results=mysqli_query($con ,$sqls); 
                  $row = $results->fetch_assoc();
                  $OCustomer = mysqli_real_escape_string($con,$row['Customer']);
                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $ORemark_Item = mysqli_real_escape_string($con,$row['Remark_item']);
                  $Oid=$row['id'];   
                  $ODelivery_date= $row['Delivery_date'];
                  $ODO_No= $row['DO_No'];
                  $OJOB_No= $row['JOB_No'];
                  $OQty= $row['Qty'];
                  $OPL= $row['PL'];
                  $OType= $row['Type'];
                  $OLocation= $row['Location']; 
                $sqldi="INSERT INTO delivery_history(input_ID,Customer,OCustomer,BrandName,OBrandName,Commodity,OCommodity,Remark_Item,ORemark_Item,ODelivery_date,ODelivery_date,DO_No,ODO_No,JOB_No,OJOB_No,OQty,OQty,PL,OPL,Type,OType,Location,OLocation,RecordTime,Recorder,status)
                VALUES ('$Oid','$okyaku','$OCustomer','$OBrandName','$OBrandName','$OCommodity','$OCommodity','$ORemark_Item','$ORemark_Item','$ODelivery_date','$ODelivery_date','$ODO_No','$ODO_No','$Job_No','$OJOB_No','$OQty','$OQty','$OPL','$OPL','$OType','$OType','$Location','$OLocation','$RecordTime','$LUser','$status')";
                mysqli_query($con ,$sqldi);
                // returns history  
                $sql="SELECT * FROM returns WHERE Customer = '$oldCustomer' and department = '$oldBranch' and BrandName = '$BrandName' and Commodity = '$Commoditys' ";
                  $results=mysqli_query($con ,$sql); 
                  $row = $results->fetch_assoc();
                  $OCustomer = mysqli_real_escape_string($con,$row['Customer']);
                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $ORemarks_item = mysqli_real_escape_string($con,$row['Remarks_item']);
                  $Oid=$row['id'];
                  $OReturn_date= $row['Return_date'];
                  $OReturn_no= $row['Return_no'];
                  $ODO_No= $row['DO_No'];
                  $OPL= $row['PL'];                                  
                  $Odepartment= $row['department'];
                  $OQty= $row['Qty'];
                  $OType= $row['Type'];                           
                $sqlir="INSERT INTO customerreturn_history(input_ID,Customer,OCustomer,BrandName,OBrandName,Commodity,OCommodity,Remarks_item,ORemarks_item,Return_date,OReturn_date,Return_no,OReturn_no,DO_No,ODO_No,PL,OPL,department,Odepartment,Qty,OQty,Type,OType,RecordTime,Recorder,status) 
                VALUES ('$Oid','$okyaku','$OCustomer','$OBrandName','$OBrandName','$OCommodity','$OCommodity','$ORemarks_item','$ORemarks_item','$OReturn_date','$OReturn_date','$OReturn_no','$OReturn_no','$ODO_No','$ODO_No','$OPL','$OPL','$Location','$Odepartment','$OQty','$OQty','$OType','$OType','$RecordTime','$LUser','$status')";
                  mysqli_query($con ,$sqlir);
                  // returns history  end
              $sqlq = " UPDATE job SET Job_date ='$Job_date',Customer ='$okyaku',Location ='$Location',Job_No ='$Job_No' WHERE  Customer = '$oldCustomer' and Job_No = '$oldJOB_NO' and Location = '$oldBranch'";
                  mysqli_query($con ,$sqlq);

            $sqld = " UPDATE delivery SET Customer ='$okyaku',Location ='$Location',Job_No ='$Job_No' WHERE Customer = '$oldCustomer' and Location = '$oldBranch' and BrandName = '$BrandName' and Commodity = '$Commoditys'";
             mysqli_query($con ,$sqld);

           $sqlr = " UPDATE returns SET Customer ='$okyaku',department ='$Location' WHERE Customer = '$oldCustomer' and department = '$oldBranch' and BrandName = '$BrandName' and Commodity = '$Commoditys'";
              mysqli_query($con ,$sqlr);
            echo"<script>alert('Successfully Updated');</script>";
            echo "<script type='text/javascript'>window.top.location='list.php';</script>";
        }
        //end myo min
                                 
     

?>