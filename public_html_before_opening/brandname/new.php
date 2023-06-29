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

                          print '<tr><td>BrandName</td><td> <input type="text" name="brandname" id="brandname" onblur="fncClearBox()" onKeyUp="Commodity()" value="" style="width:250px;height:30px;" required="required"/></td></tr>';

                           print '<tr><td></td><td><input type="submit" value="Save"  class="myButton" id="error"/></td></tr>';                           

                        print '</table>';

                        print '</form>';
                    ?>
                  </body>
                  </html>
   


