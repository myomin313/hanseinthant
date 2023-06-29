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
            url: '../job/brandname.php?' ,
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
        $("#PL" + rownum).val("");
    }


  function fncQuantityCheck(id){
        if (!id.value.match(/^([0-9]{0,5})$/)) {
          id.value = id.value.replace(/[^0-9]/g, '').substring(0,5);
        }
      }

      function fncCheckRemainStock(id,rownum){

        if($("#WIP" + rownum ).val() == ""){
          alert("Please Enter WIP!");
          $("#WIP" + rownum ).focus();
          $(id).val("");
          return false;
        }     
       
    $.ajax({
      type: "POST",
      async:false,
      dataType: "json",
      url: "checkstock.php", 
      data: { "action": "checkStock",
              "BrandName":$("#BrandName" + rownum).val(),
              "Commodity": $("#Commodity" + rownum).val(),
              "Branch": $("#Location").val(),
              "PL":$("#PL" + rownum).val(),
              "Qty": $("#WIP" + rownum).val()
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
<script>

var rowNum = 0;
function addRow(frm) {
  rowNum ++;
  var row = '<p id="rowNum'+rowNum+'">';

  row = row + '<select name="BrandName[]" id="BrandName'+rowNum+'" style="width:20%;height: 30px;" onchange="showCommo(this.value)" ><option value="" ></option>';

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
</script>
<script>
    function showUsers(str) {
      var CommodityN= document.getElementById("Commodity"+rowNum).value;
      var BrandNameN=document.getElementById("BrandName"+rowNum).value;
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
            //xmlhttp.open("GET","get-data.php?q="+str+"&rowNum="+rowNum+"&CommodityN="+CommodityN+"&BrandNameN="+BrandNameN+"&Location="+Location+"",true);
            //xmlhttp.open("GET","get-commodity.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&Brand="+encodeURIComponent(Brand)+"&Location="+encodeURIComponent(Location)+"",true);
            xmlhttp.open("GET","get-data.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&CommodityN="+encodeURIComponent(CommodityN)+"&BrandNameN="+encodeURIComponent(BrandNameN)+"&Location="+encodeURIComponent(Location)+"",true);
            xmlhttp.send();
        }
    }
</script> 
<script type="text/javascript">

        function calculate(x) {

               var  Qty = Number(document.getElementById('Qty'+x).value);
               var  WIP = Number(document.getElementById('WIP'+x).value);
               var TOTAL = (Qty - WIP);
               document.getElementById('Total'+x).value =TOTAL.toFixed(0);;

        }
    </script>
<script>
    function showCommo(str) {
      var Brand=document.getElementById("BrandName"+rowNum).value;
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
            xmlhttp.open("GET","get-commodity.php?q="+str+"&rowNum="+rowNum+"&Brand="+Brand+"&Location="+Location+"",true);
            xmlhttp.send();
        }
    }
</script> 

        <script type="text/javascript">  
      function checkdates() {
        var min_length =10; // min caracters to display the autocomplete
        var keyword = $('#keyword').val();
        // alert(keyword);
        if (keyword.length >= min_length) {
          $.ajax({
            url: '../Product/checking.php?',
            type: 'POST',
            data: {
              keyword: keyword
            },
            success: function(data) {
              // $('#namelist').show();
              $('#namelist').html(data);
            }
          });
        }
        else 
        {
          $('#namelist').hide();
        }
      } 
    </script>
    
<body style="font-size: 11px;font-family:Tahoma, Geneva, sans-serif;">
<div id="outer-container" >
    <div id="scrollable">
                   <?php
                        
                        $sqls="SELECT ifNull(Max(id),0) as ID FROM product ";
                                              
                        $results=mysqli_query($con ,$sqls);             
                        
                        $i = 0;
                        
                        print '<form method="POST" action="save.php?">';                   

                        print '<table style="width: 100%;font-size: 11px; font-family:Tahoma, Geneva, sans-serif;margin-bottom:100px;" id="customers" >';                 

                        print '<tr><td style="width:7%;">Customer Name</td><td><select name="okyaku" id="okyaku" style="height: 30px;width:20%;" required="required">';
                        print'<option value =""></option>';

                        $selected = $_GET['selected']; 
                        $sqlp="SELECT * FROM customer";
                          $resResultp = $con->query($sqlp);
                          while ($rowp=mysqli_fetch_array($resResultp)) {
                          $UserId = $rowp["UserId"];
                          $rowp['CustomerName'] = rtrim($rowp['CustomerName'],",");
                          $CustomerName = $rowp["CustomerName"];
                        
                        print '<option value="'. $UserId.'"';
                            if($UserId == $selected)
                             { print ' selected= selected ';} 

                         print '>'. $CustomerName.'</option>';

                         }

                          print'</select></td></tr>'; 
                        while($row = $results->fetch_assoc()){ 

                           $ID = $row['ID'] +1;
         $Branches = $_SESSION["Branch"];
         if ($Branches == "Shwe Pyi Thar Store") {
                          print '<tr><td style="width:8%;">Branch</td><td> 
                          <select name="Location" id="Location" style="width:20%;height:30px;">
                            <option value=""></option>
                             <option value="Shwe Pyi Thar Store">Shwe Pyi Thar Store</option>
                          </select></td></tr>'; 
          }
          
           elseif ($Branches == "Shwe Pyi Thar Store Control Panel") {
               print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="Location" id="Location" style="width:20%;height:30px;">
                           <option value=""></option>
                             <option value="Shwe Pyi Thar Store Control Panel">Shwe Pyi Thar Store Control Panel</option>
                          </select></td></tr>'; 
               
           }
          elseif ($Branches == "Yangon Show Room") {
              print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="Location" id="Location" style="width:20%;height:30px;">
                           <option value=""></option>
                             <option value="Yangon Show Room">Yangon Show Room</option>
                          </select></td></tr>'; 
              
          }
          elseif ($Branches == "Mandalay Show Room") {
              print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="Location" id="Location" style="width:20%;height:30px;">
                           <option value=""></option>
                             <option value="Mandalay Show Room">Mandalay Show Room</option>
                          </select></td></tr>'; 
              
          }
          elseif ($Branches == "Naypyidaw Show Room") {
              print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="Location"id="Location" style="width:20%;height:30px;">
                           <option value=""></option>
                             <option value="Naypyidaw Show Room">Naypyidaw Show Room</option>
                          </select></td></tr>'; 
              
          }
          else {print '<tr><td style="width:8%;">Branch</td><td>
                           <select name="Location" id="Location" style="width:20%;height:30px;">
                           <option value=""></option>
                           <option value="Shwe Pyi Thar Store">Shwe Pyi Thar Store</option>
                           <option value="Shwe Pyi Thar Store Control Panel">Shwe Pyi Thar Control Panel</option>
                           <option value="Yangon Show Room">Yangon Show Room</option>
                           <option value="Naypyidaw Show Room">Naypyidaw Show Room</option>
                           <option value="Mandalay Show Room">Mandalay Show Room</option>
                           </select></td></tr>'; 

              
          }                           
                           
                                                   
                            $LUser = $_SESSION['login_user'];
                          print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';  
                           print '<tr><td>JOB.No</td><td> <input type="text" name="JOB_No" value="" style="width:20%;height:30px;" required="required"/></td></tr>';                            
                                                  
                          print '<tr><td>Order Date</td><td> <input type="date" name="Job_date" value=""  style="width:20%;height:30px;font-size: 11px;" required="required"/></td></tr>'; 

                           print '<tr><td>Project</td><td> <input type="text"  name="Project" value=""  style="width:20%;height:30px;"/></td></tr>';

                           print '<tr><td>Commodity</td><td class="insert">';
                           print '

                          <input onclick="addRow(this.form)" type="button" value="Add New Field" class="myAdd" /><br><br><div id="itemRows" required="required"></div>

                          </td></tr>';  

                           print '<tr><td></td><td><input type="submit" value="Save" name="Save"  class="myButton" onclick="return confirm(\'Are you sure to save?\');")"/></td></tr>';                           
                           }                                               
                          print '</table>';

                        print '</form>';

          ?></div></div>

      </body>
      </html>
      

