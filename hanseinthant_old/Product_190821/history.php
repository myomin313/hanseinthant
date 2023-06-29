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

  <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="utf-8">
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
          <h2>History Of Input List</h2>
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
<input type="submit" name="history" id="history" onClick="setDeleteAction();" value="Delete" class="deleteitem" style="margin-left:3%;font-size: 11px;">
<form  name="approve" method="post" action=""> 
          <table style="margin-top: 20px;margin-bottom: 20px;border-collapse: collapse;width: auto;" id="emp_table" border="0" >
              <tr class="tr_header" style="background-color:#3385ff;font-family:Tahoma, Geneva, sans-serif;font-size: 13px;">
                <?php 
                  if (isset($_POST['users'])) {
                    $rowCount = count($_POST['users']);
                  }
                  else{
                    $rowCount = 0;
                  }
                  
                  $sqls="SELECT *,SupplierName,OSupplierName
                   FROM product_history 
                    WHERE 1=1 ";
                  if ($rowCount > 0) {
                    for($i=0;$i<$rowCount;$i++) {
                      $history= $_POST["users"][$i];
                      if ( $history <> '' && $i<=0){
                        $sqls =$sqls." AND Purchase_order_No='" . $_POST["users"][$i] . "'";
                        $result=mysqli_query($con,$sqls);  
                        $count_history=mysqli_num_rows($result); 
                        if ($count_history == 0) {
                          echo "<h3>No history list</h3>";
                        }
                      }
                      elseif ( $history <> '' || $i>0){
                        $sqls =$sqls." OR Purchase_order_No='" . $_POST["users"][$i] . "'";
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
                          <th colspan="2">Date</th>
                          <th colspan="2">SupplierName</th>                  
                          
                          <th colspan="2">BrandName</th>
                          <th colspan="2">Commodity</th>
                          <th colspan="2">Qty</th>
                          <th colspan="2">Type</th>
                          <th colspan="2">Rate Name</th>
                          <th colspan="2">Rate</th>
                          <th colspan="2">Total</th>                                            
                          <th colspan="2">PL NO</th>
                          <th colspan="2">PO NO</th>
                          <th colspan="2">Remarks_Item</th>

                           ';
                    print'</tr>';
                    print' </thead>';
                    print'<tbody>';
            
                    while($row = $results->fetch_assoc()){  
                      $i+=1;
                     
                      print '<tr style="border-bottom: 0px solid;font-size: 9px;">';
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
                      
                        
                      if ($row['Packing_date'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['OPacking_date'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['Packing_date'].'</span></td>';
                      }
                      elseif ($row['Packing_date'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['Packing_date'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['OPacking_date'].'</span></td>';
                          print '<td></td>';
                        }

                      }   
                         //..............................//                       
                        if ($row['SupplierName'] != "" && $row['status'] == "Update") {
                       $sqlss = " SELECT SupplierName FROM supplier WHERE 1=1 AND UserId = " .$row['OSupplierName'];
                        $resultss=mysqli_query($con,$sqlss);  
                      while($rowss = $resultss->fetch_assoc()){ 
                         $supp =$rowss['SupplierName'];
                         $supp = rtrim($rowss['SupplierName'],",");
                        }                            
                            
                          print '<td><span style="">'.$supp.'</span></td>';

                        $sqlso =" SELECT SupplierName FROM supplier WHERE 1=1 AND UserId = " .$row['SupplierName'];
                        $resultso=mysqli_query($con,$sqlso); 
                        while($rowso = $resultso->fetch_assoc()){ 
                          $rowso['SupplierName'] = rtrim($rowso['SupplierName'],",");
                          print '<td><span style="color:  #00cc44;">'.$rowso['SupplierName'].'</span></td>';                        
                        
                        }
                      }
                    elseif ($row['SupplierName'] != "" && $row['status'] == "New") {

                        $sqlso =" SELECT SupplierName FROM supplier WHERE 1=1 AND UserId = " .$row['SupplierName'];
                        $resultso=mysqli_query($con,$sqlso); 
                        while($rowso = $resultso->fetch_assoc()){ 
                          $rowso['SupplierName'] = rtrim($rowso['SupplierName'],",");

                          print '<td class="hide_right"><span style="color: blue;">'.$rowso['SupplierName'].'</span></td>';
                          print '<td></td>';                          
                        
                        }
                      }                     

                      else
                      {

                        if ($row['status'] == "Delete") {
                        $sqlssA = " SELECT SupplierName FROM supplier WHERE 1=1 AND UserId = " .$row['OSupplierName'];
                        $resultssA=mysqli_query($con,$sqlssA);  
                      while($rowssA = $resultssA->fetch_assoc()){ 
                         $suppA =$rowssA['SupplierName'];
                         $suppA = rtrim($rowssA['SupplierName'],",");
                        }                            
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$suppA.'</span></td>';
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
                        
                        
                      if ($row['Rate_Name'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['ORate_Name'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['Rate_Name'].'</span></td>';
                      }
                      elseif ($row['Rate_Name'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['Rate_Name'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['ORate_Name'].'</span></td>';
                          print '<td></td>';
                        }

                      }   
                      
                      //..............................//   
                                          
                        
                      if ($row['rate'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['Orate'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['rate'].'</span></td>';
                      }
                      elseif ($row['rate'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['rate'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['Orate'].'</span></td>';
                          print '<td></td>';
                        }

                      }   
                      
                      //..............................//   
                                          
                        
                      if ($row['totalRate'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['OtotalRate'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['totalRate'].'</span></td>';
                      }
                      elseif ($row['totalRate'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['totalRate'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['OtotalRate'].'</span></td>';
                          print '<td></td>';
                        }

                      }   
                      


                      //..............................//   
                        
                      if ($row['Purchase_order_No'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['OPurchase_order_No'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['Purchase_order_No'].'</span></td>';
                      }
                      elseif ($row['Purchase_order_No'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['Purchase_order_No'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['OPurchase_order_No'].'</span></td>';
                          print '<td></td>';
                        }

                      }   
                      
                       //..............................//   

                        
                      if ($row['PO_NO'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['OPO_NO'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['PO_NO'].'</span></td>';
                      }
                      elseif ($row['PO_NO'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['PO_NO'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      elseif ($row['PO_NO'] == "" && $row['status'] == "Update") {
                          print '<td></td>';
                          print '<td></td>';
                      }  
                      elseif ($row['PO_NO'] == "" && $row['status'] == "New") {
                          print '<td></td>';
                          print '<td></td>';
                      }                      
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['OPO_NO'].'</span></td>';
                          print '<td></td>';
                        }

                      }   
                      
                      //..............................//   
                        
                      if ($row['Remarks_Item'] != "" && $row['status'] == "Update") {
                        print '<td>'.$row['ORemarks_Item'].'</td>';
                        print '<td><span style="color: #00cc44;">'.$row['Remarks_Item'].'</span></td>';
                      }
                      elseif ($row['Remarks_Item'] != "" && $row['status'] == "New") {
                          print '<td class="hide_right"><span style="color: blue;">'.$row['Remarks_Item'].'</span></td>';
                          print '<td></td>';
                      }                    
                      
                      elseif ($row['Remarks_Item'] == "" && $row['status'] == "Update") {
                          print '<td ></td>';
                          print '<td></td>';
                      }  
                      elseif ($row['Remarks_Item'] == "" && $row['status'] == "New") {
                          print '<td ></td>';
                          print '<td></td>';
                      }                        
                      else
                      {

                        if ($row['status'] == "Delete") {
                          print '<td class="hide_right"><span style="color: #ff0036;">'.$row['ORemarks_Item'].'</span></td>';
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