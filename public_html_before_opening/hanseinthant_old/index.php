<!DOCTYPE html>
<html>
            <?php
              if (isset($_REQUEST['error'])):

             echo '<script type="text/javascript">alert("'.$_REQUEST['error'].'");</script>';
              endif;
            ?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body, html {
    height: auto;
    font-family: Arial, Helvetica, sans-serif;

}

* {
    box-sizing: border-box;
}

.bg-img {
    background: #e6f3ff;
    min-height: 740px;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    position: relative;
}

/* Add styles to the form container */
.container {
    position: absolute;
    left:7%;
    margin: 20px;
    margin-top: 5%;
    max-width:400px;
    padding: 20px;
    background-color: white;
}

/* Full-width input fields */
input[type=text], input[type=password] {
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    border: none;
    background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
    background-color: #ddd;
    outline: none;
}

/* Set a style for the submit button */
.btn {
    background-color: #3385ff;
    color: white;
    padding: 16px 20px;
    border: none;
    cursor: pointer;
    width: 100%;
    opacity: 0.9;
}

.btn:hover {
    opacity: 1;
}
body{
  /*background: #e6f3ff;*/
}
</style>
</head>
<body  style="background-image: url('login1.jpg');    
    min-height: 740px;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    position: relative;">

<style>
    
</style>

<div >

  <form action="post-login.php" method="POST" class="container">
    <img src = "logo.png" width="100px"; height="30px;" ><br><br><br>
      <span style="font-weight: bold;font-size: 30px;text-align: center;text-shadow: 2px 1px #3385ff;">Han Sein Thant Co., Ltd</span><br><br><br>
    <!-- <h1>Login</h1> -->

    <label for="email"><b>Username</b></label>
    <input type="text" placeholder="username" name="username" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="password" name="password" required>

    <button type="submit" class="btn" value="submitted" style="font-size: 16px;">Login</button><br><br>
     <p style="color: #737373;margin-bottom: 0px;font-size: 10px;margin-left: 60px;">© 2019 Findix Myanmar Co., Ltd. All right reserved.</p>

  </form>
      

</div>
 <!--<p style="margin-left: 37%;color: #737373;margin-bottom: 0px;">© 2019 Findix Myanmar Co., Ltd. All right reserved.</p>-->



 


</body>
</html>
