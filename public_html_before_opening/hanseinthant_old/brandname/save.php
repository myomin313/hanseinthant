	<?php 
		include_once('../config.php');

      	if($_SERVER["REQUEST_METHOD"] == "POST"){

	   //      if(isset($_POST['brandname']) && is_array($_POST['brandname'])){ 
	   //        	$Address=$_POST['Address']; 
				// $Phone=$_POST['Phone']; 
				// $Emergency=$_POST['Emergency']; 
				// $email=$_POST['email']; 
				// $LUser=$_POST['LUser']; 
				// $CreateTime= date("Y-m-d H:i:s");  
	   //        	$Name="";
	         
		  //       foreach($_POST["Name"] as $key => $text_field){
		  //          $Name .= $text_field .",";
		  //       }

		  //       $row_data[]=['$Name','$Phone','$Emergency','$Address','$email','$CreateTime','','$LUser',''];
		          
		  //       $DataArr[] = "('$Name','$Phone','$Emergency','$Address','$email','$CreateTime','','$LUser','')";
    //     	}

        	$brandname =$_POST['brandname'];
        	$LUser=$_POST['LUser']; 

        $sql = "SELECT Distinct brandname FROM brandname  WHERE brandname='$brandname'";
        // echo $sql;
        $result=mysqli_query($con ,$sql); 
        $row = $result->fetch_assoc();
       $count=mysqli_num_rows($result);
       

      if($count==1)
                  {
                   echo"<script>alert('brandname already exist.Please try again!');</script>";  
                   echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit;
       
                  }  
             
      else{
	        $sql = "INSERT INTO brandname (brandname,updated_by) VALUES ('$brandname','$LUser')";
	        mysqli_query($con, $sql);
	        echo"<script>alert('Success');</script>";
            echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit;
    	}    
      	}
	   
	?>