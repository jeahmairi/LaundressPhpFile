<?php
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD']=='POST') {
    if(!isset($_POST['handwasher_lspid'])) {
       $result['success'] = "0";
       $result['message'] = "error";
       echo json_encode($result);
       exit;
    } else {
        $handwasher_lspid = $_POST['handwasher_lspid'];
    }
    require_once ("db_connect.php");
    $result = array();
    $shop_ID=0;
    $handwasher_ID=0;
    $result['allbooking'] = array();
        $db = DB::transact_db("SELECT * , CONCAT(lh.client_FName, ' ',lh.client_MidName, ' ',lh.client_LName)AS name from laundry_transaction lt, laundry_service_provider lsp, laundry_client lh where lt.lsp_ID = ? and lt.trans_Status='Confirmed' and lt.lsp_ID = lsp.lsp_ID and lt.client_ID = lh.client_ID",
								array($handwasher_lspid),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
            $index['trans_No'] = $dbs['trans_No'];
            $index['client_ID'] = $dbs['client_ID'];
            $index['lsp_ID'] = $dbs['lsp_ID']; 
            $index['name'] = $dbs['name'];
            $index['client_Address'] = $dbs['client_Address']; 
            $index['client_Contact'] = $dbs['client_Contact']; 
            $index['trans_EstDateTime'] = $dbs['trans_EstDateTime'];
            $index['trans_DateOfRequest'] = $dbs['trans_DateOfRequest'];
            $index['trans_Status'] = $dbs['trans_Status'];
            $shop_ID= $dbs['shop_ID'];
            $handwasher_ID = $dbs['handwasher_ID'];                
            array_push($result['allbooking'], $index); 
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