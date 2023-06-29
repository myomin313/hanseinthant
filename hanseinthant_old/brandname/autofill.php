
<?php
include_once('../config.php');
if(!empty($_POST["keyword"])) {
$keyword = mysqli_real_escape_string($con,$_POST['keyword']);
$query ="SELECT DISTINCT brandname FROM brandname WHERE brandname like '" . $keyword  . "%' ORDER BY brandname";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
$brandnames = mysqli_real_escape_string($con,$row["brandname"]);
$brandnamess = rtrim($row['brandname'],',');
?>

<li onClick="set_items('<?php echo htmlspecialchars($brandnames, ENT_QUOTES); ?>');"><?php echo $brandnamess; ?></li>
<?php } ?>
</ul>
<?php } 


} ?>