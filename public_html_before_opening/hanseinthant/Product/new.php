<?php session_start();?>
<?php  
      include_once('../config.php');
    //   include_once('../menu.php');
    include_once('../bar.php');
      include_once('../style.css');
      include_once('../header.php');
      if (($_SESSION['login_session']<> true)) {
        header("Location:../index.php");
        exit();
      }      
 ?>

 <?php if (isset($_SESSION['message'])): ?>
  <div class="err">
    <?php 
      echo $_SESSION['message']; 
      unset($_SESSION['message']);
    ?>
  </div>
<?php endif ?>

 <?php if (isset($_SESSION['tt'])): ?>
  <div class="err">
    <?php 
      echo $_SESSION['tt']; 
      unset($_SESSION['tt']);
    ?>
  </div>
<?php endif ?>


 <!-- 24/10/2019 develop by Winsan -->
          <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
          <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

          <script>
            $( function() {
             $( "#keyword" ).datepicker({
              dateFormat: "yy-mm-dd"
            });
           });
         </script>
<!-- 24/10/2019 develop by Winsan -->


<style>
#brand-list{list-style:none;margin-top:-0px;padding:0;width:271px;}
#brand-list li{padding: 8px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
#brand-list li:hover{background:#d9d9d9;cursor: pointer;}
#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
</style>
    <script type="text/javascript">  
      function brand(row) {
        rowNum = row;
        var min_length = 1; // min caracters to display the autocomplete
        var keyword = $('#search-box'+rowNum+'').val();
        console.log(keyword);
        if(keyword == ""){
          $('#suggesstion-box'+rowNum+'').hide();
          return;
        }
        // alert(keyword);
        if (keyword.length >= min_length && keyword != "") {
          $.ajax({
            url: '../Product/brandname.php?' ,
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
</script>
<style>

/*.frmSearch {border: 1px solid #a8d4b1;background-color: #c6f7d0;margin: 2px 0px;padding:40px;border-radius:4px;}*/
#Commodity-list{list-style:none;margin-top:-0px;padding-left: 240px;width:210px;}
#Commodity-list li{padding: 8px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
#Commodity-list li:hover{background:#d9d9d9;cursor: pointer;}
#Commodity{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
</style>
    <script type="text/javascript">  
      function Commodity(row) {
        rowNum= row;
        var min_length = 1; // min caracters to display the autocomplete
        var keyword = $('#Commodity'+rowNum+'').val();
        // alert(keyword);
        if(keyword == ""){
          $('#Commodity-box'+rowNum+'').hide();
        }

        if (keyword.length >= min_length) {
          $.ajax({
            url: '../Product/Commodity.php?' ,
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
      function myFunction(id)
      {
        var r = confirm("Are you sure you want to delete this record?");
        if(r == true)
        {
          window.location.assign("delete.php?id=" + id);
        }
      }

      function fncClearBox(obj,rowNum,type){
        if($(obj).val() == ""){
          switch (type) {
           case "brand":
                 $('#suggesstion-box'+rowNum+'').hide();
             break;
            case "commodity":
                //$('#Commodity-box'+rowNum+'').hide();
             break;
         
           default:
             break;
         }
        }
         
      }

</script>
<script>
var rowNum = 0;
function addRow(frm) {
  rowNum ++;
  var row = '<p id="rowNum'+rowNum+'">';

    row =  row +'<input type="text" name="BrandName[]"  id="search-box'+rowNum+'" style="width:20%;height:30px;" autocomplete="off" required="required" onblur="fncClearBox(this,'+rowNum+',\'brand\')" onKeyUp="brand('+rowNum+')" placeholder="Brand"/><span id="suggesstion-box'+rowNum+'"></span>&nbsp<input type="text" name="itemCommodity[]" autocomplete="off" id="Commodity'+rowNum+'" style="width:15%;height:30px;" onblur="fncClearBox(this,'+rowNum+',\'commodity\')" onKeyUp="Commodity('+rowNum+')" placeholder="Commodity" required="required"/><span id="Commodity-box'+rowNum+'"></span>&nbsp<select name="itemType[]" id="Type'+rowNum+'" style="width:4%;height:30px;" required="required"><option value=""></option><option value="Set">Set</option><option value="No">No</option><option value="Lot">Lot</option><option value="ft">ft</option><option value="mtrs">mtrs</option><option value="Coils">Coils</option><option value="kg">kg</option><option value="Yard">Yard</option></select>&nbsp<select name="Rate_Name[]" id="Rate_Name"  style="width:5%;height:30px;"><option value=""></option><option value="USD">USD</option><option value="Myanmar">Myanmar</option><option value="Singapore">Singapore</option><option value="Europe">Europe</option><option value="Thailand">Thailand</option><option value="British">British</option><option value="Japan">Japan</option><option value="Australia">Australia</option></select>&nbsp<input type="text" name="rate[]" id="rate'+rowNum+'" style="width:8%;height:30px;" placeholder="1 per/rate" onkeyup="out('+rowNum+')">&nbsp<input type="number" name="itemQty[]" id="itemQty'+rowNum+'" style="width:5%;height:30px;" placeholder="Qty" onkeyup="out('+rowNum+')"/>&nbsp<input type="text" name="totalRate[]" id="totalRate'+rowNum+'" style="width:8%;height:30px;" placeholder="rate" onkeyup="out('+rowNum+')">&nbsp<input type="text" name="itemRemarks_Item[]" style="width:25%;height:30px;" placeholder="Remark"/>&nbsp&nbsp&nbsp<input type="button" value="remove"  onclick="removeRow('+rowNum+');" class="removeitem"></p>';

  jQuery('#itemRows').append(row);
  frm.Price.value = '';
  frm.Product.value = '';
  frm.qty.value = '';
  frm.SubAmount.value = '';

}

function removeRow(rnum) {
  jQuery('#rowNum'+rnum).remove();
} 
      var u = 0;

        function out(x) {

               var  itemQty = Number(document.getElementById('itemQty'+x).value);
               // alert(itemQty);

               var  rate = Number(document.getElementById('rate'+x).value);
               // alert(itemUSD);

               var totalRate = (itemQty * rate);
               // alert(totalUSD);

               document.getElementById('totalRate'+x).value =totalRate;
        }
    </script>



    <script type="text/javascript">
      $(document).ready(function () {  
        $('#okyaku').change(function () {
          window.location.href = "new.php?selected="+ $(this).val()+"&Commodaties=";
        });  
        $('#Commodaties').change(function () {
          window.location.href = 'new.php?selected=' +$("#okyaku option:selected").val()+'&Commodaties='+this.options[this.selectedIndex].value+""; 
        });  
      });
    </script>
        <script type="text/javascript">  
      function checkdates() {
        var min_length =10; // min caracters 0to display the autocomplete
        var keyword = $('#keyword').val();
        if (keyword.length >= min_length) {
          $.ajax({
             url: 'checking.php?' ,
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
     <form method="POST" action="save.php">       

          <?php
            print '<table style="width: 100%;font-size: 11px; font-family:Tahoma, Geneva, sans-serif;margin-bottom:10%;" id="customers" >';
       
                     print '<tr><td style="width:7%;">Supplier Name</td><td> <select name="SupplierName" id="SupplierName" style="width:20%;height:30px;" required="required">';
                        print'<option value =""></option>';

                        $selected = ""; 
                        if(isset($_GET['selected'])){
                          $selected = $_GET['selected']; 
                        }
                       
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
         $Branches = $_SESSION["Branch"];
         if ($Branches == "Shwe Pyi Thar Store") {
                          print '<tr><td style="width:8%;">Branch</td><td> 
           

                          <select name="Branch" style="width:20%;height:30px;" required="required">
                             <option value="Shwe Pyi Thar Store">Shwe Pyi Thar Store</option>
                          </select></td></tr>'; 
          }
          
           elseif ($Branches == "Shwe Pyi Thar Store Control Panel") {
               print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="Branch" style="width:20%;height:30px;" required="required">
                             <option value="Shwe Pyi Thar Store Control Panel">Shwe Pyi Thar Store Control Panel</option>
                          </select></td></tr>'; 
               
           }
          elseif ($Branches == "Yangon Show Room") {
              print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="Branch" style="width:20%;height:30px;" required="required">
                             <option value="Yangon Show Room">Yangon Show Room</option>
                          </select></td></tr>'; 
              
          }
          elseif ($Branches == "Mandalay Show Room") {
              print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="Branch" style="width:20%;height:30px;" required="required">
                             <option value="Mandalay Show Room">Mandalay Show Room</option>
                          </select></td></tr>'; 
              
          }
          elseif ($Branches == "Naypyidaw Show Room") {
              print '<tr><td style="width:8%;">Branch</td><td>
                          <select name="Branch" style="width:20%;height:30px;" required="required">
                             <option value="Naypyidaw Show Room">Naypyidaw Show Room</option>
                          </select></td></tr>'; 
              
          }
          else {print '<tr><td style="width:8%;">Branch</td><td>
                           <select name="Branch" style="width:20%;height:30px;" required="required">
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
                          print '<tr><td>PL No</td><td> <input type="text" " name="Purchase_order_No" value=""  style="width:20%;height:30px;" required="required"/><span style="color:red;font-weight:bold;">&nbsp*&nbsp&nbspPlease make sure your PL No. </span>
  
                          </td></tr>'; 
                          print '<tr><td>PO No</td><td> <input type="text"  name="PO_NO" value=""  style="width:20%;height:30px;" /></td></tr>'; 
                          print '<tr><td>Date</td><td><input type="text" name="keyword" id="keyword" placeholder="YYYY-MM-DD" required pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" 
                          title="Enter a date in this format YYYY-MM-DD" style="width:20%;height:30px;font-size: 11px;" required="required" onKeyUp="checkdates()" required="required" autocomplete="off"/><span style="color:orange;font-weight:bold;">&nbsp*&nbsp&nbspPlease make sure your Date.Your date must be inserted in Daily Rate. </span>
                          </td></tr>'; 
                           print '<tr><td>Commodity</td><td class="insert">';
                           print '

                         <input onclick="addRow(this.form);" type="button" value="New Input" class="myAdd" required="required"/><div id="item"></div><div id="itemRows" required="required"></div>

                          </td></tr>';  

                          print '<tr><td>
                          </td><td><input type="submit" value="Save" class="myButton" onclick="confirm(Are you sure you want to save this?)"/></td></tr>'; 
                                 
                          print '</table>';

                        print'<br>';
                        print'<br>';
                        print '</form>';
                               
          ?>
          
        </form>
            </div>
</div>
 <!-- added by Myo Min -->
      <script src="../js/select2.min.js" type="text/javascript"></script>
          <script>
$("#SupplierName").select2( {
  placeholder: "Select Supplier",
  allowClear: true
  } );
</script>
 <!-- added by Myo Min -->

      </body>
      </html>

