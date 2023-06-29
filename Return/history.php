<?php session_start();?>
<?php 
      if (($_SESSION['login_session']<> true)) {
        header("Location:../index.php");    
        exit();
      }     

?>
<?php 
      include_once('../config.php');
      include_once('../style.css');
      include_once('../header.php');

// $setutf8 = "SET NAMES utf8";
// $q = $con->query($setutf8);
// $setutf8c = "SET character_set_results = 'utf8', character_set_client =
// 'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
// character_set_server = 'utf8'";
// $qc = $con->query($setutf8c);
// $setutf9 = "SET CHARACTER SET utf8";
// $q1 = $con->query($setutf9);
// $setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
// $q2 = $con->query($setutf7);
  ?>

  <!-- History List -->
  <!DOCTYPE html>
    <html lang="en">
      <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
      </head>

      <script type="text/javascript">
        $(document).ready(function () {  
          $('#year').change(function () {
            window.location.href = "history.php?selected="+ $(this).val()+"&month="+"&day=";      
          });      
          $('#month').change(function () {
            window.location.href = 'history.php?selected=' +$("#year option:selected").val()+'&month='+this.options[this.selectedIndex].value+"&day="; 
          });
          $('#day').change(function () {
            window.location.href = 'history.php?selected=' +$("#year option:selected").val()+'&month='+$("#month option:selected").val()+'&day='+this.options[this.selectedIndex].value
          });      
        });
      </script>
   
      <body >
        <!-- <div class="container" style="background: white;width: 100%;margin: 10px;">  -->
          <h2>History Of Customer Return List</h2>
          <select name="year" onchange="javascript:valueselect()" id="year" style="" class="hidden-print">
            <option value=""></option>
            <?php 
              $year = date('Y');
              $min = $year - 10;
              $max = $year;
              $selected = $_GET['selected'];
              for( $y=$max; $y>=$min; $y-- ) {
                print '<option value="'. $y.'"';
                if($y == $selected)
                {
                  print ' selected= selected ';
                } 
                print '>'.$y.'</option>';
              }
            ?>
          </select>

          <span class="hidden-print" >&nbspYear</span>
          <select name="month" id="month" onchange="javascript:valueselect()" class="hidden-print">
            <option value=""></option>
              <?php 
                $month = $_GET['selected'];
                for( $m=1; $m<=12; ++$m ) { 
                  // $month_label = date('F', mktime(0, 0, 0, $m, 1));
                  print '<option value="'. $m.'"';
                  if( $_GET['month'] == $m)
                  { 
                    print ' selected= selected ';
                  } 
                  print '>' . date('F', mktime(0, 0, 0, $m, 1)) . '</option>';
                }   
              ?>
          </select> 

          <span class="hidden-print" >&nbspMonth</span>
          <select name="day" id="day" onchange="javascript:valueselect()" class="hidden-print">
            <option value=""></option>
              <?php 
                $start_date = 1;
                $end_date   = 31;
                $day = $_GET['selected'];
                for( $d=$start_date; $d<=$end_date; $d++ ) {
                  // echo '<option value='.$d.'>'.$d.'</option>';
                  print '<option value="'. $d.'"';
                  if( $_GET['day'] == $d)
                  { 
                     print ' selected= selected ';
                    } 
                    print '>' . $d . '</option>';  
                }
              ?>
          </select>
<script type="text/javascript">
              function checkAll(o) {
              var boxes = document.getElementsByTagName("input");
              for (var x = 0; x < boxes.length; x++) {
                var obj = boxes[x];
                if (obj.type == "checkbox") {
                  if (obj.name != "check")
                    obj.checked = o.checked;
                  }
              }
            }
              function setDeleteAction() {      

                document.approve.action = "deletehistory.php?";
                document.approve.method = "post";
                document.approve.target = "history";
                document.approve.submit();
            }  
</script>
          <span class="hidden-print" >&nbspDay</span>
