<?php session_start();?>
<?php 
      if (($_SESSION['login_session']<> true)) {
        header("Location:../index.php");    
        exit();
      }     

?>
<?php 
      include_once('../config.php');
      include_once('../menu.php');
      include_once('../style.css');
      include_once('../header.php');
 
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

      	$myusername = $_SESSION['login_user'];

    ?>
    <?php
		$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	?>

	

	<head>
		<!-- Header Design CSS -->
		<style type="text/css">		
			.header_BrandName{
				border-top-style: solid;
				border-bottom-style: solid;
				border-width: 5px;	
				text-align: center;
				width: 15%;
				margin-left: 81%;
				margin-top: -30px;	
				font-size: 14px;
			}			
			* { margin:0; padding:0; }
			body { 
				background:#f2f2f2; 
				font-family:Arial, Helvetica, sans-serif;
				font-size:12px; line-height:20px; 
			}
			.invoice-wrap {
				width:700px; 
				margin:0 auto; 
				background:#FFF; 
				color:#000 ;
				margin-top: 2%;
			}		
		</style>

		<!-- Delivery order table CSS -->
		<style type="text/css">
			#delivery_table {
		        font-family: Arial, serif;
		        border-collapse: collapse;
		        width: 70%;
		        padding: 4px;
		        margin-top: 0%;
		        margin-bottom: 20px;
      		}
	      	#delivery_table td, #delivery_table th {
		        border: 1px solid black;
		        padding: 4px;
		        background-color: white;
	      	}
		    #delivery_table tr:nth-child(even){background-color: #48486a;}
			#delivery_table tr:hover {background-color: #ddd;}
		    #delivery_table th {
		        padding-top: 12px;
		        padding-bottom: 12px;
		        text-align: center;
		        background-color:#668aff ;
		        color: white;
		        padding: 5px;
      		} 
			@media print { 
		      	.invoice-wrap #delivery_table .Heading th{
		        	padding-top: 12px;
		        	padding-bottom: 12px;
		        	text-align: center;
		        	background-color:#668aff ;
		        	color: white;
		        	padding: 5px;
      			}
      			#printbtn{
		          display :  none;
		        }  
      		}
      		.footer1{
				margin-left: 2%;
				margin-top: 80px;
			}
			.footer2{
				margin-left: 2%;
			}
			.footer3{
				margin-left: 72%;
				margin-top: -115px;
			}
			.footer4{
				margin-left: 72%;
				margin-top: 0px;
			}		
		</style>

		<style media="print" type="text/css">
   	 		#delivery_table th {
				background-color:#668aff ! important;
				-webkit-print-color-adjust: exact ! important;
				color: #fff ! important;
			}
		</style>

		<!-- Print Page -->
		<script>
			function myFunction() {
		    	window.print();
			}
		</script>
	</head>

	<div class="invoice-wrap" id="content">
		<h1 style="font-family: Arial self;font-weight: bold;margin-left: 20%;font-size: 30px;padding-top: 3%;">HAN SEIN THANT CO.,LTD</h1>
		<h3 class="header_BrandName">Han Sein Thant</h3><br>		
	
		<h3 style="text-align: center;font-size: 18px;">Delivery Order</h3>	

		<!-- Header information -->
		<?php 
			$myid=$_GET['id']; 
      		$DO_No=$_GET['DO_No'];
			$customer_name='';
			$delivery_date='';
			$Do_no='';
			$Job_no='';
			$ph_no='';
				
	        $sql_header="SELECT d.DO_No as DO_No,d.DO_No as DO_No,d.JOB_No as JOB_No,cus.CustomerName as CustomerName,cus.Phone as Phone,cus.Userid as Useridbn ,d.Delivery_date as Delivery_date
	            FROM delivery d
	            INNER JOIN customer cus
	            ON (d.Customer = cus.Userid)
	            WHERE d.Customer =$myid AND d.DO_No='$DO_No'	            ";	       
	                  		// echo $sql_header;
	        $result_header=mysqli_query($con,$sql_header);  

	        $count_header=mysqli_num_rows($result_header);
	        if ($count_header > 0) {
	            while ($row_header = $result_header->fetch_assoc()) {
	              	$row_header['CustomerName'] = rtrim($row_header['CustomerName'],",");
	              	// $Commodity_Type = $row_header['Commodity_Type'];
	               	$customer_name = $row_header['CustomerName'];
	               	$delivery_date = $row_header['Delivery_date'];
	               	$Do_no = $row_header['DO_No'];
	               	$Job_no = $row_header['JOB_No'];
	               	$ph_no = $row_header['Phone'];
	            }                       	             
		        print'<span style="margin-left:2%;">To</sapn><br>'; 	
		        print'<span style="margin-left:5%;">Customer:' . $customer_name . '</span>'; 		

		        print'<span style="margin-left:60%;">Date :'.$delivery_date.'</span><br>'; 		
				print '<span style="margin-left:78%">Do.No :'.$Do_no.'</span><br>'; 
				print '<span style="margin-left:78%;">JOB.No : '.$Job_no.'</span>';	
        	}              
		?>		

		<!-- Table information from database -->
		<?php
				
		    $sql="SELECT *
            FROM delivery 

            WHERE Customer =$myid AND DO_No='$DO_No'";
            // echo $sql;
           	$i=0;
        	$results=mysqli_query($con,$sql); 

            $count=mysqli_num_rows($results);  
                             
            if ($count > 0){
				print  '<div class="row"><div class="col-sm-10  col-sm-offset-1">';
                print  '<table id="delivery_table" style="width:100%;margin-left:0%;">
			            <thead class="Heading">
			            <tr><th style="width:6%;">Sr</th>
			            <th>BrandName</th>
			            <th>Commodity</th>			            
			            <th style="width:10%;"> Qty</th>
			            <th style=" word-wrap: break-word;
					    word-break: break-all;
					    white-space: normal;width:35%;">Remark</th>
								            </thead><tbody>';

	            $sql_BrandName="SELECT DISTINCT(BrandName) AS BrandName FROM delivery WHERE Customer =$myid AND DO_No='$DO_No'";
	            $result_BrandName=mysqli_query($con,$sql_BrandName);  
	            $count_BrandName=mysqli_num_rows($result_BrandName);  

                if ($count_BrandName > 0){
                	while($row_BrandName = $result_BrandName->fetch_assoc()){ 
                		// print '<tr><td></><td >' . $row_BrandName['BrandName'] . '</td><td></td><td></td></tr>';
                    		
                  		while($row = $results->fetch_assoc()){ 
	                  		$i+=1;	                      		
		                   	print '<tr><td style="text-align:center;">' . $i . '</td>';
		                   	print '<td >' . $row['BrandName'] . '</td>';  
		                   	print '<td >' . $row['Commodity'] . '</td>';  
		                    print '<td >' . $row['Qty'] . '' . $row['Type'] . '</td>';  
		                    print '<td style=" word-wrap: break-word;
						    word-break: break-all;
						    white-space: normal;width:35%;">' . $row['Remark_item'] . '</td>';  
		                    print ' </tr> </tbody>';                      		
                       	}
                    }
                }
                print '</table>'; 
                print  '</div>';
                print  '</div>';
           	}        
		?>		

		<!-- Delivery order Footer -->
		<p class="footer1">
			Issued By<br>
			Signed	: ..............<br>
			Name    : ..............
		</p>
		<p class="footer2">
			Checked By<br>
			Signed	: ..............<br>
			Name    : ..............
		</p>
		<p class="footer3">
			Received By Behalf of Customer<br>
			Signed	: ...............<br>
			Name    : ...............<br>
			Car No  : ...............
		</p>

		<p class="footer4">
			Received By Customer<br>
			Signed	: ...............<br>
			Name    : ...............<br>
			Ph No  : ...............
		</p>
		<button onclick="myFunction()" id="printbtn">Print this page</button>
	</div>
