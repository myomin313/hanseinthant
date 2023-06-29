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
    <?php
      $actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    ?>  

<script>

var rowNum = 0;
function addRow(frm) {
  rowNum ++;
  var row = '<p id="rowNum'+rowNum+'">';

  row = row + '<select name="NBrandName[]" id="NBrandName'+rowNum+'"style="width:20%;height: 30px;" onchange="showCommo(this.value)" ><option value="" ></option>';

  var rows = '';
  <?php

            $Branches = $_SESSION['Branch'];
          if ($Branches == 'Shwe Pyi Thar Store') {
            $sqlp="SELECT Distinct BrandName FROM product Where Branch='Shwe Pyi Thar Store' Order by BrandName";}
          elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {
            $sqlp="SELECT Distinct BrandName FROM product Where Branch='Shwe Pyi Thar Store Control Panel' Order by BrandName";}
          elseif ($Branches == 'Yangon Show Room') {
            $sqlp="SELECT Distinct BrandName FROM product Where Branch='Yangon Show Room'";}
          elseif ($Branches == 'Mandalay Show Room') {
            $sqlp="SELECT Distinct BrandName FROM product Where Branch='Mandalay Show Room' Order by BrandName";}
          elseif ($Branches == 'Naypyidaw Show Room') {
            $sqlp="SELECT Distinct BrandName FROM product Where Branch='Naypyidaw Show Room' Order by BrandName";}
          else {
            $sqlp="SELECT Distinct BrandName FROM product Where 1=1 Order by BrandName";} 
                        
            $resResultp = $con->query($sqlp);
              while ($rowp=mysqli_fetch_array($resResultp)) {
             $BrandName = mysqli_real_escape_string($con,$rowp["BrandName"]);

              ?>
                rows = rows + '<option value="<?php echo htmlspecialchars($BrandName, ENT_QUOTES); ?>"';
                rows = rows + '><?php echo $BrandName; ?></option>';
               
      <?php
      }
      ?>

row = row + rows+ '</select><br><br>';

row =  row +'<span  id="commo'+rowNum+'"  ></span>';
row =  row +'<span  id="txtHint'+rowNum+'"  ></span>';

    row =  row +'<input type="button" value="Submit" class="updateitem" onclick="save('+rowNum+')">&nbsp&nbsp<input type="button" value="remove"  onclick="removeRow('+rowNum+');" class="removeitem"></p>';

  jQuery('#itemRows').append(row);
  frm.Price.value = '';
  frm.Product.value = '';
  frm.qty.value = '';
  frm.SubAmount.value = '';

}

function removeRow(rnum) {
  jQuery('#rowNum'+rnum).remove();
}
     function save(rowNum)
    {
       var supplier= document.getElementById('supplier').value;
       var Return_date= document.getElementById('Return_date').value;
       var PL_NO= document.getElementById('PL_NO').value;
       var Branch= document.getElementById('Branch').value;
       var LUser= document.getElementById('LUser').value;
              
       var NBrandName= document.getElementById('NBrandName'+rowNum).value;
       var NCommodity= document.getElementById('NCommodity'+rowNum).value;
       var Type= document.getElementById('Type'+rowNum).value;
       var Qty= document.getElementById('Qty'+rowNum).value;
       var SubQty= document.getElementById('SubQty'+rowNum).value;
       var Remarks= document.getElementById('Remarks'+rowNum).value;


       window.location.href = "updatenew.php?id="+rowNum+"&LUser="+LUser+"&supplier="+supplier+"&Branch="+Branch+"&Return_date="+Return_date+"&PL_NO="+PL_NO+"&NBrandName="+NBrandName+"&NCommodity="+NCommodity+"&Type="+Type+"&Qty="+Qty+"&SubQty="+SubQty+"&Remarks="+Remarks+""; 

    }

        var u = 0;
        function calculate(obj) {

               var  txtHintss = Number(document.getElementById('txtHintss'+obj).value);
               var  Qty = Number(document.getElementById('Qty'+obj).value);

               var SubQty = (txtHintss - Qty);

               document.getElementById('SubQty'+rowNum).value =SubQty.toFixed(0);;

        }

        
</script>
<script>
    function showCommo(str) {
      var NPL_NO=document.getElementById("PL_NO").value;
     var Location=document.getElementById("Branch").value;
      var Brand=document.getElementById("NBrandName"+rowNum).value;
      // alert(Brand);
        if (str == "") {
            document.getElementById("commo"+rowNum).innerHTML = "";
            return;
        } else { 
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("commo"+rowNum).innerHTML = xmlhttp.responseText;
                }
            }
