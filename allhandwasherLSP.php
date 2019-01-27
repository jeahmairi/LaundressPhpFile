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
    $result['allhandwasher'] = array();
        $db = DB::transact_db("SELECT lh.handwasher_ID, CONCAT(lh.handwasher_FName, ' ', lh.handwasher_MidName, ' ', lh.handwasher_LName) AS name, floor(datediff(CURRENT_DATE,lh.handwasher_BDate)/365) as age, lh.handwasher_CivilStatus, lh.handwasher_Address, lh.handwasher_Contact, lsp.lsp_ID as lsp_ID FROM laundry_handwasher lh, laundry_service_provider lsp where lh.handwasher_ID = lsp.handwasher_ID AND lsp.lsp_id = ? ORDER BY lh.handwasher_id",
								array($lsp_id),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
      
            $index['id'] = $dbs['handwasher_ID'];
            $index['name'] = $dbs['name'];
            $index['address'] = $dbs['handwasher_Address'];
            $index['contact'] = $dbs['handwasher_Contact'];
            $index['age'] = $dbs['age'];
            $index['civilstat'] = $dbs['handwasher_CivilStatus'];
            $index['lspid'] = $dbs['lsp_ID'];
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

    }
?>