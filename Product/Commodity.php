<?php session_start();?>
<?php
include_once('../config.php');
       $setutf8 = "SET NAMES utf8";
        $q = $con->query($setutf8);
        $setutf8c = "SET character_set_results = 'utf8', character_set_client =
        'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
        character_set_server = 'utf8'";
        $qc = $con->query($setutf8c);
        $setutf9 = "SET CHARACTER SET utf8";
        $q1 = $con->query($setutf9);
        $setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
        $q2 = $con->query($setutf7);   
$Branches = $_SESSION['Branch'];

if(!empty($_POST["keyword"])) {
    
    $query ="SELECT Distinct Commodity,Branch FROM product WHERE Commodity like '" . $_POST["keyword"] . "%' ORDER BY Commodity LIMIT 0,10";

// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="Commodity-list">
<?php
foreach($result as $row) {
?>
<?php 
$Commoditys = mysqli_real_escape_string($con,$row["Commodity"]);
?>

<li onClick="selectCommodity('<?php echo htmlspecialchars($Commoditys, ENT_QUOTES); ?>');"><?php echo $row["Commodity"]; ?></li>
<?php } ?>
</ul>
<?php } } ?>