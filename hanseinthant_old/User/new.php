<?php session_start();?>
<?php  
      include_once('../config.php');
      include_once('../bar.php');
      include_once('../style.css');
      include_once('../header.php');
      if (($_SESSION['login_session']<> true)) {
        header("Location:../index.php");
        exit();
      }      
 ?>

<body style="font-size: 11px;font-family:Tahoma, Geneva, sans-serif;">
                    <?php
                        
                        $sqls="SELECT ifNull(Max(UserID),0) as ID FROM users ";
                                              
                        $results=mysqli_query($con ,$sqls);

                        print '<form method="POST" action="save.php">';
                     
                       print '<table style="width:100%;margin-left:0%;" id="customers">';

                        while($row = $results->fetch_assoc()){ 
                           $ID = $row['ID'] +1;
                           print '<input type="hidden" name="hidUserID" value="' .$ID. '"';
                           $LUser = $_SESSION['login_user'];
 
          
                           print '<tr><td style="width:18%;">User Name </td><td> <input type="text" required="required" name="UserName" value="" style="width:250px;height:30px;"/></td></tr>';
                           print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';
                           print '<tr><td>Password </td><td> <input type="password" required="required" name="Password"  value="" style="width:250px;height:30px;"/></td></tr>'; 
                           print '<tr><td>Authority </td><td><select name="Authority" style="width:250px;height:30px;"><option value=""></option><option value="NormalUser">NormalUser</option><option value="Accountant">Accountant</option></select> </td></tr>'; 
                           print '<tr><td>Permission (Account & Password Change)</td><td><select name="Permission" style="width:250px;height:30px;"><option value=""></option><option value="Permit">Permit</option><option value="No Permit">NoPermit</option></select> </td></tr>';

                           print '<tr><td>Export</td><td><select name="Export" style="width:250px;height:30px;"><option value=""></option><option value="Export">Export</option><option value="No Export">NoExport</option></select> </td></tr>';

                           print '<tr><td>Branch</td><td><select name="Branch" style="width:250px;height:30px;">
                           <option value=""></option>
                           <option value="Shwe Pyi Thar Store">Shwe Pyi Thar Store</option>
                           <option value="Shwe Pyi Thar Store Control Panel">Shwe Pyi Thar Store Control Panel</option>
                           <option value="Yangon Show Room">Yangon Show Room</option>
                           <option value="Naypyidaw Show Room">Naypyidaw Show Room</option>
                           <option value="Mandalay Show Room">Mandalay Show Room</option>
                           <option value="All Branch">All Branch</option>
                           </select> </td></tr>';
                           print '<tr><td></td><td><input type="submit" value="Save" style=""  class="myButton"/></td</tr>';
                         }

                        print '</table>';
                        print '</br>';

                        print '</form>';
                    ?>
                  </body>
                  </html>
   


