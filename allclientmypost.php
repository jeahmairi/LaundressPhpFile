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
   $result['allclientpost'] = array();
        $db2 = DB::transact_db("SELECT *, CONCAT(lc.client_FName, ' ', lc.client_MidName, ' ', lc.client_LName) as name FROM client_post cp, laundry_client lc where cp.client_ID = ? and cp.client_ID = lc.client_ID",
                            array($client_id),
                            "SELECT"
                        );
        if(count($db2) > 0) {
            foreach($db2 as $dbs){
            $index['post_no'] = $dbs['post_no'];
            $index['post_message'] = $dbs['post_message'];
            $index['post_datetime'] = $dbs['post_date'];
            $index['post_show_location'] = $dbs['post_show_location'];
            $index['name'] = $dbs['name'];
            array_push($result['allclientpost'], $index); 
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