
<?php
 

     
      include_once('../config.php');
      session_start();
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
       $Customer=$_GET['Customer'];
       $JOB_NO=$_GET['JOB_NO'];


       $LUser = $_SESSION['login_user'];
       $UpdateTime= date("Y-m-d H:i:s");  
      if (isset($_POST['Update'])) {
        $Job_No=$_POST['JOB_No'].''.$_POST['dep_name']; 

      foreach($_POST['Commodity'] as $row=>$Commodity) { 

      $Commodity = mysqli_real_escape_string($con,$_POST['Commodity'][$row]);
      $okyaku = mysqli_real_escape_string($con,$_POST['okyaku']);
      $BrandName = mysqli_real_escape_string($con,$_POST['BrandName'][$row]);
      $Remarks_Item = mysqli_real_escape_string($con,$_POST['Remarks_Item'][$row]);     

      $Job_date=$_POST['Job_date'];
      $Location=$_POST['Location'];
      $Project=$_POST['Project'];
      $Job_No=$_POST['JOB_No'];
      $PL=$_POST['PL'][$row];
      $WIP=$_POST['WIP'][$row];
      $Types=$_POST['Type'][$row];         
      $id_no = $_POST['id_no'][$row];

  
                  $OCustomer="";
                  $OBrandName ="";
                  $OCommodity ="";
                  $ORemarks_Item ="";
                  $OJob_date ="";
                  $OJob_No ="";
                  $OProject ="";
                  $OWIP ="";
                  $OType ="";
                  $OLocation ="";
                  $RecordTime =date("Y-m-d H:i:s");
                  $Recorder =$_SESSION['login_user'];
                  $status ="Update";
                                   
                  $sql="SELECT * FROM job WHERE  id = '$id_no' ";
                  $results=mysqli_query($con ,$sql); 
                  $row = $results->fetch_assoc();
                  $OCustomer = mysqli_real_escape_string($con,$row['Customer']);
                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $ORemarks_Item = mysqli_real_escape_string($con,$row['Remarks_Item']);

                  $OJob_date= $row['Job_date'];
                  $OPL= $row['PL'];
                  $OJob_No= $row['Job_No'];
                  $OProject= $row['Project'];
                  $OWIP= $row['WIP'];
                  $OType= $row['Type'];
                  $OLocation= $row['Location'];    
                           
                $sql="INSERT INTO job_history(input_ID,Customer,OCustomer,BrandName,OBrandName,Commodity,OCommodity,Remarks_Item,ORemarks_Item,Job_date,OJob_date,Job_No,OJob_No,Project,OProject,WIP,OWIP,Type,OType,Location,OLocation,PL,OPL,RecordTime,Recorder,status) 
                VALUES ('$id_no','$okyaku','$OCustomer','$BrandName','$OBrandName','$Commodity','$OCommodity','$Remarks_Item','$ORemarks_Item','$Job_date','$OJob_date','$Job_No','$OJob_No','$Project','$OProject','$WIP','$OWIP','$Types','$OType','$Location','$OLocation','$PL','$OPL','$RecordTime','$Recorder','$status')";
                  echo $sql;
                  mysqli_query($con ,$sql);
       
 
                  $sql = " UPDATE job SET Location ='$Location',Customer ='$okyaku',Commodity ='$Commodity',BrandName ='$BrandName',WIP ='$WIP',balanceWIP ='$WIP',Type ='$Types',Job_date ='$Job_date',Project ='$Project',Job_No ='$Job_No',PL ='$PL',Remarks_Item ='$Remarks_Item',UpdateTime='$UpdateTime',  Updator='$LUser' WHERE id='$id_no' ";  
                 // echo $sql;
                 mysqli_query($con ,$sql);
 

            }
                  $_SESSION['message'] = "Updated!"; 
                  print '<form method="POST" action="detail.php" >';
                  header("location:detail.php?Customer=$okyaku&JOB_NO=$Job_No");
                  print "</form>";   
}     

?>