<?php session_start();?>
<html>
<head>

<style type="text/css">
  .export {
  -moz-box-shadow:inset 0px 39px 0px -24px #2E8B57;
  -webkit-box-shadow:inset 0px 39px 0px -24px #2E8B57;
  box-shadow:inset 0px 39px 0px -24px #2E8B57;
  background-color: #2E8B57;
  -moz-border-radius:4px;
  -webkit-border-radius:4px;
  border-radius:4px;
  border:1px solid #ffffff;
  display:inline-block;
  cursor:pointer;
  color:#ffffff;
  font-family:Cambria;
  font-size:12px;
  padding:3px 6px;
  text-decoration:none;
  text-shadow:0px 1px 0px #2E8B57;
}
.export:hover {
  background-color:#2E8B57; 
}
.export:active {
  position:relative;
  top:1px;
}
  .chooseitem {
  -moz-box-shadow:inset 0px 39px 0px -24px #3385ff;
  -webkit-box-shadow:inset 0px 39px 0px -24px #3385ff;
  box-shadow:inset 0px 39px 0px -24px #3385ff;
  background-color: #3385ff;
  -moz-border-radius:4px;
  -webkit-border-radius:4px;
  border-radius:4px;
  border:1px solid #ffffff;
  display:inline-block;
  cursor:pointer;
  color:#ffffff;
  font-family:Cambria;
  font-size:12px;
  padding:3px 6px;
  text-decoration:none;
  text-shadow:0px 1px 0px #b23e35;
}
.chooseitem:hover {
  background-color:#3385ff;
}
.chooseitem:active {
  position:relative;
  top:1px;
}
</style>

<meta name="viewport" content="width=device-width, initial-scale=1">     
<div class="row">
  <div class="col-sm-12">
   <div class="col-sm-4">


    </div>
<div class="col-sm-6">
<nav class="navigation" style="width: 180px;border-radius: 4px;height: auto;margin-left: 89%;">  
  <span class="hidden-print">
  <ul class="mainmenu" class="hidden-print">

    <li><a href="" class="hidden-print">Menu&nbsp&nbsp&nbsp<i class="fa fa-bars" class="hidden-print"></i></a>
      <ul class="submenu">

      <?php 
       $Authority = $_SESSION['authority'];
      $Export = $_SESSION['Export'];
      if ($Authority == 'Accountant') {
       print'
       <li><a href="../Rate/list.php?namelist=&year=&month=&day=">New Rate</a></li>';}?>

      <li><a href="../Product/list.php?namelist=&year=&month=&day=" >Input</a></li>
      
      <li><a href="../transfer/list.php?namelist=&year=&month=&day=" >Transfer</a></li>

      <li><a href="../Job/list.php?namelist=&year=&month=&day=">WIP</a></li>
      
      <li><a href="../Delivery/list.php?namelist=&year=&month=&day=" >Delivery</a></li>

      <li><a href="../Return/list.php?namelist=&year=&month=&day=">Customer Return</a></li>
     
      <li><a href="../SupplierReturn/list.php?namelist=&year=&month=&day=">Supplier Return</a></li>

      <li><a href="../Instock/list.php?namelist=&year=&month=&day=&Commodities=&remain=&branch=">Instock</a></li>      

      <li><a href="../Customer/list.php?">Customer</a></li>

      <li><a href="../brandname/list.php?">BrandName</a></li>

      <li><a href="../commodity/list.php?">Commodity</a></li>

      <li><a href="../code/list.php?">Code No</a></li>

      <li><a href="../branch/list.php?">branch</a></li>

      <li><a href="../Supplier/list.php?">Supplier</a></li>
     
      <?php 
      $Permission = $_SESSION['permission'];
      if ($Permission == 'Permit') {
                     print"     
      <li><a href='../User/list.php?'>User</a></li>";}?>
      
      <li><span style="color: red;font-weight: bold;">LOGOUT<a href="../logout.php?" class="logout"><img src = "../image/log.png" width="26px"; height="25px;" ></a></span></li>

      </ul>
    </li>
  </ul>
</span>
</nav>
</div>
</div>
</div>
</head>
</html>
<style type="text/css">
  html, body {
    font-family:Tahoma, Geneva, sans-serif;
   /*background: #f2f2f2;*/
}

/* define a fixed width for the entire menu */
.navigation {
  width: 180px;
 /*margin-top: 10px;*/

}
.mainmenu, .submenu {
  list-style: none;
  padding: 0;
  margin: 0;
  position: absolute;
  z-index: 2; 
  opacity: all;
  border-radius: 2px;
  
}

.mainmenu a {
  display: block;
  background-color: #3385ff;
  text-decoration: none;
  padding: 10px;
  color: #fff;
  width: 120px;
  border-radius: 2px;


}

.mainmenu a:hover {
    background-color: #C5C5C5;

}
.mainmenu li:hover .submenu {
  display: block;
  max-height: 500px;

}
.submenu a {
  background-color: #a6a6a6;


}
.submenu a:hover {
  background-color: #3385ff;
color: white;
}
.submenu {
  overflow: hidden;
  max-height: 0;
  -webkit-transition: all 0.5s ease-out;

}
</style>

