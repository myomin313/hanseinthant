<?php

include_once('../config.php');

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

      $transfer_from=$_GET['transfer_from']; 
      $transfer_to=$_GET['transfer_to']; 
      // $Delivery_date=$_GET['Delivery_date']; 
      $transfer_no=$_GET['transfer_no'];
      $ids=$_GET['ids']; 

      // $Commodity = mysqli_real_escape_string($con,$_GET['Commodity']);
      // $BrandName = mysqli_real_escape_string($con,$_GET['BrandName']);
      // $Remark_item = mysqli_real_escape_string($con,$_GET['Remark_item']);              

      // $Types=$_GET['Type']; 
      // $Qty=$_GET['Qty']; 
      // $PL=$_GET['PL']; 
                  $Otransfer_from="";
                  $OBrandName ="";
                  $OCommodity ="";
                  $Ocode="";
                  $ORemark_Item ="";
                  $Otransfer_date ="";
                  $Otransfer_no ="";
                  $OQty ="";
                  $OPL ="";
                  $OType ="";
                  $Otransfer_to ="";
                  $RecordTime =date("Y-m-d H:i:s");
                  $Recorder =$_GET['LUser'];     
                  $status ="Delete";
                  $idarray = explode(',', $ids);

       foreach($idarray as $id) {
                                   
                  $sql="SELECT * FROM transfer WHERE  id = '$id' ";
                  $results=mysqli_query($con ,$sql); 
                  $row = $results->fetch_assoc();
                  $Otransfer_from = mysqli_real_escape_string($con,$row['transfer_from']);
                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $Ocode = mysqli_real_escape_string($con,$row['code']);
                  $ORemark_Item = mysqli_real_escape_string($con,$row['Remark_Item']);

                  $Otransfer_date= $row['transfer_date'];
                  $Otransfer_no= $row['transfer_no'];
                  $OQty= $row['Qty'];
                  $OPL= $row['PL'];
                  $OType= $row['Type'];
                  $Otransfer_to= $row['transfer_to'];
                  $ptransfer_no = mysqli_real_escape_string($con,$row['ptransfer_no']);

       $sqlS = "SELECT Distinct DO_No,department,Customer,Commodity,BrandName,PL  FROM returns WHERE PL ='$transfer_no' and Commodity ='$OCommodity' and code='$Ocode' and BrandName ='$OBrandName'";
        // echo $sqlS;
        $resultS=mysqli_query($con ,$sqlS); 
        $rowS = $resultS->fetch_assoc();
                  $countS=mysqli_num_rows($resultS);
                  if($countS==1)
                  {
                   echo"<script>alert('Your Transfer No. is connected to Delivery.Please remove Delivery First. first!');</script>";  
                echo "<script type='text/javascript'>window.top.location='detail.php?transfer_no=$transfer_no';</script>";exit;
                  }  
      else{   
          
          $sql="INSERT INTO transfer_history(input_ID,transfer_from,Otransfer_from,OBrandName,OCommodity,Ocode,Remark_Item,ORemark_Item,transfer_date,Otransfer_date,transfer_no,Otransfer_no,Qty,OQty,PL,OPL,Type,OType,transfer_to,Otransfer_to,RecordTime,Recorder,status) 
                VALUES ('$id','','$Otransfer_from','$OBrandName','$OCommodity','$Ocode','','$ORemark_Item','','$Otransfer_date','','$Otransfer_no','','$OQty','','$OPL','','$OType','','$Otransfer_to','$RecordTime','$Recorder','$status')";                   
                
                  mysqli_query($con,$sql);

      if( $ptransfer_no != ''){             
        $sqlproduct="SELECT * FROM product Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$transfer_from' and Purchase_order_No ='$OPL' and transfer_no='$ptransfer_no'";
      }else{
        $sqlproduct="SELECT * FROM product Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$transfer_from' and Purchase_order_No ='$OPL' AND ( transfer_no IS NULL OR transfer_no='')"; 
      }
      $resultproduct=mysqli_query($con ,$sqlproduct); 
      $product = $resultproduct->fetch_assoc(); 
      
      // start myomin for transfer
      $update_blancerTransfer=$product['balanceTransfer'] - $OQty;
      $update_balanceQty = $product['balanceQty'] + $OQty;
      $update_currentQty = $product['currentQty'] + $OQty;
      $update_balanceUSD = $product['balanceUSD'] -  ( $OQty * $product['USD']);
      
      if( $ptransfer_no != ''){
      $sqluproduct = " UPDATE product SET  balanceTransfer ='$update_blancerTransfer', balanceQty='$update_balanceQty', currentQty='$update_currentQty', balanceUSD='$update_balanceUSD' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$transfer_from' and Purchase_order_No ='$OPL' and transfer_no='$ptransfer_no'";
      }else{
        $sqluproduct = " UPDATE product SET  balanceTransfer ='$update_blancerTransfer', balanceQty='$update_balanceQty', currentQty='$update_currentQty', balanceUSD='$update_balanceUSD' Where BrandName = '$OBrandName' and Commodity ='$OCommodity' and code='$Ocode' and Branch ='$transfer_from' and Purchase_order_No ='$OPL' AND ( transfer_no IS NULL OR transfer_no='')";  
      }
      mysqli_query($con ,$sqluproduct);

    if( $transfer_no != ''){
      $sqlddelete="DELETE FROM product WHERE branch='$transfer_to' AND  Purchase_order_No='$OPL' AND BrandName ='$OBrandName' AND Commodity='$OCommodity' AND code='$Ocode' AND transfer_no='$transfer_no'";
    }else{
      $sqlddelete="DELETE FROM product WHERE branch='$transfer_to' AND  Purchase_order_No='$OPL' AND BrandName ='$OBrandName' AND Commodity='$OCommodity' AND code='$Ocode' AND transfer_no !=''"; 
    }
      mysqli_query($con ,$sqlddelete);

      $sql="DELETE FROM transfer WHERE id='$id'";
      
      mysqli_query($con ,$sql);
      //end myomin for transfer
    }    
 }
    echo"<script>alert('Successfully Deleted');</script>"; 
    echo "<script type='text/javascript'>window.top.location='detail.php?transfer_no=$transfer_no';</script>";exit;
?>