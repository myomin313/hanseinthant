<?php session_start();?>
<?php 
      if (($_SESSION['login_session']<> true)) {
        header("Location:../index.php");    
        exit();
      }     

?>
<?php 
      include_once('../config.php');
      include_once('../bar.php');
      include_once('../style.css');
      include_once('../header.php');
 
 ?> 
    <script>
 $(document).ready(function() {
    var max_fields      = 100;
    var wrapper         = $(".insert");
    var add_button      = $(".add_form_field");
  
    var x = 1;
    $(add_button).click(function(e){
        e.preventDefault();
        if(x < max_fields){
            x++;
            $(wrapper).append('<div><br><input type="text" name="Name[]" style="width:250px;height:30px;"/>&nbsp&nbsp<a href="#" class="myDelete" >Delete</a></div>'); //add input box
        }
  else
  {
  alert('You Reached the limits')
  }
    });
  
    $(wrapper).on("click",".myDelete", function(e){
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});   
</script>
<body style="font-size: 11px;font-family:Tahoma, Geneva, sans-serif;">

             <?php

                           print '<form method="POST" action="save.php">';
                     
                           print '<table style="width: 100%;margin-left:0%;" id="customers">';
                          $LUser = $_SESSION['login_user'];
                          print'<input type="hidden" name="LUser" id="LUser" value="'.$LUser.'" style="width:250px;height:30px;" />';
                           print '<tr><td>Supplier Name</td><td class="insert"><input type="button" value="Add New Field" class="add_form_field myAdd"/>
                             </button>
                             </td></tr>';                            

                           print '<tr><td>Phone </td><td> <input type="text" name="Phone" id="Phone" value="" style="width:250px;height:30px;"/></td></tr>';
                          print '<tr><td>Fax </td><td> <input type="text" name="Emergency" id="Emergency" value="" style="width:250px;height:30px;"/></td></tr>';
                             
                           print '<tr><td>Email </td><td> <input type="email" name="email" id="email" value="" style="width:250px;height:30px;"/></td></tr>';
                       print '<tr><td>Address </td><td> <textarea style="width:500px;word-wrap: break-word;" type="text" name="Address" id="Address"  style="width:250px;height:30px;"></textarea></td></tr>';  
                           print '<tr><td></td><td><input type="submit" value="Save"  class="myButton" id="error"/></td></tr>';                           

                        print '</table>';

                        print '</form>';
                    ?>
                  </body>
                  </html>
   


