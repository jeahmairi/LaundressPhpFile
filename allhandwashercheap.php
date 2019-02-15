<?php
error_reporting(E_ALL);

    require_once ("db_connect.php");
    $result = array();
    $result['allhandwasher'] = array();
        $db = DB::transact_db("SELECT *, CONCAT(lh.handwasher_FName, ' ', lh.handwasher_MidName, ' ', lh.handwasher_LName) AS name, floor(datediff(CURRENT_DATE,lh.handwasher_BDate)/365) as age FROM laundry_handwasher lh, laundry_service_provider lsp, service s where lh.handwasher_ID = lsp.handwasher_ID and lsp.lsp_ID = s.lsp_ID GROUP BY lh.handwasher_ID ORDER BY s.service_Price",
								array(),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
      //SELECT lh.handwasher_ID, CONCAT(lh.handwasher_FName, ' ', lh.handwasher_MidName, ' ', lh.handwasher_LName) AS name, floor(datediff(CURRENT_DATE,lh.handwasher_BDate)/365) as age, lh.handwasher_CivilStatus, lh.handwasher_Address, lh.handwasher_Contact, lsp.lsp_ID as lsp_ID FROM laundry_handwasher lh, laundry_service_provider lsp where lh.handwasher_ID = lsp.handwasher_ID ORDER BY lh.handwasher_id
            $index['id'] = $dbs['handwasher_ID'];
            $index['name'] = $dbs['name'];
            $index['address'] = $dbs['handwasher_Address'];
            $index['contact'] = $dbs['handwasher_Contact'];
            $index['age'] = $dbs['age'];
            $index['civilstat'] = $dbs['handwasher_CivilStatus'];
            $index['lspid'] = $dbs['lsp_ID'];
            array_push($result['allhandwasher'], $index); }
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