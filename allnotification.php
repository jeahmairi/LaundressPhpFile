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
    $result['allnotif'] = array();
    $notification_Message = '';

        $db = DB::transact_db("SELECT *, CONCAT(lc.client_FName, ' ', lc.client_MidName, ' ', lc.client_LName) as name from notification n, laundry_client lc where lsp_ID = ? and n.client_ID = lc.client_ID ORDER BY n.notification_Message DESC",
								array($lsp_id ),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
            $index['client_ID'] = $dbs['client_ID'];
            $index['lsp_ID'] = $dbs['lsp_ID'];
            $index['trans_No'] = $dbs['trans_No']; 
            $index['notification_Message'] = $dbs['notification_Message']; 
            $index['client_name'] = $dbs['name']; 
            $index['fromtable'] = "Notification";
            //$notification_Message = $dbs['notification_Message'];
           // if($notification_Message=='Finished'){
                    $db4 = DB::transact_db("SELECT * FROM rating_handwasher where lsp_ID = ?",
                array($lsp_id),
                "SELECT"
                );
                if(count($db4)>0){
                    foreach($db4 as $db4s){
                    $index['rating_No'] = $db4s['rating_No']; 
                    $index['rating_Score'] = $db4s['rating_Score']; 
                    $index['rating_Comment'] = $db4s['rating_Comment']; 
                    $index['rating_Date'] = $db4s['rating_Date']; 
                    
                    }
                } array_push($result['allnotif'], $index); 
            //}
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