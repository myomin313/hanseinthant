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

    <script type="text/javascript">  
      function searching() {
        var min_length = 1; // min caracters to display the autocomplete
        var keyword = $('#keywords').val();
        // alert(keyword);
        if (keyword.length >= min_length) {
          $.ajax({
            url: '../User/autofill.php?' ,
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
<style type="text/css">
        table {
        border-collapse: collapse;
        width: 500px;
      }
</style>
 <body style="font-size: 11px; font-family:Tahoma, Geneva, sans-serif;">

   <div class="col-md-12" style="margin-top:1%;">
      <input type="text" id="keywords" style="margin-left: 7px;width: 15%;" onKeyUp="searching()" placeholder="search..." /><span id="searching-box"></span>
 <a href="new.php" class="history printadd" style="margin-left:70%;">+&nbspADD NEW</a>

      </div>

<div id="outer-container">
    <div id="scrollable" style="height:710px;">
    <table id="emp_table" border="0" class="resultGridTable" style="width: auto;margin-top: 1%;font-size:10px;">
        <tr class="tr_header" style="background-color:#3385ff;font-family:Tahoma, Geneva, sans-serif;font-size: 12px;">
                  <th style="width:2%;">S/N</td>
                  <th  style="width:2%;"  class="printadd" id="action">Action</th>
                  <th>User Name</th>
                  <th>Authority</th>
                  <th>Permission</th>
                  <th>Export</th>
                  <th>Branch</th>
     
                  <th  class="printadd" id="action">Delete</th>

        </tr>
      
        <?php
                          
                        $sqlA="SELECT *,branch.branch as branch_name FROM users JOIN branch ON branch.id=users.Branch WHERE 1=1 ";
                            if (isset($_POST['keyword'])) {
                              $keyword = $_POST['keyword']; // DO NOT FORGET ABOUT STRING SANITIZATION
                              $sqlA =$sqlA." AND UserName LIKE '%$keyword%'";
                            }  
                        
                            if ($_GET['namelist'] <> ''){
                                $sqlA =$sqlA." AND UserName= '".$_GET['namelist']."' ";
                            }                          
                            
                            
                        $result=mysqli_query($con ,$sqlA);  
                        $count=mysqli_num_rows($result); 
                         $sno = 1;
             
                        while($row = mysqli_fetch_array($result)){

                            print '<tr>';
                            print '<td style="text-align:center;">' . $sno . '</td>'; 
                            $message="Edit";
                            print '<td  id="action" class="printadd"><a href="detail.php?UserID=' . $row['UserID'] . '" style="text-decoration: none;
                            padding: 2px 5px;
                            background: #2E8B57;
                            color: white;
                            border-radius: 3px;">' . $message . '</a></td>';                                                         
                            print '<td>' . $row['UserName'] . '</td>'; 
                            print '<td>' . $row['Authority'] . '</td>'; 
                            print '<td>' . $row['Permission'] . '</td>'; 
                            print '<td>' . $row['Export'] . '</td>'; 
                            print '<td>' . $row['branch_name'] . '</td>'; 
                            $message="Delete";
                            print '<td id="action"  class="printadd"><a href="delete.php?ID=' . $row['UserID'] . '" onclick="return confirm(\'Are you sure to delete?\');")"  style="text-decoration: none;
                            padding: 2px 5px;
                            background: #cc0000;
                            color: white;
                            border-radius: 3px;">' . $message . '</a></td>';                       
              print '</tr>';

              $sno ++;


            }  
            
            print ' </table>'; 


        ?>  

</div>
</div>

</body>
</html>

