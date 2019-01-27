<?php
error_reporting(E_ALL);

    require_once ("db_connect.php");
    $result = array();
    //$result['allpostclient'] = array();
   $result['allhandwasherpost'] = array();
        $db = DB::transact_db("SELECT TIMESTAMPDIFF(MINUTE,p.post_datetime,CURRENT_TIMESTAMP)as minute, p.post_no, p.post_message, p.post_showAddress, p.client_id, CONCAT(lc.client_fname, ' ', lc.client_midname, ' ', lc.client_lname) AS name   FROM postclient p, laundryclient lc
        where p.client_id = lc.client_id",
								array(),
								"SELECT"
                            );
        $db2 = DB::transact_db("SELECT TIMESTAMPDIFF(MINUTE,p.post_datetime,CURRENT_TIMESTAMP)as minute, p.post_no, p.post_message, p.post_showAddress, p.handwasher_id, CONCAT(hw.handwasher_fname, ' ', hw.handwasher_midname, ' ', hw.handwasher_lname) AS name  FROM posthandwasher p , laundryhandwasher hw 
                                where p.handwasher_id = hw.handwasher_id",
                            array(),
                            "SELECT"
                        );
        if(count($db2) > 0) {
            foreach($db2 as $dbs){
            $index['post_no'] = $dbs['post_no'];
            $index['post_message'] = $dbs['post_message'];
            $index['post_datetime'] = $dbs['minute'];
            $index['post_showAddress'] = $dbs['post_showAddress'];
            $index['poster_name'] = $dbs['name'];
            array_push($result['allhandwasherpost'], $index); 
            }
        } 
        if(count($db) > 0) {
            foreach($db as $dbs){
      
            $index['post_no'] = $dbs['post_no'];
            $index['post_message'] = $dbs['post_message'];
            $index['post_datetime'] = $dbs['minute'];
            $index['post_showAddress'] = $dbs['post_showAddress'];
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