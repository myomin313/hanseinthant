<?php session_start();?>
<?php
    include_once('../config.php');
$Branches = $_SESSION['Branch'];
       $setutf8 = "SET NAMES utf8";
        $q = $con->query($setutf8);
        $setutf8c = "SET character_set_results = 'utf8', character_set_client =
        'utf8', character_set_conection = 'utf8', character_set_database = 'utf8',
        character_set_server = 'utf8'";
        $qc = $con->query($setutf8c);
        $setutf9 = "SET CHARACTER SET utf8";
        $q1 = $con->query($setutf9);
        $setutf7 = "SET COLLATION_CONNECTION = 'utf8_general_ci'";
        $q2 = $con->query($setutf7);
if(!empty($_POST["keyword"])) {
$keyword = mysqli_real_escape_string($con,$_POST['keyword']);
if ($Branches == 'Shwe Pyi Thar Store') {  
$query ="SELECT DISTINCT BrandName,department FROM returns WHERE BrandName like '" . $keyword  . "%' and department='Shwe Pyi Thar Store'  ORDER BY BrandName LIMIT 0,15";
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


$query ="SELECT DISTINCT Commodity,department FROM returns WHERE Commodity like '" . $keyword  . "%'  and department='Shwe Pyi Thar Store' ORDER BY Commodity LIMIT 0,15";
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

$query = "SELECT Distinct  customer.CustomerName as Customer,returns.department as department
FROM returns
LEFT JOIN customer
ON customer.UserId= returns.Customer
WHERE customer.CustomerName like '" . $keyword  . "%' and returns.department='Shwe Pyi Thar Store'";
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
$CustomerA = rtrim($row['Customer'],",");
$Customers = mysqli_real_escape_string($con,$row["Customer"]);
?>

<li onClick="set_items('<?php echo htmlspecialchars($Customers, ENT_QUOTES); ?>');"><?php echo $CustomerA; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT department FROM returns WHERE department like '" . $keyword  . "%' and department='Shwe Pyi Thar Store' ORDER BY department ";
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

<li onClick="set_items('<?php echo $row["department"]; ?>');"><?php echo $row["department"]; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT DO_No,department FROM returns WHERE DO_No like '" . $keyword  . "%' and department='Shwe Pyi Thar Store' ORDER BY DO_No ";
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

<li onClick="set_items('<?php echo $row["DO_No"]; ?>');"><?php echo $row["DO_No"]; ?></li>
<?php } ?>
</ul>
<?php } 
}


elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') { 
$query ="SELECT DISTINCT BrandName,department FROM returns WHERE BrandName like '" . $keyword  . "%' and department='Shwe Pyi Thar Store Control Panel' ORDER BY BrandName LIMIT 0,15";
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


$query ="SELECT DISTINCT Commodity,department FROM returns WHERE Commodity like '" . $keyword  . "%'  and department='Shwe Pyi Thar Store Control Panel' ORDER BY Commodity LIMIT 0,15";
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

$query = "SELECT Distinct customer.CustomerName as Customer,returns.department
FROM returns
LEFT JOIN customer
ON customer.UserId= returns.Customer
WHERE customer.CustomerName like '" . $keyword  . "%' and returns.department='Shwe Pyi Thar Store Control Panel' ";
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
$CustomerA = rtrim($row['Customer'],",");
$Customers = mysqli_real_escape_string($con,$row["Customer"]);
?>

<li onClick="set_items('<?php echo htmlspecialchars($Customers, ENT_QUOTES); ?>');"><?php echo $CustomerA; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT department FROM returns WHERE department like '" . $keyword  . "%' and department='Shwe Pyi Thar Store Control Panel' ORDER BY department ";
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

<li onClick="set_items('<?php echo $row["department"]; ?>');"><?php echo $row["department"]; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT DO_No,department FROM returns WHERE DO_No like '" . $keyword  . "%' and department='Shwe Pyi Thar Store Control Panel' ORDER BY DO_No ";
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

