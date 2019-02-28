<?php
error_reporting(E_ALL);
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
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
    $result['allhandwasher'] = array();
        $db = DB::transact_db("SELECT AVG(rh.rating_Overall) as rate FROM laundry_shop ls, laundry_service_provider lsp, rating_handwasher rh where ls.shop_ID = lsp.shop_ID AND rh.lsp_ID = lsp.lsp_ID AND lsp.lsp_ID = ? ORDER BY ls.shop_ID",
								array($lsp_id),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
            if($dbs['rate']==null){
                $index['rate'] = 0.0;
            } else{
                $index['rate'] = $dbs['rate'];
            }
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

    }
?>