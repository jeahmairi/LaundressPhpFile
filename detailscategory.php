<?php
error_reporting(E_ALL);
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
    $result['category'] = array();
        $db = DB::transact_db("SELECT *  FROM category where client_ID = ? ORDER BY category_No ",
								array($client_id),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
      
            $index['id'] = $dbs['category_No'];
            $index['name'] = $dbs['category_Name'];

            array_push($result['category'], $index); }
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