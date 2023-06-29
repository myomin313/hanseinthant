<?php session_start();?>
<?php 
      if (($_SESSION['login_session']<> true)) {
        header("Location:../index.php");    
        exit();
      }     

?>
<?php 
      include_once('../config.php');
      include_once('../bar.php');
      include_once('../style.css');
      include_once('../header.php');
 
 ?> 
     <?php if (isset($_SESSION['message'])): ?>
  <div class="err">
    <?php 
      echo $_SESSION['message']; 
      unset($_SESSION['message']);
    ?>
  </div>
<?php endif ?>
    <?php
      $actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    ?>
<script>
<!-- -->
          function brand(rowNum) {
        var min_length = 1; // min caracters to display the autocomplete
        var keyword = $('#BrandName'+rowNum+'').val();
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
      $('#BrandName'+rowNum+'').css("background","#FFF");
            }
          });
        }
        else 
        {
          $('#suggesstion-box').hide();
        }
      } 

    function selectBrand(obj,value) {
    rowNum = $(obj).parent().parent().parent().find('input[type=text]').attr("id").replace("BrandName","");
    $('#BrandName'+rowNum+'').val(value);
    $('#suggesstion-box'+rowNum+'').hide();
    showCommo(value);
      //alert($(obj).closest('input[type=text]').attr("id"));
      //alert($(obj).parent().parent().parent().find('input[type=text]').attr("id"));
     //alert($(obj).attr("onclick"));
  }


    function showUsers(str) {
      var CommodityN= document.getElementById("NCommodity"+rowNum).value;
      // alert (CommodityN);
      var BrandNameN=document.getElementById("BrandName"+rowNum).value;
      // alert(BrandNameN);
      var DO_NoN=document.getElementById("DO_No").value;
      var Location=document.getElementById("department").value;
      var okyaku=document.getElementById("okyaku").value;
      
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
            xmlhttp.open("GET","get-data.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&CommodityN="+encodeURIComponent(CommodityN)+"&BrandNameN="+encodeURIComponent(BrandNameN)+"&DO_NoN="+encodeURIComponent(DO_NoN)+"&okyaku="+encodeURIComponent(okyaku)+"&Location="+encodeURIComponent(Location)+"",true);
            xmlhttp.send();
        }
    }
</script> 
<style>

/*.frmSearch {border: 1px solid #a8d4b1;background-color: #c6f7d0;margin: 2px 0px;padding:40px;border-radius:4px;}*/
#Commodity-list{list-style:none;margin-top:-0px;padding-left: 275px;width:210px;position: absolute;}
#Commodity-list li{padding: 8px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
#Commodity-list li:hover{background:#d9d9d9;cursor: pointer;}
#Commodity{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
</style>

    <script type="text/javascript">  
      function Commodity() {
        var min_length = 1; // min caracters to display the autocomplete
        var keyword = $('#Commodity'+rowNum+'').val();
        // alert(keyword);
        if (keyword.length >= min_length) {
          $.ajax({
            url: '../job/Commodity.php?' ,
            type: 'POST',
            data: {
              keyword: keyword
            },
            success: function(data) {
      $('#Commodity-box'+rowNum+'').show();
      $('#Commodity-box'+rowNum+'').html(data);
      $('#Commodity'+rowNum+'').css("background","#FFF");
            }
          });
        }
        else 
        {
          $('#Commodity-box').hide();
        }
      } 
 function selectCommodity(values) {
  $('#Commodity'+rowNum+'').val(values);
  $('#Commodity-box'+rowNum+'').hide();
  
}
</script>
<style>

/*.frmSearch {border: 1px solid #a8d4b1;background-color: #c6f7d0;margin: 2px 0px;padding:40px;border-radius:4px;}*/
#Commodity-list{list-style:none;margin-top:-0px;padding-left: 275px;width:210px;position: absolute;}
#Commodity-list li{padding: 8px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
#Commodity-list li:hover{background:#d9d9d9;cursor: pointer;}
#Commodity{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
</style>

    <script type="text/javascript">  
      function Commodity() {
        var min_length = 1; // min caracters to display the autocomplete
        var keyword = $('#Commodity'+rowNum+'').val();
        // alert(keyword);
        if (keyword.length >= min_length) {
          $.ajax({
            url: '../job/Commodity.php?' ,
            type: 'POST',
            data: {
              keyword: keyword
            },
            success: function(data) {
      $('#Commodity-box'+rowNum+'').show();
      $('#Commodity-box'+rowNum+'').html(data);
      $('#Commodity'+rowNum+'').css("background","#FFF");
            }
          });
        }
        else 
        {
          $('#Commodity-box').hide();
        }
      } 
 function selectCommodity(values) {
  $('#Commodity'+rowNum+'').val(values);
  $('#Commodity-box'+rowNum+'').hide();
    showUsers(value);
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
    function showDo(str) {
      var Nokyaku=document.getElementById("okyaku").value;
    //   alert(Nokyaku);
      var Locations=document.getElementById("department").value;

        if (str == "") {
            document.getElementById("donumber").innerHTML = "";
            return;
        } else { 
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("donumber").innerHTML = xmlhttp.responseText;
                }
            }
 
            xmlhttp.open("GET","get-do-no.php?q="+str+"&Nokyaku="+Nokyaku+"&Location="+Locations+"",true);
            xmlhttp.send();
        }
    }
