<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $itemDescription = $_POST['itemDescription'];
        $itemNoofPieces = $_POST['itemNoofPieces'];
        $client_id = $_POST['client_id'];
        $category_no = $_POST['categ_id']; 
        $picture =  $_POST['picture'];
        $client_Name =  $_POST['client_Name'];
        $path = "laundry_details/".$itemDescription.".jpeg";
        $finalPath = "http://192.168.254.117/laundress/".$path;
        
        require_once ("db_connect.php");
            $db = DB::transact_db( "INSERT INTO client_inventory
            (client_ID, category_No, cinv_ItemDescription, cinv_Photo, cinv_NoOfPieces)
            values
            (? ,? ,? ,?, ?)",
            array($client_id, $category_no, $itemDescription, $finalPath, $itemNoofPieces),
            "INSERT"
            );
            if (file_put_contents( $path, base64_decode($picture))) {
            if($db)
            {
                $result["success"] = "1";
                $result["message"] = "success";

                echo json_encode($result);
                mysqli_close($conn);					
            }
            else 
            {
                $result["success"] = "0";
                $result["message"] = "error";

                echo json_encode($result);
                mysqli_close($conn);				
            }
        }
       
   
    }

?>