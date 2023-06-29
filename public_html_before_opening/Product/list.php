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
         
         <?php  print '<a href="../transfer/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/transfer/list.php?namelist=&year=&month=&day="? "  background-color: white;color:black; height:35px;":'').'">Transfer</a>';?>

         <?php  print '<a href="../Job/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Job/list.php?namelist=&year=&month=&day="? "  background-color: white;color:black; height:35px;":'').'">WIP</a>';?>
         
         <?php  print '<a href="../Delivery/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Delivery/list.php?namelist=&year=&month=&day="? "  background-color: white;color:black; height:35px;":'').'">Delivery</a>';?>
         <?php  print '<a href="../Return/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/Return/list.php?namelist=&year=&month=&day="? "  background-color: white;color:black; height:35px;":'').'">Customer Return</a>';?>
         
         <?php  print '<a href="../SupplierReturn/list.php?namelist=&year=&month=&day="  style="'.($actual_link == "https://hanseinthant.com/SupplierReturn/list.php?namelist=&year=&month=&day="? "  background-color: white;color:black; height:35px;":'').'">Supplier Return</a>';?>
         
         <?php  print '<a href="../Instock/list.php?namelist=&year=&month=&day=&Commodities="  style="'.($actual_link == "https://hanseinthant.com/Instock/list.php?namelist=&year=&month=&day=&Commodities="? "  background-color: white;color:black; height:35px;":'').'">Instock</a>';?>
         
         <?php  print '<a href="../Customer/list.php?"  style="'.($actual_link == "https://hanseinthant.com/Customer/list.php?"? "  background-color: white;color:black; height:35px;":'').'">Customer</a>';?>

         <?php  print '<a href="../Supplier/list.php?"  style="'.($actual_link == "https://hanseinthant.com/Supplier/list.php?"? "  background-color: white;color:black; height:35px;":'').'">Supplier</a>';?>

         <?php  print '<a href="../brandname/list.php?"  style="'.($actual_link == "https://hanseinthant.com/brandname/list.php?"? "  background-color: white;color:black; height:35px;":'').'">BrandName</a>';?>

         <?php  print '<a href="../commodity/list.php?"  style="'.($actual_link == "https://hanseinthant.com/commodity/new.php"? "  background-color: white;color:black; height:35px;":'').'">Commodity</a>';?>
         
         <?php  print '<a href="../code/list.php?"  style="'.($actual_link == "https://hanseinthant.com/code/new.php"? "  background-color: white;color:black; height:35px;":'').'">Code No</a>';?>

         <?php  print '<a href="../branch/list.php?"  style="'.($actual_link == "https://hanseinthant.com/branch/new.php"? "  background-color: white;color:black; height:35px;":'').'">Branch</a>';?>
         <?php 
         $Permission = $_SESSION['permission'];
        if($Permission == 'Permit') {
           print'<a href="../User/list.php?"  style="'.($actual_link == "https://hanseinthant.com/User/list.php?"? "  background-color: white;color:black; height:35px;":'').'">User</a>';
        } ?>
        

        <a><?php 
        $Export = $_SESSION['Export'];

        if ($Export == 'Export') {
        print'<form class="form-horizontal" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data" >
          <button type="submit" id="Export" name="Export" class="export" ><img src = "../image/Excel-icon.png" width="2px";>Export</button> 
          <input type="file" name="file" id="choice" multiple>          
          <button type="submit" id="Import"  name="Import"  data-loading-text="Loading..." class="chooseitem">Import</button>
          </form> ';  }
          
          ?>       
        </a>
        <a>
          <?php 
        $Export = $_SESSION['Export'];

        if ($Export == 'Export') {
          print' 
          <form class="form-horizontal" action="database-backup.php" method="post" name="back_up" enctype="multipart/form-data" >           
          <button type="submit" id="backup" name="backup" data-loading-text="Loading..." class="chooseitem" style="background:yellow;color:green">backup</button>
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
          #search-list,#search-supplier-list,#search-rate-list,#search-pl-list{list-style:none;margin-top:-0px;position: absolute;padding: 0;width: 15%;margin-left: 7px;z-index: 2;}
          #search-branch-list{list-style:none;margin-top:-0px;position: absolute;padding: 0;width: 15%;margin-left: 204px;z-index: 2;}
          #search-code-list{list-style:none;margin-top:-0px;position: absolute;padding: 0;width: 15%;margin-left: 404px;z-index: 2;}
          #search-brandname-list{list-style:none;margin-top:-0px;position: absolute;padding: 0;width: 15%;margin-left: 654px;z-index: 2;}
          #search-commodity-list{list-style:none;margin-top:-0px;position: absolute;padding: 0;width: 15%;margin-left: 954px;z-index: 2;}
          #search-list,#search-branch-list,#search-supplier-list,#search-code-list,#search-brandname-list,#search-commodity-list,#search-rate-list,#search-pl-list li{padding: 5px; background: #f2f2f2; border-bottom: #bbb9b9 1px solid;}
          #search-list,#search-branch-list,#search-supplier-list,#search-code-list,#search-brandname-list,#search-commodity-list,#search-rate-list,#search-pl-list,#search-pl-list li:hover{background:#e6f3ff;cursor: pointer;}
          #search,#search-brandname-list{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
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
           // var string = $('#keywords').val(); 
           var Search_SupplierName = $("#search_supplier").val();
           var Search_Branch = $("#search_branch").val();
           var Search_code = $("#search_code").val();
           var Search_BrandName = $("#search_BrandName").val();
           var Search_Commodity = $("#search_Commodity").val();
           var Search_Rate_Name = $("#search_Rate_Name").val();
           //var Search_Purchase_order_No = $("#search_Purchase_Order_No").val();
           
            var Search_transfer_no = $("#search_transfer_no").val();
             var transtring = Search_transfer_no.replace(/[&\/\\#,+()$~%.':*?<>{}]/g,"\\$&");
           Search_transfer_no = window.encodeURIComponent(transtring);
           
           var Search_Purchase_order_No=$("#search_Purchase_Order_No").val();
           var newstring = Search_Purchase_order_No.replace(/[&\/\\#,+()$~%.':*?<>{}]/g,"\\$&");
           Search_Purchase_order_No = window.encodeURIComponent(newstring);
           
            // var newstring = string.replace(/[&\/\\#,+()$~%.':*?<>{}]/g,"\\$&");
            //  string = window.encodeURIComponent(newstring);
            //alert(string);
            window.location.href= "list.php?fromDate="+fromDate+"&toDate="+toDate+"&Search_SupplierName="+Search_SupplierName
            +"&Search_Branch="+Search_Branch+"&Search_code="+Search_code+"&Search_BrandName="+Search_BrandName+"&Search_Commodity="+
            Search_Commodity+"&Search_Rate_Name="+Search_Rate_Name+"&Search_Purchase_order_No="+Search_Purchase_order_No+"&Search_transfer_no="+Search_transfer_no;
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
      //   function searching() {
      //   var min_length = 1; // min caracters to display the autocomplete
      //   var keyword = $('#keywords').val();
        
      //   // alert(keyword);
      //   if (keyword.length >= min_length) {
      //     $.ajax({
      //       url: '../Product/autofill.php?' ,
      //       type: 'POST',
      //       data: {
      //         keyword: keyword
      //       },
      //       success: function(data) {
      //         $('#searching-box').show();
      //         $('#searching-box').html(data);
      //         $('#keyword').css("background","#FFF");
              
      //       }
      //     });
      //   }
      //   else 
      //   {
      //     $('#searching-box').hide();
      //   }
      // } 

      //start_myo_min
      // function set_items(items) {

      //  //var string = items; 
      //  //var newstring = string.replace(/[&\/\\#,+()$~%.':*?<>{}]/g,"\\$&");
      //   // string = window.encodeURIComponent(newstring);
      //   $('#namelist').hide();        
      //   $('#searching-box').hide();
      //   $('#keywords').val(items);
      //   //window.location.href = 'list.php?namelist='+string+'&year=&month=&day=';

      // }



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
      <div class="col-md-12">
        <form class="form-horizontal" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data" >
           
     
                    
        <!-- <div class="row"> 
        <div class="col" style="width:20%;height:30px;">
          <div class="form-group"> -->
            <!-- <label>Supplier</label> -->
            <!-- Supplier: <input type="text" class="form-control" name="supplier" id="search_supplier" onKeyUp="searchingsupplier()"><span id="supplier-searching-box"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
            Supplier: <select name="supplier" id="search_supplier" style="width:15%;height:30px;">;
                          <option value =""></option>';
                     <?php
                          $selected = ""; 
                          if(isset($_GET['selected'])){
                            $selected = $_GET['selected']; 
                          }
                            // if($_SESSION['Branch'] <> 1){                             
                              $sqls = "SELECT Distinct supplier.SupplierName as Supplier,supplier.UserId as suid 
                              FROM product
                              LEFT JOIN supplier
                              ON supplier.UserId= product.SupplierName ORDER BY supplier.SupplierName";
                          // }else{
                          //   $branch=$_SESSION['Branch'];
                          //   //$sqlp="SELECT * FROM supplier  WHERE SupplierName='$branch' ORDER BY branch";
                          //   $sqls = "SELECT Distinct supplier.SupplierName as Supplier,supplier.UserId as suid 
                          //   FROM product
                          //   LEFT JOIN supplier
                          //   ON supplier.UserId= product.SupplierName
                          //   WHERE branch='$branch' ORDER BY supplier.SupplierName";
                          // }
                          
                            $resp = $con->query($sqls);
                            while ($rowp=mysqli_fetch_array($resp)) {
                             $rowp['Supplier'] = rtrim($rowp['Supplier'],",");
                             $sid=$rowp['suid'];
                            $Supplier = $rowp["Supplier"];
  
                          print '<option value="'. $sid.'"';
                              if($sid == $selected)
                               { print ' selected= selected ';} 
  
                           print '>'. $Supplier.'</option>';
  
                           }
  
                            ?></select>

            Branch: <select name="Branch" id="search_branch" style="width:15%;height:30px;">;
                          <option value =""></option>';
                     <?php
                          $selected = ""; 
                          if(isset($_GET['selected'])){
                            $selected = $_GET['selected']; 
                          }
                          //   if($_SESSION['Branch'] == 'All'){                             
                          //  $sqlp="SELECT * FROM branch ORDER BY branch";
                          // }else{
                          //   $branch=$_SESSION['Branch'];
                          //   $sqlp="SELECT * FROM branch  WHERE branch='$branch' ORDER BY branch";
                           
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
                            $brid = $rowp['id'];
  
                          print '<option value="'. $brid.'"';
                              if($brid == $selected)
                               { print ' selected= selected ';} 
  
                           print '>'. $branch.'</option>';
  
                           }
  
                            ?></select>
           
            <!-- Code: <input type="text" class="form-control"  name="code" id="search_code" onKeyUp="searchingcode()"><span id="code-searching-box"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
              Code: <select name="code" id="search_code" style="width:15%;height:30px;">;
                          <option value=""></option>';
                     <?php
                          $selected = ""; 
                          if(isset($_GET['selected'])){
                            $selected = $_GET['selected']; 
                          }
                                                       
                            $query ="SELECT code.code,code.id FROM code";
                          
                            $restc = $con->query($query);
                            while ($rowp=mysqli_fetch_array($restc)) {
                             $rowp['code'] = rtrim($rowp['code'],",");
                            $Code = $rowp["code"];
                            $cid = $rowp["id"];
  
                          print '<option value="'. $cid.'"';
                              if($cid == $selected)
                               { print ' selected= selected ';} 
  
                           print '>'.$Code.'</option>';
  
                           }
  
                            ?></select>
            <!-- </div>
          </div> -->
          BrandName: <select name="BrandName" id="search_BrandName" style="width:15%;height:30px;">;
                          <option value=""></option>';
                     <?php
                          $selected = ""; 
                          if(isset($_GET['selected'])){
                            $selected = $_GET['selected']; 
                          }
                           
                          
                          $queryb ="SELECT brandname.brandname,brandname.id FROM brandname";
                          $restc = $con->query($queryb);
                            while ($rowp=mysqli_fetch_array($restc)) {
                             $rowp['brandname'] = rtrim($rowp['brandname'],",");
                            $brandname = $rowp["brandname"];
                            $brand_id = $rowp["id"];
  
                          print '<option value="'. $brand_id.'"';
                              if($brand_id == $selected)
                               { print ' selected= selected ';} 
  
                           print '>'.$brandname.'</option>';
  
                           }
  
                            ?></select>
          <!-- <div class="col"  style="width:20%;height:30px;">
          <div class="form-group">
           <label>BrandName</label> -->
           <!-- BrandName:<input type="text" class="form-control" name="BrandName" id="search_BrandName" onKeyUp="searchingBrandName()"><span id="BrandName-searching-box"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
            <!-- </div>

            
          </div> -->

          <!-- <div class="col"  style="width:20%;height:30px;">
          <div class="form-group">
            <label>Commodity</label> -->
           
            Commodity: <select name="Commodity" id="search_Commodity" style="width:15%;height:30px;" >;
                          <option value=""></option>';
                     <?php
                          $selected = ""; 
                          if(isset($_GET['selected'])){
                            $selected = $_GET['selected']; 
                          }
                           
                          
                          $queryb ="SELECT commodity,commodity.id FROM commodity";
                          $restc = $con->query($queryb);
                            while ($rowp=mysqli_fetch_array($restc)) {
                             $rowp['commodity'] = rtrim($rowp['commodity'],",");
                            $commodity = $rowp["commodity"];
                            $cid = $rowp["id"];
  
                          print '<option value="'. $cid.'"';
                              if($cid == $selected)
                               { print ' selected= selected ';} 
  
                           print '>'. $commodity.'</option>';
  
                           }
  
                            ?></select><br><br>
            <!-- </div>
          </div> -->

          <!-- <div class="col"  style="width:20%;height:30px;">
          <div class="form-group">
            <label>Rate Name</label> -->
            Rate Name:<select name="Rate_Name" id="search_Rate_Name" style="width:15%;height:30px;">
              <option value="">Rate</option>
               <option value="USD">USD</option>
               <option value="Myanmar">Myanmar</option>
               <option value="Japan">Japan</option>
               <option value="Thailand">Thailand</option>
               <option value="Europe">Europe</option>
               <option value="Singapore">Singapore</option>
               <option value="Australia">Australia</option>            
            </select>
            <!-- </div>
          </div> -->

          <!-- <div class="col"  style="width:20%;height:30px;">
          <div class="form-group">
            <label>PL NO</label> -->
            PL NO: <select name="Purchase_order_No" id="search_Purchase_Order_No" style="width:15%;height:30px;">;
                          <option value=""></option>';
                     <?php
                          $selected = ""; 
                          if(isset($_GET['selected'])){
                            $selected = $_GET['selected']; 
                          }
                        
                          $querypur ="SELECT DISTINCT Purchase_order_No,Branch FROM product ORDER BY Purchase_order_No";
                          $restc = $con->query($querypur);
                            while ($rowp=mysqli_fetch_array($restc)) {
                             $rowp['Purchase_order_No'] = rtrim($rowp['Purchase_order_No'],",");
                            $Purchase_order_No = $rowp["Purchase_order_No"];
  
                          print '<option value="'. $Purchase_order_No.'"';
                              if($Purchase_order_No == $selected)
                               { print ' selected= selected ';} 
  
                           print '>'. $Purchase_order_No.'</option>';
  
                           }
  
                            ?></select>
                            
                             Transfer No: <select name="transfer_no" id="search_transfer_no" style="width:15%;height:30px;">;
                          <option value=""></option>';
                     <?php
                          $selected = ""; 
                          if(isset($_GET['selected'])){
                            $selected = $_GET['selected']; 
                          }
                        
                          $querypur ="SELECT DISTINCT transfer_no,Branch FROM product ORDER BY transfer_no";
                          $restc = $con->query($querypur);
                            while ($rowp=mysqli_fetch_array($restc)) {
                             $rowp['transfer_no'] = rtrim($rowp['transfer_no'],",");
                            $transfer_no = $rowp["transfer_no"];
  
                          print '<option value="'. $transfer_no.'"';
                              if($transfer_no == $selected)
                               { print ' selected= selected ';} 
  
                           print '>'. $transfer_no.'</option>';
  
                           }
  
                            ?></select>
            <!-- </div>
          </div>
       </div> -->

        <!-- <input type="text" id="keywords" name="searchkeyword" style="margin-left: 7px;width: 15%;margin-top:1%;" onKeyUp="searching()" placeholder="search..." /><span id="searching-box"></span> -->
        
        
        
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
                <th rowspan="2" style="word-wrap:break-word;">Code</th>
                <th rowspan="2" style="word-wrap:break-word;">BrandName</th>
                <th colspan="9" style="word-wrap:break-word;">Commodity</th>
                <?php 
                $Authority = $_SESSION['authority'];
                if ($Authority == 'Accountant') {
                  print'
                  <th colspan="4" class="tableColGroupAssociate" id="rate">Rate</th>';}?>
                  <th rowspan="2" style="">PL NO</th>
                  <th rowspan="2" style="">Transfer NO</th>
                  <th rowspan="2" style="">PO NO</th>

                </tr>
                <tr>
                  <th style="font-weight:normal;word-wrap:break-word;" class="item">Item</th>
                  <th style="font-weight:normal;" class="type">Type</th>
                  <th style="font-weight:normal;" class="stock">Stock in</th>
                  <th style="font-weight:normal;" class="stock">Transfer</th>
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
                    <th style="font-weight:normal;background: #ffff66;"  class="tt">Home Currency</th>
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

                $sqls .= " SELECT product.*,branch.branch as branch_name,product.id as pID,code.code as code_no,supplier.SupplierName AS sSupplierName,brandname.brandname as pbrandname,
                commodity.commodity as ccommodity
                FROM product 
                LEFT JOIN supplier
                ON product.SupplierName= supplier.UserId                 
                LEFT JOIN code ON code.id= product.code
                JOIN brandname ON product.BrandName= brandname.id 
                JOIN commodity ON product.Commodity= commodity.id
                JOIN branch ON product.Branch= branch.id";
                // LEFT JOIN rate
                // ON product.Packing_date= rate.Rate_date
                // WHERE product.Packing_date= rate.Rate_date ";

                if ($Branches <> 1) {
                  $sqls .= " AND product.Branch='$Branches' ";
                }
              if (!empty($_GET['fromDate']) && !empty($_GET['toDate'])){
                $fromDate = date("Y-m-d",strtotime($_GET['fromDate']));
                $toDate = date("Y-m-d", strtotime($_GET['toDate'])); 
                $sqls =$sqls." AND product.Packing_date BETWEEN '$fromDate'  AND '$toDate'";
                }
                //  if (isset($_POST['keyword'])) {
                //    $keyword = $_POST['keyword'];
                //    $sqls =$sqls." AND supplier.SupplierName LIKE '%$keyword%' OR brandname.brandname= '".$_GET['keyword']."' OR product.Purchase_order_No LIKE '%$keyword%' OR product.PO_NO LIKE '%$keyword%'OR commodity.commodity= '".$_GET['keyword']."'  OR product.Branch LIKE '%$keyword%'";
                //  } 
                
                 if(isset($_GET['Search_SupplierName']) && $_GET['Search_SupplierName'] != ''){
                   $SupplierName=$_GET['Search_SupplierName'];
                   $sqls =$sqls." AND product.SupplierName='$SupplierName'";
                 }
                 if(isset($_GET['Search_BrandName']) && $_GET['Search_BrandName'] != ''){
                  $brandname=$_GET['Search_BrandName'];
                  $sqls =$sqls." AND product.BrandName='$brandname'";
                }
                if(isset($_GET['Search_Commodity']) && $_GET['Search_Commodity'] != ''){
                  $Commodity=$_GET['Search_Commodity'];
                  $sqls =$sqls." AND product.Commodity='$Commodity'";
                }
                if(isset($_GET['Search_code'])  && $_GET['Search_code'] != ''){
                  $code=$_GET['Search_code'];
                  $sqls =$sqls." AND product.code='$code'";
                }
                if(isset($_GET['Search_Rate_Name'])  && $_GET['Search_Rate_Name'] != ''){
                  $Rate_Name=$_GET['Search_Rate_Name'];
                  $sqls =$sqls." AND product.Rate_Name='$Rate_Name'";
                }
                if(isset($_GET['Search_Purchase_order_No']) && $_GET['Search_Purchase_order_No'] != ''){
                  $Purchase_order_No=$_GET['Search_Purchase_order_No'];
                  $sqls =$sqls." AND product.Purchase_order_No='$Purchase_order_No'";
                }
                if(isset($_GET['Search_transfer_no']) && $_GET['Search_transfer_no'] != ''){
                  $transfer_no=$_GET['Search_transfer_no'];
                  $sqls =$sqls." AND product.transfer_no='$transfer_no'";
                }
                if(isset($_GET['Search_Branch'])  && $_GET['Search_Branch'] != ''){
                  $Branch=$_GET['Search_Branch'];
                  $sqls =$sqls." AND product.Branch='$Branch'";
                }
                //  if (isset($_POST['keyword'])) {
                //   $keyword = $_POST['keyword'];
                //   $sqls =$sqls." AND supplier.SupplierName = '$keyword' OR product.BrandName = '$keyword' OR product.Purchase_order_No = '$keyword' OR product.PO_NO = '$keyword' OR product.Commodity = '$keyword' OR product.Branch = '$keyword'";
                // }
        //   echo urldecode($_GET['namelist']);
                // if ($_GET['namelist'] <> ''){
                //   $sqls =$sqls." AND (supplier.SupplierName= '".$_GET['namelist']."' OR brandname.brandname= '".$_GET['namelist']."'  OR product.Purchase_order_No= '".$_GET['namelist']."' OR product.PO_NO= '".$_GET['namelist']."'OR commodity.commodity= '".$_GET['namelist']."' OR product.Branch= '".$_GET['namelist']."')";
                // }                         
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
         <script src="../js/select2.min.js" type="text/javascript"></script>
        <script>
          $("#search_branch").select2( {
  placeholder: "Select Branch",
  allowClear: true
  } );

  $("#search_supplier").select2( {
  placeholder: "Select Supplier",
  allowClear: true
  } );

  $("#search_code").select2( {
  placeholder: "Select Code",
  allowClear: true
  } );

  $("#search_BrandName").select2( {
  placeholder: "Select BrandName",
  allowClear: true
  } );

  $("#search_Commodity").select2( {
  placeholder: "Select Commodity",
  allowClear: true
  } );

  $("#search_Purchase_Order_No").select2( {
  placeholder: "Select PL No",
  allowClear: true
  } );
  
  $("#search_transfer_no").select2( {
  placeholder: "Select Transfer No",
  allowClear: true
  } );
          </script>
