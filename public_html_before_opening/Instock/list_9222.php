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
              var search_branch=$("#search_branch").val();
              var search_code=$("#search_code").val();
              var search_BrandName=$("#search_BrandName").val();
              var search_Commodity=$("#search_Commodity").val();
          window.location.href= "list.php?startDate="+startDate+"&endDate="+endDate+"&search_branch="+search_branch+"&search_code="+search_code+"&search_BrandName="+search_BrandName+"&search_Commodity="+search_Commodity;

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
    <div class="col-sm-12" style="margin-top:1%;">
      <form class="form-horizontal" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data" >
  
  
   <!-- <input type="text" name="keyword" id="keywords" style="margin-left: 7px;width: 15%;margin-top:1%;" onKeyUp="searching()" placeholder="search..." /><span id="searching-box"></span> -->
    
   Branch: <select name="Branch" id="search_branch" style="width:15%;height:30px;">
                          <option value =""></option>';
                     <?php
                          $selected = ""; 
                          if(isset($_GET['selected'])){
                            $selected = $_GET['selected']; 
                          }
                          
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
                            $brid = $rowp["id"];
  
                          print '<option value="'. $brid.'"';
                              if($brid == $selected)
                               { print ' selected= selected ';} 
  
                           print '>'. $branch.'</option>';
  
                           }
  
                            ?></select>

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

Commodity: <select name="Commodity" id="search_Commodity" style="width:15%;height:30px;" >;
                          <option value=""></option>';
                     <?php
                          $selected = ""; 
                          if(isset($_GET['selected'])){
                            $selected = $_GET['selected']; 
                          }
                           
                          
                          $queryb ="SELECT commodity.commodity,commodity.id FROM commodity";
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
  
                            ?></select>

