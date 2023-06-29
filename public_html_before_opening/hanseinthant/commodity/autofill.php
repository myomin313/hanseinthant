
<?php
include_once('../config.php');
if(!empty($_POST["keyword"])) {
$keyword = mysqli_real_escape_string($con,$_POST['keyword']);
$query ="SELECT DISTINCT commodity FROM commodity WHERE commodity like '" . $keyword  . "%' ORDER BY commodity";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
$commoditys = mysqli_real_escape_string($con,$row["commodity"]);
$commodityss = rtrim($row['commodity'],',');
?>

<li onClick="set_items('<?php echo htmlspecialchars($commoditys, ENT_QUOTES); ?>');"><?php echo $commodityss; ?></li>
<?php } ?>
</ul>
<?php } 


} ?>