// getuser.php is seprate php file. q is parameter 
            //xmlhttp.open("GET","get-commodity.php?q="+str+"&rowNum="+rowNum+"&Brand="+Brand+"&NPL_NO="+NPL_NO+"&Location="+Location+"",true);
            xmlhttp.open("GET","get-commodity.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&Brand="+encodeURIComponent(Brand)+"&NPL_NO="+encodeURIComponent(NPL_NO)+"&Location="+encodeURIComponent(Location)+"",true);
            xmlhttp.send();
        }
    }
</script> 
<script>
    function showUsers(str) {
      var CommodityN= encodeURIComponent(document.getElementById("NCommodity"+rowNum).value);
      // alert (CommodityN);
      var BrandNameN=document.getElementById("NBrandName"+rowNum).value;
      // alert(BrandNameN);
      var PL_NON=document.getElementById("PL_NO").value;
      var Location=document.getElementById("Branch").value;
      // alert(PL_NON);
        if (str == "") {
            document.getElementById("txtHint"+rowNum).innerHTML = "";
            return;
        } else { 
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("txtHint"+rowNum).innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","get-data.php?q="+str+"&rowNum="+rowNum+"&CommodityN="+CommodityN+"&BrandNameN="+BrandNameN+"&PL_NON="+PL_NON+"&Location="+Location+"",true);
            xmlhttp.send();
        }
    }
