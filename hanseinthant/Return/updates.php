
<?php

      include_once('../config.php');
      session_start();
// $setutf8 = "SET NAMES utf8";
// $q = $con->query($setutf8);
// $setutf8c = "SET character_set_results = 'utf8', character_set_client =
// 'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
// character_set_server = 'utf8'";
// $qc = $con->query($setutf8c);
// $setutf9 = "SET CHARACTER SET utf8";
// $q1 = $con->query($setutf9);
// $setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
// $q2 = $con->query($setutf7);

      $DO_No=$_GET['DO_No'];
      $Customer=$_GET['Customer']; 
      $LUser = $_SESSION['login_user'];
      $UpdateTime= date("Y-m-d H:i:s"); 
      if (isset($_POST['Update'])) {
             $customerID =$_POST['customerID'];

            foreach($_POST['Commodity'] as $row=>$Commodity) {     

                  $DO_No=$_POST['DO_No'];

                  $department=$_POST['department'];
                  $Return_no=$_POST['Return_no'];
                  $Return_date=$_POST['Return_date'];

                  $okyaku = mysqli_real_escape_string($con,$_POST['okyaku']);
                  $BrandName = mysqli_real_escape_string($con,$_POST['BrandName'][$row]);
                  $Commodity = mysqli_real_escape_string($con,$_POST['Commodity'][$row]);
                  $Remarks_item = mysqli_real_escape_string($con,$_POST['Remarks_item'][$row]);
                  $Qty=$_POST['quan'][$row];
                  $PL=$_POST['PL'][$row];
                  $Types=$_POST['Types'][$row];
     
                  $LUser = $_SESSION['login_user'];
                  $IDss = $_POST['IDss'][$row];

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
                  $Recorder =$_SESSION['login_user'];
                  $status ="Update";
                                   
                  $sql="SELECT * FROM returns WHERE  id = '$IDss' ";
                  $results=mysqli_query($con ,$sql); 
                  $row = $results->fetch_assoc();

                  $OCustomer = mysqli_real_escape_string($con,$row['Customer']);
                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $ORemarks_item = mysqli_real_escape_string($con,$row['Remarks_item']);

                  $OReturn_date= $row['Return_date'];
                  $OReturn_no= $row['Return_no'];
                  $ODO_No= $row['DO_No'];                                  
                  $Odepartment= $row['department'];
                  $OQty= $row['Qty'];
                  $OType= $row['Type'];
                           
                $sql="INSERT INTO customerreturn_history(input_ID,Customer,OCustomer,BrandName,OBrandName,Commodity,OCommodity,Remarks_item,ORemarks_item,Return_date,OReturn_date,Return_no,OReturn_no,DO_No,ODO_No,department,Odepartment,Qty,OQty,Type,OType,RecordTime,Recorder,status) 
                VALUES ('$IDss','$Customer','$OCustomer','$BrandName','$OBrandName','$Commodity','$OCommodity','$Remarks_item','$ORemarks_item','$Return_date','$OReturn_date','$Return_no','$OReturn_no','$DO_No','$ODO_No','$department','$Odepartment','$Qty','$OQty','$Types','$OType','$RecordTime','$Recorder','$status')";
                  // echo $sql;
                  mysqli_query($con ,$sql);   

                  $sql = " UPDATE returns SET Customer ='$Customer',department='$department',DO_No='$DO_No',Return_no ='$Return_no',Return_date ='$Return_date',BrandName ='$BrandName',Commodity ='$Commodity',Qty ='$Qty',Remarks_item ='$Remarks_item',Type ='$Types',PL ='$PL',UpdateTime='$UpdateTime',  Updator='$LUser' WHERE id='$IDss'";  

                  // echo $sql;
                  $result = $con -> query($sql);
                   
 

            }            

                  mysqli_query($con,$return);

                  $_SESSION['message'] = "Updated!"; 
                  print '<form method="POST" action="detail.php" >';
                  header("location:detail.php?BrandName=$BrandNameB&Customer=$Customer&JOB_No=$JOB_Nos&DO_No=$DO_No");
                  print "</form>";   

}
?>