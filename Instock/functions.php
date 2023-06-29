<?php
include_once('../config.php');
session_start();
$Branches = $_SESSION['Branch'];
$Authority = $_SESSION['authority'];
 
if(isset($_POST["Export"])){

 function cleanData(&$str)
  {
    if($str == 't') $str = 'TRUE';
    if($str == 'f') $str = 'FALSE';
    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
      $str = "'$str";
    }
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';

    $str = mb_convert_encoding($str, 'UTF-32', 'UTF-8');

  }
header('Content-Description: File Transfer');
header('Content-Type: text/csv; charset=UTF-16LE');
$filename = "Instock list/" . date('Y-m-d') . ".csv";
header('Content-Disposition: attachment; filename="' . $filename . '";');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');

$output = fopen('php://output', 'w');
fputs( $output, "\xEF\xBB\xBF" );
if ($Authority == 'Accountant') {  
fputcsv($output,  array('Branch','BrandName','Commodity','Code','Total Input','Total Transfer In','Total Transfer Out','Total WIP','Total Delivery','Total Return','Remark','Total Stock Balance For Sale','Actual Total Stock Balance','Total Input USD','Total Output USD','Balance USD'));  
}
else{
fputcsv($output,  array('Branch','BrandName','Commodity','Code','Total Input','Total Transfer In','Total Transfer Out','Total WIP','Total Delivery','Total Return','Remark','Total Stock Balance For Sale','Actual Total Stock Balance'));    
}
 
