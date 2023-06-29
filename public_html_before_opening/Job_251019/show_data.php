<?php
 $sidLast = 0;
 
 while($row = mysqli_fetch_array($result)){
             

  $row['CustomerName'] = rtrim($row['CustomerName'],",");
  print '<tr class="clsrow" id="'.$row['num'].'">';
  print '<td class="clsSerial">' . $sno . '</td>';
   print '<td align="center"  class="checkss"><input name="users[]" type="checkbox" class="checkboxes" value=' . $row['Job_No'] . ' ></td>';              
  $message="Edit";
  print '<td  class="actions"><a href="detail.php?Customer='.$row['jCustomer'].'&JOB_NO='.$row['Job_No'].'&Branch=' . $row['Location'] . '" style="text-decoration: none;
  padding: 2px 5px;
  background: #2E8B57;
  color: white;
  border-radius: 3px;">' . $message . '</a></td>'; 
  if ($row['PL'] <> '') {
  print '<td  >' . $row['Job_No'] . '</td>';
  print '<td  >' . $row['Job_date'] . '</td>';
   print '<td  >' . $row['Location'] . '</td>'; 
  $row['CustomerName'] = rtrim($row['CustomerName'],","); 
  print '<td  >' . $row['CustomerName'] . '</td>';  

  print '<td  style="word-wrap:break-word;">' . $row['BrandName'] . '</td>'; 
  print '<td >' . $row['Commodity'] . '</td>';

  print '<td style="width:4%;" >' . $row['WIP'] . '</td>';
  print '<td style="width:4%;background: #ffeb99;" >' . $row['balanceWIP'] . '</td>';
  print '<td style="width:4%;">' . $row['Type'] . '</td>';
  $row['Remarks_Item'] = rtrim($row['Remarks_Item'],",");
  print '<td class="remark" style="word-break: break-all;">' . $row['Remarks_Item'] . '</td>';
  print '<td style="" >' . $row['PL'] . '</td>';
  }

  else{
  print '<td  style="background:#ff9999;">' . $row['Job_No'] . '</td>';
  print '<td  style="background:#ff9999;">' . $row['Job_date'] . '</td>';
   print '<td  style="background:#ff9999;">' . $row['Location'] . '</td>'; 
  $row['CustomerName'] = rtrim($row['CustomerName'],","); 
  print '<td  style="background:#ff9999;">' . $row['CustomerName'] . '</td>';  

  print '<td  style="word-wrap:break-word;background:#ff9999;">' . $row['BrandName'] . '</td>'; 
  print '<td style="background:#ff9999;">' . $row['Commodity'] . '</td>';
  print '<td style="width:4%;background:#ff9999;" >' . $row['WIP'] . '</td>';
  print '<td style="width:4%;background: #ff9999;" >' . $row['balanceWIP'] . '</td>';
  print '<td style="width:4%;background:#ff9999;">' . $row['Type'] . '</td>';
  $row['Remarks_Item'] = rtrim($row['Remarks_Item'],",");
  print '<td class="remark" style="word-break: break-all;background:#ff9999;">' . $row['Remarks_Item'] . '</td>';
  print '<td style="background:#ff9999;" >' . $row['PL'] . '</td>';                
  }

               
  print '</tr>';

  $sno ++;
  $sidLast = $sno;

}  
  print "<input type='hidden' class='hidLastPID' value='".$sidLast."' />";
?>