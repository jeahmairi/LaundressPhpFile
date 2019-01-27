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
    $results = array();
    $results['allhandwasherextraservice'] = array();
        $db2 = DB::transact_db("SELECT * from extra_services where lsp_ID = ? ",
                            array($lsp_id),
                            "SELECT"
                                );
        if(count($db2) > 0) {
            foreach($db2 as $dbs){

            $index['id'] = $dbs['extraserv_ID'];
            $index['lsp_id'] = $dbs['lsp_ID'];
            $index['extra_service_name'] = $dbs['extra_service_name'];
            array_push($results['allhandwasherextraservice'], $index); }
            $results['success'] = "1";
            $results['message'] = "success"; 
            echo json_encode($results);
            } 
        else {
            $results['success'] = "0";
            $results['message'] = "error";
            echo json_encode($results);
            exit;
        }
    }


?>