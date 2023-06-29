<?php session_start();?>
<?php 
      if (($_SESSION['login_session']<> true)) {
        header("Location:../index.php");    
        exit();
      }     

?>
<?php 
      include_once('../config.php');
      include_once('../bar.php');
      include_once('../style.css');
      include_once('../header.php');
 
 ?> 
    <script>
    function myFunction(id)
    {
       var r = confirm("Are you sure you want to delete this record?");
       if(r == true)
       {
          window.location.assign("delete.php?id=" + id);
       }
    }

</script>

<!-- 24/10/2019 develop by Winsan -->
          <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
          <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
          <script>
        $( function() {
             $("#Rate_date").datepicker({
              dateFormat: "yy-mm-dd"
             });
         });
         </script>
<!-- 24/10/2019 develop by Winsan -->


 <?php
              if (isset($_REQUEST['error'])):

             echo '<script type="text/javascript">alert("'.$_REQUEST['error'].'");</script>';
              endif;
  ?>
<body style="font-size: 10px;font-family:Tahoma, Geneva, sans-serif;">

             <?php
                        
                        $sqls="SELECT ifNull(Max(id),0) as ID FROM product ";
                                              
                        $results=mysqli_query($con ,$sqls);             
                        
                        $i = 0;
                        print '<form method="POST" action="save.php" >';
                      
                        print '<table style="width: 100%;margin-left:0%;position:relative;margin-top:30px" id="customers">';

                        while($row = $results->fetch_assoc()){ 

                           $ID = $row['ID'] +1;

                           print '<tr><td>Myanmar</td><td> <input type="text" name="Myanmar" id="Myanmar" value="" style="width:250px;height:30px;"/>&nbspMMK

                           </td></tr>';                           
                          $LUser = $_SESSION['login_user'];
                          print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';
                          print '<tr><td>Singapore</td><td> <input type="text" name="Singapore" id="Singapore" value="" style="width:250px;height:30px;"/>&nbspUSD</td></tr>';

                           print '<tr><td>Europe</td><td> <input  type="text" name="Europe" id="Europe" value="" style="width:250px;height:30px;"/>&nbspUSD</td></tr>';  

                           print '<tr><td>Thailand</td><td> <input type="text" name="Thailand" id="Thailand" value="" style="width:250px;height:30px;"/>&nbspUSD</td></tr>';

                           print '<tr><td>British</td><td> <input  type="text" name="British" id="British" value="" style="width:250px;height:30px;"/>&nbspUSD</td></tr>'; 

                           print '<tr><td>Japan</td><td> <input type="text" name="Japan" id="Japan" value="" style="width:250px;height:30px;"/>&nbspUSD</td></tr>'; 

                           print '<tr><td>Australia</td><td> <input type="text" name="Australia" id="Australia" value="" style="width:250px;height:30px;"/>&nbspUSD</td></tr>';

                           print '<tr><td>Today<span style="padding-left:100px;"><img src = "../image/calendar.png" width="21px"; height="20px;" style="padding-top:0px;"></span></td><td>  <input type="text" name="Rate_date" id="Rate_date" value="" style="width:250px;height:30px;font-size:11px;" autocomplete="off"/>&nbspUSD</td></tr> ';  

                           print '<tr><td></td><td style="margin-bottom:30px"><input type="submit" value="Save" class="myButton" onclick="return confirm(\'Are you sure to save?\');")"/></td></tr> ';                                                        
                                                       
                            }
                        print '</table>';
                        print '</br>';

                        print '</form>';
                    ?>
        </form>
      </body>
      </html>
   
    <style type="text/css">
#centeredmenu {
   float:left;
   width:90%;
   background:rgb(192,192,192);
   border-bottom:4px solid #005094;
   overflow:hidden;
   position:relative;
   margin-left: 2.1%;
}
#centeredmenu ul {
   clear:left;
   float:left;
   list-style:none;
   margin:0;
   padding:0;
   position:relative;
   left:50%;
   text-align:center;
}
#centeredmenu ul li {
   display:block;
   float:left;
   list-style:none;
   margin:0;
   padding:0;
   position:relative;
   right:405%;
}
#centeredmenu ul li a {
   display:block;
   margin:0 0 0 1px;
   padding:5px 10px;
   background:#ddd;
   color:#000;
   text-decoration:none;
   line-height:1.3em;
}
#centeredmenu ul li a:hover {
   background:#369;
   color:#fff;
}
#centeredmenu ul li a.active,
#centeredmenu ul li a.active:hover {
   color:#fff;
   background:#005094;
   font-weight:bold;
}
  ul.sidenav a.active{
    background-color: #668aff;
    color: black;

    }
</style>