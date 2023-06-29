<?php 
    include_once('../config.php');
      $ids=$_GET['ids']; 
      // $ids = preg_replace('/\.$/', '', $ids); 
       $idarray = explode(',', $ids);
       foreach($idarray as $id) {
         $sql="SELECT * FROM product WHERE  id = '$id' ";
         $results=mysqli_query($con,$sql); 
         $row = $results->fetch_assoc();

           $OSupplierName = mysqli_real_escape_string($con,$row['SupplierName']);
           $OBrandName = mysqli_real_escape_string($con,$row['BrandName']);
           $OCommodity = mysqli_real_escape_string($con,$row['Commodity']);
           $Ocode = mysqli_real_escape_string($con,$row['code']);
           $ORemarks_Item = mysqli_real_escape_string($con,$row['Remarks_Item']);
           

            $OPacking_date= $row['Packing_date'];
            $OPurchase_order_No= $row['Purchase_order_No'];
            $OPO_NO= $row['PO_NO'];
            $OPL_NO= $row['Purchase_order_No'];
            $OQty= $row['Qty'];
            $OtotalRate= $row['totalRate'];
            $ORate_Name= $row['Rate_Name'];
            $OType= $row['Type'];
            $Orate= $row['rate']; 
            $OBranch= $row['Branch'];
            $Recorder =$_GET['LUser'];
            $RecordTime =date("Y-m-d H:i:s");
            $status ="Delete";

            $sqlA = "SELECT DISTINCT BrandName,Commodity,PL FROM job WHERE BrandName ='$OBrandName' and Commodity= '$OCommodity' and code='$Ocode' and PL = '$OPL_NO'  and Location = '$OBranch'";
        $resultA=mysqli_query($con ,$sqlA); 
        $row = $resultA->fetch_assoc();
        $count=mysqli_num_rows($resultA);
        
       $sqls = "SELECT DISTINCT BrandName,Commodity,PL FROM delivery WHERE BrandName ='$OBrandName' and Commodity= '$OCommodity' and code='$Ocode' and PL = '$OPL_NO'";
        $results=mysqli_query($con ,$sqls); 
        $rows = $results->fetch_assoc();
        $counts=mysqli_num_rows($results); 

              if($count==1){
                   echo"<script>alert('Your PL NO. is connected to WIP .Please remove WIP. first!');</script>"; 
         echo "<script type='text/javascript'>window.top.location='detail.php?SupplierID=$SupplierID&Date=$Date&PL=$PL';</script>";exit;  
              }elseif($counts==1)
                  {
                   echo"<script>alert('Your PL NO. is connected to Delivery .Please remove Delivery. first!');</script>";      
                  echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit;
                  }else{  
                      
                     $sql="INSERT INTO product_history(input_ID,SupplierName,OSupplierName,OBrandName,OCommodity,Ocode,Branch,OBranch,Remarks_Item,ORemarks_Item,Packing_date,OPacking_date,Purchase_order_No,OPurchase_order_No,PO_NO,OPO_NO,Qty,OQty,totalRate,OtotalRate,Rate_Name,ORate_Name,rate,Orate,Type,OType,RecordTime,Recorder,status) 
                  VALUES ('$id','','$OSupplierName','$OBrandName','$OCommodity','$Ocode','','$OBranch','','$ORemarks_Item','','$OPacking_date','','$OPurchase_order_No','','$OPO_NO','','$OQty','','$OtotalRate','','$ORate_Name','','$Orate','','$OType','$RecordTime','$Recorder','$status')"; 
                 
                  mysqli_query($con ,$sql);

            $sql="DELETE FROM product WHERE id='$id'";
           mysqli_query($con,$sql);
                  }
             echo"<script>alert('Successfully Deleted');</script>"; 
             echo "<script type='text/javascript'>window.top.location='detail.php?SupplierID=$SupplierID&Branch=$Branch&Packing_date=$OPacking_date&PL=$OPL_NO';</script>";  

       }             
          
?>