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
    function showUsers(str) {
      var CommodityN= encodeURIComponent(document.getElementById("NCommodity"+rowNum).value);
      var BrandNameN=document.getElementById("BrandName"+rowNum).value;
      var JOB_Noss=document.getElementById("JOB_No").value;
       var Location=document.getElementById("Location").value;
    //   alert(Location);
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
            xmlhttp.open("GET","get-data.php?q="+str+"&rowNum="+rowNum+"&CommodityN="+CommodityN+"&BrandNameN="+BrandNameN+"&JOB_Noss="+JOB_Noss+"&Location="+Location+"",true);
            xmlhttp.send();
        }
    }
</script> 

<script>
    function showCommo(str) {
      var Brand=document.getElementById("BrandName"+rowNum).value;
      var JOB_Nos=document.getElementById("JOB_No").value;
       var Location=document.getElementById("Location").value;
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
            //xmlhttp.open("GET","get-commodity.php?q="+str+"&rowNum="+rowNum+"&Brand="+Brand+"&JOB_Nos="+JOB_Nos+"&Location="+Location+"",true);
            xmlhttp.open("GET","get-commodity.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&Brand="+encodeURIComponent(Brand)+"&JOB_Nos="+encodeURIComponent(JOB_Nos)+"&Location="+encodeURIComponent(Location)+"",true);
            xmlhttp.send();
        }
    }
</script> 
<script>
    function showJob(str) {
      var Nokyaku=document.getElementById("okyaku").value;
      var Location=document.getElementById("Location").value;
      // alert(Nokyaku);
        if (str == "") {
            document.getElementById("jobnumber").innerHTML = "";
            return;
        } else { 
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("jobnumber").innerHTML = xmlhttp.responseText;
                }
            }
 
            xmlhttp.open("GET","get-job-no.php?q="+str+"&Nokyaku="+Nokyaku+"&Location="+Location+"",true);
            xmlhttp.send();
        }fncQuantityCheck
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
        <script type="text/javascript">  
      function checkDo() {
        var min_length =10; // min caracters to display the autocomplete
        var keyword = $('#DO_No').val();
        // alert(keyword);
        if (keyword.length >= min_length) {
          $.ajax({
            url: '../Delivery/checking.php?',
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
              "BrandName":$("#BrandName" + rownum).val(),
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
<body style="font-size: 11px;font-family:Tahoma, Geneva, sans-serif;">
<div id="outer-container" >
    <div id="scrollable">
                   <?php
                        
                        $sqls="SELECT ifNull(Max(id),0) as ID FROM product ";
                                              
                        $results=mysqli_query($con ,$sqls);             
                        
                        $i = 0;
                        print '<form method="POST" action="save.php">';
                      
                        print '<table style="width: 100%;margin-left:0%;margin-bottom: 100px;" id="customers">';
                                                                       
                        print '<tr><td style="width:8%;">Customer Name</td><td><select name="okyaku" id="okyaku" style="height: 30px;width:20%;" required="required"  >';
                        print'<option value =""></option>';
                        $selected = ""; 
                        if(isset($_GET['selected'])){
                          $selected = $_GET['selected']; 
                        }
                       
                         $sqlp="SELECT * FROM customer";
                          $resResultp = $con->query($sqlp);
                          while ($rowp=mysqli_fetch_array($resResultp)) {
                          $UserIds = $rowp["UserId"];
                          $rowp['CustomerName'] = rtrim($rowp['CustomerName'],",");
                          $CustomerName = $rowp["CustomerName"];
                        
                        print '<option value="'. $UserIds.'"';
                            if($UserIds == $selected)
                             { print ' selected= selected ';} 

                         print '>'. $CustomerName.'</option>';

                         }

                          print'</select></td></tr>'; 
                            $LUser = $_SESSION['login_user'];
                          print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';                            
         $Branches = $_SESSION["Branch"];
         if ($Branches == "Shwe Pyi Thar Store") {
                          print '<tr><td style="width:8%;">Branch</td><td> 
                          <select name="Location" id ="Location" style="width:20%;height:30px;" onchange="showJob(this.value)">
                           <option value=""></option>
                             <option value="Shwe Pyi Thar Store">Shwe Pyi Thar Store</option>
                          </select></td></tr>'; 
          }
          
           elseif ($Branches == "Shwe Pyi Thar Store Control Panel") {
               print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="Location" id ="Location" style="width:20%;height:30px;" onchange="showJob(this.value)">
                           <option value=""></option>
                             <option value="Shwe Pyi Thar Store Control Panel">Shwe Pyi Thar Store Control Panel</option>
                          </select></td></tr>'; 
               
           }
          elseif ($Branches == "Yangon Show Room") {
              print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="Location" id ="Location" style="width:20%;height:30px;" onchange="showJob(this.value)">
                           <option value=""></option>
                             <option value="Yangon Show Room">Yangon Show Room</option>
                          </select></td></tr>'; 
              
          }
          elseif ($Branches == "Mandalay Show Room") {
              print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="Location" id ="Location" style="width:20%;height:30px;" onchange="showJob(this.value)">
                           <option value=""></option>
                             <option value="Mandalay Show Room">Mandalay Show Room</option>
                          </select></td></tr>'; 
              
          }
          elseif ($Branches == "Naypyidaw Show Room") {
              print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="Location" id ="Location" style="width:20%;height:30px;" onchange="showJob(this.value)">
                           <option value=""></option>
                             <option value="Naypyidaw Show Room">Naypyidaw Show Room</option>
                          </select></td></tr>'; 
              
          }
          else {print '<tr><td style="width:8%;">Branch</td><td>
                           <select name="Location" id ="Location" style="width:20%;height:30px;" onchange="showJob(this.value)">
                           <option value=""></option>
                           <option value="Shwe Pyi Thar Store">Shwe Pyi Thar Store</option>
                           <option value="Shwe Pyi Thar Store Control Panel">Shwe Pyi Thar Control Panel</option>
                           <option value="Yangon Show Room">Yangon Show Room</option>
                           <option value="Naypyidaw Show Room">Naypyidaw Show Room</option>
                           <option value="Mandalay Show Room">Mandalay Show Room</option>
                           </select></td></tr>'; 

              
          }                           

                           
                             while($row = $results->fetch_assoc()){ 

                            $ID = $row['ID'] +1;
                          
                          print '<tr><td>JOB.No</td><td class="insert">';
                          print'<span  id="jobnumber" ></span></td></tr>';

                          print '<tr><td>Commodity</td><td class="insert">';

                          print '<input onclick="addRow(this.form)" type="button" value="Add New Field" class="myAdd" /><br><br><div id="itemRows" required="required"></div>';

                          print'   </td></tr>'; 

                          print '<tr><td>Delivery Date</td><td> <input type="date" name="Delivery_date" value=""  style="width:20%;height:30px;font-size:11px;" required="required"/></td></tr>'; 
                          print '<tr><td>DO.No</td><td> <input type="text"  name="DO_No" id="DO_No" value=""  style="width:20%;height:30px;" required="required"  onKeyUp="checkDo()"/><span style="color:red;font-weight:bold;">&nbsp*&nbsp&nbspPlease make sure your DO NO. </span></td></tr>';
                            print'<ul id="namelist" ></ul>';

                          print '<tr><td></td><td><input type="submit" value="Save" style="margin-left:0%"  class="myButton"/> </td></tr>';

                                                       
                            }
                        print '</table>';

                        print '</form>';
                    ?>
        </form></div></div>
      </body>
      </html>
      

