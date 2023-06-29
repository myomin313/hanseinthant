
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
      
      $SupplierID=$_GET['SupplierID']; 
      $PL=$_GET['PL']; 
      $LUser = $_SESSION['login_user'];
      $UpdateTime= date("Y-m-d H:i:s");   
if (isset($_POST['Update'])) {

            foreach($_POST['Commodity'] as $row=>$Commodity) {    
                  $SupplierName = mysqli_real_escape_string($con,$_POST['SupplierName']);
                  $BrandName = mysqli_real_escape_string($con,$_POST['BrandName'][$row]);
                  $Commodity = mysqli_real_escape_string($con,$_POST['Commodity'][$row]);
                  $Remarks_Item = mysqli_real_escape_string($con,$_POST['Remarks_Item'][$row]);

                  $Branch=$_POST['Branch'];
                  $Packing_date=$_POST['Packing_date']; 
                  $Purchase_order_No=$_POST['Purchase_order_No']; 
                  $PO_NO=$_POST['PO_NO']; 
                  $Type=$_POST['Type'][$row];
                  $Qty=$_POST['Qty'][$row];
                  $Rate_Name=$_POST['Rate_Name'][$row];
                  $rate=$_POST['rate'][$row];
                  $totalRate=$_POST['totalRate'][$row];   

                  if ($Rate_Name == 'Myanmar') {

                    $USD =$rate / $rows['Myanmar'];
                    $totalUSD = $totalRate /$rows['Myanmar'];

                  }
                  elseif ($Rate_Name == 'Singapore') {
                    $USD = $rate * $rows['Singapore'];
                    $totalUSD = $totalRate * $rows['Singapore'];
                    

                  }
                  elseif ($Rate_Name == 'Europe') {
                    $USD = $rate * $rows['Europe'];
                    $totalUSD = $totalRate * $rows['Europe'];

                  }
                  elseif ($Rate_Name == 'Thailand') {
                    $USD = $rate * $rows['Thailand'];
                    $totalUSD = $totalRate * $rows['Thailand'];

                  }
                  elseif ($Rate_Name == 'British') {
                    $USD = $rate * $rows['British'];
                    $totalUSD = $totalRate * $rows['British'];

                  }
                  elseif ($Rate_Name == 'Japan') {
                    $USD = $rate * $rows['Japan'];
                    $totalUSD = $totalRate * $rows['Japan'];

                  }
                  elseif ($Rate_Name == 'Australia') {
                    $USD = $rate * $rows['Australia'];
                    $totalUSD = $totalRate * $rows['Australia'];

                  }
                  else{
                    $USD = $rate;
                    $totalUSD = $totalRate;
                  }              

                  $id = $_POST['id_no'][$row];                            

                  $OSupplierName="";
                  $OBrandName ="";
                  $OCommodity ="";
                  $OBranch ="";
                  $ORemarks_Item ="";
                  $OPacking_date ="";
                  $OPurchase_order_No ="";
                  $OPO_NO ="";
                  $OQty ="";
                  $OtotalRate ="";
                  $ORate_Name ="";
                  $OType ="";
                  $RecordTime =date("Y-m-d H:i:s");
                  $Recorder =$_SESSION['login_user'];
                  $status ="Update";
                                   
                  $sql="SELECT * FROM product WHERE  id = '$id' ";
                  $results=mysqli_query($con ,$sql); 
                  $row = $results->fetch_assoc();
                  $OSupplierName = mysqli_real_escape_string($con,$row['SupplierName']);
                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $ORemarks_Item = mysqli_real_escape_string($con,$row['Remarks_Item']);

                  $OBranch= $row['Branch']; 
                  $OPacking_date= $row['Packing_date'];
                  $OPurchase_order_No= $row['Purchase_order_No'];
                  $OPO_NO= $row['PO_NO'];
                  $OQty= $row['Qty'];
                  $OtotalRate= $row['totalRate'];
                  $ORate_Name= $row['Rate_Name'];
                  $OType= $row['Type'];   
                           
                  $sql="INSERT INTO product_history(input_ID,SupplierName,OSupplierName,BrandName,OBrandName,Commodity,OCommodity,Branch,OBranch,Remarks_Item,ORemarks_Item,Packing_date,OPacking_date,Purchase_order_No,OPurchase_order_No,PO_NO,OPO_NO,Qty,OQty,totalRate,OtotalRate,Rate_Name,ORate_Name,Type,OType,RecordTime,Recorder,status) 
                  VALUES ('$id','$SupplierName','$OSupplierName','$BrandName','$OBrandName','$Commodity','$OCommodity','$Branch','$OBranch','$Remarks_Item','$ORemarks_Item','$Packing_date','$OPacking_date','$Purchase_order_No','$OPurchase_order_No','$PO_NO','$OPO_NO','$Qty','$OQty','$totalRate','$OtotalRate','$Rate_Name','$ORate_Name','$Type','$OType','$RecordTime','$Recorder','$status')";

                  mysqli_query($con ,$sql);

                  $sql="UPDATE product SET SupplierName='$SupplierName', BrandName='$BrandName',Commodity='$Commodity',Branch='$Branch', Remarks_Item='$Remarks_Item',  Packing_date='$Packing_date',Purchase_order_No='$Purchase_order_No',  PO_NO='$PO_NO',Qty='$Qty',balanceQty='$Qty', rate='$rate', totalRate='$totalRate',Type='$Type',USD= '$USD',totalUSD='$totalUSD',Rate_Name='$Rate_Name',UpdateTime='$UpdateTime',  Updator='$LUser' WHERE  id = '$id' ";
                 // echo $sql;
                  mysqli_query($con ,$sql);

            }

                  $_SESSION['message'] = "Updated!"; 
                  print '<form method="POST" action="detail.php" >';
                  header("location:detail.php?SupplierID=$SupplierID&PL=$PL");
                  print '</form>';
}      

?>