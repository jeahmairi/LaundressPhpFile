<?php
error_reporting(E_ALL);
if(!isset($_POST['trans_No'])) {
    $result['success'] = "0";
    $result['message'] = "error";
    echo json_encode($result);
    exit;
 } else {
     $trans_No = $_POST['trans_No'];
 }
 //$trans_No = 1;
    require_once ("db_connect.php");
    $result = array();
    $result['ShopLaundryDetails'] = array();
        $db = DB::transact_db("SELECT *,  ci.cinv_ItemDescription as description FROM laundry_details ld, client_inventory ci where ld.cinv_No = ci.cinv_No and ld.trans_No = ?",
								array($trans_No),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
            $index['cinv_ID'] = $dbs['cinv_No'];
            $index['detail_Count'] = $dbs['detail_Count'];
            $index['cinv_ItemTag'] = $dbs['cinv_Photo'];
            $index['description'] = $dbs['description'];
            array_push($result['ShopLaundryDetails'], $index); }
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