<?php
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD']=='POST') {
    if(!isset($_POST['lsp_id'])) {
       $result['success'] = "0";
       $result['message'] = "error";
       echo json_encode($result);
       exit;
    } else {
        $lsp_id = $_POST['lsp_id'];
    }
    require_once ("db_connect.php");
    $result = array();
    $result['allrate'] = array();
        $db = DB::transact_db("SELECT *, CONCAT(lc.client_FName, ' ', lc.client_MidName, ' ', lc.client_LName) AS name from laundry_service_provider lsp, rating rh, laundry_client lc, laundry_handwasher lh where rh.lsp_ID =? and rh.client_ID = lc.client_ID and lsp.handwasher_ID = lh.handwasher_ID and lsp.lsp_ID = rh.lsp_ID ORDER BY rh.rating_No DESC",
								array($lsp_id),
								"SELECT"
                            );
        $db7 = DB::transact_db("SELECT *, AVG(r.rating_Accommodation) as accommodation, AVG(r.rating_QualityService) as quality,AVG(r.rating_Ontime) as ontime,AVG(r.rating_Overall) as overall from rating_handwasher r, laundry_service_provider lsp, laundry_client lc where r.lsp_ID = ? and r.lsp_ID = lsp.lsp_ID and r.client_ID = lc.client_ID ORDER BY r.rating_No DESC",
                            array($lsp_id ),
                            "SELECT"
                        );      
        if(count($db) > 0) {
            foreach($db as $dbs){
            $index['rating_No'] = $dbs['rating_No'];
            $index['rating_Score'] = $dbs['rating_Score']; 
            $index['rating_Comment'] = $dbs['rating_Comment']; 
            $index['rating_Date'] = $dbs['rating_Date'];
            $index['handwasher_Photo'] = $dbs['handwasher_Photo'];
            $index['name'] = $dbs['name'];
        
            if(count($db7) > 0){
                foreach($db7 as $db7s){
                    if($db7s['accommodation']==null){
                        $index['rating_Accommodation'] = 0.0;
                    } else{
                        $index['rating_Accommodation'] = $db7s['accommodation'];
                    }
                    if($db7s['quality']==null){
                        $index['rating_QualityService'] = 0.0;
                    } else{
                        $index['rating_QualityService'] = $db7s['quality'];
                    }
                    if($db7s['ontime']==null){
                        $index['rating_Ontime'] = 0.0;
                    } else{
                        $index['rating_Ontime'] = $db7s['ontime'];
                    }
                    if($db7s['overall']==null){
                        $index['rating_Overall'] = 0.0;
                    } else{
                        $index['rating_Overall'] = $db7s['overall'];
                    }                 
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