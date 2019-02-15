<?php
error_reporting(E_ALL);

    require_once ("db_connect.php");
    $result = array();
    //$result['allpostclient'] = array();
   $result['allhandwasherpost'] = array();
        $db2 = DB::transact_db("SELECT TIMESTAMPDIFF(MINUTE,p.post_date,CURRENT_TIMESTAMP)as minute, p.post_no, p.post_message, p.post_show_location, p.client_ID, CONCAT(hw.client_FName, ' ', hw.client_MidName, ' ', hw.client_LName) AS name, hw.client_address, hw.client_Contact  FROM client_post p , laundry_client hw 
                                where p.client_ID = hw.client_ID",
                            array(),
                            "SELECT"
                        );
        if(count($db2) > 0) {
            foreach($db2 as $dbs){
            $index['post_no'] = $dbs['post_no'];
            $index['post_message'] = $dbs['post_message'];
            $index['post_datetime'] = $dbs['minute'];
            $index['post_showAddress'] = $dbs['post_show_location'];
            $index['client_Address'] = $dbs['client_address'];
            $index['client_Contact'] = $dbs['client_Contact'];
            $index['poster_name'] = $dbs['name'];
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
?>