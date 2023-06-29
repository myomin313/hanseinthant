<?php session_start();?>
<?php 
      if (($_SESSION['login_session']<> true)) {
        header("Location:../index.php");    
        exit();
      }     

?>
<?php
$myusername = strtoupper($_SESSION['login_user']);
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
#brand-list{list-style:none;margin-top:-0px;padding:0;width:271px;}
#brand-list li{padding: 8px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
#brand-list li:hover{background:#d9d9d9;cursor: pointer;}
#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
input:focus, textarea:focus, select:focus{
        outline: none;
    }
</style>
    <script type="text/javascript">  
      /*function brand() {
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
      } */
 function selectBrand(obj,value) {
  rowNum = $(obj).parent().parent().parent().find('select').attr("id").replace("BrandName");
  $('#BrandName'+rowNum+'').val(value);
  $('#suggesstion-box'+rowNum+'').hide();
  showCommo(value);
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
<script src="../js/select2.min.js" type="text/javascript"></script>
<script>

var rowNum = 0;
function addRow(frm) {
  rowNum ++;
  var row = '<p id="rowNum'+rowNum+'">';
   


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
          $("#BrandName"+rowNum+"").select2( {
           placeholder: "Select Brandname",
           allowClear: true
          } );
      }
    });
  //row = row + '<select name="BrandName[]" id="BrandName'+rowNum+'" style="width:20%;height: 30px;" onchange="showCommo(this.value)" ><option value="" ></option>';

  //row =  row +'<input type="text" name="BrandName[]"  id="BrandName'+rowNum+'" style="width:20%;height:30px;" required="required" autocomplete="off" onKeyUp="brand(\''+rowNum+'\')" placeholder="Brand"/><span id="suggesstion-box'+rowNum+'"></span>';

    row = row+'<select name="BrandName[]" id="BrandName'+rowNum+'" style="width:20%;height:30px;"  autocomplete="off" required="required" onChange="showCommo(\''+rowNum+'\')" placeholder="Brand"/></select><span id="suggesstion-box'+rowNum+'"></span>';

  var rows = '';
  <?php
          /*$Branches = $_SESSION['Branch'];
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
      }*/
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

