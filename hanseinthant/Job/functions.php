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
	        $sql = "INSERT into job (id,Job_No,Job_date,Location,Customer,BrandName,Commodity,WIP,Type,Remarks_Item,Project,Creator,CreateTime ) 
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
$filename = "Job Order list/" . date('Y-m-d') . ".csv";
header('Content-Disposition: attachment; filename="' . $filename . '";');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
// output headers so that the file is downloaded rather than displayed
// create a file pointer conected to the output stream
$output = fopen('php://output', 'w');
fputs( $output, "\xEF\xBB\xBF" );
// output the column headings
fputcsv($output,  array('id','JOB No','Job_date','Location','Customer','BrandName','Commodity','WIP','Type','Remarks_Item','Project','Creator','CreateTime'));  
// fetch the data
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
// $sql = "SELECT id,Job_No,Job_date,Location,Customer,BrandName,Commodity,WIP,Type,Remarks_Item,Project,Creator,CreateTime from job ";
$sWhere = "";
$sql = "SELECT job.id,job.Job_No,job.Job_date,job.Location,customer.CustomerName,job.BrandName,job.Commodity,job.WIP,job.Type,job.Remarks_Item,job.Project,job.Creator,job.CreateTime
                  FROM job 
                  LEFT JOIN customer
                  ON job.Customer= customer.UserId";

                  if(!empty($_POST['fromDate']) && !empty($_POST['toDate'])){                    
                $fromDate = date("Y-m-d",strtotime($_POST['fromDate']));
                $toDate = date("Y-m-d", strtotime($_POST['toDate']));
                $sWhere = $sWhere . " AND job.Job_date BETWEEN '".$fromDate."'  AND '".$toDate."'";                    
                  }
                  if (!empty($_POST['keyword'])) {
                      $keyword = $_POST['keyword'];
                $sWhere =$sWhere . " AND (customer.CustomerName= '".$keyword."'OR job.BrandName= '".$keyword."'OR job.Location= '".$keyword."'OR job.Job_No= '".$keyword."'OR job.Commodity= '".$keyword."')";
                  } 
$sql = $sql. " WHERE 1=1 " .$sWhere;
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