Code: <select name="code" id="search_code" style="width:15%;height:30px;">
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
  
                            ?></select><br><br>

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
                      <th>Code</td>       
                      <th >Total Input</td>
                      <th>Transfer Out</th>
                      <th>Transfer In</th>
                      <th>Total WIP</td>
                      <th style="word-wrap:break-word;">Total Delivery</th>
                      <th style="word-wrap:break-word;">Total Return</th>
                      <th style="word-wrap:break-word;width: 15%;">Remark</th>
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
          brandname.brandname AS pbrand,
          commodity.commodity AS pCommodity,
          code.code as code_no,
          branch.branch AS branch_name,
          PoMst.BrandName,
          PoMst.Commodity,
          PoMst.Branch,
          PoMst.code,
          COUNT(*) AS Duplicate_Records,
          IFNULL(pQty,0) AS pQty,
          IFNULL(toutQty,0) AS toutQty,
          IFNULL(titQty,0) AS titQty,
          IFNULL(JWIP,0) AS wip,
          IFNULL(dQty,0) AS balanceDelivery,
          IFNULL(returnrQty,0) AS rQty,
          ddQty AS LastdQty,
          LastWIP AS LastWIP,
          returnrrQty AS returnrrQty,
          LasttoutQty AS LasttoutQty,
          pRate AS balancetotalUSD,
          rRate AS rRate,
          tRate AS tRate,
          pUSD AS proUSD,
          (CASE WHEN IFNULL(ddQty,0) < IFNULL(LastWIP,0) THEN ( (IFNULL(ANY_VALUE(pQty),0) -  IFNULL(LastWIP,0)) - IFNULL(LasttoutQty,0) ) +  IFNULL(returnrrQty, 0)   
               WHEN IFNULL(LastWIP,0) < IFNULL(ddQty,0) THEN ( (IFNULL(ANY_VALUE(pQty),0) -  IFNULL(ddQty,0)) - IFNULL(LasttoutQty,0) ) + IFNULL(returnrrQty, 0)   
               WHEN IFNULL(LastWIP,0) = IFNULL(ddQty,0) THEN ( (IFNULL(ANY_VALUE(pQty),0) -  IFNULL(LastWIP,0)) - IFNULL(LasttoutQty,0)) + IFNULL(returnrrQty, 0) 
               END) AS  balancecQty,
          ( ( (IFNULL(ANY_VALUE(pQty), 0) - IFNULL(ddQty, 0)) - IFNULL(LasttoutQty,0)) + IFNULL(returnrrQty, 0)  ) AS currentcQty,
          SUM(totalUSD) AS totalUSDs,IFNULL(pRemarks,'') AS pRemarks,IFNULL(jRemarks,'') AS jRemarks,IFNULL(dRemarks,'') AS dRemarks,
          IFNULL(rRemarks,'') AS rRemarks
          FROM 
          product PoMst
         JOIN brandname ON PoMst.BrandName = brandname.id 
         JOIN commodity ON PoMst.Commodity = commodity.id
         JOIN branch ON PoMst.Branch = branch.id
         JOIN code ON PoMst.code = code.id
         LEFT JOIN (SELECT BrandName AS pBrandName,Commodity AS pCommodity,Branch AS pBranch,code AS pcode,SUM(Qty) AS pQty,SUM(USD * Qty) AS pUSD,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS pRemarks
          FROM product USE INDEX (Branch,Packing_date,BrandName,Commodity,code) WHERE 1=1";
          

          if ($Branches <> 1) {
            $sqlA .=" AND product.Branch='$Branches'";
          }
           // to delete from transfer
        //  if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
        //      $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
        //      $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
        //        $sqlA .="  AND ( Packing_date BETWEEN '$fromDate' AND '$toDate' ) GROUP BY BrandName,Commodity,Branch) tblProd
        //   ON  PoMst.BrandName=tblProd.pBrandName
        //   AND PoMst.Commodity=tblProd.pCommodity
        //   AND PoMst.Branch=tblProd.pBranch
        //   LEFT JOIN (SELECT ANY_VALUE(Job_date) AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,SUM(WIP) as JWIP,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
        //    FROM job USE INDEX (Location,Job_date,BrandName,Commodity)";
              
        //  }else{
        //      $sqlA .=" GROUP BY BrandName,Commodity,Branch) tblProd
        //   ON  PoMst.BrandName=tblProd.pBrandName
        //   AND PoMst.Commodity=tblProd.pCommodity
        //   AND PoMst.Branch=tblProd.pBranch
        //   LEFT JOIN (SELECT ANY_VALUE(Job_date) AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,SUM(WIP) as JWIP,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
        //   FROM job USE INDEX (Location,Job_date,BrandName,Commodity) ";
        //  }

         //start for transfer
         if(!empty($_GET['startDate']) && !empty($_GET['endDate'])){
          $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
          $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
          
          $sqlA .="  AND ( Packing_date BETWEEN '$fromDate' AND '$toDate' ) GROUP BY BrandName,Commodity,Branch,code) tblProd
          ON  PoMst.BrandName=tblProd.pBrandName
          AND PoMst.Commodity=tblProd.pCommodity
          AND PoMst.code=tblProd.pcode
          AND PoMst.Branch=tblProd.pBranch
          LEFT JOIN (SELECT ANY_VALUE(transfer_date) AS transfer_date,BrandName AS tBrandName,Commodity AS tCommodity,code AS tcode,SUM(Qty) as toutQty,transfer_from AS transfer_from,GROUP_CONCAT(Remark_Item SEPARATOR '   ') AS tRemarks
           FROM transfer USE INDEX (transfer_from,transfer_date,BrandName,Commodity,code)";
         }else{
          $sqlA .=" GROUP BY BrandName,Commodity,Branch,code) tblProd
       ON  PoMst.BrandName=tblProd.pBrandName
       AND PoMst.Commodity=tblProd.pCommodity
       AND PoMst.code=tblProd.pcode
       AND PoMst.Branch=tblProd.pBranch
       LEFT JOIN (SELECT ANY_VALUE(transfer_date) AS transfer_date,BrandName AS tBrandName,Commodity AS tCommodity,code AS tcode,SUM(Qty) as toutQty,transfer_from AS transfer_from,GROUP_CONCAT(Remark_Item SEPARATOR '   ') AS tRemarks
       FROM transfer USE INDEX (transfer_from,transfer_date,BrandName,Commodity,code) ";
      }

      if ($Branches <> 1) {
        $sqlA .=" WHERE transfer.transfer_from='$Branches'";
      }

      if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {

        $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
        $toDate   =date("Y-m-d",strtotime($_GET['endDate']));

        if( $Branches <> 1){
           $sqlA .=" AND  transfer_date BETWEEN '$fromDate' AND '$toDate'  ";
        }else{
           $sqlA .=" WHERE  transfer_date BETWEEN '$fromDate' AND '$toDate' ";
        }
      
     $sqlA .=" GROUP BY Commodity,BrandName,transfer_from,code) tblTransfer
   ON  PoMst.BrandName=tblTransfer.tBrandName
   AND PoMst.Commodity=tblTransfer.tCommodity
   AND PoMst.code=tblTransfer.tcode
   AND PoMst.Branch=tblTransfer.transfer_from 
   LEFT JOIN (SELECT ANY_VALUE(t.transfer_date) AS tttransfer_date, t.BrandName AS ttBrandName,t.Commodity AS ttCommodity,t.code as ttcode,SUM(t.Qty) AS LasttoutQty,SUM(pt.USD * t.Qty) as tRate,t.transfer_from AS tttransfer_from
   FROM transfer t  LEFT JOIN product pt ON pt.Purchase_order_No = t.PL AND pt.BrandName = t.BrandName AND pt.Commodity = t.Commodity AND pt.Branch = t.transfer_from AND pt.code=t.code";
   

    }else{

      $sqlA .=" GROUP BY Commodity,BrandName,transfer_from,code) tblTransfer
   ON  PoMst.BrandName=tblTransfer.tBrandName
   AND PoMst.Commodity=tblTransfer.tCommodity
   AND PoMst.code=tblTransfer.tcode
   AND PoMst.Branch=tblTransfer.transfer_from 
   LEFT JOIN (SELECT ANY_VALUE(t.transfer_date) AS tttransfer_date, t.BrandName AS ttBrandName,t.Commodity AS ttCommodity,t.code AS ttcode,SUM(t.Qty) AS LasttoutQty,SUM(pt.USD * t.Qty) as tRate,t.transfer_from AS tttransfer_from
   FROM transfer t LEFT JOIN product pt ON pt.Purchase_order_No = t.PL AND pt.BrandName = t.BrandName AND pt.Commodity = t.Commodity AND pt.Branch = t.transfer_from AND pt.code=t.code";  

    }


    if ($Branches <> 1) {
      $sqlA .=" WHERE t.transfer_from='$Branches'";
    }
      // new
     if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
       $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
       $toDate   =date("Y-m-d",strtotime($_GET['endDate']));

       if( $Branches <> 1){
            $sqlA .=" AND t.transfer_date <= '$toDate' ";
         }else{
            $sqlA .=" WHERE  t.transfer_date <= '$toDate' ";
         }

         $sqlA .=" GROUP BY t.BrandName,t.Commodity,t.transfer_from,t.code) tbltransferLast
    ON  PoMst.BrandName=tbltransferLast.ttBrandName
    AND PoMst.Commodity=tbltransferLast.ttCommodity
    AND PoMst.code=tbltransferLast.ttcode
    AND PoMst.Branch=tbltransferLast.tttransfer_from
    LEFT JOIN (SELECT ANY_VALUE(transfer_date) AS titransfer_date,BrandName AS tiBrandName,Commodity AS tiCommodity,code AS ticode,SUM(Qty) as tiQty,transfer_to AS titransfer_to,GROUP_CONCAT(Remark_Item  SEPARATOR '   ') AS tiRemarks
    FROM transfer USE INDEX (transfer_to,transfer_date,BrandName,Commodity,code)";
    // LEFT JOIN (SELECT ANY_VALUE(Job_date) AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,SUM(WIP) as JWIP,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
    // FROM job USE INDEX (Location,Job_date,BrandName,Commodity)
        
   }else{
       $sqlA .=" GROUP BY  t.BrandName,t.Commodity,t.transfer_from,t.code) tbltransferLast
    ON  PoMst.BrandName=tbltransferLast.ttBrandName
    AND PoMst.Commodity=tbltransferLast.ttCommodity
    AND PoMst.code=tbltransferLast.ttcode
    AND PoMst.Branch=tbltransferLast.tttransfer_from
    LEFT JOIN (SELECT ANY_VALUE(transfer_date) AS titransfer_date,BrandName AS tiBrandName,Commodity AS tiCommodity,code AS ticode,SUM(Qty) as tiQty,transfer_to AS titransfer_to,GROUP_CONCAT(Remark_Item  SEPARATOR '   ') AS tiRemarks
    FROM transfer USE INDEX (transfer_to,transfer_date,BrandName,Commodity,code)";

   // LEFT JOIN (SELECT ANY_VALUE(Job_date) AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,SUM(WIP) as JWIP,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
   // FROM job USE INDEX (Location,Job_date,BrandName,Commodity)
   }

     //start transfer in 

     if ($Branches <> 1) {
      $sqlA .=" WHERE transfer.transfer_from='$Branches'";
    }

     if(!empty($_GET['startDate']) && !empty($_GET['endDate'])){
      $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
      $toDate   =date("Y-m-d",strtotime($_GET['endDate']));

    //   if( $Branches <> 1){
    //     $sqlA .=" AND transfer.transfer_date <= '$toDate' ";
    //  }else{
    //     $sqlA .=" WHERE  t.transfer_date <= '$toDate' ";
    //  }

    if( $Branches <> 1){
      $sqlA .=" AND  transfer.transfer_date BETWEEN '$fromDate' AND '$toDate'  ";
   }else{
      $sqlA .=" WHERE  transfer.transfer_date BETWEEN '$fromDate' AND '$toDate' ";
   }

      
      $sqlA .=" GROUP BY BrandName,Commodity,transfer_to,code) tbltransferin
      ON  PoMst.BrandName=tbltransferin.tiBrandName
      AND PoMst.Commodity=tbltransferin.tiCommodity
      AND PoMst.code=tbltransferin.ticode
      AND PoMst.Branch=tbltransferin.titransfer_to
      LEFT JOIN (SELECT ANY_VALUE(ti.transfer_date) AS tittransfer_date,ti.BrandName AS titBrandName,ti.Commodity AS titCommodity,ti.code AS titcode,SUM(Qty) as titQty,ti.transfer_to AS tittransfer_to,GROUP_CONCAT(Remark_Item SEPARATOR '   ') AS titRemarks
       FROM transfer ti USE INDEX (transfer_to,transfer_date,BrandName,Commodity,code)";
     }else{
      $sqlA .=" GROUP BY BrandName,Commodity,transfer_to,code) tbltransferin
      ON  PoMst.BrandName=tbltransferin.tiBrandName
      AND PoMst.Commodity=tbltransferin.tiCommodity
      AND PoMst.code=tbltransferin.ticode
      AND PoMst.Branch=tbltransferin.titransfer_to
      LEFT JOIN (SELECT ANY_VALUE(ti.transfer_date) AS tittransfer_date,ti.BrandName AS titBrandName,ti.Commodity AS titCommodity,ti.code AS titcode,SUM(Qty) as titQty,ti.transfer_to AS tittransfer_to,GROUP_CONCAT(Remark_Item SEPARATOR '   ') AS titRemarks
      FROM transfer ti USE INDEX (transfer_to,transfer_date,BrandName,Commodity,code) ";
     }

     if ($Branches <> 1) {
      $sqlA .=" WHERE ti.transfer_to='$Branches'";
    }
      // new
     if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
       $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
       $toDate   =date("Y-m-d",strtotime($_GET['endDate']));

       if( $Branches <> 1){
            $sqlA .=" AND ti.transfer_date <= '$toDate' ";
         }else{
            $sqlA .=" WHERE  ti.transfer_date <= '$toDate' ";
         }

         $sqlA .=" GROUP BY ti.BrandName,ti.Commodity,ti.transfer_to,ti.code) tbltransferinLast
    ON  PoMst.BrandName=tbltransferinLast.titBrandName
    AND PoMst.Commodity=tbltransferinLast.titCommodity
    AND PoMst.code=tbltransferinLast.titcode
    AND PoMst.Branch=tbltransferinLast.tittransfer_to    
     LEFT JOIN (SELECT ANY_VALUE(Job_date) AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,code AS jcode,SUM(WIP) as JWIP,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
     FROM job USE INDEX (Location,Job_date,BrandName,Commodity,code)";
        
   }else{
       $sqlA .=" GROUP BY  ti.BrandName,ti.Commodity,ti.transfer_to,ti.code) tbltransferinLast
    ON  PoMst.BrandName=tbltransferinLast.titBrandName
    AND PoMst.Commodity=tbltransferinLast.titCommodity
    AND PoMst.code=tbltransferinLast.titcode
    AND PoMst.Branch=tbltransferinLast.tittransfer_to
    LEFT JOIN (SELECT ANY_VALUE(Job_date) AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,code AS jcode,SUM(WIP) as JWIP,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
    FROM job USE INDEX (Location,Job_date,BrandName,Commodity,code)";
   }

      //end transfer in


         //end for transfer
             
          if ($Branches <> 1) {
            $sqlA .=" WHERE job.Location='$Branches'";
          }
           if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
               if( $Branches <> 1){
                  $sqlA .=" AND ( Job_date BETWEEN '$fromDate' AND '$toDate' ) ";
               }else{
                  $sqlA .=" WHERE  Job_date BETWEEN '$fromDate' AND '$toDate' ";
               }
              $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
              $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
            $sqlA .=" GROUP BY Commodity,BrandName,Location,code) tblJob
          ON  PoMst.BrandName=tblJob.jBrandName
          AND PoMst.Commodity=tblJob.jCommodity
          AND PoMst.code=tblJob.jcode
          AND PoMst.Branch=tblJob.jLocation   

          LEFT JOIN (SELECT ANY_VALUE(j.Job_date) AS jjJob_date, j.BrandName AS jjBrandName,j.Commodity AS jjCommodity,j.code AS jjcode,SUM(j.WIP) AS LastWIP,j.Location AS jjLocation
          FROM job j USE INDEX (Location,Job_date,BrandName,Commodity,code) ";

           }else{

             $sqlA .=" GROUP BY Commodity,BrandName,Location,code) tblJob
          ON  PoMst.BrandName=tblJob.jBrandName
          AND PoMst.Commodity=tblJob.jCommodity
          AND PoMst.code=tblJob.jcode
          AND PoMst.Branch=tblJob.jLocation   

          LEFT JOIN (SELECT ANY_VALUE(j.Job_date) AS jjJob_date, j.BrandName AS jjBrandName,j.Commodity AS jjCommodity,j.code AS jjcode,SUM(j.WIP) AS LastWIP,j.Location AS jjLocation
          FROM job j USE INDEX (Location,Job_date,BrandName,Commodity,code)";  

           }
           // new start
           if ($Branches <> 1) {
            $sqlA .=" WHERE j.Location='$Branches'";
          }
            // new
           if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
             $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
             $toDate   =date("Y-m-d",strtotime($_GET['endDate']));

             if( $Branches <> 1){
                  $sqlA .=" AND j.Job_date <= '$toDate' ";
               }else{
                  $sqlA .=" WHERE  j.Job_date <= '$toDate' ";
               }

               $sqlA .=" GROUP BY j.BrandName,j.Commodity,j.Location,j.code) tblJobLast
          ON  PoMst.BrandName=tblJobLast.jjBrandName
          AND PoMst.Commodity=tblJobLast.jjCommodity
          AND PoMst.code=tblJobLast.jjcode
          AND PoMst.Branch=tblJobLast.jjLocation
          LEFT JOIN (SELECT ANY_VALUE(Delivery_date) AS Delivery_date,BrandName AS dBrandName,Commodity AS dCommodity,code AS dcode,SUM(Qty) as dQty,Location AS dLocation,GROUP_CONCAT(Remark_Item  SEPARATOR '   ') AS dRemarks
           FROM delivery USE INDEX (Location,Delivery_date,BrandName,Commodity,code)";
              
         }else{
             $sqlA .=" GROUP BY  BrandName,Commodity,Location,code) tblJobLast
          ON  PoMst.BrandName=tblJobLast.jjBrandName
          AND PoMst.Commodity=tblJobLast.jjCommodity
          AND PoMst.code=tblJobLast.jjcode
          AND PoMst.Branch=tblJobLast.jjLocation
          LEFT JOIN (SELECT ANY_VALUE(Delivery_date) AS Delivery_date,BrandName AS dBrandName,Commodity AS dCommodity,code AS dcode,SUM(Qty) as dQty,Location AS dLocation,GROUP_CONCAT(Remark_Item  SEPARATOR '   ') AS dRemarks
          FROM delivery USE INDEX (Location,Delivery_date,BrandName,Commodity,code)";
         }
         // new
           // new end
           // new
           if ($Branches <> 1) {
            $sqlA .=" WHERE delivery.Location='$Branches'";
          }
           if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
              $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
              $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
              if( $Branches <> 1){
                  $sqlA .=" AND ( Delivery_date BETWEEN '$fromDate' AND '$toDate' ) ";
               }else{
                  $sqlA .=" WHERE Delivery_date BETWEEN '$fromDate' AND '$toDate' ";
               }
            $sqlA .=" GROUP BY Commodity,BrandName,Location,code) tblDeli
          ON  PoMst.BrandName=tblDeli.dBrandName
          AND PoMst.Commodity=tblDeli.dCommodity
          AND PoMst.code=tblDeli.dcode
          AND PoMst.Branch=tblDeli.dLocation
          LEFT JOIN (SELECT ANY_VALUE(d.Delivery_date) AS ddDelivery_date, d.BrandName AS ddBrandName,d.Commodity AS ddCommodity,d.code AS ddcode,SUM(d.Qty) AS ddQty,d.Location AS ddLocation,SUM(pd.USD * d.Qty) as pRate
          FROM delivery d  LEFT JOIN product pd ON pd.Purchase_order_No = d.PL AND pd.BrandName = d.BrandName AND pd.Commodity = d.Commodity AND pd.Branch = d.Location AND pd.code=d.code";

           }else{

             $sqlA .=" GROUP BY Commodity,BrandName,Location,code) tblDeli
          ON  PoMst.BrandName=tblDeli.dBrandName
          AND PoMst.Commodity=tblDeli.dCommodity          
          AND PoMst.code=tblDeli.dcode
          AND PoMst.Branch=tblDeli.dLocation
          LEFT JOIN (SELECT ANY_VALUE(d.Delivery_date) AS ddDelivery_date, d.BrandName AS ddBrandName,d.Commodity AS ddCommodity,d.code AS ddcode,SUM(d.Qty) AS ddQty,d.Location AS ddLocation,SUM(pd.USD * d.Qty) as pRate
          FROM delivery d  LEFT JOIN product pd ON pd.Purchase_order_No = d.PL AND pd.BrandName = d.BrandName AND pd.Commodity = d.Commodity AND pd.Branch = d.Location AND pd.code=d.code";

           }
           // new end
          
          if ($Branches <> 1) {
            $sqlA .=" WHERE d.Location='$Branches'";
          }

           if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
                 $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
                 $toDate   =date("Y-m-d",strtotime($_GET['endDate']));

                if( $Branches <> 1){
                  $sqlA .=" AND d.Delivery_date <= '$toDate' ";
               }else{
                  $sqlA .=" WHERE d.Delivery_date <= '$toDate' ";
               }
          
          $sqlA .=" GROUP BY d.Commodity,d.BrandName,d.Location,d.code) tblDeliLast 
          ON  PoMst.BrandName=tblDeliLast.ddBrandName
          AND PoMst.Commodity=tblDeliLast.ddCommodity
          AND PoMst.code=tblDeliLast.ddcode
          AND PoMst.Branch=tblDeliLast.ddLocation 
          LEFT JOIN (SELECT ANY_VALUE(Return_date) AS Return_date,Commodity AS rCommodity,BrandName AS rBrandName,code AS rcode,SUM(Qty) as returnrQty,department AS rDepartment
          ,GROUP_CONCAT(Remarks_item SEPARATOR ' ') AS rRemarks
          FROM returns USE INDEX (department,Return_date,BrandName,Commodity,code)"; 
           }else{

               $sqlA .=" GROUP BY d.Commodity,d.BrandName,d.Location,d.code) tblDeliLast 
          ON  PoMst.BrandName=tblDeliLast.ddBrandName
          AND PoMst.Commodity=tblDeliLast.ddCommodity
          AND PoMst.code=tblDeliLast.ddcode
          AND PoMst.Branch=tblDeliLast.ddLocation  

          LEFT JOIN (SELECT ANY_VALUE(Return_date) AS Return_date,Commodity AS rCommodity,BrandName AS rBrandName,code AS rcode,SUM(Qty) as returnrQty,department AS rDepartment,GROUP_CONCAT(Remarks_item SEPARATOR ' ') AS rRemarks
          FROM returns USE INDEX (department,Return_date,BrandName,Commodity,code)"; 

           }

           if ($Branches <> 1) {
            $sqlA .=" WHERE returns.department='$Branches'";
          }
          if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {

              $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
              $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
              if( $Branches <> 1){
                  $sqlA .=" AND ( Return_date BETWEEN '$fromDate' AND '$toDate' ) ";
               }else{
                  $sqlA .=" WHERE Return_date BETWEEN '$fromDate' AND '$toDate' ";
               }
          $sqlA .="GROUP BY Commodity,BrandName,department,code) tblRet 
          ON  PoMst.BrandName=tblRet.rBrandName
          AND PoMst.Commodity=tblRet.rCommodity
          AND PoMst.code=tblRet.rcode
          AND PoMst.Branch=tblRet.rDepartment 
          LEFT JOIN (SELECT ANY_VALUE(r.Return_date) AS rrReturn_date,r.Commodity AS rrCommodity,r.BrandName AS rrBrandName,r.code AS rrcode,SUM(r.Qty) AS returnrrQty,r.department AS rrDepartment,SUM(pr.USD * r.Qty) as rRate FROM returns r 
          LEFT JOIN product pr ON pr.Purchase_order_No = r.PL AND pr.BrandName = r.BrandName AND pr.Commodity = r.Commodity AND pr.Branch = r.department AND pr.code=r.code";
        }else{

           $sqlA .="GROUP BY Commodity,BrandName,department,code) tblRet 
          ON  PoMst.BrandName=tblRet.rBrandName
          AND PoMst.Commodity=tblRet.rCommodity
          AND PoMst.code=tblRet.rcode
          AND PoMst.Branch=tblRet.rDepartment 
          LEFT JOIN (SELECT ANY_VALUE(r.Return_date) AS rrReturn_date,r.Commodity AS rrCommodity,r.BrandName AS rrBrandName,r.code AS rrcode,SUM(r.Qty) AS returnrrQty,r.department AS rrDepartment,SUM(pr.USD * r.Qty) as rRate FROM returns r 
          LEFT JOIN product pr ON pr.Purchase_order_No = r.PL AND pr.BrandName = r.BrandName AND pr.Commodity = r.Commodity AND pr.Branch = r.department AND pr.code=r.code";
        }
          
          if ($Branches <> 1) {
            $sqlA .=" WHERE r.department='$Branches'";
          }
          // end

       if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
              $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
              $toDate   =date("Y-m-d",strtotime($_GET['endDate']));

              if( $Branches <> 1){
                  $sqlA .=" AND r.Return_date <= '$toDate' ";
               }else{
                  $sqlA .=" WHERE r.Return_date <= '$toDate' ";
               }

          $sqlA .=" GROUP BY r.Commodity,r.BrandName,r.department,r.code) tblRetLast 
          ON  PoMst.BrandName=tblRetLast.rrBrandName
          AND PoMst.Commodity=tblRetLast.rrCommodity
          AND PoMst.code=tblRetLast.rrcode
          AND PoMst.Branch=tblRetLast.rrDepartment  
          WHERE 1=1 ";
        }else{
           $sqlA .=" GROUP BY r.Commodity,r.BrandName,r.department,r.code) tblRetLast 
          ON  PoMst.BrandName=tblRetLast.rrBrandName
          AND PoMst.Commodity=tblRetLast.rrCommodity
          AND PoMst.code=tblRetLast.rrcode
          AND PoMst.Branch=tblRetLast.rrDepartment  
          WHERE 1=1 ";
        }

        // if ($Branches <> 'All') {
        //     $sqlA .=" AND PoMst.Branch='$Branches'";
        //   }
          
          if($Branches <> 1){
            $sqlA .=" AND PoMst.Branch='$Branches'";
          }
          
       if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])){
           $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
           $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
           $sqlA =$sqlA." AND (Packing_date BETWEEN '$fromDate' AND '$toDate' OR  return_date BETWEEN '$fromDate' AND '$toDate' OR Job_date BETWEEN '$fromDate' AND '$toDate' OR Delivery_date BETWEEN '$fromDate' AND '$toDate' OR Return_date BETWEEN '$fromDate' AND '$toDate')";
       } 
         //  if (isset($_GET['keyword'])) {
         //   $keyword = $_GET['keyword'];
         //   $sqlA =$sqlA." AND (BrandName LIKE '%$keyword%' OR Commodity LIKE '%$keyword%' OR branch LIKE '%$keyword%')";
         // }
          
        //  if (!empty($_GET['keyword'])) {
        //    $keyword = $_GET['keyword'];
        //    $sqlA =$sqlA." AND ( brandname.brandname = '$keyword' OR commodity.commodity = '$keyword' OR branch = '$keyword' )";
        //  } 

         // start for search
         if(isset($_GET['search_branch'])  && $_GET['search_branch'] != ''){
          $search_branch=$_GET['search_branch'];
          $sqlA =$sqlA." AND PoMst.Branch='$search_branch'";
        }

        if(isset($_GET['search_BrandName']) && $_GET['search_BrandName'] != ''){
          $BrandName=$_GET['search_BrandName'];
          $sqlA =$sqlA." AND PoMst.BrandName='$BrandName'";
        }

        if(isset($_GET['search_Commodity']) && $_GET['search_Commodity'] != ''){
          $commodity=$_GET['search_Commodity'];
          $sqlA =$sqlA." AND PoMst.Commodity='$commodity'";
        }
        if(isset($_GET['search_code']) && $_GET['search_code'] != ''){
          $code=$_GET['search_code'];
          $sqlA =$sqlA." AND PoMst.code='$code'";
        }

         // end for each
          $sqlA = $sqlA. " GROUP BY
          PoMst.BrandName,
          PoMst.Commodity,
          PoMst.code,
          code.code,
          Branch
          HAVING
          COUNT(*) >= 1
          ORDER BY
          brandname.brandname         
          ";
          
             
          $sqlFooter ="
          ) Tbl
          ) tbl1
          WHERE
          1 = 1 ORDER BY
          num ASC";
          
          
         // $sqllimit=" LIMIT 30";

         

          $iDataCnt = 0;
           // $sSQLQuery= " SELECT COUNT(*) AS CntRow FROM ( " . $sqlA . " ) Tbl";
         
           //    $result=mysqli_query($con transfer.transfer_to, $sSQLQuery);
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
         //  $namelist =$_GET['namelist']; 
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

    <script src="../js/select2.min.js" type="text/javascript"></script>
        <script>


  $("#search_branch").select2( {
  placeholder: "Select Branch",
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

 
  </script>