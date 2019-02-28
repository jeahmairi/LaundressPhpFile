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
   
        $db2 = DB::transact_db("SELECT *, lh.shop_Name AS name FROM shop_post hp, laundry_shop lh where hp.shop_ID = ? and hp.shop_ID = lh.shop_ID",
                            array($handwasher_id),
                            "SELECT"
                        );
        if(count($db2) > 0) {
            foreach($db2 as $dbs){
            $index['post_no'] = $dbs['post_shop_no'];
            $index['post_message'] = $dbs['post_Message'];
            $index['post_datetime'] = $dbs['post_Date'];
            //$index['post_show_location'] = $dbs['handwasher_show_location'];
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