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
 
// $setutf8 = "SET NAMES utf8";
// $q = $con->query($setutf8);
// $setutf8c = "SET character_set_results = 'utf8', character_set_client =
// 'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
// character_set_server = 'utf8'";
// $qc = $con->query($setutf8c);
// $setutf9 = "SET CHARACTER SET utf8";
// $q1 = $con->query($setutf9);
// $setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
//$q2 = $con->query($setutf7);
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
<script src="../js/select2.min.js" type="text/javascript"></script>
<script>

var rowNum = 0;
function addRow(frm) {
  rowNum ++;
  var row = '<p id="rowNum'+rowNum+'">';

  //row = row + '<select name="NBrandName[]" id="NBrandName'+rowNum+'"style="width:20%;height: 30px;" onchange="showCommo(this.value)" ><option value="" ></option>';
    $.ajax({
      url:"getbrandname.php",
      method:"GET",
      dataType:"json",
      success:function(data)
      {
        var html = '<option value="">Select BrandName</option>';
        for(var count = 0; count < data.length; count++)
        {
          html += '<option value="'+data[count].id+'">'+data[count].brandname+'</option>';
        }
          $("#NBrandName"+rowNum+"").html(html);
          $("#NBrandName"+rowNum+"").select2( {
           placeholder: "Select Brandname",
          allowClear: true
         } );
      }
    });
  
    // row =  row +'<input type="text" name="NBrandName[]"  id="NBrandName'+rowNum+'" style="width:20%;height:30px;" required="required" autocomplete="off" onKeyUp="brand(\''+rowNum+'\')" placeholder="Brand" onchange="showCommo(this.value)" /><span id="suggesstion-box'+rowNum+'"></span>';

    row = row+'<select name="NBrandName[]" id="NBrandName'+rowNum+'" style="width:20%;height:30px;"  autocomplete="off" required="required" onKeyUp="brand(\''+rowNum+'\')" onChange="showCommo(this.value)" placeholder="Brand"/></select></span>';

  var rows = '';
  <?php

   
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
       var code= document.getElementById('code'+rowNum).value;
       var Type= document.getElementById('Type'+rowNum).value;
       var Qty= document.getElementById('Qty'+rowNum).value;
       var SubQty= document.getElementById('SubQty'+rowNum).value;
       var Remarks= document.getElementById('Remarks'+rowNum).value;


       window.location.href = "updatenew.php?id="+rowNum+"&LUser="+LUser+"&supplier="+supplier+"&Branch="+Branch+"&Return_date="+Return_date+"&PL_NO="+PL_NO+"&NBrandName="+NBrandName+"&NCommodity="+NCommodity+"&code="+$code+"&Type="+Type+"&Qty="+Qty+"&SubQty="+SubQty+"&Remarks="+Remarks+""; 

    }

        var u = 0;
        function calculate(obj) {

               var  txtHintss = Number(document.getElementById('txtHintss'+obj).value);
               var  Qty = Number(document.getElementById('Qty'+obj).value);

               var SubQty = (txtHintss - Qty);

               document.getElementById('SubQty'+rowNum).value =SubQty.toFixed(0);;

        }
    
      function brand(rowNum) {
        var min_length = 1; // min caracters to display the autocomplete
        var keyword = $('#NBrandName'+rowNum+'').val();
        // alert(keyword);
        if (keyword.length >= min_length) {
          $.ajax({
            url: 'brandname.php' ,
            type: 'POST',
            data: {
              keyword: keyword
            },
            success: function(data) {             
      $('#suggesstion-box'+rowNum+'').show();
      $('#suggesstion-box'+rowNum+'').html(data);
      $('#NBrandName'+rowNum+'').css("background","#FFF");
            }
          });
        }
        else 
        {
          $('#suggesstion-box').hide();
        }
      }      

function selectBrand(obj,value) {
  rowNum = $(obj).parent().parent().parent().find('input[type=text]').attr("id").replace("NBrandName","");
  $('#NBrandName'+rowNum+'').val(value);
  $('#suggesstion-box'+rowNum+'').hide();
  showCommo(value,rowNum);
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

 <style>
#brand-list{list-style:none;margin-top:-0px;padding:0;width:271px;}
#brand-list li{padding: 8px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
#brand-list li:hover{background:#d9d9d9;cursor: pointer;}
#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
input:focus, textarea:focus, select:focus{
        outline: none;
    }
#Commodity-list{list-style:none;margin-top:-0px;padding-left: 275px;width:210px;position: absolute;}
#Commodity-list li{padding: 8px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
#Commodity-list li:hover{background:#d9d9d9;cursor: pointer;}
#Commodity{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
</style>

<script>
    function showUsers(str) {
      var CommodityN= document.getElementById("NCommodity"+rowNum).value;
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
            xmlhttp.open("GET","get-data.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&CommodityN="+encodeURIComponent(CommodityN)+"&BrandNameN="+encodeURIComponent(BrandNameN)+"&PL_NON="+encodeURIComponent(PL_NON)+"&Location="+encodeURIComponent(Location)+"",true);
            xmlhttp.send();
        }
    }
