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
        $db = DB::transact_db("SELECT * from client_inventory ci, category cat, laundry_client lc where ci.category_No = ? and ci.client_ID = ? and ci.category_No = cat.category_No and ci.client_ID = lc.client_ID",
								array($category_no, $client_id ),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
      
            $index['cinv_id'] = $dbs['cinv_No'];
            $index['cinv_itemTag'] = $dbs['cinv_ItemTag'];
            $index['cinv_itemBrand'] = $dbs['cinv_ItemBrand'];
            $index['cinv_itemColor'] = $dbs['cinv_ItemColor'];
            $index['cinv_itemDescription'] = $dbs['cinv_ItemDescription'];
            $index['cinv_noOfPieces'] = $dbs['cinv_NoOfPieces']; 
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