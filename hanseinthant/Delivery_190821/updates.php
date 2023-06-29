
<?php

      include_once('../config.php');
      session_start();
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

      $DO=$_GET['DO'];
      $CustomerID=$_GET['CustomerID'];
      $LUser = $_SESSION['login_user'];
      $UpdateTime= date("Y-m-d H:i:s");
      if (isset($_POST['Update'])) {
      $DO_No=$_POST['DO_No']; 
      $BrandName=$_POST['BrandName'];

            foreach($_POST['Commodity'] as $row=>$Commodity) {     
                  $PL=$_POST['PL'][$row]; 
                  $Delivery_date = $_POST['Delivery_date'];
                  $DO_No=$_POST['DO_No'];
                  $Location=$_POST['Location'];
                  $JOB_No=$_POST['JOB_No'];

                  $Commodity = mysqli_real_escape_string($con,$_POST['Commodity'][$row]);
                  $okyaku = mysqli_real_escape_string($con,$_POST['okyaku']);
                  $BrandName = mysqli_real_escape_string($con,$_POST['BrandName'][$row]);
                  $Remark_item = mysqli_real_escape_string($con,$_POST['Remark_item'][$row]);     

                  $Qty=$_POST['Qty'][$row];
                  $Types=$_POST['Types'][$row]; 

                  $LUser = $_SESSION['login_user'];
                  $IDss = $_POST['IDss'][$row];

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
                                   
                  $sql="SELECT * FROM delivery WHERE  id = '$IDss' ";
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
                VALUES ('$IDss','$CustomerID','$OCustomer','$BrandName','$OBrandName','$Commodity','$OCommodity','$Remark_item','$ORemark_Item','$Delivery_date','$ODelivery_date','$DO_No','$ODO_No','$JOB_No','$OJOB_No','$Qty','$OQty','$PL','$OPL','$Types','$OType','$Location','$OLocation','$RecordTime','$Recorder','$status')";
                  // echo $sql;
                  mysqli_query($con ,$sql);

                $sql = " UPDATE delivery SET Customer ='$okyaku',Location='$Location',Delivery_date='$Delivery_date',DO_No ='$DO_No',JOB_No ='$JOB_No',BrandName ='$BrandName',Commodity ='$Commodity',Qty ='$Qty',Remark_item ='$Remark_item',UpdateTime='$UpdateTime',  Updator='$LUser' WHERE id='$IDss'";  
                  $result = $con -> query($sql);

               
            }            
                  mysqli_query($con,$sql);    
                   $_SESSION['message'] = "Updated!"; 
                  print '<form method="POST" action="detail.php" >';
                  header("location:detail.php?ID=$okyaku&DO=$DO_No");
                  print "</form>";   

}

?>