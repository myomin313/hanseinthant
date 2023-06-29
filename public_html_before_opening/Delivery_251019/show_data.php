<?php
 $sidLast = 0;
 while($row = mysqli_fetch_array($result)){

  print '<tr class="clsrow" id="'.$row['num'].'">';
  print '<td class="clsSerial">' . $sno . '</td>';
  print '<td align="center" class="checkss"><input name="users[]" type="checkbox" class="checkboxes" value=' . $row['DO_No'] . ' ></td>';     

   $message="Edit";
   print '<td  class="actions"><a href="detail.php?ID=' . $row['cid'] . ' && DO=' . $row['DO_No'] . ' " style="text-decoration: none;
   padding: 2px 5px;
   background: #2E8B57;
   color: white;
   border-radius: 3px;">' . $message . '</a></td>';                 
   print '<td>' . $row['Delivery_date'] . '</td>'; 
   $IDs=$row['cid'];
   $BrandNamei=$row['BrandName'] ;
   $Delivery_date=$row['Delivery_date'] ;
   $id=$row['id'] ;

   print'<input type="hidden" value="' . $row['BrandName'] . '" id="callid">';

     for( $i=0; $i < $sum ; $i++){

    print'<input type="hidden" value="' . $Delivery_date. '" id="Delivery_date'.$id.'">';
     print'<input type="hidden" value="' . $row['DO_No']. '" id="do'.$id.'">';
  }

   print'<td ><a href="javascript:;" style="color:red;" onclick="printContent(' . $row['cid'] . ','.$id.');" >' . $row['DO_No'] . '</a></td>';
   $BrandName=$row['BrandName'];
   print'<ul id="printlist" ></ul>';
   print '<td >' . $row['jJob'] . '</td>';
   $row['Customers'] = rtrim($row['Customers'],",");
   print '<td>' . $row['Location'] . '</a></td>';
   print '<td>' . $row['Customers'] . '</td>';              
   print '<td>' . $row['BrandName'] . '</a></td>'; 
   print '<td >' . $row['Commodity'] . '<br></td>';                             
   print '<td style="background: #f2f2f2;"  >' . $row['Qty'] . '</td>';
   if ($row['rQty'] <>'') {
     print '<td style="background: #ffeb99;"  >' . $row['rQty'] . '</td>';
   }else{
     print '<td >' . $row['rQty'] . '</td>';
   }
   
   print '<td style="">' . $row['Type'] . '</td>';
   print '<td style="font-weight:normal; word-break: break-all;" class="remark">' . $row['remark'] . '</td>';
   print '<td>' . $row['PL'] . '</td>';                          
   print '</tr>';

   $sno ++;
   $sidLast = $sno;

 }  
  print "<input type='hidden' class='hidLastPID' value='".$sidLast."' />";
?>