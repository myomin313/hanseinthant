
<?php
include_once('../config.php');
if(!empty($_POST["keyword"])) {
$keyword = mysqli_real_escape_string($con,$_POST['keyword']);
$query ="SELECT DISTINCT UserName FROM users WHERE UserName like '" . $keyword  . "%' ORDER BY UserName";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
$UserNames = mysqli_real_escape_string($con,$row["UserName"]);
$UserNamess = rtrim($row['UserName'],',');
?>

<li onClick="set_items('<?php echo htmlspecialchars($UserNames, ENT_QUOTES); ?>');"><?php echo $UserNamess; ?></li>
<?php } ?>
</ul>
<?php } 


} ?>