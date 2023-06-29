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
          IFNULL(toutQty,0) AS toutQty,
          IFNULL(titQty,0) AS titQty,
          IFNULL(JWIP,0) AS wip,
          IFNULL(dQty,0) AS balanceDelivery,
          IFNULL(returnrQty,0) AS rQty,
          CONCAT(CONCAT(IFNULL(pRemarks,''),
          CONCAT(' ' ,IFNULL(jRemarks,''))), 
          CONCAT(' ',IFNULL(dRemarks,''))) AS Remarks,
         IFNULL(returnrQty,0) AS rQty,
         (CASE WHEN IFNULL(ddQty,0) < IFNULL(LastWIP,0) THEN ( (IFNULL(ANY_VALUE(pQty),0) -  IFNULL(LastWIP,0)) - IFNULL(LasttoutQty,0) ) +  IFNULL(returnrrQty, 0)   
               WHEN IFNULL(LastWIP,0) < IFNULL(ddQty,0) THEN ( (IFNULL(ANY_VALUE(pQty),0) -  IFNULL(ddQty,0)) - IFNULL(LasttoutQty,0) ) + IFNULL(returnrrQty, 0)   
               WHEN IFNULL(LastWIP,0) = IFNULL(ddQty,0) THEN ( (IFNULL(ANY_VALUE(pQty),0) -  IFNULL(LastWIP,0)) - IFNULL(LasttoutQty,0)) + IFNULL(returnrrQty, 0) 
               END) AS  balancecQty,
               ( ( (IFNULL(ANY_VALUE(pQty), 0) - IFNULL(ddQty, 0)) - IFNULL(LasttoutQty,0)) + IFNULL(returnrrQty, 0)  ) AS currentcQty";
          
          
          if ($Authority == 'Accountant') {
  $sqlA .=",SUM(totalUSD) AS totalUSDs,
          IFNULL(pRate, 0) AS balancetotalUSD,
          IFNULL(pUSD, 0) -  ( IFNULL(pRate, 0) -  IFNULL(rRate, 0)) AS netUSDs"; 
         }
        $sqlA=$sqlA."
          FROM 
          product PoMst JOIN brandname ON PoMst.BrandName = brandname.id JOIN commodity ON PoMst.Commodity = commodity.id
          JOIN branch ON PoMst.Branch = branch.id
          LEFT JOIN code ON PoMst.code = code.id  
          LEFT JOIN (SELECT BrandName AS pBrandName,Commodity AS pCommodity,Branch AS pBranch,SUM(Qty) AS pQty,SUM(USD * Qty) AS pUSD,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS pRemarks
          FROM product FORCE INDEX (Branch,Packing_date,BrandName,Commodity) WHERE 1=1";
          

          // if ($Branches <> 'All') {
          //   $sqlA .=" AND product.Branch='$Branches'";
          // }
          if($Branches <> 1){
            $sqlA .=" AND product.Branch='$Branches'";
          }

        //start for transfer
        if(!empty($_POST['startDate']) && !empty($_POST['endDate'])){
          $fromDate =date("Y-m-d",strtotime($_POST['startDate']));
          $toDate   =date("Y-m-d",strtotime($_POST['endDate']));
          
          $sqlA .="  AND ( Packing_date BETWEEN '$fromDate' AND '$toDate' ) GROUP BY BrandName,Commodity,Branch) tblProd
          ON  PoMst.BrandName=tblProd.pBrandName
          AND PoMst.Commodity=tblProd.pCommodity
          AND PoMst.Branch=tblProd.pBranch
          LEFT JOIN (SELECT ANY_VALUE(transfer_date) AS transfer_date,BrandName AS tBrandName,Commodity AS tCommodity,SUM(Qty) as toutQty,transfer_from AS transfer_from,GROUP_CONCAT(Remark_Item SEPARATOR '   ') AS tRemarks
           FROM transfer USE INDEX (transfer_from,transfer_date,BrandName,Commodity)";
         }else{
          $sqlA .=" GROUP BY BrandName,Commodity,Branch) tblProd
       ON  PoMst.BrandName=tblProd.pBrandName
       AND PoMst.Commodity=tblProd.pCommodity
       AND PoMst.Branch=tblProd.pBranch
       LEFT JOIN (SELECT ANY_VALUE(transfer_date) AS transfer_date,BrandName AS tBrandName,Commodity AS tCommodity,SUM(Qty) as toutQty,transfer_from AS transfer_from,GROUP_CONCAT(Remark_Item SEPARATOR '   ') AS tRemarks
       FROM transfer USE INDEX (transfer_from,transfer_date,BrandName,Commodity) ";
      }

      if ($Branches <> 1) {
        $sqlA .=" WHERE transfer.transfer_from='$Branches'";
      }

      if(!empty($_POST['startDate'])  && !empty($_POST['endDate'])) {
        if( $Branches <> 1){
           $sqlA .=" AND ( transfer_date BETWEEN '$fromDate' AND '$toDate' ) ";
        }else{
           $sqlA .=" WHERE  transfer_date BETWEEN '$fromDate' AND '$toDate' ";
        }
       $fromDate =date("Y-m-d",strtotime($_POST['startDate']));
       $toDate   =date("Y-m-d",strtotime($_POST['endDate']));
     $sqlA .=" GROUP BY Commodity,BrandName,transfer_from) tblTransfer
   ON  PoMst.BrandName=tblTransfer.tBrandName
   AND PoMst.Commodity=tblTransfer.tCommodity
   AND PoMst.Branch=tblTransfer.transfer_from 
   LEFT JOIN (SELECT ANY_VALUE(t.transfer_date) AS tttransfer_date, t.BrandName AS ttBrandName,t.Commodity AS ttCommodity,SUM(t.Qty) AS LasttoutQty,SUM(pt.USD * t.Qty) as tRate,t.transfer_from AS tttransfer_from
   FROM transfer t  LEFT JOIN product pt ON pt.Purchase_order_No = t.PL AND pt.BrandName = t.BrandName AND pt.Commodity = t.Commodity AND pt.Branch = t.transfer_from";
   

    }else{

      $sqlA .=" GROUP BY Commodity,BrandName,transfer_from) tblTransfer
   ON  PoMst.BrandName=tblTransfer.tBrandName
   AND PoMst.Commodity=tblTransfer.tCommodity
   AND PoMst.Branch=tblTransfer.transfer_from 
   LEFT JOIN (SELECT ANY_VALUE(t.transfer_date) AS tttransfer_date, t.BrandName AS ttBrandName,t.Commodity AS ttCommodity,SUM(t.Qty) AS LasttoutQty,SUM(pt.USD * t.Qty) as tRate,t.transfer_from AS tttransfer_from
   FROM transfer t LEFT JOIN product pt ON pt.Purchase_order_No = t.PL AND pt.BrandName = t.BrandName AND pt.Commodity = t.Commodity AND pt.Branch = t.transfer_from";  

    }


    if ($Branches <> 1) {
      $sqlA .=" WHERE t.transfer_from='$Branches'";
    }
      // new
     if(!empty($_POST['startDate'])  && !empty($_POST['endDate'])) {
       $fromDate =date("Y-m-d",strtotime($_POST['startDate']));
       $toDate   =date("Y-m-d",strtotime($_POST['endDate']));

       if( $Branches <> 1){
            $sqlA .=" AND t.transfer_date <= '$toDate' ";
         }else{
            $sqlA .=" WHERE  t.transfer_date <= '$toDate' ";
         }

         $sqlA .=" GROUP BY t.BrandName,t.Commodity,t.transfer_from) tbltransferLast
    ON  PoMst.BrandName=tbltransferLast.ttBrandName
    AND PoMst.Commodity=tbltransferLast.ttCommodity
    AND PoMst.Branch=tbltransferLast.tttransfer_from
    LEFT JOIN (SELECT ANY_VALUE(transfer_date) AS titransfer_date,BrandName AS tiBrandName,Commodity AS tiCommodity,SUM(Qty) as tiQty,transfer_to AS titransfer_to,GROUP_CONCAT(Remark_Item  SEPARATOR '   ') AS tiRemarks
    FROM transfer USE INDEX (transfer_to,transfer_date,BrandName,Commodity)";
    // LEFT JOIN (SELECT ANY_VALUE(Job_date) AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,SUM(WIP) as JWIP,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
    // FROM job USE INDEX (Location,Job_date,BrandName,Commodity)
        
   }else{
       $sqlA .=" GROUP BY  t.BrandName,t.Commodity,t.transfer_from) tbltransferLast
    ON  PoMst.BrandName=tbltransferLast.ttBrandName
    AND PoMst.Commodity=tbltransferLast.ttCommodity
    AND PoMst.Branch=tbltransferLast.tttransfer_from
    LEFT JOIN (SELECT ANY_VALUE(transfer_date) AS titransfer_date,BrandName AS tiBrandName,Commodity AS tiCommodity,SUM(Qty) as tiQty,transfer_to AS titransfer_to,GROUP_CONCAT(Remark_Item  SEPARATOR '   ') AS tiRemarks
    FROM transfer USE INDEX (transfer_to,transfer_date,BrandName,Commodity)";

   // LEFT JOIN (SELECT ANY_VALUE(Job_date) AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,SUM(WIP) as JWIP,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
   // FROM job USE INDEX (Location,Job_date,BrandName,Commodity)
   }

     //start transfer in 
     if(!empty($_POST['startDate']) && !empty($_POST['endDate'])){
      $fromDate =date("Y-m-d",strtotime($_POST['startDate']));
      $toDate   =date("Y-m-d",strtotime($_POST['endDate']));

      if( $Branches <> 1){
        $sqlA .=" AND  transfer.transfer_date BETWEEN '$fromDate' AND '$toDate'  ";
     }else{
        $sqlA .=" WHERE  transfer.transfer_date BETWEEN '$fromDate' AND '$toDate' ";
     }
      
      $sqlA .="  GROUP BY BrandName,Commodity,transfer_to) tbltransferin
      ON  PoMst.BrandName=tbltransferin.tiBrandName
      AND PoMst.Commodity=tbltransferin.tiCommodity
      AND PoMst.Branch=tbltransferin.titransfer_to
      LEFT JOIN (SELECT ANY_VALUE(ti.transfer_date) AS tittransfer_date,ti.BrandName AS titBrandName,ti.Commodity AS titCommodity,SUM(Qty) as titQty,ti.transfer_to AS tittransfer_to,GROUP_CONCAT(Remark_Item SEPARATOR '   ') AS titRemarks
       FROM transfer ti USE INDEX (transfer_to,transfer_date,BrandName,Commodity)";
     }else{
      $sqlA .=" GROUP BY BrandName,Commodity,transfer_to) tbltransferin
      ON  PoMst.BrandName=tbltransferin.tiBrandName
      AND PoMst.Commodity=tbltransferin.tiCommodity
      AND PoMst.Branch=tbltransferin.titransfer_to
      LEFT JOIN (SELECT ANY_VALUE(ti.transfer_date) AS tittransfer_date,ti.BrandName AS titBrandName,ti.Commodity AS titCommodity,SUM(Qty) as titQty,ti.transfer_to AS tittransfer_to,GROUP_CONCAT(Remark_Item SEPARATOR '   ') AS titRemarks
      FROM transfer ti USE INDEX (transfer_to,transfer_date,BrandName,Commodity) ";
     }

     if ($Branches <> 1) {
      $sqlA .=" WHERE ti.transfer_to='$Branches'";
    }
      // new
     if(!empty($_POST['startDate'])  && !empty($_POST['endDate'])) {
       $fromDate =date("Y-m-d",strtotime($_POST['startDate']));
       $toDate   =date("Y-m-d",strtotime($_POST['endDate']));

       if( $Branches <> 1){
            $sqlA .=" AND ti.transfer_date <= '$toDate' ";
         }else{
            $sqlA .=" WHERE  ti.transfer_date <= '$toDate' ";
         }

         $sqlA .=" GROUP BY ti.BrandName,ti.Commodity,ti.transfer_to) tbltransferinLast
    ON  PoMst.BrandName=tbltransferinLast.titBrandName
    AND PoMst.Commodity=tbltransferinLast.titCommodity
    AND PoMst.Branch=tbltransferinLast.tittransfer_to    
     LEFT JOIN (SELECT ANY_VALUE(Job_date) AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,SUM(WIP) as JWIP,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
     FROM job USE INDEX (Location,Job_date,BrandName,Commodity)";
        
   }else{
       $sqlA .=" GROUP BY  BrandName,Commodity,transfer_to) tbltransferinLast
    ON  PoMst.BrandName=tbltransferinLast.titBrandName
    AND PoMst.Commodity=tbltransferinLast.titCommodity
    AND PoMst.Branch=tbltransferinLast.tittransfer_to
    LEFT JOIN (SELECT ANY_VALUE(Job_date) AS Job_date,BrandName AS jBrandName,Commodity AS jCommodity,SUM(WIP) as JWIP,Location AS jLocation,GROUP_CONCAT(Remarks_Item  SEPARATOR '   ') AS jRemarks
    FROM job USE INDEX (Location,Job_date,BrandName,Commodity)";
   }

      //end transfer in


         //end for transfer
             
          if ($Branches <> 1) {
            $sqlA .=" WHERE job.Location='$Branches'";
          }
           if(!empty($_POST['startDate'])  && !empty($_POST['endDate'])) {
               if( $Branches <> 1){
                  $sqlA .=" AND ( Job_date BETWEEN '$fromDate' AND '$toDate' ) ";
               }else{
                  $sqlA .=" WHERE  Job_date BETWEEN '$fromDate' AND '$toDate' ";
               }
              $fromDate =date("Y-m-d",strtotime($_POST['startDate']));
              $toDate   =date("Y-m-d",strtotime($_POST['endDate']));
            $sqlA .=" GROUP BY Commodity,BrandName,Location) tblJob
          ON  PoMst.BrandName=tblJob.jBrandName
          AND PoMst.Commodity=tblJob.jCommodity
          AND PoMst.Branch=tblJob.jLocation   

          LEFT JOIN (SELECT ANY_VALUE(j.Job_date) AS jjJob_date, j.BrandName AS jjBrandName,j.Commodity AS jjCommodity,SUM(j.WIP) AS LastWIP,j.Location AS jjLocation
          FROM job j USE INDEX (Location,Job_date,BrandName,Commodity) ";

           }else{

             $sqlA .=" GROUP BY Commodity,BrandName,Location) tblJob
          ON  PoMst.BrandName=tblJob.jBrandName
          AND PoMst.Commodity=tblJob.jCommodity
          AND PoMst.Branch=tblJob.jLocation   

          LEFT JOIN (SELECT ANY_VALUE(j.Job_date) AS jjJob_date, j.BrandName AS jjBrandName,j.Commodity AS jjCommodity,SUM(j.WIP) AS LastWIP,j.Location AS jjLocation
          FROM job j USE INDEX (Location,Job_date,BrandName,Commodity)";  

           }
           // new start
           if ($Branches <> 1) {
            $sqlA .=" WHERE j.Location='$Branches'";
          }
            // new
           if(!empty($_POST['startDate'])  && !empty($_POST['endDate'])) {
             $fromDate =date("Y-m-d",strtotime($_POST['startDate']));
             $toDate   =date("Y-m-d",strtotime($_POST['endDate']));

             if( $Branches <> 1){
                  $sqlA .=" AND j.Job_date <= '$toDate' ";
               }else{
                  $sqlA .=" WHERE  j.Job_date <= '$toDate' ";
               }

               $sqlA .=" GROUP BY j.BrandName,j.Commodity,j.Location) tblJobLast
          ON  PoMst.BrandName=tblJobLast.jjBrandName
          AND PoMst.Commodity=tblJobLast.jjCommodity
          AND PoMst.Branch=tblJobLast.jjLocation
          LEFT JOIN (SELECT ANY_VALUE(Delivery_date) AS Delivery_date,BrandName AS dBrandName,Commodity AS dCommodity,SUM(Qty) as dQty,Location AS dLocation,GROUP_CONCAT(Remark_Item  SEPARATOR '   ') AS dRemarks
           FROM delivery USE INDEX (Location,Delivery_date,BrandName,Commodity)";
              
         }else{
             $sqlA .=" GROUP BY  BrandName,Commodity,Location) tblJobLast
          ON  PoMst.BrandName=tblJobLast.jjBrandName
          AND PoMst.Commodity=tblJobLast.jjCommodity
          AND PoMst.Branch=tblJobLast.jjLocation
          LEFT JOIN (SELECT ANY_VALUE(Delivery_date) AS Delivery_date,BrandName AS dBrandName,Commodity AS dCommodity,SUM(Qty) as dQty,Location AS dLocation,GROUP_CONCAT(Remark_Item  SEPARATOR '   ') AS dRemarks
          FROM delivery USE INDEX (Location,Delivery_date,BrandName,Commodity)";
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
            $sqlA .=" GROUP BY Commodity,BrandName,Location) tblDeli
          ON  PoMst.BrandName=tblDeli.dBrandName
          AND PoMst.Commodity=tblDeli.dCommodity
          AND PoMst.Branch=tblDeli.dLocation   

          LEFT JOIN (SELECT ANY_VALUE(d.Delivery_date) AS ddDelivery_date, d.BrandName AS ddBrandName,d.Commodity AS ddCommodity,SUM(d.Qty) AS ddQty,d.Location AS ddLocation,SUM(pd.USD * d.Qty) as pRate
          FROM delivery d  LEFT JOIN product pd ON pd.Purchase_order_No = d.PL AND pd.BrandName = d.BrandName AND pd.Commodity = d.Commodity AND pd.Branch = d.Location";

           }else{

             $sqlA .=" GROUP BY Commodity,BrandName,Location) tblDeli
          ON  PoMst.BrandName=tblDeli.dBrandName
          AND PoMst.Commodity=tblDeli.dCommodity
          AND PoMst.Branch=tblDeli.dLocation   

          LEFT JOIN (SELECT ANY_VALUE(d.Delivery_date) AS ddDelivery_date, d.BrandName AS ddBrandName,d.Commodity AS ddCommodity,SUM(d.Qty) AS ddQty,d.Location AS ddLocation,SUM(pd.USD * d.Qty) as pRate
          FROM delivery d  LEFT JOIN product pd ON pd.Purchase_order_No = d.PL AND pd.BrandName = d.BrandName AND pd.Commodity = d.Commodity AND pd.Branch = d.Location";

           }
           // new end
          
          if ($Branches <> 1) {
            $sqlA .=" WHERE d.Location='$Branches'";
          }

           if(!empty($_POST['startDate'])  && !empty($_POST['endDate'])) {
                 $fromDate =date("Y-m-d",strtotime($_POST['startDate']));
                 $toDate   =date("Y-m-d",strtotime($_POST['endDate']));

                if( $Branches <> 1){
                  $sqlA .=" AND d.Delivery_date <= '$toDate' ";
               }else{
                  $sqlA .=" WHERE d.Delivery_date <= '$toDate' ";
               }
          
          $sqlA .=" GROUP BY d.Commodity,d.BrandName,d.Location ) tblDeliLast 
          ON  PoMst.BrandName=tblDeliLast.ddBrandName
          AND PoMst.Commodity=tblDeliLast.ddCommodity
          AND PoMst.Branch=tblDeliLast.ddLocation 
          LEFT JOIN (SELECT ANY_VALUE(Return_date) AS Return_date,Commodity AS rCommodity,BrandName AS rBrandName,SUM(Qty) as returnrQty,department AS rDepartment
          ,GROUP_CONCAT(Remarks_item SEPARATOR ' ') AS rRemarks
          FROM returns USE INDEX (department,Return_date,BrandName,Commodity)"; 
           }else{

               $sqlA .=" GROUP BY d.Commodity,d.BrandName,d.Location) tblDeliLast 
          ON  PoMst.BrandName=tblDeliLast.ddBrandName
          AND PoMst.Commodity=tblDeliLast.ddCommodity
          AND PoMst.Branch=tblDeliLast.ddLocation  

          LEFT JOIN (SELECT ANY_VALUE(Return_date) AS Return_date,Commodity AS rCommodity,BrandName AS rBrandName,SUM(Qty) as returnrQty,department AS rDepartment,GROUP_CONCAT(Remarks_item SEPARATOR ' ') AS rRemarks
          FROM returns USE INDEX (department,Return_date,BrandName,Commodity)"; 

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
          $sqlA .="GROUP BY Commodity,BrandName,department) tblRet 
          ON  PoMst.BrandName=tblRet.rBrandName
          AND PoMst.Commodity=tblRet.rCommodity
          AND PoMst.Branch=tblRet.rDepartment 
          LEFT JOIN (SELECT ANY_VALUE(r.Return_date) AS rrReturn_date,r.Commodity AS rrCommodity,r.BrandName AS rrBrandName,SUM(r.Qty) AS returnrrQty,r.department AS rrDepartment,SUM(pr.USD * r.Qty) as rRate FROM returns r 
          LEFT JOIN product pr ON pr.Purchase_order_No = r.PL AND pr.BrandName = r.BrandName AND pr.Commodity = r.Commodity AND pr.Branch = r.department";
        }else{

           $sqlA .="GROUP BY Commodity,BrandName,department) tblRet 
          ON  PoMst.BrandName=tblRet.rBrandName
          AND PoMst.Commodity=tblRet.rCommodity
          AND PoMst.Branch=tblRet.rDepartment 
          LEFT JOIN (SELECT ANY_VALUE(r.Return_date) AS rrReturn_date,r.Commodity AS rrCommodity,r.BrandName AS rrBrandName,SUM(r.Qty) AS returnrrQty,r.department AS rrDepartment,SUM(pr.USD * r.Qty) as rRate FROM returns r 
          LEFT JOIN product pr ON pr.Purchase_order_No = r.PL AND pr.BrandName = r.BrandName AND pr.Commodity = r.Commodity AND pr.Branch = r.department";
        }
          
          if ($Branches <> 1) {
            $sqlA .=" WHERE r.department='$Branches'";
          }
          // end

       if(!empty($_POST['startDate'])  && !empty($_POST['endDate'])) {
              $fromDate =date("Y-m-d",strtotime($_POST['startDate']));
              $toDate   =date("Y-m-d",strtotime($_POST['endDate']));

              if( $Branches <> 1){
                  $sqlA .=" AND r.Return_date <= '$toDate' ";
               }else{
                  $sqlA .=" WHERE r.Return_date <= '$toDate' ";
               }

          $sqlA .=" GROUP BY r.Commodity,r.BrandName,r.department ) tblRetLast 
          ON  PoMst.BrandName=tblRetLast.rrBrandName
          AND PoMst.Commodity=tblRetLast.rrCommodity
          AND PoMst.Branch=tblRetLast.rrDepartment  
          WHERE 1=1 ";
        }else{
           $sqlA .=" GROUP BY r.Commodity,r.BrandName,r.department) tblRetLast 
          ON  PoMst.BrandName=tblRetLast.rrBrandName
          AND PoMst.Commodity=tblRetLast.rrCommodity
          AND PoMst.Branch=tblRetLast.rrDepartment  
          WHERE 1=1 ";
        }

        if ($Branches <> 1) {
            $sqlA .=" AND PoMst.Branch='$Branches'";
          }

          

       if(!empty($_POST['startDate'])  && !empty($_POST['endDate'])){
           $fromDate =date("Y-m-d",strtotime($_POST['startDate']));
           $toDate   =date("Y-m-d",strtotime($_POST['endDate']));
           $sqlA =$sqlA." AND (Packing_date BETWEEN '$fromDate' AND '$toDate' OR  return_date BETWEEN '$fromDate' AND '$toDate' OR Job_date BETWEEN '$fromDate' AND '$toDate' OR Delivery_date BETWEEN '$fromDate' AND '$toDate' OR Return_date BETWEEN '$fromDate' AND '$toDate')";
       } 
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
          PoMst.Branch
          HAVING
          COUNT(*) >= 1
          ORDER BY
          brandname.brandname         
          ";

 

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