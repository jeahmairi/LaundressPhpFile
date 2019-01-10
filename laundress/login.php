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
        $db = DB::transact_db("SELECT client_id, CONCAT(client_fname, ' ', client_midname, ' ', client_lname) AS name, client_user FROM laundryclient WHERE client_email = ? and client_password = ?",
								array($email, md5($password)),
								"SELECT"
                            );

        $db2 = DB::transact_db("SELECT hw.handwasher_id, CONCAT(hw.handwasher_fname, ' ', hw.handwasher_midname, ' ', hw.handwasher_lname) AS name, sp.lsp_type FROM laundryhandwasher hw, serviceprov sp WHERE handwasher_username = ? and handwasher_password = ? and hw.lsp_id = sp.lsp_id",
                            array($email, md5($password)),
                            "SELECT"
                            );
        if($db) {
            $db = $db[0];
            $index['name'] = $db['name'];
            //$index['email'] = $db['client_email'];
            $index['user'] = $db['client_user'];
            $index['id'] = $db['client_id'];
            array_push($result['login'], $index);
            $result['success'] = "1";
            $result['message'] = "success";
            echo json_encode($result);
        } else if($db2){
            $db2 = $db2[0];
            $index2['name'] = $db2['name'];
            //$index2['email'] = $db2['handwasher_username'];
            $index2['user'] = $db2['lsp_type'];
            $index2['id'] = $db2['handwasher_id'];
            array_push($result['login'], $index2);
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