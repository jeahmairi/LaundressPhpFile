<?php
error_reporting(E_ALL);

    require_once ("db_connect.php");
    $result = array();
    //$result['allpostclient'] = array();
   $result['allhandwasherpost'] = array();
        $db2 = DB::transact_db("SELECT TIMESTAMPDIFF(MINUTE,p.handwasher_date,CURRENT_TIMESTAMP)as minute, p.post_handwasher_no, p.handwasher_message, p.handwasher_show_location, p.handwasher_ID, CONCAT(hw.handwasher_FName, ' ', hw.handwasher_MidName, ' ', hw.handwasher_LName) AS name  FROM handwasher_post p , laundry_handwasher hw 
                                where p.handwasher_ID = hw.handwasher_ID",
                            array(),
                            "SELECT"
                        );
        if(count($db2) > 0) {
            foreach($db2 as $dbs){
            $index['post_no'] = $dbs['post_handwasher_no'];
            $index['post_message'] = $dbs['handwasher_message'];
            $index['post_datetime'] = $dbs['minute'];
            $index['post_showAddress'] = $dbs['handwasher_show_location'];
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