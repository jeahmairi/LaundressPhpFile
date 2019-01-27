<?php
error_reporting(E_ALL);

    require_once ("db_connect.php");
    $result = array();
    $result['allpostclient'] = array();
   //$result['allhandwasher'] = array();
        $db = DB::transact_db("SELECT * FROM postclient",
								array(),
								"SELECT"
                            );
        $db2 = DB::transact_db("SELECT * FROM posthandwasher",
                            array(),
                            "SELECT"
                        );
        if(count($db2) > 0) {
            foreach($db2 as $dbs){
            $index['post_no'] = $dbs['post_no'];
            $index['post_message'] = $dbs['post_message'];
            $index['post_datetime'] = $dbs['post_datetime'];
            $index['post_showAddress'] = $dbs['post_showAddress'];
            
            array_push($result['allpostclient'], $index); 
            }
        } 
        if(count($db) > 0) {
            foreach($db as $dbs){
      
            $index['post_no'] = $dbs['post_no'];
            $index['post_message'] = $dbs['post_message'];
            $index['post_datetime'] = $dbs['post_datetime'];
            $index['post_showAddress'] = $dbs['post_showAddress'];
            
            array_push($result['allpostclient'], $index); 
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

       /* $db2 = DB::transact_db("SELECT * FROM posthandwasher",
                array(),
                "SELECT"
            );
            if(count($db2) > 0) {
                foreach($db2 as $dbs){
          
                $indexs['post_no'] = $dbs['post_no'];
                $indexs['post_message'] = $dbs['post_message'];
                $indexs['post_datetime'] = $dbs['post_datetime'];
                $indexs['post_showAddress'] = $dbs['post_showAddress'];
                array_push($result['allhandwasher'], $indexs); 
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
 */
?>