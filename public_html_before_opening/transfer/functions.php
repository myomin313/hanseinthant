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
	        $sql = "INSERT into delivery (id,Delivery_date,DO_No,Location,Customer,BrandName,Commodity,Qty,Type,Remark_item,PL,Creator,CreateTime ) 
                   values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."','".$getData[8]."','".$getData[9]."','".$getData[10]."','".$getData[11]."','".$getData[12]."')";
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

      // fclose($output);  
  	  function cleanData(&$str)
  {
    if($str == 't') $str = 'TRUE';
    if($str == 'f') $str = 'FALSE';
    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
      $str = "'$str";
    }
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';

    $str = mb_convert_encoding($str, 'UTF-32', 'UTF-8');

  }

 header('Content-Description: File Transfer');
 header('Content-Type: text/csv; charset=UTF-16LE');
 $filename = "Transfer list/" . date('Y-m-d') . ".csv";
 header('Content-Disposition: attachment; filename="' . $filename . '";');
 header('Content-Transfer-Encoding: binary');
 header('Expires: 0');
 header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
 header('Pragma: public');
// output headers so that the file is downloaded rather than displayed
 //create a file pointer conected to the output stream
 $output = fopen('php://output', 'w');
 fputs( $output, "\xEF\xBB\xBF" );
 fputcsv($output,  array('id','Transfer No','Transfer Date','Transfer From','Transfer To','Code','BrandName','Commodity','Qty','Type','Remark_item','Transfer USD','PL','Old Transfer No','Creator','CreateTime'));
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
// $sql = "SELECT id,Delivery_date,DO_No,Location,Customer,BrandName,Commodity,Qty,Type,Remark_item,PL,Creator,CreateTime from delivery ";
   $sWhere = "";
//    $sql=" SELECT delivery.id,delivery.Delivery_date,delivery.DO_No,delivery.Location,customer.customerName,code.code,brandname.brandname as BrandName,commodity.commodity as Commodity,delivery.Qty,delivery.deliveryUSD,delivery.returnQty,delivery.Type,delivery.Remark_item,delivery.PL,delivery.Creator,delivery.CreateTime 
//           FROM delivery 
//           LEFT JOIN customer ON customer.UserId= delivery.Customer
//           LEFT JOIN code ON code.id= delivery.code
//           JOIN brandname ON delivery.BrandName= brandname.id 
//           JOIN commodity ON delivery.Commodity= commodity.id"; 

   $sql="SELECT t.id as tid,t.transfer_no,t.transfer_date,bf.branch as branch_from,bt.branch as branch_to,co.code as code_no,brandname.brandname as BrandName,commodity.commodity as Commodity,t.Qty as Qty,t.Type as Type,t.Remark_item as remark,t.transferUSD as transferUSD,t.PL as PL,t.ptransfer_no as ptransfer_no,Creator,CreateTime FROM transfer t
     JOIN brandname ON t.BrandName= brandname.id
     JOIN commodity ON t.Commodity= commodity.id
     JOIN branch bf ON t.transfer_from= bf.id
     JOIN branch bt ON t.transfer_to= bt.id
     LEFT JOIN code co ON co.id= t.code";  

            //  if(!empty($_POST['keyword'])){
            //        $keyword = $_POST['keyword'];
            //     $sWhere =$sWhere . " AND (customer.CustomerName= '".$keyword."'OR brandname.brandname= '".$keyword."'OR delivery.Location= '".$keyword."'OR delivery.DO_No= '".$keyword."'OR delivery.JOB_No= '".$keyword."'OR commodity.commodity= '".$keyword."')";
            //     }
                if(isset ($_POST['fromDate']) && ($_POST['toDate'])){
                  $fromDate = date("Y-m-d", strtotime($_POST['fromDate']));
                   $toDate = date("Y-m-d", strtotime($_POST['toDate']));
                   $sWhere = $sWhere ." AND t.transfer_date BETWEEN '$fromDate'  AND '$toDate'";
                }
                if(isset($_POST['transfer_no']) && $_POST['transfer_no'] != ''){
                  $transfer_no=$_POST['transfer_no'];
                 $sWhere =$sWhere." AND t.transfer_no='$transfer_no'";
               }
               if(isset($_POST['transfer_from'])  && $_POST['transfer_from'] != ''){
                 $transfer_from=$_POST['transfer_from'];
                 $sWhere =$sWhere." AND t.transfer_from='$transfer_from'";
               }
               if(isset($_POST['transfer_to'])  && $_POST['transfer_to'] != ''){
                 $transfer_to=$_POST['transfer_to'];
                 $sWhere =$sWhere." AND t.transfer_to='$transfer_to'";
               }
               if(isset($_POST['BrandName']) && $_POST['BrandName'] != ''){
                $BrandName=$_POST['BrandName'];
                $sWhere =$sWhere." AND t.BrandName='$BrandName'";
              }
              if(isset($_POST['Commodity']) && $_POST['Commodity'] != ''){
                $Commodity=$_POST['Commodity'];
                $sWhere =$sWhere." AND t.Commodity='$Commodity'";
              }
              if(isset($_POST['code'])  && $_POST['code'] != ''){
                $code=$_POST['code'];
                $sWhere =$sWhere." AND t.code='$code'";
              }
              if(isset($_POST['PL']) && $_POST['PL'] != ''){
                $PL=$_POST['PL'];
                $sWhere =$sWhere." AND t.PL='$PL'";
              }
              
$sql = $sql . " WHERE 1= 1 " .$sWhere; 
 $rows = $con->query($sql);
 $arr1= array();
 if ($rows->num_rows > 0) {
 while($row = $rows->fetch_assoc()) {
 fputcsv($output, $row); 
 }
 } else {
      echo "0 results";
 }

 }     
 ?>