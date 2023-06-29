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
        // $q2 = $con->query($setutf7);

    ?>
    <?php
      $actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
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
<script>

var rowNum = 0;
function addRow(frm) {
  rowNum ++;
  var row = '<p id="rowNum'+rowNum+'">';

  // row = row + '<select name="NBrandName[]" id="NBrandName'+rowNum+'"style="width:20%;height: 30px;" onchange="showCommo(this.value)" ><option value="" ></option>';
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



       var okyaku= document.getElementById('okyaku').value;
       var DO_No= document.getElementById('DO_No').value;
       var department= document.getElementById('department').value;
       var Return_no= document.getElementById('Return_no').value;
       var Return_date= document.getElementById('Return_date').value;
       var LUser= document.getElementById('LUser').value;
       var NBrandName= document.getElementById('NBrandName'+rowNum).value;
       var NCommodity= document.getElementById('NCommodity'+rowNum).value;
       var NType= document.getElementById('NType'+rowNum).value;
       var Qty= document.getElementById('Qty'+rowNum).value;

       var PL= document.getElementById('PL'+rowNum).value;
       var Remarks= document.getElementById('Remarks'+rowNum).value;

       
       window.location.href = "updatenew.php?id="+rowNum+"&LUser="+LUser+"&okyaku="+okyaku+"&DO_No="+DO_No+"&department="+department+"&Return_no="+Return_no+"&Return_date="+Return_date+"&NBrandName="+NBrandName+"&NCommodity="+NCommodity+"&NType="+NType+"&Qty="+Qty+"&PL="+PL+"&Remarks="+Remarks+""; 

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
    function showCommo(str) {
      var NDO_No=document.getElementById("DO_No").value;
      // alert(NDO_No);
      var Brand=document.getElementById("NBrandName"+rowNum).value;
      var okyaku=document.getElementById("okyaku").value;
       // alert(okyaku);
      var department=document.getElementById("department").value;
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
            //xmlhttp.open("GET","get-commodity.php?q="+str+"&rowNum="+rowNum+"&Brand="+Brand+"&NDO_No="+NDO_No+"&department="+department+"&okyaku="+okyaku+"",true);
            xmlhttp.open("GET","get-commodity.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&Brand="+encodeURIComponent(Brand)+"&NDO_No="+encodeURIComponent(NDO_No)+"&department="+encodeURIComponent(department)+"&okyaku="+encodeURIComponent(okyaku)+"",true);
            xmlhttp.send();
        }
    }
</script> 
<script>
    function showUsers(str) {

      var CommodityN= document.getElementById("NCommodity"+rowNum).value;
      // alert (CommodityN);
      var BrandNameN=document.getElementById("NBrandName"+rowNum).value;
      // alert(BrandNameN);
      var okyaku=document.getElementById("okyaku").value;
      var DO_NoN=document.getElementById("DO_No").value;
      var department= document.getElementById('department').value;
      // alert(DO_NoN);
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
            xmlhttp.open("GET","get-data.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&CommodityN="+encodeURIComponent(CommodityN)+"&BrandNameN="+encodeURIComponent(BrandNameN)+"&DO_NoN="+encodeURIComponent(DO_NoN)+"&okyaku="+encodeURIComponent(okyaku)+"&Location="+encodeURIComponent(department)+"",true);
            xmlhttp.send();
        }
    }
