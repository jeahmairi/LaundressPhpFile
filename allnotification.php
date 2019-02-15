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
    $rate_no = '';
        $db = DB::transact_db("SELECT *, CONCAT(lc.client_FName, ' ', lc.client_MidName, ' ', lc.client_LName) as name from notification n, laundry_client lc where n.lsp_ID = ? and n.client_ID = lc.client_ID ORDER BY n.notification_No DESC",
								array($lsp_id ),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
            $index['client_ID'] = $dbs['client_ID'];
            $index['lsp_ID'] = $dbs['lsp_ID'];
            $index['client_Photo'] = $dbs['client_Photo'];
            $index['trans_No'] = $dbs['trans_No']; 
            $index['notification_Message'] = $dbs['notification_Message']; 
            $index['client_name'] = $dbs['name']; 
            $index['fromtable'] = "Notification";
            $rate_no = $dbs['rating_Nohw'];
            if($rate_no!=0 && $dbs['notification_Message']=="Finished"){
                $db2 = DB::transact_db("SELECT * from rating_handwasher where rating_No = ?",
                    array($rate_no),
                    "SELECT"
                );
                if(count($db2)>0){
                    foreach($db2 as $db2s){
                        $index['rating_No'] = $db2s['rating_No']; 
                        $index['rating_Score'] = $db2s['rating_Accommodation']; 
                        $index['rating_Comment'] = $db2s['rating_Comment']; 
                        $index['rating_Date'] = $db2s['rating_Date']; 
                    }
            }
            }
            array_push($result['allnotif'], $index); 
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