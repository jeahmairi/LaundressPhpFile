<?php
error_reporting(E_ALL);
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
    $result['allclientbooking'] = array();
        $db = DB::transact_db("SELECT CONCAT(lc.client_FName,' ', lc.client_MidName,' ',lc.client_LName) AS name, COUNT(lt.client_ID) as bookings, AVG(rh.rating_Score) as rate from laundry_transaction lt, rating_handwasher rh, laundry_client lc where lt.trans_No = rh.trans_No and lt.client_ID = lc.client_ID and lt.trans_Status='Finished' and lt.lsp_ID = ?",
								array($lsp_id),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){ 
            $index['name'] = $dbs['name'];
            $index['bookings'] = $dbs['bookings'];
            if($dbs['rate']==null){
                $index['rate'] = 0.0;
            } else{
                $index['rate'] = $dbs['rate'];
            }
            array_push($result['allclientbooking'], $index); }
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


?>