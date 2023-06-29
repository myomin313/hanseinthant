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
                                              
                        $results=mysqli_query($con,$sqls);

                        print '<form method="POST" action="save.php">';
                     
                       print '<table style="width:100%;margin-left:0%;" id="customers">';

                        while($row = $results->fetch_assoc()){ 
                           $ID = $row['ID'] +1;
                           print '<input type="hidden" name="hidUserID" value="' .$ID. '"';
                           $LUser = $_SESSION['login_user'];
                          //  start

                          print '<tr><td style="width:7%;">BrandName</td><td> <select name="brandname"  class="brandname" id="brandname" style="width:20%;height:30px;" required="required">';
                           print'<option value =""></option>';
                           $sqlp="SELECT * FROM brandname ORDER BY brandname";                         
                            $resResultp = $con->query($sqlp);
                            while ($rowp=mysqli_fetch_array($resResultp)) {
                             $rowp['brandname'] = rtrim($rowp['brandname'],",");
                            $brandname = $rowp["brandname"];
                            $bid = $rowp["id"];  
                          print '<option value="'. $bid.'"';                             
                           print '>'. $brandname.'</option>';  
                           }  
                            print'</select></td></tr>';


                            print '<tr><td style="width:7%;">Commodity</td><td> <select name="commodity"  class="commodity" id="commodity" style="width:20%;height:30px;" required="required">';
                             print'<option value =""></option>';
                              $sqlp="SELECT * FROM commodity ORDER BY commodity";                         
                               $resResultp = $con->query($sqlp);
                               while ($rowp=mysqli_fetch_array($resResultp)) {
                                $rowp['commodity'] = rtrim($rowp['commodity'],",");
                               $commodity = $rowp["commodity"];
                               $cid = $rowp["id"];  
                             print '<option value="'. $cid.'"';                             
                              print '>'. $commodity.'</option>';  
                              }  
                               print'</select></td></tr>';
                            print '<tr><td>Code No</td><td>
                            <input type="text" " name="code" value=""  style="width:20%;height:30px;" required="required"/>
                            <span style="color:red;font-weight:bold;">&nbsp*&nbsp&nbspPlease make sure your Code No. </span>  
                               </td></tr>'; 


                          //end
                           print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';
                         
                          

                    

                          
                           print '<tr><td></td><td><input type="submit" value="Save" style=""  class="myButton"/></td</tr>';
                         }

                        print '</table>';
                        print '</br>';

                        print '</form>';
                    ?>

<script src="../js/select2.min.js" type="text/javascript"></script>
<script>
  $("#brandname").select2( {
  placeholder: "Select BrandName",
  allowClear: true
  } );

  $("#commodity").select2( {
  placeholder: "Select Commodity",
  allowClear: true
  } );
  </script>

                  </body>
                  </html>
   


