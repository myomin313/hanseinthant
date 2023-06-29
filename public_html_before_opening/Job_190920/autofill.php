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
if ($Branches == 'Shwe Pyi Thar Store') {
$keyword = mysqli_real_escape_string($con,$_POST['keyword']);
$query ="SELECT DISTINCT BrandName,Location FROM job WHERE BrandName like '" . $keyword  . "%' and Location='Shwe Pyi Thar Store'  ORDER BY BrandName LIMIT 0,15";
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


$query ="SELECT DISTINCT Commodity,Location FROM job WHERE Commodity like '" . $keyword  . "%'  and Location='Shwe Pyi Thar Store' ORDER BY Commodity LIMIT 0,15";
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

$query = "SELECT Distinct  customer.CustomerName as Customer ,job.Location as Location
FROM job
LEFT JOIN customer
ON customer.UserId= job.Customer
WHERE customer.CustomerName like '" . $keyword  . "%' and Location='Shwe Pyi Thar Store'";
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

$query ="SELECT DISTINCT Location FROM job WHERE Location like '" . $keyword  . "%' and Location='Shwe Pyi Thar Store' ORDER BY Location ";
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

<li onClick="set_items('<?php echo $row["Location"]; ?>');"><?php echo $row["Location"]; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT Job_No,Location FROM job WHERE Job_No like '" . $keyword  . "%' and Location='Shwe Pyi Thar Store' ORDER BY JOB_No ";
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

<li onClick="set_items('<?php echo $row["Job_No"]; ?>');"><?php echo $row["Job_No"]; ?></li>
<?php } ?>
</ul>
<?php } 

} 

elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {
$keyword = mysqli_real_escape_string($con,$_POST['keyword']);
$query ="SELECT DISTINCT BrandName,Location FROM job WHERE BrandName like '" . $keyword  . "%' and Location='Shwe Pyi Thar Store Control Panel' ORDER BY BrandName LIMIT 0,15";
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


$query ="SELECT DISTINCT Commodity,Location FROM job WHERE Commodity like '" . $keyword  . "%'  and Location='Shwe Pyi Thar Store Control Panel' ORDER BY Commodity LIMIT 0,15";
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

$query = "SELECT Distinct  customer.CustomerName as Customer ,job.Location as Location
FROM job
LEFT JOIN customer
ON customer.UserId= job.Customer
WHERE customer.CustomerName like '" . $keyword  . "%' and Location='Shwe Pyi Thar Store Control Panel'";
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

$query ="SELECT DISTINCT Location FROM job WHERE Location like '" . $keyword  . "%' and Location='Shwe Pyi Thar Store Control Panel' ORDER BY Location ";
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

<li onClick="set_items('<?php echo $row["Location"]; ?>');"><?php echo $row["Location"]; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT Job_No,Location FROM job WHERE Job_No like '" . $keyword  . "%' and Location='Shwe Pyi Thar Store Control Panel' ORDER BY JOB_No ";
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

<li onClick="set_items('<?php echo $row["Job_No"]; ?>');"><?php echo $row["Job_No"]; ?></li>
<?php } ?>
</ul>
<?php } 

} 


elseif ($Branches == 'Yangon Show Room') {
$keyword = mysqli_real_escape_string($con,$_POST['keyword']);
$query ="SELECT DISTINCT BrandName,Location FROM job WHERE BrandName like '" . $keyword  . "%' and Location='Yangon Show Room' ORDER BY BrandName LIMIT 0,15";
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

$query ="SELECT DISTINCT Commodity,Location FROM job WHERE Commodity like '" . $keyword  . "%'  and Location='Yangon Show Room' ORDER BY Commodity LIMIT 0,15";
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

$query = "SELECT Distinct  customer.CustomerName as Customer ,job.Location as Location
FROM job
LEFT JOIN customer
ON customer.UserId= job.Customer
WHERE customer.CustomerName like '" . $keyword  . "%' and Location='SYangon Show Room'";
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

$query ="SELECT DISTINCT Location FROM job WHERE Location like '" . $keyword  . "%' and Location='Yangon Show Room' ORDER BY Location ";
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

<li onClick="set_items('<?php echo $row["Location"]; ?>');"><?php echo $row["Location"]; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT Job_No,Location FROM job WHERE Job_No like '" . $keyword  . "%' and Location='Yangon Show Room' ORDER BY JOB_No ";
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

<li onClick="set_items('<?php echo $row["Job_No"]; ?>');"><?php echo $row["Job_No"]; ?></li>
<?php } ?>
</ul>
<?php } 

} 


