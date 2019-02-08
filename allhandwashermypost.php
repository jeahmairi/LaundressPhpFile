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
    //$result['allpostclient'] = array();
   $result['allhandwasherpost'] = array();
        $db2 = DB::transact_db("SELECT *,CONCAT(lh.handwasher_FName, ' ',lh.handwasher_MidName, ' ',lh.handwasher_LName) AS name FROM handwasher_post hp, laundry_handwasher lh where hp.handwasher_ID = ? and hp.handwasher_ID = lh.handwasher_ID",
                            array($handwasher_id),
                            "SELECT"
                        );
        if(count($db2) > 0) {
            foreach($db2 as $dbs){
            $index['post_no'] = $dbs['post_handwasher_no'];
            $index['post_message'] = $dbs['handwasher_message'];
            $index['post_datetime'] = $dbs['handwasher_date'];
            $index['post_show_location'] = $dbs['handwasher_show_location'];
            $index['name'] = $dbs['name'];
            array_push($result['allhandwasherpost'], $index); 
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