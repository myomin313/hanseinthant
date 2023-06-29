<!-- <?php session_start();?> -->
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
    <?php
      $actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    ?>  

  <script>
    function myFunction(id)
    {
      var r = confirm("Are you sure you want to delete this record?");
      if(r == true)
      {
        window.location.assign("update.php?id=" + id);
      }
    }
    function myDelete(id)
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
                        
                        $_SESSION['page'] = "detail";
                       
                        $id=$_GET['id']; 

                        $sqls="SELECT * 
                            FROM brandname
                            where  id ='$id'";
                                              
                        $results=mysqli_query($con ,$sqls);             
                        $i = 0;
                        print '<form method="POST" action="update.php">';
                      
                        print '<table style="width: 100%;margin-left:0%;" id="brandname">';


                        while($row = $results->fetch_assoc()){ 


                          print '<input type="hidden" name="id" value="' . $row['id']. '"';
                        $LUser = $_SESSION['login_user'];

                          print'<tr><td><input type="text" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" /></td></tr>'; 

                           print '<tr><td>BrandName</td><td><input type="text"  name="brandname" id="brandname" value="' . $row['brandname']. '" style="width:250px;height:30px;font-size:10px;"/></td></tr>';
                             
                           print '<tr><td></td><td><input type="submit" value="Update"    class="updateitem"/></td></tr>';                        

                           }
                        print '</table>';

                        print '</form>';



                    ?>
                  </body></html>


    <script>

