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

    <script>


 $(document).ready(function() {
    var max_fields      = 100;
    var wrapper         = $(".insert");
    var add_button      = $(".add_form_field");
  
    var x = 1;
    $(add_button).click(function(e){
        e.preventDefault();
        if(x < max_fields){
            x++;
            $(wrapper).append('<div><br><input type="text" name="Commodity[]" style="width:250px;height:30px;" placeholder="Item"/>&nbsp<input type="text" name="Parts[]" style="width:90px;height:30px;" placeholder="Parts"/>&nbsp<input type="text" name="Qty[]" style="width:90px;height:30px;" placeholder="Qty"/>&nbsp<input type="text" name="Remark[]" style="width:280px;height:30px;" placeholder="Remark"/><a href="#" class="delete" >Delete</a></div>'); //add input box
        }
  else
  {
  alert('You Reached the limits')
  }
    });
  
    $(wrapper).on("click",".delete", function(e){
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});   
</script>
<script type="text/javascript">
  
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

var rowNum = 0;
function addRow(frm) {
  rowNum ++;
  var suppliers=document.getElementById("supplier").value;

  var row = '<p id="rowNum'+rowNum+'">';

 // row = row + '<select name="BrandName[]" id="BrandName'+rowNum+'"style="width:20%;height: 30px;" onchange="showCommo(this.value)" ><option value="" ></option>';
 
   row =  row +'<input type="text" name="BrandName[]"  id="BrandName'+rowNum+'" style="width:20%;height:30px;" required="required" autocomplete="off" onKeyUp="brand(\''+rowNum+'\')" placeholder="Brand" onchange="showCommo(this.value)" /><span id="suggesstion-box'+rowNum+'"></span>';

  var rows = '';
  <?php
    //         $Branches = $_SESSION['Branch'];
    //       if ($Branches == 'Shwe Pyi Thar Store') {
    //         $sqlp="SELECT Distinct BrandName FROM product Where Branch='Shwe Pyi Thar Store' Order by BrandName";}
    //       elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {
    //         $sqlp="SELECT Distinct BrandName FROM product Where Branch='Shwe Pyi Thar Store Control Panel' Order by BrandName";}
    //       elseif ($Branches == 'Yangon Show Room') {
    //         $sqlp="SELECT Distinct BrandName FROM product Where Branch='Yangon Show Room' Order by BrandName";}
    //       elseif ($Branches == 'Mandalay Show Room') {
    //         $sqlp="SELECT Distinct BrandName FROM product Where Branch='Mandalay Show Room' Order by BrandName";}
    //       elseif ($Branches == 'Naypyidaw Show Room') {
    //         $sqlp="SELECT Distinct BrandName FROM product Where Branch='Naypyidaw Show Room' Order by BrandName";}
    //       else {
    //         $sqlp="SELECT Distinct BrandName FROM product Where 1=1 Order by BrandName";} 
  
                        
    //         $resResultp = $con->query($sqlp);
    //           while ($rowp=mysqli_fetch_array($resResultp)) {
    //          // $BrandNames = $rowp["BrandName"];
    //          $BrandName = mysqli_real_escape_string($con,$rowp["BrandName"]);

    //           ?>
    //             rows = rows + '<option value="<?php echo htmlspecialchars($BrandName, ENT_QUOTES); ?>"';
    //             rows = rows + '><?php echo $BrandName; ?></option>';
               
    //   <?php
    //   }
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
<script>
    function showCommo(str) {
      var NPL_NO=document.getElementById("PL_NO").value;
      var Location=document.getElementById("Location").value;
      var Brand=document.getElementById("BrandName"+rowNum).value;
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
      var CommodityN= document.getElementById("NCommodity"+rowNum).value;
      // alert (CommodityN);
      var BrandNameN=document.getElementById("BrandName"+rowNum).value;
      var Location=document.getElementById("Location").value;
      var PL_NON=document.getElementById("PL_NO").value;
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
<script>
    function showPL(str) {
      var Nsupplier=document.getElementById("supplier").value;
      var Location=document.getElementById("Location").value;
      // alert(Nokyaku);
        if (str == "") {
            document.getElementById("plnumber").innerHTML = "";
            return;
        } else { 
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("plnumber").innerHTML = xmlhttp.responseText;
                }
            }
 
            xmlhttp.open("GET","get-pl-no.php?q="+str+"&Nsupplier="+Nsupplier+"&Location="+Location+"",true);
            xmlhttp.send();
        }
    }
</script> 
<body style="font-size: 10px;font-family:Tahoma, Geneva, sans-serif;">
<div id="outer-container" >
    <div id="scrollable">
                   <?php
                        
                        $sqls="SELECT ifNull(Max(id),0) as ID FROM product ";
                                              
                        $results=mysqli_query($con ,$sqls);             
                        
                        $i = 0;
                        print '<form method="POST" action="save.php">';
                      
                        print '<table style="width: 100%;margin-left:0%;margin-bottom: 100px;" id="customers">';

                         print '<tr><td style="width:8%;">Supplier Name</td><td><select name="supplier" id="supplier" style="height: 30px;width:20%;" required="required" onchange="showPL(this.value)">';
                        print'<option value =""></option>';


                        $selected = $_GET['selected']; 
                         $sqlp="SELECT * FROM supplier ORDER BY SupplierName";
                          $resResultp = $con->query($sqlp);
                          while ($rowp=mysqli_fetch_array($resResultp)) {
                          $UserId = $rowp["UserId"];
                          $rowp['SupplierName'] = rtrim($rowp['SupplierName'],",");
                          $SupplierName = $rowp["SupplierName"];
                        
                        print '<option value="'. $UserId.'"';
                            if($UserId == $selected)
                             { print ' selected= selected ';} 

                         print '>'. $SupplierName.'</option>';

                         }

                          print'</select></td></tr>'; 
                            $LUser = $_SESSION['login_user'];
                          print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';  

                        while($row = $results->fetch_assoc()){ 

                           $ID = $row['ID'] +1;
                $Branches = $_SESSION["Branch"];
         if ($Branches == "Shwe Pyi Thar Store") {
                          print '<tr><td style="width:8%;">Branch</td><td> 
           

                          <select name="Branch" id="Location" style="width:20%;height:30px;" onchange="showPL(this.value)">
                           <option value=""></option>
                             <option value="Shwe Pyi Thar Store">Shwe Pyi Thar Store</option>
                          </select></td></tr>'; 
          }
          
           elseif ($Branches == "Shwe Pyi Thar Store Control Panel") {
               print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="Branch" id="Location" style="width:20%;height:30px;" onchange="showPL(this.value)">
                           <option value=""></option>
                             <option value="Shwe Pyi Thar Store Control Panel">Shwe Pyi Thar Store Control Panel</option>
                          </select></td></tr>'; 
               
           }
          elseif ($Branches == "Yangon Show Room") {
              print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="Branch" id="Location" style="width:20%;height:30px;" onchange="showPL(this.value)">
                           <option value=""></option>
                             <option value="Yangon Show Room">Yangon Show Room</option>
                          </select></td></tr>'; 
              
          }
          elseif ($Branches == "Mandalay Show Room") {
              print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="Branch" id="Location" style="width:20%;height:30px;" onchange="showPL(this.value)">
                           <option value=""></option>
                             <option value="Mandalay Show Room">Mandalay Show Room</option>
                          </select></td></tr>'; 
              
          }
          elseif ($Branches == "Naypyidaw Show Room") {
              print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="Branch" id="Location" style="width:20%;height:30px;" onchange="showPL(this.value)">
                           <option value=""></option>
                             <option value="Naypyidaw Show Room">Naypyidaw Show Room</option>
                          </select></td></tr>'; 
              
          }
          else {print '<tr><td style="width:8%;">Branch</td><td>
                           <select name="Branch" id="Location" style="width:20%;height:30px;" onchange="showPL(this.value)">
                           <option value=""></option>
                           <option value="Shwe Pyi Thar Store">Shwe Pyi Thar Store</option>
                           <option value="Shwe Pyi Thar Store Control Panel">Shwe Pyi Thar Control Panel</option>
                           <option value="Yangon Show Room">Yangon Show Room</option>
                           <option value="Naypyidaw Show Room">Naypyidaw Show Room</option>
                           <option value="Mandalay Show Room">Mandalay Show Room</option>
                           </select></td></tr>'; 

              
          }                        
                           print '<tr><td>PL NO</td><td>';
                            print'<span  id="plnumber" ></span></td></tr>';

                           print '<tr><td>Commodity</td><td class="insert">';

                         print '<input onclick="addRow(this.form);" type="button" value="Add New Field" class="myAdd" required="required"/><br><br><div id="itemRows" required="required"></div>';

                          print'   </td></tr>';  

                        print '<tr><td>Return Date</td><td> <input type="date" name="Return_date" value=""  style="width:20%;height:30px;font-size:11px;" required="required"/></td></tr>'; 

                        print '<tr><td></td><td><input type="submit" value="Save" class="myButton"/></td></tr>';
                                                       
                            }
                        print '</table>';

                        print '</form>';
                    ?>
        </form></div><div>
               <!-- added by Myo Min -->
        <script src="../js/select2.min.js" type="text/javascript"></script>
          <script>
$("#supplier").select2( {
  placeholder: "Select Supplier",
  allowClear: true
  } );
</script>
 <!-- added by Myo Min -->
      </body>
      </html>
      

