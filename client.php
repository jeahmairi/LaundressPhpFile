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
    //$result['allpostclient'] = array();
   $result['client'] = array();
        $db2 = DB::transact_db("SELECT * FROM laundry_client where client_ID = 1",
                            array($client_id),
                            "SELECT"
                        );
        if(count($db2) > 0) {
            foreach($db2 as $dbs){
            $index['client_Address'] = $dbs['client_Address'];
            array_push($result['client'], $index); 
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