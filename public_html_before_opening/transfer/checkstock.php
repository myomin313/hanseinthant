<?php
header("Content-type: json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
session_start();
include("../config.php");

if (is_ajax()) {
    if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
        $action = $_POST["action"];
        switch($action) { //Switch case for value of action
            case "checkStock":            
            $return["status"]= fncCheckStock($con);
            break;
        }
        echo json_encode($return);
    }
}

function fncCheckStock($conn){
    
   
    $sRet = "";
    $BrandName = $_POST['BrandName'];
    $Commodity = $_POST['Commodity'];
    $transfer_from = $_POST['transfer_from'];
    $PL = $_POST['PL'];
    $Qty =$_POST['Qty'];
    $transfer_no =$_POST['transfer_no'];
    
  
    if( $transfer_no != null){

    $sqls = " SELECT * FROM  product WHERE BrandName =? AND Commodity=? AND Branch=? AND Purchase_order_No=? AND transfer_no=?";
    $stmt= $conn->prepare($sqls);
    $stmt->bind_param("sssss",$BrandName,$Commodity,$transfer_from,$PL,$transfer_no);

  }else{
    $sqls = " SELECT * FROM  product WHERE BrandName =? AND Commodity=? AND Branch=? AND Purchase_order_No=? and transfer_no IS NULL";
    $stmt= $conn->prepare($sqls);
    $stmt->bind_param("ssss",$BrandName,$Commodity,$transfer_from,$PL);
  }
    $stmt->execute();
    $stmt->store_result();
    $row=bindAll($stmt);
    $count = $stmt->affected_rows;
    if($count > 0 ){
      while($stmt->fetch()) {     
        if((int)$Qty > (int)$row["currentQty"]){
            $sRet = "Current Stock Of [" .$BrandName.", $Commodity". ", $PL"." ]= " .$row["currentQty"] ;
            $sRet .= "\n***Stock is not enough! ****";
        }
      }
    }     
    return $sRet;
  }

 //Function to check if the request is an AJAX request
 function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
  }


  function bindAll($stmt) {
    $meta = $stmt->result_metadata();
    $fields = array();
    $fieldRefs = array();
    while ($field = $meta->fetch_field())
    {
        $fields[$field->name] = "";
        $fieldRefs[] = &$fields[$field->name];
    }
  
    call_user_func_array(array($stmt, 'bind_result'), $fieldRefs);
    $stmt->store_result();
    //var_dump($fields);
    return $fields;
  }

?>