<?php 
    include_once('../config.php');
    
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
      $SupplierName=$_GET['SupplierName']; 
      $Branch=$_GET['Branch']; 
      $Packing_date=$_GET['Packing_date']; 
      $PL=$_GET['Purchase_order_No']; 
      $PO_NO=$_GET['PO_NO']; 

      $id=$_GET['id']; 
      $Commodity = mysqli_real_escape_string($con,$_GET['Commodity']);
      $BrandName = mysqli_real_escape_string($con,$_GET['BrandName']);
      $Remarks_Item = mysqli_real_escape_string($con,$_GET['Remarks_Item']);  

      $Type=$_GET['Type']; 
      $Rate_Name=$_GET['Rate_Name']; 
      $rate=$_GET['rate']; 
      $Qty=$_GET['Qty'];
      $totalRate=$_GET['totalRate']; 
      
                  $RecordTime =date("Y-m-d H:i:s");
                  $Recorder =$_GET['LUser'];       

                  $OSupplierName="";
                  $OBrandName ="";
                  $OCommodity ="";
                  $ORemarks_Item ="";
                  $OPacking_date ="";
                  $OPurchase_order_No ="";
                  $OPO_NO ="";
                  $OQty ="";
                  $ORate_Name ="";
                  $OtotalRate ="";
                  $OType ="";

                  $status ="Delete";
                                   
                  $sql="SELECT * FROM product WHERE  id = '$id' ";
                  $results=mysqli_query($con ,$sql); 
                  $row = $results->fetch_assoc();
                  $OSupplierName = mysqli_real_escape_string($con,$row['SupplierName']);
                  $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
                  $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
                  $ORemarks_Item = mysqli_real_escape_string($con,$row['Remarks_Item']);                     

                  $OPacking_date= $row['Packing_date'];
                  $OPurchase_order_No= $row['Purchase_order_No'];
                  $OPO_NO= $row['PO_NO'];
                  $OQty= $row['Qty'];
                  $OtotalRate= $row['totalRate'];
                  $ORate_Name= $row['Rate_Name'];
                  $OType= $row['Type'];
                  $Orate= $row['rate']; 
                  $OBranch= $row['Branch']; 

       $sqlA = "SELECT DISTINCT BrandName,Commodity,PL FROM job WHERE BrandName ='$BrandName' and Commodity= '$Commodity' and PL = '$PL'  and Location = '$Branch'";
        $resultA=mysqli_query($con ,$sqlA); 
        $row = $resultA->fetch_assoc();
        $count=mysqli_num_rows($resultA);
        
       $sqls = "SELECT DISTINCT BrandName,Commodity,PL FROM delivery WHERE BrandName ='$BrandName' and Commodity= '$Commodity' and PL = '$PL'";
        $results=mysqli_query($con ,$sqls); 
        $rows = $results->fetch_assoc();
        $counts=mysqli_num_rows($results);   
        
        
        if($count==1)
             {
                   echo"<script>alert('Your PL NO. is connected to WIP .Please remove WIP. first!');</script>"; 
         echo "<script type='text/javascript'>window.top.location='detail.php?SupplierID=$SupplierID&Date=$Date&PL=$PL';</script>";exit;	
              }  

      elseif($counts==1)
                  {
                   echo"<script>alert('Your PL NO. is connected to Delivery .Please remove Delivery. first!');</script>";      
                  echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit;
                  }                    
      else{  
                            $sql="INSERT INTO product_history(input_ID,SupplierName,OSupplierName,BrandName,OBrandName,Commodity,OCommodity,Branch,OBranch,Remarks_Item,ORemarks_Item,Packing_date,OPacking_date,Purchase_order_No,OPurchase_order_No,PO_NO,OPO_NO,Qty,OQty,totalRate,OtotalRate,Rate_Name,ORate_Name,rate,Orate,Type,OType,RecordTime,Recorder,status) 
                  VALUES ('$id','','$OSupplierName','','$OBrandName','','$OCommodity','','$OBranch','','$ORemarks_Item','','$OPacking_date','','$OPurchase_order_No','','$OPO_NO','','$OQty','','$OtotalRate','','$ORate_Name','','$Orate','','$OType','$RecordTime','$Recorder','$status')";  
                           
                // echo $sql;
                  mysqli_query($con ,$sql);

		 $sql="DELETE FROM product WHERE id='$id' AND SupplierName='$SupplierName' AND Purchase_order_No='$PL' ";
	     mysqli_query($con,$sql);
		 echo"<script>alert('Successfully Deleted');</script>"; 
         echo "<script type='text/javascript'>window.top.location='detail.php?SupplierID=$SupplierID&Date=$Date&PL=$PL';</script>";exit;		

    
          }
          
          
?>