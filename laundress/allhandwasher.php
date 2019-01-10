<?php
error_reporting(E_ALL);

    require_once ("db_connect.php");
    $result = array();
    $result['allhandwasher'] = array();
        $db = DB::transact_db("SELECT handwasher_id, CONCAT(handwasher_fname, ' ', handwasher_midname, ' ', handwasher_lname) AS name, handwasher_address, handwasher_contact   FROM laundryhandwasher ORDER BY handwasher_id",
								array(),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
      
            $index['id'] = $dbs['handwasher_id'];
            $index['name'] = $dbs['name'];
            $index['address'] = $dbs['handwasher_address'];
            $index['contact'] = $dbs['handwasher_contact'];
            array_push($result['allhandwasher'], $index); }
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