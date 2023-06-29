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
                       
                        $id=$_GET['id']; 

                      

                        $sqls="SELECT * 
                            FROM code
                            where  id ='$id'";
                                              
                        $results=mysqli_query($con ,$sqls);             
                        $i = 0;
                       
                        print '<form method="POST" action="update.php">';
                     
                        print '<table style="width:100%;margin-left:0%;" id="customers">';
 
                         while($row = $results->fetch_assoc()){ 
                            $obrandname = $row['brandname'];
                            $ocommodity = $row['commodity'];
                            $ocode = $row['code'];
                            print '<input type="hidden" name="id" value="' .$id. '">';
                            $LUser = $_SESSION['login_user'];
                           //  start
 
                           print '<tr><td style="width:7%;">BrandName</td><td> <select name="brandname"  class="brandname" id="brandname" style="width:20%;height:30px;"  required="required">';
                          // print'<option value =""></option>';
                            $sqlp="SELECT * FROM brandname ORDER BY brandname";                         
                             $resResultp = $con->query($sqlp);
                             while ($rowp=mysqli_fetch_array($resResultp)) {
                              $rowp['brandname'] = rtrim($rowp['brandname'],",");
                             $brandname = $rowp["brandname"];
                             $bid = $rowp["id"];
                              
                           print '<option value="'. $bid.'"';
                           if($obrandname == $bid)
                              { print ' selected= selected ';}   

                            print '>'. $brandname.'</option>';  
                            }  
                             print'</select></td></tr>';

                             print '<input type="hidden" name="obrandname" value="' .$obrandname. '">';
                             print '<input type="hidden" name="ocommodity" value="' .$ocommodity. '">';
                             print '<tr><td style="width:7%;">Commodity</td><td> <select name="commodity"  class="commodity" id="commodity" style="width:20%;height:30px;" required="required">';
                             // print'<option value =""></option>';
                               $sqlp="SELECT * FROM commodity ORDER BY commodity";                         
                                $resResultp = $con->query($sqlp);
                                while ($rowp=mysqli_fetch_array($resResultp)) {
                                 $rowp['commodity'] = rtrim($rowp['commodity'],",");
                                $commodity = $rowp["commodity"];
                                $cid = $rowp["id"];  
                              print '<option value="'. $cid.'"';
                              if($ocommodity == $cid)
                              { print ' selected= selected ';}                              
                               print '>'. $commodity.'</option>';  
                               }  
                                print'</select></td></tr>';
                             print '<tr><td>Code No</td><td>
                             <input type="text"  name="code" value="' .$ocode.' "  style="width:20%;height:30px;" required="required"/>
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
                  </body></html>


    <script>

