<?php session_start();?>
<?php
include_once('../config.php');
$Branches = $_SESSION['Branch'];

if(!empty($_POST["keyword"])) {
    
    $query ="SELECT Distinct BrandName,Branch FROM product WHERE BrandName like '" . $_POST["keyword"] . "%'  ORDER BY BrandName LIMIT 0,10";

// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="brand-list">
<?php
foreach($result as $row) {
?>
<?php 
$brands = mysqli_real_escape_string($con,$row["BrandName"]);
?>

<li onClick="selectBrand('<?php echo htmlspecialchars($brands, ENT_QUOTES); ?>');"><?php echo $row["BrandName"]; ?></li>
<?php } ?>
</ul>
<?php } } ?>