<?php 
include_once('config.php');
      session_start();

 $select ="SELECT Qty,USD,id FROM product";
 $results=mysqli_query($con ,$select); 
// $rows = $results->fetch_assoc();

 while($row = mysqli_fetch_array($results)){
 
     //$USD = (float) str_replace(',','', $row['Myanmar']) ;
   //  $Rate_date = $row['Rate_date'];
       $id=$row['id'];
       $Qty=$row['Qty'];
       $USD   = $row['USD'];
      /*$sql = "UPDATE product SET totalUSD = totalRate / '$USD' WHERE Packing_date='$Rate_date'";
       mysqli_query($con,$sql); */
         $sql = "UPDATE product SET totalUSD = '$USD' * '$Qty' WHERE id='$id'";
       mysqli_query($con,$sql); 
     // $sql="UPDATE product SET USD='rate /', BrandName='$BrandName',Commodity='$Commodity',Branch='$Branch', Remarks_Item='$Remarks_Item', Packing_date='$Packing_date',Purchase_order_No='$Purchase_order_No',  PO_NO='$PO_NO',Qty='$Qty', balanceQty='$BalQty',currentQty='$currQuantity',rate='$rate', totalRate='$totalRate',Type='$Type',USD= '$itemUSD',totalUSD='$itemtotalUSD',Rate_Name='$Rate_Name' WHERE  id = '$id' and Branch = '$Branch' and SupplierName = '$SupplierName' and Purchase_order_No = '$Purchase_order_No' ";


 }

/*$setutf8 = "SET NAMES utf8";
$q = $con->query($setutf8);*/
/*$setutf8c = "SET character_set_results = 'utf8', character_set_client =
'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
character_set_server = 'utf8'";
$qc = $con->query($setutf8c);
$setutf9 = "SET CHARACTER SET utf8";
$q1 = $con->query($setutf9);
$setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
$q2 = $con->query($setutf7);*/

// $select ="SELECT Myanmar,Rate_date FROM rate";
//  $results=mysqli_query($con ,$select); 
//  $rows = $results->fetch_assoc();

//  while($row = mysqli_fetch_array($results)){
 
//      $USD = (float) str_replace(',','', $row['Myanmar']) ;
//      $Rate_date = $row['Rate_date'];

      // $sql = "UPDATE product SET USD = rate WHERE Rate_Name='USD'";
      //  mysqli_query($con,$sql); 
     // $sql="UPDATE product SET USD='rate /', BrandName='$BrandName',Commodity='$Commodity',Branch='$Branch', Remarks_Item='$Remarks_Item', Packing_date='$Packing_date',Purchase_order_No='$Purchase_order_No',  PO_NO='$PO_NO',Qty='$Qty', balanceQty='$BalQty',currentQty='$currQuantity',rate='$rate', totalRate='$totalRate',Type='$Type',USD= '$itemUSD',totalUSD='$itemtotalUSD',Rate_Name='$Rate_Name' WHERE  id = '$id' and Branch = '$Branch' and SupplierName = '$SupplierName' and Purchase_order_No = '$Purchase_order_No' ";


 // }


    // foreach($rows as $row=>$Commodity) {

    // } 
 
// $sql = "UPDATE
//     product p
// JOIN rate r ON
//     (p.Product_date = r.Rate_date)
// SET
//     p.USD = p.rate / (float) str_replace(',', '', r.Myanmar);";

//     echo $sql;exit();

//       mysqli_query($con,$sql);
//       if (mysqli_query($con,$sql)) {
//       	echo "success";exit();
//       }else{
//       	echo "error";exit();
//       }
?>
