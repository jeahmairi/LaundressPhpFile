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
    require_once ("db_connect.php");
    $result = array();
    $result['alllaundrydetails'] = array();
        $db = DB::transact_db("SELECT ci.cinv_No, CONCAT(ci.cinv_ItemTag, ' ', ci.cinv_ItemBrand, ' ', ci.cinv_ItemColor, ' ', ci.cinv_ItemDescription) AS description, ci.cinv_NoOfPieces, cat.category_Name, cat.category_No from client_inventory ci, category cat, laundry_client lc where ci.client_ID = ? and ci.category_No = cat.category_No and ci.client_ID = lc.client_ID order by cat.category_No",
								array($client_id ),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs){
      
            $index['cinv_id'] = $dbs['cinv_No'];
            /* $index['cinv_itemTag'] = $dbs['cinv_ItemTag'];
            $index['cinv_itemBrand'] = $dbs['cinv_ItemBrand'];
            $index['cinv_itemColor'] = $dbs['cinv_ItemColor']; */
            $index['cinv_itemDescription'] = $dbs['description'];
            $index['cinv_noOfPieces'] = $dbs['cinv_NoOfPieces']; 
            $index['category_Name'] = $dbs['category_Name']; 
            $index['category_No'] = $dbs['category_No']; 
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