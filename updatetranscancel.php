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
    $update = "Cancelled";
    $update2 = "Missed";
    $db =  DB::transact_db("update laundry_transaction set trans_Status = ? where trans_No = ?",
            array($update, $trans_no),
            "UPDATE");

    $db2 =  DB::transact_db("update notification set notification_Message = ? where trans_No = ?",
            array($update2, $trans_no),
            "UPDATE");
    $db3 =  DB::transact_db("delete from  laundry_details where trans_No = ?",
            array($trans_no),
            "UPDATE");
            $result['success'] = "1";
            $result['message'] = "success"; 
            echo json_encode($result);
    }

?>