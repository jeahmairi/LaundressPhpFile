<?php
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD']=='POST') {
    if(!isset($_POST['lspid'])) {
       $result['success'] = "0";
       $result['message'] = "error";
       echo json_encode($result);
       exit;
    } else {
        $lspid = $_POST['lspid'];
    }
    require_once ("db_connect.php");
    $result = array();
    $result['history'] = array();
        $db = DB::transact_db("SELECT *, CONCAT(lc.client_FName, ' ', lc.client_MidName, ' ', lc.client_LName) AS name FROM laundry_transaction lt, rating_handwasher r, laundry_client lc
        WHERE lt.trans_No = r.trans_No and lc.client_ID = lt.client_ID and lt.lsp_ID = ? ORDER BY lt.trans_No DESC",
								array($lspid ),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
            $index['rating_No'] = $dbs['rating_No'];
            $index['trans_No'] = $dbs['trans_No'];
            $index['date'] = $dbs['trans_DateOfRequest'];
            $index['weight'] = $dbs['trans_EstWeight']; 
            $index['rating_Score'] = $dbs['rating_Score']; 
            $index['rating_Comment'] = $dbs['rating_Comment']; 
            $index['rating_Date'] = $dbs['rating_Date'];
            $index['name'] = $dbs['name'];
            array_push($result['history'], $index); 
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