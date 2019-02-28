<?php
error_reporting(E_ALL);

    $trans_No = $_POST['trans_No'];
    require_once ("db_connect.php");
    $result = array();
    $shop_ID=0;
    $handwasher_ID=0;
    $price = 0;
    $extraprice = 0;
    $result['allreceipt'] = array();
        $db = DB::transact_db("SELECT *, CONCAT(lc.client_FName, ' ' ,lc.client_MidName, ' ', lc.client_LName) as name FROM receipt r, laundry_service_provider lsp, laundry_client lc, laundry_transaction lt, laundry_service ls where r.trans_No = ? and r.lsp_ID = lsp.lsp_ID and r.client_ID = lc.client_ID and r.trans_No = lt.trans_No and lt.trans_No = ls.trans_No",
								array($trans_No),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
            $index['trans_No'] = $dbs['trans_No'];
            $index['client_ID'] = $dbs['client_ID'];
            $index['lsp_ID'] = $dbs['lsp_ID']; 
            $index['trans_EstWeight'] = $dbs['trans_EstWeight']; 
            $index['trans_EstDateTime'] = $dbs['trans_EstDateTime'];
            $index['trans_DateOfRequest'] = $dbs['trans_DateOfRequest'];
            $index['trans_Status'] = $dbs['trans_Status'];
            $index['name'] = $dbs['name'];
            $shop_ID= $dbs['shop_ID'];
            $handwasher_ID = $dbs['handwasher_ID']; 
            if($shop_ID!=0){
                $db2 = DB::transact_db("SELECT * from laundry_shop where shop_ID = ?",
                    array($shop_ID),
                    "SELECT"
                );
                if(count($db2)>0){
                    foreach($db2 as $db2s){
                    $index['washer_name'] = $db2s['shop_Name']; 
                    }
                }
            } else if($handwasher_ID!=0){
                $db3 = DB::transact_db("SELECT * from laundry_handwasher where handwasher_ID = ?",
                    array($handwasher_ID),
                    "SELECT"
                );
                if(count($db3)>0){
                    foreach($db3 as $db3s){
                    $index['washer_name'] = $db3s['handwasher_FName']." ".$db3s['handwasher_MidName']." ".$db3s['handwasher_LName']; 
                    //$index['shop_ContactNo1'] = $db3s['trans_ExtService']; 
                    }
                }
            }
            $index['prices'] = $dbs['receipt_AmountToPay'];  
            $index['date'] = $dbs['date_Issued'];          
            array_push($result['allreceipt'], $index); 
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

?>