function brand(rowNum) {
        var min_length = 1; // min caracters to display the autocomplete
        var keyword = $('#BrandName'+rowNum+'').val();
        alert(keyword);

      //alert(keyword);
        // alert(keyword);
    
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
            //alert(encodeURIComponent(CommodityN));
            //xmlhttp.open("GET","get-data.php?q="+str+"&rowNum="+rowNum+"&CommodityN="+CommodityN+"&BrandNameN="+BrandNameN+"&Location="+Location+"",true);
            //xmlhttp.open("GET","get-commodity.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&Brand="+encodeURIComponent(Brand)+"&Location="+encodeURIComponent(Location)+"",true);
            xmlhttp.open("GET","get-data.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&CommodityN="+encodeURIComponent(CommodityN)+"&BrandNameN="+encodeURIComponent(BrandNameN)+"&Location="+encodeURIComponent(Location)+"",true);
            xmlhttp.send();
        }
    }

  //▽2019/08/16 Newton Add
  function fncQuantityCheck(id){
        if (!id.value.match(/^([0-9]{0,5})$/)) {
          id.value = id.value.replace(/[^0-9]/g, '').substring(0,5);
        }
      }

    function fncClearPl(rownum){
        $("#PL" + rownum).val("");
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
            $("#WIP" + rownum).val(' ');
            return false;
          }
          
        }else{
         
        }
      }
    });

      }
    //△

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
      //alert("hi");
      var Brand=document.getElementById("BrandName"+rowNum).value;
      //Brand=str;
     //alert(Brand);
      var Location=document.getElementById("Location").value;
      //alert(Location);

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
            xmlhttp.open("GET","get-commodity.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&Brand="+encodeURIComponent(Brand)+"&Location="+encodeURIComponent(Location)+"",true);
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

                        $selected ="";
                        if(isset($_GET['selected'])){
                          $selected = $_GET['selected']; 
                        }
                        
                        $sqlp="SELECT * FROM customer ORDER BY CustomerName";
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
        //  start
        //start for branch

        print '<tr><td style="width:7%;">Branch Name</td><td> <select name="Location" id="Location" style="width:20%;height:30px;" required="required">';
        print'<option value =""></option>';

        $selected = ""; 
        if(isset($_GET['selected'])){
          $selected = $_GET['selected']; 
        }
        //   if($_SESSION['Branch'] == 'All'){                             
        //  $sqlp="SELECT * FROM branch ORDER BY branch";
        // }else{
        //   $sqlp="SELECT * FROM branch WHERE branch='$Branches' ORDER BY branch";
         
        // }

        if($_SESSION['Branch'] == 1){                             
          $sqlp="SELECT * FROM branch WHERE id!=1 ORDER BY branch";
         }else{
           $branch=$_SESSION['Branch'];
           $sqlp="SELECT * FROM branch WHERE id='$branch' ORDER BY branch";
          
         }
          $resResultp = $con->query($sqlp);
          while ($rowp=mysqli_fetch_array($resResultp)) {
           $rowp['branch'] = rtrim($rowp['branch'],",");
          $branch = $rowp["branch"];
          $brid= $rowp['id'];

        print '<option value="'. $brid.'"';
            if($brid == $selected)
             { print ' selected= selected ';} 

         print '>'. $branch.'</option>';

         }

          print'</select></td></tr>';

        //end for branch

        // end
        //  if ($Branches == "Shwe Pyi Thar Store") {
        //                   print '<tr><td style="width:8%;">Branch</td><td> 
        //                   <select name="Location" id="Location" style="width:20%;height:30px;">
        //                     <option value=""></option>
        //                      <option value="Shwe Pyi Thar Store">Shwe Pyi Thar Store</option>
        //                   </select></td></tr>'; 
        //   }         
        //    elseif ($Branches == "Shwe Pyi Thar Store Control Panel") {
        //        print '<tr><td style="width:8%;">Branch</td><td>
        //                   <select name="Location" id="Location" style="width:20%;height:30px;">
        //                    <option value=""></option>
        //                      <option value="Shwe Pyi Thar Store Control Panel">Shwe Pyi Thar Store Control Panel</option>
        //                   </select></td></tr>'; 
               
        //    }
        //   elseif ($Branches == "Yangon Show Room") {
        //       print '<tr><td style="width:8%;">Branch</td><td>
        //                   <select name="Location" id="Location" style="width:20%;height:30px;">
        //                    <option value=""></option>
        //                      <option value="Yangon Show Room">Yangon Show Room</option>
        //                   </select></td></tr>'; 
              
        //   }
        //   elseif ($Branches == "Mandalay Show Room") {
        //       print '<tr><td style="width:8%;">Branch</td><td>
        //                   <select name="Location" id="Location" style="width:20%;height:30px;">
        //                    <option value=""></option>
        //                      <option value="Mandalay Show Room">Mandalay Show Room</option>
        //                   </select></td></tr>'; 
              
        //   }
        //   elseif ($Branches == "Naypyidaw Show Room") {
        //       print '<tr><td style="width:8%;">Branch</td><td>
        //                   <select name="Location"id="Location" style="width:20%;height:30px;">
        //                    <option value=""></option>
        //                      <option value="Naypyidaw Show Room">Naypyidaw Show Room</option>
        //                   </select></td></tr>'; 
              
        //   }
        //   else {print '<tr><td style="width:8%;">Branch</td><td>
        //                    <select name="Location" id="Location" style="width:20%;height:30px;">
        //                    <option value=""></option>
        //                    <option value="Shwe Pyi Thar Store">Shwe Pyi Thar Store</option>
        //                    <option value="Shwe Pyi Thar Store Control Panel">Shwe Pyi Thar Control Panel</option>
        //                    <option value="Yangon Show Room">Yangon Show Room</option>
        //                    <option value="Naypyidaw Show Room">Naypyidaw Show Room</option>
        //                    <option value="Mandalay Show Room">Mandalay Show Room</option>
        //                    </select></td></tr>';              
        //   }                           
                           
                                                   
                            $LUser = $_SESSION['login_user'];
                          print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';  
                           // print '<tr><td>JOB.No</td><td> <input type="number" name="JOB_No" value="" style="width:20%;height:30px;" required="required"/></td></tr>'; 

                          print '<tr><td>JOB.No</td><td> <input type="text" name="JOB_No" value="" style="width:10%;height:30px;" required="required"/>';

          //                  if ($Branches == "Shwe Pyi Thar Store") {
          //                 print '<select name="dep_name" id="dep_name" style="width:10%;height:30px;">
          //                    <option value="SPT">SPT</option>
          //                 </select>'; 
          // }
          
          //  elseif ($Branches == "Shwe Pyi Thar Store Control Panel") {
          //      print '<select name="dep_name" id="dep_name" style="width:10%;height:30px;">
          //                    <option value="CP">CP</option>
          //                 </select>'; 
               
          //  }
          // elseif ($Branches == "Yangon Show Room") {
          //     print '<select name="dep_name" id="dep_name" style="width:10%;height:30px;">
          //                    <option value="YSR">YSR</option>
          //                 </select>'; 
              
          // }
          // elseif ($Branches == "Mandalay Show Room") {
          //     print '<select name="dep_name" id="dep_name" style="width:10%;height:30px;">
          //                    <option value="MDY">MDY</option>
          //                 </select>'; 
              
          // }
          // elseif ($Branches == "Naypyidaw Show Room") {
          //     print '<select name="dep_name" id="dep_name" style="width:10%;height:30px;">
          //                    <option value="NPT">NPT</option>
          //                 </select>'; 
              
          // }
          // else {print '<select name="dep_name" id="dep_name" style="width:10%;height:30px;">
          //                  <option value=""></option>
          //                  <option value="SPT">SPT</option>
          //                  <option value="CP">CP</option>
          //                  <option value="YSR">YSR</option>
          //                  <option value="NPT">NPT</option>
          //                  <option value="MDY">MDY</option>
          //                  </select>';              
          // }  

                      //start

                      //start for branch

        print '<select name="dep_name" id="dep_name" style="width:10%;height:30px;" required="required">';
        print'<option value =""></option>';

        $selected = ""; 
        if(isset($_GET['selected'])){
          $selected = $_GET['selected']; 
        }
        //   if($_SESSION['Branch'] == 'All'){                             
        //  $sqlp="SELECT * FROM branch ORDER BY branch";
        // }else{
        //   $sqlp="SELECT * FROM branch  WHERE branch='$Branches' ORDER BY branch";
         
        // }

        if($_SESSION['Branch'] == 1){                             
          $sqlp="SELECT * FROM branch WHERE id!=1 ORDER BY branch";
         }else{
           $branch=$_SESSION['Branch'];
           $sqlp="SELECT * FROM branch WHERE id='$branch' ORDER BY branch";
          
         }

          $resResultp = $con->query($sqlp);
          while ($rowp=mysqli_fetch_array($resResultp)) {
           $rowp['short_term'] = rtrim($rowp['short_term'],",");
          $short_term = $rowp["short_term"];

        print '<option value="'. $short_term.'"';
            if($short_term == $selected)
             { print ' selected= selected ';} 

         print '>'. $short_term.'</option>';

         }

          // print'</select></td></tr>';

        //end for branch


                      // end

                          print '</select></td></tr>';  
                          
                          
                                                  
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
          <!-- added by Myo Min -->
          <script src="../js/select2.min.js" type="text/javascript"></script>
          <script>
$("#okyaku").select2( {
  placeholder: "Select customer",
  allowClear: true
  } );
</script>
<script type="text/javascript">
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>

<!-- added by Myo Min -->

      </body>
      </html>
      

