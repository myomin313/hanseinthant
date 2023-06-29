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
 
        /*$setutf8 = "SET NAMES utf8";
        $q = $con->query($setutf8);
        $setutf8c = "SET character_set_results = 'utf8', character_set_client =
        'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
        character_set_server = 'utf8'";
        $qc = $con->query($setutf8c);
        $setutf9 = "SET CHARACTER SET utf8";
        $q1 = $con->query($setutf9);
        $setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
        $q2 = $con->query($setutf7);*/

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
<script src="../js/select2.min.js" type="text/javascript"></script>
<script type="text/javascript">
var rowNum = 0;
function addRow(frm) {
  rowNum ++;
  var row = '<p id="rowNum'+rowNum+'">';

  //row = row + '<select name="NBrandName[]" id="NBrandName'+rowNum+'"style="width:20%;height: 30px;" onchange="showCommo(this.value)" ><option value="" ></option>';
  // row =  row +'<input type="text" name="NBrandName[]"  id="NBrandName'+rowNum+'" style="width:20%;height:30px;" required="required" autocomplete="off" onKeyUp="showCommo(\''+rowNum+'\')" placeholder="Brand"/><span id="suggesstion-box'+rowNum+'"></span>';

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

  row = row+'<select name="BrandName[]" id="NBrandName'+rowNum+'" style="width:20%;height:30px;"  autocomplete="off" required="required" onChange="showCommo(\''+rowNum+'\')" placeholder="Brand"/></select><span id="suggesstion-box'+rowNum+'"></span>';

  var rows = '';
  <?php

          /* $Branches = $_SESSION['Branch'];
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
      }*/
      ?>
//row = row + rows+ '</select><br><br>';

row =  row +'<span  id="commo'+rowNum+'"  ></span>';
row =  row +'<span  id="txtcode'+rowNum+'"  ></span>';
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

       var transfer_from= document.getElementById('transfer_from').value;
       var transfer_to= document.getElementById('transfer_to').value;
       var transfer_date= document.getElementById('transfer_date').value;
       var transfer_no= document.getElementById('transfer_no').value;
       var LUser= document.getElementById('LUser').value;

              
       var NBrandName= document.getElementById('NBrandName'+rowNum).value;
       var NCommodity= document.getElementById('NCommodity'+rowNum).value;
       var code= document.getElementById('code'+rowNum).value;
       var NType= document.getElementById('NType'+rowNum).value;
       var NQty= document.getElementById('NQty'+rowNum).value;
       var txtHintss= document.getElementById('txtHintss'+rowNum).value;
       var NRemark= document.getElementById('NRemark'+rowNum).value;
       var Ntransfer_no= document.getElementById('Ntransfer_no'+rowNum).value;
             
       window.location.href = "updatenew.php?id="+encodeURIComponent(rowNum)+"&LUser="+encodeURIComponent(LUser)+"&transfer_from="+encodeURIComponent(transfer_from)+"&transfer_to="+encodeURIComponent(transfer_to)+"&transfer_date="+encodeURIComponent(transfer_date)+"&transfer_no="+encodeURIComponent(transfer_no)+"&NBrandName="+encodeURIComponent(NBrandName)+"&NCommodity="+encodeURIComponent(NCommodity)+"&code="+encodeURIComponent(code)+"&NType="+encodeURIComponent(NType)+"&NQty="+encodeURIComponent(NQty)+"&txtHintss="+encodeURIComponent(txtHintss)+"&NRemark="+encodeURIComponent(NRemark)+"&Ntransfer_no="+encodeURIComponent(Ntransfer_no)+""; 

    }
        var u = 0;

        function calculate(obj) {

               var  txtHintss = Number(document.getElementById('txtHintss'+obj).value);
               var  NQty = Number(document.getElementById('NQty'+obj).value);

               var SubQty = (txtHintss - NQty);

               document.getElementById('NSubQty'+rowNum).value =SubQty.toFixed(0);;

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
  showCommo(value);
}

