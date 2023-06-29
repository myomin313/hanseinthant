<?php session_start();?>
<?php 
      if (($_SESSION['login_session']<> true)) {
        header("Location:../index.php");    
        exit();
      }     

?>
<?php 
      include_once('../config.php');
      include_once('../listbar.php');
      include_once('../style.css');
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
$myusername = $_SESSION['login_user'];

    ?>  
        
<!doctype html>
<html>
<head>
 
<script type="text/javascript">
              function checkAll(o) {
              var boxes = document.getElementsByTagName("input");
              for (var x = 0; x < boxes.length; x++) {
                var obj = boxes[x];
                if (obj.type == "checkbox") {
                  if (obj.name != "check")
                    obj.checked = o.checked;
                  }
              }
            }
              function setHistoryAction() {      
                window.open("about:blank","history","width=640,height=480,scrollbar=yes");
                document.approve.action = "history.php?year=&month=&day=&selected=";
                document.approve.method = "post";
                document.approve.target = "history";
                document.approve.submit();
            }  
</script>

</head>

    <script type="text/javascript">  
      function searching() {
        var min_length = 1; // min caracters to display the autocomplete
        var keyword = $('#keywords').val();
        // alert(keyword);
        if (keyword.length >= min_length) {
          $.ajax({
            url: '../SupplierReturn/autofill.php?' ,
            type: 'POST',
            data: {
              keyword: keyword
            },
            success: function(data) {
      $('#searching-box').show();
      $('#searching-box').html(data);
      $('#keyword').css("background","#FFF");
            }
          });
        }
        else 
        {
          $('#searching-box').hide();
        }
      } 

    //  function set_items(items) {

    //   var string = items; 
    //   var newstring = string.replace(/[&\/\\#,+()$~%.':*?<>{}]/g,"\\$&")       

    //     $('#namelist').hide();
         
    //     $('#searching-box').hide();
    //       window.location.href = 'list.php?namelist='+newstring+'&month=&day=';

    //   }
         function set_items(items) {

       var string = items; 
       var newstring = string.replace(/[&\/\\#,+()$~%.':*?<>{}]/g,"\\$&");       
        
        // $('#keywords').val(items);
        //  alert(items);
        // var string = addslashes(items);
       // $('#keywords').val(items);
        // hide proposition list
        string = window.encodeURIComponent(newstring);
        // console.log(newstring);
        // alert(newstring);
        $('#namelist').hide();
         
        $('#searching-box').hide();
          window.location.href = 'list.php?namelist='+string+'&year=&month=&day=';

      }

</script>
    <script type="text/javascript">
      $(document).ready(function () {  
        $('#year').change(function () {
          window.location.href = "list.php?year="+ $(this).val()+"&month="+"&day=&namelist=&brandsearch=";
        });      
        $('#month').change(function () {
          window.location.href = 'list.php?year=' +$("#year option:selected").val()+'&month='+this.options[this.selectedIndex].value+"&day=&namelist=&brandsearch="; 
        });
        $('#day').change(function () {
          window.location.href = 'list.php?year=' +$("#year option:selected").val()+'&month='+$("#month option:selected").val()+'&day='+this.options[this.selectedIndex].value+"&namelist=&brandsearch="; 
        }); 
                
      });
    </script>    


  </head>
 <body style="font-size: 10px; font-family:Tahoma, Geneva, sans-serif;">

    <div class="col-md-12"   style="margin-top:1%;">
<input type="text" id="keywords" style="margin-left: 7px;width: 15%;" onKeyUp="searching()" placeholder="search..." /><span id="searching-box"></span>
      <select name="year" onchange="javascript:valueselect()" id="year" class="hidden-print" style="height:25px;margin-left: 5%;">
        <option value=""></option>
          <?php 
            $year = date('Y');
            $min = $year - 10;
            $max = $year;
             $year = $_GET['year'];
            for( $y=$max; $y>=$min; $y-- ) {
              print '<option value="'. $y.'"';

              if($y == $year)
              { print ' selected= selected ';} 
              print '>'.$y.'</option>';
            }
          ?>
      </select>

      <span id="year" >&nbspYear</span>
      <select name="month" id="month" onchange="javascript:valueselect()" class="hidden-print" style="height:25px;">
        <option value=""></option>
          <?php 
            $month = $_GET['year'];
            for( $m=1; $m<=12; ++$m ) { 
              // $month_label = date('F', mktime(0, 0, 0, $m, 1));
              print '<option value="'. $m.'"';
              if( $_GET['month'] == $m)
              { print ' selected= selected ';} 
              print '>' . date('F', mktime(0, 0, 0, $m, 1)) . '</option>';
            }   
          ?>
      </select> 

      <span id="month" >&nbspMonth</span>
      <select name="day" id="day" onchange="javascript:valueselect()" class="hidden-print" style="height:25px;">
        <option value=""></option>
          <?php 
            $start_date = 1;
            $end_date   = 31;
            $day = $_GET['year'];
            for( $d=$start_date; $d<=$end_date; $d++ ) {
              // echo '<option value='.$d.'>'.$d.'</option>';
              print '<option value="'. $d.'"';
              if( $_GET['day'] == $d)
              { print ' selected= selected ';} 
              print '>' . $d . '</option>';
            }
          ?>
      </select>

      <span id="day" >&nbspDay</span>   
       <a href="new.php" class="history printadd" style="margin-left:50%;">+&nbspADD NEW</a>

     
    </div>


  </div>
<form  name="approve" method="post" action=""> 

<div id="outer-container">
    <div id="scrollable" style="height:710px;">
    <table id="emp_table" border="0" class="resultGridTable" style="width: auto;margin-top: 1%;font-size:10px;">
        <tr class="tr_header" style="background-color:#3385ff;font-family:Tahoma, Geneva, sans-serif;font-size: 12px;">
                  <th  rowspan="2" style="width:2%;">S/N</th>
                  <th class="checkall" rowspan="2" style="width:2%;"> 
                    <input type="checkbox" name="check_all" id="check_all" onclick="javascript:checkAll(this)" class="hidden-print"  style="margin-left: 0px;" />
                   </th>       
                  <th  rowspan="2" style="width:2%;" class="action">Action</th>
                  <th  rowspan="2" style="width:5%;">Return Date</th>
                  <th  rowspan="2" style="word-wrap:break-word;">Supplier</th>
                  <th  rowspan="2" style="word-wrap:break-word;">PL NO</th>
                  <th  rowspan="2" style="font-weight:normal;word-wrap:break-word;" >Brand</th>
                  <th colspan="4" style="font-weight:normal;word-wrap:break-word;" >Commodity</th>
        </tr>
                  <tr>
                    <th style="font-weight:normal;word-wrap:break-word;" class="stock">Item</th>
                  <th style="font-weight:normal;" class="stock">Qty</th>
                  <th style="font-weight:normal;" class="stock">Type</th>
                  <th style="font-weight:normal;word-break: break-all;" class="stock">Remark</th></tr>       

        <?php

       $Branches = $_SESSION['Branch'];
      if ($Branches == 'Shwe Pyi Thar Store') {
          $sqlA=" SELECT *, supplier.SupplierName as Supplier,supplier_return.Supplier as sSupplier,
                  supplier_return.BrandName as BrandName,
                  supplier_return.Commodity as Commodity,
                  supplier_return.Qty as Qty,
                  supplier_return.Type  as Type,
                  supplier_return.Remark_item  as Remarks_Item
                  FROM supplier_return 
                  LEFT JOIN supplier
                  ON supplier_return.Supplier= supplier.UserId


                  WHERE supplier_return.Branch='Shwe Pyi Thar Store' ";}
      elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {
          $sqlA=" SELECT *, supplier.SupplierName as Supplier,supplier_return.Supplier as sSupplier,
                  supplier_return.BrandName as BrandName,
                  supplier_return.Commodity as Commodity,
                  supplier_return.Qty as Qty,
                  supplier_return.Type  as Type,
                  supplier_return.Remark_item  as Remarks_Item
                  FROM supplier_return 
                  LEFT JOIN supplier
                  ON supplier_return.Supplier= supplier.UserId


                  WHERE supplier_return.Branch='Shwe Pyi Thar Store Control Panel' ";}
      elseif ($Branches == 'Yangon Show Room') {
          $sqlA=" SELECT *, supplier.SupplierName as Supplier,supplier_return.Supplier as sSupplier,
                  supplier_return.BrandName as BrandName,
                  supplier_return.Commodity as Commodity,
                  supplier_return.Qty as Qty,
                  supplier_return.Type  as Type,
                  supplier_return.Remark_item  as Remarks_Item
                  FROM supplier_return 
                  LEFT JOIN supplier
                  ON supplier_return.Supplier= supplier.UserId


                  WHERE supplier_return.Branch='Yangon Show Room' ";}
      elseif ($Branches == 'Mandalay Show Room') {
          $sqlA=" SELECT *, supplier.SupplierName as Supplier,supplier_return.Supplier as sSupplier,
                  supplier_return.BrandName as BrandName,
                  supplier_return.Commodity as Commodity,
                  supplier_return.Qty as Qty,
                  supplier_return.Type  as Type,
                  supplier_return.Remark_item  as Remarks_Item
                  FROM supplier_return 
                  LEFT JOIN supplier
                  ON supplier_return.Supplier= supplier.UserId


                  WHERE supplier_return.Branch='Mandalay Show Room' ";}
                                                                        
      elseif ($Branches == 'Naypyidaw Show Room') {
          $sqlA=" SELECT *, supplier.SupplierName as Supplier,supplier_return.Supplier as sSupplier,
                  supplier_return.BrandName as BrandName,
                  supplier_return.Commodity as Commodity,
                  supplier_return.Qty as Qty,
                  supplier_return.Type  as Type,
                  supplier_return.Remark_item  as Remarks_Item
                  FROM supplier_return 
                  LEFT JOIN supplier
                  ON supplier_return.Supplier= supplier.UserId


                  WHERE supplier_return.Branch='Naypyidaw Show Room' ";}
                                                                        
      else {
          $sqlA=" SELECT *, supplier.SupplierName as Supplier,supplier_return.Supplier as sSupplier,
                  supplier_return.BrandName as BrandName,
                  supplier_return.Commodity as Commodity,
                  supplier_return.Qty as Qty,
                  supplier_return.Type  as Type,
                  supplier_return.Remark_item  as Remarks_Item
                  FROM supplier_return 
                  LEFT JOIN supplier
                  ON supplier_return.Supplier= supplier.UserId


                  WHERE 1=1 ";}                  
                 
          if (isset($_POST['keyword'])) {
            $keyword = $_POST['keyword']; 
            $sqlA =$sqlA." AND (supplier_return.BrandName LIKE '%$keyword%' OR supplier_return.Commodity LIKE '%$keyword%' OR supplier.SupplierName LIKE '%$keyword%'OR supplier_return.PL LIKE '%$keyword%')";
          }  
          if ($_GET['namelist'] <> ''){
            $sqlA =$sqlA." AND (supplier_return.BrandName= '".$_GET['namelist']."' OR supplier_return.Commodity= '".$_GET['namelist']."' OR supplier_return.PL= '".$_GET['namelist']."' OR supplier.SupplierName= '".$_GET['namelist']."')";
            
          }                             
          if ($year == '' ){
            $sqlA =$sqlA." AND YEAR(Return_date) = YEAR(CURRENT_DATE())";
          }
          if ($year <> ''){
            $sqlA =$sqlA." AND YEAR(Return_date)= ".$year;
          } 
          if ($_GET['month'] <> ''){
            $sqlA =$sqlA." AND MONTH(Return_date)= '".$_GET['month']."'";
          }
          if ($_GET['day'] <> ''){
            $sqlA =$sqlA." AND DAY(Return_date)= ".$_GET['day'];
          }                                                      
                         
 	     $sqlA = $sqlA. " Order by BrandName";
                                           
          $result=mysqli_query($con ,$sqlA); 
             $sno =1;
 
             while($row = mysqli_fetch_array($result)){
                 
              $row['Supplier'] = rtrim($row['Supplier'],",");
              print '<tr>';
              print '<td  >' . $sno . '</td>';
               print '<td align="center" class="checkss"><input name="users[]" type="checkbox" class="checkboxes" value=' . $row['PL'] . ' ></td>';                
              $message="Edit";
              print '<td  class="actions"><a href="detail.php?Supplier='.$row['sSupplier'].'&PL='.$row['PL'].'&Branch='.$row['Branch'].'" style="text-decoration: none;
              padding: 2px 5px;
              background: #2E8B57;
              color: white;
              border-radius: 3px;">' . $message . '</a></td>';                
              print '<td  >' . $row['Return_date'] . '</td>';  
              $row['Supplier'] = rtrim($row['Supplier'],","); 
              print '<td  >' . $row['Supplier'] . '</td>';  
              print '<td  >' . $row['PL'] . '</td>'; 
              print '<td  style="word-wrap:break-word;">' . $row['BrandName'] . '</td>'; 
              print '<td >' . $row['Commodity'] . '</td>';
              print '<td >' . $row['Qty'] . '</td>';
              print '<td>' . $row['Type'] . '</td>';
              print '<td style="font-weight:normal;word-break: break-all;">' . $row['Remarks_Item'] . '</td>';                         
              print '</tr>';
              $sno ++;

            }  
            
            print ' </table>'; 


        ?>  
</div></div>
<style type="text/css">
        table {
        border-collapse: collapse;
        width: 500px;
      }
</style>