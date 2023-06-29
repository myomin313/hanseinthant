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

<!doctype html>
<html>
<head>
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
            url: '../Delivery/autofill.php?' ,
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
       window.location.href = "list.php?year="+ $(this).val()+"&month="+"&day=&namelist=";
      
  });      
      $('#month').change(function () {
       window.location.href = 'list.php?year=' +$("#year option:selected").val()+'&month='+this.options[this.selectedIndex].value+"&day=&namelist="; 
  });
      $('#day').change(function () {
       window.location.href = 'list.php?year=' +$("#year option:selected").val()+'&month='+$("#month option:selected").val()+'&day='+this.options[this.selectedIndex].value+"&namelist="; 
  });




  $('#scrollable').on('scroll', function() { 
                if ($(this).scrollTop() + 
                    $(this).innerHeight() >=  
                    $(this)[0].scrollHeight) {                     
                      var last_id = $(".clsrow:last").attr("id");
                      var last_serial=$(".clsSerial:last").html();
                      //alert(last_id  + " " + last_serial);
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
  </head>
 <body style="font-size: 10px; font-family:Tahoma, Geneva, sans-serif;">

    <div  class="col-md-12" style="margin-top:1%;">
      <input type="text" id="keywords" style="margin-left: 7px;width: 15%;" onKeyUp="searching()" placeholder="search..." /><span id="searching-box"></span>
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
  <form  name="approve" method="post" action=""> 
    <div id="outer-container">
    <div id="scrollable" style="height:710px;">
    <table id="emp_table" border="0" class="emp" style="width: auto;margin-top: 1%;font-size:10px;">
        <tr class="tr_header" style="background-color:#3385ff;font-family:Tahoma, Geneva, sans-serif;font-size: 12px;">
                  <th rowspan="2" style="width:2%;">S/N</td>
                  <th class="checkall" rowspan="2" style="width:2%;">
                    <input type="checkbox" name="check_all" id="check_all" onclick="javascript:checkAll(this)" class="hidden-print"  style="margin-left: 0px;" />
                   </th>                    
                  <th rowspan="2" style="width:2%;" class="action">Action</td>
                  <th rowspan="2" style="width:5%;">Date</td>
                  <th rowspan="2" >DO.No</th>
                  <th rowspan="2" >JOB.No</th> 
                  <th rowspan="2" style="word-wrap:break-word;">Branch</th>                   
                  <th rowspan="2" style="word-wrap:break-word;">Customer</th>                  
                  <th rowspan="2" style="word-wrap:break-word;">Brand</th>
                  <th colspan="5" style="word-wrap:break-word;">Commodity</th>
                  <th rowspan="2" style="font-weight:normal; word-break: break-all; ">PL</th>  

        </tr>

                  <tr >
                  <th style="font-weight:normal;word-wrap:break-word;" class="stock">Item</th>                
                  <th style="font-weight:normal;"class="stock">Delivery</th>
                  <th style="font-weight:normal;"class="stock">Return</th>
                   <th style="font-weight:normal;" class="stock">Type</th>
                  <th style="font-weight:normal; word-break: break-all;width: 20%; " class="stock">Remark</th>
           
                  </tr> 

  <?php   
          $Branches = $_SESSION['Branch'];

       /* if ($Branches == 'Shwe Pyi Thar Store') {
        $sql = "SELECT Delivery_date, count(*) as count_rows FROM delivery Where Location='Shwe Pyi Thar Store'";       
        $result1 = mysqli_query($con,$sql);
    
        while($rows = mysqli_fetch_array($result1)) {
          $sum = $rows['count_rows'];
          
        }
         
         $sqlA=" SELECT   d.id as id,d.Customer as CustomerID,d.Delivery_date as Delivery_date,d.DO_No as DO_No,d.JOB_No as jJob,c.CustomerName as Customers,c.UserId as cid,d.Type as Type,d.Location as Location,d.PL as PL,
                 d.BrandName as BrandName,
                 d.Commodity as Commodity,
                 d.Type as Type,
                 d.Qty as Qty,
                  d.Remark_item as remark,
                 d.returnQty as rQty
         FROM delivery d
         LEFT JOIN customer c ON c.UserId= d.Customer
         
         Where d.Location='Shwe Pyi Thar Store' ";}


        elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {
        $sql = "SELECT Delivery_date, count(*) as count_rows FROM delivery Where Location='Shwe Pyi Thar Store Control Panel'";       
        $result1 = mysqli_query($con,$sql);
                    

        while($rows = mysqli_fetch_array($result1)) {
          $sum = $rows['count_rows'];
          
        } 
         
         $sqlA=" SELECT   d.id as id,d.Customer as CustomerID,d.Delivery_date as Delivery_date,d.DO_No as DO_No,d.JOB_No as jJob,c.CustomerName as Customers,c.UserId as cid,d.Type as Type,d.Location as Location,d.PL as PL,
                 d.BrandName as BrandName,
                 d.Commodity as Commodity,
                 d.Type as Type,
                 d.Qty as Qty,
                 d.Remark_item as remark,
                 d.returnQty as rQty
         FROM delivery d
         LEFT JOIN customer c ON c.UserId= d.Customer
        

         Where d.Location='Shwe Pyi Thar Store Control Panel' ";}

        elseif ($Branches == 'Yangon Show Room') {
        $sql = "SELECT Delivery_date, count(*) as count_rows FROM delivery Where Location='Yangon Show Room'";       
        $result1 = mysqli_query($con,$sql);
    
        while($rows = mysqli_fetch_array($result1)) {
          $sum = $rows['count_rows'];
          
        } 
         
         $sqlA=" SELECT   d.id as id,d.Customer as CustomerID,d.Delivery_date as Delivery_date,d.DO_No as DO_No,d.JOB_No as jJob,c.CustomerName as Customers,c.UserId as cid,d.Type as Type,d.Location as Location,d.PL as PL,
                 d.BrandName as BrandName,
                 d.Commodity as Commodity,
                 d.Type as Type,
                 d.Qty as Qty,
                 d.Remark_item as remark,
                 d.returnQty as rQty
         FROM delivery d
         LEFT JOIN customer c ON c.UserId= d.Customer

         Where d.Location='Yangon Show Room' ";}

        elseif ($Branches == 'Naypyidaw Show Room') {
        $sql = "SELECT Delivery_date, count(*) as count_rows FROM delivery Where Location='Naypyidaw Show Room'";       
        $result1 = mysqli_query($con,$sql);
    
        while($rows = mysqli_fetch_array($result1)) {
          $sum = $rows['count_rows'];
          
        } 
         
         $sqlA=" SELECT   d.id as id,d.Customer as CustomerID,d.Delivery_date as Delivery_date,d.DO_No as DO_No,d.JOB_No as jJob,c.CustomerName as Customers,c.UserId as cid,d.Type as Type,d.Location as Location,d.PL as PL,
                 d.BrandName as BrandName,
                 d.Commodity as Commodity,
                 d.Type as Type,
                 d.Qty as Qty,
                 d.Remark_item as remark,
                 d.returnQty as rQty
         FROM delivery d
         LEFT JOIN customer c ON c.UserId= d.Customer
         

         Where d.Location='Naypyidaw Show Room' ";}


        elseif ($Branches == 'Mandalay Show Room') {
        $sql = "SELECT Delivery_date, count(*) as count_rows FROM delivery Where Location='Mandalay Show Room'";       
        $result1 = mysqli_query($con,$sql);
    
        while($rows = mysqli_fetch_array($result1)) {
          $sum = $rows['count_rows'];
          
        } 
         
         $sqlA=" SELECT   d.id as id,d.Customer as CustomerID,d.Delivery_date as Delivery_date,d.DO_No as DO_No,d.JOB_No as jJob,c.CustomerName as Customers,c.UserId as cid,d.Type as Type,d.Location as Location,d.PL as PL,
                 d.BrandName as BrandName,
                 d.Commodity as Commodity,
                 d.Type as Type,
                 d.Qty as Qty,
                 d.Remark_item as remark,
                 d.returnQty as rQty
         FROM delivery d
         LEFT JOIN customer c ON c.UserId= d.Customer
         

         Where d.Location='Mandalay Show Room' ";}



        else{
        $sql = "SELECT Delivery_date, count(*) as count_rows FROM delivery ";       
        $result1 = mysqli_query($con,$sql);
    
        while($rows = mysqli_fetch_array($result1)) {
          $sum = $rows['count_rows'];
          
        } 
         
         $sqlA=" SELECT  d.id as id,d.Customer as CustomerID,d.Delivery_date as Delivery_date,d.DO_No as DO_No,d.JOB_No as jJob,c.CustomerName as Customers,c.UserId as cid,d.Type as Type,d.Location as Location,d.PL as PL,
                 d.BrandName as BrandName,
                 d.Commodity as Commodity,
                 d.Type as Type,
                 d.Qty as Qty,
                 d.Remark_item as remark,
                 d.returnQty as rQty          

         FROM delivery d
         LEFT JOIN customer c ON c.UserId= d.Customer

         Where 1=1 " ;    
       
         }     */

         $sql = "SELECT Delivery_date, count(*) as count_rows FROM delivery ";   
         if($Branches <> "All"){
          $sql .= " Where Location='$Branches'";
         }
         $result1 = mysqli_query($con,$sql);
     
         while($rows = mysqli_fetch_array($result1)) {
           $sum = $rows['count_rows'];           
         } 
         $_SESSION['Delivery_sum']=$sum;

         $sqlHeader = "
         SELECT
         *
         FROM
         (SELECT *, @rownum :=(@rownum +1) AS num
         FROM
         (SELECT @rownum := 0) AS initialization,
         (
                 ";
          
          $sqlA=" SELECT  d.id as id,d.Customer as CustomerID,d.Delivery_date as Delivery_date,d.DO_No as DO_No,d.JOB_No as jJob,c.CustomerName as Customers,c.UserId as cid,d.Type as Type,d.Location as Location,d.PL as PL,
                  d.BrandName as BrandName,
                  d.Commodity as Commodity,
                  d.Qty as Qty,
                  d.Remark_item as remark,
                  d.returnQty as rQty          
 
          FROM delivery d
          LEFT JOIN customer c ON c.UserId= d.Customer 
          Where " ;  
          if($Branches <> "All"){
            $sqlA .= " d.Location='$Branches '";
          }else{
            $sqlA .= " 1=1 ";
          }
        

//Where d.Location='Mandalay Show Room'


                            if (isset($_POST['keyword'])) {
                              $keyword = $_POST['keyword']; 
                              $sqlA =$sqlA." AND (customer.CustomerName LIKE '%$keyword%' OR delivery.BrandName LIKE '%$keyword%'OR delivery.Commodity LIKE '%$keyword%'OR delivery.JOB_No LIKE '%$keyword%'OR delivery.DO_No LIKE '%$keyword%'OR delivery.Location LIKE '%$keyword%')";

                            }  
                        
                            if ($_GET['namelist'] <> ''){
                                $sqlA =$sqlA." AND (c.CustomerName= '".$_GET['namelist']."' OR d.BrandName= '".$_GET['namelist']."'OR d.Commodity= '".$_GET['namelist']."'OR d.JOB_No= '".$_GET['namelist']."'OR d.DO_No= '".$_GET['namelist']."'OR d.Location= '".$_GET['namelist']."')";
                             
                            }
                        if ($year == '' ){
                        $sqlA =$sqlA." AND YEAR(Delivery_date) = YEAR(CURRENT_DATE())
                        ";
                        }
                        if ($year <> ''){
                        $sqlA =$sqlA." AND YEAR(Delivery_date)= ".$year;
                        } 

                        if ($_GET['month'] <> ''){
                        $sqlA =$sqlA." AND MONTH(Delivery_date)= '".$_GET['month']."'";
                        }

                        if ($_GET['day'] <> ''){
                        $sqlA =$sqlA." AND DAY(Delivery_date)= ".$_GET['day'];
                        } 

                         
         $sqlA = $sqlA. " Order by BrandName ";

         $sqlFooter ="
         ) Tbl
         ) tbl1
         WHERE
         1 = 1 ORDER BY
         num ASC
         LIMIT 30";

     
         
          //$result=mysqli_query($con ,$sqlA); 
          $sSQLQuery= $sqlHeader . $sqlA .  $sqlFooter;
          $result=mysqli_query($con , $sSQLQuery); 
          $_SESSION["Delivery_LoadMoreQuery"] = $sSQLQuery;
          //echo $sSQLQuery;
            $sno =1;
 
           /*while($row = mysqli_fetch_array($result)){

             print '<tr>';
             print '<td >' . $sno . '</td>';
             print '<td align="center" class="checkss"><input name="users[]" type="checkbox" class="checkboxes" value=' . $row['DO_No'] . ' ></td>';     

              $message="Edit";
              print '<td  class="actions"><a href="detail.php?ID=' . $row['cid'] . ' && DO=' . $row['DO_No'] . ' " style="text-decoration: none;
              padding: 2px 5px;
              background: #2E8B57;
              color: white;
              border-radius: 3px;">' . $message . '</a></td>';                 
              print '<td>' . $row['Delivery_date'] . '</td>'; 
              $IDs=$row['cid'];
              $BrandNamei=$row['BrandName'] ;
              $Delivery_date=$row['Delivery_date'] ;
              $id=$row['id'] ;

              print'<input type="hidden" value="' . $row['BrandName'] . '" id="callid">';

                for( $i=0; $i < $sum ; $i++){

               print'<input type="hidden" value="' . $Delivery_date. '" id="Delivery_date'.$id.'">';
                print'<input type="hidden" value="' . $row['DO_No']. '" id="do'.$id.'">';
             }

              print'<td ><a href="javascript:;" style="color:red;" onclick="printContent(' . $row['cid'] . ','.$id.');" >' . $row['DO_No'] . '</a></td>';
              $BrandName=$row['BrandName'];
              print'<ul id="printlist" ></ul>';
              print '<td >' . $row['jJob'] . '</td>';
              $row['Customers'] = rtrim($row['Customers'],",");
              print '<td>' . $row['Location'] . '</a></td>';
              print '<td>' . $row['Customers'] . '</td>';              
              print '<td>' . $row['BrandName'] . '</a></td>'; 
              print '<td >' . $row['Commodity'] . '<br></td>';                             
              print '<td style="background: #f2f2f2;"  >' . $row['Qty'] . '</td>';
              if ($row['rQty'] <>'') {
                print '<td style="background: #ffeb99;"  >' . $row['rQty'] . '</td>';
              }else{
                print '<td >' . $row['rQty'] . '</td>';
              }
              
              print '<td style="">' . $row['Type'] . '</td>';
              print '<td style="font-weight:normal; word-break: break-all;" class="remark">' . $row['remark'] . '</td>';
              print '<td>' . $row['PL'] . '</td>';                          
              print '</tr>';

              $sno ++;


            }  */
            include('show_data.php');
            print ' </table>'; 
        ?> 
        <div class="ajax-load" style="display:none;text-align:center;">
    <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More...</p>
</div> 
</div></div>
</div>

</body>
</html>
<script>

function printContent(id,row){ 

  var callid=document.getElementById('callid').value;
    var DO_No=document.getElementById('do'+row).value;
    // alert (DO_No);
     $.ajax({
            type: "POST",
            url: 'delivery_invoice.php?BrandName='+callid+'&DO_No='+DO_No,
            data: {id: id},
      type: 'get',
            success: function( response ) {
      
      var contents = response;

      var idname = name;
 

            var frame1 = document.createElement('iframe');
            frame1.name = "frame1";
            frame1.style.position = "absolute";
            frame1.style.top = "-1000000px";
            document.body.appendChild(frame1);
            var frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1.contentDocument.document : frame1.contentDocument;
            frameDoc.document.open();
            frameDoc.document.write('<html><head><title></title>');
           
      frameDoc.document.write('<style>table {  border-collapse: collapse;  border-spacing: 0; width:100%; margin-top:20px;font-size:13px;font-family:Cambria;} .table td, .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th{ padding:8px 18px;  } .table-bordered, .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {     border: 1px solid #e2e2e2;} </style>');
       
        // your title
      frameDoc.document.title = "Print Content with ajax in php";
      
      
        frameDoc.document.write('</head><body>');
            frameDoc.document.write(contents);
            frameDoc.document.write('</body></html>');
            frameDoc.document.close();
            setTimeout(function () {
                window.frames["frame1"].focus();
                window.frames["frame1"].print();
                document.body.removeChild(frame1);
            }, 500);
            return false; 

      
        
        
            }
        });
  
}
</script>