</script>
<script>
    function showCommo(str) {
     
      var Brand=document.getElementById("NBrandName"+rowNum).value;     
      var transfer_from=document.getElementById("transfer_from").value;
      var transfer_no=document.getElementById("transfer_no").value;

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
           xmlhttp.open("GET","get-commodity-detail.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&Brand="+encodeURIComponent(Brand)+"&transfer_no="+encodeURIComponent(transfer_no)+"&transfer_from="+encodeURIComponent(transfer_from)+"",true);
            xmlhttp.send();
        }
    }
</script>
<!-- myo min start  -->
<script>
    function getCode(str) {
      var CommodityN= document.getElementById("NCommodity"+rowNum).value;  
      var BrandNameN=document.getElementById("NBrandName"+rowNum).value;
      var transfer_from=document.getElementById("transfer_from").value;
    //   alert(Location);
        if (str == "") {
            document.getElementById("txtcode"+rowNum).innerHTML = "";
            return;
        } else { 
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("txtcode"+rowNum).innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","code.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&CommodityN="+encodeURIComponent(CommodityN)+"&BrandNameN="+encodeURIComponent(BrandNameN)+"&transfer_from="+encodeURIComponent(transfer_from)+"",true);
            xmlhttp.send();
        }
    }
</script>
<!-- myo min end  --> 
<script>
    function showUsers(str) {
      var CommodityN= document.getElementById("NCommodity"+rowNum).value;
     
      var transfer_from= document.getElementById('transfer_from').value;
    //  var okyaku= document.getElementById('okyaku').value;
       // var CommodityN=document.getElementById("Commodity"+rowNum).value=x.replace(/[^a-zA-Z ]/g, ""); 
    //  var code=document.getElementById("code"+rowNum).value;
      var BrandNameN=document.getElementById("NBrandName"+rowNum).value;
      var code=document.getElementById("code"+rowNum).value;

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
           //xmlhttp.open("GET","get-commodity-detail.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&Brand="+encodeURIComponent(Brand)+"&NDO_No="+encodeURIComponent(NDO_No)+"&NJOB_No="+encodeURIComponent(NJOB_No)+"&Location="+encodeURIComponent(Location)+"",true);
           xmlhttp.open("GET","get-datas.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&CommodityN="+encodeURIComponent(CommodityN)+"&BrandNameN="+encodeURIComponent(BrandNameN)+"&transfer_from="+encodeURIComponent(transfer_from)+"&code="+encodeURIComponent(code)+"",true);
            xmlhttp.send();
        }
    }

   //▽2019/08/16 Newton Add
  function fncClearPl(rownum){
        $("#txtHintss" + rownum).val("");
        $("#Ntransfer_no" + rownum).val("");
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
      "transfer_from": $("#transfer_from").val(),
      "PL":$("#txtHintss" + rownum).val(),
      "Qty": $("#NQty" + rownum).val(),
      "transfer_no":$("#Ntransfer_no"+ rownum).val()
    },
success: function(data) {
if(data["status"] != ""){
  alert(data["status"]);
 $("#NQty" + rownum).val(' ');
}else{
 
}
}
});

}
//△
</script> 

