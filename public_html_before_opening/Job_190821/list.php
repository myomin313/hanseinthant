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


    <div class="col-md-12" style="margin-top:1%;">
 <input type="text" id="keywords" style="margin-left: 7px;width: 15%;" onKeyUp="searching()" placeholder="search..." /><span id="searching-box"></span>

      </select>
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

      <span id="day">&nbspDay</span> 
       <a href="new.php" class="history printadd" style="margin-left:50%;">+&nbspADD NEW</a>

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
                  <th style="font-weight:normal;">WIP</th>
                  <th style="font-weight:normal;">Delivery</th>
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

          if ($Branches == 'Shwe Pyi Thar Store') {
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

                  WHERE 1=1 ";}                  
          if (isset($_POST['keyword'])) {
                              $keyword = $_POST['keyword']; // DO NOT FORGET ABOUT STRING SANITIZATION
                              $sqls =$sqls." AND (customer.CustomerName LIKE '%$keyword%' OR job.BrandName LIKE '%$keyword%' OR job.Commodity LIKE '%$keyword%' OR job.Job_No LIKE '%$keyword%' OR job.Location LIKE '%$keyword%')";


                            }  
                        
          if ($_GET['namelist'] <> ''){
                                $sqls =$sqls." AND (customer.CustomerName= '".$_GET['namelist']."' OR job.BrandName= '".$_GET['namelist']."'  OR job.Commodity= '".$_GET['namelist']."' OR job.Job_No= '".$_GET['namelist']."'OR job.Location= '".$_GET['namelist']."')";
                            }                          
          if ($year == '' ){
            $sqls =$sqls." AND YEAR(Job_date) = YEAR(CURRENT_DATE())";
          }
          if ($year <> ''){
            $sqls =$sqls." AND YEAR(Job_date)= ".$year;
          } 
          if ($_GET['month'] <> ''){
            $sqls =$sqls." AND MONTH(Job_date)= '".$_GET['month']."'";
          }
          if ($_GET['day'] <> ''){
            $sqls =$sqls." AND DAY(Job_date)= ".$_GET['day'];
          }     
	
	      $sqls = $sqls. " Order by job.BrandName";
	     
                                           
          $result=mysqli_query($con ,$sqls); 
            $sno =1;
 
            while($row = mysqli_fetch_array($result)){
             

              $row['Customer'] = rtrim($row['Customer'],",");
              print '<tr>';
              print '<td  >' . $sno . '</td>';  
               print '<td align="center"  class="checkss"><input name="users[]" type="checkbox" class="checkboxes" value=' . $row['Job_No'] . ' ></td>';              
              $message="Edit";
              print '<td  class="actions"><a href="detail.php?Customer='.$row['jCustomer'].'&JOB_NO='.$row['Job_No'].'&Branch=' . $row['Location'] . '" style="text-decoration: none;
              padding: 2px 5px;
              background: #2E8B57;
              color: white;
              border-radius: 3px;">' . $message . '</a></td>'; 
              if ($row['PL'] <> '') {
              print '<td  >' . $row['Job_No'] . '</td>';
              print '<td  >' . $row['Job_date'] . '</td>';
               print '<td  >' . $row['Location'] . '</td>'; 
              $row['Customer'] = rtrim($row['Customer'],","); 
              print '<td  >' . $row['Customer'] . '</td>';  

              print '<td  style="word-wrap:break-word;">' . $row['BrandName'] . '</td>'; 
              print '<td >' . $row['Commodity'] . '</td>';

              print '<td style="width:4%;" >' . $row['WIP'] . '</td>';
              print '<td style="width:4%;background: #ffeb99;" >' . $row['balanceWIP'] . '</td>';
              print '<td style="width:4%;">' . $row['Type'] . '</td>';
              $row['Remarks_Item'] = rtrim($row['Remarks_Item'],",");
              print '<td class="remark" style="word-break: break-all;">' . $row['Remarks_Item'] . '</td>';
              print '<td style="" >' . $row['PL'] . '</td>';
              }

              else{
              print '<td  style="background:#ff9999;">' . $row['Job_No'] . '</td>';
              print '<td  style="background:#ff9999;">' . $row['Job_date'] . '</td>';
               print '<td  style="background:#ff9999;">' . $row['Location'] . '</td>'; 
              $row['Customer'] = rtrim($row['Customer'],","); 
              print '<td  style="background:#ff9999;">' . $row['Customer'] . '</td>';  

              print '<td  style="word-wrap:break-word;background:#ff9999;">' . $row['BrandName'] . '</td>'; 
              print '<td style="background:#ff9999;">' . $row['Commodity'] . '</td>';
              print '<td style="width:4%;background:#ff9999;" >' . $row['WIP'] . '</td>';
              print '<td style="width:4%;background: #ff9999;" >' . $row['balanceWIP'] . '</td>';
              print '<td style="width:4%;background:#ff9999;">' . $row['Type'] . '</td>';
              $row['Remarks_Item'] = rtrim($row['Remarks_Item'],",");
              print '<td class="remark" style="word-break: break-all;background:#ff9999;">' . $row['Remarks_Item'] . '</td>';
              print '<td style="background:#ff9999;" >' . $row['PL'] . '</td>';                
              }

                           
              print '</tr>';

              $sno ++;


            }  
            
            print ' </table>'; 
            print ' </form>'; 


        ?>  

</div></div>

</body>
</html>

