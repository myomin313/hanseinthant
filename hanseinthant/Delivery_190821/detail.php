<?php session_start();?>
<?php 
      if (($_SESSION['login_session']<> true)) {
        header("Location:../index.php");    
        exit();
      }     

?>
<?php 
      include_once('../config.php');
      include_once('../style.css');
      include_once('../bardetail.php');
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
<script type="text/javascript">
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
            $sqlp="SELECT Distinct BrandName FROM product Where Branch='Yangon Show Room' Order by BrandName";}
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

    row =  row +'&nbsp&nbsp<input type="button" value="Submit" class="updateitem" onclick="save('+rowNum+')"><input type="button" value="remove"  onclick="removeRow('+rowNum+');" class="removeitem"></p>';

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
       var Location= document.getElementById('Location').value;
       var Delivery_date= document.getElementById('Delivery_date').value;
       var DO_No= document.getElementById('DO_No').value;
       var JOB_No= document.getElementById('JOB_No').value;
       var LUser= document.getElementById('LUser').value;

              
       var NBrandName= document.getElementById('NBrandName'+rowNum).value;
       var NCommodity= document.getElementById('NCommodity'+rowNum).value;
       var NType= document.getElementById('NType'+rowNum).value;
       var NQty= document.getElementById('NQty'+rowNum).value;
       var txtHintss= document.getElementById('txtHintss'+rowNum).value;

       var NRemark= document.getElementById('NRemark'+rowNum).value;
             
       window.location.href = "updatenew.php?id="+rowNum+"&LUser="+LUser+"&okyaku="+okyaku+"&Location="+Location+"&Delivery_date="+Delivery_date+"&DO_No="+DO_No+"&JOB_No="+JOB_No+"&NBrandName="+NBrandName+"&NCommodity="+NCommodity+"&NType="+NType+"&NQty="+NQty+"&txtHintss="+txtHintss+"&NRemark="+NRemark+""; 

    }
        var u = 0;

        function calculate(obj) {

               var  txtHintss = Number(document.getElementById('txtHintss'+obj).value);
               var  NQty = Number(document.getElementById('NQty'+obj).value);

               var SubQty = (txtHintss - NQty);

               document.getElementById('NSubQty'+rowNum).value =SubQty.toFixed(0);;

        }
</script>
<script>
    function showCommo(str) {
      var Brand=document.getElementById("NBrandName"+rowNum).value;
      var NDO_No=document.getElementById("DO_No").value;
      var NJOB_No=document.getElementById("JOB_No").value;
      var Location= document.getElementById('Location').value;

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
           // xmlhttp.open("GET","get-commodity-detail.php?q="+str+"&rowNum="+rowNum+"&Brand="+Brand+"&NDO_No="+NDO_No+"&NJOB_No="+NJOB_No+"&Location="+Location+"",true);
           xmlhttp.open("GET","get-commodity-detail.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&Brand="+encodeURIComponent(Brand)+"&NDO_No="+encodeURIComponent(NDO_No)+"&NJOB_No="+encodeURIComponent(NJOB_No)+"&Location="+encodeURIComponent(Location)+"",true);
            xmlhttp.send();
        }
    }
</script> 
<script>
    function showUsers(str) {
      var CommodityN= document.getElementById("NCommodity"+rowNum).value;
      var JOB_Noss=document.getElementById("JOB_No").value;
      var Location= document.getElementById('Location').value;
      var okyaku= document.getElementById('okyaku').value;
       // var CommodityN=document.getElementById("Commodity"+rowNum).value=x.replace(/[^a-zA-Z ]/g, ""); 
      
      var BrandNameN=document.getElementById("NBrandName"+rowNum).value;

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
            //xmlhttp.open("GET","get-datas.php?q="+str+"&rowNum="+rowNum+"&CommodityN="+CommodityN+"&BrandNameN="+BrandNameN+"&JOB_Noss="+JOB_Noss+"&Location="+Location+"&okyaku="+okyaku+"",true);
          // xmlhttp.open("GET","get-commodity-detail.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&Brand="+encodeURIComponent(Brand)+"&NDO_No="+encodeURIComponent(NDO_No)+"&NJOB_No="+encodeURIComponent(NJOB_No)+"&Location="+encodeURIComponent(Location)+"",true);
          xmlhttp.open("GET","get-datas.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&CommodityN="+encodeURIComponent(CommodityN)+"&BrandNameN="+encodeURIComponent(BrandNameN)+"&JOB_Noss="+encodeURIComponent(JOB_Noss)+"&Location="+encodeURIComponent(Location)+"&okyaku="+encodeURIComponent(okyaku)+"",true);
            xmlhttp.send();
        }
    }
    
