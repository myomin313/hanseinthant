
<?php 
    include_once('../config.php');
    $keyword =  strval($_POST['keyword']);

        $sql = "SELECT DISTINCT Rate_date FROM rate WHERE Rate_date LIKE '%{$keyword}%'";
        echo $sql;
        $results=mysqli_query($con ,$sql); 
        $row = $results->fetch_assoc();
        if ($row['Rate_date'] != $keyword ) {
        $message = "Your date is not allowed";
        echo "<script type='text/javascript'>alert('$message');</script>";
        }
       
 
    $con->close();
?>

