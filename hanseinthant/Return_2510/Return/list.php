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


// $setutf8 = "SET NAMES utf8";
// $q = $con->query($setutf8);
// $setutf8c = "SET character_set_results = 'utf8', character_set_client =
// 'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
// character_set_server = 'utf8'";
// $qc = $con->query($setutf8c);
// $setutf9 = "SET CHARACTER SET utf8";
// $q1 = $con->query($setutf9);
// $setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
// $q2 = $con->query($setutf7);
$myusername = $_SESSION['login_user'];

?>  

<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <script src="https://unpkg.com/knayi-myscript@latest/dist/knayi-myscript.min.js"></script>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
   <link rel="stylesheet" href="/resources/demos/style.css">
<!-- develop by Winsan -->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js">

  </script>
<!-- develop by Winsan -->
  <script>
    $( function() {
     $( "#fromDate" ).datepicker({
      dateFormat: "dd-mm-yy"
    });
     $( "#toDate" ).datepicker({
      dateFormat: "dd-mm-yy"
    });
   });
 </script>
 <script type="text/javascript">
  $(document).ready(function (){
    $('#returnsSearch').on('click', function(){
      var fromDate = $('#fromDate').val();
      var toDate = $('#toDate').val();
      var string = $('#keywords').val(); 
      var newstring = string.replace(/[&\/\\#,+()$~%.':*?<>{}]/g,"\\$&");
        string = window.encodeURIComponent(newstring);
      window.location.href= "list.php?fromDate="+fromDate+"&toDate="+toDate+"&namelist="+string;
    });
  });
</script>
<!-- develop by Winsan -->

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
<style type="text/css">
  table {
    border-collapse: collapse;
    width: 500px;
  }
</style>

<script type="text/javascript">  
  function searching() {
        var min_length = 1; // min caracters to display the autocomplete
        var keyword = $('#keywords').val();
        // alert(keyword);
        if (keyword.length >= min_length) {
          $.ajax({
            url: '../Return/autofill.php?' ,
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

       $('#namelist').hide();        
        $('#searching-box').hide();
        $('#keywords').val(items);

    // var string = items; 
    // var newstring = string.replace(/[&\/\\#,+()$~%.':*?<>{}]/g,"\\$&");       

        // $('#keywords').val(items);
        //  alert(items);
        // var string = addslashes(items);
       // $('#keywords').val(items);
        // hide proposition list
        //string = window.encodeURIComponent(newstring);
        // console.log(newstring);
        // alert(newstring);
       // $('#namelist').hide();

       // $('#searching-box').hide();
        //window.location.href = 'list.php?namelist='+string+'&year=&month=&day=';

      }

    </script>

    <script type="text/javascript">
      $(document).ready(function () {  
        // $('#year').change(function () {
        //   window.location.href = "list.php?year="+ $(this).val()+"&month="+"&day=&namelist=&brandsearch=";
        // });      
        // $('#month').change(function () {
        //   window.location.href = 'list.php?year=' +$("#year option:selected").val()+'&month='+this.options[this.selectedIndex].value+"&day=&namelist=&brandsearch="; 
        // });
        // $('#day').change(function () {
        //   window.location.href = 'list.php?year=' +$("#year option:selected").val()+'&month='+$("#month option:selected").val()+'&day='+this.options[this.selectedIndex].value+"&namelist=&brandsearch="; 
        // });  

        $('#scrollable').on('scroll', function() { 
          if ($(this).scrollTop() + 
            $(this).innerHeight() >=  
            $(this)[0].scrollHeight) {                     
            var last_id = $(".clsrow:last").attr("id");
          var last_serial=$(".clsSerial:last").html();
          loadMoreData(last_id,last_serial);
        }

      });

        function loadMoreData(last_id,last_serial){

         setTimeout(function(){
           $.ajax(
           {
             url: 'loadmoredata.php?last_id=' + last_id + '&last_serial=' + $(".hidLastPID:last").val() ,
             type: "get",
             cache: false,
             async: false,
             beforeSend: function()
             {
               $('.ajax-load').show();
             }
           })
           .done(function(data)
           {
             if(data != '""'){               
               $("#emp_table").append(data);
             } 
             $('.ajax-load').hide();              
           })
           .fail(function(jqXHR, ajaxOptions, thrownError)
           {
             alert('server not responding...');
           });

         },0);

       }

     });
   </script>    


 </head>
 <body style="font-size: 10px; font-family:Tahoma, Geneva, sans-serif;">
  <div class="col-md-12"  style="margin-top:1%;">
<!-- develop by Winsan -->
    <div class="row">
      <div class="col-sm-12">
        <input type="text" id="keywords" style="margin-left: 7px;width: 15%;" onKeyUp="searching()" placeholder="search..." /><span id="searching-box"></span>
        From: <input type="text" name="fromDate" id="fromDate" placeholder="from date" autocomplete="off">
        To: <input type="text" name="toDate" id="toDate" placeholder="to date" autocomplete="off">
        <input type="button" id="returnsSearch" value="search">
        <a href="new.php" class="history printadd" style="margin-left:5%;">+&nbspADD NEW</a>
      </div>
    </div>
  </div>
<!-- develop by Winsan -->
 
  <!-- <input type="text" id="keywords" style="margin-left: 7px;width: 15%;" onKeyUp="searching()" placeholder="search..." /><span id="searching-box"></span> -->
      <!-- <select name="year" onchange="javascript:valueselect()" id="year" class="hidden-print" style="height:25px;margin-left: 5%;">
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

      <span id="year">&nbspYear</span>
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

      <span id="month">&nbspMonth</span>
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

      <span id="day">&nbspDay</span>   --> 


    </div>


  </div>
  <form  name="approve" method="post" action=""> 
    <div id="outer-container">
      <div id="scrollable" style="height:710px;">
        <table id="emp_table" border="0" class="resultGridTable" style="width: auto;margin-top: 1%;font-size:10px;">
          <tr class="tr_header" style="background-color:#3385ff;font-family:Tahoma, Geneva, sans-serif;font-size: 12px;">
            <th rowspan="2" style="width:2%;">S/N</td>
              <th class="checkall" rowspan="2" style="width:2%;">&nbsp 
                <input type="checkbox" name="check_all" id="check_all" onclick="javascript:checkAll(this)" class="hidden-print"  style="margin-left: 0px;" />
              </th>                      
              <th  rowspan="2" style="width:2%;" class="action">Action</td>
                <th  rowspan="2" style="width:5%;">Return Date</td>
                  <th  rowspan="2" >Return No</td>
                    <th  rowspan="2" >To</td>
                      <th  rowspan="2" style="word-wrap:break-word;">Customer</th>
                      <th  rowspan="2" style="word-wrap:break-word;">DO NO</th>
                      <th  rowspan="2" style="font-weight:normal;word-wrap:break-word;" >Brand</th>
                      <th colspan="4" style="font-weight:normal;word-wrap:break-word;" >Commodity</th>
                    </tr>
                    <tr>
                      <th style="font-weight:normal;word-wrap:break-word;" class="stock">Item</th>
                      <th style="font-weight:normal;" class="stock">Return Qty</th>
                      <th style="font-weight:normal;" class="stock">Type</th>
                      <th style="font-weight:normal;word-break: break-all;" class="stock">Remark</th>
                    </tr>      

                    <?php
                    $Branches = $_SESSION['Branch'];
 /*if ($Branches == 'Shwe Pyi Thar Store') {           
          $sqlA=" SELECT *, customer.CustomerName as Customer,customer.CustomerName as jCustomer,returns.Customer as rCustomer,
                  returns.Remarks_item as Remarks_item,
                  returns.Commodity as Commodity,
                  returns.BrandName as BrandName,
                  returns.Qty as Qty,
                  returns.Type   as Type,
                  returns.Remarks_Item as Remarks_Item
                  FROM returns 
                  LEFT JOIN customer
                  ON returns.Customer= customer.UserId
                  WHERE returns.department='Shwe Pyi Thar Store' ";}
elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {           
          $sqlA=" SELECT *, customer.CustomerName as Customer,customer.CustomerName as jCustomer,returns.Customer as rCustomer,
                  returns.Remarks_item as Remarks_item,
                  returns.Commodity as Commodity,
                  returns.BrandName as BrandName,
                  returns.Qty as Qty,
                  returns.Type   as Type,
                  returns.Remarks_Item as Remarks_Item
                  FROM returns 
                  LEFT JOIN customer
                  ON returns.Customer= customer.UserId
                  WHERE returns.department='Shwe Pyi Thar Store Control Panel' ";}
 elseif ($Branches == 'Yangon Show Room') {           
          $sqlA=" SELECT *, customer.CustomerName as Customer,customer.CustomerName as jCustomer,returns.Customer as rCustomer,
                  returns.Remarks_item as Remarks_item,
                  returns.Commodity as Commodity,
                  returns.BrandName as BrandName,
                  returns.Qty as Qty,
                  returns.Type   as Type,
                  returns.Remarks_Item as Remarks_Item
                  FROM returns 
                  LEFT JOIN customer
                  ON returns.Customer= customer.UserId
                  WHERE returns.department='Yangon Show Room' ";}
elseif ($Branches == 'Mandalay Show Room') {           
          $sqlA=" SELECT *, customer.CustomerName as Customer,customer.CustomerName as jCustomer,returns.Customer as rCustomer,
                  returns.Remarks_item as Remarks_item,
                  returns.Commodity as Commodity,
                  returns.BrandName as BrandName,
                  returns.Qty as Qty,
                  returns.Type   as Type,
                  returns.Remarks_Item as Remarks_Item
                  FROM returns 
                  LEFT JOIN customer
                  ON returns.Customer= customer.UserId
                  WHERE returns.department='Mandalay Show Room' ";}
elseif ($Branches == 'Naypyidaw Show Room') {           
          $sqlA=" SELECT *, customer.CustomerName as Customer,customer.CustomerName as jCustomer,returns.Customer as rCustomer,
                  returns.Remarks_item as Remarks_item,
                  returns.Commodity as Commodity,
                  returns.BrandName as BrandName,
                  returns.Qty as Qty,
                  returns.Type   as Type,
                  returns.Remarks_Item as Remarks_Item
                  FROM returns 
                  LEFT JOIN customer
                  ON returns.Customer= customer.UserId
                  WHERE returns.department='Naypyidaw Show Room' ";}
else {           
          $sqlA=" SELECT *, customer.CustomerName as Customer,customer.CustomerName as jCustomer,returns.Customer as rCustomer,
                  returns.Remarks_item as Remarks_item,
                  returns.Commodity as Commodity,
                  returns.BrandName as BrandName,
                  returns.Qty as Qty,
                  returns.Type   as Type,
                  returns.Remarks_Item as Remarks_Item
                  FROM returns 
                  LEFT JOIN customer
                  ON returns.Customer= customer.UserId
                  WHERE 1=1 ";}    
                  
*/

                  $sqlHeader = "
                  SELECT
                *
                  FROM
                  (SELECT *, @rownum :=(@rownum +1) AS num
                  FROM
                  (SELECT @rownum := 0) AS initialization,
                  ( ";

                  $sqlA=" SELECT returns.*, customer.CustomerName,customer.UserId as rCustomer
                  FROM returns 
                  LEFT JOIN customer
                  ON returns.Customer= customer.UserId
                  WHERE 1=1 ";

                  if($Branches != "All"){
                    $sqlA .=" AND returns.department='$Branches'";
                  }
// develop by Winsan
                  // echo $_GET['fromDate']; exit();
                  if(isset ($_GET['fromDate']) && ($_GET['toDate'])){
                    $fromDate = date("Y-m-d", strtotime($_GET['fromDate']));
                    $toDate = date("Y-m-d", strtotime($_GET['toDate']));
                    $sqlA .=" AND returns.Return_date BETWEEN '$fromDate'  AND '$toDate'";
                  }
// develop by Winsan
                  if (isset($_POST['keyword'])) {
                    $keyword = $_POST['keyword']; 
                    $sqlA =$sqlA." AND (returns.BrandName LIKE '%$keyword%' OR customer.CustomerName LIKE '%$keyword%' OR returns.Customer LIKE '%$keyword%'OR returns.DO_No LIKE '%$keyword%' OR returns.department LIKE '%$keyword%')";
                  }  
                  if ($_GET['namelist'] <> ''){
                    $sqlA =$sqlA." AND (returns.BrandName= '".$_GET['namelist']."' OR returns.Commodity= '".$_GET['namelist']."' OR returns.DO_No= '".$_GET['namelist']."' OR customer.CustomerName= '".$_GET['namelist']."' OR returns.department= '".$_GET['namelist']."')";
                  }
                                         
         //  if ($year == '' ){
         //    $sqlA =$sqlA." AND YEAR(Return_date) = YEAR(CURRENT_DATE())";
         //  }
         //  if ($year <> ''){
         //    $sqlA =$sqlA." AND YEAR(Return_date)= ".$year;
         //  } 
         //  if ($_GET['month'] <> ''){
         //    $sqlA =$sqlA." AND MONTH(Return_date)= '".$_GET['month']."'";
         //  }
         //  if ($_GET['day'] <> ''){
         //    $sqlA =$sqlA." AND DAY(Return_date)= ".$_GET['day'];
         //  }                 
         // $sqlA = $sqlA. " Order by returns.BrandName";   

                  $sqlFooter ="
                  ) Tbl
                  ) tbl1
                  WHERE
                  1 = 1 ORDER BY
                  num ASC
                  LIMIT 30";

          //  $resultA=mysqli_query($con ,$sqlA); 
                  $sSQLQuery= $sqlHeader . $sqlA .  $sqlFooter;
                  $result=mysqli_query($con , $sSQLQuery); 
                  $_SESSION["Return_LoadMoreQuery"] = $sSQLQuery;
// echo $sSQLQuery;
                  $sno = 1;
                  include('show_data.php');            
                  print '</table>'; 
                  print '</form>'; 

            /*while($row = mysqli_fetch_array($resultA)){

              print '<tr>';
              print '<td  >' . $sno . '</td>'; 
               print '<td align="center" class="checkss"><input name="users[]" type="checkbox" class="checkboxes" value=' . $row['DO_No'] . ' ></td>';                
              $message="Edit";
              print '<td  class="actions"><a href="detail.php?Customer='.$row['rCustomer'].'&Return_no='.$row['Return_no'].'&DO_No='.$row['DO_No'].'" style="text-decoration: none;
              padding: 2px 5px;
              background: #2E8B57;
              color: white;
              border-radius: 3px;">' . $message . '</a></td>';               
              print '<td  >' . $row['Return_date'] . '</td>';
              print '<td  >' . $row['Return_no'] . '</td>';  
              print '<td  >' . $row['department'] . '</td>';
              $row['jCustomer'] = rtrim($row['jCustomer'],","); 
              print '<td  >' . $row['jCustomer'] . '</td>';  
              print '<td  >' . $row['DO_No'] . '</td>';    
              print '<td  style="word-wrap:break-word;">' . $row['BrandName'] . '</td>'; 
              print '<td >' . $row['Commodity'] . '</td>';
              print '<td>' . $row['Qty'] . '</td>';
              print '<td>' . $row['Type'] . '</td>';
              print '<td style="font-weight:normal;word-break: break-all;">' . $row['Remarks_item'] . '</td>';
                      
              print '</tr>';

              $sno ++;


            }  
            
            print ' </table>'; 
            */
            ?>  
            <div class="ajax-load" style="display:none;text-align:center;">
              <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More...</p>
            </div></div>