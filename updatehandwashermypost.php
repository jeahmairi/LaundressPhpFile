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
        if(!isset($_POST['post_message']))
        {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $post_message = $_POST['post_message'];
        }
        if(!isset($_POST['post_show_location']))
        {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $post_show_location = $_POST['post_show_location'];
        }
        require_once ("db_connect.php");
            $db =  DB::transact_db("update handwasher_post set handwasher_message = ?, handwasher_show_location = ? where post_handwasher_no = ?",
            array($post_message, $post_show_location, $post_no),
            "UPDATE");
           //if($db){
                $result["success"] = "1";
                $result["message"] = "success";

                echo json_encode($result);
                mysqli_close($conn);					
          // }
   
    }

?>