</script> 
<script>
    function showCommo(str) {
      var NDO_No=document.getElementById("DO_No").value;
      // alert(NDO_No);
      var Brand=document.getElementById("BrandName"+rowNum).value;
      var okyaku=document.getElementById("okyaku").value;
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
            //xmlhttp.open("GET","get-commodity.php?q="+str+"&rowNum="+rowNum+"&Brand="+Brand+"&NDO_No="+NDO_No+"&department="+department+"&okyaku="+okyaku+"&department="+department+"",true);
            xmlhttp.open("GET","get-commodity.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&Brand="+encodeURIComponent(Brand)+"&NDO_No="+encodeURIComponent(NDO_No)+"&department="+encodeURIComponent(department)+"&okyaku="+encodeURIComponent(okyaku)+"&department="+encodeURIComponent(department)+"",true);
            xmlhttp.send();
        }
    }
</script> 

<script>

var rowNum = 0;
function addRow(frm) {
  rowNum ++;
  var row = '<p id="rowNum'+rowNum+'">';

  // row = row + '<select name="BrandName[]" id="BrandName'+rowNum+'"style="width:20%;height: 30px;" onchange="showCommo(this.value)" ><option value="" ></option>';
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
          $("#BrandName"+rowNum+"").html(html);              
      }
    });


  // row =  row +'<input type="text" name="BrandName[]"  id="BrandName'+rowNum+'" style="width:20%;height:30px;" required="required" autocomplete="off" onKeyUp="brand(\''+rowNum+'\')" placeholder="Brand" onchange="showCommo(this.value)" /><span id="suggesstion-box'+rowNum+'"></span>';

   row = row+'<select name="BrandName[]" id="BrandName'+rowNum+'" style="width:20%;height:30px;"  autocomplete="off" required="required" onChange="showCommo(\''+rowNum+'\')" placeholder="Brand"/></select><span id="suggesstion-box'+rowNum+'"></span>';


  var rows = '';
  <?php
          
      ?>
row = row + rows+ '</select><br><br>';

row =  row +'<span  id="commo'+rowNum+'"  ></span>';
row =  row +'<span  id="txtHint'+rowNum+'"  ></span>';

    row =  row +'&nbsp&nbsp&nbsp<input type="button" value="remove"  onclick="removeRow('+rowNum+');" class="removeitem"></p>';

  jQuery('#itemRows').append(row);
  frm.Price.value = '';
  frm.Product.value = '';
  frm.qty.value = '';
  frm.SubAmount.value = '';

}

function removeRow(rnum) {
  jQuery('#rowNum'+rnum).remove();
}
        function calculate(obj) {

               var  txtHintss = Number(document.getElementById('txtHintss'+obj).value);
               var  Qty = Number(document.getElementById('Qty'+obj).value);

               var SubQty = (txtHintss - Qty);

               document.getElementById('SubQty'+rowNum).value =SubQty.toFixed(0);;

        }

</script>

