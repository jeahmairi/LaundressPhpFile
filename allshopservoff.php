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
    $result['allshopserviceoffered'] = array();
    
        $db = DB::transact_db("SELECT * from services_offered where lsp_ID = ? ",
								array($lsp_id),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
      
            $index['id'] = $dbs['seroffer_ID'];
            $index['lsp_id'] = $dbs['lsp_ID'];
            $index['service_offered_name'] = $dbs['service_offered_name'];
            array_push($result['allshopserviceoffered'], $index); }
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