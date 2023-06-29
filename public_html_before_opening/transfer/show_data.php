<?php
 $sidLast = 0;
 while($row = mysqli_fetch_array($result)){

  print '<tr class="clsrow" id="'.$row['num'].'">';
  print '<td class="clsSerial">' . $sno . '</td>';
  print '<td align="center" class="checkss"><input name="users[]" type="checkbox" class="checkboxes" value=' . $row['transfer_no'] . ' ></td>';     

   $message="Edit";
   print '<td  class="actions"><a href="detail.php?transfer_no=' . $row['transfer_no'] . ' " style="text-decoration: none;
   padding: 2px 5px;
   background: #2E8B57;
   color: white;
   border-radius: 3px;">' . $message . '</a></td>';                 
   print '<td>' . $row['transfer_date'] . '</td>'; 
   $IDs=$row['tid'];
   $BrandNamei=$row['BrandName'] ;
   $transfer_date=$row['transfer_date'] ;
   $id=$row['tid'] ;

   print'<input type="hidden" value="' . $row['BrandName'] . '" id="callid">';

//      for( $i=0; $i < $sum ; $i++){

    print'<input type="hidden" value="' . $transfer_date. '" id="transfer_date'.$id.'">';
     print'<input type="hidden" value="' . $row['transfer_no']. '" id="do'.$id.'">';
//   }

   print'<td >' . $row['transfer_no'] . '</td>';
   $BrandName=$row['BrandName'];
   print'<ul id="printlist" ></ul>';
   print '<td>' . $row['branch_from'] . '</a></td>';
   print '<td>' . $row['branch_to'] . '</a></td>';
   print '<td>' . $row['code_no'] . '<br></td>';                
   print '<td>' . $row['BrandName'] . '</a></td>'; 
   print '<td>' . $row['Commodity'] . '<br></td>';                          
   print '<td style="background: #f2f2f2;"  >' . $row['Qty'] . '</td>';    

   
   print '<td style="">' . $row['Type'] . '</td>';
   print '<td style="font-weight:normal; word-break: break-all;" class="remark">' . $row['remark'] . '</td>';
    if ($Authority == 'Accountant') {          
    print '<td style"background: #f2f2f2;" >' . $row['transferUSD'] . '</td>';
        }
   print '<td>' . $row['PL'] . '</td>';
      print '<td>' . $row['ptransfer_no'] . '</td>';  
   print '</tr>';

   $sno ++;
   $sidLast = $sno;

 }  
  print "<input type='hidden' class='hidLastPID' value='".$sidLast."' />";
?>