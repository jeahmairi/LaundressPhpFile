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
        $db = DB::transact_db("SELECT * FROM laundry_transaction lt, laundry_service ls where lt.trans_No = ? and lt.trans_No = ls.trans_No GROUP By lt.trans_No",
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
            $index['seroffer_ID'] = $dbs['seroffer_ID'];
            $index['extraserv_ID'] = $dbs['extraserv_ID'];
            $db2 = DB::transact_db("SELECT * FROM laundry_service ls, services_offered so where ls.trans_No = ? and ls.seroffer_ID = so.seroffer_ID GROUP BY so.seroffer_ID",
								array($trans_No),
								"SELECT"
                            );
            if(count($db2)>0){
                foreach($db2 as $db2s){
                    if($db2s['service_offered_uom']=="per Bundle"){
                        $price = $db2s['service_offered_price'];
                    } else {
                        $price = $dbs['trans_EstWeight'] * $db2s['service_offered_price'];
                    }
                }
                
            }
            $db3 = DB::transact_db("SELECT * FROM laundry_service ls, extra_services so where ls.trans_No = ? and ls.extraserv_ID = so.extraserv_ID",
								array($trans_No),
								"SELECT"
                            );
            if(count($db3)>0){
                foreach($db3 as $db3s){
                    if($db3s['extra_service_uom']=="Additional per Kilo"){
                        $extraprice = $extraprice + ($db3s['extra_service_price']*$dbs['trans_EstWeight'] );
                    } else{$extraprice = $extraprice + $db3s['extra_service_price'];}
                
                }
                
            }
            $index['prices'] = $price + $extraprice;             
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