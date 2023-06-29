<?php session_start();?>
<?php 
      if (($_SESSION['login_session']<> true)) {
        header("Location:../index.php");    
        exit();
      }     

?>
<?php 
      include_once('../config.php');
      include_once('../bardetail.php');
      include_once('../style.css');
      include_once('../header.php');
 
 ?> 
 <?php if (isset($_SESSION['message'])): ?>
  <div class="msg">
    <?php 
      echo $_SESSION['message']; 
      unset($_SESSION['message']);
    ?>
  </div>
<?php endif ?>
 <?php if (isset($_SESSION['err'])): ?>
  <div class="err">
    <?php 
      echo $_SESSION['err']; 
      unset($_SESSION['err']);
    ?>
  </div>
<?php endif ?>

 <?php if (isset($_SESSION['tt'])): ?>
  <div class="err">
    <?php 
      echo $_SESSION['tt']; 
      unset($_SESSION['tt']);
    ?>
  </div>
<?php endif ?>
    <?php
      $actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    ?>  

        <script>
          function out(id) {

               var  Qty = Number(document.getElementById('Qty'+id).value);
                     var  rate = Number(document.getElementById('rate'+id).value);
               var totalRate = (Qty * rate);
               document.getElementById('totalRate'+id).value =totalRate.toFixed(0);;

        }

          function calculate(x) {

               var  itemQty = Number(document.getElementById('itemQty'+x).value);
               var  itemrate = Number(document.getElementById('itemrate'+x).value);
               var totalRates = (itemQty * itemrate);
               document.getElementById('totalRates'+x).value =totalRates.toFixed(0);;

        }        
      function myDestory(id)
      {
        var r = confirm("Are you sure you want to delete this record?");
        if(r == true)
        {
          window.location.assign("delete.php?id=" + id);
        }
      }

      $(document).ready(function() {
        var max_fields      = 100;
        var wrapper         = $(".insert");
        var news         = $(".news");
        var next         = $(".next");
        var new_button      = $(".add_new_field");  
        var x = 1;

        $(new_button).click(function(e){
          e.preventDefault();
          if(x < max_fields){
            x++;
            $(news).append('<div><br><input type="text" name="itemBrandName[]" id="itemBrandName'+x+'" style="width:20%;height:30px;border: #1aa3ff 1px solid;" />&nbsp&nbsp<input type="text" name="itemCommodity[]" id="itemCommodity'+x+'" style="width:15%;height:30px;border: #1aa3ff 1px solid;" />&nbsp<select name="itemType[]" id="itemType'+x+'"  style="width:4%;height:30px;border: #1aa3ff 1px solid;"><option value=""></option><option value="Set">Set</option><option value="No">No</option><option value="Lot">Lot</option><option value="ft">ft</option><option value="mtrs">mtrs</option><option value="Coils">Coils</option><option value="kg">kg</option><option value="Yard">Yard</option></select>&nbsp&nbsp<select name="Rate_Names[]" id="Rate_Names'+x+'"  style="width:7%;height:30px;border: #1aa3ff 1px solid;"><option value=""></option><option value="USD">USD</option><option value="Myanmar">Myanmar</option><option value="Singapore">Singapore</option><option value="Europe">Europe</option><option value="Thailand">Thailand</option><option value="British">British</option><option value="Japan">Japan</option><option value="Australia">Australia</option></select>&nbsp&nbsp<input type="text" name="itemrate[]" id="itemrate'+x+'" style="width:6%;height:30px;border: #1aa3ff 1px solid;" onkeyup="calculate('+x+')" placeholder="1 item/per Rate">&nbsp&nbsp<input type="number" name="itemQty[]" id="itemQty'+x+'" style="width:4%;height:30px;border: #1aa3ff 1px solid;font-size:10px;"  onkeyup="calculate('+x+')" placeholder="Qty"/>&nbsp&nbsp<input type="text" name="totalRates[]" id="totalRates'+x+'" style="width:6%;height:30px;border: #1aa3ff 1px solid;" onkeyup="calculate('+x+')">&nbsp&nbsp<input type="text" name="itemRemarks_Item[]" id="itemRemarks_Item'+x+'" style="width:25%;height:30px;border: #1aa3ff 1px solid;" />&nbsp<input type="button" value="Submit" class="updateitem" onclick="save('+x+')"><input type="button" value="remove"  onclick="removeRow('+x+');" class="removeitem"></div>'); 
          }

          else
          {
            alert('You Reached the limits')
          }
        });

        $(news).on("click",".removeitem", function(e){
          e.preventDefault(); $(this).parent('div').remove(); x--;
        })
        $(news).on("click",".myDelete", function(e){
          e.preventDefault(); $(this).parent('div').remove(); x--;
        })
    
      });   
      
     function save(x)
    {
       var SupplierName= document.getElementById('SupplierName').value;
       var Branch= document.getElementById('Branch').value;
       var Packing_date= document.getElementById('Packing_date').value;
       var Purchase_order_No= document.getElementById('Purchase_order_No').value;
       var PO_NO= document.getElementById('PO_NO').value;
       var LUser= document.getElementById('LUser').value;
              
       var itemBrandName= document.getElementById('itemBrandName'+x).value;
       var itemCommodity= document.getElementById('itemCommodity'+x).value;
       var itemType= document.getElementById('itemType'+x).value;
       var Rate_Names= document.getElementById('Rate_Names'+x).value;
       var itemrate= document.getElementById('itemrate'+x).value;
       var itemQty= document.getElementById('itemQty'+x).value;
       var totalRates= document.getElementById('totalRates'+x).value;
       var itemRemarks_Item= document.getElementById('itemRemarks_Item'+x).value;
       
       window.location.href = "updatenew.php?SupplierName="+encodeURIComponent(SupplierName)+"&itemBrandName="+encodeURIComponent(itemBrandName)+"&Branch="+encodeURIComponent(Branch)+"&Packing_date="+encodeURIComponent(Packing_date)+"&Purchase_order_No="+encodeURIComponent(Purchase_order_No)+"&PO_NO="+encodeURIComponent(PO_NO)+"&itemBrandName="+encodeURIComponent(itemBrandName)+"&itemCommodity="+encodeURIComponent(itemCommodity)+"&itemType="+encodeURIComponent(itemType)+"&Rate_Names="+encodeURIComponent(Rate_Names)+"&itemrate="+encodeURIComponent(itemrate)+"&itemQty="+encodeURIComponent(itemQty)+"&totalRates="+encodeURIComponent(totalRates)+"&itemRemarks_Item="+encodeURIComponent(itemRemarks_Item)+"&LUser="+encodeURIComponent(LUser)+""; 
         // alert(Region);

    }
    </script>

 <body style="font-size: 11px; font-family:Tahoma, Geneva, sans-serif;">

      <?php 
        $SupplierID=$_GET['SupplierID'];
         
        $PL=$_GET['PL']; 
        print '<form method="POST" action="updates.php?SupplierID='.$SupplierID.'&PL='.$PL.'">';
        $_SESSION['page'] = "detail";        
      
        $total_sum = "SELECT count(*) as count_rows,BrandName FROM product WHERE Purchase_order_No='$PL'";
        $result1 = mysqli_query($con, $total_sum);
        while($rows = mysqli_fetch_array($result1)) {
          $sum = $rows['count_rows'];

        } 

        // $con->query("SET  group_concat_max_len = 100000000000000000000000000000");
        /* $setutf8c = "SET character_set_results = 'utf8', character_set_client =
        'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
        character_set_server = 'utf8'";
        $qc = $con->query($setutf8c);
        $setutf9 = "SET CHARACTER SET utf8";
        $q1 = $con->query($setutf9);
        $setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
        $q2 = $con->query($setutf7);*/
         $con->query("SET group_concat_max_len = 10000000000000000");
        $sql_item ="
         SELECT *,supplier.SupplierName as supplier,product.SupplierName as SupplierNameA,product.Creator as Creator,product.Branch as Branch,
            GROUP_CONCAT(Commodity SEPARATOR ',') AS Commodity,
            GROUP_CONCAT(BrandName SEPARATOR ',') AS BrandName,
            GROUP_CONCAT(Type SEPARATOR ',') AS Type,
            GROUP_CONCAT(Qty SEPARATOR ',') AS Qty,
            GROUP_CONCAT(Rate_Name SEPARATOR ',') AS Rate_Name,
            GROUP_CONCAT(rate SEPARATOR ',') AS rate,
            GROUP_CONCAT(totalRate SEPARATOR ',') AS totalRate,
            GROUP_CONCAT(Remarks_Item SEPARATOR ',') AS Remarks_Item,
            GROUP_CONCAT(id SEPARATOR ',') AS id
            FROM product
            LEFT JOIN supplier
            ON product.SupplierName =supplier.UserId
            WHERE  Purchase_order_No='$PL'"; 
        $result = mysqli_query($con, $sql_item);
      
        $item_array1 = '';
       print '<table style="width: 100%;margin-left:0%;margin-bottom:10%;" id="customers">';
      
        while($row = mysqli_fetch_array($result)) {
           $Commoditys= $row['Commodity']; 
           // $Commodity=htmlspecialchars($Commoditys, ENT_COMPAT);
           $Commodity=htmlspecialchars($Commoditys, ENT_QUOTES | ENT_SUBSTITUTE, 'utf-8');
            $Types= $row['Type']; 
            //$Type=htmlspecialchars($Types, ENT_COMPAT);
            $Type=htmlspecialchars($Types, ENT_QUOTES | ENT_SUBSTITUTE, 'utf-8');
            $Qty= $row['Qty']; 
            $Rate_Name= $row['Rate_Name'];         
            $rate= $row['rate']; 
            $totalRate= $row['totalRate'];
            $id= $row['id'];
            $BrandNames= $row['BrandName']; 
            //$BrandName=htmlspecialchars($BrandNames, ENT_COMPAT);
            $BrandName=htmlspecialchars($BrandNames, ENT_QUOTES | ENT_SUBSTITUTE, 'utf-8');
            $Remarks_Items= $row['Remarks_Item'];
            //$Remarks_Item=htmlspecialchars($Remarks_Items, ENT_COMPAT);
            $Remarks_Item=htmlspecialchars($Remarks_Items, ENT_QUOTES | ENT_SUBSTITUTE, 'utf-8');
            $SupplierNameA= $row['SupplierNameA'];
            $Branch= $row['Branch']; 
            $Packing_date= $row['Packing_date'];  
            $row['supplier'] = rtrim($row['supplier'],",");
            $supplier= $row['supplier'];

                  // print'<tr><td style="background:#3385ff;color:white;"><p style="margin-left:10px;"><a href="list.php?namelist=&year=&month=&day=" style="font-size:13px;color:white;"><span class="arrow arrow-left"></span><span class="arrow arrow-left"></span>Back</a></p></td><td style="background:#3385ff;color:white;text-align:center;">To edit Input Product
                  //   </td></tr>';
                  // print '<tr><td>Creator </td><td style="color:blue;">' . $row['Creator']. '</td></tr>';
                  // print '<tr><td>Create Time </td><td style="color:blue;">' . $row['CreateTime']. '</td></tr>';

                  print '<input type="hidden" name="hidID" value="' . $row['id']. '"';
                  print'<tr><td style="width:7%;">Supplier Name</td><td>
                   <select name="SupplierName" id="SupplierName" style="width:20%;height:30px;font-size: 10px;background:#f2f2f2;" readonly="readonly">';
                  print'<option value ="'.$SupplierNameA.'" style="width:20%;height:30px;">'.$supplier.'</option>';
                         // $sqlp="SELECT * FROM supplier";
                         //  $resResultp = $con->query($sqlp);
                         //  while ($rowp=mysqli_fetch_array($resResultp)) {
                         //  $rowp['SupplierName'] = rtrim($rowp['SupplierName'],",");
                         //  $SupplierNames = $rowp["SupplierName"];
                         //  $UserId = $rowp["UserId"];

                         //    if ($SupplierNames == $supplier ) {
                              
                         //    }
                         //    else{
                         //       print '<option value='.$UserId.'>'.$SupplierNames.'</option>';
                         //    }                           
    
                         // }

                           print'</select></td></tr>';  

                           print '<tr><td>Branch</td><td> 
                           <select name="Branch" id="Branch" style="width:20%;height:30px;font-size: 10px;background:#f2f2f2;" readonly="readonly">
                           <option value="' . $row['Branch']. '">' . $row['Branch']. '</option>

                           </select>
                           </td></tr>';  

                           // <option value="Shwe Pyi Thar Store">Shwe Pyi Thar Store</option>
                           // <option value="Shwe Pyi Thar Store Control Panel">Shwe Pyi Thar Control Panel</option>
                           // <option value="Yangon Show Room">Yangon Show Room</option>
                           // <option value="Naypyidaw Show Room">Naypyidaw Show Room</option>
                           // <option value="Mandalay Show Room">Mandalay Show Room</option>                           

                            print '<tr><td>Input Date </td><td> <input type="date" required="required" name="Packing_date" id="Packing_date" value="' . $row['Packing_date']. '" style="width:20%;height:30px;background:#f2f2f2;font-size: 10px;" readonly="readonly"/></td></tr>';
                            print '<tr><td>PL NO</td><td> <input type="text" name="Purchase_order_No" id="Purchase_order_No" value="' . $row['Purchase_order_No']. '" style="width:20%;height:30px;background:#f2f2f2;font-size: 10px;" readonly="readonly"/></td></tr>';                        
                            print '<tr><td>PO NO </td><td> <input  type="text" name="PO_NO" id="PO_NO" value="' . $row['PO_NO']. '" style="width:20%;height:30px;background:#f2f2f2;" readonly="readonly"/></td></tr>';    
            
                           $LUser = $_SESSION['login_user'];
                           print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';  
            print '<tr><td>Commodity</td><td class="insert">';
            print'<input type="button" value="New Commodity" class="add_new_field myAdd" /><div class="news"></div>';

            print'<br>'; 
            print'<br>';                        
        }
         
        // Disapper Comma
        $BrandName = explode(',', $BrandName);
        $Commodity = explode(',', $Commodity);
        $Type = explode(',', $Type);
        $Rate_Name = explode(',', $Rate_Name);
        $Qty = explode(',', $Qty);
        $rate = explode(',', $rate);
        $totalRate = explode(',', $totalRate);
        $Remarks_Item = explode(',', $Remarks_Item);
        $id = explode(',', $id);


        // Show Data According to no of Item

        for ($i=0; $i < $sum ; $i++) { 

          print'<input type="text" required="required" name="BrandName[]" id="BrandName'. $id[$i].'"  value="' . $BrandName[$i]. '"  style="width:20%;height:30px;background:#f2f2f2;" readonly/>';
          print '<input  type="text" name="Commodity[]" id="Commodity'. $id[$i].'" value="' . $Commodity[$i]. '" style="width:15%;height:30px;margin-left:10px;font-size: 10px;background:#f2f2f2;" placeholder="Commodity" readonly/>';

          print '&nbsp&nbsp<select name="Type[]" id="Type'. $id[$i].'" style="width:4%;height:30px;" >';
          print'<option style="width:200px;height:30px;font-size: 10px;background:#f2f2f2;">'.$Type[$i].'</option>';
           print'<option value="Set">Set</option><option value="No">No</option><option value="Lot">Lot</option><option value="ft">ft</option><option value="mtrs">mtrs</option><option value="Coils">Coils</option><option value="kg">kg</option><option value="Yard">Yard</option>';
            print'</select>';    


          print '&nbsp&nbsp<select name="Rate_Name[]" id="Rate_Name'. $id[$i].'" style="width:7%;height:30px;" >';
          print'<option style="width:200px;height:30px;font-size: 10px;">'.$Rate_Name[$i].'</option>';
           print'<option value="USD">USD</option><option value="Myanmar">Myanmar</option><option value="Singapore">Singapore</option><option value="Europe">Europe</option><option value="Thailand">Thailand</option><option value="British">British</option><option value="Japan">Japan</option><option value="Australia">Australia</option>';

          print'</select>';   
          print '&nbsp&nbsp<input type="text" name="rate[]" id="rate'. $id[$i].'" value="'. $rate[$i].'" style="width:6%;height:30px;font-size: 10px;" onkeyup="out('.$id[$i].')" />';   

          print '&nbsp&nbsp<input type="text" name="Qty[]" id="Qty'. $id[$i].'" value="'. $Qty[$i].'" style="width:4%;height:30px;font-size: 10px;" onkeyup="out('. $id[$i].')" />';                 

   
          print '&nbsp&nbsp<input type="text" name="totalRate[]" id="totalRate'. $id[$i].'" value="'. $totalRate[$i].'" style="width:6%;height:30px;font-size: 10px;" onkeyup="out('.$id[$i].')" />'; 

          
          print '&nbsp&nbsp<input  type="text" name="Remarks_Item[]" id="Remarks_Item'.$id[$i].'" value="' . $Remarks_Item[$i]. '" style="width:25%;height:30px;font-size: 10px;" />';                            
            print '<input type="hidden" name="id_no[]" value="'.$id[$i].'">';
            print'&nbsp<input type="button" name="update_ids" value="Update" class="updateitem" onclick="update(' . $id[$i] .')">
           &nbsp&nbsp<input type="button" name="Delete_ids" value="Delete" class="deleteitem" onclick="Delete(' . $id[$i] .')"><br><br>';                              
        }            
        
        // print '<tr><td><input type="submit" name="Update" value="Update" style="margin-left:2%"   class="saveitem"/></td><td><span  class="warn warning"></span><span style="color:#ff8566;">This Update is not for Commodity.</span></td></tr>';
        print '</table>';        

        print '</form>';
        print '</form>';
        
      /*  $con->query("SET group_concat_max_len = 10000000000000000");
          $sql_item ="
         SELECT *,supplier.SupplierName as supplier,product.SupplierName as SupplierNameA,product.Creator as Creator,product.Branch as Branch,
            GROUP_CONCAT(Commodity SEPARATOR ',') AS Commodity,
            GROUP_CONCAT(BrandName SEPARATOR ',') AS BrandName,
            GROUP_CONCAT(Type SEPARATOR ',') AS Type,
            GROUP_CONCAT(Qty SEPARATOR ',') AS Qty,
            GROUP_CONCAT(Rate_Name SEPARATOR ',') AS Rate_Name,
            GROUP_CONCAT(rate SEPARATOR ',') AS rate,
            GROUP_CONCAT(totalRate SEPARATOR ',') AS totalRate,
            GROUP_CONCAT(Remarks_Item SEPARATOR ',') AS Remarks_Item,
            GROUP_CONCAT(id SEPARATOR ',') AS id
            FROM product
            LEFT JOIN supplier
            ON product.SupplierName =supplier.UserId
            WHERE  Purchase_order_No='$PL'"; 
        $result = mysqli_query($con, $sql_item);
       
       $con->query("SET group_concat_max_len = 10000000000000000");
         $sql_item ="
         
         SELECT 
            GROUP_CONCAT(BrandName SEPARATOR '') AS BrandName
            FROM product
            LEFT JOIN supplier
            ON product.SupplierName =supplier.UserId
            WHERE  Purchase_order_No='$PL'"; 
        $result = mysqli_query($con, $sql_item);

while($row = mysqli_fetch_array($result)) {
     echo "<span style='margin-bottom:10%;'>" .$row['BrandName'] . "</span><br/> newton test <br/>";
        //echo $BrandNames;
}*/
        
        
      ?>   
  </body></html>

  <script type="text/javascript">
        function update(id)
    {
       var SupplierName= document.getElementById('SupplierName').value;
       var Branch= document.getElementById('Branch').value;
       var Packing_date= document.getElementById('Packing_date').value;
       var Purchase_order_No= document.getElementById('Purchase_order_No').value;
       var PO_NO= document.getElementById('PO_NO').value;
       var LUser= document.getElementById('LUser').value;
              
       var BrandName= document.getElementById('BrandName'+id).value;
       var Commodity= document.getElementById('Commodity'+id).value;
       var Type= document.getElementById('Type'+id).value;
       var Rate_Name= document.getElementById('Rate_Name'+id).value;
       var rate= document.getElementById('rate'+id).value;
       var Qty= document.getElementById('Qty'+id).value;
       var totalRate= document.getElementById('totalRate'+id).value;
       var Remarks_Item= document.getElementById('Remarks_Item'+id).value;

       window.location.href = "update.php?id="+encodeURIComponent(id)+"&LUser="+encodeURIComponent(LUser)+"&SupplierName="+encodeURIComponent(SupplierName)+"&Branch="+encodeURIComponent(Branch)+"&Packing_date="+encodeURIComponent(Packing_date)+"&Purchase_order_No="+encodeURIComponent(Purchase_order_No)+"&PO_NO="+encodeURIComponent(PO_NO)+"&BrandName="+encodeURIComponent(BrandName)+"&Commodity="+encodeURIComponent(Commodity)+"&Type="+encodeURIComponent(Type)+"&Rate_Name="+encodeURIComponent(Rate_Name)+"&rate="+encodeURIComponent(rate)+"&Qty="+encodeURIComponent(Qty)+"&totalRate="+encodeURIComponent(totalRate)+"&Remarks_Item="+encodeURIComponent(Remarks_Item)+""; 
         // alert(Region);

    }
        function Delete(id)
    {
       var SupplierName= document.getElementById('SupplierName').value;
       var Branch= document.getElementById('Branch').value;
       var Packing_date= document.getElementById('Packing_date').value;
       var Purchase_order_No= document.getElementById('Purchase_order_No').value;
       var PO_NO= document.getElementById('PO_NO').value;
       var LUser= document.getElementById('LUser').value;
              
       var BrandName= document.getElementById('BrandName'+id).value;
       var Commodity= document.getElementById('Commodity'+id).value;
       var Type= document.getElementById('Type'+id).value;
       var Rate_Name= document.getElementById('Rate_Name'+id).value;
       var rate= document.getElementById('rate'+id).value;
       var Qty= document.getElementById('Qty'+id).value;
       var totalRate= document.getElementById('totalRate'+id).value;
       var Remarks_Item= document.getElementById('Remarks_Item'+id).value;

       window.location.href = "delete.php?id="+id+"&LUser="+LUser+"&SupplierName="+SupplierName+"&Branch="+Branch+"&Packing_date="+Packing_date+"&Purchase_order_No="+Purchase_order_No+"&PO_NO="+PO_NO+"&BrandName="+BrandName+"&Commodity="+Commodity+"&Type="+Type+"&Rate_Name="+Rate_Name+"&rate="+rate+"&Qty="+Qty+"&totalRate="+totalRate+"&Remarks_Item="+Remarks_Item+""; 
         // alert(Region);

    }
  </script>
