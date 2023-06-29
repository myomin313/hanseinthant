
<?php
include_once('../config.php');
if(!empty($_POST["keyword"])) {
$keyword = mysqli_real_escape_string($con,$_POST['keyword']);
$query ="SELECT DISTINCT branch FROM branch WHERE branch like '" . $keyword  . "%' ORDER BY branch";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brandnames = mysqli_real_escape_string($con,$row["brandname"]);
$branch = addcslashes(mysqli_real_escape_string($con,$row["branch"]), "'");
//$brandnamess = rtrim($row['brandname'],',');
?>
 <li onClick="set_items('<?php echo htmlspecialchars($branch, ENT_QUOTES); ?>');"><?php echo $row["branch"]; ?></li>

<?php } ?>
</ul>
<?php } 


} ?>