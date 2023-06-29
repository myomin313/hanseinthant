<?php session_start();?>
<?php 
      if (($_SESSION['login_session']<> true)) {
        header("Location:../index.php");    
        exit();
      }     

?>
<?php 
      include_once('../config.php');
      include_once('../bartwo.php');
      include_once('../style.css');
      include_once('../header.php');
 
 ?> 

<!doctype html>
<html>
<style type="text/css">
        table {
        border-collapse: collapse;
        width: 500px;
      }
</style>
<head>
      <script src="jquery-1.12.0.min.js" type="text/javascript"></script>


</head>
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
 <body style="font-size: 10px; font-family:Tahoma, Geneva, sans-serif;">

  <select name="year" onchange="javascript:valueselect()" id="year" style="height:25px;margin-left:1%;margin-top:1%;">
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

      <span  class="printadd" >&nbspYear</span>
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

      <span  class="printadd" >&nbspMonth</span>
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

      <span  class="printadd">&nbspDay</span>    
       <a href="new.php" class="history printadd" style="margin-left:70%;">+&nbspADD NEW</a>

   <br><br>
<head>
  <link rel="stylesheet" type="text/css" href="clock_style.css">
  <script type="text/javascript">
    window.onload = setInterval(clock,1);

    function clock()
    {
    var d = new Date();
    
    var date = d.getDate();
    
    var month = d.getMonth();
    var montharr =["Jan","Feb","Mar","April","May","June","July","Aug","Sep","Oct","Nov","Dec"];
    month=montharr[month];
    
    var year = d.getFullYear();
    
    var day = d.getDay();
    var dayarr =["Sun","Mon","Tues","Wed","Thurs","Fri","Sat"];
    day=dayarr[day];
    
    var hour =d.getHours();
      var min = d.getMinutes();
    var sec = d.getSeconds();
  
    document.getElementById("date").innerHTML=day+" "+date+" "+month+" "+year;
    document.getElementById("time").innerHTML=hour+":"+min+":"+sec;
    }
  </script>
</head>

 <div id="outer-container" >
    <div id="scrollable" style="height:710px;">
    <table id="emp_table" border="0" class="resultGridTable" style="width: auto;font-size:10px;">
        <tr class="tr_header" style="background-color:#3385ff;font-family:Tahoma, Geneva, sans-serif;font-size: 14px;">                          <th>ID</th>
                                  <th style="width:2%;" id="action">Action</td>
                                  <th>Myanmar</th>
                                  <th>Singapore</th>
                                  <th>Europe</th>
                                  <th>Thailand</th>
                                  <th>British</th>
                                  <th>Japan</th>
                                  <th>Australia</th>
                                  <th>Date</th>
                                  <th>Creator</th>
                                  <th id="action">Delete</th>

        </tr>
    <?php


    $sqls ="SELECT * From rate WHERE 1=1";                     
                        
                            if ($year == '' ){
                        $sqls =$sqls." AND YEAR(Rate_date) = YEAR(CURRENT_DATE())
                        ";
                        // echo $sqls;
                        }
                        if ($year <> ''){
                        $sqls =$sqls." AND YEAR(Rate_date)= '".$year."'";
                        } 

                        if ($_GET['month'] <> ''){
                        $sqls =$sqls." AND MONTH(Rate_date)= '".$_GET['month']."'";
                        }

                        if ($_GET['day'] <> ''){
                        $sqls =$sqls." AND DAY(Rate_date)=  '".$_GET['day']."'";
                        }                         
  $sqls = $sqls. "Order by Rate_date"; 
 $results=mysqli_query($con ,$sqls); 
                      
                        $sno=1;
             
                        while($row = $results->fetch_assoc()){  

                            print '<tr>';
                            print '<td  >' . $sno . '</td>'; 
                            $message="Edit";
                            print '<td  id="action"><a href="detail.php?ID=' . $row['id'] . '"  style="text-decoration: none;
                            padding: 2px 5px;
                            background: #2E8B57;
                            color: white;
                            border-radius: 3px;" >' . $message . '</a></td>';   
                            print '<td>' . $row['Myanmar'] . '</td>'; 
                            print '<td>' . $row['Singapore'] . '</td>';
                            print '<td>' . $row['Europe'] . '</td>'; 
                            print '<td>' . $row['Thailand'] . '</td>';
                            print '<td>' . $row['British'] . '</td>';
                            print '<td>' . $row['Japan'] . '</td>';
                            print '<td>' . $row['Australia'] . '</td>';
                            print '<td>' . $row['Rate_date'] . '</td>';
                            print '<td>' . $row['Creator'] . '</td>'; 
                            $message="Delete";
                            print '<td  id="action"><a href="delete.php?id=' . $row['id'] . '&Rate_date=' . $row['Rate_date'] . '"   onclick="return confirm(\'Are you sure to delete?\');")"  style="text-decoration: none;
                            padding: 2px 5px;
                            background: #cc0000;
                            color: white;
                            border-radius: 3px;" >' . $message . '</a></td>';                                               
                            print '</tr>';

              $sno ++;

            }  
       mysqli_close($con);     
            print ' </table>'; 

        ?>  
</div>
</div>


