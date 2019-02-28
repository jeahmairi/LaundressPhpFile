<?php
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD']=='POST') {
    if(!isset($_POST['trans_no'])) {
       $result['success'] = "0";
       $result['message'] = "error";
       echo json_encode($result);
       exit;
    } else {
        $trans_no = $_POST['trans_no'];
    }
    require_once ("db_connect.php");
    $result = array();
    $result['allnotif'] = array();
    $update = "Accepted";
    $update2 = "Approved";
    $date = date('Y-m-d');
    $db =  DB::transact_db("update laundry_transaction set trans_Status = ?, trans_DateLodge = ? where trans_No = ?",
            array($update, $date, $trans_no),
            "UPDATE");

    $db2 =  DB::transact_db("update notification set notification_Message = ? where trans_No = ?",
            array($update2, $trans_no),
            "UPDATE");
    $db3 =  DB::transact_db("update laundry_details set detail_status = ? where trans_No = ?",
            array($update2, $trans_no),
            "UPDATE");
            $result['success'] = "1";
            $result['message'] = "success"; 
            echo json_encode($result);
    }

?>