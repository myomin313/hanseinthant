<?php session_start();?>
<?php
include_once('../config.php');
$Branches = $_SESSION['Branch'];

if(!empty($_POST["keyword"])) {
    if ($Branches == 'Shwe Pyi Thar Store') {   
$query ="SELECT Distinct BrandName,Branch FROM product WHERE BrandName like '" . $_POST["keyword"] . "%' and Branch = 'Shwe Pyi Thar Store'  ORDER BY BrandName LIMIT 0,10";

}
elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {
 $query ="SELECT Distinct BrandName,Branch FROM product WHERE BrandName like '" . $_POST["keyword"] . "%' and Branch = 'Shwe Pyi Thar Store Control Panel'  ORDER BY BrandName LIMIT 0,10";   
}
elseif ($Branches == 'Yangon Show Room') {
    $query ="SELECT Distinct BrandName,Branch FROM product WHERE BrandName like '" . $_POST["keyword"] . "%' and Branch = 'Yangon Show Room'  ORDER BY BrandName LIMIT 0,10";
}
elseif ($Branches == 'Naypyidaw Show Room') {
    $query ="SELECT Distinct BrandName,Branch FROM product WHERE BrandName like '" . $_POST["keyword"] . "%' and Branch = 'Naypyidaw Show Room'  ORDER BY BrandName LIMIT 0,10";
}
elseif ($Branches == 'Mandalay Show Room') {
    $query ="SELECT Distinct BrandName,Branch FROM product WHERE BrandName like '" . $_POST["keyword"] . "%' and Branch = 'Mandalay Show Room'  ORDER BY BrandName LIMIT 0,10";
}
else{
    $query ="SELECT Distinct BrandName,Branch FROM product WHERE BrandName like '" . $_POST["keyword"] . "%'  ORDER BY BrandName LIMIT 0,10";
}
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

<li onClick="selectBrand(this,'<?php echo htmlspecialchars($brands, ENT_QUOTES); ?>');"><?php echo $row["BrandName"]; ?></li>
<?php } ?>
</ul>
<?php } } ?>