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

        //	$brandname =$_POST['brandname'];
        	$code = mysqli_real_escape_string($con,$_POST['code']);
        	$commodity=$_POST['commodity'];
            $brandname=$_POST['brandname']; 
            $LUser=$_POST['LUser']; 

        $sql = "SELECT Distinct code FROM code WHERE commodity='$commodity' and brandname='$brandname'";
		
        // echo $sql;
        $result=mysqli_query($con ,$sql); 
        $row = $result->fetch_assoc();
       $count=mysqli_num_rows($result);
       

      if($count==1)
                  {
                   echo"<script>alert('BrandName and Commodity already exist.Please try again!');</script>";  
                   echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit;
       
                  }  
             
      else{
	        $sql = "INSERT INTO code (code,updated_by,brandname,commodity) VALUES ('$code','$LUser',$brandname,$commodity)";
	        mysqli_query($con, $sql);
	        echo"<script>alert('Success');</script>";
            echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit;
    	}    
      	}
	   
	?>