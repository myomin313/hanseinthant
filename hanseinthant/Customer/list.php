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
<head>
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
            url: '../Customer/autofill.php?' ,
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
  </head>

 <body style="font-size: 11px; font-family:Tahoma, Geneva, sans-serif;">

   <div  class="col-md-12"   style="margin-top:1%;">
      <input type="text" id="keywords" style="margin-left: 7px;width: 15%;" onKeyUp="searching()" placeholder="search..." /><span id="searching-box"></span>

        <a href="new.php" class="history printadd" style="margin-left:70%;">+&nbspADD NEW</a>

      </div>

<div id="outer-container">
    <div id="scrollable" style="height:710px;">
    <table id="emp_table" border="0" class="resultGridTable" style="width: auto;margin-top: 1%;font-size:10px;">
        <tr class="tr_header" style="background-color:#3385ff;font-family:Tahoma, Geneva, sans-serif;font-size: 12px;">
                                    <th style="width:2%;">S/N</td>
                                    <th style="width:2%;"  class="printadd">Action</th> 
                                    <th >Customer Name</th>
                                    <th >Phone</th>
                                    <th >Emergency</th>
                                    <th >Email</th>
                                    <th >Address</th>
                                    <th  class="printadd">Delete</th>


        </tr>
      
        <?php
                         $sqlA="SELECT * 
                            FROM customer c
                           where 1=1 ";
                            if (isset($_POST['keyword'])) {
                              $keyword = $_POST['keyword']; // DO NOT FORGET ABOUT STRING SANITIZATION
                              $sqlA =$sqlA." AND CustomerName LIKE '%$keyword%'";
                            }  
                        
                            // if ($_GET['namelist'] <> ''){
                            //     $sqlA =$sqlA." AND CustomerName= '".$_GET['namelist']."' OR Address= '".$_GET['namelist']."' OR Email= '".$_GET['namelist']."' ";
                            // }                              
                            

                        $result=mysqli_query($con ,$sqlA);  
             $sno = 1;
 
           while($row = mysqli_fetch_array($result)){

                         $row['CustomerName'] = rtrim($row['CustomerName'],",");
                            print '<tr>';
                            print '<td style="text-align:center;">' . $sno . '</td>';                             
                            $message="Edit";
                            print '<td   class="printadd"><a href="detail.php?ID=' . $row['UserId'] . '"  style="text-decoration: none;
                            padding: 2px 5px;
                            background: #2E8B57;
                            color: white;
                            border-radius: 3px;" >' . $message . '</a></td>'; 

                            print '<td>' . $row['CustomerName'] . '</td>'; 
                            $CustomerName = rtrim($row['CustomerName'],',');
                            
                            print '<td style="word-wrap: break-word;">' . $row['Phone'] . '</td>'; 
                            print '<td style="word-wrap: break-word;">' . $row['Emergency'] . '</td>'; 
                            print '<td style="word-wrap: break-word;">' . $row['Email'] . '</td>';
                            print '<td style="word-wrap: break-word;">' . $row['Address'] . '</td>';  
                             $message="Delete";
                            print '<td   class="printadd"><a href="delete.php?ID=' . $row['UserId'] . '" onclick="return confirm(\'Are you sure to delete?\');")"  style="text-decoration: none;
                            padding: 2px 5px;
                            background: #cc0000;
                            color: white;
                            border-radius: 3px;"  class="printadd">' . $message . '</a></td>';                       
              print '</tr>';

              $sno ++;


            }  
            
            print ' </table>'; 


        ?>  

  </table>
</div>
</div>

</html>