</script> 

 <body style="font-size: 11px; font-family:Tahoma, Geneva, sans-serif;">

      <?php 
      $Customer=$_GET['Customer']; 
      $Return_no=$_GET['Return_no'];
      $DO_No=$_GET['DO_No'];
      $con->query("SET GLOBAL group_concat_max_len = 100000000000000000000000000000000000000000000000000000000000000000000000000000");

        print '<form method="POST" action="updates.php?Return_no='.$Return_no.'&Customer='.$Customer.'">';
        $_SESSION['page'] = "detail";
        $SubQty_sum = "SELECT Customer, count(*) as count_rows FROM returns WHERE  Customer ='$Customer' AND Return_no='$Return_no' ";
        
       
        
        $result1 = mysqli_query($con,$SubQty_sum);
    
        while($rows = mysqli_fetch_array($result1)) {
          $sum = $rows['count_rows'];
        } 

        $sql_item = "SELECT 
        returns.Customer,
        returns.DO_No,
        ANY_VALUE(returns.department) AS department,
        returns.Return_no,
        ANY_VALUE(returns.Return_date) AS Return_date,
        GROUP_CONCAT(b.brandname SEPARATOR ',') AS BrandName,
        GROUP_CONCAT(bc.commodity SEPARATOR ',') AS Commodity,
        GROUP_CONCAT(returns.BrandName SEPARATOR ',') AS bid,
        GROUP_CONCAT(returns.Commodity SEPARATOR ',') AS cid,
        GROUP_CONCAT(returns.Qty SEPARATOR ',') AS Qty,
        GROUP_CONCAT(returns.Type SEPARATOR ',') AS Type,
        GROUP_CONCAT(returns.PL SEPARATOR ',') AS PL,
        GROUP_CONCAT(returns.Remarks_item SEPARATOR ',') AS Remarks_item,
        GROUP_CONCAT(returns.id SEPARATOR ',') AS ids,c.CustomerName as cCustomer,c.UserId as cUserID
        FROM returns
        LEFT JOIN customer c ON c.UserId= returns.Customer 
        LEFT JOIN brandname b ON b.id =returns.BrandName
        LEFT JOIN commodity bc ON bc.id=returns.Commodity WHERE  returns.Customer ='$Customer' AND returns.Return_no='$Return_no'  AND returns.DO_No='$DO_No' 
        ";
       // echo  $sql_item;exit();
        $result = mysqli_query($con,$sql_item);

        print '<table style="width: 100%;margin-left:0%;margin-bottom:100px" id="customers">';
        
       
        while($row = mysqli_fetch_array($result)) {
          $Customerss= $row['Customer']; 

           $Commoditys= $row['Commodity']; 
          $Commodity=htmlspecialchars($Commoditys, ENT_COMPAT);
          $BrandNames= $row['BrandName']; 
          $BrandName=htmlspecialchars($BrandNames, ENT_COMPAT);

          $DO_No= $row['DO_No']; 
          $Qty= $row['Qty']; 
          $Type= $row['Type'];
          $PL= $row['PL'];         
          $Remarks_item= $row['Remarks_item']; 
          $bid= $row['bid'];
          $cid= $row['cid'];
          $id= $row['ids']; 
          $row['cCustomer'] = rtrim($row['cCustomer'],",");

          // print'<tr><td style="background:#3385ff;color:white;"><p style="margin-left:10px;"><a href="list.php?namelist=&year=&month=&day="   style="font-size:13px;color:white;"><span class="arrow arrow-left"></span><span class="arrow arrow-left"></span>Back</a></p></td><td style="background:#3385ff;color:white;text-align:center;">To edit Customer Return

          // </td></tr>';
                           // print '<tr><td>Create Time </td><td style="color:blue;">' . $row['CreateTime']. '</td></tr>';
                           // print '<tr><td>Update Time </td><td style="color:green;">' . $row['UpdateTime']. '</td></tr>';
                           // print '<tr><td>Creator </td><td style="color:blue;">' . $row['Creator']. '</td></tr>';
                           // print '<tr><td>Updator </td><td style="color:green;">' . $row['Updator']. '</td></tr>';          
          
                    print'<tr><td>Customer Name</td><td>
                   <select name="okyaku" id="okyaku" style="width:20%;height:30px;background:#f2f2f2;font-size:10px;" readonly="readonly"><option value="'.$row["cUserID"].'">'.$row['cCustomer'].'</option>';
                    print'</select></td></tr>'; 

          print '<tr><td>DO No</td><td> <input type="text" name="DO_No" id="DO_No" value="' . $row['DO_No']. '" style="width:20%;height:30px;background:#f2f2f2;font-size:10px;" readonly="readonly"/></td></tr>';


                           print '<tr><td>Branch</td><td> 
                           <select name="department" id="department" style="width:20%;height:30px;background:#f2f2f2;font-size:10px;">
                           <option value="' . $row['department']. '">' . $row['department']. '</option>

                           </select>

                           </td></tr>';            
                           // <option value="Shwe Pyi Thar Store">Shwe Pyi Thar Store</option>
                           // <option value="Shwe Pyi Thar Store Control Panel">Shwe Pyi Thar Control Panel</option>
                           // <option value="Yangon Show Room">Yangon Show Room</option>
                           // <option value="Naypyidaw Show Room">Naypyidaw Show Room</option>
                           // <option value="Mandalay Show Room">Mandalay Show Room</option>
          print '<tr><td>Return No.</td><td> <input type="text" name="Return_no" id="Return_no" value="' . $row['Return_no']. '" style="width:20%;height:30px;font-size:10px;background:#f2f2f2;" readonly="readonly"/></td></tr>';  

          print '<tr><td>Return Date</td><td> <input type="date" name="Return_date" id="Return_date" value="' . $row['Return_date']. '" style="width:20%;height:30px;font-size:10px;background:#f2f2f2;" readonly="readonly"/></td></tr>'; 
          $LUser = $_SESSION['login_user'];
          print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';              

          print '<tr><td>Commodity</td>

          <td class="insert">';
 
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
        $Qty = explode(',', $Qty);
        $Type = explode(',', $Type);
        $Remarks_item = explode(',', $Remarks_item);
        $id  = explode(',', $id);
        $PL  = explode(',', $PL);
        $bid =   $bid;
        $cid =   $cid;

        // Show Data According to no of Item
        for ($i=0; $i < $sum ; $i++) { 
          print'<input type="checkbox" name="returnId" id="id" value="' . $id[$i] .'">';

          // print '<input  type="text" name="BrandName[]" id="BrandName'. $id[$i].'" value="' . $BrandName[$i].'" style="width:20%;height:30px;background-color:#f2f2f2;margin-left:0px;font-size:10px;" readonly/>';
          print '<select name="BrandName[]" id="BrandName'. $id[$i].'" style="width:20%;height:30px;background:#f2f2f2;" required="required" readonly >';
         print'<option style="width:200px;height:30px;font-size: 10px;">'.$BrandName[$i].'</option>';
          print'</select>';


          // print '&nbsp<input  type="text" name="Commodity[]" id="Commodity'. $id[$i].'" value="' . $Commodity[$i].'" style="width:15%;height:30px;background-color:#f2f2f2;margin-left:0px;font-size:10px;" readonly/>';
          print '<select name="Commodity[]" id="Commodity'. $id[$i].'" style="width:20%;height:30px;background:#f2f2f2;" required="required" readonly >';
          print'<option style="width:200px;height:30px;font-size: 10px;">'.$Commodity[$i].'</option>';
          print'</select>';



          print '&nbsp<input  type="text" name="PL[]" id="PL'. $id[$i].'" value="' . $PL[$i].'" style="width:10%;height:30px;background-color:#f2f2f2;margin-left:0px;font-size:10px;" readonly/>';

          print'&nbsp<input type="text" name="Types[]" id="Types'. $id[$i].'"  value="' .$Type[$i]. '"  style="width:4%;height:30px;background-color:#f2f2f2;font-size:10px;" readonly/>';                        
          print '&nbsp&nbsp<input  type="text" name="quan[]" id="quan'. $id[$i].'" value="' . $Qty[$i]. '" style="width:5%;height:30px;background-color:#f2f2f2;font-size:10px;" readonly/>';
                       
          print '&nbsp<input  type="text" name="Remarks_item[]" id="Remarks_item'. $id[$i].'" value="' . $Remarks_item[$i]. '" style="width:30%;height:30px;font-size:10px;" placeholder="Remark"/>';

          print'<input type="hidden" value="'.$Customer.'" id="Customer" name="Customer">';  
          print'<input type="hidden" value="'.$id[$i].'" id="IDss" name="IDss[]">';  
  
          print '&nbsp<input type="button" name="update_ids" value="Update" class="updateitem" onclick="update(' . $id[$i] .')">
            &nbsp&nbsp
          <input type="button" name="delete_ids" value="Delete" class="deleteitem" onclick="Delete(' . $id[$i] .')"><br><br>';                       
        }  
        // print '<tr><td><input type="submit" name="Update" value="Update" style="margin-left:2%"   class="saveitem"/></td><td><span  class="warn warning"></span><span style="color:#ff8566;">This Update is not for Commodity.</span></td></tr>';
        print '<input type="hidden" name="customerID" value="'.$Customer.'">';
        // print '<tr><td><input type="submit" name="Update" value="Update" style="margin-left:2%"   class="myUpdate"/></td><td></td></tr>'; 

        print '</table>';

        print '</form>';
      ?>
 
 </body></html>

  <script type="text/javascript">
        function update(id)
    {

       var okyaku= encodeURIComponent(document.getElementById('okyaku').value);
       var DO_No= encodeURIComponent(document.getElementById('DO_No').value);
       var department= encodeURIComponent(document.getElementById('department').value);
       var Return_no= encodeURIComponent(document.getElementById('Return_no').value);
       var Return_date= encodeURIComponent(document.getElementById('Return_date').value);
       var LUser= encodeURIComponent(document.getElementById('LUser').value);       
              
       var BrandName=encodeURIComponent(document.getElementById('BrandName'+id).value);
       var Commodity= encodeURIComponent(document.getElementById('Commodity'+id).value);
       var Type= encodeURIComponent(document.getElementById('Types'+id).value);
       var quan= encodeURIComponent(document.getElementById('quan'+id).value);
       var PL= encodeURIComponent(document.getElementById('PL'+id).value);
       var Remarks_item= encodeURIComponent(document.getElementById('Remarks_item'+id).value);
       // alert(Remarks_item);
       
       window.location.href = "update.php?id="+id+"&LUser="+LUser+"&okyaku="+okyaku+"&DO_No="+DO_No+"&department="+department+"&Return_no="+Return_no+"&Return_date="+Return_date+"&BrandName="+BrandName+"&Commodity="+Commodity+"&Type="+Type+"&quan="+quan+"&PL="+PL+"&Remarks_item="+Remarks_item+""; 
         // alert(Region);

    }
        function Delete(id)
    {

       var okyaku= encodeURIComponent(document.getElementById('okyaku').value);
       var DO_No= encodeURIComponent(document.getElementById('DO_No').value);
       var department= encodeURIComponent(document.getElementById('department').value);
       var Return_no= encodeURIComponent(document.getElementById('Return_no').value);
       var Return_date= encodeURIComponent(document.getElementById('Return_date').value);
       var LUser= encodeURIComponent(document.getElementById('LUser').value);       
              
       var BrandName= encodeURIComponent(document.getElementById('BrandName'+id).value);
       var Commodity=encodeURIComponent(document.getElementById('Commodity'+id).value);
       var Type= encodeURIComponent(document.getElementById('Types'+id).value);
       var quan=encodeURIComponent(document.getElementById('quan'+id).value);
       var PL= encodeURIComponent(document.getElementById('PL'+id).value);
       var Remarks_item= encodeURIComponent(document.getElementById('Remarks_item'+id).value);
       // alert(Remarks_item);
       
       window.location.href = "remove.php?id="+id+"&LUser="+LUser+"&okyaku="+okyaku+"&DO_No="+DO_No+"&department="+department+"&Return_no="+Return_no+"&Return_date="+Return_date+"&BrandName="+BrandName+"&Commodity="+Commodity+"&Type="+Type+"&quan="+quan+"&PL="+PL+"&Remarks_item="+Remarks_item+""; 
         // alert(Region);

    }
  </script>
  <!-- myomin 24-12-2019 -->
  <script type="text/javascript"> 
    $('#selectall').click(function() { $(this.form.elements).filter(':checkbox').prop('checked', this.checked);
     });   
    $('.deleteitemall').on('click',function(){
      var returnId = [];
        $("input:checkbox[name=returnId]:checked").each(function(){
            returnId.push($(this).val());
          });
       var okyaku= document.getElementById('okyaku').value;
       var DO_No= document.getElementById('DO_No').value;
       var department= document.getElementById('department').value;
       var Return_no= document.getElementById('Return_no').value;
       var Return_date= document.getElementById('Return_date').value;
       var LUser= document.getElementById('LUser').value;
         window.location.href="removeall.php?ids="+returnId+"&LUser="+LUser+"&department="+department+"&okyaku="+okyaku+"&DO_No="+DO_No+"&Return_no="+Return_no+"&Return_date="+Return_date+"";

     });
  </script>

