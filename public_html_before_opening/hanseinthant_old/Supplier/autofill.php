<?php
include_once('../config.php');
if(!empty($_POST["keyword"])) {
$keyword = mysqli_real_escape_string($con,$_POST['keyword']);
$query ="SELECT DISTINCT SupplierName FROM supplier WHERE SupplierName like '" . $keyword  . "%' ORDER BY SupplierName";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
$SupplierNames = mysqli_real_escape_string($con,$row["SupplierName"]);
$SupplierNamess = rtrim($row['SupplierName'],',');
?>

<li onClick="set_items('<?php echo htmlspecialchars($SupplierNames, ENT_QUOTES); ?>');"><?php echo $SupplierNamess; ?></li>
<?php } ?>
</ul>
<?php } 


} ?>