<?php      
// $myID=$_GET['ID']; 
$BrandNames="";
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
 <body style="font-size: 11px; font-family:Tahoma, Geneva, sans-serif;">
       <?php 
      // $myID=$_GET['ID']; 
      $transfer_no=$_GET['transfer_no'];

        print '<form method="POST" action="updatetransferno.php?">';
        $_SESSION['page'] = "detail";
        // $SubQty_sum = "SELECT Customer, count(*) as count_rows FROM delivery WHERE  Customer ='$myID' AND DO_No='$DO' ";
        
        // $result1 = mysqli_query($con,$SubQty_sum);
    
        // while($rows = mysqli_fetch_array($result1)) {
        //   $sum = $rows['count_rows'];
        // } 
       /* $sql_item = "SELECT *,
        GROUP_CONCAT(d.Type SEPARATOR ',') AS Types,
        GROUP_CONCAT(d.BrandName SEPARATOR ',') AS BrandName,
        GROUP_CONCAT(d.Commodity SEPARATOR ',') AS Commodity,
        GROUP_CONCAT(d.Qty SEPARATOR ',') AS Qty,
        GROUP_CONCAT(PL SEPARATOR ',') AS PL,
        GROUP_CONCAT(d.Remark_item SEPARATOR ',') AS Remark_item,c.UserId as cUserID,
        GROUP_CONCAT(d.id SEPARATOR ',') AS ids
        FROM delivery d
        
        LEFT JOIN customer c ON c.UserId= d.Customer WHERE  d.Customer ='$myID' AND d.DO_No='$DO' 
        ";*/

        /*$sql_item = "SELECT *,
        d.Type AS Types,
        d.BrandName   AS BrandName,
        d.Commodity   AS Commodity,
        d.Qty         AS Qty,
        d.PL          AS PL,
        d.Remark_item AS Remark_item,
        d.id  AS ids,        
        c.UserId as cUserID        
        FROM delivery d        
        LEFT JOIN customer c 
        ON c.UserId= d.Customer 
        WHERE  d.Customer ='$myID' AND d.DO_No='$DO'";
      // echo $sql_item;
        $result = mysqli_query($con,$sql_item);*/


        // $sql_item = "SELECT 
        // c.UserId AS cUserID,
        // c.CustomerName AS CustomerName,
        // Location,
        // Delivery_date,
        // DO_No,
        // JOB_No
        // FROM delivery d        
        // LEFT JOIN customer c 
        // ON c.UserId= d.Customer 
        // WHERE  d.Customer ='$myID' AND d.DO_No='$DO'
        // GROUP BY d.Customer,c.CustomerName,d.DO_No,d.Location,Delivery_date,JOB_No
        // ";

        //  start myo min
         $sql_item = "SELECT transfer_from,
         transfer_to,transfer_date,
         transfer_no,bf.branch as branch_from,bt.branch as branch_to FROM transfer t JOIN branch bf
        ON bf.id= t.transfer_from JOIN branch bt
        ON bt.id= t.transfer_to WHERE transfer_no='$transfer_no' GROUP BY transfer_from,transfer_to,transfer_no,transfer_date,bf.branch,bt.branch";
        // end myo min
      
        $result = mysqli_query($con,$sql_item);

        print '<table style="width: 100%;margin-left:0%;margin-bottom:10%;" id="customers">';
        while($row = mysqli_fetch_array($result)) {
          /*$cUserID= $row['cUserID']; 
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
          $PL= $row['PL'];*/

        //    $arr = array('SPT','CP','YSR','NPT','MDY');
        //         foreach ($arr as $url) {
        // if (strpos($row['DO_No'], $url) !== FALSE) { 
        //        $pieces = explode($url,$row['DO_No'], 2);
        //        }
        //   }    
        //         if(preg_match("/SPT/", $row['DO_No']))
        //       {
        //             $match = "SPT";               
        //       }
        //       elseif(preg_match("/CP/",$row['DO_No']))
        //         {
        //            $match = "CP";             
        //        }
        //        elseif(preg_match("/YSR/",$row['DO_No']))
        //       {
        //            $match = "YSR";
        //       }
        //       elseif(preg_match("/NPT/", $row['DO_No']))
        //       {
        //          $match = "NPT";
        //       }
        //        elseif(preg_match("/MDY/", $row['DO_No']))
        //        {
        //           $match = "MDY";
        //         }

        // start
        
     
        //end

          
        //   if (in_array($row['DO_No'],$patterns, true)) {
        //         $pieces = explode("SPT", $row['DO_No']);
        //          echo($pieces[0]);exit();
        //     }
            //   echo $matches[1];exit(); 
          // preg_match("/(\\d+)([a-zA-Z]+)/",$row['DO_No'], $matches);

                    print'<tr><td>Transfer from</td><td>
                   <select name="transfer_from" id="transfer_from" style="width:20%;height:30px;font-size:10px;background:#f2f2f2;" readonly="readonly"><option value="'.$row["transfer_from"].'">'.$row['branch_from'].'</option>';

                     

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
            print'<tr><td>Transfer To</td><td>
            <select name="transfer_to" id="transfer_to" style="width:20%;height:30px;font-size:10px;background:#f2f2f2;" readonly="readonly"><option value="'.$row["transfer_to"].'">'.$row['branch_to'].'</option>';

              

             print'</select></td></tr>'; 
            // print '<tr><td>Transfer To</td><td><input type="text"  name="transfer_to" id="transfer_to" value="' . $row['transfer_to']. '" style="width:20%;height:30px;background:#f2f2f2;font-size:10px;" readonly="readonly"/></td></tr>';     
          print '<tr><td>Transfer Date </td><td> <input type="date" required="required" name="transfer_date" id="transfer_date" value="' . $row['transfer_date']. '" style="width:20%;height:30px;font-size:10px;background:#f2f2f2;" readonly="readonly"/></td></tr>';
          print '<tr><td>Transfer .No </td><td> <input type="text" name="transfer_no" id="transfer_no" value="' . $row['transfer_no']. '" style="width:10%;height:30px;font-size:10px;"/>';

            $Branches = $_SESSION["Branch"];

          
          
          print '<input type="hidden" name="old_transfer_from" id="old_transfer_from" value="' . $row['transfer_from']. '" style="width:20%;height:30px;background:#f2f2f2;font-size:10px;" readonly="readonly"/>';
          print '<input type="hidden" name="old_transfer_to" id="old_transfer_to" value="' . $row['transfer_to']. '" style="width:20%;height:30px;background:#f2f2f2;font-size:10px;" readonly="readonly"/>';
          print '<input type="hidden" name="old_transfer_no" id="old_transfer_no" value="' . $row['transfer_no']. '" style="width:20%;height:30px;background:#f2f2f2;font-size:10px;" readonly="readonly"/>';

          print '<tr><td></td><td><input type="submit" name="submit" value="Submit"  class="updateitem"></td></tr>';    
          print '<tr><td>Commodity</td><td class="insert">';
                    // print'<span style="margin-left:100px;text-decoration:underline;">BrandName</span>'; 
                    // print'<span style="margin-left:190px;text-decoration:underline;">Commodity</span>';  
                    // print'<span style="margin-left:110px;text-decoration:underline;">Type</span>'; 
                    // print'<span style="margin-left:50px;text-decoration:underline;">Qty</span>'; 
                    //  print'<span style="margin-left:80px;text-decoration:underline;">PL NO</span>';
                    // print'<span style="margin-left:90px;text-decoration:underline;">Remark</span>';   
          print '<input onclick="addRow(this.form);" type="button" value="Add New Field" class="myAdd" />';
           print'<input type="checkbox" id="selectall"/>Check All';
          print '<input  type="button"  value="Delete All"  class="deleteitemall"/></div>';
          print '<br><br><div id="itemRows"></div>';          
      
          print'<br>'; 

        }
        // Disapper Comma
        /*$BrandName = explode(',', $BrandName);
        $Commodity = explode(',', $Commodity);
        $PL = explode(',', $PL);
        $Qty = explode(',', $Qty);
        $Type = explode(',', $Type);
        $Remark_item = explode(',', $Remark_item);
        $id = explode(',', $id);*/
            

        $sql_item = "SELECT t.*,
        t.Type AS Types,
        brandname.brandname as BrandName,
        commodity.commodity as Commodity,
        t.BrandName as bid,
        t.Commodity as cid,
        t.Qty       AS Qty,
        t.PL        AS PL,
        t.Remark_item AS Remark_item,
        t.id  AS ids,      
        co.code as code_no                
        FROM transfer t
        LEFT JOIN code co 
        ON co.id= t.code
        JOIN brandname
        ON t.BrandName= brandname.id
        JOIN commodity
        ON t.Commodity= commodity.id 
        WHERE  t.transfer_no='$transfer_no'";

       

        $result = mysqli_query($con,$sql_item);
        $i=0;
        while($row = mysqli_fetch_array($result)) {
           print'<input type="checkbox" name="transferid" id="id" value="' . $row["id"] .'">';
          // print '<input  type="text" name="BrandName[]" id="BrandName'. $row["id"].'" value="' . htmlspecialchars($row["BrandName"], ENT_COMPAT) .'" style="width:20%;height:30px;background-color:#f2f2f2;margin-left:0px;font-size:10px;" readonly/>';
           print '<select name="BrandName[]" id="BrandName'. $row['id'].'" style="width:20%;height:30px;background:#f2f2f2;" required="required" readonly>';
             print'<option style="width:200px;height:30px;font-size: 10px;" value="'.$row['bid'].'">'. htmlspecialchars($row['BrandName'], ENT_COMPAT).'</option>';
          print'</select>';


          // print '&nbsp&nbsp<input  type="text" name="Commodity[]" id="Commodity'. $row["id"].'" value="' . htmlspecialchars($row["Commodity"], ENT_COMPAT).'" style="width:15%;height:30px;background-color:#f2f2f2;margin-left:0px;font-size:10px;" readonly/>';

           print '<select name="Commodity[]" id="Commodity'. $row['id'].'" style="width:20%;height:30px;background:#f2f2f2;" required="required" readonly >';
          print'<option style="width:200px;height:30px;font-size: 10px;" value="'.$row['cid'].'">'. htmlspecialchars($row['Commodity'], ENT_COMPAT).'</option>';
          print'</select>';

          print '<select name="code[]" id="code'. $row['id'].'" style="width:20%;height:30px;background:#f2f2f2;" required="required" readonly >';
          print'<option style="width:200px;height:30px;font-size: 10px;" value="'.$row['code'].'">'. htmlspecialchars($row['code_no'], ENT_COMPAT).'</option>';
          print'</select>';



          print'&nbsp&nbsp<input type="text" name="Types[]" id="Type'. $row["id"].'"  value="' . htmlspecialchars($row["Type"], ENT_COMPAT). '"  style="width:4%;height:30px;margin-left:10px;background-color:#f2f2f2;font-size:10px;" readonly/>';


          print '&nbsp&nbsp<input type="text" name="Qty[]" id="Qty'. $row["id"].'" value="' .htmlspecialchars($row["Qty"], ENT_COMPAT). '" style="width:5%;height:30px;background:#f2f2f2;font-size:10px;" onkeyup="cal('. $row["id"].')" readonly/>';     
          print '&nbsp<input type="text" name="PL[]" id="PL'. $row["id"].'" value="'. htmlspecialchars($row["PL"], ENT_COMPAT).'" style="width:10%;height:30px;background:#f2f2f2;font-size:10px;" readonly/>';           
          print '&nbsp&nbsp<input  type="text" name="Remark_item[]" id="Remark_item'. $row["id"].'" value="' . htmlspecialchars($row["Remark_item"], ENT_COMPAT). '" style="width:28%;height:30px;font-size:10px;" placeholder="Remark"/>';
         // print'<input type="hidden" value="'.$myID.'" id="Customer" name="Customer">';  
          print'<input type="hidden" value="'.$row["id"].'" id="IDss" name="IDss[]">'; 
          print '&nbsp<input type="button" name="update_ids" value="Update" class="updateitem" onclick="update(' . $row["id"] .')">&nbsp&nbsp
         <input type="button" name="delete_ids" value="Delete" class="deleteitem" onclick="Delete(' . $row["id"] .')">
         <br><br>';            
         $i += 1;
        }


        /*$BrandName = $BrandName;
        $Commodity = $Commodity;
        $PL = $PL;
        $Qty = $Qty;
        $Type = $Type;
        $Remark_item = $Remark_item;
        $id = $id;*/

        // Show Data According to no of Item
        /*for ($i=0; $i < $sum ; $i++) { 
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
        }  */

       // print '<input type="hidden" name="customerID" value="'.$myID.'">';
