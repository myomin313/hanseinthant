<?php session_start();
include_once('../config.php');

$sno="";
$spid="";

$Authority = $_SESSION['authority'];
fncGetQueryString();

$sSQL = $_SESSION["Product_LoadMoreQuery"];
$sSQL = str_replace("1=1"," num >".$spid,$sSQL);
$result=mysqli_query($con ,$sSQL); 
$count = mysqli_num_rows($result);
if($count > 0 ){
    $json=include('show_data.php');
}else{
    $json="";
}
echo json_encode($json);

function fncGetQueryString(){
    if (isset($_GET['last_id'])) {
        $GLOBALS['spid'] = $_GET['last_id'];
    }
    if (isset($_GET['last_serial'])) {
        $GLOBALS['sno'] = ((int) $_GET['last_serial']);
    }
}

?>