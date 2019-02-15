<?php
error_reporting(E_ALL);

    require_once ("db_connect.php");
    $result = array();
    $result['alllaundryshop'] = array();
        $db = DB::transact_db("SELECT *, AVG(rs.rating_Score) as average, lsp.lsp_ID FROM laundry_shop ls, laundry_service_provider lsp, rating_shop rs where ls.shop_ID = lsp.shop_ID and lsp.lsp_ID = rs.lsp_ID ORDER BY average",
								array(),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
      
            $index['id'] = $dbs['shop_ID'];
            $index['name'] = $dbs['shop_Name'];
            $index['address'] = $dbs['shop_Address'];
            $index['contact'] = $dbs['shop_ContactNo1'];
            $index['openhours'] = $dbs['shop_OpenHour'];
            $index['closehours'] = $dbs['shop_CloseHour'];
            $index['lsp_ID'] = $dbs['lsp_ID'];
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