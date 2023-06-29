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
            xmlhttp.open("GET","get-data.php?q="+str+"&rowNum="+rowNum+"&CommodityN="+CommodityN+"&BrandNameN="+BrandNameN+"&DO_NoN="+DO_NoN+"&okyaku="+okyaku+"&Location="+Location+"",true);
            xmlhttp.send();
        }
    }
</script> 
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

  row = row + '<select name="BrandName[]" id="BrandName'+rowNum+'"style="width:20%;height: 30px;" onchange="showCommo(this.value)" ><option value="" ></option>';

  var rows = '';
  <?php
              $Branches = $_SESSION['Branch'];
          if ($Branches == 'Shwe Pyi Thar Store') {
            $sqlp="SELECT Distinct BrandName FROM delivery Where Location='Shwe Pyi Thar Store' Order by BrandName";}
          elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {
            $sqlp="SELECT Distinct BrandName FROM delivery Where Location='Shwe Pyi Thar Store Control Panel' Order by BrandName";}
          elseif ($Branches == 'Yangon Show Room') {
            $sqlp="SELECT Distinct BrandName FROM delivery Where Location='Yangon Show Room' Order by BrandName";}
          elseif ($Branches == 'Mandalay Show Room') {
            $sqlp="SELECT Distinct BrandName FROM delivery Where Location='Mandalay Show Room' Order by BrandName";}
          elseif ($Branches == 'Naypyidaw Show Room') {
            $sqlp="SELECT Distinct BrandName FROM delivery Where Location='Naypyidaw Show Room' Order by BrandName";}
          else {
            $sqlp="SELECT Distinct BrandName FROM delivery Where 1=1 Order by BrandName";}    
            
         
                        
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
                      
                        print '<table style="width: 100%;margin-left:0%;" id="customers">';
 
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
      

