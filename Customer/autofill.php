
<?php
    include_once('../config.php');

if(!empty($_POST["keyword"])) {
$keyword = mysqli_real_escape_string($con,$_POST['keyword']);
$query ="SELECT DISTINCT CustomerName FROM customer WHERE CustomerName like '" . $keyword  . "%' ORDER BY CustomerName";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
$CustomerNames = mysqli_real_escape_string($con,$row["CustomerName"]);
$CustomerNamess = rtrim($row['CustomerName'],',');
?>

<li onClick="set_items('<?php echo htmlspecialchars($CustomerNames, ENT_QUOTES); ?>');"><?php echo $CustomerNamess; ?></li>
<?php } ?>
</ul>
<?php } 


} ?>