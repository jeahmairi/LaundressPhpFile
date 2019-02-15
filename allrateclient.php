<?php
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD']=='POST') {
    if(!isset($_POST['client_id'])) {
       $result['success'] = "0";
       $result['message'] = "error";
       echo json_encode($result);
       exit;
    } else {
        $client_id = $_POST['client_id'];
    }
    require_once ("db_connect.php");
    $result = array();
    $result['allrate'] = array();
    $handwasher_ID = 0;
    $shop_ID = 0;
        $db = DB::transact_db("SELECT * from rating_handwasher rh, laundry_service_provider lsp, laundry_client lc where rh.client_ID = ? and rh.lsp_ID = lsp.lsp_ID and rh.client_ID = lc.client_ID ORDER BY rh.rating_No DESC",
								array($client_id ),
								"SELECT"
                            );
        $db7 = DB::transact_db("SELECT *, AVG(r.rating_Score) as average from rating r, laundry_service_provider lsp, laundry_client lc where r.client_ID = ? and r.lsp_ID = lsp.lsp_ID and r.client_ID = lc.client_ID ORDER BY r.rating_No DESC",
                            array($client_id ),
                            "SELECT"
                        );                    
        if(count($db) > 0) {
            foreach($db as $dbs){
            $index['rating_No'] = $dbs['rating_No'];
            $index['shop_ID'] = $dbs['shop_ID'];
            $index['client_Photo'] = $dbs['client_Photo'];
            $index['handwasher_ID'] = $dbs['handwasher_ID']; 
            $index['rating_Accommodation'] = $dbs['rating_Accommodation']; 
            $index['rating_QualityService'] = $dbs['rating_QualityService']; 
            $index['rating_Ontime'] = $dbs['rating_Ontime']; 
            $index['rating_Overall'] = $dbs['rating_Overall']; 
            $index['rating_Comment'] = $dbs['rating_Comment']; 
            $index['rating_Date'] = $dbs['rating_Date'];
            //$index['average'] = $dbs['average'];
            $handwasher_ID =$dbs['handwasher_ID'];
            $shop_ID =$dbs['shop_ID'];
            if($shop_ID!=0){
                $db2 = DB::transact_db("SELECT * from laundry_shop where shop_ID = ?",
                    array($shop_ID),
                    "SELECT"
                );
                if(count($db2)>0){
                    foreach($db2 as $db2s){
                    $index['name'] = $db2s['shop_Name'];
                    }
                }
            } else if($handwasher_ID!=0){
                $db3 = DB::transact_db("SELECT CONCAT(handwasher_FName, ' ',handwasher_MidName, ' ',handwasher_LName)AS name, handwasher_Address,handwasher_Contact  from laundry_handwasher where handwasher_ID = ?",
                    array($handwasher_ID),
                    "SELECT"
                );
                if(count($db3)>0){
                    foreach($db3 as $db3s){
                    $index['name'] = $db3s['name'];
                    //$index['shop_ContactNo1'] = $db3s['trans_ExtService']; 
                    }
                }
            }
            if(count($db7) > 0){
                foreach($db7 as $db7s){
                    $index['average'] = $db7s['average'];
                   
                }     
            } 
           array_push($result['allrate'], $index); 
        }
            
            $result['success'] = "1";
            $result['message'] = "success"; 
            echo json_encode($result);
        } 
        
       else {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
       }
}

?>