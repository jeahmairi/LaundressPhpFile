<?php
error_reporting(E_ALL);

    require_once ("db_connect.php");
    $result = array();
    //$result['allpostclient'] = array();
   $result['allhandwasherpost'] = array();
        $db2 = DB::transact_db("SELECT TIMESTAMPDIFF(MINUTE,p.post_date,CURRENT_TIMESTAMP)as minute, p.post_no, p.post_message, p.post_show_location, p.client_ID, CONCAT(hw.client_FName, ' ', hw.client_MidName, ' ', hw.client_LName) AS name  FROM client_post p , laundry_client hw 
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

       /* $db2 = DB::transact_db("SELECT * FROM posthandwasher",
                array(),
                "SELECT"
            );
            if(count($db2) > 0) {
                foreach($db2 as $dbs){
          
                $indexs['post_no'] = $dbs['post_no'];
                $indexs['post_message'] = $dbs['post_message'];
                $indexs['post_datetime'] = $dbs['post_datetime'];
                $indexs['post_showAddress'] = $dbs['post_showAddress'];
                array_push($result['allhandwasher'], $indexs); 
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
 */
?>