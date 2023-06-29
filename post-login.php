<?php session_start();?>
<?php 

if($_SERVER["REQUEST_METHOD"] == "POST")
{

		$myusername=addslashes($_POST['username']); 
		$mypassword=addslashes($_POST['password']); 

        //email and password are blank
	    $input='';

	    if($_POST['username'] == '' ||  $_POST['password'] == ''){

			$input = 'Please fill all field';

		}

	    if ($input!='') {

	    	header("Location:home.php?input=$input&invalid=$invalid");
	    	
	    }else{
		
		    $sql="SELECT UserID,Authority,Export,Permission,Branch FROM users WHERE UserName='$myusername' and Password='$mypassword'";

			   $con = mysqli_connect("localhost","root","","hanseint_db_new");

			  if (mysqli_connect_errno()){
			  
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();

			  }else{

			  //check connection close
			  }

		    $result = $con->query($sql);
	        $row = $result->fetch_assoc();

			$count=mysqli_num_rows($result);

			if($count==1)
			{
			$_SESSION['login_session']=true;
			$_SESSION['login_user']=$myusername;
			$_SESSION['login_userID']=$row['UserID'];
			$_SESSION['authority']=$row['Authority'];
			$_SESSION['permission']=$row['Permission'];
			$_SESSION['Branch']=$row['Branch'];
			$_SESSION['Export']=$row['Export'];
		//	echo $_SESSION['login_user'];

		header("location: Product/list.php?namelist=&year=&month=&day=");
			}


	        else{
	             
	           header("Location:index.php?error=Username and Password doesn't match");

	       }

	    }

	}//isset close

?>