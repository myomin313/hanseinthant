<?php
	   $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	      	?>

<div class="topnav">
       <?php 
       $Authority = $_SESSION['authority'];
      $Export = $_SESSION['Export'];
      if ($Authority == 'Accountant') {
     print '<a href="../Rate/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Rate/list.php?namelist=&year=&month=&day="? "  background-color: white;color:black; height:35px;":'').'">Rate</a>';
       
       }?>
       
      <?php  print '<a href="../Product/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Product/list.php?namelist=&year=&month=&day="? "  background-color: white;color:black; height:35px;":'').'">Input</a>';?>
      
      <?php  print '<a href="../Job/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Job/list.php?namelist=&year=&month=&day="? "  background-color: white;color:black; height:35px;":'').'">WIP</a>';?>
      
      <?php  print '<a href="../Delivery/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Delivery/list.php?namelist=&year=&month=&day="? "  background-color: white;color:black; height:35px;":'').'">Delivery</a>';?>
      <?php  print '<a href="../Return/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Return/list.php?namelist=&year=&month=&day="? "  background-color: white;color:black; height:35px;":'').'">Customer Return</a>';?>
      
      <?php  print '<a href="../SupplierReturn/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/SupplierReturn/list.php?namelist=&year=&month=&day="? "  background-color: white;color:black; height:35px;":'').'">Supplier Return</a>';?>
      
      <?php  print '<a href="../Instock/list.php?namelist=&year=&month=&day=&Commodities="  style="'.($actual_link == "https://hanseinthant.com/Instock/list.php?namelist=&year=&month=&day=&Commodities="? "  background-color: white;color:black; height:35px;":'').'">Instock</a>';?>
      
      <?php  print '<a href="../Customer/list.php?"  style="'.($actual_link == "https://hanseinthant.com/Customer/list.php?namelist=&year=&month=&day=="? "  background-color: white;color:black; height:35px;":'').'">Customer</a>';?>

      <?php  print '<a href="../Supplier/list.php?"  style="'.($actual_link == "https://hanseinthant.com/Supplier/list.php?"? "  background-color: white;color:black; height:35px;":'').'">Supplier</a>';?>

      <?php 
      $Permission = $_SESSION['permission'];
      if ($Permission == 'Permit') {
              
     print '<a href="../User/list.php?"  style="'.($actual_link == "https://hanseinthant.com/User/list.php?"? "  background-color: white;color:black; height:35px;":'').'">User</a>';
     
     }?>
     <a><?php 
        $Export = $_SESSION['Export'];

          if ($Export == 'Export') {
            print' 
            <form class="form-horizontal" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data" >
                  <button type="submit" id="Export" name="Export"  class="export" ><img src = "../image/Excel-icon.png" width="11px";  > Export</button>    
     
          </form> ';  }
         
      ?>       
      </a>
      <a style="margin-left:10%;">
          <?php 
      $Authority = $_SESSION['authority'];
      if ($Authority == 'Accountant') {
       print'<input type="submit" name="history" id="history" class="history" onClick="setHistoryAction();" value="History" >';}?> 
     <!--<button id="printbtn" onclick="javascript:window.print();" class="print">Print</button>-->
      <a href="../logout.php?"  style="margin-left:13%;"><img src = "../image/log.png" width="26px"; height="25px;" ></a></a>
  
    

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
  padding: 8px 15px;
  text-decoration: none;
  font-size: 13px;
}

.topnav a:hover {
  background-color: white;
  color: black;
  height:35px;
}

.topnav a.active {
  background-color: white;
  color: white;
   height:35px;
  
}
</style>
        <style>
      html {
        font-family: Tahoma, Geneva, sans-serif;
        /*padding: 20px;*/
        background-color: #fff;
      }
      table {
        border-collapse: collapse;
        width: 500px;
      }
      td, th {
        padding: 2px;
      }
/*      th {
        background-color: #54585d;
        color: #ffffff;
        font-weight: bold;
        font-size: 13px;
        border: 1px solid #54585d;
      }*/
      td {
        color:#262626;
        border: 1px solid #dddfe1;
      }
      tr {
        background-color: #f9fafb;
      }
      tr:nth-child(odd) {
        background-color: #ffffff;
      }
      .pagination {
        list-style-type: none;
        padding: 10px 0;
        display: inline-flex;
        justify-content: space-between;
        box-sizing: border-box;
      }
      .pagination li {
        box-sizing: border-box;
        padding-right: 10px;
      }
      .pagination li a {
        box-sizing: border-box;
        background-color: #e2e6e6;
        padding: 8px;
        text-decoration: none;
        font-size: 12px;
        font-weight: bold;
        color: #616872;
        border-radius: 4px;
      }
      .pagination li a:hover {
        background-color: #d4dada;
      }
      .pagination .next a, .pagination .prev a {
        text-transform: uppercase;
        font-size: 12px;
      }
      .pagination .currentpage a {
        background-color: #518acb;
        color: #fff;
      }
      .pagination .currentpage a:hover {
        background-color: #518acb;
      }
      </style>
<!--<div id="footer_fixed"> -->
<!--   <div class="footer_content" > </div>-->
<!--</div>-->
