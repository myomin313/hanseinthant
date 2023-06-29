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
        $transfer_no=$_POST['transfer_no'];
         
         //if ($Authority == 'Accountant') {     

        $sql = "SELECT DISTINCT transfer_no FROM transfer WHERE transfer_no ='$transfer_no'";
        $result=mysqli_query($con ,$sql); 
        $row = $result->fetch_assoc();
        $count=mysqli_num_rows($result);
        if($count==1)
             {
              echo"<script>alert('Your Transfer NO is not allowed.Please try again!');</script>"; 
              }  
      else{        
      $row_data = array();
      $i = 1;
      
      foreach($_POST['NCommodity'] as $row=>$NCommodity) { 

      
      $transfer_from = mysqli_real_escape_string($con,$_POST['transfer_from']);
      $transfer_to=mysqli_real_escape_string($con,$_POST['transfer_to']);
      $BrandName = mysqli_real_escape_string($con,$_POST['BrandName'][$row]);
      $Commoditys = mysqli_real_escape_string($con,$_POST['NCommodity'][$row]);
      $code = mysqli_real_escape_string($con,$_POST['code'][$row]);
      $Type=$_POST['NType'][$row];           
      $Qty=$_POST['NQty'][$row];
      $PL=$_POST['txtHintss'][$row];
      $NRemark = mysqli_real_escape_string($con,$_POST['NRemark'][$row]); 
      $transfer_date=$_POST['transfer_date'];
      $transfer_no=$_POST['transfer_no'];
      $LUser=$_POST['LUser']; 
	  $CreateTime= date("Y-m-d H:i:s");
    $Ntransfer_no = mysqli_real_escape_string($con,$_POST['Ntransfer_no'][$row]); 

      //for product insert
      $OSupplierName="";
      $OBrandName="";
      $OCommodity="";
      $Ocode="";
      $OBranch="";
      $Oremark_item="";
      $OPacking_Date="";
      $OPurchase_order_no="";
      $OPO_NO="";
      $OQty="";
      $ORate_name="";
      $Orate="";
      $OtotalRate="";
      $OUSD="";
      $OtotalUSD="";
      $OType="";
      $ObalanceQty="";
      $OcurrentQty="";
      $ObalanceWIP ="";
      $ObalanceDelivery="";
      $ObalanceUSD="";
      $ObalanceReturn="";
      $OCreateTime ="";
     // for product end

      //$row_data[] = "('$Location','$okyaku','$Commoditys','$BrandName','$code','$WIP','$WIP','$Type','$Job_date','$Project','$Job_No','$PL','$Remarks_Item','$balanceWIP','$CreateTime','$LUser')";
      if( $Ntransfer_no != ''){
      $sql="SELECT currentQty,USD FROM product 
      Where BrandName = '$BrandName' and Commodity ='$Commoditys' and Branch ='$transfer_from' and Purchase_order_No ='$PL' and transfer_no='$Ntransfer_no'";
      
      }else{
        $sql="SELECT currentQty,USD FROM product 
      Where BrandName = '$BrandName' and Commodity ='$Commoditys' and Branch ='$transfer_from' and Purchase_order_No ='$PL'"; 
      }
      $result=mysqli_query($con ,$sql); 


      $sum = 0;
      $transferUSD = 0; 
      while($row = mysqli_fetch_array($result))
     {
         

        $sum += $row['currentQty'];
        $transferUSD = $Qty * $row['USD'];         
     }
     $row_data[]="('$transfer_from','$transfer_to','$BrandName','$Commoditys','$code','$Type','$Qty','$transferUSD','$PL','$NRemark','$transfer_date','$transfer_no','$LUser','$CreateTime')";
    
    
    //  start
    if( $Qty > $sum){
        mysqli_rollback($con);
        echo"<script>alert('Your Quantity is not enough .Please try again!');</script>";                   
        echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit; 
    }else{

        //start
        if( $Ntransfer_no != ''){
        $sqlp="SELECT * FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and Branch ='$transfer_from' and Purchase_order_No ='$PL' and transfer_no='$Ntransfer_no'";
        }else{
          $sqlp="SELECT * FROM product Where BrandName = '$BrandName' and Commodity ='$Commoditys' and Branch ='$transfer_from' and Purchase_order_No ='$PL'"; 
        }
        $resultp=mysqli_query($con ,$sqlp);
        $rowp = $resultp->fetch_assoc();
        $OSupplierName=$rowp['SupplierName'];
        $OBrandName=$rowp['BrandName'];
        $OCommodity=$rowp['Commodity'];
        $Ocode=$rowp['code'];
        $Branch=$transfer_to;
        $Remarks_Item= $NRemark;
        $Packing_date= $rowp['Packing_date'];
        $Purchase_order_no= $transfer_no;
        $OPO_NO=$rowp['PO_NO'];
        $Qty=$Qty;
        $ORate_Name=$rowp['Rate_Name'];
        $Orate=$rowp['rate'];
        $OtotalRate=$rowp['rate'] * $Qty;
        $OUSD=$rowp['USD'];
        $OtotalUSD=$rowp['USD'] * $Qty;
        $OType=$rowp['Type'];
        $ObalanceQty=$rowp['balanceQty'];
        $OcurrentQty=$rowp['currentQty'];
        $ObalanceWIP=0;
        $ObalanceDelivery=0;
        $ObalanceUSD=0;
        $ObalanceReturn=0;
        $OCreateTime=date("Y-m-d H:i:s");
        $OCreator=$LUser;

        $row_pdatas[]="('$OSupplierName','$OBrandName','$OCommodity','$Ocode','$Branch','$Remarks_Item','$transfer_date',
        '$PL','$OPO_NO','$Qty','$OType','USD',
        '$OUSD','$OtotalUSD','$OUSD','$OtotalUSD','$Qty','$Qty','$ObalanceWIP','$ObalanceDelivery',
        '$ObalanceUSD','$ObalanceReturn','$OCreateTime','$OCreator','$transfer_no')";

        // start from old remain balance

        $remain_currentQty =  $rowp['currentQty'] - $Qty;
        $remain_balanceQty =  $rowp['balanceQty'] - $Qty;
       // $remain_balanceUSD =  $rowp['USD'] * ( $Qty +  $rowp['balanceDelivery'] ); 
        $remain_balanceUSD =  $rowp['USD'] * ( $Qty +  ( $rowp['balanceDelivery'] - $rowp['balanceReturn'] ) );
        $balanceTransfer = $rowp['balanceTransfer'] + $Qty;
        if( $Ntransfer_no != ''){
        $sqlpupdate = "UPDATE product SET balanceQty='$remain_balanceQty',currentQty ='$remain_currentQty',balanceUSD='$remain_balanceUSD',balanceTransfer='$balanceTransfer' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and Branch ='$transfer_from' and Purchase_order_No ='$PL' and transfer_no='$Ntransfer_no'";  
        }else{
          $sqlpupdate = "UPDATE product SET balanceQty='$remain_balanceQty',currentQty ='$remain_currentQty',balanceUSD='$remain_balanceUSD',balanceTransfer='$balanceTransfer' Where BrandName = '$BrandName' and Commodity ='$Commoditys' and Branch ='$transfer_from' and Purchase_order_No ='$PL'";   
        }
        mysqli_query($con,$sqlpupdate); 

       }

      $i += 1;
      }
         
        $osql='INSERT INTO product(SupplierName,BrandName,Commodity,code,Branch,Remarks_Item,Packing_date,Purchase_order_No,PO_NO,Qty,Type,Rate_Name,rate,totalRate,USD,totalUSD,balanceQty,currentQty,balanceWIP,balanceDelivery,balanceUSD,balanceReturn,CreateTime,Creator,transfer_no) VALUES '.implode(',', $row_pdatas);
        
        mysqli_query($con,$osql);
        //end
        $sql = 'INSERT INTO transfer(transfer_from,transfer_to,BrandName,Commodity,code,Type,Qty,transferUSD,PL,Remark_Item,transfer_date,transfer_no,Creator,CreateTime) VALUES '.implode
      (',', $row_data);

        mysqli_query($con ,$sql);
        
        echo"<script>alert('Success');</script>";

}
echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit;

}
?>