elseif ($Branches == 'Mandalay Show Room') {
$keyword = mysqli_real_escape_string($con,$_POST['keyword']);
$query ="SELECT DISTINCT BrandName,Location FROM job WHERE BrandName like '" . $keyword  . "%' and Location='Mandalay Show Room' ORDER BY BrandName LIMIT 0,15";
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


$query ="SELECT DISTINCT Commodity,Location FROM job WHERE Commodity like '" . $keyword  . "%'  and Location='Mandalay Show Room' ORDER BY Commodity LIMIT 0,15";
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

$query = "SELECT Distinct  customer.CustomerName as Customer ,job.Location as Location
FROM job
LEFT JOIN customer
ON customer.UserId= job.Customer
WHERE customer.CustomerName like '" . $keyword  . "%' and Location='SMandalay Show Room'";
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

$query ="SELECT DISTINCT Location FROM job WHERE Location like '" . $keyword  . "%' and Location='Mandalay Show Room' ORDER BY Location ";
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

<li onClick="set_items('<?php echo $row["Location"]; ?>');"><?php echo $row["Location"]; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT Job_No,Location FROM job WHERE Job_No like '" . $keyword  . "%' and Location='Mandalay Show Room' ORDER BY JOB_No ";
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

<li onClick="set_items('<?php echo $row["Job_No"]; ?>');"><?php echo $row["Job_No"]; ?></li>
<?php } ?>
</ul>
<?php } 

} 

elseif ($Branches == 'Naypyidaw Show Room') {
$keyword = mysqli_real_escape_string($con,$_POST['keyword']);
$query ="SELECT DISTINCT BrandName,Location FROM job WHERE BrandName like '" . $keyword  . "%' and Location='Naypyidaw Show Room'  ORDER BY BrandName LIMIT 0,15";
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


$query ="SELECT DISTINCT Commodity,Location FROM job WHERE Commodity like '" . $keyword  . "%'  and Location='Naypyidaw Show Room' ORDER BY Commodity LIMIT 0,15";
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

$query = "SELECT Distinct  customer.CustomerName as Customer ,job.Location as Location
FROM job
LEFT JOIN customer
ON customer.UserId= job.Customer
WHERE customer.CustomerName like '" . $keyword  . "%' and Location='Naypyidaw Show Room'";
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

$query ="SELECT DISTINCT Location FROM job WHERE Location like '" . $keyword  . "%' and Location='Naypyidaw Show Room' ORDER BY Location ";
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

<li onClick="set_items('<?php echo $row["Location"]; ?>');"><?php echo $row["Location"]; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT Job_No,Location FROM job WHERE Job_No like '" . $keyword  . "%' and Location='Naypyidaw Show Room' ORDER BY JOB_No ";
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

<li onClick="set_items('<?php echo $row["Job_No"]; ?>');"><?php echo $row["Job_No"]; ?></li>
<?php } ?>
</ul>
<?php } 

} 



else{
$keyword = mysqli_real_escape_string($con,$_POST['keyword']);
$query ="SELECT DISTINCT BrandName FROM job WHERE BrandName like '" . $keyword  . "%' ";
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


//$query ="SELECT DISTINCT Commodity,Location FROM job WHERE Commodity like '" . $keyword  . "%'  and Location='Naypyidaw Show Room' ORDER BY Commodity LIMIT 0,15";
$query ="SELECT DISTINCT Commodity,Location FROM job WHERE Commodity like '" . $keyword  . "%'  ORDER BY Commodity LIMIT 0,15";
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
FROM job
LEFT JOIN customer
ON customer.UserId= job.Customer
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

$query ="SELECT DISTINCT Location FROM job WHERE Location like '" . $keyword  . "%'  ORDER BY Location ";
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

<li onClick="set_items('<?php echo $row["Location"]; ?>');"><?php echo $row["Location"]; ?></li>
<?php } ?>
</ul>
<?php } 

$query ="SELECT DISTINCT Job_No FROM job WHERE Job_No like '" . $keyword  . "%'  ORDER BY JOB_No ";
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

<li onClick="set_items('<?php echo $row["Job_No"]; ?>');"><?php echo $row["Job_No"]; ?></li>
<?php } ?>
</ul>
<?php } 

} 
}?>