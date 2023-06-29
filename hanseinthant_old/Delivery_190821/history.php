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
 

        $setutf8 = "SET NAMES utf8";
        $q = $con->query($setutf8);
        $setutf8c = "SET character_set_results = 'utf8', character_set_client =
        'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
        character_set_server = 'utf8'";
        $qc = $con->query($setutf8c);
        $setutf9 = "SET CHARACTER SET utf8";
        $q1 = $con->query($setutf9);
        $setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
        $q2 = $con->query($setutf7);
  ?>

  <!-- History List -->
  <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
      </head>
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
   
      <body>
        <!-- <div class="container" style="background: white;width: 100%;margin: 10px;">  -->
          <h2>History Of Delivery Order List</h2>
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

          <span class="hidden-print" >&nbspDay</span>
<input type="submit" name="history" id="history" onClick="setDeleteAction();" value="Delete" class="deleteitem" style="margin-left:3%;">
<form  name="approve" method="post" action=""> 
          <table style="margin-top: 20px;margin-bottom: 20px;border-collapse: collapse;width: auto;font-size: 11px;" id="emp_table" border="0" >
              <tr class="tr_header" style="background-color:#3385ff;font-family:Tahoma, Geneva, sans-serif;font-size: 12px;">
                <?php 
                // echo $_POST['users'];
                  if (isset($_POST['users'])) {
                    $rowCount = count($_POST['users']);
                  }
                  else{
                    $rowCount = 0;
                  }
                  
                    $sqls="SELECT *,Customer,OCustomer
                   FROM delivery_history 
                    WHERE 1=1 ";
                  // echo $sqls;
                  
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
                          <th colspan="2">BrandName</th>
                          <th colspan="2">Commodity</th>
                          <th colspan="2">Type</th>
                          <th colspan="2">Qty</th>                                                                                            
                          <th colspan="2">Remarks_Item</th>
                          <th colspan="2">Delivery Order Date</th>
                          <th colspan="2">DO No</th>
                          <th colspan="2">Branch</th>

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
                        if ($row['Customer'] != "" && $row['status'] == "Update") {
                        $sqlss = " SELECT CustomerName FROM customer WHERE 1=1 AND UserId = " .$row['OCustomer']; 
                         $resultss=mysqli_query($con,$sqlss);  
                      while($rowss = $resultss->fetch_assoc()){ 
                         $cuss =$rowss['CustomerName'];
                         $cuss = rtrim($rowss['CustomerName'],",");
                        }                            
                            
                          print '<td><span style="">'.$cuss.'</span></td>';

                        $sqlso =" SELECT CustomerName FROM customer WHERE 1=1 AND UserId = " .$row['Customer'];
                        $resultso=mysqli_query($con,$sqlso); 
                        while($rowso = $resultso->fetch_assoc()){ 
                          $rowso['CustomerName'] = rtrim($rowso['CustomerName'],",");
                          print '<td><span style="color:  #00cc44;">'.$rowso['CustomerName'].'</span></td>';                        
                        
                        }
                      }
                    elseif ($row['Customer'] != "" && $row['status'] == "New") {

                         $sqlso =" SELECT CustomerName FROM customer WHERE 1=1 AND UserId = " .$row['Customer'];
                        $resultso=mysqli_query($con,$sqlso); 
                        while($rowso = $resultso->fetch_assoc()){ 
                          $rowso['CustomerName'] = rtrim($rowso['CustomerName'],",");

                          print '<td class="hide_right"><span style="color: blue;">'.$rowso['CustomerName'].'</span></td>';
                          print '<td></td>';                          
                        
                        }
                      }                     

                      else
                      {

                        if ($row['status'] == "Delete") {
                        $sqlssA = " SELECT CustomerName FROM customer WHERE 1=1 AND UserId = " .$row['OCustomer']; 
                         $resultssA=mysqli_query($con,$sqlssA);  
                      while($rowssA = $resultssA->fetch_assoc()){ 
                         $cussA =$rowssA['CustomerName'];
                         $cussA = rtrim($rowssA['CustomerName'],",");
                        }                              
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$cussA.'</span></td>';
                          print '<td></td>';
                          
                        }
                

                      }     


                       //..............................//  
                      if ($row['BrandName'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['OBrandName'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['BrandName'].'</span></td>';
                      }
                      elseif ($row['BrandName'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['BrandName'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['OBrandName'].'</span></td>';
                          print '<td></td>';
                        }

                      }   
                                          
                       //..............................//                   
                      if ($row['Commodity'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['OCommodity'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['Commodity'].'</span></td>';
                      }
                      elseif ($row['Commodity'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['Commodity'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['OCommodity'].'</span></td>';
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
                         
                      if ($row['Remark_Item'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['ORemark_Item'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['Remark_Item'].'</span></td>';
                      }
                      elseif ($row['Remark_Item'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['Remark_Item'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      elseif ($row['Remark_Item'] == "" && $row['status'] == "Update") {
                          print '<td ></td>';
                          print '<td></td>';
                      }  
                      elseif ($row['Remark_Item'] == "" && $row['status'] == "New") {
                          print '<td ></td>';
                          print '<td></td>';
                      }                       
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['ORemark_Item'].'</span></td>';
                          print '<td></td>';
                        }

                      }    
                      //..............................//                     
                                         
                         if ($row['Delivery_date'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['ODelivery_date'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['Delivery_date'].'</span></td>';
                      }
                      elseif ($row['Delivery_date'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['Delivery_date'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['ODelivery_date'].'</span></td>';
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
                            if ($row['Location'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['OLocation'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['Location'].'</span></td>';
                      }
                      elseif ($row['Location'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['Location'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['OLocation'].'</span></td>';
                          print '<td></td>';
                        }

                      }                   
                
                  
                        
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