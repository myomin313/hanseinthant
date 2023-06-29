<?php session_start();?>
<?php 
if (($_SESSION['login_session']<> true)) {
  header("Location:../index.php");    
  exit();
}     

?>

<?php
include_once('../config.php');
//$myusername = $_SESSION['login_user'];
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
if($_SERVER["REQUEST_METHOD"] == "POST")
{
        $Job_No=$_POST['JOB_No'].''.$_POST['dep_name'];
         
         //if ($Authority == 'Accountant') {     

        $sql = "SELECT DISTINCT Job_No FROM job WHERE Job_No ='$Job_No'";
        $result=mysqli_query($con ,$sql); 
        $row = $result->fetch_assoc();
        $count=mysqli_num_rows($result);
        if($count==1)
             {
              echo"<script>alert('Your JOB NO is not allowed.Please try again!');</script>"; 
              }  
      else{        
      $row_data = array();
      $i = 1;
      
      foreach($_POST['Commodity'] as $row=>$Commodity) { 

      $Commoditys = mysqli_real_escape_string($con,$_POST['Commodity'][$row]);
      $okyaku = mysqli_real_escape_string($con,$_POST['okyaku']);
      $BrandName = mysqli_real_escape_string($con,$_POST['BrandName'][$row]);
      $code = mysqli_real_escape_string($con,$_POST['code'][$row]);
      $Remarks_Item = mysqli_real_escape_string($con,$_POST['Remarks_Item'][$row]);      

      $Job_date=$_POST['Job_date'];
      $Project=$_POST['Project'];
      $Job_No=$_POST['JOB_No'].''.$_POST['dep_name'];
      $Location=$_POST['Location'];

      $PL=$_POST['PL'][$row];
      $WIP=$_POST['WIP'][$row];
      $balanceWIP=0;
      $Type=$_POST['Type'][$row];
      
	$LUser=$_POST['LUser']; 
	$CreateTime= date("Y-m-d H:i:s"); 

      $row_data[] = "('$Location','$okyaku','$Commoditys','$BrandName','$code','$WIP','$WIP','$Type','$Job_date','$Project','$Job_No','$PL','$Remarks_Item','$balanceWIP','$CreateTime','$LUser')";
      
      $sql="SELECT Qty,balanceWIP,balanceDelivery,balanceReturn FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and Branch ='$Location' and Purchase_order_No ='$PL'";
      $result=mysqli_query($con ,$sql); 
      $rows = $result->fetch_assoc();
      
      $balanceWIP = $rows['balanceWIP'] + $WIP;

      $sql = " UPDATE product SET balanceWIP ='$balanceWIP' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and Branch ='$Location' and Purchase_order_No ='$PL'"; 

      mysqli_query($con ,$sql);
//2019-08-07 newton USD column is not include       $sqlresult="SELECT Qty,balanceWIP,balanceDelivery,balanceReturn FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and Branch ='$Location' and Purchase_order_No ='$PL'";
        $sqlresult="SELECT balanceTransfer,Qty,balanceWIP,balanceDelivery,balanceReturn,USD FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and Branch ='$Location' and Purchase_order_No ='$PL'";
      $results=mysqli_query($con ,$sqlresult); 
      $rowsreesult = $results->fetch_assoc();

      $wtd=$rowsreesult['balanceDelivery']+$rowsreesult['balanceTransfer'];
      $return=$wtd-$rowsreesult['balanceReturn'];
 
      $bal=$rowsreesult['balanceWIP']+ $return;
      $balanceQtyss = $rowsreesult['Qty'] - $bal;
      $s = " UPDATE product SET balanceQty ='$balanceQtyss' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and code='$code' and Branch ='$Location' and Purchase_order_No ='$PL'"; 
      
      mysqli_query($con ,$s);     

      $balanceUSDs = $rowsreesult['USD'] * $return;

//2019-08-07 newton ☆☆☆$_GET['PL']☆☆☆ is not exist $sql = " UPDATE product SET  balanceUSD='$balanceUSDs' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and Branch ='$Location'  and Purchase_order_No ='".$_GET['PL']."'"; 
      $sql = " UPDATE product SET  balanceUSD='$balanceUSDs' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and  code='$code' and Branch ='$Location'  and Purchase_order_No ='".$PL."'"; 

      mysqli_query($con ,$sql);    

      $i += 1;
      }

      $sql = 'INSERT INTO job(Location,Customer,Commodity,BrandName,code,WIP,balanceJOB,Type,Job_date,Project,Job_No,PL,Remarks_Item,balanceWIP,CreateTime,Creator) VALUES '.implode
      (',', $row_data);

        mysqli_query($con ,$sql);
        echo"<script>alert('Success');</script>";

}
echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit;

}
?>