//         print '<tr><td><input type="submit" name="Update" value="Update" style="margin-left:2%"   class="saveitem"/></td><td>
// <span  class="warn warning"></span><span style="color:#ff8566;">This Update is not for Commodity.</span></td></tr>'; 

        print '</table>';

        print '</form>';
      ?>
 
                  </body></html>

  <script type="text/javascript">
        function update(id)
    {

       var transfer_from= encodeURIComponent(document.getElementById('transfer_from').value);
       var transfer_to= encodeURIComponent(document.getElementById('transfer_to').value);
       var transfer_date= encodeURIComponent(document.getElementById('transfer_date').value);
       var transfer_no= encodeURIComponent(document.getElementById('transfer_no').value);
       var LUser= encodeURIComponent(document.getElementById('LUser').value);
              
       var BrandName= encodeURIComponent(document.getElementById('BrandName'+id).value);
       var Commodity= encodeURIComponent(document.getElementById('Commodity'+id).value);
       var code= encodeURIComponent(document.getElementById('code'+id).value);
       var Type= encodeURIComponent(document.getElementById('Type'+id).value);
       var Qty= encodeURIComponent(document.getElementById('Qty'+id).value);
        var PL= encodeURIComponent(document.getElementById('PL'+id).value);
       var Remark_item= encodeURIComponent(document.getElementById('Remark_item'+id).value);    

       window.location.href = "update.php?id="+id+"&LUser="+LUser+"&transfer_from="+transfer_from+"&transfer_to="+transfer_to+"&transfer_date="+transfer_date+"&transfer_no="+transfer_no+"&BrandName="+BrandName+"&Commodity="+Commodity+"&code="+code+"&Type="+Type+"&Qty="+Qty+"&PL="+PL+"&Remark_item="+Remark_item+""; 
       

    }

  </script>
  <script type="text/javascript">
        function Delete(id)
    {
        
       var transfer_from= encodeURIComponent(document.getElementById('transfer_from').value);
       var transfer_to= encodeURIComponent(document.getElementById('transfer_to').value);
       var transfer_date= encodeURIComponent(document.getElementById('transfer_date').value);
       var transfer_no= encodeURIComponent(document.getElementById('transfer_no').value);
       var LUser= encodeURIComponent(document.getElementById('LUser').value);
              
       var BrandName= encodeURIComponent(document.getElementById('BrandName'+id).value);
       var Commodity= encodeURIComponent(document.getElementById('Commodity'+id).value);
       var code= encodeURIComponent(document.getElementById('code'+id).value);
       var Type= encodeURIComponent(document.getElementById('Type'+id).value);
       var Qty= encodeURIComponent(document.getElementById('Qty'+id).value);
       var PL= encodeURIComponent(document.getElementById('PL'+id).value);
       var Remark_item= encodeURIComponent(document.getElementById('Remark_item'+id).value);    

       window.location.href = "remove.php?id="+id+"&LUser="+LUser+"&transfer_from="+transfer_from+"&transfer_to="+transfer_to+"&transfer_date="+transfer_date+"&transfer_no="+transfer_no+"&BrandName="+BrandName+"&Commodity="+Commodity+"&code="+code+"&Type="+Type+"&Qty="+Qty+"&PL="+PL+"&Remark_item="+Remark_item+""; 
         

    }

  </script>
     <!-- myomin 24-12-2019 -->
  <script type="text/javascript">
    $('#selectall').click(function() { $(this.form.elements).filter(':checkbox').prop('checked', this.checked);
     });
    $('.deleteitemall').on('click',function(){
      var transferid = [];
        $("input:checkbox[name=transferid]:checked").each(function(){
          transferid.push($(this).val());
          });
       var LUser= document.getElementById('LUser').value;
       var transfer_from= document.getElementById('transfer_from').value;
       var transfer_to= document.getElementById('transfer_to').value;
       var transfer_no= document.getElementById('transfer_no').value;
        
          window.location.href = "removeall.php?ids="+transferid+"&LUser="+LUser+"&transfer_from="+transfer_from+"&transfer_to="+transfer_to+"&transfer_no="+transfer_no+"";

     });
  </script>
