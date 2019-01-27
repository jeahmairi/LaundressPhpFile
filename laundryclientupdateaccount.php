<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(!isset($_POST['client_id'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $client_id = $_POST['client_id'];
        }
        $email = $_POST['email'];
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        require_once ("db_connect.php");

            $records =  DB::transact_db("select * from laundry_client where client_ID = ? and client_Password = ?",
                    array($client_id,md5($old_password)),
                    "SELECT"
            );
            if(count($records)>0)
            {
                $db = DB::transact_db("update laundry_client set client_Password = ?, client_Email = ? where client_ID = ?",
                    array(md5($new_password),$email,$client_id),
                    "UPDATE"); 
                    if($db)
                    {
                        $result["success"] = "1";
                        $result["message"] = "success";
        
                        echo json_encode($result);
                        mysqli_close($conn);					
                    }
                    else 
                    {
                        $result["success"] = "0";
                        $result["message"] = "error";
        
                        echo json_encode($result);
                        mysqli_close($conn);				
                    }

            }

    }

?>