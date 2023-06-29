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
<style>

#brand-list{list-style:none;margin-top:-0px;padding:0;width:271px;position: absolute;}
#brand-list li{padding: 8px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
#brand-list li:hover{background:#d9d9d9;cursor: pointer;}
#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
</style>
    <script type="text/javascript">  
      function brand() {
        var min_length = 1; // min caracters to display the autocomplete
        var keyword = $('#search-box'+rowNum+'').val();
        // alert(keyword);
        if (keyword.length >= min_length) {
          $.ajax({
            url: 'brandname.php?' ,
            type: 'POST',
            data: {
              keyword: keyword
            },
            success: function(data) {
      $('#suggesstion-box'+rowNum+'').show();
      $('#suggesstion-box'+rowNum+'').html(data);
      $('#search-box'+rowNum+'').css("background","#FFF");
            }
          });
        }
        else 
        {
          $('#suggesstion-box').hide();
        }
      } 
 function selectBrand(value) {
  $('#search-box'+rowNum+'').val(value);
$('#suggesstion-box'+rowNum+'').hide();
}

 //▽2019/08/16 Newton Add
 
    function fncClearPl(rownum){
        $("#NPL" + rownum).val("");
    }
 
  function fncQuantityCheck(id){
        if (!id.value.match(/^([0-9]{0,5})$/)) {
          id.value = id.value.replace(/[^0-9]/g, '').substring(0,5);
        }
      }

      function fncCheckRemainStock(id,rownum){

        if($("#NWIP" + rownum ).val() == ""){
          alert("Please Enter WIP!");
          $("#NWIP" + rownum ).focus();
          $(id).val("");
          return false;
        }     
       
    $.ajax({
      type: "POST",
      async:false,
      dataType: "json",
      url: "checkstock.php", 
      data: { "action": "checkStock",
              "BrandName":$("#NBrandName" + rownum).val(),
              "Commodity": $("#NCommodity" + rownum).val(),
              "Branch": $("#Location").val(),
              "PL":$("#NPL" + rownum).val(),
              "Qty": $("#NWIP" + rownum).val()
            },
      success: function(data) {
        if(data["status"] != ""){
          if(confirm(data["status"])) {
            return true;
          }else{
            $("#rowNum" + rownum).remove();
            return false;
          }
          
        }else{
         
        }
      }
    });

      }
    //△


</script>
<style>

