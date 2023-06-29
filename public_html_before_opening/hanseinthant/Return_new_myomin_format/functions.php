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
 
	        $sql = "INSERT into returns (id,Return_date,Return_no,department,Customer,DO_No,BrandName,Commodity,Qty,Type,Remarks_item,Creator,CreateTime ) 
                   values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."','".$getData[8]."','".$getData[9]."','".$getData[10]."','".$getData[11]."','".$getData[11]."')";
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
 
 //  if(isset($_POST["Export"])){
		 
 //      header('Content-Type: text/csv; charset=utf-8');  
 //      $filename = "Customer Return list/" . date('Y-m-d') . ".csv";
 //      header('Content-Disposition: attachment; filename="' . $filename . '";');
 //      // header('Content-Disposition: attachment; filename=order list.csv');  
 //      $output = fopen("php://output", "w");
 //      fputcsv($output, array('id','Return date','Return no','To','Customer','DO No','BrandName','Commodity','Qty','Type','Remark_item','Creator','CreateTime'));  
 //      $query = "SELECT id,Return_date,Return_no,department,Customer,DO_No,BrandName,Commodity,Qty,Type,Remarks_item,Creator,CreateTime from returns ";  

 //      $result = mysqli_query($con, $query);  
 //      while($row = mysqli_fetch_assoc($result))  
 //      {  
 //           fputcsv($output, $row);  
 //      }  
 //      fclose($output);  
 // }
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
 $filename = "Customer Return list/" . date('Y-m-d') . ".csv";
 header('Content-Disposition: attachment; filename="' . $filename . '";');
 header('Content-Transfer-Encoding: binary');
 header('Expires: 0');
 header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
 header('Pragma: public');
 $output = fopen('php://output', 'w');
 fputs( $output, "\xEF\xBB\xBF" );
 fputcsv($output,  array('id','Return date','Return no','To','Customer','DO No','BrandName','Commodity','Qty','Type','Remark_item','Creator','CreateTime'));  
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
$sWhere = "";
$sqls=" SELECT returns.id,returns.Return_date,returns.Return_no,returns.department,customer.CustomerName,returns.Do_No,brandname.brandname as BrandName,commodity.commodity as Commodity,returns.Qty,returns.Type,returns.Remarks_item,returns.Creator,returns.CreateTime FROM returns 
                  LEFT JOIN customer
                  ON returns.Customer= customer.UserId
                  JOIN brandname ON returns.BrandName= brandname.id 
                  JOIN commodity ON returns.Commodity= commodity.id
                  WHERE 1=1 ";
                
                  if(!empty($_POST['fromDate']) && !empty($_POST['toDate'])){
                $fromDate = date("Y-m-d",strtotime($_POST['fromDate']));
                $toDate = date("Y-m-d", strtotime($_POST['toDate']));
                $sWhere = $sWhere . " AND returns.Return_date BETWEEN '".$fromDate."'  AND '".$toDate."'";
                }
                  if(!empty($_POST['keyword'])){
                   $keyword = $_POST['keyword'];
                $sWhere =$sWhere . " AND (brandname.brandname= '".$keyword."'OR customer.CustomerName= '".$keyword."'OR commodity.commodity= '".$keyword."'OR returns.DO_No= '".$keyword."'OR returns.Return_no= '".$keyword."'OR returns.department= '".$keyword."')";
                }
                //  if(!empty($_POST['keyword'])){
                //    $keyword = $_POST['keyword'];
                // $sWhere =$sWhere . " AND (customer.CustomerName= '".$keyword."'OR brandname.brandname= '".$keyword."'OR returns.department= '".$keyword."'OR returns.DO_No= '".$keyword."'OR commodity.commodity= '".$keyword."')";
                // }

$sqls = $sqls . " AND 1= 1 " .$sWhere;            
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
 ?>