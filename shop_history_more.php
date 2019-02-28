<?php
error_reporting(E_ALL);
if(!isset($_POST['trans_no'])) {
    $result['success'] = "0";
    $result['message'] = "error";
    echo json_encode($result);
    exit;
 } else {
     $trans_No = $_POST['trans_no'];
 }
 $trans_No;
    require_once ("db_connect.php");
    $result = array();
    $result['moreHistory'] = array();
        $db = DB::transact_db("SELECT * FROM laundry_transaction lt, laundry_service ls, service s, services_offered so, extra_services es where lt.trans_No = ls.trans_No and so.seroffer_ID = ls.seroffer_ID and s.service_No = ls.service_No and es.extraserv_ID = ls.extraserv_ID and lt.trans_No = ?",
								array($trans_No),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
            $index['trans_Service'] = $dbs['service_offered_name'];
            $index['trans_ExtService'] = $dbs['extra_service_name'];
            $index['trans_ServiceType'] = $dbs['service_Type'];
            $index['trans_EstWeight'] = $dbs['trans_EstWeight'];
            $index['trans_EstDateTime'] = $dbs['trans_EstDateTime'];
            $index['trans_Status'] = $dbs['trans_Status'];
			
			if($dbs['trans_Status'] == "Cancelled")
				$index['rating_Score'] = 0;
			else if($dbs['trans_Status'] == "Finished")
			{
				$db1 = DB::transact_db("SELECT * FROM rating where trans_No = ?",
								array($trans_No),
								"SELECT"
                            );
				if(count($db1) > 0) {
					foreach($db1 as $dbs1){
						$index['rating_Score'] = $dbs1['rating_Score'];
					}
				}
			}
            array_push($result['moreHistory'], $index); }
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