//▽2019/08/16 Newton Add
  function fncClearPl(rownum){
        $("#txtHintss" + rownum).val("");
      }

   function fncQuantityCheck(id){
        if (!id.value.match(/^([0-9]{0,5})$/)) {
          id.value = id.value.replace(/[^0-9]/g, '').substring(0,5);
        }
      }   

function fncCheckRemainStock(id,rownum){

if($("#NQty" + rownum ).val() == ""){
  alert("Please Enter Quantity!");
  $("#NQty" + rownum ).focus();
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
      "PL":$("#txtHintss" + rownum).val(),
      "Qty": $("#NQty" + rownum).val()
    },
success: function(data) {
if(data["status"] != ""){
  alert(data["status"]);
  $("#rowNum" + rownum).remove();
}else{
 
}
}
});

}
//△    
    
    
</script> 

<?php      
$myID=$_GET['ID']; 
?>
<script type="text/javascript">
    $(document).ready(function () {  
      $('#old').change(function () {
         window.location.href = "detail.php?ID=<?php echo $myID;?>&BrandName=<?php echo $BrandNames;?>&selected="+ $(this).val()+"";

      });  


  });

        function cal(id) {

               var  WIP = Number(document.getElementById('WIP'+id).value);
               var  Qty = Number(document.getElementById('Qty'+id).value);

               var SubQtys = (WIP - Qty);

               document.getElementById('SubQty'+id).value =SubQtys.toFixed(0);;

        }  
  </script> 
 <body style="font-size: 11px; font-family:Tahoma, Geneva, sans-serif;">
       <?php 
      $myID=$_GET['ID']; 
      $DO=$_GET['DO'];

        print '<form method="POST" action="updates.php?DO='.$DO.'&CustomerID='.$myID.'">';
        $_SESSION['page'] = "detail";
        $SubQty_sum = "SELECT Customer, count(*) as count_rows FROM delivery WHERE  Customer ='$myID' AND DO_No='$DO' ";
        
        $result1 = mysqli_query($con,$SubQty_sum);
    
        while($rows = mysqli_fetch_array($result1)) {
          $sum = $rows['count_rows'];
        } 
          $sql_item = "SELECT *,
        GROUP_CONCAT(d.Type SEPARATOR ',') AS Types,
        GROUP_CONCAT(d.BrandName SEPARATOR ',') AS BrandName,
        GROUP_CONCAT(d.Commodity SEPARATOR ',') AS Commodity,
        GROUP_CONCAT(d.Qty SEPARATOR ',') AS Qty,
        GROUP_CONCAT(PL SEPARATOR ',') AS PL,
        GROUP_CONCAT(d.Remark_item SEPARATOR ',') AS Remark_item,c.UserId as cUserID,
        GROUP_CONCAT(d.id SEPARATOR ',') AS ids
        FROM delivery d
        
        LEFT JOIN customer c ON c.UserId= d.Customer WHERE  d.Customer ='$myID' AND d.DO_No='$DO' 
        ";
      
      // echo $sql_item;
        $result = mysqli_query($con,$sql_item);

        print '<table style="width: 100%;margin-left:0%;" id="customers">';
        while($row = mysqli_fetch_array($result)) {
          $cUserID= $row['cUserID']; 
          $Commoditys= $row['Commodity']; 
          $Commodity=htmlspecialchars($Commoditys, ENT_COMPAT);
          $BrandNames= $row['BrandName'];
          $BrandName=htmlspecialchars($BrandNames, ENT_COMPAT);
          // echo $BrandName;
          $Qty= $row['Qty']; 
          $Type= $row['Types'];          
          $JOB_No= $row['JOB_No']; 
          $Location= $row['Location']; 
          $Remark_item= $row['Remark_item']; 
          $id= $row['ids']; 
          $PL= $row['PL'];


          $row['CustomerName'] = rtrim($row['CustomerName'],",");

                    print'<tr><td>Customer Name</td><td>
                   <select name="okyaku" id="okyaku" style="width:20%;height:30px;font-size:10px;background:#f2f2f2;" readonly="readonly"><option value="'.$row["cUserID"].'">'.$row['CustomerName'].'</option>';

                        //   $sqlp="SELECT * FROM customer";
                        //   $resResultp = $con->query($sqlp);
                        //   while ($rowp=mysqli_fetch_array($resResultp)) {
                        //   $rowp['CustomerName'] = rtrim($rowp['CustomerName'],",");
                        //   $CustomerNames = $rowp["CustomerName"];
                        //   $UserIds = $rowp["UserId"];

                        // print'<option value ="'.$UserIds.'" style="width:200px;height:30px;background:#f2f2f2;" readonly="readonly" >'.$CustomerNames.'</option>';
                        //  }

                    print'</select></td></tr>';             
                  //  print'<tr><td>Branch</td><td>
                  //  <select name="Location" id="Location" style="width:20%;height:30px;background:#f2f2f2;" readonly="readonly"><option value="' . $row['Location']. '">' . $row['Location']. '</option>
                  // ';

                  //  print'</select></td></tr>';    
                           // <option value="Shwe Pyi Thar Store">Shwe Pyi Thar Store</option>
                           // <option value="Shwe Pyi Thar Store Control Panel">Shwe Pyi Thar Control Panel</option>
                           // <option value="Yangon Show Room">Yangon Show Room</option>
                           // <option value="Naypyidaw Show Room">Naypyidaw Show Room</option>
                           // <option value="Mandalay Show Room">Mandalay Show Room</option>
                             $LUser = $_SESSION['login_user'];
                           print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';                             
            print '<tr><td>Branch</td><td><input type="text"  name="Location" id="Location" value="' . $row['Location']. '" style="width:20%;height:30px;background:#f2f2f2;font-size:10px;" readonly="readonly"/></td></tr>';     
          print '<tr><td>Delivery Date </td><td> <input type="date" required="required" name="Delivery_date" id="Delivery_date" value="' . $row['Delivery_date']. '" style="width:20%;height:30px;font-size:10px;background:#f2f2f2;" readonly="readonly"/></td></tr>';
          print '<tr><td>DO.No </td><td> <input type="text" name="DO_No" id="DO_No" value="' . $row['DO_No']. '" style="width:20%;height:30px;background:#f2f2f2;font-size:10px;" readonly="readonly"/></td></tr>';      

          print '<tr><td>JOB.No</td><td> <input type="text" name="JOB_No" id="JOB_No" value="' . $row['JOB_No']. '" style="width:20%;height:30px;background:#f2f2f2;font-size:10px;" readonly="readonly"/></td></tr>';  
          print '<tr><td>Commodity</td><td class="insert">
          ';
                    // print'<span style="margin-left:100px;text-decoration:underline;">BrandName</span>'; 
                    // print'<span style="margin-left:190px;text-decoration:underline;">Commodity</span>';  
                    // print'<span style="margin-left:110px;text-decoration:underline;">Type</span>'; 
                    // print'<span style="margin-left:50px;text-decoration:underline;">Qty</span>'; 
                    //  print'<span style="margin-left:80px;text-decoration:underline;">PL NO</span>';
                    // print'<span style="margin-left:90px;text-decoration:underline;">Remark</span>';   
          print '<input onclick="addRow(this.form);" type="button" value="Add New Field" class="myAdd" />';
          print '<br><br><div id="itemRows"></div>';          
      
          print'<br>'; 

        }
        // Disapper Comma
        $BrandName = explode(',', $BrandName);
        $Commodity = explode(',', $Commodity);
        $PL = explode(',', $PL);
        $Qty = explode(',', $Qty);
        $Type = explode(',', $Type);
        $Remark_item = explode(',', $Remark_item);
        $id = explode(',', $id);

        // Show Data According to no of Item
        for ($i=0; $i < $sum ; $i++) { 
           print '<input  type="text" name="BrandName[]" id="BrandName'. $id[$i].'" value="' . $BrandName[$i].'" style="width:20%;height:30px;background-color:#f2f2f2;margin-left:0px;font-size:10px;" readonly/>';

           print '&nbsp&nbsp<input  type="text" name="Commodity[]" id="Commodity'. $id[$i].'" value="' . $Commodity[$i].'" style="width:15%;height:30px;background-color:#f2f2f2;margin-left:0px;font-size:10px;" readonly/>';
          print'&nbsp&nbsp<input type="text" name="Types[]" id="Type'. $id[$i].'"  value="' .$Type[$i]. '"  style="width:4%;height:30px;margin-left:10px;background-color:#f2f2f2;font-size:10px;" readonly/>';
          print '&nbsp&nbsp<input type="text" name="Qty[]" id="Qty'. $id[$i].'" value="' . $Qty[$i]. '" style="width:5%;height:30px;background:#f2f2f2;font-size:10px;" onkeyup="cal('. $id[$i].')" readonly/>';     
             
            print '&nbsp<input type="text" name="PL[]" id="PL'. $id[$i].'" value="'. $PL[$i].'" style="width:10%;height:30px;background:#f2f2f2;font-size:10px;" readonly/>';           
                   
          print '&nbsp&nbsp<input  type="text" name="Remark_item[]" id="Remark_item'. $id[$i].'" value="' . $Remark_item[$i]. '" style="width:28%;height:30px;font-size:10px;" placeholder="Remark"/>';

          print'<input type="hidden" value="'.$myID.'" id="Customer" name="Customer">';  
           print'<input type="hidden" value="'.$id[$i].'" id="IDss" name="IDss[]">';    
  

          print '&nbsp<input type="button" name="update_ids" value="Update" class="updateitem" onclick="update(' . $id[$i] .')">&nbsp&nbsp
          <input type="button" name="delete_ids" value="Delete" class="deleteitem" onclick="Delete(' . $id[$i] .')">
          <br><br>';            
          // <a href="remove.php?ID=' . $id[$i] .'&Customer='.$myID.'&DO='.$DO.'&JOB_No='.$JOB_No.'" name="Delete" onclick="return confirm(\'Are you sure to delete?\');" class="deleteitem" )">Delete</a>           
        }  

        print '<input type="hidden" name="customerID" value="'.$myID.'">';
