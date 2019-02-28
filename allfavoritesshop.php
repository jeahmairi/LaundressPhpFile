<?php
error_reporting(E_ALL);

    require_once ("db_connect.php");
    $result = array();
    $shop_ID=0;
    $handwasher_ID=0;
    $client_id = $_POST['client_id'];
    //$client_id = 1;
    $result['alllaundryshop'] = array();
        $db = DB::transact_db("SELECT * FROM laundry_service_provider lsp, favorites f where lsp.lsp_ID = f.lsp_id and f.client_id = ?",
								array($client_id),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
                if($dbs['lsp_ID'] != null){
                    $index['lsp_ID'] = $dbs['lsp_ID'];
                } else {
                    $index['lsp_ID'] = 0;
                }
            
            $shop_ID= $dbs['shop_ID'];
            $handwasher_ID = $dbs['handwasher_ID']; 
            if($shop_ID!=0){
                $db2 = DB::transact_db("SELECT * from laundry_shop where shop_ID = ?",
                    array($shop_ID),
                    "SELECT"
                );
                if(count($db2)>0){
                    foreach($db2 as $db2s){
                    if($db2s['shop_ID'] != null) {
                        $index['id'] = $db2s['shop_ID'];
                    } else {
                        $index['id'] = 0;
                    }
                    $index['name'] = $db2s['shop_Name']; 
                    $index['address'] = $db2s['shop_Address']; 
                    $index['contact'] = $db2s['shop_ContactNo1']; 
                    $index['photo'] = $db2s['shop_Photo'];
                    $index['openhours'] = $db2s['shop_OpenHour'];
                    $index['closehours'] = $db2s['shop_CloseHour'];
                    $index['table'] = "from shop";
                    }
                }
            }
            array_push($result['alllaundryshop'], $index); }
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