<body style="font-size: 10px;font-family:Tahoma, Geneva, sans-serif;">

                   <?php
                        
                        $sqls="SELECT ifNull(Max(id),0) as ID FROM product ";
                                              
                        $results=mysqli_query($con ,$sqls);             
                        
                        $i = 0;
                        print '<form method="POST" action="save.php">';
                      
                        print '<table style="width: 100%;margin-left:11px;margin-bottom: 100px;" id="customers">';
 
                        print '<tr><td style="width:8%;">Customer Name</td><td><select name="okyaku" id="okyaku" style="height: 30px;width:20%;"  >';
                        print'<option value =""></option>';


                        $selected ="";
                        if(isset ($_GET['selected'])){
                          $selected = $_GET['selected']; 
                        }
                         $sqlp="SELECT Distinct delivery.Customer as Custom,customer.CustomerName as cCustomer,customer.UserId as userId
                         FROM delivery
                         Left Join customer
                         on customer.UserId=delivery.Customer ORDER BY cCustomer";
                          $resResultp = $con->query($sqlp);
                          while ($rowp=mysqli_fetch_array($resResultp)) {
                          $UserId = $rowp["userId"];
                          $rowp['cCustomer'] = rtrim($rowp['cCustomer'],",");
                          $CustomerName = $rowp["cCustomer"];
                        
                        print '<option value="'. $UserId.'"';
                            if($UserId == $selected)
                             { print ' selected= selected ';} 

                         print '>'. $CustomerName.'</option>';

                         }

                          print'</select></td></tr>'; 
                              $LUser = $_SESSION['login_user'];
                          print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';  

                        while($row = $results->fetch_assoc()){ 

                           $ID = $row['ID'] +1;
          $Branches = $_SESSION["Branch"];
         if ($Branches == "Shwe Pyi Thar Store") {
                          print '<tr><td style="width:8%;">Branch</td><td> 
                          <select name="department" id="department" style="width:20%;height:30px;" onchange="showDo(this.value)">
                           <option value=""></option>
                             <option value="Shwe Pyi Thar Store">Shwe Pyi Thar Store</option>
                          </select></td></tr>'; 
          }
          
           elseif ($Branches == "Shwe Pyi Thar Store Control Panel") {
               print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="department" id="department" style="width:20%;height:30px;" onchange="showDo(this.value)">
                           <option value=""></option>
                             <option value="Shwe Pyi Thar Store Control Panel">Shwe Pyi Thar Store Control Panel</option>
                          </select></td></tr>'; 
               
           }
          elseif ($Branches == "Yangon Show Room") {
              print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="department" id="department" style="width:20%;height:30px;" onchange="showDo(this.value)">
                           <option value=""></option>
                             <option value="Yangon Show Room">Yangon Show Room</option>
                          </select></td></tr>'; 
              
          }
          elseif ($Branches == "Mandalay Show Room") {
              print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="department" id="department" style="width:20%;height:30px;"onchange="showDo(this.value)">
                           <option value=""></option>
                             <option value="Mandalay Show Room">Mandalay Show Room</option>
                          </select></td></tr>'; 
              
          }
          elseif ($Branches == "Naypyidaw Show Room") {
              print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="department" id="department" style="width:20%;height:30px;" onchange="showDo(this.value)">
                           <option value=""></option>
                             <option value="Naypyidaw Show Room">Naypyidaw Show Room</option>
                          </select></td></tr>'; 
              
          }
          else {print '<tr><td style="width:8%;">Branch</td><td>
                           <select name="department" id="department" style="width:20%;height:30px;" onchange="showDo(this.value)">
                           <option value=""></option>
                           <option value="Shwe Pyi Thar Store">Shwe Pyi Thar Store</option>
                           <option value="Shwe Pyi Thar Store Control Panel">Shwe Pyi Thar Control Panel</option>
                           <option value="Yangon Show Room">Yangon Show Room</option>
                           <option value="Naypyidaw Show Room">Naypyidaw Show Room</option>
                           <option value="Mandalay Show Room">Mandalay Show Room</option>
                           </select></td></tr>'; 

              
          }                            


                           print '<tr><td>Our DO.No</td><td>';
                     
                           print'<span  id="donumber" ></span></td></tr>';
                        

                           print '<tr><td>Commodity</td><td class="insert">';


                         print '<input onclick="addRow(this.form);" type="button" value="Add New Field" class="myAdd" /><br><br><div id="itemRows" ></div>';

                          print'   </td></tr>';  


                        print '<tr><td>Return No.</td><td> <input type="text" name="Return_no" value=""  style="width:20%;height:30px;" required="required"/></td></tr>';

                        print '<tr><td>Return Date</td><td> <input type="date" name="Return_date" value=""  style="width:20%;height:30px;font-size:11px;" required="required"/></td></tr>'; 

                        print '<tr><td></td><td><input type="submit" value="Save" style="margin-left:0%"  class="myButton"/></td></tr>';                                                       
                            }
                        print '</table>';
       
                        print '</form>';
                    ?>
        </form>
            <!-- added by Myo Min -->
  <script src="../js/select2.min.js" type="text/javascript"></script>
          <script>
$("#okyaku").select2( {
  placeholder: "Select customer",
  allowClear: true
  } );
</script>
 <!-- added by Myo Min -->
      </body>
      </html>
      