#Commodity-list{list-style:none;margin-top:-0px;padding-left: 275px;width:210px;position: absolute;}
#Commodity-list li{padding: 8px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
#Commodity-list li:hover{background:#d9d9d9;cursor: pointer;}
#Commodity{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
</style>
    <script type="text/javascript">  
      function NCommoditys() {
        var min_length = 1; // min caracters to display the autocomplete
        var keyword = $('#NCommodity'+rowNum+'').val();
        // alert(keyword);
        if (keyword.length >= min_length) {
          $.ajax({
            url: 'Commodity.php?' ,
            type: 'POST',
            data: {
              keyword: keyword
            },
            success: function(data) {
      $('#Commodity-box'+rowNum+'').show();
      $('#Commodity-box'+rowNum+'').html(data);
      $('#NCommodity'+rowNum+'').css("background","#FFF");
            }
          });
        }
        else 
        {
          $('#Commodity-box').hide();
        }
      } 
 function selectCommodity(values) {
  $('#NCommodity'+rowNum+'').val(values);
$('#Commodity-box'+rowNum+'').hide();
}
</script>
<script>
var rowNum = 0;
function addRow(frm) {
  rowNum ++;
  var row = '<p id="rowNum'+rowNum+'">';

  row = row + '<select name="NBrandName[]" id="NBrandName'+rowNum+'" style="width:20%;height: 30px;" onchange="showCommo(this.value)" ><option value="" ></option>';

  var rows = '';
  <?php
            $Branches = $_SESSION['Branch'];
          if ($Branches == 'Shwe Pyi Thar Store') {
            $sqlp="SELECT Distinct BrandName FROM product Where Branch='Shwe Pyi Thar Store' Order by BrandName";}
          elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {
            $sqlp="SELECT Distinct BrandName FROM product Where Branch='Shwe Pyi Thar Store Control Panel' Order by BrandName";}
          elseif ($Branches == 'Yangon Show Room') {
            $sqlp="SELECT Distinct BrandName FROM product Where Branch='Yangon Show Room' Order by BrandName";}
          elseif ($Branches == 'Mandalay Show Room') {
            $sqlp="SELECT Distinct BrandName FROM product Where Branch='Mandalay Show Room' Order by BrandName";}
          elseif ($Branches == 'Naypyidaw Show Room') {
            $sqlp="SELECT Distinct BrandName FROM product Where Branch='Naypyidaw Show Room' Order by BrandName";}
          else {
            $sqlp="SELECT Distinct BrandName FROM product Where 1=1 Order by BrandName";}     
                        
            $resResultp = $con->query($sqlp);
              while ($rowp=mysqli_fetch_array($resResultp)) {
             // $BrandNames = $rowp["BrandName"];
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

    row =  row +'&nbsp&nbsp<input type="button" value="Submit" class="updateitem" onclick="save('+rowNum+')"><input type="button" value="remove"  onclick="removeRow('+rowNum+');" class="removeitem"></p>';
    
    // row =  row +'&nbsp&nbsp&nbsp<input type="button" value="remove"  onclick="removeRow('+rowNum+');" class="removeitem"></p>';

  jQuery('#itemRows').append(row);
  frm.Price.value = '';
  frm.Product.value = '';
  frm.qty.value = '';
  frm.SubAmount.value = '';

}

function removeRow(rnum) {
  jQuery('#rowNum'+rnum).remove();
}
   function showCommo(str) {
      var Brand=document.getElementById("NBrandName"+rowNum).value;
      var Location=document.getElementById("Location").value;

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
           // xmlhttp.open("GET","get-commodityss.php?q="+str+"&rowNum="+rowNum+"&Brand="+Brand+"&Location="+Location+"",true);
           xmlhttp.open("GET","get-commodityss.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&Brand="+encodeURIComponent(Brand)+"&Location="+encodeURIComponent(Location)+"",true);
            xmlhttp.send();
        }
    }
    
   function showUsers(str) {
      var CommodityN= encodeURIComponent(document.getElementById("NCommodity"+rowNum).value);
      var BrandNameN=document.getElementById("NBrandName"+rowNum).value;
      var Location=document.getElementById("Location").value;
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
            xmlhttp.open("GET","get-datas.php?q="+str+"&rowNum="+rowNum+"&CommodityN="+CommodityN+"&BrandNameN="+BrandNameN+"&Location="+Location+"",true);
            xmlhttp.send();
        }
    }

     function save(rowNum)
    {
       var Location= document.getElementById('Location').value;
       var okyaku= document.getElementById('okyaku').value;
       var Job_date= document.getElementById('Job_date').value;
       var Project= document.getElementById('Project').value;
       var JOB_No= document.getElementById('JOB_No').value;
       var LUser= document.getElementById('LUser').value;
              
       var NBrandName= document.getElementById('NBrandName'+rowNum).value;
       // alert(NBrandName);
       var NCommodity= document.getElementById('NCommodity'+rowNum).value;
       var NType= document.getElementById('NType'+rowNum).value;
       var NPL= document.getElementById('NPL'+rowNum).value;
       // alert(NPL);
       var NWIP= document.getElementById('NWIP'+rowNum).value;
       var NRemark= document.getElementById('NRemark'+rowNum).value;
     
       window.location.href = "updatenew.php?id="+rowNum+"&LUser="+LUser+"&Location="+Location+"&okyaku="+okyaku+"&Job_date="+Job_date+"&Project="+Project+"&JOB_No="+JOB_No+"&NBrandName="+NBrandName+"&NCommodity="+NCommodity+"&NType="+NType+"&NPL="+NPL+"&NWIP="+NWIP+"&NRemark="+NRemark+""; 
    }
    </script> 
  </script> 

 <body style="font-size: 11px; font-family:Tahoma, Geneva, sans-serif;">     
      <?php 

        $Customer=$_GET['Customer'];
        $JOB_NO=$_GET['JOB_NO'];   
        $Branch=$_GET['Branch']; 
        $_SESSION['page'] = "detail";      
      
        $total_sum = "SELECT count(*) as count_rows,BrandName FROM job WHERE Customer='$Customer' AND Job_No='$JOB_NO' and Location='$Branch'";
        // AND Job_date='$Date'
        $result1 = mysqli_query($con, $total_sum);
        while($rows = mysqli_fetch_array($result1)) {
          $sum = $rows['count_rows'];
        } 
         $sql_item ="SELECT * ,customer.CustomerName as Customers,job.Customer as customer,
            GROUP_CONCAT(job.BrandName SEPARATOR ',') AS BrandName,
            GROUP_CONCAT(job.Commodity SEPARATOR ',') AS Commodity,
            GROUP_CONCAT(job.Type SEPARATOR ',') AS Type,
            GROUP_CONCAT(job.WIP SEPARATOR ',') AS WIP,
            GROUP_CONCAT(job.Remarks_Item SEPARATOR ',') AS Remarks_Item,
            GROUP_CONCAT(job.id SEPARATOR ',')  AS ids ,
            GROUP_CONCAT(job.PL SEPARATOR ',')  AS PL 
            FROM job
            Left join customer
            on customer.UserId= job.Customer
            WHERE  Customer='$Customer' AND Job_No='$JOB_NO' and Location='$Branch'"; 
        $result = mysqli_query($con, $sql_item);
        $item_array1 = '';
        print '<form method="POST" action="updates.php?Customer='.$_GET['Customer'].'&JOB_NO='.$_GET['JOB_NO'].'">';
       print '<table style="width: 100%;margin-left:0%;" id="customers">';

        while($row = mysqli_fetch_array($result)) {
            $Commoditys= $row['Commodity']; 
            $Commodity=htmlspecialchars($Commoditys, ENT_COMPAT);
            $Type= $row['Type'];
            $PL= $row['PL']; 
            $WIP= $row['WIP']; 
            $id= $row['ids'];
            $Locations= $row['Location']; 
            $Location=htmlspecialchars($Locations, ENT_COMPAT);
            $BrandNames= $row['BrandName']; 
            $BrandName=htmlspecialchars($BrandNames, ENT_COMPAT);
            $Remarks_Items= $row['Remarks_Item'];
            $Remarks_Item=htmlspecialchars($Remarks_Items, ENT_COMPAT);
            $Customers= $row['Customers']; 
           
            $row['Customers'] = rtrim($row['Customers'],",");
            $Customers= $row['Customers'];
         
                   print '<input type="hidden" name="hidID" value="' . $row['id']. '"';

                   print'<tr><td>Customer Name</td><td>
                   <select name="okyaku" id="okyaku" style="width:20%;height:30px;font-size:10px;background:#f2f2f2;"><option value="'.$row["UserId"].'">'.$Customers.'</option>';

                        //   $sqlp="SELECT * FROM customer";
                        //   $resResultp = $con->query($sqlp);
                        //   while ($rowp=mysqli_fetch_array($resResultp)) {
                        //   $rowp['CustomerName'] = rtrim($rowp['CustomerName'],",");
                        //   $CustomerNames = $rowp["CustomerName"];
                        //   $UserId = $rowp["UserId"];

                        // print'<option value ="'.$UserId.'" style="width:200px;height:30px;background:#f2f2f2;" readonly="readonly" >'.$CustomerNames.'</option>';
                        //  }

                    print'</select></td></tr>';  

                   print '<tr><td>Branch </td><td> <input type="text" name="Location" id="Location" value="' . $row['Location']. '" style="width:20%;height:30px;font-size: 11px;background:#f2f2f2;font-size:10px;" readonly="readonly" /></td></tr>';   

                    print '<tr><td>Job Order Date </td><td> <input type="date" name="Job_date" id="Job_date" value="' . $row['Job_date']. '" style="width:20%;height:30px;font-size: 11px;font-size:10px;background:#f2f2f2;" readonly="readonly"/></td></tr>';
                    print '<tr><td>Project</td><td> <input type="text" name="Project" id="Project" value="' . $row['Project']. '" style="width:20%;height:30px;font-size:10px;background:#f2f2f2;" readonly="readonly"/></td></tr>';  
                           $LUser = $_SESSION['login_user'];
                           print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';                      
                    print '<tr><td>JOB No</td><td> <input  type="text" name="JOB_No" id="JOB_No" value="' . $row['Job_No']. '" style="width:20%;height:30px;background:#f2f2f2;font-size:10px;" readonly="readonly"/></td></tr>';

                    print'<tr><td>Commodity</td><td>

                    ';
                 
                         print '

                        <input onclick="addRow(this.form);" type="button" value="New item" class="myAdd" /><div id="item"></div><div id="itemRows"></div>';             
                          print'<br>'; 
                      
        }
        $Commodity = explode(',', $Commodity);
        $Type = explode(',', $Type);
        $WIP = explode(',', $WIP);
        $BrandName = explode(',', $BrandName);
        $Remarks_Item = explode(',', $Remarks_Item);
        $id = explode(',', $id);
        $PL = explode(',', $PL);

        for ($i=0; $i < $sum ; $i++) { 
            print '<input  type="text" name="BrandName[]" id="BrandName'. $id[$i].'" value="' . $BrandName[$i]. '" style="width:20%;height:30px;background:#f2f2f2;font-size:10px;" readonly=readonly/>';

            print '&nbsp&nbsp<input  type="text" name="Commodity[]" id="Commodity'. $id[$i].'" value="' . $Commodity[$i]. '" style="width:15%;height:30px;background:#f2f2f2;font-size:10px;" readonly=readonly/>';
            print'&nbsp&nbsp<select name="Type[]" id="Type'. $id[$i].'" style="width:4%;height:30px;font-size:10px;">
            <option value="' .$Type[$i]. '">' .$Type[$i]. '</option>
             <option value="Set">Set</option><option value="No">No</option><option value="Lot">Lot</option><option value="ft">ft</option><option value="mtrs">mtrs</option><option value="Coils">Coils</option><option value="kg">kg</option><option value="Yard">Yard</option>             
            </select>';        
   
            print'&nbsp&nbsp<select name="PL[]" id="PL'. $id[$i].'" style="width:10%;height:30px;font-size:10px;background:#f2f2f2;" readonly=readonly>
             <option value="' .$PL[$i]. '">' .$PL[$i]. '</option>';
        //       $sqlp="SELECT Distinct Purchase_order_No FROM product WHERE Branch='$Branch' and BrandName='$BrandName[$i]' and 
        //   Commodity ='$Commodity[$i]' ";
                     
        //                   $resResultp = $con->query($sqlp);
        //                   while ($rowp=mysqli_fetch_array($resResultp)) {                          
        //                   $Purchase_order_No = $rowp["Purchase_order_No"];
        //                  print'<option value="' .$Purchase_order_No. '">' .$Purchase_order_No. '</option>';
        //                 }
            print'</select>';           
            print '&nbsp&nbsp<input type="text" name="WIP[]" id="WIP'. $id[$i].'" value="'. $WIP[$i].'" style="width:5%;height:30px;font-size:10px;" onkeyup="cal('. $id[$i].')" />';        
            print '&nbsp&nbsp<input  type="text" name="Remarks_Item[]" id="Remarks_Item'. $id[$i].'" value="' . $Remarks_Item[$i]. '" style="width:30%;height:30px;font-size:10px;"/>';                            
            print '<input type="hidden" name="id_no[]" value="'.$id[$i].'">';
            print '&nbsp<input type="button" name="update_ids" value="Update" class="updateitem" onclick="update(' . $id[$i] .')">
            &nbsp&nbsp<input type="button" name="Delete_ids" value="Delete" class="deleteitem" onclick="Delete(' . $id[$i] .')">
           <br><br>';    
 // <a href="delete.php?ID=' . $id[$i] .'&Customer=' . $_GET['Customer'] .'&JOB_NO='.$JOB_NO.'"  style="" name="Delete" onclick="return confirm(\'Are you sure to delete?\');" class="deleteitem" )">Delete</a>
        }   
        // print '<tr><td><input type="submit" value="Update" name="Update" style="margin-left:1%"   class="saveitem"/></td><td><span  class="warn warning"></span><span style="color:#ff8566;">This Update is not for Commodity.</span></td></tr>';  
        print '</table>';        

        print '</form>';

      ?>      
