<?php
error_reporting(E_ALL);
 if ($_SERVER['REQUEST_METHOD']=='POST') {
     if(!isset($_POST['email'])) {
        $result['success'] = "0";
        $result['message'] = "error";
        echo json_encode($result);
        exit;
     } else {
         $email = $_POST['email'];
     }
     if(!isset($_POST['password'])){
        $result['success'] = "0";
        $result['message'] = "error";
        echo json_encode($result);
        exit;
     } else {
        $password = $_POST['password']; 
     }
    
    

    require_once ("db_connect.php");
    $result = array();
    $result['login'] = array();
        $db = DB::transact_db("SELECT client_ID, CONCAT(client_FName, ' ', client_MidName, ' ', client_LName) AS name, client_User FROM laundry_client WHERE client_Email = ? and client_Password = ?",
								array($email, md5($password)),
								"SELECT"
                            );

        $db2 = DB::transact_db("SELECT lp.lsp_ID, lh.handwasher_ID, CONCAT(lh.handwasher_FName, ' ',lh.handwasher_MidName, ' ',lh.handwasher_LName) AS name FROM laundry_handwasher lh, laundry_service_provider lp WHERE lh.handwasher_ID = lp.handwasher_ID and lh.handwasher_Username = ? and lh.handwasher_Password = ?",
                            array($email, md5($password)),
                            "SELECT"
                            );
        $db3 = DB::transact_db("SELECT shop_ID, shop_Name as name FROM laundry_shop WHERE shop_Username = ? and shop_Password = ?",
                            array($email, md5($password)),
                            "SELECT"
                            );
        if($db) {
            $db = $db[0];
            $index['name'] = $db['name'];
            $index['user'] = $db['client_User'];
            $index['id'] = $db['client_ID'];
            array_push($result['login'], $index);
            $result['success'] = "1";
            $result['message'] = "success";
            echo json_encode($result);
        } else if($db2){
            $db2 = $db2[0];
            $index2['name'] = $db2['name'];
            $index2['user'] = "Laundry Handwasher";
            $index2['id'] = $db2['handwasher_ID'];
            $index2['lspid'] = $db2['lsp_ID'];
            array_push($result['login'], $index2);
            $result['success'] = "1";
            $result['message'] = "success";
            echo json_encode($result);
        }  else if($db3){
            $db3 = $db3[0];
            $index3['name'] = $db3['name'];
            $index3['user'] = "Laundry Shop";
            $index3['id'] = $db3['shop_ID'];
            array_push($result['login'], $index3);
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