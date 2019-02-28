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
            } else if($handwasher_ID!=0){
                $db3 = DB::transact_db("SELECT CONCAT(handwasher_FName, ' ',handwasher_MidName, ' ',handwasher_LName)AS name, handwasher_Address,handwasher_Contact, handwasher_Photo, handwasher_ID from laundry_handwasher where handwasher_ID = ?",
                    array($handwasher_ID),
                    "SELECT"
                );
                if(count($db3)>0){
                    foreach($db3 as $db3s){
                    $index['id'] = $db3s['handwasher_ID'];
                    $index['name'] = $db3s['name']; 
                    $index['address'] = $db3s['handwasher_Address']; 
                    $index['contact'] = $db3s['handwasher_Contact']; 
                    $index['photo'] = $db3s['handwasher_Photo'];
                    $index['openhours'] = null;
                    $index['closehours'] = null;
                    $index['table'] = "from handwasher";
                    //$index['shop_ContactNo1'] = $db3s['trans_ExtService']; 
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