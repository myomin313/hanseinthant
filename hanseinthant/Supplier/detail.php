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
                       
                        $myID=$_GET['ID']; 

                        $sqls="SELECT *,GROUP_CONCAT(s.SupplierName SEPARATOR ',') AS SupplierName 
                            FROM supplier s
                            where  UserId ='$myID'";
                                              
                        $results=mysqli_query($con ,$sqls);             
                        $i = 0;
                        print '<form method="POST" action="update.php">';
                      
                        print '<table style="width: 100%;margin-left:0%;" id="customers">';


                        while($row = $results->fetch_assoc()){ 


                          print '<input type="hidden" name="hidID" value="' . $row['UserId']. '"';
                           $row['SupplierName'] = rtrim($row['SupplierName'],",");
                           // print '<tr><td>Create Time </td><td style="color:blue;">' . $row['CreateTime']. '</td></tr>';
                           // print '<tr><td>Update Time </td><td style="color:green;">' . $row['UpdateTime']. '</td></tr>';
                           // print '<tr><td>Creator </td><td style="color:blue;">' . $row['Creator']. '</td></tr>';
                           // print '<tr><td>Updator </td><td style="color:green;">' . $row['Updator']. '</td></tr>';
                        $LUser = $_SESSION['login_user'];
                          print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';                           

                           print '<tr><td>Supplier Name </td><td> <input type="text"  name="Name" id="Name" value="' . $row['SupplierName']. '" style="width:250px;height:30px;font-size:10px;"/></td></tr>';

                           print '<tr><td>Phone </td><td> <input type="text"  name="Phone" id="Phone" value="' . $row['Phone']. '" style="width:250px;height:30px;font-size:10px;"/></td></tr>';
                           print '<tr><td>Emergency </td><td> <input type="text" name="Emergency" id="Emergency" value="' . $row['Emergency']. '" style="width:250px;height:30px;font-size:10px;"/></td></tr>';                           
                           print '<tr><td>Email </td><td> <input  type="text" name="email" id="email" value="' . $row['Email']. '" style="width:250px;height:30px;font-size:10px;"/></td></tr>';
                           print '<tr><td>Address </td><td> <textarea style="width:500px;word-wrap: break-word;" type="text" name="Address" id="Address"  style="width:250px;height:30px;font-size:10px;">' . $row['Address']. '</textarea></td></tr>';   
                           print '<tr><td></td><td><input type="submit" value="Update"    class="updateitem"/></td></tr>';                        

                           }
                        print '</table>';

                        print '</form>';



                    ?>
                  </body></html>


    <script>
