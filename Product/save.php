<?php 
include_once('../config.php');
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
if($_SERVER["REQUEST_METHOD"] == "POST")
{ 
$Packing_date=$_POST['keyword']; 
$sqls = "SELECT DISTINCT Rate_date FROM rate WHERE Rate_date ='$Packing_date'";
$resultss=mysqli_query($con ,$sqls); 
$rows = $resultss->fetch_assoc();
$counts=mysqli_num_rows($resultss);
if($counts!=1)
{
 echo"<script>alert('Your Date is not allowed.Please try again!');</script>"; 

} 

else{ 
      $Purchase_order_No=$_POST['Purchase_order_No']; 
      $PO_NO=$_POST['PO_NO']; 

      $sql = "SELECT DISTINCT Purchase_order_No FROM product WHERE Purchase_order_No ='$Purchase_order_No'";
      $result=mysqli_query($con ,$sql); 
      $row = $result->fetch_assoc();
      $count=mysqli_num_rows($result);
      if($count==1)
      {
         echo"<script>alert('Your PL Number is not allowed.Please try again!');</script>"; 
      }  
      else{  
      $Packing_date=$_POST['keyword']; 
      $sql="SELECT Singapore,Europe,Thailand,British,Japan,Australia,Myanmar FROM rate WHERE Rate_date = '$Packing_date'";
      $results=mysqli_query($con ,$sql); 
      $rows = $results->fetch_assoc();
      $row_datas = array();
      $i = 1;
      
      foreach($_POST['itemCommodity'] as $row=>$Commodity) { 
      $itemCommodity = $_POST['itemCommodity'][$row];
      $Branch=$_POST['Branch'];

      $itemQty=$_POST['itemQty'][$row];
      $Rate_Name=$_POST['Rate_Name'][$row];
      $rate=$_POST['rate'][$row]; 
      $totalRate=$_POST['totalRate'][$row];

        if ($Rate_Name == 'Myanmar') {
        //   $USD =$rate / (float) str_replace(',', '', $rows['Myanmar']);
          //$totalUSD = $totalRate / (float) str_replace(',', '', $rows['Myanmar']);
         // $getUSD = $rate * str_replace(',', '',$rows['Myanmar']);
          $getUSD =$rate / str_replace(',', '',$rows['Myanmar']);
          $USD=round($getUSD, 4);
          $totalUSD = $itemQty * $USD;
        }
        elseif ($Rate_Name == 'Singapore') {
          //$totalUSD = $totalRate * (float) str_replace(',', '',$rows['Singapore']);
          //$USD = $rate * (float) str_replace(',', '',$rows['Singapore']);
          $getUSD = $rate * str_replace(',', '',$rows['Singapore']);
          $USD=round($getUSD, 4);
          $totalUSD = $itemQty * $USD;
        
        }
        elseif ($Rate_Name == 'Europe') {
        //   $USD = $rate * (float) str_replace(',', '',$rows['Europe']);
          //$totalUSD = $totalRate * (float) str_replace(',', '',$rows['Europe']);
          $getUSD = $rate * str_replace(',', '',$rows['Europe']);
          $USD=round($getUSD, 4);
           $totalUSD = $itemQty * $USD;
        }
        elseif ($Rate_Name == 'Thailand') {
        //   $USD = $rate * (float) str_replace(',', '',$rows['Thailand']);
          
          $getUSD = $rate * str_replace(',', '',$rows['Thailand']);
          $USD=round($getUSD, 4);
          $totalUSD = $itemQty * $USD;
        
        }
        elseif ($Rate_Name == 'British') {
        //   $USD = $rate * (float) str_replace(',', '',$rows['British']);
         // $totalUSD = $totalRate * (float) str_replace(',', '',$rows['British']);
         $getUSD = $rate * str_replace(',', '',$rows['British']);
          $USD=round($getUSD, 4);
         $totalUSD = $itemQty * $USD;
        
        }
        elseif ($Rate_Name == 'Japan') {
        //   $USD = $rate * (float) str_replace(',', '',$rows['Japan']);
          //$totalUSD = $totalRate * (float) str_replace(',', '',$rows['Japan']);
          $getUSD = $rate * str_replace(',', '',$rows['Japan']);
          $USD=round($getUSD, 4);
          $totalUSD = $itemQty * $USD;
        }
        elseif ($Rate_Name == 'Australia') {
         //$USD = $rate * (float) str_replace(',', '',$rows['Australia']);
          //$totalUSD = $itemQty * (float) str_replace(',', '',$rows['Australia']);
         $getUSD = $rate * str_replace(',', '',$rows['Australia']);
          $USD=round($getUSD, 4);
          $totalUSD = $itemQty * $USD;
        }
        else{
          $USD = $rate;
          $totalUSD = $totalRate;
        }

      $itemType=$_POST['itemType'][$row];
      $itemRemarks_Item = mysqli_real_escape_string($con,$_POST['itemRemarks_Item'][$row]);

      $Purchase_order_Nos = mysqli_real_escape_string($con,$_POST['Purchase_order_No']);
      $PO_NOs = mysqli_real_escape_string($con,$_POST['PO_NO']);

      $SupplierName = mysqli_real_escape_string($con,$_POST['SupplierName']);
      $BrandName = mysqli_real_escape_string($con,$_POST['BrandName'][$row]);
      $code=$_POST['code'][$row];
      $itemCommodity = mysqli_real_escape_string($con,$_POST['itemCommodity'][$row]);
      
	  $LUser=$_POST['LUser']; 
	  $CreateTime= date("Y-m-d H:i:s");  
      $balanceWIP=0;
      $balanceDelivery=0;
      $balanceUSD=0;
      $balanceReturn=0;
                
      $row_datas[] = "('$SupplierName','$BrandName','$code','$itemCommodity','$Branch','$itemRemarks_Item','$Packing_date','$Purchase_order_Nos','$PO_NOs','$itemQty','$itemType','$Rate_Name','$rate','$totalRate','$USD','$totalUSD','$itemQty','$itemQty','$balanceWIP','$balanceDelivery','$balanceUSD','$balanceReturn','$CreateTime','$LUser')";

      
      $i += 1;
      }

$sql='INSERT INTO product(SupplierName,BrandName,code,Commodity,Branch,Remarks_Item,Packing_date,Purchase_order_No,PO_NO,Qty,Type,Rate_Name,rate,totalRate,USD,totalUSD,balanceQty,currentQty,balanceWIP,balanceDelivery,balanceUSD,balanceReturn,CreateTime,Creator) VALUES '.implode
      (',', $row_datas);
// echo $sql;
mysqli_query($con ,$sql);
echo"<script>alert('Success');</script>";


 }
}
echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit;
}
?>
