<?php
error_reporting(E_ALL);
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        if(!isset($_POST['client_id'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $client_id = $_POST['client_id'];
        }
        require_once ("db_connect.php");
        $result = array();
        $result['laundryclient'] = array();
            $db = DB::transact_db("SELECT *  FROM laundry_client where client_ID = ?  ORDER BY client_ID",
                                array($client_id ),
                                    "SELECT"
                                );
            if(count($db) > 0) {
                foreach($db as $dbs){
                $index['client_fname'] = $dbs['client_FName'];
                $index['client_midname'] = $dbs['client_MidName'];
                $index['client_lname'] = $dbs['client_LName'];
                $index['client_address'] = $dbs['client_Address'];
                $index['client_bdate'] = $dbs['client_BDate'];
                $index['client_gender'] = $dbs['client_Gender'];
                $index['client_contact'] = $dbs['client_Contact'];
                $index['client_email'] = $dbs['client_Email'];
                $index['client_password'] = $dbs['client_Password'];
                $index['client_Photo'] = $dbs['client_Photo'];
                $index['client_id'] = $dbs['client_ID'];
                array_push($result['laundryclient'], $index); }
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