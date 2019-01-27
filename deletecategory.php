<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(!isset($_POST['categ_id']))
        {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $categ_id = $_POST['categ_id'];
        }
        require_once ("db_connect.php");
            
            $db = DB::transact_db("delete from category where category_No = ?",
            array($categ_id),
            "DELETE"
            );
           
                $result["success"] = "1";
                $result["message"] = "success";

                echo json_encode($result);
                mysqli_close($conn);			
       
   
    }

?>