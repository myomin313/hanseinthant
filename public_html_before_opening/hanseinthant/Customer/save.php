	<?php 
		include_once('../config.php');

	      	if($_SERVER["REQUEST_METHOD"] == "POST"){

	        if(isset($_POST['Name']) && is_array($_POST['Name'])){ 
	          	$Address=$_POST['Address']; 
				$Phone=$_POST['Phone']; 
				$Emergency=$_POST['Emergency']; 
				$email=$_POST['email']; 
				$LUser=$_POST['LUser']; 
				$CreateTime= date("Y-m-d H:i:s");  
	          	$Name="";
	         
		        foreach($_POST["Name"] as $key => $text_field){
		           $Name .= $text_field .",";
		        }

		        $row_data[]=['$Name','$Phone','$Emergency','$Address','$email','$CreateTime','','$LUser',''];
		          
		        $DataArr[] = "('$Name','$Phone','$Emergency','$Address','$email','$CreateTime','','$LUser','')";
        	}


        $sql = "SELECT DISTINCT CustomerName FROM customer WHERE CustomerName ='$Name'";
        $result=mysqli_query($con ,$sql); 
        $row = $result->fetch_assoc();
        $count=mysqli_num_rows($result);
        if($count==1)
             {
              echo"<script>alert('Your Customer Name already exist.Please try again!');</script>"; 
             echo "<script type='text/javascript'>window.top.location='new.php';</script>";exit;
              }  
              
       else{       
	        $sql = "INSERT INTO customer (CustomerName,Phone,Emergency,Address, Email,CreateTime,UpdateTime,Creator,Updator) VALUES ";
	        $sql .= implode(',', $DataArr);
	        mysqli_query($con, $sql);
	        echo"<script>alert('Success');</script>";
        echo "<script type='text/javascript'>window.top.location='list.php';</script>";exit;	        
    	  } 
    	

	      	}

	?>