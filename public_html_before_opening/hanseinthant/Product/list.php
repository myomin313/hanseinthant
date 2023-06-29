<?php session_start();?>
<?php 
if (($_SESSION['login_session']<> true)) {
  header("Location:../index.php");    
  exit();
}     

?>
<?php 
include_once('../config.php');
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
        $myusername = $_SESSION['login_user'];
        ?> 
        <?php
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        ?>
        <div class="topnav">
         <?php 
         $Authority = $_SESSION['authority'];
         $Export = $_SESSION['Export'];
         if ($Authority == 'Accountant') {
           print '<a href="../Rate/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Rate/list.php?namelist=&year=&month=&day="? "  background-color: white;color:black; height:35px;":'').'">Rate</a>';
           
         }?>
         
         <?php  print '<a href="../Product/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Product/list.php?namelist=&year=&month=&day="? "  background-color: white;color:black; height:35px;":'').'">Input</a>';?>
         
         <?php  print '<a href="../Job/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Job/list.php?namelist=&year=&month=&day="? "  background-color: white;color:black; height:35px;":'').'">WIP</a>';?>
         
         <?php  print '<a href="../Delivery/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Delivery/list.php?namelist=&year=&month=&day="? "  background-color: white;color:black; height:35px;":'').'">Delivery</a>';?>
         <?php  print '<a href="../Return/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Return/list.php?namelist=&year=&month=&day="? "  background-color: white;color:black; height:35px;":'').'">Customer Return</a>';?>
         
         <?php  print '<a href="../SupplierReturn/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/SupplierReturn/list.php?namelist=&year=&month=&day="? "  background-color: white;color:black; height:35px;":'').'">Supplier Return</a>';?>
         
         <?php  print '<a href="../Instock/list.php?namelist=&year=&month=&day=&Commodities="  style="'.($actual_link == "https://hanseinthant.com/Instock/list.php?namelist=&year=&month=&day=&Commodities="? "  background-color: white;color:black; height:35px;":'').'">Instock</a>';?>
         
         <?php  print '<a href="../Customer/list.php?"  style="'.($actual_link == "https://hanseinthant.com/Customer/list.php?"? "  background-color: white;color:black; height:35px;":'').'">Customer</a>';?>

         <?php  print '<a href="../Supplier/list.php?"  style="'.($actual_link == "https://hanseinthant.com/Supplier/list.php?"? "  background-color: white;color:black; height:35px;":'').'">Supplier</a>';?>
         <?php 
         $Permission = $_SESSION['permission'];
         if ($Permission == 'Permit') {
          print'     
          <a href="../User/list.php?"  style="'.($actual_link == "https://hanseinthant.com/User/list.php?"? "  background-color: white;color:black; height:35px;":'').'">User</a>';
        }?>
        

        <a><?php 
        $Export = $_SESSION['Export'];

        if ($Export == 'Export') {
          print' 
          <form class="form-horizontal" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data" >
          <button type="submit" id="Export" name="Export"  class="export" ><img src = "../image/Excel-icon.png" width="11px";  > Export</button> 
          <input type="file" name="file" id="choice"   multiple >          
          <button type="submit" id="Import" name="Import" data-loading-text="Loading..." class="chooseitem">Import</button>
          </form> ';  }
          
          ?>       
        </a>
        <a >
          <?php 
          $Authority = $_SESSION['authority'];
          if ($Authority == 'Accountant') {
           print'<input type="submit" name="history" id="history" class="history" onClick="setHistoryAction();" value="History" style="margin-top:0.4%;">';}?> 
           <!--<button id="printbtn" onclick="javascript:window.print();" class="print">Print</button>-->
           <a href="../logout.php?"  style="margin-left:2%;"><img src = "../image/log.png" width="26px"; height="25px;"></a></a>
           
           

         </div>
         <style>

          .topnav {
            overflow: hidden;
            background-color: #4d4d4d;
          }

          .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 8px 13px;
            text-decoration: none;
            font-size: 13px;
          }

          .topnav a:hover {
            background-color: #ddd;
            color: black;
            height:35px;
          }

          .topnav a.active {
            background-color: #4CAF50;
            color: white;
            height:35px;
            
          }
        </style>
        <style>
          #search-list{list-style:none;margin-top:-0px;position: absolute;padding: 0;width: 15%;margin-left: 7px;z-index: 2;}
          #search-list li{padding: 5px; background: #f2f2f2; border-bottom: #bbb9b9 1px solid;}
          #search-list li:hover{background:#e6f3ff;cursor: pointer;}
          #search{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
        </style>
        <!doctype html>
        <html>    
        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
          <script src="https://unpkg.com/knayi-myscript@latest/dist/knayi-myscript.min.js"></script>
          <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
          <link rel="stylesheet" href="/resources/demos/style.css">
          <!-- develop by Winsan -->
          <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
          <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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
         <!-- develop by Winsan -->

         <script type="text/javascript">
          $(document).ready(function (){
            $('#productSearch').on('click', function(){
            var fromDate = $('#fromDate').val();
            var toDate = $('#toDate').val();
            var string = $('#keywords').val(); 
            var newstring = string.replace(/[&\/\\#,+()$~%.':*?<>{}]/g,"\\$&");
             string = window.encodeURIComponent(newstring);
            //alert(string);
            window.location.href= "list.php?fromDate="+fromDate+"&toDate="+toDate+"&namelist="+string;
            });
          });
        </script>
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
      <style>
        html {
          font-family: Tahoma, Geneva, sans-serif;
          /*padding: 20px;*/
          background-color: #fff;
        }
        table {
          border-collapse: collapse;
          width: 500px;
        }
        td, th {
          padding: 2px;
        }
/*      th {
        background-color: #54585d;
        color: #ffffff;
        font-weight: bold;
        font-size: 13px;
        border: 1px solid #54585d;
        }*/
        td {
          color:#262626;
          border: 1px solid #dddfe1;
        }
        tr {
          background-color: #f9fafb;
        }
        tr:nth-child(odd) {
          background-color: #ffffff;
        }

      </style>

      <script type="text/javascript">  
        function searching() {
        var min_length = 1; // min caracters to display the autocomplete
        var keyword = $('#keywords').val();
        // alert(keyword);
        if (keyword.length >= min_length) {
          $.ajax({
            url: '../Product/autofill.php?' ,
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

      function set_items(items) {

       //var string = items; 
       //var newstring = string.replace(/[&\/\\#,+()$~%.':*?<>{}]/g,"\\$&");
        // string = window.encodeURIComponent(newstring);
        $('#namelist').hide();        
        $('#searching-box').hide();
        $('#keywords').val(items);
        //window.location.href = 'list.php?namelist='+string+'&year=&month=&day=';

      }

    </script>

    <script type="text/javascript">
      $(document).ready(function () {  
        $('#year').change(function () {
          window.location.href = "list.php?year="+ $(this).val()+"&month="+"&day=&namelist=";
        });      
        $('#month').change(function () {
          window.location.href = 'list.php?year=' +$("#year option:selected").val()+'&month='+this.options[this.selectedIndex].value+"&day=&namelist="; 
        });
        $('#day').change(function () {
          window.location.href = 'list.php?year=' +$("#year option:selected").val()+'&month='+$("#month option:selected").val()+'&day='+this.options[this.selectedIndex].value+"&namelist="; 
        });   
        
        
      });      
    </script>    



    <script type="text/javascript">
      $(document).ready(function(){

    // Checkbox click
    $(".hidecol").click(function(){

      var id = this.id;
      var splitid = id.split("_");
      var colno = splitid[1];
      var checked = true;

        // Checking Checkbox state
        if($(this).is(":checked")){
          checked = true;
        }else{
          checked = false;
        }
        setTimeout(function(){
          if(checked){
            $('#emp_table td:nth-child('+colno+')').hide();
            $('#emp_table th:nth-child('+colno+')').hide();
          } else{
            $('#emp_table td:nth-child('+colno+')').show();
            $('#emp_table th:nth-child('+colno+')').show();
          }
            // Hiding column

          }, 1500);

      });


    /*$("#scrollable").scroll(function() {      
        //if($("#scrollable").scrollTop() + $("#scrollable").height() >= $("#scrollable").height()) {
     
      //alert($("#scrollable").scrollTop());
      //alert($(document).height());
      alert($("#scrollable").height());

     if ($("#scrollable").scrollTop() == $(document).height() - $("#scrollable").height()){       
            var last_id = $(".clsrow:last").attr("id");
            var last_serial=$(".clsSerial:last").html();
            //alert(last_id + " " + last_serial);
            loadMoreData(last_id,last_serial);
          //alert("hay");
        }
      });*/

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
      //$(".hidLastPID:last").val();
      setTimeout(function(){

        $.ajax(
        {
                //url: 'loadmoredata.php?last_id=' + last_id + '&last_serial=' +  $(" #hidLastPID").val() ,
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

<body style="font-size: 10px;  font-family:Tahoma, Geneva, sans-serif;">
  <div class="col-md-12" style="margin-top:1%;">
    <div class="row">
      <div class="col-sm-12">
        <form class="form-horizontal" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data" >
        <input type="text" id="keywords" name="searchkeyword" style="margin-left: 7px;width: 15%;margin-top:1%;" onKeyUp="searching()" placeholder="search..." /><span id="searching-box"></span>
        From: <input type="text" name="searchfromDate" id="fromDate" placeholder="from date" autocomplete="off">
        To: <input type="text" name="searchtoDate" id="toDate" placeholder="to date" autocomplete="off">
        <input type="button" id="productSearch" value="search">
         <button type="submit" id="Export" name="Export"  class="export" ><img src = "../image/Excel-icon.png" width="11px";  >Export</button> 
        <a href="new.php" class="history printadd" style="margin-left:30%;">+&nbspADD NEW</a>
         </form>
      </div>
    </div>

      <!--  <select name="year" onchange="javascript:valueselect()" id="year" style="height:25px;margin-left: 5%;">
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
      <select name="month" id="month" onchange="javascript:valueselect()" style="height:25px;">
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
      <select name="day" id="day" onchange="javascript:valueselect()" style="height:25px;">
        <option value=""></option>
          <?php 
            $start_date = 1;
            $end_date   = 31;
            $day = $_GET['year'];
            for( $d=$start_date; $d<=$end_date; $d++ ) {
              print '<option value="'. $d.'"';
              if( $_GET['day'] == $d)
              { print ' selected= selected ';} 
              print '>' . $d . '</option>';
            }
          ?>
      </select>

      <span id="day">&nbspDay</span> --> 
      <!-- <a href="new.php" class="history printadd" style="margin-left:50%;">+&nbspADD NEW</a> -->


    </div>
  </div>
  
</div>

<div id="outer-container" >
  <div id="scrollable" style="height:710px;">
    <form  name="approve" method="post" action=""> 
      <table id="emp_table" border="0" class="emp" style="width: auto;margin-top: 1%;font-size:10px;">
        <tr class="tr_header" style="background-color:#3385ff;font-family:Tahoma, Geneva, sans-serif;font-size: 12px;">
          <th rowspan="2" style="width:1%;">S/N</td>
            <th rowspan="2" class="checkall">
              <input type="checkbox" name="check_all" id="check_all" onclick="javascript:checkAll(this)"  style="margin-left: 0px;" />
            </th>
            <th rowspan="2" style="width:1%;" class="action">Action</td>
              <th rowspan="2" style="width:5%;">Date</td>
                <th rowspan="2" style="word-wrap:break-word;">Supplier</th>
                <th rowspan="2" style="word-wrap:break-word;">Branch</th>
                <th rowspan="2" style="word-wrap:break-word;">BrandName</th>
                <th colspan="9" style="word-wrap:break-word;">Commodity</th>
                <?php 
                $Authority = $_SESSION['authority'];
                if ($Authority == 'Accountant') {
                  print'
                  <th colspan="3" class="tableColGroupAssociate" id="rate">Rate</th>';}?>
                  <th rowspan="2" style="">PL NO</th>
                  <th rowspan="2" style="">PO NO</th>

                </tr>
                <tr>
                  <th style="font-weight:normal;word-wrap:break-word;" class="item">Item</th>
                  <th style="font-weight:normal;" class="type">Type</th>
                  <th style="font-weight:normal;" class="stock">Stock in</th>
                  <th style="font-weight:normal;" class="stock">WIP</th>
                  <th style="font-weight:normal;" class="stock">Delivery</th>
                  <th style="font-weight:normal;" class="stock">Return</th>
                  <th style="font-weight:normal;" class="stock">Balance</th>
                  <th style="font-weight:normal;" class="stock">Current Qty</th>
                  
                  <th style="word-break: break-all;font-weight: normal;" class="remarkss">Remark</th>
                  <?php 
                  $Authority = $_SESSION['authority'];
                  if ($Authority == 'Accountant') {
                    print'
                    <th style="font-weight:normal;background: #ffff66;"  class="tt">Name</th>
                    <th style="font-weight:normal;background: #ffff66;" class="tt">Total USD</th>
                    <th style="font-weight:normal;background: #ffff66;" class="tt">Delivery USD</th>

                    ';

                  }?>

                </tr>    
                <?php $Branches = $_SESSION['Branch'];

                $sqls = "
                SELECT * FROM (
                SELECT
              *, @rownum :=(@rownum +1) AS num
                FROM
                (SELECT    @rownum := 0) AS initialization,
                (
                ";

           /* if ($Branches == 'Shwe Pyi Thar Store') {
                  $sqls .= " SELECT *,product.id as pID,
                  product.SupplierName as SupplierID

                  FROM product 
                  LEFT JOIN supplier
                  ON product.SupplierName= supplier.UserId

                  LEFT JOIN rate
                  ON product.Packing_date= rate.Rate_date

                  WHERE  product.Packing_date= rate.Rate_date and product.Branch='Shwe Pyi Thar Store' ";
        }

         elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {
              $sqls .= " SELECT *,product.id as pID, 
                  product.SupplierName as SupplierID

                  FROM product 
                  LEFT JOIN supplier
                  ON product.SupplierName= supplier.UserId

                  LEFT JOIN rate
                  ON product.Packing_date= rate.Rate_date

                  WHERE  product.Packing_date= rate.Rate_date and product.Branch='Shwe Pyi Thar Store Control Panel' ";
        }

         elseif ($Branches == 'Yangon Show Room') {
              $sqls .= " SELECT *,product.id as pID, 
                  product.SupplierName as SupplierID

                  FROM product 
                  LEFT JOIN supplier
                  ON product.SupplierName= supplier.UserId

                  LEFT JOIN rate
                  ON product.Packing_date= rate.Rate_date

                  WHERE  product.Packing_date= rate.Rate_date and product.Branch='Yangon Show Room' ";
        }     
         elseif ($Branches == 'Naypyidaw Show Room') {
              $sqls .= " SELECT *,product.id as pID, 
                  product.SupplierName as SupplierID

                  FROM product 
                  LEFT JOIN supplier
                  ON product.SupplierName= supplier.UserId

                  LEFT JOIN rate
                  ON product.Packing_date= rate.Rate_date

                  WHERE product.Packing_date= rate.Rate_date and product.Branch='Naypyidaw Show Room' ";
        }    

          elseif ($Branches == 'Mandalay Show Room') {
              $sqls .= " SELECT *,product.id as pID, 
                  product.SupplierName as SupplierID

                  FROM product 
                  LEFT JOIN supplier
                  ON product.SupplierName= supplier.UserId

                  LEFT JOIN rate
                  ON product.Packing_date= rate.Rate_date

                  WHERE product.Packing_date= rate.Rate_date and product.Branch='Mandalay Show Room' ";
        }    
        else{
              $sqls .= " SELECT product.*,product.id as pID
                  FROM product 
                  LEFT JOIN supplier
                  ON product.SupplierName= supplier.UserId

                  LEFT JOIN rate
                  ON product.Packing_date= rate.Rate_date

                  WHERE product.Packing_date= rate.Rate_date ";
                }  */

                $sqls .= " SELECT product.*,product.id as pID, supplier.SupplierName AS sSupplierName
                FROM product 
                LEFT JOIN supplier
                ON product.SupplierName= supplier.UserId
                LEFT JOIN rate
                ON product.Packing_date= rate.Rate_date
                WHERE product.Packing_date= rate.Rate_date ";

                if ($Branches <> 'All') {
                  $sqls .= " AND product.Branch='$Branches' ";
                }
              if (!empty($_GET['fromDate']) && !empty($_GET['toDate'])){
                $fromDate = date("Y-m-d",strtotime($_GET['fromDate']));
                $toDate = date("Y-m-d", strtotime($_GET['toDate'])); 
                $sqls =$sqls." AND product.Packing_date BETWEEN '$fromDate'  AND '$toDate'";
                }
                 if (isset($_POST['keyword'])) {
                   $keyword = $_POST['keyword'];
                   $sqls =$sqls." AND supplier.SupplierName LIKE '%$keyword%' OR product.BrandName LIKE '%$keyword%' OR product.Purchase_order_No LIKE '%$keyword%' OR product.PO_NO LIKE '%$keyword%'OR product.Commodity LIKE '%$keyword%' OR product.Branch LIKE '%$keyword%'";
                 }  
                //  if (isset($_POST['keyword'])) {
                //   $keyword = $_POST['keyword'];
                //   $sqls =$sqls." AND supplier.SupplierName = '$keyword' OR product.BrandName = '$keyword' OR product.Purchase_order_No = '$keyword' OR product.PO_NO = '$keyword' OR product.Commodity = '$keyword' OR product.Branch = '$keyword'";
                // }
        //   echo urldecode($_GET['namelist']);
                if ($_GET['namelist'] <> ''){
                  $sqls =$sqls." AND (supplier.SupplierName= '".$_GET['namelist']."' OR product.BrandName= '".$_GET['namelist']."'  OR product.Purchase_order_No= '".$_GET['namelist']."' OR product.PO_NO= '".$_GET['namelist']."'OR product.Commodity= '".$_GET['namelist']."' OR product.Branch= '".$_GET['namelist']."')";
                }                         
          // if ($year == '' ){
          //   $sqls =$sqls." AND YEAR(Packing_date) = YEAR(CURRENT_DATE())";
          // }
          // if ($year <> ''){
          //   $sqls =$sqls." AND YEAR(Packing_date)= '".$_GET['year']."'";
                
          // } 
          // if ($_GET['month'] <> ''){
          //   $sqls =$sqls." AND MONTH(Packing_date)= '".$_GET['month']."'";
          // }
          // if ($_GET['day'] <> ''){
          //   $sqls =$sqls." AND DAY(Packing_date)= '".$_GET['day']."'";
          // }  
                $sqls = $sqls. " )tbl ";
                $sqls = $sqls. "Order by Purchase_order_No ";
                
                $sqls = $sqls.") tbl1,(SELECT @rownum:=0) AS t WHERE 1=1 ORDER BY num ASC LIMIT 30"; 
                $result=mysqli_query($con ,$sqls); 
                $sno =  1;
                $_SESSION["Product_LoadMoreQuery"]=$sqls;
  //echo $sqls;
   /* while($row = mysqli_fetch_array($result)){
              $row['SupplierName'] = rtrim($row['SupplierName'],",");
              print '<tr>';
           
              print '<td  >' . $sno . '</td>'; 
              print '<td align="center" class="checkss"><input name="users[]" type="checkbox" class="checkboxes" value=' . $row['Purchase_order_No'] . ' ></td>';
              $message="Edit";
             
              print '<td  class="actions"><a href="detail.php?SupplierID=' . $row['SupplierID'] . '&PL=' . urlencode($row['Purchase_order_No']) . '" style="text-decoration: none;
              padding: 2px 5px;
              background: #2E8B57;
              color: white;
              border-radius: 3px;">' . $message . '</a></td>'; 
              print '<td  >' . $row['Packing_date'] . '</td>';  
              print '<td  >' . $row['SupplierName'] . '</td>';  
              print '<td  >' . $row['Branch'] . '</td>';  
              print '<td  style="word-break: break-all;width:100px;" >' . $row['BrandName'] . '</td>'; 
              print '<td style="word-break: break-all;width:100px;" >' . $row['Commodity'] . '</td>';
              print '<td style="width:5px;">' . $row['Type'] . '</td>';
              print '<td>' . $row['Qty'] . '</td>';
              print '<td style="width:5px;background-color: #ffeb99;">' . $row['balanceWIP'] . '</td>';
              print '<td style="width:5px;background-color: #ffeb99;">' . $row['balanceDelivery'] . '</td>';
              print '<td style="width:5px;background-color: #ffeb99;">' . $row['balanceReturn'] . '</td>';
  
              if ($row['balanceQty'] < $row['Qty'] and $row['balanceQty'] > 0 ) {
                print '<td style="width:5px;background-color: #98b2e6;">' . $row['balanceQty']  . '</td>';
              }
              elseif ($row['balanceQty'] == $row['Qty']) {
                print '<td style="width:5px;background-color: #8cd9b3;">' . $row['balanceQty'] . '</td>';
              }
              elseif ($row['balanceQty'] < $row['Qty'] and $row['balanceQty'] < 0) {
                print '<td style="width:5px;background-color:#ff6666;">' . $row['balanceQty'] . '</td>';
              }              
              else{
                print '<td style="width:5px;background-color: #ff9999;">' . $row['balanceQty'] . '</td>';
              }
              print'<td style=" background-color: #4287f5;color:white;">' . $row['currentQty'] . '</td>';
                        
              print '<td style="word-break: break-all; ">' . $row['Remarks_Item'] . '</td>';
                if ($Authority == 'Accountant') {
              print '<td>' . $row['Rate_Name'].'&nbsp(' . $row['totalRate'].')</td>';
              print '<td>' . $row['totalUSD'].'</td>';
              print '<td>' . $row['balanceUSD'].'</td>';
     
            }

              print '<td >' . $row['Purchase_order_No'] . '</td>';
              print '<td style="word-break: break-all;width:40px; ">' . $row['PO_NO'] . '</td>';                      
              print '</tr>';
              $sno ++;
            }*/
            include('show_data.php');

            mysqli_close($con);
            ?>
          </tbody>
        </table>
        <div class="ajax-load" style="display:none;text-align:center;">
          <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More...</p>
        </div>


        <style type="text/css">

          .ajax-load{
            background: #e1e1e1;
            padding: 10px 0px;
            width: 100%;
          }

          #outer-container {
            position: relative;
          }

          #scrollable {
            height:670px;
            overflow-y: auto;
          }


        </style>
