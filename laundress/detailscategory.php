<?php
error_reporting(E_ALL);

    require_once ("db_connect.php");
    $result = array();
    $result['category'] = array();
        $db = DB::transact_db("SELECT *  FROM category ORDER BY category_no",
								array(),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
      
            $index['id'] = $dbs['category_no'];
            $index['name'] = $dbs['category_name'];

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