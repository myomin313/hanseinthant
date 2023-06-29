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

 <style type="text/css">
        table {
        border-collapse: collapse;
        width: 500px;
      }
</style>
<!doctype html>
<html>
<head>

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

       var string = items; 
       var newstring = string.replace(/[&\/\\#,+()$~%.':*?<>{}]/g,"\\$&")       

        $('#namelist').hide();
         
        $('#searching-box').hide();
          window.location.href = 'list.php?namelist='+newstring+'&month=&day=';

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
      });
    </script>    

 </head>
 <body style="font-size: 10px; font-family:Tahoma, Geneva, sans-serif;">
 

      <input type="text" id="keywords" style="margin-left: 7px;width: 15%;margin-top:1%;" onKeyUp="searching()" placeholder="search..." /><span id="searching-box"></span>

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

           if ($Branches == 'Shwe Pyi Thar Store') {
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
            
          }           
          
          if (isset($_POST['keyword'])) {
           $keyword = $_POST['keyword']; 
           $sqlA =$sqlA." AND (product.BrandName LIKE '%$keyword%'OR product.Commodity LIKE '%$keyword%'OR product.branch LIKE '%$keyword%')";

           }  
                        
           if ($_GET['namelist'] <> ''){
            $sqlA =$sqlA." AND  (product.BrandName= '".$_GET['namelist']."'OR product.Commodity= '".$_GET['namelist']."'OR product.branch= '".$_GET['namelist']."')";
                                
             }                    
             
          $sqlA = $sqlA. "
          GROUP BY product.BrandName,product.Commodity,product.Branch
          HAVING COUNT(*) >= 1 Order by product.BrandName";   
        
       
         $result=mysqli_query($con ,$sqlA); 
          $sno = 1;
          
          
          $TotalUSD = 0; 
          $TotalBalance = 0;
          $minus = 0; 
          $balanceUSD = 0;
          $balancequantity = 0;
          $wip = 0;
          $balanceDelivery = 0;
          $balanceQty = 0;
          $balanceQtys = 0;
          $currentQty = 0;
          $currentQtys = 0;          
          $balancetotalUSD = 0;
             while($row = mysqli_fetch_array($result)){
  
              print '<tr>';
              print '<td  >' . $sno . '</td>'; 
              print '<td  >' . $row['Branch'] . '</td>'; 
              print '<td  >' . $row['pbrand'] . '</td>';  
              print '<td  >' . $row['pCommodity'] . '</td>';  
              print '<td  >' . $row['pQty'] . '</td>';

              $p=$row['pQty'];
              $wip=$row['wip'];
              $balanceDelivery=$row['balanceDelivery'];
              $balanceQty=$row['balanceQty'];
              $currentQty=$row['currentQty'];

              $r=$row['rQty'];

              echo '<td >'.$wip.'</td>';
  
              print '<td >' . $balanceDelivery . '</td>';
              print '<td >' . $r . '</td>';
              echo '<td style="">'.$row['pRemarks'].''.$row['jRemarks'].''.$row['dRemarks'].''.$row['rRemarks'].'</td>';
              echo '<td style="">'.$balanceQty.'</td>';
              $balanceQtys +=  $balanceQty;
              echo '<td style="">'.$currentQty.'</td>';
              $currentQtys +=  $currentQty;

              if ($Authority == 'Accountant') {          
              print '<td  style="width:7%;" >' . $row['totalUSDs'] . '&nbsp&nbsp$</td>';
              $TotalUSD +=  $row['totalUSDs'];
              print '<td >' . $row['balancetotalUSD'] . '&nbsp&nbsp$</td>';
              $TotalBalance +=  $row['balancetotalUSD'];

              $balance = $row['totalUSDs'] - $row['balancetotalUSD']  ;  
              $minus +=  $balance; 
              print '<td  >' . $balance . '&nbsp&nbsp$</td>';

              }

              print '</tr>';
              $sno ++;

            }  
            print '<tr>';
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


          if (isset($_POST['keyword'])) {
           $keyword = $_POST['keyword']; 
           $sqls =$sqls." AND  product.BrandName LIKE '%$keyword%'OR product.Commodity LIKE '%$keyword%'OR product.branch LIKE '%$keyword%'";

           }  
                        
           if ($_GET['namelist'] <> ''){
            $sqls =$sqls." AND  product.BrandName= '".$_GET['namelist']."'OR product.Commodity= '".$_GET['namelist']."'OR product.branch= '".$_GET['namelist']."'";
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

            print '</tr>'; 
            print ' </table>'; 


        ?>  

</div>
</div>

</body>
</html>


