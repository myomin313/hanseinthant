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

?> 
<?php
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];      
?>
<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
            $('#jobSearch').on('click', function(){
            var search_Job_No=$("#search_Job_No").val();
            var search_branch=$("#search_branch").val();
            var search_CustomerName=$("#search_CustomerName").val();
            var search_code=$("#search_code").val();
            var search_BrandName=$("#search_BrandName").val();
            var search_Commodity=$("#search_Commodity").val();
            //var search_PL=$("#search_PL").val();
            
            var search_PL=$("#search_PL").val();
            var newstring = search_PL.replace(/[&\/\\#,+()$~%.':*?<>{}]/g,"\\$&");
            search_PL = window.encodeURIComponent(newstring);
           
            var fromDate = $('#fromDate').val();
            var toDate = $('#toDate').val();

            //   var string = $('#keywords').val(); 
            // var newstring = string.replace(/[&\/\\#,+()$~%.':*?<>{}]/g,"\\$&");
            //  string = window.encodeURIComponent(newstring);
            //alert(string);
            // window.location.href= "list.php?fromDate="+fromDate+"&toDate="+toDate+"&namelist="+string;
            window.location.href= "list.php?fromDate="+fromDate+"&toDate="+toDate+"&search_Job_No="+search_Job_No
            +"&search_branch="+search_branch+"&search_CustomerName="+search_CustomerName+"&search_code="+search_code+"&search_BrandName="+search_BrandName+"&search_Commodity="+
            search_Commodity+"&search_PL="+search_PL;

              // window.location.href= "list.php?fromDate="+fromDate+"&toDate="+toDate+"&namelist="+string;
            });
          });
        </script>
  <!-- develop by winsan -->
</head>
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
            url: '../Job/autofill.php?' ,
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
    <div class="col-md-12" style="margin-top:1%;">
     <div class="row">
          <div class="col-sm-12">
               <form class="form-horizontal" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data" >
           
               Job NO: <select name="Job_No" id="search_Job_No" style="width:15%;height:30px;">;
                          <option value=""></option>';
                     <?php
                          $selected = ""; 
                          if(isset($_GET['selected'])){
                            $selected = $_GET['selected']; 
                          }
                        
                          $querypur ="SELECT DISTINCT Job_No FROM job ORDER BY Job_No";
                          $restc = $con->query($querypur);
                            while ($rowp=mysqli_fetch_array($restc)) {
                             $rowp['Job_No'] = rtrim($rowp['Job_No'],",");
                            $Job_No = $rowp["Job_No"];
  
                          print '<option value="'. $Job_No.'"';
                              if($Job_No == $selected)
                               { print ' selected= selected ';} 
  
                           print '>'. $Job_No.'</option>';
  
                           }
  
                            ?></select>

   Branch: <select name="Branch" id="search_branch" style="width:15%;height:30px;">
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
                            $brid = $rowp["id"];
                          print '<option value="'. $brid.'"';
                              if($brid == $selected)
                               { print ' selected= selected ';} 
  
                           print '>'. $branch.'</option>';
  
                           }
  
                            ?></select>

