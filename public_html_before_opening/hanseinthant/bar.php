<?php
	    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	      	?>
<style>
   .active{
    /*position: relative;*/
  background-color: red;
  color: white;

    }
</style>
<div class="topnav" id="test">
       <?php 
       $Authority = $_SESSION['authority'];
      $Export = $_SESSION['Export'];
      if ($Authority == 'Accountant') {
     print '<a href="../Rate/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Rate/new.php"? "  background-color: white;color:black; height:35px;":'').'">Rate</a>';
       
       }?>
       
      <?php  print '<a href="../Product/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Product/new.php"? "  background-color: white;color:black; height:35px;":'').'">Input</a>';?>
      
      <?php  print '<a href="../Job/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Job/new.php"? "  background-color: white;color:black; height:35px;":'').'">WIP</a>';?>
      
      <?php  print '<a href="../Delivery/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Delivery/new.php"? "  background-color: white;color:black; height:35px;":'').'">Delivery</a>';?>
      <?php  print '<a href="../Return/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Return/new.php"? "  background-color: white;color:black; height:35px;":'').'">Customer Return</a>';?>
      
      <?php  print '<a href="../SupplierReturn/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/SupplierReturn/new.php"? "  background-color: white;color:black; height:35px;":'').'">Supplier Return</a>';?>
      
      <?php  print '<a href="../Instock/list.php?namelist=&year=&month=&day=&Commodities="  style="'.($actual_link == "https://hanseinthant.com/Instock/list.php?namelist=&year=&month=&day=&Commodities="? "  background-color: white;color:black; height:35px;":'').'">Instock</a>';?>
      
      <?php  print '<a href="../Customer/list.php?"  style="'.($actual_link == "https://hanseinthant.com/Customer/new.php"? "  background-color: white;color:black; height:35px;":'').'">Customer</a>';?>

      <?php  print '<a href="../Supplier/list.php?"  style="'.($actual_link == "https://hanseinthant.com/Supplier/new.php"? "  background-color: white;color:black; height:35px;":'').'">Supplier</a>';?>

      <?php  print '<a href="../brandname/list.php?"  style="'.($actual_link == "https://hanseinthant.com/brandname/new.php"? "  background-color: white;color:black; height:35px;":'').'">BrandName</a>';?>

      <?php  print '<a href="../commodity/list.php?"  style="'.($actual_link == "https://hanseinthant.com/commodity/new.php"? "  background-color: white;color:black; height:35px;":'').'">Commodity</a>';?>

      <?php 
      $Permission = $_SESSION['permission'];
      if ($Permission == 'Permit') {
        print '<a href="../User/list.php?"  style="'.($actual_link == "https://hanseinthant.com/User/new.php"? "  background-color: white;color:black; height:35px;":'').'">User</a>';

     
     }?>

      <a href="../logout.php?"  style="margin-left:10%;" ><img src = "../image/log.png" width="26px"; height="25px;" ></a>
  
    

</div>
<style>

.topnav {
  overflow: hidden;
  background-color: #4d4d4d;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 8px 16px;
  text-decoration: none;
  font-size: 13px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
  height:35px;
}

.topnav a.active {
  background-color: #4CAF50;
  color: white;
   height:35px;
  
}
</style>
<div id="footer_fixed"> 
   <div class="footer_content" > </div>
</div>
<style>
    #footer_fixed {
    	position: fixed;
    	bottom: 0;
    	display: block;
    	padding: 0;
    	margin: 0;
    	width: 100%;
    	height: 50px;
    	background-color: #4d4d4d;
    	border-top: 1px solid #dcdcdc;
    	z-index: 10000;		
    }
    .footer_content {
    	color: #898989;
    	font-size: 16px;
    	text-align: center;
    	margin: 0 auto;
    	padding-top: 14px;
    	width: auto;
    }	
    </style>
    
<style type="text/css">
  #outer-container {
    position: relative;
}

#scrollable {
    height:630px;
    overflow-y: auto;
}


</style>