</script>  

 <body style="font-size: 13px; font-family:Tahoma, Geneva, sans-serif;">

      <?php 
      $Supplier=$_GET['Supplier']; 
      $PL=$_GET['PL'];
      $Branch=$_GET['Branch'];
      $con->query("SET GLOBAL group_concat_max_len = 100000000000000000000000000000000000000000000000000000000000000000000000000000");
        print '<form method="POST" action="updates.php?PL='.$PL.'&Supplier='.$Supplier.'">';
        $_SESSION['page'] = "detail";
        $SubQty_sum = "SELECT Supplier, count(*) as count_rows FROM supplier_return WHERE  Supplier ='$Supplier' AND PL='$PL' ";
        
        $result1 = mysqli_query($con,$SubQty_sum);
    
        while($rows = mysqli_fetch_array($result1)) {
          $sum = $rows['count_rows'];
        } 

        $sql_item = "SELECT 
        supplier_return.Return_date,
        supplier_return.PL,
        supplier_return.Branch,
        br.branch as branch_name,
        supplier_return.Supplier,
        supplier_return.Qty as Qty,
        GROUP_CONCAT(b.brandname SEPARATOR ',') AS BrandName,
        GROUP_CONCAT(bc.commodity SEPARATOR ',') AS Commodity,
        GROUP_CONCAT(co.code SEPARATOR ',') AS code_no,
        GROUP_CONCAT(supplier_return.BrandName SEPARATOR ',') AS bid,
        GROUP_CONCAT(supplier_return.Commodity SEPARATOR ',') AS cid,
        GROUP_CONCAT(supplier_return.code SEPARATOR ',') AS coid,
        GROUP_CONCAT(supplier_return.Qty SEPARATOR ',') AS Qty,
        GROUP_CONCAT(supplier_return.type SEPARATOR ',') AS Type,
        GROUP_CONCAT(supplier_return.Remark_item SEPARATOR ',') AS Remarks_item,
        GROUP_CONCAT(supplier_return.id SEPARATOR ',') AS ids,
        supplier.SupplierName as cSupplier,supplier.UserId as UserID
        FROM supplier_return         
        LEFT JOIN supplier  ON supplier.UserId= supplier_return.Supplier
        LEFT JOIN code co  ON co.id= supplier_return.code
        JOIN branch br ON br.id= supplier_return.Branch
        LEFT JOIN brandname b ON b.id =supplier_return.BrandName
        LEFT JOIN commodity bc ON bc.id=supplier_return.Commodity
        WHERE  Supplier ='$Supplier' AND PL='$PL'
        ";
      
        $result = mysqli_query($con,$sql_item);

        print '<table style="width: 100%;margin-left:0%;margin-bottom: 100px;" id="customers">';
        while($row = mysqli_fetch_array($result)) {
          $Supplierss= $row['Supplier']; 
          $Commoditys= $row['Commodity']; 
          $Commodity=htmlspecialchars($Commoditys, ENT_COMPAT);
          $BrandNames= $row['BrandName']; 
          $BrandName=htmlspecialchars($BrandNames, ENT_COMPAT);
          $code_noss= $row['code_no']; 
          $code_no=htmlspecialchars($code_noss, ENT_COMPAT);
          $PL= $row['PL']; 
          $bid=$row['bid'];
          $cid=$row['cid'];
          $coid=$row['coid'];
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
                           <option value="' . $row['Branch']. '">' . $row['branch_name']. '</option>

                           </select>
                           

                           </td></tr>'; 
   
          print '<tr><td>Return Date</td><td> <input type="date" name="Return_date" id="Return_date" value="' . $row['Return_date']. '" style="width:20%;height:30px;font-size:10px;background:#f2f2f2;" readonly="readonly"/></td></tr>';  
          $LUser = $_SESSION['login_user'];
         print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';            

          print '<tr><td>Commodity</td><td class="insert">
          ';
      
          print '<input onclick="addRow(this.form);" type="button" value="Add New Field" class="myAdd" />';
          print '<br><br><div id="itemRows"></div>';
          
          print'<input type="checkbox" id="selectall"/>Check All';
          print '<input  type="button"  value="Delete All"  class="deleteitemall"/></div>';
          print '<br><br><div id="itemRows"></div>'; 

          print'<br>'; 

                     
        }
        // Disapper Comma
        $BrandName = explode(',', $BrandName); 
        $Commodity = explode(',', $Commodity);         
        $code_no = explode(',', $code_no); 
        $Qty = explode(',', $Qty); 
        $Remarks_item = explode(',', $Remarks_item); 
        $id = explode(',', $id);  
        $bid = explode(',', $bid);
        $cid = explode(',', $cid);
        $coid = explode(',', $coid);
        $Type = explode(',', $Type);

        // Show Data According to no of Item
        for ($i=0; $i < $sum ; $i++) {
           print'<input type="checkbox" name="supplierreturnId" id="id'. $id[$i].'" value="' . $id[$i] .'">';
           print '<select name="BrandName[]" id="BrandName'. $id[$i].'" style="width:20%;height:30px;background:#f2f2f2;" required="required" readonly >';
           print'<option style="width:200px;height:30px;font-size: 10px;" value="'.$bid[$i].'">'.$BrandName[$i].'</option>';
            print'</select>';

            print '<select name="Commodity[]" id="Commodity'. $id[$i].'" style="width:20%;height:30px;background:#f2f2f2;" required="required" readonly >';
            print'<option style="width:200px;height:30px;font-size: 10px;" value="'.$cid[$i].'">'.$Commodity[$i].'</option>';
            print'</select>';

            print '<select name="code[]" id="code'. $id[$i].'" style="width:20%;height:30px;background:#f2f2f2;" required="required" readonly >';
            print'<option style="width:200px;height:30px;font-size: 10px;"  value="'.$coid[$i].'">'.$code_no[$i].'</option>';
            print'</select>';

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
         
       var supplier= encodeURIComponent(document.getElementById('supplier').value);
       var Return_date= encodeURIComponent(document.getElementById('Return_date').value);
       var PL_NO= encodeURIComponent(document.getElementById('PL_NO').value);
       var Branch= encodeURIComponent(document.getElementById('Branch').value);
       var LUser= encodeURIComponent(document.getElementById('LUser').value);
              
       var BrandName= encodeURIComponent(document.getElementById('BrandName'+id).value);
       var Commodity=encodeURIComponent(document.getElementById('Commodity'+id).value);
       var code=encodeURIComponent(document.getElementById('code'+id).value);
       var Types= encodeURIComponent(document.getElementById('Types'+id).value);
       var quan= encodeURIComponent(document.getElementById('quan'+id).value);
       var Remarks_item= encodeURIComponent(document.getElementById('Remarks_item'+id).value);

      
       window.location.href = "update.php?id="+id+"&LUser="+LUser+"&supplier="+supplier+"&Branch="+Branch+"&Return_date="+Return_date+"&PL_NO="+PL_NO+"&BrandName="+BrandName+"&Commodity="+Commodity+"&code="+code+"&Types="+Types+"&quan="+quan+"&Remarks_item="+Remarks_item+""; 
         // alert(Region);

    }
        function Delete(id)
    {
     
       var supplier= encodeURIComponent(document.getElementById('supplier').value);
       var Return_date= encodeURIComponent(document.getElementById('Return_date').value);
       var PL_NO= encodeURIComponent(document.getElementById('PL_NO').value);
       var Branch= encodeURIComponent(document.getElementById('Branch').value);
       var LUser= encodeURIComponent(document.getElementById('LUser').value);
              
       var BrandName=encodeURIComponent(document.getElementById('BrandName'+id).value);
       var Commodity=encodeURIComponent(document.getElementById('Commodity'+id).value);
       var code=encodeURIComponent(document.getElementById('code'+id).value);
       var Types= encodeURIComponent(document.getElementById('Types'+id).value);
       var quan= encodeURIComponent(document.getElementById('quan'+id).value);
       var Remarks_item= encodeURIComponent(document.getElementById('Remarks_item'+id).value);

       window.location.href = "remove.php?id="+id+"&LUser="+LUser+"&supplier="+supplier+"&Branch="+Branch+"&Return_date="+Return_date+"&PL_NO="+PL_NO+"&BrandName="+BrandName+"&Commodity="+Commodity+"&code="+code+"&Types="+Types+"&quan="+quan+"&Remarks_item="+Remarks_item+""; 
         // alert(Region);

    }
  </script>
     <!-- myomin 24-12-2019 -->
   <script type="text/javascript"> 
    $('#selectall').click(function() { $(this.form.elements).filter(':checkbox').prop('checked', this.checked);
      });   
    $('.deleteitemall').on('click',function(){
      var supplierreturnId = [];
        $("input:checkbox[name=supplierreturnId]:checked").each(function(){
            supplierreturnId.push($(this).val());
          });
      var supplier= document.getElementById('supplier').value;
       var Return_date= document.getElementById('Return_date').value;
       var PL_NO= document.getElementById('PL_NO').value;
       var Branch= document.getElementById('Branch').value;
       var LUser= document.getElementById('LUser').value;

         window.location.href="removeall.php?ids="+supplierreturnId+"&LUser="+LUser+"&Branch="+Branch+"&PL_NO="+PL_NO+"&supplier="+supplier+"&Return_date="+Return_date+"";

     });
  </script>
  <script>
  var delayTimer;
function input(ele) {
    clearTimeout(delayTimer);
    delayTimer = setTimeout(function() {
       ele.value = parseFloat(ele.value).toFixed(3);
    }, 1000); 
}
</script>


