
<?php
include_once('../config.php');
if(!empty($_POST["keyword"])) {
$keyword = mysqli_real_escape_string($con,$_POST['keyword']);
$query ="SELECT DISTINCT code FROM code WHERE code like '" . $keyword  . "%' ORDER BY code";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $commoditys = mysqli_real_escape_string($con,$row["commodity"]);
// $commodityss = rtrim($row['commodity'],',');
$codes = addcslashes($row["code"], "'");
?>

<li onClick="set_items('<?php echo htmlspecialchars($codes, ENT_QUOTES); ?>');"><?php echo $row["code"]; ?></li>
<?php } ?>
</ul>
<?php } 




$query = "SELECT Distinct brandname.brandname as bbrandname ,code.brandname as cbrandname
FROM code
LEFT JOIN brandname
ON brandname.id= code.brandname
WHERE brandname.brandname like '" . $keyword  . "%'";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $commoditys = mysqli_real_escape_string($con,$row["commodity"]);
// $commodityss = rtrim($row['commodity'],',');
$bbrandname = addcslashes($row["bbrandname"], "'");
?>

<li onClick="set_items('<?php echo htmlspecialchars($bbrandname, ENT_QUOTES); ?>');"><?php echo $row["bbrandname"]; ?></li>
<?php } ?>
</ul>
<?php } 


$query = "SELECT Distinct commodity.commodity as cccommodity ,code.commodity as ccommodity
FROM code
LEFT JOIN commodity
ON commodity.id= code.commodity
WHERE commodity.commodity like '" . $keyword  . "%'";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $commoditys = mysqli_real_escape_string($con,$row["commodity"]);
// $commodityss = rtrim($row['commodity'],',');
$cccommodity = addcslashes($row["cccommodity"], "'");
?>

<li onClick="set_items('<?php echo htmlspecialchars($cccommodity, ENT_QUOTES); ?>');"><?php echo $row["cccommodity"]; ?></li>
<?php } ?>
</ul>
<?php } 


} ?>