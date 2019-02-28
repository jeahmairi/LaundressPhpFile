<?php
error_reporting(E_ALL);

    require_once ("db_connect.php");
    $result = array();
    $result['alllaundryshop'] = array();
        $db = DB::transact_db("SELECT *, AVG(rs.rating_Overall) as average, lsp.lsp_ID FROM laundry_shop ls, laundry_service_provider lsp, rating_shop rs where ls.shop_ID = lsp.shop_ID and lsp.lsp_ID = rs.lsp_ID and ls.shop_Status = 'A' ORDER BY average",
								array(),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
                if($dbs['shop_ID'] != null){
                    $index['id'] = $dbs['shop_ID'];
                } else {
                    $index['id'] = 0;
                }
            //$index['id'] = $dbs['shop_ID'];
            $index['name'] = $dbs['shop_Name'];
            $index['address'] = $dbs['shop_Address'];
            $index['contact'] = $dbs['shop_ContactNo1'];
            $index['openhours'] = $dbs['shop_OpenHour'];
            $index['closehours'] = $dbs['shop_CloseHour'];
            $index['average'] = $dbs['average'];
            $index['table'] = "from shop";
            if($dbs['lsp_ID'] != null){
                $index['lsp_ID'] = $dbs['lsp_ID'];
            } else {
                $index['lsp_ID'] = 0;
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