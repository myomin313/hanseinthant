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
     /* function brand() {
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
      } */

      // function brand(rowNum) {
      //   var min_length = 1; // min caracters to display the autocomplete
      //   var keyword = $('#NBrandName'+rowNum+'').val();
      //   // alert(keyword);
      //   if (keyword.length >= min_length) {
      //     $.ajax({
      //       url: 'brandname.php' ,
      //       type: 'POST',
      //       data: {
      //         keyword: keyword
      //       },
      //       success: function(data) {             
      // $('#suggesstion-box'+rowNum+'').show();
      // $('#suggesstion-box'+rowNum+'').html(data);
      // $('#NBrandName'+rowNum+'').css("background","#FFF");
      //       }
      //     });
      //   }
      //   else 
      //   {
      //     $('#suggesstion-box').hide();
      //   }
      // }      

 function selectBrand(obj,value) {
  rowNum = $(obj).parent().parent().parent().find('select').attr("id").replace("NBrandName");
  $('#NBrandName'+rowNum+'').val(value);
  $('#suggesstion-box'+rowNum+'').hide();
  showCommo(value);
}
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
<script src="../js/select2.min.js" type="text/javascript"></script>
<script>
var rowNum = 0;
function addRow(frm) {
  rowNum ++;
  var row = '<p id="rowNum'+rowNum+'">';

  //row = row + '<select name="NBrandName[]" id="NBrandName'+rowNum+'" style="width:20%;height: 30px;" onchange="showCommo(this.value)" ><option value="" ></option>';
  // myo min closed
  // row =  row +'<input type="text" name="BrandName[]"  id="NBrandName'+rowNum+'" style="width:20%;height:30px;" required="required" autocomplete="off" onKeyUp="brand(\''+rowNum+'\')" placeholder="Brand"/><span id="suggesstion-box'+rowNum+'"></span>';
  //myo min closed
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
        /*    $Branches = $_SESSION['Branch'];
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

    row =  row +'&nbsp&nbsp<input type="button" value="Submit" class="updateitem" onclick="save('+rowNum+')"><input type="button" value="remove" onclick="removeRow('+rowNum+');" class="removeitem"></p>';
    
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
      var CommodityN= document.getElementById("NCommodity"+rowNum).value;
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
            xmlhttp.open("GET","get-datas.php?q="+encodeURIComponent(str)+"&rowNum="+encodeURIComponent(rowNum)+"&CommodityN="+encodeURIComponent(CommodityN)+"&BrandNameN="+encodeURIComponent(BrandNameN)+"&Location="+encodeURIComponent(Location)+"",true);
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
       var dep_name= document.getElementById('dep_name').value;
       var LUser= document.getElementById('LUser').value;
              
       var NBrandName= document.getElementById('NBrandName'+rowNum).value;
       // alert(NBrandName);
       var NCommodity= document.getElementById('NCommodity'+rowNum).value;
       var Ncode= document.getElementById('Ncode'+rowNum).value;
       var NType= document.getElementById('NType'+rowNum).value;
       var NPL= document.getElementById('NPL'+rowNum).value;
       // alert(NPL);
       var NWIP= document.getElementById('NWIP'+rowNum).value;
       var NRemark= document.getElementById('NRemark'+rowNum).value;
     
       window.location.href = "updatenew.php?id="+encodeURIComponent(rowNum)+"&LUser="+encodeURIComponent(LUser)+"&Location="+encodeURIComponent(Location)+"&okyaku="+encodeURIComponent(okyaku)+"&Job_date="+encodeURIComponent(Job_date)+"&Project="+encodeURIComponent(Project)+"&JOB_No="+encodeURIComponent(JOB_No)+"&dep_name="+encodeURIComponent(dep_name)+"&NBrandName="+encodeURIComponent(NBrandName)+"&NCommodity="+encodeURIComponent(NCommodity)+"&Ncode="+encodeURIComponent(Ncode)+"&NType="+encodeURIComponent(NType)+"&NPL="+encodeURIComponent(NPL)+"&NWIP="+encodeURIComponent(NWIP)+"&NRemark="+encodeURIComponent(NRemark)+""; 
    }

  //▽2019/08/16 Newton Add
  function fncQuantityCheck(id){
        if (!id.value.match(/^([0-9]{0,5})$/)) {
          id.value = id.value.replace(/[^0-9]/g, '').substring(0,5);
        }
      }
     
    function fncClearPl(rownum){
        $("#NPL" + rownum).val("");
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
            $("#NWIP" + rownum).val(' ');
            return false;
          }
          
        }else{
         
        }
      }
    });

      }
    //△


    </script>  

 <body style="font-size: 11px; font-family:Tahoma, Geneva, sans-serif;">     
      <?php 

        $Customer=$_GET['Customer'];
        $JOB_NO=$_GET['JOB_NO'];   
        $Branch=$_GET['Branch']; 
        $_SESSION['page'] = "detail";      
      
        //$total_sum = "SELECT BrandName FROM job WHERE Customer='$Customer' AND Job_No='$JOB_NO' and Location='$Branch'";
        
       // echo $total_sum;exit();
        
        //$result1 = mysqli_query($con, $total_sum);
        // while($rows = mysqli_fetch_array($result1)) {
        //   $sum = $rows['count_rows'];
        // } 
        

            $sql_item ="SELECT 
            UserId,
            CustomerName AS Customers,
            Location,
            branch.branch as branch_name,
            Job_date,
            Project,
            Job_No
            FROM job
            Left join customer
            on customer.UserId= job.Customer
            JOIN branch ON job.Location= branch.id
            WHERE  Customer='$Customer' AND Job_No='$JOB_NO' and Location='$Branch'
            GROUP BY 
            UserId,
            CustomerName,
            Location,
            Job_date,
            Project,
            Job_No
            ";
        $result = mysqli_query($con, $sql_item);
        
        $item_array1 = '';
        print '<form method="POST" action="updateCustomer.php?">';
       print '<table style="width: 100%;margin-left:0%;width: 100%;margin-left:0%;margin-bottom:10%;" id="customers">';

        while($row = mysqli_fetch_array($result)) {
            /*$Commoditys= $row['Commodity']; 
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
            $Remarks_Item=htmlspecialchars($Remarks_Items, ENT_COMPAT);*/

            $Customers= $row['Customers']; 
           
            $row['Customers'] = rtrim($row['Customers'],",");
            $Customers= $row['Customers'];

   // $str=preg_replace('/[a-z](?=\\d)/i', '$0 ', $row['Job_No']);
    // $string= preg_match_all( '!\d+!', $row['Job_No'], $matches );
  //  print_r($string);exit();
       //preg_match("/(\\d+)([a-zA-Z]+)/",$row['Job_No'], $matches);
    //   start

                  

                  $resResultpshort =mysqli_query($con,"SELECT short_term FROM branch Order By short_term");

                  $arr = array();
                  // look through query
                  while($rrow = mysqli_fetch_assoc($resResultpshort)){                  
                    // add each row returned into an array
                    $arr[] = $rrow['short_term'];
                  }

                  
              
         
         // $arr = array('SPT','CP','YSR','NPT','MDY');
                foreach ($arr as $url) {
        if (strpos($row['Job_No'], $url) !== FALSE) {
               $pieces = explode($url,$row['Job_No'], 2);
                $ssurl        = $url;
               }
          }    
              
           
              
    //end
// $data['job_string'] = $aa[1];
// $data['job_integer'] = $aa[2];
// var_dump($data['job_string']);exit();

//print("Integer component: " . $matches[1] . "\n");
//print("Letter component: " . $matches[2] . "\n");
   
         
                   //print '<input type="hidden" name="hidID" value="' . $row['id']. '"';

                    print'<tr><td>Customer Name</td><td>
                   <select name="okyaku" id="okyaku" style="width:20%;height:30px;font-size:10px;background:#f2f2f2;"><option value="'.$Customer.'">'.$Customers.'</option>';

                           $sqlp="SELECT * FROM customer Order By CustomerName";
                           $resResultp = $con->query($sqlp);
                           while ($rowp=mysqli_fetch_array($resResultp)) {
                           $rowp['CustomerName'] = rtrim($rowp['CustomerName'],",");
                           $CustomerNames = $rowp["CustomerName"];
                           $UserId = $rowp["UserId"];

                        print'<option value ="'.$UserId.'" style="width:200px;height:30px;background:#f2f2f2;" readonly="readonly" >'.$CustomerNames.'</option>';
                          }

                    print'</select></td></tr>';  

                    print '<tr><td>Branch</td><td> 
                           <select name="Location" id="Location" style="width:20%;height:30px;font-size: 10px;background:#f2f2f2;" readonly="readonly">
                           <option value="' . $row['Location']. '">' . $row['branch_name']. '</option>

                           </select>
                           </td></tr>'; 

                  //  print '<tr><td>Branch </td><td> <input type="text" name="Location" id="Location" value="' . $row['Location']. '" style="width:20%;height:30px;font-size: 11px;background:#f2f2f2;font-size:10px;" readonly/></td></tr>';   

                    print '<tr><td>Job Order Date </td><td> <input type="date" name="Job_date" id="Job_date" value="' . $row['Job_date']. '" style="width:20%;height:30px;font-size: 11px;background:#f2f2f2;font-size:10px;" readonly/></td></tr>';
                    print '<tr><td>Project</td><td> <input type="text" name="Project" id="Project" value="' . $row['Project']. '" style="width:20%;height:30px;font-size: 10px;background:#f2f2f2;font-size:10px;" readonly/></td></tr>';  
                           $LUser = $_SESSION['login_user'];
                    print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';
                    print'<input type="hidden" name="oldCustomer" id="oldCustomer" value="'.$Customer.'" style="width:250px;height:30px;" />';
                    print'<input type="hidden" name="oldBranch" id="oldBranch" value="'.$Branch.'" style="width:250px;height:30px;" />';
                    print'<input type="hidden" name="oldJOB_NO" id="oldJOB_NO" value="'.$JOB_NO.'" style="width:250px;height:30px;"/>';                     
                    print '<tr><td>JOB No</td><td> <input  type="text" name="JOB_No" id="JOB_No" value="' . $pieces[0]. '" style="width:10%;height:30px;font-size:10px;" />';

                        $Branches = $_SESSION["Branch"];

          //            if ($Branches == "Shwe Pyi Thar Store") {
          //                 print '<select name="dep_name" id="dep_name" style="width:10%;height:30px;">
          //                   <option value="'.$match.'">'.$match.'</option>";
          //                    <option value="SPT">SPT</option>
          //                 </select>'; 
          // }
          
          //  elseif ($Branches == "Shwe Pyi Thar Store Control Panel") {
          //      print '<select name="dep_name" id="dep_name" style="width:10%;height:30px;">
          //                    <option value="'.$match.'">'.$match.'</option>";
          //                    <option value="CP">CP</option>
          //                 </select>'; 
               
          //  }
          // elseif ($Branches == "Yangon Show Room") {
          //     print '<select name="dep_name" id="dep_name" style="width:10%;height:30px;">
          //          <option value="'.$match.'">'.$match.'</option>";
          //                    <option value="YSR">YSR</option>
          //                 </select>'; 
              
          // }
          // elseif ($Branches == "Mandalay Show Room") {
          //     print '<select name="dep_name" id="dep_name" style="width:10%;height:30px;">
          //         <option value="'.$match.'">'.$match.'</option>";
          //                    <option value="MDY">MDY</option>
          //                 </select>'; 
              
          // }
          // elseif ($Branches == "Naypyidaw Show Room") {
          //     print '<select name="dep_name" id="dep_name" style="width:10%;height:30px;">
          //         <option value="'.$match.'">'.$match.'</option>";
          //                    <option value="NPT">NPT</option>
          //                 </select>'; 
              
          // }
          // else {print '<select name="dep_name" id="dep_name" style="width:10%;height:30px;">
          //                  <option value="'.$match.'">'.$match.'</option>";
          //                  <option value="SPT">SPT</option>
          //                  <option value="CP">CP</option>
          //                  <option value="YSR">YSR</option>
          //                  <option value="NPT">NPT</option>
          //                  <option value="MDY">MDY</option>
          //                  </select>';              
          // }  
          //start
          if(isset($ssurl)){
            $selected = $ssurl; 
          }

        
  
          print '<select name="dep_name" id="dep_name" style="width:10%;height:30px;" required="required">';
        // print'<option value =""></option>';

       

       
        //if($_SESSION['Branch'] == 'All'){                             
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

        print '<option value="'.$short_term.'"';
            if($short_term == $selected)
             { print ' selected= selected ';} 

         print '>'. $short_term.'</option>';

         }

          //end
                    print"</select></td></tr>";
                    print '<tr><td></td><td><input type="submit" name="submit" value="Update"  class="updateitem"></td></tr>';
                    print'<tr><td>Commodity</td><td>';                  
                    print '<input onclick="addRow(this.form);" type="button" value="New item" class="myAdd" /><div id="item"></div><div id="itemRows"></div>';print'<br>';
                    print'<input type="checkbox" id="selectall"/>Check All';
                    print '<input  type="button"  value="Delete All"  class="deleteitemall"/></div>';
                    print'<br>';
                      
        }

        $sql_item ="SELECT 
            job.id,
            brandname.brandname as BrandName,
            commodity.commodity as Commodity,
            code.code as code_no,
            job.code as coid,
            job.brandname as bid,
            job.commodity as cid,
            job.Type,
            job.PL,
            job.WIP,
            job.Remarks_Item 
            FROM job
            Left join customer
            on customer.UserId= job.Customer
            Left join code
            on code.id= job.code
            LEFT JOIN brandname
            ON job.BrandName= brandname.id
            LEFT JOIN commodity
            ON job.Commodity= commodity.id
            WHERE  Customer='$Customer' AND Job_No='$JOB_NO' and Location='$Branch'";
 
              
            $result = mysqli_query($con, $sql_item);
            while($row = mysqli_fetch_array($result)) {
             print'<input type="checkbox" name="jobId" id="id" value="' . $row["id"] .'">';

              // print '<input  type="text" name="BrandName[]" id="NBrandName'. $row["id"].'" value="' . htmlspecialchars($row["BrandName"], ENT_COMPAT). '" style="width:20%;height:30px;background:#f2f2f2;font-size:10px;" readonly=readonly/>';
         print '<select name="BrandName[]" id="NBrandName'. $row['id'].'" style="width:20%;height:30px;background:#f2f2f2;" required="required" readonly >';

         print'<option style="width:200px;height:30px;font-size: 10px;" value="'.$row['bid'].'">'. htmlspecialchars($row['BrandName'], ENT_COMPAT).'</option>';
          print'</select>';

             // print '&nbsp&nbsp<input  type="text" name="Commodity[]" id="Commodity'. $row["id"].'" value="' . htmlspecialchars($row["Commodity"], ENT_COMPAT). '" style="width:15%;height:30px;background:#f2f2f2;font-size:10px;" readonly=readonly/>';
            print '<select name="Commodity[]" id="Commodity'. $row['id'].'" style="width:20%;height:30px;background:#f2f2f2;" required="required" readonly >';            
            print'<option style="width:200px;height:30px;font-size: 10px;" value="'.$row['cid'].'">'. htmlspecialchars($row['Commodity'], ENT_COMPAT).'</option>';
          print'</select>';

          print '<select name="code[]" id="code'. $row['id'].'" style="width:20%;height:30px;background:#f2f2f2;" required="required" readonly >';            
            print'<option style="width:200px;height:30px;font-size: 10px;" value="'.$row['coid'].'">'. htmlspecialchars($row['code_no'], ENT_COMPAT).'</option>';
          print'</select>';

              print'&nbsp&nbsp<select name="Type[]" id="Type'. $row["id"].'" style="width:4%;height:30px;font-size:10px;">
              <option value="' .htmlspecialchars($row["Type"], ENT_COMPAT). '">' .htmlspecialchars($row["Type"], ENT_COMPAT). '</option>
               <option value="Set">Set</option><option value="No">No</option><option value="Lot">Lot</option><option value="ft">ft</option><option value="mtrs">mtrs</option><option value="Coils">Coils</option><option value="kg">kg</option><option value="Yard">Yard</option>            
              </select>';        
     
              print'&nbsp&nbsp<select name="PL[]" id="PL'. $row["id"].'" style="width:10%;height:30px;font-size:10px;background:#f2f2f2;" readonly=readonly>
               <option value="' .htmlspecialchars($row["PL"], ENT_COMPAT). '">' .htmlspecialchars($row["PL"], ENT_COMPAT). '</option>';
              print'</select>';           
              print '&nbsp&nbsp<input type="text" name="WIP[]" id="WIP'. $row["id"].'" value="'. htmlspecialchars($row["WIP"], ENT_COMPAT).'" style="width:5%;height:30px;font-size:10px;" onkeyup="cal('. $row["id"].')" />';        
              print '&nbsp&nbsp<input  type="text" name="Remarks_Item[]" id="Remarks_Item'. $row["id"].'" value="' . htmlspecialchars($row["Remarks_Item"], ENT_COMPAT). '" style="width:30%;height:30px;font-size:10px;"/>';                            
              print '<input type="hidden" name="id_no[]" value="'.$row["id"].'">';
              print '&nbsp<input type="button" name="update_ids" value="Update" class="updateitem" onclick="update(' . $row["id"] .')">
              &nbsp&nbsp<input type="button" name="Delete_ids" value="Delete" class="deleteitem" onclick="Delete(' . $row["id"] .')">
             <br><br>'; 
   
            }


      /*  $Commodity = explode(',', $Commodity);
        $Type = explode(',', $Type);
        $WIP = explode(',', $WIP);
        $BrandName = explode(',', $BrandName);
        $Remarks_Item = explode(',', $Remarks_Item);
        $id = explode(',', $id);
        $PL = explode(',', $PL);

        for ($i=0; $i < $sum ; $i++) { 
            print '<input  type="text" name="BrandName[]" id="NBrandName'. $id[$i].'" value="' . $BrandName[$i]. '" style="width:20%;height:30px;background:#f2f2f2;font-size:10px;" readonly=readonly/>';

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
        }*/   


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
       var dep_name= document.getElementById('dep_name').value;
       var LUser= document.getElementById('LUser').value;              
       var BrandName= document.getElementById('NBrandName'+id).value;
       var Commodity= document.getElementById('Commodity'+id).value;
       var code= document.getElementById('code'+id).value;
       var Type= document.getElementById('Type'+id).value;
       var PL= document.getElementById('PL'+id).value;
       var WIP= document.getElementById('WIP'+id).value;
       var Remarks_Item= document.getElementById('Remarks_Item'+id).value;

       window.location.href = "update.php?id="+encodeURIComponent(id)+"&LUser="+encodeURIComponent(LUser)+"&Location="+encodeURIComponent(Location)+"&okyaku="+encodeURIComponent(okyaku)+"&Job_date="+encodeURIComponent(Job_date)+"&Project="+encodeURIComponent(Project)+"&JOB_No="+encodeURIComponent(JOB_No)+"&dep_name="+encodeURIComponent(dep_name)+"&BrandName="+encodeURIComponent(BrandName)+"&Commodity="+encodeURIComponent(Commodity)+"&code="+encodeURIComponent(code)+"&Type="+encodeURIComponent(Type)+"&PL="+encodeURIComponent(PL)+"&WIP="+encodeURIComponent(WIP)+"&Remarks_Item="+encodeURIComponent(Remarks_Item)+""; 
         // alert(Region);

    }
        function Delete(id)
    {

       var Location= document.getElementById('Location').value;
       var okyaku= document.getElementById('okyaku').value;
       var Job_date= document.getElementById('Job_date').value;
       var Project= document.getElementById('Project').value;
       var JOB_No= document.getElementById('JOB_No').value;
       var dep_name= document.getElementById('dep_name').value;
       var LUser= document.getElementById('LUser').value;
              
       var BrandName= document.getElementById('NBrandName'+id).value;
       var Commodity= document.getElementById('Commodity'+id).value;
       var code= document.getElementById('code'+id).value;
       var Type= document.getElementById('Type'+id).value;
       var PL= document.getElementById('PL'+id).value;
       var WIP= document.getElementById('WIP'+id).value;
       var Remarks_Item= document.getElementById('Remarks_Item'+id).value;

       //window.location.href = "delete.php?id="+id+"&LUser="+LUser+"&Location="+Location+"&okyaku="+okyaku+"&Job_date="+Job_date+"&Project="+Project+"&JOB_No="+JOB_No+"&BrandName="+BrandName+"&Commodity="+Commodity+"&Type="+Type+"&PL="+PL+"&WIP="+WIP+"&Remarks_Item="+Remarks_Item+""; 
       window.location.href = "delete.php?id="+encodeURIComponent(id)+"&LUser="+encodeURIComponent(LUser)+"&Location="+encodeURIComponent(Location)+"&okyaku="+encodeURIComponent(okyaku)+"&Job_date="+encodeURIComponent(Job_date)+"&Project="+encodeURIComponent(Project)+"&JOB_No="+encodeURIComponent(JOB_No)+"&dep_name="+encodeURIComponent(dep_name)+"&BrandName="+encodeURIComponent(BrandName)+"&Commodity="+encodeURIComponent(Commodity)+"&code="+encodeURIComponent(code)+"&Type="+encodeURIComponent(Type)+"&PL="+encodeURIComponent(PL)+"&WIP="+encodeURIComponent(WIP)+"&Remarks_Item="+encodeURIComponent(Remarks_Item)+""; 
         // alert(Region);

    }

  </script>
   <!-- myomin 24-12-2019 -->
  <script type="text/javascript">
      $('#selectall').click(function() { $(this.form.elements).filter(':checkbox').prop('checked', this.checked);
});
    $('.deleteitemall').on('click',function(){
      var jobId = [];
        $("input:checkbox[name=jobId]:checked").each(function(){
            jobId.push($(this).val());
          });

        var LUser= document.getElementById('LUser').value;
        var Location= document.getElementById('Location').value;
        var okyaku= document.getElementById('okyaku').value;
        var JOB_No= document.getElementById('JOB_No').value;
        var dep_name=document.getElementById('dep_name').value;
         window.location.href="remove.php?ids="+jobId+"&LUser="+LUser+"&Location="+Location+"&okyaku="+okyaku+"&JOB_No="+JOB_No+"&dep_name="+dep_name+"";

     });
  </script>
  <script type="text/javascript">
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>

