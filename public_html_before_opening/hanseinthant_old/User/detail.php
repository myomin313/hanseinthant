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
                       
                        $myUserID=$_GET['UserID'];  
                       
                        $sqls="SELECT * FROM users where  UserID ='$myUserID'";
                                              
                        $results=mysqli_query($con ,$sqls);             
                        
                        $i = 0;
                                              
                        $results=mysqli_query($con ,$sqls);             
                        $i = 0;
                        print '<form method="POST" action="update.php">';
                      
                        print '<table style="width: 100%;margin-left:0%;" id="customers">';


                        while($row = $results->fetch_assoc()){ 
                           
                           print '<input type="hidden" name="hidUserID" value="' . $row['UserID']. '"';
                           // print '<tr><td>User ID </td><td> <label for="UserID" name="UserID" >' . $row['UserID']. '</label></td></tr>';
                           // print '<tr><td>Create Time </td><td style="color:blue;">' . $row['CreateTime']. '</td></tr>';
                           // print '<tr><td>Update Time </td><td style="color:green;">' . $row['UpdateTime']. '</td></tr>';
                           // print '<tr><td>Creator </td><td style="color:blue;">' . $row['Creator']. '</td></tr>';
                           // print '<tr><td>Updator </td><td style="color:green;">' . $row['Updator']. '</td></tr>';  
                          $LUser = $_SESSION['login_user'];
                          print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';                           
                           print '<tr><td>User Name </td><td> <input type="text" required="required" name="UserName" value="' . $row['UserName']. '" style="width:250px;height:30px;font-size:10px;"/></td></tr>';
                           print '<tr><td>Password </td><td> <input type="password" required="required" name="Password"  value="' . $row['Password']. '" style="width:250px;height:30px;font-size:10px;"/></td></tr>'; 
                           print '<tr><td>New Password </td><td> <input type="text"  name="NewPassword"  value="" style="width:250px;height:30px;font-size:10px;"/></td></tr>'; 
                            $Authority= $row['Authority'];
                           print '<tr><td>Authority </td><td>
                            <select name="Authority" style="width:250px;height:30px;font-size:10px;">
                              <option value='.$row['Authority'].'>' . $row['Authority']. '</option>
                              <option value="NormalUser">NormalUser</option>
                              <option value="Accountant">Accountant</option>';

                           print' </select></td></tr>';

                           $Permission= $row['Permission'];
                           print '<tr><td>Permission </td><td>
                            <select name="Permission" style="width:250px;height:30px;font-size:10px;">
                              <option >' . $row['Permission']. '</option>
                              <option value="Permit">Permit</option><option value="No Permit">NoPermit</option>';

                           print' </select></td></tr>';

                            $Export= $row['Export'];
                           print '<tr><td>Export </td><td>
                            <select name="Export" style="width:250px;height:30px;font-size:10px;">
                              <option value='.$row['Export'].'>' . $row['Export']. '</option>
                              <option value="Export">Export</option><option value="No Export">NoExport</option>';

                           print' </select></td></tr>';
                           // echo $row["Branch"];

                           print '<tr><td>Branch</td><td><select name="Branch" style="width:250px;height:30px;font-size:10px;">
                           <option value='.$row['Branch'].'>'.$row['Branch'].'</option>
                           <option value="Shwe Pyi Thar Store">Shwe Pyi Thar Store</option>
                           <option value="Shwe Pyi Thar Store Control Panel">Shwe Pyi Thar Store Control Panel</option>
                           <option value="Yangon Show Room">Yangon Show Room</option>
                           <option value="Naypyidaw Show Room">Naypyidaw Show Room</option>
                           <option value="Mandalay Show Room">Mandalay Show Room</option>
                           <option value="All Branch">All Branch</option>



                           </select> </td></tr>';
        

                           print'<tr><td></td><td><input type="submit" value="Update"    class="updateitem"/></td></tr>';



                           }
                        print '</table>';
            
                        print '</form>';



                    ?>
                  </body></html>


    <script>

