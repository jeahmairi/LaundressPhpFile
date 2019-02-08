<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(!isset($_POST['rate_no']))
        {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $rate_no = $_POST['rate_no'];
        }
        require_once ("db_connect.php");
            
            $db = DB::transact_db("delete from rating_handwasher where rating_No = ?",
            array($rate_no),
            "DELETE"
            );
           
                $result["success"] = "1";
                $result["message"] = "success";

                echo json_encode($result);
                mysqli_close($conn);			
       
   
    }

?>