//         print '<tr><td><input type="submit" name="Update" value="Update" style="margin-left:2%"   class="saveitem"/></td><td>
// <span  class="warn warning"></span><span style="color:#ff8566;">This Update is not for Commodity.</span></td></tr>'; 

        print '</table>';

        print '</form>';
      ?>
 
                  </body></html>

  <script type="text/javascript">
        function update(id)
    {

       var okyaku= document.getElementById('okyaku').value;
       var Location= document.getElementById('Location').value;
       var Delivery_date= document.getElementById('Delivery_date').value;
       var DO_No= document.getElementById('DO_No').value;
       var JOB_No= document.getElementById('JOB_No').value;
       var LUser= document.getElementById('LUser').value;
              
       var BrandName= document.getElementById('BrandName'+id).value;
       var Commodity= document.getElementById('Commodity'+id).value;
       var Type= document.getElementById('Type'+id).value;
       var Qty= document.getElementById('Qty'+id).value;
        var PL= document.getElementById('PL'+id).value;
       var Remark_item= document.getElementById('Remark_item'+id).value;    

       window.location.href = "update.php?id="+id+"&LUser="+LUser+"&okyaku="+okyaku+"&Location="+Location+"&Delivery_date="+Delivery_date+"&DO_No="+DO_No+"&JOB_No="+JOB_No+"&BrandName="+BrandName+"&Commodity="+Commodity+"&Type="+Type+"&Qty="+Qty+"&PL="+PL+"&Remark_item="+Remark_item+""; 
       

    }

  </script>
  <script type="text/javascript">
        function Delete(id)
    {

       var okyaku= document.getElementById('okyaku').value;
       var Location= document.getElementById('Location').value;
       var Delivery_date= document.getElementById('Delivery_date').value;
       var DO_No= document.getElementById('DO_No').value;
       var JOB_No= document.getElementById('JOB_No').value;
       var LUser= document.getElementById('LUser').value;
              
       var BrandName= document.getElementById('BrandName'+id).value;
       var Commodity= document.getElementById('Commodity'+id).value;
       var Type= document.getElementById('Type'+id).value;
       var Qty= document.getElementById('Qty'+id).value;
        var PL= document.getElementById('PL'+id).value;
       var Remark_item= document.getElementById('Remark_item'+id).value;    

       window.location.href = "remove.php?id="+id+"&LUser="+LUser+"&okyaku="+okyaku+"&Location="+Location+"&Delivery_date="+Delivery_date+"&DO_No="+DO_No+"&JOB_No="+JOB_No+"&BrandName="+BrandName+"&Commodity="+Commodity+"&Type="+Type+"&Qty="+Qty+"&PL="+PL+"&Remark_item="+Remark_item+""; 
         

    }

  </script>
