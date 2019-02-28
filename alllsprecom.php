<?php
error_reporting(E_ALL);

    require_once ("db_connect.php");
    $result = array();
    $shop_ID=0;
    $lsp_ID=0;
    $handwasher_ID=0;
    $result['alllaundryshop'] = array();
        $db = DB::transact_db("SELECT * FROM laundry_service_provider lsp, rating_handwasher rh, rating_shop rs where lsp.lsp_ID = rh.lsp_ID OR lsp.lsp_ID = rs.lsp_ID",
								array(),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
            $index['lsp_ID'] = $dbs['lsp_ID'];
            $lsp_ID= $dbs['lsp_ID'];
            $shop_ID= $dbs['shop_ID'];
            $handwasher_ID = $dbs['handwasher_ID']; 
            if($shop_ID!=0){
                $db2 = DB::transact_db("SELECT *, AVG(rs.rating_Overall) as average, lsp.lsp_ID FROM laundry_shop ls, laundry_service_provider lsp, rating_shop rs where ls.shop_ID = lsp.shop_ID and lsp.lsp_ID = rs.lsp_ID and ls.shop_Status = 'A' and rs.lsp_ID = ? ORDER BY average",
                    array($lsp_ID),
                    "SELECT"
                );
                if(count($db2)>0){
                    foreach($db2 as $db2s){
                    $index['id'] = $db2s['shop_ID'];
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
                $db3 = DB::transact_db("SELECT *, lh.handwasher_ID, CONCAT(lh.handwasher_FName, ' ', lh.handwasher_MidName, ' ', lh.handwasher_LName) AS name, floor(datediff(CURRENT_DATE,lh.handwasher_BDate)/365) as age, lh.handwasher_CivilStatus, lh.handwasher_Address, lh.handwasher_Contact, lsp.lsp_ID as lsp_ID, AVG(rh.rating_No) as average FROM laundry_handwasher lh, laundry_service_provider lsp, rating_handwasher rh where lh.handwasher_ID = lsp.handwasher_ID and rh.lsp_ID = lsp.lsp_ID and lh.handwasher_Status ='A' and rh.lsp_ID = ? ORDER BY average",
                    array($lsp_ID),
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