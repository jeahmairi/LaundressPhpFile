<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $message = $_POST['messages'];
        $showlocation = $_POST['showlocation'];
        $id = $_POST['id'];
        
        require_once ("db_connect.php");
            
            $db = DB::transact_db( "INSERT INTO handwasher_post(handwasher_ID, handwasher_message, handwasher_show_location)
                 values
                 (? ,?, ?)",
                 array($id,$message,$showlocation),
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