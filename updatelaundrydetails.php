<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
       
            $itemDescription = $_POST['itemDescription'];
            $itemNoofPieces = $_POST['itemNoofPieces'];
            $cinv_no = $_POST['cinv_no'];
            $photo =  $_POST['photo'];

            $path = "laundry_details/".$itemDescription.".jpeg";
            $finalPath = "http://192.168.254.117/laundress/".$path;
        
        require_once ("db_connect.php");
            $db =  DB::transact_db("update client_inventory set cinv_ItemDescription = ?, cinv_Photo = ?, cinv_NoOfPieces = ? where cinv_No = ?",
            array($itemDescription, $finalPath, $itemNoofPieces, $cinv_no),
            "UPDATE");
            if (file_put_contents( $path, base64_decode($photo))) {
                $result["success"] = "1";
                $result["message"] = "success";

                echo json_encode($result);
                mysqli_close($conn);	
            }				
    }

?>