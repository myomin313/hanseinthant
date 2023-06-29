<?php session_start();?>
<?php 
if (($_SESSION['login_session']<> true)) {
  header("Location:../index.php");    
  exit();
}     

?>
<?php 
include_once('../config.php');
include_once('../instockbar.php');
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

        <style type="text/css">
          table {
            border-collapse: collapse;
            width: 500px;
          }
        </style>
        <!doctype html>
        <html>
        <head>
          <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
          <link rel="stylesheet" href="/resources/demos/style.css">
          <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
          <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
          <script type="text/javascript">
            $(document).ready(function () {  
              $('#stockSearch').on('click',function () {
               var startDate = $('#startDate').val();
               var endDate = $('#endDate').val();
               var keywords = $('#keywords').val();
               var string = $('#keywords').val(); 
               var newstring = string.replace(/[&\/\\#,+()$~%.':*?<>{}]/g,"\\$&");
            string = window.encodeURIComponent(newstring);
          window.location.href = "list.php?startDate="+startDate+"&endDate="+endDate+"&keyword="+string;
        });  
            });
          </script> 

          <script type="text/javascript">
            var xport = {
              _fallbacktoCSV: true,  

              toCSV: function(tableId, filename) {
        this._filename = (typeof filename === 'undefined') ? tableId : filename;
    // Generate our CSV string from out HTML Table
    var csv = this._tableToCSV(document.getElementById(tableId));
    // Create a CSV Blob
    var blob = new Blob([csv], { type: "text/csv" });
    // Determine which approach to take for the download
    if (navigator.msSaveOrOpenBlob) {
      // Works for Internet Explorer and Microsoft Edge
      navigator.msSaveOrOpenBlob(blob, this._filename + ".csv");
    } else {      
      this._downloadAnchor(URL.createObjectURL(blob), 'csv');      
    }
  },
  _getMsieVersion: function() {
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    if (msie > 0) {
      // IE 10 or older => return version number
      return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
    }
    var trident = ua.indexOf("Trident/");
    if (trident > 0) {
      // IE 11 => return version number
      var rv = ua.indexOf("rv:");
      return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
    }
    var edge = ua.indexOf("Edge/");
    if (edge > 0) {
      // Edge (IE 12+) => return version number
      return parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10);
    }
    // other browser
    return false;
  },
  _isFirefox: function(){
    if (navigator.userAgent.indexOf("Firefox") > 0) {
      return 1;
    }
    
    return 0;
  },
  _downloadAnchor: function(content, ext) {
    var anchor = document.createElement("a");
    anchor.style = "display:none !important";
    anchor.id = "downloadanchor";
    document.body.appendChild(anchor);
      // If the [download] attribute is supported, try to use it      
      if ("download" in anchor) {
        anchor.download = this._filename + "." + ext;
      }
      anchor.href = content;
      anchor.click();
      anchor.remove();
    },
    _tableToCSV: function(table) {
    // We'll be co-opting `slice` to create arrays
    var slice = Array.prototype.slice;
    return slice
    .call(table.rows)
    .map(function(row) {
      return slice
      .call(row.cells)
      .map(function(cell) {
        return '"t"'.replace("t", cell.textContent);
      })
      .join(",");
    })
    .join("\r\n");
  }
};

</script>
</head>

<script type="text/javascript">  
  function searching() {
        var min_length = 1; // min caracters to display the autocomplete
        var keyword = $('#keywords').val();
        // alert(keyword);
        if (keyword.length >= min_length) {
          $.ajax({
            url: '../Instock/autofill.php?' ,
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
        $('#namelist').hide();        
        $('#searching-box').hide();
        $('#keywords').val(items);
          //window.location.href = 'list.php?&startDate=&endDate=&keywords='+'&namelist='+string;

        }
      </script>

      <script type="text/javascript">
        $(document).ready(function () { 
        // }); 
        $('#branch').change(function () {
          window.location.href = 'list.php?year=' +$("#year option:selected").val()+'&month='+$("#month option:selected").val()+'&day='+$("#day option:selected").val()+'&branch='+this.options[this.selectedIndex].value+"&namelist=&Commodities=&remain=&brandsearch="; 
        }); 

        $('#brandsearch').change(function () {
          window.location.href = 'list.php?year=' +$("#year option:selected").val()+'&month='+$("#month option:selected").val()+'&day='+$("#day option:selected").val()+'&brandsearch='+this.options[this.selectedIndex].value+"&namelist=&Commodities=&remain=&branch="; 
        }); 
        $('#Commodity').change(function () {
          window.location.href = 'list.php?year=' +$("#year option:selected").val()+'&month='+$("#month option:selected").val()+'&day='+$("#day option:selected").val()+'&Commodities='+this.options[this.selectedIndex].value+"&remain=&brandsearch=&remain=&branch="; 
        }); 

        $('#remain').change(function () {
          window.location.href = 'list.php?year=' +$("#year option:selected").val()+'&month='+$("#month option:selected").val()+'&day='+$("#day option:selected").val()+'&Commodities='+$("#Commodity option:selected").val()+'&remain='+this.options[this.selectedIndex].value+"&brandsearch=&branch="; 
        }); 
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

<script>
  $( function() {
   $( "#startDate" ).datepicker({
    dateFormat: "dd-mm-yy"
  });
   $( "#endDate" ).datepicker({
    dateFormat: "dd-mm-yy"
  });
 });
  
</script>
<!-- <style type="text/css">
  .loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style> 
 -->
</head>
<body style="font-size: 10px; font-family:Tahoma, Geneva, sans-serif;"> 

 <!--  <div class="loader"></div> -->

    <div class="row">
    <div class="col-sm-12">
      <form class="form-horizontal" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data" >
  <input type="text" name="keyword" id="keywords" style="margin-left: 7px;width: 15%;margin-top:1%;" onKeyUp="searching()" placeholder="search..." /><span id="searching-box"></span>
 
    From: <input type="text" name="startDate" id="startDate"  placeholder="start date"  autocomplete="off" >
     To:         
      <input type="text" name="endDate" id="endDate"  placeholder="end date" autocomplete="off">
      <input type="button"  id="stockSearch" value="search">  
       <button type="submit" id="Export" name="Export"  class="export" ><img src = "../image/Excel-icon.png" width="11px";  >Export</button>
       </form>     
    </div>         
  </div>
  <div id="outer-container">
    <div id="scrollable" style="height:710px;">

      <table id="emp_table" border="0" class="resultGridTable" style="width: auto;margin-top: 1%;font-size:10px;">
        <tr class="tr_header" style="background-color:#3385ff;font-family:Tahoma, Geneva, sans-serif;font-size: 12px;">
                      <th style="width:2%;">S/N</td>
                      <th style="word-wrap:break-word;width:9%;" >Branch</td>
                      <th style="word-wrap:break-word;">BrandName</td>
                      <th>Commodity</td>        
                      <th >Total Input</td>
                      <th >Total WIP</td>
                      <th style="word-wrap:break-word;">Total Delivery</th>
                      <th style="word-wrap:break-word;">Total Return</th>
                      <th style="word-wrap:break-word;width: 30%;">Remark</th>
                      <th style="word-wrap:break-word;">Total Stock Balance For Sale</th>
                      <th style="word-wrap:break-word;">Actual Total Stock Balance</th>

                      <!-- <th style="word-wrap:break-word;">PL</th> -->
                      <?php 
                      $Authority = $_SESSION['authority'];
                      if ($Authority == 'Accountant') {               
                        print'
                        <th style="word-wrap:break-word;">Total Input USD</th>';
                        print'
                        <th style="word-wrap:break-word;">Total Output USD</th>';
                        print'
                        <th style="word-wrap:break-word;">Balance USD</th>';
                      }?>

                    </tr>      
                    <?php
                    $Branches = $_SESSION['Branch'];

                    $con->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));SET GLOBAL group_concat_max_len = 1000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000");
          
          $sqlHeader = "
          SELECT
          *
          FROM
          (SELECT *, @rownum :=(@rownum +1) AS num
          FROM
          (SELECT @rownum := 0) AS initialization,
          (
          ";      

           $sqlA="SELECT                 
          Branch AS pBranch,
          brandname.brandname AS pbrand,
          commodity.commodity AS pCommodity,
          PoMst.BrandName,
          PoMst.Commodity,
          COUNT(*) AS Duplicate_Records,
          IFNULL(pQty,0) AS pQty,
          IFNULL(JWIP,0) AS wip,
          IFNULL(dQty,0) AS balanceDelivery,
          IFNULL(returnrQty,0) AS rQty,
          ddQty AS LastdQty,
          LastWIP AS LastWIP,
          returnrrQty AS returnrrQty,
          pRate AS balancetotalUSD,
          (CASE WHEN IFNULL(ddQty,0) < IFNULL(LastWIP,0) THEN (IFNULL(ANY_VALUE(pQty),0) -  IFNULL(LastWIP,0)) +  IFNULL(returnrrQty, 0)   
               WHEN IFNULL(LastWIP,0) < IFNULL(ddQty,0) THEN (IFNULL(ANY_VALUE(pQty),0) -  IFNULL(ddQty,0)) + IFNULL(returnrrQty, 0)   
               WHEN IFNULL(LastWIP,0) = IFNULL(ddQty,0) THEN (IFNULL(ANY_VALUE(pQty),0) -  IFNULL(LastWIP,0)) + IFNULL(returnrrQty, 0) 
               END) AS  balancecQty,
          ( ( IFNULL(ANY_VALUE(pQty), 0) - IFNULL(ddQty, 0)) + IFNULL(returnrrQty, 0)  ) AS currentcQty,
          SUM(totalUSD) AS totalUSDs,
          IFNULL(pRemarks,'') AS pRemarks,IFNULL(jRemarks,'') AS jRemarks,IFNULL(dRemarks,'') AS dRemarks,IFNULL(rRemarks,'') AS rRemarks
          FROM 
          product PoMst
         JOIN brandname ON PoMst.BrandName = brandname.id 
         JOIN commodity ON PoMst.Commodity = commodity.id   
         LEFT JOIN (SELECT BrandName AS pBrandName,Commodity AS pCommodity,Branch AS pBranch,SUM(Qty) AS pQty,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS pRemarks
          FROM product USE INDEX (Branch,Packing_date,BrandName,Commodity) WHERE 1=1";
          

          if ($Branches <> 'All') {
            $sqlA .=" AND product.Branch='$Branches'";
          }

         if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
             $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
             $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
               $sqlA .="  AND ( Packing_date BETWEEN '$fromDate' AND '$toDate' ) GROUP BY BrandName,Commodity,Branch) tblProd
          ON  PoMst.BrandName=tblProd.pBrandName
          AND PoMst.Commodity=tblProd.pCommodity
          AND PoMst.Branch=tblProd.pBranch
          LEFT JOIN (SELECT ANY_VALUE(Job_date) AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,SUM(WIP) as JWIP,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
           FROM job USE INDEX (Location,Job_date,BrandName,Commodity)";
              
         }else{
             $sqlA .=" GROUP BY BrandName,Commodity,Branch) tblProd
          ON  PoMst.BrandName=tblProd.pBrandName
          AND PoMst.Commodity=tblProd.pCommodity
          AND PoMst.Branch=tblProd.pBranch
          LEFT JOIN (SELECT ANY_VALUE(Job_date) AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,SUM(WIP) as JWIP,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
          FROM job USE INDEX (Location,Job_date,BrandName,Commodity) ";
         }
             
          if ($Branches <> 'All') {
            $sqlA .=" WHERE job.Location='$Branches'";
          }
           if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
               if( $Branches <> 'All'){
                  $sqlA .=" AND ( Job_date BETWEEN '$fromDate' AND '$toDate' ) ";
               }else{
                  $sqlA .=" WHERE  Job_date BETWEEN '$fromDate' AND '$toDate' ";
               }
              $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
              $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
            $sqlA .=" GROUP BY Commodity,BrandName,Location) tblJob
          ON  PoMst.BrandName=tblJob.jBrandName
          AND PoMst.Commodity=tblJob.jCommodity
          AND PoMst.Branch=tblJob.jLocation   

          LEFT JOIN (SELECT ANY_VALUE(j.Job_date) AS jjJob_date, j.BrandName AS jjBrandName,j.Commodity AS jjCommodity,SUM(j.WIP) AS LastWIP,j.Location AS jjLocation
          FROM job j USE INDEX (Location,Job_date,BrandName,Commodity) ";

           }else{

             $sqlA .=" GROUP BY Commodity,BrandName,Location) tblJob
          ON  PoMst.BrandName=tblJob.jBrandName
          AND PoMst.Commodity=tblJob.jCommodity
          AND PoMst.Branch=tblJob.jLocation   

          LEFT JOIN (SELECT ANY_VALUE(j.Job_date) AS jjJob_date, j.BrandName AS jjBrandName,j.Commodity AS jjCommodity,SUM(j.WIP) AS LastWIP,j.Location AS jjLocation
          FROM job j USE INDEX (Location,Job_date,BrandName,Commodity)";  

           }
           // new start
           if ($Branches <> 'All') {
            $sqlA .=" WHERE j.Location='$Branches'";
          }
            // new
           if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
             $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
             $toDate   =date("Y-m-d",strtotime($_GET['endDate']));

             if( $Branches <> 'All'){
                  $sqlA .=" AND j.Job_date <= '$toDate' ";
               }else{
                  $sqlA .=" WHERE  j.Job_date <= '$toDate' ";
               }

               $sqlA .=" GROUP BY j.BrandName,j.Commodity,j.Location) tblJobLast
          ON  PoMst.BrandName=tblJobLast.jjBrandName
          AND PoMst.Commodity=tblJobLast.jjCommodity
          AND PoMst.Branch=tblJobLast.jjLocation
          LEFT JOIN (SELECT ANY_VALUE(Delivery_date) AS Delivery_date,BrandName AS dBrandName,Commodity AS dCommodity,SUM(Qty) as dQty,Location AS dLocation,GROUP_CONCAT(Remark_Item  SEPARATOR '   ') AS dRemarks
           FROM delivery USE INDEX (Location,Delivery_date,BrandName,Commodity)";
              
         }else{
             $sqlA .=" GROUP BY  BrandName,Commodity,Location) tblJobLast
          ON  PoMst.BrandName=tblJobLast.jjBrandName
          AND PoMst.Commodity=tblJobLast.jjCommodity
          AND PoMst.Branch=tblJobLast.jjLocation
          LEFT JOIN (SELECT ANY_VALUE(Delivery_date) AS x,BrandName AS dBrandName,Commodity AS dCommodity,SUM(Qty) as dQty,Location AS dLocation,GROUP_CONCAT(Remark_Item  SEPARATOR '   ') AS dRemarks
          FROM delivery USE INDEX (Location,Delivery_date,BrandName,Commodity)";
         }
         // new
           // new end
           
           if ($Branches <> 'All') {
            $sqlA .=" WHERE job.Location='$Branches'";
          }
           if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
               if( $Branches <> 'All'){
                  $sqlA .=" AND ( Job_date BETWEEN '$fromDate' AND '$toDate' ) ";
               }else{
                  $sqlA .=" WHERE  Job_date BETWEEN '$fromDate' AND '$toDate' ";
               }
              $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
              $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
            $sqlA .=" GROUP BY Commodity,BrandName,Location) tblJob
          ON  PoMst.BrandName=tblJob.jBrandName
          AND PoMst.Commodity=tblJob.jCommodity
          AND PoMst.Branch=tblJob.jLocation   

          LEFT JOIN (SELECT ANY_VALUE(j.Job_date) AS jjJob_date, j.BrandName AS jjBrandName,j.Commodity AS jjCommodity,SUM(j.WIP) AS LastWIP,j.Location AS jjLocation
          FROM job j USE INDEX (Location,Job_date,BrandName,Commodity) ";

           }else{

             $sqlA .=" GROUP BY Commodity,BrandName,Location) tblJob
          ON  PoMst.BrandName=tblJob.jBrandName
          AND PoMst.Commodity=tblJob.jCommodity
          AND PoMst.Branch=tblJob.jLocation   

          LEFT JOIN (SELECT ANY_VALUE(j.Job_date) AS jjJob_date, j.BrandName AS jjBrandName,j.Commodity AS jjCommodity,SUM(j.WIP) AS LastWIP,j.Location AS jjLocation
          FROM job j USE INDEX (Location,Job_date,BrandName,Commodity)";  

           }
           
           // new
           if ($Branches <> 'All') {
            $sqlA .=" WHERE delivery.Location='$Branches'";
          }
           if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
              $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
              $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
              if( $Branches <> 'All'){
                  $sqlA .=" AND ( Delivery_date BETWEEN '$fromDate' AND '$toDate' ) ";
               }else{
                  $sqlA .=" WHERE Delivery_date BETWEEN '$fromDate' AND '$toDate' ";
               }
            $sqlA .=" GROUP BY Commodity,BrandName,Location) tblDeli
          ON  PoMst.BrandName=tblDeli.dBrandName
          AND PoMst.Commodity=tblDeli.dCommodity
          AND PoMst.Branch=tblDeli.dLocation   

          LEFT JOIN (SELECT ANY_VALUE(d.Delivery_date) AS ddDelivery_date, d.BrandName AS ddBrandName,d.Commodity AS ddCommodity,SUM(d.Qty) AS ddQty,d.Location AS ddLocation,SUM(pd.USD * d.Qty) as pRate
          FROM delivery d  LEFT JOIN product pd ON pd.Purchase_order_No = d.PL AND pd.BrandName = d.BrandName AND pd.Commodity = d.Commodity AND pd.Branch = d.Location";

           }else{

             $sqlA .=" GROUP BY Commodity,BrandName,Location) tblDeli
          ON  PoMst.BrandName=tblDeli.dBrandName
          AND PoMst.Commodity=tblDeli.dCommodity
          AND PoMst.Branch=tblDeli.dLocation   

          LEFT JOIN (SELECT ANY_VALUE(d.Delivery_date) AS ddDelivery_date, d.BrandName AS ddBrandName,d.Commodity AS ddCommodity,SUM(d.Qty) AS ddQty,d.Location AS ddLocation,SUM(pd.USD * d.Qty) as pRate
          FROM delivery d LEFT JOIN product pd ON pd.Purchase_order_No = d.PL AND pd.BrandName = d.BrandName AND pd.Commodity = d.Commodity AND pd.Branch = d.Location";

           }
           // new end
          
          if ($Branches <> 'All') {
            $sqlA .=" WHERE d.Location='$Branches'";
          }

           if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
                 $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
                 $toDate   =date("Y-m-d",strtotime($_GET['endDate']));

                if( $Branches <> 'All'){
                  $sqlA .=" AND d.Delivery_date <= '$toDate' ";
               }else{
                  $sqlA .=" WHERE d.Delivery_date <= '$toDate' ";
               }
          
          $sqlA .=" GROUP BY d.Commodity,d.BrandName,d.Location ) tblDeliLast 
          ON  PoMst.BrandName=tblDeliLast.ddBrandName
          AND PoMst.Commodity=tblDeliLast.ddCommodity
          AND PoMst.Branch=tblDeliLast.ddLocation
          
          LEFT JOIN (SELECT ANY_VALUE(Return_date) AS Return_date,Commodity AS rCommodity,BrandName AS rBrandName,SUM(Qty) as returnrQty,department AS rDepartment
          ,GROUP_CONCAT(Remarks_item SEPARATOR ' ') AS rRemarks
          FROM returns USE INDEX (department,Return_date,BrandName,Commodity)"; 
           }else{

               $sqlA .=" GROUP BY d.Commodity,d.BrandName,d.Location) tblDeliLast 
          ON  PoMst.BrandName=tblDeliLast.ddBrandName
          AND PoMst.Commodity=tblDeliLast.ddCommodity
          AND PoMst.Branch=tblDeliLast.ddLocation  

          LEFT JOIN (SELECT ANY_VALUE(Return_date) AS Return_date,Commodity AS rCommodity,BrandName AS rBrandName,SUM(Qty) as returnrQty,department AS rDepartment,GROUP_CONCAT(Remarks_item SEPARATOR ' ') AS rRemarks
          FROM returns USE INDEX (department,Return_date,BrandName,Commodity)"; 

           }

           if ($Branches <> 'All') {
            $sqlA .=" WHERE returns.department='$Branches'";
          }
          if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {

              $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
              $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
              if( $Branches <> 'All'){
                  $sqlA .=" AND ( Return_date BETWEEN '$fromDate' AND '$toDate' ) ";
               }else{
                  $sqlA .=" WHERE Return_date BETWEEN '$fromDate' AND '$toDate' ";
               }
          $sqlA .="GROUP BY Commodity,BrandName,department) tblRet 
          ON  PoMst.BrandName=tblRet.rBrandName
          AND PoMst.Commodity=tblRet.rCommodity
          AND PoMst.Branch=tblRet.rDepartment
          
          LEFT JOIN (SELECT ANY_VALUE(r.Return_date) AS rrReturn_date,r.Commodity AS rrCommodity,r.BrandName AS rrBrandName,SUM(r.Qty) AS returnrrQty,r.department AS rrDepartment,SUM(pt.USD * r.Qty) AS rRate FROM returns r 
          LEFT JOIN delivery dt ON dt.PL = r.PL AND dt.BrandName = r.BrandName AND dt.Commodity = r.Commodity AND dt.Location = r.department AND dt.DO_No = r.DO_No
          LEFT JOIN product pt ON pt.Purchase_order_No = dt.PL AND pt.BrandName = dt.BrandName AND pt.Commodity = dt.Commodity AND pt.Branch = dt.Location";

        }else{

           $sqlA .="GROUP BY Commodity,BrandName,department) tblRet 
          ON  PoMst.BrandName=tblRet.rBrandName
          AND PoMst.Commodity=tblRet.rCommodity
          AND PoMst.Branch=tblRet.rDepartment
          
          LEFT JOIN (SELECT ANY_VALUE(r.Return_date) AS rrReturn_date,r.Commodity AS rrCommodity,r.BrandName AS rrBrandName,SUM(r.Qty) AS returnrrQty,r.department AS rrDepartment,SUM(pt.USD * r.Qty) AS rRate FROM returns r  
          LEFT JOIN delivery dt ON dt.PL = r.PL AND dt.BrandName = r.BrandName AND dt.Commodity = r.Commodity AND dt.Location = r.department AND dt.DO_No = r.DO_No
          LEFT JOIN product pt ON pt.Purchase_order_No = dt.PL AND pt.BrandName = dt.BrandName AND pt.Commodity = dt.Commodity AND pt.Branch = dt.Location";

        }
          
          if ($Branches <> 'All') {
            $sqlA .=" WHERE r.department='$Branches'";
          }
          // end

       if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
              $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
              $toDate   =date("Y-m-d",strtotime($_GET['endDate']));

              if( $Branches <> 'All'){
                  $sqlA .=" AND r.Return_date <= '$toDate' ";
               }else{
                  $sqlA .=" WHERE r.Return_date <= '$toDate' ";
               }

          $sqlA .=" GROUP BY Commodity,BrandName,department ) tblRetLast 
          ON  PoMst.BrandName=tblRetLast.rrBrandName
          AND PoMst.Commodity=tblRetLast.rrCommodity
          AND PoMst.Branch=tblRetLast.rrDepartment  
          WHERE 1=1 ";
        }else{
           $sqlA .=" GROUP BY Commodity,BrandName,department) tblRetLast 
          ON  PoMst.BrandName=tblRetLast.rrBrandName
          AND PoMst.Commodity=tblRetLast.rrCommodity
          AND PoMst.Branch=tblRetLast.rrDepartment  
          WHERE 1=1 ";
        }

        if ($Branches <> 'All') {
            $sqlA .=" AND PoMst.Branch='$Branches'";
          }

          

       if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])){
           $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
           $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
           $sqlA =$sqlA." AND (Packing_date BETWEEN '$fromDate' AND '$toDate' OR Job_date BETWEEN '$fromDate' AND '$toDate' OR Delivery_date BETWEEN '$fromDate' AND '$toDate' OR Return_date BETWEEN '$fromDate' AND '$toDate')";
       } 
         //  if (isset($_GET['keyword'])) {
         //   $keyword = $_GET['keyword'];
         //   $sqlA =$sqlA." AND (BrandName LIKE '%$keyword%' OR Commodity LIKE '%$keyword%' OR branch LIKE '%$keyword%')";
         // }
          
         if (!empty($_GET['keyword'])) {
           $keyword = $_GET['keyword'];
           $sqlA =$sqlA." AND ( brandname.brandname = '$keyword' OR commodity.commodity = '$keyword' OR branch = '$keyword' )";
         } 
          $sqlA = $sqlA. " GROUP BY
          PoMst.BrandName,
          PoMst.Commodity,
          Branch
          HAVING
          COUNT(*) >= 1
          ORDER BY
          brandname.brandname         
          "; 
          
          echo  $sqlA;exit();
             
          $sqlFooter ="
          ) Tbl
          ) tbl1
          WHERE
          1 = 1 ORDER BY
          num ASC";
          
          
          
        //   var_dump($sqlA->toSql());exit();
        //   var_dump($sqlA->toSql());exit(); 
          
         // $sqllimit=" LIMIT 30";

         

          $iDataCnt = 0;
           // $sSQLQuery= " SELECT COUNT(*) AS CntRow FROM ( " . $sqlA . " ) Tbl";
         
           //    $result=mysqli_query($con , $sSQLQuery);
           //    while($row = mysqli_fetch_array($result)){
           //      $iDataCnt = $row['CntRow'];
           //    }
          // $rr=$sqlHeader . $sqlA .  $sqlFooter;
          // $result = mysqli_query($con,$rr);
          
          // $total_rows = mysqli_num_rows($result);
          // $total_pages = ceil($total_rows / $no_of_records_per_page);
          //var_dump($total_pages);exit();
         

          $sSQLQuery= $sqlHeader . $sqlA .  $sqlFooter;
          
          
          
         
       
          $result=mysqli_query($con , $sSQLQuery);         
         //echo $sSQLQuery;
          $namelist =$_GET['namelist']; 
          $keyword = ""; 
         $_SESSION["InStock_LoadMoreQuery"] = $sSQLQuery;    
          $_SESSION["InStock_DataCnt"] = $iDataCnt; 
          //$_SESSION["InStock_namelist"] =$_GET['namelist']; 
          $_SESSION["InStock_balanceQtys"] = "0";
          $_SESSION["InStock_currentQtys"] = "0";
          $_SESSION["InStock_TotalBalance"] = "0";
          $_SESSION["InStock_minus"] = "0";
          $_SESSION["InStock_keyword"] ="";
          $sno = 1;
          if(isset($_POST['keyword'])){
            $keyword = $_POST['keyword']; 
            $_SESSION["InStock_keyword"] =$_POST['keyword'];
          }
          include('show_data.php');
        /*  print '<tr>';
         if ($Authority == 'Accountant') {
             print '<th colspan="9" style="background:#ffff66;color:black;">Total USD</th>';
              print '<td  style="background:#ffff66;">' . $balanceQtys . '</td>';
            print '<td  style="background:#ffff66;">' . $currentQtys . '</td>';             
             print' <td style="background:#ffff66;">';
            

           if ($Branches == 'Shwe Pyi Thar Store') {
            $sqls="SELECT SUM(totalUSD)
            From product             
            Where Branch='Shwe Pyi Thar Store' ";
             } 
           elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {
            $sqls="SELECT SUM(totalUSD)
            From product             
            Where Branch='Shwe Pyi Thar Store Control Panel' ";
             }  
           elseif ($Branches == 'Yangon Show Room') {
            $sqls="SELECT SUM(totalUSD)
            From product             
            Where Branch='Yangon Show Room' ";
             }  
           elseif ($Branches == 'Naypyidaw Show Room') {
            $sqls="SELECT SUM(totalUSD)
            From product             
            Where Branch='Naypyidaw Show Room' ";
             }  
           elseif ($Branches == 'Mandalay Show Room') {
            $sqls="SELECT SUM(totalUSD)
            From product             
            Where Branch='Mandalay Show Room' ";
             }  
           else{
            $sqls="SELECT SUM(totalUSD)
            From product             
           Where 1=1 ";
             } 
             
          $sqls="SELECT SUM(totalUSD)
                 From product             
                 Where 1=1 ";
          if ($Branches != 'All') {
            $sqls=" AND Branch='$Branches' ";
          }


          if (isset($_POST['keyword'])) {
           $keyword = $_POST['keyword']; 
           //$sqls =$sqls." AND  product.BrandName LIKE '%$keyword%'OR product.Commodity LIKE '%$keyword%'OR product.branch LIKE '%$keyword%'";
           $sqls =$sqls." AND  BrandName LIKE '%$keyword%'OR product.Commodity LIKE '%$keyword%'OR product.branch LIKE '%$keyword%'";

           }  
                        
           if ($_GET['namelist'] <> ''){
            //$sqls =$sqls." AND  product.BrandName= '".$_GET['namelist']."'OR product.Commodity= '".$_GET['namelist']."'OR product.branch= '".$_GET['namelist']."'";
            $sqls =$sqls." AND  BrandName= '".$_GET['namelist']."'OR product.Commodity= '".$_GET['namelist']."'OR product.branch= '".$_GET['namelist']."'";
                                // echo $sqls;
             }                    
                 $result = $con->query($sqls);
                    while($row=$result->fetch_assoc())
                    {
                      $g=$row['SUM(totalUSD)'];

                   // echo $g;
                    if ($Authority == 'Accountant') {
                      
                      echo '<span>'.$g.' &nbsp&nbsp$</span>';
                    }
                    
                    }     
            print' </td>'; 

            print '<td  style="background:#ffff66;">' . $TotalBalance . '&nbsp&nbsp$</td>';
            print '<td  style="background:#ffff66;">' . $minus . '&nbsp&nbsp$</td>';   

           }          

           print '</tr>';*/ 
           print ' </table>'; 
           ?>  
           <div class="ajax-load" style="display:none;text-align:center;">
            <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More...</p>
          </div>

        </div>
      </div>

    </body>
    </html>