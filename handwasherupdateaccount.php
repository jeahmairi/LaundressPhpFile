<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(!isset($_POST['handwasher_id'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $handwasher_id = $_POST['handwasher_id'];
        }
        $email = $_POST['email'];
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        require_once ("db_connect.php");

            $records =  DB::transact_db("select * from laundry_handwasher where handwasher_ID = ? and handwasher_Password = ?",
                    array($handwasher_id,md5($old_password)),
                    "SELECT"
            );
            if(count($records)>0)
            {
                $db = DB::transact_db("update laundry_handwasher set handwasher_Username = ?, handwasher_Password = ? where handwasher_ID = ?",
                    array($email,md5($new_password),$handwasher_id),
                    "UPDATE"); 
                        $result["success"] = "1";
                        $result["message"] = "success";
        
                        echo json_encode($result);
                        mysqli_close($conn);					
                    

            }else 
                    {
                        $result["success"] = "0";
                        $result["message"] = "error";
        
                        echo json_encode($result);
                        mysqli_close($conn);				
                    }

    }

?>