<?php
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD']=='POST') {
    if(!isset($_POST['trans_No'])) {
       $result['success'] = "0";
       $result['message'] = "error";
       echo json_encode($result);
       exit;
    } else {
        $trans_no = $_POST['trans_No'];
    }
    require_once ("db_connect.php");
    $result = array();
    $result['allnotif'] = array();
    $update = "Confirmed";
    $update2 = "Confirmed";
    $date = date('Y-m-d');
    $cinv_id = json_decode($_POST['cinv_id'], true);
    foreach($cinv_id as $cinv_ids){
        $db =  DB::transact_db("update laundry_details set detail_status = ? where cinv_No = ? and trans_No = ?",
        array($update, $cinv_ids['cinvid'], $trans_no),
        "UPDATE");
    }
    $db =  DB::transact_db("update laundry_transaction set trans_Status = ?, trans_DateLaundry = ? where trans_No = ?",
                array($update, $date, $trans_no),
                "UPDATE");
    $db2 =  DB::transact_db("update notification set notification_Message = ? where trans_No = ?",
            array($update2, $trans_no),
            "UPDATE");
            $result['success'] = "1";
            $result['message'] = "success"; 
            echo json_encode($result);
    }

?>