<?php
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD']=='POST') {
    if(!isset($_POST['client_id'])) {
       $result['success'] = "0";
       $result['message'] = "error";
       echo json_encode($result);
       exit;
    } else {
        $client_id = $_POST['client_id'];
    }
    require_once ("db_connect.php");
    $result = array();
    $shop_ID=0;
    $handwasher_ID=0;
    $result['allbooking'] = array();
        $db = DB::transact_db("SELECT * from notification lt, laundry_service_provider lsp where lt.client_ID = ? and lt.lsp_ID = lsp.lsp_ID Order by lt.notification_No DESC",
								array($client_id ),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
            $index['trans_No'] = $dbs['trans_No'];
            $index['client_ID'] = $dbs['client_ID'];
            $index['lsp_ID'] = $dbs['lsp_ID']; 
            $index['shop_ID'] = $dbs['shop_ID']; 
            $index['handwasher_ID'] = $dbs['handwasher_ID']; 
            $index['notification_Message'] = $dbs['notification_Message']; 
            $index['fromtable'] = "Notification";
            $shop_ID= $dbs['shop_ID'];
            $handwasher_ID = $dbs['handwasher_ID']; 
            if($shop_ID!=0){
                $db2 = DB::transact_db("SELECT * from laundry_shop where shop_ID = ?",
                    array($shop_ID),
                    "SELECT"
                );
                if(count($db2)>0){
                    foreach($db2 as $db2s){
                    $index['name'] = $db2s['shop_Name']; 
                    $index['address'] = $db2s['shop_Address']; 
                    $index['contact'] = $db2s['shop_ContactNo1']; 
                    }
                }
            } else if($handwasher_ID!=0){
                $db3 = DB::transact_db("SELECT CONCAT(handwasher_FName, ' ',handwasher_MidName, ' ',handwasher_LName)AS name, handwasher_Address,handwasher_Contact  from laundry_handwasher where handwasher_ID = ?",
                    array($handwasher_ID),
                    "SELECT"
                );
                if(count($db3)>0){
                    foreach($db3 as $db3s){
                    $index['name'] = $db3s['name']; 
                    $index['address'] = $db3s['handwasher_Address']; 
                    $index['contact'] = $db3s['handwasher_Contact']; 
                    //$index['shop_ContactNo1'] = $db3s['trans_ExtService']; 
                    }
                }
            }
            $db4 = DB::transact_db("SELECT * FROM rating where client_ID = ?",
            array($client_id),
            "SELECT"
            );
            if(count($db4)>0){
                foreach($db4 as $db4s){
                $index['rating_No'] = $db4s['rating_No']; 
                $index['rating_Score'] = $db4s['rating_Score']; 
                $index['rating_Comment'] = $db4s['rating_Comment']; 
                $index['rating_Date'] = $db4s['rating_Date']; 
                //$index['shop_ContactNo1'] = $db3s['trans_ExtService']; 
                }
            }
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