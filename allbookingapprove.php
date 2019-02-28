<?php
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD']=='POST') {
    if(!isset($_POST['lsp_id'])) {
       $result['success'] = "0";
       $result['message'] = "error";
       echo json_encode($result);
       exit;
    } else {
        $lsp_id = $_POST['lsp_id'];
    }
    require_once ("db_connect.php");
    $result = array();
    $shop_ID=0;
    $handwasher_ID=0;
    $extraserve=0;
    $extraserves="";
    $result['allbooking'] = array();

        $db4 = DB::transact_db("SELECT * from extra_services es, laundry_service ls, laundry_transaction lt where lt.lsp_ID = ? and es.extraserv_ID = ls.extraserv_ID and ls.trans_No = lt.trans_No",
            array($lsp_id),
            "SELECT"
        );
        if(count($db4)>0){
            foreach($db4 as $db4s){
            $extraserves = $extraserves." ".$db4s['extra_service_name']; 
            //$index['shop_ContactNo1'] = $db3s['trans_ExtService']; 
            }
        }
        $db = DB::transact_db("SELECT * from laundry_transaction lt, laundry_service_provider lsp, laundry_client lc,  laundry_service ls, service s, services_offered so, extra_services es where lt.trans_Status ='Accepted' and lt.lsp_ID = ? and lt.lsp_ID = lsp.lsp_ID and lt.client_ID = lc.client_ID and lt.trans_No = ls.trans_No and ls.seroffer_ID = so.seroffer_ID and ls.service_No = s.service_No and ls.extraserv_ID = es.extraserv_ID Group By lt.trans_No",
								array($lsp_id ),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
            $index['trans_No'] = $dbs['trans_No'];
            $index['client_ID'] = $dbs['client_ID'];
            $index['lsp_ID'] = $dbs['lsp_ID'];  
            $index['name'] = $dbs['client_FName']." ".$dbs['client_MidName']." ".$dbs['client_LName']; 
            $index['client_Photo'] = $dbs['client_Photo'];
            $index['client_Address'] = $dbs['client_Address'];
			$index['client_Contact'] = $dbs['client_Contact'];
            $index['handwasher_ID'] = $dbs['handwasher_ID']; 
            $index['trans_Service'] = $dbs['service_offered_name']; 
            //$index['trans_ExtService'] = $dbs['extra_service_name']; 
            $index['trans_ServiceType'] = $dbs['service_Type'];
            $index['trans_EstWeight'] = $dbs['trans_EstWeight'];
            $index['trans_EstDateTime'] = $dbs['trans_EstDateTime'];
            $index['trans_DateOfRequest'] = $dbs['trans_DateOfRequest'];
            $index['trans_Status'] = $dbs['trans_Status'];
            $shop_ID= $dbs['shop_ID'];
            $extraserve= $dbs['extraserv_ID'];
            $handwasher_ID = $dbs['handwasher_ID']; 
            if($handwasher_ID!=0){
                $db3 = DB::transact_db("SELECT * from laundry_handwasher where handwasher_ID = ?",
                    array($handwasher_ID),
                    "SELECT"
                );
                if(count($db3)>0){
                    foreach($db3 as $db3s){
                    $index['handwasher_Address'] = $db3s['handwasher_Address']; 
                    $index['handwasher_Contact'] = $db3s['handwasher_Contact']; 
                    //$index['shop_ContactNo1'] = $db3s['trans_ExtService']; 
                    }
                }
            }
            
            $index['trans_ExtService']=$extraserves;
            $handwasher_ID = $dbs['handwasher_ID'];
            array_push($result['allbooking'], $index); 
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
