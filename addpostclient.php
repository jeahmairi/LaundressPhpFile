<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $message = $_POST['messages'];
        $id = $_POST['id'];
        
        require_once ("db_connect.php");
            
            $db = DB::transact_db( "INSERT INTO postclient(client_id, post_message)
                 values
                 (? ,?)",
                 array($id,$message),
                 "INSERT"
            );
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

?>