Customer: <select name="CustomerName" id="search_CustomerName" style="width:15%;height:30px;">
                          <option value =""></option>';
                     <?php
                          $selected = ""; 
                          if(isset($_GET['selected'])){
                            $selected = $_GET['selected']; 
                          }
                                                         
                           $sqlp="SELECT * FROM customer ORDER BY CustomerName";
                          
                            $resResultp = $con->query($sqlp);
                            while ($rowp=mysqli_fetch_array($resResultp)) {
                             $rowp['CustomerName'] = rtrim($rowp['CustomerName'],",");
                            $CustomerName = $rowp["CustomerName"];
                            $cid = $rowp["UserId"];
  
                          print '<option value="'. $cid.'"';
                              if($cid == $selected)
                               { print ' selected= selected ';} 
  
                           print '>'. $CustomerName.'</option>';
  
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
  
                            ?></select>

PL NO: <select name="PL" id="search_PL" style="width:15%;height:30px;">;
                          <option value=""></option>';
                     <?php
                          $selected = ""; 
                          if(isset($_GET['selected'])){
                            $selected = $_GET['selected']; 
                          }
                        
                          $querypur ="SELECT DISTINCT PL FROM job ORDER BY PL";
                          $restc = $con->query($querypur);
                            while ($rowp=mysqli_fetch_array($restc)) {
                             $rowp['PL'] = rtrim($rowp['PL'],",");
                            $PL = $rowp["PL"];
  
                          print '<option value="'. $PL.'"';
                              if($PL == $selected)
                               { print ' selected= selected ';} 
  
                           print '>'. $PL.'</option>';
  
                           }
  
                            ?></select>
              
            From: <input type="text" name="fromDate" id="fromDate" placeholder="from date"  autocomplete="off">
            To: <input type="text" name="toDate" id="toDate" placeholder="to date" autocomplete="off">
            <input type="button" id="jobSearch" value="search">
             <button type="submit" id="Export" name="Export"  class="export" ><img src = "../image/Excel-icon.png" width="11px";  >Export</button>
            <a href="new.php" class="history printadd" style="margin-left:5%;">+&nbspADD NEW</a>
          </div>
            </form>
          <!-- <a href="new.php" class="history printadd" style="margin-left:50%;">+&nbspADD NEW</a> -->
    </div>


   </select>
  <!-- s -->
  
</div>


</div>
<form  name="approve" method="post" action=""> 
  <div id="outer-container">
    <div id="scrollable" style="height:710px;">
      <table id="emp_table" border="0" class="emp" style="width: auto;margin-top: 1%;font-size:10px;">
        <tr class="tr_header" style="background-color:#3385ff;font-family:Tahoma, Geneva, sans-serif;font-size: 12px;">
          <th style="width:2%;">S/N</td>
            <th  style="width:2%;" class="checkall">&nbsp 
              <input type="checkbox" name="check_all" id="check_all" onclick="javascript:checkAll(this)" class="hidden-print"  style="margin-left: 0px;" />
            </th>                    
            <th style="width:2%;" class="action">Action</td>
              <th style="">Job No</td>
                <th style="width:5%;">Date</td>
                  <th style="word-wrap:break-word;">Branch</th>
                  <th style="word-wrap:break-word;">Customer</th>
                  <th style="word-wrap:break-word;">Brand</th>
                  <th style="word-wrap:break-word;">Commodity</th>
                  <th style="word-wrap:break-word;">Code</th>
                  <th style="font-weight:normal;">WIP</th>
                  <th style="font-weight:normal;">Delivery</th>
                  <th style="font-weight:normal;">balance WIP</th>
                  <th style="font-weight:normal;">Type</th>
                  <th style="font-weight:normal;word-wrap:break-word;width: 20%;">Remark</th>
                  <th style="font-weight:normal;">PL</th>

                </tr>

                <?php
     /* $con->query("SET GLOBAL group_concat_max_len = 1000000");
          $setutf8 = "SET NAMES utf8";
      $q = $con->query($setutf8);
      $setutf8c = "SET character_set_results = 'utf8', character_set_client =
      'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
      character_set_server = 'utf8'";
      $qc = $con->query($setutf8c);
      $setutf9 = "SET CHARACTER SET utf8";
      $q1 = $con->query($setutf9);
      $setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
      $q2 = $con->query($setutf7);*/
      $Branches = $_SESSION['Branch'];

          /*if ($Branches == 'Shwe Pyi Thar Store') {
          $sqls=" SELECT *, customer.CustomerName as Customer,customer.UserId as jCustomer
                  FROM job 
                  LEFT JOIN customer
                  ON job.Customer= customer.UserId

                  WHERE job.Location='Shwe Pyi Thar Store' ";}
          elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {
          $sqls=" SELECT *, customer.CustomerName as Customer,customer.UserId as jCustomer
                  FROM job 
                  LEFT JOIN customer
                  ON job.Customer= customer.UserId

                  WHERE job.Location='Shwe Pyi Thar Store Control Panel' ";}

          elseif ($Branches == 'Yangon Show Room') {
          $sqls=" SELECT *, customer.CustomerName as Customer,customer.UserId as jCustomer
                  FROM job 
                  LEFT JOIN customer
                  ON job.Customer= customer.UserId

                  WHERE job.Location='Yangon Show Room' ";}

          elseif ($Branches == 'Mandalay Show Room') {
          $sqls=" SELECT *, customer.CustomerName as Customer,customer.UserId as jCustomer
                  FROM job 
                  LEFT JOIN customer
                  ON job.Customer= customer.UserId

                  WHERE job.Location='Mandalay Show Room' ";}
                  
          elseif ($Branches == 'Naypyidaw Show Room') {
          $sqls=" SELECT *, customer.CustomerName as Customer,customer.UserId as jCustomer
                  FROM job 
                  LEFT JOIN customer
                  ON job.Customer= customer.UserId

                  WHERE job.Location='Naypyidaw Show Room' ";}

          else{
          $sqls=" SELECT *, customer.CustomerName as Customer,customer.UserId as jCustomer
                  FROM job 
                  LEFT JOIN customer
                  ON job.Customer= customer.UserId

                  WHERE 1=1 ";}  */

                  $sqlHeader = "
                  SELECT
                  *
                  FROM
                  (SELECT *, @rownum :=(@rownum +1) AS num
                  FROM
                  (SELECT @rownum := 0) AS initialization,
                  ( ";

                  $sqls=" SELECT job.*,branch.branch as branch_name,customer.CustomerName,customer.UserId as jCustomer,brandname.brandname as pbrandname,
                commodity.commodity as ccommodity,code.code as code_no
                  FROM job 
                  LEFT JOIN customer
                  ON job.Customer= customer.UserId
                  LEFT JOIN code
                  ON job.code= code.id
                  JOIN brandname
                  ON job.BrandName= brandname.id
                  JOIN commodity
                  ON job.Commodity= commodity.id
                  JOIN branch
                  ON job.Location= branch.id
                  WHERE 1=1";

                 if($Branches <> 1){
                    $sqls .=" AND job.Location='$Branches'";
                  }

                  if(!empty($_GET['fromDate']) && !empty($_GET['toDate'])){
                    $fromDate = date("Y-m-d", strtotime($_GET['fromDate']));
                    $toDate = date("Y-m-d", strtotime($_GET['toDate']));
                    $sqls .=" AND job.Job_date BETWEEN '$fromDate' AND '$toDate'";
                    // echo $sqls; exit();
                  }
                  // if (isset($_POST['keyword'])) {
                  //     $keyword = $_POST['keyword']; // DO NOT FORGET ABOUT STRING SANITIZATION
                  //   $sqls =$sqls." AND (customer.CustomerName LIKE '%$keyword%' OR brandname.brandname= '".$_POST['keyword']."' OR  commodity.commodity= '".$_POST['keyword']."' OR job.Job_No LIKE '%$keyword%' OR job.Location LIKE '%$keyword%' OR job.PL LIKE '%$keyword%')";
                  // }  

                  // start myomin
                  if(isset($_GET['search_Job_No']) && $_GET['search_Job_No'] != ''){
                    $Job_No=$_GET['search_Job_No'];
                   $sqls =$sqls." AND job.Job_No='$Job_No'";
                 }
                 if(isset($_GET['search_branch'])  && $_GET['search_branch'] != ''){
                   $search_branch=$_GET['search_branch'];
                   $sqls =$sqls." AND job.Location='$search_branch'";
                 }
                 if(isset($_GET['search_CustomerName'])  && $_GET['search_CustomerName'] != ''){
                   $CustomerName=$_GET['search_CustomerName'];
                   $sqls =$sqls." AND job.Customer='$CustomerName'";
                 }
                 if(isset($_GET['search_BrandName']) && $_GET['search_BrandName'] != ''){
                  $BrandName=$_GET['search_BrandName'];
                  $sqls =$sqls." AND job.BrandName='$BrandName'";
                }
                if(isset($_GET['search_Commodity']) && $_GET['search_Commodity'] != ''){
                  $Commodity=$_GET['search_Commodity'];
                  $sqls =$sqls." AND job.Commodity='$Commodity'";
                }
                if(isset($_GET['search_code'])  && $_GET['search_code'] != ''){
                  $code=$_GET['search_code'];
                  $sqls =$sqls." AND job.code='$code'";
                }
                if(isset($_GET['search_PL']) && $_GET['search_PL'] != ''){
                  $PL=$_GET['search_PL'];
                  $sqls =$sqls." AND job.PL='$PL'";
                }
                
                  //end myomin
                  // if ($_GET['namelist'] <> ''){
                  //             $sqls =$sqls." AND (customer.CustomerName= '".$_GET['namelist']."' OR brandname.brandname= '".$_GET['namelist']."'  OR commodity.commodity= '".$_GET['namelist']."' OR job.Job_No= '".$_GET['namelist']."'OR job.Location= '".$_GET['namelist']."'OR job.PL= '".$_GET['namelist']."')";
                  //   }                          
                            // if ($year == '' ){
                            //   $sqls =$sqls." AND YEAR(Job_date) = YEAR(CURRENT_DATE())";
                            // }
                            // if ($year <> ''){
                            //   $sqls =$sqls." AND YEAR(Job_date)= ".$year;
                            // } 
                            // if ($_GET['month'] <> ''){
                            //   $sqls =$sqls." AND MONTH(Job_date)= '".$_GET['month']."'";
                            // }
                            // if ($_GET['day'] <> ''){
                            //   $sqls =$sqls." AND DAY(Job_date)= ".$_GET['day'];
                            // }     

                            // $sqls = $sqls. " Order by job.BrandName";

                            $sqlFooter ="
                            ) Tbl
                            ) tbl1
                            WHERE
                            1 = 1 ORDER BY
                            num ASC
                            LIMIT 30";

          //$result=mysqli_query($con ,$sqls); 
                            $sSQLQuery= $sqlHeader . $sqls .  $sqlFooter;

                          
                            $result=mysqli_query($con , $sSQLQuery); 
                            $_SESSION["Job_LoadMoreQuery"] = $sSQLQuery;
        // echo $sSQLQuery;


                            $sno =1; 
                            include('show_data.php');            
                            print ' </table>'; 
                            print ' </form>'; 


                            ?>  
                            <div class="ajax-load" style="display:none;text-align:center;">
                              <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More...</p>
                            </div>

                          </div></div>

                          <script src="../js/select2.min.js" type="text/javascript"></script>
        <script>
          $("#search_Job_No").select2( {
  placeholder: "Select Job No",
  allowClear: true
  } );

  $("#search_branch").select2( {
  placeholder: "Select Branch",
  allowClear: true
  } );

  $("#search_CustomerName").select2( {
  placeholder: "Select Customer",
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

  $("#search_PL").select2( {
  placeholder: "Select PL No",
  allowClear: true
  } );
  </script>

                        </body>
                        </html>

