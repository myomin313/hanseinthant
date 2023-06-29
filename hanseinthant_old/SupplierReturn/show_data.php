<?php
$sidLast = 0;
while($row = mysqli_fetch_array($result)){
                 
    $row['SupplierName'] = rtrim($row['SupplierName'],",");
    print '<tr class="clsrow" id="'.$row['num'].'">';
    print '<td class="clsSerial">' . $sno . '</td>';
    print '<td align="center" class="checkss"><input name="users[]" type="checkbox" class="checkboxes" value=' . $row['PL'] . ' ></td>';                
    $message="Edit";
    print '<td  class="actions"><a href="detail.php?Supplier='.$row['sSupplier'].'&PL='.$row['PL'].'&Branch='.$row['Branch'].'" style="text-decoration: none;
    padding: 2px 5px;
    background: #2E8B57;
    color: white;
    border-radius: 3px;">' . $message . '</a></td>';                
    print '<td  >' . $row['Return_date'] . '</td>';  
    $row['SupplierName'] = rtrim($row['SupplierName'],","); 
    print '<td  >' . $row['SupplierName'] . '</td>';  
    print '<td  >' . $row['PL'] . '</td>'; 
    print '<td  style="word-wrap:break-word;">' . $row['sbrandname'] . '</td>'; 
    print '<td >' . $row['scommodity'] . '</td>';
    print '<td>' . $row['Qty'] . '</td>';
    print '<td>' . $row['type'] . '</td>';
    print '<td style="font-weight:normal;word-break: break-all;">' . $row['Remark_item'] . '</td>';
            
    print '</tr>';

    $sno ++;
    $sidLast = $sno;

  }  
  print "<input type='hidden' class='hidLastPID' value='".$sidLast."' />";
?>