// echo $sql;   
$keyword = "";
if(isset($_SESSION["InStock_namelist"])){
  $keyword =$_SESSION["InStock_namelist"];
}


 $Branches = $_SESSION['Branch'];     

           $sqlA="SELECT                 
          branch.branch as branch_name,
          brandname.brandname AS pbrand,
          commodity.commodity AS pCommodity,
          code.code as code_no,
          IFNULL(pQty,0) AS pQty,
          IFNULL(LasttoutQty,0) AS LasttoutQty,
          IFNULL(titQty,0) AS titQty,
          IFNULL(LastWIP,0) AS wip,
          IFNULL(ddQty,0) AS LastdQty,
          IFNULL(returnrrQty,0) AS rQty,
          CONCAT(CONCAT(' ',IFNULL(pRemarks,''), CONCAT(' ' ,IFNULL(jRemarks,''))), CONCAT(' ',IFNULL(dRemarks,''))) AS Remarks,
         (CASE WHEN IFNULL(ddQty,0) < IFNULL(LastWIP,0) THEN ( (IFNULL(pQty,0) -  IFNULL(LastWIP,0)) - IFNULL(LasttoutQty,0) ) +  IFNULL(returnrrQty, 0)   
               WHEN IFNULL(LastWIP,0) < IFNULL(ddQty,0) THEN ( (IFNULL(pQty,0) -  IFNULL(ddQty,0)) - IFNULL(LasttoutQty,0) ) + IFNULL(returnrrQty, 0)   
               WHEN IFNULL(LastWIP,0) = IFNULL(ddQty,0) THEN ( (IFNULL(pQty,0) -  IFNULL(LastWIP,0)) - IFNULL(LasttoutQty,0)) + IFNULL(returnrrQty, 0) 
               END) AS  balancecQty,
               ( ( (IFNULL(pQty,0) - IFNULL(ddQty, 0)) - IFNULL(LasttoutQty,0)) + IFNULL(returnrrQty, 0)  ) AS currentcQty";
          
          
          if ($Authority == 'Accountant') {
  $sqlA .=",IFNULL(pUSD, 0) AS ProUSD,
          ( IFNULL(pRate, 0) + IFNULL(tRate, 0) ) -  IFNULL(rRate, 0)  AS balancetotalUSD,
          IFNULL(pUSD, 0) -  (  ( IFNULL(pRate, 0) + IFNULL(tRate, 0) ) -  IFNULL(rRate, 0)) AS netUSDs"; 
         }
        $sqlA=$sqlA."
          FROM 
          product PoMst 
          JOIN brandname ON PoMst.BrandName = brandname.id JOIN commodity ON PoMst.Commodity = commodity.id
          JOIN branch ON PoMst.Branch = branch.id
          JOIN code ON PoMst.code = code.id  
          LEFT JOIN (SELECT BrandName AS pBrandName,Commodity AS pCommodity,Branch AS pBranch,code AS pcode,SUM(Qty) AS pQty,SUM(USD * Qty) AS pUSD,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS pRemarks
          FROM product FORCE INDEX (Branch,Packing_date,BrandName,Commodity,code) " ;//WHERE 1=1
          

       
          if ($Branches <> 1) {
            $sqlA .=" AND product.Branch='$Branches'";
          }
        //  if(!empty($_GET['startDate']) && !empty($_GET['endDate'])){
             
        //   $fromDate =date("Y-m-d",strtotime($_GET['startDate']));
        //   $toDate   =date("Y-m-d",strtotime($_GET['endDate']));
          
        //   $sqlA .="  AND ( Packing_date BETWEEN '$fromDate' AND '$toDate' ) GROUP BY BrandName,Commodity,Branch,code) tblProd
        //   ON  PoMst.BrandName=tblProd.pBrandName
        //   AND PoMst.Commodity=tblProd.pCommodity
        //   AND PoMst.code=tblProd.pcode
        //   AND PoMst.Branch=tblProd.pBranch
        //   LEFT JOIN (SELECT ANY_VALUE(transfer_date) AS transfer_date,BrandName AS tBrandName,Commodity AS tCommodity,code AS tcode,SUM(Qty) as LasttoutQty,SUM(transferUSD) as tRate,transfer_from AS ttransfer_from,GROUP_CONCAT(Remark_Item SEPARATOR '   ') AS tRemarks
        //   FROM transfer USE INDEX (transfer_from,transfer_date,BrandName,Commodity,code)";
        
        //  }else 
        if(!empty($_POST['endDate'])){
             
             $toDate   =date("Y-m-d",strtotime($_POST['endDate']));

       
           // $sqlA .=" AND Packing_date <= '$toDate' ";
             if( $Branches <> 1){
            $sqlA .=" AND Packing_date <= '$toDate' ";
           }else{
              $sqlA .=" WHERE Packing_date <= '$toDate' ";  
           }
            
            $sqlA .="  GROUP BY BrandName,Commodity,Branch,code) tblProd
          ON  PoMst.BrandName=tblProd.pBrandName
          AND PoMst.Commodity=tblProd.pCommodity
          AND PoMst.code=tblProd.pcode
          AND PoMst.Branch=tblProd.pBranch
          LEFT JOIN (SELECT ANY_VALUE(transfer_date) AS transfer_date,BrandName AS tBrandName,Commodity AS tCommodity,code AS tcode,SUM(Qty) as LasttoutQty,SUM(transferUSD) as tRate,transfer_from AS ttransfer_from,GROUP_CONCAT(Remark_Item SEPARATOR '   ') AS tRemarks
          FROM transfer USE INDEX (transfer_from,transfer_date,BrandName,Commodity,code)";
            
         }else{
             
          $sqlA .=" GROUP BY BrandName,Commodity,Branch,code) tblProd
       ON  PoMst.BrandName=tblProd.pBrandName
       AND PoMst.Commodity=tblProd.pCommodity
       AND PoMst.code=tblProd.pcode
       AND PoMst.Branch=tblProd.pBranch
       LEFT JOIN (SELECT ANY_VALUE(transfer_date) AS transfer_date,BrandName AS tBrandName,Commodity AS tCommodity,code AS tcode,SUM(Qty) as LasttoutQty,SUM(transferUSD) as tRate,transfer_from AS ttransfer_from,GROUP_CONCAT(Remark_Item SEPARATOR '   ') AS tRemarks
       FROM transfer USE INDEX (transfer_from,transfer_date,BrandName,Commodity,code) ";
      }

      if ($Branches <> 1) {
        $sqlA .=" WHERE transfer.transfer_from='$Branches'";
      }

      if(!empty($_POST['startDate'])  && !empty($_POST['endDate'])) {

        $fromDate =date("Y-m-d",strtotime($_POST['startDate']));
        $toDate   =date("Y-m-d",strtotime($_POST['endDate']));

        if( $Branches <> 1){
           $sqlA .=" AND  transfer.transfer_date BETWEEN '$fromDate' AND '$toDate'  ";
        }else{
           $sqlA .=" WHERE  transfer.transfer_date BETWEEN '$fromDate' AND '$toDate' ";
        }
      
     $sqlA .=" GROUP BY Commodity,BrandName,transfer_from,code) tblTransfer
   ON  PoMst.BrandName=tblTransfer.tBrandName
   AND PoMst.Commodity=tblTransfer.tCommodity
   AND PoMst.code=tblTransfer.tcode
   AND PoMst.Branch=tblTransfer.ttransfer_from 
    LEFT JOIN (SELECT ANY_VALUE(t.transfer_date) AS titransfer_date, t.BrandName AS tiBrandName,t.Commodity AS tiCommodity,t.code as ticode,SUM(t.Qty) AS titQty,t.transfer_to AS titransfer_to
    FROM transfer t";

   //start update myomin 
    }else if(empty($_POST['startDate'])  && !empty($_POST['endDate'])){
        
        $toDate   =date("Y-m-d",strtotime($_POST['endDate']));

       if( $Branches <> 1){
            $sqlA .=" AND transfer.transfer_date <= '$toDate' ";
         }else{
            $sqlA .=" WHERE  transfer.transfer_date <= '$toDate' ";
         }
         
           $sqlA .=" GROUP BY Commodity,BrandName,transfer_from,code) tblTransfer
   ON  PoMst.BrandName=tblTransfer.tBrandName
   AND PoMst.Commodity=tblTransfer.tCommodity
   AND PoMst.code=tblTransfer.tcode
   AND PoMst.Branch=tblTransfer.ttransfer_from 
   LEFT JOIN (SELECT ANY_VALUE(t.transfer_date) AS titransfer_date, t.BrandName AS tiBrandName,t.Commodity AS tiCommodity,t.code as ticode,SUM(t.Qty) AS titQty,t.transfer_to AS titransfer_to
    FROM transfer t ";
    }
    //end update myomin
    else{
        
      $sqlA .=" GROUP BY Commodity,BrandName,transfer_from,code) tblTransfer
      ON  PoMst.BrandName=tblTransfer.tBrandName
      AND PoMst.Commodity=tblTransfer.tCommodity
      AND PoMst.code=tblTransfer.tcode
      AND PoMst.Branch=tblTransfer.ttransfer_from
      LEFT JOIN (SELECT ANY_VALUE(t.transfer_date) AS titransfer_date, t.BrandName AS tiBrandName,t.Commodity AS tiCommodity,t.code as ticode,SUM(t.Qty) AS titQty,t.transfer_to AS titransfer_to
      FROM transfer t ";
   }


       if ($Branches <> 1) {
        $sqlA .=" WHERE t.transfer_to='$Branches'";
      }


     if(!empty($_POST['startDate']) && !empty($_POST['endDate'])){
      $fromDate =date("Y-m-d",strtotime($_POST['startDate']));
      $toDate   =date("Y-m-d",strtotime($_POST['endDate']));

 
    if( $Branches <> 1){
      $sqlA .=" AND  t.transfer_date BETWEEN '$fromDate' AND '$toDate'  ";
   }else{
      $sqlA .=" WHERE  t.transfer_date BETWEEN '$fromDate' AND '$toDate' ";
   }

      
      $sqlA .=" GROUP BY BrandName,Commodity,transfer_to,code) tbltransferin
      ON  PoMst.BrandName=tbltransferin.tiBrandName
      AND PoMst.Commodity=tbltransferin.tiCommodity
      AND PoMst.code=tbltransferin.ticode
      AND PoMst.Branch=tbltransferin.titransfer_to
      LEFT JOIN (SELECT ANY_VALUE(Job_date) AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,code AS jcode,SUM(WIP) as LastWIP,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
      FROM job USE INDEX (Location,Job_date,BrandName,Commodity,code)";
    //update start myo min
     }else if(empty($_POST['startDate'])  && !empty($_POST['endDate']) ){
         
        $toDate   =date("Y-m-d",strtotime($_POST['endDate']));

        if( $Branches <> 1){
            $sqlA .=" AND t.transfer_date <= '$toDate' ";
         }else{
            $sqlA .=" WHERE  t.transfer_date <= '$toDate' ";
         }
         
         $sqlA .=" GROUP BY BrandName,Commodity,transfer_to,code) tbltransferin
      ON  PoMst.BrandName=tbltransferin.tiBrandName
      AND PoMst.Commodity=tbltransferin.tiCommodity
      AND PoMst.code=tbltransferin.ticode
      AND PoMst.Branch=tbltransferin.titransfer_to
      LEFT JOIN (SELECT ANY_VALUE(Job_date) AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,code AS jcode,SUM(WIP) as LastWIP,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
      FROM job USE INDEX (Location,Job_date,BrandName,Commodity,code)";
   
     }
     
     //update end by myo min
     else{
         
      $sqlA .=" GROUP BY BrandName,Commodity,transfer_to,code) tbltransferin
      ON  PoMst.BrandName=tbltransferin.tiBrandName
      AND PoMst.Commodity=tbltransferin.tiCommodity
      AND PoMst.code=tbltransferin.ticode
      AND PoMst.Branch=tbltransferin.titransfer_to
       LEFT JOIN (SELECT ANY_VALUE(Job_date) AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,code AS jcode,SUM(WIP) as LastWIP,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
      FROM job USE INDEX (Location,Job_date,BrandName,Commodity,code)";
     }
     
     
          if ($Branches <> 1) {
            $sqlA .=" WHERE job.Location='$Branches'";
          }
           if(!empty($_POST['startDate'])  && !empty($_POST['endDate'])) {
               
              $fromDate =date("Y-m-d",strtotime($_POST['startDate']));
              $toDate   =date("Y-m-d",strtotime($_POST['endDate']));
              
               if( $Branches <> 1){
                  $sqlA .=" AND ( Job_date BETWEEN '$fromDate' AND '$toDate' ) ";
               }else{
                  $sqlA .=" WHERE  Job_date BETWEEN '$fromDate' AND '$toDate' ";
               }
            $sqlA .=" GROUP BY Commodity,BrandName,Location,code) tblJob
          ON  PoMst.BrandName=tblJob.jBrandName
          AND PoMst.Commodity=tblJob.jCommodity
          AND PoMst.code=tblJob.jcode
          AND PoMst.Branch=tblJob.jLocation
          LEFT JOIN (SELECT ANY_VALUE(Delivery_date) AS Delivery_date,BrandName AS dBrandName,Commodity AS dCommodity,code AS dcode,SUM(Qty) as ddQty,SUM(deliveryUSD) AS pRate,Location AS dLocation,GROUP_CONCAT(Remark_Item  SEPARATOR '   ') AS dRemarks
          FROM delivery USE INDEX (Location,Delivery_date,BrandName,Commodity,code)";
             //update start myomin
           }else if(empty($_POST['startDate'])  && !empty($_POST['endDate'])){
               
                 $toDate   =date("Y-m-d",strtotime($_POST['endDate']));
             if( $Branches <> 1){
                 
                  $sqlA .=" AND Job_date <= '$toDate' ";
               }else{
                  $sqlA .=" WHERE Job_date <= '$toDate' ";
               }
               
                 $sqlA .=" GROUP BY Commodity,BrandName,Location,code) tblJob
          ON  PoMst.BrandName=tblJob.jBrandName
          AND PoMst.Commodity=tblJob.jCommodity
          AND PoMst.code=tblJob.jcode
          AND PoMst.Branch=tblJob.jLocation
          LEFT JOIN (SELECT ANY_VALUE(Delivery_date) AS Delivery_date,BrandName AS dBrandName,Commodity AS dCommodity,code AS dcode,SUM(Qty) as ddQty,SUM(deliveryUSD) AS pRate,Location AS dLocation,GROUP_CONCAT(Remark_Item  SEPARATOR '   ') AS dRemarks
          FROM delivery USE INDEX (Location,Delivery_date,BrandName,Commodity,code)";
               
           }
             // update end myomin
             
           else{

             $sqlA .=" GROUP BY Commodity,BrandName,Location,code) tblJob
          ON  PoMst.BrandName=tblJob.jBrandName
          AND PoMst.Commodity=tblJob.jCommodity
          AND PoMst.code=tblJob.jcode
          AND PoMst.Branch=tblJob.jLocation   
          LEFT JOIN (SELECT ANY_VALUE(Delivery_date) AS Delivery_date,BrandName AS dBrandName,Commodity AS dCommodity,code AS dcode,SUM(Qty) as ddQty,SUM(deliveryUSD) AS pRate,Location AS dLocation,GROUP_CONCAT(Remark_Item  SEPARATOR '   ') AS dRemarks
          FROM delivery USE INDEX (Location,Delivery_date,BrandName,Commodity,code)";  

           }
          
         
         
         // new
           // new end
           // new
           if ($Branches <> 1) {
            $sqlA .=" WHERE delivery.Location='$Branches'";
          }
           if(!empty($_POST['startDate'])  && !empty($_POST['endDate'])) {
              $fromDate =date("Y-m-d",strtotime($_POST['startDate']));
              $toDate   =date("Y-m-d",strtotime($_POST['endDate']));
              
              if( $Branches <> 1){
                  $sqlA .=" AND ( Delivery_date BETWEEN '$fromDate' AND '$toDate' ) ";
               }else{
                  $sqlA .=" WHERE Delivery_date BETWEEN '$fromDate' AND '$toDate' ";
               }
            $sqlA .=" GROUP BY Commodity,BrandName,Location,code) tblDeli
          ON  PoMst.BrandName=tblDeli.dBrandName
          AND PoMst.Commodity=tblDeli.dCommodity
          AND PoMst.code=tblDeli.dcode
          AND PoMst.Branch=tblDeli.dLocation
          LEFT JOIN (SELECT ANY_VALUE(Return_date) AS Return_date,Commodity AS rCommodity,BrandName AS rBrandName,code AS rcode,SUM(Qty) as returnrrQty,SUM(returnUSD) as rRate,department AS rDepartment,GROUP_CONCAT(Remarks_item SEPARATOR ' ') AS rRemarks
          FROM returns USE INDEX (department,Return_date,BrandName,Commodity,code)";

         //start update myomin
           }else if(empty($_POST['startDate'])  && !empty($_POST['endDate'])){
               
                $toDate   =date("Y-m-d",strtotime($_POST['endDate']));

             if( $Branches <> 1){
                  $sqlA .=" AND Delivery_date <= '$toDate' ";
               }else{
                  $sqlA .=" WHERE  Delivery_date <= '$toDate' ";
               }
               
               $sqlA .=" GROUP BY Commodity,BrandName,Location,code) tblDeli
          ON  PoMst.BrandName=tblDeli.dBrandName
          AND PoMst.Commodity=tblDeli.dCommodity          
          AND PoMst.code=tblDeli.dcode
          AND PoMst.Branch=tblDeli.dLocation 
          LEFT JOIN (SELECT ANY_VALUE(Return_date) AS Return_date,Commodity AS rCommodity,BrandName AS rBrandName,code AS rcode,SUM(Qty) as returnrrQty,SUM(returnUSD) as rRate,department AS rDepartment,GROUP_CONCAT(Remarks_item SEPARATOR ' ') AS rRemarks
          FROM returns USE INDEX (department,Return_date,BrandName,Commodity,code)";
               
           } //end
           else{

             $sqlA .=" GROUP BY Commodity,BrandName,Location,code) tblDeli
          ON  PoMst.BrandName=tblDeli.dBrandName
          AND PoMst.Commodity=tblDeli.dCommodity          
          AND PoMst.code=tblDeli.dcode
          AND PoMst.Branch=tblDeli.dLocation 
          LEFT JOIN (SELECT ANY_VALUE(Return_date) AS Return_date,Commodity AS rCommodity,BrandName AS rBrandName,code AS rcode,SUM(Qty) as returnrrQty,SUM(returnUSD) as rRate,department AS rDepartment,GROUP_CONCAT(Remarks_item SEPARATOR ' ') AS rRemarks
          FROM returns USE INDEX (department,Return_date,BrandName,Commodity,code)";
           }
           if ($Branches <> 1) {
            $sqlA .=" WHERE returns.department='$Branches'";
          }
          if(!empty($_POST['startDate'])  && !empty($_POST['endDate'])) {

              $fromDate =date("Y-m-d",strtotime($_POST['startDate']));
              $toDate   =date("Y-m-d",strtotime($_POST['endDate']));
              if( $Branches <> 1){
                  $sqlA .=" AND ( Return_date BETWEEN '$fromDate' AND '$toDate' ) ";
               }else{
                  $sqlA .=" WHERE Return_date BETWEEN '$fromDate' AND '$toDate' ";
               }
          $sqlA .="GROUP BY Commodity,BrandName,department,code) tblRet 
          ON  PoMst.BrandName=tblRet.rBrandName
          AND PoMst.Commodity=tblRet.rCommodity
          AND PoMst.code=tblRet.rcode  
          AND PoMst.Branch=tblRet.rDepartment
          WHERE 1=1";
          
        //start update myomin
        }else if(empty($_POST['startDate'])  && !empty($_POST['endDate'])){
            $toDate   =date("Y-m-d",strtotime($_POST['endDate']));
              if( $Branches <> 1){
                  $sqlA .=" AND Return_date <= '$toDate' ";
               }else{
                  $sqlA .=" WHERE Return_date <= '$toDate' ";
               }
            $sqlA .="GROUP BY Commodity,BrandName,department,code) tblRet 
          ON  PoMst.BrandName=tblRet.rBrandName
          AND PoMst.Commodity=tblRet.rCommodity
          AND PoMst.code=tblRet.rcode
          AND PoMst.Branch=tblRet.rDepartment
             WHERE 1=1";
             
 
        }
        //end update myomin
        else{

           $sqlA .="GROUP BY Commodity,BrandName,department,code) tblRet 
          ON  PoMst.BrandName=tblRet.rBrandName
          AND PoMst.Commodity=tblRet.rCommodity
          AND PoMst.code=tblRet.rcode
          AND PoMst.Branch=tblRet.rDepartment
          AND PoMst.Branch=tblRet.rDepartment
          WHERE 1=1";
            
        }

        if ($Branches <> 1) {
            $sqlA .=" AND PoMst.Branch='$Branches'";
          }

          

    //   if(!empty($_POST['startDate'])  && !empty($_POST['endDate'])){
    //       $fromDate =date("Y-m-d",strtotime($_POST['startDate']));
    //       $toDate   =date("Y-m-d",strtotime($_POST['endDate']));
    //       $sqlA =$sqlA." AND (Packing_date BETWEEN '$fromDate' AND '$toDate' OR  return_date BETWEEN '$fromDate' AND '$toDate' OR Job_date BETWEEN '$fromDate' AND '$toDate' OR Delivery_date BETWEEN '$fromDate' AND '$toDate' OR Return_date BETWEEN '$fromDate' AND '$toDate')";
    //   } 
         //  if (isset($_POST['keyword'])) {
         //   $keyword = $_POST['keyword'];
         //   $sqlA =$sqlA." AND (BrandName LIKE '%$keyword%' OR Commodity LIKE '%$keyword%' OR branch LIKE '%$keyword%')";
         // } 
        //   if (!empty($_POST['keyword'])) {
        //    $keyword = $_POST['keyword'];
        //    $sqlA =$sqlA." AND ( brandname.brandname = '$keyword' OR commodity.commodity = '$keyword' OR branch = '$keyword' )";
        //  }

         if(isset($_POST['Branch'])  && $_POST['Branch'] != ''){
          $Branch=$_POST['Branch'];
          $sqlA =$sqlA." AND PoMst.Branch='$Branch'";
        }

        if(isset($_POST['BrandName']) && $_POST['BrandName'] != ''){
          $BrandName=$_POST['BrandName'];
          $sqlA =$sqlA." AND PoMst.BrandName='$BrandName'";
        }

        if(isset($_POST['Commodity']) && $_POST['Commodity'] != ''){
          $commodity=$_POST['Commodity'];
          $sqlA =$sqlA." AND PoMst.Commodity='$commodity'";
        }
        if(isset($_POST['code']) && $_POST['code'] != ''){
          $code=$_POST['code'];
          $sqlA =$sqlA." AND PoMst.code='$code'";
        }

          $sqlA = $sqlA. " GROUP BY
          PoMst.BrandName,
          PoMst.Commodity,
          PoMst.Branch,
          PoMst.code
          HAVING
          COUNT(*) >= 1
          ORDER BY
          brandname.brandname         
          ";
          

     
     // echo $sqlA;exit();
// $rows = $con->query($sql);
$rows = $con->query($sqlA);
$arr1= array();
if ($rows->num_rows > 0) {
// output data of each row
while($row = $rows->fetch_assoc()) {
fputcsv($output, $row);  
    // fputcsv($output, $row);  
}
} else {
     echo "0 results";
}

 }     
 ?>