</script>  

 <body style="font-size: 13px; font-family:Tahoma, Geneva, sans-serif;">

      <?php 
      $Supplier=$_GET['Supplier']; 
      $PL=$_GET['PL'];
      $Branch=$_GET['Branch'];
        print '<form method="POST" action="updates.php?PL='.$PL.'&Supplier='.$Supplier.'">';
        $_SESSION['page'] = "detail";
        $SubQty_sum = "SELECT Supplier, count(*) as count_rows FROM supplier_return WHERE  Supplier ='$Supplier' AND PL='$PL' ";
        
        $result1 = mysqli_query($con,$SubQty_sum);
    
        while($rows = mysqli_fetch_array($result1)) {
          $sum = $rows['count_rows'];
        } 

        $sql_item = "SELECT *,
        GROUP_CONCAT(supplier_return.BrandName SEPARATOR ',') AS BrandName,
        GROUP_CONCAT(supplier_return.Commodity SEPARATOR ',') AS Commodity,
        GROUP_CONCAT(supplier_return.Qty SEPARATOR ',') AS Qty,
        GROUP_CONCAT(supplier_return.Type SEPARATOR ',') AS Type,
        GROUP_CONCAT(supplier_return.Remark_item SEPARATOR ',') AS Remarks_item,
        GROUP_CONCAT(supplier_return.id SEPARATOR ',') AS ids,supplier.SupplierName as cSupplier,supplier.UserId as UserID
        FROM supplier_return         
        LEFT JOIN supplier  ON supplier.UserId= supplier_return.Supplier
        ";
      
        $result = mysqli_query($con,$sql_item);

        print '<table style="width: 100%;margin-left:0%;" id="customers">';
        while($row = mysqli_fetch_array($result)) {
          $Supplierss= $row['Supplier']; 
          $Commoditys= $row['Commodity']; 
          $Commodity=htmlspecialchars($Commoditys, ENT_COMPAT);
          $BrandNames= $row['BrandName']; 
          $BrandName=htmlspecialchars($BrandNames, ENT_COMPAT);
          $PL= $row['PL']; 
          $Qty= $row['Qty'];          
          $Remarks_item= $row['Remarks_item']; 
          $Type= $row['Type'];    
 
          $id= $row['ids']; 

                     print'<tr><td>Supplier Name</td><td>
                   <select name="supplier" id="supplier" style="width:20%;height:30px;font-size:10px;background:#f2f2f2;" readonly="readonly"><option value="'.$row["UserID"].'">'.$row['cSupplier'].'</option>';

                     print'</select></td></tr>';           
          print '<tr><td>PL NO</td><td> <input type="text" name="PL_NO" id="PL_NO" value="' . $row['PL']. '" style="width:20%;height:30px;background:#f2f2f2;font-size:10px;" readonly="readonly"/></td></tr>';            
         print '<tr><td>From Branch</td><td> 
                           <select name="Branch" id="Branch" style="width:20%;height:30px;font-size:10px;background:#f2f2f2;" required="required"readonly="readonly">
                           <option value="' . $row['Branch']. '">' . $row['Branch']. '</option>

                           </select>
                           

                           </td></tr>'; 
   
          print '<tr><td>Return Date</td><td> <input type="date" name="Return_date" id="Return_date" value="' . $row['Return_date']. '" style="width:20%;height:30px;font-size:10px;background:#f2f2f2;" readonly="readonly"/></td></tr>';  
          $LUser = $_SESSION['login_user'];
         print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';            

          print '<tr><td>Commodity</td><td class="insert">
          ';
      
          print '<input onclick="addRow(this.form);" type="button" value="Add New Field" class="myAdd" />';
          print '<br><br><div id="itemRows"></div>';          

          print'<br>'; 

                     
        }
        // Disapper Comma
        $BrandName = explode(',', $BrandName);
        $Commodity = explode(',', $Commodity);
        $Qty = explode(',', $Qty);
        $Remarks_item = explode(',', $Remarks_item);
        $id = explode(',', $id);
        $Type = explode(',', $Type);

        // Show Data According to no of Item
        for ($i=0; $i < $sum ; $i++) {
           print '<input  type="text" name="BrandName[]" id="BrandName'. $id[$i].'" value="' . $BrandName[$i].'" style="width:20%;height:30px;background-color:#f2f2f2;margin-left:0px;font-size:10px;" readonly/>';         

           print '&nbsp&nbsp<input  type="text" name="Commodity[]" id="Commodity'. $id[$i].'" value="' . $Commodity[$i].'" style="width:15%;height:30px;background-color:#f2f2f2;font-size:10px;" readonly/>';
           print'&nbsp&nbsp<input type="text" name="Types[]" id="Types'. $id[$i].'"  value="' .$Type[$i]. '"style="width:4%;height:30px;background-color:#f2f2f2;font-size:10px;" readonly/>';                          
          print '&nbsp&nbsp<input  type="text" name="quan[]" id="quan'. $id[$i].'" value="' . $Qty[$i]. '" style="width:5%;height:30px;background-color:#f2f2f2;font-size:10px;" onkeyup="cal('. $id[$i].')" readonly/>';   

          
              
          print '&nbsp&nbsp<input  type="text" name="Remarks_item[]" id="Remarks_item'. $id[$i].'" value="' . $Remarks_item[$i]. '" style="width:30%;height:30px;font-size:10px;" placeholder="Remark"/>';

          print'<input type="hidden" value="'.$Supplier.'" id="Supplier" name="Supplier">';  
           print'<input type="hidden" value="'.$id[$i].'" id="IDss" name="IDss[]">';    
  

          print '&nbsp<input type="button" name="update_ids" value="Update" class="updateitem" onclick="update(' . $id[$i] .')">&nbsp&nbsp
          <input type="button" name="delete_ids" value="Delete" class="deleteitem" onclick="Delete(' . $id[$i] .')"><br><br>';                       
        }  

        print '<input type="hidden" name="supplierID" value="'.$Supplier.'">';
        // print '<tr><td><input type="submit" name="Update" value="Update" style="margin-left:2%"   class="saveitem"/></td><td><span  class="warn warning"></span><span style="color:#ff8566;">This Update is not for Commodity.</span></td></tr>';

        print '</table>';

        print '</form>';
      ?>
 
                  </body></html>

    <script type="text/javascript">
        function update(id)
    {
     
       var supplier= document.getElementById('supplier').value;
       var Return_date= document.getElementById('Return_date').value;
       var PL_NO= document.getElementById('PL_NO').value;
       var Branch= document.getElementById('Branch').value;
       var LUser= document.getElementById('LUser').value;
              
       var BrandName= document.getElementById('BrandName'+id).value;
       var Commodity= document.getElementById('Commodity'+id).value;
       var Types= document.getElementById('Types'+id).value;
       var quan= document.getElementById('quan'+id).value;
       var Remarks_item= document.getElementById('Remarks_item'+id).value;


       window.location.href = "update.php?id="+id+"&LUser="+LUser+"&supplier="+supplier+"&Branch="+Branch+"&Return_date="+Return_date+"&PL_NO="+PL_NO+"&BrandName="+BrandName+"&Commodity="+Commodity+"&Types="+Types+"&quan="+quan+"&Remarks_item="+Remarks_item+""; 
         // alert(Region);

    }
        function Delete(id)
    {
     
       var supplier= document.getElementById('supplier').value;
       var Return_date= document.getElementById('Return_date').value;
       var PL_NO= document.getElementById('PL_NO').value;
       var Branch= document.getElementById('Branch').value;
       var LUser= document.getElementById('LUser').value;
              
       var BrandName= document.getElementById('BrandName'+id).value;
       var Commodity= document.getElementById('Commodity'+id).value;
       var Types= document.getElementById('Types'+id).value;
       var quan= document.getElementById('quan'+id).value;
       var Remarks_item= document.getElementById('Remarks_item'+id).value;


       window.location.href = "remove.php?id="+id+"&LUser="+LUser+"&supplier="+supplier+"&Branch="+Branch+"&Return_date="+Return_date+"&PL_NO="+PL_NO+"&BrandName="+BrandName+"&Commodity="+Commodity+"&Types="+Types+"&quan="+quan+"&Remarks_item="+Remarks_item+""; 
         // alert(Region);

    }
  </script>


