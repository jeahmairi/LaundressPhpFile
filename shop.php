<?php
error_reporting(E_ALL);

    require_once ("db_connect.php");
    $result = array();
    $result['shopBookings'] = array();
        $db = DB::transact_db("SELECT CONCAT(client_FName, ' ', client_MidName, ' ', client_LName) AS client_Name, client_Address, client_Contact from laundry_client",
								array(),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
      
            $index['clientName'] = $dbs['client_Name'];
            $index['clientAddress'] = $dbs['client_Address'];
            $index['clientContact'] = $dbs['client_Contact'];
            
            array_push($result['shopBookings'], $index); }
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