<input type="submit" name="history" id="history" onClick="setDeleteAction();" value="Delete" class="deleteitem" style="margin-left:3%;">
<form  name="approve" method="post" action=""> 
          <table style="margin-top: 20px;margin-bottom: 20px;border-collapse: collapse;width: auto;font-size: 11px;" id="emp_table" border="0" >
              <tr class="tr_header" style="background-color:#3385ff;font-family:Tahoma, Geneva, sans-serif;font-size: 13px;">
                <?php 
                
               
                // echo $_POST['users'];
                  if (isset($_POST['users'])) {
                    $rowCount = count($_POST['users']);
                  }
                  else{
                    $rowCount = 0;
                  }
                  
                    $sqls="SELECT *,customerreturn_history.Customer as Customer,customerreturn_history.OCustomer as OCustomer,cu.CustomerName as CustomerName,ocu.CustomerName as OCustomerName,b.brandname as brandname,c.commodity as commodity,co.code as code_no,oco.code as Ocode_no,ob.brandname as obrandname,oc.commodity as ocommodity
                   FROM customerreturn_history
                   LEFT JOIN brandname b  ON customerreturn_history.BrandName= b.id 
                   LEFT JOIN commodity c  ON customerreturn_history.Commodity= c.id
                   LEFT JOIN brandname ob ON customerreturn_history.OBrandName= ob.id 
                   LEFT JOIN commodity oc ON customerreturn_history.OCommodity= oc.id
                   LEFT JOIN code co ON customerreturn_history.code= co.id
                   LEFT JOIN code oco ON customerreturn_history.code= oco.id
                   LEFT JOIN customer cu ON customerreturn_history.Customer=cu.UserId
                   LEFT JOIN customer ocu ON customerreturn_history.OCustomer=ocu.UserId
                   WHERE 1=1";
                  if ($rowCount > 0) {
                    for($i=0;$i<$rowCount;$i++) {
                      $history= $_POST["users"][$i];
                      if ( $history <> '' && $i<=0){
                        $sqls =$sqls." AND DO_No='" . $_POST["users"][$i] . "'";
                        $result=mysqli_query($con,$sqls);  
                        $count_history=mysqli_num_rows($result); 
                        if ($count_history == 0) {
                          echo "<h3>No history list</h3>";
                        }
                      }
                      elseif ( $history <> '' || $i>0){
                        $sqls =$sqls." OR DO_No='" . $_POST["users"][$i] . "'";
                      }
                    }
                  }
                  
                  if ($selected == '' ){
                    $sqls =$sqls." AND YEAR(RecordTime) = YEAR(CURRENT_DATE())";
                  }
                  if ($selected <> ''){
                    $sqls =$sqls." AND YEAR(RecordTime)= ".$selected;
                  } 
                  if ($_GET['month'] <> ''){
                    $sqls =$sqls." AND MONTH(RecordTime)= '".$_GET['month']."'";
                  }
                  if ($_GET['day'] <> ''){
                    $sqls =$sqls." AND DAY(RecordTime)= ".$_GET['day'];
                  }  
                  $sqls = $sqls . " ORDER BY RecordTime DESC";                        
                  $results=mysqli_query($con,$sqls);  
                  $count=mysqli_num_rows($results);           
                  if ($count > 0){                 
                    $i = 0;

                    print'<th class="checkall" rowspan="2" style="width:2%;"> 
                          <input type="checkbox" name="check_all" id="check_all" onclick="javascript:checkAll(this)" class="hidden-print"  style="margin-left: 0px;" />
                         </th>  
                          <th>ID</th>
                          <th>Updator</th>
                          <th>Update Time</th>
                          <th>Status</th>                      
                          <th colspan="2">CustomerName</th>
                          <th colspan="2">Code</th>
                          <th colspan="2">BrandName</th>
                          <th colspan="2">Commodity</th>
                          <th colspan="2">Qty</th>
                          <th colspan="2">Type</th>
                          <th colspan="2">DO</th>
                          <th colspan="2">PL</th>                                                                                            
                          <th colspan="2">Remarks_item</th>
                          <th colspan="2">Customer Return Date</th>
                          <th colspan="2">Return No</th>
                          <th colspan="2">To Department</th>

                           ';
                    print'</tr>';
                    print' </thead>';
                    print'<tbody>';
            
                    while($row = $results->fetch_assoc()){  
                      $i+=1;
                     
                      print '<tr style="border-bottom: 1px solid;font-size: 9px;">';
                       print '<td align="center" class="checkss"><input name="users[]" type="checkbox" class="checkboxes" value=' . $row['id'] . ' ></td>';
                     
                       print '<td  >' . $i . '</td>'; 
                      print '<td style="width:92px;">' . $row['Recorder'] . '</td>';
                      print '<td>' . $row['RecordTime'] . '</td>';

                      if ($row['status'] == "Update") {
                        print '<td><span style="color: #00cc44;">' . $row['status'] . '</span></td>'; 
                      }
                      if ($row['status'] == "Delete") {
                        print '<td><span style="color: #ff0036;">' . $row['status'] . '</span></td>';     
                      }
                      if ($row['status'] == "New") {
                        print '<td><span style="color: blue;">' . $row['status'] . '</span></td>';     
                      }
                      
                       if ($row['OCustomer'] != ""  && $row['status'] == "Update") {
                        // $sqlss = " SELECT CustomerName FROM customer WHERE 1=1 AND UserId = " .$row['OCustomer']; 
                        //  $resultss=mysqli_query($con,$sqlss);  
                        // while($rowss = $resultss->fetch_assoc()){ 
                        //  $cuss =$rowss['CustomerName'];
                        //  $cuss = rtrim($rowss['CustomerName'],",");
                        // }
                        print '<td><span style="">'.$row['OCustomerName'].'</span></td>';
                    }

                   if ($row['Customer'] != "" && $row['status'] == "Update") {
                        // $sqlso =" SELECT CustomerName FROM customer WHERE 1=1 AND UserId = " .$row['Customer'];
                        // $resultso=mysqli_query($con,$sqlso); 
                        // while($rowso = $resultso->fetch_assoc()){ 
                        // $rowso['CustomerName'] = rtrim($rowso['CustomerName'],",");
                          print '<td><span style="color:  #00cc44;">'.$row['CustomerName'].'</span></td>';                        
                        
                        // }
                    }
                    elseif ($row['Customer'] != "" && $row['status'] == "New") {

                        //  $sqlso =" SELECT CustomerName FROM customer WHERE 1=1 AND UserId = " .$row['Customer'];
                        // $resultso=mysqli_query($con,$sqlso); 
                        // while($rowso = $resultso->fetch_assoc()){ 
                        //   $rowso['CustomerName'] = rtrim($rowso['CustomerName'],",");

                          print '<td class="hide_right"><span style="color: blue;">'.$row['CustomerName'].'</span></td>';
                          print '<td></td>';                          
                        
                        //}
                      }                     

                      else
                      {
                          

                        

                        if ($row['status'] == "Delete") {
                    //   $sqlso = " SELECT CustomerName FROM customer WHERE 1=1 AND UserId = " .$row['OCustomer'];
                    //      $resultso=mysqli_query($con,$sqlso);
                    //   while($rowso = $resultso->fetch_assoc()){ 
                    //      $cussA =$rowso['CustomerName'];
                    //      $cussA = rtrim($rowso['CustomerName'],",");
                    //     }
                         
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['OCustomerName'].'</span></td>';
                          print '<td></td>';
                          
                        }
                

                      }  
                      
                       //..............................//  
                       if ($row['code_no'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['Ocode_no'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['code_no'].'</span></td>';
                      }
                      elseif ($row['code_no'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['code_no'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['Ocode_no'].'</span></td>';
                          print '<td></td>';
                        }

                      }   
                                          
                       //..............................//
     
                        //..............................//  
                      if ($row['brandname'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['obrandname'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['brandname'].'</span></td>';
                      }
                      elseif ($row['brandname'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['brandname'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['obrandname'].'</span></td>';
                          print '<td></td>';
                        }

                      }   
                                          
                       //..............................//                   
                      if ($row['commodity'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['ocommodity'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['commodity'].'</span></td>';
                      }
                      elseif ($row['commodity'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['commodity'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['ocommodity'].'</span></td>';
                          print '<td></td>';
                        }

                      }   
                      //..............................// 
                      if ($row['Qty'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['OQty'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['Qty'].'</span></td>';
                      }
                      elseif ($row['Qty'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['Qty'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['OQty'].'</span></td>';
                          print '<td></td>';
                        }

                      }   
                        //..............................// 
                      if ($row['Type'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['OType'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['Type'].'</span></td>';
                      }
                      elseif ($row['Type'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['Type'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['OType'].'</span></td>';
                          print '<td></td>';
                        }

                      }    
                      //..............................// 
                      
                       if ($row['DO_No'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['ODO_No'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['DO_No'].'</span></td>';
                      }
                      elseif ($row['DO_No'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['DO_No'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['ODO_No'].'</span></td>';
                          print '<td></td>';
                        }

                      }                       
  
                       //..............................//                               
                       if ($row['PL'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['OPL'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['PL'].'</span></td>';
                      }
                      elseif ($row['PL'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['PL'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['OPL'].'</span></td>';
                          print '<td></td>';
                        }

                      }                       
  
                       //..............................//    
                       if ($row['Remarks_item'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['ORemarks_item'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['Remarks_item'].'</span></td>';
                      }
                      elseif ($row['Remarks_item'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['Remarks_item'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['ORemarks_item'].'</span></td>';
                          print '<td></td>';
                        }

                      }                       
  
                       //..............................//                                                                 
                        if ($row['Return_date'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['OReturn_date'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['Return_date'].'</span></td>';
                      }
                      elseif ($row['Return_date'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['Return_date'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['OReturn_date'].'</span></td>';
                          print '<td></td>';
                        }

                      }                       
  
                       //..............................//                
                       if ($row['Return_no'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['OReturn_no'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['Return_no'].'</span></td>';
                      }
                      elseif ($row['Return_no'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['Return_no'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['OReturn_no'].'</span></td>';
                          print '<td></td>';
                        }

                      }                       
  
                       //..............................//    
                        if ($row['department'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['Odepartment'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['department'].'</span></td>';
                      }
                      elseif ($row['department'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['department'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['Odepartment'].'</span></td>';
                          print '<td></td>';
                        }

                      }                       
  
                       //..............................//                          
                      print '</tr>';                     
                    }
                    print ' </tbody>'; 
                    print ' </table>'; 
                  }
                  else{
                    print '<span style="margin-left:600px;"><h1 style="margin-left:600px;font-family:Times New Roman, Times, serif;
                                  border-collapse: collapse;">No Matching Data.</h1></span>';
                  }                  
                ?> 
        </div>
      </body>
    </html>

    <style type="text/css">
      table th,td{
        border:1px solid;
        padding: 10px;
      }
      table td.hide_right{
        border-right-style:hidden ! important;
      }
      thead{    
        background-color: #1ac6ff !important;
      }
    </style>