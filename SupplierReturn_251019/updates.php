
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
      $Supplier=$_GET['Supplier']; 
      $PL=$_GET['PL'];
      $LUser = $_SESSION['login_user'];
      $UpdateTime= date("Y-m-d H:i:s");       
      if (isset($_POST['Update'])) {

            foreach($_POST['Commodity'] as $row=>$Commodity) {     

                  $PL = $_POST['PL_NO'];
                  $Branch = $_POST['Branch'];
                  $Return_date=$_POST['Return_date'];
                  $supplier = mysqli_real_escape_string($con,$_POST['supplier']);
                  $BrandName = mysqli_real_escape_string($con,$_POST['BrandName'][$row]);
                  $Commodity = mysqli_real_escape_string($con,$_POST['Commodity'][$row]);
                  $Remarks_item = mysqli_real_escape_string($con,$_POST['Remarks_item'][$row]);

                  $Qty=$_POST['quan'][$row];
                  $Types=$_POST['Types'][$row];
                  $LUser = $_SESSION['login_user'];
                  $IDss = $_POST['IDss'][$row];

                  $OSupplier="";
                  $OBrandName ="";
                  $OCommodity ="";
                  $ORemark_item ="";
                  $OReturn_date ="";
                  $OPL ="";                
                  $OQty ="";
                  $OType ="";
                  $RecordTime =date("Y-m-d H:i:s");
                  $Recorder =$_SESSION['login_user'];
                  $status ="Update";
                                   
                  $sql="SELECT * FROM supplier_return WHERE  id = '$IDss' ";
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
                           
                $sql="INSERT INTO supplierreturn_history(input_ID,Supplier,OSupplier,Branch,OBranch,BrandName,OBrandName,Commodity,OCommodity,Remark_item,ORemark_item,Return_date,OReturn_date,PL,OPL,Qty,OQty,Type,OType,RecordTime,Recorder,status) 
                VALUES ('$IDss','$Supplier','$OSupplier','$Branch','$OBranch','$BrandName','$OBrandName','$Commodity','$OCommodity','$Remarks_item','$ORemark_item','$Return_date','$OReturn_date','$PL','$OPL','$Qty','$OQty','$Types','$OType','$RecordTime','$Recorder','$status')";
                  // echo $sql;
                  mysqli_query($con ,$sql);

                  $sql = " UPDATE supplier_return SET Supplier ='$Supplier', Branch ='$Branch',PL='$PL',Return_date ='$Return_date',BrandName ='$BrandName',Commodity ='$Commodity',Qty ='$Qty',Remark_item ='$Remarks_item',Type ='$Types',UpdateTime='$UpdateTime',  Updator='$LUser' WHERE id='$IDss'";  

                 // echo $sql;
                   mysqli_query($con,$sql);
    

            }
            
                  // $sqls = " UPDATE product SET Qty='$NSubQty' WHERE SupplierName ='$Supplier' AND Commodity = '$NCommodity'  AND Purchase_order_No = '$PL'";
                  // // echo $sqls;


                 $_SESSION['message'] = "Updated!"; 
                  print '<form method="POST" action="detail.php" >';
                  header("location:detail.php?Supplier=$Supplier&PL=$PL");
                  print "</form>";   

}
?>