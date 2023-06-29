<?php
 $sidLast = 0;
 while($row = mysqli_fetch_array($result)){
    $row['sSupplierName'] = rtrim($row['sSupplierName'],",");
    print '<tr class="clsrow" id="'.$row['num'].'">';
 
    print '<td class="clsSerial">' . $sno . '</td>'; 
    print '<td align="center" class="checkss"><input name="users[]" type="checkbox" class="checkboxes" value=' . $row['Purchase_order_No'] . ' ></td>';
    $message="Edit";
    print '<td  class="actions"><a href="detail.php?SupplierID=' . $row['SupplierName'] . '&PL=' . urlencode($row['Purchase_order_No']). '" style="text-decoration: none;
    padding: 2px 5px;
    background: #2E8B57;
    color: white;
    border-radius: 3px;">' . $message . '</a></td>'; 
    print '<td  >' . $row['Packing_date'] . '</td>';  
    //print '<td  >' . $row['SupplierName'] . '</td>';  
    print '<td  >' . $row['sSupplierName'] . '</td>';   
    print '<td  >' . $row['Branch'] . '</td>';  
    print '<td  style="word-break: break-all;width:100px;" >' . $row['pbrandname'] . '</td>'; 
    print '<td style="word-break: break-all;width:100px;" >' . $row['ccommodity'] . '</td>';
    print '<td style="width:5px;">' . $row['Type'] . '</td>';
    print '<td>' . $row['Qty'] . '</td>';
    print '<td style="width:5px;background-color: #ffeb99;">' . $row['balanceWIP'] . '</td>';
    print '<td style="width:5px;background-color: #ffeb99;">' . $row['balanceDelivery'] . '</td>';
    print '<td style="width:5px;background-color: #ffeb99;">' . $row['balanceReturn'] . '</td>';

    if ($row['balanceQty'] < $row['Qty'] and $row['balanceQty'] > 0 ) {
      print '<td style="width:5px;background-color: #98b2e6;">' . $row['balanceQty']  . '</td>';
    }
    elseif ($row['balanceQty'] == $row['Qty']) {
      print '<td style="width:5px;background-color: #8cd9b3;">' . $row['balanceQty'] . '</td>';
    }
    elseif ($row['balanceQty'] < $row['Qty'] and $row['balanceQty'] < 0) {
      print '<td style="width:5px;background-color:#ff6666;">' . $row['balanceQty'] . '</td>';
    }              
    else{
      print '<td style="width:5px;background-color: #ff9999;">' . $row['balanceQty'] . '</td>';
    }
    print'<td style=" background-color: #4287f5;color:white;">' . $row['currentQty'] . '</td>';
              
    print '<td style="word-break: break-all; ">' . $row['Remarks_Item'] . '</td>';
      if ($Authority == 'Accountant') {
    print '<td>' . $row['Rate_Name'].'&nbsp(' . $row['totalRate'].')</td>';
    print '<td>' . $row['totalUSD'].'</td>';
    print '<td>' . $row['balanceUSD'].'</td>';

  }

    print '<td >' . $row['Purchase_order_No'] . '</td>';
    print '<td style="word-break: break-all;width:40px; ">' . $row['PO_NO'] . '</td>';                      
    print '</tr>';
    $sno ++;
    $sidLast = $sno;
}
  print "<input type='hidden' class='hidLastPID' value='".$sidLast."' />";
?>