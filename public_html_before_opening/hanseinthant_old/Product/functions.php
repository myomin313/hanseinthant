<?php
include_once('../config.php');
 if(isset($_POST["Import"])){
    
    $filename=$_FILES["file"]["tmp_name"];    
 
 
     if($_FILES["file"]["size"] > 1)
     {
        $file = fopen($filename, "r");
        $i = 0;
          while (($getData = fgetcsv($file, 0, ",")) !== FALSE)
           {
            if($i==0) { $i++; continue; }  // to exclude first line in the csv file.
            $getData=str_replace("'","\'",$getData);
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
           $sql = "INSERT into product (SupplierName,BrandName,Commodity,Branch,Remarks_Item,Packing_date,Purchase_order_No,PO_NO,Qty,Rate_Name,rate,totalRate,USD,totalUSD,Type,balanceQty,currentQty,balanceWIP,balanceDelivery,balanceUSD,balanceReturn,CreateTime,Creator) 
                    values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."','".$getData[8]."','".$getData[9]."','".$getData[10]."','".$getData[11]."','".$getData[12]."','".$getData[13]."','".$getData[14]."','".$getData[15]."','".$getData[16]."','".$getData[17]."','".$getData[18]."','".$getData[19]."','".$getData[20]."','".$getData[21]."','".$getData[22]."')";

                   //  $sql = "INSERT into product (id,SupplierName,BrandName,Commodity,Branch,Remarks_Item,Packing_date,Purchase_order_No,PO_NO,Qty,Type,Rate_Name,rate,totalRate,USD,totalUSD,Creator,CreateTime,balanceQty,currentQty,balanceWIP,balanceDelivery,balanceUSD,balanceReturn) 
                   // values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."','".$getData[8]."','".$getData[9]."','".$getData[10]."','".$getData[11]."','".$getData[12]."','".$getData[13]."','".$getData[14]."','".$getData[15]."','".$getData[16]."','".$getData[17]."','".$getData[18]."','".$getData[19]."','".$getData[20]."','".$getData[21]."','".$getData[22]."','".$getData[23]."')";
                    // echo  $sql;
                  $result = mysqli_query($con, $sql);
        if(!isset($result))
        {
          echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"list.php?selected=&month=&day=&namelist=\"
              </script>";   
        }
        else {
            echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"list.php?selected=&month=&day=&namelist=\"
          </script>";
        }
           }
      
           fclose($file); 
     }
  }  
 
  if(isset($_POST["Export"])){
 
  function cleanData(&$str)
  {
    if($str == 't') $str = 'TRUE';
    if($str == 'f') $str = 'FALSE';
    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
      $str = "'$str";
    }
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  header('Content-Description: File Transfer');
  header('Content-Type: text/csv; charset=UTF-16LE');
  $filename = "supplier list/" . date('Y-m-d') . ".csv";
  header('Content-Disposition: attachment; filename="' . $filename . '";');
  header('Content-Transfer-Encoding: binary');
  header('Expires: 0');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Pragma: public');
  $output = fopen('php://output', 'w');
  fputs( $output, "\xEF\xBB\xBF" );
  fputcsv($output,  array('id','SupplierName'));  
  // $setutf8 = "SET NAMES utf8";
  // $q = $con->query($setutf8);
  // $setutf8c = "SET character_set_results = 'utf8', character_set_client =
  // 'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
  // character_set_server = 'utf8'";
  // $qc = $con->query($setutf8c);
  // $setutf9 = "SET CHARACTER SET utf8";
  // $q1 = $con->query($setutf9);
  // $setutf7 = "SET COLLATION_CONNECTION = 'utf8_unicode_ci'";
  // $q2 = $con->query($setutf7);
 // $sql = "SELECT id,SupplierName,Branch,BrandName,Commodity,Remarks_Item,Packing_date,Purchase_order_No,PO_NO,Qty,bala,Type,Rate_Name,rate,totalRate,USD,totalUSD,DeliveryCreator,CreateTime from product";
// 12.12.2019 myo min start
              // $sWhere = "";
                $sqls = " SELECT UserId,SupplierName FROM supplier";
                // echo $sqls;exit();
 
              // if(!empty($_POST['searchkeyword'])){
              //      $keyword = $_POST['searchkeyword'];
              //   $sWhere =$sWhere . " AND (supplier.SupplierName= '".$keyword."'OR brandname.brandname= '".$keyword."'OR product.branch= '".$keyword."'OR product.Purchase_order_No= '".$keyword."'OR product.PO_NO= '".$keyword."'OR commodity.commodity= '".$keyword."')";
              //   }
              // if(!empty($_POST['searchfromDate']) && !empty($_POST['searchtoDate'])){
              //   $fromDate = date("Y-m-d",strtotime($_POST['searchfromDate']));
              //   $toDate = date("Y-m-d", strtotime($_POST['searchtoDate']));
              //   $sWhere = $sWhere . " AND product.Packing_date BETWEEN '".$fromDate."'  AND '".$toDate."'";
              //   }
                
            
// 12.12.2019 myo min end
  // $sqls = $sqls . " AND 1= 1 " .$sWhere; 
 $rows = $con->query($sqls);
  $arr1= array();
  if ($rows->num_rows > 0) {
 while($row = $rows->fetch_assoc()) {
 fputcsv($output, $row);   
  }
 } else {
   echo "0 results";
  }

 }  

// if(isset($_POST["Export"])){ 
//   function cleanData(&$str)
//   {
//     if($str == 't') $str = 'TRUE';
//     if($str == 'f') $str = 'FALSE';
//     if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
//       $str = "'$str";
//     }
//     if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';

//     if(!mb_check_encoding($str, 'UTF-8') 
//         OR !($str === mb_convert_encoding(mb_convert_encoding($str, 'UTF-32', 'UTF-8' ), 'UTF-8', 'UTF-32'))) {

//         $str = mb_convert_encoding($str, 'UTF-8'); 

//         if (mb_check_encoding($str, 'UTF-8')) { 
//             log('Converted to UTF-8'); 
//         } else { 
//             log('Could not converted to UTF-8'); 
//         } 
//     } 
//     return $str; 

//     // $str = mb_convert_encoding($str, 'UTF-8');

//   }

//   // filename for download
//   $filename = "input" . date('Ymd') . ".csv";

//   header("Content-Disposition: attachment; filename=\"$filename\"");
//   header("Content-Type: text/csv; charset=UTF-16LE");

//   $out = fopen("php://output", 'w');

//   $flag = false;
//   // $result = mysqli_query("SELECT id,SupplierName,Branch,BrandName,Commodity,Remarks_Item,Packing_date,Purchase_order_No,PO_NO,Qty,Type,Rate_Name,rate,totalRate,USD,totalUSD,Creator,CreateTime FROM product") or die('Query failed!');
// $sql = "SELECT id,SupplierName,Branch,BrandName,Commodity,Remarks_Item,Packing_date,Purchase_order_No,PO_NO,Qty,Type,Rate_Name,rate,totalRate,USD,totalUSD,Creator,CreateTime from product ";
// // echo $sql;
//  $result=mysqli_query($con ,$sql); 
// // $row = $con->query($sql);
//   // while(false !== ($row = $result->fetch_assoc())) {
// while($row = $result->fetch_assoc()){  
//     if(!$flag) {
//       // display field/column names as first row
//       fputcsv($out, array_keys($row), ',', '"');
//       $flag = true;
//     }
//     array_walk($row, __NAMESPACE__ . '\cleanData');
//     fputcsv($out, array_values($row), ',', '"');
//   }

//   fclose($out);
//   exit;
// }
 ?>