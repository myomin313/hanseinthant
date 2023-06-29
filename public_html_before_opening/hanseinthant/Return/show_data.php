<?php
$sidLast = 0;

while($row = mysqli_fetch_array( $result)){

    $row['CustomerName'] = rtrim($row['CustomerName'],",");
    print '<tr class="clsrow" id="'.$row['num'].'">';
    print '<td class="clsSerial">' . $sno . '</td>';
    print '<td align="center" class="checkss"><input name="users[]" type="checkbox" class="checkboxes" value=' . $row['DO_No'] . ' ></td>';                
    $message="Edit";
    print '<td  class="actions"><a href="detail.php?Customer='.$row['rCustomer'].'&Return_no='.$row['Return_no'].'&DO_No='.$row['DO_No'].'" style="text-decoration: none;
    padding: 2px 5px;
    background: #2E8B57;
    color: white;
    border-radius: 3px;">' . $message . '</a></td>';               
    print '<td  >' . $row['Return_date'] . '</td>';
    print '<td  >' . $row['Return_no'] . '</td>';  
    print '<td  >' . $row['department'] . '</td>';
    $row['CustomerName'] = rtrim($row['CustomerName'],","); 
    print '<td  >' . $row['CustomerName'] . '</td>';  
    print '<td  >' . $row['DO_No'] . '</td>';    
    print '<td  style="word-wrap:break-word;">' . $row['BrandName'] . '</td>'; 
    print '<td >' . $row['Commodity'] . '</td>';
    print '<td>' . $row['Qty'] . '</td>';
    print '<td>' . $row['Type'] . '</td>';
    print '<td style="font-weight:normal;word-break: break-all;">' . $row['Remarks_item'] . '</td>';
            
    print '</tr>';

    $sno ++;
    $sidLast = $sno;

}  
  print "<input type='hidden' class='hidLastPID' value='".$sidLast."' />";
?>