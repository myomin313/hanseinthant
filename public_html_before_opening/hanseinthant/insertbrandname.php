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
	        $sql = "INSERT into brandname (id,brandname) 
                   values ('".$getData[0]."')";
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
 
  
 ?>