<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(!isset($_POST['accommodation'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $accommodation = $_POST['accommodation'];
        }

        if(!isset($_POST['qualityofservice'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $qualityofservice = $_POST['qualityofservice'];
        }

        if(!isset($_POST['ontime'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $ontime = $_POST['ontime'];
        }

        if(!isset($_POST['overall'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $overall = $_POST['overall'];
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
            $db =  DB::transact_db("update rating_handwasher set rating_Accommodation = ?, rating_QualityService = ?, rating_Ontime = ?, rating_Overall = ?, rating_Comment = ? where rating_No = ?",
            array($accommodation, $qualityofservice, $ontime, $overall, $comments, $rate_no),
            "UPDATE");
           //if($db){
                $result["success"] = "1";
                $result["message"] = "success";

                echo json_encode($result);
                mysqli_close($conn);					
          // }
   
    }

?>