<li onClick="set_items('<?php echo $row["DO_No"]; ?>');"><?php echo $row["DO_No"]; ?></li>
<?php } ?>
</ul>
<?php } 
}


 elseif ($Branches == 'Yangon Show Room') {   
$query ="SELECT DISTINCT BrandName,department FROM returns WHERE BrandName like '" . $keyword  . "%' and department='Yangon Show Room' ORDER BY BrandName LIMIT 0,15";
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


$query ="SELECT DISTINCT Commodity,department FROM returns WHERE Commodity like '" . $keyword  . "%'  and department='Yangon Show Room' ORDER BY Commodity LIMIT 0,15";
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


$query = "SELECT Distinct  customer.CustomerName as Customer,returns.department as department
FROM returns
LEFT JOIN customer
ON customer.UserId= returns.Customer
WHERE customer.CustomerName like '" . $keyword  . "%' and returns.department='Yangon Show Room'";
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
$CustomerA = rtrim($row['Customer'],",");
$Customers = mysqli_real_escape_string($con,$row["Customer"]);
?>

<li onClick="set_items('<?php echo htmlspecialchars($Customers, ENT_QUOTES); ?>');"><?php echo $CustomerA; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT department FROM returns WHERE department like '" . $keyword  . "%' and department='Yangon Show Room' ORDER BY department ";
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

<li onClick="set_items('<?php echo $row["department"]; ?>');"><?php echo $row["department"]; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT DO_No,department FROM returns WHERE DO_No like '" . $keyword  . "%' and department='Yangon Show Room' ORDER BY DO_No ";
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

<li onClick="set_items('<?php echo $row["DO_No"]; ?>');"><?php echo $row["DO_No"]; ?></li>
<?php } ?>
</ul>
<?php } 
}


 elseif ($Branches == 'Naypyidaw Show Room') {   
$query ="SELECT DISTINCT BrandName,department FROM returns WHERE BrandName like '" . $keyword  . "%' and department='Naypyidaw Show Room' ORDER BY BrandName LIMIT 0,15";
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


$query ="SELECT DISTINCT Commodity,department FROM returns WHERE Commodity like '" . $keyword  . "%'  and department='Naypyidaw Show Room' ORDER BY Commodity LIMIT 0,15";
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


$query = "SELECT Distinct  customer.CustomerName as Customer,returns.department as department
FROM returns
LEFT JOIN customer
ON customer.UserId= returns.Customer
WHERE customer.CustomerName like '" . $keyword  . "%' and returns.department='Naypyidaw Show Room'";
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
$CustomerA = rtrim($row['Customer'],",");
$Customers = mysqli_real_escape_string($con,$row["Customer"]);
?>

<li onClick="set_items('<?php echo htmlspecialchars($Customers, ENT_QUOTES); ?>');"><?php echo $CustomerA; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT department FROM returns WHERE department like '" . $keyword  . "%' and department='Naypyidaw Show Room' ORDER BY department ";
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

<li onClick="set_items('<?php echo $row["department"]; ?>');"><?php echo $row["department"]; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT DO_No,department FROM returns WHERE DO_No like '" . $keyword  . "%' and department='Naypyidaw Show Room' ORDER BY DO_No ";
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

<li onClick="set_items('<?php echo $row["DO_No"]; ?>');"><?php echo $row["DO_No"]; ?></li>
<?php } ?>
</ul>
<?php } 
}


 elseif ($Branches == 'Mandalay Show Room') {   
$query ="SELECT DISTINCT BrandName,department FROM returns WHERE BrandName like '" . $keyword  . "%' and department='Mandalay Show Room' ORDER BY BrandName LIMIT 0,15";
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



$query ="SELECT DISTINCT Commodity,department FROM returns WHERE Commodity like '" . $keyword  . "%'  and department='Mandalay Show Room' ORDER BY Commodity LIMIT 0,15";
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

$query = "SELECT Distinct  customer.CustomerName as Customer,returns.department as department
FROM returns
LEFT JOIN customer
ON customer.UserId= returns.Customer
WHERE customer.CustomerName like '" . $keyword  . "%' and returns.department='Mandalay Show Room' ";
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
$CustomerA = rtrim($row['Customer'],",");
$Customers = mysqli_real_escape_string($con,$row["Customer"]);
?>

<li onClick="set_items('<?php echo htmlspecialchars($Customers, ENT_QUOTES); ?>');"><?php echo $CustomerA; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT department FROM returns WHERE department like '" . $keyword  . "%' and department='Mandalay Show Room' ORDER BY department ";
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

<li onClick="set_items('<?php echo $row["department"]; ?>');"><?php echo $row["department"]; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT DO_No,department FROM returns WHERE DO_No like '" . $keyword  . "%' and department='Mandalay Show Room' ORDER BY DO_No ";
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

<li onClick="set_items('<?php echo $row["DO_No"]; ?>');"><?php echo $row["DO_No"]; ?></li>
<?php } ?>
</ul>
<?php } 
}

else{
$query ="SELECT DISTINCT BrandName FROM returns WHERE BrandName like '" . $keyword  . "%' ORDER BY BrandName LIMIT 0,15";
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


$query ="SELECT DISTINCT Commodity FROM returns WHERE Commodity like '" . $keyword  . "%'   ORDER BY Commodity LIMIT 0,15";
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

$query = "SELECT Distinct  customer.CustomerName as Customer 
FROM returns
LEFT JOIN customer
ON customer.UserId= returns.Customer
WHERE customer.CustomerName like '" . $keyword  . "%' ";
$result =  $con->query($query);
if(!empty($result)) {
?>
<ul id="search-list">
<?php
foreach($result as $row) {
?>
<?php 
// $brands = htmlspecialchars($row["BrandName"], ENT_QUOTES); 
$CustomerA = rtrim($row['Customer'],",");
$Customers = mysqli_real_escape_string($con,$row["Customer"]);
?>

<li onClick="set_items('<?php echo htmlspecialchars($Customers, ENT_QUOTES); ?>');"><?php echo $CustomerA; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT department FROM returns WHERE department like '" . $keyword  . "%' ORDER BY department ";
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

<li onClick="set_items('<?php echo $row["department"]; ?>');"><?php echo $row["department"]; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT DO_No FROM returns WHERE DO_No like '" . $keyword  . "%' ORDER BY DO_No ";
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

<li onClick="set_items('<?php echo $row["DO_No"]; ?>');"><?php echo $row["DO_No"]; ?></li>
<?php } ?>
</ul>
<?php } 
}
} ?>