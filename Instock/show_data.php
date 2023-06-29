<?php
    $sidLast = 0;
    $TotalUSD = 0; 
    $TotalBalance = 0;
    $minus = 0; 
    $balanceUSD = 0;
    $balancequantity = 0;
    $wip = 0;
    $LastdQty = 0;
    $balanceQty = 0;
    $balanceQtys = 0;
    $currentQty = 0;
    $currentQtys = 0;          
    $balancetotalUSD = 0;
    $LasttoutQty = 0;
    
    
  
    while($row = mysqli_fetch_array($result)){
        
    // echo 'pQty-'.$row['pQty'].'<br>';
    // echo 'LastWIP-'.$row['LastWIP'].'<br>';
    // echo 'LasttoutQty-'.$row['LasttoutQty'].'<br>';
    // echo 'returnrrQty-'.$row['returnrrQty'].'<br>';
    // echo 'LastdQty-'.$row['LastdQty'].'<br>';
    // echo 'currentcQty-'.$row['currentcQty'].'<br>';
    // echo 'balanceDelivery-'.$row['balanceDelivery'].'<br>';
    //  echo 'titQty-'.$row['titQty'];
    // exit();
  
        print '<tr class="clsrow" id="'.$row['num'].'">';
        print '<td  >' . $sno . '</td>'; 
        print '<td  >' . $row['branch_name'] . '</td>'; 
        print '<td  >' . $row['pbrand'] . '</td>';  
        print '<td  >' . $row['pCommodity'] . '</td>';
        print '<td  >' . $row['code_no'] . '</td>';    
        print '<td  >' . $row['pQty'] . '</td>';
        print '<td  >' . $row['LasttoutQty'] . '</td>';
        print '<td  >' . $row['titQty'] . '</td>';
        $p=$row['pQty'];
        $wip=$row['wip'];
        $LastdQty=$row['LastdQty'];
        
        $balanceQty=$row['balancecQty'];
        $currentQty=$row['currentcQty'];

        $r=$row['rQty'];
        
        echo '<td >'.$wip.'</td>';

        print '<td >' . $LastdQty . '</td>';
        print '<td >' . $row['returnrrQty'] . '</td>';
        echo '<td style="">'.$row['pRemarks'].''.$row['jRemarks'].''.$row['dRemarks'].''.$row['rRemarks'].'</td>';
        echo '<td style="">'.$balanceQty.'</td>';
        $balanceQtys +=  $balanceQty;
        echo '<td style="">'.$currentQty.'</td>';
        $currentQtys +=  $currentQty;

        if ($Authority == 'Accountant') {          
        print '<td  style="width:7%;" >' . $row['proUSD'] . '&nbsp&nbsp$</td>';
        $TotalUSD +=  $row['proUSD'];
        $totalbalance = ($row['balancetotalUSD'] + $row['tRate']) - $row['rRate'];
        print '<td >' . $totalbalance   . '&nbsp&nbsp$</td>';
        $TotalBalance +=  $totalbalance;
        $balance =$row['proUSD'] - $totalbalance ;
        $minus +=  $balance; 
        print '<td  >' . $balance . '&nbsp&nbsp$</td>';

        }

        print '</tr>';
        $sno ++;
        $sidLast = $sno;

      }

         $_SESSION["InStock_balanceQtys"] = $balanceQtys + $_SESSION["InStock_balanceQtys"];
         $_SESSION["InStock_currentQtys"] = $currentQtys + $_SESSION["InStock_currentQtys"];
         $_SESSION["InStock_TotalBalance"] = $TotalBalance + $_SESSION["InStock_TotalBalance"];
         $_SESSION["InStock_minus"] = $minus + $_SESSION["InStock_minus"] ;
      
      if($sidLast >= $_SESSION["InStock_DataCnt"]){
        print '<tr>';
        if ($Authority == 'Accountant') {
         print '<th colspan="12" style="background:#ffff66;color:black;">Total USD</th>';
         print '<td  style="background:#ffff66;">' . $_SESSION["InStock_balanceQtys"] . '</td>';
         print '<td  style="background:#ffff66;">' . $_SESSION["InStock_currentQtys"]  . '</td>';             
         print' <td style="background:#ffff66;">';
         
      $sqls="SELECT SUM(totalUSD)
             From product             
             Where 1=1 ";
      if ($Branches != 1) {
        $sqls=" AND Branch='$Branches' ";
      }


      // if ($keyword <> '') {
      //  $keyword = $keyword; 
      //  $sqls =$sqls." AND  BrandName LIKE '%$keyword%'OR product.Commodity LIKE '%$keyword%'OR product.branch LIKE '%$keyword%'";
      //  }  

       if(isset($_GET['search_branch'])  && $_GET['search_branch'] != ''){
        $search_branch=$_GET['search_branch'];
        $sqls =$sqls." AND product.Branch='$search_branch'";
      }
      if(isset($_GET['search_BrandName']) && $_GET['search_BrandName'] != ''){
        $BrandName=$_GET['search_BrandName'];
        $sqls =$sqls." AND product.BrandName='$BrandName'";
      }
      if(isset($_GET['search_Commodity']) && $_GET['search_Commodity'] != ''){
        $commodity=$_GET['search_Commodity'];
        $sqls =$sqls." AND product.Commodity='$commodity'";
      }
      if(isset($_GET['search_code']) && $_GET['search_code'] != ''){
        $code=$_GET['search_code'];
        $sqls =$sqls." AND product.code='$code'";
      }
                    
      //  if ($namelist <> ''){
      //   $sqls =$sqls." AND  BrandName= '".$namelist."'OR product.Commodity= '".$namelist."'OR product.branch= '".$namelist."'";
      //    }                    
             $result = $con->query($sqls);
                while($row=$result->fetch_assoc())
                {
                $g=$row['SUM(totalUSD)'];             
                if ($Authority == 'Accountant') {
                  
                  echo '<span>'.$g.' &nbsp&nbsp$</span>';
                }
                
                }     
        print' </td>'; 

        print '<td  style="background:#ffff66;">' . $_SESSION["InStock_TotalBalance"] . '&nbsp&nbsp$</td>';
        print '<td  style="background:#ffff66;">' . $_SESSION["InStock_minus"] . '&nbsp&nbsp$</td>';   

       }          

        print '</tr>'; 
      }

      print "<input type='hidden' class='hidLastPID' value='".$sidLast."' />";
    //   mysqli_close($con);
?>
 <!--<ul class="pagination">-->
 <!--       <li><a href="?pageno=1">First</a></li>-->
 <!--       <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">-->
 <!--           <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>-->
 <!--       </li>-->
 <!--       <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">-->
 <!--           <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>-->
 <!--       </li>-->
 <!--       <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>-->
 <!--   </ul>-->