</body></html>
  <script type="text/javascript">
        function update(id)
    {

       var Location= document.getElementById('Location').value;
       var okyaku= document.getElementById('okyaku').value;
       var Job_date= document.getElementById('Job_date').value;
       var Project= document.getElementById('Project').value;
       var JOB_No= document.getElementById('JOB_No').value;
       var LUser= document.getElementById('LUser').value;
              
       var BrandName= document.getElementById('BrandName'+id).value;
       var Commodity= document.getElementById('Commodity'+id).value;
       var Type= document.getElementById('Type'+id).value;
       var PL= document.getElementById('PL'+id).value;
       var WIP= document.getElementById('WIP'+id).value;
       var Remarks_Item= document.getElementById('Remarks_Item'+id).value;

       window.location.href = "update.php?id="+id+"&LUser="+LUser+"&Location="+Location+"&okyaku="+okyaku+"&Job_date="+Job_date+"&Project="+Project+"&JOB_No="+JOB_No+"&BrandName="+BrandName+"&Commodity="+Commodity+"&Type="+Type+"&PL="+PL+"&WIP="+WIP+"&Remarks_Item="+Remarks_Item+""; 
         // alert(Region);

    }
        function Delete(id)
    {

       var Location= document.getElementById('Location').value;
       var okyaku= document.getElementById('okyaku').value;
       var Job_date= document.getElementById('Job_date').value;
       var Project= document.getElementById('Project').value;
       var JOB_No= document.getElementById('JOB_No').value;
       var LUser= document.getElementById('LUser').value;
              
       var BrandName= document.getElementById('BrandName'+id).value;
       var Commodity= document.getElementById('Commodity'+id).value;
       var Type= document.getElementById('Type'+id).value;
       var PL= document.getElementById('PL'+id).value;
       var WIP= document.getElementById('WIP'+id).value;
       var Remarks_Item= document.getElementById('Remarks_Item'+id).value;

       window.location.href = "delete.php?id="+id+"&LUser="+LUser+"&Location="+Location+"&okyaku="+okyaku+"&Job_date="+Job_date+"&Project="+Project+"&JOB_No="+JOB_No+"&BrandName="+BrandName+"&Commodity="+Commodity+"&Type="+Type+"&PL="+PL+"&WIP="+WIP+"&Remarks_Item="+Remarks_Item+""; 
         // alert(Region);

    }

  </script>

