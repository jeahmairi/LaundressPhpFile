<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(!isset($_POST['post_no'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $post_no = $_POST['post_no'];
        }
        require_once ("db_connect.php");
            
            $db = DB::transact_db("delete from client_post where post_no = ?",
            array($post_no),
            "DELETE"
            );
           
                $result["success"] = "1";
                $result["message"] = "success";

                echo json_encode($result);
                mysqli_close($conn);			
       
   
    }

?>