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
    $result['allhandwasherservicetype'] = array();
        $db = DB::transact_db("SELECT * from service where lsp_ID = ? ",
								array($lsp_id),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
      
            $index['service_No'] = $dbs['service_No'];
            $index['lsp_id'] = $dbs['lsp_ID'];
            $index['service_Type'] = $dbs['service_Type'];
            array_push($result['allhandwasherservicetype'], $index); }
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