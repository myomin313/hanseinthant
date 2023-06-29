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
fputcsv($output,  array('Branch','BrandName','Commodity','Input','WIP','Delivery','Return','Remark','','','','Total Stock','Current Stock','TotalUSD','NetUSD'));  
}
else{
fputcsv($output,  array('Branch','BrandName','Commodity','Input','WIP','Delivery','Return','Remark','','','','Total Stock','Current Stock'));    
}
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
if ($Authority == 'Accountant') {     
if ($Branches == 'Shwe Pyi Thar Store') {
           $sql="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,   
           
           (SELECT SUM(r.Qty) 
           FROM returns as r  WHERE returns.Commodity = r.Commodity and returns.BrandName = r.BrandName and delivery.BrandName = r.BrandName and delivery.Commodity = r.Commodity and delivery.Location = returns.department and delivery.DO_No = r.DO_No and returns.DO_No = r.DO_No ) AS  rQty,                         
 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '    ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '    ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,  

           (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '    ') AS ss
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,               

           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '    ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,  

           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty, 
           
           (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty,                  

           (SELECT SUM(s.totalUSD) 
           FROM product as s  WHERE product.Commodity = s.Commodity and product.BrandName = s.BrandName and product.Branch = s.Branch  )  as totalUSDs,

           (SELECT SUM(p.balanceUSD)            
           FROM product as p  WHERE product.Commodity = p.Commodity and product.BrandName = p.BrandName and product.Branch = p.Branch  )  as balancetotalUSD

            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No  
            
            Where product.Branch='Shwe Pyi Thar Store'
           GROUP BY product.BrandName,product.Commodity,product.Branch
          
            ";
          }
elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {

           $sql="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,   
           
           (SELECT SUM(r.Qty) 
           FROM returns as r  WHERE returns.Commodity = r.Commodity and returns.BrandName = r.BrandName and delivery.BrandName = r.BrandName and delivery.Commodity = r.Commodity and delivery.Location = returns.department and delivery.DO_No = r.DO_No and returns.DO_No = r.DO_No ) AS  rQty,                         
 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '    ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '    ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,   

           (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '    ') AS ss
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,              

           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '    ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,  


           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty,
           
            (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty,                 

           (SELECT SUM(s.totalUSD) 
           FROM product as s  WHERE product.Commodity = s.Commodity and product.BrandName = s.BrandName and product.Branch = s.Branch  )  as totalUSDs,

           (SELECT SUM(p.balanceUSD)            
           FROM product as p  WHERE product.Commodity = p.Commodity and product.BrandName = p.BrandName and product.Branch = p.Branch  )  as balancetotalUSD

            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No  
            
            Where product.Branch='Shwe Pyi Thar Store Control Panel'
           GROUP BY product.BrandName,product.Commodity,product.Branch
          
            ";
          }
elseif ($Branches == 'Yangon Show Room') {

           $sql="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,   
           
           (SELECT SUM(r.Qty) 
           FROM returns as r  WHERE returns.Commodity = r.Commodity and returns.BrandName = r.BrandName and delivery.BrandName = r.BrandName and delivery.Commodity = r.Commodity and delivery.Location = returns.department and delivery.DO_No = r.DO_No and returns.DO_No = r.DO_No ) AS  rQty,                         

 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '    ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '    ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,    

           (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '    ') AS ss
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,             

           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '    ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,  


           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty,   
           
           (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty,                  

           (SELECT SUM(s.totalUSD) 
           FROM product as s  WHERE product.Commodity = s.Commodity and product.BrandName = s.BrandName and product.Branch = s.Branch  )  as totalUSDs,

           (SELECT SUM(p.balanceUSD)            
           FROM product as p  WHERE product.Commodity = p.Commodity and product.BrandName = p.BrandName and product.Branch = p.Branch  )  as balancetotalUSD

            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No  
            
            Where product.Branch='Yangon Show Room'
           GROUP BY product.BrandName,product.Commodity,product.Branch
          
            ";
          }
elseif ($Branches == 'Naypyidaw Show Room') {

           $sql="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,   
           
           (SELECT SUM(r.Qty) 
           FROM returns as r  WHERE returns.Commodity = r.Commodity and returns.BrandName = r.BrandName and delivery.BrandName = r.BrandName and delivery.Commodity = r.Commodity and delivery.Location = returns.department and delivery.DO_No = r.DO_No and returns.DO_No = r.DO_No ) AS  rQty,                         

 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '    ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '    ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,   

            (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '    ') AS ss
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,             

           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '    ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,  


           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty,        
           
           (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty,                  

           (SELECT SUM(s.totalUSD) 
           FROM product as s  WHERE product.Commodity = s.Commodity and product.BrandName = s.BrandName and product.Branch = s.Branch  )  as totalUSDs,

           (SELECT SUM(p.balanceUSD)            
           FROM product as p  WHERE product.Commodity = p.Commodity and product.BrandName = p.BrandName and product.Branch = p.Branch  )  as balancetotalUSD
            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No  
            
            Where product.Branch='Naypyidaw Show Room'
           GROUP BY product.BrandName,product.Commodity,product.Branch
          
            ";
          }   
elseif ($Branches == 'Mandalay Show Room') {

           $sql="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,   
           
           (SELECT SUM(r.Qty) 
           FROM returns as r  WHERE returns.Commodity = r.Commodity and returns.BrandName = r.BrandName and delivery.BrandName = r.BrandName and delivery.Commodity = r.Commodity and delivery.Location = returns.department and delivery.DO_No = r.DO_No and returns.DO_No = r.DO_No ) AS  rQty,                         

 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '    ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '    ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,  


           (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '    ') AS ss
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,  

           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '    ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,  


           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty,       
           
           (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty,       
           
           (SELECT SUM(s.totalUSD) 
           FROM product as s  WHERE product.Commodity = s.Commodity and product.BrandName = s.BrandName and product.Branch = s.Branch  )  as totalUSDs,

           (SELECT SUM(p.balanceUSD)            
           FROM product as p  WHERE product.Commodity = p.Commodity and product.BrandName = p.BrandName and product.Branch = p.Branch  )  as balancetotalUSD

            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No  
            
            Where product.Branch='Mandalay Show Room'
           GROUP BY product.BrandName,product.Commodity,product.Branch
          
            ";
          } 
else{

           $sql="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,   
           
           (SELECT SUM(r.Qty) 
           FROM returns as r  WHERE returns.Commodity = r.Commodity and returns.BrandName = r.BrandName and delivery.BrandName = r.BrandName and delivery.Commodity = r.Commodity and delivery.Location = returns.department and delivery.DO_No = r.DO_No and returns.DO_No = r.DO_No ) AS  rQty,                         

 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '    ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '    ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,  

           (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '    ') AS ss
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,  


           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '    ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,  


           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty,    
           
           (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty,       
           
           (SELECT SUM(s.totalUSD) 
           FROM product as s  WHERE product.Commodity = s.Commodity and product.BrandName = s.BrandName and product.Branch = s.Branch  )  as totalUSDs,

           (SELECT SUM(p.balanceUSD)            
           FROM product as p  WHERE product.Commodity = p.Commodity and product.BrandName = p.BrandName and product.Branch = p.Branch  )  as balancetotalUSD



            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No  
            
            Where 1=1
           GROUP BY product.BrandName,product.Commodity,product.Branch
          
            ";
          }  
}

else{

if ($Branches == 'Shwe Pyi Thar Store') {
           $sql="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,   
           
           (SELECT SUM(r.Qty) 
           FROM returns as r  WHERE returns.Commodity = r.Commodity and returns.BrandName = r.BrandName and delivery.BrandName = r.BrandName and delivery.Commodity = r.Commodity and delivery.Location = returns.department and delivery.DO_No = r.DO_No and returns.DO_No = r.DO_No ) AS  rQty,                         

 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '    ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '    ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,   

           (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '    ') AS ss
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,              

           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '    ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,  


           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty,
           
           (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty     

            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No  
            
            Where product.Branch='Shwe Pyi Thar Store'
           GROUP BY product.BrandName,product.Commodity,product.Branch
          
            ";
          }
elseif ($Branches == 'Shwe Pyi Thar Store Control Panel') {

           $sql="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,   
           
           (SELECT SUM(r.Qty) 
           FROM returns as r  WHERE returns.Commodity = r.Commodity and returns.BrandName = r.BrandName and delivery.BrandName = r.BrandName and delivery.Commodity = r.Commodity and delivery.Location = returns.department and delivery.DO_No = r.DO_No and returns.DO_No = r.DO_No ) AS  rQty,                         

 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '    ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '    ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,  

           (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '    ') AS ss
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,               

           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '    ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,  


           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty,
           
           (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty     


            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No  
            
            Where product.Branch='Shwe Pyi Thar Store Control Panel'
           GROUP BY product.BrandName,product.Commodity,product.Branch
          
            ";
          }
elseif ($Branches == 'Yangon Show Room') {

           $sql="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,   
           
           (SELECT SUM(r.Qty) 
           FROM returns as r  WHERE returns.Commodity = r.Commodity and returns.BrandName = r.BrandName and delivery.BrandName = r.BrandName and delivery.Commodity = r.Commodity and delivery.Location = returns.department and delivery.DO_No = r.DO_No and returns.DO_No = r.DO_No ) AS  rQty,                         

 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '    ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '    ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,    

           (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '    ') AS ss
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,  

           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '    ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,  


           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty,

           (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty     

            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No  
            
            Where product.Branch='Yangon Show Room'
           GROUP BY product.BrandName,product.Commodity,product.Branch
          
            ";
          }
elseif ($Branches == 'Naypyidaw Show Room') {

           $sql="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,   
           
           (SELECT SUM(r.Qty) 
           FROM returns as r  WHERE returns.Commodity = r.Commodity and returns.BrandName = r.BrandName and delivery.BrandName = r.BrandName and delivery.Commodity = r.Commodity and delivery.Location = returns.department and delivery.DO_No = r.DO_No and returns.DO_No = r.DO_No ) AS  rQty,                         

 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '    ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '    ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,    

           (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '    ') AS ss
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,             

           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '    ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,  ,


           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty,

           (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty     
           
            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No  
            
            Where product.Branch='Naypyidaw Show Room'
           GROUP BY product.BrandName,product.Commodity,product.Branch
          
            ";
          }   
elseif ($Branches == 'Mandalay Show Room') {

           $sql="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,   
           
           (SELECT SUM(r.Qty) 
           FROM returns as r  WHERE returns.Commodity = r.Commodity and returns.BrandName = r.BrandName and delivery.BrandName = r.BrandName and delivery.Commodity = r.Commodity and delivery.Location = returns.department and delivery.DO_No = r.DO_No and returns.DO_No = r.DO_No ) AS  rQty,                         
 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '    ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '    ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,   

           (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '    ') AS ss
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,              

           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '    ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,  


           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty,
           
           (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty     


            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No  
            
            Where product.Branch='Mandalay Show Room'
           GROUP BY product.BrandName,product.Commodity,product.Branch
          
            ";
          } 
else{

           $sql="SELECT 
           product.Branch as Branch,product.BrandName as pbrand,product.Commodity as pCommodity,
           (SELECT SUM(g.Qty) 
           FROM product as g  WHERE product.Commodity =g.Commodity  and product.BrandName =g.BrandName and product.Branch = g.Branch )  as pQty,  

           (SELECT SUM(t.balanceWIP) 
           FROM product as t  WHERE product.Commodity = t.Commodity and product.BrandName = t.BrandName and product.Branch = t.Branch )  as wip,

           (SELECT SUM(y.balanceDelivery) 
           FROM product as y  WHERE product.Commodity = y.Commodity and product.BrandName = y.BrandName and product.Branch = y.Branch )  as balanceDelivery,   
           
           (SELECT SUM(r.Qty) 
           FROM returns as r  WHERE returns.Commodity = r.Commodity and returns.BrandName = r.BrandName and delivery.BrandName = r.BrandName and delivery.Commodity = r.Commodity and delivery.Location = returns.department and delivery.DO_No = r.DO_No and returns.DO_No = r.DO_No ) AS  rQty,                         

 
           (SELECT GROUP_CONCAT(pp.Remarks_Item  SEPARATOR '    ') AS dd
           FROM product as pp  WHERE product.Commodity = pp.Commodity and product.BrandName = pp.BrandName and product.Branch = pp.Branch)  as pRemarks,    

           (SELECT GROUP_CONCAT(jj.Remarks_Item  SEPARATOR '    ') AS ss
           FROM job as jj  WHERE job.Commodity = jj.Commodity and job.BrandName = jj.BrandName and job.Location = jj.Location)  as jRemarks,   

           (SELECT GROUP_CONCAT(ddd.Remark_item  SEPARATOR '    ') AS ss
           FROM delivery as ddd  WHERE delivery.Commodity = ddd.Commodity and delivery.BrandName = ddd.BrandName and delivery.Location = ddd.Location)  as dRemarks,              

           (SELECT GROUP_CONCAT(rr.Remarks_item  SEPARATOR '    ') AS rr
           FROM returns as rr  WHERE returns.Commodity = rr.Commodity and returns.BrandName = rr.BrandName and returns.department = rr.department)  as rRemarks,  


           (SELECT SUM(h.balanceQty) 
           FROM product as h  WHERE product.Commodity = h.Commodity and product.BrandName = h.BrandName and product.Branch = h.Branch  )  as balanceQty,
           
           (SELECT SUM(eh.currentQty) 
           FROM product as eh  WHERE product.Commodity = eh.Commodity and product.BrandName = eh.BrandName and product.Branch = eh.Branch  )  as currentQty     

            From product           

            Left join job 
            on job.Commodity = product.Commodity 
            and job.BrandName = product.BrandName
            and job.Location = product.Branch  
 
            Left join delivery 
            on delivery.Commodity = product.Commodity 
            and delivery.BrandName = product.BrandName   
            and delivery.Location = product.Branch  

            Left join returns 
            on returns.Commodity = delivery.Commodity 
            and returns.BrandName = delivery.BrandName
            and returns.department = delivery.Location
            and returns.DO_No = delivery.DO_No  
            
            Where 1=1
           GROUP BY product.BrandName,product.Commodity,product.Branch
          
            ";
          }   


}     
// echo $sql;                     
$rows = $con->query($sql);
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