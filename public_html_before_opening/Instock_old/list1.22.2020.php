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
        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
              //  var string = $('#keywords').val(); 
     /// var newstring = string.replace(/[&\/\\#,+()$~%.':*?<>{}]/g,"\\$&");
          //string = window.encodeURIComponent(newstring);
          window.location.href = "list.php?startDate="+startDate+"&endDate="+endDate+"&namelist="+keywords;
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
      return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
    }
    var trident = ua.indexOf("Trident/");
    if (trident > 0) {
      var rv = ua.indexOf("rv:");
      return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
    }
    var edge = ua.indexOf("Edge/");
    if (edge > 0) {
      return parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10);
    }
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
      if ("download" in anchor) {
        anchor.download = this._filename + "." + ext;
      }
      anchor.href = content;
      anchor.click();
      anchor.remove();
    },
    _tableToCSV: function(table) {
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
        var min_length = 1; 
        var keyword = $('#keywords').val();
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
</head>
<body style="font-size: 10px; font-family:Tahoma, Geneva, sans-serif;"> 
    <div class="row">
    <div class="col-sm-12">
     <form class="form-horizontal" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data" >
  <input type="text" id="keywords" name="keyword" style="margin-left: 7px;width: 15%;margin-top:1%;" onKeyUp="searching()" placeholder="search..." /><span id="searching-box"></span>

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
                      <th >Input</td>
                      <th >WIP</td>
                      <th style="word-wrap:break-word;">Delivery</th>
                      <th style="word-wrap:break-word;">Return</th>
                      <th style="word-wrap:break-word;width: 30%;">Remark</th>
                      <th style="word-wrap:break-word;">Total Stock</th>
                      <th style="word-wrap:break-word;">Current Stock</th>

                      <!-- <th style="word-wrap:break-word;">PL</th> -->
                      <?php 
                      $Authority = $_SESSION['authority'];
                      if ($Authority == 'Accountant') {               
                        print'
                        <th style="word-wrap:break-word;">Total USD</th>';
                        print'
                        <th style="word-wrap:break-word;">Net USD</th>';
                        print'
                        <th style="word-wrap:break-word;">Balance USD</th>';
                      }?>

                    </tr>      
                    <?php
                    $Branches = $_SESSION['Branch'];
                    $con->query("SET GLOBAL group_concat_max_len = 1000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000");

         /*  if ($Branches == 'Shwe Pyi Thar Store') {
           $sqlA="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,COUNT(*) AS Duplicate_Records,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,   
           

           (SELECT SUM(pp.balanceReturn) 
           FROM product as pp  WHERE product.Commodity =pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch )  as rQty,                       

 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '    ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '    ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,    

           (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '    ') AS dddd
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,             

           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '    ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,  


           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty,  
           
           (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty,                  

           (SELECT SUM(s.totalUSD) 
           FROM product as s  WHERE product.Commodity = s.Commodity and product.BrandName = s.BrandName and product.Branch = s.Branch  )  as totalUSDs,

           (SELECT SUM(p.balanceUSD)            
           FROM product as p  WHERE product.Commodity = p.Commodity and product.BrandName = p.BrandName and product.Branch = p.Branch  )  as balancetotalUSD


            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No  
            
            Where product.Branch='Shwe Pyi Thar Store'";
}

          elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {
           $sqlA="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,COUNT(*) AS Duplicate_Records,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,   

           (SELECT SUM(pp.balanceReturn) 
           FROM product as pp  WHERE product.Commodity =pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch )  as rQty,                        

 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '    ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '    ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,    

           (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '    ') AS dddd
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,  


           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '    ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,  


           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty,        

           (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty,       
           
           (SELECT SUM(s.totalUSD) 
           FROM product as s  WHERE product.Commodity = s.Commodity and product.BrandName = s.BrandName and product.Branch = s.Branch  )  as totalUSDs,

           (SELECT SUM(p.balanceUSD)            
           FROM product as p  WHERE product.Commodity = p.Commodity and product.BrandName = p.BrandName and product.Branch = p.Branch  )  as balancetotalUSD


            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No  
            
            Where product.Branch='Shwe Pyi Thar Store Control Panel'";
      
}   

          elseif ($Branches == 'Yangon Show Room') {
           $sqlA="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,COUNT(*) AS Duplicate_Records,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,   
           
 
           (SELECT SUM(pp.balanceReturn) 
           FROM product as pp  WHERE product.Commodity =pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch )  as rQty,                         

 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '    ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '    ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,   

           (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '    ') AS dddd
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,              

           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '    ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,  


           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty,   
           
           (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty,       
           
           (SELECT SUM(s.totalUSD) 
           FROM product as s  WHERE product.Commodity = s.Commodity and product.BrandName = s.BrandName and product.Branch = s.Branch  )  as totalUSDs,

           (SELECT SUM(p.balanceUSD)            
           FROM product as p  WHERE product.Commodity = p.Commodity and product.BrandName = p.BrandName and product.Branch = p.Branch  )  as balancetotalUSD


            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No   
            

            Where product.Branch='Yangon Show Room'";
      
 }

          elseif ($Branches == 'Naypyidaw Show Room') {
           $sqlA="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,COUNT(*) AS Duplicate_Records,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,   
           

           (SELECT SUM(pp.balanceReturn) 
           FROM product as pp  WHERE product.Commodity =pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch )  as rQty, 
           
 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '    ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '    ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,    

           (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '    ') AS dddd
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,  

           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '    ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,  


           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty,        
           
           (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty,                  

           (SELECT SUM(s.totalUSD) 
           FROM product as s  WHERE product.Commodity = s.Commodity and product.BrandName = s.BrandName and product.Branch = s.Branch  )  as totalUSDs,

           (SELECT SUM(p.balanceUSD)            
           FROM product as p  WHERE product.Commodity = p.Commodity and product.BrandName = p.BrandName and product.Branch = p.Branch  )  as balancetotalUSD


            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No  
            
            Where product.Branch='Naypyidaw Show Room'";
}
          elseif ($Branches == 'Mandalay Show Room') {
           $sqlA="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,COUNT(*) AS Duplicate_Records,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,   

           (SELECT SUM(pp.balanceReturn) 
           FROM product as pp  WHERE product.Commodity =pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch )  as rQty,                        

 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '    ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '    ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,   

           (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '    ') AS dddd
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,             

           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '    ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,  


           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty,     
           
           (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty,       
           
           (SELECT SUM(s.totalUSD) 
           FROM product as s  WHERE product.Commodity = s.Commodity and product.BrandName = s.BrandName and product.Branch = s.Branch  )  as totalUSDs,

           (SELECT SUM(p.balanceUSD)            
           FROM product as p  WHERE product.Commodity = p.Commodity and product.BrandName = p.BrandName and product.Branch = p.Branch  )  as balancetotalUSD


            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No  
            and returns.DO_No = delivery.DO_No  
            

            Where product.Branch='Mandalay Show Room'";
}

else{
           $sqlA="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,COUNT(*) AS Duplicate_Records,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,                      


           (SELECT SUM(pp.balanceReturn) 
           FROM product as pp  WHERE product.Commodity =pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch )  as rQty,  

 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '   ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '   ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,    

           (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '   ') AS dddd
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,  

           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '   ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,                      


           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty,    
           
           (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty,              

           (SELECT SUM(s.totalUSD) 
           FROM product as s  WHERE product.Commodity = s.Commodity and product.BrandName = s.BrandName and product.Branch = s.Branch  )  as totalUSDs,

           (SELECT SUM(p.balanceUSD)            
           FROM product as p  WHERE product.Commodity = p.Commodity and product.BrandName = p.BrandName and product.Branch = p.Branch  )  as balancetotalUSD


            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No  
            
            Where 1=1";
            
          }   */

         if(!empty($_GET['keyword'])){
                 $keyword = $_GET['keyword'];
            }else{
                $keyword = '';
            }
          
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
          Packing_date AS Packing_date,                        
          Branch AS Branch,
          BrandName AS pbrand,
          Commodity AS pCommodity,
          COUNT(*) AS Duplicate_Records,
          SUM(InputQty) AS pQty,
          SUM(JWIP) AS wip,
          SUM(dQty)AS balanceDelivery,
          SUM(returnQty) AS rQty,
          SUM(balanceQty) AS balanceQty,
          SUM(currentQty) AS currentQty,
          SUM(totalUSD) AS totalUSDs,
          SUM(balanceUSD) AS balancetotalUSD,
          IFNULL(pRemarks,'') AS pRemarks,IFNULL(jRemarks,'') AS jRemarks,IFNULL(dRemarks,'') AS dRemarks,IFNULL(rRemarks,'') AS rRemarks
          FROM 
          product PoMst  
          LEFT JOIN (SELECT BrandName AS pBrandName,Commodity AS pCommodity,qty as InputQty,Branch AS pBranch,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS pRemarks
          FROM product";
          

      // }  

          // $sqlA="         
          // SELECT
          // Packing_date AS 5,
          // Branch AS Branch,
          // BrandName AS pbrand,
          // Commodity AS pCommodity,
          // COUNT(*) AS Duplicate_Records,
          // SUM(Qty) AS pQty,
          // SUM(balanceWIP) AS wip,
          // SUM(balanceDelivery)AS balanceDelivery,
          // SUM(balanceReturn) AS rQty,
          // SUM(balanceQty) AS balanceQty,
          // SUM(currentQty) AS currentQty,
          // SUM(totalUSD) AS totalUSDs,
          // SUM(balanceUSD) AS balancetotalUSD,
          // IFNULL(pRemarks,'') AS pRemarks,IFNULL(jRemarks,'') AS jRemarks,IFNULL(dRemarks,'') AS dRemarks,IFNULL(rRemarks,'') AS rRemarks
          // FROM
          // product PoMst
          // LEFT JOIN (SELECT BrandName AS pBrandName,Commodity AS pCommodity,Branch AS pBranch,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS pRemarks
          // FROM product ";
          if ($Branches <> 'All') {
            $sqlA .=" WHERE product.Branch='$Branches'";
          }

         if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
             $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
             $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
               $sqlA .=" WHERE Packing_date BETWEEN '$fromDate' AND '$toDate' GROUP BY BrandName,Commodity,Branch) tblProd
          ON  PoMst.BrandName=tblProd.pBrandName
          AND PoMst.Commodity=tblProd.pCommodity
          AND PoMst.Branch=tblProd.pBranch
          LEFT JOIN (SELECT Job_date AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,SUM(WIP) as JWIP,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
           FROM job";              
         }else{
             $sqlA .=" GROUP BY  BrandName,Commodity,Branch) tblProd
          ON  PoMst.BrandName=tblProd.pBrandName
          AND PoMst.Commodity=tblProd.pCommodity
          AND PoMst.Branch=tblProd.pBranch
          LEFT JOIN (SELECT Job_date AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,SUM(WIP) as JWIP,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
          FROM job";
         }

              
         //$sSubWhere = "";
          // $sqlA .=" GROUP BY  BrandName,Commodity,Branch) tblProd
          // ON  PoMst.BrandName=tblProd.pBrandName
          // AND PoMst.Commodity=tblProd.pCommodity
          // AND PoMst.Branch=tblProd.pBranch
          // LEFT JOIN (SELECT Job_date AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
          // FROM job"; 
          if ($Branches <> 'All') {
            $sqlA .=" WHERE job.Location='$Branches'";
          }
         //  if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])){
         //   $fromDate =date("Y-m-d",strtotime($_GET['startDate']));         
         //   $toDate   =date("Y-m-d",strtotime($_GET['endDate']));        
         //   $sqlA .=" AND Job_date BETWEEN '$fromDate' AND '$toDate'";
         // }
           if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
              $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
              $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
            $sqlA .=" WHERE Job_date BETWEEN '$fromDate' AND '$toDate' GROUP BY Commodity,BrandName,Location) tblJob
          ON  PoMst.BrandName=tblJob.jBrandName
          AND PoMst.Commodity=tblJob.jCommodity
          AND PoMst.Branch=tblJob.jLocation   

          LEFT JOIN (SELECT Delivery_date AS Delivery_date, BrandName AS dBrandName,Commodity AS dCommodity,Qty AS dQty,Location AS dLocation,GROUP_CONCAT(Remark_item  SEPARATOR '   ') AS dRemarks
          FROM delivery";

           }else{

             $sqlA .=" GROUP BY Commodity,BrandName,Location) tblJob
          ON  PoMst.BrandName=tblJob.jBrandName
          AND PoMst.Commodity=tblJob.jCommodity
          AND PoMst.Branch=tblJob.jLocation   

          LEFT JOIN (SELECT Delivery_date AS Delivery_date, BrandName AS dBrandName,Commodity AS dCommodity,Qty AS dQty,Location AS dLocation,GROUP_CONCAT(Remark_item  SEPARATOR '   ') AS dRemarks
          FROM delivery";
           }
          if ($Branches <> 'All') {
            $sqlA .=" WHERE delivery.Location='$Branches'";
          }
           if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
                 $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
                 $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
                $sqlA .=" WHERE Delivery_date BETWEEN '$fromDate' AND '$toDate' GROUP BY Commodity,BrandName,Location ) tblDeli 
          ON  PoMst.BrandName=tblDeli.dBrandName
          AND PoMst.Commodity=tblDeli.dCommodity
          AND PoMst.Branch=tblDeli.dLocation 
          LEFT JOIN (SELECT Return_date AS Return_date,Commodity AS rCommodity,BrandName AS rBrandName,Qty as returnQty,department AS rDepartment,GROUP_CONCAT(Remarks_item  SEPARATOR '   ') AS rRemarks
          FROM returns"; 
           }else{
               $sqlA .=" GROUP BY Commodity,BrandName,Location) tblDeli 
          ON  PoMst.BrandName=tblDeli.dBrandName
          AND PoMst.Commodity=tblDeli.dCommodity
          AND PoMst.Branch=tblDeli.dLocation  

          LEFT JOIN (SELECT Return_date AS Return_date,Commodity AS rCommodity,BrandName AS rBrandName,Qty as returnQty,department AS rDepartment,GROUP_CONCAT(Remarks_item  SEPARATOR '   ') AS rRemarks
          FROM returns"; 

           }
           // if (!empty($_GET['startDate']) && !empty($_GET['endDate'])){         
           //  $startDate = date("Y-m-d",strtotime($_GET['startDate']));         
           //  $endDate = date("Y-m-d", strtotime($_GET['endDate']));         
           //  $sqlA .=" AND Return_date BETWEEN '$startDate'  AND '$endDate'";
           // } 

          // $sqlA .=" GROUP BY Commodity,BrandName,Location) tblDeli 
          // ON  PoMst.BrandName=tblDeli.dBrandName
          // AND PoMst.Commodity=tblDeli.dCommodity
          // AND PoMst.Branch=tblDeli.dLocation  

          // LEFT JOIN (SELECT Return_date AS Return_date,Commodity AS rCommodity,BrandName AS rBrandName,department AS rDepartment,GROUP_CONCAT(Remarks_item  SEPARATOR '   ') AS rRemarks
          // FROM returns";  
          if ($Branches <> 'All') {
            $sqlA .=" WHERE returns.department='$Branches'";
          }
           //   if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])){
           //   $fromDate =date("Y-m-d",strtotime($_GET['startDate']));         
           //   $toDate   =date("Y-m-d",strtotime($_GET['endDate']));        
           //   $sqlA .=" AND Packing_date BETWEEN '$fromDate' AND '$toDate'";
           // }

          // if (isset($_GET['startDate']) && isset($_GET['endDate'])){ 
          //   $startDate = date("Y-m-d",strtotime($_GET['startDate']));
          //   $endDate = date("Y-m-d", strtotime($_GET['endDate'])); 
          //    $sqlA .="WHERE returns.Return_date >='$startDate'  AND returns.Return_date <='$endDate'";
          // } 

       if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])) {
              $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
              $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
          $sqlA .=" WHERE Return_date BETWEEN '$fromDate' AND '$toDate' GROUP BY Commodity,BrandName,department) tblRet 
          ON  PoMst.BrandName=tblRet.rCommodity
          AND PoMst.Commodity=tblRet.rBrandName
          AND PoMst.Branch=tblRet.rDepartment  
          WHERE 1=1 ";
        }else{
           $sqlA .=" GROUP BY Commodity,BrandName,department) tblRet 
          ON  PoMst.BrandName=tblRet.rCommodity
          AND PoMst.Commodity=tblRet.rBrandName
          AND PoMst.Branch=tblRet.rDepartment  
          WHERE 1=1 ";
        }
          if ($Branches <> 'All') {
            $sqlA .=" AND Branch='$Branches'";
          } 

        //   if (isset($_GET['startDate'])  ){
        //    $fromDate   =date("Y-m-d",strtotime($_GET['startDate']));
        //    $sqlA =$sqlA." AND (Packing_date >= '$fromDate')";
        // }
        // if (isset($_GET['endDate']) ){
        //    $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
        //   $sqlA =$sqlA." AND (Packing_date <= '$toDate')";
        // } 
       // if(!empty($_GET['startDate'])  && !empty($_GET['endDate'])){
       //     $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
       //     $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
       //     $sqlA =$sqlA." AND Packing_date BETWEEN '$fromDate' AND '$toDate'";
       // } 
          if (isset($_GET['keyword'])) {
           $keyword = $_GET['keyword'];
           //$sqlA =$sqlA." AND (product.BrandName LIKE '%$keyword%'OR product.Commodity LIKE '%$keyword%'OR product.branch LIKE '%$keyword%')";
           $sqlA =$sqlA." AND (BrandName LIKE '%$keyword%' OR Commodity LIKE '%$keyword%'OR branch LIKE '%$keyword%')";
         } 
         if ($_GET['namelist'] <> ''){
            //$sqlA =$sqlA." AND  (product.BrandName= '".$_GET['namelist']."'OR product.Commodity= '".$_GET['namelist']."'OR product.branch= '".$_GET['namelist']."')";
          $sqlA =$sqlA." AND  (BrandName= '".$_GET['namelist']."'OR Commodity= '".$_GET['namelist']."'OR branch= '".$_GET['namelist']."')";
        }
           
         /* $sqlA = $sqlA. "
          GROUP BY product.BrandName,product.Commodity,product.Branch
          HAVING COUNT(*) >= 1 Order by product.BrandName";   */
          $sqlA = $sqlA. " GROUP BY
          BrandName,
          Commodity,
          Branch
          HAVING
          COUNT(*) >= 1
          ORDER BY
          BrandName         
          ";
          
        
          
          $sqlFooter ="
          ) Tbl
          ) tbl1
          WHERE
          1 = 1 ORDER BY
          num ASC
          LIMIT 30";

          $iDataCnt = 0;
          $sSQLQuery= " SELECT COUNT(*) AS CntRow FROM ( " . $sqlA . " ) Tbl";

          $result=mysqli_query($con , $sSQLQuery);
        //  echo $sSQLQuery;
          while($row = mysqli_fetch_array($result)){
            $iDataCnt = $row['CntRow'];
          }

          $sSQLQuery= $sqlHeader . $sqlA .  $sqlFooter;    
          $result=mysqli_query($con , $sSQLQuery); 
         //echo $sSQLQuery;
          $namelist =$_GET['namelist']; 
          $keyword = ""; 
          $_SESSION["InStock_LoadMoreQuery"] = $sSQLQuery;    
          $_SESSION["InStock_DataCnt"] = $iDataCnt; 
          $_SESSION["InStock_namelist"] =$_GET['namelist']; 
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
         
           print ' </table>'; 
           ?>  
           <div class="ajax-load" style="display:none;text-align:center;">
            <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More...</p>
          </div>

        </div>
      </div>

    </body>
    </html>


