<?php session_start();?>
<?php
    include_once('../config.php');
$Branches = $_SESSION['Branch'];
       /*$setutf8 = "SET NAMES utf8";
        $q = $con->query($setutf8);
        $setutf8c = "SET character_set_results = 'utf8', character_set_client =
        'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
        character_set_server = 'utf8'";
        $qc = $con->query($setutf8c);
        $setutf9 = "SET CHARACTER SET utf8";
        $q1 = $con->query($setutf9);
        $setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
        $q2 = $con->query($setutf7);*/    
if(!empty($_POST["keyword"])) {
$keyword = mysqli_real_escape_string($con,$_POST['keyword']);
if ($Branches == 'Shwe Pyi Thar Store') {
$query ="SELECT DISTINCT BrandName,Branch FROM product WHERE BrandName like '" . $keyword  . "%' and Branch='Shwe Pyi Thar Store'  ORDER BY BrandName LIMIT 0,15 ";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
$brands = mysqli_real_escape_string($con,$row["BrandName"]);
?>

<li onClick="set_items('<?php echo htmlspecialchars($brands, ENT_QUOTES); ?>');"><?php echo $row["BrandName"]; ?></li>
<?php } ?>
</ul>
<?php }


$query ="SELECT DISTINCT Commodity,Branch FROM product WHERE Commodity like '" . $keyword  . "%'  and Branch='Shwe Pyi Thar Store' ORDER BY Commodity LIMIT 0,15";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
//$Commoditys = mysqli_real_escape_string($con,$row["Commodity"]);
$Commoditys = $row["Commodity"];
?>

<li onClick="set_items('<?php echo htmlspecialchars($Commoditys, ENT_QUOTES); ?>');"><?php echo $row["Commodity"]; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT Branch FROM product WHERE Branch like '" . $keyword  . "%' and Branch='Shwe Pyi Thar Store' ORDER BY Branch ";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 

?>

<li onClick="set_items('<?php echo $row["Branch"]; ?>');"><?php echo $row["Branch"]; ?></li>
<?php } ?>
</ul>
<?php } 
}




elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {
$query ="SELECT DISTINCT BrandName,Branch FROM product WHERE BrandName like '" . $keyword  . "%' and Branch='Shwe Pyi Thar Store Control Panel'  ORDER BY BrandName LIMIT 0,15 ";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
$brands = mysqli_real_escape_string($con,$row["BrandName"]);
?>

<li onClick="set_items('<?php echo htmlspecialchars($brands, ENT_QUOTES); ?>');"><?php echo $row["BrandName"]; ?></li>
<?php } ?>
</ul>
<?php }



$query ="SELECT DISTINCT Commodity,Branch FROM product WHERE Commodity like '" . $keyword  . "%'  and Branch='Shwe Pyi Thar Store Control Panel' ORDER BY Commodity LIMIT 0,15";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
//$Commoditys = mysqli_real_escape_string($con,$row["Commodity"]);
$Commoditys = $row["Commodity"];
?>

<li onClick="set_items('<?php echo htmlspecialchars($Commoditys, ENT_QUOTES); ?>');"><?php echo $row["Commodity"]; ?></li>
<?php } ?>
</ul>
<?php } 
$query ="SELECT DISTINCT Branch FROM product WHERE Branch like '" . $keyword  . "%' and Branch='Shwe Pyi Thar Store Control Panel' ORDER BY Branch ";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 

?>

<li onClick="set_items('<?php echo $row["Branch"]; ?>');"><?php echo $row["Branch"]; ?></li>
<?php } ?>
</ul>
<?php } 
}



elseif ($Branches == 'Yangon Show Room') {
$query ="SELECT DISTINCT BrandName,Branch FROM product WHERE BrandName like '" . $keyword  . "%' and Branch='Yangon Show Room'  ORDER BY BrandName LIMIT 0,15 ";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
$brands = mysqli_real_escape_string($con,$row["BrandName"]);
?>

<li onClick="set_items('<?php echo htmlspecialchars($brands, ENT_QUOTES); ?>');"><?php echo $row["BrandName"]; ?></li>
<?php } ?>
</ul>
<?php }



$query ="SELECT DISTINCT Commodity,Branch FROM product WHERE Commodity like '" . $keyword  . "%'  and Branch='Yangon Show Room' ORDER BY Commodity LIMIT 0,15";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
//$Commoditys = mysqli_real_escape_string($con,$row["Commodity"]);
$Commoditys = $row["Commodity"];
?>

