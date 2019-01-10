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
    if(!isset($_POST['categ_id'])){
       $result['success'] = "0";
       $result['message'] = "error";
       echo json_encode($result);
       exit;
    } else {
       $category_no = $_POST['categ_id']; 
    }
    require_once ("db_connect.php");
    $result = array();
    $result['alllaundrydetails'] = array();
        $db = DB::transact_db("SELECT * from client_inventory ci, category cat, laundryclient lc where ci.category_no = ? and ci.client_id = ? and ci.category_no = cat.category_no and ci.client_id = lc.client_id",
								array($category_no, $client_id ),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
      
            $index['cinv_id'] = $dbs['cinv_no'];
            $index['cinv_itemTag'] = $dbs['cinv_itemTag'];
            $index['cinv_itemBrand'] = $dbs['cinv_itemBrand'];
            $index['cinv_itemColor'] = $dbs['cinv_itemColor'];
            $index['cinv_noOfPieces'] = $dbs['cinv_noOfPieces']; 
            array_push($result['alllaundrydetails'], $index); 
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