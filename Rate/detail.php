<?php session_start();?>
<?php 
      if (($_SESSION['login_session']<> true)) {
        header("Location:../index.php");    
        exit();
      }     

?>
<?php 
      include_once('../config.php');
      include_once('../bardetail.php');
      include_once('../style.css');
      include_once('../header.php');
 
 ?> 
<?php if (isset($_SESSION['message'])): ?>
  <div class="msg">
    <?php 
      echo $_SESSION['message']; 
      unset($_SESSION['message']);
    ?>
  </div>
<?php endif ?>

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

 <body style="font-size: 11px; font-family:Tahoma, Geneva, sans-serif;">

     <?php
print'';?>
         <?php
                        
                        $_SESSION['page'] = "detail";
                       
                        $myUserID=$_GET['ID']; 
                       
                        $sqls="SELECT * FROM rate where  id ='$myUserID'";
                                              
                        $results=mysqli_query($con ,$sqls);             
                        
                        $i = 0;
                        print '<form method="POST" action="update.php">';
                      
                        print '<table style="width: 100%;margin-left:0%;" id="customers">';


                        while($row = $results->fetch_assoc()){ 
  
                          print '<input type="hidden" name="hidID" value="' . $row['id']. '"';                          

                           print '<tr><td>Myanmar</td><td> <input type="text" name="Myanmar" id="Myanmar" value="' . $row['Myanmar']. '" style="width:250px;height:30px;" />&nbspMMK</td></tr>';
                          $LUser = $_SESSION['login_user'];
                          print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';
                          print '<tr><td>Singapore</td><td> <input type="text" name="Singapore" id="Singapore" value="' . $row['Singapore']. '" style="width:250px;height:30px;" />&nbspUSD</td></tr>';

                           print '<tr><td>Europe</td><td> <input  type="text" name="Europe" id="Europe" value="' . $row['Europe']. '" style="width:250px;height:30px;" />&nbspUSD</td></tr>';  

                           print '<tr><td>Thailand</td><td> <input type="text" name="Thailand" id="Thailand" value="' . $row['Thailand']. '" style="width:250px;height:30px;" />&nbspUSD</td></tr>';

                           print '<tr><td>British</td><td> <input  type="text" name="British" id="British"
                            value="' . $row['British']. '" style="width:250px;height:30px;" />&nbspUSD</td></tr>'; 

                           print '<tr><td>Japan</td><td> <input type="text" name="Japan" id="Japan" value="' . $row['Japan']. '" style="width:250px;height:30px;" />&nbspUSD</td></tr>'; 

                           print '<tr><td>Australia</td><td> <input type="text" name="Australia" id="Australia" 
                           value="' . $row['Australia']. '" style="width:250px;height:30px;" />&nbspUSD</td></tr>';

                           print '<tr><td>Today<span style="padding-left:100px;"><img src = "../image/calendar.png" width="21px"; height="20px;" style="padding-top:0px;"></span></td><td> <input type="date" name="Rate_date" id="Rate_date" value="' . $row['Rate_date']. '" style="width:250px;height:30px;font-size:11px;"/>&nbspUSD</td></tr>';                          
                           print '<tr><td> </td><td><input type="submit" value="Update" style="margin-left:2%"   class="myUpdate"/></td></tr>';
                            }
                        print '</table>';
     
                        print '</form>';



                    ?>
                  </body></html>


    <script>
    function myDelete(id)
    {
      var r = confirm("Are you sure you want to delete this record?");
      if(r == true)
      {
        window.location.assign("delete.php?id=" + id);
      }
    }
  
  </script>    

