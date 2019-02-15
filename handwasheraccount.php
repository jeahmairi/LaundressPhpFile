<?php
error_reporting(E_ALL);
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        if(!isset($_POST['handwasher_id'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $handwasher_id = $_POST['handwasher_id'];
        }
        require_once ("db_connect.php");
        $result = array();
        $result['handwasher'] = array();
            $db = DB::transact_db("SELECT *  FROM laundry_handwasher where handwasher_ID = ?  ORDER BY handwasher_ID",
                                array($handwasher_id ),
                                    "SELECT"
                                );
            if(count($db) > 0) {
                foreach($db as $dbs){
                $index['handwasher_FName'] = $dbs['handwasher_FName'];
                $index['handwasher_MidName'] = $dbs['handwasher_MidName'];
                $index['handwasher_LName'] = $dbs['handwasher_LName'];
                $index['handwasher_Address'] = $dbs['handwasher_Address'];
                $index['handwasher_BDate'] = $dbs['handwasher_BDate'];
                $index['handwasher_Gender'] = $dbs['handwasher_Gender'];
                $index['handwasher_CivilStatus'] = $dbs['handwasher_CivilStatus'];
                $index['handwasher_Contact'] = $dbs['handwasher_Contact'];
                $index['handwasher_Username'] = $dbs['handwasher_Username'];
                $index['handwasher_Password'] = $dbs['handwasher_Password'];
                $index['handwasher_Photo'] = $dbs['handwasher_Photo'];
                $index['handwasher_ID'] = $dbs['handwasher_ID'];
                array_push($result['handwasher'], $index); }
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