<li onClick="set_items('<?php echo htmlspecialchars($Commoditys, ENT_QUOTES); ?>');"><?php echo $row["Commodity"]; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT Branch FROM product WHERE Branch like '" . $keyword  . "%' and Branch='Yangon Show Room' ORDER BY Branch ";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 

?>

<li onClick="set_items('<?php echo $row["Branch"]; ?>');"><?php echo $row["Branch"]; ?></li>
<?php } ?>
</ul>
<?php } 
}





elseif ($Branches == 'Mandalay Show Room') {
$query ="SELECT DISTINCT BrandName,Branch FROM product WHERE BrandName like '" . $keyword  . "%' and Branch='Mandalay Show Room'  ORDER BY BrandName LIMIT 0,15 ";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
$brands = mysqli_real_escape_string($con,$row["BrandName"]);
?>

<li onClick="set_items('<?php echo htmlspecialchars($brands, ENT_QUOTES); ?>');"><?php echo $row["BrandName"]; ?></li>
<?php } ?>
</ul>
<?php }



$query ="SELECT DISTINCT Commodity,Branch FROM product WHERE Commodity like '" . $keyword  . "%'  and Branch='Mandalay Show Room' ORDER BY Commodity LIMIT 0,15";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
//$Commoditys = mysqli_real_escape_string($con,$row["Commodity"]);
$Commoditys = $row["Commodity"];
?>

<li onClick="set_items('<?php echo htmlspecialchars($Commoditys, ENT_QUOTES); ?>');"><?php echo $row["Commodity"]; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT Branch FROM product WHERE Branch like '" . $keyword  . "%' and Branch='Mandalay Show Room' ORDER BY Branch ";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 

?>

<li onClick="set_items('<?php echo $row["Branch"]; ?>');"><?php echo $row["Branch"]; ?></li>
<?php } ?>
</ul>
<?php } 
}





elseif ($Branches == 'Naypyidaw Show Room') {
$query ="SELECT DISTINCT BrandName,Branch FROM product WHERE BrandName like '" . $keyword  . "%' and Branch='Naypyidaw Show Room'  ORDER BY BrandName LIMIT 0,15 ";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
$brands = mysqli_real_escape_string($con,$row["BrandName"]);
?>

<li onClick="set_items('<?php echo htmlspecialchars($brands, ENT_QUOTES); ?>');"><?php echo $row["BrandName"]; ?></li>
<?php } ?>
</ul>
<?php }



$query ="SELECT DISTINCT Commodity,Branch FROM product WHERE Commodity like '" . $keyword  . "%'  and Branch='Naypyidaw Show Room' ORDER BY Commodity LIMIT 0,15";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
//$Commoditys = mysqli_real_escape_string($con,$row["Commodity"]);
$Commoditys = $row["Commodity"];
?>

<li onClick="set_items('<?php echo htmlspecialchars($Commoditys, ENT_QUOTES); ?>');"><?php echo $row["Commodity"]; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT Branch FROM product WHERE Branch like '" . $keyword  . "%' and Branch='Naypyidaw Show Room' ORDER BY Branch ";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 

?>

<li onClick="set_items('<?php echo $row["Branch"]; ?>');"><?php echo $row["Branch"]; ?></li>
<?php } ?>
</ul>
<?php } 
}


else{
$query ="SELECT DISTINCT BrandName FROM product WHERE BrandName like '" . $keyword  . "%'  ORDER BY BrandName LIMIT 0,15 ";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
$brands = mysqli_real_escape_string($con,$row["BrandName"]);
?>

<li onClick="set_items('<?php echo htmlspecialchars($brands, ENT_QUOTES); ?>');"><?php echo $row["BrandName"]; ?></li>
<?php } ?>
</ul>
<?php }


$query ="SELECT DISTINCT Commodity,Branch FROM product WHERE Commodity like '" . $keyword  . "%'  ORDER BY Commodity LIMIT 0,15";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
//$Commoditys = mysqli_real_escape_string($con,$row["Commodity"]);
$Commoditys = $row["Commodity"];
?>

<li onClick="set_items('<?php echo htmlspecialchars($Commoditys, ENT_QUOTES); ?>');"><?php echo $row["Commodity"]; ?></li>
<?php } ?>
</ul>
<?php } 
$query ="SELECT DISTINCT Branch FROM product WHERE Branch like '" . $keyword  . "%' ORDER BY Branch ";
// echo $query;
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 

?>

<li onClick="set_items('<?php echo $row["Branch"]; ?>');"><?php echo $row["Branch"]; ?></li>
<?php } ?>
</ul>
<?php } 
}
} ?>