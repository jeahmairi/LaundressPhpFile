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
    $shop_ID=0;
    $handwasher_ID=0;
    $result['allbooking'] = array();
        $db = DB::transact_db("SELECT * from laundry_transaction lt, laundry_service_provider lsp where lt.trans_Status ='Accepted' and lt.lsp_ID = ? and lt.lsp_ID = lsp.lsp_ID",
								array($lsp_id ),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
            $index['trans_No'] = $dbs['trans_No'];
            $index['client_ID'] = $dbs['client_ID'];
            $index['lsp_ID'] = $dbs['lsp_ID'];  
            $index['handwasher_ID'] = $dbs['handwasher_ID']; 
            $index['trans_Service'] = $dbs['trans_Service']; 
            $index['trans_ExtService'] = $dbs['trans_ExtService']; 
            $index['trans_ServiceType'] = $dbs['trans_ServiceType'];
            $index['trans_EstWeight'] = $dbs['trans_EstWeight'];
            $index['trans_EstDateTime'] = $dbs['trans_EstDateTime'];
            $index['trans_DateOfRequest'] = $dbs['trans_DateOfRequest'];
            $index['trans_Status'] = $dbs['trans_Status'];
            $shop_ID= $dbs['shop_ID'];
            $handwasher_ID = $dbs['handwasher_ID']; 
            if($handwasher_ID!=0){
                $db3 = DB::transact_db("SELECT * from laundry_handwasher where handwasher_ID = ?",
                    array($handwasher_ID),
                    "SELECT"
                );
                if(count($db3)>0){
                    foreach($db3 as $db3s){
                    $index['handwasher_LName'] = $db3s['handwasher_LName']; 
                    $index['handwasher_Address'] = $db3s['handwasher_Address']; 
                    $index['handwasher_Contact'] = $db3s['handwasher_Contact']; 
                    //$index['shop_ContactNo1'] = $db3s['trans_ExtService']; 
                    }
                }
            }
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