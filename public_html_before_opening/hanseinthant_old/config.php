<?php
// $con = mysqli_connect("localhost","root","","hst_db");
$con = mysqli_connect("localhost:3308","root","","hanseint_db");



// Check connection
if (mysqli_connect_errno()){
  
echo "Failed to connect to MySQL: " . mysqli_connect_error();

}else{

  //header("Location:welcome.php");
	
}

?>