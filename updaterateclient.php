<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(!isset($_POST['rating'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $rating = $_POST['rating'];
        }
        if(!isset($_POST['comments']))
        {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $comments = $_POST['comments'];
        }
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
            $db =  DB::transact_db("update rating_handwasher set rating_Score = ?, rating_Comment = ? where rating_No = ?",
            array($rating, $comments, $rate_no),
            "UPDATE");
           //if($db){
                $result["success"] = "1";
                $result["message"] = "success";

                echo json_encode($result);
                mysqli_close($conn);					
          // }
   
    }

?>