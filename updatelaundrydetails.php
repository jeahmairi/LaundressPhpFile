<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(!isset($_POST['itemTag'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $itemTag = $_POST['itemTag'];
        }
        if(!isset($_POST['itemBrand']))
        {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $itemBrand = $_POST['itemBrand'];
        }
        if(!isset($_POST['itemColor']))
        {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $itemColor = $_POST['itemColor'];
        }
        if(!isset($_POST['itemDescription']))
        {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $itemDescription = $_POST['itemDescription'];
        }
        if(!isset($_POST['itemNoofPieces']))
        {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $itemNoofPieces = $_POST['itemNoofPieces'];
        }
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
            $db =  DB::transact_db("update client_inventory set cinv_ItemTag = ?, cinv_ItemBrand = ?, cinv_ItemColor = ?, cinv_ItemDescription = ?, cinv_NoOfPieces = ? where cinv_No = ?",
            array($itemTag, $itemBrand, $itemColor, $itemDescription, $itemNoofPieces, $cinv_no),
            "UPDATE");
                $result["success"] = "1";
                $result["message"] = "success";

                echo json_encode($result);
                mysqli_close($conn);					
    }

?>