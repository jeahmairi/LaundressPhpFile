<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(!isset($_POST['cinv_no']))
        {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $cinv_no = $_POST['cinv_no'];
        }
        require_once ("db_connect.php");
            
            $db = DB::transact_db("delete from client_inventory where cinv_No = ?",
            array($cinv_no),
            "DELETE"
            );
           
                $result["success"] = "1";
                $result["message"] = "success";

                echo json_encode($result);
                mysqli_close($conn);			
       
   
    }

?>