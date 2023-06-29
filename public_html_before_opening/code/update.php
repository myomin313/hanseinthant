<?php
include_once('../config.php');
if($_SERVER["REQUEST_METHOD"] == "POST")
{

$id=$_POST['id']; 
$code=$_POST['code'];
$brandname=$_POST['brandname'];

$commodity=$_POST['commodity'];  

$obrandname = $_POST['obrandname'];

$ocommodity = $_POST['ocommodity'];
$LUser=$_POST['LUser']; 
$UpdateTime= date("Y-m-d H:i:s"); 
      
  if($brandname != $obrandname || $commodity != $ocommodity){
        $sqlp="UPDATE product SET BrandName='$brandname',Commodity='$commodity' WHERE BrandName='$obrandname' and Commodity='$ocommodity' and code='$id'";
        mysqli_query($con ,$sqlp);

        $sqlpo="UPDATE product_history SET BrandName='$brandname',Commodity='$commodity' WHERE BrandName='$obrandname' and Commodity='$ocommodity' and code='$id'";
        mysqli_query($con ,$sqlpo);

        $sqlph="UPDATE product_history SET OBrandName='$brandname',OCommodity='$commodity' WHERE OBrandName='$obrandname' and OCommodity='$ocommodity' and Ocode='$id'";
        mysqli_query($con ,$sqlph);

        $sqlt="UPDATE transfer SET BrandName='$brandname',Commodity='$commodity' WHERE BrandName='$obrandname' and Commodity='$ocommodity' and code='$id'";
        mysqli_query($con ,$sqlt);

        $sqlto="UPDATE transfer_history SET BrandName='$brandname',Commodity='$commodity' WHERE BrandName='$obrandname' and Commodity='$ocommodity' and code='$id'";
        mysqli_query($con ,$sqlto);

        $sqlth="UPDATE transfer_history SET OBrandName='$brandname',OCommodity='$commodity' WHERE OBrandName='$obrandname' and OCommodity='$ocommodity' and Ocode='$id'";
        mysqli_query($con ,$sqlth);

        $sqlj="UPDATE job SET BrandName='$brandname',Commodity='$commodity' WHERE BrandName='$obrandname' and Commodity='$ocommodity' and code='$id'";
        mysqli_query($con ,$sqlj);

        $sqljo="UPDATE job_history SET BrandName='$brandname',Commodity='$commodity' WHERE BrandName='$obrandname' and Commodity='$ocommodity' and code='$id'";
        mysqli_query($con ,$sqljo);

        $sqljh="UPDATE job_history SET OBrandName='$brandname',OCommodity='$commodity' WHERE OBrandName='$obrandname' and OCommodity='$ocommodity' and Ocode='$id'";
        mysqli_query($con ,$sqljh);        

        $sqld="UPDATE delivery SET BrandName='$brandname',Commodity='$commodity' WHERE BrandName='$obrandname' and Commodity='$ocommodity' and code='$id'";
        mysqli_query($con ,$sqld);

        $sqldo="UPDATE delivery_history SET BrandName='$brandname',Commodity='$commodity' WHERE BrandName='$obrandname' and Commodity='$ocommodity' and code='$id'";
        mysqli_query($con ,$sqldo);

        $sqldh="UPDATE delivery_history SET OBrandName='$brandname',OCommodity='$commodity' WHERE OBrandName='$obrandname' and OCommodity='$ocommodity' and Ocode='$id'";
        mysqli_query($con ,$sqldh);

        $sqlr="UPDATE returns SET BrandName='$brandname',Commodity='$commodity' WHERE BrandName='$obrandname' and Commodity='$ocommodity' and code='$id'";
        mysqli_query($con ,$sqlr);

        $sqlro="UPDATE customerreturn_history SET BrandName='$brandname',Commodity='$commodity' WHERE BrandName='$obrandname' and Commodity='$ocommodity' and code='$id'";
        mysqli_query($con ,$sqlro);

        $sqlrh="UPDATE customerreturn_history SET OBrandName='$brandname',OCommodity='$commodity' WHERE OBrandName='$obrandname' and OCommodity='$ocommodity' and Ocode='$id'";
        mysqli_query($con ,$sqlrh);

        $sqls="UPDATE supplier_return SET BrandName='$brandname',Commodity='$commodity' WHERE BrandName='$obrandname' and Commodity='$ocommodity' and code='$id'";
        mysqli_query($con ,$sqls);

        $sqlso="UPDATE supplierreturn_history SET BrandName='$brandname',Commodity='$commodity' WHERE BrandName='$obrandname' and Commodity='$ocommodity' and code='$id'";
        mysqli_query($con ,$sqlso);

        $sqlsh="UPDATE supplierreturn_history SET OBrandName='$brandname',OCommodity='$commodity' WHERE OBrandName='$obrandname' and OCommodity='$ocommodity' and Ocode='$id'";
        mysqli_query($con ,$sqlsh);
   }

  

       
        $sql="UPDATE code SET code='$code',brandname='$brandname',commodity='$commodity',updated_at='$UpdateTime',  updated_by='$LUser' WHERE id='$id'";
        mysqli_query($con ,$sql);

        
        echo"<script>alert('Successfully Updated');</script>";
        echo "<script type='text/javascript'>window.top.location='detail.php?id=$id';</script>";exit;
     


}
?>