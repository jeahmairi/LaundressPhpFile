<?php
error_reporting(E_ALL);
if($_SERVER['REQUEST_METHOD'] == 'POST')
{ 
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
    //$result['allpostclient'] = array();
   $result['allhandwasherservice'] = array();
        $db = DB::transact_db("SELECT * FROM `services_offered` where lsp_ID = ?",
								array($lsp_id),
								"SELECT"
                            );
        $db2 = DB::transact_db("SELECT * FROM `extra_services` where lsp_ID = ?",
                            array($lsp_id),
                            "SELECT"
                        );
        $db3 = DB::transact_db("SELECT * FROM `service` where lsp_ID = ?",
                        array($lsp_id),
                        "SELECT"
                        );
        if(count($db2) > 0) {
            foreach($db2 as $dbs){
            $index['id'] = $dbs['extraserv_ID'];
            $index['lsp_ID'] = $dbs['lsp_ID'];
            $index['name'] = $dbs['extra_service_name'];
            $index['price'] = $dbs['extra_service_price'];
            $index['uom'] = $dbs['extra_service_uom'];
            array_push($result['allhandwasherservice'], $index); 
            }
        } 
        if(count($db) > 0)
        foreach($db as $dbs){ {
            $index['id'] = $dbs['seroffer_ID'];
            $index['lsp_ID'] = $dbs['lsp_ID'];
            $index['name'] = $dbs['service_offered_name'];
            $index['price'] = $dbs['service_offered_price'];
            $index['uom'] = $dbs['service_offered_uom'];
            array_push($result['allhandwasherservice'], $index); 
            }
            
           
        }             
        if(count($db3) > 0) {
            foreach($db3 as $dbs){
            $index['id'] = $dbs['service_No'];
            $index['lsp_ID'] = $dbs['lsp_ID'];
            $index['name'] = $dbs['service_Type'];
            array_push($result['allhandwasherservice'], $index); 
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