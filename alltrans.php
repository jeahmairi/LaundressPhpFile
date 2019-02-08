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
        $db = DB::transact_db("SELECT * from laundry_transaction where trans_No = ?",
								array($trans_no ),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
            $index['trans_Service'] = $dbs['trans_Service'];
            $index['trans_ExtService'] = $dbs['trans_ExtService'];
            $index['trans_ServiceType'] = $dbs['trans_ServiceType']; 
            $index['trans_EstWeight'] = $dbs['trans_EstWeight']; 
            $index['trans_EstDateTime'] = $dbs['trans_EstDateTime']; 
            $index['trans_Status'] = $dbs['trans_Status'];
            array_push($result['allnotif'], $index); 
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
    }

?>