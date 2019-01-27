<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(!isset($_POST['categ_id'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $categ_id = $_POST['categ_id'];
        }
        if(!isset($_POST['category_name']))
        {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $category_name = $_POST['category_name'];
        }
        require_once ("db_connect.php");
            $db =  DB::transact_db("update category set category_Name = ? where category_No = ?",
            array($category_name, $categ_id),
            "UPDATE");
           //if($db){
                $result["success"] = "1";
                $result["message"] = "success";

                echo json_encode($result);
                mysqli_close($conn);					
          // }
   
    }

?>